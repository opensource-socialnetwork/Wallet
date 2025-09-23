<?php
$id      = input('id');
$success = false;
header('Content-Type: application/json');

$stripe = new \Wallet\Gateway\Stripe(ossn_loggedin_user());
try {
		$verify = $stripe->verify($id);
		if($verify && $verify->status == 'succeeded') {
				$amount = $verify->amount / 100;

				$wallet = new \Wallet\Wallet(ossn_loggedin_user()->guid);
				$wallet->credit($amount, 'Load via Card');

				ossn_trigger_callback('wallet', 'card:charged', array(
						'user'       => ossn_loggedin_user(),
						'amount'     => $amount,
						'descrpitor' => 'Load via Card',
						'time'       => time(),
				));

				echo json_encode(array(
						'success'  => true,
						'redirect' => ossn_site_url('wallet/overview'),
				));
		}
} catch (Exception $e) {
		echo json_encode(array(
				'failed'   => true,
				'redirect' => ossn_site_url('wallet/charge/failed'),
		));
}