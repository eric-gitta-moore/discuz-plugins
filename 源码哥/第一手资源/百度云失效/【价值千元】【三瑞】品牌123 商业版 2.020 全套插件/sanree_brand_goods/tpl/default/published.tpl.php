<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{if $_G['inajax']==1}-->
{template common/header_ajax}
<!--{else}-->
{subtemplate common/header}
<!--{/if}-->
<script type="text/javascript" reload="1">	
function killErrors(){return true;}
window.onerror = killErrors;	
var editorid = '';
var X2IMGDIR = '{$thisconfig[imgdir]}';
var ATTACHNUM = {'imageused':0,'imageunused':0,'attachused':0,'attachunused':0}, ATTACHUNUSEDAID = new Array(), IMGUNUSEDAID = new Array();
</script>
<script type="text/javascript" src="{$thisconfig[jspath]}swfupload.js?{VERHASH}" reload="1"></script>
<script type="text/javascript" src="{$thisconfig[jspath]}swfupload.queue.js?{VERHASH}" reload="1"></script>
<script type="text/javascript" src="source/plugin/sanree_brand_goods/X2/js/handlers{C_CHARSET}.js?{VERHASH}" reload="1"></script>				
<script type="text/javascript" src="{$thisconfig[jspath]}fileprogress.js?{VERHASH}" reload="1"></script>
<script type="text/javascript" reload="1">
	function uploadSuccess(file, serverData) {
		try {
			var progress = new FileProgress(file, this.customSettings.progressTarget);
			if(this.customSettings.uploadSource == 'forum') {
				aid = parseInt(serverData);
				if(aid > 0) {
					if(this.customSettings.uploadType == 'attach') {
						ajaxget('plugin.php?id=sanree_brand_goods&mod=attachlist&aids=' + aid + (!fid ? '' : '&fid=' + fid)+(typeof resulttype == 'undefined' ? '' : '&result=simple'), file.id);
					}
				} else {
					aid = aid < -1 ? Math.abs(aid) : aid;
					if(typeof STATUSMSG[aid] == "string") {
						progress.setStatus(STATUSMSG[aid]);
						showDialog(STATUSMSG[aid], 'notice', null, null, 0, null, null, null, null, sdCloseTime);
					} else {
						progress.setStatus("{lang sanree_brand_goods:cancel}");
					}
					this.cancelUpload(file.id);
					progress.setCancelled();
					progress.toggleCancel(true, this);
					var stats = this.getStats();
					var obj = {'successful_uploads':--stats.successful_uploads, 'upload_cancelled':++stats.upload_cancelled};
					this.setStats(obj);
				}
			}
		} catch (ex) {
			this.debug(ex);
		}
	}
	var fid = $_G[fid];
	function showswfupload(){
		if (SWFUpload == undefined) {
			SWFUpload = function (settings) {
				this.initSWFUpload(settings);
			};
		}	
		var upload = new SWFUpload({
			upload_url: "{$_G[siteurl]}misc.php?mod=swfupload&action=swfupload&operation=upload&fid=$_G[fid]",
			post_params: {"uid" : "$_G[uid]", "hash":"$swfconfig[hash]"},
			file_size_limit : "$swfconfig[max]",
			file_types : "$swfconfig[attachexts][ext]",
			file_types_description : "$swfconfig[attachexts][depict]",
			file_upload_limit : $swfconfig['limit'],
			file_queue_limit : 0,
			swfupload_preload_handler : preLoad,
			swfupload_load_failed_handler : loadFailed,
			file_dialog_start_handler : fileDialogStart,
			file_queued_handler : fileQueued,
			file_queue_error_handler : fileQueueError,
			file_dialog_complete_handler : fileDialogComplete,
			upload_start_handler : uploadStart,
			upload_progress_handler : uploadProgress,
			upload_error_handler : uploadError,
			upload_success_handler : uploadSuccess,
			upload_complete_handler : uploadComplete,
			button_image_url : "{$thisconfig[imgdir]}/uploadbutton.png",
			button_placeholder_id : "spanButtonPlaceholder",
			button_width: 100,
			button_height: 25,
			button_cursor:SWFUpload.CURSOR.HAND,
			button_window_mode: "transparent",
	
			custom_settings : {
				progressTarget : "fsUploadProgress",
				uploadSource: 'forum',
				uploadType: 'attach',
				<!--{if $swfconfig['maxsizeperday']}-->
				maxSizePerDay: $swfconfig['maxsizeperday'],
				<!--{/if}-->
				<!--{if $swfconfig['maxattachnum']}-->
				maxAttachNum: $swfconfig['maxattachnum'],
				<!--{/if}-->
				uploadFrom: 'fastpost'
			},
			debug: false
		});
		isload = true;
	}
