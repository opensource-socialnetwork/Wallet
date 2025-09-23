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
namespace Wallet\Gateway\Stripe;

require_once __Wallet__ . 'vendors/stripe/init.php';

class Seamless {
		private $_stripe;
		private $_user;
		
		/**
		 * Constructor for Stripe Seamless Gateway.
		 *
		 * Initializes Stripe client and validates user and settings.
		 *
		 * @param \OssnUser $user The OSSN user object.
		 * @throws \Wallet\GatewayException
		 * @throws \Wallet\NoUserException
		 */
		public function __construct($user) {
				$com      = new \OssnComponents();
				$settings = wallet_get_settings();

				if(!isset($settings->stripe_publishable_key) || !isset($settings->stripe_secret_key)) {
						throw new \Wallet\GatewayException('Invalid settings in administrator panel!');
				}

				if(!$user instanceof \OssnUser) {
						throw new \Wallet\NoUserException('Invalid User');
				}

				\Stripe\Stripe::setApiKey($settings->stripe_secret_key);

				$this->_stripe = new \Stripe\StripeClient($settings->stripe_secret_key);
				$this->_user   = $user;
		}

		/**
		 * Detach (remove) a payment method from Stripe.
		 *
		 * @param string $id The payment method ID.
		 * @return bool True if removed successfully, false otherwise.
		 */
		public function removePaymentMethod($id) {
				if(!empty($id)) {
						try {
								$paymentMethod = $this->_stripe->paymentMethods->detach($id, array());
								if(isset($paymentMethod->id)) {
										return true;
								}
						} catch (\Stripe\Exception\InvalidRequestException $e) {
								return false;
						}
						return false;
				}
		}

		/**
		 * Get Stripe Customer ID.
		 *
		 * @return string|null The customer ID or null.
		 */
		public function getCustomerID() {
				$stripe = new \Wallet\Gateway\Stripe($this->_user);
				return $stripe->getCustomerID();
		}

		/**
		 * Retrieve a specific payment method from Stripe.
		 *
		 * @param string $id The payment method ID.
		 * @return \Stripe\PaymentMethod|false
		 */
		public function paymentMethod($id) {
				try {
						return $this->_stripe->paymentMethods->retrieve($id);
				} catch (Exception $e) {
						// fallback
				} catch (\Stripe\Exception\InvalidRequestException $e) {
				}
				return false;
		}

		/**
		 * Get the count of failed seamless payment attempts.
		 *
		 * @return int Number of failed attempts.
		 */
		public function getFailedSeamless() {
				if(isset($this->_user->wallet_stripe_payment_seamless_fail_count)) {
						return intval($this->_user->wallet_stripe_payment_seamless_fail_count);
				}
				return 0;
		}

		/**
		 * Check if failed attempt limit has been reached.
		 *
		 * @return bool True if limit (3) reached, false otherwise.
		 */
		public function hasFailedLimitReached() {
				if($this->getFailedSeamless() > 3) {
						return true;
				}
				return false;
		}

		/**
		 * Increment the seamless payment failed attempt counter.
		 *
		 * @return void
		 */
		public function failedCountIncrease() {
				$count                                                        = $this->getFailedSeamless();
				$failed                                                       = $count + 1;
				$this->_user->data->wallet_stripe_payment_seamless_fail_count = $failed;
				$this->_user->save();
		}

		/**
		 * Reset the failed counter when payment succeeds.
		 *
		 * @return bool True if saved, false otherwise.
		 */
		public function resetFailedCount() {
				if(isset($this->_user->wallet_stripe_payment_method_id)) {
						$this->_user->data->wallet_stripe_payment_seamless_fail_count = 0;
						return $this->_user->save();
				}
				return false;
		}

		/**
		 * Charge a customer using a saved payment method.
		 *
		 * @param string $pm_id Payment method ID.
		 * @param float $price Amount to charge.
		 * @param string $descrption Description for the charge.
		 * @return \Stripe\PaymentIntent
		 */
		public function charge($pm_id, $price, $descrption) {
				$customer_id = $this->getCustomerID();
				return \Stripe\PaymentIntent::create(array(
						'customer'            => $customer_id,
						'payment_method'      => $pm_id,
						'amount'              => intval($price) * 100,
						'currency'            => strtolower(WALLET_CURRENCY_CODE),
						'description'         => $descrption,
						'confirmation_method' => 'automatic',
						'confirm'             => true,
						'off_session'         => true,
				));
		}

		/**
		 * Create a SetupIntent for saving a new payment method.
		 *
		 * @return \Stripe\SetupIntent|void Outputs JSON error and exits on failure.
		 */
		public function save() {
				$customer_id = $this->getCustomerID();
				try {
						return \Stripe\SetupIntent::create(array(
								'customer'               => $customer_id,
								'payment_method_types'   => array(
										'card',
								),
								'payment_method_options' => array(
										'card' => array(
												'request_three_d_secure' => 'any',
										),
								),
								'usage'                  => 'off_session',
						));
				} catch (Exception $e) {
						header('Content-Type: application/json');
						echo json_encode(array(
								'error' => $e->getMessage(),
						));
						error_log($e->getMessage());
						exit();
				}
		}
}