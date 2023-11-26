<?PHP exit('QQÈº£º550494646');?>
<div class="tbmu cl">
	<a href="forum.php?mod=group&action=manage&op=group&fid=$_G[fid]"{if $_GET['op'] == 'group'} class="a"{/if}>$alang_set</a>
<!--{if !empty($groupmanagers[$_G[uid]]) || $_G['adminid'] == 1}-->
	<a href="forum.php?mod=group&action=manage&op=checkuser&fid=$_G[fid]"{if $_GET['op'] == 'checkuser'} class="a"{/if}>{lang group_member_moderate}</a>
	<a href="forum.php?mod=group&action=manage&op=manageuser&fid=$_G[fid]"{if $_GET['op'] == 'manageuser'} class="a"{/if} style="display:none;">{lang group_member_management}</a>
<!--{/if}-->
<!--{if $_G['forum']['founderuid'] == $_G['uid'] || $_G['adminid'] == 1}-->
	<a href="forum.php?mod=group&action=manage&op=threadtype&fid=$_G[fid]"{if $_GET['op'] == 'threadtype'} class="a"{/if} style="display:none;">$alang_sort</a>
	<a href="forum.php?mod=group&action=manage&op=demise&fid=$_G[fid]"{if $_GET['op'] == 'demise'} class="a"{/if} style="display:none;">$alang_turn</a>
<!--{/if}-->
</div>

