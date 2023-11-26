<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
	<!--{template common/header}-->
	<link rel="stylesheet" type="text/css" href="data/cache/style_{STYLEID}_home_space.css?{VERHASH}" />
	<link rel="stylesheet" type="text/css" id="sanree_brand" href="source/plugin/sanree_brand_domain/tpl/default/sanree_brand_domain.css?{VERHASH}" />
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
				<a href="plugin.php?id=sanree_brand_domain&mod=buydomain" id="buydlg" onclick="showWindow(this.id, this.href, 'get', 1)" class="y pn pnc"><strong>{lang sanree_brand_domain:buydomain}</strong></a>
				<ul class="tb cl">
				</ul>			
					<table cellspacing="0" cellpadding="0" class="dt" style="margin-top:10px;">
						<tr>
							<th>{lang sanree_brand_domain:domainname}</th>
							<th>{lang sanree_brand_domain:brandname}</th>
							<th>{lang sanree_brand_domain:isshowstr}</th>		
							<th>{lang sanree_brand_domain:chulist}</th>					
							<th width="120">{lang sanree_brand_domain:time}</th>
							<th width="120">{lang sanree_brand_domain:endtime}</th>
							<th width="50">{lang sanree_brand_domain:operation}</th>
						</tr>
						<!--{loop $classarr $classid $classname}-->
						<tr{$classname[style]}>
							<td>{$classname[domainname]}{$okdomain}</td>
							<td>{$classname['brandname']}</td>
							<td>{$classname['isshowstr']}</td>
							<td>{$classname['st']}</td>
							<td>{$classname['dateline']}</td>
							<td>{$classname['enddate']}</td>
							<td><!--{if $classname['status']==1}--><a href="{$classname[editurl]}" onclick="showWindow('editdlg', this.href, 'get', 1)">{lang sanree_brand_domain:edit}</a><!--{/if}--></td>
						</tr>
						<!--{/loop}-->
					</table>				
			</div>
		<!--{if $count}-->
			<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->
		<!--{else}-->
			<div class="emp">{lang sanree_brand_domain:no_related_domain}</div>
		<!--{/if}-->
		</div>
	</div>
<!--{template common/footer}-->