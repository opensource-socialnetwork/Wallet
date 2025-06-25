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
ossn_register_languages('en', array(
		'wallet'                              => 'Wallet',
		'wallet:overview'                     => 'Wallet Overview',
		'wallet:current:balance'              => 'Current Balance',
		'wallet:history'                      => 'History',
		'wallet:date'                         => 'Date',
		'wallet:amount'                       => 'Amount',
		'wallet:type'                         => 'Type',
		'wallet:description'                  => 'Description',
		'wallet:addbalance'                   => 'Charge Balance',
		'wallet:charge:paypal'                => 'Charge Your Wallet using PayPal',
		'wallet:charge:balance:note'          => 'You can charge balance into your wallet. You can use one of the below method.',
		'wallet:charge:amount:paypal'         => 'Enter Amount (Minumum %s %s)',
		'wallet:charge:failed'                => 'Wallet Charge Failed',
		'wallet:charge:failed:note'           => 'Wallet can not be charged right now. This can be due to many reasons, you may contact customer support for more details.',
		'wallet:charge:paypal:success'        => 'Wallet has been charged successfully!',
		'wallet:charge:paypal:failed'         => 'Charge has been failed',
		'wallet:paynow'                       => 'Pay Now',
		'wallet:admin:paypal'                 => 'PayPal',
		'wallet:admin:paypal:client:id'       => 'Client ID',
		'wallet:admin:paypal:client:secret'   => 'Client Secret',
		'wallet:admin:settings:saved'         => 'Settings has been saved',
		'wallet:admin:settings:save:error'    => 'Settings can not be saved right now!',
		'wallet:charge:min'                   => 'Your amount is less then the minimum amount required for load!',

		'wallet:admin:stripe'                 => 'Stripe',
		'wallet:admin:stripe:publishable:key' => 'Publishable Key',
		'wallet:admin:stripe:secret:key'      => 'Secret Key',
		'wallet:admin:payment:methods'        => 'Payment Methods',
		'wallet:charge:card'                  => 'Charge via Card',
		'wallet:card:holder'                  => 'Card Holder',
		'wallet:card:number'                  => 'Card Number',
		'wallet:card:process'                 => 'The card is being processed please wait.....',
		'wallet:notconfigured:note'           => 'Wallet services are not configured please report this to website admin!',
		'wallet:method:not:enabled'           => 'Method not enabled!',

		'wallet:change:user:balance'          => 'Change Balance',
		'wallet:alter:type'                   => 'Change Type',
		'wallet:alter:type:entier'            => 'Entire/Total Balance Change',
		'wallet:alter:type:debit'             => 'Debit (Deduct)',
		'wallet:alter:type:credit'            => 'Credit (Add)',
		'wallet:alter:amount'                 => 'Amount',

		'wallet:charge:iyzipay'               => 'Iyzipay',
		'wallet:admin:iyzipay'                => 'Iyzipay (Iyzico)',
		'wallet:admin:iyzipay:key'            => 'API Key',
		'wallet:admin:iyzipay:secret:key'     => 'Secret Key',
		'wallet:admin:iyzipay:mode'           => 'Use Mode',
		'wallet:iyzipay:city'                 => 'City',
		'wallet:iyzipay:address'              => 'Address',
		'wallet:iyzipay:country'              => 'Country',
		'wallet:iyzipay:zipcode'              => 'Zip Code',
		'wallet:iyzipay:identity' 			  => 'Identity Number',
		'wallet:iyzipay:loading'              => 'Loading...Please wait!',
		
		'wallet:savepayment:method'			  => 'Securely Save Your Card for Seamless Payments',
		'wallet:savepayment:method:note' 	  => 'By securely saving your card details, you enable our system to automatically process payments when due. This ensures uninterrupted access to our services without the hassle of manual transactions. Rest assured, your information is encrypted and protected with industry-standard security measures.',
		'wallet:addcard'					  => 'Add Credit/Debit Card',
		'wallet:seamnless:charge:head'		  => 'Verification Charge Notice!',
		'wallet:saveseamless:testcharge:note' => "As part of our security measures, a one-time charge of %s %s will be applied to verify your new payment method. This amount will be credited to your wallet and can be used for future purchases. This is a one-time verification step required for any new payment method you add to your account. It helps us ensure the card is valid and authorized for transactions. No additional fees will be charged, and your payment details are securely handled using industry-standard encryption.",
		'wallet:seamlesscharge:credit' 	      => 'Wallet Verification Charge Credit!',
		'wallet:charge:failed:seamless:head'  => 'We were unable to set up your card for seamless or automatic payments.',
		'wallet:charge:failed:seamless:note'  => "Unfortunately, the process could not be completed at this time. This may be due to a number of reasons, including card restrictions or limitations set by your bank. Some cards do not support seamless or recurring payment features, which can prevent successful setup. We recommend contacting your card issuer for more information, or trying a different card to ensure uninterrupted service.",
		'wallet:makesure:delete:seamless' 	  => 'Are you sure want to delete this card?',
		'wallet:paymentmethod:remove:failed' =>  'Unable to remove the card, please try again later or contact customer support!',
		'wallet:paymentmethod:removed'       => 'Card has been removed!',
		'wallet:seamless:blocked'			 => 'Your payment method has been temporarily blocked due to multiple failed attempts. For security reasons, it cannot be deleted at this time. To update or replace this payment method, please contact the administrator at %s  If the issue has been resolved, you may re-add the same payment method. You can still manually upload funds to your account to cover future payments.',
		'wallet:admin:overview' 			=> 'Overview',
		'wallet:admin:gateways'				=> 'Gateways',
		'wallet:admin:blocked' 				=> 'Blocked Users',
		'walet:delete:seamless:note:block' => "If a user's card is blocked after three consecutive failed attempts for seamless payments, they won't be able to add or remove any cards. Only admins can delete a blocked card. Once it's deleted, the user will be able to add a new card or re-add the same one to resume payments smoothly.",
		'wallet:tran:status:success' => 'Success',
		'wallet:tran:status:failed' => 'Failed',
		'wallet:tran:notification:debit' => 'Wallet Debit Transaction - %s',
		'wallet:tran:notification:credit' => 'Wallet Credit Transaction - %s',
'wallet:tran:debit:notification:body' => "Dear Member,

A transaction has been made on your wallet:

Type: %s
Status: %s
Amount: %s
Description: %s

Thank you,
Please do not reply to this email."
));