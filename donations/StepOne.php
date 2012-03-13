<?php
session_start();
require_once("classes/NMI-Three-Step-API.class.php");

nmiThreeStep::__getInstance(array(
						"userID" => null, //User
						"password" => null,
						"apiKey" => "657MvvHRPquyr44k7A8kE9Gu2N5x58ug", //API Key
						"gatewayURI" => "https://secure.nmi.com/api/v2/three-step", //Gateway URI
						"redirectURI" => "http://localhost/donations/StepThree.php", //Redirect URI
						"amount" => $_POST['amount'] //Sale Amount ... if NULL, it is assumed that this is a vault action
						));
?>

<?php
echo nmiThreeStep::__getInstance()->StepOne( 
	array(
		'transactionType' => array(
			'type' => 'sale'
		),
		'billing' => array(
			"first-name" => "first-name",
			"last-name" => "last-name",
			"address1" => "address1",
			"city" => "city",
			"state" => "state",
			"country" => "country",
			"postal" => "postal",
			"email" => "email",
			"phone" => "phone",
			"submit" => "STEP_ONE" //serves as a flag, removed from cURL POST
		),
		'shipping' => array(
			"shipping-id" => "shipping-id",
			"first-name" => "first-name",
			"last-name" => "last-name", 
			"address1" => "address1"
		)
	)
);
?>