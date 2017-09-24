<?php

date_default_timezone_set('Europe/Oslo');

$config = array(
	'HOST_WEB'    => 'localhost',
	'USER_WEB'    => 'root',
	'PASS_WEB'    => '',
	'DB_WEB'      => 'northcraft_web',

	'HOST_REALMD'  => 'localhost',
	'USER_REALMD'  => 'root',
	'PASS_REALMD'  => '',
	'DB_REALMD'    => 'ptr_realmd',

	'HOST_CHARS'  => 'localhost',
	'USER_CHARS'  => 'root',
	'PASS_CHARS'  => '',
	'DB_CHARS'    => 'ptr_character',

	'CHARSET'     => 'UTF8'
);

try
{
	$con_web = new PDO('mysql:host=' . $config['HOST_WEB'] . ';dbname=' . $config['DB_WEB'] . ';charset=' . $config['CHARSET'], $config['USER_WEB'], $config['PASS_WEB']);
}
catch(PDOException $e)
{
	die($e->getMessage());
}

try
{
	$con_realmd = new PDO('mysql:host=' . $config['HOST_REALMD'] . ';dbname=' . $config['DB_REALMD'] . ';charset=' . $config['CHARSET'], $config['USER_REALMD'], $config['PASS_REALMD']);
}
catch(PDOException $e)
{
	die($e->getMessage());
}

try
{
	$con_characters = new PDO('mysql:host=' . $config['HOST_CHARS'] . ';dbname=' . $config['DB_CHARS'] . ';charset=' . $config['CHARSET'], $config['USER_CHARS'], $config['PASS_CHARS']);
}
catch(PDOException $e)
{
	die($e->getMessage());
}

?>