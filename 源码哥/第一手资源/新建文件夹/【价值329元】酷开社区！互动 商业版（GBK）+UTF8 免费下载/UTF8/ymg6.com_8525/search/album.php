<?php echo '源码哥免费分享，仅供学习，请支持正版！';exit;?>
<!--{subtemplate common/header}-->
<div id="ct" class="cl w search_wrap nbk yanjiao" style="margin-top:18px;">
	<form class="searchform" method="post" autocomplete="off" action="search.php?mod=album" onsubmit="if($('scform_srchtxt')) searchFocus($('scform_srchtxt'));">
		<input type="hidden" name="formhash" value="{FORMHASH}" />

		<!--{subtemplate search/pubsearch}-->
		<!--{hook/album_top}-->

	</form>

	<!--{if !empty($searchid) && submitcheck('searchsubmit', 1)}-->
		<!--{subtemplate search/album_list}-->
	<!--{/if}-->
	
</div>
<!--{hook/album_bottom}-->

<!--{subtemplate common/footer}-->
