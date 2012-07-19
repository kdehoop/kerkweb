<?php

class startAdmin {

	function getHomePagelistStruc($p_aMultiPage) {
		asort($p_aMultiPage);
		$l_sContentTotaalValue = '';
		foreach ($p_aMultiPage as $key1 => $val1){
			$l_sLokatie 			= $val1['Locatie'];
			$l_sLokatie 			= substr(strrchr($l_sLokatie, "/"), 1);
			$l_sType 				= $val1['Type'];
			$l_sPositie 			= $val1['Positie'];
			$l_sOrder 				= $val1['Order'];
			$l_sMenuText			= $val1['menutekst'];			
			$l_sContentTotaalValue	= $l_sContentTotaalValue . '<li><a  class="ui-state-default" href="' . $l_sLokatie. '" onclick="loadXMLDoc' . "('./login.php?content=" . $l_sLokatie . "&menuloc=1'); return false " . '">' . $l_sMenuText . '</a></li> ';
		}
		
		return $l_sContentTotaalValue;
	}  
}

?>