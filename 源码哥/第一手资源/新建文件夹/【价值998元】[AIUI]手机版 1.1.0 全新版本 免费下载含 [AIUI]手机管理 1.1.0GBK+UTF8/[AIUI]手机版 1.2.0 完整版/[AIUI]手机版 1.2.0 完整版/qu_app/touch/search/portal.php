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
	<form class="searchform" method="post" autocomplete="off" action="search.php?mod=portal" onsubmit="if($('scform_srchtxt')) searchFocus($('scform_srchtxt'));">
		<input type="hidden" name="formhash" value="{FORMHASH}" />

		<!--{subtemplate search/pubsearch}-->
		<!--{hook/portal_top}-->

	</form>
	<!--{if !empty($searchid) && submitcheck('searchsubmit', 1)}-->
	<!--{subtemplate search/portal_list}-->
	<!--{/if}-->

</div>
<!--{hook/portal_bottom}-->

<!--{template common/footer}-->