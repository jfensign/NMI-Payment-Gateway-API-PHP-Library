<?php 
require_once("core/NMI-Three-Step-API.class.php");
?>

<html>
<head>
<title>NMI Three-Step API Example</title>
<script type="text/javascript" src="assets/js/jquery.js"></script>


<script type="text/javascript">
$(document).ready(function() {

	$(".donation_form_wrap").not("#start_transaction").hide();

	$(".payment_form_toggle > a").click(function() {
		if(!$(this).attr("onclick")) {
		
		$(".payment_form_toggle > a").css("borderBottom", "none");
		
		$(this).css("borderBottom", "2px solid #222");
		
		var divID = $(this).attr("href");
		$(".donation_form_wrap").not(divID).hide();
		
		$(divID).show();
		
		} else {
			return false;
		}
	});
});
</script>

<script type="text/javascript">

$(document).ready(function() {

	$("#breadcrumb_wrap").hide();
	
	$("#set_amount").click(function() {
		$("#breadcrumb_wrap").show();
		$("#checkout_button").css("color", "#CCC");
		$("#checkout_button").attr("onclick", "return false");
		$("#billing_shipping_button").click();
	}); 

	//all forms except the final form can make xHTTP requests
  $("form").not("#payment_info_form").attr("onsubmit", "return false;");
  
  $("form").submit(function() {
	
	var formID = $(this).attr("id");
	var formName = $(this).attr("name");
	var action = $(this).attr("action");
	var SerializeData = $(this).serialize();

	$.ajax({
		type: "post",
		url: action,
		data: SerializeData,
		success: function(data) {
		var Doc = $.parseJSON(data),
			$Result = Doc['result'];
			
			if(parseInt($Result) === 1) {
				$formURL = Doc['form-url'];
				$tokenID = Doc['token-id'];
				
				$("#payment_frame").attr("src", "html/CC_payment_info.php");
				$("#checkout_button").removeAttr("onclick");
				$("#checkout_button").css("color", "#D26911");
				$("#checkout_button").click();
			}
				
			return false;
		
			/* BELOW IS XML...
			
				var Doc = $.parseXML(data),
				$XML = $(Doc);
				$Result = $XML.find("result").text();
				$ResultText = $XML.find("result-text").text();
				$FormURL = $XML.find("form-url").text();
				$TransactionId = $XML.find("transaction-id").text();
			*/
			
			}
	});
  });
  
});

</script>

