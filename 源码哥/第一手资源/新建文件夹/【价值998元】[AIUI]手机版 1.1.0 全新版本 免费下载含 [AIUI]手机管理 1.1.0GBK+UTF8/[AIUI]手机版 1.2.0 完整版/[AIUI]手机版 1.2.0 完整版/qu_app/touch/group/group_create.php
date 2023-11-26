<?PHP exit('QQÈº£º550494646');?>
<div class="group_add" id="main_messaqge">
	<div class="ainuodashedtip cl" style="margin:10px;">{lang group_you_have}</div>
	<div class="cl" style="border-top:1px solid #eee;">
		<form method="post" autocomplete="off" name="groupform" id="groupform" class="s_clear" onsubmit="checkCategory();ajaxpost('groupform', 'returnmessage4', 'returnmessage4', 'onerror');return false;" action="forum.php?mod=group&action=create">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<input type="hidden" name="referer" value="{echo dreferer()}" />
			<input type="hidden" name="handlekey" value="creategroup" />
			<table cellspacing="0" cellpadding="0" width="100%" summary="{lang group_create}">
				<tbody>
					<tr>
						<th>{lang group_name}:<span class="rq">*</span></th>
						<td>
							<input type="text" name="name" id="name" class="px" size="36" tabindex="1" value="" autocomplete="off" onBlur="checkgroupname()" tabindex="1" />
							<span id="groupnamecheck" class="xi1"></span>
						</td>
					</tr>
					<tr>
						<th style="height:75px;">{lang group_category}:<span class="rq">*</span></th>
						<td style="height:75px;">
							<select name="parentid" tabindex="2" class="ps" onchange="ajaxget('forum.php?mod=ajax&action=secondgroup&fupid='+ this.value, 'secondgroup');" style="margin-top:10px;">
								<option value="0">{lang choose_please}</option>
								$groupselect[first]
							</select>
							<em id="secondgroup"></em>
							<span id="groupcategorycheck" class="xi1"></span>
						</td>
					</tr>
					<tr>
						<th>{lang group_description}:</th>
						<td>
							<script type="text/javascript">
								var allowbbcode = allowimgcode = parsetype = 1;
								var allowhtml = forumallowhtml = allowsmilies = 0;
							</script>
                          
							
							<div id="descriptionpreview"></div>
							<div class="tedt">
								<div class="area">
									<textarea id="descriptionmessage" name="descriptionnew" tabindex="3" class="px" rows="3"></textarea>
								</div>
							</div>
					</tr>
					<tr>
						<th>{lang group_perm_visit}:<span class="rq">*</span></th>
						<td>
							<label class="lb"><input type="radio" name="gviewperm" class="pr" tabindex="4" value="1" checked="checked" />{lang group_perm_all_user}</label>
							<label class="lb"><input type="radio" name="gviewperm" class="pr" value="0" />{lang group_perm_member_only}</label>
						</td>
					</tr>
					<tr>
						<th>{lang group_join_type}:<span class="rq">*</span></th>
						<td>
							<label class="lb"><input type="radio" name="jointype" class="pr" tabindex="5" value="0" checked="checked" />{lang group_join_type_free}</label>
							<label class="lb"><input type="radio" name="jointype" class="pr" value="2" />{lang group_join_type_moderate}</label>
							<label class="lb"><input type="radio" name="jointype" class="pr" value="1" />{lang group_join_type_invite}</label>
						</td>
					</tr>
					<tr>
						<td colspan="2" style=" padding-left:0; height:52px;">
							<input type="hidden" name="createsubmit" value="true"><button type="submit" tabindex="6" class="ainuoformdialog">{lang create}</button>
							<!--{if $_G['group']['buildgroupcredits']}-->&nbsp;&nbsp;&nbsp;(<strong class="rq">{lang group_create_buildcredits} $_G['group']['buildgroupcredits'] $_G['setting']['extcredits'][$creditstransextra]['unit']{$_G['setting']['extcredits'][$creditstransextra]['title']}</strong>)<!--{/if}-->
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</div>
<script type="text/javascript">
	function checkgroupname() {
		var groupname = trim(document.getElementById('name').value);
		ajaxget('forum.php?mod=ajax&forumcheck=1&infloat=creategroup&handlekey=creategroup&action=checkgroupname&groupname=' + (document.charset == 'utf-8' ? encodeURIComponent(groupname) : groupname), 'groupnamecheck');
	}
	function checkCategory(){
		var groupcategory = trim(document.getElementById('fup').value);
		if(groupcategory == ''){
			document.getElementById('groupcategorycheck').innerHTML = '{lang group_create_selete_categroy}';
			return false;
		} else {
			document.getElementById('groupcategorycheck').innerHTML = '';
		}
	}
	<!--{if $_GET['fupid']}-->
			ajaxget('forum.php?mod=ajax&action=secondgroup&fupid=$_GET[fupid]<!--{if $_GET[groupid]}-->&groupid=$_GET[groupid]<!--{/if}-->', 'secondgroup');
	<!--{/if}-->
	if($('name')) {
		$('name').focus();
	}
