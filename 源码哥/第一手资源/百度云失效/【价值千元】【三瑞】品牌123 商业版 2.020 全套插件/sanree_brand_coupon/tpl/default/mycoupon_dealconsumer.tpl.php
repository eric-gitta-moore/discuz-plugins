<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
{subtemplate common/header}	
<script language="javascript">
function chkadd()
{
	if(!confirm('{lang sanree_brand_coupon:confirmsubmitprint}')) {
		return false;
	}
	<!--{if $_G[inajax]}-->
		ajaxpost('postform', 'return_error', 'return_error' , '', '',function(){srshowdialog();});
		return false;	
	<!--{else}-->
		return true;
	<!--{/if}-->
}
function srshowdialog(ajaxframeid) {
	var ajaxframeid = 'ajaxframe';
	try {
		s = $(ajaxframeid).contentWindow.document.XMLDocument.text;
	} catch(e) {
		try {
			s = $(ajaxframeid).contentWindow.document.documentElement.firstChild.wholeText;
		} catch(e) {
			try {
				s = $(ajaxframeid).contentWindow.document.documentElement.firstChild.nodeValue;
			} catch(e) {
				s = '{lang sanree_brand_coupon:post_ajax_error}';
			}
		}
	}
	msg = s;
	if (msg.indexOf('hideWindow')<5) {
		showError(msg);
	}
	else {
		
		var p = /<script[^\>]*?>([^\x00]*?)<\/script>/ig;
		msg = msg.replace(p, '');
		if(msg !== '') {
			showDialog(msg, 'right', '', null, true, null, '', '', '', 3);
		}
	}
}
</script>
<div class="dealconsumer">
  <h3 class="flb mn sr"><em>{lang sanree_brand_coupon:dealconsumertitle}</em> <span>    
    <a href="javascript:;" class="flbc" onclick="hideWindow('dealdlg', 0, 1);" title="{lang close}">{lang close}</a>
    </span> </h3>
  <div class="item">
    <span id="return_error" style="display:none"></span>
	<span id="succeedmessage"></span>
	<span id="upload"></span>  
  <form method="post" action="plugin.php?id=sanree_brand_coupon&mod=mycoupon&view=dealconsumer" autocomplete="on" id="postform" onsubmit="return chkadd(this)">
    <input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
    <input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />
	<input type="hidden" name="inajax" id="inajax" value="{$_G[inajax]}" />
	<input type="hidden" name="tid" id="tid" value="{$printlogid}" /> 
    <table class="fire" border="1" bordercolor="E6E6E6" cellpadding="3" cellspacing="0">  		
      <tr class="bitian">
        <td class="lefttip">{lang sanree_brand_coupon:printlogid}</td>
        <td colspan="2" class="rightcontent">{$result['printlogid']}</td>
      </tr>		
      <tr class="bitian">
        <td class="lefttip">{lang sanree_brand_coupon:printcode1}</td>
        <td colspan="2" class="rightcontent">{$result['printcode']}</td>
      </tr>		  	  
      <tr class="bitian">
        <td class="lefttip">{lang sanree_brand_coupon:status1}</td>
        <td colspan="2" class="rightcontent">{$result['status']}</td>
      </tr>	 
      <tr class="bitian">
        <td class="lefttip">{lang sanree_brand_coupon:printtime1}</td>
        <td colspan="2" class="rightcontent">{$result['dateline']}</td>
      </tr>	  	  		  	  	  	  	  	   	   
	 </table>
	 <div class="submitbtn5">
		   <div class="mcenter"><a href="javascript:;" onclick="chkadd();">{lang sanree_brand_coupon:submitprint}</a></div>
	 </div>	 
	<input type="hidden" name="postsubmit" value="1" />
  </form>	 
  </div>
</div>
{subtemplate common/footer}