<html>
<head>
<title>NMI Three-Step API Example</title>
<script type="text/javascript" src="assets/js/jquery.js"></script>

<style type="text/css">


h4 {
	width: 380px;
	font: 16px Helvetica, Arial, freesans, clean, sans-serif;
	color: whiteSmoke;
	border-radius: 5px;
	padding: 3px;
	background-color: #69D344;
	background-image: -moz-linear-gradient(#69D344,#4C8B36);
	background-image: -webkit-linear-gradient(#69D344,#4C8B36);
	-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#69d344',endColorstr='#4c8b36',GradientType=0)";
	border-color: #4A993E;
	color: white;
	font-weight: 700;
}

#thankYouPar {
	font: 16px Arial, helvetica, sans-serif;
	color: #222;
	text-align: center;
	margin-left: auto;
	margin-right: auto;
	padding: 5px;
	width: 325px;
	
}

#postTransactionOptionsNav {
	margin-top: 100px;
	width: 350px;
	display: block;
	float: none;
	
}

.receipt_container {
	list-style: decimal;
	width: 300px;
}

.receipt_container > li {
	max-width: 235px;
	min-height: 20px;
	float:
	padding: 0;
	margin: 0;
	float: left;
	display: block;
}

.receiptPar {
	font: 12px Helvetica, Arial, freeserif, clean, sans-serif;
	font-weight: bold;
	padding: 0;
	margin: 0;
	color: #222;
	text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
	border-bottom: 1px dotted #CCC;
}

</style>
<?php 

	$receiptArray = array(
							"ip-address",
							"action-type",
							"first-name",
							"last-name",
							"amount",
							"currency",
							"cc-number",
							"cc-exp",
							"transaction-id",
					);

?>


<?php
require_once("core/NMI-Three-Step-API.class.php");
session_start();
$three_step = nmiThreeStep::__getInstance()->StepThree();
$three_step = json_decode($three_step);
?>

</head>
<body>
<?php if($three_step->result > 1):?>

	<?php $_SESSION["gatewayErrorText"] = $three_step->{"result-text"};?>
	<?php header("Location: " . $_SERVER['HTTP_REFERER']);?>
	
<?php else:?>
	<div class="gatewayResponseSuccessDiv" id="paymentSuccessDiv" style="text-align: center;">
	<h4><?php echo $three_step->{"result-text"};?></h4>
	<p class="receiptPar">Thanks <?php echo isset($three_step->{"first-name"}) ? $three_step->{"first-name"} : $three_step->{"ip-address"};?>! Below is your receipt.</p>
	<?php foreach($receiptArray as $key):?>
	  
		<div style= "height: 20px; width: 325px; border: 1px solid #DDD; display: block; margin-left: auto; margin-right: auto;">
			<div style="float: left; height: 20px; text-align: center;">
				<?php $cleanKey = str_replace("-", " ",  $key);?>
				<?php echo ucwords($cleanKey);?>
			</div>
			<div style="float: right; min-width: 150px; height: 20px; text-align: center;">
				
					<?php echo @$three_step->{"$key"};?>
			</div>
		</div>
	  
	<?php endforeach;?>
	
	<span><a href="#">Export Receipt</a></span><span><a>Print Receipt</a></span><span>Make Another Donation</span>
	</div>
<?php endif;?>
</body>
</html>
<?php nmiThreeStep::__getInstance()->__releaseInstance();?>