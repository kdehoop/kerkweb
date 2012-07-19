<?php

class view {

  function __construct() {
   // $this->procVars = procVar::getInstance();
   // $this->sysFunc = sysFun::getInstance();
  }

  /*
   * Laatste stap voor het displayen van een blok door de controller
   */

  function formatView($p_HtmlContent) {
    $l_sViewResult = str_replace('index.php', 'admin.php', $p_HtmlContent);
    $l_sReplaceOnd = 'onderwerp_' . $this->procVars->get('blokcount');
    $l_sViewResult = str_replace('onderwerp', $l_sReplaceOnd, $l_sViewResult);
    $l_sReplaceOnd = 'koptekst_' . $this->procVars->get('blokcount');
    $l_sViewResult = str_replace('koptekst', $l_sReplaceOnd, $l_sViewResult);
    return $l_sViewResult;
  }

  /*
   * Kader om blokken heen
   */

  function addAdminKader($p_ContentHtml, $p_sUrl, $p_NavBut='11111111') {
   // logRegel($p_sUrl  ,__FILE__ . __LINE__);
    $l_nBlokId = $this->procVars->get('blokcount');
    $this->urlRest      = $p_sUrl . '&blokid=' . 'admincontent_' . $l_nBlokId;
    $this->l_sScreenId  = 'sortord_' . $l_nBlokId . ' value=' . $this->procVars->get('pagefilenaam');
    $p_NavBut           = $this->insertNavBlok($p_NavBut, $l_nBlokId);
    $l_sHtmlReturn      = '<li id="' . $this->l_sScreenId .'"> 
                              <div  id="adminmodule_' . $l_nBlokId . '">
								<table class ="adminmodule">
									<tr>
										<td>' . $this->knop1 . '</td>
							   			<td>' . $this->knop2 . '</td>
										<td>' . $this->knop3 . '</td>
										<td>' . $this->knop4 . '</td>
									</tr>
								</table>
						   <div class="admincontent"  id="admincontent_' . $l_nBlokId . '">';
    $l_sHtmlReturn = $l_sHtmlReturn . $p_ContentHtml . '</div> </li> ';
    return $l_sHtmlReturn;
  }

  /*
   * blokbar knoppen aan of uit
   */

  function insertNavBlok($p_kopStatus, $p_nBlokId) {
    if (empty($p_kopStatus)) {
      $l_skopStatus = '111111';
    } else {
      $l_skopStatus = $p_kopStatus;
    }

    if (substr($l_skopStatus, 0, 1) == 1) {
      $this->knop1 = '<a id="editblok_' . $p_nBlokId . '" class="wijzigcontent"  href="#" onclick="loadRemContent(' . "'" . $this->urlRest . '&methode=editcontent' . "'" . ', this.id)">
   								<span>Wijzig de inhoud van het blok</span> 
   								<img alt="Wijzig tekst"  src="./saadmin/css/icons/paper_content_pencil_48.png" style="width: 25px; height: 25px;"  />
   					  		</a>';
    } else {
      $this->knop1 = '';
    }
    if (substr($l_skopStatus, 1, 1) == 1) {
      $this->knop2 = '<a id="delblok_' . $p_nBlokId . '" class="wijzigcontent"  href="#" onclick="loadRemContent(' . "'" . $this->urlRest . '&methode=deletcontent&module=' . $this->procVars->get('pagetype') . '&delpage=' . $this->l_sScreenId . "'" . ', this.id)">
			   					<span>Delete het blok</span> 
			   					<img src="./saadmin/css/icons/cancel_48.png" style="width: 25px; height: 25px;"  />
			   				</a>';
    } else {
      $this->knop2 = '';
    }
    if (substr($l_skopStatus, 2, 1) == 1) {
      $this->knop3 = '<a id="instBlok_' . $p_nBlokId . '" class="wijzigcontent"  href="#" onclick="loadRemContent("", this.id)">
			   					<span>Instellingen van het blok</span> 
			   					<img src="./saadmin/css/icons/spanner_48.png" style="width: 25px; height: 25px;"  />
			   				</a>';
    } else {
      $this->knop3 = '';
    }
    if (substr($l_skopStatus, 3, 1) == 1) {
      $dropId = 'blokinsert_' . $p_nBlokId;
      $this->knop4 = '<select id="' . $dropId . '" onChange="insertActie(' . "'" . $dropId . "'" . ')">
						   	  <option value="">Voeg een nieuw blok toe</option>
							  <option value="artikel">Voeg artikel toe</option>
                              <option value="Multi1Page">Voeg groepspagina toe</option>
                              <option value="preek">Voeg preek pagina toe</option>
                              <option value="fotoalbum">Voeg fotoalbum toe</option>
							  <option value="BlokMenu">Voeg menublok toe</option>
							  <option value="Popup">Voeg aktiviteitenblok toe</option>
							  <option value="listpage">Voeg document lijst toe</option>
							  <option value="test">Voeg email pagina toe</option>
							  <option value="test">Voeg contact pagina toe</option>
							  <option value="test">Voeg blog toe</option>
							  <option value="test">Voeg kalender toe</option>
							  <option value="test">Voeg advertentie toe</option>
							  <option value="test">Voeg profiel pagina toe</option>
						   </select>';
    } else {
      $this->knop4 = '';
    }
  }

