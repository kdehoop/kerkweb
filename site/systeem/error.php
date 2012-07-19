<?php 
error_reporting(E_ALL);
	date_default_timezone_set('Europe/Amsterdam');
if ($g_bDebug=='Y'){
	$error = '<div class="error"> debug mode staat aan </div>';
	set_error_handler("myErrorHandler",-1);
	error_reporting(-1);
	//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);	
}

// error handler function
function myErrorHandler($errno, $errstr, $errfile, $errline)
{
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting
        return;
    }

    switch ($errno) {
    case E_USER_ERROR:
    /*    echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
        echo "  Fatal error on line $errline in file $errfile";
        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        echo "Aborting...<br />\n";*/
        exit(1);
        break;

    case E_USER_WARNING:
      /*  echo "<b>My WARNING</b> [$errno] $errstr<br />\n";*/
        break;

    case E_USER_NOTICE:
        /*echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";*/
        break;

    default:
        /*echo "Unknown error type: [$errno] $errstr<br />\n";*/
        break;
    }

    $date =  date("j F, Y, H:i ");
    $l_sLogMessag = '****************'. $date. chr(13).'ErrorNummer: '. $errno. chr(13). 'ErrorString: ' . $errstr. chr(13). 
    'InFile: ' .  $errfile. chr(13). 'RegelNummer: ' . $errline. chr(13);
	error_log("$l_sLogMessag", 3, "./log/systeem.txt");
    /* Don't execute PHP internal error handler */
    return true;
}


global $logFile;
global $fileopen; 

function logRegel($p_gLogtekst, $p_refTekst='') {
	$g_bDebug = 'Y';
	
	if (is_object($p_gLogtekst)){
		$logtekst = get_object_vars($p_gLogtekst) ;
	}
	
	$type = is_array($p_gLogtekst);
	
	
	if ($type == 'Array' ) {
	//	$logtekst 	= 	implode('|', $p_gLogtekst); 
	} else {
		$logtekst 	= 	$p_gLogtekst;
	}
	
	if ($type == 'Array' ) {
		$logtekst 	= 	print_r($p_gLogtekst, true); 
	} else {
		
		$logtekst 	= 	$p_gLogtekst;
	}
	
	//$logtekst = '<![CDATA[' .  $logtekst . ']]>';
	//$logtekst = str_replace('<', '&lt', $logtekst );
	//$logtekst = str_replace('>', '&gt', $logtekst );
	
	if($g_bDebug=='Y'){	
			$filename = './log/systeem.txt';
			$datumentijd 	= date("F j, Y, g:i a");
			$somecontent 	= '****************' . $datumentijd.'# '. $_SERVER['HTTP_HOST'] .'# ';
			$somecontent 	= $somecontent . $p_refTekst . '||' . $logtekst . '<br>';
			// Let's make sure the file exists and is writable first.
			
			if (is_writable($filename)) {
				// In our example we're opening $filename in append mode.
				// The file pointer is at the bottom of the file hence
				// that's where $somecontent will go when we fwrite() it.
				if (!$handle = fopen($filename, 'a')) {
					 echo "Cannot open file ($filename)";
					 $handle = fopen($filename, 'x+');
					 exit;
				}
	
				// Write $somecontent to our opened file.
				fseek($handle, 0);
				if (fwrite($handle, $somecontent."\r\n") === FALSE) {
				    echo "Cannot write to file ($filename)";
					exit;
				}
				// echo "Success, wrote ($somecontent) to file ($filename)";
				fclose($handle);
			} else {
				$handle = fopen($filename, 'x+');	
				echo "The file $filename is not writable";
			}
	}
	
}


?>
