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
	<span>{$n5app['lang']['kjwdscbt']}</span>
</div>
{/if}
<style type="text/css">
	.ztfl_fllb {width: 100%;} 
	.ztfl_fllb ul li {width: 14.28%;padding: 0;}
</style>
<div class="n5sq_ztfl">
	<div class="ztfl_flzt">
		<div class="ztfl_fllb">
			<ul id="n5sq_glpd">
				<li$actives[all]><a href="home.php?mod=space&do=favorite&type=all">{$n5app['lang']['kjwdscqbsc']}</a></li>
				<li$actives[thread]><a href="home.php?mod=space&do=favorite&type=thread">{lang favorite_thread}</a></li>
				<li$actives[forum]><a href="home.php?mod=space&do=favorite&type=forum">{lang favorite_forum}</a></li>
				<!--{if helper_access::check_module('group')}--><li$actives[group]><a href="home.php?mod=space&do=favorite&type=group">{$n5app['lang']['sssswzqz']}</a></li><!--{/if}-->
				<!--{if helper_access::check_module('blog')}--><li$actives[blog]><a href="home.php?mod=space&do=favorite&type=blog">{lang favorite_blog}</a></li><!--{/if}-->
				<!--{if helper_access::check_module('album')}--><li$actives[album]><a href="home.php?mod=space&do=favorite&type=album">{lang favorite_album}</a></li><!--{/if}-->
				<!--{if helper_access::check_module('portal')}--><li$actives[article]><a href="home.php?mod=space&do=favorite&type=article">{lang favorite_article}</a></li><!--{/if}-->
			</ul>
		</div>
	</div>
</div>
<style type="text/css">
.tip dd .formdialog {padding-right: 0;border-right: 0;}
</style>
<!--{if $list}-->
<form method="post" autocomplete="off" name="delform" id="delform" action="home.php?mod=spacecp&ac=favorite&op=delete&type=$_GET[type]&checkall=1" onsubmit="showDialog('{lang del_select_favorite_confirm}', 'confirm', '', '$(\'delform\').submit();'); return false;">
<input type="hidden" name="formhash" value="{FORMHASH}" />
<input type="hidden" name="delfavorite" value="true" />
<div class="n5gr_wdsc">
	<ul id="favorite_ul">
	<!--{loop $list $k $value}-->
		<li id="fav_$k">
			<a class="y dialog" id="a_delete_$k" href="home.php?mod=spacecp&ac=favorite&op=delete&favid=$k"></a>
			<!--{if $_GET['type'] == 'all'}--><span>$value[icon]</span><!--{/if}-->
			<a href="$value[url]">$value[title]</a>
			<!--{if $value[description]}-->
				<div class="quote">
					<blockquote id="quote_preview">$value[description]</blockquote>
				</div>
			<!--{/if}-->
		</li>
	<!--{/loop}-->
	</ul>
</div>
</form>
<style type="text/css">
.page {margin-top:50px;}
.page a {float: none;display:inline;padding: 10px 30px;}
</style>
<!--{if $multi}-->$multi<!--{/if}-->
<!--{else}-->
<div class="n5qj_wnr">
<img src="template/zhikai_n5app/images/n5sq_gzts.png">
<p>{lang no_favorite_yet}</p>
</div>
<!--{/if}-->
<!--{template common/footer}-->