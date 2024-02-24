<?php
/**
 * Open Source Social Network
 *
 * @package   Premium Social Network
 * @author    OSSN Core Team <info@openteknik.com>
 * @copyright (C) OpenTeknik LLC
 * @license   OPENTEKNIK LLC, COMMERCIAL LICENSE v1.0 https://www.openteknik.com/license/commercial-license-v1
 * @link      https://www.openteknik.com
 */
$component = new OssnComponents();

$vars = array(
		'paypal_client_id'       => input('paypal_client_id'),
		'paypal_client_secret'   => input('paypal_client_secret'),
		'stripe_publishable_key' => input('stripe_publishable_key'),
		'stripe_secret_key'      => input('stripe_secret_key'),
		'iyzipay_key'            => input('iyzipay_key'),
		'iyzipay_secret_key'     => input('iyzipay_secret_key'),
		'iyzipay_mode'           => input('iyzipay_mode'),
);
$methods = input('methods');
if(!empty($methods)) {
		$payment_methods = json_encode(array_keys($methods));
} else {
		$payment_methods = '';
}
$vars['payment_methods'] = $payment_methods;
if($component->setSettings('Wallet', $vars)) {
		ossn_trigger_message(ossn_print('wallet:admin:settings:saved'));
		redirect(REF);
} else {
		ossn_trigger_message(ossn_print('wallet:admin:settings:save:error'), 'error');
		redirect(REF);
}