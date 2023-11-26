<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{template common/header}-->
<div class="branchdlg">
<h3 class="flb mn sr"><em>{$brandresult[name]} {lang sanree_brand:tplbranchstr}</em><span><!--{if $_G['inajax']}--><a href="javascript:;" class="flbc" onclick="hideWindow('branchdlg', 0, 1);" title="{lang close}">{lang close}</a><!--{/if}--></span></h3>
<div class="alertbody">
<span id="return_error" style="display:none"></span>
<table class="fire" width="100%" border="1" cellpadding="5"  cellspacing="0" style="margin:0px auto;">
  <!--{loop $pbidlist $value}-->
  <tr>
    <td><a href="{$value['url']}" target="_blank">{$value['name']}</a></td>
  </tr> 
  <!--{/loop}--> 
</table>
</div>
</div>
<!--{template common/footer}-->