  /**
   * methode voor het vinden van markers binnen een html sjabloon/pagina en deze te vervagen door methode ContToken
   */
  function MarkerReplace($p_sContent) {
    if (strpos($p_sContent, '{|')) {
      while (strpos($p_sContent, '{|')) {
        $l_sBegin = strpos($p_sContent, '{|') + 2;
        $l_sEinde = strpos($p_sContent, '|}');
        $l_sLengte = $l_sEinde - $l_sBegin;
        $l_sTokenCode = substr($p_sContent, $l_sBegin, $l_sLengte);
        $l_sTokenCont = $this->ContMarker($l_sTokenCode);
        $l_sReplToken = '{|' . $l_sTokenCode . '|}';
        $p_sContent = str_replace($l_sReplToken, $l_sTokenCont, $p_sContent);
      }
    }
    return $p_sContent;
  }

  function MultiContent($p_aLocatie) {
    $l_sPathContIni = $this->sysFunc->readConf($p_aLocatie);
    $l_aPaginaInfo = $this->sysFunc->seriConfFrom($l_sPathContIni);
    $l_sModuleType = $this->procVars->get('ConfModul', 'Type') . 'Model';
    $l_sViewType = $this->procVars->get('ConfModul', 'Type') . 'View';
    $l_oModelClass = new $l_sModuleType();
    $l_sModelResult = $l_oModelClass->view();
    $l_oViewClass = new $l_sViewType();
    $l_sViewResult = $l_oViewClass->view($l_sModelResult);
    //logRegel($l_sViewResult,__FILE__ . __LINE__);
    return $l_sViewResult;
  }

  /**
   *
   */
  function InSjabloon($p_sHtmlReturn, $p_sContentMarker, $p_sHtmlInsert) {
    if (strlen($p_sHtmlInsert) == 0) {
      $l_sPathContSjb = $this->procVars->get('sjabpath') . $this->procVars->get('ConfModul', 'sjabloon') . '.php';
      $p_sHtmlInsert = file_get_contents($l_sPathContSjb);
    }
    $l_sDataHtml = str_replace($p_sContentMarker, $p_sHtmlReturn, $p_sHtmlInsert);
    $l_sDataHtml = str_replace('index.php', 'admin.php', $l_sDataHtml);
    return $l_sDataHtml;
  }

  function AjaxReturn($p_sViewResult, $p_sMessagetype=NULL, $pNodeId=Null) {
    $g_hReturn = '<?xml version="1.0" encoding="UTF-8"?>
		<return>
			<type>' . ''. '</type>
			<repid>' . '' . '</repid>
			<htmldata> <![CDATA[' . $p_sViewResult . ']]> </htmldata>
			<insnodeid>' . $pNodeId . '</insnodeid>
            <messagetype>' . $p_sMessagetype . '</messagetype>
		</return>
		';
    // logRegel($g_hReturn  ,__FILE__ . __LINE__);
    return $g_hReturn;
  }

