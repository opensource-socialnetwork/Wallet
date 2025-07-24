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
	<div>
		<label><?php echo ossn_print('wallet:amount');?> (<?php echo WALLET_CURRENCY_CODE;?>)</label>
		<input id='amount' type="number" min="<?php echo WALLET_MINIMUM_LOAD;?>" value="<?php echo WALLET_MINIMUM_LOAD;?>" />
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
<input type="button" id="payWalletCard" class="btn btn-success btn-sm" value="Pay Now" />
<div id="wallet-card-payment-loading" class="ossn-loading d-none"></div>
<script>
	wallet_card('<?php echo $settings->stripe_publishable_key;?>');
</script>