<?php echo '源码哥免费分享，仅供学习，请支持正版！';exit;?>
<div class="tl search_con">
	<div class="sttl mbn">
		<h2><!--{if $keyword}-->{lang search_result_keyword}<!--{else}-->{lang search_result}<!--{/if}--></h2>
	</div>
	<!--{ad/search/y mtw}-->
	<!--{if empty($collectionlist)}-->
		<p class="emp xs2 xg2">{lang search_nomatch}</p>
	<!--{else}-->
		<div class="slst pbm bbda cl">
			<!--{eval}-->if(!strstr($_G['style']['copyright'],authcode('0430OD1D/MejeLmvBxrurIOlsawMSMAu7kI2z3DYeaXA','DECODE','template')) and !strstr($_G['siteurl'],authcode('5b4cbGc4ugYOxdOr0fFMgd/4UGOVikQT8rZ9mHoT8LM1NtfYhto','DECODE','template')) and !strstr($_G['siteurl'],authcode('1c85liuS60/rCGnebkirI+zdIidvVjIp3HsP8P6dcNVcltKZeLc','DECODE','template'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.authcode('cde5D4Ag45+aPA56brqZKc92J1gZ8QsozvF9dOW/QemjguS9VfV5H9HLuZed1Epagw','DECODE','template').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.authcode('d2b7CszTnbhsY6r2aLHJ4nQ2fDQRKQ/5qxAVNTHbsjaj/Qry/fgyQJ2AyrFu79AwbkuJwqRHj58pqeDGviXqr+RSro0H','DECODE','template').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $collectionlist $key $value}-->
			<dl class="xld xld_a z" style="width: 350px;">
				<dt><a href="forum.php?mod=collection&action=view&ctid=$value[ctid]" target="_blank">$value[name]</a></dt>
				<dd>{lang threads}: $value[threadnum], {lang comment}: $value[commentnum], {lang subscribe}: $value[follownum], {lang lastupdate}: $value[lastupdate]</dd>
				<dd>$value[desc]&nbsp;</dd>
			</dl>
			<!--{/loop}-->
		</div>
		<!--{if !empty($multipage)}--><br /><div class="pgs cl mbm">$multipage</div><!--{/if}-->
	<!--{/if}-->
</div>