<!--{if $_GET['op'] == 'group'}-->
	<div class="aset">
		<form enctype="multipart/form-data" action="forum.php?mod=group&action=manage&op=group&fid=$_G[fid]" name="manage" method="post" autocomplete="off">
			<input type="hidden" value="{FORMHASH}" name="formhash" />
			<table cellspacing="0" cellpadding="0" class="tfm vt" summary="{lang group_admin_panel}">
				<tbody>
					<!--{if !empty($specialswitch['allowchangename']) && ($_G['uid'] == $_G['forum']['founderuid'] || $_G['adminid'] == 1)}-->
					<tr>
						<th><span class="rq">*</span>{lang group_name}:</th>
						<td><input type="text" id="name" name="name" class="px" size="36" tabindex="1" value="$_G[forum][name]" autocomplete="off" tabindex="1" /></td>
					</tr>
					<!--{/if}-->
					<!--{if !empty($specialswitch['allowchangetype']) && ($_G['uid'] == $_G['forum']['founderuid'] || $_G['adminid'] == 1)}-->
					<tr>
						<th><span class="rq">*</span>{lang group_category}:</th>
						<td>
							<select name="parentid" tabindex="2" class="ps" onchange="ajaxget('forum.php?mod=ajax&action=secondgroup&fupid='+ this.value, 'secondgroup');">
								$groupselect[first]
							</select>
							<em id="secondgroup"><!--{if $groupselect['second']}--><select id="fup" name="fup" class="ps" >$groupselect[second]</select><!--{/if}--></em>
						</td>
					</tr>
					<!--{/if}-->
					<tr>
						<th>{lang group_description}:</th>
						<td>

							<div id="descriptionpreview"></div>
							<div class="tedt">
								<div class="area">
									<textarea id="descriptionmessage" name="descriptionnew" class="px" rows="3">$_G[forum][descriptionnew]</textarea>
								</div>
							</div>
					</tr>
					<tr>
						<th>{lang group_perm_visit}:</th>
						<td>
							<label class="lb"><input type="radio" name="gviewpermnew" class="pr" value="1" $gviewpermselect[1] />{lang group_perm_all_user}</label>
							<label class="lb"><input type="radio" name="gviewpermnew" class="pr" value="0" $gviewpermselect[0] />{lang group_perm_member_only}</label>
						</td>
					</tr>
					<tr>
						<th>{lang group_join_type}:</th>
						<td>
							<label class="lb"><input type="radio" name="jointypenew" class="pr" value="0" $jointypeselect[0] />{lang group_join_type_free}</label>
							<label class="lb"><input type="radio" name="jointypenew" class="pr" value="2" $jointypeselect[2] />{lang group_join_type_moderate}</label>
							<label class="lb"><input type="radio" name="jointypenew" class="pr" value="1" $jointypeselect[1] />{lang group_join_type_invite}</label>
							<!--{if !empty($specialswitch['allowclosegroup'])}-->
							<label class="lb"><input type="radio" name="jointypenew" class="pr" value="-1" $jointypeselect[-1] />{lang close}</label>
							<p class="d">{lang group_close_notice}</p>
							<!--{/if}-->
						</td>
					</tr>
					<!--{if $_G['setting']['allowgroupdomain'] && !empty($_G['setting']['domain']['root']['group']) && $domainlength}-->
					<tr>
						<th>{lang subdomain}:</th>
						<td>
							http://<input type="text" name="domain" class="px" value="$_G[forum][domain]" />.{$_G['setting']['domain']['root']['group']}
							<p class="d">
								{lang group_domain_message}<br/>
								<!--{if $_G[forum][domain] && $consume}-->{lang group_edit_domain_message}<!--{/if}-->
							</p>
						</td>
					</tr>
					<!--{/if}-->
					<!--{if !empty($_G['group']['allowupbanner']) || $_G['adminid'] == 1}-->
					<tr>
						<th>$alang_toppic:</th>
						<td>
							<input type="file" name="bannernew" id="bannernew" class="pf" size="25" />
                            <!--{if $_G['forum']['banner']}-->
                            <div class="addpic cl"><span><i class="iconfont icon-add1"></i>$alang_xgtp</span></div>
							<label><input type="checkbox" name="deletebanner" class="pc" value="1" />{lang group_no_image}</label>
                            <img src="$_G[forum][banner]?{TIMESTAMP}" />
							<!--{else}-->
                            <div class="addpic cl"><span><i class="iconfont icon-add1"></i>$alang_sctp</span></div>
                            <!--{/if}-->
						</td>
					</tr>
					<!--{/if}-->
					<tr>
						<th>{lang group_icon}:</th>
						<td>
							<input type="file" id="iconnew" class="pf" size="25" name="iconnew" />
                            <!--{if $_G['forum']['icon']}-->
                            	<div class="addpic cl"><span><i class="iconfont icon-add1"></i>$alang_xgtp</span></div>
								<img width="48" height="48" alt="" class="vm" style="margin-right: 1em;" src="$_G[forum][icon]?{TIMESTAMP}" />
							<!--{else}-->
                            	<div class="addpic cl"><span><i class="iconfont icon-add1"></i>$alang_sctp</span></div>
                            <!--{/if}-->
                            <p class="d" style="margin-top:10px;">{lang group_icon_resize}</p>
						</td>
					</tr>
					<tr>
						<td align="center" colspan="2"><button type="submit" name="groupmanage" value="1">{lang submit}</button></td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
<!--{elseif $_GET['op'] == 'checkuser'}-->
	<!--{if $checkusers}-->
		<div class="acheck">
		<!--{loop $checkusers $uid $user}-->
			<dl>
				<!--{echo avatar($user[uid], 'middle')}-->
				<dt><a href="home.php?mod=space&uid=$user[uid]">$user[username]</a> <span class="xw0">($user['joindateline'])</span></dt>
				<dd><button type="submit" name="checkusertrue" class="a_btn1" value="true" onclick="location.href='forum.php?mod=group&action=manage&op=checkuser&fid=$_G[fid]&uid=$user[uid]&checktype=1'"><em>{lang pass}</em></button> &nbsp; <button type="submit" name="checkuserfalse" class="a_btn2" value="true" onclick="location.href='forum.php?mod=group&action=manage&op=checkuser&fid=$_G[fid]&uid=$user[uid]&checktype=2'"><em>{lang ignore}</em></button></dd>
			</dl>
            
		<!--{/loop}-->
		</div>
		<!--{if $multipage}-->$multipage<!--{/if}-->
	<!--{else}-->
		<p class="emp">{lang group_no_member_moderated}</p>
	<!--{/if}-->
