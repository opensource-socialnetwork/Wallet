<?php
/**
 * Open Source Social Network
 *
 * @package   Wallet
 * @author    OSSN Core Team <info@openteknik.com>
 * @copyright (c) Engr. Syed Arsalan Hussain Shah (OpenTeknik LLC)
 * @license   OpenTeknik LLC, COMMERCIAL LICENSE  https://www.openteknik.com/license/commercial-license-v1
 * @link      https://www.openteknik.com/
 */
namespace Wallet;
class Wallet {
		/**
		 * Set a user
		 *
		 * Throws an error if user is invalid
		 * @param integer $guid User GUID
		 *
		 * @return void
		 */
		public function __construct($guid) {
				$this->user = ossn_user_by_guid($guid);
				if(!$this->user) {
						throw new \Wallet\NoUserException('Invalid User');
				}
		}
		/**
		 * Get a current user balance
		 *
		 * @return float
		 */
		public function getBalance() {
				if(!isset($this->user->wallet_balance)) {
						$this->user->wallet_balance = 0;
				}
				return floatval(trim($this->user->wallet_balance));
		}
		/**
		 * set a user balance
		 * This will override whatever user balance will be.
		 * Use this method on your own risk as there won't be a way to recover old amount.
		 *
		 * @param integer $guid User GUID
		 *
		 * @return boolean
		 */
		public function setBalance(float $balance): bool {
				if(empty($balance)) {
						return false;
				}
				$this->user->data->wallet_balance = trim(intval($balance));
				return $this->user->save();
		}
		/**
		 * Debit a mount form user balance
		 * This will throw expception if user have insufficent balance.
		 *
		 * @param float $amount Debit amount
		 * @param string  $description Description
		 *
		 * @return boolean
		 */
		public function debit(float $amount, string $description): bool {
				if(!empty($amount)) {
						if(!isset($this->user->wallet_balance)) {
								$this->user->wallet_balance = 0;
						}
						$actual_amount = floatval(trim($amount));
						$old_amount    = floatval($this->user->wallet_balance);

						if($actual_amount > $old_amount) {
								throw new \Wallet\DebitException('Insufficient Funds!', 51);
						}
						if($actual_amount <= 0) {
								throw new \Wallet\DebitException('Invalid Amount!', 13);
						}
						$decimal_check = strlen(substr(strrchr($actual_amount, "."), 1));
						if($decimal_check > 2){
								throw new \Wallet\DebitException('Amount can be only 2 decimal places!', 14);
						}
						$new_balance                      = $old_amount - $actual_amount;
						$this->user->data->wallet_balance = $new_balance;
						if($this->user->save()) {
								$log = new \Wallet\Log();
								$log->addLog($this->user->guid, 'debit', $amount, $description);

								ossn_trigger_callback('user', 'wallet:debit', array(
										'user'        => $this->user,
										'description' => $description,
										'debit'       => $amount,
								));
								return true;
						}
				}
				return false;
		}
		/**
		 * Credit a mount to user balance
		 *
		 * @param integer $amount credit amount,
		 * @param string  $description Description
		 *
		 * @return boolean
		 */
		public function credit(int $amount, string $description): bool {
				if(!empty($amount)) {
						if(!isset($this->user->wallet_balance)) {
								$this->user->wallet_balance = 0;
						}
						$actual_amount = floatval(trim($amount));
						$old_amount    = floatval($this->user->wallet_balance);
						
						if($actual_amount <= 0) {
								throw new \Wallet\CreditException('Invalid Amount!', 13);
						}
						
						$new_balance                      = $old_amount + $actual_amount;
						$this->user->data->wallet_balance = $new_balance;
						if($this->user->save()) {
								$log = new \Wallet\Log();
								$log->addLog($this->user->guid, 'credit', $amount, $description);

								ossn_trigger_callback('user', 'wallet:credit', array(
										'user'        => $this->user,
										'description' => $description,
										'credit'      => $amount,
								));
								return true;
						}
				}
				return false;
		}
}