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

 echo ossn_plugin_view('wallet/adminnav');
 $page = input('page', '', 'gateways');
 switch($page){
	case 'overview':
	
		break;
	case 'gateways':
		echo ossn_view_form('wallet/admin/settings', array(
    			'action' => ossn_site_url() . 'action/wallet/admin/settings',
    			'class' => 'ossn-admin-form'	
		));	
		break;
	case 'tax':
		echo ossn_view_form('wallet/admin/tax', array(
    			'action' => ossn_site_url() . 'action/wallet/admin/settings/tax',
    			'class' => 'ossn-admin-form'	
		));	
		break;		
	case 'blocked':
		echo ossn_view_form('wallet/admin/blocked', array(
    			'action' => 'javacript:void(0);',
    			'class' => 'ossn-admin-form'	
		));		
		break;
 }