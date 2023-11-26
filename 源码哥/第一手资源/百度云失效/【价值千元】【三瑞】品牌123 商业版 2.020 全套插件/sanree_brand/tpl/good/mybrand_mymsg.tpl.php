<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
	<!--{template common/header}-->
	<link rel="stylesheet" type="text/css" href="data/cache/style_{STYLEID}_home_space.css?{VERHASH}" />
	<link rel="stylesheet" type="text/css" href="data/cache/style_{STYLEID}_forum_viewthread.css?{VERHASH}" />
	<link rel="stylesheet" type="text/css" href="{SANREE_BRAND_TEMPLATE}/sanree_brand.css?{VERHASH}" />
	<div id="pt" class="bm cl">
		<div class="z">
			<a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em>
			<a href="{$allurl}">{$config['mantitle']}</a>
			
		</div>
	</div>
	<div id="ct" class="ct2_a wp cl">

			<div class="appl" style="float:left;">
				<div class="tbn">
					<h2 class="mt bbda">{$config['mantitle']}</h2>
					<ul>
						<li$actives[me]><a href="plugin.php?id=sanree_brand&mod=mybrand&view=me">{lang sanree_brand:mybrand}({$bcount[3]})</a></li>
						<li$actives[mymsg]><a href="plugin.php?id=sanree_brand&mod=mybrand&view=mymsg">{lang sanree_brand:mymsg}</a></li>
						<!--{hook/sanree_brand_userbar}-->
					</ul>
				</div>
			</div>
			<div class="mn pbm" style="border:none; margin:0">
			<div class="tbmu cl">
               <span class="y">{$msgcounttip}</span>
			</div>

			<div class="ptw">
				<!--{if $count}-->
					<div class="xld xlda">
					<!--{loop $list $k $value}-->
						<dl class="bbda">
							<dd class="m">
								<div class="avt"><a href="home.php?mod=space&uid=$value[uid]" target="_blank"><!--{avatar($value[uid],small)}--></a></div>
							</dd>
				
							<dt class="xs2">
								$value[subject]
								<!--{if $value[status] == 1}--> <span class="xi1"></span><!--{/if}-->
							</dt>
							<dd>
								<a href="home.php?mod=space&uid=$value[uid]">$value[username]</a> <span class="xg1">$value[dateline]</span>
							</dd>
							<dd class="cl" id="blog_article_$value[blogid]">
								$value[message]
							</dd>
							<dd class="xg1">
							</dd>
						</dl>
					<!--{/loop}-->
					</div>
					<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->
				<!--{else}-->
					<div class="emp">{lang sanree_brand:no_msg}</div>
				<!--{/if}-->	
			</div>
		   
		</div>
	</div>
<!--{template common/footer}-->