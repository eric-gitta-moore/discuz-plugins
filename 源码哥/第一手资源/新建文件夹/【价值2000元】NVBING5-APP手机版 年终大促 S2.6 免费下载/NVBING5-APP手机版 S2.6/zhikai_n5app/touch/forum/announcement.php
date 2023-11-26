<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<script type="text/javascript" src="{$_G[setting][jspath]}common.js"></script>
<style type="text/css">.n5qj_top {display: none;}</style><!--From ww w.xhkj5.com-->
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">.bg {padding-top: 0;}</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:history.back();" class="wxmsf"></a>
	<a href="forum.php?forumlist=1&mobile=2" class="wxmsy"></a>
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a href="forum.php?forumlist=1&mobile=2" class="n5qj_ycan shouye"><!--{if $_G[member][newprompt]}--><b></b><!--{/if}--><!--{if $_G[member][newpm]}--><b></b><!--{/if}--></a>
	<span>{$n5app['lang']['gonggaobiaoti']}</span>
</div>
{/if}
<!--{loop $announcelist $ann}-->
<div class="n5gg_gglb cl">
	<div id="announce$ann[id]_c" class="umh{if $messageid != $ann[id]} umn{/if}">
		<h3 onclick="toggle_collapse('announce$ann[id]', 1, 1);">$ann[subject]</h3>
	</div><!--Fro m www.xhkj5.com-->
	<div id="announce$ann[id]" class="n5gg_ggys cl" style="display: none">
		<p><span class="y">$ann[starttime]</span><span class="z">{lang author}: <a href="home.php?mod=space&username=$ann[authorenc]" class="xi2">$ann[author]</a></span></p>
		<div class="n5gg_ggnr cl">$ann[message]</div>
	</div>
</div>
<!--{/loop}-->
<!--{template common/footer}-->