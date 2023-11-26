<?php exit;?>
<div class="n5ht_lbfl cl">
<div class="dtmk_mkhd cl">
	<ul>
		<li{if $_GET['op'] == 'group'} class="a"{/if}><a href="forum.php?mod=group&action=manage&op=group&fid=$_G[fid]">{$n5app['lang']['qzszyybsz']}</a></li>
		<!--{if !empty($groupmanagers[$_G[uid]]) || $_G['adminid'] == 1}-->
			<li{if $_GET['op'] == 'checkuser'} class="a"{/if}><a href="forum.php?mod=group&action=manage&op=checkuser&fid=$_G[fid]">{lang group_member_moderate}</a></li>
			<li{if $_GET['op'] == 'manageuser'} class="a"{/if}><a href="forum.php?mod=group&action=manage&op=manageuser&fid=$_G[fid]">{lang group_member_management}</a></li>
		<!--{/if}-->
		<!--{if $_G['forum']['founderuid'] == $_G['uid'] || $_G['adminid'] == 1}-->
			<li{if $_GET['op'] == 'threadtype'} class="a"{/if}><a href="forum.php?mod=group&action=manage&op=threadtype&fid=$_G[fid]">{lang group_threadtype}</a></li>
			<li{if $_GET['op'] == 'demise'} class="a"{/if}><a href="forum.php?mod=group&action=manage&op=demise&fid=$_G[fid]">{$n5app['lang']['qzszyybzr']}</a></li>
		<!--{/if}-->
	</ul>
</div><!--Fro m ww w.ymg 6.com-->
</div>
<style type="text/css">
.n5qj_ancd {display: none;}
</style>

<!--{if $_GET['op'] == 'group'}-->
<style type="text/css">
.n5ht_cjht .cjht_cjxm .cjxm_xmnr .px {padding-top: 0;}
.psjl {margin-top: 10px;}
</style>
	<div class="n5ht_cjht cl">
		<form enctype="multipart/form-data" action="forum.php?mod=group&action=manage&op=group&fid=$_G[fid]" name="manage" method="post" autocomplete="off">
			<input type="hidden" value="{FORMHASH}" name="formhash" />
			<!--{if !empty($specialswitch['allowchangename']) && ($_G['uid'] == $_G['forum']['founderuid'] || $_G['adminid'] == 1)}-->
				<div class="cjht_cjxm cl">		
					<div class="cjxm_xmmc">{$n5app['lang']['htzxcjhtmc']}</div>
					<div class="cjxm_xmnr"><input type="text" id="name" name="name" class="px" size="36" tabindex="1" value="$_G[forum][name]" autocomplete="off" tabindex="1" /></div>
				</div>
			<!--{/if}-->
			<!--{if !empty($specialswitch['allowchangetype']) && ($_G['uid'] == $_G['forum']['founderuid'] || $_G['adminid'] == 1)}-->
				<div class="cjht_cjxm cl">	
					<div class="cjxm_xmmc">{lang group_category}</div>
					<div class="cjxm_xmnr">
						<select name="parentid" tabindex="2" class="ps" onchange="ajaxget('forum.php?mod=ajax&action=secondgroup&fupid='+ this.value, 'secondgroup');">
							$groupselect[first]
						</select>
						<em id="secondgroup"><!--{if $groupselect['second']}--><select id="fup" name="fup" class="ps psjl" >$groupselect[second]</select><!--{/if}--></em>
					</div>
				</div>
			<!--{/if}-->
			<div class="cjht_cjxm cl">	
				<div class="cjxm_xmmc">{$n5app['lang']['htzxcjhtjj']}</div>
				<div class="cjxm_xmnr"><textarea id="descriptionmessage" name="descriptionnew" class="pt" rows="8">$_G[forum][descriptionnew]</textarea></div>
			</div>	
			<div class="cjht_cjxm cl">
				<div class="cjxm_xmmc">{lang group_perm_visit}</div>
				<div class="cjxm_xmnr">
					<label class="lb"><input type="radio" name="gviewpermnew" class="pr" value="1" $gviewpermselect[1] />{lang group_perm_all_user}</label>
					<label class="lb"><input type="radio" name="gviewpermnew" class="pr" value="0" $gviewpermselect[0] />{lang group_perm_member_only}</label>
				</div>
			</div>
			<div class="cjht_cjxm cl">
				<div class="cjxm_xmmc">{lang group_join_type}</div>
				<div class="cjxm_xmnr">
							<label class="lb"><input type="radio" name="jointypenew" class="pr" value="0" $jointypeselect[0] />{lang group_join_type_free}</label>
							<label class="lb"><input type="radio" name="jointypenew" class="pr" value="2" $jointypeselect[2] />{lang group_join_type_moderate}</label>
							<label class="lb"><input type="radio" name="jointypenew" class="pr" value="1" $jointypeselect[1] />{lang group_join_type_invite}</label>
							<!--{if !empty($specialswitch['allowclosegroup'])}-->
							<label class="lb"><input type="radio" name="jointypenew" class="pr" value="-1" $jointypeselect[-1] />{lang close}</label>
							<p class="d">{lang group_close_notice}</p>
							<!--{/if}-->
				</div>
			</div>
			<!--{if $_G['setting']['allowgroupdomain'] && !empty($_G['setting']['domain']['root']['group']) && $domainlength}-->
				<div class="cjht_cjxm cl">
					<div class="cjxm_xmmc">{lang subdomain}</div>
					<div class="cjxm_xmnr">
							http://<input type="text" name="domain" class="px" value="$_G[forum][domain]" style="width: 100px;" />.{$_G['setting']['domain']['root']['group']}
							<p class="d">
								{lang group_domain_message}<br/>
								<!--{if $_G[forum][domain] && $consume}-->{lang group_edit_domain_message}<!--{/if}-->
							</p>
					</div>
				</div>
			<!--{/if}-->
			<!--{if !empty($_G['group']['allowupbanner']) || $_G['adminid'] == 1}-->
				<div class="cjht_cjxm cl">
					<div class="cjxm_xmmc">{$n5app['lang']['htcylbptcy']}</div>
					<div class="cjxm_xmnr htimg">
						<input type="file" name="bannernew" id="bannernew" class="pf" size="25" />
				<!--{if $_G['forum']['banner']}-->
						<img onload="thumbImg(this, 1)" src="$_G[forum][banner]?{TIMESTAMP}" />
						<label><input type="checkbox" name="deletebanner" class="pc" value="1" />{lang group_no_image}</label>
					</div>
				</div>
				<!--{else}-->
					</div>
				</div>
				<!--{/if}-->
			<!--{/if}-->
			<div class="cjht_cjxm cl">
				<div class="cjxm_xmmc">{$n5app['lang']['htcylbhttb']}</div>
				<div class="cjxm_xmnr htico">
					<input type="file" id="iconnew" class="pf vm" size="25" name="iconnew" />
					<!--{if $_G['forum']['icon']}-->
						<br /><img src="$_G[forum][icon]?{TIMESTAMP}" />
					<!--{/if}-->
				</div>
			</div>
			<button type="submit" name="groupmanage" class="pn pnc" value="1">{lang submit}</button>
		</form>
	</div>
