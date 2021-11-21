<?php
$com = new OssnComponents;
$settings = $com->getSettings('Wallet');
$paypal_client_id = '';
if(isset($settings->paypal_client_id)){
	$paypal_client_id = $settings->paypal_client_id;
}
if(isset($settings->paypal_client_secret)){
	$paypal_client_secret = $settings->paypal_client_secret;
}

?>
<div>
	<label><?php echo ossn_print('wallet:admin:paypal');?></label>
</div>
<div>
	<label><?php echo ossn_print('wallet:admin:paypal:client:id');?></label>
    <input type="text" name="paypal_client_id" value="<?php echo $paypal_client_id;?>" />
</div>
<div>
	<label><?php echo ossn_print('wallet:admin:paypal:client:secret');?></label>
    <input type="text" name="paypal_client_secret" value="<?php echo $paypal_client_secret;?>" />
</div>
<div>
	<input type="submit" value="<?php echo ossn_print('save');?>" class="btn btn-success" />
</div>