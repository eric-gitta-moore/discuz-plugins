<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
	<!--{template common/header}-->
	<script language="javascript" src="{sr_brand_JS}/msg{C_CHARSET}.js"></script>
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
						<li$actives[myalbum]><a href="plugin.php?id=sanree_brand&mod=mybrand&view=myalbum&bid={$brandresult[bid]}">{lang sanree_brand:myalbum}</a></li>
						<!--{hook/sanree_brand_userbar}-->
					</ul>
				</div>
			</div>
			<div class="mn pbm" style="border:none; margin:0">
			<div class="tbmu cl">
			<style>
			.ml p{height:22px;}
			.ml li{
			overflow:hidden;
			}
			.mlp .d{height:210px;}
			.conbar {
				text-align:center; 
				display:none; 
				position:relative; 
				z-index:99;
			}
			.conbar a{
				color:#FF0000
			}
			</style>			
			<script src="{sr_brand_JS}/album.js"></script>
			<a style="cursor:pointer" id="savebtn"  onclick="saveorder()" class="y pn pnc"><strong>{lang sanree_brand:savedisplay}</strong></a>
			<!--{if ($st == 'album')}-->
				<a href="plugin.php?id=sanree_brand&mod=ajax&do=uploadpic&bid={$brandresult[bid]}&catid={$catid}" id="uploadpicdlg"  onclick="showWindow(this.id, this.href, 'get', 1)" class="y pn pnc"><strong>{lang sanree_brand:upload_pic}</strong></a>
			<!--{/if}-->
			<!--{if ($st == 'album_category')}-->	
				<a href="plugin.php?id=sanree_brand&mod=ajax&do=creatalbum&bid={$brandresult[bid]}" onclick="showWindow(this.id, this.href, 'get', 1)" id="creatalbumdlg" class="y pn pnc"><strong>{lang sanree_brand:creatalbum}</strong></a>
            <!--{/if}-->				
				<ul class="tb cl">
					<li $stactives[album_category]><a href="plugin.php?id=sanree_brand&mod=mybrand&view=myalbum&st=album_category&bid={$brandresult[bid]}">{lang sanree_brand:myalbum}</a></li>
					<li $stactives[album]><a href="plugin.php?id=sanree_brand&mod=mybrand&view=myalbum&st=album&bid={$brandresult[bid]}">{lang sanree_brand:piclist}</a></li>
				</ul>
			</div>

			<div class="ptw">
		<!--{if ($st == 'album_category')}-->
			    <div>{lang sanree_brand:brandnameto}<a href="{$brandresult[url]}" target="_blank"><strong>{$brandresult[name]}</strong></a> &nbsp; {lang sanree_brand:brandgroup}<img src="{$brandresult[group]['grouplogo']}" align="absmiddle" /> {$brandresult[group]['maxalbumcategorytip']}</div>					
				<!--{if $count}-->
				<form method="post" id="postform" action="plugin.php?id=sanree_brand&mod=mybrand&view=myalbum&st=album_category&inajax=yes&infloat=yes"  autocomplete="off">
				<input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
				<input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />
				<input type="hidden" name="bid" id="bid" value="{$brandresult[bid]}" />
				<span id="return_error" style="display:none"></span>				
				<ul class="ml mlp cl">
					<!--{loop $list $key $value}-->