  function NavTerugHomePage() {

    $l_sHtmlNavigatie = '
			<div id="messagenavigatie" >
					<a class="info" href="admin.php" >
						<span class="tip">
					    	<span class="tooltip">Terug naar de voorpagina</span>
					    </span>
					</a>
				</div>
			';
    return $l_sHtmlNavigatie;
  }

  /**
   * voeg sjaboon en pagina samen
   */
  function SjabloonToPage($p_sjabloon, $p_page, $p_module) {
    $l_sDataHtml = str_replace('{|content|}', $p_page, $p_sjabloon);
    $l_sDataHtml = str_replace('index.php', 'admin.php', $l_sDataHtml);
    return $l_sDataHtml;
  }
    
  function paginaNavigatie($l_sContent, $p_module) {
    $stringNa = '<a class="info" href="' . $l_sContent . '" onclick="loadXMLDoc(' . "'" . './admin.php' . "?page=" . $l_sContent . "&module=" . $p_module . "&methode=viewContent'); return false" . '">Meer info ...</a><br/><br/>';
    return $stringNa;

  }
  
  function backToHomeNavigatie() {
    $stringNa = '<a class="info" href="index.php" >
			<span class="tip">
		    	<span class="tooltip">Terug naar de voorpagina</span>
		    </span>
		</a>';
    return $stringNa;

  }

  function matchSjabloon($p_aViewBuffer, $p_sSjabloon) {
    $aantalInArray = count($p_aViewBuffer);
    $teller = 0;
    $posTeller = 1;
    $posNa = $p_aViewBuffer[$teller]['positie'];
    $htmlBuffer = '';
    $positie = 'content_' . $posTeller;
    //logRegel($teller  . '@@' .$aantalInArray,__FILE__ . __LINE__);
    while ($teller <> $aantalInArray) {
      $posVoor = $p_aViewBuffer[$teller]['positie'];
      if (trim($posNa) <> trim($posVoor)) {
        $abuffer[$positie] = $htmlBuffer;
        $htmlBuffer = '';
        $posTeller++;
        $positie = 'content_' . $posTeller;
        $htmlBuffer .= $p_aViewBuffer[$teller]['result'];
      } else {
        $htmlBuffer .= $p_aViewBuffer[$teller]['result'];
      }
      $posNa = $p_aViewBuffer[$teller]['positie'];
      $teller++;
    }
    $abuffer[$positie] = $htmlBuffer;

    $p_sHtmlInsert = file_get_contents('./site/sjabloon/blok2pagina.php');
    $teller = 0;
    while ($posTeller <> $teller) {
      $contel = $teller + 1;
      $positieA = 'content_' . $contel;
      $test = '{|' . $positieA . '|}';
      $p_sHtmlInsert = str_replace($test, $abuffer[$positieA], $p_sHtmlInsert);
      $teller++;
    }
    //$l_sFileNaam = pathinfo($this->procVars->get('pageLocatie'), PATHINFO_BASENAME) ;
    //$l_sFileNaam = $this->procVars->get('page');
    $l_sFileNaam = 'addActiviteit.html';
    //logRegel( $l_sFileNaam,__FILE__ . __LINE__);
    $p_sHtmlInsert = str_replace('{|paginanaam|}', $l_sFileNaam, $p_sHtmlInsert);
    $p_sHtmlInsert = str_replace('{|backToHomeNavigatie|}', $this->NavTerugHomePage(), $p_sHtmlInsert);
    if($_REQUEST['methode']=='viewNotAuth'){
      $p_sHtmlInsert = str_replace('{content}', $p_sHtmlInsert , file_get_contents('./site/frontpagina.html'));
      $p_sHtmlInsert = str_replace('{footer}', '' , $p_sHtmlInsert);
    }
    // $p_sHtmlInsert = str_replace('{|paginaNavigatie|}', $this->paginaNavigatie(), $p_sHtmlInsert);
    if($_REQUEST['methode']<>'viewNotAuth'){
    	$p_sHtmlInsert = $this->AjaxReturn($p_sHtmlInsert, '', 'content_body');
    }
    //logRegel($p_sHtmlInsert,__FILE__ . __LINE__);
    return $p_sHtmlInsert;
  }

}

?>