<?php

class activiteitModel extends model {

  /**
   *  lees htmlformulier in voor verwerking
   * @return string array met content
   */
  function create() {
    $contentHtml    = file_get_contents('./site/addActiviteit.html');
    $navArray       = $this->pageNav();
    $search         = array('[@onderwerp]' ,'[@beschrijving]','[@locatie]', '[@begintijd]', '[@eindtijd]', '[@startdatum]', '[@einddatum]', '[@kal_categorie]', '[@contactp]', '[@telefoon]', '[@email]', '[@emailtwee]', '[@soort]', '[@page-nav]');
    $replace        = array('','','','','','','','','','','','','', $navArray['submit']);
    $content        = str_replace($search, $replace, $contentHtml); 
    $l_aViewBuffer[]= array("positie" => '0', "order" => '0', "result" => $content);
    //$this->pageNavigatie();
    return $l_aViewBuffer;
  }
  
  // http://localhost/kerk-aktief2/admin.php?XDEBUG_SESSION_START=netbeans-xdebug&module=activiteit&methode=viewNotAuth&aktiefile=kalender20110929_2.xml
  // http://localhost/kerk-aktief2/admin.php?&module=activiteit&methode=viewNotAuth&aktiefile=kalender20110929_2.xml
  
  function viewNotAuth(){
    //$pFilename        = $this->procVars->get('checkfile');
    //$l_sLocatieFiles  = './site/media/kalender/nietgeautoriseerd/';
    $navArray         = $this->pageNav();
    $xmlResult        = simplexml_load_file($_REQUEST['aktiefile']);
    $template         = file_get_contents('./site/addActiviteit.html');
    $aEmail           = explode('@', $xmlResult->email) ;
    $datumstart   	 = substr($xmlResult->begindatum,6,2) .'-'. substr($xmlResult->begindatum,4,2) .'-'. substr($xmlResult->begindatum,0,4);
    $datumeind			 = substr($xmlResult->einddatum,6,2). '-'. substr($xmlResult->einddatum,4,2). '-'. substr($xmlResult->einddatum,0,4);
    $search           = array('[@onderwerp]' ,'[@beschrijving]','[@locatie]', '[@begintijd]', '[@eindtijd]', '[@startdatum]', '[@einddatum]', '[@kal_categorie]', '[@contactp]', '[@telefoon]', '[@email]', '[@emailtwee]', '@soort', '[@page-nav]', '[@filenaam]');
    $replace          = array($xmlResult->onderwerp, $xmlResult->beschrijving, $xmlResult->locatie, $xmlResult->begintijd, $xmlResult->eindtijd, $datumstart, $datumeind, 
                      $xmlResult->kal_categorie, $xmlResult->contactpersoon, $xmlResult->telefoon, $aEmail[0], $aEmail[1], $xmlResult->soort, $navArray['save'].$navArray['delete'], $xmlResult->file);
    $content          =  str_replace($search, $replace, $template); 
    return $content;
  }
  

  /**
   * 
   * Voeg buttons toe aan pagina
   * @return array buttons save delete en submit
   */
  function pageNav(){
    $navArray['save']   = '<input  name="editform"  onclick="loadJSxmlCallB('. "'./index.php' , '#editcontent', 'FormSave'); return false". '"      type="button" value="Wijziging opslaan" />';
    $navArray['delete'] = '<input  name="delform"   onclick="loadJSxmlCallB('. "'./index.php' , '#editcontent', 'Formverwijderen'); return false". '"  type="button" value="Verwijderen" />';
    $navArray['submit'] = '<input id="mailbutton"   name="saveform"  onclick="loadJSxmlCallB('. "'./index.php' , '#editcontent', 'FormOpslaan'); return false". '"      type="button" value="Verstuur het bericht" />';
    return $navArray;
  }
  
