<?php 
	
			$html_Content = '
				<div id="container">
				<div id="heading"> <!-- the heading -->
				<h1>Anker kamp 2011</h1>
				</div>
				<div id="gallery"> <!-- this is the containing div for the images -->
			';
			//$folder = $this->procVars->get('webInput', 'album');
			$directory = './site/media/fotoalbum/'. 'Anker_kamp_2011' ;	//where the gallery images are located
			$allowed_types=array('jpg','jpeg','gif','png');	//allowed image types
			$file_parts=array();
			$ext='';
			$title='';
			$i=0;
				
			//try to open the directory scandir($p_sDirectoryPath);
			//$dir_handle = @opendir($directory) or die("Er is een probleem geconstateert bij het openen van de folder !");
			$dir_handle = @scandir($directory) or die("Er is een probleem geconstateert bij het openen van de folder !");
			//while ($file = readdir($dir_handle))	//traverse through the files
			//count($dir_handle);
			$teller = 0;	
			while (count($dir_handle)<>$teller++)	//traverse through the files
			{	$file = $dir_handle[$teller];
				logRegel( $file ,__FILE__ . __LINE__);
				if($file=='.' || $file == '..') continue;	//skip links to the current and parent directories
				$file_parts = explode('.',$file);	//split the file name and put each part in an array
				$ext = strtolower(array_pop($file_parts));	//the last element is the extension
				$title = implode('.',$file_parts);	//once the extension has been popped out, all that is left is the file name
				$title = htmlspecialchars($title);	//make the filename html-safe to prevent potential security issues
				$nomargin='';
				if(in_array($ext,$allowed_types))	//if the extension is an allowable type
				{
					if(($i+1)%4==0) $nomargin='nomargin';	//the last image on the row is assigned the CSS class "nomargin"
					$html_Content .= '
					<div class="pic '.$nomargin.'" style="background:url('.$directory.'/'.$file.') no-repeat 50% 50%;">
					<a href="'.$directory.'/'.$file.'" title="'.$title.'" target="_blank">'.$title.'</a>
					</div>';
					$i++;	//increment the image counter
				}
			}
			
			closedir($dir_handle);	//close the directory
			$html_Content .= '
				<div class="clear"></div> <!-- using clearfix -->
				</div>
				<div id="footer"> <!-- some tutorial info -->
				</div>
				</div> <!-- closing the container div -->
				<div id="messagenavigatie" >
					<a class="info" href="index.php" >
						<span class="tip">
					    	<span class="tooltip">Terug naar de voorpagina</span>
					    </span>
					</a>
				</div>
			';
		
?>		
