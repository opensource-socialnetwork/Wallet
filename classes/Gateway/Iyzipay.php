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
namespace Wallet\Gateway;
class Iyzipay {
		public function __construct() {
				require_once __Wallet__ . 'vendors/iyzipay/IyzipayBootstrap.php';
				$IyzipayBootstrap = new \IyzipayBootstrap();
				$IyzipayBootstrap->init();

				$com      = new \OssnComponents();
				$settings = $com->getSettings('Wallet');
				if(!isset($settings->iyzipay_key) || !isset($settings->iyzipay_secret_key) || !isset($settings->iyzipay_mode)) {
						throw new \Wallet\GatewayException('Invalid settings in administrator panel!');
				}
				$options = new \Iyzipay\Options();
				$options->setApiKey($settings->iyzipay_key);
				$options->setSecretKey($settings->iyzipay_secret_key);
				
				if($settings->iyzipay_mode == 'sandbox'){
					$options->setBaseUrl('https://sandbox-api.iyzipay.com');
				}
				if($settings->iyzipay_mode == 'production'){
					$options->setBaseUrl('https://api.iyzipay.com');
				}
				$this->_iyzipayOptions = $options;
		}
		public function checkForm($amount, $identityNumber, $address, $city, $country, $zip) {
				if(empty($amount) || empty($address) || empty($identityNumber) || empty($city) || empty($country) || empty($zip)) {
						return false;
				}
				if($amount < WALLET_MINIMUM_LOAD){
						return false;	
				}
				$user = ossn_loggedin_user();
				$lang = 'en';
				if($user->language == 'tr') {
						$lang = 'tr';
				}
				if($user->language == 'en') {
						$lang = 'en';
				}
				$request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
				$request->setLocale('tr');
				$request->setPrice($amount);
				$request->setPaidPrice($amount);
				$request->setCurrency(WALLET_CURRENCY_CODE);
				$request->setBasketId("WALLET-{$user->email}");
				$request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
				$request->setCallbackUrl(ossn_site_url('components/Wallet/vendors/iyzipay/redirect.php'));

				$buyer = new \Iyzipay\Model\Buyer();
				$buyer->setId($user->guid);
				$buyer->setName($user->first_name);
				$buyer->setSurname($user->last_name);
				$buyer->setEmail($user->email);
				$buyer->setIdentityNumber($identityNumber);
				$buyer->setRegistrationAddress($address);
				$buyer->setCity($city);
				$buyer->setCountry($country);
				$buyer->setZipCode($zip);

				$Address = new \Iyzipay\Model\Address();
				$Address->setContactName($user->fullname);
				$Address->setCity($city);
				$Address->setCountry($country);
				$Address->setAddress($address);
				$Address->setZipCode($zip);

				$Item = new \Iyzipay\Model\BasketItem();
				$Item->setId("WALLET-{$user->email}");
				$Item->setName('Wallet');
				$Item->setCategory1('Wallet');
				$Item->setCategory2('Reload');
				$Item->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);
				$Item->setPrice($amount);

				$request->setBasketItems(array(
						$Item,
				));
				$request->setShippingAddress($Address);
				$request->setBillingAddress($Address);
				$request->setBuyer($buyer);
				$request->setEnabledInstallments(array(
						1,
				));

				$checkoutFormInitialize       = \Iyzipay\Model\CheckoutFormInitialize::create($request, $this->_iyzipayOptions);
				$this->checkoutFormInitialize = $checkoutFormInitialize;
				return $checkoutFormInitialize->getcheckoutFormContent();
		}
		public function callback($token) {
				$request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
				$user    = ossn_loggedin_user();
				$lang    = 'en';
				if($user->language == 'tr') {
						$lang = 'tr';
				}
				if($user->language == 'en') {
						$lang = 'en';
				}

				$request->setLocale($lang);
				$request->setToken($token);
				return \Iyzipay\Model\CheckoutForm::retrieve($request, $this->_iyzipayOptions);
		}
}