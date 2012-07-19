/* 
 * Dit zijn de basis js functies van Actasys
 * Versie     : 2
 * Created on : 12 februari, 2010, 11:58:00 AM
 * Author     : kees
 * Description:
 */

var xmlhttp;
var callbackactie = "";
var popid = "";
var elementNaam         = "";
var elementId           = "";
var elementWaarde       = "";
var elementClass        = "";
var elementInpWaarde    = "";
var elementLengte       = "";
var message             = "";
var validate            = "N";
var functieIs           = "";
var xmlhttp;
var callbackactie       = "";
var lastvalureradio		= "";
var submitcheck 		= "N";


 function datum(){
   
 	$("#datum1").datepicker({ dateFormat: 'dd-mm-yy' });
 	$("#datum2").datepicker({ dateFormat: 'dd-mm-yy' });
 }

function elementinfo(veld_id, veldwaarde){
  elementNaam 		= document.getElementById(veld_id).getAttribute('name');
  elementId   		= veld_id;
  elementType 		= document.getElementById(veld_id).getAttribute('type');
  elementPatern 	= document.getElementById(veld_id).getAttribute('pattern');
  if (elementType=='checkbox') { 
    if( document.getElementById(veld_id).checked) {
      document.getElementById(veld_id).value='Y';
    } else {
      document.getElementById(veld_id).value='N';
    }
  }
  elementWaarde     = document.getElementById(veld_id).getAttribute('value');
  elementInpWaarde  = veldwaarde;
  elementClass      = document.getElementById(veld_id).getAttribute('class');
  elementLengte     = document.getElementById(veld_id).getAttribute('width');
  elementReadonly   = document.getElementById(veld_id).getAttribute('readonly');
  elementRequired   = document.getElementById(veld_id).getAttribute('required');
}

function dateMask(elementId){
    var waardeNieuw = '';
    var element = document.getElementById(elementId);
    var waarde  = element.value;
    //var date   = waarde.split('-');
    if(waarde.length==1){
        waardeNieuw = waarde;   
    }
    if(waarde.length==2){
        if(waarde.substring(1)=='-'){
            waarde = '0'+waarde.substring(0); 
        }
        waardeNieuw = waarde+'-';   
    }
    if(waarde.length==3){
        waardeNieuw = waarde;   
    }
    if(waarde.length==4){
        waardeNieuw = waarde;   
    }
    if(waarde.length==5){
        if(waarde.substring(4)=='-'){
            waarde = waarde.substring(0,3)+'0'+waarde.substring(3); 
        }
        waardeNieuw = waarde+'-'
    }
    if(waarde.length==6){
        waardeNieuw = waarde;   
    }
    if(waarde.length==7){
        waardeNieuw = waarde;   
    }
    if(waarde.length==8){
        waardeNieuw = waarde;   
    }
    if(waarde.length==9){
        waardeNieuw = waarde;   
    }
    if(waarde.length==10){
        waardeNieuw = waarde;   
    }
    if(waarde.length==11){
        waardeNieuw = waarde.substring(0,10);   
    }
    element.value = waardeNieuw;
}

function loadJSxml(path, select, action){
	var data2 = '';
	var data3 = '';
	var data1 = $(select).serialize() + "&action="+ action +'&content=email.php';
	$.post( path, data1,
    	function(data2) {
			data3 = data2.trim();
    		alert(data3);
    });
	var test = data3.indexOf('ingevoerde');
   if(test==-1){
    	$("input").attr('readonly', 'y');
    	$("textarea").attr('readonly', 'y');
    	$('#mailbutton').remove();
   }
}

function loadJSxmlCallB(path, select, action, blokidpopup){
  if(action=='onderbreken'){
    $('#overlay').empty();
  }else{	
   // var valResult = formValidatie(select);
   valResult = true;
    if(valResult==true){
      var data1 = $(select).serialize() + "&methode="+ action + "&blokid=" + blokidpopup+'&content=addActiviteit.html'; 
      var data2 = $(select).serializeArray();
      $('#overlay').empty();
      //refreshBlok(data2,blokidpopup);
      $.post( path, data1,
        function(data) {
          adMinContentVerdeler(data);
        }
      );
    }
  }
}
function adMinContentVerdeler(p_data){
  var returnstring    = p_data;
  var replacetype     = stripstring("<type>", "</type>", returnstring);
  var replacestring   = stripstring("<![CDATA[", "]]>", returnstring);
  var messagetype     = stripstring("<messagetype>", "</messagetype>", returnstring);
  var insertId        = stripstring("<insnodeid>" , "</insnodeid>" , returnstring);
  switch( insertId ){
    case "content_body":
      $('#content_body').empty();
      $('#'+insertId).append(replacestring);
      break;
    default:
  }
  /* onderstaande gedeelte hoort hier te staan om dat eerst de hele pagina aanwezig dient te zijn.*/
  $( "#sortable1, #sortable2" ).sortable({
    connectWith: ".connectedSortable",
    cursor: 'crosshair',
    //cursor: 'move',
    update: function() {
      var parentSort2 = $('#sortable2').parent().attr("id");
      var parentSort1 = $('#sortable1').parent().attr("id");
      paginacode = $('#paginanaam').attr("value");
      var order1 = 'sortord='+$('#sortable1').sortable("toArray") + '&module=Multi1Page' + '&methode=storeVolgorde' + '&page='+paginacode+'&pagelocatie='+parentSort1+'&remote=yes'+'&parentpage='+paginacode;
      $.post("admin.php", order1);
      var order2 = 'sortord='+$('#sortable2').sortable("toArray") + '&module=Multi1Page' + '&methode=storeVolgorde' + '&page='+paginacode+'&pagelocatie='+parentSort2+'&remote=yes'+'&parentpage='+paginacode;
      $.post("admin.php", order2);
      ecCount  = 'Y';
    }
  }).disableSelection();
}

