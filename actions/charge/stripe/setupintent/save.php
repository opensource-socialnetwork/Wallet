<?php
header('Content-Type: application/json');

$id = input('payment_id');

$user = ossn_loggedin_user();

$stripe = new \Wallet\Gateway\Stripe\Seamless(ossn_loggedin_user());

try {
		$charge = $stripe->charge($id, WALLET_SEAMLESS_CHARGE, 'wallet verification charge');
		if($charge->status == 'succeeded') {
				$wallet = new \Wallet\Wallet($user->guid);
				$wallet->credit(WALLET_SEAMLESS_CHARGE, ossn_print('wallet:seamlesscharge:credit'));
				
				$pm   = $stripe->paymentMethod($id);
				$card = array(
						'brand'     => $pm->card->display_brand,
						'last4'     => $pm->card->last4,
						'exp_month' => $pm->card->exp_month,
						'exp_year'  => $pm->card->exp_year,
				);
				$card = json_encode($card);

				$user->data->wallet_stripe_payment_method_id    = $id;
				$user->data->wallet_stripe_payment_card_details = $card;
				$user->data->wallet_stripe_payment_seamless_fail_count = 0;

				$user->save();
				echo json_encode(array(
						'success' => true,
				));
				exit();
		}
} catch (\Stripe\Exception\CardException $e) {
}

echo json_encode(array(
		'success'  => false,
		'redirect' => ossn_site_url('wallet/seamlessfailed'),
));
exit();