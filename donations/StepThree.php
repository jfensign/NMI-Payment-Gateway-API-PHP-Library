<?php
require_once("classes/NMI-Three-Step-API.class.php");
$three_step = nmiThreeStep::__getInstance()->StepThree();
?>


<?php 

	if(isset($_SESSION['StepThree-result'])) {
		if(intval($_SESSION['StepThree-result']) === 1) {
			include_once("html/SuccessView.php");
		} else {
			header("Location: " . $_SERVER["HTTP_REFERER"]);
			echo $_SERVER["StepThree-result-text"];
		}
	}
	
	
?>