<?php 

// bepaal de locatie van de config files 
$l_sLocatiePrekenFiles 	= $g_aModule['ContentLocatie'] ;
$l_lDropBox				= $g_aModule['DropBox'] ;

$l_scontentcel = 'kaldefault';
// bepaal welke preken er zijn.
$l_AFiles	= $l_oReadDir->getFileNamesDirectory($l_sLocatiePrekenFiles, 'preek');
$l_oString 	= new stringSys;

$outputItem = '

	<div class="preekblok"> <table class ="preektable">';

foreach ($l_AFiles as $val1){
	$l_xFile 	= file_get_contents($l_sLocatiePrekenFiles.$val1 );
	if($val1 <> '.' && $val1 <> '..'){
		$l_xmlResult		= simplexml_load_file($l_sLocatiePrekenFiles.$val1 );
		$l_sOnderwerp 		= $l_xmlResult->onderwerp;
		$l_dbeschrijving	= $l_xmlResult->beschrijving;
		$l_sdatum			= $l_xmlResult->datum; 
		$l_stijd			= $l_xmlResult->tijd;
		$l_sextern			= $l_xmlResult->extern; 
		$l_sfile			= $l_xmlResult->file;
        if($l_lDropBox<>'Ja') { 
			$l_sUrlMp3File = '<td class = "' .$l_scontentcel . '" ><embed type="application/x-shockwave-flash" flashvars="audioUrl=' . $l_sLocatiePrekenFiles . $l_sfile . '" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="400" height="27" quality="best"></embed> </td>';
        } else {	
        	$l_sUrlMp3File = '<td class = "' .$l_scontentcel . '" ><embed type="application/x-shockwave-flash" flashvars="audioUrl=' . $l_sfile . '" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="400" height="27" quality="best"></embed>  &#32 &#32 &#32 <a class="info" href="./site/systeem/downloadfile.php?file='. $l_sfile. '" >Download preek</a> </td>';
        }	
		// format tekst voor scherm
		$outputItem 		=  $outputItem . 
		'<tr>
        	<td class = "' .$l_scontentcel . '" >'. $l_sOnderwerp . ' </td>
        </tr>
        <tr>
        	<td class = "' .$l_scontentcel . '" >'. $l_dbeschrijving . ' </td>
        </tr>
        <tr>
        	<td class = "' .$l_scontentcel . '" >'. $l_sdatum . '   ' . $l_stijd . ' </td>
        </tr>
        <tr>' . $l_sUrlMp3File . '
        </tr>
        <tr>
        	<td class = "' .$l_scontentcel . '" ><br/><hr/><br/> </td>
        </tr>
        ';	
	}	
}
$outputItem = $outputItem . '</table> </div>';

$l_sDataHtml 		= str_replace('{content1}' ,  $outputItem, $l_sDataHtml) ;

?>
<!-- a class="info" href="artikel3.html" onclick="loadXMLDoc('./index.php?module=pagina&amp;content=preken.html'); return false ">Meer info ...</a -->