function trim(str) {
	return (str + '').replace(/(\s+)$/g, '').replace(/^\s+/g, '');
}
function strlen(str) {
	return (str.indexOf('\n') != -1) ? str.replace(/\r?\n/g, '_').length : str.length;
}
function ajaxget(url, showid, waitid, loading, display, recall) {
	var x = new Ajax();
	x.showId = document.getElementById(showid);

	if(url.substr(strlen(url) - 1) == '#') {
		url = url.substr(0, strlen(url) - 1);
		x.autogoto = 1;
	}

	var url = url + '&inajax=1&ajaxtarget=' + showid;
	x.get(url, function(s, x) {
		var evaled = false;
		if(s.indexOf('ajaxerror') != -1) {
			evalscript(s);
			evaled = true;
		}
		if(!evaled && (typeof ajaxerror == 'undefined' || !ajaxerror)) {
			if(x.showId) {
				x.showId.style.display = x.display;
				ajaxinnerhtml(x.showId, s);
				ajaxupdateevents(x.showId);
				if(x.autogoto) scroll(0, x.showId.offsetTop);
			}
		}

		ajaxerror = null;
		if(recall && typeof recall == 'function') {
			recall();
		} else if(recall) {
			eval(recall);
		}
		if(!evaled) evalscript(s);
	});
}
function ajaxinnerhtml(showid, s) {
	if(showid.tagName != 'TBODY') {
		showid.innerHTML = s;
	} else {
		while(showid.firstChild) {
			showid.firstChild.parentNode.removeChild(showid.firstChild);
		}
		var div1 = document.createElement('DIV');
		div1.id = showid.id+'_div';
		div1.innerHTML = '<table><tbody id="'+showid.id+'_tbody">'+s+'</tbody></table>';
		document.getElementById('append_parent').appendChild(div1);
		var trs = div1.getElementsByTagName('TR');
		var l = trs.length;
		for(var i=0; i<l; i++) {
			showid.appendChild(trs[0]);
		}
		var inputs = div1.getElementsByTagName('INPUT');
		var l = inputs.length;
		for(var i=0; i<l; i++) {
			showid.appendChild(inputs[0]);
		}
		div1.parentNode.removeChild(div1);
	}
}
function ajaxupdateevents(obj, tagName) {
	tagName = tagName ? tagName : 'A';
	var objs = obj.getElementsByTagName(tagName);
	for(k in objs) {
		var o = objs[k];
		ajaxupdateevent(o);
	}
}

