	
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