<?php
header('Content-Type: application/json');

$user =  ossn_loggedin_user();

$stripe = new \Wallet\Gateway\Stripe\Seamless(ossn_loggedin_user());
$status = $stripe->save();


if($status->status == 'requires_payment_method') {
		if(isset($status->id)){
			 $user->data->wallet_stripe_setup_intent_id = $status->id;	
			 $user->save();
		}
		echo json_encode(array(
				'requires_action'              => true,
				'payment_intent_client_secret' => $status->client_secret,
		));
} else {
		echo json_encode(array(
				'failed'   => true,
				'redirect' => ossn_site_url('wallet/charge/failed'),
		));
}
exit();
