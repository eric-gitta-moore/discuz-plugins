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
	ShowuploadExe(function (aid, url) {rebackposter(aid, url)}, 'backimage') ;
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
<div class="bodyconfig">
  <div class="ctitle">
    <h3 class="flb mn sr">{lang sanree_brand:bodyconfig}</h3>
  </div>
  <form method="post" id="postform" action="plugin.php?id=sanree_brand&mod=brandconfig&do=body&inajax=yes&infloat=yes" autocomplete="off">
    <input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
    <input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />
    <input type="hidden" name="bid" id="bid" value="{$bid}" />
	<input type="hidden" name="poster" id="poster" value="{$backgroundimage}" />
    <input type="hidden" name="caid" id="caid" />
    <input type="hidden" name="postsubmit" value="1" />	
    <span id="return_error" style="display:none"></span>
	<div style="margin-right:10px;">
    <table class="fire" width="100%" border="1" cellpadding="5"  cellspacing="0" style="margin:10px auto;">
	<tbody style="display:block;">
	<tbody>
      <tr>
        <td width="100" height="30">{lang sanree_brand:isenableback}</td>
        <td><input type="radio" name="isuse" value="1" {$check[isuse][1]} onclick="showconfig(1)" />
          {lang sanree_brand:yes}
          <input type="radio" name="isuse" value="0" {$check[isuse][0]} onclick="showconfig(0)" />
          {lang sanree_brand:no} </td>
      </tr>
	  <tbody id="configmain"<!--{if $bodystyle['isuse']!=1}--> style="display:none;"<!--{/if}-->>
      <tr>
        <td height="30">{lang sanree_brand:hideheader}</td>
        <td><input type="radio" name="ishideheader" value="1" {$check[ishideheader][1]} />
          {lang sanree_brand:yes}
          <input type="radio" name="ishideheader" value="0" {$check[ishideheader][0]}/>
          {lang sanree_brand:no}</td>
      </tr>		  
      <tr>
        <td height="30"> {lang sanree_brand:backcolor}</td>
        <td><input id="ccolorid_v" type="text" name="color" id="color" value="{$body[color]}" maxlength="7" />
          <input style="background:{$body[color]}" id="ccolorid" onclick="ccolorid_frame.location='static/image/admincp/getcolor.htm?ccolorid|ccolorid_v';showMenu({'ctrlid':'ccolorid','pos':'*','ctrlclass':'a'})" type="button" class="colorwd" value="">
          <span id="ccolorid_menu" class="p_pop p_opt" style="display: none">
          <iframe name="ccolorid_frame" src="" frameborder="0" width="210" height="148" scrolling="no"> </iframe>
          </span></td>
      </tr>
      <tr>
        <td height="30">{lang sanree_brand:backgroundimage}</td>
        <td>
          <div class="uploadbar" id="uploadbar" style="float:left">
            <button type="button" onclick="backimageupload()" class="pn pnc"><strong>{lang sanree_brand:clickupload}</strong></button>
          </div>
          <input type="checkbox" name="notbackimg" id="notbackimg" value="1" {$check[notbackimg]} />
          {lang sanree_brand:notbacktip}</td>
      </tr>    
      <td height="30">{lang sanree_brand:selectrepeatshow}</td>
        <td>{$selectrepeat}</td>
      </tr>
      <tr>
        <td height="30">{lang sanree_brand:selectattachment}</td>
        <td>{$selectattachment}</td>
      </tr>
      <td height="30">{lang sanree_brand:backgroundpositionx}</td>
        <td>{$selectpositionx}</td>
      </tr>	
      <td height="30">{lang sanree_brand:backgroundpositiony}</td>
        <td>{$selectpositiony}</td>
      </tr>		  
	  </tbody>
      <tr>
        <td colspan="2" align="center"><button type="button" onclick="saveform()" class="pn pnc"><strong>{lang sanree_brand:submitsave}</strong></button></td>
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
