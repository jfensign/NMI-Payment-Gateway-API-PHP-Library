<?php 
require_once("classes/NMI-Three-Step-API.class.php");
session_start();
?>
<html>
<head>
<title>NMI Three-Step API Example</title>
<script type="text/javascript" src="js/jquery.js"></script>

<script type="text/javascript">

$(document).ready(function() {

	$("#set_amount").click(function() {
	
		$("#start_transaction").hide();
		$("#billing_shipping").show();
	
	}); 

	//all forms except the final form can make xHTTP requests
  $("form").not("#payment_info_form").attr("onsubmit", "return false;");
  
  $("form").submit(function() {
  
	var action = $(this).attr("action");
	var SerializeData = $(this).serialize();

	$.ajax({
		type: "post",
		url: action,
		data: SerializeData
	
	})
  
  });

});

</script>

<style type="text/css">
  div {
	width: 350px;
	padding-bottom: 0;
	padding-left: auto;
	padding-right: auto;
	margin-left: auto;
	margin-right: auto;
  }
  
  form {
	width: 300px;
	margin-left: auto;
	margin-right: auto;
  }
  
  h3 {
background-color: #FAFAFA;
background-image: -moz-linear-gradient(#FAFAFA,#E0E0E0);
background-image: -webkit-linear-gradient(#FAFAFA,#E0E0E0);
-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#fafafa',endColorstr='#e0e0e0')";
  }
  
  
  #breadcrumb_wrap {
	margin-left: auto;
	margin-right: auto;
	margin-top: 5px;
	width: 285px;
  }
  
  .payment_form_toggle {
	cursor: pointer;
	font-family: Helvetica,arial,freesans,clean,sans-serif;
	font-size: 11px;
	font-weight: bold;
	color: #333;
	text-shadow: 1px 1px 0 white;
	white-space: nowrap;
	float: left;
	margin-right: 15px;
	padding: 0;
	margin-bottom: 20px;
}
  
   h3 {

margin: 0;
border-top-left-radius: 1px;
border-top-right-radius: 1px;
border: 1px solid #D8D8D8;
border-bottom: 1px solid #CCC;
padding: 10px 10px 11px 10px;
font-size: 14px;
text-shadow: 0 1px 0 white;
}
  
input[type="text"], input[type="password"], input[type="email"], input[type="tel"] {
margin-right: 5px;
font-size: 14px;
width: 200px;
padding: 5px;
padding-bottom: 7px;
color: #666;
background-repeat: no-repeat;
background-position: right center;
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




</head>
<body>

<div id="donations_wrap">
<h3>Donate Today</h3>
<div id="breadcrumb_wrap">
	<span id="#start_transaction" class="payment_form_toggle">Choose Option</span>
	<span id="#billing_shipping" class="payment_form_toggle">Billing and Shipping</span>
	<span id="#checkout" class="payment_form_toggle">Payment</span>
</div>

<div id="start_transaction" class="donation_form_wrap">
	<form name="start_transaction" id="start_transaction" method="POST" action="http://localhost/nmi/NMI_FRESH/NMI_FRESH_TWO/StepOne.php">
		<input type="text" name="amount" required="required" />
		<input type="button" name="billing_shipping_toggle" id="set_amount" value="Continue" />
</div>
<div id="billing_shipping" class="donation_form_wrap">


<fieldset>
		<legend>Shipping and Billing Information</legend>
		
		<div id="shipping_billing_info_wrap" class="payment_form_field_wrap">
		<label for="first-name">Firstname</label><br /><input type="text" name="first-name" id="payer_first-name" /><br />
		<label for="last-name">Lastname</label><br /><input type="text" name="last-name" id="payer_lastname" /><br />
		<label for="address1">Address</label><br /><input type="text" name="address1" id="payer_address1" /><br />
		<label for="city">City</label><br /><input type="text" name="city" id="payer_city" /><br />
		<label for="state">State</label><br /><input type="text" name="state" id="payer_state" /><br />
		<label for="postal">Zip</label><br /><input type="text" name="postal" id="payer_postal" /><br />
		<label for="country">Country</label><br /><input type="text" name="country" id="payer_country" /><br />
		<label for="email">Email</label><br /><input type="email" name="email" id="payer_email" /><br />
		<label for="phone">Phone Number</label><br /><input type="tel" name="phone" id="payer_phone" /><br />
		</div>
		<input type="submit" name="STEP_ONE" value="Proceed to Checkout" />
		</form>
</fieldset>


</div>
<div id="checkout" class="donation_form_wrap">
<iframe src="html/CC_payment_info.php"></iframe>
	<!--<fieldset>
		<legend>Payment Information</legend>
		<form name="payment_info_form" id="payment_info_form" method="POST" action="<?php echo $_SESSION['form-url'];?>">
		<div id="payment_info_wrap" class="payment_form_field_wrap">
		  <label for="billing-cc-number">Card Number</label><br /><input type="text" name="billing-cc-number" id="payer_card" /><br />
		  <label for="billing-cc-exp">Expires</label><br /><input type="text" name="billing-cc-exp" id="payer_card_number" /><br />
		  <label for="billing-cvv">CVV</label><br /><input type="text" name="billing-cvv" id="payer_card_cvv" /><br />
		</div>
		<input type="submit" name="STEP_TWO" value="Process" />
		</form>
	</fieldset>-->
</div>

</div>

<script type="text/javascript">
$(document).ready(function() {

	$(".donation_form_wrap").not("#start_transaction").hide();

	$(".payment_form_toggle").click(function() {
		$(".payment_form_toggle").css("borderBottom", "none");
		$(this).css("borderBottom", "1px solid #222");
		
		var divID = $(this).attr("id");
		$(".donation_form_wrap").not(divID).hide();
		
		$(divID).show();
	});
});
</script>

</body>
</html>