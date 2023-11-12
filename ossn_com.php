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
define('__Wallet__', ossn_route()->com . 'Wallet/');
define('WALLET_CURRENCY_CODE', 'USD');
define('WALLET_MINIMUM_LOAD', 10);

ossn_register_class(array(
		'Wallet\Wallet'           => __Wallet__ . 'classes/Wallet.php',
		'Wallet\DebitException'   => __Wallet__ . 'classes/Exception/Debit.php',
		'Wallet\CreditException'  => __Wallet__ . 'classes/Exception/Credit.php',
		'Wallet\NoUserException'  => __Wallet__ . 'classes/Exception/NoUser.php',
		'Wallet\GatewayException' => __Wallet__ . 'classes/Exception/Gateway.php',
		'Wallet\Gateway\PayPal'   => __Wallet__ . 'classes/Gateway/PayPal.php',
		'Wallet\Gateway\Stripe'   => __Wallet__ . 'classes/Gateway/Stripe.php',
		'Wallet\Log'              => __Wallet__ . 'classes/Log.php',
));
/**
 * Wallet component initialize
 *
 * @return void
 */
function wallet_init() {
		ossn_extend_view('css/ossn.default', 'css/wallet/site');
		ossn_extend_view('js/ossn.site', 'js/wallet');
		
		ossn_new_js('wallet.card', 'wallet/card/js');
		
		if(ossn_isLoggedin()) {
				ossn_register_com_panel('Wallet', 'settings');
				
				ossn_register_page('wallet', 'wallet_page_handler');
				ossn_register_action('wallet/charge/paypal', __Wallet__ . 'actions/charge/paypal.php');
				
				ossn_register_action('wallet/charge/card', __Wallet__ . 'actions/charge/stripe/card.php');
				ossn_register_action('wallet/charge/card/verify', __Wallet__ . 'actions/charge/stripe/verify.php');

				ossn_register_sections_menu('newsfeed', array(
						'name'    => 'wallet',
						'text'    => ossn_print('wallet'),
						'url'     => ossn_site_url('wallet/overview'),
						'section' => 'links',
				));
		}
		if(ossn_isAdminLoggedin()) {
				ossn_register_action('wallet/admin/settings', __Wallet__ . 'actions/admin/settings.php');
				
				//change balance or add balance menu
				ossn_register_action('wallet/alter/balance', __Wallet__ . 'actions/alter.php');				
				ossn_register_callback('page', 'load:profile', 'wallet_user_profile_balance_change_menu');				
		}
		ossn_add_hook('services', 'methods', 'wallet_api_register');
		ossn_register_callback('user', 'delete', 'wallet_user_delete');
}
/**
 * Alter user balance menu
 *
 * @return void
 * @access private
 */
function wallet_user_profile_balance_change_menu($name, $type, $params) {
    $guid = ossn_get_page_owner_guid();
	//ossn_site_url("action/wallet/alter/balance?guid={$guid}", true)
	ossn_register_menu_item('profile_extramenu', array(
				'name' => 'wallet_balance_alter_profile',
				'text' => ossn_print('wallet:change:user:balance'),
				'href' => 'javascript:void(0)',
				'id'   => 'wallet-alter-balance',
				'data-guid' => $guid,
	));
}
/**
 * Wallet component register a API endpoints
 *
 * @return array
 */
function wallet_api_register($hook, $type, $methods, $params) {
		$methods['v1.0'][] = 'wallet/debit';
		$methods['v1.0'][] = 'wallet/credit';
		return $methods;
}
/**
 * Wallet page handler
 *
 * @return array
 */
function wallet_page_handler($pages) {
		if(empty($pages[0])) {
				ossn_error_page();
		}
		switch($pages[0]) {
			case 'overview':
				$title               = ossn_print('wallet:overview');
				$contents['content'] = ossn_plugin_view('wallet/overview');
				$content             = ossn_set_page_layout('newsfeed', $contents);
				echo ossn_view_page($title, $content);
				break;
			case 'alter':
				if(!ossn_isAdminLoggedin()){
						ossn_error_page();					
				}
				echo ossn_plugin_view('output/ossnbox', array(
							'title'    => ossn_print('wallet:change:user:balance'),
							'contents' => ossn_plugin_view('wallet/balance_alter'),
							'callback' => '#ossn-wallet-balance-alter-btn',
				));					
				break;
			case 'charge':
				$methods = wallet_enabled_payment_methods();
				switch($pages[1]) {
					case 'paypal':
						if(!in_array('paypal', $methods)){
								ossn_trigger_message(ossn_print('wallet:method:not:enabled'), 'error');
								redirect('wallet/overview');	
						}
						$title               = ossn_print('wallet:charge:paypal');
						$contents['content'] = ossn_plugin_view('wallet/charge/paypal');
						$content             = ossn_set_page_layout('newsfeed', $contents);
						echo ossn_view_page($title, $content);
						break;
					case 'card':
						if(!in_array('stripe', $methods)){
								ossn_trigger_message(ossn_print('wallet:method:not:enabled'), 'error');
								redirect('wallet/overview');	
						}					
						ossn_load_js('wallet.card');
						$title               = ossn_print('wallet:charge:card');
						$contents['content'] = ossn_plugin_view('wallet/charge/card');
						$content             = ossn_set_page_layout('newsfeed', $contents);
						echo ossn_view_page($title, $content);					
						break;
					case 'failed':
						$title               = ossn_print('wallet:charge:failed');
						$contents['content'] = ossn_plugin_view('wallet/charge/failed');
						$content             = ossn_set_page_layout('newsfeed', $contents);
						echo ossn_view_page($title, $content);
						break;
				default:
						ossn_error_page();
				}
				break;
		default:
				ossn_error_page();
		}
}
/**
 * Delete user wallet when user deleted
 *
 * @return void
 * @access private
 */
function wallet_user_delete($callback, $type, $params) {
		$guid = $params['entity']->guid;
		$logs = new Wallet\Log();
		$list = $logs->show($guid, array(
				'page_limit' => false,
		));
		if($list) {
				foreach($list as $log) {
						$log->deleteObject();
				}
		}
}
/** 
 * Wallet settings
 * 
 * @return boolean|object
 */
function wallet_get_settings(){
	$com      = new \OssnComponents();
	return $com->getSettings('Wallet');	
}
/**
 * Wallet enabled payment methods
 *
 * @return boolean|array
 */
function wallet_enabled_payment_methods(){
	$settings = wallet_get_settings();
	if($settings && isset($settings->payment_methods)){
			return json_decode($settings->payment_methods, true);
	}
	return false;
} 
ossn_register_callback('ossn', 'init', 'wallet_init');
