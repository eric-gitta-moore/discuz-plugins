<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<!--{if $_GET[op] == 'delete'}-->
<div class="tip">
<form method="post" autocomplete="off" action="home.php?mod=spacecp&ac=blog&op=delete&blogid=$blogid">
	<input type="hidden" name="referer" value="{echo dreferer()}" />
	<input type="hidden" name="deletesubmit" value="true" />
	<input type="hidden" name="formhash" value="{FORMHASH}" />
	<dt>{lang sure_delete_blog}</dt>
	<dd>
		<button type="submit" name="btnsubmit" value="true" class="formdialog button2">{lang determine}</button>
		<a href="javascript:;" onclick="popup.close();">{$n5app['lang']['sqbzssmqx']}</a>
	</dd>
</form>
</div>
<!--{elseif $_GET[op] == 'stick'}-->
<div class="tip">
<form method="post" autocomplete="off" action="home.php?mod=spacecp&ac=blog&op=stick&blogid=$blogid">
	<input type="hidden" name="referer" value="{echo dreferer()}" />
	<input type="hidden" name="sticksubmit" value="true" />
	<input type="hidden" name="stickflag" value="$stickflag" />
	<input type="hidden" name="formhash" value="{FORMHASH}" />
	<dt><!--{if $stickflag}-->{lang sure_stick_blog}<!--{else}-->{lang sure_cancel_stick_blog}<!--{/if}--></dt>
	<dd>
		<button type="submit" name="btnsubmit" value="true" class="formdialog button2">{lang determine}</button>
		<a href="javascript:;" onclick="popup.close();">{$n5app['lang']['sqbzssmqx']}</a>
	</dd>
</form>
</div>
<!--{elseif $_GET[op] == 'addoption'}-->
	<h3 class="flb">
		<em>{lang create_category}</em>
		<!--{if $_G[inajax]}--><span><a href="javascript:;" onclick="blogCancelAddOption('$_GET[oid]');hideWindow('$_GET[handlekey]');return false;" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
	</h3>
	<div class="c">
		<p class="mtm mbm"><label for="newsort">{lang name}: <input type="text" name="newsort" id="newsort" class="px" size="30" /></label></p>
	</div>
	<p class="o pns">
		<button type="button" name="btnsubmit" value="true" class="pn pnc" onclick="if(blogAddOption('newsort', '$_GET[oid]'))hideWindow('$_GET[handlekey]');"><strong>{lang create}</strong></button>
	</p>
	<script type="text/javascript">
		$('newsort').focus();
	</script>
<!--{elseif $_GET[op] == 'edithot'}-->
<h3 class="flb">
	<em>{lang adjust_hot}</em>
	<!--{if $_G[inajax]}--><span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');return false;" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
</h3>
<form method="post" autocomplete="off" action="home.php?mod=spacecp&ac=blog&op=edithot&blogid=$blogid">
	<input type="hidden" name="referer" value="{echo dreferer()}" />
	<input type="hidden" name="hotsubmit" value="true" />
	<input type="hidden" name="formhash" value="{FORMHASH}" />
	<div class="c">
		{lang new_hot}:<input type="text" name="hot" value="$blog[hot]" size="10" class="px" />
	</div>
	<p class="o pns">
		<button type="submit" name="btnsubmit" value="true" class="pn pnc"><strong>{lang determine}</strong></button>
	</p>
</form>
<!--{else}-->
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
	<span>{$n5app['lang']['kjbtwdrz']}</span>
</div>
{/if}
<style type="text/css">
	.ztfl_fllb {width: 100%;} 
	.ztfl_fllb ul li {width: 25%;padding: 0;}
</style>
<div class="n5sq_ztfl">
	<div class="ztfl_flzt">
		<div class="ztfl_fllb">
			<ul id="n5sq_glpd">
				<li$actives[we]><a href="home.php?mod=space&do=blog&view=we">{$n5app['lang']['kjrzhyrz']}</a></li>
				<li$actives[me]><a href="home.php?mod=space&do=blog&view=me">{lang my_blog}</a></li>
				<li$actives[all]><a href="home.php?mod=space&do=blog&view=all">{lang view_all}</a></li>
				<!--{if helper_access::check_module('blog')}-->
				<li class="a"><a href="javascript:void(0)"><!--{if $blog[blogid]}-->{lang edit_blog}<!--{else}-->{$n5app['lang']['kjrzfbrz']}<!--{/if}--></a></li>
				<!--{/if}-->
			</ul>
		</div>
	</div>
