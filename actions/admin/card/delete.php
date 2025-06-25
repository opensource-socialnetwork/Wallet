<?php
$guid   = input('guid');
$user   = ossn_user_by_guid($guid);

if(!$user){
	ossn_trigger_message(ossn_print('wallet:paymentmethod:remove:failed'), 'error');
	redirect(REF);	
}

$stripe = new \Wallet\Gateway\Stripe\Seamless($user);

if($stripe->removePaymentMethod($user->wallet_stripe_payment_method_id)) {
		$user->data->wallet_stripe_payment_method_id    = false;
		$user->data->wallet_stripe_payment_card_details = false;
		$user->data->wallet_stripe_setup_intent_id      = false;
		$user->data->wallet_stripe_payment_seamless_fail_count = false;
		
		$user->save();

		ossn_trigger_message(ossn_print('wallet:paymentmethod:removed'));
		redirect(REF);
}
ossn_trigger_message(ossn_print('wallet:paymentmethod:remove:failed'), 'error');
redirect(REF);