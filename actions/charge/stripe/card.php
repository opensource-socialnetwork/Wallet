<?php
header('Content-Type: application/json');

$amount = input('amount');
if($amount <= 0) {
		echo json_encode(array(
				'success' => false,
		));
		exit();
}
$id = input('id');

$stripe = new \Wallet\Gateway\Stripe\Seamless(ossn_loggedin_user());
$status = $stripe->action($id, $amount, 'Wallet load via card');

if($status->status == 'requires_action' && $status->next_action->type == 'use_stripe_sdk') {
		echo json_encode(array(
				'requires_action'              => true,
				'payment_intent_client_secret' => $status->client_secret,
		));
} elseif($status->status == 'succeeded') {
		$amount = $status->amount / 100;

		$wallet = new \Wallet\Wallet(ossn_loggedin_user()->guid);
		$wallet->credit($amount, 'Load via Card');

		echo json_encode(array(
				'success'  => true,
				'redirect' => ossn_site_url('wallet/overview'),
		));
} else {
		echo json_encode(array(
				'failed'   => true,
				'redirect' => ossn_site_url('wallet/charge/failed'),
		));
}
exit();
