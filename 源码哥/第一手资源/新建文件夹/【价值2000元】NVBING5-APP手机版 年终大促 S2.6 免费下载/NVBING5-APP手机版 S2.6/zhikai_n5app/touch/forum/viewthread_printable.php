<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<script>document.title = '{$n5app['lang']['ztnrdzqbdz']} - {$n5app['jjseobt']}';</script>
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
	<span>{$n5app['lang']['ztnrdzqbdz']}</span>
</div>
{/if}

<style type="text/css">
.n5sq_dslb {margin-top:0;}
.n5sq_dslb li {height: 38px;}
.n5sq_dslb .dslb_txys img {width: 38px;height: 38px;}
.dslb_hyxx {margin-left: 50px;}
.dslb_hyxx .dslb_hypf {line-height: 38px;font-size: 16px;}
.dslb_hyxx .y {line-height: 38px;font-size: 14px;}
</style>
<!--{eval $recommend_users = DB::fetch_all("SELECT a.recommenduid,a.dateline,b.username,b.uid FROM ".DB::table('forum_memberrecommend')." a LEFT JOIN ".DB::table('common_member')." b on b.uid=a.recommenduid WHERE a.`tid` = '$_G[tid]' AND b.`status`=0 ORDER BY a.`dateline` DESC LIMIT 0,20");}-->
<div class="n5sq_dslb cl">
	<ul>
	<!--{if $recommend_users}-->
	<!--{loop $recommend_users $rdu}-->
		<li>
			<div class="dslb_txys cl"><a href="home.php?mod=space&uid=$log[uid]&do=profile"><img src="uc_server/avatar.php?uid={$rdu['uid']}&size=middle"/></a></div>
			<div class="dslb_hyxx cl">
				<span class="y">{echo date("Y-m-d H:i",$rdu['dateline'])}</span>
				<div class="dslb_hypf cl"><a href="home.php?mod=space&uid=$log[uid]" class="rate_user">{$rdu['username']}</a></div>
				<p>$log[reason]</p>
			</div>
		</li>
	<!--{/loop}-->
	<!--{/if}-->
	</ul>
</div>
<!--{template common/footer}-->