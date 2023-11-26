<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5_groupjr.php'}-->
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">
.bg {padding-top: 0;}
.n5sq_qhzt .n5sq_fqbf {top: 0;height: 100%;}
</style>
<div class="n5qj_wxgdan cl">
	<a href="group.php" class="wxmsf"></a>
	<a href="forum.php?mod=group&amp;action=create" class="wxmcj {if $_G[uid]}{else}n5app_wdlts{/if}"></a>
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="group.php" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a href="forum.php?mod=group&amp;action=create" id="create_group_btn" class="n5qj_ycan htsycj {if $_G[uid]}{else}n5app_wdlts{/if}"></a>
	<script type="text/javascript">
var jq = jQuery.noConflict(); 
function toshare(){
jq(".n5ht_htsxs").addClass("am-modal-actives");	
if(jq(".sharebgs").length>0){
jq(".sharebgs").addClass("sharebgs-active");
}else{
jq("body").append('<div class="sharebgs"></div>');
jq(".sharebgs").addClass("sharebgs-active");
}
jq(".sharebgs-active,.share_btn").click(function(){
jq(".n5ht_htsxs").removeClass("am-modal-actives");	
setTimeout(function(){
jq(".sharebgs-active").removeClass("sharebgs-active");	
jq(".sharebgs").remove();	
},300);
})
}	
</script>
	<span class="n5qj_htsx" onclick="toshare()">$curtype[name]</span>
</div>
{/if}
<div class="n5ht_htsxs">
<div class="n5ht_htsx cl">
	<ul>
		<li><a href="$url" class="$selectorder[default] sx1">{$n5app['lang']['htsxmr']}</a></li>
		<li><a href="$url&orderby=thread" class="$selectorder[thread] sx2">{$n5app['lang']['sqzhutits']}</a></li>
		<li><a href="$url&orderby=membernum" class="$selectorder[membernum] sx2">{lang group_member_count}</a></li>
		<li><a href="$url&orderby=dateline" class="$selectorder[dateline] sx2">{$n5app['lang']['sqshangpinsj']}</a></li>
		<li><a href="$url&orderby=activity" class="$selectorder[activity] sx3">{$n5app['lang']['htsxrd']}</a></li>
	</ul>
</div>
</div>

<style type="text/css">
.n5sq_qhzt .n5sq_fqbf {width: 25%;height: 100%;}
.n5sq_qhzt .n5sq_bkbf .bm_c {padding: 5px 15px;}
.n5sq_qhzt .n5sq_bkbf li {height: 44px;line-height: 22px;padding: 10px 0;font-size: 15px;}
.n5sq_qhzt .n5sq_bkbf li img {width: 44px;height: 44px;}
.n5sq_qhzt .n5sq_bkbf li .btdb {margin-top: 0;}
.n5sq_qhzt .n5sq_bkbf li .n5sq_bkgz {position: absolute;top: 18px;height: 27px;line-height: 27px;}
.sharebgs {top: 45px;}
.n5qj_wnr {padding-top: 100px;}
.n5qj_wnr p {line-height: 25px;padding-top: 10px;}
</style>
<div class='n5sq_qhzt'>
    <ul class="n5sq_fqbf cl">
		<!--{eval $qunzudh = DB::fetch_all("SELECT * FROM ".DB::table('forum_forum')." WHERE `type`= 'group' AND status = '3' ORDER BY `displayorder` ASC");}-->
		<!--{loop $qunzudh $htfq}-->
            <li class="bo_bl {if $_GET['gid'] == $htfq[fid]}active{/if}"><a href="group.php?gid=$htfq[fid]&amp;mobile=2">$htfq[name]</a></li>
		<!--{/loop}-->
    </ul>
    <div class="n5sq_bkbf cl">
		<div class="bm_c">
		<!--{if $list}-->
			<ul>
				<!--{eval require "./source/plugin/zhikai_n5appgl/nvbing5_huati.php"}-->
				<!--{eval $tuijian = DB::fetch_all("SELECT * FROM ".DB::table('forum_forum')." WHERE `type`= 'sub' AND status = '3' AND fup in ($str) ORDER BY `displayorder` ASC");}-->
				<!--{loop $list $fid $val}-->
				<li {if checkGroupJoin($val['fid'])} class="tjlb_pdys"{/if}>
					<a href="forum.php?mod=forumdisplay&action=list&fid=$fid"><img src="$val[icon]" alt="$val[name]" align="left"></a>
					<a href="forum.php?mod=forumdisplay&action=list&fid=$fid" class="btdb">$val[name]</a>
					<p>{lang threads}:$val[threads]&nbsp;/&nbsp;{$n5app['lang']['qzfllbqzcy']}:$val[membernum]</p>
					{if checkGroupJoin($val['fid'])}{else}<a href="forum.php?mod=group&amp;action=join&amp;fid=$val[fid]&amp;mobile=2" class="n5sq_bkgz {if $_G[uid]}dialog{else}n5app_wdlts{/if}">{if checkGroupJoin($_G['fid'])}111{else}{$n5app['lang']['htsyjrht']}{/if}</a>{/if}
				</li>
				<!--{/loop}-->
				<style type="text/css">
					.page {margin: 20px 0 70px 0;}
				</style>
				$multipage
			</ul>
		<!--{else}-->
			<div class="n5qj_wnr">
				<img src="template/zhikai_n5app/images/n5sq_gzts.png">
				<p>{$n5app['lang']['qbhtlbwts']}</p>
			</div>
		<!--{/if}-->
		</div>
    </div>
</div>
<!--{template common/footer}-->