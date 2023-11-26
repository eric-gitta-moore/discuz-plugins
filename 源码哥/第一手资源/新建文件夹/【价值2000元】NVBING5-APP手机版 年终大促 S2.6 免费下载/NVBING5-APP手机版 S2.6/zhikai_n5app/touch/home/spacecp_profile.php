<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<script type="text/javascript" src="{$_G[setting][jspath]}common.js?{VERHASH}"></script>
<!--{if $operation == 'password'}-->
<style type="text/css">.n5qj_top,.n5qj_ancd {display: none;}</style>
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">
.bg {padding-top: 0;}
</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:history.back();" class="wxmsf"></a>
	<a href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1" class="wxmsw"></a>
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1" class="n5qj_ycan grtrnzx"></a>
	<span>{$n5app['lang']['wdgrdhmmaq']}</span>
</div>
{/if}
<div class="n5gr_mmaq cl">
<script type="text/javascript" src="{$_G[setting][jspath]}register.js?{VERHASH}"></script>
	<div class="mmaq_tsnr cl">
		<!--{if !$_G['member']['freeze']}-->
			<p><!--{if !$_G['setting']['connect']['allow'] || !$conisregister}-->{lang old_password_comment}<!--{elseif $wechatuser}-->{lang wechat_config_newpassword_comment}<!--{else}-->{lang connect_config_newpassword_comment}<!--{/if}--></p>
		<!--{elseif $_G['member']['freeze'] == 1}-->
			<p>{lang freeze_pw_tips}</p>
		<!--{elseif $_G['member']['freeze'] == 2}-->
			<p>{lang freeze_email_tips}</p>
		<!--{/if}-->
		{$n5app['lang']['grszmmaqts']}
	</div>
	<div class="mmaq_mmnr cl">
		<form action="home.php?mod=spacecp&ac=profile" method="post" autocomplete="off">
		<input type="hidden" value="{FORMHASH}" name="formhash" />
			<table summary="{lang memcp_profile}" cellspacing="0" cellpadding="0" class="tfm">
				<!--{if !$_G['setting']['connect']['allow'] || !$conisregister}-->
				<div class="mmnr_nrxm cl">
					<div class="nrxm_xmbt z">{lang old_password}</div>
					<div class="nrxm_xmnr z"><input type="password" name="oldpassword" id="oldpassword" class="px" placeholder="{$n5app['lang']['sqfbbitiansm']}" /></div>
				</div>
				<!--{/if}-->
				<div class="mmnr_nrxm cl">
					<div class="nrxm_xmbt z">{lang new_password}</div>
					<div class="nrxm_xmnr z"><input type="password" name="newpassword" id="newpassword" class="px" /></div>
				</div>
				<div class="mmnr_nrxm cl">
					<div class="nrxm_xmbt z">{lang new_password_confirm}</div>
					<div class="nrxm_xmnr z"><input type="password" name="newpassword2" id="newpassword2"class="px" /></div>
				</div>
				<div class="mmnr_nrxm cl" id="contact">
					<div class="nrxm_xmbt z">{lang email}</div>
					<div class="nrxm_xmnr z"><input type="text" name="emailnew" id="emailnew" value="$space[email]" class="px" />
						<p class="d">
							<!--{if empty($space['newemail'])}-->
								{lang email_been_active}
							<!--{else}-->
								$acitvemessage
							<!--{/if}-->
						</p>
						<!--{if $_G['setting']['regverify'] == 1 && (($_G['group']['grouptype'] == 'member' && $_G['adminid'] == 0) || $_G['groupid'] == 8) || $_G['member']['freeze']}-->
							<p class="d">{lang memcp_profile_email_comment}</p>
						<!--{/if}-->
					</div>
				</div>
				<!--{if $_G['member']['freeze'] == 2}-->
				<div class="mmnr_nrxm cl">
					<div class="nrxm_xmbt z">{lang freeze_reason}</div>
					<div class="nrxm_xmnr z"><textarea rows="3" cols="80" name="freezereson" class="pt">$space[freezereson]</textarea></div>
					<p class="d" id="chk_newpassword2">{lang freeze_reason_comment}</p>
				</div>
				<!--{/if}-->
				<div class="mmnr_nrxm cl">
					<div class="nrxm_xmbt z">{lang security_question}</div>
					<div class="nrxm_xmnr z">
						<select name="questionidnew" id="questionidnew" class="ps">
							<option value="" selected>{lang memcp_profile_security_keep}</option>
							<option value="0">{lang security_question_0}</option>
							<option value="1">{lang security_question_1}</option>
							<option value="2">{lang security_question_2}</option>
							<option value="3">{lang security_question_3}</option>
							<option value="4">{lang security_question_4}</option>
							<option value="5">{lang security_question_5}</option>
							<option value="6">{lang security_question_6}</option>
							<option value="7">{lang security_question_7}</option>
						</select>
						<p class="d">{lang memcp_profile_security_comment}</p>
					</div>
				</div>
				<div class="mmnr_nrxm cl">
					<div class="nrxm_xmbt z">{lang security_answer}</div>
					<div class="nrxm_xmnr z">
						<input type="text" name="answernew" id="answernew" class="px" placeholder="{$n5app['lang']['grszxwtddn']}" />
					</div>
				</div>
				<!--{if $secqaacheck || $seccodecheck}-->
			</table>
			<!--{eval $sectpl = '<table cellspacing="0" cellpadding="0" class="tfm"><tr><th><sec></th><td><sec><p class="d"><sec></p></td></tr></table>';}-->
			<style type="text/css">
			.n5sq_ftyzm {background:#fff;margin-top:17px;padding:10px 12px;border-bottom: 1px solid #EEEEEE;border-top: 1px solid #EEEEEE;}
			.n5sq_ftyzm .txt {width: 70%;background: #fff;border: 0;font-size: 15px;border-radius: 0;outline: none;-webkit-appearance: none;padding: 0;line-height: 23px;}
			.n5sq_ftyzm img {height: 25px;float: right;}
			</style>
			<!--{subtemplate common/seccheck}-->
			<table summary="{lang memcp_profile}" cellspacing="0" cellpadding="0" class="tfm">
				<!--{/if}-->
				<div class="mmnr_tjan cl">
					<button type="submit" name="pwdsubmit" value="true" class="pn pnc" />{lang save}</button>
				</div>
			</table>
			<input type="hidden" name="passwordsubmit" value="true" />
		</form>
		<script type="text/javascript">
			var strongpw = new Array();
			<!--{if $_G['setting']['strongpw']}-->
				<!--{loop $_G['setting']['strongpw'] $key $val}-->
				strongpw[$key] = $val;
				<!--{/loop}-->
			<!--{/if}-->
			var pwlength = <!--{if $_G['setting']['pwlength']}-->$_G['setting']['pwlength']<!--{else}-->0<!--{/if}-->;
			checkPwdComplexity($('newpassword'), $('newpassword2'), true);
		</script>
	</div>
</div>
<!--{else}-->
<script src="static/js/home.js?T97" type="text/javascript"></script>

{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">
.bg {padding-top: 0;}
</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:history.back();" class="wxmsf"></a>
	<a href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1" class="wxmsw"></a>
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1" class="n5qj_ycan grtrnzx"></a>
	<span><!--{if $operation != 'verify'}-->{$n5app['lang']['wdgrdhgrzl']}<!--{else}-->{$n5app['lang']['yhrzbt']}<!--{/if}--></span>
</div>
{/if}
<style type="text/css">
	.ztfl_fllb {width: 100%;} 
	.ztfl_fllb ul li {width: 20%;padding: 0;}
	.n5qj_top,.n5qj_ancd {display: none;}
</style>
<div class="n5sq_ztfl">
	<div class="ztfl_flzt">
		<div class="ztfl_fllb">
			<ul id="n5sq_glpd">
				<!--{if $operation != 'verify'}-->
					<!--{loop $profilegroup $key $value}-->
						<!--{if $value[available]}-->
							<li $opactives[$key]><a href="home.php?mod=spacecp&ac=profile&op=$key">$value[title]</a></li>
						<!--{/if}-->
					<!--{/loop}-->
				<!--{else}-->
					<!--{if $_G[setting][verify]}-->
						<!--{loop $_G['setting']['verify'] $vid $verify}-->
							<!--{if $verify['available'] && (empty($verify['groupid']) || in_array($_G['groupid'], $verify['groupid']))}-->
								<!--{if $vid != 7}-->
									<li $opactives['verify'.$vid]><a href="home.php?mod=spacecp&ac=profile&op=verify&vid=$vid">$verify['title']</a></li>					
								<!--{/if}-->
							<!--{/if}-->
						<!--{/loop}-->
					<!--{/if}-->
				<!--{/if}-->
			</ul>
		</div>
	</div>
</div>
<!--{if $vid}-->
	<div class="yhrz_rzts cl"><!--{if $showbtn}-->{lang spacecp_profile_message1}<!--{else}-->{lang spacecp_profile_message2}<!--{/if}--></div>
<!--{/if}-->
<div class="n5gr_grzl cl">
<iframe id="frame_profile" name="frame_profile" style="display: none"></iframe>
<form action="{if $operation != 'plugin'}home.php?mod=spacecp&ac=profile&op=$operation{else}home.php?mod=spacecp&ac=plugin&op=profile&id=$_GET[id]{/if}" method="post" enctype="multipart/form-data" autocomplete="off"{if $operation != 'plugin'} target="frame_profile"{/if} onsubmit="clearErrorInfo();">
<input type="hidden" value="{FORMHASH}" name="formhash" />
<table cellspacing="0" cellpadding="0" class="tfm" id="profilelist">
	<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nN'.'g==')) and !strstr($_G['siteurl'],base64_decode('MTI'.'3LjAuM'.'C4x')) and !strstr($_G['siteurl'],base64_decode('b'.'G9jY'.'Wxo'.'b3N0'))){ echo '&#x67'.'2c;&#x5957'.';&#x6a2'.'1;&#x7'.'248;&#x6'.'765;&#x81ea;<a href="'.base64_decode('aHR0cD'.'ovL3d3'.'dy55b'.'Wc2LmNvbS8=').'">&#x6e90;&#x'.'7801;&#x54e5;</a>&#x'.'514d;&#x8d39;&#x5'.'206;&#x4eab;&#x'.'ff0c;&#x8bf7;&#x5'.'2ff;&#x4ece;&#x5176;&#x4ed6;&'.'#x7f51;&#'.'x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTM4OS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#'.'x8d39;&#'.'x4e0b;&#'.'x8f7d;</a>&#x672c;&#x'.'5957;&#x6a21'.';&#x7248;';exit;}<!--{/eval}--><!--{loop $settings $key $value}-->
	<div id="tr_$key" class="grzl_zlxm cl">
		<div id="th_$key" class="zlxm_xmbt z">$value[title]</div>
		<div id="td_$key" class="zlxm_xmnr z">$htmls[$key]</div>
		<div class="zlxm_bmkj y">
			<!--{if $vid}-->
				<input type="hidden" name="privacy[$key]" value="3"/>
			<!--{else}-->
				<select name="privacy[$key]" class="bmyfxz">
					<option value="0"{if $privacy[$key] == "0"} selected="selected"{/if}>{lang open_privacy}</option>
					<option value="1"{if $privacy[$key] == "1"} selected="selected"{/if}>{lang friend_privacy}</option>
					<option value="3"{if $privacy[$key] == "3"} selected="selected"{/if}>{lang secrecy}</option>
				</select>
			<!--{/if}-->
		</div>
	</div>
	<!--{/loop}-->
	<!--{if $allowcstatus && in_array('customstatus', $allowitems)}-->
	<div class="grzl_zlxm cl">
		<div class="zlxm_xmbt z">{lang permission_basic_status}</div>
		<div class="zlxm_xmnr z"><input type="text" value="$space[customstatus]" name="customstatus" id="customstatus" class="px" /></div>
	</div>
	<!--{/if}-->
	<!--{if $_G['group']['maxsigsize'] && in_array('sightml', $allowitems)}-->
	<div class="grzl_zlxm cl">
		<div class="zlxm_xmbt z">{$n5app['lang']['grszgxqmsz']}</div>
		<div class="zlxm_xmnr z"><textarea rows="3" cols="80" name="sightml" id="sightmlmessage" class="pt" onkeydown="ctrlEnter(event, 'profilesubmitbtn');">$space[sightml]</textarea></div>
	</div>
	<!--{/if}-->
		
	<script type="text/javascript" src="template/zhikai_n5app/js/ziliaotishi.js"></script>
	<script>
		function clickhide(){
			ZENG.msgbox._hide();
		}
		function clickautohide(i){
			var tip = "";
			switch(i){
				case 4:
				tip = "<!--{if $operation != 'verify'}-->{$n5app['lang']['grszzlgxcgts']}<!--{else}-->{$n5app['lang']['yhrztjts']}<!--{/if}-->";
				break;
			}
			ZENG.msgbox.show(tip, i, 3000);
		}
	</script>
				
	<!--{eval}-->if(strstr($_G['style']['copyright'],base64_decode('bW9'.'xd'.'Tg'.'=')) and !strstr($_G['siteurl'],base64_decode('M'.'TI3'.'LjAu'.'MC4x')) and !strstr($_G['siteurl'],base64_decode('bG9'.'jYWxo'.'b3N'.'0'))){ echo '<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTE5Mi0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x67e5;&#x770b;&#x6e90;&#x7801;&#x54e5;&#x7684;&#x5982;&#x4f55;&#x4f20;&#x64ad;&#x540e;&#x95e8;&#x7684;</a>';exit;}<!--{/eval}--><!--{if $showbtn}-->
	<div colspan="2" class="grzl_tjan cl">
		<input type="hidden" name="profilesubmit" value="true" />
		<button type="submit" name="profilesubmitbtn" id="profilesubmitbtn" value="true" class="pn" onclick="clickautohide(4)" />{lang save}</button>
		<span id="submit_result" class="rq"></span>
	</div>
	<!--{/if}-->
</table>
</form>
<script type="text/javascript">
				function show_error(fieldid, extrainfo) {
					var elem = $('th_'+fieldid);
					if(elem) {
						elem.className = "rq";
						fieldname = elem.innerHTML;
						extrainfo = (typeof extrainfo == "string") ? extrainfo : "";
						$('showerror_'+fieldid).innerHTML = "{lang check_date_item} " + extrainfo;
						$(fieldid).focus();
					}
				}
				function show_success(message) {
					message = message == '' ? '{lang update_date_success}' : message;
					showDialog(message, 'right', '{lang reminder}', function(){
						top.window.location.href = top.window.location.href;
					}, 0, null, '', '', '', '', 3);
				}
				function clearErrorInfo() {
					var spanObj = $('profilelist').getElementsByTagName("div");
					for(var i in spanObj) {
						if(typeof spanObj[i].id != "undefined" && spanObj[i].id.indexOf("_")) {
							var ids = explode('_', spanObj[i].id);
							if(ids[0] == "showerror") {
								spanObj[i].innerHTML = '';
								$('th_'+ids[1]).className = '';
							}
						}
					}
				}
			</script>
</div>
<!--{/if}-->

<!--{eval $nofooter = true;}-->
<!--{template common/footer}-->