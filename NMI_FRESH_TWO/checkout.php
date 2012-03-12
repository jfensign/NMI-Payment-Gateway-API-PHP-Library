<?php		
session_start();
require_once("classes/NMI-Three-Step-API.class.php");
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








/*
$three_step->StepOne( 
	array(
		'persistenceMedium' => array(
					"type" => "file",
					"StepOneResponseXML" => "StepOneResponse.xml",
					"StepOneFormVals" => "StepOneFormVals.xml",
					"StepOneFormFile" => "html/shipping_billing_info.php"
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
*/
?>

<?php

$three_step->StepTwo(
		array(
			'persistenceMedium' => array(
					"type" => "file",
					"StepTwoFormFile" => null,
					'form_url' => $three_step->__get("form-url")
					)
		)	
);


/*
$three_step->StepTwo(
		array(
			'persistenceMedium' => array(
					"type" => "file",
					"StepTwoFormFile" => "html/CC_payment_info.php",
					'form_url' => $three_step->__get("form-url")
					)
		)	
   );
   
*/
?>

<?php 

$three_step->StepThree(
		array(
			"StepThreeResponseXML" => "StepThreeResponse.xml"
		)
	);
?>