function ajaxupdateevent(o) {
	if(typeof o == 'object' && o.getAttribute) {
		if(o.getAttribute('ajaxtarget')) {
			if(!o.id) o.id = Math.random();
			var ajaxevent = o.getAttribute('ajaxevent') ? o.getAttribute('ajaxevent') : 'click';
			var ajaxurl = o.getAttribute('ajaxurl') ? o.getAttribute('ajaxurl') : o.href;
			_attachEvent(o, ajaxevent, newfunction('ajaxget', ajaxurl, o.getAttribute('ajaxtarget'), o.getAttribute('ajaxwaitid'), o.getAttribute('ajaxloading'), o.getAttribute('ajaxdisplay')));
			if(o.getAttribute('ajaxfunc')) {
				o.getAttribute('ajaxfunc').match(/(\w+)\((.+?)\)/);
				_attachEvent(o, ajaxevent, newfunction(RegExp.$1, RegExp.$2));
			}
		}
	}
}
function Ajax(recvType, waitId) {
	var aj = new Object();
	aj.loading = 'Waiting...';
	aj.recvType = recvType ? recvType : 'XML';
	aj.waitId = waitId ? $(waitId) : null;
	aj.resultHandle = null;
	aj.sendString = '';
	aj.targetUrl = '';
	aj.setLoading = function(loading) {
		if(typeof loading !== 'undefined' && loading !== null) aj.loading = loading;
	};
	aj.setRecvType = function(recvtype) {
		aj.recvType = recvtype;
	};
	aj.setWaitId = function(waitid) {
		aj.waitId = typeof waitid == 'object' ? waitid : $(waitid);
	};
	aj.createXMLHttpRequest = function() {
		var request = false;
		if(window.XMLHttpRequest) {
			request = new XMLHttpRequest();
			if(request.overrideMimeType) {
				request.overrideMimeType('text/xml');
			}
		} else if(window.ActiveXObject) {
			var versions = ['Microsoft.XMLHTTP', 'MSXML.XMLHTTP', 'Microsoft.XMLHTTP', 'Msxml2.XMLHTTP.7.0', 'Msxml2.XMLHTTP.6.0', 'Msxml2.XMLHTTP.5.0', 'Msxml2.XMLHTTP.4.0', 'MSXML2.XMLHTTP.3.0', 'MSXML2.XMLHTTP'];
			for(var i=0; i<versions.length; i++) {
				try {
					request = new ActiveXObject(versions[i]);
					if(request) {
						return request;
					}
				} catch(e) {}
			}
		}
		return request;
	};
	aj.XMLHttpRequest = aj.createXMLHttpRequest();
	aj.showLoading = function() {
		if(aj.waitId && (aj.XMLHttpRequest.readyState != 4 || aj.XMLHttpRequest.status != 200)) {
			aj.waitId.style.display = '';
			aj.waitId.innerHTML = '<span><img src="' + IMGDIR + '/loading.gif" class="vm"> ' + aj.loading + '</span>';
		}
	};
	aj.processHandle = function() {
		if(aj.XMLHttpRequest.readyState == 4 && aj.XMLHttpRequest.status == 200) {
			if(aj.waitId) {
				aj.waitId.style.display = 'none';
			}
			if(aj.recvType == 'HTML') {
				aj.resultHandle(aj.XMLHttpRequest.responseText, aj);
			} else if(aj.recvType == 'XML') {
				if(!aj.XMLHttpRequest.responseXML || !aj.XMLHttpRequest.responseXML.lastChild || aj.XMLHttpRequest.responseXML.lastChild.localName == 'parsererror') {
					aj.resultHandle('' , aj);
				} else {
					aj.resultHandle(aj.XMLHttpRequest.responseXML.lastChild.firstChild.nodeValue, aj);
				}
			} else if(aj.recvType == 'JSON') {
				var s = null;
				try {
					s = (new Function("return ("+aj.XMLHttpRequest.responseText+")"))();
				} catch (e) {
					s = null;
				}
				aj.resultHandle(s, aj);
			}
		}
	};
	aj.get = function(targetUrl, resultHandle) {
		targetUrl = hostconvert(targetUrl);
		setTimeout(function(){aj.showLoading()}, 250);
		aj.targetUrl = targetUrl;
		aj.XMLHttpRequest.onreadystatechange = aj.processHandle;
		aj.resultHandle = resultHandle;
		var attackevasive = isUndefined(attackevasive) ? 0 : attackevasive;
		if(window.XMLHttpRequest) {
			aj.XMLHttpRequest.open('GET', aj.targetUrl);
			aj.XMLHttpRequest.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
			aj.XMLHttpRequest.send(null);
		} else {
			aj.XMLHttpRequest.open("GET", targetUrl, true);
			aj.XMLHttpRequest.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
			aj.XMLHttpRequest.send();
		}
	};
	aj.post = function(targetUrl, sendString, resultHandle) {
		targetUrl = hostconvert(targetUrl);
		setTimeout(function(){aj.showLoading()}, 250);
		aj.targetUrl = targetUrl;
		aj.sendString = sendString;
		aj.XMLHttpRequest.onreadystatechange = aj.processHandle;
		aj.resultHandle = resultHandle;
		aj.XMLHttpRequest.open('POST', targetUrl);
		aj.XMLHttpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		aj.XMLHttpRequest.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		aj.XMLHttpRequest.send(aj.sendString);
	};
	aj.getJSON = function(targetUrl, resultHandle) {
		aj.setRecvType('JSON');
		aj.get(targetUrl+'&ajaxdata=json', resultHandle);
	};
	aj.getHTML = function(targetUrl, resultHandle) {
		aj.setRecvType('HTML');
		aj.get(targetUrl+'&ajaxdata=html', resultHandle);
	};
	return aj;
}
function getHost(url) {
	var host = "null";
	if(typeof url == "undefined"|| null == url) {
		url = window.location.href;
	}
	var regex = /^\w+\:\/\/([^\/]*).*/;
	var match = url.match(regex);
	if(typeof match != "undefined" && null != match) {
		host = match[1];
	}
	return host;
}
function hostconvert(url) {
	if(!url.match(/^https?:\/\//)) url = SITEURL + url;
	var url_host = getHost(url);
	var cur_host = getHost().toLowerCase();
	if(url_host && cur_host != url_host) {
		url = url.replace(url_host, cur_host);
	}
	return url;
}
</script>