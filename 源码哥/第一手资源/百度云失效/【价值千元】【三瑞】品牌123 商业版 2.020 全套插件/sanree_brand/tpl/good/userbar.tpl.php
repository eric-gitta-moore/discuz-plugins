<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{if $_G['inajax']==1}-->
{template common/header_ajax}
<!--{else}-->
{subtemplate common/header}
<!--{/if}-->
<div id="floatmenu">
	<div class="uw960">
	 <ul>
	  <li class="nky" title="{lang sanree_brand:youall}"></li>
	  <!--{loop $bf_menu_list $cate}-->
		  <!--{if $cate[window]==1}-->
		  <li class="bf_menu"><a href="{$cate[url]}" id="cmenu{$cate[id]}" onclick="showWindow('cmenu', this.href, 'get', 1)">{$cate[title]}</a></li>
		  <!--{else}-->
		  <li class="bf_menu"><a href="{$cate[url]}">{$cate[title]}</a></li>
		  <!--{/if}-->
	  <!--{/loop}--> 
	  <li class="cright">
		  <div class="addbutton"><a href="plugin.php?id=sanree_brand&mod=published" id="fpublisheddlg" onclick="showWindow('publisheddlg', this.href, 'get', 1)"></a></div>
	  </li>    
	 </ul>
	</div>
</div>
<div class="clear"></div>
<!--{if $_G['inajax']==1}-->
{template common/footer_ajax}
<!--{else}-->
{subtemplate common/footer}
<!--{/if}-->