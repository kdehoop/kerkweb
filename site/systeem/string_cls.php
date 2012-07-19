<?php 
/*
 *  class stringSys
 *  string bewerkingen die regelmatig terug komen in het systeem
 */

class stringSys {
	/*
	 *  functie get_xmlstring
	 *  @begin is eerste string 
 	*/	
	function get_xmlstring($p_begin, $p_einde, $p_string) {
		$l_nLengteBegin		= strlen ($p_begin);
		$l_sBegin 			= strpos($p_string, $p_begin )+$l_nLengteBegin;
		$l_sEinde 			= strpos($p_string, $p_einde );
		$l_sLengte 			= $l_sEinde - $l_sBegin;
		$l_sString		 	= trim(substr($p_string, $l_sBegin, $l_sLengte));
		return $l_sString;
	}
	
}
?>
