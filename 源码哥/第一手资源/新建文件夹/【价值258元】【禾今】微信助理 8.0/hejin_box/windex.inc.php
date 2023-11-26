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
if(submitcheck('add_fl')){
	if($_POST['type']){
		$fldata = array();
		$fldata['type']	= intval($_POST['type']);	
		$fldata['title'] = addslashes($_POST['title']);
		if($_POST['content']){
			$fldata['content'] = addslashes($_POST['content']);
		}	
		$fldata['pic'] = addslashes($_POST['pic']);
		if($_POST['url']){
			$fldata['url'] = addslashes($_POST['url']);
		}	
		$fldata['sort']	= intval($_POST['sort']);	
		$fldata['isshow']= intval($_POST['isshow']);	
		if($_POST['listid']){
			$fldata['listid'] = intval($_POST['listid']);
		}	
		if($_POST['zid']){
			$fldata['zid'] = intval($_POST['zid']);
		}	
		if($_POST['showid']){
			$fldata['showid'] = intval($_POST['showid']);
		}	
		$addfl = C::t('#hejin_box#hjbox_wfl')->insert($fldata);
		if($addfl){
			if($_POST['type']==1){
				$okurl = 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=windex';
			}else{
				$okurl = 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=windex&model=dbdh';
			}
			cpmsg(lang('plugin/hejin_box', 'addstok'), $okurl, 'succeed');
		}
	}

}
if(submitcheck('edit_fl')){
	if($_POST['id']){
		$id = intval($_POST['id']);
		$info = C::t('#hejin_box#hjbox_wfl')->fetch_by_id($id);
		if(count($info)){
			$upfldata = array();
			$upfldata['title'] =  addslashes($_POST['title']);
			if($_POST['content']){
				$upfldata['content'] =  addslashes($_POST['content']);
			}
			$upfldata['pic'] = addslashes($_POST['pic']);
			if($_POST['url']){
				$upfldata['url'] = addslashes($_POST['url']);
			}	
			$upfldata['sort']	= intval($_POST['sort']);	
			$upfldata['isshow']= intval($_POST['isshow']);	
			if($_POST['listid']){
				$upfldata['listid'] = intval($_POST['listid']);
			}	
			if($_POST['showid']){
				$upfldata['showid'] = intval($_POST['showid']);
			}	

			$editfl = C::t('#hejin_box#hjbox_wfl')->update_by_id($id,$upfldata);
			if($editfl){
				if($info['type']==1){
					$okurl = 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=windex';
				}else{
					$okurl = 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=windex&model=dbdh';
				}
				cpmsg(lang('plugin/hejin_box', 'editstok'), $okurl, 'succeed');
			}
		}
	}
}

if(submitcheck('add_news')){
	if($_POST['fid']){
		$newsdata = array();
		$newsdata['fid'] = intval($_POST['fid']);
		$newsdata['title'] = addslashes($_POST['title']);
		$newsdata['text'] = addslashes($_POST['text']);
		if($_POST['pic']){
			$newsdata['pic'] = addslashes($_POST['pic']);
		}
		if($_POST['content']){
			$newsdata['content'] = addslashes($_POST['content']);
		}
		if($_POST['url']){
			$newsdata['url'] = addslashes($_POST['url']);
		}
		$newsdata['sort'] = intval($_POST['sort']);
		$newsdata['istj'] = intval($_POST['istj']);
		$newsdata['add_time'] = time();
		$addnews = C::t('#hejin_box#hjbox_news')->insert($newsdata);
		if($addnews){
			$okurl = 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=windex';
			cpmsg(lang('plugin/hejin_box', 'addstok'), $okurl, 'succeed');
		}
	}
}

if(submitcheck('edit_news')){
	if($_POST['id']){
		$id = intval($_POST['id']);
		$fid = intval($_POST['fid']);
		$newsdata = array();
		$newsdata['title'] = addslashes($_POST['title']);
		$newsdata['text'] = addslashes($_POST['text']);
		if($_POST['pic']){
			$newsdata['pic'] = addslashes($_POST['pic']);
		}
		if($_POST['content']){
			$newsdata['content'] = addslashes($_POST['content']);
		}
		if($_POST['url']){
			$newsdata['url'] = addslashes($_POST['url']);
		}
		$newsdata['sort'] = intval($_POST['sort']);
		$newsdata['istj'] = intval($_POST['istj']);
		$editnews = C::t('#hejin_box#hjbox_news')->update_by_id($id,$newsdata);
		if($editnews){
				$okurl = 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=windex&model=news&fid='.$fid;
				cpmsg(lang('plugin/hejin_box', 'editstok'), $okurl, 'succeed');
		}
	}
}

