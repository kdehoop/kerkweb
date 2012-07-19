<?php
/*
 * file       : readconfig
 * doel       : lees de configuratie variable in van files in de folder configuratie
 * d.d.       : 23-12-2010
 * ver.       : 1
 * create by  : kdh
 * ticket     : 1 
 */
 
/*
 * Werking van de code.
 * Include_once file configmain
 * Bepaal welke files er nog meer beginnen met congfig.
 * Include deze files ook.
 * 
 */


// bepaal de locatie van de systeem classe files 
$l_sLocatieConfigFiles = './site/systeem';
// file functie class
include_once('file_cls.php');

// bepaal welke classe files er zijn en include deze
$l_oReadDir = new fileSys;
$l_AFiles   = $l_oReadDir->getFileNamesDirectory($l_sLocatieConfigFiles, '_cls');
for($i = 0; $i < sizeof($l_AFiles); $i++){	
	if($l_AFiles[$i]<>'classeopen.php'){
		include_once($l_AFiles[$i]);
	}
}


?>