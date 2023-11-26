<?php exit;?>
<script type="text/javascript" src="{$_G[setting][jspath]}common.js"></script>
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">
.bg {padding-top: 0;}
</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:history.back();" class="wxmsf"></a>
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<span>{$n5app['lang']['htzxcjht']}</span>
</div>
{/if}

<style type="text/css">
.n5sq_ztts {margin: 10px;}
.n5qj_top,.n5qj_ancd {display: none;}
</style>
<div class="n5sq_ztts cl">{lang group_you_have}<!--{if $_G['group']['buildgroupcredits']}--><br />{$n5app['lang']['htzxcjhtsf']} $_G['group']['buildgroupcredits'] $_G['setting']['extcredits'][$creditstransextra]['unit']{$_G['setting']['extcredits'][$creditstransextra]['title']}<!--{/if}--></div>

<div class="n5ht_cjht cl">
<form method="post" autocomplete="off" name="groupform" id="groupform" class="s_clear" onsubmit="checkCategory();ajaxpost('groupform', 'returnmessage4', 'returnmessage4', 'onerror');return false;" action="forum.php?mod=group&action=create">
	<input type="hidden" name="formhash" value="{FORMHASH}" />
	<input type="hidden" name="referer" value="{echo dreferer()}" />
	<input type="hidden" name="handlekey" value="creategroup" />
		<style type="text/css">
			#returnmessage4 { display: none; color: {NOTICETEXT}; font-weight: bold; }
			#returnmessage4.onerror { display: block; }
			.psjl {margin-top: 10px;}
		</style>
		<p id="returnmessage4"></p>
		<div class="cjht_cjxm cl">		
			<div class="cjxm_xmmc">{$n5app['lang']['htzxcjhtmc']}</div>
			<div class="cjxm_xmnr"><input type="text" name="name" id="name" class="px" size="36" tabindex="1" value="" autocomplete="off" onBlur="checkgroupname()" tabindex="1" placeholder="{$n5app['lang']['sqfbbitiansm']}" /></div>
		</div>		
		<div class="cjht_cjxm cl">			
			<div class="cjxm_xmmc">{lang group_category}</div>
			<div class="cjxm_xmnr">
				<select name="parentid" tabindex="2" class="ps" onchange="ajaxget('forum.php?mod=ajax&action=secondgroup&fupid='+ this.value, 'secondgroup');">
					<option value="0">{lang choose_please}</option>
					$groupselect[first]
				</select>
				<em id="secondgroup"></em>
				<span id="groupcategorycheck" class="xi1"></span>
			</div>
		</div>		
					
		<div class="cjht_cjxm cl">			
			<div class="cjxm_xmmc">{$n5app['lang']['htzxcjhtjj']}</div>
			<div class="cjxm_xmnr"><textarea id="descriptionmessage" name="descriptionnew" tabindex="3" class="pt" rows="8" placeholder="{$n5app['lang']['sqfbqingsrnr']}"></textarea></div>		
		</div>	
			
		<div class="cjht_cjxm cl">
		    <div class="cjxm_xmmc">{lang group_perm_visit}</div>
			<div class="cjxm_xmnr">
							<label class="lb"><input type="radio" name="gviewperm" class="pr" tabindex="4" value="1" checked="checked" />{lang group_perm_all_user}</label>
							<label class="lb"><input type="radio" name="gviewperm" class="pr" value="0" />{lang group_perm_member_only}</label>
			</div>
		</div>

		<div class="cjht_cjxm cl">
		    <div class="cjxm_xmmc">{lang group_join_type}</div>
			<div class="cjxm_xmnr">
				<label class="lb"><input type="radio" name="jointype" class="pr" tabindex="5" value="0" checked="checked" />{lang group_join_type_free}</label>
				<label class="lb"><input type="radio" name="jointype" class="pr" value="2" />{lang group_join_type_moderate}</label>
				<label class="lb"><input type="radio" name="jointype" class="pr" value="1" />{lang group_join_type_invite}</label>
			</div>
		</div>
					
		<input type="hidden" name="createsubmit" value="true">
		<button type="submit" class="pn" tabindex="6">{lang create}</button>
</form>
</div>
<script type="text/javascript">
	function checkgroupname() {
		var groupname = trim($('name').value);
		ajaxget('forum.php?mod=ajax&forumcheck=1&infloat=creategroup&handlekey=creategroup&action=checkgroupname&groupname=' + (BROWSER.ie && document.charset == 'utf-8' ? encodeURIComponent(groupname) : groupname), 'groupnamecheck');
	}
	function checkCategory(){
		var groupcategory = trim($('fup').value);
		if(groupcategory == ''){
			$('groupcategorycheck').innerHTML = '{lang group_create_selete_categroy}';
			return false;
		} else {
			$('groupcategorycheck').innerHTML = '';
		}
	}
	<!--{if $_GET['fupid']}-->
			ajaxget('forum.php?mod=ajax&action=secondgroup&fupid=$_GET[fupid]<!--{if $_GET[groupid]}-->&groupid=$_GET[groupid]<!--{/if}-->', 'secondgroup');
	<!--{/if}-->
	if($('name')) {
		$('name').focus();
	}
</script>