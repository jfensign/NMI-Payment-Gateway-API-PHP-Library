<fieldset>
		<legend>Shipping and Billing Information</legend>
		<form name="gateway_shipping_billing_info" id="shipping_billing_info_form" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
		
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

<script type="text/javascript">
function persist() {
/*
   * In case of page refresh,
   * store the values of form to DOMStorage
*/

var form = document.getElementById("shipping_billing_info_form");
    window.onbeforeunload = function () {
        var str = serialize(form);
        try {
            sessionStorage[form.name] = str;
        } catch (e) {}
    }
 
/*
   * If the form was refreshed and old values are available,
   * restore the old values in form
   */
    window.onload = function () {
        try {
            if (sessionStorage[form.name]) {
                var obj = eval("(" + sessionStorage[form.name] + ")");
                for (var i = 0; i < obj.elements.length - 1; i++) {
                    var elementName = obj.elements[i].name;
                    document.forms[obj.formName].elements[obj.elements[i].name].value = obj.elements[i].value;
                }
 
            }
        } catch (e) {}
    }
}
 
/*
 * Convert form elements into JSON String
 */
 
function serialize(form) {
    var serialized = '{ "formName":"' + form.name + '", "elements": [';
    for (var i = 0; i < form.elements.length; i++) {
 
        serialized += '{';
        serialized += '"name":"' + form[i].name + '",';
        serialized += '"value":"' + form[i].value + '"';
        serialized += '},';
    }
    serialized += '{"name":0, "value":0}';
    serialized += '] }';
    return serialized;
}
 
/*
 * Make the Client Form persistable.
 * i.e. Persist its values in case of page refresh
 */
persist(document.clientForm);
</script>
