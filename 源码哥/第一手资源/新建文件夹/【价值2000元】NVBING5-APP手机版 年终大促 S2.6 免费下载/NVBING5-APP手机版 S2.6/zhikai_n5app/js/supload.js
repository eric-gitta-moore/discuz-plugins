
function openShutManager(oSourceObj,oTargetObj,shutAble,oOpenTip,oShutTip){
var sourceObj = typeof oSourceObj == "string" ? document.getElementById(oSourceObj) : oSourceObj;
var targetObj = typeof oTargetObj == "string" ? document.getElementById(oTargetObj) : oTargetObj;
var openTip = oOpenTip || "";
var shutTip = oShutTip || "";
if(targetObj.style.display!="block"){
   if(shutAble) return;
   targetObj.style.display="block";
   if(openTip && shutTip){
    sourceObj.innerHTML = shutTip;
   }
} else {
   targetObj.style.display="none";
   if(openTip && shutTip){
    sourceObj.innerHTML = openTip;
   }
}
}

function addface(tagname, tag) {
	var myField;
	if (document.getElementById(tagname) && document.getElementById(tagname).type == 'textarea') {
		myField = document.getElementById(tagname);
	}
	else {
		return false;
	}
	if (document.selection) {
		myField.focus();
		sel = document.selection.createRange();
		sel.text = tag;
		myField.focus();
	}
	else if (myField.selectionStart || myField.selectionStart == '0') {
		var startPos = myField.selectionStart;
		var endPos = myField.selectionEnd;
		var cursorPos = endPos;
		myField.value = myField.value.substring(0, startPos)
			+ tag
			+ myField.value.substring(endPos, myField.value.length);
		cursorPos += tag.length;
		myField.focus();
		myField.selectionStart = cursorPos;
		myField.selectionEnd = cursorPos;
	}
	else {
		myField.value += tag;
		myField.focus();
	}
}

function uploadWindow(fid, recall, type) {	
	
	var type = isUndefined(type) ? 'image' : type;
	UPLOADWINRECALL = recall;	
	$('#upfile').load('./forum.php?mod=misc&action=upload&fid=' + fid + '&type=' + type + 'mobile=2')
}

function hideWindow(k) {
 	$("#"+k).remove();
}

function showError(msg) {
	var p = /<script[^\>]*?>([^\x00]*?)<\/script>/ig;
	msg = msg.replace(p, '');
	if(msg !== '') {
		showDialog(msg, 'alert', '′í?óD??￠', null, true, null, '', '', '', 3);
	}
}

function updatetradeattach(aid, url, attachurl) {
	Scratching('tradeaid').value = aid;
	Scratching('tradeattach_image').innerHTML = '<img src="' + attachurl + '/' + url + '" class="spimg" />';
	ATTACHORIMAGE = 1;
}

function updateactivityattach(aid, url, attachurl) {
	Scratching('activityaid').value = aid;
	Scratching('activityattach_image').innerHTML = '<img src="' + attachurl + '/' + url + '" class="spimg" />';
	ATTACHORIMAGE = 1;
}

function updatesortattach(aid, url, attachurl, identifier) {	
	Scratching('sortaid_' + identifier).value = aid;
	Scratching('sortattachurl_' + identifier).value = attachurl + '/' + url;
	Scratching('sortattach_image_' + identifier).innerHTML = '<img src="' + attachurl + '/' + url + '" class="spimg" />';
	ATTACHORIMAGE = 1;
}

function uploadWindowstart() {
	alert();
	Scratching('uploadwindowing').style.visibility = 'visible';
}

function uploadWindowload() {	
	Scratching('uploadwindowing').style.visibility = 'hidden';
	var str = Scratching('uploadattachframe').contentWindow.document.body.innerHTML;
	if(str == '') return;	
	var arr = str.split('|');
	if(arr[0] == 'DISCUZUPLOAD' && arr[2] == 0) {
		UPLOADWINRECALL(arr[3], arr[5], arr[6]);
		hideWindow('upfilecoose');
	} else {
		var sizelimit = '';
		if(arr[7] == 'ban') {
			sizelimit = '(附件类型被禁止)';
		} else if(arr[7] == 'perday') {
			sizelimit = '(不能超过 ' + arr[8] + ' 字节)';
		} else if(arr[7] > 0) {
			sizelimit = '(不能超过 ' + arr[7] + ' 字节)';
		}
		showError(STATUSMSG[arr[2]] + sizelimit);
	}
	if(Scratching('attachlimitnotice')) {
		ajaxget('forum.php?mod=ajax&action=updateattachlimit&fid=' + fid, 'attachlimitnotice');
	}
	
}