  /*
   * Verwijder xml activiteit bestand uit de nietgeautoriseerde map
   */
  public function Formverwijderen(){
      //$this->xmlfile  = $this->procVars->get('file');
      $fileInfo         = pathinfo($_REQUEST['file']);
      $fileXml          = $fileInfo['basename'];
      $editFile         = './site/media/kalender/nietgeautoriseerd/'.$fileXml;
      unlink($editFile);
  }
  /**
   * formulier op slaan na verwerking door auditor
   */
  public function formSave() {
    $formmessage = $this->formvalidate();
    if (!empty($formmessage)) {
      return $this->formvalidate();
    } else {
        //$this->xmlfile    = $this->procVars->get('file');
        $fileInfo         = pathinfo($_REQUEST['file']);
        $fileXml          = $fileInfo['basename'];
        $l_sEditFile      = './site/media/kalender/nietgeautoriseerd/'.$_REQUEST['file'];
     	$l_sEditFileAuth  = './site/media/kalender/'.$fileXml;
        $l_xmlResult1     = simplexml_load_file($l_sEditFile);
        $l_xmlResult1->onderwerp      = trim($_REQUEST['onderwerp']);
        $l_xmlResult1->beschrijving   = trim($_REQUEST['beschrijving']);
        $l_xmlResult1->locatie        = trim($_REQUEST['locatie']);
        $l_xmlResult1->begintijd      = trim($_REQUEST['begintijd']);
        $l_xmlResult1->eindtijd       = trim($_REQUEST['eindtijd']);
        $datumin = substr(trim($_REQUEST['begindatum']), 6, 4) . substr(trim($_REQUEST['begindatum']), 3, 2).substr(trim($_REQUEST['begindatum']), 0, 2);
        $l_xmlResult1->begindatum     = $datumin;
        $datumuit = substr(trim($_REQUEST['einddatum']), 6, 4) . substr(trim($_REQUEST['einddatum']), 3, 2).substr(trim($_REQUEST['einddatum']), 0, 2);
        $l_xmlResult1->einddatum      = $datumuit;
        $l_xmlResult1->kal_categorie  = trim($_REQUEST['kal_categorie']);
        $l_xmlResult1->kal_contentcel = 'kaldefault';
        $l_xmlResult1->contactpersoon = trim($_REQUEST['contact']);
        $l_xmlResult1->telefoon       = trim($_REQUEST['telefoon']);
		$l_xmlResult1->email          = trim($_REQUEST['email']);
		$l_xmlResult1->soort          = trim($_REQUEST['soort']);
        $l_xmlResult1->plaatsing      = trim($_REQUEST['plaats']);
        $l_xmlResult1->gemaakt        = trim($_REQUEST['gemaakt']); 
		$l_xmlResult1->gemaaktop      = trim($_REQUEST['gemaaktop']);
		$l_xmlResult1->gewijzig       = trim($_REQUEST['gewijzigd']);
        $l_xmlResult1->gewijzigdop    = trim($_REQUEST['gewijzigdop']);
        $l_xmlResult1->extern         = trim($_REQUEST['extern']);
        $l_xmlResult1->file           = $_REQUEST['file'];
        $l_xmlResult1->tijd           = trim($_REQUEST['tijd']);
		$l_sContentEditFile = $l_xmlResult1->asXML();
        file_put_contents($l_sEditFile, $l_sContentEditFile);
        copy( $l_sEditFile, $l_sEditFileAuth);
        unlink($l_sEditFile);
       
    }
  }
  
  /**
  * formulier op slaan voor verwerking door auditor
  */
  public function formOpslaan() {
    $formmessage = $this->formvalidate();
    if (!empty($formmessage)) {
      return $this->formvalidate();
    } else {
      $this->savexml();
    }
  }

