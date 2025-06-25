<?php
$blocked = wallet_get_seamless_blocked_users();
$count = wallet_get_seamless_blocked_users(true);
?>
<div class="alert alert-info"><?php echo ossn_print('walet:delete:seamless:note:block');?></div>
<table class="table">
<?php
if($blocked){
	foreach($blocked as $user){ ?>
  <tr>
    <td><div class="d-flex"><img src="<?php echo $user->iconURL()->smaller;?>" /><a class="ms-1 mt-1 fw-bold"target="_blank" href="<?php echo $user->profileURL();?>"><?php echo $user->fullname;?></a></div></td>
    <td>
    <?php
	if(isset($user->wallet_stripe_payment_card_details)){
		$card = json_decode($user->wallet_stripe_payment_card_details);		   
	?>
     <div class="wallet-seamless-card-item">
            	<i class="fab fa-cc-<?php echo $card->brand;?>"></i>
                <span class="last4">**** **** <?php echo $card->last4;?></span>
                <span class="exp">**/<?php echo $card->exp_year;?></span>
      </div>
    <?php } ?>
    </td>
    <td><a href="<?php echo ossn_site_url("action/wallet/admin/seamless/remove/block?guid={$user->guid}", true);?>" class="badge bg-danger"><i class="fa fa-trash"></i><?php echo ossn_print('delete');?></a></td>
  </tr>
<?php
	}
}
?>
</table>
<?php 
echo ossn_view_pagination($count);