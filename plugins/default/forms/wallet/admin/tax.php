<?php
$com   			= new OssnComponents();
$settings       = $com->getSettings('Wallet');
$tax_type       = '';
$tax_enabled     = '';

if(isset($settings->tax_type)) {
		$tax_type = $settings->tax_type;
}
if(isset($settings->tax_enabled)) {
		$tax_enabled = $settings->tax_enabled;
}
?>
<div class="alert alert-warning">
	<?php echo ossn_print('wallet:admn:tax:note');?>
</div>
<div>
	<label><?php echo ossn_print('wallet:admn:taxenable');?></label>
    <?php
		echo ossn_plugin_view('input/dropdown', array(
					'name' => 'tax_enabled',
					'value' => $tax_enabled,
					'options' => array(
					  'no' => 'No',
					  'yes' => 'Yes',
					),
		));
	?>
</div>
<div>
	<label><?php echo ossn_print('wallet:admn:taxtype');?></label>
    <?php
		echo ossn_plugin_view('input/dropdown', array(
					'name' => 'tax_type',
					'value' => $tax_type,
					'options' => array(
					  'inclusive' => 'Inclusive',
					  'exclusive' => 'Exclusive',
					),
		));
	?>
</div>

<div class="margin-top-10">
	<input type="submit" value="<?php echo ossn_print('save');?>" class="btn btn-success btn-sm" />
</div>