<?php
$guid   = input('guid');
$type   = input('alter_type');
$amount = input('amount');

$wallet = new Wallet\Wallet($guid);

switch($type) {
	case 'total':
		$wallet->setBalance($amount);
		break;
	case 'debit':
		try {
				$wallet->debit($amount, 'System');
		} catch (Exception $e) {
				ossn_trigger_message($e->getMessage(), 'error');
				redirect(REF);
		}
		break;
	case 'credit':
		try {
				$wallet->credit($amount, 'System');
		} catch (Exception $e) {
				ossn_trigger_message($e->getMessage(), 'error');
				redirect(REF);
		}
		break;
}
ossn_trigger_message(ossn_print('wallet:admin:settings:saved'));
redirect(REF);