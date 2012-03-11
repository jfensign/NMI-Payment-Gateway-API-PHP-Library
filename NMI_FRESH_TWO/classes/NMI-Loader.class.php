<?php

class NMI_Loader {


	public function three_step($creds, $redirect) {
			require_once("NMI-Three-Step-API.class.php");
			return new NMI_Three_Step($creds, $redirect);
	}
	
	public function direct_post($creds) {
		require_once("NMI-Direct-Post-Api.class.php");
		return new NMI_Direct_Post($creds);
	}


}

?>