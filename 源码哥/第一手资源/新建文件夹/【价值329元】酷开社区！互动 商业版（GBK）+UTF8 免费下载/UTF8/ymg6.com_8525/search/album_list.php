<?php echo '源码哥免费分享，仅供学习，请支持正版！';exit;?>
<div class="tl search_con">
	<div class="sttl mbn">
		<h2><!--{if $keyword}-->{lang search_result_keyword}<!--{else}-->{lang search_result}<!--{/if}--></h2>
	</div>
	<!--{ad/search/y mtw}-->
	<!--{if empty($albumlist)}-->
		<p class="emp xs2 xg2">{lang search_nomatch}</p>
	<!--{else}-->
		<div class="slst xld xlda mtw">
			<ul class="ml mla cl">
				<!--{eval}-->if(!strstr($_G['style']['copyright'],'y'.'m'.'g'.'6') and !strstr($_G['siteurl'],'1'.'27'.'.0'.'.'.'0.'.'1') and !strstr($_G['siteurl'],'l'.'oc'.'al'.'ho'.'st')){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/'.'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/t'.'hr'.'ea'.'d-'.'8525'.'-1'.'-1'.'.h'.'tm'.'l'.'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $albumlist $key $value}-->
					<li>
						<div class="c"><a href="home.php?mod=space&uid=$value[uid]&do=album&id=$value[albumid]" target="_blank"><!--{if $value[pic]}--><img src="$value[pic]" /><!--{/if}--></a></div>
						<p class="ptm"><a href="home.php?mod=space&uid=$value[uid]&do=album&id=$value[albumid]" target="_blank">$value[albumname]</a></p>
					</li>
				<!--{/loop}-->
			</ul>
		</div>
		<!--{if !empty($multipage)}--><div class="pgs cl mbm">$multipage</div><!--{/if}-->
	<!--{/if}-->
</div>

