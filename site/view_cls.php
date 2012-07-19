<?php 
/*
 * file       : view_cls.php
 * doel       : Algemeene Class voor het afhandelen van view actie van andere views.
 * d.d.       : 01-06-2011
 * ver.       : 1
 * create by  : kdh
 * ticket     : 1 
 * Copyright  : Actasys 
 */
class view {
	
	function __construct(){
		$this->procVars = procVar::getInstance();
	}
	
	function display() {
		if ($this->procVars->get('Step')=='Nieuw'){
			return $this->displayNieuw();
		}else{
			return $this->displayVervolg();
		}
	}
	
	function displayNieuw() {
		$l_sViewResult1[0]  = null;
		$l_sViewResult1[1]  = null;
		$l_sAdminPage 		= $this->procVars->get('temppath')  . $GLOBALS["adminpagefile"] ;
		$l_sDataHtml		= file_get_contents($l_sAdminPage);
        $l_sDataHtml        = stripcslashes($l_sDataHtml);
		$l_oMenu			= new frontpagina();
		$l_sMenu 			= $l_oMenu->getModuleMenu();
		$l_sViewResult1[0] 	= str_replace('{content1}',  $l_sMenu, $l_sDataHtml) ;
		$l_sViewResult1[1]  = 'Y';
		return $l_sViewResult1;
	}
	
	function displayVervolg() {
		$l_sType 			= '';
		$l_sDeleteNode		= '';
		$l_sViewResult 		= '';
		$l_sViewResult1[0]  = null;
		$l_sViewResult1[1]  = null;
		$l_sType   			= $this->procVars->get('moduleInfo', 'Type');
		// Bepaal de class en de methode en roept deze aan 		
		if($this->procVars->get( 'webInput','ref')){
			$l_sMethode = 'getXML'; 
		}else{
			$l_sMethode = 'getPage';
		}	
		
		if(strlen($this->procVars->get('action'))> 0 && $this->procVars->get('action') <> 'geen'){
			$l_sType 	= $this->procVars->get('webInput','module').'View';
			$l_sMethode = $this->procVars->get('webInput','action');
		} else {
			$l_sType 	= $l_sType.'View';
		}
		logRegel( $l_sType . '##'. $l_sMethode ,__FILE__ . __LINE__);
		$l_sViewPage 	= new $l_sType();
		$l_sViewResult 	= $l_sViewPage->$l_sMethode();
		
		$l_l_TestArray 	= is_array($l_sViewResult);
		if($l_l_TestArray==1){
			$l_sViewResult1[1]	= $l_sViewResult[1];
			$l_sPageResult 		= $l_sViewResult[0];
		} else {
			$l_sPageResult 		= $l_sViewResult;
			$l_sViewResult1[1]  = 'Y';
		}	
		
		
		 // Bepaal vak 1,2, of 3 in scherm
		
		if($this->procVars->get('moduleInfo', 'Type')=='Multi1Page'){
			if($this->procVars->get('Type')== 'Page'){
				$l_sRepId = 'kolom3';
			} else {
				$l_sRepId = 'kolom2';
			}
		} else {
			if( $this->procVars->get('moduleInfo', 'Type')=='listpage'|| $this->procVars->get('moduleInfo', 'Type')=='footer'||$this->procVars->get('moduleInfo', 'Type')=='BlokMenu'|| $this->procVars->get('moduleInfo', 'Type')=='Popup')
			{
				$l_sRepId = 'kolom2';
			} else {
				$l_sRepId = 'kolom3';
			}
		}
		if($this->procVars->get('RepId')){
			$l_sRepId = $this->procVars->get('RepId');
		}
	    if(strlen($this->procVars->get('webInput','ref')) > 0){	    	
	    	$l_sRepId = 'kolom3';
	    }
		if(!$l_sRepId){
			$l_sRepId = 'kolom3';
		}
		//logRegel( $l_sRepId ,__FILE__ . __LINE__);	
		// result voor http callback  
		$l_sViewResult1[0] = '  
		<?xml version="1.0" encoding="UTF-8"?>
		<return>
			<type>'	 . $l_sType 	. '</type>
			<file>'	 . $this->procVars->get('moduleInfo', 'Locatie') . '</file>
			<repid>' . $l_sRepId. '</repid>
			<delnodeid>' . $l_sDeleteNode 	. '</delnodeid>
			<htmldata> <![CDATA['. $l_sPageResult . ']]> </htmldata>
		</return>
		';
		return $l_sViewResult1;
	}

	function pageOpslaan(){
			$l_sDataHtml = 'Wijziging verwerkt';
		return $l_sDataHtml;
	}
}


?>