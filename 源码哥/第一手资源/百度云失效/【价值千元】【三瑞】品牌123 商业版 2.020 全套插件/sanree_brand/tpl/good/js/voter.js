window.onerror=function(){return true;}
function succeedhandle_fastpost(str){
	showDialog(votersucceed, 'right', '', null, true, null, '', '', '', 3);
	setTimeout("window.location.reload();", 3000);
}
function mestuHover() {
	var obj=document.getElementById("commentlist");
	var getElm = obj.getElementsByTagName("LI");
	for (var i=0; i<getElm.length; i++) {
	      var t = getElm[i].getElementsByTagName("label");
		  var p = t[0].getElementsByTagName("p")[0];
		  if(p.clientHeight>100) {
				p.style.height='100px';
				p.style.overflow='hidden';
				p.onmousemove=function (){
					this.style.height='auto';
				}
				p.onmouseout =function (){
					this.style.height='100px';
				}
		  }
	}
}
function fastpost(obj)
{
	if ($('star').value==0) {
		alert(langvoter[0]);
		return false;
	}
	ajaxpost('fastpostform', 'fastreturn_error', 'fastreturn_error' , '', '',function(){srshowdialog();});
	return false;
}

function fastnewpost(obj)
{
	if ($('star').value==0) {
		alert(langvoter[0]);
		return false;
	}

}

function setstar(star, obj) {
	var starshow = document.getElementById(obj);
	starshow.innerHTML = "";
	var i = 1;
	if (star < 3) {
	  for (; i <= star; i++) {
		starshow.innerHTML = starshow.innerHTML + ('<div onmouseup="setstar(' + i + ',\'' + obj + '\',1)" ><img src="source/plugin/sanree_brand/tpl/good/images/star3.jpg" width="16" height="15" /></div>');
	  }
	} else {
	  for (; i <= star; i++) {
		starshow.innerHTML = starshow.innerHTML + ('<div onmouseup="setstar(' + i + ',\'' + obj + '\',1)" ><img src="source/plugin/sanree_brand/tpl/good/images/star1.jpg" width="16" height="15" /></div>');
	  }
	}
	for (var j = i; j <= 5; j++) {
	  var html = starshow.innerHTML;
	  starshow.innerHTML = starshow.innerHTML + ('<div onmouseup="setstar(' + j + ',\'' + obj + '\',1)"><img src="source/plugin/sanree_brand/tpl/good/images/star2.jpg" width="16" height="15" /></div>');
	}
	$('star').value = star;
	$('desc').innerHTML = langvoter[1] + star;
}

function setnewstar(star, obj) {
	var starshow = document.getElementById(obj);
	starshow.innerHTML = "";
	var i = 1;
	  
	  for (; i <= star; i++) {
		starshow.innerHTML = starshow.innerHTML + ('<span onmouseover="setnewstar(' + i + ',\'' + obj + '\',1)" ><img src="source/plugin/sanree_brand/tpl/bird/images/staron.png" /></span>');
	  }
	  
	for (var j = i; j <= 5; j++) {
	  var html = starshow.innerHTML;
	  starshow.innerHTML = starshow.innerHTML + ('<span onmouseover="setnewstar(' + j + ',\'' + obj + '\',1)"><img src="source/plugin/sanree_brand/tpl/bird/images/staroff.png" /></span>');
	}
	jQuery('#star').val(star);
	jQuery('desc').html(langvoter[1] + star);
}

