<?php
require_once("NMI.class.php");

class nmiThreeStep {

	private static $_instance;
	private static $acceptedContentTypes = array(
											  "xml" => "Content-type: text/xml",
											  "json" => "Content-type: text/json",
											  "html" => "Content-type: text/html"	
											);
	private $ContentType,
			$StepOneResponse,
			$StepOneResponseJSON,
			$StepThreeResponse;
			
			
	public $TransactionType,
			$Shipping,
			$Billing,
			$apiKey,
			$userID,
			$password,
			$redirectURI,
			$gatewayURI,
			$formURI,
			$transactionID,
			$amount,
			$serializedResponse = array();

	public function __construct($initVals) {
		
		if(is_array($initVals)):
		foreach($initVals as $key => $val): //set cache values
			if($val != NULL):
				nmiCache::Cache()->__cacheSet($key, $val);
				$this->$key = nmiCache::Cache()->__cacheGet($key);
			endif;
		endforeach;
		endif;
	}
	
	public static function __getInstance($initVals = NULL) {
		if(empty(self::$_instance) && nmiCache::isStarted() === FALSE):
			self::$_instance = new nmiThreeStep($initVals);
			nmiCache::Cache()->__cacheSet("ThreeStepInstance", self::$_instance);
		endif;
		
		return nmiCache::Cache()->__cacheGet("ThreeStepInstance");
	}
	
	public function __set($key, $val) {
		return nmiCache::Cache()->__cacheSet($key, $val);
	}
	
	public function __get($key) {
		return nmiCache::Cache()->__cacheGet($key);
	}
	
	public function StepOne(array $StepOneVals = NULL, $enc = NULL) {
		
		nmiCache::Cache()->__cacheSet("apiKey", $this->apiKey);
		nmiCache::Cache()->__cacheSet("gatewayURI", $this->gatewayURI);
		nmiCache::Cache()->__cacheSet("redirectURI", $this->redirectURI);
		
		if($enc != NULL):
			if(array_key_exists($enc, self::$acceptedContentTypes)):
				$this->ContentType = self::$acceptedContentTypes[$enc];
			else:
				$contentTypeErrorList = implode(", " . PHP_EOL, self::$acceptedContentTypes); 
				throw new Exeption("Not an accepted content type. 
									Must be one of the following: 
									$contentTypeErrorList" . 
									PHP_EOL);
			endif;
		endif;
		
		if($StepOneVals === NULL): //check that argument is not empty
			exit(__CLASS__ . "::" . __FUNCTION__ . " requires an array as its argument.");
		endif;
		
		$this->TransactionType = $StepOneVals['transactionType']['type'];
		
		$doc = new DOMDocument("1.0", "UTF-8");
		$doc->formatOutput = TRUE;
		
		$type = $doc->createElement($this->TransactionType);
			//REQUIRED
			$apiKey = $doc->createElement("api-key");
				$apiKey->appendChild($doc->createTextNode($this->apiKey));
				$type->appendChild($apiKey);
			//REQUIRED	
			$redirectURL = $doc->createElement("redirect-url");
				$redirectURL->appendChild($doc->createTextNode($this->redirectURI));
				$type->appendChild($redirectURL);
			
		if(isset($this->amount)): //create amount element 
			//REQUIRED FOR TRANSACTIONS	
			$amount = $doc->createElement("amount");
				$amount->appendChild($doc->createTextNode($this->amount));
				$type->appendChild($amount);
		endif;
		
		$doc->appendChild($type);
		
		$key = array_keys($StepOneVals);
		
		for($i=0;$i<count($key);$i++):
			if($key[$i] != "transactionType"):
				$this->genChildElement($doc, $type, $key[$i], $StepOneVals[$key[$i]]);
			endif;
		endfor;

		$this->StepOneResponse = $this->execCurl($doc->saveXML(), "xml");
		return $this->returnSerializedResponse($this->StepOneResponse, "json", array("form-url", "token-id"));
	}
	
