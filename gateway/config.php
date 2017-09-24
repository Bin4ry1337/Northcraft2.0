<?php

require __DIR__ . '/autoload.php';

//define('SITE_URL', 'https://northcraft.org/gateway');
define('SITE_URL', 'http://localhost/projects/Northcraft-2.0/gateway');
define('CURRENCY', 'EUR');

$paypal = new \PayPal\Rest\ApiContext(
	new \PayPal\Auth\OAuthTokenCredential(
		'AfreVnx1UmbQmXXIL6ImM-slOfY8EgunuNL02wR4ypJCVYzX876v5k_8KwhsaaAYvw8a43yPc8Xh8pdy',
		'EJuJ8Lxn0uplTan453F1z4wCzOVrqUnGH94Awhk-8t7fdqpYHu-TDL1AZlwGYnIAYTezGAVTGF4GEOKV'
	)
);

$paypal->setConfig(
    array(
       'mode' => 'sandbox'
    )
);

?>