</script>
								
<script language="javascript">
function chkadd(obj)
{
	if(obj.bid.selectedIndex <1) 	{
		alert('{lang sanree_brand_goods:inputbid}');
		obj.bid.focus();
		return false;
	}
	if(obj.goodsname.value=='') {
		alert('{lang sanree_brand_goods:inputgoodsname}');
		obj.goodsname.focus();
		return false;
	}	
	if(obj.cateid.selectedIndex <1) 	{
		alert('{lang sanree_brand_goods:inputcate}');
		obj.cateid.focus();
		return false;
	}
	
	if(obj.content.value=='') {
		alert('{lang sanree_brand_goods:inputcontent}');
		obj.content.focus();
		return false;
	}
	
	if(obj.price.value=='') {
		alert('{lang sanree_brand_goods:inputprice}');
		obj.price.focus();
		return false;
	}
	if(obj.minprice.value=='') {
		alert('{lang sanree_brand_goods:inputminprice}');
		obj.minprice.focus();
		return false;
	}			

	<!--{if $_G[inajax]}-->
		ajaxpost('postform', 'return_error', 'return_error' , '', '',function(){srshowdialog();});
		return false;	
	<!--{else}-->
		return true;
	<!--{/if}-->
}
if ($('postform')) $('postform').bid.focus();
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
				s = '{lang sanree_brand_goods:post_ajax_error}';
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
<link rel="stylesheet" type="text/css" id="sanree_brand_goods" href="{sr_brand_goods_TPL}sanree_brand_goods.css?{VERHASH}" />
<link rel="stylesheet" type="text/css"  href="data/cache/style_{STYLEID}_forum_forumdisplay.css?{VERHASH}" />
<script type="text/javascript" src="{$_G[setting][jspath]}forum_post.js?{VERHASH}" reload="1"></script>
<div class="goods_published<!--{if !$_G['inajax']}--> published_notajax<!--{/if}-->">
  <h3 class="flb mn sr"><em>{$addteltitle}</em> <span>    
    <!--{if $_G['inajax']}-->
    <a href="javascript:;" class="flbc" onclick="hideWindow('publisheddlg', 0, 1);" title="{lang close}">{lang close}</a>
    <!--{/if}-->
    </span> </h3>
  <div class="goodsitem">
    <span id="return_error" style="display:none"></span>
	<span id="succeedmessage"></span>
	<span id="upload"></span>  
  <form method="post" target="_blank" action="plugin.php?id=sanree_brand_goods&mod=published" autocomplete="on" id="postform" onsubmit="return chkadd(this)">
    <input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
    <input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />
	<input type="hidden" name="inajax" id="inajax" value="{$_G[inajax]}" />
	<input type="hidden" name="gid" id="gid" value="{$gid}" />  
	<input type="hidden" name="tid" id="tid" value="{$tid}" />  
	<input type="hidden" name="pid" id="pid" value="{$pid}" /> 
	<input type="hidden" name="st" id="view" value="{$_G[sr_st]}" />  
    <table class="fire" width="700" border="1" bordercolor="E6E6E6" cellpadding="3" cellspacing="0">
      <tr>
		<td colspan="2" valign="middle"><div class="fright"><input class="pn pnc sanreesubmit" type="submit" value="<!--{if $gid}-->{lang sanree_brand_goods:edit_new_goods}<!--{else}-->{lang sanree_brand_goods:post_new_goods}<!--{/if}-->" /></div>
		<div class="post_remind">{lang sanree_brand_goods:post_remind} {$pubtip_price}</div>
        </td>
      </tr>		  	
      <tr class="bitian">
        <td class="lefttip"><span>*</span>{lang sanree_brand:brandnameto}</td>
        <td><select name="bid" class="catesel"  tabindex="1" >
            <option value="">{lang sanree_brand:selectedbrand}</option>
            <!--{loop $selectlist $cate}-->
            <option value='<!--{$cate[bid]}-->'<!--{if $cate[bid]==$result[bid]}-->selected<!--{/if}-->>
            <!--{$cate[name]}-->
            </option>
            <!--{/loop}-->
          </select></td>
      </tr>
      <tr class="bitian">
        <td class="lefttip"><span>*</span>{lang sanree_brand_goods:post_goodsname}</td>
        <td><input type="text" name="goodsname" value="{$result[name]}" class="goodsname" tabindex="2" /></td>
      </tr>
      <tr class="bitian">
        <td class="lefttip"><span>*</span>{lang sanree_brand_goods:post_goodscate}</td>
        <td><select name="cateid" class="catesel"  tabindex="3" >
            <option value="">{lang sanree_brand:pchose}</option>
            <!--{loop $category_list $cate}-->
            <option value='<!--{$cate[cateid]}-->'<!--{if $cate[cateid]==$result[cateid]}-->selected<!--{/if}-->>
            <!--{$cate[name]}-->
            </option>
            <!--{/loop}-->
          </select></td>
      </tr>
      <tr>
        <td class="lefttip">{lang sanree_brand_goods:post_keywords}</td>
        <td><input type="text" name="keywords" value="{$result[keywords]}" class="goodsname"  tabindex="4" /></td>
      </tr>
      <tr>
        <td class="lefttip">{lang sanree_brand_goods:post_description}</td>
        <td><textarea rows="2" name="description" class="goodsname"  tabindex="5">{$result[description]}</textarea></td>
      </tr>
	  <!--{if $isbuylink==1}-->
      <tr>
        <td class="lefttip">{lang sanree_brand_goods:post_buylink}</td>
        <td><input type="text" name="buylink" value="{$result[buylink]}" class="goodsname"  tabindex="6" /></td>
      </tr>
	  <!--{/if}-->	  
      <tr>
        <td class="lefttip">
		<span>*</span>{lang sanree_brand_goods:post_picture}</td>
        <td><span id="spanButtonPlaceholder" ><button onclick="showswfupload();">{lang sanree_brand_goods:upload}</button></span><br />
		<div class="upfl">
					<table cellpadding="0" cellspacing="0" border="0" width="600" id="attach_tblheader" style="display: none">
						<tr>
							<td class="attswf">{lang sanree_brand_goods:e_attach_insert}</td>
							<td class="attpr">{lang sanree_brand_goods:post_ishome}</td>
							<td class="attc">{lang sanree_brand_goods:deleteask}</td>
						</tr>
					</table>
					<div class="fieldset flash" id="attachlist"></div>
					<div class="fieldset flash" id="fsUploadProgress"></div>
			</div>		
		  </td>
      </tr>	  
      <tr class="bitian">
        <td class="lefttip"><span>*</span>{lang sanree_brand_goods:post_content}</td>
        <td>
			<div class=tedt>
				<div class=bar><SPAN class=y><HOOK></HOOK></SPAN><span class="hook"></span>
					<!--{eval $seditor = array('fastpost', array('bold', 'color', 'img', 'link', 'quote', 'code', 'smilies'), !$allowfastpost ? 1 : 0);}-->
					<!--{subtemplate common/seditor}-->
				</div>
				<div class=area>
					<TEXTAREA id="fastpostmessage" class=pt tabIndex="7" rows=6 cols=40 name=content>{$result[content]}</TEXTAREA>
				</div>
			</div>
		  </td>
      </tr>
	  
      <tr class="bitian">
        <td class="lefttip"><span>*</span>{lang sanree_brand_goods:priceunit}</td>
        <td>{$selectunitstr}</td>
      </tr>	  
      <tr class="bitian">
        <td class="lefttip"><span>*</span>{lang sanree_brand_goods:post_price}</td>
        <td><input type="text" name="price" value="{$result[price]}"  tabindex="8" /></td>
      </tr>
      <tr>
        <td class="lefttip"><span>*</span>{lang sanree_brand_goods:post_minprice}</td>
        <td><input type="text" name="minprice" value="{$result[minprice]}"  tabindex="9" /></td>
      </tr>
  	  
      <tr>
        <td class="lefttip">{lang sanree_brand_goods:post_goodsno}</td>
        <td><input type="text" name="goodsno" value="{$result[goodsno]}" tabindex="10" /></td>
      </tr>	 
      <tr>
        <td class="lefttip">{lang sanree_brand_goods:unit}</td>
        <td><input type="text" name="unit" value="{$result[unit]}"  tabindex="11" /> {lang sanree_brand_goods:unittip}</td>
      </tr>	     
      <tr>
        <td class="lefttip">{lang sanree_brand_goods:isshow}</td>
        <td><input type="radio" name="isshow" value="1" tabindex="12" {$isshowst}/>
          {lang sanree_brand_goods:post_yew}
          <input type="radio" name="isshow" value="0" tabindex="13" {$notshowst}/>
          {lang sanree_brand_goods:post_no}</td>
      </tr>
      <tr>
        <td colspan="2" align="right"><input class="pn pnc sanreesubmit" type="submit" value="<!--{if $gid}-->{lang sanree_brand_goods:edit_new_goods}<!--{else}-->{lang sanree_brand_goods:post_new_goods}<!--{/if}-->"  tabindex="14" />
        </td>
      </tr>
    </table>
	<input type="hidden" name="postsubmit" value="1" />
  </form>	
  </div>
