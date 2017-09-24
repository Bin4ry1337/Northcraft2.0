<?php



function BackupData($host, $user, $pass, $db)
{
	try
	{
		$con = new PDO('mysql:host=' . $host . ';dbname=' . $db . ';charset=UTF8', $user, $pass);
	}
	catch(PDOException $e)
	{
		die($e->getMessage());
	}


	if(isset($con))
	{
		$saved_data = '';
		$backup_folder = 'backups/server/';

		$data = $con->prepare('SELECT * INTO OUTFILE :file FROM :table');
		$data->execute(array(
			':file'  => $backup_folder . 'backup-' . time(),
			':table' => 'account'
		));

		echo 'Saved!';
	}
}

BackupData('localhost', 'root', '', 'data');




?>