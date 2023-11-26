<?php exit;?>
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<div id="comment" class="n5mh_wypl cl">
	<h2>
		<!--{if $data[commentnum] > 0}-->$data[commentnum]{$n5app['lang']['wznrpltsdw']}<!--{/if}-->{$n5app['lang']['wznrwyplbl']}
		<!--{if $data[commentnum] > 20}--><span class="y"><a href="$common_url">{lang view_all_comments}</a></span><!--{/if}-->
	</h2>
	<!--{if $data[commentnum] > 0}-->
	<div id="comment_ul" class="xwpl_plnrs cl">
		<!--{loop $commentlist $comment}-->
		<!--{template portal/comment_li}-->
		<!--{if !empty($aimgs[$comment[cid]])}-->
			<script type="text/javascript" reload="1">aimgcount[{$comment[cid]}] = [<!--{echo implode(',', $aimgs[$comment[cid]]);}-->];attachimgshow($comment[cid]);</script>
		<!--{/if}-->
		<!--{/loop}-->
	</div>
	<!--{else}-->
	<style type="text/css">
		.n5qj_wnr {padding: 20px 0;}
	</style><!--Fr om www.xhkj 5.com-->
	<div class="n5qj_wnr">
		<img src="template/zhikai_n5app/images/n5sq_gzts.png">
		<p>{$n5app['lang']['kjrzwplts']}</p>
    </div>
	<!--{/if}-->
</div>
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
	.n5sq_nrdb .nrdb_hf {width: 56%;}
</style>
<div class="n5sq_nrdb cl">
	<a {if $_G[uid]}onClick="nryhf()"{/if} class="nrdb_hf {if $_G['uid']}{else}n5app_wdlts{/if}">{$n5app['lang']['sqkshfts']}</a>
	<a href="home.php?mod=spacecp&ac=favorite&type=article&id=$article[aid]&handlekey=favoritearticlehk_{$article[aid]}" class="{if $_G['uid']}dialog{else}n5app_wdlts{/if}"><i class="iconfont icon-n5appnrdz"></i><p>{$n5app['lang']['sqnrdbscnr']}</p></a>
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
<!--{if !$blog[noreply] && helper_access::check_module('blog')}-->
	<form id="cform" name="cform" action="$form_url" method="post" autocomplete="off">
		<div class="plrz_srk cl">
			<textarea name="message" rows="3" class="pt" id="message" onkeydown="ctrlEnter(event, 'commentsubmit_btn');"></textarea>
		</div>	<!--Fro m www.ymg6 .com-->
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
				<!--{if !empty($topicid) }-->
					<input type="hidden" name="referer" value="$topicurl#comment" />
					<input type="hidden" name="topicid" value="$topicid">
				<!--{else}-->
					<input type="hidden" name="portal_referer" value="$viewurl#comment">
					<input type="hidden" name="referer" value="$viewurl#comment" />
					<input type="hidden" name="id" value="$data[id]" />
					<input type="hidden" name="idtype" value="$data[idtype]" />
					<input type="hidden" name="aid" value="$aid">
				<!--{/if}-->
				<input type="hidden" name="formhash" value="{FORMHASH}">
				<input type="hidden" name="replysubmit" value="true">
				<input type="hidden" name="commentsubmit" value="true" />
				<button type="submit" name="commentsubmit_btn" id="commentsubmit_btn" value="true" class="pn">{lang comment}</button>
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
	<script type="text/javascript">
		function succeedhandle_qcblog_$id(url, msg, values) {
			if(values['cid']) {
				comment_add(values['cid']);
			} else {
				$('return_qcblog_{$id}').innerHTML = msg;
			}
		<!--{if $sechash}-->
		<!--{if $secqaacheck}-->
			updatesecqaa('$sechash');
		<!--{/if}-->
		<!--{if $seccodecheck}-->
			updateseccode('$sechash');
		<!--{/if}-->
		<!--{/if}-->
		}
	</script>
<!--{/if}-->
</div>