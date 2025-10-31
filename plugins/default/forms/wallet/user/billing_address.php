<?php
require_once(__Wallet__ . 'libs/countries.php');
$user = ossn_loggedin_user();
$address = '';
$country = '';
$city    = '';
$postal  = '';
$state  = '';

// Safely load stored billing info from user->data
if (isset($user->billing_address) && !empty($user->billing_address)) {
    $address = $user->billing_address;    
}

if (isset($user->billing_country) && !empty($user->billing_country)) {
    $country = $user->billing_country;    
}

if (isset($user->billing_city) && !empty($user->billing_city)) {
    $city = $user->billing_city;    
}

if (isset($user->billing_postal) && !empty($user->billing_postal)) {
    $postal = $user->billing_postal;    
}
if (isset($user->billing_state) && !empty($user->billing_state)) {
    $state = $user->billing_state;    
}
?>
<div>
	<label><?php echo ossn_print('wallet:billingaddress:address');?></label>
    <?php
		echo ossn_plugin_view('input/text', array(
				'name' => 'address',
				'value' => $address,
		));
	?>
</div>
<div>
	<label><?php echo ossn_print('wallet:billingaddress:city');?></label>
    <?php
		echo ossn_plugin_view('input/text', array(
				'name' => 'city',	
				'value' => $city,
		));
	?>
</div>
<div>
	<label><?php echo ossn_print('wallet:billingaddress:state');?></label>
    <?php
		echo ossn_plugin_view('input/text', array(
				'name' => 'state',
				'value' => $state,
		));
	?>
</div>
<div>
	<label><?php echo ossn_print('wallet:billingaddress:postal');?></label>
    <?php
		echo ossn_plugin_view('input/text', array(
				'name' => 'postal_code',	
				'value' => $postal,
		));
	?>
</div>
<div>
	<label><?php echo ossn_print('wallet:billingaddress:country');?></label>
    <?php
		echo ossn_plugin_view('input/dropdown', array(
				'options' => wallet_countries_list(),	
				'name' => 'country',
				'placeholder' => ossn_print('wallet:billingaddress:select'),
				'value' => $country,
		));
	?>
</div>
<input type="submit" value="<?php echo ossn_print('save');?>" class="btn btn-success btn-sm" />