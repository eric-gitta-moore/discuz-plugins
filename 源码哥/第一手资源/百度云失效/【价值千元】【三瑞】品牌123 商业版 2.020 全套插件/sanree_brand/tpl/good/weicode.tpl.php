<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{template common/header}-->

<div class="weicode">
<h3 class="flb mn sr"><em>{$weixintitle}</em><span>
  <!--{if $_G['inajax']}-->
  <a href="javascript:;" class="flbc" onclick="hideWindow('weicodedlg', 0, 1);" title="{lang close}">{lang close}</a>
  <!--{/if}-->
  </span></h3>
<div class="alertbody">
  <div class="stline">{lang sanree_brand:weixinnum}<strong>{$brandresult['weixin']}</strong></div>
  <!--{if $backgroundimage}-->
  <div>{lang sanree_brand:weixinimg}</div>  
  <div class="smline"><img src="$backgroundimage"  width="150" height="150" /></div>
  <!--{/if}-->  
  </div>
</div>
<!--{template common/footer}-->