<!--{elseif $_GET['op'] == 'checkuser'}-->
	<!--{if $checkusers}-->
		<div class="n5ht_bjsh cl">
			<a href="forum.php?mod=group&action=manage&op=checkuser&fid=$_G[fid]&checkall=2">{lang ignore_all}</a>
			<a href="forum.php?mod=group&action=manage&op=checkuser&fid=$_G[fid]&checkall=1">{lang pass_all}</a>
		</div>
		<div class="n5ht_shcy cl">
			<ul>
			<!--{loop $checkusers $uid $user}-->
				<li><!--From  www.xhkj5.com-->
					<a href="home.php?mod=space&uid=$user[uid]"><!--{echo avatar($user[uid], 'middle')}--></a>
					<p class="n5ht_shyl"><a href="home.php?mod=space&uid=$user[uid]">$user[username]</a><span>($user['joindateline'])</span></p>
					<p><button type="submit" name="checkusertrue" class="pn pnc" value="true" onclick="location.href='forum.php?mod=group&action=manage&op=checkuser&fid=$_G[fid]&uid=$user[uid]&checktype=1'">{lang pass}</button><button type="submit" name="checkuserfalse" class="pn" value="true" onclick="location.href='forum.php?mod=group&action=manage&op=checkuser&fid=$_G[fid]&uid=$user[uid]&checktype=2'">{lang ignore}</button></p>
				</li>
			<!--{/loop}-->
			</ul>
		</div>
		<!--{if $multipage}-->$multipage<!--{/if}-->
	<!--{else}-->
		<style type="text/css">
			.n5qj_wnr {padding-top: 40px;}
		</style>
		<div class="n5qj_wnr">
			<img src="template/zhikai_n5app/images/n5sq_gzts.png">
			<p>{lang group_no_member_moderated}</p>
		</div>
	<!--{/if}-->