if(empty($model)){
	$wfles = C::t('#hejin_box#hjbox_wfl')->fetch_fl_all();
	include template('hejin_box:admin/wfenlei');
}

else if($model == 'addfla'){
	include template('hejin_box:admin/addfla');
}
else if($model == 'addflb'){
	include template('hejin_box:admin/addflb');
}
else if($model == 'addflc'){
	if($_GET['zid']){
		$zid = intval($_GET['zid']);
	}
	include template('hejin_box:admin/addflc');
}
else if($model == 'editfl'){
	if($_GET['id']){
		$id = intval($_GET['id']);
		$flinfo = C::t('#hejin_box#hjbox_wfl')->fetch_by_id($id);
		if($flinfo['url']){
			include template('hejin_box:admin/editfla');
		}else{
			include template('hejin_box:admin/editflb');
		}
	}
}
else if($model == 'editflc'){
	if($_GET['id']){
		$id = intval($_GET['id']);
		$flinfo = C::t('#hejin_box#hjbox_wfl')->fetch_by_id($id);
		include template('hejin_box:admin/editflc');
	}
}

else if($model == 'delfl'){
	if($_GET['formhash']==formhash()){
		if($_GET['id']){
			$id = intval($_GET['id']);
			$flinfo = C::t('#hejin_box#hjbox_wfl')->fetch_by_id($id);
			if($flinfo['url']){
				$isdel = 1;	
			}else{
				$newses = C::t('#hejin_box#hjbox_news')->fetch_fid_all($id);
				if(count($newses)){
					$isdel = 0;	
				}else{
					$isdel = 1;	
				}
			}
			if($isdel){
				$delfl = C::t('#hejin_box#hjbox_wfl')->delete_by_id($id);
				if($delfl){
					$okurl = 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=windex';
					cpmsg(lang('plugin/hejin_box', 'delstok'), $okurl, 'succeed');
				}
			}else{
				$nourl = 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=windex';
				cpmsg(lang('plugin/hejin_box', 'delflno'), $nourl, 'error');
			}
		}
	}
}


else if($model == 'dbdh'){
	$wdbdhes = C::t('#hejin_box#hjbox_wfl')->fetch_dbdh_all();
	include template('hejin_box:admin/wdbdh');
}
else if($model == 'addnews'){
	if($_GET['fid']){
		$fid = intval($_GET['fid']);
		$flinfo = C::t('#hejin_box#hjbox_wfl')->fetch_by_id($fid);
		include template('hejin_box:admin/addnews');
	}
}

else if($model == 'news'){
	if($_GET['fid']){
		$fid = intval($_GET['fid']);
		$flinfo = C::t('#hejin_box#hjbox_wfl')->fetch_by_id($fid);
		$newses = C::t('#hejin_box#hjbox_news')->fetch_fid_all($fid);
		include template('hejin_box:admin/newslist');
	}
}

else if($model == 'editnews'){
	if($_GET['nid']){
		$nid = intval($_GET['nid']);
		$newsinfo = C::t('#hejin_box#hjbox_news')->fetch_by_id($nid);
		$flinfo = C::t('#hejin_box#hjbox_wfl')->fetch_by_id(intval($newsinfo['fid']));
		include template('hejin_box:admin/editnews');
	}
}

elseif($model=='delnews'){
	if($_GET['formhash']==formhash()){
		$nid = intval($_GET['nid']);
		$fid = intval($_GET['fid']);
		if($nid){
			$delnews = C::t('#hejin_box#hjbox_news')->delete_by_id($nid);
			if($delnews){
				$url = 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=windex&model=news&fid='.$fid;
				cpmsg(lang('plugin/hejin_box', 'delstok'), $url, 'succeed');	
			}	
		}
	}
}

//WWW.fx8.cc
?>