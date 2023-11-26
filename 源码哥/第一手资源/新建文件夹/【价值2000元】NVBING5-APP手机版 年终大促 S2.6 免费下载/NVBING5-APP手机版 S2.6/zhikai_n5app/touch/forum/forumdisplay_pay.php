<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">.bg {padding-top: 0;}</style>
<div class="n5qj_wxgdan cl">
	<a href="forum.php?forumlist=1" class="wxmsf"></a>
	<a href="search.php?mod=forum" class="wxmss"></a>
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="forum.php?forumlist=1" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a href="search.php?mod=forum" class="n5qj_ycan sousuo"></a>
	<span>$_G['forum'][name]</span>
</div>
{/if}
<div class="n5sq_bkjm cl">
	<div class="n5sq_bksf cl"></div>
	<p>{lang youneedpay} <i>$paycredits</i> {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]]['unit']}{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]]['title']}<br />{lang onlyintoforum}</p>
	<div class="bkjm_mmsr">
		<form method="post" autocomplete="off" action="forum.php?mod=forumdisplay&fid=$_G[fid]&action=paysubmit">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<button class="mmsrqr" type="submit" name="loginsubmit" value="true">{lang confirmyourpay}</button>
			<button class="mmsrqrs" type="button" onclick="history.go(-1)">{lang cancel}</button>
		</form>
	</div>
</div>
<!--{template common/footer}-->