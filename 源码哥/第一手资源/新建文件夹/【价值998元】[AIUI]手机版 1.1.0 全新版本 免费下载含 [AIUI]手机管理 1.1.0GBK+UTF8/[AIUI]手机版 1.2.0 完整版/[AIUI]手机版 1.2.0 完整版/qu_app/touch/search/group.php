<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->
<!-- header start -->
    <div class="header">
        <div class="nav">
            <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
			<span class="name">{lang search}</span>
        </div>
    </div>
<!-- header end -->

<div class="cl ainuo_search">
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

<!--{template common/footer}-->