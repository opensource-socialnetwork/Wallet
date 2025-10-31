<?php
$address = input('address');
$country = input('country');
$city    = input('city');
$postal  = input('postal_code');
$state   = input('state');

if(empty($address) || empty($country) || empty($city) || empty($postal) || empty($state)) {
		ossn_trigger_message(ossn_print('wallet:billing:fieldsrequired'), 'error');
		redirect(REF);
}

// Validate city and state (only letters, spaces, and hyphens allowed)
if(preg_match('/[^A-Za-z\s\-]/', $city)) {
		ossn_trigger_message(ossn_print('wallet:billing:invalid_city'), 'error');
		redirect(REF);
}
if(preg_match('/[^A-Za-z\s\-]/', $state)) {
		ossn_trigger_message(ossn_print('wallet:billing:invalid_state'), 'error');
		redirect(REF);
}

if(!validate_postal_code($country, $postal)) {
		ossn_trigger_message(ossn_print('wallet:billing:invalid_postal'), 'error');
		redirect(REF);
}

$user                        = ossn_loggedin_user();
$user->data->billing_address = $address;
$user->data->billing_city    = $city;
$user->data->billing_postal  = $postal;
$user->data->billing_state   = $state;
$user->data->billing_country = $country;

if($user->save()) {
		ossn_trigger_message(ossn_print('wallet:billing:saved'));
		redirect(REF);
} else {
		ossn_trigger_message(ossn_print('wallet:billing:save:error'), 'error');
		redirect(REF);
}