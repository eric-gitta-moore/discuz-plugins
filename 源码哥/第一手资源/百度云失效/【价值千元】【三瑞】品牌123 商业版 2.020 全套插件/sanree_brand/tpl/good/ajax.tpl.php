<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{template common/header}-->
<!--{if $do=='creatalbum'}-->
<script language="javascript" src="{sr_brand_JS}/msg{C_CHARSET}.js"></script>
<script language="javascript">
function chkaddalbum(obj)
{
	if(obj.albumname.value=='') {
		alert('{lang sanree_brand:nocatname}');
		obj.albumname.focus();
		return false;
	}
	<!--{if $_G[inajax]}-->
		ajaxpost('creatalbum', 'return_error', 'return_error' , '', '',function(){srshowdialog();});
		return false;	
	<!--{else}-->
		return true;
	<!--{/if}-->	
}
</script>
<div class="creatalbum">
<h3 class="flb mn sr"><em>{$htitle}</em><span><!--{if $_G['inajax']}--><a href="javascript:;" class="flbc" onclick="hideWindow('creatalbumdlg', 0, 1);" title="{lang close}">{lang close}</a><!--{/if}--></span></h3>
<div class="alertbody">
<form method="post" id="creatalbum" action="plugin.php?id=sanree_brand&mod=ajax&do=creatalbum"  autocomplete="off" onsubmit="return chkaddalbum(this);">
    <input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
    <input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />
	<input type="hidden" name="inajax" id="inajax" value="{$_G[inajax]}" />
	<input type="hidden" name="catid" id="catid" value="{$catid}" />
	<input type="hidden" name="bid" id="bid" value="{$bid}" />	
<span id="return_error" style="display:none"></span>
<table class="fire" width="100%" border="1" cellpadding="5"  cellspacing="0" style="margin:0px auto;">
  <tr>
    <td width="100" align="right">{lang sanree_brand:brandnameto}&nbsp;</td>
    <td>&nbsp;{$brandresult[name]}</td>
  </tr>
  <tr>
    <td  align="right">{lang sanree_brand:albumcatename}&nbsp;</td>
    <td>&nbsp;<input type="text" name="albumname" size="50" value="{$result[catname]}" /><span class="mred">*</span></td>
  </tr>
  <tr>
    <td  align="right">{lang sanree_brand:albumdesc}&nbsp;</td>
    <td>&nbsp;<textarea name="description" cols="50" rows="3" />{$result[description]}</textarea></td>
  </tr>
  <tr>
    <td  align="right">{lang sanree_brand:albumdisplayorder}&nbsp;</td>
    <td>&nbsp;<input type="text" name="displayorder" value="{$result[displayorder]}" size="5" /></td>
  </tr> 
  <tr>
    <td  align="right">&nbsp;</td>
    <td>&nbsp;<button type="button" onclick="chkaddalbum($('creatalbum'));" class="pn pnc"><strong>{lang sanree_brand:submit}</strong></button>
	<input type="hidden" name="postsubmit" value="1" /> </td>
  </tr>    
