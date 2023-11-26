<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{if $_G['inajax']==1}-->
{template common/header_ajax}
<!--{else}-->
{subtemplate common/header}
<!--{/if}-->
<script language="javascript" reload="1">
var UPLOADWINRECALL = function (a,b,c,d){
	<!--{if !$config[isbird]}-->
		$('srbanner').src= '{$_G[setting][attachurl]}common/'+ b;
		<!--{if $goto}-->
		setTimeout("window.location.href ='{$thisurl}';", 3000);
		$('showok').style.display = 'block';
		<!--{/if}-->
	<!--{else}-->
		$('srbanner'+d).src= '{$_G[setting][attachurl]}category/'+ b;
		<!--{if $goto}-->
		$('showok'+d).style.display = '';
		<!--{/if}-->
	<!--{/if}-->
}
function uploadWindowload() {
	$('uploadwindowing').style.visibility = 'hidden';
	var str = $('uploadattachframe').contentWindow.document.body.innerHTML;
	if(str == '') return;
	var arr = str.split('|');
	if(arr[0] == 'DISCUZUPLOAD' && arr[2] == 0) {
		UPLOADWINRECALL(arr[3], arr[5], arr[6], arr[8]);
		hideWindow('upload', 0);
	}else {
		alert( 'error:'+arr[7]);
	}
}
</script>
<div class="ctitle">
  <h3 class="flb mn sr">{lang sanree_brand:bannerconfig}</h3>
</div>
<!--{if !$config[isbird]}-->
<div class="brandbanner">
<em id="uploadwindowing" class="mtn" style="visibility:hidden"><img src="{IMGDIR}/uploading.gif" alt="" /></em>
<form id="uploadform" class="uploadform ptm pbm" method="post" autocomplete="off" target="uploadattachframe" onsubmit="uploadWindowstart()" action="plugin.php?id=sanree_brand&mod=brandconfig&do=banner&inajax=yes&infloat=yes&simple=2" enctype="multipart/form-data">
  <input type="hidden" name="handlekey" value="upload" />
  <input type="hidden" name="uid" value="$_G['uid']">
  <input type="hidden" name="hash" value="{echo md5(substr(md5($_G['config']['security']['authkey']), 8).$_G['uid'])}">
  <input type="hidden" name="bid" value="$result['bid']">
  <input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
  <input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />
  <div class="filebtn">
    <input type="file" name="Filedata" id="filedata" class="pf cur1" size="1" onchange="$('uploadform').submit()" />
    <button type="button" class="pn pnc"><strong>{lang sanree_brand:upload_selectfile}</strong></button>
  </div>
  <input type="hidden" name="postsubmit" value="1" />
</form>
<iframe name="uploadattachframe" id="uploadattachframe" style="display: none;" onload="uploadWindowload();"></iframe>
<table width="100%" border="0" style="margin-top:20px;">
  <tr>
    <td>{lang sanree_brand:config_bannerimgtip}</td>
  </tr>
  <tr>
    <td>{lang sanree_brand:config_bannerimg}</td>
  </tr>
  <tr>
    <td><div style=" margin-top:2px;width:100%; height:100px; overflow:hidden;"> <img id="srbanner" src="{$result['banner']}" width="533" border="1"  height="78"/> </div></td>
  </tr>
  <tbody id="showok" style="display:none; color:#FF0000">
  <tr>
    <td align="center">{lang sanree_brand:gototip}</td>
  </tr> 
  </tbody> 
</table>
</div>
<!--{else}-->
{eval $nb_arr = array('0', '1', '2', '3', '4');}
{eval $defaultbanner = 'source/plugin/sanree_brand/tpl/bird/images/'}

{eval $newbanner = explode(',', $result[newbanner]);}
 
{eval $newbannerdefault = array($defaultbanner.'c_banner.jpg', $defaultbanner.'c_banner_01.jpg', $defaultbanner.'c_banner_02.jpg', $defaultbanner.'c_banner_05.jpg', $defaultbanner.'c_banner_06.jpg');}

<div style="overflow-y:scroll; height:450px">
<!--{loop $nb_arr $key $cate}-->
<div class="brandbanner">
<em id="uploadwindowing" class="mtn" style="visibility:hidden"><img src="{IMGDIR}/uploading.gif" alt="" /></em>
<form id="uploadform{$key}" class="uploadform ptm pbm" method="post" autocomplete="off" target="uploadattachframe" onsubmit="uploadWindowstart()" action="plugin.php?id=sanree_brand&mod=brandconfig&do=banner&newbanner={$key}&inajax=yes&infloat=yes&simple=2" enctype="multipart/form-data">
  <input type="hidden" name="handlekey" value="upload" />
  <input type="hidden" name="uid" value="$_G['uid']">
  <input type="hidden" name="hash" value="{echo md5(substr(md5($_G['config']['security']['authkey']), 8).$_G['uid'])}">
  <input type="hidden" name="bid" value="$result['bid']">
  <input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
  <input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />
  <div class="filebtn">
    <input type="file" name="Filedata{$key}" id="filedata" class="pf cur1" size="1" onchange="$('uploadform{$key}').submit()" />
    <button type="button" class="pn pnc"><strong>{lang sanree_brand:upload_selectfile}</strong></button>
  </div>
  <input type="hidden" name="postsubmit" value="1" />
</form>
<iframe name="uploadattachframe" id="uploadattachframe" style="display: none;" onload="uploadWindowload();"></iframe>
<table width="100%" border="0" style="margin-top:20px;">
  <tr>
    <td>{lang sanree_brand:bird_detail_banner}</td>
  </tr>
  <tr>
    <td>{lang sanree_brand:config_bannerimg}</td>
  </tr>
  <tr>{eval $newbanner[$cate] = $newbanner[$cate] ? $_G[setting][attachurl].'category/'.$newbanner[$cate] : $newbannerdefault[$cate]}
    <td><div style=" margin-top:2px;width:100%; height:178px; overflow:hidden;"> <img id="srbanner{$key}" src="{$newbanner[$cate]}" width="533" border="1"  height="178"/> </div></td>
  </tr>
  <tbody id="showok{$key}" style="display:none; color:#FF0000">
  <tr>
    <td align="center">{lang sanree_brand:bird_detail_gototip}</td>
  </tr> 
  </tbody> 
</table>
</div>
<!--{/loop}-->
<!--{/if}-->
<!--{if $_G['inajax']==1}-->
{template common/footer_ajax}
<!--{else}-->
{subtemplate common/footer}
<!--{/if}-->
