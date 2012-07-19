<?php 
//logRegel($_REQUEST , 'input');
	date_default_timezone_set('Europe/Amsterdam');	
	$l_sContent		= '';
	$l_sDataHtml	= '';
	if(isset($_REQUEST['content'])){	
		$p_sContent 	= trim(strip_tags($_REQUEST['content']));
	} else {
		$p_sContent = '';
	}
	$l_sCont		= '';
	// eerste keer aanvraag homepagina set variable
	logRegel($_REQUEST);
	if ($p_sContent == '' ) {
		$p_sContent2 	= 'frontpagina.html';
		$l_sInstelling 	= substr($p_sContent, 0, strrpos($p_sContent2, '.')) . '.php';
		$l_sPathContIni = './site/paginainstellingen/' . substr($p_sContent2, 0, strrpos($p_sContent2, '.')) . '.php';	
		
	} else {	
		$l_nstartfile = strripos($p_sContent, '/')+1;
		if($l_nstartfile==1){
			$l_nstartfile= 0;
		}
		//logRegel($p_sContent, 'module');
		$l_ndotinfile = strrpos($p_sContent, '.')-$l_nstartfile;
		$l_sInstelling 	= substr($p_sContent, $l_nstartfile, $l_ndotinfile) . '.php';
		$l_sPathContIni = './site/paginainstellingen/' . substr($p_sContent,$l_nstartfile, $l_ndotinfile) . '.php';	
		
	}
	
	$l_oStart	= new start;
	
	include("$l_sPathContIni");
	// serializen dient hier te gebeuren voor $g_aModule en voor $g_aMultiPages

	if($g_sModule){
		$g_aMultiPage = unserialize($g_sMultiPage) ;
		$g_aModule    = unserialize($g_sModule) ;
	}
	//logRegel( $g_aMultiPage  ,__FILE__ . __LINE__);
	
	
	$l_sPaginaLokatie = $g_aModule['Locatie'];	
	//bepaal pagina sjabloon
	$l_sPathContSjb = './site/sjabloon/' . $g_aModule['sjabloon'] . '.php';	
	//logRegel( $g_aModule['menutekst']  ,__FILE__ . __LINE__);
	
	switch ($g_aModule['Type']){
		case 'Page': // 1 kolom voor de hele pagina
			$l_sContentPagina 	= file_get_contents($l_sPathContSjb);	
			//logRegel( $l_sPathContSjb ,__FILE__ . __LINE__);
			$l_sDataHtml 		= str_replace('{content}', file_get_contents($g_aModule['Locatie']), $l_sContentPagina) ;
			$l_sBegin 			= strpos($l_sDataHtml, '<a class="info"' );
			$l_sEinde 			= strpos($l_sDataHtml, '</a>' );
			$l_sLengte 			= $l_sEinde - $l_sBegin;
			$l_sDataHtml 		= substr_replace($l_sDataHtml, '', $l_sBegin, $l_sLengte );
			Break;
			
		case 'Popup':

			$p_sFileId 		= trim(strip_tags($_REQUEST['id']));	
			$l_sDataHtml 	= file_get_contents($l_sPathContSjb);
				
			$l_xmlResult	= simplexml_load_file($g_aModule['ContentLocatie'].$p_sFileId);	
//logRegel( $l_xmlResult.'##' .  sDataHtml ,__FILE__ . __LINE__);
			foreach ($l_xmlResult->children() as $child)
			{
			   	$l_xTag = $child->getName();
			   	$l_xInh = $l_xmlResult->$l_xTag;
			   	$l_cont = '{'.$l_xTag.'}';
                if($l_xTag=='beschrijving'){
                  $l_xInh = stripslashes(stripslashes($l_xInh));
                }
                if($l_xTag=='begindatum'){
                  $l_xInh = substr(trim($l_xInh), 0, 4). '-' . substr(trim($l_xInh), 4, 2) . '-' . substr(trim($l_xInh), 6, 4);
                } 
			 	$l_sDataHtml = str_replace($l_cont, $l_xInh , $l_sDataHtml);
			}
			Break;
			
		case 'Multi1Page':
//logRegel( $g_aMultiPage  ,__FILE__ . __LINE__);
			sort($g_aMultiPage);
				foreach ($g_aMultiPage as $key1 => $val1){
					$l_sLokatie 		= $val1['Locatie'];
					$l_sType 			= $val1['Type'];
					$l_sPositie 		= $val1['Positie'];
					$l_sOrder 			= $val1['Order'];
					$l_sOnderwerp 		= $val1['menutekst'];
//logRegel( $l_sLokatie  ,__FILE__ . __LINE__);
					if($l_sLokatie) {
						
						// module output genereren	
						if($l_sType == 'Insert'){							
						$l_aPaginaIni = $l_oStart->getPageIni($l_sLokatie);
							include($l_aPaginaIni['Locatie']);
							if($g_sMultiPage){
								$g_aMultiPage = unserialize($g_sMultiPage) ;
								$g_aModule    = unserialize($g_sModule) ;
							}
							$l_sContentValue =  $outputItem;
						} else {
							// bepaal de koptekst
							$l_sArtikelContent	= file_get_contents($l_sLokatie);
                            $l_sArtikelContent  = stripcslashes($l_sArtikelContent);
                            
							if($l_sType ==  'Page'|| $l_sType ==  'Multi1Page'){
									$orgdoc1	= new DOMDocument();			
									$orgdoc1->loadHTML($l_sArtikelContent);
									$l_sModHtml	= $orgdoc1->saveHTML();	
									$orgdoc		= new DOMDocument();
									$orgdoc->loadHTML($l_sModHtml);
									$koptekst 	= stripslashes($orgdoc->getElementById("koptekst")->nodeValue);
									$onderwerp 	= stripslashes($orgdoc->getElementById("onderwerp")->nodeValue);
									$tekst 		= stripslashes($orgdoc->getElementById("tekst")->nodeValue);							
								$l_sBegin 			= strpos($l_sArtikelContent, '<div id="koptekst">' );
								$l_sEinde 			= strpos($l_sArtikelContent, '<div id="tekst' );
								$l_sLengte 			= $l_sEinde - $l_sBegin;
								$l_sContentValue1 	= substr($l_sArtikelContent, $l_sBegin, $l_sLengte);
								$PageName       = pathinfo($l_sLokatie);
								$PageNameEx     = $PageName['filename']. '.' .$PageName['extension'];
								$l_sReplaceStr  = './index.php?content='.$PageNameEx;
								if(strlen($tekst)==0){
									$l_sReplaceStr = '"">' ;
									$l_sContentValue1 = str_replace( 'return false ">Meer info ...', $l_sReplaceStr, $l_sContentValue1 );
									$l_sReplaceStr ='';
									$l_sContentValue = str_replace( 'class="info"', $l_sReplaceStr, $l_sContentValue1 );
								} else {
									$l_sContentValue = str_replace( './index.php?content', $l_sReplaceStr, $l_sContentValue1 );
								}
								
							} else {
						
								$l_sContentValue 	= $l_sArtikelContent;
							}
						}				
						// voeg blokken samen
						
						$l_sContent	= 'l_sContent'. $l_sPositie;
						
						if(isset($$l_sContent)){ 
						
							$$l_sContent = $$l_sContent . $l_sContentValue;
						} else {
							$$l_sContent = $l_sContentValue;
						}	
					}		
				}
							 
				$l_sContentSjabloon	= file_get_contents($l_sPathContSjb);
                $l_sContentSjabloon = stripcslashes($l_sContentSjabloon);
				if ($p_sContent == '' ) {
							
					$l_sDataHtml = file_get_contents($g_aModule['Locatie']);
					$l_sDataHtml = stripcslashes($l_sDataHtml);
					// Deze is er altijd.
					$content 	 = '{content}';
					
					$l_sDataHtml = str_replace($content,  $l_sContentSjabloon, $l_sDataHtml) ;
				/*	$content 	 = '{footer}';
					$l_sLokatie	 = './site/sjabloon/footer.php';	
					$l_sFooterContent	= file_get_contents($l_sLokatie);
					$l_sDataHtml = str_replace($content,  $l_sFooterContent, $l_sDataHtml) ;*/
					
				}else{					
					/* start pagina */
					$l_sDataHtml 		= $l_sContentSjabloon;
				}	
				
				$l_lCheck 	 = true;
					$l_nteller 	 = 1;	
				
					if(strpos($l_sDataHtml, '{content0}' )){
						$l_sContentKop 		= file_get_contents($l_sPaginaLokatie);
                        $l_sContentKop      = stripcslashes($l_sContentKop);        
//						logRegel( $l_sContentKop  ,__FILE__ . __LINE__);
						$l_sBegin 			= strpos($l_sContentKop, '<h1 id="onderwerp">' );
						$l_sEinde 			= strpos($l_sContentKop, '<a class="info" href' );
						$l_sLengte 			= $l_sEinde - $l_sBegin;
						$l_sContentValue1 	= substr($l_sContentKop, 0, $l_sEinde);
//						logRegel( $l_sEinde  ,__FILE__ . __LINE__);
						$l_sDataHtml        = str_replace('{content0}',  $l_sContentValue1 , $l_sDataHtml);
	
					}
					// Bepaal de content markers in de pagina
					while ($l_lCheck == true) {
						$l_sZoeknaar 		= '{content' .$l_nteller. '}';
						$$l_sCont 			= 'l_sContent' . $l_nteller;
						$l_sContResult 		= $$l_sCont;	
						
						if (strpos($l_sDataHtml, $l_sZoeknaar)) {
//							logRegel( $l_sZoeknaar .'##' . $$l_sContResult  ,__FILE__ . __LINE__);
							$l_sDataHtml	= str_replace($l_sZoeknaar,  $$l_sContResult, $l_sDataHtml) ;
						} else {
							$l_lCheck 		= false;
						}
						$l_nteller++;
						if($l_nteller== 13) {
							$l_lCheck 		= false;
						}
					}

					// Bepaal de footer content
					$l_sPathContIni = './site/paginainstellingen/footer.php';
					$l_sPathFooter	= './site/systeem/listfooter.php';
					include("$l_sPathContIni");
					include("$l_sPathFooter");
					$l_sZoeknaar = '{footer}' ;
					$l_sDataHtml = str_replace($l_sZoeknaar, $outputItem, $l_sDataHtml);
					
			Break;
		case 'FotoAlbum':
//	logRegel( $g_aModule['menutekst']  ,__FILE__ . __LINE__);
//	logRegel( $g_aModule['Type'] ,__FILE__ . __LINE__);
			if( $g_aModule['menutekst']=='Fotoalbum Mzzl'){
//				logRegel( $g_aModule['menutekst']  ,__FILE__ . __LINE__);
				include("./site/systeem/fotoalbum3.php");
			}else{		
				if( $g_aModule['menutekst']=='Fotoalbum Anker kamp'){
//					logRegel( $g_aModule['menutekst']  ,__FILE__ . __LINE__);
					include("./site/systeem/fotoalbum2.php");
				} else {
//					logRegel( $g_aModule['menutekst']  ,__FILE__ . __LINE__);
					include("./site/systeem/fotoalbum.php");
				}	
			}
				$l_sDataHtml = $html_Content;
			Break;
		default:
			if($p_sContent=='email.php'){
			}else{
			   echo 'error';	
			}
	}
if($g_aModule['naactie']){
	$actie = $g_aModule['naactie'];
		include("$actie");
}
if($p_sContent=='addActiviteit.html'||$p_sContent=='addActiviteit.php'){
  include('./site/systeem/kalender.php');
    $l_sDataHtml  =  $l_HtmlResult;      
	$p_sContent   = '';
}  
if($p_sContent=='email.php') {
		include('./site/systeem/email.php');
		$p_sContent = '';
	}
// geef de content terug
    $l_sDataHtml = htmlspecialchars_decode($l_sDataHtml);
	if ($p_sContent <> '' ) {
		$g_hReturn = '  
		<?xml version="1.0" encoding="UTF-8"?>
		<return>
			<type>'	 . $g_aModule['Type'] 	. '</type>
			<file>'	 . $p_sContent   		. '</file>
			<repid>' . $g_aModule['RepId'] 	. '</repid>
			<htmldata> <![CDATA['. $l_sDataHtml . ']]> </htmldata>
		</return>
		';
		echo $g_hReturn ;
	} else {
		echo $l_sDataHtml ;
	}
?>


