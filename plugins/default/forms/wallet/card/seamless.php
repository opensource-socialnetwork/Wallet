<?php
$com = new \OssnComponents;
$settings = $com->getSettings('Wallet');
if(!isset($settings->stripe_publishable_key) || !isset($settings->stripe_secret_key)){
		throw new \Wallet\GatewayException('Invalid settings in administrator panel!');
}
?>
<div id="wallet-form-errors">
	<div class="alert alert-danger d-none"></div>
</div>
<div id="wallet-card-details">
	<div class="alert alert-success" role="alert">
 		 <h4 class="alert-heading"><?php echo ossn_print('wallet:seamnless:charge:head');?></h4>
  		 <p><?php echo ossn_print('wallet:saveseamless:testcharge:note', array(WALLET_SEAMLESS_CHARGE, WALLET_CURRENCY_CODE));?></p>
  	</div>
	<div>
		<label><?php echo ossn_print('wallet:card:holder');?></label>
		<input type="text" value="<?php echo ossn_loggedin_user()->fullname;?>" readonly="readonly" />
	</div>
	<div>
		<label><?php echo ossn_print('wallet:card:number');?></label>
		<div id="card" class="wallet-card-input"></div>
	</div>
</div>
<div id="wallet-card-processing" class="d-none">
	<div class="alert alert-info"><?php echo ossn_print('wallet:card:process');?></div>
</div>
<input type="button" id="payWalletCard" class="btn btn-success btn-sm" value="<?php echo ossn_print('save');?>" />
<div id="wallet-card-payment-loading" class="ossn-loading d-none"></div>
<script>
	wallet_seamless('<?php echo $settings->stripe_publishable_key;?>');
</script>