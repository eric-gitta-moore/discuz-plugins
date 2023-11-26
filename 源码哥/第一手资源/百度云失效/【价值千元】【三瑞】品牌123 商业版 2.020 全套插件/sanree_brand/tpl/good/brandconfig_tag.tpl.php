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

var arrayObj = '{$result[brandtag]}'.split(",");
function settag(name){
	
	if (!in_array(name,arrayObj)) {
		arrayObj.push(name);
	}
	$("brandtag").value= arrayObj.join(',');
	$("brandtag").focus();
	
}

function in_array(search,array){
    for(var i in array){
        if(array[i]==search){
            return true;
        }
    }
    return false;
}
</script>
<style type="text/css">
	.tab_left{
		text-align:center;
	}
	.uploadbar{
		margin-left:28px;
	}
	.sminput{
		
		margin-left:2px; 
	}
	ul.tag_list {
		margin-top: 6px;
	}
	ul.tag_list li a {
		width: 19%;
		padding: 6px 0;
		background: #f9f9f9;
		float: left;
		margin: 0 2px 5px;
		display: block;
	}
	ul.tag_list li a:hover {
		width: 19%;
		padding: 6px 0;
		background: #e8f0f7;
		float: left;
		margin: 0 2px 5px;
		display: block;
		color: #2366a8;
		text-decoration: none;
	}
	.t_tip {
		margin-bottom: 6px 15px;
		color: #2366a8;
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
    <h3 class="flb mn sr">{lang sanree_brand:tag}</h3>
  </div>
  <form method="post" id="postform" action="plugin.php?id=sanree_brand&mod=brandconfig&do=tag&inajax=yes&infloat=yes" autocomplete="off">
    <input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
    <input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />
    <input type="hidden" name="bid" id="bid" value="{$bid}" />
	<input type="hidden" name="poster" id="poster" value="{$result[weixinimg]}" />
    <input type="hidden" name="wxpublic" id="wxpublic" value="{$result[weixinpublicpic]}" />
    <input type="hidden" name="caid" id="caid" />
    <input type="hidden" name="postsubmit" value="1" />	
    <span id="return_error" style="display:none"></span>
	<div style="margin-right:10px; overflow-y:scroll; height:440px">
    <table class="fire" width="100%" border="1" cellpadding="5"  cellspacing="0" style="margin:10px auto;">
	<tbody>
      <tr>
        <td height="30" class="tab_left">{lang sanree_brand:tag}</td>
        <td><input type="text" name="brandtag" value="{$result[brandtag]}" class="sminput" id="brandtag"/></td>
      </tr>
      <tr><td colspan="2" class="tab_left" style="background: #e8f0f7;"><span class="t_tip">{lang sanree_brand:clicktag}</span></td></tr>
      <tr><td colspan="2" class="tab_left">
	  <ul class="tag_list"><!--{loop $brandtag $tag}--><li><label><a onclick="settag('{$tag[tagname]}')">{$tag[tagname]}</a></label></li><!--{/loop}--></ul></td></tr>
      <tr>
        <td colspan="3" align="center"><div class="b_btn"><button type="button" onclick="saveform()" class="pn pnc"><strong>{lang sanree_brand:submitsave}</strong></button></div></td>
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
