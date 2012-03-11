<?php
require_once("classes/NMI.class.php");

class nmiThreeStep {

	protected static $_instance = NULL;
	
	public $gatewayData,
		   $currentStep = null;
	
	//Accepted Formats
	private static $acceptedContentTypes = array(
		":json" => "Content-type: text/json",
		":xml" => "Content-type: text/xml",
		":html" => "Content-type: text/html"
	);

	//__construct(array) sets required data members
	private function __construct(array $args = NULL) {
		
		$this->__set("user", $args["user"]);
		$this->__set("apiKey", $args["key"]);
		$this->__set("gatewayURL", $args["gwURI"]);
		$this->__set("redirectURL", $args["redirectURI"]);
		
		if(is_numeric($args["amount"])):
			$this->__set("amount", floatval($args["amount"]));
		endif;
		
		header("Location: " . $args["checkoutURI"]);
	}
	
	// __getInstance creates a Singleton instance and binds itself to 
	// the NMI observer class ensuring data persistence
	public static function __getInstance($args) {
	
		if(empty(self::$_instance) && empty(NMI::$subject)):
			self::$_instance = new nmiThreeStep($args);
			NMI::attach(self::$_instance);
		endif;
		
		return self::$_instance;
	}
	
	//PHP MAGIC METHOD __SET dynamically sets data members
	public function __set($key, $val) {
		$this->gatewayData[$key] = $val;
	}
	//PHP MAGIC METHOD __get calls dynamically set data members
	public function __get($key) {
		if(array_key_exists($key, $this->gatewayData)):
			return $this->gatewayData[$key];
		else:
			return FALSE;
		endif;
	}
	
