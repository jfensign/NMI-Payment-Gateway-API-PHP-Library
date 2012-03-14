<?php 
session_start();
require_once("../core/NMI-Three-Step-API.class.php");
$form_url = nmiThreeStep::__getInstance()->StepTwo();
?>

	<div id="reviewWrap">
		<div id="reviewWrapChildLeft" class="childReviewDiv">
		<p>Amount: $<?php echo nmiThreeStep::__getInstance()->__get("amount");?></p>
		<p>Firstname: <?php echo nmiThreeStep::__getInstance()->__get("first-name");?></p>
		<p>Lastname: <?php echo nmiThreeStep::__getInstance()->__get("last-name");?></p>
		<p>Email: <?php echo nmiThreeStep::__getInstance()->__get("email");?></p>
		<p>Phone: <?php echo nmiThreeStep::__getInstance()->__get("phone");?></p>
		</div>
		
		<div id="reviewWrapChildRight" class="childReviewDiv">
		<p>Address: <?php echo nmiThreeStep::__getInstance()->__get("address1");?></p>
		<p>City: <?php echo nmiThreeStep::__getInstance()->__get("city");?></p>
		<p>State: <?php echo nmiThreeStep::__getInstance()->__get("state");?></p>
		<p>Zip Code: <?php echo nmiThreeStep::__getInstance()->__get("postal");?></p>
		<p>Country: <?php echo nmiThreeStep::__getInstance()->__get("country");?></p>
		</div>
	</div>
	<fieldset>
		<form name="payment_info_form" id="payment_info_form" method="POST" action="<?php echo $form_url;?>">
		  <label for="billing-cc-number">Card Number</label><br /><input type="text" name="billing-cc-number" id="payer_card" /><br />
		  <label for="billing-cc-exp">Expires</label><br /><input type="text" name="billing-cc-exp" id="payer_card_number" /><br />
		  <label for="billing-cvv">CVV</label><br /><input type="text" name="billing-cvv" id="payer_card_cvv" /><br />
		<input type="submit" name="STEP_TWO" value="Continue" />
		</form>
	</fieldset>

	
	
	
<style type="text/css">
	

	fieldset {
		padding: 0;
		margin: 0;
	}
  .childReviewDiv {
	width: 165px;
	height: 165px;
	float: left;
	text-align: center;
  }
  
  #reviewWrap {
	width: 350px;
	margin-left: auto;
	margin-right: auto;
	padding-bottom: 0;
	margin-bottom: 0;
  }
  
  .childReviewDiv > p{
	font: 11px Helvetica, Arial, freesans, clean, sans-serif;
	padding: 0;
	margin-bottom: -5px;
  }

  
  label {
	font: 11px Helvetica, Arial, freesans, clean, sans-serif;
	font-weight: 700;
	color: #333;
  }
  
  fieldset {
	border: none;
  }
  
  legend {
	visibility: hidden;
  }
	
input[type="text"], input[type="password"], input[type="email"], input[type="tel"] {
margin-right: 5px;
font-size: 14px;
padding: 5px;
padding-bottom: 7px;
color: #666;
background-repeat: no-repeat;
background-position: right center;
width: 385px;
margin-left: auto;
margin-right: auto;
  }
  
input[type="submit"] {
display: inline-block;
padding: 8px 15px;
line-height: normal;
position: relative;
font-family: Helvetica,arial,freesans,clean,sans-serif;
font-size: 12px;
font-weight: bold;
color: #666;
text-shadow: 0 1px rgba(255, 255, 255, 0.9);
background-color: whiteSmoke;
background-image: -moz-linear-gradient(whiteSmoke,#E5E5E5);
background-image: -webkit-linear-gradient(whiteSmoke,#E5E5E5);
-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#f5f5f5',endColorstr='#e5e5e5')";
border-radius: 3px;
border: 1px solid #DDD;
border-bottom-color: #BBB;
box-shadow: 0 1px 3px rgba(0,0,0,0.1);
cursor: pointer;
margin-left: 0;
margin-top: 10px;

color: white;
text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.4);
border-color: #74BB5A;
border-bottom-color: #509338;
background-color: #8ADD6D;
background-image: -moz-linear-gradient(#8ADD6D,#60B044);
background-image: -webkit-linear-gradient(#8ADD6D,#60B044);
-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#8add6d',endColorstr='#60b044')";
box-shadow: 0 1px 4px rgba(0,0,0,0.2);
}
	
	
</style>