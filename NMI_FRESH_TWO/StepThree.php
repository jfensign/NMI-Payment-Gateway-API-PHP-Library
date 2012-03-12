<?php
session_start();
require_once("classes/NMI-Three-Step-API.class.php");
$three_step = unserialize($_SESSION["THREE_STEP"]);

$three_step->StepThree(
		array(
			"StepThreeResponseXML" => "StepThreeResponse.xml"
		)
	);
?>