</div>
<script language="javascript" reload="1">
var isload = false;
var pid = '{$result[pid]}';
setTimeout(function(){forload()},1000);
function forload() {
	if (isload) return;
	showswfupload();
	setTimeout(function(){forload()},1000);
}
</script>
<!--{if $result[aids]}-->
<script language="javascript" reload="1">
function updateattachnum(id){}
function delAttach(id, type) {
	var ids = {};
	if(typeof id == 'number') {
		ids[id] = id;
	} else {
		ids = id;
	}
	for(id in ids) {
		if($('attach_' + id)) {
			$('attach_' + id).style.display = '';
			$('attach_' + id).parentNode.removeChild($('attach_' + id));
			ATTACHNUM['attach' + (type ? 'un' : '') + 'used']--;
			updateattachnum('attach');
		}
	}
	appendAttachDel(ids);
}

function loadimg(){
    var aid ='{$result[aids]}';
	var homeaid = '{$result[homeaid]}';
	var tid = '{$result[tid]}';
	ajaxget('plugin.php?id=sanree_brand_goods&mod=attachlist&aids=' + aid+'&homeaid='+homeaid+'&pid=' + pid+'&tid='+tid, 'attachlist');
	$('attach_tblheader').style.display='block';

}
setTimeout(function(){showswfupload();loadimg()},1000);
</script> 
<!--{/if}-->
<style type="text/css">object{visibility:visible;}</style>
<!--{if $_G['inajax']==1}-->
{template common/footer_ajax}
<!--{else}-->
{subtemplate common/footer}
<!--{/if}-->