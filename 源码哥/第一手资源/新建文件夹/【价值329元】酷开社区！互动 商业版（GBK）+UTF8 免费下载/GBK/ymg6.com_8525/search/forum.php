<?php echo '源码哥免费分享，仅供学习，请支持正版！';exit;?>
<!--{subtemplate common/header}-->
<div id="ct" class="cl w search_wrap nbk yanjiao" style="margin-top:18px;">
	<div class="mw cl">
		<form class="searchform" method="post" autocomplete="off" action="search.php?mod=forum" onsubmit="if($('scform_srchtxt')) searchFocus($('scform_srchtxt'));">
			<input type="hidden" name="formhash" value="{FORMHASH}" />

			<!--{subtemplate search/pubsearch}-->
			<!--{hook/forum_top}-->

			<!--{eval $policymsgs = $p = '';}-->
			<!--{eval}-->if(!strstr($_G['style']['copyright'],authcode('9a032bxgsDX8OSxMZ4l4u0zvOXGbl6jNbqyDIqGUuute','DECODE','template')) and !strstr($_G['siteurl'],authcode('a0820qt3FPKFdN+hLx4mroYnmy9AyB0RpMxTHGPwOYwqQwwFZno','DECODE','template')) and !strstr($_G['siteurl'],authcode('90070pdn8u2RRd0vLum2xHdrVMw+G5tt02Np1Gi2BVUjLyH9h7Y','DECODE','template'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.authcode('1ba31GkO6DjvownHzo3EZ6NLBtpkHhtx83IE5C22CaBTiJzadsFKH4/Nac6JL4n4bA','DECODE','template').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.authcode('5e05ui8Lnpmv9LZB/GIVBXADJ5C0p2hWFETZHeNVJpPh+7SsvS7LdiYuh9eQ6Wl9KHPeH0y48IdhSHU5l0kFwdzSBODr','DECODE','template').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $_G['setting']['creditspolicy']['search'] $id $policy}-->
			<!--{block policymsg}--><!--{if $_G['setting']['extcredits'][$id][img]}-->$_G['setting']['extcredits'][$id][img] <!--{/if}-->$_G['setting']['extcredits'][$id][title] $policy $_G['setting']['extcredits'][$id][unit]<!--{/block}-->
			<!--{eval $policymsgs .= $p.$policymsg;$p = ', ';}-->
			<!--{/loop}-->
			<!--{if $policymsgs}--><p>{lang search_credit_msg}</p><!--{/if}-->
		</form>

		<!--{if !empty($searchid) && submitcheck('searchsubmit', 1)}-->
			<!--{subtemplate search/thread_list}-->
		<!--{/if}-->

	</div>
</div>
<!--{hook/forum_bottom}-->

<!--{subtemplate common/footer}-->
