<?php

class start {

	function getPageIni($p_sLokatie) {
		$l_sPageInstelling = './site/paginainstellingen/' . substr($p_sLokatie, 7, strrpos($p_sLokatie, '.'));
		//logRegel( $l_sPageInstelling  ,__FILE__ . __LINE__);
		include("$l_sPageInstelling");
        
		if(isset($g_sModule)){
			//$g_aMultiPage = unserialize($g_sMultiPage) ;
			$g_aModule    = unserialize($g_sModule) ;
			if(!$g_aModule){
				$g_aModule 	  = unserialize($g_sMenu) ;
			}
		}
		return $g_aModule;
	}  
	
	function getPageIniMenu($p_sLokatie) {
		$l_sPageInstelling = './site/paginainstellingen/' . substr($p_sLokatie, 7, strrpos($p_sLokatie, '.'));
		include("$l_sPageInstelling");
		if($g_sModule){
			$g_aMenu = unserialize($g_sMenu) ;
			$g_aModule    = unserialize($g_sModule) ;
		}
		return $g_aMenu;
	}
}

?>