	public function StepTwo() {

		if(nmiCache::Cache()->__cacheGet("form-url") === FALSE) {
			nmiCache::Cache()->__cacheSet(__FUNCTION__ . "Complete", FALSE);
			return FALSE;
		}
		else {
			nmiCache::Cache()->__cacheSet(__FUNCTION__ . "Complete", TRUE);
			//HANDLE Passing form-url to view
			return nmiCache::Cache()->__cacheGet("form-url");
		}
	}
	
	public function StepThree() {
		
		if(!empty($_GET['token-id'])):
		
			$doc = new DOMDocument("1.0", "UTF-8");
			$doc->formatOutput = TRUE;
			
			$type = $doc->createElement("complete-action");
			
			$apiKey = $doc->createElement("api-key");
			$apiKey->appendChild($doc->createTextNode(nmiCache::Cache()->__cacheGet("apiKey")));
			$type->appendChild($apiKey);
			
			$tokenId = $doc->createElement("token-id");
			$tokenId->appendChild($doc->createTextNode($_GET['token-id']));
			$type->appendChild($tokenId);
			
			$doc->appendChild($type);

			$this->StepThreeResponse = $this->execCurl($doc->saveXML(), "xml");
			
			return $this->returnSerializedResponse($this->StepThreeResponse, "json", "ALL");
			
		endif;
		
	}
	
	public function returnSerializedResponse($content, $ContentType = NULL, $cacheVals = NULL) {
		
		if($ContentType === NULL) { //Will return XML
			return $content;
		}
		else {
		
			$parse = xml_parser_create('UTF-8');
			$read = xml_parse_into_struct($parse, $content, $values, $index);
			xml_parser_free($parse);
		
			for($i=0;$i<count($values);$i++):
				if(array_key_exists("value", $values[$i])):
				
					if($cacheVals != NULL):
						if(is_array($cacheVals)):
							if(in_array(strtolower($values[$i]['tag']), $cacheVals)):
								nmiCache::Cache()->__cacheSet(strtolower($values[$i]['tag']), $values[$i]['value']);
							endif;
						elseif(is_string($cacheVals)):
							if($cacheVals == "ALL"):
								nmiCache::Cache()->__cacheSet(strtolower($values[$i]['tag']), $values[$i]['value']);
							endif;
						endif;
						$this->serializedResponse[strtolower($values[$i]['tag'])] = $values[$i]['value'];
					endif;
					
				endif;
			endfor;
			
			switch($ContentType):
				case $ContentType == "json" || $ContentType == "JSON":
					return json_encode($this->serializedResponse);
				break;
				
				default:
					exit("Not Supported yet...");
				break;
			endswitch;
				
			}
			
		}
	
	
	private function execCurl($data = NULL, $contentType = NULL) {
	
		if($data === NULL && $contentType === NULL) {
			throw new Exception("Both arguments are required");
		}
		elseif(!array_key_exists($contentType, self::$acceptedContentTypes)) {
			throw new Exception("Function " . __FUNCTION__ . 
								"'s second argument must be one of the following" . 
								implode(", " . PHP_EOL, self::$acceptedContentTypes) . 
								"!");
		}
		elseif($contentType != "xml") {
			throw new Exeption("The NMI Payment Gateway only accepts XML.");
		}
		else {
		
			try {
				$headers = array();
				$headers[] = "Content-type: text/xml";
			
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, nmiCache::Cache()->__cacheGet("gatewayURI"));
				curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); //CURRENTLY ONLY SUPPORTS XML
				curl_setopt($curl, CURLOPT_FAILONERROR, 1);
				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // Allow redirects
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // Return into a variable
				curl_setopt($curl, CURLOPT_PORT, 443); // Set the port number
				curl_setopt($curl, CURLOPT_TIMEOUT, 15); // Times out after 15s
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Add XML directly in POST
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
				$result = curl_exec($curl);
				
				curl_close($curl);
				
				return $result;
			} 
			catch(Exception $e) {
				echo $e->getMessage();
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