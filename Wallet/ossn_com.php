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
		'Wallet\Log'              => __Wallet__ . 'classes/Log.php',
));
/**
 * Wallet component initialize
 *
 * @return void
 */
function wallet_init() {
		ossn_extend_view('css/ossn.default', 'css/wallet/site');
		#ossn_extend_view('js/ossn.site', 'js/wallet/site');
		if(ossn_isLoggedin()) {
				ossn_register_com_panel('Wallet', 'settings');

				ossn_register_page('wallet', 'wallet_page_handler');
				ossn_register_action('wallet/charge/paypal', __Wallet__ . 'actions/charge/paypal.php');

				ossn_register_sections_menu('newsfeed', array(
						'name'    => 'wallet',
						'text'    => ossn_print('wallet'),
						'url'     => ossn_site_url('wallet/overview'),
						'section' => 'links',
				));
		}
		if(ossn_isAdminLoggedin()) {
				ossn_register_action('wallet/admin/settings', __Wallet__ . 'actions/admin/settings.php');
		}
		ossn_add_hook('services', 'methods', 'wallet_api_register');
		ossn_register_callback('user', 'delete', 'wallet_user_delete');
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
			case 'charge':
				switch($pages[1]) {
					case 'paypal':
						$title               = ossn_print('wallet:charge:paypal');
						$contents['content'] = ossn_plugin_view('wallet/charge/paypal');
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
ossn_register_callback('ossn', 'init', 'wallet_init');
