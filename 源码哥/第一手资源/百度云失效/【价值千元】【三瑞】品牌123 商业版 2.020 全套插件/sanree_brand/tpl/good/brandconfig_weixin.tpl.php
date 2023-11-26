<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{if $_G['inajax']==1}-->
{template common/header_ajax}
<!--{else}-->
{subtemplate common/header}
<!--{/if}-->
<script language="javascript" src="{sr_brand_JS}/upload{C_CHARSET}.js" reload="1"></script>
<script language="javascript" src="{sr_brand_JS}/msg{C_CHARSET}.js" reload="1"></script>
<script language="javascript" reload="1">
function saveform() {
	if($('postform')) {
		ajaxpost('postform', 'return_error', 'return_error' , '', '',function(){srshowdialog();});
	}
}
function backimageupload() {
	ShowuploadExe(function (aid, url) {rebackposter(aid, url)}, 'wximage') ;
}

function wxpublicupload() {
	ShowuploadExe(function (aid, url) {rebackwxpublic(aid, url)}, 'wximage') ;
}
function rebackwxpublic(aid, url){
	$('wxpublic').value=url;
	$('uploadpublic').innerHTML= haveuploaded;
}

function showconfig(id){
	if (id!=1) {
		$('configmain').style.display='none';
	}else{
		$('configmain').style.display='';
	}
}
var haveuploaded='{lang sanree_brand:haveuploaded}';
</script>
<style type="text/css">
	.tab_left{
		text-align:right;
	}
	.uploadbar{
		margin-left:28px;
	}
	.sminput{
		width:140px !important;
		margin-left:2px; 
	}
</style>
<div class="bodyconfig">
  <div class="ctitle">
    <h3 class="flb mn sr">{lang sanree_brand:weixinconfig}</h3>
  </div>
  <form method="post" id="postform" action="plugin.php?id=sanree_brand&mod=brandconfig&do=weixin&inajax=yes&infloat=yes" autocomplete="off">
    <input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
    <input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />
    <input type="hidden" name="bid" id="bid" value="{$bid}" />
	<input type="hidden" name="poster" id="poster" value="{$result[weixinimg]}" />
    <input type="hidden" name="wxpublic" id="wxpublic" value="{$result[weixinpublicpic]}" />
    <input type="hidden" name="caid" id="caid" />
    <input type="hidden" name="postsubmit" value="1" />	
    <span id="return_error" style="display:none"></span>
	<div style="margin-right:10px;">
    <table class="fire" width="100%" border="1" cellpadding="5"  cellspacing="0" style="margin:10px auto;">
	<tbody>
      <tr>
        <td height="30" class="tab_left">{lang sanree_brand:weixinnum}</td>
        <td><input type="text" name="weixin" value="{$result[weixin]}" class="sminput" /></td>
        <td rowspan="3" ><div style=" margin-top:2px;width:100%; height:160px; overflow:hidden; text-align:center"> <img id="srbanner" src="{$backgroundimage}" width="150" height="150" border="1" /> </div></td>
      </tr> 	
      <tr>
        <td height="30" class="tab_left">{lang sanree_brand:weixinimg}</td>
        <td>
          <div class="uploadbar" id="uploadbar" style="float:left">
            <button type="button" onclick="backimageupload()" class="pn pnc"><strong>{lang sanree_brand:clickupload}</strong></button>
          </div></td>
      </tr>
      <tr><td></td><td></td></tr>
      <tr>
        <td height="30" class="tab_left">{lang sanree_brand:weixinpublic}</td>
        <td><input type="text" name="weixinpublic" value="{$result[weixinpublic]}" class="sminput" /></td>
		<td rowspan="3" ><div style=" margin-top:2px;width:100%; height:160px; overflow:hidden; text-align:center"> <img id="srbanner" src="{$weixinpublicpic}" width="150" height="150" border="1" /> </div></td>
      </tr> 
      <tr>
        <td height="30" class="tab_left">{lang sanree_brand:weixinpublicpic}</td>
        <td>
        	<div class="uploadbar" id="uploadpublic" style="float:left">
            	<button type="button" onclick="wxpublicupload()" class="pn pnc"><strong>{lang sanree_brand:clickupload}</strong></button>
          	</div>
      	</td>
      </tr>
      <tr><td></td><td></td></tr>
      <tr>
        <td colspan="3" align="center"><button type="button" onclick="saveform()" class="pn pnc"><strong>{lang sanree_brand:submitsave}</strong></button></td>
      </tr>
	  </tbody>
    </table>
	</div>
  </form>
</div>
<!--{if $_G['inajax']==1}-->
{template common/footer_ajax}
<!--{else}-->
{subtemplate common/footer}
<!--{/if}-->
