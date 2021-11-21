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
$amount = trim(intval(input('amount')));
if($amount < WALLET_MINIMUM_LOAD){
		ossn_trigger_message(ossn_print('wallet:charge:min'), 'error');
		redirect(REF);
}
$Gateway = new Wallet\Gateway\PayPal();
$client  = $Gateway->getClient();

$request = new PayPalCheckoutSdk\Orders\OrdersCreateRequest();
$request->prefer('return=representation');
$request->body = array(
		'intent'              => 'CAPTURE',
		'purchase_units'      => array(
				array(
						'description'  => 'Wallet Reload via PayPal',
						'reference_id' => 'wallet_charge_' . time() . '_' . ossn_loggedin_user()->guid,
						'amount'       => array(
								'value'         => $amount,
								'currency_code' => WALLET_CURRENCY_CODE,
						),
				),
		),
		'application_context' => array(
				'cancel_url' => ossn_site_url('wallet/charge/failed'),
				'return_url' => ossn_site_url('wallet/charge/paypal'),
		),
);
try {
		// Call API with your client and get a response for your call
		$response = $client->execute($request);

		// If call returns body in response, you can get the deserialized version from the result attribute of the response
		if(isset($response->result) && isset($response->result->id)) {
				$_SESSION['__WALLET_PAYPAL_EA_ID'] = $response->result->id;
				foreach($response->result->links as $link) {
						if($link->rel == 'approve') {
								$ealink = $link->href;
								header("Location: {$ealink}");
								exit();
								break;
						}
				}
		}
} catch (PayPalHttp\HttpException $ex) {
		ossn_trigger_message(ossn_print('wallet:charge:paypal:failed'), 'error');
}
redirect('wallet/charge/failed');