<!--{elseif $_GET['op'] == 'manageuser'}-->
	<script type="text/javascript">
		function groupManageUser(targetlevel_val) {
			$('targetlevel').value = targetlevel_val;
			$('manageuser').submit();
		}
	</script>

	<form action="forum.php?mod=group&action=manage&op=manageuser&fid=$_G[fid]&manageuser=true" name="manageuser" id="manageuser" method="post" autocomplete="off" class="ptm">
		<input type="hidden" value="{FORMHASH}" name="formhash" />
        <input type="hidden" value="0" name="targetlevel" id="targetlevel" />
		<!--{if $adminuserlist}-->
			<div class="group_member">
					<h2>{lang group_admin_member}</h2>
				<div class="">
					<ul>
						<!--{loop $adminuserlist $user}-->
						<li>
							<a href="home.php?mod=space&uid=$user[uid]" title="{if $user['level'] == 1}{lang group_moderator_title}{elseif $user['level'] == 2}{lang group_moderator_vice_title}{/if}{if $user['online']} {lang login_normal_mode}{/if}" class="avt">
								<!--{if $user['level'] == 1}-->
									<em class="gm"></em>
								<!--{elseif $user['level'] == 2}-->
									<em class="gm" style="filter: alpha(opacity=50); opacity: 0.5"></em>
								<!--{/if}-->
								<!--{if $user['online']}-->
									<em class="gol"></em>
								<!--{/if}-->
								<!--{echo avatar($user[uid], 'middle')}-->
							</a>
							<p><!--{if $_G['adminid'] == 1 || ($_G['uid'] != $user['uid'] && ($_G['uid'] == $_G['forum']['founderuid'] || $user['level'] > $groupuser['level']))}--><input type="checkbox" class="pc" name="muid[{$user[uid]}]" value="$user[level]" /><!--{/if}--><a href="home.php?mod=space&uid=$user[uid]">$user[username]</a></p>
						</li>
						<!--{/loop}-->
					</ul>
				</div>
			</div>
		<!--{/if}-->
		<!--{if $staruserlist || $userlist}-->
			<div class="group_member">
					<h2>{lang member}</h2>
				<div class="">
				<!--{if $staruserlist}-->
					<ul>
						<!--{loop $staruserlist $user}-->
						<li>
							<a href="home.php?mod=space&uid=$user[uid]" title="{lang group_star_member_title}{if $user['online']} {lang login_normal_mode}{/if}" class="avt">
								<em class="gs"></em>
								<!--{if $user['online']}-->
									<em class="gol"{if $user['level'] <= 3} style="margin-top: 15px;"{/if}></em>
								<!--{/if}-->
								<!--{echo avatar($user[uid], 'middle')}-->
							</a>
							<p><!--{if $_G['adminid'] == 1 || $user['level'] > $groupuser['level']}--><input type="checkbox" class="pc" name="muid[{$user[uid]}]" value="$user[level]" /><!--{/if}--><a href="home.php?mod=space&uid=$user[uid]">$user[username]</a></p>
						</li>
						<!--{/loop}-->
					</ul>
				<!--{/if}-->
				<!--{if $userlist}-->
					<ul>
						<!--{loop $userlist $user}-->
						<li>
							<a href="home.php?mod=space&uid=$user[uid]" class="avt"><!--{echo avatar($user[uid], 'middle')}--></a>
							<p><!--{if $_G['adminid'] == 1 || $user['level'] > $groupuser['level']}--><input type="checkbox" class="pc" name="muid[{$user[uid]}]" value="$user[level]" /><!--{/if}--><a href="home.php?mod=space&uid=$user[uid]">$user[username]</a></p>
						</li>
						<!--{/loop}-->
					</ul>
				<!--{/if}-->
				</div>
			</div>
		<!--{/if}-->
		<!--{if $multipage}-->$multipage<!--{/if}-->
		<div class="group_memeber_m">
			<!--{loop $mtype $key $name}-->
            	<!--{if $_G['forum']['founderuid'] == $_G['uid'] || $key > $groupuser['level'] || $_G['adminid'] == 1}-->
                <button type="button" name="manageuser" value="true" class="a_btn1" onclick="groupManageUser('{$key}')"><span>$name</span></button>
                <!--{/if}-->
            <!--{/loop}-->
		</div>
	</form>
