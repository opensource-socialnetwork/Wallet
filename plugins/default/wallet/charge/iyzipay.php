<?php
/**
 * Open Source Social Network
 *
 * @package   Wallet
 * @author    OSSN Core Team <info@openteknik.com>
 * @copyright (c) Engr. Syed Arsalan Hussain Shah (OpenTeknik LLC)
 * @license   OpenTeknik LLC, COMMERCIAL LICENSE  https://www.openteknik.com/license/commercial-license-v1
 * @link      https://www.openteknik.com/
 */
?>
<div class="ossn-page-contents">
<?php

$iyzipay_from = input('iyzipay_from');
if($iyzipay_from && $iyzipay_from == 'yes'){
	
	$iyzipay = new Wallet\Gateway\Iyzipay();
	$amount  = input('amount');
	$address = input('address');
	$city    = input('city');
	$country = input('country');
	$zip     = input('zip');
	$identityNumber = input("identity_number");
	echo $iyzipay->checkForm($amount, $identityNumber, $address, $city, $country, $zip);
	if(isset($iyzipay->checkoutFormInitialize) && $iyzipay->checkoutFormInitialize->getStatus() == 'success'){
			?>
            <p><?php echo ossn_print('wallet:iyzipay:loading');?></p>
            <div class="ossn-loading"></div>
            <?php
	}
	if(!isset($iyzipay->checkoutFormInitialize)){
		redirect(REF);	
	}
} else {
	echo ossn_view_form('wallet/charge/iyzipay', array(
   	 	'action' => ossn_site_url("wallet/charge/iyzipay"),
   		 'class' => 'ossn-iyzipay-form'	
	));	
}
?>
</div>