<?php echo '源码哥免费分享，仅供学习，请支持正版！';exit;?>
<!--{subtemplate common/header}-->
<div id="ct" class="cl w search_wrap nbk yanjiao" style="margin-top:18px;">
	<form class="searchform" method="post" autocomplete="off" action="search.php?mod=group" onsubmit="if($('scform_srchtxt')) searchFocus($('scform_srchtxt'));">
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<input type="hidden" name="srchfid" value="$srchfid" />
		<!--{subtemplate search/pubsearch}-->
		<!--{hook/group_top}-->

	</form>

	<!--{if !empty($searchid) && submitcheck('searchsubmit', 1)}-->
		<!--{if $srchfid}-->
			<!--{subtemplate search/thread_list}-->
		<!--{else}-->
			<!--{subtemplate search/group_list}-->
		<!--{/if}-->
	<!--{/if}-->

</div>
<!--{hook/group_bottom}-->

<!--{subtemplate common/footer}-->
