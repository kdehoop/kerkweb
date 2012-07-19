<?php 

// bepaal de locatie van de config files 
$l_sLocatieLinkFiles = $g_aModule['ContentLocatie'];

$l_scontentcel = 'kaldefault';
// bepaal welke links er zijn.
$l_AFiles	= $l_oReadDir->getFileNamesDirectory($l_sLocatieLinkFiles, $g_aModule['ContentFilter']);

$l_oString 	= new stringSys;

$outputItem = '

	<div class="linkblok"> <table class ="linktable">';

foreach ($l_AFiles as $val1){
	$l_xFile 	= file_get_contents($l_sLocatieLinkFiles.$val1 );
	
	if($val1 <> '.' && $val1 <> '..'){
		$l_xmlResult		= simplexml_load_file($l_sLocatieLinkFiles.$val1 );
		$l_sOnderwerp 		= $l_xmlResult->onderwerp;
		$l_dbeschrijving	= $l_xmlResult->beschrijving;
		$l_sdatum			= $l_xmlResult->datum; 
		$l_sextern			= $l_xmlResult->extern; 
		$l_sfile			= $l_xmlResult->file;

		// format tekst voor scherm
		$outputItem 		=  $outputItem . 
		'<tr>
        	<td></td> 
        	<td><h3>'. $l_sOnderwerp . ' </h3></td>
        </tr>
        <!--tr>
        	<td></td>
        	<td class = "' .$l_scontentcel . '" >'. $l_dbeschrijving . ' </td>
        </tr-->
        <tr>
        	<td></td>
        	<td class = "' .$l_scontentcel . '" ><a class="info"  href="' . $l_sLocatieLinkFiles . $l_sfile . '" >Open bestand</a> </td>
        </tr>
        <tr>
        	<td></td>
        	<td class = "' .$l_scontentcel . '" ><br/><hr/><br/> </td>
        </tr>
        ';	
	}	
}
$outputItem = $outputItem . '</table> </div>';
//logRegel($l_sDataHtml, 'gggggg');
//logRegel($l_sDataHtml, 'gggggg');
$l_sDataHtml 		= str_replace('{content1}' ,  $outputItem, $l_sDataHtml) ;
//logRegel($l_sDataHtml, 'gggggg');
?>
