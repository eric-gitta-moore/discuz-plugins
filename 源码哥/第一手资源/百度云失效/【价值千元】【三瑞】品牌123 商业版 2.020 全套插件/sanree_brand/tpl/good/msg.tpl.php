<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{if $_G['inajax']==1}-->
{template common/header_ajax}
<!--{else}-->
{subtemplate common/header}
<!--{/if}-->
<link rel="stylesheet" type="text/css" href="{SANREE_BRAND_TEMPLATE}/msg.css?{VERHASH}" />
<script language="javascript" src="{sr_brand_JS}/msg{C_CHARSET}.js"></script>
<script language="javascript">
function chk(obj) {
	if(obj.errorword.value=='') {
		alert('{lang sanree_brand:errorwordtip}');
		obj.errorword.focus();
		return false;
	}
	<!--{if $_G[inajax]}-->
		ajaxpost('postform', 'return_error', 'return_error' , '', '',function(){srshowdialog();});
		return false;	
	<!--{else}-->
		return true;
	<!--{/if}-->
}	
</script>	
<div class="msgbody<!--{if !$_G['inajax']}--> msgbody_notajax<!--{/if}-->">
	<h3 class="flb mn">
	    <em>
		<!--{if $type==0}-->
		{lang sanree_brand:errorpay}
		<!--{elseif $type==1}-->
		{lang sanree_brand:getbrand}
		<!--{elseif $type==2}-->
		{lang sanree_brand:guestbook}
		<!--{elseif $type==3}-->
		{lang sanree_brand:report}
		<!--{/if}-->
		</em>
		<span><!--{if !empty($_G['sr_infloat']) && !isset($_G['sr_frommessage'])}--><a href="javascript:;" class="flbc" onclick="hideWindow('cmenu', 0, 1);" title="{lang close}">{lang close}</a><!--{/if}--></span>
	</h3>	
	<span id="return_error" style="display:none"></span>
	<form method="post" target="_blank" action="plugin.php?id=sanree_brand&mod=msg" autocomplete="off" id="postform" onsubmit="return chk(this)">
		<input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
		<input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />
		<input type="hidden" name="bid" id="bid" value="{$bid}" />
		<input type="hidden" name="inajax" id="inajax" value="{$_G[inajax]}" />
		<input type="hidden" name="type" id="type" value="{$type}" />
		<div class="errorbox">
		    <div class="hd"><h1>{lang sanree_brand:brandstr}<span>{$brandresult['name']}</span></h1></div>
			<div class="bd">
				<dl>
					<dd><label>{lang sanree_brand:errorword}</label></dd>
					<dd><textarea class="errorword" name="errorword" id="errorword"></textarea></dd>
					<dd class="tjline"><input type="hidden" name="postsubmit" value="1" /><input type="image" src="{sr_brand_IMG}/msgbtn.jpg" /></dd>
				</dl>
			</div>
		</div>
	</form>	
</div>
<!--{if $_G['inajax']==1}-->
{template common/footer_ajax}
<!--{else}-->
{subtemplate common/footer}
<!--{/if}-->