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
$guid        = input('guid');
$amount      = input('amount');
$description = input('description');
if(empty($description)){
	$params['OssnServices']->throwError('200', 'Empty Description');
}
try {
		$wallet = new \Wallet\Wallet($guid);
		if($wallet->credit($amount, $description)) {
				$params['OssnServices']->successResponse(array(
						'status' => 'success',
						'amount' => $amount,
						'guid'   => $guid,
				));
		}
} catch (Wallet\NoUserException $e) {
		$params['OssnServices']->throwError('103', $e->getMessage());
}