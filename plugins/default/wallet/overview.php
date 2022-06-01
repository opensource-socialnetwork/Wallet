<?php
$DateTime = new DateTime('NOW');
$wallet   = new \Wallet\Wallet(ossn_loggedin_user()->guid);
$settings = wallet_get_settings();
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
			   if(in_array('paypal', $methods)){ 
			   ?>
	               <a href="<?php echo ossn_site_url('wallet/charge/paypal');?>" class="btn btn-outline-secondary btn-sm"><i class="fab fa-paypal"></i>PayPal</a>
               <?php } ?>
               <?php  if(in_array('stripe', $methods)){  ?>
	               <a href="<?php echo ossn_site_url('wallet/charge/card');?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-credit-card"></i>Credit/Debit Card</a>
               <?php } ?>
    </div>
</div>
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