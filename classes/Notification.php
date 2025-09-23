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
class Notification {
		private $user;
		/**
		 * Set a user
		 *
		 * Throws an error if user is invalid
		 * @param integer $guid User GUID
		 *
		 * @return void
		 */
		public function __construct($user) {
				$this->user = $user;
				if(!$this->user instanceof \OssnUser) {
						throw new \Wallet\NoUserException('Invalid User');
				}
		}
		/**
		 * Send email for debit
		 *
		 * @return boolean
		 */
		public function debit($amount, $description, $status = 'success') {
				$currency = WALLET_CURRENCY_CODE;
				$status   = ossn_print("wallet:tran:status:{$status}");
				$title    = ossn_print('wallet:tran:notification:debit', array(
						$status,
				));
				$body = ossn_print('wallet:tran:debit:notification:body', array(
						'Debit',
						$status,
						"{$amount} {$currency}",
						$description,
				));

				$mail = new \OssnMail();
				return $mail->notifyUser($this->user->email, $title, $body);
		}
		/**
		 * Send email for credit
		 *
		 * @return boolean
		 */
		public function credit($amount, $description, $status = 'success') {
				$currency = WALLET_CURRENCY_CODE;
				$status   = ossn_print("wallet:tran:status:{$status}");
				$title    = ossn_print('wallet:tran:notification:credit', array(
						$status,
				));
				$body = ossn_print('wallet:tran:debit:notification:body', array(
						'Credit',
						$status,
						"{$amount} {$currency}",
						$description,
				));

				$mail = new \OssnMail();
				return $mail->notifyUser($this->user->email, $title, $body);
		}
}