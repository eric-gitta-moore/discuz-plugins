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
</div><!--Fro m www.xhkj5.com-->
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a href="forum.php?forumlist=1&mobile=2" class="n5qj_ycan shouye"><!--{if $_G[member][newprompt]}--><b></b><!--{/if}--><!--{if $_G[member][newpm]}--><b></b><!--{/if}--></a>
	<span>{$n5app['lang']['biaoqian']}</span>
</div>
{/if}
<!--{if $type != 'countitem'}-->
	<div id="ct" class="n5bq_bqss cl">
		<form method="post" action="misc.php?mod=tag" class="pns">
			<div class="bqss_srnr z cl"><input type="text" name="name" class="px vm" size="30" /></div>
			<div class="bqss_qrss z cl"><button type="submit" class="pn vm">{lang search}</button></div>
		</form><!--Fr om www.xhkj5.com-->
	</div>
	
	<!--{if $tagarray}-->
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
			<!--{loop $tagarray $tag}-->
				<a href="misc.php?mod=tag&id=$tag[tagid]" title="$tag[tagname]">$tag[tagname]</a>
			<!--{/loop}-->
		</div>
	<!--{else}-->
		<div class="n5qj_wnr">
			<img src="template/zhikai_n5app/images/n5sq_gzts.png">
			<p>{$n5app['lang']['zdwbqtsxx']}</p>
		</div>
	<!--{/if}-->
	
<!--{else}-->
	$num
<!--{/if}-->
<!--{template common/footer}-->