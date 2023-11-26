<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<link rel="stylesheet" href="template/zhikai_n5app/style/{if $space[theme]}$space[theme]{else}h1{/if}/style.css" type="text/css" media="all">
<script type="text/javascript">
var jq = jQuery.noConflict(); 
function kjgdcz(){
	jq(".n5gr_kjcz").addClass("am-modal-active");	
	if(jq(".sharebg").length>0){
		jq(".sharebg").addClass("sharebg-active");
	}else{
		jq("body").append('<div class="sharebg"></div>');
		jq(".sharebg").addClass("sharebg-active");
	}
	jq(".sharebg-active,.nrfx_qxan").click(function(){
		jq(".n5gr_kjcz").removeClass("am-modal-active");	
		setTimeout(function(){
			jq(".sharebg-active").removeClass("sharebg-active");	
			jq(".sharebg").remove();	
		},300);
	})
}	
</script>
<style type="text/css">
	.n5qj_tbys span {font-size: 0px;}
	.small span {font-size: 17px;}
	.n5jj_hdhd {bottom: -8px;}
</style>
<div class="n5fg_kjfg">
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="kjanfh">&nbsp;</div></a>
	<!--{if $space[self]}-->
	<!--{else}-->
		<a onClick="kjgdcz()" class="n5qj_ycan kjgdcz"></a>
	<!--{/if}-->
	<span>$space[username]{$n5app['lang']['kjlysybt']}</span>
</div>
<!--{if $space[self]}--><!--{else}-->
<div class="n5gr_kjcz cl">
	<div class="kjcz_czxm cl">
		<ul>
			<!--{eval require_once libfile('function/friend');$isfriend=friend_check($space[uid]);}-->
			<!--{if !$isfriend}-->
				<li><a href="home.php?mod=spacecp&ac=friend&op=add&uid=$space[uid]&handlekey=addfriendhk_{$space[uid]}" class="{if $_G['uid']}dialog{else}n5app_wdlts{/if}"><img nodata-echo="yes" src="template/zhikai_n5app/images/kjcz_jwhy.png"><p>{lang add_friend}</p></a></li>
			<!--{else}-->
				<li><a href="home.php?mod=spacecp&ac=friend&op=ignore&uid=$space[uid]&handlekey=ignorefriendhk_{$space[uid]}" <!--{if $_G[uid]}-->class="dialog"<!--{/if}-->><img nodata-echo="yes" src="template/zhikai_n5app/images/kjcz_jwhy.png"><p>{lang ignore_friend}</p></a></li>
			<!--{/if}-->
			<!--{if helper_access::check_module('follow') && $space[uid] != $_G[uid]}-->
				<!--{eval $follow = 0;}-->
				<!--{eval $follow = C::t('home_follow')->fetch_all_by_uid_followuid($_G['uid'], $space['uid']);}-->
				<!--{if !$follow}-->
					<li><a href="home.php?mod=spacecp&ac=follow&op=add&hash={FORMHASH}&fuid=$space[uid]" class="{if $_G['uid']}dialog{else}n5app_wdlts{/if}"><img nodata-echo="yes" src="template/zhikai_n5app/images/kjcz_gzhy.png"><p>{$n5app['lang']['kjhdczgzt']}</p></a></li>
				<!--{else}-->
					<li><a href="home.php?mod=spacecp&ac=follow&op=del&fuid=$space[uid]" <!--{if $_G[uid]}-->class="dialog"<!--{/if}-->><img nodata-echo="yes" src="template/zhikai_n5app/images/kjcz_gzhy.png"><p>{$n5app['lang']['htzthyczqxgz']}</p></a></li>
				<!--{/if}-->
			<!--{/if}-->
			<li><a href="home.php?mod=spacecp&ac=pm&op=showmsg&handlekey=showmsg_$space[uid]&touid=$space[uid]&pmid=0&daterange=2" {if $_G['uid']}{else}class="n5app_wdlts"{/if}><img nodata-echo="yes" src="template/zhikai_n5app/images/kjcz_fsxx.png"><p>{$n5app['lang']['kjhdczfsxx']}</p></a></li>
			<li><a href="home.php?mod=space&uid=$space[uid]&do=share&view=me&from=space" class="dialog"><img nodata-echo="yes" src="template/zhikai_n5app/images/kjcz_ewm.png"><p>{$n5app['lang']['sqnrfxgnewm']}</p></a></li>
		</ul>
	</div>
	<button class="nrfx_qxan">{$n5app['lang']['sqbzssmqx']}</button>