</table>
</form>
</div>
</div>
<!--{elseif $do=='uploadpic'}-->
<script language="javascript" src="{sr_brand_JS}/msg{C_CHARSET}.js"></script>
<script language="javascript">
function chkaddpic(obj) {
	if(obj.brandname.selectedIndex <1)  {
		alert('{lang sanree_brand:selectbrandname}');
		obj.brandname.focus();
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
<div class="uploadpic">
<h3 class="flb mn sr"><em>{lang sanree_brand:uploadnewpic}</em><span><!--{if $_G['inajax']}--><a href="javascript:;" class="flbc" onclick="hideWindow('uploadpicdlg', 0, 1);" title="{lang close}">{lang close}</a><!--{/if}--></span></h3>
<div class="alertbody">
<form method="post" id="postform" action="plugin.php?id=sanree_brand&mod=ajax&do=uploadpic&inajax=yes&infloat=yes"  autocomplete="off" onsubmit="return chkaddpic(this);" enctype="multipart/form-data">
<input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
<input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />
<input type="hidden" name="inajax" id="inajax" value="{$_G[inajax]}" />
<input type="hidden" name="albumid" id="albumid" value="{$albumid}" />
<input type="hidden" name="handlekey" value="upload" />
<input type="hidden" name="uid" value="$_G['uid']">
<input type="hidden" name="hash" value="{echo md5(substr(md5($_G['config']['security']['authkey']), 8).$_G['uid'])}">
<input type="hidden" name="postsubmit" value="1" />
<input type="hidden" name="bid" id="bid" value="{$bid}" />
<span id="return_error" style="display:none"></span>
<table class="fire" width="100%" border="1" cellpadding="5"  cellspacing="0" style="margin:0px auto;">
      <tr>
        <td width="130" align="right">{lang sanree_brand:albumnameto}&nbsp;</td>
        <td>&nbsp;
          <select name="brandname">
            <!--{loop $selectlist $brand}-->
            <option value="{$brand['bid']}"<!--{if $brand[bid]==$catid}--> selected<!--{/if}-->>{$brand['name']}</option>
            <!--{/loop}-->
          </select>
          <span class="mred">*</span></td>
      </tr>
      <tr>
        <td  align="right">{lang sanree_brand:selectpic}&nbsp;</td>
        <td><div class="filebtn">
            <input type="file" name="Filedata" id="filedata" class="pf cur1" size="1" onchange="chkaddpic($('postform'))" />
            <button type="button" class="pn pnc"><strong>{lang sanree_brand:upload}</strong></button>
          </div></td>
      </tr>
    </table>
</form>
<p class="xg1 mtn" style="text-align:center"> {lang sanree_brand:attachment_allow_exts}: <span class="xi1">$imgexts</span> </p>
</div>
</div>
<!--{elseif $do=='editpic'}-->
<script language="javascript" src="{sr_brand_JS}/msg{C_CHARSET}.js"></script>
<script language="javascript">
function chkaddpic(obj) {
	<!--{if $_G[inajax]}-->
		ajaxpost('postform', 'return_error', 'return_error' , '', '',function(){srshowdialog();});
		return false;	
	<!--{else}-->
		return true;
	<!--{/if}-->	
}
</script>
<div class="editdpic">
<h3 class="flb mn sr"><em>{lang sanree_brand:modiyalbum}</em><span><!--{if $_G['inajax']}--><a href="javascript:;" class="flbc" onclick="hideWindow('editpic', 0, 1);" title="{lang close}">{lang close}</a><!--{/if}--></span></h3>
<div class="alertbody">
<form method="post" id="postform" action="plugin.php?id=sanree_brand&mod=ajax&do=editpic&inajax=yes&infloat=yes"  autocomplete="off" onsubmit="return chkaddpic(this);">
<input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
<input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />
<input type="hidden" name="inajax" id="inajax" value="{$_G[inajax]}" />
<input type="hidden" name="albumid" id="albumid" value="{$albumid}" />
<input type="hidden" name="postsubmit" value="1" />
<input type="hidden" name="bid" id="bid" value="{$bid}" />
<span id="return_error" style="display:none"></span>
<table class="fire" width="100%" border="1" cellpadding="5"  cellspacing="0" style="margin:0px auto;">
      <tr>
        <td  align="right">{lang sanree_brand:albumname}&nbsp;</td>
        <td><input type="text" size="50"  value="{$result[albumname]}" name="albumname" /></td>
      </tr>
      <tr>
        <td  align="right">{lang sanree_brand:sethomestr}&nbsp;</td>
        <td><input type="checkbox" name="istop"  value="1" /></td>
      </tr>		  
      <tr>
        <td  align="right">&nbsp;</td>
        <td><input type="submit" value="{lang sanree_brand:submit}" /></td>
      </tr>	  
    </table>
</form>
</div>
</div>
<!--{elseif $do=='uploadpicbatch'}-->
<script language="javascript" reload="1">
function swfHandler(action, type) {
	if (action==2) {
		hideWindow('uploadpicbatchdlg', 0, 1);
		location.reload();
		doane();		
	}
}
</script>
<DIV class="uploadpicbatch">
<h3 class="flb mn sr"><em>{lang sanree_brand:batch_upload}</em><span><!--{if $_G['inajax']}--><a href="javascript:;" class="flbc" onclick="hideWindow('uploadpicbatchdlg', 0, 1);" title="{lang close}">{lang close}</a><!--{/if}--></span></h3>
	<DIV id=e_multi class=p_opt unselectable="on">
	  <DIV id=e_multiimg class="bbda hm">
		<script type="text/javascript">
			$('e_multiimg').innerHTML = AC_FL_RunContent(
				'width', '470', 'height', '268',
				'src', 'source/plugin/sanree_brand/tpl/default/images/upload.swf?site={$_G[siteroot]}plugin.php%3fid=sanree_brand%26mod=misc_swfupload%26fid={$_G[fid]}%26bid={$bid}%26uid={$_G[uid]}%26type=image%26random=<!--{echo random(4)}-->',
				'quality', 'high',
				'id', 'swfupload',
				'menu', 'false',
				'allowScriptAccess', 'always',
				'wmode', 'transparent'
			);
		</script>
	  </DIV>
	  <DIV class="notice uploadinfo">{lang sanree_brand:cur_album_name}<SPAN class=xi1>{$albumcate['catname']}</SPAN> , {lang sanree_brand:cur_album_upload_msg1}<SPAN class=xi1>{$maxpicnum}</SPAN> {lang sanree_brand:cur_album_upload_msg2}<br />{lang sanree_brand:attachment_size}: <SPAN class=xi1><!--{if $_G['group']['maxattachsize']}-->{lang sanree_brand:lower_than} $maxattachsize_mb <!--{else}-->{lang sanree_brand:size_no_limit}<!--{/if}--></SPAN>, {lang sanree_brand:attachment_allow_exts}: <SPAN class=xi1>{$imgexts}</SPAN> <BR>
		{lang sanree_brand:attachment_filenums_tip} </DIV>
	</DIV>
  </DIV>
<!--{/if}-->
<!--{template common/footer}-->