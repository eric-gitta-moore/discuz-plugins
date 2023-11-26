<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{if $_G['inajax']==1}-->
{template common/header_ajax}
<!--{else}-->
{subtemplate common/header}
<!--{/if}-->			
<script language="javascript">
function chkadd(obj)
{
	if(obj.domainname.value=='') {
		alert('{lang sanree_brand_domain:error_domaintitle}');
		obj.domainname.focus();
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
				s = '{lang sanree_brand_domain:post_ajax_error}';
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
<link rel="stylesheet" type="text/css" id="sanree_brand_domain" href="{sr_brand_domain_TPL}sanree_brand_domain.css?{VERHASH}" />
<div class="editdomain">
  <h3 class="flb mn sr"><em>{lang sanree_brand_domain:buydomaintitle}</em> <span>    
    <!--{if $_G['inajax']}-->
    <a href="javascript:;" class="flbc" onclick="hideWindow('buydlg', 0, 1);" title="{lang close}">{lang close}</a>
    <!--{/if}-->
    </span> </h3>
  <div class="domainitem">
    <span id="return_error" style="display:none"></span>
	<span id="succeedmessage"></span>
	<span id="upload"></span>  
  <form method="post" target="_blank" action="plugin.php?id=sanree_brand_domain&mod=buydomain" autocomplete="on" id="postform" onsubmit="return chkadd(this)">
    <input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
    <input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />
	<input type="hidden" name="inajax" id="inajax" value="{$_G[inajax]}" />
	<input type="hidden" name="domainid" id="domainid" value="{$domainid}" />  
    <table class="fire" width="400" border="1" bordercolor="E6E6E6" cellpadding="3" cellspacing="0">  
      <tr>
        <td colspan="2" align="center">{lang sanree_brand_domain:tpl_str2} <font color="red">{$domainprice}</font> {$creditunitname}</td>
      </tr>	
      <tr>
        <td class="lefttip">{lang sanree_brand_domain:tpl_str1}</td>
        <td><input type="text" name="domainname" value="" />{$okdomain}</td>
      </tr>
      <tr>
        <td colspan="2" align="center"><input class="pn pnc sanreesubmit" type="submit" value="{lang sanree_brand_domain:submit}"  tabindex="14" />
        </td>
      </tr>
      <tr>
        <td colspan="2" align="center" height="80">{lang sanree_brand_domain:tpl_str3}</td>
      </tr>		  
    </table>
	<input type="hidden" name="postsubmit" value="1" />
  </form>	
  </div>
</div>
<!--{if $_G['inajax']==1}-->
{template common/footer_ajax}
<!--{else}-->
{subtemplate common/footer}
<!--{/if}-->