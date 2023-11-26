<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: function_module.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function goods_add_diy_template($template, $arr){

	global $_G;
	$template = stripslashes($template);
	include_once libfile('function/block');
	block_parse_template($template, $arr);
	$appVer = $_G['setting']['version'];
	if ($appVer!='X2') {
		$arr = daddslashes($arr);
	}	
	$hash=$arr['hash'];
	$result = C::t('#sanree_brand#sanree_brand_businesses')->fix_get_block($hash);
	if($result) {
	
		C::t('#sanree_brand#sanree_brand_businesses')->fix_update_block($hash,$arr);
		
	} else {
	
		C::t('#sanree_brand#sanree_brand_businesses')->fix_insert_block($arr);
			
	}
	
	require_once libfile('function/cache');
	updatecache('blockclass');
	blockclass_cache();	
		
}

function goods_diystyle() {

	global $_G;
	$style = '';
	$condition = array();
	$condition[]= 'status=1';
	$orderby = 'displayorder, diystyleid';
	$stamplist=C::t('#sanree_brand_goods#sanree_brand_goods_diystyle')->fetch_all_by_search($condition, $orderby);
	foreach($stamplist as $key => $val) {

	    $val['content'] = unserialize($val['content']) ? unserialize($val['content']) : $val['content'];
	    $val['content'] = str_replace('stylename', $val['name'], $val['content']);
		$val['content'] = fixhtmlstr($val['content']);
		$style.= $val[content]."\r\n";
		
	}	
	diystylelog($style, "sanree_brand_goods_diy.css");
	
}

function goods_diytemplate($diytemplateid = 0) {

	global $_G;
	$style = '';
	$condition = array();
	$condition[]= 'status=1';
	if ($diytemplateid>0) {
	
		$condition[]= 'diytemplateid='.$diytemplateid;
		
	}
	$orderby = 'displayorder, diytemplateid';
	$stamplist=C::t('#sanree_brand_goods#sanree_brand_goods_diytemplate')->fetch_all_by_search($condition, $orderby);
	foreach($stamplist as $key => $val) {
	
	    $val['name'] = $val['issys']==1 ? srlang('neizhi').$val['name'] : $val['name'];
		$arr = array(
			'name' => $val['name'],
			'blockclass' => 'sanree_brand_goods',
		);	
		$val['content'] = unserialize($val['content']) ? unserialize($val['content']) : $val['content'];
		$val['content'] = fixhtmlstr($val['content']);
		goods_add_diy_template($val['content'], $arr);
		
	}		
	
}

function goods_srconvertunusedattach($aid, $tid, $pid, $uid, $description) {
	global $_G;
	if(!$aid) {
		return;
	}

	$attach = C::t('#sanree_brand#forum_attachment_n')->fetch_by_aid_uid(127, $aid, $uid);
	if ((!$attach)&&($uid != $_G['uid'])) {
		$attach = C::t('#sanree_brand#forum_attachment_n')->fetch_by_aid_uid(127, $aid, $_G['uid']);
	}	
	if(!$attach) {

	} else {
		$attach = daddslashes($attach);
		$attach['tid'] = $tid;
		$attach['pid'] = $pid;
		C::t('#sanree_brand#forum_attachment_n')->insert('tid:'.$tid, $attach);
		C::t('#sanree_brand#forum_attachment')->update($attach['aid'], array('tid' => $tid, 'pid' => $pid, 'tableid' => getattachtableid($tid)));
		C::t('#sanree_brand#forum_attachment_unused')->delete($attach['aid']);
	}
	
}

function goods_setattachment($bid, $caidstr, $tid, $pid, $homeaid, $uid) {

	global $_G;
	$aids = explode("|", $caidstr);	

	$inaddstr = '';
	foreach($aids as $aid) {
	
		goods_srconvertunusedattach($aid, $tid, $pid, $uid, $_G['sr_attachnew'][$aid][description]);
		$inaddstr.= '[attach]'.$aid.'[/attach]'."\r\n";
		
	}
	$tidata = C::t('#sanree_brand#forum_post')->fetch_threadpost_by_tid_invisible($tid);
	$message = $tidata['message'];
	$message = preg_replace('/\[attachnews\]/is', $inaddstr, $message);
	$message = preg_replace('/\[poster\]/is', '[attach]'.$homeaid.'[/attach]', $message);
	C::t('#sanree_brand#forum_post')->update(0, $pid, array('message'=> $message, 'attachment' => 1), TRUE);

}

