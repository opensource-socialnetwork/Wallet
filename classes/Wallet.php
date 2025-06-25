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
				if($balance <= 0) {
						throw new \Wallet\GeneralException('Invalid Amount!', 13);
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
		public function debit(float $amount, string $description): bool{
				$notification = new \Wallet\Notification($this->user);
				if($amount !== null && $amount > 0) {
						if($amount <= 0) {
								throw new \Wallet\DebitException('Invalid Amount!', 13);
						}
						if(!isset($this->user->wallet_balance)) {
								$this->user->wallet_balance = 0;
						}
						$actual_amount = floatval(trim($amount));
						$old_amount    = floatval($this->user->wallet_balance);

						//throw error if seamless actived , failed charge and no balance
						if($actual_amount > $old_amount && $this->seamlessActive()) {
								$stripe = new \Wallet\Gateway\Stripe\Seamless($this->user);
								if($stripe->hasFailedLimitReached()) {
										$notification->debit($amount, $description, 'failed');
										error_log("Limit Reached for Re-attempt | {$this->user->email} | GUID: {$this->user->guid}");
										throw new \Wallet\DebitException('Insufficient Funds! Limit Reached for Re-attempt!', 429);
								}
								try {
										$charge = $stripe->charge($this->user->wallet_stripe_payment_method_id, $amount, $description);
										if($charge->status == 'succeeded') {
												//credit to user wallet
												$this->credit($amount, 'Wallet Load');

												//reset the failed count
												$stripe->resetFailedCount();

												//update amount variable to debit can take place
												//because user object still have old data
												$user       = ossn_user_by_guid($this->user->guid);
												$this->user = $user;
												$old_amount = floatval($user->wallet_balance);
										}
								} catch (\Stripe\Exception\CardException $e) {
										//payment failed
										$stripe->failedCountIncrease();
										$notification->debit($amount, $description, 'failed');

										error_log("Wallet Payment Failed Seamless {$e->getMessage()} | {$this->user->email} | GUID: {$this->user->guid}");
										throw new \Wallet\DebitException('Insufficient Funds! Seamless Payment Failed', 51);
								} catch (\Exception $e) {
										$notification->debit($amount, $description, 'failed');
										error_log("Wallet Payment Failed Seamless {$e->getMessage()} | Some other error occured");
										throw new \Wallet\DebitException('Insufficient Funds! Seamless Payment Failed', 51);
								}
						}

						//throw error if seamless not active and no balance
						if($actual_amount > $old_amount && !$this->seamlessActive()) {
								$notification->debit($amount, $description, 'failed');
								throw new \Wallet\DebitException('Insufficient Funds!', 51);
						}

						if($actual_amount <= 0) {
								throw new \Wallet\DebitException('Invalid Amount!', 13);
						}
						$decimal_check = strlen(substr(strrchr($actual_amount, '.'), 1));
						if($decimal_check > 2) {
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
								$notification->debit($amount, $description, 'success');
								return true;
						}
				}
				return false;
		}
		/**
		 * Seamless payments requires Stripe and Save Payment Method
		 * If not enabled then it won't work
		 *
		 * @return boolean
		 */
		public function seamlessActive() {
				$methods = wallet_enabled_payment_methods();
				if(isset($this->user->wallet_stripe_payment_method_id) && in_array('stripe', $methods)) {
						return true;
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
		public function credit(int $amount, string $description): bool{
				$notification = new \Wallet\Notification($this->user);
				if($amount !== null && $amount > 0) {
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
								$notification->credit($amount, $description, 'success');
								return true;
						}
				}
				$notification->credit($amount, $description, 'failed');
				return false;
		}
}