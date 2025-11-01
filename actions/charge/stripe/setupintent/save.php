<?php
header('Content-Type: application/json');

$id        = input('payment_id');
$tier_guid = input('tier_guid');
$tier      = false;

if(com_is_active('MembershipTier') && !empty($tier_guid)) {
		$tier = get_membership_tier($tier_guid);
}
$descrpitor = 'wallet verification charge';

$test_charge = WALLET_SEAMLESS_CHARGE;

if($tier) {
		$test_charge = $tier->tier_cost;
		$descrpitor  = 'subscription';
}

$redirect = false;
$user     = ossn_loggedin_user();

$stripe = new \Wallet\Gateway\Stripe\Seamless(ossn_loggedin_user());

try {
		$charge = $stripe->charge($id, $test_charge, $descrpitor);
		if($charge->status == 'succeeded') {
				
				$wallet = new \Wallet\Wallet($user->guid);
				$wallet->credit(WALLET_SEAMLESS_CHARGE, ossn_print('wallet:seamlesscharge:credit'));

				if($tier && com_is_active('MembershipTier')) {
						$membership = new Membership\Tier();
						$membership->setSubscribed(ossn_loggedin_user(), $tier->guid, $tier->duration);
						
						//debit
						$wallet = new \Wallet\Wallet($user->guid);
						$wallet->debit(WALLET_SEAMLESS_CHARGE, ossn_print('wallet:seamlesscharge:credit'));
						
						$redirect = 'home';
				}

				$pm   = $stripe->paymentMethod($id);
				$card = array(
						'brand'     => $pm->card->display_brand,
						'last4'     => $pm->card->last4,
						'exp_month' => $pm->card->exp_month,
						'exp_year'  => $pm->card->exp_year,
				);
				$card = json_encode($card);

				$user->data->wallet_stripe_payment_method_id           = $id;
				$user->data->wallet_stripe_payment_card_details        = $card;
				$user->data->wallet_stripe_payment_seamless_fail_count = 0;

				$user->save();

				ossn_trigger_callback('wallet', 'card:charged', array(
						'user'       => ossn_loggedin_user(),
						'amount'     => $test_charge,
						'descrpitor' => $descrpitor,
						'time'       => time(),
				));

				echo json_encode(array(
						'success'  => true,
						'redirect' => $redirect,
				));
				exit();
		}
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
\OssnSession::assign('wallet_last_error', $error);
ossn_trigger_callback('wallet', 'error', $error);

header('Content-Type: application/json');
error_log($error['type'] . ': ' . $error['message']);

echo json_encode(array(
		'success'  => false,
		'redirect' => ossn_site_url('wallet/seamlessfailed'),
));
exit();