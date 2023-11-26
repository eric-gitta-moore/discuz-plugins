<?php echo '源码哥免费分享，仅供学习，请支持正版！';exit;?>
<div class="tl search_con">
	<div class="sttl mbn">
		<h2><!--{if $keyword}-->{lang search_result_keyword}<!--{else}-->{lang search_result}<!--{/if}--></h2>
	</div>
	<!--{ad/search/y mtw}-->
	<!--{if empty($bloglist)}-->
		<p class="emp xs2 xg2">{lang search_nomatch}</p>
	<!--{else}-->
		<div class="slst mtw">
			<ul>
				<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nNg==')) and !strstr($_G['siteurl'],base64_decode('MTI3LjAuMC4x')) and !strstr($_G['siteurl'],base64_decode('bG9jYWxob3N0'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS8=').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtODUyNS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $bloglist $blog}-->
				<li class="pbw">
					<h3 class="xs3"><a href="home.php?mod=space&uid=$blog[uid]&do=blog&id=$blog[blogid]"{if $blog[magiccolor]} class="magiccolor$blog[magiccolor]"{/if} target="_blank">$blog[subject]</a></h3>
					<p class="xg1">$blog[replynum] {lang a_comment} - $blog[viewnum] {lang a_visit} - $blog[hot] {lang heat}</p>
					<p>$blog[message]</p>
					<p>
						<span>$blog[dateline]</span>
						 -
						<span><a href="home.php?mod=space&uid=$blog[uid]" target="_blank">$blog[username]</a></span>
					</p>
				</li>
				<!--{/loop}-->
			</ul>
		</div>
	<!--{/if}-->
	<!--{if !empty($multipage)}--><div class="pgs cl mbm">$multipage</div><!--{/if}-->
</div>
