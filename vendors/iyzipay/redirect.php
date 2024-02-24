<?php
$token = $_POST['token'];
if(empty($token)){
	echo "Error!";
	exit;
}
global $Ossn;
$Ossn = new stdClass();

require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/configurations/ossn.config.site.php');

header("Location: {$Ossn->url}/wallet/iyzipay_callback?token={$token}");
exit();