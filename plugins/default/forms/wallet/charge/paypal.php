<div class="ossn-widget">
	<div class="widget-heading"><?php echo ossn_print('wallet:charge:paypal');?></div>
	<div class="widget-contents">
		<div>
        		<label><?php echo ossn_print('wallet:charge:amount:paypal', array(WALLET_MINIMUM_LOAD, WALLET_CURRENCY_CODE));?></label>
                <input type="number" name="amount" min="<?php echo WALLET_MINIMUM_LOAD;?>" value="<?php echo WALLET_MINIMUM_LOAD;?>" />
        </div>	
        <div>
        		<input type="submit" class="btn btn-success btn-sm" value="<?php echo ossn_print('save');?>" />
        </div>
    </div>
</div>