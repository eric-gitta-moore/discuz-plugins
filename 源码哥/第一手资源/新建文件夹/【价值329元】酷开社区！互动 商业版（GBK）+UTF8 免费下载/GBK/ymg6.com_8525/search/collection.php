<?php echo 'Դ�����ѷ�������ѧϰ����֧�����棡';exit;?>
<!--{subtemplate common/header}-->
<div id="ct" class="cl w search_wrap nbk yanjiao" style="margin-top:18px;">
	<form class="searchform" method="post" autocomplete="off" action="search.php?mod=collection" onsubmit="if($('scform_srchtxt')) searchFocus($('scform_srchtxt'));">
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<!--{subtemplate search/pubsearch}-->
		<!--{hook/collection_top}-->

	</form>

	<!--{if !empty($searchid) && submitcheck('searchsubmit', 1)}-->
		<!--{subtemplate search/collection_list}-->
	<!--{/if}-->

</div>
<!--{hook/collection_bottom}-->

<!--{subtemplate common/footer}-->
