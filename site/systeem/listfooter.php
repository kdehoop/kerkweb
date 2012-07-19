<?php 

// bepaal de locatie van de config files 
$l_sLocatieLinkFiles = $g_aModule['ContentLocatie'];
$l_scontentcel = 'kaldefault';
// bepaal welke links er zijn.
$l_AFiles	= $l_oReadDir->getFileNamesDirectory($l_sLocatieLinkFiles, 'footer');
$l_oString 	= new stringSys;
$l_nLastPos = 1;
$outputItem	= '';
$outputItem .= '<ul id="footerkolom1">';

foreach ($l_AFiles as $val1){
	$l_npositie = 0;
	$l_xFile 	= file_get_contents($l_sLocatieLinkFiles.$val1 );

	if($val1 <> '.' && $val1 <> '..'){
		$l_xmlResult		= simplexml_load_file($l_sLocatieLinkFiles.$val1 );
		$l_sdisplaytekst	= trim($l_xmlResult->displaytekst);
		$l_surl				= trim($l_xmlResult->url);
		$l_npositie			= trim($l_xmlResult->positie);
		$l_npositie = trim($l_npositie);
		$l_alist[] = array("positie"=>$l_npositie, "url"=>$l_surl, "tekst"=>$l_sdisplaytekst);
	}	
}
asort($l_alist);
foreach ($l_alist as $val1){
	if($val1['positie']<>$l_nLastPos){
			$outputItem .= '</ul><ul id="footerkolom'.$val1['positie'].'">';
		}
	$outputItem	.= '<li><a class="footerlist" target="_blank" href="' . $val1['url'] . '">' . $val1['tekst'] . '</a></li>';
	$l_nLastPos = $val1['positie'];
}
$outputItem = $outputItem . '</ul>';

?>
