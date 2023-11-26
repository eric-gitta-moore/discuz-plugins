<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
	<!--{template common/header}-->
	<link rel="stylesheet" type="text/css" href="data/cache/style_{STYLEID}_home_space.css?{VERHASH}" />
	<link rel="stylesheet" type="text/css" id="sanree_brand" href="{SANREE_BRAND_TEMPLATE}/sanree_brand.css?{VERHASH}" />
    <style type="text/css">
    
		#tip_windows {
			position: absolute;
			background: none repeat scroll 0% 0% #3A69C4;
			color: #FFF;
			padding: 5px 20px;
			border-radius: 5px;
			box-shadow: 7px 7px 3px #999;
			left: 40%;
			z-index: 201;
		}
		.promotion {
			width:100%;
		}
		
		.apply {
			background: #f5f5f5;
		}
		.content {
			text-align: left;
			padding: 10px;
		}
		.content .fire {
			border: 1px solid #ECE9D9;
		}
		.content .tips {
			margin-top: 5px;
		}
		.content .tips strong {
			color: #ff0000;
		}
		.opt {
			width: 105px;
			background: #fff;
			color: #333;
		}
		.opt div {
			cursor: pointer;
			width: 53px;
		}
		.opt .confirm {
			float: right;
		}
				
    </style>
	<div id="pt" class="bm cl">
		<div class="z">
			<a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em>
			<a href="{$allurl}">{$config['mantitle']}</a>
			
		</div>
	</div>
	<div id="ct" class="ct2_a wp cl">

			<div class="appl">
				<div class="tbn">
					<h2 class="mt bbda">{$config['mantitle']}</h2>
					<ul>
						<li $actives[me]><a href="plugin.php?id=sanree_brand&mod=mybrand&view=me">{lang sanree_brand:mybrand}({$bcount[3]})</a></li>
						<li $actives[mymsg]><a href="plugin.php?id=sanree_brand&mod=mybrand&view=mymsg">{lang sanree_brand:mymsg}</a></li>
						<!--{hook/sanree_brand_userbar}-->
					</ul>
				</div>
			</div>
			<div class="mn pbm" style="border:none; margin:0">
			<div class="tbmu cl">
            	<div id="tip_windows"></div>
				<a href="plugin.php?id=sanree_brand&mod=published" id="publisheddlg" onclick="showWindow(this.id, this.href, 'get', 1)" class="y pn pnc"><strong>{lang sanree_brand:post_new_brand}</strong></a>
				<ul class="tb cl">
					<li $stactives[pass]><a href="plugin.php?id=sanree_brand&mod=mybrand&view=me&st=pass">{lang sanree_brand:pass}($bcount[0])</a></li>
					<li $stactives[businessesnew]><a href="plugin.php?id=sanree_brand&mod=mybrand&view=me&st=businessesnew">{lang sanree_brand:businessesnew}($bcount[1])</a></li>
					<li $stactives[refuse]><a href="plugin.php?id=sanree_brand&mod=mybrand&view=me&st=refuse">{lang sanree_brand:refuse}($bcount[2])</a></li>
                    <li $stactives[record]><a href="plugin.php?id=sanree_brand&mod=mybrand&view=me&st=record">{lang sanree_brand:promotion_record}</a></li>
				</ul>

				<table cellspacing="0" cellpadding="0" class="dt">
					<tr>
						<th>{lang sanree_brand:brandname}</th>
                        <!--{if $st=='record'}--><th>{lang sanree_brand:promotion_group}</th><!--{/if}-->						
						<!--{if $st=='refuse'}--><th>{lang sanree_brand:refusereason}</th><!--{/if}-->
						<!--{if $st=='pass'}--><th width="140">{lang sanree_brand:temp_brandgroup}</th><!--{/if}-->
                        <!--{if $st=='pass'}--><th width="140">{lang sanree_brand:promotion_brandgroup}</th><!--{/if}-->
                       	<!--{if $st=='record'}--> <th width="120">{lang sanree_brand:ordertime}</th><!--{else}-->
						<th width="120">{lang sanree_brand:addtime}</th><!--{/if}-->
                        <!--{if $st=='record'}--><th width="140">{lang sanree_brand:promotion_price}</th><!--{else}-->
						<th width="140">{lang sanree_brand:operation}</th><!--{/if}-->
					</tr>
					<!--{loop $classarr $classid $classname}-->
					<tr>
						<td><a href="{$classname[turl]}" target="_blank">{$classname[name]}</a></td>
						<!--{if $st=='record'}--><td>$classname[groupname]</td><!--{/if}-->
                        <!--{if $st=='refuse'}--><td>$classname[reason]</td><!--{/if}-->
						<!--{if $st=='pass'}--><td><img src="{$classname[groupimg]}" /></td><!--{/if}-->
                        <!--{if $st=='pass'}--><td><a {if $classname[maxorder]} style="text-decoration:none; cursor:default;" {else}  {if $config[isbuy]} href="plugin.php?id=sanree_brand&mod=apply_promotion&bid={$classname[bid]}&order={$classname[order]}" {else} style="cursor:default" {/if} onclick="<!--{if $config[isbuy]}-->showWindow('publisheddlg', this.href, 'get', 1)<!--{else}-->tip_windows('{lang sanree_brand:promotion_noopen}');<!--{/if}-->" {/if}><!--{if $classname[maxorder]}-->{lang sanree_brand:promotion_maxorder}<!--{else}-->{lang sanree_brand:apply_promotion}<!--{/if}--></a></td><!--{/if}-->
						<td>$classname[dateline]</td>
                        <!--{if $st=='record'}--><td>$classname[cost]</td><!--{else}-->
						<td><a href="{$classname[editurl]}" onclick="showWindow('publisheddlg', this.href, 'get', 1)">{lang sanree_brand:edit}</a> <!--{/if}-->
						<!--{if $classname[status]==1}-->&nbsp;&nbsp;<a href="{$classname[brandconfigurl]}" onclick="showWindow('brandconfigdlg', this.href, 'get', 1)">{lang sanree_brand:brandconfig}</a><!--{/if}-->
						<!--{if $classname[allowalbum]==1&&$classname[status]==1&&$isalbum==1}-->
						&nbsp;&nbsp;<a href="plugin.php?id=sanree_brand&mod=mybrand&view=myalbum&st=album_category&bid={$classname[bid]}">{lang sanree_brand:album}</a>
						<!--{/if}-->
						<!--{if $classname[status]==1}-->&nbsp;&nbsp;<a href="{$classname[turl]}" target="_blank">{lang sanree_brand:view}</a><!--{/if}-->
						</td>
					</tr>
					<!--{/loop}-->
				</table>
			</div>

		<!--{if $count}-->
			<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->
		<!--{else}-->
			<!--{if $bcount[3]<1}-->
				<div class="emp">{lang sanree_brand:reminder_t1}<a href="plugin.php?id=sanree_brand&mod=published" id="publisheddlg1" onclick="showWindow('publisheddlg', this.href, 'get', 1)"><strong>{lang sanree_brand:reminder_t2}</strong></a></div>
			<!--{/if}-->
		<!--{/if}-->
		<div class="pub_tip"><ul><li><img src="{sr_brand_IMG}/reminder.gif" align="absmiddle" /> &nbsp;{lang sanree_brand:friendlyreminder}</li><!--{if $regprice>0 || $config['isshen']==1}--><!--{if $regprice>0}--><li class="wleft50">{$pubtip_price}</li><!--{/if}--><!--{if $config['isshen']==1}--><li class="wleft50">{$pubtip_shen}</li><!--{/if}--><!--{else}--><li>{$pubtip_ok}</li><!--{/if}--></ul></div>
		</div>
	</div>
    <script>
    	function tip_windows(content, flag) {
			
			var tip_windows = document.getElementById('tip_windows');
			content = typeof content == undefined ? false : content;
			if(!content) {
				
				//tip_windows.style.display = 'none';
				tip_windows.style.visibility = 'hidden';
				
			}else {
				
				tip_windows.innerHTML = content;
				if(!flag) {
					hideWindow('publisheddlg', 0, 1);
				}
				//tip_windows.style.display = 'block';
				tip_windows.style.visibility = 'visible';
				setTimeout("tip_windows();", 3000);
				
			}
			
		}
		tip_windows();
		
    </script>
<!--{if $mapapi=='baidu'}--><script type="text/javascript" src="http://api.map.baidu.com/api?v=1.2"></script><script type="text/javascript" src=" http://api.map.baidu.com/library/CityList/1.2/src/CityList_min.js"></script><!--{/if}-->
<!--{if $mapapi=='google'}--><script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script><!--{/if}-->	
<!--{template common/footer}-->