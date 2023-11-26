<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
	<!--{template common/header}-->
	<link rel="stylesheet" type="text/css" href="data/cache/style_{STYLEID}_home_space.css?{VERHASH}" />
	<link rel="stylesheet" type="text/css" id="sanree_brand" href="source/plugin/sanree_brand/tpl/good/sanree_brand.css?{VERHASH}" />
	<link rel="stylesheet" type="text/css" href="{sr_brand_goods_TPL}sanree_brand_goods.css?{VERHASH}" />
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
				<a href="plugin.php?id=sanree_brand_goods&mod=published" id="publisheddlg" onclick="showWindow(this.id, this.href, 'get', 1)" class="y pn pnc"><strong>{lang sanree_brand_goods:post_new_goods}</strong></a>
				<ul class="tb cl">
					<li $stactives[pass]><a href="plugin.php?id=sanree_brand_goods&mod=mygoods&view=me&st=pass">{lang sanree_brand:pass}($gcount[0])</a></li>
					<li $stactives[goodsnew]><a href="plugin.php?id=sanree_brand_goods&mod=mygoods&view=me&st=goodsnew">{lang sanree_brand:businessesnew}($gcount[1])</a></li>
					<li $stactives[refuse]><a href="plugin.php?id=sanree_brand_goods&mod=mygoods&view=me&st=refuse">{lang sanree_brand:refuse}($gcount[2])</a></li>
				</ul>
				<script language="javascript">
				function deletegoods(goodsid){
					if(confirm('{lang sanree_brand_goods:deletetip}')) {
						return true;
					}	
					return false;
				}			       
				</script>
				<table cellspacing="0" cellpadding="0" class="dt">
					<tr>
						<th>{lang sanree_brand_goods:goodsname}</th>
						<th>{lang sanree_brand_goods:brandname}</th>						
						<!--{if $st=='refuse'}--><th>{lang sanree_brand:refusereason}</th><!--{/if}-->
						<!--{if $st=='pass'}--><th width="120">{lang sanree_brand_goods:status}</th><!--{/if}-->
						<th width="120">{lang sanree_brand_goods:addtime}</th>
						<th width="100">{lang sanree_brand:operation}</th>
					</tr>
					<!--{loop $classarr $classid $classname}-->
					<tr>
						<td><a href="{$classname[turl]}" target="_blank">{$classname[name]}</a></td>
						<td><a href="{$classname[brandurl]}" target="_blank">$classname['brandname']</a></td>
						<!--{if $st=='refuse'}--><td>$classname['reason']</td><!--{/if}-->
						<!--{if $st=='pass'}--><td>$classname['isshow']</td><!--{/if}-->
						<td>$classname['dateline']</td>
						<td><a href="{$classname[editurl]}" onclick="showWindow('publisheddlg', this.href, 'get', 1)">{lang sanree_brand:edit}</a> 
							<a href="{$classname[deleteurl]}" onclick="return deletegoods()">{lang sanree_brand_goods:delete}</a> 
						</td>
					</tr>
					<!--{/loop}-->
				</table>
			</div>
		<!--{if $count}-->
			<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->
		<!--{else}-->
			<div class="emp">{lang sanree_brand_goods:no_related_goods}</div>
		<!--{/if}-->
		</div>
	</div>
<!--{template common/footer}-->