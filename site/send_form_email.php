<?php


  
if(isset($_POST['prem'])) {
     
    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to 		= "kdehoop@actasys.nl";
    $email_subject 	= "Aanmelding Gemeentedag";
     
     
    function died($error) {
        // your error code can go here
        echo "We constateren dat niet alle gegevens zijn ingevuld ";
        echo "Het gaat om de volgende gegevens.<br /><br />";
        echo $error."<br /><br />";
        echo "Ga terug en vul de ontbrekende gegevens aan.<br /><br />";
        die();
    }
     
    // validation expected data exists
    if(!isset($_POST['contact']) ||
        !isset($_POST['prem']) ||
        !isset($_POST['postm']) ||
        !isset($_POST['deelmiddag']) ||
        !isset($_POST['middagkinderen']) ||
        !isset($_POST['deelavond']) ||
        !isset($_POST['avondkinderen']) ||
        !isset($_POST['eigenvervoer']) ||
        !isset($_POST['neemmee'])) {
        died('Niet alle gegevens zijn ingevoerd.');      
    }
     
    $eerstedeel_email 	= $_POST['prem']; // required
    $tweededeel_email 	= $_POST['postm']; // required
    $email_from			= $eerstedeel_email.'@'.$tweededeel_email;
    $contactpersoon 	= $_POST['contact']; // required
    $middag 			= $_POST['deelmiddag']; // required
    $middagKinderen		= $_POST['middagkinderen']; // required
    $avond				= $_POST['deelavond']; // required
    $avondKinderen		= $_POST['avondkinderen']; // required
    $eigenverv			= $_POST['eigenvervoer']; // required
    $neemmee			= $_POST['neemmee']; // required
 
   
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }
    $string_exp = "/^[A-Za-z .'-]+$/";
  if(!preg_match($string_exp,$contactpersoon)) {
    $error_message .= 'The First Name you entered does not appear to be valid.<br />';
  }
  if(strlen($error_message) > 0) {
    died($error_message);
  }
    $email_message = "De ingevoerde formuliergegevens zijn als volgt ingevuld.\n\n";
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
     
    $email_message .= "Contactpersoon: ".clean_string($contactpersoon)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Deelnemers middagprogramma: ".clean_string($middag)."\n";
    $email_message .= "Waarvan het aantal kinderen: ".clean_string($middagKinderen)."\n";
    $email_message .= "Deelnemers avondprogramma: ".clean_string($avond)."\n";
    $email_message .= "Waarvan het aantal kinderen: ".clean_string($avondKinderen)."\n";
    $email_message .= "Heeft eigen vervoer: ".clean_string($eigenverv)."\n";
    $email_message .= "Biedt aan iemand mee te nemen zonder eigen vervoer: ".clean_string($neemmee)."\n";
     
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
echo '<br/>'.$email_to. $email_subject. $email_message. $headers;
@mail($email_to, $email_subject, $email_message, $headers); 
?>
 
<!-- include your own success html here -->
 
Bedankt voor de aanmelding we wensen u een fijne gemeentedag toe.
 
<?php
}
?>