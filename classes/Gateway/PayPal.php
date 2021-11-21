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
require_once(__Wallet__ . 'vendors/paypal/vendor/autoload.php');
class PayPal {
			public function getClient(){
				$com = new \OssnComponents;
				$settings = $com->getSettings('Wallet');
				if(!isset($settings->paypal_client_id) || !isset($settings->paypal_client_secret)){
							throw new \Wallet\GatewayException('Invalid settings in administrator panel!');
				}

				//$environment = new \PayPalCheckoutSdk\Core\SandboxEnvironment($settings->paypal_client_id, $settings->paypal_client_secret);
				$environment = new \PayPalCheckoutSdk\Core\ProductionEnvironment($settings->paypal_client_id, $settings->paypal_client_secret);
				$client = new \PayPalCheckoutSdk\Core\PayPalHttpClient($environment);
				return $client;
			}
}