	//Step one takes trivial transaction info (billing and shipping information)
	public function StepOne($postVals) {
	
		foreach($postVals['persistenceMedium'] as $key => $val):
			$this->__set("$key", "$val");
		endforeach;
		
		$this->__set("transactionType", $postVals['transactionType']['type']);
		
		unset($postVals['persistenceMedium']);
		unset($postVals['transactionType']);
	
		include_once($this->__get('StepOneFormFile'));
		
		if(!empty($_POST[$postVals["billing"]['submit']])):

		$doc = new DOMDocument("1.0", "UTF-8");
		$doc->formatOutput = TRUE;
		
		$type = $doc->createElement($this->__get("transactionType"));
			//REQUIRED
			$apiKey = $doc->createElement("api-key");
				$apiKey->appendChild($doc->createTextNode($this->__get("apiKey")));
				$type->appendChild($apiKey);
			//REQUIRED	
			$redirectURL = $doc->createElement("redirect-url");
				$redirectURL->appendChild($doc->createTextNode($this->__get("redirectURL")));
				$type->appendChild($redirectURL);
			
			if($this->__get("amount") != FALSE):
			//REQUIRED FOR TRANSACTIONS	
			$amount = $doc->createElement("amount");
				$amount->appendChild($doc->createTextNode($this->__get("amount")));
				$type->appendChild($amount);
			endif;
		$doc->appendChild($type);
		
		$key = array_keys($postVals);
		for($i=0;$i<count($key);$i++) {
			if($key[$i] != "persistenceMedium" && $key[$i] != "transactionType"):
				$this->genChildElement($doc, $type, $key[$i], $postVals[$key[$i]]);
			endif;
		}
		
		$x = $doc->saveXML();
		
		file_put_contents($this->__get('StepOneFormVals'), $x, LOCK_EX);
		
		$headers = array();
		$headers[] = "Content-type: text/xml";
		
		$this->__set("cURL_HeadersContentType", $headers);
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->__get("gatewayURL"));
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); //CURRENTLY ONLY SUPPORTS XML
		curl_setopt($curl, CURLOPT_FAILONERROR, 1);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // Allow redirects
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // Return into a variable
		curl_setopt($curl, CURLOPT_PORT, 443); // Set the port number
		curl_setopt($curl, CURLOPT_TIMEOUT, 15); // Times out after 15s
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $x); // Add XML directly in POST
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
		
		// This should be unset in production use. With it on, it forces the ssl cert to be valid before sending info.
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		
		$this->__set(__FUNCTION__ . "Response", curl_exec($curl));
		
		file_put_contents($this->__get('StepOneResponseXML'), $this->__get(__FUNCTION__ . "Response"), LOCK_EX);
		
		$file = file($this->__get('StepOneResponseXML'));
		if(!empty($file)) {
		
			$doc = new DOMDocument("1.0", "UTF-8");
			$doc->formatOutput = TRUE;
			
			$doc->load($this->__get("StepOneResponseXML"));
		
			$responseVals = array();
		
			@$result = $doc->getElementsByTagName("Result");
				$tmp = $doc->getElementsByTagName("result");
			@$responseVals['result'] = $tmp->item(0)->nodeValue;
				$tmp = $doc->getElementsByTagName("result-text");
			@$responseVals['result-text'] = $tmp->item(0)->nodeValue;
				$tmp = $doc->getElementsByTagName("transaction-id");
			@$responseVals['transaction-id'] = $tmp->item(0)->nodeValue;
				$tmp = $doc->getElementsByTagName("result-code");
			@$responseVals['result-code'] = $tmp->item(0)->nodeValue;
				$tmp = $doc->getElementsByTagName("form-url");
			@$responseVals['form-url'] = $tmp->item(0)->nodeValue;
		
		foreach($responseVals as $key => $val) {
			$this->__set($key, $val);
		}
		
		if(intval($this->__get("result")) > 1) {
			echo ($this->__get("result-text"));
			parse_str($this->__get("StepOneResponseXML"), $invalid_file);
			unset($invalid_file);
			exit();
		}
		
		NMI::update(self::$_instance); //Attach Current Instance
		} else {
			exit("An error occurred. Please try again.");
		}
		unset($file);
		endif;
	}
	
	public function StepTwo($files) {
		
		foreach($files['persistenceMedium'] as $key => $val) {
			$this->__set($key, $val);
		}
		
		if(file_exists($this->__get("StepOneResponseXML"))):
			$y = $this->__get("StepOneResponseXML");
			unset($y);
			extract($files["persistenceMedium"]);
			include_once($this->__get("StepTwoFormFile"));
		endif;
		
		NMI::update(self::$_instance);
		
	}
	
	public function StepThree($files) {
	
		foreach($files as $key => $val):
			$this->__set("$key", "$val");
		endforeach;
	
		if(!empty($_GET['token-id'])) {
			$this->__set("token-id", $_GET['token-id']);
			
			$doc = new DOMDocument("1.0", "UTF-8");
			$doc->formatOutput = TRUE;
			
			$type = $doc->createElement('complete-action');
			
				$apiKey = $doc->createElement('api-key');
					$apiKey->appendChild($doc->createTextNode($this->__get("apiKey")));
					$type->appendChild($apiKey);
					
				$tokenId = $doc->createElement('token-id');
					$tokenId->appendChild($doc->createTextNode($this->__get("token-id")));
					$type->appendChild($tokenId);
				
			$doc->appendChild($type);
			
			$x = $doc->saveXML();
			$header = array();
			$header[] = "Content-type: text/xml";
			$curl = curl_init();	
			curl_setopt($curl, CURLOPT_URL, $this->__get("gatewayURL"));
			curl_setopt($curl, CURLOPT_HTTPHEADER, $header); //CURRENTLY ONLY SUPPORTS XML
			curl_setopt($curl, CURLOPT_FAILONERROR, 1);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // Allow redirects
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // Return into a variable
			curl_setopt($curl, CURLOPT_PORT, 443); // Set the port number
			curl_setopt($curl, CURLOPT_TIMEOUT, 15); // Times out after 15s
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $x); // Add XML directly in POST
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		
			$this->__set(__FUNCTION__ . "Response", curl_exec($curl));
			file_put_contents($this->__get(__FUNCTION__ . "ResponseXML"), $this->__get(__FUNCTION__ . "Response"), LOCK_EX);
			
			$doc = new DOMDocument("1.0", "UTF-8");
			$doc->formatOutput = TRUE;
			
			$doc->load($this->__get(__FUNCTION__ . "ResponseXML"));
			
			$tmp = $doc->getElementsByTagName("result");
				$responseResult['result'] = $tmp->item(0)->nodeValue;
			$tmp = $doc->getElementsByTagName("result-text");
				$responseResult['result-text'] = $tmp->item(0)->nodeValue;
			$tmp = $doc->getElementsByTagName("result-code");
				$responseResult['result-code'] = $tmp->item(0)->nodeValue;
	
			foreach($responseResult as $key => $val) {
				$this->__set(__FUNCTION__ . "$key", "$val");
			}
			
			NMI::update(self::$_instance);
			
			if(intval($this->__get(__FUNCTION__ . 'result')) > 1) {
				exit($this->__get(__FUNCTION__ . 'result-text'));
			}
		}
	
	}
	
	private function genChildElement(DOMDocument $handle, $abstrParentElement, $element_name, array $elementArray = NULL) {
		
		try {
		
			$abstrChildElem = $handle->createElement($element_name);
			if(!is_null($elementArray)):
				foreach($elementArray as $key => $val):
					if($key != "submit"):
						$tmpElem = $handle->createElement("$key");
						$tmpElem->appendChild($handle->createTextNode(@$_POST[$key]));
						$abstrChildElem->appendChild($tmpElem);
					endif;
				endforeach;
			endif;
			$abstrParentElement->appendChild($abstrChildElem);
		}
		catch(Exception $e) {
			echo $e->getMessage();
		}
		
	}
	
	
	
	
	
}
?>