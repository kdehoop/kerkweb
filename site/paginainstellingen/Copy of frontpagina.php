<?php
// starttpagina instellingen
	$g_aModule['menutekst']		= 'Voorpagina';
	$g_aModule['Locatie'] 		= './site/frontpagina.html';
	$g_aModule['Type'] 			= 'Multi1Page';
	$g_aModule['sjabloon'] 		= 'multi1pagina';
	$g_aModule['AantalPosities']= '2';
	$g_aModule['naactie'] 		= '';
	$g_aModule['RepId']			= '3';
	
	$g_aMultiPage['11']['Order'] = '11';
	$g_aMultiPage['11']['Type'] = 'Page'; // open een nieuwe pagina
	$g_aMultiPage['11']['Locatie'] = './site/artikel1.html';
	$g_aMultiPage['11']['Positie'] = '1';
	$g_aMultiPage['11']['menutekst'] = 'Nieuw in de gemeente';		
		
	$g_aMultiPage['23']['Order'] = '21';
	$g_aMultiPage['23']['Type'] = 'Insert'; // apparte module geen kop en tekst deel
	$g_aMultiPage['23']['Locatie'] = './site/blokmenu1.php';
	$g_aMultiPage['23']['Positie'] = '2';
	$g_aMultiPage['23']['menutekst'] = 'Meer informatie';
	
	$g_aMultiPage['22']['Order'] = '22';
	$g_aMultiPage['22']['Type'] = 'Page'; // preken
	$g_aMultiPage['22']['Locatie'] = './site/preken.html'; 
	$g_aMultiPage['22']['Positie'] = '2';
	$g_aMultiPage['22']['menutekst'] = 'Op zondag zijn we open';
	
	$g_aMultiPage['24']['Order'] = '12';
	$g_aMultiPage['24']['Type'] = 'Insert';
	$g_aMultiPage['24']['Locatie'] = './site/bijbeltekstvdd.php';
	$g_aMultiPage['24']['Positie'] = '1';
	$g_aMultiPage['24']['menutekst'] = 'Tekst van de dag';
	
	$g_aMultiPage['12']['Order'] = '13';
	$g_aMultiPage['12']['Type'] = 'Page';
	$g_aMultiPage['12']['Locatie'] = './site/artikel2.html';
	$g_aMultiPage['12']['Positie'] = '1';
	$g_aMultiPage['12']['menutekst'] = 'Cursus Op weg';
	
	$g_aMultiPage['21']['Order'] = '23';
	$g_aMultiPage['21']['Type'] = 'Insert';
	$g_aMultiPage['21']['Locatie'] = './site/kalendercontent.php';
	$g_aMultiPage['21']['Positie'] = '2';
	$g_aMultiPage['21']['menutekst'] = 'Activiteiten';
?>