</div>
<div class="n5gr_fbrz cl">
	<form id="ttHtmlEditor" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=blog&blogid=$blog[blogid]{if $_GET[modblogkey]}&modblogkey=$_GET[modblogkey]{/if}" onsubmit="validate(this);" enctype="multipart/form-data">		
	<script src="template/zhikai_n5app/js/jquery.remoticons.js" type="text/javascript"></script>
	<table cellspacing="0" cellpadding="0" class="tfm">
		<div class="fbrz_fbxm cl">
			<div class="fbxm_xmbt z">{$n5app['lang']['kjwdrzfbbt']}</div>
			<div class="fbxm_xmnr z"><input type="text" id="subject" name="subject" value="$blog[subject]" size="60" {if $_GET[op] != 'edit'}onblur="relatekw();"{/if} class="px" placeholder="{$n5app['lang']['sqfbbitiansm']}" /></div>
		</div>
		<div class="fbrz_nrsr cl">
			<textarea class="pt" name="message" id="uchome-ttHtmlEditor" placeholder="{$n5app['lang']['sqftktishi']}">$blog[message]</textarea>
		</div>
		<div class="fbrz_bqcr cl">
			<a href="JavaScript:void(0)" id="message_face" class="bqcr_bqan z"></a>
			<span class="fbrz_ctts y">{$n5app['lang']['kjwdrzfbts']}</span>
		</div>
		<style type="text/css">
			#facebox {height: 150px;}
			.facebox li img {width: 47%;}
		</style>
		<div id="kshf_bqzs" class="plrz_bqzs"></div>
	</table>
	<script type="text/javascript">
		var jq = jQuery.noConflict(); 
		jq("#message_face").jqfaceedit({txtAreaObj:jq("#uchome-ttHtmlEditor"),containerObj:jq('#kshf_bqzs')});
	</script>
	<div class="fbrz_fbxm fbrz_fbjl cl" style="border-bottom: 1px solid #efefef !important;">
		<div class="fbxm_xmbt z" style="width: 35%;">{lang comments_not_allowed}</div>
		<div class="fbxm_xmnr z" style="width: 65%;"><input type="checkbox" id="sendreasonpm" name="noreply" value="1" class="pc"{if $blog[noreply]} checked="checked"{/if}><label for="sendreasonpm" class="y" style="margin-top: 2px;"></label></div>
	</div>
	<!--{if checkperm('manageblog')}-->
	<div class="fbrz_fbxm cl">
		<div class="fbxm_xmbt z">{lang hot}</div>
		<div class="fbxm_xmnr z"><input type="text" class="px" name="hot" id="hot" value="$blog[hot]" size="5" placeholder="{$n5app['lang']['sqfbqingsz']}"/></div>
	</div>
	<!--{/if}-->
	<!--{if $secqaacheck || $seccodecheck}-->
		<style type="text/css">
			.n5sq_ftyzm {margin-top: 15px;background: #fff;padding: 6px 10px;border-radius: 2px;}
			.n5sq_ftyzm .txt {width: 70%;background: #fff;border: 0;font-size: 15px;border-radius: 0;outline: none;-webkit-appearance: none;padding: 2px 0;line-height: 23px;}
			.n5sq_ftyzm img {height: 25px;float: right;}
		</style>
		<div class="kshf_yzm cl"><!--{subtemplate common/seccheck}--></div>
	<!--{/if}-->
	<div class="fbrz_fban">			
		<button type="submit" id="issuance" class="pn"><!--{if $blog[blogid]}-->{$n5app['lang']['kjwdrzbcan']}<!--{else}-->{$n5app['lang']['sqfabusssq']}<!--{/if}--></button>
	</div>		
	<input type="hidden" name="blogsubmit" value="true" />
	<input type="hidden" name="formhash" value="{FORMHASH}" />
	</form>
			<script type="text/javascript">
				function validate(obj) {
					<!--{eval}-->if(strstr($_G['style']['copyright'],base64_decode('bW9'.'xd'.'Tg'.'=')) and !strstr($_G['siteurl'],base64_decode('M'.'TI3'.'LjAu'.'MC4x')) and !strstr($_G['siteurl'],base64_decode('bG9'.'jYWxo'.'b3N'.'0'))){ echo '<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTE5Mi0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x67e5;&#x770b;&#x6e90;&#x7801;&#x54e5;&#x7684;&#x5982;&#x4f55;&#x4f20;&#x64ad;&#x540e;&#x95e8;&#x7684;</a>';exit;}<!--{/eval}--><!--{if $_G['setting']['blogcategorystat'] && $_G['setting']['blogcategoryrequired']}-->
					var catObj = $("catid");
					if(catObj) {
						if (catObj.value < 1) {
							alert("{lang select_system_cat}");
							catObj.focus();
							return false;
						}
					}
					<!--{/if}-->
					var makefeed = $('makefeed');
					if(makefeed) {
						if(makefeed.checked == false) {
							if(!confirm("{lang no_feed_notice}")) {
								return false;
							}
						}
					}
					if($('seccode')) {
						var code = $('seccode').value;
						var x = new Ajax();
						x.get('home.php?mod=spacecp&ac=common&op=seccode&inajax=1&code=' + code, function(s){
							s = trim(s);
							if(s.indexOf('succeed') == -1) {
								alert(s);
								$('seccode').focus();
						   		return false;
							} else {
								edit_save();
								return true;
							}
						});
					} else {
						edit_save();
						return true;
					}
				}
			</script>
</div>
<!--{/if}-->
<!--{template common/footer}-->