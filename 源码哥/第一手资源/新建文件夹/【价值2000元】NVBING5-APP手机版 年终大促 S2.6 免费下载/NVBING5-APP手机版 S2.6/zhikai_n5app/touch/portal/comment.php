<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">.bg {padding-top: 0;}</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:history.back();" class="wxmsf"></a>
	<a href="search.php?mod=portal" class="wxmss"></a>
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a href="search.php?mod=portal" class="n5qj_ycan sousuo"></a>
	<span>{lang comment_view}</span>
</div>
{/if}
<style type="text/css">
	.n5mh_wypl {margin-top: 0}
	.n5mh_wypl .xwpl_plnrs {margin: 0 10px 15px 10px;padding-top: 15px;}
</style><!--Fro m www.xhkj5.com-->
<div class="n5xw_qbplbt cl">
	<h2><a href="$url">$csubject[title]</a></h2>
</div>
<div class="n5mh_wypl cl">
<div class="xwpl_plnrs cl">
<!--{loop $commentlist $comment}-->
	<!--{template portal/comment_li}-->
<!--{/loop}-->
</div>
</div>
<style type="text/css">
	.page {margin: 30px 10px 30px 10px;}
</style>
<!--{if $list['multi']}-->{$list['multi']}<!--{/if}-->
<!--{if $csubject['allowcomment'] == 1}-->
<script type="text/javascript">
	var jq = jQuery.noConflict(); 
	function nrywfx(){
		jq(".n5qj_nrfx").addClass("am-modal-active");	
		if(jq(".sharebg").length>0){
			jq(".sharebg").addClass("sharebg-active");
		}else{
			jq("body").append('<div class="sharebg"></div>');
			jq(".sharebg").addClass("sharebg-active");
		}
		jq(".sharebg-active,.nrfx_qxan").click(function(){
			jq(".n5qj_nrfx").removeClass("am-modal-active");	
			setTimeout(function(){
				jq(".sharebg-active").removeClass("sharebg-active");	
				jq(".sharebg").remove();	
			},300);
		})
	}
</script>

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
	.n5sq_nrdb .nrdb_hf {width: 70%;}
</style><!--Fro m www.xhkj5.com-->
<div class="n5sq_nrdb cl">
	<a {if $_G[uid]}onClick="nryhf()"{/if} class="nrdb_hf {if $_G['uid']}{else}n5app_wdlts{/if}">{$n5app['lang']['sqkshfts']}</a>
	<a onClick="nrywfx()"><i class="iconfont icon-n5appnrfxo"></i><p>{$n5app['lang']['sqnrdbfxnr']}</p></a>
</div>

<div class="n5qj_nrfx cl">
	{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}<div class="nrfx_wxfx cl">{$n5app['lang']['sqnrfxgnwx']}</div>{/if}
	<div class="bdsharebuttonbox" data-tag="share_1" id="nrfx_fxxm">
		<a href="#" class="bds_tsina" data-cmd="tsina">{$n5app['lang']['sqnrfxgnxlwb']}</a>
		<a href="#" class="bds_qzone" data-cmd="qzone">{$n5app['lang']['sqnrfxgnqqkj']}</a>
		<a href="#" class="bds_sqq" data-cmd="sqq">{$n5app['lang']['sqnrfxgnqqhy']}</a>
		<a href="#" class="bds_tqq" data-cmd="tqq">{$n5app['lang']['sqnrfxgntxwb']}</a>
		<a href="#" class="bds_weixin" data-cmd="weixin">{$n5app['lang']['sqnrfxgnewm']}</a>
		<a href="#" class="bds_copy" data-cmd="copy">{$n5app['lang']['sqnrfxgnfzwz']}</a>
	</div>
	<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"$article[title] - $_G['setting'][sitename]","bdMini":"2","bdPic":"1","bdStyle":"0","bdSize":"16"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
	<button class="nrfx_qxan">{$n5app['lang']['sqbzssmqx']}</button>
</div>

<script src="template/zhikai_n5app/js/jquery.memoticons.js" type="text/javascript"></script>
<div class="n5sq_kshf n5gr_plrz cl">
	<form id="cform" name="cform" action="portal.php?mod=portalcp&ac=comment" method="post" autocomplete="off">
		<div class="plrz_srk cl">
			<textarea name="message" cols="60" rows="3" class="pt" id="message"></textarea>
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
				<!--{if $idtype == 'topicid' }-->
					<input type="hidden" name="topicid" value="$id">
				<!--{else}-->
					<input type="hidden" name="aid" value="$id">
				<!--{/if}-->
				<input type="hidden" name="formhash" value="{FORMHASH}">
				<button type="submit" name="commentsubmit" value="true" class="pn">{lang comment}</button>
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
		jq("#message_face").jqfaceedit({txtAreaObj:jq("#message"),containerObj:jq('#kshf_bqzs')});
	</script>
</div>
<!--{/if}-->
	
<!--{template common/footer}-->