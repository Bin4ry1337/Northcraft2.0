<?php

session_start();

include('db.php');

if(!isset($_GET['success']))
{
	die();
}

if((bool)$_GET['success'] === false)
{
	if(isset($_SESSION['username']))
	{
		$username = $_SESSION['username'];
	}
	else
	{
		$username = 'Unknown';
	}

	$character = $_GET['character'];
	$amount    = $_GET['amount'];
	$item_id   = $_GET['item'];
	$paymentId = $_GET['paymentId'];
	$token     = $_GET['token'];
	$payerId   = $_GET['PayerID'];
	$time      = time();

	global $con_web;

	$data = $con_web->prepare('INSERT INTO transactions (transaction_id, amount, currency_type, token, payerid, username, character_name, item_id, approved, time) VALUES(:transaction_id, :amount, :currency, :token, :payerid, :username, :character_name, :item_id, :approved, :time)');
	$data->execute(array(
		':transaction_id' => $paymentId,
		':amount'         => $amount,
		':currency'       => CURRENCY,
		':token'          => $token,
		':payerid'        => $payerId,
		':username'       => $username,
		':character_name' => $character,
		':item_id'        => $item_id,
		':approved'       => 0,
		':time'           => $time
	)) or die(print_r($data->errorInfo(), true));

	header('Location: https://northcraft.org/');
}
else
{
	header('Location: https://northcraft.org/');
}

?>