function goods_chkmodeend($result,$isshow = TRUE) {
	global $_G, $enddatetip;
	if (!$result['enddate']) return false;
	if (TIMESTAMP > $result['enddate']) {
	
		if ($isshow) {
			$url = 'forum.php?mod=viewthread&amp;tid='.$result['tid'];
			showmessage($enddatetip,$url);
		}
		return true;
	
	}
	return false;
} 
function goods_dsign($str, $length = 16){
	return substr(md5(getglobal('uid').$str.getglobal('authkey')), 0, ($length ? max(8, $length) : 16));
}

function goods_getforumimg($aid, $nocache = 0, $w = 140, $h = 140, $type = '') {
	global $_G;
	$key = goods_dsign($aid.'|'.$w.'|'.$h);
	return 'plugin.php?id=sanree_brand_goods&mod=image&aid='.$aid.'&size='.$w.'x'.$h.'&key='.rawurlencode($key).($nocache ? '&nocache=yes' : '').($type ? '&type='.$type : '');
}

function goods_gethome($goods) {
	global $_G;
	if (!$goods) {
		return 'static/image/common/nophoto.gif';
	}
	require_once libfile('function/post');
	loadcache('groupreadaccess');
	$tid = $_G['tid'] = intval($goods['tid']);
	$attachs =  getattach($goods['pid']);
	if ($attachs['attachs']['used']) {
		foreach($attachs['attachs']['used'] as $key => $value) {
			if ($value['aid'] == $goods['homeaid']) {
			
				return goods_getforumimg($value['aid'], 1, 300, 300, 'fixnone').'&ramdom='.random(5);
				
			}
		}
		return goods_getforumimg($attachs['attachs']['used'][0]['aid'], 1, 300, 300, 'fixnone').'&ramdom='.random(5);
	}
	return 'static/image/common/nophoto.gif';
}

function goods_fixthreadpic($aid, $ispic = 0){
	$pic = goods_getforumimg($aid, 0, 600, 0, 'fixnone');
	if ($ispic==1) return $pic;
	$picstr = '<img style="cursor:pointer;" id="aimg_'.$aid.'"  src="'.$pic.'" onclick="zoom(this, this.src)" onload="centerimg(this)" />';
	return $picstr;
}

function goods_shtmlspecialchars($string){
	return str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>') , $string);
}

function goods_brandgetburl($bid){
	global $_G;
	$config = $_G['cache']['plugin']['sanree_brand'];
	$is_rewrite = $config['is_rewrite'];
	$brand = C::t('#sanree_brand#sanree_brand_businesses')->fetch_first_bybid($bid);
	$group = C::t('#sanree_brand#sanree_brand_group')->get_by_groupid($brand[groupid]);
	if ($group[urlmod] == 1|| $config['isonepage'] ==1 ) {
		if ($is_rewrite) {
			$keylist = array('tid');
			$tid  = $bid;
			$urlitemmode = empty($config['urlitemmode']) ? "brand-item-{tid}.html": $config['urlitemmode'];
			foreach($keylist as $line) {
				$urlitemmode = str_replace("{".$line."}",$$line ,$urlitemmode);
			}
			return $urlitemmode;
		}
		return 'plugin.php?id=sanree_brand&mod=item&tid='.$bid;
	}
	return 'forum.php?mod=viewthread&amp;tid='.$brand[tid];
}

