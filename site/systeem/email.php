<?php

include_once './securimage/securimage.php';
$securimage = new Securimage();
if ($securimage->check($_REQUEST['captcha_code']) == false) {
  // the code was incorrect
  // you should handle the error so that the form processor doesn't continue

  // or you can use the following code if there is no validation or you do not know how
 // echo "The security code entered was incorrect.<br /><br />";
  //echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
  
  $l_sDataHtml = "De ingevoerde code was niet in orde.\n"."Voer opnieuw de code in.";
  
  //exit;
} else {
	
	if(isset($_REQUEST['prem'])) {
		
		$email_to 	= "cdehoop@solcon.nl";
		$email_subject 	= "Hervormd Reeuwijk Contact Mail";
	
		 function died($error) {
		    // your error code can go here
		    echo "We constateren dat niet alle gegevens zijn ingevuld\n";
		    echo "Het gaat om de volgende gegevens:\n";
		    echo $error."\n";
		    echo "Ga terug en vul de ontbrekende gegevens in.\n";
		    die();
		}
		 
		 // validation expected data exists
		if(!isset($_POST['vncontact']) ||
		    !isset($_POST['prem']) ||
		    !isset($_POST['ancontact']) ||
		    !isset($_POST['onderwerp']) ||
		    !isset($_POST['bericht'])) {
		    died('Niet alle gegevens zijn ingevoerd.');      
		}
		
		function clean_string($string) {
	      $bad = array("content-type","bcc:","to:","cc:","href");
	      return str_replace($bad,"",$string);
	    }
		 
		$email_from	= $_POST['prem']; // required
		$Voornaam 	= $_POST['vncontact']; // required
		$achternaam	= $_POST['ancontact']; // required
		$onderwerp	= $_POST['onderwerp']; // required
		$bericht	= $_POST['bericht']; // required
		
		 
		$error_message = "";
		
		$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
		if(!preg_match($email_exp,$email_from)) {
		    $error_message .= 'Het e-mailadres is niet in ord.'."\n";
		}
		
		$string_exp = "/^[A-Za-z .'-]+$/";
		if(!preg_match($string_exp,$Voornaam)) {
			$error_message .= 'De ingevoerde voornaam is niet in orde.'."\n";
		}
		
		$string_exp = "/^[A-Za-z .'-]+$/";
		if(!preg_match($string_exp,$achternaam)) {
			$error_message .= 'De ingevoerde achternaam is niet in orde.'."\n";
		}
	
		if(strlen($error_message) > 0) {
			died($error_message);
		}
		
		$email_message  = "Hartelijkdank voor de reactie via de website.\nIndien nodig, ontvangt u van ons zo spoedig mogelijk een reactie terug.\n\n";
		$email_message .= "De formuliergegevens zijn als volgt ingevuld.\n";
	 	$l_sDataHtml 	= 'Bedankt voor uw reactie.';
         	$email_message .= "Contactpersoon: ".clean_string($Voornaam).clean_string($achternaam)."\n";
	 	$email_message .= "Email: ".clean_string($email_from)."\n";
	 	$email_message .= "Het onderwerp van het mailbericht is: ".clean_string($onderwerp)."\n";
		$email_message .= "Bericht: ".clean_string($bericht)."\n";
		
		// create email headers
		$headers = 'From: nietreageren@hervormdreeuwijk.nl' . 'Reply-To:' . $email_from . "\r\n" . 'X-Mailer: PHP/' . phpversion();
		// reactie naar beheerder
		mail($email_to, $onderwerp, $email_message,$headers);
		// reactie naar afzender
		mail($email_from, $email_subject, $email_message,$headers);
	}
	 	
}	
?>
