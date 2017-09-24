<?php

//Load the settings file
include('inc/settings.php');

date_default_timezone_set('Europe/Oslo');

//Start the database connection
try
{
	$con = new PDO('mysql:host=' . $DBConfig['HOST'] . ';dbname=' . $DBConfig['DB'] . ';charset=UTF8', $DBConfig['USER'], $DBConfig['PASS']);

	if($DBConfig['DEBUG_MODE'] == true)
	{
		$con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	}
}
catch(PDOException $e)
{
	die($e->getMessage());
}

try
{
	$con_realmd = new PDO('mysql:host=' . $DBConfig['REALMD_HOST'] . ';dbname=' . $DBConfig['REALMD_DB'] . ';charset=UTF8', $DBConfig['REALMD_USER'], $DBConfig['REALMD_PASS']);

	if($DBConfig['DEBUG_MODE'] == true)
	{
		$con_realmd->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	}
}
catch(PDOException $e)
{
	die($e->getMessage());
}

try
{
	$con_char = new PDO('mysql:host=' . $DBConfig['CHAR_HOST'] . ';dbname=' . $DBConfig['CHAR_DB'] . ';charset=UTF8', $DBConfig['CHAR_USER'], $DBConfig['CHAR_PASS']);

	if($DBConfig['DEBUG_MODE'] == true)
	{
		$con_char->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	}
}
catch(PDOException $e)
{
	die($e->getMessage());
}

try
{
	$con_world = new PDO('mysql:host=' . $DBConfig['WORLD_HOST'] . ';dbname=' . $DBConfig['WORLD_DB'] . ';charset=UTF8', $DBConfig['WORLD_USER'], $DBConfig['WORLD_PASS']);

	if($DBConfig['DEBUG_MODE'] == true)
	{
		$con_world->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	}
}
catch(PDOException $e)
{
	die($e->getMessage());
}

?>