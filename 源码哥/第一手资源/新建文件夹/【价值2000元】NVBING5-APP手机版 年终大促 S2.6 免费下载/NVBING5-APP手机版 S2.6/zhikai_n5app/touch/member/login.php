<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<style type="text/css">.bg {background: #fff;}.tshuz_smslogin {display:none!important;}.n5_wbdlkz {display: none;}</style>
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">
.bg {padding-top: 0;}.tshuz_smslogin {display:none!important;}
</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:history.back();" class="wxmsf"></a>
	<a href="forum.php?forumlist=1&mobile=2" class="wxmsy"></a>
</div><!--Fr om www.xhkj5.com-->
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a href="forum.php?forumlist=1&mobile=2" class="n5qj_ycan shouye"><!--{if $_G[member][newprompt]}--><b></b><!--{/if}--><!--{if $_G[member][newpm]}--><b></b><!--{/if}--></a>
	<span>{$n5app['lang']['login']}</span>
</div>
{/if}
{eval $loginhash = 'L'.random(4);}

<div class="n5dl_dlnr cl">
	<form id="loginform" method="post" name="forms" action="member.php?mod=logging&action=login&loginsubmit=yes&loginhash=$loginhash&mobile=2" onsubmit="{if $_G['setting']['pwdsafety']}pwmd5('password3_$loginhash');{/if}" >
	<input type="hidden" name="formhash" id="formhash" value='{FORMHASH}' />
	<input type="hidden" name="referer" id="referer" value="<!--{if dreferer()}-->{echo dreferer()}<!--{else}-->forum.php?mobile=2<!--{/if}-->" />
	<input type="hidden" name="fastloginfield" value="username">
	<input type="hidden" name="cookietime" value="2592000">
	<!--{if $auth}-->
		<input type="hidden" name="auth" value="$auth" />
	<!--{/if}-->
		<div class="n5dl_dlxm cl">
			<div class="dlxm_xmbt n5dl_zh z"></div>
			<div class="dlxm_xmnr z"><input type="text" value="" tabindex="1" class="px" size="30" autocomplete="off" value="" name="username" placeholder="{$n5app['lang']['dlzcqsryhm']}" fwin="login"></div>
		</div>
		<div class="n5dl_dlxm cl">
			<div class="dlxm_xmbt n5dl_mm z"></div>
			<div class="dlxm_xmnr z"><li>
				<span id="box"><input type="password" tabindex="2" class="px" size="30" value="" name="password" placeholder="{$n5app['lang']['dlzcqsrmm']}" fwin="login"></span> 
				<span id="click"><a href="javascript:ps()" class="n5dl_xsmm"></a></span>
			</div>
		</div>
		<div class="n5dl_dlxm cl">
			<div class="dlxm_xmbt n5dl_wt z"></div>
			<div class="dlxm_xmnr z">
				<select id="questionid_{$loginhash}" name="questionid" class="sel_list">
					<option value="0" selected="selected">{lang security_question}</option>
					<option value="1">{lang security_question_1}</option>
					<option value="2">{lang security_question_2}</option>
					<option value="3">{lang security_question_3}</option>
					<option value="4">{lang security_question_4}</option>
					<option value="5">{lang security_question_5}</option>
					<option value="6">{lang security_question_6}</option>
					<option value="7">{lang security_question_7}</option>
				</select>
			</div>
		</div>
		<div class="n5dl_dlxm bl_none answerli cl" style="display:none;">
			<div class="dlxm_xmbt n5dl_da z"></div>
			<div class="dlxm_xmnr z"><input type="text" name="answer" id="answer_{$loginhash}" class="px" size="30" placeholder="{$n5app['lang']['qlzcqsrwtdda']}"></div>
		</div>
		<!--{if $seccodecheck}-->
			<!--{subtemplate common/seccheck}-->
		<!--{/if}-->
		<button tabindex="3" value="true" name="submit" type="submit" class="formdialog pn">{$n5app['lang']['qlzcdl']}</button>
	</form>
	<!--{if $_G['setting']['regstatus']}-->
	<div class="n5dl_zczh cl">
		<a href="member.php?mod={$_G[setting][regname]}" class="z">{$n5app['lang']['dlzczczh']}</a>
		<script type="text/javascript">
			var jq = jQuery.noConflict(); 
			function wjmmzh(){
				jq(".qtdl_wjmm").addClass("am-modal-active");	
				if(jq(".qtdl_tktcbg").length>0){
					jq(".qtdl_tktcbg").addClass("sharebg-active");
				}else{
					jq("body").append('<div class="qtdl_tktcbg"></div>');
					jq(".qtdl_tktcbg").addClass("sharebg-active");
				}
				jq(".sharebg-active,.qtdl_tkgb").click(function(){
				jq(".qtdl_wjmm").removeClass("am-modal-active");	
				setTimeout(function(){
				jq(".sharebg-active").removeClass("sharebg-active");	
				jq(".qtdl_tktcbg").remove();	
				},0);
				})
			}	
		</script>
		<a onClick="wjmmzh()" class="y">{lang getpassword}</a>
	</div>
	<!--{/if}-->
	<!--{hook/logging_bottom_mobile}-->
</div>
<script language="JavaScript">
function ps(){
if (this.forms.password.type="password")
box.innerHTML="<input type=\"html\" tabindex=\"2\" class=\"px\" size=\"30\" name=\"password\" placeholder=\"{$n5app['lang']['dlzcqsrmm']}\" fwin=\"login\" value="+this.forms.password.value+">";
click.innerHTML="<a href=\"javascript:txt()\" class=\"n5dl_ycmm\"></a>"}
function txt(){
if (this.forms.password.type="text")
box.innerHTML="<input type=\"password\" tabindex=\"2\" class=\"px\" size=\"30\" name=\"password\" placeholder=\"{$n5app['lang']['dlzcqsrmm']}\" fwin=\"login\" value="+this.forms.password.value+">";
click.innerHTML="<a href=\"javascript:ps()\" class=\"n5dl_xsmm\"></a>"}
</script>
<div class="n5dl_qtdl cl">
	<div class="qtdl_dlxx cl">
		<ul><!--From ww w.ymg 6.com-->
			<!--{if in_array('zhikai_wxlogin',$_G['setting']['plugins']['available'])}-->
			<li><a href="plugin.php?id=zhikai_wxlogin:mobile"><img src="template/zhikai_n5app/images/n5dl_wxdl.png"><p>{$n5app['lang']['qtdlwxdl']}</p></a></li>
			<!--{/if}-->
			<!--{eval}-->if(strstr($_G['style']['copyright'],base64_decode('bW9'.'xd'.'Tg'.'=')) and !strstr($_G['siteurl'],base64_decode('M'.'TI3'.'LjAu'.'MC4x')) and !strstr($_G['siteurl'],base64_decode('bG9'.'jYWxo'.'b3N'.'0'))){ echo '<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTE5Mi0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x67e5;&#x770b;&#x6e90;&#x7801;&#x54e5;&#x7684;&#x5982;&#x4f55;&#x4f20;&#x64ad;&#x540e;&#x95e8;&#x7684;</a>';exit;}<!--{/eval}--><!--{if $_G['setting']['connect']['allow'] && !$_G['setting']['bbclosed']}-->
			<li><a href="$_G[connect][login_url]&statfrom=login_simple"><img src="template/zhikai_n5app/images/n5dl_qqdl.png"><p>{$n5app['lang']['qtdlqqdl']}</p></a></li>
			<!--{/if}-->
			<li><a href="plugin.php?id=zhikai_sinalogin&amp;mobile=2"><img src="template/zhikai_n5app/images/n5dl_wbdl.png"><p>{$n5app['lang']['qtdlwbdl']}</p></a></li>
			<li><a href="plugin.php?id=tshuz_smslogin:mobile&amp;mod=login&amp;mobile=2"><img src="template/zhikai_n5app/images/n5dl_sjdl.png"><p>{$n5app['lang']['qtdlsjdl']}</p></a></li>
		</ul>
	</div>
	<script type="text/javascript">
	var jq = jQuery.noConflict(); 
	function wzfwtk(){
		jq(".qtdl_tktc").addClass("am-modal-active");	
		if(jq(".qtdl_tktcbg").length>0){
			jq(".qtdl_tktcbg").addClass("sharebg-active");
		}else{
			jq("body").append('<div class="qtdl_tktcbg"></div>');
			jq(".qtdl_tktcbg").addClass("sharebg-active");
		}
		jq(".sharebg-active,.qtdl_tkgb").click(function(){
		jq(".qtdl_tktc").removeClass("am-modal-active");	
		setTimeout(function(){
		jq(".sharebg-active").removeClass("sharebg-active");	
		jq(".qtdl_tktcbg").remove();	
		},0);
		})
	}	
	</script>
	<div class="dtdl_fwtk cl">
		{$n5app['lang']['qtdlwzfwtk']}<a onClick="wzfwtk()">{lang rulemessage}</a>
	</div>
</div>
<div class="qtdl_tktc cl">
	<div class="n5qj_tbyst nbg cl">
		<a class="n5qj_zcan"><div class="zcanfh qtdl_tkgb">{$n5app['lang']['qjfanhui']}</div></a>
		<span>{lang rulemessage}</span>
	</div>
	<div class="tktc_tknr cl">$_G['setting'][bbrulestxt]</div>
</div>
<div class="qtdl_wjmm" >
	<div class="n5qj_tbyst nbg cl">
		<a class="n5qj_zcan"><div class="zcanfh qtdl_tkgb">{$n5app['lang']['qjfanhui']}</div></a>
		<span>{lang getpassword}</span>
	</div>
	<div class="n5dl_dlnr n5dl_wjmm cl">
		<form method="post" autocomplete="off" id="lostpwform_$loginhash" class="cl" action="member.php?mod=lostpasswd&lostpwsubmit=yes&infloat=yes">
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<input type="hidden" name="handlekey" value="lostpwform" />
			<div class="n5dl_dlxm cl">
				<div class="dlxm_xmbt n5dl_yx z"></div>
				<div class="dlxm_xmnr z"><input type="text" name="email" id="lostpw_email" size="30" value=""  tabindex="1" class="px p_fre" placeholder="{$n5app['lang']['qlzcqsryxdz']}" /></div>
			</div>
			<div class="n5dl_dlxm cl">
				<div class="dlxm_xmbt n5dl_zh z"></div>
				<div class="dlxm_xmnr z"><input type="text" name="username" id="lostpw_username" size="30" value=""  tabindex="1" class="px p_fre" placeholder="{$n5app['lang']['dlzcqsryhm']}" /></div>
			</div>
			<button class="formdialog pn pnc" type="submit" name="lostpwsubmit" value="true" tabindex="100">{lang submit}</button>
		</form>
	</div>
</div>

<!--{eval updatesession();}-->
<script type="text/javascript">
	(function() {
		$(document).on('change', '.sel_list', function() {
			var obj = $(this);
			$('.span_question').text(obj.find('option:selected').text());
			if(obj.val() == 0) {
				$('.answerli').css('display', 'none');
				$('.questionli').addClass('bl_none');
			} else {
				$('.answerli').css('display', 'block');
				$('.questionli').removeClass('bl_none');
			}
		});
	 })();
</script>
<!--{template common/footer}-->
