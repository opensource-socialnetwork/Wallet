<?php
$com                    = new OssnComponents();
$settings               = $com->getSettings('Wallet');
$paypal_client_id       = '';
$paypal_client_secret   = '';
$stripe_publishable_key = '';
$stripe_secret_key      = '';
$iyzipay_key            = '';
$iyzipay_secret_key     = '';
$iyzipay_mode           = '';

$payment_methods        = array();
if(isset($settings->paypal_client_id)) {
		$paypal_client_id = $settings->paypal_client_id;
}
if(isset($settings->paypal_client_secret)) {
		$paypal_client_secret = $settings->paypal_client_secret;
}
if(isset($settings->stripe_publishable_key)) {
		$stripe_publishable_key = $settings->stripe_publishable_key;
}
if(isset($settings->stripe_secret_key)) {
		$stripe_secret_key = $settings->stripe_secret_key;
}
if(isset($settings->payment_methids)){
		$payment_methods = json_decode($settings->payment_methids, true);	
}
if(isset($settings->iyzipay_key)){
		$iyzipay_key = $settings->iyzipay_key;	
}
if(isset($settings->iyzipay_secret_key)){
		$iyzipay_secret_key = $settings->iyzipay_secret_key;	
}
if(isset($settings->iyzipay_mode)){
		$iyzipay_mode = $settings->iyzipay_mode;	
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
	<label><?php echo ossn_print('wallet:admin:stripe');?></label>
</div>
<div>
	<label><?php echo ossn_print('wallet:admin:stripe:publishable:key');?></label>
    <input type="text" name="stripe_publishable_key" value="<?php echo $stripe_publishable_key;?>" />
</div>
<div>
	<label><?php echo ossn_print('wallet:admin:stripe:secret:key');?></label>
    <input type="text" name="stripe_secret_key" value="<?php echo $stripe_secret_key;?>" />
</div>
<div>
	<label><?php echo ossn_print('wallet:admin:iyzipay');?></label>
</div>
<div>
	<label><?php echo ossn_print('wallet:admin:iyzipay:key');?></label>
    <input type="text" name="iyzipay_key" value="<?php echo $iyzipay_key;?>" />
</div>
<div>
	<label><?php echo ossn_print('wallet:admin:iyzipay:secret:key');?></label>
    <input type="text" name="iyzipay_secret_key" value="<?php echo $iyzipay_secret_key;?>" />
</div>
<div>
	<label><?php echo ossn_print('wallet:admin:iyzipay:mode');?></label>
    <?php
		echo ossn_plugin_view('input/dropdown', array(
					'name' => 'iyzipay_mode',
					'value' => $iyzipay_mode,
					'options' => array(
						'' => '',
					   'sandbox' => 'Sandbox',
					   'production' => 'Production',
					),
		));
	?>
</div>
<div>
	<label><?php echo ossn_print('wallet:admin:payment:methods');?></label>
</div>
<div class="wallet-payment-methods">
<?php
	$payment_methods = array(
				    'paypal' => 'PayPal',
					'stripe' => 'Stripe (Card)',
					'iyzipay' => 'Iyzipay (Iyzico)',
	);
	$avil_methods = wallet_enabled_payment_methods();
	foreach($payment_methods  as $key => $item){
			$args = array(
						'name' => "methods[$key]",
						'label' => $item,
			);
			$args['value'] = false;
			if($avil_methods && in_array($key, $avil_methods)){
				$args['value'] = true;
				$args['checked'] = 'checked';	
			}			
			echo ossn_plugin_view('input/checkbox', $args);
	}
?>
</div>
<div class="margin-top-10">
	<input type="submit" value="<?php echo ossn_print('save');?>" class="btn btn-success btn-sm" />
</div>
<style>
	.wallet-payment-methods .checkbox-block {
		margin-bottom:5px;
	}
	.wallet-payment-methods .checkbox-block span {
		margin-left:10px;
	}
	.wallet-payment-methods .ossn-checkbox-input {
   	 	width: 20px;
    	height: 20px;
		cursor:pointer;
    	float: left;		
	}
</style>