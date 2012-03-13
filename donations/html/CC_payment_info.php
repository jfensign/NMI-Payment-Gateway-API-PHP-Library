<!--<html>
<head>
<title>NMI Three-Step API Example</title>
<script type="text/javascript" src="../js/jquery.js"></script>
	
	<script type="text/javascript">
	
	/*$(document).ready(function () {

		$('form').attr("onsubmit", "return false;");
		
		$('form').submit(function () {
		
			var formID = $(this).attr('id');
			var action = $(this).attr('action');
			var postData = $(this).serialize();
			
			$.ajax({
				
				type: "post",
				url: action,
				data: postData,
				success: function(data) {
					
				}
			});
		});
	});*/
	
	</script>
</head>
<body>	-->
<!--
<?php require_once("../classes/NMI-Three-Step-API.class.php");?>
-->
<?php $form_url = nmiThreeStep::__getInstance()->StepTwo();?>
	
	<fieldset>
		<legend>Payment Information</legend>
		<form name="payment_info_form" id="payment_info_form" method="POST" action="<?php echo $form_url;?>">
		<div id="payment_info_wrap" class="payment_form_field_wrap">
		  <label for="billing-cc-number">Card Number</label><br /><input type="text" name="billing-cc-number" id="payer_card" /><br />
		  <label for="billing-cc-exp">Expires</label><br /><input type="text" name="billing-cc-exp" id="payer_card_number" /><br />
		  <label for="billing-cvv">CVV</label><br /><input type="text" name="billing-cvv" id="payer_card_cvv" /><br />
		</div>
		<input type="submit" name="STEP_TWO" value="Continue" />
		</form>
	</fieldset>
	
	
	
<style type="text/css">
	
  form {
	margin-top: 0;
	margin-left: auto;
	margin-right: auto;
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
width: 375px;
  }
  
input[type="submit"], input[type="button"]
{
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
  }
	
	
</style>
<!--
</body>
</html>
-->