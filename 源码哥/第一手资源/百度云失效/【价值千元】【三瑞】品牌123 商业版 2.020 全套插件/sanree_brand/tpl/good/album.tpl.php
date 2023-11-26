<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
{template common/header_ajax}
<!--{if $albumlist}-->
<script src="{sr_brand_JS}/album.js?{VERHASH}"></script>
<div>
  <div class="hd"><span><a href="{$brandresult[albumurl]}">{lang sanree_brand:morepic}</a></span></div>
  <div class="bd">
    <ul>
	<!--{loop $albumlist $thread}-->
      <li class=clearall onmousemove="showthis({$thread[albumid]})" onmouseout="hidethis({$thread[albumid]})">
	     <div style="position:absolute">
	     <img id='aimg_{$thread[albumid]}' src="{$thread[thumbpic]}" zoomfile="{$thread[pic]}" title="{$thread[albumname]}" onclick="zoom(this, '{$thread[pic]}')" alt="{$thread[albumname]}" />
		 </div>
		 <div class="albumname" id='aimgtxt_{$thread[albumid]}'><a onclick="clickshow({$thread[albumid]})">{$thread[albumname]}</a></div>
      </li>
	  <!--{/loop}-->
    </ul>
  </div>
</div>
<script language="javascript" reload="1">
	var stid=0;
	var aimgcount = new Array();
	aimgcount[{$bid}] = {$aids};
	attachimggroup({$bid});
	attachimgshow({$bid});
	var aimgfid = 0;
</script>
<!--{/if}-->
{template common/footer_ajax}