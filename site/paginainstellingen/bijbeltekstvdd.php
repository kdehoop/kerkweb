<?php 
	$g_aModule['menutekst'] = 'Bijbeltekst';
	$g_aModule['onderwerp'] = 'Tekst van de dag';
	$g_aModule['Locatie'] = './site/bijbeltekstvdd.html';
	$g_aModule['rsslink'] = 'http://feed.dagelijkswoord.nl/rss2/statenvertaling';
	$g_aModule['sitelink'] = 'http://www.dagelijkswoord.nl';
	$g_aModule['Type'] = 'Module';
	$g_aModule['sjabloon'] = 'insert';
	$g_aModule['naactie'] = '';
	$g_aModule['RepId'] = '';

$xmlObj = simplexml_load_file($g_aModule['rsslink']);
$item 	= $xmlObj->channel->item;	
	$g_aModule['item'] 			= $item->link;
	$g_aModule['description'] 	= $item->description;

/*$outputItem =  '<a href="'. $item->link . '" ><h1>' . $g_aModule['onderwerp'] . '</h1></a>' .  
	'<div id ="koptekst" class="tekst1"> ' .  $item->description . '</div>
	 <div id="tekst"> </div>';	*/

// Bij meer rss feeds 
/*foreach ($xmlObj->channel->item as $item)
{
    echo $item->title, '<br />';
    echo $item->description, '<br />';
}*/
      
?>    