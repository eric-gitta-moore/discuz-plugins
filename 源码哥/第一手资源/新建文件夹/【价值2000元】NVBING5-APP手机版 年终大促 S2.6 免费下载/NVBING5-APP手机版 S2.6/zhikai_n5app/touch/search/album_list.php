<?php exit;?>
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<style type="text/css">
.n5ss_sslb {padding-bottom: 0;}
.n5ss_sslb h2 {margin-bottom: 0;}
</style>
<div class="n5ss_sslb cl">
	<h2><!--{if $keyword}-->{lang search_result_keyword}<!--{else}-->{lang search_result}<!--{/if}--></h2>
</div>
<div class="n5ss_xclb cl">
	<!--{if empty($albumlist)}-->
		<div class="n5qj_wnr" style="padding: 40px 0 80px 0;">
			<img src="template/zhikai_n5app/images/n5sq_gzts.png">
			<p>{$n5app['lang']['ssghgjcss']}</p>
		</div>
	<!--{else}-->
		<ul>
			<!--{loop $albumlist $key $value}-->
				<li>
					<!--{if $value[picnum]}--><div class="ssxc_tpsl">$value[picnum]P</div><!--{/if}-->
					<a href="home.php?mod=space&uid=$value[uid]&do=album&id=$value[albumid]">
						<!--{if $value[pic]}--><img src="$value[pic]" /><!--{/if}-->
						<span></span>
						<em><!--{if $value[albumname]}-->$value[albumname]<!--{/if}--></em>
					</a>
				</li>
			<!--{/loop}-->
		</ul>
	<!--{/if}-->
</div>
<style type="text/css">
.page {margin-top: 30px;}
</style>
$multipage