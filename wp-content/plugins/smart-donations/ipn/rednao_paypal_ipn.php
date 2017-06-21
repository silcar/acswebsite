<?php

include_once('../../../../wp-config.php');
require_once('wordpress_connection_provide.php');
require_once('smart_donations_db_privider.php');
require_once('rednao_paypal_provider.php');
require_once('rednao_provider_processor.php');
global $rednaolog;
$ipn = new rednao_provider_processor(new rednao_paypal_provider());



try {
	$ipn->ProcessCall();
} catch (Exception $e) {
	$rednaolog .= $e->getMessage();
	$ipn->SendLogIfNeeded();
}







