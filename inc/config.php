<?php

include('inc/settings.php');

date_default_timezone_set('Europe/Oslo');

try
{
	$con_web = new PDO('mysql:host=' . $config['HOST_WEB'] . ';dbname=' . $config['DB_WEB'] . ';charset=' . $config['CHARSET'], $config['USER_WEB'], $config['PASS_WEB']);
}
catch(PDOException $e)
{
	//die($e->getMessage());
}

try
{
	$con_realmd = new PDO('mysql:host=' . $config['HOST_REALMD'] . ';dbname=' . $config['DB_REALMD'] . ';charset=' . $config['CHARSET'], $config['USER_REALMD'], $config['PASS_REALMD']);
}
catch(PDOException $e)
{
	//die($e->getMessage());
}

try
{
	$con_characters = new PDO('mysql:host=' . $config['HOST_CHARS'] . ';dbname=' . $config['DB_CHARS'] . ';charset=' . $config['CHARSET'], $config['USER_CHARS'], $config['PASS_CHARS']);
}
catch(PDOException $e)
{
	//die($e->getMessage());
}

try
{
	$con_world = new PDO('mysql:host=' . $config['HOST_WORLD'] . ';dbname=' . $config['DB_WORLD'] . ';charset=' . $config['CHARSET'], $config['USER_WORLD'], $config['PASS_WORLD']);
}
catch(PDOException $e)
{
	//die($e->getMessage());
}

?>