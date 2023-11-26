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
		text-align:center;
	}
	.tab_left .checkbox {
		margin-right: 5px;
		vertical-align: middle;
	}
	
	.uploadbar{
		margin-left:28px;
	}
	.sminput{
		width:140px !important;
		margin-left:2px; 
	}
	ul.tab_list {
		padding: 0 15px;
		overflow: hidden;
	}
	ul.tab_list li {
		float: left;
		width: 19%;
		text-align: left;
		padding: 6px 0;
		background: #f9f9f9;
		border-bottom: 1px dotted #e0e0e0;
		margin: 6px 2px;
	}
	.fire {
		border: none !important;
	}
	.fire td{
		border: none !important;
	}
	.b_btn {
		border: 1px dashed #E0E0E0;
		padding: 9px 0;
		background: #fafafa;
	}
</style>
<div class="bodyconfig">
  <div class="ctitle">
    <h3 class="flb mn sr">{lang sanree_brand:mf}</h3>
  </div>
  <form method="post" id="postform" action="plugin.php?id=sanree_brand&mod=brandconfig&do=mf&inajax=yes&infloat=yes" autocomplete="off">
    <input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
    <input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />
    <input type="hidden" name="bid" id="bid" value="{$bid}" />
	<input type="hidden" name="poster" id="poster" value="{$result[weixinimg]}" />
    <input type="hidden" name="wxpublic" id="wxpublic" value="{$result[weixinpublicpic]}" />
    <input type="hidden" name="caid" id="caid" />
    <input type="hidden" name="postsubmit" value="1" />	
    <span id="return_error" style="display:none"></span>
	<div style="margin-right:10px; overflow-y:scroll; height:440px">
    <table class="fire" width="100%" border="0" cellpadding="0"  cellspacing="0" style="margin:10px auto;">
	<tbody>
      <tr>
      	<td class="tab_left">
        <ul class="tab_list">
        <!--{loop $mflist $mf}-->
        <li>
        <input {if in_array($mf[0],$brandmf)} checked="checked" {/if} id="mf{$mf[0]}" type="checkbox" name="brandmf[]" value="{$mf[0]}" class="checkbox" /><label for="mf{$mf[0]}">{$mf[1]}</label>
        <!--{/loop}-->
        </li>
        </ul>
        </td>
      </tr>
      <tr>
        <td colspan="3" align="center" style="padding: 0 15px;"><div class="b_btn"><button type="button" onclick="saveform()" class="pn pnc"><strong>{lang sanree_brand:submitsave}</strong></button></div></td>
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
