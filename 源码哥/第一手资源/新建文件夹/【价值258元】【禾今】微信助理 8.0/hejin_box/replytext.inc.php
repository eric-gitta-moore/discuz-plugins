<?php
/*
 * 出处：源码哥
 * 官网: Www.fx8.cc
 * 备用网址: www.ymg6.com (请收藏备用!)
 * 技术支持/更新维护：QQ 154606914
 * 
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require_once DISCUZ_ROOT.'./source/plugin/hejin_box/config.inc.php';
$model = addslashes($_GET['model']);
if(submitcheck('add_reply')){
	$type = intval($_POST['type']);
	if($type){
		$replydata = array();
		$replydata['type'] = $type;
		$replydata['keywords'] = addslashes($_POST['keywords']);
		$replydata['title'] = addslashes($_POST['title']);
		$replydata['pic'] = addslashes($_POST['pic']);
		$replydata['content'] = addslashes($_POST['content']);
		$replydata['url'] = addslashes($_POST['url']);
		$replydata['state'] = intval($_POST['state']);
		$replydata['sort'] = intval($_POST['sort']);
		$replydata['is_openid'] = intval($_POST['is_openid']);
		$replydata['add_time'] = time();
		$addreply = C::t('#hejin_box#hjbox_replys')->insert($replydata);
		if($addreply){
			if($type==1){
				$url = 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=replytext';
			}else{
				$url = 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=replytext';
			}
			cpmsg(lang('plugin/hejin_box', 'addstok'), $url, 'succeed');	
		}
	}
}

if(submitcheck('edit_reply')){
	$rid = intval($_POST['rid']);
	$type = intval($_POST['type']);
	if($rid){
		$replydata = array();
		$replydata['keywords'] = addslashes($_POST['keywords']);
		$replydata['title'] = addslashes($_POST['title']);
		$replydata['pic'] = addslashes($_POST['pic']);
		$replydata['content'] = addslashes($_POST['content']);
		$replydata['url'] = addslashes($_POST['url']);
		$replydata['state'] = intval($_POST['state']);
		$replydata['sort'] = intval($_POST['sort']);
		$replydata['is_openid'] = intval($_POST['is_openid']);
		$editreply = C::t('#hejin_box#hjbox_replys')->update_by_id($rid,$replydata);

			if($type==1){
				$url = 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=replytext';
			}else{
				$url = 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=replytext';
			}

		if($editreply){
			cpmsg(lang('plugin/hejin_box', 'editstok'), $url, 'succeed');	
		}else{
			cpmsg(lang('plugin/hejin_box', 'editstok'), $url, 'succeed');	
		}
	}
}


if(empty($model)){
	$replyes = C::t('#hejin_box#hjbox_replys')->fetch_text_all();
	include template('hejin_box:admin/textreply');
}

elseif($model=='img'){
	$replyes = C::t('#hejin_box#hjbox_replys')->fetch_img_all();
	include template('hejin_box:admin/imgreply');
}

elseif($model=='addimg'){
	include template('hejin_box:admin/addimg');
}
elseif($model=='editimg'){
	$rid = intval($_GET['rid']);
	if($rid){
		$reply = C::t('#hejin_box#hjbox_replys')->fetch_by_id($rid);
		include template('hejin_box:admin/editimg');
	}
}


elseif($model=='text'){
	$replyes = C::t('#hejin_box#hjbox_replys')->fetch_text_all();
	include template('hejin_box:admin/textreply');
}

elseif($model=='addtext'){
	include template('hejin_box:admin/addtext');
}
elseif($model=='edittext'){
	$rid = intval($_GET['rid']);
	if($rid){
		$reply = C::t('#hejin_box#hjbox_replys')->fetch_by_id($rid);
		include template('hejin_box:admin/edittext');
	}
}



elseif($model=='del'){
	if($_GET['formhash']==formhash()){
		$rid = intval($_GET['rid']);
		if($rid){
			$delreply = C::t('#hejin_box#hjbox_replys')->delete_by_id($rid);
			if($delreply){
				$url = 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=replytext';
				cpmsg(lang('plugin/hejin_box', 'delstok'), $url, 'succeed');	
			}	
		}
	}
}

//WWW.fx8.cc
?>