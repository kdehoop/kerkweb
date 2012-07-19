<?php
    include 'samodelcls.php';
    include 'saviewcls.php';
    include 'samodelactiviteitcls.php';
    include 'saviewactiviteitcls.php';
    $l_oModelClass        = new activiteitModel();				
    $l_oViewClass         = new activiteitView();
    switch ($_REQUEST['methode']){
      case 'FormOpslaan':  
        $l_sModelResult   = $l_oModelClass->formOpslaan();
        $l_aViewResult    = $l_oViewClass->formOpslaan($l_sModelResult);
      Break;

      case 'viewNotAuth': 
          $l_sModelResult = $l_oModelClass->viewNotAuth();
          $l_aViewResult  = $l_oViewClass->viewNotAuth($l_sModelResult);
      Break;
    
      case 'FormSave': 
          $l_sModelResult = $l_oModelClass->formSave();
          $l_aViewResult  = $l_oViewClass->formSave($l_sModelResult);
      Break;
    
    case 'Formverwijderen': 
          $l_sModelResult = $l_oModelClass->Formverwijderen();
          $l_aViewResult  = $l_oViewClass->Formverwijderen($l_sModelResult);
      Break;

      default:
        $l_sModelResult   = $l_oModelClass->create();
        $l_aViewResult    = $l_oViewClass->create($l_sModelResult);
    }
    $l_HtmlResult         = $l_oViewClass->matchSjabloon($l_aViewResult ,'./site/sjabloon/blok2pagina.php');
    //echo  $l_HtmlResult;
?>
