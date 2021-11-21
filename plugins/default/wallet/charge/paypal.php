<?php
$PayerID = input('PayerID');
$token   = input('token');
if(!empty($token) && !empty($PayerID)) {
		if(!isset($_SESSION['__WALLET_PAYPAL_EA_ID']) || (isset($_SESSION['__WALLET_PAYPAL_EA_ID']) && empty($_SESSION['__WALLET_PAYPAL_EA_ID']))) {
				ossn_trigger_message(ossn_print('wallet:charge:paypal:failed'), 'error');
				redirect('wallet/charge/failed');
		}
		$Gateway = new Wallet\Gateway\PayPal();
		$client  = $Gateway->getClient();

		$request = new PayPalCheckoutSdk\Orders\OrdersCaptureRequest($_SESSION['__WALLET_PAYPAL_EA_ID']);
		$request->prefer('return=representation');
		try {
				unset($_SESSION['__WALLET_PAYPAL_EA_ID']);
				$response = $client->execute($request);
				if(isset($response->result) && isset($response->result->status) && $response->result->status == 'COMPLETED') {
						if(isset($response->result->purchase_units) && isset($response->result->purchase_units[0]->amount) && isset($response->result->purchase_units[0]->amount->value)) {
								$amount = $response->result->purchase_units[0]->amount->value;
								$wallet = new \Wallet\Wallet(ossn_loggedin_user()->guid);
								if($wallet->credit($amount, 'Load via PayPal')) {
										ossn_trigger_message(ossn_print('wallet:charge:paypal:success'));
										redirect('wallet/overview');
								}
						}
				}
		} catch (PayPalHttp\HttpException $ex) {
				error_log("WalletChargePaypal: Error : ".$ex->getMessage());
				ossn_trigger_message(ossn_print('wallet:charge:paypal:failed'), 'error');
				redirect('wallet/charge/failed');
		}
}
echo ossn_view_form('wallet/charge/paypal', array(
		'action' => ossn_site_url() . 'action/wallet/charge/paypal',
));