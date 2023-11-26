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
	<a href="forum.php?mod=guide&view=newthread&mobile=2" class="wxmsy"></a>
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a href="forum.php?mod=guide&view=newthread&mobile=2" class="n5qj_ycan shouye"><!--{if $_G[member][newprompt]}--><b></b><!--{/if}--><!--{if $_G[member][newpm]}--><b></b><!--{/if}--></a>
	<span>{$n5app['lang']['rwzxbt']}</span>
</div>
{/if}
<!--{if empty($do)}-->
<style type="text/css">
	.ztfl_fllb {width: 100%;} 
	.ztfl_fllb ul li {width: 25%;padding: 0;}
</style>
<div class="n5sq_ztfl">
	<div class="ztfl_flzt">
		<div class="ztfl_fllb">
			<ul id="n5sq_glpd">
				<li$actives[new]><a href="home.php?mod=task&item=new">{$n5app['lang']['rwzxxrw']}</a></li>
				<li$actives[doing]><a href="home.php?mod=task&item=doing">{$n5app['lang']['rwzxjxz']}</a></li>
				<li$actives[done]><a href="home.php?mod=task&item=done">{$n5app['lang']['rwzxywc']}</a></li>
				<li$actives[failed]><a href="home.php?mod=task&item=failed">{$n5app['lang']['rezxsbd']}</a></li>
			</ul>
		</div>
	</div>
</div>
<!--{/if}-->

<div class="n5rw_rwkj cl">
	<!--{if empty($do)}-->
		<!--{subtemplate home/space_task_list}-->
	<!--{elseif $do == 'view'}-->
		<!--{subtemplate home/space_task_detail}-->
	<!--{/if}-->
</div>
<!--{template common/footer}-->