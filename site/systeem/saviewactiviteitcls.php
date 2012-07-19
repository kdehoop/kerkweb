<?php

class activiteitView extends view{

	function create( $pContentHtml){
      //$this->procVars->set('sjabloon', 'blok2pagina.php');
      return $pContentHtml;
	}
    
    function formOpslaan(){
      $content = 'Het activiteiten formulier is verstuurd </br> Hartelijk bedankt voor uw medewerking.';
      $l_aViewBuffer[]  = array("positie" => '1', "order" => '0', "result" => $content );
      //$this->procVars->set('sjabloon', 'blok2pagina.php');
      return $l_aViewBuffer ;
    }
    
    public function formSave() {
      $content = 'Formulier gewijzigd';
      $l_aViewBuffer[]  = array("positie" => '1', "order" => '0', "result" => $content );
      //$this->procVars->set('sjabloon', 'blok2pagina.php');
      return $l_aViewBuffer;
    }
    
    public function Formverwijderen(){
      $content = 'Activiteit aanvraag verwijderd';
      $l_aViewBuffer[]  = array("positie" => '1', "order" => '0', "result" => $content );
      $this->procVars->set('sjabloon', 'blok2pagina.php');
      return $l_aViewBuffer ;
    }
    
    function viewNotAuth($content){      
      $l_aViewBuffer[]  = array("positie" => '1', "order" => '0', "result" => $content );
      return $l_aViewBuffer;
    }
}
?>
