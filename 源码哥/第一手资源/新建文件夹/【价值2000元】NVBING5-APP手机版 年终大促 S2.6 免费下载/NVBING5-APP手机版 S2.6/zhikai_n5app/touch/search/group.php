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
	<a href="group.php?mobile=2" class="wxmsy"></a>
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a href="group.php?mobile=2" class="n5qj_ycan htsyht"></a>
	<span>{$n5app['lang']['qzszyybswqz']}</span>
</div>
{/if}
<style type="text/css">
	.ztfl_fllb {width: 100%;} 
	.ztfl_fllb ul li {width: 20%;padding: 0;}
</style>
<div class="n5sq_ztfl">
	<div class="ztfl_flzt">
		<div class="ztfl_fllb">
			<ul id="n5sq_glpd">
				<li><a href="search.php?mod=forum">{$n5app['lang']['sqtsfbpt']}</a></li>
				<li><a href="search.php?mod=portal">{$n5app['lang']['sssswzwz']}</a></li>
				<li><a href="search.php?mod=blog">{$n5app['lang']['kjezxqbt']}</a></li>
				<li><a href="search.php?mod=album">{$n5app['lang']['grkjsyxc']}</a></li>
				<li class="a"><a href="search.php?mod=group">{$n5app['lang']['sssswzqz']}</a></li>
			</ul>
		</div>
	</div>
</div>

<form class="searchform" method="post" autocomplete="off" action="search.php?mod=group" onsubmit="if($('scform_srchtxt')) searchFocus($('scform_srchtxt'));">
<input type="hidden" name="formhash" value="{FORMHASH}" />
<input type="hidden" name="srchfid" value="$srchfid" />
	<!--{subtemplate search/pubsearch}-->
</form>
<!--{if !empty($searchid) && submitcheck('searchsubmit', 1)}-->
	<!--{if $srchfid}-->
		<!--{subtemplate search/thread_list}-->
	<!--{else}-->
		<!--{subtemplate search/group_list}-->
	<!--{/if}-->
<!--{/if}-->

<!--{template common/footer}-->