<!--{elseif $_GET['op'] == 'threadtype'}-->
	<div class="asort">
		<!--{if empty($specialswitch['allowthreadtype'])}-->
			{lang group_level_cannot_do}
		<!--{else}-->
		<script type="text/JavaScript">
			var rowtypedata = [
				[
					[1,'<input type="checkbox" class="pc" disabled="disabled" />', ''],
					[1,'<input type="checkbox" class="pc" name="newenable[]" checked="checked" value="1" />', ''],
					[1,'<input class="px" type="text" size="2" name="newdisplayorder[]" value="0" />'],
					[1,'<input class="px" type="text" name="newname[]" />']
				],
			];
			var addrowdirect = 0;
			var typenumlimit = $typenumlimit;
			function addrow(obj, type) {
				var table = obj.parentNode.parentNode.parentNode.parentNode;
				if(typenumlimit <= obj.parentNode.parentNode.parentNode.rowIndex - 1) {
					alert('{lang group_threadtype_limit_1}'+typenumlimit+'{lang group_threadtype_limit_2}');
					return false;
				}
				if(!addrowdirect) {
					var row = table.insertRow(obj.parentNode.parentNode.parentNode.rowIndex);
				} else {
					var row = table.insertRow(obj.parentNode.parentNode.parentNode.rowIndex + 1);
				}

				var typedata = rowtypedata[type];
				for(var i = 0; i <= typedata.length - 1; i++) {
					var cell = row.insertCell(i);
					cell.colSpan = typedata[i][0];
					var tmp = typedata[i][1];
					if(typedata[i][2]) {
						cell.className = typedata[i][2];
					}
					tmp = tmp.replace(/\{(\d+)\}/g, function($1, $2) {return addrow.arguments[parseInt($2) + 1];});
					cell.innerHTML = tmp;
				}
				addrowdirect = 0;
			}
		</script>
		<div id="threadtypes">
			<form id="threadtypeform" action="forum.php?mod=group&action=manage&op=threadtype&fid=$_G[fid]" autocomplete="off" method="post" name="threadtypeform">
				<input type="hidden" value="{FORMHASH}" name="formhash" />
				<table cellspacing="0" cellpadding="0" class="vt">
					<tr>
						<th>{lang threadtype_turn_on}:</th>
						<td>
							<label class="lb"><input type="radio" name="threadtypesnew[status]" class="pr" value="1" onclick="$('threadtypes_config').style.display = '';$('threadtypes_manage').style.display = '';" $checkeds[status][1] />{lang yes}</label>
							<label class="lb"><input type="radio" name="threadtypesnew[status]" class="pr" value="0" onclick="$('threadtypes_config').style.display = 'none';$('threadtypes_manage').style.display = 'none';"  $checkeds[status][0] />{lang no}</label>
						</td>
					</tr>
					<tbody id="threadtypes_config" style="display: $display">
						<tr>
							<th>{lang threadtype_required}:</th>
							<td>
								<label class="lb"><input type="radio" name="threadtypesnew[required]" class="pr" value="1" $checkeds[required][1] />{lang yes}</label>
								<label class="lb"><input type="radio" name="threadtypesnew[required]" class="pr" value="0" $checkeds[required][0] />{lang no}</label>
							</td>
						</tr>
						<tr>
							<th>{lang threadtype_prefix}:</th>
							<td>
								<label class="lb"><input type="radio" name="threadtypesnew[prefix]" class="pr" value="0" $checkeds[prefix][0] />{lang threadtype_prefix_off}</label>
								<label class="lb"><input type="radio" name="threadtypesnew[prefix]" class="pr" value="1" $checkeds[prefix][1] />{lang threadtype_prefix_on}</label>
							</td>
						</tr>
					</tbody>
				</table>
				<div id="threadtypes_manage" style="display: $display">
					<h2 class="ptm pbm">{lang threadtype}</h2>
					<table cellspacing="0" cellpadding="0" class="dt">
						<thead>
							<tr>
								<th width="15%">{lang delete}</th>
								<th width="10%">{lang enable}</th>
								<th width="15%">{lang displayorder}</th>
								<th width="60%">{lang threadtype_name}</th>
							</tr>
						</thead>
						<!--{if $threadtypes}-->
							<!--{loop $threadtypes $val}-->
							<tbody>
								<tr>
									<td><input type="checkbox" class="pc" name="threadtypesnew[options][delete][]" value="{$val[typeid]}" /></td>
									<td><input type="checkbox" class="pc" name="threadtypesnew[options][enable][{$val[typeid]}]" value="1" class="pc" $val[enablechecked] /></td>
									<td><input type="text" name="threadtypesnew[options][displayorder][{$val[typeid]}]" class="px" size="2" value="$val[displayorder]" /></td>
									<td><input type="text" name="threadtypesnew[options][name][{$val[typeid]}]" class="px" value="$val[name]" /></td>
								</tr>
							</tbody>
							<!--{/loop}-->
						<!--{/if}-->
						<tr>
							<td colspan="4"><img class="vm" src="{IMGDIR}/addicn.gif" /> <a href="javascript:;" onclick="addrow(this, 0)">{lang threadtype_add}</a></td>
						</tr>
					</table>
				</div>
				<button type="submit" class="a_btn1" name="groupthreadtype" value="1"><strong>{lang submit}</strong></button>
			</form>
		</div>
		<!--{/if}-->
	</div>
