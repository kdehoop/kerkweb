<?php

/*
 * De controller krijgt input van buiten af b.v. een brouwser.
 * De input van buitenaf wordt gecontroleerd door controller.
 * De controller bepaald de reactie (invoer) naar het model.
 */

class controller {

	/*
	 * start controller, bepaal of er post/get input is.
	 * indien niet dan is het een eerste actie. 
	 */
	
	function __construct(){
		
	}
	
	/*
	 * 
	 */
	
	function Request() {
	    $this->g_aReqArray = array_merge($_SERVER, $_ENV,  $_COOKIE);
		
		if(!isset($_REQUEST)){
			$this->g_aReqArray = array_merge($g_aReqArray, $_REQUEST);
			
		} else { // eerste verzoek tot informatie
			$this->StartAdmin();	
		}
	}
	
	/*
	 * 
	 */
	
	function StartAdmin() {
		$test = $this->getGlobVar('SERVER_SOFTWARE');	
	}
	
	/*
	 * 
	 */
	
	function getGlobVar($p_sRequestVar) {
		return $this->g_aReqArray[$p_sRequestVar];
	}
}


?>