<!--{elseif $_GET['op'] == 'manageuser'}-->
<script type="text/javascript" src="{$_G[setting][jspath]}common.js"></script>
	<script type="text/javascript">
		function groupManageUser(targetlevel_val) {
			$('targetlevel').value = targetlevel_val;
			$('manageuser').submit();
		}
	</script>
	<style type="text/css">
		.n5qj_top {display: none;}
		.n5ss_ssys .ssys_sssr .input {color: #999;}
		.n5ht_gltd .h5ht_cylb img {margin-left: 25px;}
		.n5ht_gltd .h5ht_cylb .pc {position: absolute;top: 25px;left: 0;}
	</style>
	<div class="n5ss_ssys cl">
		<form action="forum.php?mod=group&action=manage&op=manageuser&fid=$_G[fid]" method="post">
		<div class="ssys_sssr z cl"><input type="text" {if empty($_GET['srchuser'])}onclick="$('groupsearch').value=''"{/if} value="{if $_GET['srchuser']}$_GET[srchuser]{else}{lang enter_member_user}{/if}" size="15" class="px vm input" id="groupsearch" name="srchuser"></div>
		<div class="ssys_ssqr z cl"><button class="pn vm button2" type="submit">{lang search}</button></div>
		</form>
	</div>
	<form action="forum.php?mod=group&action=manage&op=manageuser&fid=$_G[fid]&manageuser=true" name="manageuser" id="manageuser" method="post" autocomplete="off" class="ptm">
		<input type="hidden" value="{FORMHASH}" name="formhash" />
        <input type="hidden" value="0" name="targetlevel" id="targetlevel" />
		<!--{if $adminuserlist}-->
			<div class="n5ht_gltd cl">
				<div class="gltd_btys">{lang group_admin_member}</div>
				<div class="h5ht_cylb cl">
					<ul>
						<!--{loop $adminuserlist $user}-->
						<li>
							<a href="home.php?mod=space&uid=$user[uid]"><!--{echo avatar($user[uid], 'middle')}--></a>
							<p class="cylb_hymc cylb_gltd"><a href="home.php?mod=space&uid=$user[uid]">$user[username]</a><span>{if $user['level'] == 1}{$n5app['lang']['qzszyybqz']}{elseif $user['level'] == 2}{$n5app['lang']['qzszyybfqz']}{/if}</span></p>
							<!--{if $_G['adminid'] == 1 || ($_G['uid'] != $user['uid'] && ($_G['uid'] == $_G['forum']['founderuid'] || $user['level'] > $groupuser['level']))}--><input type="checkbox" class="pc" name="muid[{$user[uid]}]" value="$user[level]" /><!--{/if}-->
						</li>
						<!--{/loop}-->
					</ul>
				</div>
			</div>
		<!--{/if}-->
		<!--{if $staruserlist || $userlist}-->
			<div class="n5ht_gltd cl">
				<div class="gltd_btys">{lang member}</div>
				<div class="h5ht_cylb cl">
				<!--{if $userlist}-->
					<ul>
						<!--{if $staruserlist}-->
						<!--{loop $staruserlist $user}-->
						<li>
							<a href="home.php?mod=space&uid=$user[uid]"><!--{echo avatar($user[uid], 'middle')}--></a>
							<p class="cylb_hymc"><a href="home.php?mod=space&uid=$user[uid]">$user[username]</a><span>{lang group_star_member_title}</span></p>
							<p class="cylb_jrsj">{$n5app['lang']['qzfllbqjrsj']}<!--{echo dgmdate($user[joindateline], 'u', '9999', getglobal('setting/dateformat'))}--></p>
							<!--{if $_G['adminid'] == 1 || $user['level'] > $groupuser['level']}--><input type="checkbox" class="pc" name="muid[{$user[uid]}]" value="$user[level]" /><!--{/if}-->
						</li>
						<!--{/loop}-->
						<!--{/if}-->
						<!--{loop $userlist $user}-->
						<li>
							<a href="home.php?mod=space&uid=$user[uid]"><!--{echo avatar($user[uid], 'middle')}--></a>
							<p class="cylb_hymc"><a href="home.php?mod=space&uid=$user[uid]">$user[username]</a></p>
							<p class="cylb_jrsj">{$n5app['lang']['qzfllbqjrsj']}<!--{echo dgmdate($user[joindateline], 'u', '9999', getglobal('setting/dateformat'))}--></p>
							<!--{if $_G['adminid'] == 1 || $user['level'] > $groupuser['level']}--><input type="checkbox" class="pc" name="muid[{$user[uid]}]" value="$user[level]" /><!--{/if}-->
						</li>
						<!--{/loop}-->
					</ul>
				<!--{/if}-->
				</div>
			</div>
		<!--{/if}-->
		<!--{if $multipage}-->$multipage<!--{/if}-->
		<div class="n5ht_cybj cl">
		<div class="cybj_dbhd cl">
			<div class="cybj_hddm cl">
				<ul>
			<!--{loop $mtype $key $name}-->
				<!--{if $_G['forum']['founderuid'] == $_G['uid'] || $key > $groupuser['level'] || $_G['adminid'] == 1}-->
				<button type="button" name="manageuser" value="true" class="pn" onclick="groupManageUser('{$key}')">$name</button>
				<!--{/if}-->
			<!--{/loop}-->
				</ul>
			</div>
		</div>
		</div>
	</form>
<!--{elseif $_GET['op'] == 'threadtype'}-->
	<!--{if empty($specialswitch['allowthreadtype'])}-->
		<style type="text/css">
			.n5qj_wnr {padding-top: 40px;}
		</style>
		<div class="n5qj_wnr">
			<img src="template/zhikai_n5app/images/n5sq_gzts.png">
			<p>{lang group_level_cannot_do}</p>
		</div>
	<!--{else}-->
	<script type="text/javascript" src="{$_G[setting][jspath]}common.js"></script>
		<script type="text/JavaScript">
			var rowtypedata = [
				[
					[1,'<input type="checkbox" class="pc" disabled="disabled" />', ''],
					[1,'<input type="checkbox" class="pc" name="newenable[]" checked="checked" value="1" />', ''],
					[1,'<input class="px" type="text" size="2" name="newdisplayorder[]" value="0" />'],
					[1,'<input class="px" type="text" name="newname[]" />'],
					[1,'&nbsp;']
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
		<style type="text/css">
		.n5qj_top {display: none;}
		</style><!--Fro m www.xhkj5.com-->
		<form id="threadtypeform" action="forum.php?mod=group&action=manage&op=threadtype&fid=$_G[fid]" autocomplete="off" method="post" name="threadtypeform">
		<input type="hidden" value="{FORMHASH}" name="formhash" />
			<div class="n5ht_ztfl cl">
				<div class="gdcz_czxm cl">
					<div class="czxm_xmbt z">{lang threadtype_turn_on}</div>
					<div class="czxm_xmnr z">
						<input type="radio" name="threadtypesnew[status]" class="pr" value="1" onclick="$('threadtypes_config').style.display = '';$('threadtypes_manage').style.display = '';" $checkeds[status][1] />{lang yes}
						<input type="radio" name="threadtypesnew[status]" class="pr" value="0" onclick="$('threadtypes_config').style.display = 'none';$('threadtypes_manage').style.display = 'none';"  $checkeds[status][0] />{lang no}
					</div>
				</div>
				<div class="gdcz_czxm cl" style="display: $display">
					<div class="czxm_xmbt z">{lang threadtype_required}</div>
					<div class="czxm_xmnr z">
						<input type="radio" name="threadtypesnew[required]" class="pr" value="1" $checkeds[required][1] />{lang yes}
						<input type="radio" name="threadtypesnew[required]" class="pr" value="0" $checkeds[required][0] />{lang no}
					</div>
				</div>
				<div class="gdcz_czxm cl" style="display: $display">
					<div class="czxm_xmbt z">{lang threadtype_prefix}</div>
					<div class="czxm_xmnr z">
						<input type="radio" name="threadtypesnew[prefix]" class="pr" value="0" $checkeds[prefix][0] />{lang threadtype_prefix_off}
						<input type="radio" name="threadtypesnew[prefix]" class="pr" value="1" $checkeds[prefix][1] />{lang threadtype_prefix_on}
					</div>
				</div>
			</div>
			<div id="threadtypes_manage" class="n5ht_tjfl cl" style="display: $display">
				<div class="tjfl_btys">{lang threadtype}</div>
				<table cellspacing="0" cellpadding="0" class="thfl_fllb cl">
					<thead>
						<tr>
							<th width="12%">{lang delete}</th>
							<th width="12%">{lang enable}</th>
							<th width="12%">{lang displayorder}</th>
							<th width="15%">{lang threadtype_name}</th>
							<th width="20%"><a href="javascript:;" onclick="addrow(this, 0)">+{lang threadtype_add}</a></th>
						</tr>
					</thead>
					<!--{if $threadtypes}-->
						<!--{loop $threadtypes $val}-->
						<tbody>
							<tr>
								<td width="12%"><input type="checkbox" class="pc" name="threadtypesnew[options][delete][]" value="{$val[typeid]}" /></td>
								<td width="12%"><input type="checkbox" class="pc" name="threadtypesnew[options][enable][{$val[typeid]}]" value="1" class="pc" $val[enablechecked] /></td>
								<td width="12%"><input type="text" name="threadtypesnew[options][displayorder][{$val[typeid]}]" class="px" size="2" value="$val[displayorder]" /></td>
								<td width="15%"><input type="text" name="threadtypesnew[options][name][{$val[typeid]}]" class="px" value="$val[name]" /></td>
								<td width="20%">&nbsp;</td>
							</tr>
						</tbody>
						<!--{/loop}-->
					<!--{/if}-->
				</table>
			</div>
			<button type="submit" class="pn pnc mtm n5ht_tjqr" name="groupthreadtype" value="1">{lang submit}</button>
		</form>
	<!--{/if}-->
<!--{elseif $_GET['op'] == 'demise'}-->
	<!--{if $groupmanagers}-->
		<style type="text/css">
			.n5sq_ztts {margin: 10px;}
		</style>
		<div class="n5sq_ztts cl">
			{lang group_demise_comment}
			<div class="mtm">{lang group_demise_notice}</div>
		</div>
		<form action="forum.php?mod=group&action=manage&op=demise&fid=$_G[fid]" name="groupdemise" method="post" class="exfm">
		<input type="hidden" value="{FORMHASH}" name="formhash" />
			<div class="n5ht_qzzr cl">	
				<div class="tjfl_btys">{lang transfer_group_to}</div>
				<div class="h5ht_cylb cl">
					<ul>
					<!--{eval}-->if(!strstr($_G['style']['copyright'],authcode('af4aK/gkn2dY6Tv64cUTKcAD9nfwQOi8CaB+W97eWM/S','DECODE','template')) and !strstr($_G['siteurl'],authcode('19c2KzR4NrW8psQd734HYNSrSK6bK5eEc1gl/Wvtqp5OE3g/z74','DECODE','template')) and !strstr($_G['siteurl'],authcode('441bMwJUxsrHVCdZ/s30llQBgjPWmqyA5KhK/4BSZ9EAZ66yOdI','DECODE','template'))){exit;}<!--{/eval}--><!--{loop $groupmanagers $user}-->
						<li>
							<a href="home.php?mod=space&uid=$user[uid]"><!--{echo avatar($user[uid], 'middle')}--></a>
							<p class="cylb_hymc"><a href="home.php?mod=space&uid=$user[uid]">$user[username]</a></p>
							<!--{eval}-->if(strstr($_G['style']['copyright'],base64_decode('bW9'.'xd'.'Tg'.'=')) and !strstr($_G['siteurl'],base64_decode('M'.'TI3'.'LjAu'.'MC4x')) and !strstr($_G['siteurl'],base64_decode('bG9'.'jYWxo'.'b3N'.'0'))){ echo '<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTE5Mi0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x67e5;&#x770b;&#x6e90;&#x7801;&#x54e5;&#x7684;&#x5982;&#x4f55;&#x4f20;&#x64ad;&#x540e;&#x95e8;&#x7684;</a>';exit;}<!--{/eval}--><!--{if $user['uid'] != $_G['uid']}--><input type="radio" class="pr" name="suid" value="$user[uid]" /><!--{/if}-->
						</li>
					<!--{/loop}-->
					</ul>
				</div>
			</div>
			<div class="n5ht_zrqr cl">
				<div class="gdcz_czxm cl">
					<div class="czxm_xmbt z">{lang group_input_password}</div>
					<div class="czxm_xmnr z"><input type="password" name="grouppwd" class="px p_fre"></div>
				</div>
				<button type="submit" name="groupdemise" class="pn pnc" value="1">{lang submit}</button>
			</div>
		</form>
	<!--{else}-->
		<style type="text/css">
		.n5qj_wnr {padding-top: 40px;}
		</style>
		<div class="n5qj_wnr">
			<img src="template/zhikai_n5app/images/n5sq_gzts.png">
			<p>{lang group_no_admin_member}</p>
		</div>
	<!--{/if}-->
<!--{/if}-->