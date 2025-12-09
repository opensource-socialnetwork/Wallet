<?php
$user = ossn_loggedin_user();
$user = ossn_user_by_guid($user->guid);

$DateTime = new DateTime('NOW');
$wallet   = new \Wallet\Wallet(ossn_loggedin_user()->guid);
$settings = wallet_get_settings();

$owner_email = ossn_site_settings('owner_email');

if(!$settings){
?>
<div class="ossn-widget">
	<div class="widget-heading"><?php echo ossn_print('wallet:overview');?> (<span class="wallet-balance-date"><?php echo $DateTime->format(DateTime::ATOM);?>)</span></div>
	<div class="widget-contents">
    	<div class="alert alert-danger">
        		<?php echo ossn_print('wallet:notconfigured:note');?>
        </div>
    </div>
</div>
<?php	
return;
}
?>
<div class="ossn-widget">
	<div class="widget-heading"><?php echo ossn_print('wallet:overview');?> (<span class="wallet-balance-date"><?php echo $DateTime->format(DateTime::ATOM);?>)</span></div>
	<div class="widget-contents">
    		<div class="wallet-balance">
				<div class="wallet-balance-title"><?php echo ossn_print('wallet:current:balance');?></div>
    	        <div class="wallet-balance-amount"><span><?php echo number_format($wallet->getBalance(),2);?></span> <span class="wallet-balance-currency"><?php echo WALLET_CURRENCY_CODE;?></span></div>
             </div>
    </div>
</div>

<div class="ossn-widget">
	<div class="widget-heading"><?php echo ossn_print('wallet:addbalance');?></div>
	<div class="widget-contents text-center">
    	       <p><?php echo ossn_print('wallet:charge:balance:note');?></p>
               <?php
			   $methods = wallet_enabled_payment_methods();
			   if(is_array($methods) && in_array('paypal', $methods)){ 
			   ?>
	               <a href="<?php echo ossn_site_url('wallet/charge/paypal');?>" class="btn btn-outline-secondary btn-sm"><i class="fab fa-paypal"></i>PayPal</a>
               <?php } ?>
               <?php  
			   if(is_array($methods) && in_array('stripe', $methods)){  ?>
	               <a href="<?php echo ossn_site_url('wallet/charge/card');?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-credit-card"></i>Credit/Debit Card</a>
               <?php } ?>
               <?php  
			   if(is_array($methods) && in_array('iyzipay', $methods)){  ?>
	               <a href="<?php echo ossn_site_url('wallet/charge/iyzipay');?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-credit-card"></i><?php echo ossn_print('wallet:charge:iyzipay');?></a>
               <?php } ?>               
    </div>
</div>
<?php
$methods = wallet_enabled_payment_methods();
if(is_array($methods) && in_array('stripe', $methods)) {
$seamless = new \Wallet\Gateway\Stripe\Seamless($user);
?>
<div class="ossn-widget">
	<div class="widget-heading"><?php echo ossn_print('wallet:savepayment:method');?></div>
	<div class="widget-contents text-center">
    		<p><?php echo ossn_print('wallet:savepayment:method:note');?></p>
            <?php
			if(!isset($user->wallet_stripe_payment_card_details) || isset($user->wallet_stripe_payment_card_details) && empty($user->wallet_stripe_payment_card_details)){ ?>
            <a href="<?php echo ossn_site_url('wallet/seamless');?>" class="btn btn-outline-secondary btn-sm">
            	<i class="far fa-credit-card"></i> <?php echo ossn_print('wallet:addcard');?>
            </a>
            <?php 
			} else {
				$card = json_decode($user->wallet_stripe_payment_card_details);
			?>
            <?php if($seamless->hasFailedLimitReached()){ ?>
            <div class="alert alert-warning"><?php echo ossn_print('wallet:seamless:blocked', [$owner_email]);?></div>
            <?php } ?>
            <div class="wallet-seamless-card-item">
            	<i class="fab fa-cc-<?php echo $card->brand;?>"></i>
                <span class="last4">**** **** <?php echo $card->last4;?></span>
                <span class="exp">**/<?php echo $card->exp_year;?></span>
                <?php
				if(!$seamless->hasFailedLimitReached()){ ?>
                <a href="<?php echo ossn_site_url('action/wallet/charge/card/delete', true);?>" class="badge bg-danger float-end ossn-make-sure" data-ossn-msg="<?php echo ossn_print('wallet:makesure:delete:seamless');?>"><i class="fa fa-trash"></i></a>
                <?php } else { ?>
                <button disabled="disabled" class="badge bg-secondary float-end opacity-50"><i class="fa fa-trash"></i></button>                
                <?php } ?>
            </div>
            <?php } ?>
    </div>
</div>
<?php } ?>
<div class="ossn-widget">
	<div class="widget-heading"><?php echo ossn_print('wallet:history');?></div>
	<div class="widget-contents">
    		<div class="wallet-history">
            	<table class="table table-striped">
                	<tr>
                    	<th><?php echo ossn_print('wallet:date');?></th>
                    	<th><?php echo ossn_print('wallet:type');?></th>
                    	<th><?php echo ossn_print('wallet:description');?></th>
                    	<th><?php echo ossn_print('wallet:amount');?></th>
                    </tr>
				<?php
				$wallet = new \Wallet\Log;
				$history = $wallet->show(ossn_loggedin_user()->guid);
				$count   = $wallet->show(ossn_loggedin_user()->guid, array('count' => true));
				foreach($history as $item){
						$date = new DateTime();
						$date->setTimestamp($item->time_created);
						if($item->title == 'debit'){
								$amount = '<span class="wallet-debit">-'.number_format($item->amount, 2).'</span>';
						} else {
								$amount = '<span class="wallet-credit">+'.number_format($item->amount, 2).'</span>';
						}
						?>
                        <tr>
                        	<td><?php echo $date->format(DateTime::ATOM); ?></td>
                            <td><?php echo $item->title;?></td>
                            <td><?php echo $item->description;?></td>
                            <td> <?php echo WALLET_CURRENCY_CODE;?> <?php echo $amount;?></td>
                        </tr>
                        
                        <?php							
				}
				?>
                </table>
                <?php 
					echo ossn_view_pagination($count);
					?>
            </div>
    </div>
</div>