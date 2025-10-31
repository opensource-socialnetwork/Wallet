<?php
if(!wallet_stripe_deduct_tax()){
		return;
}
?>
<div class="wallet-billing-form">
	<label><?php echo ossn_print('wallet:billingaddress'); ?></label>

	<div class="form-group">
		<input type="text" class="form-control" name="address"
			placeholder="<?php echo ossn_print('wallet:billingaddress:address'); ?>">
	</div>

	<div class="form-group-row">
		<div class="form-group ossn-form-group-half">
			<input type="text" class="form-control" name="city"
				placeholder="<?php echo ossn_print('wallet:billingaddress:city'); ?>">
		</div>
		<div class="form-group ossn-form-group-half">
			<input type="text" class="form-control" name="state"
				placeholder="<?php echo ossn_print('wallet:billingaddress:state'); ?>">
		</div>
	</div>

	<div class="form-group-row">
		<div class="form-group ossn-form-group-half">
			<input type="text" class="form-control" name="postal_code"
				placeholder="<?php echo ossn_print('wallet:billingaddress:postal'); ?>">
		</div>
		<div class="form-group ossn-form-group-half">
			<?php
				require_once(__Wallet__ . 'libs/countries.php');
				echo ossn_plugin_view('input/dropdown', array(
					'options' => wallet_countries_list(),
					'name' => 'country',
					'placeholder' => ossn_print('wallet:billingaddress:country'),
					'value' => $country,
				));
			?>
		</div>
	</div>
</div>
<style>
.wallet-billing-form .ossn-form-group-half {
	float:none;
}
</style>