<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{block brand_header}-->
<style type="text/css" title="sanreeconfigcss">
{$bodycss}
</style>
<div class="brand_header">
  <div class="tmpbg"><img src="{$brandresult[banner]}" border="0" /></div>
  <div class="bbanner">
    <h1><span<!--{if intval($brandresult[isshowbrandname])==1}--> style="display:none"<!--{/if}-->>{$brandresult[name]}</span></h1>
    <ul class="brandnav">
      <!--{loop $headermenulist $menu}-->
      <!--{if $menu[window]==1}-->
      <li{$menu[class]}><a href="{$menu[url]}" id="cmenu{$menu[id]}" onclick="showWindow('cmenu', this.href, 'get', 1)">{$menu[title]}</a>
      </li>
      <!--{else}-->
      <li{$menu[class]}>
      <ul>
        <li class="m0"></li>
        <li class="m1"><a href="{$menu[url]}">{$menu[title]}</a></li>
        <li class="m2"></li>
      </ul>
      </li>
      <!--{/if}-->
      <!--{/loop}-->
    </ul>
  </div>
  <!--{if $_G[cache][plugin][sanree_brand_wap][isopen]==1}--><div class="code2"><img src="plugin.php?id=sanree_brand_wap&mod=show2code&tid={$brandresult[bid]}" /></div><!--{/if}-->
</div>
<!--{if defined('IN_BRAND_USER')}-->
<script src="{sr_brand_JS}/manage.js?{VERHASH}"></script>
<div class="brand_manage" id="managebar" style="display:none">
  <div class="filterdiv" style="height:{$ih}px"></div>
  <div class="fshow">
	  <div class="m950">
		  <ul class="managenav">
		  <!--{loop $managemenulist $menu}-->
		      <!--{if !empty($menu[addhtml])}-->{$menu[addhtml]}<!--{/if}-->
			  <!--{if $menu[window]==1}-->
			  <li{$menu[class]}>
			  <!--{if !empty($menu[image])}--><a href="{$menu[url]}" title="{$menu[title]}" id="{$menu[name]}" onclick="showWindow('{$menu[name]}', this.href, 'get', 1)"><img src="{$menu[image]}" /></a><!--{/if}-->
			  <a href="{$menu[url]}" title="{$menu[title]}" id="{$menu[name]}" onclick="showWindow('{$menu[name]}', this.href, 'get', 1)">{$menu[title]}</a></li>
			  <!--{else}-->
			  <li{$menu[class]}>
			  <!--{if !empty($menu[image])}--><a<!--{if !empty($menu[url])}--> href="{$menu[url]}"<!--{/if}--> title="{$menu[title]}" target="_blank"><img src="{$menu[image]}" /></a><!--{/if}-->	  
			  <a<!--{if !empty($menu[url])}--> href="{$menu[url]}"<!--{/if}--> title="{$menu[title]}" target="_blank">{$menu[title]}</a></li>
			  <!--{/if}-->
		  <!--{/loop}-->
		  </ul>
		  <div class="mclose"><a href="javascript:void(0)" onclick="showmanage()" class="srflbc"></a></div>
	  </div>
  </div>
</div>
<!--{if $_G['cache']['plugin']['sanree_we']['isopen']}-->
<style>
.old-tplcode { width: 125px; height: auto; position: fixed; top: 190px; right: 50%; margin-right: 500px; padding: 9px; background: #fff; float: right; border: 1px solid #ddd;  z-index: 9; }
.old-tplcode .codehome img { width: 125px; height: 125px; overflow: hidden; }
.old-tplcode .codetxt { width: 125px; padding: 5px 0; background: #999; display: block; color: #fff; text-decoration: none; text-align: center; margin-bottom: 9px; }
</style>
<div class="old-tplcode">
		<div class="codetxt">{lang sanree_brand:scancostwap}</div>
		<div class="codehome">
			<img src="plugin.php?id=sanree_we&mod=codehome&cmod=item&tid={$brandresult['bid']}">
		</div>
</div>
<!--{/if}-->
<!--{/if}-->
<!--{/block}-->