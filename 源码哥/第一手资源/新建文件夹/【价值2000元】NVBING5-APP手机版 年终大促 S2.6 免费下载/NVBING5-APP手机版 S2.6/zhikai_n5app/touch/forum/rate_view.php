<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./template/zhikai_n5app/lang.php';}-->
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
	<span>{$n5app['lang']['dselqbds']}</span>
</div>
{/if}
<div class="n5sq_dszj cl">
	<i>{lang total}:</i><!--{loop $logcount $id $count}-->&nbsp;{$_G['setting']['extcredits'][$id][title]} <!--{if $count>0}-->+<!--{/if}-->$count {$_G['setting']['extcredits'][$id][unit]}<!--{/loop}-->
</div>
<div class="n5sq_dslb cl">
	<ul>
	<!--{loop $loglist $log}-->
		<li>
			<div class="dslb_txys cl"><a href="home.php?mod=space&uid=$log[uid]&do=profile"><!--{avatar($log[uid],middle)}--></a></div>
			<div class="dslb_hyxx cl">
				<span class="y">$log[dateline]</span>
				<div class="dslb_hypf cl"><a href="home.php?mod=space&uid=$log[uid]" class="rate_user">$log[username]</a><i>{$_G['setting']['extcredits'][$log[extcredits]][title]} $log[score] {$_G['setting']['extcredits'][$log[extcredits]][unit]}</i></div>
				<p>$log[reason]</p>
			</div>
		</li>

	<!--{/loop}-->
	</ul>
</div>
<!--{template common/footer}-->