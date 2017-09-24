<?php

session_start();

use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;

require 'config.php';
require 'db.php';


if(isset($_GET['type']))
{
	switch($_GET['type'])
	{
		case 'SHOP':
			global $con_web;

			$product_id = (int)$_GET['product_id'];

			$data = $con_web->prepare('SELECT * FROM shop WHERE product_id = :id');
			$data->execute(array(
				':id' => $product_id
			));

			$result = $data->fetchAll(PDO::FETCH_ASSOC);

			foreach($result as $row)
			{
				$product     = $row['product_name'];
				$description = $row['product_description'];
				$price       = $row['price'];
				$quantity    = $row['quantity'];
				$item_id     = $row['product_id'];
			}
		break;

		case 'SERVICE':
			if(isset($_GET['character']))
			{
				$character = ucfirst(strtolower($_GET['character']));
				$type      = strtolower($_GET['service']);

				if(empty($_GET['character']))
				{
					die('Character name cant be blank!');
				}

				if(!isset($_GET['character']))
				{
					die('Character name must be specified!');
				}

				if(ctype_alpha($character))
				{		
					switch($type)
					{
						case 'racechange':
							$product     = 'Race Change';
							$description = 'Northcraft Race Change Service';
							$price       = 10;
							$quantity    = 1;
							$item_id     = 1;
						break;

						case 'factionchange':
							$product     = 'Faction Change';
							$description = 'Northcraft Faction Change Service';
							$price       = 20;
							$quantity    = 1;
							$item_id     = 2;
						break;
					}
				}
				else
				{
					die('You cannot use numbers in the character input field!');
				}
			}
		break;

		case 'DONATE':
			if(isset($_GET['amount']))
			{
				if($_GET['amount'] < 1)
				{
					die('The amount cant be lower than 1 EUR!');
				}

				$donate_amount = (int)$_GET['amount'];

				$product     = 'Donation';
				$description = 'A generous donation to our project';
				$price       = $donate_amount;
				$quantity    = 1;
				$item_id     = 1;
			}
		break;
	}
	
	$total = $price;

	$payer = new Payer();
	$payer->setPaymentMethod('paypal');

	$item = new Item();
	$item->setName($product)
		->setCurrency(CURRENCY)
		->setQuantity($quantity)
		->setPrice($price);

	$itemList = new ItemList();
	$itemList->setItems([$item]);

	$details = new Details();
	$details->setSubtotal($total);

	$amount = new Amount();
	$amount->setCurrency(CURRENCY)
		->setTotal($total)
		->setDetails($details);

	$transaction = new Transaction();
	$transaction->setAmount($amount)
		->setItemList($itemList)
		->setDescription($description)
		->setInvoiceNumber(uniqid());

	$redirectUrls = new RedirectUrls();

	if($_GET['type'] == "SERVICE")
	{
		$redirectUrls->setReturnUrl(SITE_URL . '/pay.php?success=true&type=1&character=' . $character . '&amount=' . $price . '&item=' . $item_id)
			->setCancelUrl(SITE_URL . '/cancel.php?success=false&type=1&character=' . $character . '&amount=' . $price . '&item=' . $item_id);
	}
	elseif($_GET['type'] == "SHOP")
	{
		$redirectUrls->setReturnUrl(SITE_URL . '/pay.php?success=true&type=2&amount=' . $price . '&item=' . $item_id)
			->setCancelUrl(SITE_URL . '/cancel.php?success=false&type=2&amount=' . $price . '&item=' . $item_id);
	}
	elseif($_GET['type'] == "DONATE")
	{
		$redirectUrls->setReturnUrl(SITE_URL . '/pay.php?success=true&type=3&amount=' . $price . '&item=' . $item_id)
			->setCancelUrl(SITE_URL . '/cancel.php?success=false&type=3&amount=' . $price . '&item=' . $item_id);
	}

	$payment = new Payment();
	$payment->setIntent('sale')
		->setPayer($payer)
		->setRedirectUrls($redirectUrls)
		->setTransactions([$transaction]);

	try
	{
		$payment->create($paypal);
	}
	catch(Exception $e)
	{
	    die($e);
	}

	$approvalUrl = $payment->getApprovalLink();

	header('Location:' . $approvalUrl);
}
else
{
	header('Location: https://northcraft.org/');
}

?>