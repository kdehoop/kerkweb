<?php
//echo var_dump($_POST);
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
        !isset($_POST['eigenvervoer'])) {
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
 	$email_to 			= $email_to.';'.$email_from;
   
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }
    $string_exp = "/^[A-Za-z .'-]+$/";
  if(!preg_match($string_exp,$contactpersoon)) {
    $error_message .= 'De ingevoerde naam is niet in orde.<br />';
  }
  if(strlen($error_message) > 0) {
    died($error_message);
  }
    $email_message = "De ingevoerde formuliergegevens zijn als volgt ingevuld.\n\n";
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
    if($neemmee){
		$neemmee = 'Ja';
	} else {
			$neemmee = 'Nee';
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
//echo '<br/>'.$email_to. $email_subject. $email_message. $headers;
@mail($email_to, $email_subject, $email_message, $headers); 

?>
 
<!-- include your own success html here -->
 
<!-- Bedankt voor de aanmelding we wensen u een fijne gemeentedag toe.-->

<?php
 $bedankt = 'Bedankt voor de aanmelding we wensen u een fijne gemeentedag toe.';
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl">
	<head>
	<title>Hervormd Reeuwijk</title>
        <meta content="" name="keywords"/>
        <meta name="description" content="" />
        <!--link type="text/css" rel="stylesheet" href="./css/basis.css"/-->
		<style type="text/css">
			
			p {
				margin-left: 0px;
				color: #d25d27;
			    font-family: "Arial Rounded MT Bold";
			    font-size: 16px;
			}
			
			body {
				background-color:#f7f3e7;
				font-family: Arial;
			    font-size: 13px; 
			}
			
			table{
				border: 0px;
				padding: 5px;
			}
			
			td{
				border: 0px;
			}
			
			.eigenverv{
				width: 50px;
			}
			
			.getal {
				width: 50px;
			}
			
			.tekst1{
				background-color:#f0e7bc;
			    color: #000000;
				padding: 5px;
				margin-top: -15px;
				border: 1px solid;
			}	
			
			.tabform{
				background-color: #819828;
			    border-top: 3px solid;
				border-color: #4a6345;
			    margin-top: -15px;
			    padding: 1px;
			}
			
			#content{
				margin-left:auto;
				margin-right:auto;
				height:768px;
				width:1024px;
				background-color:#e5e5e5;
				overflow:auto;
				padding: 15px;	
			}
			#frame{
			   background-color: #362721;
			   height: 770px;
			   margin-left: auto;
			   margin-right: auto;
			   padding: 60px;
			   position: relative;
			   width: 1130px;
			}
			#kop{
			    color: #000000;
			    font-family: Arial;
			    font-size: xx-large;
			    text-align: center;	
				height: 50px;
			}
			#colom1{
				
			    float: left;
			    font-family: Arial;
			    font-size: 13px;
			    margin: 10px;
			    padding: 5px;
			    position: relative;
			    width: 305px;
			}
			#colom2{
				
			    float: left;
			    font-family: Arial;
			    font-size: 13px;
			    margin: 10px;
			    padding: 5px;
			    position: relative;
			    width: 305px;
			}
			#colom3{
				
			    float: left;
			    font-family: Arial;
			    font-size: 13px;
			    margin: 10px;
			    padding: 5px;
			    position: relative;
			    width: 305px;
			}
			#form1{
				
				position: relative;
				float: left;
				width: 1020px;
				padding:0px;
			}
			#footer{
				background-color: #6fb8b8;
			    float: left;
			    height: 25px;
			    margin-top: 20px;
			    padding-top: 7px;
			    position: relative;
			    text-align: center;
			    width: 1020px;
				font-size: 19px;
				border-top: 3px solid;
				border-color: #4a6345;
			}
			#row1{
				font-family: Arial;
				position: relative;
				float: left;
				margin-top: -10px;
			}
		</style>		
	</head>
	 <body> 
		 <div id="frame">
		 	<div id="content"> 
				<div id="kop">
					<?php
					if($bedankt){
						echo $bedankt;
					} else {
					  	echo 'Uitnodiging voor de gemeentedag op 28 mei aanstaande';
					}
					 ?>
					
				</div>
				<div id="formulier">
					<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" accept-charset="utf-8">
						D.V. Zaterdag 28 mei is het zover. Dan organiseert onze kerkelijke gemeente van Reeuwijk haar gemeentedag. Een dag voor jong en oud waar u en jij van harte worden uitgenodigd om aan mee te doen. Deelname hieraan zal zeker geen teleurstelling opleveren, dat beloven we u / jou alvast!
						Om het zo aantrekkelijk mogelijk te maken is er gekozen voor een apart middagprogramma en avondprogramma. Dat maakt de drempel laag om mee te willen/kunnen doen voor iedereen.
						<br/>
						<div id="row1"> 
							<div id="colom1">
								<p>Middagprogramma</p>
								<div class="tekst1"> 
									We brengen een bezoek aan het attractieve streekcentrum ooievaarsdorp Het Liesvelt.
									Voor de kinderen zijn daar speurtochten te doen en er is een leuke natuurspeeltuin.
									<a href="http://www.streekcentrum.nl"> www.streekcentrum.nl</a>
									<br/>
									Verzamelpunt 	Ichtuskerk Reeuwijk<br/>
									Ontvangst  	 	12.45 uur <br/>
									Opening         13.00 uur welkom en korte opening gemeentedag<br/>
									Vertrek naar Het Liesvelt gebeurt per eigen auto. Tussen 16.45 uur en 17.00 uur retour naar Reeuwijk.
								</div>
							</div>
							<div id='colom2'>
								<p>Avondprogramma</p>
								<div class="tekst1">
									Het avondprogramma begint met ontvangst van aperitief, opgevolgd met een goed georganiseerde en gezellige maaltijd voorzien van barbecue en nasi / bami en andere lekkernijen. Voor de allerkleinsten zijn er ook nog heerlijke worstenbroodjes gemaakt.
									Na de barbecue is er een half uurtje sing-in en vanaf  20.00 uur kunnen sportievelingen zich uitleven op het weiland tegenover het kerkplein. Er zal een spannend volleybaltoernooi gehouden worden.  Zie hiervoor apart opgave formulier. Dus strek de armen en benen maar alvast!
									<br/><br/>
									Verzamelpunt    Dorpskerkplein Reeuwijk Dorp<br/>
									Ontvangst  	    17.30 uur  ontvangst met aperitief<br/>
									Maaltijd        18.00 uur <br/>
									Volleybal	    20.00 uur
								</div>
							</div>
							<div id="colom3">
								<p>Deelnamekosten</p>
								<div class="tekst1">
									De kosten zijn laag gehouden. Deelname aan middagprogramma hebben we ondanks de entreekosten 
									kosteloos weten te houden. 
									<br/><br/>
									Deelname aan barbecue/maaltijd is als volgt:<br/>
									Per persoon: &euro; 7,50 <br/>
									Kinderen basisschool: &euro; 5,00<br/>
									Gezinsdeelname max.  &euro; 20,00<br/>
									<br/>
									Deelnemers die zich melden via het onderstaande formulier dienen de kosten op de middag/avond zelf af te rekenen. 
								</div>
							</div>
						</div>
						
						<div id="form1">
						<p>Geef je op met dit formulier</p>
							<div class="tabform">
								<table width="800" border="1">
								    <tr>
								        <td>Naam contactpersoon:<input name = "contact" type="text"  /> </td>
								        <td></td>
								    </tr>
								    <tr>
								        <td>E-mailadres: <input name = "prem" type="text"  />@<input name = "postm" type="text"  /></td>
								        <td> </td>
								    </tr>
								    <tr>
								        <td>Heeft eigen vervoer:Ja <input class="eigenverv" value="Ja" name = "eigenvervoer" type="radio"  /> Nee <input value="Nee" name = "eigenvervoer" type="radio"  /></td>
								        <td> </td>
								    </tr>
									<tr>
								        <td>Biedt aan iemand mee te nemen zonder eigen vervoer:<input value="Nee" name = "neemmee" type="checkbox"  /> </td>
								        <td></td>
								    </tr>	
									<tr>
								        <td>Nemen deel aan het middagprogramma met:<input class="getal" name = "deelmiddag" type="text"  /> personen, waarvan <input class="getal" name = "middagkinderen" type="text"  /> kinderen </td>
								        <td> </td>
								    </tr>
									<tr>
								        <td>Nemen deel aan het avondprogramma met : <input class="getal" name = "deelavond" type="text"  /> personen, waarvan <input class="getal" name = "avondkinderen" type="text"  /> kinderen  </td>
								        <td> </td>
								    </tr>					 
								</table>
							<p><input type="submit" value="Verstuur je bericht" /></p>
							</div>
						</div>
					</form>
				</div>
				<div id="footer">
					Het wordt een ongedwongen samenzijn in een leuke ontspannen sfeer!
				</div>
			</div>
		 </div>
	 </body>
