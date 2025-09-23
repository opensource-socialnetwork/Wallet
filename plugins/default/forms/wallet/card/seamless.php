<?php
$com = new \OssnComponents;
$settings = $com->getSettings('Wallet');
if(!isset($settings->stripe_publishable_key) || !isset($settings->stripe_secret_key)){
		throw new \Wallet\GatewayException('Invalid settings in administrator panel!');
}
$duration = array(
		'monthly' => ossn_print('membershiptier:duration:monthly'),
		'yearly'  =>ossn_print('membershiptier:duration:yearly'), 
		'onetime' => ossn_print('membershiptier:duration:onetime'),				   
); 
?>
<div id="wallet-form-errors">
	<div class="alert alert-danger d-none"></div>
</div>
<div id="wallet-card-details">
	<?php  if(isset($params['guid']) && isset($params['tier']) && $params['tier'] == 'tier' && com_is_active('MembershipTier') && $tier = get_membership_tier($params['guid'])){ ?>
		<label><?php echo ossn_print('membership:status:plan');?></label>
		<input type="text" value="<?php echo $tier->title;?>" readonly/>

		<label><?php echo ossn_print('membershiptier:cost');?></label>
		<input type="text" value="<?php echo $tier->tier_cost;?> <?php echo WALLET_CURRENCY_CODE;?>" readonly/>      

		<label><?php echo ossn_print('membershiptier:duration');?></label>
		<input type="text" value="<?php echo $duration[$tier->duration];?>" readonly/>      
        
        <input type="hidden" name="tier_guid" value="<?php echo $iter->guid;?>" />          
    <?php } else { ?>
	<div class="alert alert-success" role="alert">
 		 <h4 class="alert-heading"><?php echo ossn_print('wallet:seamnless:charge:head');?></h4>
  		 <p><?php echo ossn_print('wallet:saveseamless:testcharge:note', array(WALLET_SEAMLESS_CHARGE, WALLET_CURRENCY_CODE));?></p>
  	</div>
    <?php } ?>
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
	var tier_guid = "";
	<?php  if(isset($params['guid']) && isset($params['tier']) && $params['tier'] == 'tier' && com_is_active('MembershipTier') && $tier = get_membership_tier($params['guid'])){ ?>
	var tier_guid = "<?php echo $params['guid']; ?>";	
	<?php }	?>
	wallet_seamless('<?php echo $settings->stripe_publishable_key;?>', tier_guid);
</script>