  function savexml(){
    $l_sContentLocatie  = './site/media/kalender/nietgeautoriseerd/';
		$l_sTemplateFile    = $l_sContentLocatie .'template.xml';
		$l_sLinkType        = 'kalender';
        $l_sNieuwFile       = $this->openxmlfile('./site/media/kalender/kalenderini.xml', 'filenaam');
        $fileInfo         = pathinfo($l_sNieuwFile);
        $fileXml          = $fileInfo['basename'];
		$l_sNieuwFile       = './site/media/kalender/nietgeautoriseerd/'.$l_sLinkType.$l_sNieuwFile;

		$l_xmlResult1 = simplexml_load_file($l_sTemplateFile);
        $l_xmlResult1->onderwerp      = trim($this->onderwerp);
        $l_xmlResult1->beschrijving   = trim($this->bericht);
        $l_xmlResult1->locatie        = trim($_POST['locatie']);
        $l_xmlResult1->begintijd      = trim($_POST['begintijd']);
        $l_xmlResult1->eindtijd       = trim($_POST['eindtijd']);
        logRegel($_POST['begindatum'],__FILE__ . __LINE__);
        $datumin = substr($_POST['begindatum'], 6, 4) . substr($_POST['begindatum'], 3, 2) . substr($_POST['begindatum'], 0, 2);
        logRegel($datumin,__FILE__ . __LINE__); 
        $l_xmlResult1->begindatum     = trim($datumin);
        $datumuit = substr($_POST['einddatum'], 6, 4).substr($_POST['einddatum'], 3, 2).substr($_POST['einddatum'], 0, 2);
        $l_xmlResult1->einddatum      = trim($datumuit);
        $l_xmlResult1->kal_categorie  = trim($_POST['kal_categorie']);
        $l_xmlResult1->kal_contentcel = trim($_POST['kal_contentcel']);
        $l_xmlResult1->contactpersoon = trim($this->contact);
        $l_xmlResult1->telefoon       = trim($_POST['telefoon']);
		$l_xmlResult1->email          = trim($this->email_from);
		$l_xmlResult1->soort          = trim($_POST['soort']);
        $l_xmlResult1->plaatsing      = trim($_POST['plaats']);
        $l_xmlResult1->gemaakt        = trim($_POST['gemaakt']); 
		$l_xmlResult1->gemaaktop      = trim($_POST['gemaaktop']);
		$l_xmlResult1->gewijzig       = trim($_POST['gewijzigd']);
        $l_xmlResult1->gewijzigdop    = trim($_POST['gewijzigdop']);
        $l_xmlResult1->extern         = trim($_POST['extern']);
        $l_xmlResult1->file           = $l_sLinkType.$fileXml ;
        $l_xmlResult1->tijd           = trim($_POST['tijd']);
		$l_sContentNieuwFile = $l_xmlResult1->asXML();
		copy($l_sTemplateFile, $l_sNieuwFile);
        file_put_contents($l_sNieuwFile, $l_sContentNieuwFile);
        $this->insertxmlactiviteit($l_sNieuwFile,trim($_POST['begindatum']),trim($_POST['einddatum'])); 
        $message = 'www.hervormdreeuwijk.nl/index.php?&module=activiteit&methode=viewNotAuth&aktiefile=' . $l_sNieuwFile. '&content=addActiviteit.html';
      //  logRegel($message,__FILE__ . __LINE__);
        mail('vries.eck@caiway.nl,kdehoop@actasys.nl', 'activiteit gemeld', $message);
  }
  
  function died($error) {
    // your error code can go here
    echo "We constateren dat niet alle gegevens zijn ingevuld\n";
    echo "Het gaat om de volgende gegevens:\n";
    echo $error . "\n";
    echo "Ga terug en vul de ontbrekende gegevens in.\n";
    die();
  }
  
  /**
   *
   * @param type $string
   * @return type 
   */
  function clean_string($string) {
    $bad = array("content-type", "bcc:", "to:", "cc:", "href");
    return str_replace($bad, "", $string);
  }

  function formvalidate() {
    // validation expected data exists
    if (!isset($_POST['onderwerp']) ||
            !isset($_POST['beschrijving']) ||
            !isset($_POST['locatie']) ||
            !isset($_POST['contactpersoon']) ||
            !isset($_POST['kal_categorie']) ||
            !isset($_POST['email']) ||
            !isset($_POST['emailtwee'])) {
      died('Niet alle gegevens zijn ingevoerd.');
    }
    $this->email_to = 'keesdehoop@actasys.nl';
    $this->email_from = $_POST['email'] . '@' . $_POST['emailtwee']; // required
    $this->contact = $_POST['contactpersoon']; // required

    $this->onderwerp = $_POST['onderwerp']; // required
    $this->bericht = $_POST['beschrijving']; // required
    $this->categorie = $_POST['kal_categorie']; // required
    $this->email_to = $this->email_to . ';' . $this->email_from;

    $error_message = "";

    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
    if (!preg_match($email_exp, $this->email_from)) {
      $error_message .= 'Het e-mailadres is niet in ord.' . "\n";
    }

    $string_exp = "/^[A-Za-z .'-]+$/";
    if (!preg_match($string_exp, $this->contact)) {
      $error_message .= 'De ingevoerde naam is niet in orde.' . "\n";
    }

    if (strlen($error_message) > 0) {
      died($error_message);
    }

    return $error_message;
  }

  function emailform() {
    $email_message  = "De formuliergegevens zijn als volgt ingevuld.\n\n";
    $l_sDataHtml    = 'Bedankt voor uw reactie.';

    $email_message .= "Contactpersoon: " . clean_string($Voornaam) . clean_string($achternaam) . "\n";
    $email_message .= "Email: " . clean_string($email_from) . "\n";
    $email_message .= "Het onderwerp van het mailbericht is: " . clean_string($onderwerp) . "\n";
    $email_message .= "Bericht: " . clean_string($bericht) . "\n";

    // create email headers
    $headers = 'From: ' . $email_from . "\r\n" .
            'Reply-To: ' . $email_from . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
    echo '<br/>' . $email_to . $email_subject . $email_message . $headers;
    //echo 'test';
    //mail($email_to, $email_subject, $email_message, $headers); 
  }

}

?>