<!--{elseif $_GET['op'] == 'demise'}-->
	<div class="azhuanrang">
		<!--{if $groupmanagers}-->
			<div class="">
				{lang group_demise_comment}
				<div class="mtm">{lang group_demise_notice}</div>
			</div>
            <p class="atip">{lang transfer_group_to}:</p>
			<form action="forum.php?mod=group&action=manage&op=demise&fid=$_G[fid]" name="groupdemise" method="post" class="exfm">
				<input type="hidden" value="{FORMHASH}" name="formhash" />
				<table cellspacing="0" cellpadding="0" class="tfm vt">
					<tr>
						<td>
							<ul>
                            
								<!--{loop $groupmanagers $user}-->
                                <!--{if $user['uid'] != $_G['uid']}-->
								<li>
									<a href="home.php?mod=space&uid=$user[uid]" title="{if $user['level'] == 1}{lang group_moderator}{elseif $user['level'] == 2}{lang group_moderator_vice}{/if}{if $user['online']} {lang login_normal_mode}{/if}" class="avt">
										<!--{echo avatar($user[uid], 'middle')}-->
									</a>
									<p><input type="radio" class="pr" name="suid" value="$user[uid]" /><a href="home.php?mod=space&uid=$user[uid]">$user[username]</a></p>
								</li>
								<!--{/loop}-->
                                <!--{/if}-->
							</ul>
						</td>
					</tr>
					<tr>
						<th>{lang group_input_password}: &nbsp;</th>
						<td><input type="password" name="grouppwd" class="px" /></td>
					</tr>
					<tr>
						<th>&nbsp;</th>
						<td>
							<button type="submit" name="groupdemise" class="a_btn1" value="1"><strong>{lang submit}</strong></button>
						</td>
					</tr>
				</table>
			</form>
		<!--{else}-->
			<p class="emp">{lang group_no_admin_member}</p>
		<!--{/if}-->
	</div>
<!--{/if}-->

<script>
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