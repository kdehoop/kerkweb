<?php session_start();?>
<h1> Plaats een reactie</h1>
	<div id ="koptekst" class="tekst1">
		Wilt u contact opnemen met de wijkouderling of predikant dan kunt u gebruik maken van de email gegevens op de gemeenteinfo pagina of de contactpagina van de website. <br/>
		Voor alle overige situaties kunt u gebruik maken van dit reactieformulier. 
		<a class="info" href="artikel1.html" onclick="loadXMLDoc('./index.php?content'); return false ">Meer info ...</a> 
	</div>
<div>
	</br>
	<div id="formulier">
	<form id="formactie" accept-charset="utf-8">
		<div id="mailform1">
		<p><h1>Reactie</h1></p>
			<div class="tabform">
				<table width="400" border="0">
				    <tr>
				        <td ><h1><B><span class="mailcolom1">Voornaam:</span></B></h1> </td>
				        <td ><h1><B><span class="mailcolom1">Achternaam:</span></B></h1></td>
				    </tr>
					<tr>
				        <td ><input class="mailcolom2" name = "vncontact" type="text"  /></td>
				        <td ><input class="mailcolom2" name = "ancontact" type="text"  /> </td>
				    </tr>
				    <tr>
				        <td ><h1><b><span clase="mailcolom1">E-mailadres:</span></b></h1></td>
				        <td ><h1><b><span clase="mailcolom1">Onderwerp:</span></b></h1></td>
				        
				    </tr>
				    <tr>
				        <td ><input class="mailcolom2" name = "prem" type="text" /></td>
				        <td ><input class="mailcolom2" name = "onderwerp" type="tekst" /></td>
				    </tr>
				    <tr>
				        <td ></br></td>
				        <td ></td>
				    </tr>
				    <tr>
				        <td colspan="2"><textarea id="mailtext" class="mailcolom3" value="" name="bericht" rows="7"></textarea></td>
				    </tr>
				    <tr>
				        <td ></br></td>
				        <td ></td>
				    </tr>
				    <tr>
				        <td>
						    <table>
							    <tr>
							        <td rowspan="3"> <img class="chapta" id="captcha" src="./securimage/securimage_show.php" alt="CAPTCHA Image" /> </td>
							        <td></td>
							    </tr>
							    <tr>
									<td>&nbsp;&nbsp;&nbsp;&nbsp;
										<a href="#" onclick="document.getElementById('captcha').src = './securimage/securimage_show.php?' + Math.random(); return false">
							        		<img src="./securimage/securimage/images/refresh.png" alt="Andere code" title="Vernieuw de code."/>
							        	</a>
									</td>							    	
							    </tr>
							    <tr>
							    	<td>
							    		<!--object type="application/x-shockwave-flash" data="./securimage/securimage_play.swf?audio=./securimage/securimage_play.php&amp;bgColor1=#fff&amp;bgColor2=#fff&amp;iconColor=#777&amp;borderWidth=1&amp;borderColor=#000" width="19" height="19">
											<param name="movie" value="./securimage/securimage_play.swf?audio=./securimage/securimage_play.php&amp;bgColor1=#fff&amp;bgColor2=#fff&amp;iconColor=#777&amp;borderWidth=1&amp;borderColor=#000" />
										</object-->
							    	</td>
							    </tr>
						   </table>
						</td>
						<td>
							 <table>
							    <tr>
							        <td>
							        </td>
							        	
							        <td >Type de karakters van de afbeelding in.</td>
							    </tr>
							    <tr>
							    	<td></br></td>
							        <td><input class="mailcolom2" type="text" name="captcha_code" size="10" maxlength="6" /></td>
							    </tr>
							    <tr>
							    	<td></td>
							        <td></td>
							    </tr>
						   </table>	
						</td>
				    </tr>
	
				    		
				     <tr>
				        <td >	
				        	
						</td>
				        <td ></td>
				    </tr>
				     <tr>
				        <td colspan="2">
			 
				        <input id="mailbutton"   onclick="loadJSxml('./index.php', '#formactie', 'mail'); return false " type="button" value="Verstuur het bericht" /></td>
				    </tr>
											 
				</table>
				</br>
				</br>		
			</div>
		</div>
	</form>
	
</div>
	<div id="tekst" >
		
	</div>