function loadXMLDoc(url){
    xmlhttp=null;
	if (window.XMLHttpRequest) {// code for Firefox, Opera, IE7, etc.
  		xmlhttp=new XMLHttpRequest();
  	}else if (window.ActiveXObject) {// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
	if (xmlhttp!=null){
  		xmlhttp.onreadystatechange=state_Change;
  		xmlhttp.open("GET",url,true);
  		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  		xmlhttp.send(null);
  	} else {
  		alert("Your browser does not support XMLHTTP.");
  	}
}



function state_Change(){
    if (xmlhttp.readyState==4){// 4 = "loaded"
        if (xmlhttp.status==200){// 200 = "OK"
            verdeler();
        }    
    }
}

function verdeler(){
	var returnstring 	= xmlhttp.responseText;
	var replacetype		= stripstring("<type>", "</type>",returnstring);
	var replacestring   = stripstring("<![CDATA[", "]]>", returnstring);
	var replaceid		= stripstring("<repid>", "</repid>", returnstring);
	if (replacetype != 'Popup') {
		document.getElementById('content_body').innerHTML=replacestring;
		if(replaceid==''){
			 replaceid = popid;
		}
		$('#calcFocus').focus();
		var actueelId   = document.getElementById(replaceid);
		if(actueelId!=null){
			actueelId.style.visibility  = 'hidden';
		}
	} else {
		document.getElementById(replaceid).innerHTML=replacestring;
		popid = replaceid;
		var actueelId   = document.getElementById(replaceid);
		//if(actueelId.style.visibility.length!=0){
			actueelId.style.visibility  = 'visible';
		//}	
	}
	if($('.pic a').length!=0){
		$('.pic a').lightBox({
			// we call the lightbox method, and convert all the hyperlinks in the .pic container into a lightbox gallery
	
				imageLoading:  './site/media/websitefotos/lightbox/images/loading.gif',
				imageBtnClose: './site/media/websitefotos/lightbox/images/close.gif',
				imageBtnPrev:  './site/media/websitefotos/lightbox/images/prev.gif',
				imageBtnNext:  './site/media/websitefotos/lightbox/images/next.gif'
	
		});
	}
   // datum();
}

function stripstring(start, stop, stringtotaal){
	var 	startval 		= stringtotaal.lastIndexOf(start);
	var 	lengte 			= start.length;
			startval 		= lengte+startval;
	var 	stopval 		= stringtotaal.indexOf(stop);
	var 	replacestring 	= stringtotaal.slice(startval,stopval);
	return 	replacestring;
}

function closepopup(){
    var actueelId   = document.getElementById(popid);
    actueelId.style.visibility  = 'hidden';
}

$(document).ready(function(){
	$('#calcFocus').focus();
	$('#topfocus').focus();
});

function formValidatie(select){
  var result		= false;
  var data1 		= $(select).serializeArray();
  var count 		= 0;
  var datacount 	= data1.length;
  var testRq 		= 0;
  while(datacount != count){
    var aName  	= data1[count].name;
    var aValue 	= data1[count].value;
    var aselect	= "input[name=" + aName + "]";
    var aId 	= $(aselect).attr("id");
    aId2 	= '#'+aId;
    var aRq		= $(aId2).attr("required");

    // check required
    if(aId){
      elementinfo(aId, aValue);
      if (elementReadonly != 'readonly') {
        if(aRq){
          if(aValue.length==0){
            $(aId2).removeClass().addClass("inputFout");
            testRq++;
          }else{
            $(aId2).removeClass().addClass("inputCorrect");
          }
        }
        // check pattern
        var valres = validateInput(aValue,aId);		
        if(valres==false){
          if(aRq){
            testRq++;
            $(aId2).removeClass().addClass("inputFout");
          }else{
            $(aId2).removeClass().addClass("inputCorrect");
          }
        }	
      }
    }
    count++;
  }
  if(testRq>0){
    return false;
  }else{
    return true;
  }
}