<style type="text/css">

  #donations_wrap {
	width: 415px;
	margin: 0px auto 0px auto;
	border: 1px solid #ccc;
	border-radius: 5px 5px;
	padding-bottom: 0;
  }
  
  #start_transaction {
	margin-top: 5px;
  }
  
  .payment_form_field_wrap {
	width: 350px;
	
  }
  
  fieldset {
	border: none;
  }
  
  form {
	width: 375px;
	margin-left: auto;
	margin-right: auto;
  }

  
  label {
	font: 11px Helvetica, Arial, freesans, clean, sans-serif;
	font-weight: 700;
	color: #333;
  }
  
  h3 {
background-color: #FAFAFA;
background-image: -moz-linear-gradient(#FAFAFA,#E0E0E0);
background-image: -webkit-linear-gradient(#FAFAFA,#E0E0E0);
-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#fafafa',endColorstr='#e0e0e0')";
border-radius: 5px 5px 0 0;
  }
  
  
  #breadcrumb_wrap {
	/*margin-left: auto;
	margin-right: auto;*/
	margin-top: 10px;
	padding-left: 15px;
	width: 415px;
	margin-bottom: 15px;
  }
  
  .payment_form_toggle > a {
	cursor: pointer;
	font-family: Helvetica,arial,freesans,clean,sans-serif;
	font-size: 11px;
	font-weight: bold;
	color: #D26911;
	text-shadow: 1px 1px 0 white;
	white-space: nowrap;
	float: left;
	margin-right: 15px;
	padding: 0;
	margin-bottom: 10px;
	text-decoration: none;
	padding: 0 3px 0 3px;
}
  
h3 {
/*
margin: 0;
border-top-left-radius: 1px;
border-top-right-radius: 1px;
border: 1px solid #D8D8D8;
border-bottom: 1px solid #CCC;
padding: 10px 10px 11px 10px;
font-size: 14px;
font-family: Helvetica, Arial, freesans, clean, sans-serif;
text-shadow: 0 1px 0 white;
*/

color: white;
font-size: 16px;
font-weight: bold;
font-family: Helvetica, Arial, freesans, clean, sans-serif;
background-color: #829AA8;
background-image: -moz-linear-gradient(#829AA8,#405A6A);
background-image: -webkit-linear-gradient(#829AA8,#405A6A);
-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#829aa8',endColorstr='#405a6a')";
border: 1px solid #677C89;
border-bottom-color: #6B808D;
border-radius: 5px 5px 0 0;
text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.7);
margin: 0;
padding: 10px 0 10px 18px;
position: relative;
}
  
input[type="text"], input[type="password"], input[type="email"], input[type="tel"] {
margin-right: 5px;
font-size: 14px;
padding: 5px 0 7px 0;
color: #666;
background-repeat: no-repeat;
background-position: right center;
margin-left: 0;
width: 375px;
text-align: left;
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
  
  #shipping_billing_info_wrap>input[type="text"], 
  #shipping_billing_info_wrap>input[type="tel"],
  #shipping_billing_info_wrap>input[type="email"] {
	width: 375px;
	text-align: left;
	border-radius: 3px;
  }
  
  
  iframe {
	padding-top: 10px;
	padding-left: 0;
	width: 400px;
	min-height: 390px;
	margin-left: auto;
	margin-right: auto;
	overflow: none;
	border: none;
  }
  
</style>




</head>
<body>
<div id="donations_wrap">
<h3>Donate Today</h3>
<div id="breadcrumb_wrap">
	<span id="#billing_shipping" class="payment_form_toggle"><a href="#billing_shipping" id="billing_shipping_button">Billing and Shipping Information</a></span>
	<span id="#checkout" class="payment_form_toggle"><a href="#checkout" id="checkout_button">Payment Information</a></span>
</div>

<div id="start_transaction" class="donation_form_wrap">
<fieldset>
	<form name="billing_shipping" id="start_transaction" method="POST" action="StepOne.php/">
		<label for="amount">Amount</label><br />
		<input type="text" name="amount" required="required" />
		<input type="button" name="billing_shipping_toggle" id="set_amount" value="Continue" />
</fieldset>
</div>
<div id="billing_shipping" class="donation_form_wrap"><!--BEGIN BILLING SHIPPING DIV-->
<fieldset>
		<label for="first-name">Firstname</label><br /><input type="text" name="first-name" id="payer_first-name" /><br />
		<label for="last-name">Lastname</label><br /><input type="text" name="last-name" id="payer_lastname" /><br />
		<label for="address1">Address</label><br /><input type="text" name="address1" id="payer_address1" /><br />
		<label for="city">City</label><br /><input type="text" name="city" id="payer_city" /><br />
		<label for="state">State</label><br /><input type="text" name="state" id="payer_state" /><br />
		<label for="postal">Zip</label><br /><input type="text" name="postal" id="payer_postal" /><br />
		<label for="country">Country</label><br /><input type="text" name="country" id="payer_country" /><br />
		<label for="email">Email</label><br /><input type="email" name="email" id="payer_email" /><br />
		<label for="phone">Phone Number</label><br /><input type="tel" name="phone" id="payer_phone" /><br />
		<input type="submit" name="STEP_ONE" id="stepOneSubmit" value="Proceed to Checkout" />
		</form>
</fieldset>
</div><!--END BILLING SHIPPING DIV-->

<div id="checkout" class="donation_form_wrap"><!--BEGIN CHECKOUT DIV-->
<? //iframe is used because of the API's mandatory redirect?>
<iframe id="payment_frame"></iframe> <!--Taking the iFrame approach to retain the main window's state-->
</div><!-- END CHECKOUT DIV-->

</div><!--END DONATIONS WRAP-->

</body>
</html>