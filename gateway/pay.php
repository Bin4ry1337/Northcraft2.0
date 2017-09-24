<?php

session_start();

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

include('db.php');

require 'config.php';

if(!isset($_GET['success']))
{
	die();
}

if((bool)$_GET['success'] === false)
{
	die();
}

if(isset($_SESSION['username']))
{
	$username = $_SESSION['username'];
}
else
{
	$username = 'Unknown';
}

if(isset($_GET['character']))
{
	$character = $_GET['character'];
}

$type      = (int)$_GET['type'];
$amount    = (int)$_GET['amount'];
$item_id   = $_GET['item'];
$paymentId = $_GET['paymentId'];
$token     = $_GET['token'];
$payerId   = $_GET['PayerID'];
$time      = time();

$payment = Payment::get($paymentId, $paypal);

$execute = new PaymentExecution();
$execute->setPayerId($payerId);

try
{
	$result = $payment->execute($execute, $paypal);

	global $con_web;
	global $con_realmd;
	global $con_characters;

	function GrabReward($id)
	{
		global $con_web;

		$data = $con_web->prepare('SELECT * FROM shop WHERE product_id = :id');
		$data->execute(array(
			':id' => $id
		));

		$result = $data->fetchAll(PDO::FETCH_ASSOC);

		foreach($result as $row)
		{
			return $row['entry'];
		}
	}

	if($type == '1') // Race and Faction Change
	{
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
			':approved'       => 1,
			':time'           => $time
		)) or die(print_r($data->errorInfo(), true));

		switch ($item_id)
		{
			case 1:
				$data = $con_characters->prepare('UPDATE characters SET at_login = :data WHERE name = :name');
				$data->execute(array(
					':data' => 128, // Race Change Flag
					':name' => ucfirst(strtolower($character))
				));
			break;

			case 2:
				$data = $con_characters->prepare('UPDATE characters SET at_login = :data WHERE name = :name');
				$data->execute(array(
					':data' => 64, // Faction Change Flag
					':name' => ucfirst(strtolower($character))
				));
			break;
		}

		header('Location: success.php?id=1');
	}
	elseif($type == '2') // Vanity Shop
	{
		function GrabEmail($username)
		{
			global $con_realmd;

			$data = $con_realmd->prepare('SELECT * FROM account WHERE username = :username');
			$data->execute(array(
				':username' => $username
			));

			$result = $data->fetchAll(PDO::FETCH_ASSOC);

			foreach($result as $row)
			{
				return $row['email'];
			}
		}

		$data = $con_web->prepare('INSERT INTO transactions (transaction_id, amount, currency_type, token, payerid, username, character_name, item_id, approved, time) VALUES(:transaction_id, :amount, :currency, :token, :payerid, :username, :character_name, :item_id, :approved, :time)');
		$data->execute(array(
			':transaction_id' => $paymentId,
			':amount'         => $amount,
			':currency'       => CURRENCY,
			':token'          => $token,
			':payerid'        => $payerId,
			':username'       => $username,
			':character_name' => 'SHOP_ITEM',
			':item_id'        => $item_id,
			':approved'       => 1,
			':time'           => $time
		)) or die(print_r($data->errorInfo(), true));

		$code   = substr(str_shuffle('1234567890ABCDEFabcdef-'), 0, 30);

		$data = $con_web->prepare('INSERT INTO reward_system (code, reward, redeemed_on, username, ip_used, time_used, active) VALUES(:code, :reward, "", :username, "", 0, 1)');
		$data->execute(array(
			':code'     => $code,
			':reward'   => GrabReward($item_id),
			':username' => $username
		));

		$headers  = "From: support@northcraft.org\r\n";
		$headers .= "Reply-To: support@northcraft.org\r\n";
		$headers .= "CC: support@northcraft.org\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";

		mail(GrabEmail($username), 'Northcraft Payment', 'Hello ' . $username . ', <br><br>Thank you for your purchase!<br><br> Here is your redeem code: ' . $code . '<br><br>You can redeem it in your UserCP.<br><br>Northcraft STAFF', $headers); // Change to PHPMailer Later
		
		header('Location: success.php?id=2&code=' . $code);
	}
	elseif($type == '3') // Donation
	{
		$data = $con_web->prepare('INSERT INTO transactions (transaction_id, amount, currency_type, token, payerid, username, character_name, item_id, approved, time) VALUES(:transaction_id, :amount, :currency, :token, :payerid, :username, :character_name, :item_id, :approved, :time)');
		$data->execute(array(
			':transaction_id' => $paymentId,
			':amount'         => $amount,
			':currency'       => CURRENCY,
			':token'          => $token,
			':payerid'        => $payerId,
			':username'       => $username,
			':character_name' => 'DONATION',
			':item_id'        => $item_id,
			':approved'       => 1,
			':time'           => $time
		)) or die(print_r($data->errorInfo(), true));

		header('Location: success.php?id=3');
	}
}
catch(Exception $e)
{
	die('Something went wrong, please contact staff!');
}





?>