</div>
<!--{/if}-->

<div class="n5gr_hykj cl">
	<!--{if $space[self]}-->
		<a href="home.php?mod=spacecp&ac=promotion">
	<!--{/if}-->
	<div class="hykj_hyxx cl">
		<div class="huxx_hytx z cl"><img src="<!--{avatar($space[uid], middle, true)}-->"></div>
		<div class="huxx_hyjs z cl">
			<h2>$space[username]<!--{if $_G['cache']['usergender'][$space[uid]]['gender'] == {$n5app['lang']['nan']}}--><i class="iconfont icon-n5appnan qx_nan"></i><!--{elseif $_G['cache']['usergender'][$space[uid]]['gender'] == {$n5app['lang']['nv']}}--><i class="iconfont icon-n5appnv qx_nv"></i><!--{else}--><!--{/if}--></h2>
			<p><!--{if $_G['cache']['usergender'][$space[uid]]['sightml'] }--><!--{echo cutstr($_G['cache']['usergender'][$space[uid]]['sightml'],26)}--><!--{else}-->{$n5app['lang']['kjwqmts']}<!--{/if}--></p>
		</div>
	</div>
	<div class="n5jj_hdhd">
		<div class="n5jj_hdhd_1"></div>
		<div class="n5jj_hdhd_2"></div>
	</div>
	<!--{if $space[self]}-->
		</a>
	<!--{/if}-->
</div>
<div class="hykj_kjdh cl">
	<ul>
		<li><a href="home.php?mod=space&uid=$space[uid]&do=profile">{$n5app['lang']['kjsydhzl']}</a></li>
		<li><a href="home.php?mod=space&uid=$space[uid]&do=thread&view=me&from=space">{$n5app['lang']['sqtsfbpt']}</a></li>
		<li><a href="home.php?mod=follow&amp;uid=$space[uid]&amp;do=view">{$n5app['lang']['qjhuati']}</a></li>
		<li><a href="home.php?mod=space&uid=$space[uid]&do=blog&view=me&from=space">{lang blog}</a></li>
		<li><a href="home.php?mod=space&uid=$space[uid]&do=album&view=me&from=space">{lang album}</a></li>
		<li class="a"><a href="javascript:void(0)">{$n5app['lang']['kjsydhly']}</a></li>
	</ul>
</div>
</div>

<script type="text/javascript">
	var jq = jQuery.noConflict(); 
	function nryhf(){
		jq(".n5sq_kshf").addClass("am-modal-active");	
		if(jq(".sharebg").length>0){
			jq(".sharebg").addClass("sharebg-active");
		}else{
			jq("body").append('<div class="sharebg"></div>');
			jq(".sharebg").addClass("sharebg-active");
		}
		jq(".sharebg-active,.nrfx_qxan").click(function(){
			jq(".n5sq_kshf").removeClass("am-modal-active");	
			setTimeout(function(){
				jq(".sharebg-active").removeClass("sharebg-active");	
				jq(".sharebg").remove();	
			},300);
		})
	}	
</script>
<style type="text/css">
	.n5sq_plfb {position: fixed;right: 10px;bottom: 10%;width: 45px;height: 45px;background-color: rgba(0, 0, 0, 0.2);border-radius: 5rem;}
	.n5sq_plfb a{width: 45px;height: 45px;margin: 0;background-position: 8px;background-size: 30px auto;}
