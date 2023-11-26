<?PHP exit('QQÈº£º550494646');?>
<script>
function showFace(showid, target,dropstr) {
	if(document.getElementById(showid + '_menu') != null) {
		var smilemenucss = document.getElementById(showid+'_menu').style.display;
		if(smilemenucss == ''){
			document.getElementById(showid+'_menu').style.display = 'none';
			
			$("#message_face i").css("color","#666");
		}else{
			document.getElementById(showid+'_menu').style.display = '';
			
			$("#message_face i").css("color","#d43d3d");
		}
	} else {
		var faceDiv = document.createElement("div");
		faceDiv.id = showid+'_menu';
		faceDiv.className = 'ainuo_facemenu cl';
		var faceul = document.createElement("ul");
		for(i=1; i<40; i++) {
			var faceli = document.createElement("li");
			faceli.innerHTML = '<img src="' + SITEURL + 'static/image/smiley/comcom/'+i+'.gif" onclick="insertFace(\''+showid+'\','+i+', \''+ target +'\', \''+dropstr+'\')" style="cursor:pointer; position:relative;" />';
			faceul.appendChild(faceli);
		}
		faceDiv.appendChild(faceul);
		document.getElementById('ainuo_facemenu').appendChild(faceDiv);
		
		$("#message_face i").css("color","#d43d3d");
	}
	//_attachEvent(document.body, 'click', function(){if(document.getElementById(showid+'_menu')) document.getElementById(showid+'_menu').style.display = 'none';});
}
function insertFace(showid, id, target, dropstr) {
	var faceText = '[em:'+id+':]';
	if(document.getElementById(target) != null) {
		insertContent(target, faceText);

	}
}
function checkFocus(target) {
	var obj = document.getElementById(target);
	if(!obj.hasfocus) {
		obj.focus();
	}
}
function insertContent(target, text) {
	var obj = document.getElementById(target);
	selection = document.selection;
	checkFocus(target);
	if(!isUndefined(obj.selectionStart)) {
		var opn = obj.selectionStart + 0;
		obj.value = obj.value.substr(0, obj.selectionStart) + text + obj.value.substr(obj.selectionEnd);
	} else if(selection && selection.createRange) {
		var sel = selection.createRange();
		sel.text = text;
		sel.moveStart('character', -strlen(text));
	} else {
		obj.value += text;
	}
}
</script>