function goods_srshowsetting($setname, $varname, $value, $type = 'radio', $disabled = '', $hidden = 0, $comment = '', $extra = '', $setid = '', $nofaq = false) {

	global $_G;
	$s = "\n";
	$check = array();
	$check['disabled'] = $disabled ? ($disabled == 'readonly' ? ' readonly' : ' disabled') : '';
	$check['disabledaltstyle'] = $disabled ? ', 1' : '';

	$nocomment = false;

	if(isset($_G['showsetting_multi'])) {
		$hidden = 0;
		if(is_array($varname)) {
			$varnameid = '_'.str_replace(array('[', ']'), '_', $varname[0]).'|'.$_G['showsetting_multi'];
			$varname[0] = preg_replace('/\w+new/', 'multinew['.$_G['showsetting_multi'].'][\\0]', $varname[0]);
		} else {
			$varnameid = '_'.str_replace(array('[', ']'), '_', $varname).'|'.$_G['showsetting_multi'];
			$varname = preg_replace('/\w+new/', 'multinew['.$_G['showsetting_multi'].'][\\0]', $varname);
		}
	} else {
		$varnameid = '';
	}
	if($type == 'srimg') {
		if ($_G['setting']['version']=='X2') {
			require_once DISCUZ_ROOT.'./source/plugin/sanree_brand_goods/X2/function/function_upload.php';
			
			$swfconfig = getuploadconfig($_G['uid'], $_G['fid']);
			define(IMGDIR, 'source/plugin/sanree_brand_goods/X2/images/');
			$thisconfig= array();
			$thisconfig['jspath'] = 'source/plugin/sanree_brand_goods/X2/js/';
			$thisconfig['imgdir'] = 'source/plugin/sanree_brand_goods/X2/images/';
			$thisconfig['cookiepre'] = $_G[config][cookie][cookiepre];
			$thisconfig['cookiedomain'] = $_G[config][cookie][cookiedomain];
			$thisconfig['cookiepath'] = $_G[config][cookie][cookiepath];
			$thisconfig['file_types'] = $swfconfig[attachexts][ext];
			$thisconfig['file_types_description'] = $swfconfig[attachexts][depict];
						
		} else {
			require_once libfile('function/upload');
			$swfconfig = getuploadconfig($_G['uid'], $_G['fid']);
			define('IMGDIR', 'static/image/common');
			$thisconfig= array();
			$thisconfig['jspath'] = $_G['setting']['jspath'];
			$thisconfig['imgdir'] = IMGDIR;
			$thisconfig['cookiepre'] = $_G['config']['cookie']['cookiepre'];
			$thisconfig['cookiedomain'] = $_G['config']['cookie']['cookiedomain'];
			$thisconfig['cookiepath'] = $_G['config']['cookie']['cookiepath'];
			$thisconfig['file_types'] = $swfconfig['attachexts']['ext'];
			$thisconfig['file_types_description'] = $swfconfig['attachexts']['depict'];			
		}
		$thisconfig[realjspath] = 'source/plugin/sanree_brand_goods/X2/js/';
        $showload= empty($value['aids']) ? '' : 'setTimeout(function(){loadimg()},1000);';
		global $langs;

		$charset = CHARSET;
		$VERHASH = formhash();
		$TIMESTAMP = TIMESTAMP;
		$IMGDIR = IMGDIR;
		$C_CHARSET = C_CHARSET;
$s.= <<<SANREE
<style>.attswf{width:300px;}.atds{width:100px;text-align:left;}.atds input{width:80px;}.attpr{width:60px;}
.progressWrapper { overflow: hidden; width: 100%; }
.progressContainer { overflow: hidden; margin: 5px; padding: 4px; border: solid 1px #E8E8E8; background-color: #F7F7F7; }
.message { overflow: hidden; margin: 1em 0; padding: 10px 20px; border: solid 1px #FD9; background-color: #FFC; } /* Message */
.red { border: solid 1px #B50000; background-color: #FFEBEB; } /* Error */
.green { border: solid 1px #DDF0DD; background-color: #EBFFEB; } /* Current */
.blue { border: solid 1px #CEE2F2; background-color: #F0F5FF; } /* Complete */
.progressName { overflow: hidden; white-space: nowrap; width: 323px; height: 18px; text-align: left; font-weight: 700; color: #555; }
.progressBarInProgress, .progressBarComplete, .progressBarError { clear: both; margin-top: 2px; width: 0; height: 2px; background-color: blue; font-size: 0; }
.progressBarComplete { visibility: hidden; width: 100%; background-color: green; }
.progressBarError { visibility: hidden; width: 100%; background-color: red; }
.progressBarStatus { white-space: nowrap; margin-top: 2px; width: 337px; text-align: left; }
a.progressCancel { display: block; float: right; width: 14px; height: 14px; background: url({$IMGDIR}/cancelbutton.gif) no-repeat -14px 0; font-size: 0; }
	a.progressCancel:hover { background-position: 0 0; }
.swfupload { vertical-align: top; }
</style>
<tr><td class="lefttip" ><span>*</span><strong>$langs[post_picture]</strong></td><td><span id="spanButtonPlaceholder" >$langs[upload]</span></td>
</tr>
<tr>
<td colspan="2">
<div class="fieldset flash" id="fsUploadProgress"></div>
<div class="upfl">
<table cellpadding="0" cellspacing="0" border="0" width="100%" id="attach_tblheader" style="display: none">
<tr>
<td class="attswf">$langs[e_attach_insert]</td>
<td class="atds">$langs[description]</td>
<td class="attpr">$langs[post_ishome]</td>
<td class="attc"></td>
</tr>
</table>
<div class="fieldset flash" id="attachlist"></div>
</div>
</td>
</tr>	
<script type="text/javascript">		
var editorid = '';
var X2IMGDIR = '$IMGDIR';
var ATTACHNUM = {'imageused':0,'imageunused':0,'attachused':0,'attachunused':0}, ATTACHUNUSEDAID = new Array(), IMGUNUSEDAID = new Array();
</script>
<script type="text/javascript" src="{$_G[setting][jspath]}forum_post.js?$VERHASH" reload="1"></script>
<script type="text/javascript" src="$thisconfig[jspath]swfupload.js?$VERHASH" reload="1"></script>
<script type="text/javascript" src="$thisconfig[jspath]swfupload.queue.js?$VERHASH" reload="1"></script>
<script type="text/javascript" src="$thisconfig[realjspath]handlers{$C_CHARSET}.js?$VERHASH" reload="1"></script>
<script type="text/javascript" src="$thisconfig[jspath]fileprogress.js?$VERHASH" reload="1"></script>
<input type="hidden" name="posttime" id="posttime" value="$TIMESTAMP" />
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
progress.setStatus("$langs[cancel]");
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
var upload = new SWFUpload({
upload_url: "$_G[siteurl]misc.php?mod=swfupload&action=swfupload&operation=upload&fid=$_G[fid]",
post_params: {"uid" : "$_G[uid]", "hash":"$swfconfig[hash]"},
file_size_limit : "$swfconfig[max]",
file_types : "$thisconfig[file_types]",
file_types_description : "$thisconfig[file_types_description]",
file_upload_limit : $swfconfig[limit],
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
button_image_url : "$thisconfig[imgdir]/uploadbutton.png",
button_placeholder_id : "spanButtonPlaceholder",
button_width: 100,
button_height: 25,
button_cursor:SWFUpload.CURSOR.HAND,
button_window_mode: "transparent",
custom_settings : {
progressTarget : "fsUploadProgress",
uploadSource: 'forum',
uploadType: 'attach',
uploadFrom: 'fastpost'
},
debug: false
});
var charset = '$charset';
var cookiepre = '$thisconfig[cookiepre]',
cookiedomain = '$thisconfig[cookiedomain]', 
cookiepath = '$thisconfig[cookiepath]';
</script>
SANREE;

$s.= <<<SANREE
<script type="text/javascript" src="$thisconfig[jspath]forum_post.js?VERHASH" reload="1"></script>
<script language="javascript" reload="1">
function seditor_insertunit(key, text, textend, moveend, selappend) {
key ='';
if($(key + 'content')) {
	$(key + 'content').focus();
}
textend = isUndefined(textend) ? '' : textend;
moveend = isUndefined(textend) ? 0 : moveend;
selappend = isUndefined(selappend) ? 1 : selappend;

startlen = strlen(text);
endlen = strlen(textend);
if(!isUndefined($(key + 'content').selectionStart)) {
	if(selappend) {
		var opn = $(key + 'content').selectionStart + 0;
		if(textend != '') {
			text = text + $(key + 'content').value.substring($(key + 'content').selectionStart, $(key + 'content').selectionEnd) + textend;
		}
		$(key + 'content').value = $(key + 'content').value.substr(0, $(key + 'content').selectionStart) + text + $(key + 'content').value.substr($(key + 'content').selectionEnd);
		if(!moveend) {
			$(key + 'content').selectionStart = opn + strlen(text) - endlen;
			$(key + 'content').selectionEnd = opn + strlen(text) - endlen;
		}
	} else {
		text = text + textend;
		$(key + 'content').value = $(key + 'content').value.substr(0, $(key + 'content').selectionStart) + text + $(key + 'content').value.substr($(key + 'content').selectionEnd);
	}
} else if(document.selection && document.selection.createRange) {
	var sel = document.selection.createRange();
	if(!sel.text.length && $(key + 'content').sel) {
		sel = $(key + 'content').sel;
		$(key + 'content').sel = null;
	}
	if(selappend) {
		if(textend != '') {
			text = text + sel.text + textend;
		}
		sel.text = text.replace(/\\r?\\n/g, '\\r\\n');
		if(!moveend) {
			sel.moveStart('character', -endlen);
			sel.moveEnd('character', -endlen);
		}
		sel.select();
	} else {
		sel.text = text + textend;
	}
} else {
	$(key + 'content').value += text;
}
hideMenu(2);
if(BROWSER.ie) {
	doane();
}
}
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
var pid = "$value[pid]";
var tid = "$value[tid]";
function loadimg(){

var aid ="$value[aids]";
var homeaid = "$value[homeaid]";
ajaxget('plugin.php?id=sanree_brand_goods&mod=attachlist&aids=' + aid+'&homeaid='+homeaid+'&pid=' + pid+'&tid='+tid, 'attachlist');
$('attach_tblheader').style.display='block';

}
$showload
</script> 
SANREE;
		$readonly = $disabled ? 'readonly' : '';
		$s .= "<tr><td>".$setname."<td></tr>";
		$s .= "<tr><td colspan=\"2\"><textarea $readonly rows=\"6\" ".(!isset($_G['showsetting_multi']) ? "ondblclick=\"textareasize(this, 1)\"" : '')." onkeyup=\"textareasize(this, 0)\" name=\"$varname\" id=\"$varname\" cols=\"50\" class=\"tarea\" $extra>".dhtmlspecialchars($value['content'])."</textarea></td></tr>";
	
	} elseif($type == 'radio') {
		$value ? $check['true'] = "checked" : $check['false'] = "checked";
		$value ? $check['false'] = '' : $check['true'] = '';
		$check['hidden1'] = $hidden ? ' onclick="$(\'hidden_'.$setname.'\').style.display = \'\';"' : '';
		$check['hidden0'] = $hidden ? ' onclick="$(\'hidden_'.$setname.'\').style.display = \'none\';"' : '';
		$onclick = $disabled && $disabled == 'readonly' ? ' onclick="return false"' : ($extra ? $extra : '');
		$s .= '<ul onmouseover="altStyle(this'.$check['disabledaltstyle'].');">'.
			'<li'.($check['true'] ? ' class="checked"' : '').'><input class="radio" type="radio"'.($varnameid ? ' id="_v1_'.$varnameid.'"' : '').' name="'.$varname.'" value="1" '.$check['true'].$check['hidden1'].$check['disabled'].$onclick.'>&nbsp;'.cplang('yes').'</li>'.
			'<li'.($check['false'] ? ' class="checked"' : '').'><input class="radio" type="radio"'.($varnameid ? ' id="_v0_'.$varnameid.'"' : '').' name="'.$varname.'" value="0" '.$check['false'].$check['hidden0'].$check['disabled'].$onclick.'>&nbsp;'.cplang('no').'</li>'.
			'</ul>';
	} elseif($type == 'text' || $type == 'password' || $type == 'number') {
		$s .= '<input name="'.$varname.'" value="'.dhtmlspecialchars($value).'" type="'.$type.'" class="txt" '.$check['disabled'].' '.$extra.' />';
	} elseif($type == 'htmltext') {
		$id .= 'html'.random(2);
		$s .= '<div id="'.$id.'">'.$value.'</div><input id="'.$id.'_v" name="'.$varname.'" value="'.dhtmlspecialchars($value).'" type="hidden" /><script type="text/javascript">sethtml(\''.$id.'\')</script>';
	} elseif($type == 'file') {
		$s .= '<input name="'.$varname.'" value="" type="file" class="txt uploadbtn marginbot" '.$check['disabled'].' '.$extra.' />';
	} elseif($type == 'filetext') {
		$defaulttype = $value ? 1 : 0;
		$id = 'file'.random(2);
		$s .= '<input id="'.$id.'_0" style="display:'.($defaulttype ? 'none' : '').'" name="'.($defaulttype ? 'TMP' : '').$varname.'" value="" type="file" class="txt uploadbtn marginbot" '.$check['disabled'].' '.$extra.' />'.
			'<input id="'.$id.'_1" style="display:'.(!$defaulttype ? 'none' : '').'" name="'.(!$defaulttype ? 'TMP' : '').$varname.'" value="'.dhtmlspecialchars($value).'" type="text" class="txt marginbot" '.$extra.' /><br />'.
			'<a id="'.$id.'_0a" style="'.(!$defaulttype ? 'font-weight:bold' : '').'" href="javascript:;" onclick="$(\''.$id.'_1a\').style.fontWeight = \'\';this.style.fontWeight = \'bold\';$(\''.$id.'_1\').name = \'TMP'.$varname.'\';$(\''.$id.'_0\').name = \''.$varname.'\';$(\''.$id.'_0\').style.display = \'\';$(\''.$id.'_1\').style.display = \'none\'">'.cplang('switch_upload').'</a>&nbsp;'.
			'<a id="'.$id.'_1a" style="'.($defaulttype ? 'font-weight:bold' : '').'" href="javascript:;" onclick="$(\''.$id.'_0a\').style.fontWeight = \'\';this.style.fontWeight = \'bold\';$(\''.$id.'_0\').name = \'TMP'.$varname.'\';$(\''.$id.'_1\').name = \''.$varname.'\';$(\''.$id.'_1\').style.display = \'\';$(\''.$id.'_0\').style.display = \'none\'">'.cplang('switch_url').'</a>';
	} elseif($type == 'textarea') {
		$readonly = $disabled ? 'readonly' : '';
		$s .= "<textarea $readonly rows=\"6\" ".(!isset($_G['showsetting_multi']) ? "ondblclick=\"textareasize(this, 1)\"" : '')." onkeyup=\"textareasize(this, 0)\" name=\"$varname\" id=\"$varname\" cols=\"50\" class=\"tarea\" $extra>".dhtmlspecialchars($value)."</textarea>";
	} elseif($type == 'select') {
		$s .= '<select name="'.$varname[0].'" '.$extra.'>';
		foreach($varname[1] as $option) {
			if(!array_key_exists(0, $option)) {
				$option = array_values($option);
			}
			$selected = $option[0] == $value ? 'selected="selected"' : '';
			if(empty($option[2])) {
				$s .= "<option value=\"$option[0]\" $selected>".$option[1]."</option>\n";
			} else {
				$s .= "<optgroup label=\"".$option[1]."\"></optgroup>\n";
			}
		}
		$s .= '</select>';
	} elseif($type == 'mradio' || $type == 'mradio2') {
		$nocomment = $type == 'mradio2' && !isset($_G['showsetting_multi']) ? true : false;
		$addstyle = $nocomment ? ' style="float: left; width: 18%"' : '';
		$ulstyle = $nocomment ? ' style="width: 790px"' : '';
		if(is_array($varname)) {
			$radiocheck = array($value => ' checked');
			$s .= '<ul'.(empty($varname[2]) ?  ' class="nofloat"' : '').' onmouseover="altStyle(this'.$check['disabledaltstyle'].');"'.$ulstyle.'>';
			foreach($varname[1] as $varary) {
				if(is_array($varary) && !empty($varary)) {
					if(!array_key_exists(0, $varary)) {
						$varary = array_values($varary);
					}
					$onclick = '';
					if(!isset($_G['showsetting_multi']) && !empty($varary[2])) {
						foreach($varary[2] as $ctrlid => $display) {
							$onclick .= '$(\''.$ctrlid.'\').style.display = \''.$display.'\';';
						}
					}
					$onclick && $onclick = ' onclick="'.$onclick.'"';
					$s .= '<li'.($radiocheck[$varary[0]] ? ' class="checked"' : '').$addstyle.'><input class="radio" type="radio"'.($varnameid ? ' id="_v'.md5($varary[0]).'_'.$varnameid.'"' : '').' name="'.$varname[0].'" value="'.$varary[0].'"'.$radiocheck[$varary[0]].$check['disabled'].$onclick.'>&nbsp;'.$varary[1].'</li>';
				}
			}
			$s .= '</ul>';
		}
	} elseif($type == 'mcheckbox' || $type == 'mcheckbox2') {
		$nocomment = $type != 'mcheckbox2' && count($varname[1]) > 3 && !isset($_G['showsetting_multi']) ? true : false;
		$addstyle = $nocomment ? ' style="float: left;'.(empty($_G['showsetting_multirow']) ? ' width: 18%' : '').'"' : '';
		$ulstyle = $nocomment && empty($_G['showsetting_multirow']) ? ' style="width: 790px"' : '';
		$s .= '<ul class="nofloat" onmouseover="altStyle(this'.$check['disabledaltstyle'].');"'.$ulstyle.'>';
		foreach($varname[1] as $varary) {
			if(is_array($varary) && !empty($varary)) {
				if(!array_key_exists(0, $varary)) {
					$varary = array_values($varary);
				}
				$onclick = !isset($_G['showsetting_multi']) && !empty($varary[2]) ? ' onclick="$(\''.$varary[2].'\').style.display = $(\''.$varary[2].'\').style.display == \'none\' ? \'\' : \'none\';"' : '';
				$checked = is_array($value) && in_array($varary[0], $value) ? ' checked' : '';
				$s .= '<li'.($checked ? ' class="checked"' : '').$addstyle.'><input class="checkbox" type="checkbox"'.($varnameid ? ' id="_v'.md5($varary[0]).'_'.$varnameid.'"' : '').' name="'.$varname[0].'[]" value="'.$varary[0].'"'.$checked.$check['disabled'].$onclick.'>&nbsp;'.$varary[1].'</li>';
			}
		}
		$s .= '</ul>';
	} elseif($type == 'binmcheckbox') {
		$checkboxs = count($varname[1]);
		$value = sprintf('%0'.$checkboxs.'b', $value);$i = 1;
		$s .= '<ul class="nofloat" onmouseover="altStyle(this'.$check['disabledaltstyle'].');">';
		foreach($varname[1] as $key => $var) {
			if($var !== false) {
				$s .= '<li'.($value{$checkboxs - $i} ? ' class="checked"' : '').'><input class="checkbox" type="checkbox"'.($varnameid ? ' id="_v'.md5($i).'_'.$varnameid.'"' : '').' name="'.$varname[0].'['.$i.']" value="1"'.($value{$checkboxs - $i} ? ' checked' : '').' '.(!empty($varname[2][$key]) ? $varname[2][$key] : '').'>&nbsp;'.$var.'</li>';
			}
			$i++;
		}
		$s .= '</ul>';
	} elseif($type == 'omcheckbox') {
		$nocomment = count($varname[1]) > 3 ? true : false;
		$addstyle = $nocomment ? 'style="float: left; width: 18%"' : '';
		$ulstyle = $nocomment ? 'style="width: 790px"' : '';
		$s .= '<ul onmouseover="altStyle(this'.$check['disabledaltstyle'].');"'.(empty($varname[2]) ? ' class="nofloat"' : 'class="ckbox"').' '.$ulstyle.'>';
		foreach($varname[1] as $varary) {
			if(is_array($varary) && !empty($varary)) {
				$checked = is_array($value) && $value[$varary[0]] ? ' checked' : '';
				$s .= '<li'.($checked ? ' class="checked"' : '').' '.$addstyle.'><input class="checkbox" type="checkbox" name="'.$varname[0].'['.$varary[0].']" value="'.$varary[2].'"'.$checked.$check['disabled'].'>&nbsp;'.$varary[1].'</li>';
			}
		}
		$s .= '</ul>';
	} elseif($type == 'mselect') {
		$s .= '<select name="'.$varname[0].'" multiple="multiple" size="10" '.$extra.'>';
		foreach($varname[1] as $option) {
			if(!array_key_exists(0, $option)) {
				$option = array_values($option);
			}
			$selected = is_array($value) && in_array($option[0], $value) ? 'selected="selected"' : '';
			if(empty($option[2])) {
				$s .= "<option value=\"$option[0]\" $selected>".$option[1]."</option>\n";
			} else {
				$s .= "<optgroup label=\"".$option[1]."\"></optgroup>\n";
			}
		}
		$s .= '</select>';
	} elseif($type == 'color') {
		global $stylestuff;
		$preview_varname = str_replace('[', '_', str_replace(']', '', $varname));
		$code = explode(' ', $value);
		$css = '';
		for($i = 0; $i <= 1; $i++) {
			if($code[$i] != '') {
				if($code[$i]{0} == '#') {
					$css .= strtoupper($code[$i]).' ';
				} elseif(preg_match('/^http:\/\//i', $code[$i])) {
					$css .= 'url(\''.$code[$i].'\') ';
				} else {
					$css .= 'url(\''.$stylestuff['imgdir']['subst'].'/'.$code[$i].'\') ';
				}
			}
		}
		$background = trim($css);
		$colorid = ++$GLOBALS['coloridcount'];
		$s .= "<input id=\"c{$colorid}_v\" type=\"text\" class=\"txt\" style=\"float:left; width:210px;\" value=\"$value\" name=\"$varname\" onchange=\"updatecolorpreview('c{$colorid}')\">\n".
			"<input id=\"c$colorid\" onclick=\"c{$colorid}_frame.location='static/image/admincp/getcolor.htm?c{$colorid}|c{$colorid}_v';showMenu({'ctrlid':'c$colorid'})\" type=\"button\" class=\"colorwd\" value=\"\" style=\"background: $background\"><span id=\"c{$colorid}_menu\" style=\"display: none\"><iframe name=\"c{$colorid}_frame\" src=\"\" frameborder=\"0\" width=\"210\" height=\"148\" scrolling=\"no\"></iframe></span>\n$extra";
	} elseif($type == 'calendar') {
		$s .= "<input type=\"text\" class=\"txt\" name=\"$varname\" value=\"".dhtmlspecialchars($value)."\" onclick=\"showcalendar(event, this".($extra ? ', 1' : '').")\">\n";
	} elseif(in_array($type, array('multiply', 'range', 'daterange'))) {
		$onclick = $type == 'daterange' ? ' onclick="showcalendar(event, this)"' : '';
		if(isset($_G['showsetting_multi'])) {
			$varname[1] = preg_replace('/\w+new/', 'multinew['.$_G['showsetting_multi'].'][\\0]', $varname[1]);
		}
		$s .= "<input type=\"text\" class=\"txt\" name=\"$varname[0]\" value=\"".dhtmlspecialchars($value[0])."\" style=\"width: 108px; margin-right: 5px;\"$onclick>".($type == 'multiply' ? ' X ' : ' -- ')."<input type=\"text\" class=\"txt\" name=\"$varname[1]\" value=\"".dhtmlspecialchars($value[1])."\"class=\"txt\" style=\"width: 108px; margin-left: 5px;\"$onclick>";
	} else {
		$s .= $type;
	}
	$name = cplang($setname);
	$name .= $name && substr($name, -1) != ':' ? ':' : '';
	$name = $disabled ? '<span class="lightfont">'.$name.'</span>' : $name;
	$setid = !$setid ? substr(md5($setname), 0, 4) : $setid;
	$setid = isset($_G['showsetting_multi']) ? 'S'.$setid : $setid;
	if(!empty($_G['showsetting_multirow'])) {
		if(empty($_G['showsetting_multirow_n'])) {
			echo '<tr>';
		}
		echo '<td class="vtop rowform"><p class="td27m">'.$name.'</p>'.$s.'</td>';
		$_G['showsetting_multirow_n']++;
		if($_G['showsetting_multirow_n'] == 2) {
			if(empty($_G['showsetting_multirow_n'])) {
				echo '</tr>';
			}
			$_G['showsetting_multirow_n'] = 0;
		}
		return;
	}
	if(!isset($_G['showsetting_multi'])) {
		if(!$nofaq) {
			$faqurl = 'http://faq.comsenz.com?type=admin&ver='.$_G['setting']['version'].'&action='.rawurlencode($_GET['action']).'&operation='.rawurlencode($_GET['operation']).'&key='.rawurlencode($setname);
			///showtablerow('onmouseover="setfaq(this, \'faq'.$setid.'\')"', 'colspan="2" class="td27" s="1"', $name.'<a id="faq'.$setid.'" class="faq" title="'.cplang('setting_faq_title').'" href="'.$faqurl.'" target="_blank" style="display:none">&nbsp;&nbsp;&nbsp;</a>');
		} else {
			showtablerow('', 'colspan="2" class="td27" s="1"', $name);
		}
	} else {
		if(empty($_G['showsetting_multijs'])) {
			$_G['setting_JS'] .= 'var ss = new Array();';
			$_G['showsetting_multijs'] = 1;
		}
		if($_G['showsetting_multi'] == 0) {
			showtablerow('', array('class="td27"'), array('<div id="D'.$setid.'"></div>'));
			$_G['setting_JS'] .= 'ss[\'D'.$setid.'\'] = new Array();';
		}
		$name = preg_replace("/\r\n|\n|\r/", '\n', addcslashes($name, "'\\"));
		$_G['setting_JS'] .= 'ss[\'D'.$setid.'\'] += \'<div class="multicol">'.$name.'</div>\';';
	}
	if(!$nocomment && ($type != 'omcheckbox' || $varname[2] != 'isfloat')) {
		if(!isset($_G['showsetting_multi'])) {
			showtablerow('class="noborder" onmouseover="setfaq(this, \'faq'.$setid.'\')"', array('class="vtop rowform"', 'class="vtop tips2" s="1"'), array(
				$s,
				($comment ? $comment : cplang($setname.'_comment', false)).($type == 'textarea' ? '<br />'.cplang('tips_textarea') : '').
				($disabled ? '<br /><span class="smalltxt" style="color:#F00">'.cplang($setname.'_disabled', false).'</span>' : NULL)
			));
		} else {
			if($_G['showsetting_multi'] == 0) {
				showtablerow('class="noborder"', array('class="vtop rowform" style="width:auto"'), array(
					'<div id="'.$setid.'"></div>'
				));
				$_G['setting_JS'] .= 'ss[\''.$setid.'\'] = new Array();';
			}
			$s = preg_replace("/\r\n|\n|\r/", '\n', addcslashes($s, "'\\"));
			$_G['setting_JS'] .= 'ss[\''.$setid.'\'] += \'<div class="multicol">'.$s.'</div>\';';
		}
	} else {
		///showtablerow('class="noborder" onmouseover="setfaq(this, \'faq'.$setid.'\')"', array('colspan="2" class="vtop rowform"'), array($s));
	}

	if($hidden) {
		showtagheader('tbody', 'hidden_'.$setname, $value, 'sub');
	}

}
//www-FX8-co
?>