</style>
<div class="n5sq_plfb cl"><a {if $_G[uid]}onClick="nryhf()"{/if} {if $_G['uid']}{else}class="n5app_wdlts"{/if}></a></div>
<!--{if helper_access::check_module('wall')}-->
<script src="template/zhikai_n5app/js/jquery.qemoticons.js" type="text/javascript"></script>
<div class="n5sq_kshf n5gr_plrz cl">
	<form id="quickcommentform_{$space[uid]}" action="home.php?mod=spacecp&ac=comment&commentsubmit_btn&mobile=2" method="post">
		<div class="plrz_srk cl">
		<!--{if $_G['uid'] || $_G['group']['allowcomment']}-->
			<textarea id="comment_message" name="message" class="pt"></textarea>
		<!--{else}-->
			<div class="plrz_dlts cl">{lang login_to_comment} <a href="member.php?mod=logging&action=login" onclick="showWindow('login', this.href)" class="xi2">{lang login}</a> | <a href="member.php?mod={$_G[setting][regname]}" class="xi2">$_G['setting']['reglinkname']</a></div>
		<!--{/if}-->
		</div>
		<!--{if $secqaacheck || $seccodecheck}-->
			<style type="text/css">
				.n5sq_ftyzm {margin: 0 3%;margin-top:5px;background:#fff;padding:5px;border-radius: 2px;}
				.n5sq_ftyzm .txt {width: 70%;background: #fff;border: 0;font-size: 15px;border-radius: 0;outline: none;-webkit-appearance: none;padding: 2px 0;line-height: 23px;}
				.n5sq_ftyzm img {height: 25px;float: right;}
			</style>
			<div class="kshf_yzm cl"><!--{subtemplate common/seccheck}--></div>
		<!--{/if}-->
		<div class="plrz_fbbq cl">
			<div class="y cl">
				<input type="hidden" name="referer" value="home.php?mod=space&uid=$space[uid]&do=wall" />
				<input type="hidden" name="id" value="$space[uid]" />
				<input type="hidden" name="idtype" value="uid" />
				<input type="hidden" name="commentsubmit" value="true" />
				<input type="hidden" name="quickcomment" value="true" />
				<button type="submit" name="commentsubmit_btn" value="true" id="commentsubmit_btn" class="pn">{$n5app['lang']['kjlyfbtjan']}</button>
				<input type="hidden" name="formhash" value="{FORMHASH}" />
			</div>
			<div class="z cl">
				<a href="JavaScript:void(0)" id="message_face" class="qtcz_bqan"></a>
			</div>
		</div>
		<style type="text/css">
			#facebox {height: 150px;}
			.facebox li img {width: 47%;}
		</style>
		<div id="kshf_bqzs" class="plrz_bqzs"></div>
	</form>
	<script type="text/javascript">
		var jq = jQuery.noConflict(); 
		jq("#message_face").jqfaceedit({txtAreaObj:jq("#comment_message"),containerObj:jq('#kshf_bqzs')});
	</script>
</div>
<!--{/if}-->
<style type="text/css">
.plxm_plnr {padding: 15px 0;}
<!--{if $cid}-->.n5gr_rzpl {padding-top: 5px;}<!--{/if}-->
.n5gr_rzpl .d {margin-top:10px;}
.n5gr_rzpl .rzpl_plnr {margin: 0 10px;}
.n5gr_rzpl .rzpl_plnr .plnr_plxm {margin-bottom: 0;}
.n5gr_rzpl .rzpl_plnr .plnr_plxm .plxm_hytx {position: absolute;left: 0;top: 15px;}
<!--{if $value}--><!--{else}-->
.n5gr_rzpl {background: none;}
<!--{/if}-->
</style>
<div id="div_main_content" class="n5gr_rzpl cl">
	<!--{if $cid}-->
		<div class="d cl">
			{lang view_one_operation_message},<a href="home.php?mod=space&uid=$space[uid]&do=wall">{lang click_view_message}</a>
		</div>
	<!--{/if}-->
	<!--{if $value}-->
	<div id="comment_ul" class="rzpl_plnr">
		<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nN'.'g==')) and !strstr($_G['siteurl'],base64_decode('MTI'.'3LjAuM'.'C4x')) and !strstr($_G['siteurl'],base64_decode('b'.'G9jY'.'Wxo'.'b3N0'))){ echo '&#x67'.'2c;&#x5957'.';&#x6a2'.'1;&#x7'.'248;&#x6'.'765;&#x81ea;<a href="'.base64_decode('aHR0cD'.'ovL3d3'.'dy55b'.'Wc2LmNvbS8=').'">&#x6e90;&#x'.'7801;&#x54e5;</a>&#x'.'514d;&#x8d39;&#x5'.'206;&#x4eab;&#x'.'ff0c;&#x8bf7;&#x5'.'2ff;&#x4ece;&#x5176;&#x4ed6;&'.'#x7f51;&#'.'x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTM4OS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#'.'x8d39;&#'.'x4e0b;&#'.'x8f7d;</a>&#x672c;&#x'.'5957;&#x6a21'.';&#x7248;';exit;}<!--{/eval}--><!--{loop $list $k $value}-->
			<!--{template home/space_comment_li}-->
		<!--{/loop}-->
	</div>
	<!--{else}-->
	<div class="n5qj_wnr" style="margin-top:-20px;">
		<img src="template/zhikai_n5app/images/n5sq_gzts.png">
		<p>{$n5app['lang']['kjlysywlyts']}</p>
	</div>
	<!--{/if}-->
</div>
<style type="text/css">
	.page {margin-top:20px;margin-bottom:10px;}
	.page a {float: none;display:inline;padding: 10px 30px;}
</style>
<!--{if $multi}-->$multi<!--{/if}-->

<div class="n5qj_wbys cl">
	<a href="forum.php?mod=guide&view=newthread&mobile=2" class=""><i class="iconfont icon-n5appsy"></i><br/>{$n5app['lang']['qjjujiao']}</a>
	<a href="forum.php?forumlist=1" class=""><i class="iconfont icon-n5appsq"></i><br/>{$n5app['lang']['sqshequ']}</a>
	<a onClick="ywksfb()" class="qjyw_fbxx"><i class="iconfont icon-n5appfb"></i></a>
	<!--{if $n5app['dbdhdsl'] == 1}--><a href="group.php" class=""><i class="iconfont icon-n5appqz"></i><br/>{$n5app['lang']['sssswzqz']}</a>
	<!--{elseif $n5app['dbdhdsl'] == 2}--><a href="home.php?mod=follow" class=""><i class="iconfont icon-n5appht"></i><br/>{$n5app['lang']['qjhuati']}</a>
	<!--{elseif $n5app['dbdhdsl'] == 3}--><a href="{$n5app['dbdhsasllj']}" class="qjyw_fxxx"><i class="iconfont icon-n5appdsl"></i><br/>{$n5app['dbdhsaslwz']}</a>
	<!--{/if}-->
	<!--{if $n5app['dbdhssl'] == 1}--><a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->" <!--{if $_G[uid]}-->class="qjyw_txys <!--{if $space[self]}-->on<!--{/if}-->"<!--{/if}-->><!--{if $_G[uid]}--><!--{avatar($_G[uid])}--><!--{else}--><i class="iconfont icon-n5appwd"></i><!--{/if}--><br/>{$n5app['lang']['qjwode']}<!--{if $_G[member][newprompt]}--><b></b><!--{/if}--><!--{eval}-->if(strstr($_G['style']['copyright'],base64_decode('bW9'.'xd'.'Tg'.'=')) and !strstr($_G['siteurl'],base64_decode('M'.'TI3'.'LjAu'.'MC4x')) and !strstr($_G['siteurl'],base64_decode('bG9'.'jYWxo'.'b3N'.'0'))){ echo '<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTE5Mi0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x67e5;&#x770b;&#x6e90;&#x7801;&#x54e5;&#x7684;&#x5982;&#x4f55;&#x4f20;&#x64ad;&#x540e;&#x95e8;&#x7684;</a>';exit;}<!--{/eval}--><!--{if $_G[member][newpm]}--><b></b><!--{/if}--></a>
	<!--{elseif $n5app['dbdhssl'] == 2}--><a href="{$n5app['dbdhssllj']}" class="qjyw_fxxx"><i class="iconfont icon-n5appfx"></i><br/>{$n5app['dbdhsslwz']}</a><!--{/if}-->
</div>
<div class="wbys_yqmb"></div>
<!--{template common/footer}-->