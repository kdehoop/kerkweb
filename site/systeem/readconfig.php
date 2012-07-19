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


// bepaal de locatie van de config files 
$l_sLocatieConfigFiles = './site/configuratie/';

// bepaal welke configfiles er zijn en include deze.

$l_oReadDir = new fileSys;
$l_AFiles   = $l_oReadDir->getFileNamesDirectory($l_sLocatieConfigFiles, 'config');
for($i = 0; $i < sizeof($l_AFiles); $i++){	
	include_once($l_sLocatieConfigFiles.$l_AFiles[$i]);
}


?>