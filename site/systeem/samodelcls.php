<?php 

class model {
	function __construct() {
		//$this->procVars = procVar::getInstance();
		//$this->sysFunc 			= sysFun::getInstance();
	}
	
	function ContToken($p_TagCode) {
		if($p_TagCode=="meerinfo"){
			$l_sContent 	= $this->procVars->get('ConfModul', 'Locatie');
			$l_sType		= $this->procVars->get('ConfModul', 'Type');
			$stringNa 		= '<a class="info" href="'.$l_sContent.'" onclick="loadXMLDoc('. "'./index.php?page=" . $this->procVars->get('ConfModul', 'Locatie') . "&methode=viewContent'); return false". '">Meer info ...</a>';
			return $stringNa;
		}
	}
	
	function TokenReplace($p_sContent){
		if(strpos($p_sContent, '{|' )){
			while(strpos($p_sContent, '{|' )){
				$l_sBegin 		= strpos($p_sContent, '{|' )+2;
				$l_sEinde 		= strpos($p_sContent, '|}' );
				$l_sLengte 		= $l_sEinde - $l_sBegin;
				$l_sTokenCode	= substr($p_sContent, $l_sBegin, $l_sLengte);
				$l_sTokenCont	= $this->ContToken($l_sTokenCode);
				$l_sReplToken	= '{|' . $l_sTokenCode . '|}';
				$p_sContent 	= str_replace($l_sReplToken, $l_sTokenCont, $p_sContent);
			}
		}
		return $p_sContent;
	}
    
     /**
     *  Haal de configfile op
     */
    function getConfFile($p_sPagina) {
      $l_sFileInfo = pathinfo($p_sPagina);
      $l_sFile = $l_sFileInfo['filename'] . '.php';
      if (strlen($l_sFile) > 4) {
        $this->procVars->set('ConfFile', $l_sFile);
        return $l_sFile;
      }
    }
    
    function viewblok($p_page) {
      $l_pagina   = pathinfo($p_page,PATHINFO_FILENAME).'.html';
      $l_sContLok = $this->procVars->get('htmlpath') . $l_pagina;
      $l_sContent = file_get_contents($l_sContLok);
      $l_sBegin   = strpos($l_sContent, '<div id="koptekst">');
      $l_sEinde   = strpos($l_sContent, '<div id="tekst');
      $l_sLengte  = $l_sEinde - $l_sBegin;
      $l_sContValue = substr($l_sContent, $l_sBegin, $l_sLengte);
      /* find all {| in file */
      return $l_sContValue;
    }
	
    /**
     *
     * @param file locatie $pfilename Path plus filenaam met ini file
     * @param filenaam $pInfoRequest functie result filenaam geeft nieuwe filenaam met volgnummer
     * @return filenaam format yyyymmdd
     */
    function openxmlfile($pfilename, $pInfoRequest){
        $xmlResult      = simplexml_load_file($pfilename);
        if($pInfoRequest=='filenaam'){
          $filenummer   = $xmlResult->filenummer+1;
          $xmlResult->filenummer = $filenummer;
          $l_sContentFile = $xmlResult->asXML();
          file_put_contents($pfilename, $l_sContentFile);
          $date         = date('Ymd');
          return $date.'_'.$filenummer.'.xml';
        }
    }
    
    function insertxmlactiviteit($pNieuwFile,$pStartDate,$pEinddate){
      
    }
}

?>