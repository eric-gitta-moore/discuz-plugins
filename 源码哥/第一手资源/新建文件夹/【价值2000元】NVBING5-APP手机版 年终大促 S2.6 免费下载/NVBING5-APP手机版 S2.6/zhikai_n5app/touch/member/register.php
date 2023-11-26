<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<style type="text/css">.bg {background: #fff;}</style>
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">
.bg {padding-top: 0;}
</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:history.back();" class="wxmsf"></a>
	<a href="forum.php?forumlist=1&mobile=2" class="wxmsy"></a>
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a href="forum.php?forumlist=1&mobile=2" class="n5qj_ycan shouye"><!--{if $_G[member][newprompt]}--><b></b><!--{/if}--><!--{if $_G[member][newpm]}--><b></b><!--{/if}--></a>
	<span>{$n5app['lang']['regname']}</span>
</div><!--Fro m www.xhkj5.com-->
{/if}
<div class="n5dl_dlnr cl">
	<form method="post" autocomplete="off" name="register" id="registerform" action="member.php?mod={$_G[setting][regname]}&mobile=2">
	<input type="hidden" name="regsubmit" value="yes" />
	<input type="hidden" name="formhash" value="{FORMHASH}" />
	<!--{eval $dreferer = str_replace('&amp;', '&', dreferer());}-->
	<input type="hidden" name="referer" value="$dreferer" />
	<input type="hidden" name="activationauth" value="{if $_GET[action] == 'activation'}$activationauth{/if}" />
	<input type="hidden" name="agreebbrule" value="$bbrulehash" id="agreebbrule" checked="checked" />
		<div class="n5dl_dlxm cl">
			<div class="dlxm_xmbt n5dl_zh z"></div>
			<div class="dlxm_xmnr z"><input type="text" tabindex="1" class="px p_fre" size="30" autocomplete="off" value="" name="{$_G['setting']['reginput']['username']}" placeholder="{lang registerinputtip}" fwin="login"></div>
		</div>
		<div class="n5dl_dlxm cl">
			<div class="dlxm_xmbt n5dl_mm z"></div>
			<div class="dlxm_xmnr z"><li>
				<span id="box"><input type="password" tabindex="2" class="px p_fre" size="30" value="" name="{$_G['setting']['reginput']['password']}" placeholder="{$n5app['lang']['dlzcqsrmm']}" fwin="login"></span> 
				<span id="click"><a href="javascript:ps()" class="n5dl_xsmm"></a></span>
			</div>
		</div><!--Fr om www.xhkj5.com-->
		<div class="n5dl_dlxm cl">
			<div class="dlxm_xmbt n5dl_mm z"></div>
			<div class="dlxm_xmnr z"><li>
				<span id="boxs"><input type="password" tabindex="3" class="px p_fre" size="30" value="" name="{$_G['setting']['reginput']['password2']}" placeholder="{$n5app['lang']['dlczqzcqrmm']}" fwin="login"></span> 
				<span id="clicks"><a href="javascript:pc()" class="n5dl_xsmm"></a></span>
			</div>
		</div>
		<div class="n5dl_dlxm cl">
			<div class="dlxm_xmbt n5dl_yx z"></div>
			<div class="dlxm_xmnr z"><input type="email" tabindex="4" class="px p_fre" size="30" autocomplete="off" value="" name="{$_G['setting']['reginput']['email']}" placeholder="{$n5app['lang']['qlzcqsryxdz']}" fwin="login"></div>
		</div>
		<!--{if empty($invite) && ($_G['setting']['regstatus'] == 2 || $_G['setting']['regstatus'] == 3)}-->
		<div class="n5dl_dlxm cl">
			<div class="dlxm_xmbt n5dl_yq z"></div>
			<div class="dlxm_xmnr z"><input type="text" name="invitecode" autocomplete="off" tabindex="5" class="px p_fre" size="30" placeholder="{$n5app['lang']['qlzcqsrts']}{lang invite_code}" fwin="login"></div>
		</div>
		<!--{/if}-->
		<!--{if $_G['setting']['regverify'] == 2}-->
		<div class="n5dl_dlxm cl">
			<div class="dlxm_xmbt n5dl_yq z"></div>
			<div class="dlxm_xmnr z"><input type="text" name="regmessage" autocomplete="off" tabindex="6" class="px p_fre" size="30" placeholder="{$n5app['lang']['qlzcqsrts']}{lang register_message}" fwin="login"></div>
		</div>
		<!--{/if}-->
		<!--{if $secqaacheck || $seccodecheck}-->
			<!--{subtemplate common/seccheck}-->
		<!--{/if}-->
	<button tabindex="7" value="true" name="regsubmit" type="submit" class="formdialog pn pnc">{$n5app['lang']['dlzczc']}</button>
	</form>
	<div class="n5dl_zczh cl">
		<a href="member.php?mod=logging&action=login">{$n5app['lang']['dlzcyyzh']}</a>
	</div>
</div>
<script language="JavaScript">
function ps(){
if (this.register.{$_G['setting']['reginput']['password']}.type="password")
box.innerHTML="<input type=\"html\" tabindex=\"2\" class=\"px p_fre\" size=\"30\" name=\"{$_G['setting']['reginput']['password']}\" placeholder=\"{$n5app['lang']['dlzcqsrmm']}\" fwin=\"login\" value="+this.register.{$_G['setting']['reginput']['password']}.value+">";
click.innerHTML="<a href=\"javascript:txt()\" class=\"n5dl_ycmm\"></a>"}
function txt(){
if (this.register.{$_G['setting']['reginput']['password']}.type="text")
box.innerHTML="<input type=\"password\" tabindex=\"2\" class=\"px p_fre\" size=\"30\" name=\"{$_G['setting']['reginput']['password']}\" placeholder=\"{$n5app['lang']['dlzcqsrmm']}\" fwin=\"login\" value="+this.register.{$_G['setting']['reginput']['password']}.value+">";
click.innerHTML="<a href=\"javascript:ps()\" class=\"n5dl_xsmm\"></a>"}
</script>
<script language="JavaScript">
function pc(){
if (this.register.{$_G['setting']['reginput']['password2']}.type="password")
boxs.innerHTML="<input type=\"html\" tabindex=\"3\" class=\"px p_fre\" size=\"30\" name=\"{$_G['setting']['reginput']['password2']}\" placeholder=\"{$n5app['lang']['dlczqzcqrmm']}\" fwin=\"login\" value="+this.register.{$_G['setting']['reginput']['password2']}.value+">";
clicks.innerHTML="<a href=\"javascript:txts()\" class=\"n5dl_ycmm\"></a>"}
function txts(){
if (this.register.{$_G['setting']['reginput']['password2']}.type="text")
boxs.innerHTML="<input type=\"password\" tabindex=\"3\" class=\"px p_fre\" size=\"30\" name=\"{$_G['setting']['reginput']['password2']}\" placeholder=\"{$n5app['lang']['dlczqzcqrmm']}\" fwin=\"login\" value="+this.register.{$_G['setting']['reginput']['password2']}.value+">";
clicks.innerHTML="<a href=\"javascript:pc()\" class=\"n5dl_xsmm\"></a>"}
</script>
<!--{eval updatesession();}-->
<!--{template common/footer}-->