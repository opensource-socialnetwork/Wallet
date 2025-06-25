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
namespace Wallet\Gateway;
require_once __Wallet__ . 'vendors/stripe/init.php';
class Stripe {
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
		public function action($id, $price, $descrption) {
				$customer_id = $this->getCustomerID();
				try {
						return \Stripe\PaymentIntent::create(array(
								'customer'             => $customer_id,
								'payment_method'       => $id,
								'amount'               => intval($price) * 100,
								'currency'             => strtolower(WALLET_CURRENCY_CODE),
								'description'          => $descrption,
								'payment_method_types' => array(
										'card',
								),
								'confirmation_method'  => 'manual',
								'confirm'              => true,
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
		public function getCustomerID() {
				$user = $this->_user;
				if(!isset($user->wallet_stripe_customer_id) || (isset($user->wallet_stripe_customer_id) && empty($user->wallet_stripe_customer_id))) {
						$customer = $this->_stripe->customers->create(array(
								'name'        => $user->fullname,
								'email'       => $user->email,
								'description' => 'Wallet Customer',
								'metadata'    => array(
										'guid' => $user->guid,
								),
						));
						if($customer && !isset($customer->id)) {
								error_log('Customer create failed Wallet Stripe');
								return false;
						}
						$customer_id                           = $customer->id;
						$user->data->wallet_stripe_customer_id = $customer_id;
						$user->save();
				} else {
						$customer_id = $user->wallet_stripe_customer_id;
				}
				return $customer_id;
		}
		public function verify($id) {
				return $this->_stripe->paymentIntents->confirm($id);
		}
}