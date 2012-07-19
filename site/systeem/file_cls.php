<?php

class fileSys {

  
  
  /*
   * Functie getFileNamesDirectory
   * parameter 1 geeft het path aan naar de directory.
   * parameter 2 geeft de selectie string aan. Deze selectiestring dient een deel van de file naam te zijn
   * output is een array met de gevonden file namen in de directory van parameter 1
   *  
   */  
  function getFileNamesDirectory($p_sDirectoryPath, $p_sFilter) {
    $l_aFiles = scandir($p_sDirectoryPath);
    if($p_sFilter){
	    for($i = 0; $i < sizeof($l_aFiles); $i++){	
	      if (strstr($l_aFiles[$i], $p_sFilter)<> FALSE){
	        $l_aFileList[] = $l_aFiles[$i];
	      }
	    }
    } else {
    	$l_aFileList = $l_aFiles;
    }
    return $l_aFileList;
  } 
}

?>