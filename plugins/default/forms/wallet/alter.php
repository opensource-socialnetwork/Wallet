<?php
$id = input('guid');
$wallet = new Wallet\Wallet($id);
$balance = $wallet->getBalance();

$user = ossn_user_by_guid($id);
?>
<style>
.wallet-alter label {
	display:block !important;
	margin-bottom:10px;
}
.wallet-alter input[type="text"]{
	width:100% !important;	
}
</style>
<div class="wallet-alter">
<div>
	<label><?php echo ossn_print('name'); ?></label>
    <input type="text" disabled="disabled" value="<?php echo $user->fullname;?>" />
</div>
<div class="margin-top-10">
	<label><?php echo ossn_print('wallet:current:balance'); ?></label>
    <input type="text" disabled="disabled" value="<?php echo $balance;?>" />
</div>
<hr />
<div class="margin-top-10">
	<label><?php echo ossn_print('wallet:alter:type'); ?></label>
    <?php 
	echo ossn_plugin_view('input/dropdown', array(
			'name' => 'alter_type',
			'options' => array(
				'total' => 	ossn_print('wallet:alter:type:entier'),
				'credit' => ossn_print('wallet:alter:type:credit'),
				'debit' => ossn_print('wallet:alter:type:debit'),
			),
	)); 
	?>
</div>
<div class="margin-top-10">
	<label><?php echo ossn_print('wallet:alter:amount'); ?> (<?php echo WALLET_CURRENCY_CODE;?>)</label>
	<input type="number" name="amount" />
</div>
	<input type="hidden" name="guid" value="<?php echo input('guid');?>" />
	<input type="submit" id="ossn-wallet-balance-alter-btn" class="hidden d-none" />
</div>