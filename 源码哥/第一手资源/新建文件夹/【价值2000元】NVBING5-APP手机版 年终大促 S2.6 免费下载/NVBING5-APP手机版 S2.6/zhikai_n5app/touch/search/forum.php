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
	<a href="forum.php?forumlist=1&mobile=2" class="wxmsy"></a>
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a href="forum.php?forumlist=1&mobile=2" class="n5qj_ycan shouye"><!--{if $_G[member][newprompt]}--><b></b><!--{/if}--><!--{if $_G[member][newpm]}--><b></b><!--{/if}--></a>
	<span>{$n5app['lang']['sssstz']}</span>
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
				<li class="a"><a href="search.php?mod=forum">{$n5app['lang']['sqtsfbpt']}</a></li>
				<li><a href="search.php?mod=portal">{$n5app['lang']['sssswzwz']}</a></li>
				<li><a href="search.php?mod=blog">{$n5app['lang']['kjezxqbt']}</a></li>
				<li><a href="search.php?mod=album">{$n5app['lang']['grkjsyxc']}</a></li>
				<li><a href="search.php?mod=group">{$n5app['lang']['sssswzqz']}</a></li>
			</ul>
		</div>
	</div>
</div>

<form id="searchform" class="searchform" method="post" autocomplete="off" action="search.php?mod=forum&mobile=2">
	<input type="hidden" name="formhash" value="{FORMHASH}" />
	<!--{subtemplate search/pubsearch}-->
	<!--{eval $policymsgs = $p = '';}-->
	<!--{loop $_G['setting']['creditspolicy']['search'] $id $policy}-->
	<!--{block policymsg}--><!--{if $_G['setting']['extcredits'][$id][img]}-->$_G['setting']['extcredits'][$id][img] <!--{/if}-->$_G['setting']['extcredits'][$id][title] $policy $_G['setting']['extcredits'][$id][unit]<!--{/block}-->
	<!--{eval $policymsgs .= $p.$policymsg;$p = ', ';}-->
	<!--{/loop}-->
</form>

<!--{if !empty($searchid) && submitcheck('searchsubmit', 1)}-->
	<!--{subtemplate search/thread_list}-->
<!--{else}-->
	<!--{if $_G['setting']['srchhotkeywords']}-->
	<script type="text/javascript">
      $(document).ready(function() {
         var tags_a = $(".n5ss_rmss a");
         tags_a.each(function(){
             var x = 6;
             var y = 0;
             var rand = parseInt(Math.random() * (x - y + 1) + y);
             $(this).addClass("rmss"+rand);
          });
      })   
    </script>
	<div class="n5ss_rmss cl">
	<!--{loop $_G['setting']['srchhotkeywords'] $val}-->
	<!--{if $val=trim($val)}-->
	<!--{eval $valenc=rawurlencode($val);}-->
	<!--{block srchhotkeywords[]}-->
		<!--{if !empty($searchparams[url])}-->
			<a href="$searchparams[url]?q=$valenc&source=hotsearch{$srchotquery}">$val</a>
		<!--{else}-->
			<a href="search.php?mod=forum&srchtxt=$valenc&formhash={FORMHASH}&searchsubmit=true&source=hotsearch">$val</a>
		<!--{/if}-->
	<!--{/block}-->
	<!--{/if}-->
	<!--{/loop}-->
	<!--{echo implode('', $srchhotkeywords);}-->
	</div>
	<!--{/if}-->
<!--{/if}-->

<!--{template common/footer}-->