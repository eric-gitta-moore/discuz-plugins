<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
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
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">
.bg {padding-top: 0;}
</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:history.back();" class="wxmsf"></a>
	<!--{if helper_access::check_module('doing')}-->
	<a <!--{if $_G[uid]}-->onClick="nryhf()"<!--{/if}--> class="wxmsb {if $_G['uid']}{else}n5app_wdlts{/if}"></a>
	<!--{/if}-->
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>

	<!--{if helper_access::check_module('doing')}-->
	<a <!--{if $_G[uid]}-->onClick="nryhf()"<!--{/if}--> class="n5qj_ycan kjrzbj {if $_G['uid']}{else}n5app_wdlts{/if}"></a>
	<!--{/if}-->
	<span>{$n5app['lang']['hykjssbt']}</span>
</div>
{/if}
<div class="n5ss_ssbj cl">
	<img src="template/zhikai_n5app/images/n5ss_ssbj.jpg">
</div>
<style type="text/css">
	.ztfl_fllb {width: 100%;} 
	.ztfl_fllb ul li {width: 33.33%;padding: 0;}
</style>
<div class="n5sq_ztfl">
	<div class="ztfl_flzt">
		<div class="ztfl_fllb">
			<ul id="n5sq_glpd">
				<li$actives[me]><a href="home.php?mod=space&do=$do&view=me" {if $_G['uid']}{else}class="n5app_wdlts"{/if}>{$n5app['lang']['hykjwdss']}</a></li>
				<li$actives[we]><a href="home.php?mod=space&do=$do&view=we" {if $_G['uid']}{else}class="n5app_wdlts"{/if}>{$n5app['lang']['hykjhyss']}</a></li>
				<li$actives[all]><a href="home.php?mod=space&do=$do&view=all">{lang view_all}</a></li>
			</ul>
		</div>
	</div>
</div>
<!--{if $_G[uid]}-->
<!--{if helper_access::check_module('doing')}-->
	<!--{template home/space_doing_form}-->
<!--{/if}-->
<!--{/if}-->


<!--{if $dolist}-->
	<style type="text/css">
		.n5gr_rzpl {margin-top: 0;background: #fff;padding-top: 5px;}
		.plxm_plnr {margin-left: 45px;padding-bottom: 20px;}
		.plxm_plnr .plnr_rzcz .rzcz_hysj a {font-size: 14px;}
		.plxm_plnr .plnr_rzcz .rzcz_hysj span {font-size: 12px;}
		.n5gr_rzpl .rzpl_plnr .plnr_rzhf {font-size: 14px;}
		.n5gr_rzpl .rzpl_plnr .plnr_plxm {margin-bottom: 20px;}
		.n5gr_rzpl .rzpl_plnr .plnr_plxm .plxm_hytx img {width: 35px;height: 35px;}
	</style>
	<div class="n5gr_rzpl cl">
	<div class="rzpl_plnr">
	<!--{loop $dolist $dv}-->
	<!--{eval $doid = $dv[doid];}-->
	<!--{eval $_GET[key] = $key = random(8);}-->
		<div id="{$key}dl{$doid}" class="plnr_plxm cl">
			<!--{if empty($diymode)}-->
			<div class="plxm_hytx cl">
				<a href="home.php?mod=space&amp;uid=$dv[uid]&amp;do=profile&amp;mobile=2" c="1"><!--{avatar($dv[uid],middle)}--></a>
			</div>
			<!--{/if}-->
			<div class="plxm_plnr cl">
				<div class="plnr_rzcz cl">
					<div class="rzcz_hfcz y cl">
						<!--{if $dv[uid]==$_G[uid]}-->
						<a href="home.php?mod=spacecp&ac=doing&op=delete&doid=$doid&id=$dv[id]&handlekey=doinghk_{$doid}_$dv[id]" class="rzcz_hfsc dialog"></a>
						<!--{/if}-->
						<!--{if helper_access::check_module('doing')}-->
						<a href="home.php?mod=spacecp&amp;ac=doing&amp;op=docomment&amp;handlekey=msg_0&amp;doid=$doid&amp;id=0&amp;key=$key" class="rzcz_hfrz {if $_G['uid']}dialog{else}n5app_wdlts{/if}"></a>
						<!--{/if}-->
					</div>
					<div class="rzcz_hysj z cl">
						<a href="home.php?mod=space&amp;uid=$dv[uid]&amp;do=profile&amp;mobile=2">$dv[username]</a>
						<span><!--{date($dv['dateline'])}--></span>
					</div>
				</div>
				<div class="plnr_rzhf">$dv[message]</div>
				<!--{eval $list = $clist[$doid];}-->
				<div class="n5ss_hflb cl" id="{$key}_$doid"{if empty($list) || !$showdoinglist[$doid]} style="display:none;"{/if}>
					<span id="{$key}_form_{$doid}_0"></span>
					<!--{template home/space_doing_li}-->
				</div>
			</div>
		</div>
	<!--{/loop}-->
	</div></div>

	<!--{if $multi}-->
		<div class="pgs cl mtm">$multi</div>
	<!--{/if}-->
<!--{else}-->
	<div class="n5qj_wnr">
		<img src="template/zhikai_n5app/images/n5sq_gzts.png">
		<p>{lang doing_no_replay}<!--{if $space[self]}--><p>{lang doing_now}</p><!--{/if}--></p>
	</div>
<!--{/if}-->
<div class="n5qj_wbys cl">
	<a href="forum.php?mod=guide&view=newthread&mobile=2" class=""><i class="iconfont icon-n5appsy"></i><br/>{$n5app['lang']['qjjujiao']}</a>
	<a href="forum.php?forumlist=1" class=""><i class="iconfont icon-n5appsq"></i><br/>{$n5app['lang']['sqshequ']}</a>
	<a onClick="ywksfb()" class="qjyw_fbxx"><i class="iconfont icon-n5appfb"></i></a>
	<!--{if $n5app['dbdhdsl'] == 1}--><a href="group.php" class=""><i class="iconfont icon-n5appqz"></i><br/>{$n5app['lang']['sssswzqz']}</a>
	<!--{elseif $n5app['dbdhdsl'] == 2}--><a href="home.php?mod=follow" class=""><i class="iconfont icon-n5appht"></i><br/>{$n5app['lang']['qjhuati']}</a>
	<!--{elseif $n5app['dbdhdsl'] == 3}--><a href="{$n5app['dbdhsasllj']}" class="qjyw_fxxx"><i class="iconfont icon-n5appdsl"></i><br/>{$n5app['dbdhsaslwz']}</a>
	<!--{/if}-->
	<!--{if $n5app['dbdhssl'] == 1}--><a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->" <!--{if $_G[uid]}-->class="qjyw_txys"<!--{/if}-->><!--{if $_G[uid]}--><!--{avatar($_G[uid])}--><!--{else}--><i class="iconfont icon-n5appwd"></i><!--{/if}--><br/>{$n5app['lang']['qjwode']}<!--{if $_G[member][newprompt]}--><b></b><!--{/if}--><!--{if $_G[member][newpm]}--><b></b><!--{/if}--></a>
	<!--{elseif $n5app['dbdhssl'] == 2}--><a href="{$n5app['dbdhssllj']}" class="qjyw_fxxx"><i class="iconfont icon-n5appfx"></i><br/>{$n5app['dbdhsslwz']}</a><!--{/if}-->
</div>
<div class="wbys_yqmb"></div>
<!--{template common/footer}-->