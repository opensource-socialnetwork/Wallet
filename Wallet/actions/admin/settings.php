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
		'paypal_client_id'        => input('paypal_client_id'),
		'paypal_client_secret'    => input('paypal_client_secret'),
);
if($component->setSettings('Wallet', $vars)) {
		ossn_trigger_message(ossn_print('wallet:admin:settings:saved'));
		redirect(REF);
} else {
		ossn_trigger_message(ossn_print('wallet:admin:settings:save:error'), 'error');
		redirect(REF);
}