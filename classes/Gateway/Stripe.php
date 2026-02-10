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
		private $_stripe;
		private $_user;

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
				\Stripe\Stripe::setApiVersion('2025-09-30.preview');

				$this->_stripe = new \Stripe\StripeClient($settings->stripe_secret_key);
				$this->_user   = $user;
		}
		public function calculateTax($reference, $price) {
				if(empty($price) || empty($reference)) {
						return false;
				}
				$tax_type = wallet_stripe_tax_type();
				try {
						$tax = $this->_stripe->tax->calculations->create(array(
								'currency'   => strtolower(WALLET_CURRENCY_CODE),
								'line_items' => array(
										array(
												'amount'       => round(floatval($price) * 100),
												'reference'    => $reference,
												'tax_behavior' => $tax_type,
										),
								),
								'customer'   => $this->getCustomerID(),
						));
				} catch (Exception $e) {
						error_log($e->getMessage());
						return false;
				} catch (\Stripe\Exception\InvalidRequestException $e) {
						error_log($e->getMessage());
						return false;
				}
				if(isset($tax->amount_total)) {
						return $tax;
				}
				return false;
		}

		public function action($id, $price, $descrption) {
				$customer_id = $this->getCustomerID();
				$args        = array(
						'customer'             => $customer_id,
						'payment_method'       => $id,
						'amount'               => round(floatval($price) * 100),
						'currency'             => strtolower(WALLET_CURRENCY_CODE),
						'description'          => $descrption,
						'payment_method_types' => array(
								'card',
						),
						'confirmation_method'  => 'manual',
						'confirm'              => true,
				);

				if($address_array = $this->getCustomerAddress()) {
						$args['shipping']['name']    = $this->_user->fullname;
						$args['shipping']['address'] = $address_array;
				}

				if(wallet_stripe_deduct_tax()) {
						$tax_cal = $this->calculateTax($descrption, $price);
						if($tax_cal) {
								$tax_cal_id     = $tax_cal->id;
								$args['amount'] = $tax_cal->amount_total;
								if(empty($tax_cal->amount_total)) {
										header('Content-Type: application/json');
										echo json_encode(array(
												'error' => ossn_print('wallet:error:taxamountempty'),
										));
										error_log('Tax amount can not be empty');
										exit();
								}
								$args['hooks'] = array(
										'inputs' => array(
												'tax' => array(
														'calculation' => $tax_cal_id,
												),
										),
								);
						}
				}

				try {
						$paymentIntent = \Stripe\PaymentIntent::create($args);
						return $paymentIntent;
				} catch (\Stripe\Exception\CardException $e) {
						// Card was declined, expired, etc.
						$error = array(
								'type'         => 'card_error',
								'message'      => $e->getError()->message,
								'code'         => $e->getError()->code,
								'decline_code' => $e->getError()->decline_code,
						);
				} catch (\Stripe\Exception\RateLimitException $e) {
						// Too many requests made too quickly
						$error = array(
								'type'    => 'rate_limit',
								'message' => $e->getMessage(),
						);
				} catch (\Stripe\Exception\InvalidRequestException $e) {
						// Invalid parameters were supplied to Stripe's API
						$error = array(
								'type'    => 'invalid_request',
								'message' => $e->getMessage(),
						);
				} catch (\Stripe\Exception\AuthenticationException $e) {
						// API key or authentication failed
						$error = array(
								'type'    => 'auth_error',
								'message' => $e->getMessage(),
						);
				} catch (\Stripe\Exception\ApiConnectionException $e) {
						// Network communication with Stripe failed
						$error = array(
								'type'    => 'api_connection',
								'message' => $e->getMessage(),
						);
				} catch (\Stripe\Exception\ApiErrorException $e) {
						// Generic API error (covers most remaining Stripe errors)
						$error = array(
								'type'    => 'api_error',
								'message' => $e->getMessage(),
						);
				} catch (Exception $e) {
						// Catch any other non-Stripe exception (e.g., PHP logic errors)
						$error = array(
								'type'    => 'general_error',
								'message' => $e->getMessage(),
						);
				}
				//log errors
				\OssnSession::assign("wallet_last_error", $error);
				ossn_trigger_callback('wallet', 'error', $error);
				
				header('Content-Type: application/json');
				error_log($error['type'] . ': ' . $error['message']);
				
				//don't send error message to user.
				unset($error['message']);
				echo json_encode(array(
						'error' => $error,
				));
				exit();
		}
		public function getCustomerAddress() {
				$user = $this->_user;

				$address = '';
				$country = '';
				$city    = '';
				$postal  = '';
				$state   = '';

				if(isset($user->billing_address) && !empty($user->billing_address)) {
						$address = $user->billing_address;
				}

				if(isset($user->billing_country) && !empty($user->billing_country)) {
						$country = $user->billing_country;
				}

				if(isset($user->billing_city) && !empty($user->billing_city)) {
						$city = $user->billing_city;
				}

				if(isset($user->billing_postal) && !empty($user->billing_postal)) {
						$postal = $user->billing_postal;
				}
				if(isset($user->billing_state) && !empty($user->billing_state)) {
						$state = $user->billing_state;
				}

				$user_stripe_array = array();
				if(!empty($country) && !empty($postal) && !empty($address) && !empty($city) && !empty($state)) {
						$user_stripe_array['country']     = $country;
						$user_stripe_array['postal_code'] = $postal;
						$user_stripe_array['line1']       = $address;
						$user_stripe_array['city']        = $city;
						$user_stripe_array['state']       = $state;
				}
				if(!empty($user_stripe_array)) {
						return $user_stripe_array;
				}
				return false;
		}
		public function getCustomerID() {
				$user              = $this->_user;
				$user_stripe_array = array(
						'name'        => $user->fullname,
						'email'       => $user->email,
						'description' => 'Wallet Customer',
						'metadata'    => array(
								'guid' => $user->guid,
						),
				);

				if($address_array = $this->getCustomerAddress()) {
						$user_stripe_array['address'] = $address_array;
				}

				if(!isset($user->wallet_stripe_customer_id) || (isset($user->wallet_stripe_customer_id) && empty($user->wallet_stripe_customer_id))) {
						$customer = $this->_stripe->customers->create($user_stripe_array);
						if($customer && !isset($customer->id)) {
								error_log('Customer create failed Wallet Stripe');
								return false;
						}
						$customer_id                           = $customer->id;
						$user->data->wallet_stripe_customer_id = $customer_id;
						$user->save();
				} else {


						//exists update customer in system
						$customer = $this->_stripe->customers->update($user->wallet_stripe_customer_id, $user_stripe_array);
						if($customer && !isset($customer->id)) {
								error_log('Customer update failed Wallet Stripe');
								return false;
						}
						$customer_id = $user->wallet_stripe_customer_id;
				}
				return $customer_id;
		}
		public function verify($id) {
				return $this->_stripe->paymentIntents->confirm($id);
		}
}