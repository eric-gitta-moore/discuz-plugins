<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
	<!--{template common/header}-->
	<link rel="stylesheet" type="text/css" href="data/cache/style_{STYLEID}_home_space.css?{VERHASH}" />
	<link rel="stylesheet" type="text/css" id="sanree_brand" href="source/plugin/sanree_brand/tpl/good/sanree_brand.css?{VERHASH}" />
    <link rel="stylesheet" type="text/css" id="sanree_brand_guestbook" href="source/plugin/sanree_brand_guestbook/tpl/default/sanree_brand_guestbook.css?{VERHASH}" />
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
					<li $actives[show]><a>{lang sanree_brand_guestbook:temp_viewguestbook}</a></li>
				</ul>
				<table cellspacing="0" cellpadding="0" width="100%">
					<tr class="lineshow">
						<th class="ntitle" valign="middle">{lang sanree_brand_guestbook:temp_guestbookid}</th>
						<th>{$guestbookresult['guestbookid']}</th>						
					</tr>				
				    <!--{if $guestbookresult[username]}-->
					<tr class="lineshow">
						<th class="ntitle" valign="middle">{lang sanree_brand_guestbook:temp_viewguestname}</th>
						<th><a href="home.php?mod=space&amp;uid={$guestbookresult[uid]}" target="_blank">{$guestbookresult[username]}</a></th>						
					</tr>	
					<!--{/if}-->			
					<tr class="lineshow">
						<th class="ntitle" valign="middle">{lang sanree_brand_guestbook:temp_viewbrandname}</th>
						<th><a href="{$guestbookresult['brandurl']}" target="_blank">{$guestbookresult['brandname']}</a></th>						
					</tr>				
					<tr class="lineshow">
						<th class="ntitle" valign="middle">{lang sanree_brand_guestbook:temp_title}</th>
						<th>{$guestbookresult['title']}</th>						
					</tr>				
					<tr class="lineshow">
						<th class="ntitle" valign="middle">{lang sanree_brand_guestbook:temp_fullname}</th>
						<th>{$guestbookresult['fullname']}</th>						
					</tr>
					<tr class="lineshow">
						<th class="ntitle" valign="middle">{lang sanree_brand_guestbook:temp_address}</th>
						<th>{$guestbookresult['address']}</th>						
					</tr>
					<tr class="lineshow">
						<th class="ntitle" valign="middle">{lang sanree_brand_guestbook:temp_phone}</th>
						<th>{$guestbookresult['phone']}</th>						
					</tr>
					<tr class="lineshow">
						<th class="ntitle" valign="middle">{lang sanree_brand_guestbook:temp_email}</th>
						<th>{$guestbookresult['email']}</th>						
					</tr>
					<tr class="lineshow">
						<th class="ntitle" valign="middle">{lang sanree_brand_guestbook:temp_qq}</th>
						<th>{$guestbookresult['qq']}</th>						
					</tr>						
					<tr class="lineshow">
						<th class="ntitle" valign="middle">{lang sanree_brand_guestbook:temp_words}</th>
						<th><div class="smessage">{$guestbookresult['words']}</div></th>						
					</tr>
					<tr class="lineshow">
						<th class="ntitle" valign="middle">{lang sanree_brand_guestbook:temp_refuse}</th>
						<th><div class="smessage">{$guestbookresult['refuse']}</div></th>						
					</tr>
					<tr class="lineshow">
						<th class="ntitle" valign="middle">{lang sanree_brand_guestbook:temp_time}</th>
						<th>{$guestbookresult['opdate']}</th>						
					</tr>
					<tr class="lineshow">
						<td colspan="2" align="center"><input onclick="javascript:history.back()" class="sanreebtn pn pnc" type="button" value="{lang sanree_brand_guestbook:temp_back}"> <input onclick="javascript:window.print()" class="sanreebtn pn pnc" type="button" value="{lang sanree_brand_guestbook:temp_print}"></td>						
					</tr>																														
				</table>
			</div>
		</div>
	</div>
<!--{template common/footer}-->