<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{if $_G['inajax']==1}-->
{template common/header_ajax}
<!--{else}-->
{subtemplate common/header}
<!--{/if}-->
<script language="javascript" src="{sr_brand_JS}/msg{C_CHARSET}.js" reload="1"></script>
<script language="javascript" reload="1">
function saveform()
{
	if($('postform')) {
		ajaxpost('postform', 'return_error', 'return_error' , '', '',function(){srshowdialog();});
	}

}
</script>
<div class="ctitle"><h3 class="flb mn sr">{lang sanree_brand:baseconfig}</h3></div>
<form method="post" id="postform" action="plugin.php?id=sanree_brand&mod=brandconfig&do=config&inajax=yes&infloat=yes"  autocomplete="off">
<input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
<input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />
<input type="hidden" name="bid" id="bid" value="{$result[bid]}" />
<div style="margin-right:10px;">
<span id="return_error" style="display:none"></span>
<table class="fire" width="100%" border="1" cellpadding="5"  cellspacing="0" style="margin:20px auto;">
<tr><td width="100" height="30">{lang sanree_brand:config_hidebannername}</td><td><input type="radio" name="isshowbrandname" value="1" {$check[isshowbrandname][1]} /> {lang sanree_brand:yes} 
<input type="radio" name="isshowbrandname" value="0" {$check[isshowbrandname][0]}/> {lang sanree_brand:no}</td></tr>
<tr><td width="100" height="30">{lang sanree_brand:iscard}</td><td><input type="radio" name="iscard" value="1" {$check[iscard][1]} /> {lang sanree_brand:yes} 
<input type="radio" name="iscard" value="0" {$check[iscard][0]}/> {lang sanree_brand:no}</td></tr>
<tr><td  height="30">{lang sanree_brand:brand_tel}</td><td><input type="text" name="tel" value="{$result[tel]}" class="sminput" /><!--{if $ismultiple==1&&$result[allowmultiple]==1}--> {lang sanree_brand:multipletip}<!--{/if}--></td></tr>
<tr><td  height="30">{lang sanree_brand:brand_qq}</td><td><input type="text" name="qq" value="{$result[qq]}" class="sminput" /><!--{if $ismultiple==1&&$result[allowmultiple]==1}--> {lang sanree_brand:multipletip}<!--{/if}--></td></tr>
<tr><td  height="30">{lang sanree_brand:brand_msn}</td><td><input type="text" name="msn" value="{$result[msn]}" class="sminput" /><!--{if $ismultiple==1&&$result[allowmultiple]==1}--> {lang sanree_brand:multipletip}<!--{/if}--></td></tr>
<tr><td  height="30">{lang sanree_brand:brand_wangwang}</td><td><input type="text" name="wangwang" value="{$result[wangwang]}" class="sminput" /><!--{if $ismultiple==1&&$result[allowmultiple]==1}--> {lang sanree_brand:multipletip}<!--{/if}--></td></tr>
<tr><td  height="30">{lang sanree_brand:brand_baiduhi}</td><td><input type="text" name="baiduhi" value="{$result[baiduhi]}" class="sminput" /><!--{if $ismultiple==1&&$result[allowmultiple]==1}--> {lang sanree_brand:multipletip}<!--{/if}--></td></tr>
<tr><td  height="30">{lang sanree_brand:brand_skype}</td><td><input type="text" name="skype" value="{$result[skype]}" class="sminput" /><!--{if $ismultiple==1&&$result[allowmultiple]==1}--> {lang sanree_brand:multipletip}<!--{/if}--></td></tr>
<tr><td colspan="2" align="center"><button type="button" onclick="saveform()" class="pn pnc"><strong>{lang sanree_brand:submitsave}</strong></button></td></tr>
</table>
</div>
<input type="hidden" name="postsubmit" value="1" />				
</form>	
<!--{if $_G['inajax']==1}-->
{template common/footer_ajax}
<!--{else}-->
{subtemplate common/footer}
<!--{/if}-->