var showDialogST = null;
function showDialog(msg, mode, t, func, cover, funccancel, leftmsg, confirmtxt, canceltxt, closetime, locationtime) {
	clearTimeout(showDialogST);
	cover = isUndefined(cover) ? (mode == 'info' ? 0 : 1) : cover;
	leftmsg = isUndefined(leftmsg) ? '' : leftmsg;
	mode = in_array(mode, ['confirm', 'notice', 'info', 'right']) ? mode : 'alert';
	var menuid = 'fwin_dialog';
	var menuObj = Scratching(menuid);
	var showconfirm = 1;
	confirmtxtdefault = 'è·?¨';
	closetime = isUndefined(closetime) ? '' : closetime;
	closefunc = function () {
		if(typeof func == 'function') func();
		else eval(func);
		hideMenu(menuid, 'dialog');
	};
	if(closetime) {
		showPrompt(null, null, '<i>' + msg + '</i>', closetime * 1000, 'popuptext');
		return;
	}
	locationtime = isUndefined(locationtime) ? '' : locationtime;
	if(locationtime) {
		leftmsg = locationtime + ' ??oóò3??ì?×a';
		showDialogST = setTimeout(closefunc, locationtime * 1000);
		showconfirm = 0;
	}
	confirmtxt = confirmtxt ? confirmtxt : confirmtxtdefault;
	canceltxt = canceltxt ? canceltxt : 'è???';

	if(menuObj) hideMenu('fwin_dialog', 'dialog');
	menuObj = document.createElement('div');
	menuObj.style.display = 'none';
	menuObj.className = 'fwinmask';
	menuObj.id = menuid;
	Scratching('append_parent').appendChild(menuObj);
	var hidedom = '';
	if(!BROWSER.ie) {
		hidedom = '<style type="text/css">object{visibility:hidden;}</style>';
	}
	var s = hidedom + '<table cellpadding="0" cellspacing="0" class="fwin"><tr><td class="t_l"></td><td class="t_c"></td><td class="t_r"></td></tr><tr><td class="m_l">&nbsp;&nbsp;</td><td class="m_c"><h3 class="flb"><em>';
	s += t ? t : 'ìáê?D??￠';
	s += '</em><span><a href="javascript:;" id="fwin_dialog_close" class="flbc" onclick="hideMenu(\'' + menuid + '\', \'dialog\')" title="1?±?">1?±?</a></span></h3>';
	if(mode == 'info') {
		s += msg ? msg : '';
	} else {
		s += '<div class="c altw"><div class="' + (mode == 'alert' ? 'alert_error' : (mode == 'right' ? 'alert_right' : 'alert_info')) + '"><p>' + msg + '</p></div></div>';
		s += '<p class="o pns">' + (leftmsg ? '<span class="z xg1">' + leftmsg + '</span>' : '') + (showconfirm ? '<button id="fwin_dialog_submit" value="true" class="pn pnc"><strong>'+confirmtxt+'</strong></button>' : '');
		s += mode == 'confirm' ? '<button id="fwin_dialog_cancel" value="true" class="pn" onclick="hideMenu(\'' + menuid + '\', \'dialog\')"><strong>'+canceltxt+'</strong></button>' : '';
		s += '</p>';
	}
	s += '</td><td class="m_r"></td></tr><tr><td class="b_l"></td><td class="b_c"></td><td class="b_r"></td></tr></table>';
	menuObj.innerHTML = s;
	if(Scratching('fwin_dialog_submit')) Scratching('fwin_dialog_submit').onclick = function() {
		if(typeof func == 'function') func();
		else eval(func);
		hideMenu(menuid, 'dialog');
	};
	if(Scratching('fwin_dialog_cancel')) {
		Scratching('fwin_dialog_cancel').onclick = function() {
			if(typeof funccancel == 'function') funccancel();
			else eval(funccancel);
			hideMenu(menuid, 'dialog');
		};
		Scratching('fwin_dialog_close').onclick = Scratching('fwin_dialog_cancel').onclick;
	}
	showMenu({'mtype':'dialog','menuid':menuid,'duration':3,'pos':'00','zindex':JSMENU['zIndex']['dialog'],'cache':0,'cover':cover});
	try {
		if(Scratching('fwin_dialog_submit')) Scratching('fwin_dialog_submit').focus();
	} catch(e) {}
}


