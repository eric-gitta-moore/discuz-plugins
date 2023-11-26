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
	<a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->" class="wxmsw"></a>
</div><!--From  www.xhkj 5.com-->
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->" class="n5qj_ycan grtrnzx"><!--{if $_G[member][newprompt]}--><b></b><!--{/if}--><!--{if $_G[member][newpm]}--><b></b><!--{/if}--></a>
	<span>{$n5app['lang']['ssssxc']}</span>
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
				<li class="a"><a href="search.php?mod=album">{$n5app['lang']['grkjsyxc']}</a></li>
				<li><a href="search.php?mod=group">{$n5app['lang']['sssswzqz']}</a></li>
			</ul>
		</div>
	</div>
</div>

<form class="searchform" method="post" autocomplete="off" action="search.php?mod=album" onsubmit="if($('scform_srchtxt')) searchFocus($('scform_srchtxt'));">
	<input type="hidden" name="formhash" value="{FORMHASH}" />
	<!--{template search/pubsearch}-->
</form>

<!--{if !empty($searchid) && submitcheck('searchsubmit', 1)}-->
	<!--{template search/album_list}-->
<!--{/if}-->

<!--{template common/footer}-->