<li class="d" onmousemove="kshowthis({$value[catid]})" onmouseout="khidethis({$value[catid]})">
<div style="height:25px;">
<div id="con{$value[catid]}" class="conbar"><a href="plugin.php?id=sanree_brand&mod=ajax&do=creatalbum&bid={$brandresult[bid]}&catid={$value[catid]}&inajax=yes&infloat=yes" onclick="showWindow('creatalbumdlg', this.href, 'get', 1)">{lang sanree_brand:editalbumname}</a></div>
</div>
<div>
<div>
<div class="c">
<a href="plugin.php?id=sanree_brand&mod=mybrand&view=myalbum&st=album&bid={$brandresult[bid]}&catid=$value[catid]"><!--{if $value[pic]}--><img width="120" height="120" src="$value[pic]" alt="{$value[name]}" /><!--{/if}--></a>
</div>
<p class="ptm"><a href="plugin.php?id=sanree_brand&mod=mybrand&view=myalbum&st=album&bid={$brandresult[bid]}&catid=$value[catid]" class="xi2">$value[name]</a>($value[piccount])</p>					
<span style="height:22px;"><label for="mmm{$value[catid]}">{lang sanree_brand:displayorder}</label><input id="mmm{$value[catid]}" type="text"  name="album_displayorder[{$value[catid]}]" size="2" value="{$value[displayorder]}" /></span>
</div>
</div>
</li>
					<!--{/loop}-->
				</ul>
				<input type="hidden" name="postsubmit" value="1" />				
				</form>	
				 <div class="clear"></div>			
				<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->
				<!--{else}-->
				<div class="emp">{lang sanree_brand:no_album}</div>
				<!--{/if}-->
			<!--{elseif ($st == 'album')}-->
			    <div>{lang sanree_brand:brandnameto}<a href="{$brandresult[url]}" target="_blank"><strong>{$brandresult[name]}</strong></a> &nbsp; {lang sanree_brand:brandgroup}<img src="{$brandresult[group]['grouplogo']}" align="absmiddle" /> {$brandresult[group]['maxalbumtip']}</div>		
                <div class="ml mlp cl" style="margin-bottom:10px;"><!--{if $catname}-->{lang sanree_brand:curalbum}<strong>{$catname}</strong><!--{/if}--></div>
				<!--{if $count}-->
				<form method="post" id="postform" action="plugin.php?id=sanree_brand&mod=mybrand&view=myalbum&st=album&inajax=yes&infloat=yes"  autocomplete="off">
				<input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
				<input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />
				<input type="hidden" name="bid" id="bid" value="{$brandresult[bid]}" />
				<span id="return_error" style="display:none"></span>
				<ul class="ml mlp cl">
					<!--{loop $list $key $value}-->
					<li class="d" onmousemove="kshowthis({$value[albumid]})" onmouseout="khidethis({$value[albumid]})">
					<div>
<div style="height:25px;">
<div id="con{$value[albumid]}" class="conbar"><a href="plugin.php?id=sanree_brand&mod=ajax&do=editpic&bid={$brandresult[bid]}&albumid={$value[albumid]}&inajax=yes&infloat=yes" id="editpic"  onclick="showWindow(this.id, this.href, 'get', 1)" >{lang sanree_brand:editpicname}</a>
<!--{if $allowdeletealbum==1}--> | <a href="plugin.php?id=sanree_brand&mod=delete&do=album&bid={$brandresult[bid]}&catid={$value[catid]}&albumid={$value[albumid]}" onclick="if (confirm('{lang sanree_brand:deletepictip}')){return true;}else{return false;}"><font color="#0000FF">{lang sanree_brand:deletepic}</font></a><!--{/if}-->
</div>
</div>
	<div>
	<div class="c">
	<!--{if $value[pic]}--><img width="120" height="120" style="cursor:pointer" src="{$value[thumbpic]}" zoomfile="{$value[pic]}" alt="{$value[name]}"  title="{$value[name]}"  onclick="zoom(this, '{$value[pic]}')" /><!--{/if}-->
	</div>
	<p class="ptm"><label for="mm{$value[albumid]}">{lang sanree_brand:tuijian}</label><input id="mm{$value[albumid]}" type="checkbox" value="1" name="album_ishome[{$value[albumid]}]" {$value[ishomestr]} />&nbsp;&nbsp;<label for="mmm{$value[albumid]}">{lang sanree_brand:displayorder}</label><input id="mmm{$value[albumid]}" type="text"  name="album_displayorder[{$value[albumid]}]" size="2" value="{$value[displayorder]}" /></p>
	<span></span>
	</div>
</div>

					</li>
					<!--{/loop}-->
				</ul>
				<input type="hidden" name="postsubmit" value="1" />				
				</form>
				<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->
				<!--{else}-->
				<div class="emp">{lang sanree_brand:no_pic}</div>
				<!--{/if}-->
			<!--{/if}-->				
			</div>
		   
		</div>
	</div>
<!--{template common/footer}-->