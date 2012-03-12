<?php
session_start();
require_once("classes/NMI-Three-Step-API.class.php");
if(empty($_SESSION["THREE_STEP"])):
$three_step = nmiThreeStep::__getInstance(array(
									"user" => null, //User
									"key" => "657MvvHRPquyr44k7A8kE9Gu2N5x58ug", //API Key
									"gwURI" => "https://secure.nmi.com/api/v2/three-step", //Gateway URI
									"redirectURI" => "http://localhost/nmi/NMI_FRESH/NMI_FRESH_TWO/checkout.php", //Redirect URI
									"checkoutURI" => "http://localhost/nmi/NMI_FRESH/NMI_FRESH_TWO/checkout.php",
									"sessionIndex" => "THREE_STEP",
									"amount" => 91.06 //Sale Amount ... if NULL, it is assumed that this is a vault action
								));						
$_SESSION['THREE_STEP'] = serialize($three_step);
endif;
?>

<?php
if(!empty($_POST['firstname'])):
$three_step = unserialize($_SESSION["THREE_STEP"]);
$three_step->StepOne( 
	array(
		'persistenceMedium' => array(
					"type" => "file",
					"StepOneResponseXML" => "StepOneResponse.xml",
					"StepOneFormVals" => "StepOneFormVals.xml",
					"StepOneFormFile" => null
		),
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
endif;
?>