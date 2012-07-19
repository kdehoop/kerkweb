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

$num = 0;
foreach ($l_AFiles as $val1){
	$num++;
   if($val1 <> '.' && $val1 <> '..'){
		$l_xmlResult	= simplexml_load_file( $l_sLocatiePrekenFiles.$val1 );
		$l_xmlResult		= simplexml_load_file($l_sLocatiePrekenFiles.$val1 );
		$l_sOnderwerp 		= $l_xmlResult->onderwerp;
		$l_dbeschrijving	= $l_xmlResult->beschrijving;
		$l_sdatum			= $l_xmlResult->datum; 
		$l_stijd			= $l_xmlResult->tijd;
		$l_sextern			= $l_xmlResult->extern; 
		$l_sfile			= $l_xmlResult->file;
        
        $dispDate		= substr($l_sdatum, 6,  4) . substr($l_sdatum, 3,  2) . substr($l_sdatum, 0,  2);

      $aactieLijst[]  = array("soortdatum"=>trim($dispDate.''), "onderwerp"=>trim($l_sOnderwerp.''), "beschrijving"=>trim($l_dbeschrijving.''), "datum"=>trim($l_sdatum.''), "tijd"=>trim($l_stijd.''), "file"=>trim($l_sfile.'')); 
           
	}	
}
foreach ($aactieLijst as $key => $row) {
    $datum2[$key]  = $row['soortdatum'];
    $tijd2[$key]   = $row['tijd'];
}
array_multisort($datum2, SORT_DESC, $tijd2, SORT_DESC  ,$aactieLijst) ;

 foreach ($aactieLijst as $key => $value) {
    $l_sOnderwerp     = stripslashes($value['onderwerp']);
    $l_sbeschrijving  = stripslashes($value['beschrijving']);
    $l_dDatum         = $value['datum'];
    $l_stijd          = $value['tijd'];
    $l_sFile          = $value['file'];
    $l_sDatumSort     = $value['soortdatum'];
    
    if($l_lDropBox<>"Ja") { 
      $l_sUrlMp3File = '<td class = "' .$l_scontentcel . '" ><embed type="application/x-shockwave-flash" flashvars="audioUrl=' . $l_sLocatiePrekenFiles . $l_sFile . '" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="400" height="27" quality="best"></embed> </td>';
    } else {	
    $l_sUrlMp3File = '<td class = "' .$l_scontentcel . '" ><embed type="application/x-shockwave-flash" flashvars="audioUrl=' . $l_sFile . '" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="400" height="27" quality="best"></embed>  &#32 &#32 &#32 <a class="info" href="./site/systeem/downloadfile.php?file='. $l_sFile. '" >Download preek</a> </td>';
    }	
    // format tekst voor scherm
		$outputItem 		=  $outputItem . 
		'<tr>
        	<td class = "' .$l_scontentcel . '" >'. $l_sOnderwerp . ' </td>
        </tr>
        <tr>
        	<td class = "' .$l_scontentcel . '" >'. $l_sbeschrijving . ' </td>
        </tr>
        <tr>
        	<td class = "' .$l_scontentcel . '" >'. $l_dDatum . '    ' . $l_stijd . ' </td>
        </tr>
        <tr>' . $l_sUrlMp3File . '
        </tr>
        <tr>
        	<td class = "' .$l_scontentcel . '" ><br/><hr/><br/> </td>
        </tr>
        ';	
    
 }
$outputItem = $outputItem . '</table> </div>';         
$l_sDataHtml 		= str_replace('{content1}' ,  $outputItem, $l_sDataHtml) ;          
          
?>
