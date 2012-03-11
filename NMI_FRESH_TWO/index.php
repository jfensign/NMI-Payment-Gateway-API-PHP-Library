<?php
session_start();
require_once("classes/NMI-Three-Step-API.class.php");
if(!empty($_POST)):
$three_step = nmiThreeStep::__getInstance(array(
									"user" => null, //User
									"key" => "API KEY", //API Key
									"gwURI" => "https://secure.nmi.com/api/v2/three-step", //Gateway URI
									"redirectURI" => "http://localhost/nmi/NMI_FRESH/NMI_FRESH_TWO/checkout.php", //Redirect URI
									"checkoutURI" => "http://localhost/nmi/NMI_FRESH/NMI_FRESH_TWO/checkout.php",
									"sessionIndex" => "THREE_STEP",
									"amount" => @$_POST['amount'] //Sale Amount ... if NULL, it is assumed that this is a vault action
								));
								
$_SESSION['THREE_STEP'] = serialize($three_step);
endif;
?>

<script type="text/javascript">

	<div class="item"></div>

</script>

<fieldset>
  <legend>Proceed to Checkout</legend>
  <div>
	<ul>
	  <li>Something</li>
	  <li>Somewhere</li>
	</ul>
	
	<form name="start_transaction" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<input type="hidden" value="0.99" name="amount" value="0.99" />
		<input type="submit" name="start_transaction" value="Begin Transaction" />
	</form>
  </div>
</fieldset>