<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
	<!--{template common/header}-->
	<link rel="stylesheet" type="text/css" href="data/cache/style_{STYLEID}_home_space.css?{VERHASH}" />
	<link rel="stylesheet" type="text/css" id="sanree_brand" href="source/plugin/sanree_brand/tpl/good/sanree_brand.css?{VERHASH}" />
	<link rel="stylesheet" type="text/css" href="{sr_brand_coupon_TPL}sanree_brand_coupon.css?{VERHASH}" />
	<div id="pt" class="bm cl">
		<div class="z">
			<a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em>
			<a href="{$allurl}">{$brand_config['mantitle']}</a>			
		</div>
	</div>
	<div id="ct" class="ct2_a wp cl">
			<div class="appl">
				<div class="tbn">
					<h2 class="mt bbda">{$brand_config['mantitle']}</h2>
					<ul>
						<li$actives[me]><a href="plugin.php?id=sanree_brand&mod=mybrand&view=me">{lang sanree_brand:mybrand}({$bcount[3]})</a></li>
						<li$actives[mymsg]><a href="plugin.php?id=sanree_brand&mod=mybrand&view=mymsg">{lang sanree_brand:mymsg}</a></li>
						<!--{hook/sanree_brand_userbar}-->
					</ul>
				</div>
			</div>
			<div class="mn pbm" style="border:none; margin:0">
			<div class="tbmu cl">
				<a href="plugin.php?id=sanree_brand_coupon&mod=published" id="publisheddlg" onclick="showWindow(this.id, this.href, 'get', 1)" class="y pn pnc"><strong>{lang sanree_brand_coupon:post_new_coupon}</strong></a>
				<ul class="tb cl">
					<li $stactives[pass]><a href="plugin.php?id=sanree_brand_coupon&mod=mycoupon&view=me&st=pass">{lang sanree_brand:pass}($gcount[0])</a></li>
					<li $stactives[couponnew]><a href="plugin.php?id=sanree_brand_coupon&mod=mycoupon&view=me&st=couponnew">{lang sanree_brand:businessesnew}($gcount[1])</a></li>
					<li $stactives[refuse]><a href="plugin.php?id=sanree_brand_coupon&mod=mycoupon&view=me&st=refuse">{lang sanree_brand:refuse}($gcount[2])</a></li>
					<li $stactives[printlog]><a href="plugin.php?id=sanree_brand_coupon&mod=mycoupon&view=printlog">{lang sanree_brand_coupon:printlog}</a></li>				
				</ul>
				<table cellspacing="0" cellpadding="0" class="dt">
				    <tr>
					<td colspan="6">
						<form method="post" id="postform" action="plugin.php?id=sanree_brand_coupon&mod=mycoupon&view=printlog"  autocomplete="off">
						<input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
						<input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />
						<div class="dsearch">{lang sanree_brand_coupon:kkword}<input name="keyword" value="{$keyword}" type="text" style="width:200px;" /> &nbsp;<button class="y pn pnc"><strong>{lang sanree_brand_coupon:clicksearch}</strong></button></div>
						</form>
					</td>
					</tr>
					<tr>
						<th>{lang sanree_brand_coupon:printcode}</th>
						<th>{lang sanree_brand_coupon:couponname}</th>				
						<th>{lang sanree_brand_coupon:username}</th>						
						<th width="120">{lang sanree_brand_coupon:printtime}</th>
						<th>{lang sanree_brand_coupon:status}</th>
						<th>{lang sanree_brand:operation}</th>
					</tr>
					<!--{loop $classarr $classid $classname}-->
					<tr>
						<td>$classname['printcode']</td>					
						<td><a href="{$classname[turl]}" target="_blank">{$classname[shortname]}</a></td>
						<td><a href="home.php?mod=space&amp;uid={$classname['uid']}" target="_blank">{$classname['username']}</a></td>
						<td>$classname['dateline']</td>
						<td>$classname['status']</td>
						<td><a href="plugin.php?id=sanree_brand_coupon&mod=mycoupon&view=viewconsumer&printlogid={$classname['printlogid']}" id="viewdlg" onclick="showWindow(this.id, this.href, 'get', 1)">{lang sanree_brand_coupon:view}</a> | <a href="plugin.php?id=sanree_brand_coupon&mod=mycoupon&view=dealconsumer&tid={$classname['printlogid']}" id="dealdlg" onclick="showWindow(this.id, this.href, 'get', 1)">{lang sanree_brand_coupon:dealconsumer}</a></td>
					</tr>
					<!--{/loop}-->
				</table>
			</div>
		<!--{if $count}-->
			<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->
		<!--{else}-->
			<div class="emp">{lang sanree_brand_coupon:no_related_couponprint}</div>
		<!--{/if}-->
		</div>
	</div>
<!--{template common/footer}-->