<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
	<!--{template common/header}-->
	<link rel="stylesheet" type="text/css" href="data/cache/style_{STYLEID}_home_space.css?{VERHASH}" />
	<link rel="stylesheet" type="text/css" id="sanree_brand" href="source/plugin/sanree_brand_guestbook/tpl/default/sanree_brand_guestbook.css?{VERHASH}" />
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
				<ul class="tb cl">
				    <li $stactives[guestbooknew]><a href="plugin.php?id=sanree_brand_guestbook&mod=myguestbook&view=list&st=guestbooknew">{lang sanree_brand_guestbook:guestbooknew}($gbcount[1])</a></li>
					<li $stactives[pass]><a href="plugin.php?id=sanree_brand_guestbook&mod=myguestbook&view=list&st=pass">{lang sanree_brand_guestbook:guestbookpass}($gbcount[0])</a></li>
					<li $stactives[mygb]><a href="plugin.php?id=sanree_brand_guestbook&mod=myguestbook&view=list&st=mygb">{lang sanree_brand_guestbook:myguestbook}($gbcount[2])</a></li>
				</ul>
				<!--{if $st=='mygb'}-->
					<table cellspacing="0" cellpadding="0" class="dt" style="margin-top:10px;">
						<tr>
						    <th>{lang sanree_brand_guestbook:showindex}</th>
							<th>{lang sanree_brand_guestbook:guestbookname}</th>
							<th width="100">{lang sanree_brand_guestbook:temp_guestname}</th>
							<th>{lang sanree_brand:brandname}</th>	
							<th>{lang sanree_brand_guestbook:chulist}</th>					
							<th width="120">{lang sanree_brand_guestbook:addtime}</th>
							<th width="100">{lang sanree_brand:operation}</th>
						</tr>
						<!--{loop $classarr $classid $classname}-->
						<tr{$classname[style]}>
						    <td>{$classname[guestbookid]}</td>
							<td><a href="{$classname[url]}">{$classname[title]}</a></td>
							<td><!--{if $classname[username]}--><a href="home.php?mod=space&amp;uid={$classname[uid]}" target="_blank">{$classname[username]}</a><!--{else}-->{lang sanree_brand_guestbook:temp_guestuser}<!--{/if}--></td>
							<td><a href="{$classname['brandurl']}" target="_blank">{$classname['brandname']}</a></td>
							<td>{$classname['st']}</td>
							<td>{$classname['dateline']}</td>
							<td><a href="{$classname[url]}">{lang sanree_brand_guestbook:temp_view}</a>
							</td>
						</tr>
						<!--{/loop}-->
					</table>				
				<!--{else}-->
					<table cellspacing="0" cellpadding="0" class="dt" style="margin-top:10px;">
						<tr>
						    <th>{lang sanree_brand_guestbook:showindex}</th>
							<th>{lang sanree_brand_guestbook:guestbookname}</th>
							<th width="100">{lang sanree_brand_guestbook:temp_guestname}</th>
							<th>{lang sanree_brand:brandname}</th>						
							<th width="120">{lang sanree_brand_guestbook:addtime}</th>
							<th width="100">{lang sanree_brand:operation}</th>
						</tr>
						<!--{loop $classarr $classid $classname}-->
						<tr>
						    <td>{$classname[guestbookid]}</td>
							<td><a href="{$classname[url]}">{$classname[title]}</a></td>
							<td><!--{if $classname[username]}--><a href="home.php?mod=space&amp;uid={$classname[uid]}" target="_blank">{$classname[username]}</a><!--{else}-->{lang sanree_brand_guestbook:temp_guestuser}<!--{/if}--></td>
							<td><a href="{$classname['brandurl']}" target="_blank">{$classname['brandname']}</a></td>
							<td>{$classname['dateline']}</td>
							<td>
							<!--{if $classname[status]!='1'}--><a href="{$classname[chuliurl]}">{lang sanree_brand_guestbook:chuli}</a> |<!--{/if}-->
							<!--{if $isdeleteuser}--><a href="{$classname[deleteurl]}">{lang sanree_brand_guestbook:delete}</a> |<!--{/if}-->
							 <a href="{$classname[url]}">{lang sanree_brand_guestbook:temp_view}</a>
							</td>
						</tr>
						<!--{/loop}-->
					</table>
				<!--{/if}-->
			</div>
		<!--{if $count}-->
			<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->
		<!--{else}-->
			<div class="emp">{lang sanree_brand_guestbook:no_related_guestbook}</div>
		<!--{/if}-->
		</div>
	</div>
<!--{template common/footer}-->