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
		public function __construct() {
				$com      = new \OssnComponents();
				$settings = $com->getSettings('Wallet');
				if(!isset($settings->stripe_publishable_key) || !isset($settings->stripe_secret_key)) {
						throw new \Wallet\GatewayException('Invalid settings in administrator panel!');
				}
				\Stripe\Stripe::setApiKey($settings->stripe_secret_key);
				$this->_stripe = new \Stripe\StripeClient($settings->stripe_secret_key);

		}
		public function action($id, $price, $descrption) {
				try {
						$user = ossn_loggedin_user();
						return \Stripe\PaymentIntent::create(array(
								'payment_method'      => $id,
								'amount'              => intval($price) * 100,
								'currency'            => strtolower(WALLET_CURRENCY_CODE),
								'description'         => $descrption,
								'confirmation_method' => 'manual',
								'confirm'             => true,							
						));
				} catch (Exception $e) {
						header('Content-Type: application/json');
						echo json_encode(array(
								'error' => $e->getMessage(),
						));
						exit();
				}
		}
		public function verify($id){
				return $this->_stripe->paymentIntents->confirm($id);	
		}
}