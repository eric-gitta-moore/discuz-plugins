<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
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
	<span>{$n5app['lang']['wdgrdhwdqz']}</span>
</div>
{/if}
<style type="text/css">
	.ztfl_fllb {width: 100%;} 
	.ztfl_fllb ul li {width: 33.33%;padding: 0;}
</style>
<div class="n5sq_ztfl">
	<div class="ztfl_flzt">
		<div class="ztfl_fllb">
			<ul id="n5sq_glpd">
				<li $actives[join]><a href="group.php?mod=my&view=join">{lang my_join}</a></li>
				<li $actives[manager]><a href="group.php?mod=my&view=manager">{lang my_manage}</a></li>	
				<li><a href="forum.php?mod=group&amp;action=create">{$n5app['lang']['htzxcjht']}</a></li>				
			</ul>
		</div>
	</div>
</div>

<!--{if $view == 'manager' || $view == 'join'}-->
	<!--{if $grouplist}-->
		<div class="n5ht_wdht cl">
			<ul>
				<!--{loop $grouplist $groupid $group}-->
					<li>
						<a href="forum.php?mod=forumdisplay&action=list&fid=$groupid">
							<span class="wdht_httb cl"><img src="$group[icon]" alt="$group[name]" /></span>
							<p class="wdht_htmc">$group[name]</p>
							<p class="wdht_htxx">{lang threads}:$group[threads]</p>
						</a>
					</li>
				<!--{/loop}-->
			</ul>
		</div>
		<!--{if $multipage}-->$multipage<!--{/if}-->
	<!--{else}-->
		<div class="n5qj_wnr">
		    <img src="template/zhikai_n5app/images/n5sq_gzts.png">
			<p><!--{if $view == 'manager'}-->{$n5app['lang']['wdhtwgldts']}<!--{elseif $view == 'join'}-->{$n5app['lang']['wdhtwcydts']}<!--{/if}--></p>
		</div>
	<!--{/if}-->
<!--{/if}-->

<!--{template common/footer}-->