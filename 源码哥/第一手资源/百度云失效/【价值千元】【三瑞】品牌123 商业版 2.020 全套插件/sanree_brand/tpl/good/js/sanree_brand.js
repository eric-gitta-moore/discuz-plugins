function atarget(obj) {
	obj.target = getcookie('atarget') > 0 ? '_blank' : '';
}
function setatarget(v) {
	$('atarget').className = 'y atarget_' + v;
	$('atarget').onclick = function() {setatarget(v == 1 ? -1 : 1);};
	setcookie('atarget', v, 2592000);
}
function onmousemovet(obj){
	if (obj&&BROWSER.ie) {
		obj.style.border ="1px solid #dab14a";
		obj.style.background = "#FFFFFF url(source/plugin/sanree_brand/tpl/good/images/ton.gif) bottom right no-repeat";
	}
}
function onmouseoutt(obj){
	if (obj&&BROWSER.ie) {
		obj.style.border ="1px solid #DCDCDC";
		obj.style.background ='#FFFFFF';
	}
}
function setthis(obj) {
	obj.value="";
	obj.style.color='#000000';
}
function favoriteupdate() {
	var obj = $('favoritenumber'+stid);
	if (obj)obj.innerHTML = parseInt(obj.innerHTML) + 1;
}
function shareupdate() {
	var obj = $('sharenumber'+stid);
	if (obj) obj.innerHTML = parseInt(obj.innerHTML) + 1;
}

function showit(id){
   var obj = $('dshow'+id);
   if (obj.style.height!=='auto') {
	   obj.style.height = 'auto';
	   $('onbtn'+id).style.display ='none';
	   $('offbtn'+id).style.display ='block';
	   setcookie('dshow'+id,"1",60*60*24);
   }
   else {
	   obj.style.height = '43px';
	   $('onbtn'+id).style.display ='block';
	   $('offbtn'+id).style.display ='none';	   
	   setcookie('dshow'+id,"0");
   }
}

function showdefault(){
	for(var j=1; j<5;j++) {
	   var p = getcookie('dshow'+j);
	   if ($('offbtn'+j)) $('offbtn'+j).style.display ='none';
	   if (p==1) {
		   var obj = $('dshow'+j);
		   if (obj) obj.style.height = 'auto';
		   if ($('onbtn'+j)) $('onbtn'+j).style.display ='none';
		   if ($('offbtn'+j)) $('offbtn'+j).style.display ='block';
	   }
	}
}
showdefault();
function srloadjs(src) {
    document.write('<script type="text/javascript" src="'+src+'"></script>');
}
