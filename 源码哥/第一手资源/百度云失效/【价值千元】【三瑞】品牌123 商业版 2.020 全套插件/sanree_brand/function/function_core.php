<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: function_core.php 2014-07-29 10:20:00 sanree checkedby fx8.cc $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}
$_G['setting']['plugins']['func'][HOOKTYPE]['sanreedomain'] =1;

function attention_information($id, $flag) {

	global $_G;
	$config = $_G['cache']['plugin']['sanree_attention'];
	if(!$config){
		$attentionplugin = C::t('#sanree_brand#common_plugin')->fetch_by_identifier('sanree_attention');
		$open = C::t('#sanree_brand#common_pluginvar')->fetch_all_by_pluginid($attentionplugin['pluginid']);
		if($open[0]['variable'] == 'isopen'){
			$config['isopen'] = $open[0]['value'];
		}
	}
	if($config['isopen']){
		if(in_array($flag, array('goods' , 'news', 'coupon', 'jobs', 'video'))) {
			$ids = array();
			if (!is_array($id)) {
				$ids[] = $id;
			}
			else {
				$ids = $id;
			}
			foreach ($ids as $value) {
				switch($flag){
					case 'goods':
						$row = C::t('#sanree_brand_goods#sanree_brand_goods')->fetch_first_bygid($value);
						$nameturl = 'plugin.php?id=sanree_brand_goods&mod=goodsshow&tid='.$row['gid'];
						break;
					case 'news':
						$row = C::t('#sanree_brand_news#sanree_brand_news')->fetch_first_bynid($value);
						$nameturl = 'plugin.php?id=sanree_brand_news&mod=newsshow&tid='.$row['nid'];
						break;
					case 'coupon':
						$row = C::t('#sanree_brand_coupon#sanree_brand_coupon')->fetch_first_bycid($value);
						$nameturl = 'plugin.php?id=sanree_brand_coupon&mod=couponshow&tid='.$row['cid'];
						break;
					case 'jobs':
						$row = C::t('#sanree_brand_jobs#sanree_brand_jobs')->fetch_first_byjid($value);
						$nameturl = 'plugin.php?id=sanree_brand_jobs&mod=jobsshow&tid='.$row['jid'];
						break;
					case 'video':
						$row = C::t('#sanree_brand_video#sanree_brand_video')->fetch_first_bycid($value);
						$nameturl = 'plugin.php?id=sanree_brand_video&mod=videoshow&tid='.$row['cid'];
						break;
					default:
						$row = C::t('#sanree_brand#sanree_brand_businesses')->fetch_first_bybid($value);
						break;
				}
				
				if ($row) {
					
					if($flag == 'jobs'){
						$name = $row['title'];
					}else{
						$name = $row['name'];
					}
					$brand = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($row['bid']);
					$welcomformat = lang('plugin/sanree_attention', $flag);
					
					$turl = getburl($brand);
					$brandnametxt = '<a href="'.$turl.'">'.addslashes($brand['name']).'</a>';
					
					$nametxt = '<a href="'.$nameturl.'">'.addslashes($name).'</a>';
					$timetxt = dgmdate(TIMESTAMP);					
					
					$uids = C::t('#sanree_attention#sanree_attention')->getuid_by_bid($row['bid']);
					if($uids){
						foreach($uids as $uid){
							$username = C::t('#sanree_brand#xcommon_member')->fetch_all_username_by_uid($uid['uid']);
							$usertxt = '<a href="home.php?mod=space&amp;uid='.$uid['uid'].'">'.$username.'</a>';
							$welcomemsgtxt = str_replace('{user}', $usertxt, $welcomformat);
							$welcomemsgtxt = str_replace('{brand}', $brandnametxt, $welcomemsgtxt);
							$welcomemsgtxt = str_replace('{'.$flag.'}', $nametxt, $welcomemsgtxt);
							$welcomemsgtxt = str_replace('{time}', $timetxt, $welcomemsgtxt);
							$welcomemsgtxt = nl2br(str_replace(':', '&#58;', $welcomemsgtxt));
							@notification_addex($uid['uid'], 'system', $welcomemsgtxt, array(), 1);
						}
					}
				}
			
			}
		}
		
	}
	
	return $config;
	
}

function sanree_brand_multi($num, $perpage, $curpage, $mpurl, $maxpages = 0, $page = 10, $autogoto = FALSE, $simple = FALSE, $jsfunc = FALSE) {
		global $_G;
		$ajaxtarget = !empty($_GET['ajaxtarget']) ? " ajaxtarget=\"".dhtmlspecialchars($_GET['ajaxtarget'])."\" " : '';

		$a_name = '';
		if(strpos($mpurl, '#') !== FALSE) {
			$a_strs = explode('#', $mpurl);
			$mpurl = $a_strs[0];
			$a_name = '#'.$a_strs[1];
		}
		if($jsfunc !== FALSE) {
			$mpurl = 'javascript:'.$mpurl;
			$a_name = $jsfunc;
			$pagevar = '';
		} else {
			$pagevar = 'page=';
		}

		if(defined('IN_ADMINCP')) {
			$shownum = $showkbd = TRUE;
			$showpagejump = FALSE;
			$lang['prev'] = '&lsaquo;&lsaquo;';
			$lang['next'] = '&rsaquo;&rsaquo;';
		} else {
			$shownum = $showkbd = FALSE;
			$showpagejump = TRUE;
			if(defined('IN_MOBILE') && !defined('TPL_DEFAULT')) {
				$lang['prev'] = lang('core', 'prevpage');
				$lang['next'] = lang('core', 'nextpage');
			} else {
				$lang['prev'] = '<b></b>';
				$lang['next'] = '<b></b>';
			}
			$lang['pageunit'] = lang('plugin/sanree_brand', 'pageunit');
			$lang['total'] = lang('core', 'total');
			$lang['pagejumptip'] = lang('core', 'pagejumptip');
		}
		if(defined('IN_MOBILE') && !defined('TPL_DEFAULT')) {
			$dot = '..';
			$page = intval($page) < 10 && intval($page) > 0 ? $page : 4 ;
		} else {
			$dot = '...';
		}
		$multipage = '';
		if($jsfunc === FALSE) {
			$mpurl .= strpos($mpurl, '?') !== FALSE ? '&amp;' : '?';
		}

		$realpages = 1;
		$_G['page_next'] = 0;
		$page -= strlen($curpage) - 1;
		if($page <= 0) {
			$page = 1;
		}
		if($num > $perpage) {

			$offset = floor($page * 0.5);

			$realpages = @ceil($num / $perpage);
			$curpage = $curpage > $realpages ? $realpages : $curpage;
			$pages = $maxpages && $maxpages < $realpages ? $maxpages : $realpages;

			if($page > $pages) {
				$from = 1;
				$to = $pages;
			} else {
				$from = $curpage - $offset;
				$to = $from + $page - 1;
				if($from < 1) {
					$to = $curpage + 1 - $from;
					$from = 1;
					if($to - $from < $page) {
						$to = $page;
					}
				} elseif($to > $pages) {
					$from = $pages - $page + 1;
					$to = $pages;
				}
			}
			$_G['page_next'] = $to;
			$multipage = ($curpage - $offset > 1 && $pages > $page ? '<a href="'.$mpurl.$pagevar.'1'.$a_name.'" class="first"'.$ajaxtarget.'>1 '.$dot.'</a>' : '').
			($curpage > 1 && !$simple ? '<a href="'.$mpurl.$pagevar.($curpage - 1).$a_name.'" class="pagePrev"'.$ajaxtarget.'>'.$lang['prev'].'</a>' : '');
			for($i = $from; $i <= $to; $i++) {
				$multipage .= $i == $curpage ? '<a hideFocus class=selected btnmode="true">'.$i.'</a>' :
				'<a href="'.$mpurl.$pagevar.$i.($ajaxtarget && $i == $pages && $autogoto ? '#' : $a_name).'"'.$ajaxtarget.'>'.$i.'</a>';
			}
			$multipage .= ($to < $pages ? '<a href="'.$mpurl.$pagevar.$pages.$a_name.'" class="last"'.$ajaxtarget.'>'.$dot.'</a>' : '').
			($showpagejump && !$simple && !$ajaxtarget ? '<label><input class="isTxtBig w30" type="text" name="custompage" class="px" size="2" title="'.$lang['pagejumptip'].'" value="'.$curpage.'" onkeydown="if(event.keyCode==13) {window.location=\''.$mpurl.$pagevar.'\'+this.value; doane(event);}" /><span title="'.$lang['total'].' '.$pages.' '.$lang['pageunit'].'"> / '.$pages.' '.$lang['pageunit'].'</span></label>' : '').
			($curpage < $pages && !$simple ? '<a href="'.$mpurl.$pagevar.($curpage + 1).$a_name.'" class="pageNext"'.$ajaxtarget.'>'.$lang['next'].'</a>' : '').
			($showkbd && !$simple && $pages > $page && !$ajaxtarget ? '<kbd><input type="text" name="custompage" size="3" onkeydown="if(event.keyCode==13) {window.location=\''.$mpurl.$pagevar.'\'+this.value; doane(event);}" /></kbd>' : '');

			$multipage = $multipage ? '<div class="bigPage pt20 pb30 vm center">'.($shownum && !$simple ? '<em>&nbsp;'.$num.'&nbsp;</em>' : '').$multipage.'</div>' : '';
		}
		$maxpage = $realpages;
		return $multipage;
}
	
function syngroup($bid) {
    global $_G;
	$config = $_G['cache']['plugin']['sanree_brand'];
	if (intval($config['allowsyngroup'])!=1) return;
	$bids = array();
	if (!is_array($bid)) {
	
		$bids[] = $bid;
		
	}
	else {
	
		$bids = $bid;
		
	}
	$category = C::t('#sanree_brand#sanree_brand_category')->fetch_all_category();
	$cates = array();
	foreach($category as $v) {
	
		$cates[$v[cateid]] = $v;
		
	}	
	require_once libfile('function/group');	
	foreach ($bids as $ibid) {
	
		$lastdata = C::t('#sanree_brand#sanree_brand_businesses')->fetch_first_bybid($ibid);
		if (!$lastdata) continue;
		$group = C::t('#sanree_brand#sanree_brand_group')->get_by_groupid(intval($lastdata['groupid']));
		if (!$group) continue;
		if (intval($group['allowsyngroup'])!=1) continue;
		$lastdata['syngroupid'] = intval($cates[$lastdata['cateid']]['syngroupid']);
		if ($lastdata['syngroupid']<1) continue;
		$postgroup =  getgroupcache($lastdata['syngrouptid']);

		if ($lastdata['syngrouptid'] && $postgroup) {
		    $setarr = array();
			$setarr['name'] = $lastdata['name'];
			$setarr['parentid'] = $lastdata['syngroupid'];
			$setarr['fup'] = $lastdata['syngroupid'];
			$setarr['descriptionnew'] = '';
			$setarr['jointype'] =0;
			$setarr['gviewperm'] = 1;
			$setarr['bid'] = $lastdata['bid'];
			$setarr['uid'] = $lastdata['uid'];
			$setarr['username'] = $lastdata['username'];
			$setarr['fid'] = $lastdata['syngrouptid'];
			srupdategroup($setarr);
		} else {
		
		    $setarr = array();
			$setarr['name'] = $lastdata['name'];
			$setarr['parentid'] = $lastdata['syngroupid'];
			$setarr['fup'] = $lastdata['syngroupid'];
			$setarr['descriptionnew'] = '';
			$setarr['jointype'] =0;
			$setarr['gviewperm'] = 1;
			$setarr['bid'] = $lastdata['bid'];
			$setarr['uid'] = $lastdata['uid'];
			$setarr['username'] = $lastdata['username'];
			srcreategroup($setarr);
		}
	}
}
function srupdategroup($lastdata){
	global $_G;
	$lastdata['jointypenew'] = intval($lastdata['jointype']);
	$lastdata['fupnew'] = intval($lastdata['fup']);
	$lastdata['gviewpermnew'] = intval($lastdata['gviewperm']);
	$lastdata['descriptionnew'] = dhtmlspecialchars(censor(trim($lastdata['descriptionnew'])));
	$lastdata['namenew'] = dhtmlspecialchars(censor(trim($lastdata['name'])));
	$icondata = array();
	$fid = $lastdata['fid'];
	$group = C::t('#sanree_brand#forum_forum')->fetch_info_by_fid($lastdata['fid']);
	$iconnew = upload_icon_banner($group, $_FILES['iconnew'], 'icon');
	$bannernew = upload_icon_banner($group, $_FILES['bannernew'], 'banner');
	if($iconnew) {
		$icondata['icon'] = $iconnew;
	}
	if($bannernew) {
		$icondata['banner'] = $bannernew;
	};

	if($lastdata['deleteicon']) {
		@unlink($_G['setting']['attachurl'].'group/'.$group['icon']);
		$icondata['icon'] = '';
	}
	if($lastdata['deletebanner']) {
		@unlink($_G['setting']['attachurl'].'group/'.$group['banner']);
		$icondata['banner'] = '';
	}
	$groupdata = array_merge($icondata, array(
		'description' => $lastdata['descriptionnew'],
		'gviewperm' => $lastdata['gviewpermnew'],
		'jointype' => $lastdata['jointypenew'],
	));
	C::t('#sanree_brand#forum_forumfield')->update($fid, $groupdata);
	$setarr = array();
	if($lastdata['fupnew']) {
		$setarr['fup'] = $lastdata['fupnew'];
	}
	if($lastdata['namenew'] && $lastdata['namenew'] != $group['name'] && C::t('#sanree_brand#forum_forum')->fetch_fid_by_name($lastdata['namenew'])) {
		return;
	}
	$setarr['name'] = $lastdata['namenew'];
	C::t('#sanree_brand#forum_forum')->update($fid, $setarr);

	if(!empty($lastdata['fupnew']) && $lastdata['fupnew'] != $group['fup']) {
		C::t('#sanree_brand#forum_forumfield')->update_groupnum($lastdata['fupnew'], 1);
		C::t('#sanree_brand#forum_forumfield')->update_groupnum($group['fup'], -1);
		require_once libfile('function/cache');
		updatecache('grouptype');
	}

}

function srcreategroup($lastdata){
	global $_G;
	$parentid = intval($lastdata['parentid']);
	$fup = intval($lastdata['fup']);
	$name = censor(dhtmlspecialchars(cutstr(trim($lastdata['name']), 255, '')));
	$censormod = censormod($name);
	if(empty($name)) {
		return;
	} elseif($censormod) {
		return;
	} elseif(empty($parentid) && empty($fup)) {
		return;
	}
	if(empty($_G['cache']['grouptype']['first'][$parentid]) && empty($_G['cache']['grouptype']['second'][$fup])
		|| $_G['cache']['grouptype']['first'][$parentid]['secondlist'] &&  !in_array($_G['cache']['grouptype']['second'][$fup]['fid'], $_G['cache']['grouptype']['first'][$parentid]['secondlist'])) {

	}
	if(empty($fup)) {
		$fup = $parentid;
	}
	if(C::t('#sanree_brand#forum_forum')->fetch_fid_by_name($name)) {
		return;
	}
	require_once libfile('function/discuzcode');
	$descriptionnew = discuzcode(dhtmlspecialchars(censor(trim($lastdata['descriptionnew']))), 0, 0, 0, 0, 1, 1, 0, 0, 1);
	$censormod = censormod($descriptionnew);
	if($censormod) {
		return;
	}
	if(empty($_G['setting']['groupmod']) || $_G['adminid'] == 1) {
		$levelinfo = C::t('#sanree_brand#forum_grouplevel')->fetch_by_credits();
		$levelid = $levelinfo['levelid'];
	} else {
		$levelid = -1;
	}

	$newfid = C::t('#sanree_brand#forum_forum')->insert_group($fup, 'sub', $name, '3', $levelid);
	if($newfid) {
		$jointype = intval($lastdata['jointype']);
		$gviewperm = intval($lastdata['gviewperm']);
		$fieldarray = array('fid' => $newfid, 'description' => $descriptionnew, 'jointype' => $jointype, 'gviewperm' => $gviewperm, 'dateline' => TIMESTAMP, 'founderuid' => $lastdata['uid'], 'foundername' => $lastdata['username'], 'membernum' => 1);
		C::t('#sanree_brand#forum_forumfield')->insert($fieldarray);
		C::t('#sanree_brand#forum_forumfield')->update_groupnum($fup, 1);
		C::t('#sanree_brand#forum_groupuser')->insert($newfid, $lastdata['uid'], $lastdata['username'], 1, TIMESTAMP);
		require_once libfile('function/cache');
		updatecache('grouptype');
	}
	C::t('#sanree_brand#sanree_brand_businesses')->update($lastdata['bid'], array('syngrouptid'=>$newfid));
	include_once libfile('function/stat');
	updatestat('group');
	if($levelid == -1) {
		return true;
	}
	return true;

}
function deletecachebrandpic($bid){

	global $_G;
	$dw = 120;
	$dh = 85;
	$thumbfile = 'image/brand_'.$bid.'_'.$dw.'_'.$dh.'.jpg';
	if(file_exists($_G['setting']['attachdir'].$thumbfile)) {
		@unlink($_G['setting']['attachdir'].$thumbfile);
	}
	$dw = 322;
	$dh = 242;
	$thumbfile = 'image/brand_'.$bid.'_'.$dw.'_'.$dh.'.jpg';
	if(file_exists($_G['setting']['attachdir'].$thumbfile)) {
		@unlink($_G['setting']['attachdir'].$thumbfile);
	}
	$dw = 130;
	$dh = 98;
	$thumbfile = 'image/brand_'.$bid.'_'.$dw.'_'.$dh.'.jpg';
	if(file_exists($_G['setting']['attachdir'].$thumbfile)) {
		@unlink($_G['setting']['attachdir'].$thumbfile);
	}
	$dw = 210;
	$dh = 158;
	$thumbfile = 'image/brand_'.$bid.'_'.$dw.'_'.$dh.'.jpg';
	if(file_exists($_G['setting']['attachdir'].$thumbfile)) {
		@unlink($_G['setting']['attachdir'].$thumbfile);
	}			
	
}
function fixalbum($bid, $newuid=0){
    if ($newuid==0) {
		$result = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bid($bid);
		if ($result) {
			$newuid = $result['uid'];
		} else {
			return;
		}
	}
	C::t('#sanree_brand#sanree_brand_album_category')->fixalbum($bid, array('uid' => $newuid));
	C::t('#sanree_brand#sanree_brand_album')->fixalbum($bid, array('uid' => $newuid));
}
function sr_albumimage($picfile, $dw, $dh) {
	global $_G;
				
	if(!empty($picfile)) {
	
		$valueparse = parse_url($picfile);
		if(isset($valueparse['host'])) {
		
			return $pic;
			
		} else {

			$daid = md5($picfile);
			$thumbfile = 'image/brand_album_'.$daid.'_'.$dw.'_'.$dh.'.jpg';
			$w = intval($dw);
			$h = intval($dh);			
			$parse = parse_url($_G['setting']['attachurl']);
			$attachurl = !isset($parse['host']) ? $_G['siteurl'].$_G['setting']['attachurl'] : $_G['setting']['attachurl'];
			$filename = $_G['setting']['attachdir'].'album/'.$picfile;
			if (!file_exists($filename)) {
				return $_G['siteurl'].'static/image/common/nophoto.gif';
			}		
			require_once libfile('class/image');
			$img = new image;
			if($img->Thumb($filename, $thumbfile, $w, $h)) {
				return $attachurl.$thumbfile;
			} else {
				return $attachurl.'album/'.$picfile;
			}						
		}
		
	}
	return $_G['siteurl'].'static/image/common/nophoto.gif';

}

function brand_dsign($str, $length = 16){
	return substr(md5(getglobal('uid').$str.getglobal('authkey')), 0, ($length ? max(8, $length) : 16));
}

function brand_getlogo($bid, $nocache = 0, $w = 140, $h = 140, $type = '') {
	global $_G;
	$key = brand_dsign($bid.'|'.$w.'|'.$h);
	return 'plugin.php?id=sanree_brand&mod=image&bid='.$bid.'&size='.$w.'x'.$h.'&key='.rawurlencode($key).($nocache ? '&nocache=yes' : '').($type ? '&type='.$type : '');
}

function getthumbnailimage($aid, $picflag) {

	global $_G;
	$daid = intval($aid);
	if($attach = C::t('#sanree_brand#forum_attachment_n')->fetch('aid:'.$daid, $daid, array(1, -1))) {
	
	    $picflag = 1;
		return 'forum/'.$attach['attachment'];
		
	}
	$picflag = 0;
	return $_G['siteurl'].'static/image/common/nophoto.gif';
	
}

function srfiximages($pic, $type = 'category', $none = '/none.gif'){

	global $_G;
	if(!empty($pic)) {
	
		$valueparse = parse_url($pic);
		if(isset($valueparse['host'])) {
		
			return $pic;
			
		} else {
		
			return $_G['setting']['attachurl'].$type.'/'.$pic.'?'.random(6);
			
		}
		
	}
	if (!defined('sr_brand_IMG')) {
	    $brand_config = $_G['cache']['plugin']['sanree_brand'];
		$template = trim($brand_config['template']);
		$template = empty($template) ? 'good' : $template;	
		define('sr_brand_IMG','source/plugin/sanree_brand/tpl/'.$template.'/images');
	}
	return sr_brand_IMG.$none;
	
}


function newtheme($pic, $type = 'category', $none = '/none.gif'){

	global $_G;
	if(!empty($pic)) {
	
		$valueparse = parse_url($pic);
		if(isset($valueparse['host'])) {
		
			return $pic;
			
		} else {
		
			return $_G['setting']['attachurl'].$type.'/'.$pic;
			
		}
		
	}
	if (!defined('sr_brand_IMG')) {
	    $brand_config = $_G['cache']['plugin']['sanree_brand'];
		$template = trim($brand_config['template']);
		$template = empty($template) ? 'good' : $template;	
		define('sr_brand_IMG','source/plugin/sanree_brand/tpl/'.$template.'/images');
	}
	return sr_brand_IMG.$none;
	
}

function getallicq($str, $add = '&nbsp;') {

	global $icqshow;
	if (empty($str)) return srlang('zanwustr');
	$icqlist = explode(',', $str);
	$out = '';
	foreach($icqlist as $icqnumber) {
	
	    $icqnumber = trim($icqnumber);
		!(empty($icqnumber)) && $out .= str_replace('{icqnumber}',$icqnumber, $icqshow).$add;
			
	}
	return $out;
	
}

function getfirsticq($str){

    $str = trim($str);
	if (strpos($str, ',')>0) {
	
		return substr($str, 0, strpos($str, ','));
		
	}
	return $str;
	
}

function replaceparting($str){

	return str_replace(srlang('parting'), ',', $str);
	
}

function srreferer($default = '') {

	global $_G;
	$default = empty($default) ? $GLOBALS['_t_curapp'] : '';
	$_G['referer'] = !empty($_GET['referer']) ? $_GET['referer'] : $_SERVER['HTTP_REFERER'];
	$_G['referer'] = substr($_G['referer'], -1) == '?' ? substr($_G['referer'], 0, -1) : $_G['referer'];
	if(strpos($_G['referer'], 'sanree_brand&mod=mybrand')) {
		return false;
	}
	return true;
	
}

function ajaxexit($msg){
	include template('common/header');
	echo $msg;
	include template('common/footer');
	exit();
}

function importone($id, $upid, $level) {
    if (!updata) return;
	$thislevel = $level;
    foreach(C::t('#sanree_brand#common_district')->fetch_all_by_upid($id) as $data) {
	   $data[upid] = $upid;
	   $nid = $data[id];
	   unset($data[id]);
	   $data[level] = $thislevel;
	   $data[enabled] = 1;
	   $data[usetype] = 3;
	   $inid = C::t('#sanree_brand#sanree_brand_district')->insert($data, TRUE);
	   importone($nid, $inid, $thislevel+1);
	}
}
function chkbrandend($result,$isshow = TRUE) {
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
function mypic_save($FILE, $albumid, $title, $iswatermark = true, $catid = 0) {
	global $_G;
	if($albumid<0) $albumid = 0;
	$swfhash = md5(substr(md5($_G['config']['security']['authkey']), 8).$_G[uid]);
	if($_G['sr_hash'] != $swfhash) {
	    if (defined('IN_ADMINCP')) {
			cpmsg_error('error 123');
		}
		else {
			showmessage('error 123');
		}
	}	

	$allowpictype = array('jpg','jpeg','gif','png');
	$appVer = $_G['setting']['version'];
	if ($appVer=='X2') {
		require_once libfile('class/upload');
	}
	$upload = new discuz_upload();
	$upload->init($FILE, 'album');

	if($upload->error()) {
	    if (defined('IN_ADMINCP')) {
			cpmsg_error(lang('spacecp', 'lack_of_access_to_upload_file_size'));
		}
		else {
			showmessage(lang('spacecp', 'lack_of_access_to_upload_file_size'));
		}	
	}

	if(!$upload->attach['isimage']) {
	    if (defined('IN_ADMINCP')) {
			cpmsg_error(lang('spacecp', 'only_allows_upload_file_types'));
		}
		else {
			showmessage(lang('spacecp', 'only_allows_upload_file_types'));
		}		
	}
	$upload->save();
	if($upload->error()) {
	    if (defined('IN_ADMINCP')) {
			cpmsg_error(lang('spacecp', 'mobile_picture_temporary_failure'));
		}
		else {
			showmessage(lang('spacecp', 'mobile_picture_temporary_failure'));
		}		
	}

	$setarr = array(
		'albumid' => $albumid,
		'uid' => $_G['uid'],
		'username' => $_G['username'],
		'dateline' => $_G['timestamp'],
		'filename' => addslashes($upload->attach['name']),
		'postip' => $_G['clientip'],
		'title' => $title,
		'type' => addslashes($upload->attach['ext']),
		'size' => $upload->attach['size'],
		'filepath' => $upload->attach['attachment'],
		'thumb' => $thumb,
		'remote' => $pic_remote,
		'status' => $pic_status,
	);	
	return $setarr;	
}
	
function brand_discountsetting($value) {
    global $_G;
	$config = $_G['cache']['plugin']['sanree_brand'];
	$selectdiscount = $config['selectdiscount'];
	$marr = explode("\r\n", $selectdiscount); 
	$config['selectdiscountshow'] = array();
	foreach($marr as $row) {
		list($key , $val) = explode("=", $row);
		$config['selectdiscountshow'][$key] = $val;
	}
	$html = '<select name="discount">';
	foreach($config['selectdiscountshow'] as $key => $val) {
		$selected = $key==$value ? ' selected ':'';
		$html .= '<option value="'.$key.'"'.$selected.'>'.$val.'</option>';
	}
	$html .= '</select>';
	return $html;	
}

function gethomeurl(){
    global $_G;
	$config = $_G['cache']['plugin']['sanree_brand']; 
	$is_rewrite = $config['is_rewrite'];
	$domain = trim($config['domain']);
	if (empty($domain)) {
		if ($is_rewrite) {
			$urlitemmode = empty($config['urlhomemode']) ? "brand.html": $config['urlhomemode'];
			return $urlitemmode;
		}
		return 'plugin.php?id=sanree_brand';
	}
	if ($is_rewrite) {
		$urlitemmode = empty($config['urlhomemode']) ? "brand.html": $config['urlhomemode'];
	}	
	return branddomain().$urlitemmode;
}

function getcateurl($param,$zero = FALSE){
    global $_G;
	$config = $_G['cache']['plugin']['sanree_brand'];  
	$isindexlist = intval($config['isindexlist']);
	$is_rewrite = $config['is_rewrite'];
	$keylist = array('tid', 'did', 'filter', 'listmode', 'tag', 'attestation');
	$extra = '';
	foreach($keylist as $key =>$val) {
	    if (isset($param[$val])) {
		    $$val = $param[$val];
		} else {
			if ($zero) {
			    $$val = 0;
			} else {
				$$val 	= intval($_G['sr_'.$val]);
			}
			if ($val=='listmode'&&intval($_GET['listmode'])==0) {
				$listmode = $isindexlist;
			}

		}
		($$val>0) && $extra.="&$val=".$$val;
	}
    if ($is_rewrite) {
	    $urllistmode = empty($config['urllistmode']) ? "brand-index-{tid}-{did}-{filter}-{listmode}-{tag}-{attestation}.html": $config['urllistmode'];
		foreach($keylist as $line) {
		    $urllistmode = str_replace("{".$line."}",$$line ,$urllistmode);
		}
		return branddomain().$urllistmode;
	}
	return branddomain()."plugin.php?id=sanree_brand&mod=index".$extra;
}

function homegetcateurl($param,$zero = FALSE){
	global $_G;
	$config = $_G['cache']['plugin']['sanree_brand'];
	$isindexlist = intval($config['isindexlist']);
	$is_rewrite = $config['is_rewrite'];
	$keylist = array('tid', 'did', 'filter', 'listmode', 'tag');
	$extra = '';
	foreach($keylist as $key =>$val) {
		if (isset($param[$val])) {
			$$val = $param[$val];
		} else {
			if ($zero) {
				$$val = 0;
			} else {
				$$val 	= intval($_G['sr_'.$val]);
			}
			if ($val=='listmode'&&intval($_GET['listmode'])==0) {
				$listmode = $isindexlist;
			}

		}
		($$val>0) && $extra.="&$val=".$$val;
	}
	if ($is_rewrite) {
		$urllisthome = empty($config['urllisthome']) ? "brand-home-{tid}-{did}-{filter}-{listmode}-{tag}.html": $config['urllisthome'];
		foreach($keylist as $line) {
			$urllisthome = str_replace("{".$line."}",$$line ,$urllisthome);
		}
		return branddomain().$urllisthome;
	}
	return branddomain()."plugin.php?id=sanree_brand&mod=home".$extra;
}

function getburl($value){
    global $_G;
	$config = $_G['cache']['plugin']['sanree_brand']; 
    $groupid= $value['groupid'];
	$is_rewrite = $config['is_rewrite'];
	$group = C::t('#sanree_brand#sanree_brand_group')->get_by_groupid($groupid);
	if ($group['urlmod'] == 1|| $config['isonepage'] ==1 ) {
	    
		if($_G['setting']['plugins']['func'][HOOKTYPE]['sanreedomain']) {
			$_G['hooksanreedomain'] = '';
			hookscript('sanreedomain', 'global', 'funcs', array('mode' => 'bid', 'data' => $value['bid']), 'sanreedomain');
			if ($_G['hooksanreedomain']) {
				return $_G['hooksanreedomain'];
			}
		}		
	    if ($is_rewrite) {
		    $keylist = array('tid');
			$tid  = $value['bid'];
		    $urlitemmode = empty($config['urlitemmode']) ? "brand-item-{tid}.html": $config['urlitemmode'];
			foreach($keylist as $line) {
				$urlitemmode = str_replace("{".$line."}",$$line ,$urlitemmode);
			}
			return branddomain().$urlitemmode;
		}
		return branddomain().'plugin.php?id=sanree_brand&mod=item&tid='.$value['bid'];
	}
	return 'forum.php?mod=viewthread&amp;tid='.$value['tid'];
}

function getdetailurl($value){
    global $_G;
	$config = $_G['cache']['plugin']['sanree_brand']; 
    $groupid= $value['groupid'];
	$is_rewrite = $config['is_rewrite'];
	$group = C::t('#sanree_brand#sanree_brand_group')->get_by_groupid($groupid);
	if ($group['urlmod'] == 1|| $config['isonepage'] ==1 ) {
	    	
	    if ($is_rewrite) {
		    $keylist = array('tid');
			$tid  = $value['bid'];
		    $urlitemmode = empty($config['urldetailmode']) ? "brand-detail-{tid}.html": $config['urldetailmode'];
			foreach($keylist as $line) {
				$urlitemmode = str_replace("{".$line."}",$$line ,$urlitemmode);
			}
			return $urlitemmode;
		}
		return 'plugin.php?id=sanree_brand&mod=detail&tid='.$value['bid'];
	}
	return 'forum.php?mod=viewthread&amp;tid='.$value['tid'];
}

function gettagurl($tagid) {
    global $_G;
	$tagid = intval($tagid);
	$config = $_G['cache']['plugin']['sanree_brand'];
	if ($config['is_rewrite']&&$config['urltagmode']) {
		$keylist = array('tag');
		$tid  = $tagid;
		$urltagmode = empty($config['urlitemmode']) ? "brand-tag-{tag}.html": $config['urltagmode'];
		foreach($keylist as $line) {
			$urlitemmode = str_replace("{".$line."}",$$line ,$urltagmode);
		}
		return branddomain().$urltagmode;
	}
	return branddomain().'plugin.php?id=sanree_brand&mod=tag&tag='.$tagid;
}

function getmyburl_by_bid($bid){
    global $_G;
	$bid = intval($bid);
	$config = $_G['cache']['plugin']['sanree_brand'];
	$is_rewrite = $config['is_rewrite'];
	$brand = C::t('#sanree_brand#sanree_brand_businesses')->fetch_first_bybid($bid);
	$group = C::t('#sanree_brand#sanree_brand_group')->get_by_groupid($brand[groupid]);
	$siturl = branddomain();
	$siturl = empty($siturl) ? $_G['siteurl'] : $siturl;
	if ($group['urlmod'] == 1|| $config['isonepage'] ==1 ) {

		if($_G['setting']['plugins']['func'][HOOKTYPE]['sanreedomain']) {
			$_G['hooksanreedomain'] = '';
			hookscript('sanreedomain', 'global', 'funcs', array('mode' => 'bid', 'data' => $bid), 'sanreedomain');
			if ($_G['hooksanreedomain']) {
				return $_G['hooksanreedomain'];
			}
		}
	    if ($is_rewrite) {
		    $keylist = array('tid');
			$tid  = $bid;
		    $urlitemmode = empty($config['urlitemmode']) ? "brand-item-{tid}.html": $config['urlitemmode'];
			foreach($keylist as $line) {
				$urlitemmode = str_replace("{".$line."}",$$line ,$urlitemmode);
			}
			return $siturl.$urlitemmode;
		}
		return $siturl.'plugin.php?id=sanree_brand&mod=item&tid='.$bid;
	}
	return $siturl.'forum.php?mod=viewthread&tid='.$brand[tid];
}

function getburl_by_bid($bid){
    global $_G;
	$bid = intval($bid);
	$config = $_G['cache']['plugin']['sanree_brand'];
	$is_rewrite = $config['is_rewrite'];
	$brand = C::t('#sanree_brand#sanree_brand_businesses')->fetch_first_bybid($bid);
	$group = C::t('#sanree_brand#sanree_brand_group')->get_by_groupid($brand[groupid]);
	if ($group[urlmod] == 1|| $config['isonepage'] ==1 ) {

		if($_G['setting']['plugins']['func'][HOOKTYPE]['sanreedomain']) {
			$_G['hooksanreedomain'] = '';
			hookscript('sanreedomain', 'global', 'funcs', array('mode' => 'bid', 'data' => $bid), 'sanreedomain');
			if ($_G['hooksanreedomain']) {
				return $_G['hooksanreedomain'];
			}
		}
	    if ($is_rewrite) {
		    $keylist = array('tid');
			$tid  = $bid;
		    $urlitemmode = empty($config['urlitemmode']) ? "brand-item-{tid}.html": $config['urlitemmode'];
			foreach($keylist as $line) {
				$urlitemmode = str_replace("{".$line."}",$$line ,$urlitemmode);
			}
			return branddomain().$urlitemmode;
		}
		return branddomain().'plugin.php?id=sanree_brand&mod=item&tid='.$bid;
	}
	return 'forum.php?mod=viewthread&amp;tid='.$brand[tid];
}

function getitemurl($bid){
    global $_G;
	$bid = intval($bid);
	$config = $_G['cache']['plugin']['sanree_brand']; 
	$is_rewrite = $config['is_rewrite'];
	if($_G['setting']['plugins']['func'][HOOKTYPE]['sanreedomain']) {
		$_G['hooksanreedomain'] = '';
		hookscript('sanreedomain', 'global', 'funcs', array('mode' => 'bid', 'data' => $bid), 'sanreedomain');
		if ($_G['hooksanreedomain']) {
			return $_G['hooksanreedomain'];
		}
	}	
	if ($is_rewrite) {
		$keylist = array('tid');
		$tid  = $bid;
		$urlitemmode = empty($config['urlitemmode']) ? "brand-item-{tid}.html": $config['urlitemmode'];
		foreach($keylist as $line) {
			$urlitemmode = str_replace("{".$line."}",$$line ,$urlitemmode);
		}
		return branddomain().$urlitemmode;
	}
	return branddomain().'plugin.php?id=sanree_brand&mod=item&tid='.$bid;
}

function getalbumurl($bid){
    global $_G;
	$bid = intval($bid);
	$config = $_G['cache']['plugin']['sanree_brand']; 
    $is_rewrite = $config['is_rewrite'];
	$userurl = branddomain();
	if($_G['setting']['plugins']['func'][HOOKTYPE]['sanreedomain']) {
		$_G['hooksanreedomain'] = '';
		hookscript('sanreedomain', 'global', 'funcs', array('mode' => 'albumlist', 'data' => $bid), 'sanreedomain');
		if ($_G['hooksanreedomain']) {
			$userurl = $_G['hooksanreedomain'];
		}
	}	
	if ($is_rewrite) {
		$keylist = array('tid');
		$tid  = $bid;
		$urlalbummode = empty($config['urlalbummode']) ? "brand-albumlist-{tid}.html" : $config['urlalbummode'];
		foreach($keylist as $line) {
			$urlalbummode = str_replace("{".$line."}",$$line ,$urlalbummode);
		}
		return $userurl.$urlalbummode;
	}
	return $userurl.'plugin.php?id=sanree_brand&mod=albumlist&tid='.$bid;
}

function getalbumitemurl($catid){
    global $_G;
	$catid = intval($catid);
	$config = $_G['cache']['plugin']['sanree_brand']; 
	$is_rewrite = $config['is_rewrite'];
	$userurl = branddomain();
	if($_G['setting']['plugins']['func'][HOOKTYPE]['sanreedomain']) {
		$_G['hooksanreedomain'] = '';
		hookscript('sanreedomain', 'global', 'funcs', array('mode' => 'albumshow', 'data' => $catid), 'sanreedomain');
		if ($_G['hooksanreedomain']) {
			$userurl = $_G['hooksanreedomain'];
		}
	}		
	if ($is_rewrite) {
		$keylist = array('tid');
		$tid  = $catid;
		$urlalbumitemmode = empty($config['urlalbumitemmode']) ? "brand-albumshow-{tid}.html" : $config['urlalbumitemmode'];
		foreach($keylist as $line) {
			$urlalbumitemmode = str_replace("{".$line."}",$$line ,$urlalbumitemmode);
		}
		return $userurl.$urlalbumitemmode;
	}
	return $userurl.'plugin.php?id=sanree_brand&mod=albumshow&tid='.$catid;
}

function getbrandnourl($brandno) {
    global $_G;
	$config = $_G['cache']['plugin']['sanree_brand']; 
	$brandno = dhtmlspecialchars(trim($brandno));	
	$is_rewrite = $config['is_rewrite'];
	$siturl = branddomain();
	$siturl = empty($siturl) ? $_G['siteurl'] : $siturl;
	if($_G['setting']['plugins']['func'][HOOKTYPE]['sanreedomain']) {
		$_G['hooksanreedomain'] = '';
		hookscript('sanreedomain', 'global', 'funcs', array('mode' => 'brandno', 'data' => $brandno), 'sanreedomain');
		if ($_G['hooksanreedomain']) {
			return $_G['hooksanreedomain'];
		}
	}	
	if ($is_rewrite) {
		$keylist = array('tid');
		$tid  = $brandno;
		$urlbrandnomode = empty($config['urlbrandnomode']) ? "b/{tid}.html": $config['urlbrandnomode'];
		foreach($keylist as $line) {
			$urlbrandnomode = str_replace("{".$line."}",$$line ,$urlbrandnomode);
		}
		return $siturl.$urlbrandnomode;
	}
	return $siturl.'plugin.php?id=sanree_brand&mod=brandno&tid='.$brandno;
}

function getgroupurlmode($groupid){
    global $_G;
	$config = $_G['cache']['plugin']['sanree_brand'];
	if (intval($config['isonepage'])==1) return 1;
	$group = C::t('#sanree_brand#sanree_brand_group')->get_by_groupid($groupid);
	if($group) {
		return $group['urlmod'];
	}  
	return 0;  
}
function getgroupsmallicons($groupid){
    global $_G;
	$group = C::t('#sanree_brand#sanree_brand_group')->get_by_groupid($groupid);
	if($group['smallicons']) {
		return fiximage($group['smallicons']);
	}  
	return 'source/plugin/sanree_brand/tpl/good/images/h_vip0.gif';  
}
function getgroupimg($groupid){
    global $_G;
	$group = C::t('#sanree_brand#sanree_brand_group')->get_by_groupid($groupid);
	if($group['grouplogo']) {
		return fiximage($group['grouplogo']);
	}  
	return 'source/plugin/sanree_brand/tpl/good/images/vip0.gif';  
}

function getgroup($groupid){
	return C::t('#sanree_brand#sanree_brand_group')->get_by_groupid($groupid);
}

function sanree_libfile($libname, $folder = '') {
	$libpath = DISCUZ_ROOT.'/source/plugin/'.$folder;
	if(strstr($libname, '/')) {
		list($pre, $path, $name) = explode('/', $libname);
		return realpath("{$libpath}/{$pre}/$path/{$path}_{$name}.php");
	} else {
		return realpath("{$libpath}/{$libname}.php");
	}
}

function sdebug($str,$end = true) {
   echo $str;
   if ($end) exit();
}

function pdebug($str,$end = true) {
   print_r($str);
   if ($end) exit();
}

function showwater($watermarktextcvt) {
    $watermarktextcvt=str_replace(lang('plugin/sanree_brand', 'fixwaterstr1'),"-",$watermarktextcvt);
	$watermarktextcvt=substr($watermarktextcvt,0,13);
	$imwidth=strlen($watermarktextcvt) * 10;
	$im = imagecreatetruecolor($imwidth, 20); 
	imagesavealpha($im, true); 
	$red = imagecolorallocate($im, 0xff, 0, 0);  
	$trans_colour = imagecolorallocatealpha($im, 0xff, 0xff, 0xff, 127); 
	imagefill($im, 0, 0, $trans_colour); 
	imagecolortransparent($im, $trans_colour);
	imagestring($im, 16, 5, 5,  $watermarktextcvt, $red);
	header("Content-type:image/jpeg");  
	imagegif($im);  
	imagedestroy($im); 
}

function srlang($word) {
	return lang('plugin/sanree_brand', $word);
}

function checktplrefreshEx($maintpl, $subtpl, $timecompare, $templateid, $cachefile, $tpldir, $file) {
	static $tplrefresh, $timestamp, $targettplname;
	if($tplrefresh === null) {
		$tplrefresh = getglobal('config/output/tplrefresh');
		$timestamp = getglobal('timestamp');
	}

	if(empty($timecompare) || $tplrefresh == 1 || ($tplrefresh > 1 && !($timestamp % $tplrefresh))) {
		if(empty($timecompare) || @filemtime(DISCUZ_ROOT.$subtpl) > $timecompare) {
			require_once DISCUZ_ROOT.'/source/class/class_template.php';
			$template = new template();
			$template->parse_template($maintpl, $templateid, $tpldir, $file, $cachefile);
			if($targettplname === null) {
				$targettplname = getglobal('style/tplfile');
				if(!empty($targettplname)) {
					include_once libfile('function/block');
					$targettplname = strtr($targettplname, ':', '_');
					update_template_block($targettplname, getglobal('style/tpldirectory'), $template->blocks);
				}
				$targettplname = true;
			}
			return TRUE;
		}
	}
	return FALSE;
}

function templateEx($file, $templateid = 0, $tpldir = '', $gettplfile = 0, $primaltpl='') {
	global $_G, $brandresult;
	
	$m = md5($file);
	if(empty($_G[$m])) {
		hookscript('sanreebrandtemplatefile', 'global', 'funcs', array('file' => &$file, 'templateid' => &$templateid, 'tpldir' => &$tpldir, 'gettplfile' => &$gettplfile, 'primaltpl' => &$primaltpl), 'sanreebrandtemplatefile');
		$_G[$m] = true;
	}
	
	$appVer = $_G['setting']['version'];
	$debartemplate  = array(
		'srhead', 'srfoot', 'header_one_'.$appVer
	);
	
	list($plugin, $temp) = explode(':', $file);
	list($template, $birdfile) = explode('/', $temp);

	if(($_G['cache']['plugin']['sanree_brand']['isbird']) && !in_array($birdfile, $debartemplate)) {

		if ($_G['cache']['plugin']['sanree_brand']['isnice']) {
			$tpladd = 'home';
		}

		$tpltemplate = array(
			'index', 'hello', 'christmas', 'newyear', 'springfestival',
			'item', 'detail', 'albumlist', 'albumshow',$tpladd
		);

		if($_G['item_detail'] == 'detail') {
			$birdfile = $_G['item_detail'];
		}

		$fulltemplate  = array(
			'item', 'detail', 'albumlist', 'albumshow'
		);

		$fullflag  = array(
			'item' => 'index',
			'detail' => 'detail',
			'albumlist' => 'myalbum',
			'albumshow' => 'myalbum',
		);

		if(in_array($birdfile, $fulltemplate)) {
			if ($_G['cache']['plugin']['sanree_brand']['isnice']) {
				require_once libfile('class/'.$plugin.'_nicemenu','plugin/'.$plugin);
				new sanree_brand_nicemenu($fullflag[$birdfile], $brandresult, $birdfile);
			} else {
				require_once libfile('class/'.$plugin.'_newmenu','plugin/'.$plugin);
				new sanree_brand_newmenu($fullflag[$birdfile], $brandresult, $birdfile);
			}

		}

		if($plugin == 'sanree_brand' && in_array($birdfile, $tpltemplate)) {

				$template = 'nice';
				define('NICE_TPL', 'source/plugin/'.$plugin.'/tpl/nice/');
				define('NICE_IMG', 'source/plugin/'.$plugin.'/tpl/nice/images/');
				define('NICE_JS', 'source/plugin/'.$plugin.'/tpl/nice/js/');
				define('NICE_CSS', 'source/plugin/'.$plugin.'/tpl/nice/');

				$template = 'bird';
				define('BIRD_IMG', 'source/plugin/'.$plugin.'/tpl/'.$template.'/images/');
				define('BIRD_JS', 'source/plugin/'.$plugin.'/tpl/'.$template.'/js/');
				define('BIRD_CSS', 'source/plugin/'.$plugin.'/tpl/'.$template.'/');

			if ($_G['cache']['plugin']['sanree_brand']['isnice']) {
				$template = 'nice';
			}

			$birdindex = array('index', 'hello', 'christmas', 'newyear', 'springfestival');

			if(in_array($birdfile, $birdindex)) {

				$file = $plugin.':'.$template.'/'.$tpltemplate[0];
			
			} elseif($birdfile == $fulltemplate[0]) {

				$file = $plugin.':'.$template.'/'.$birdfile.'_'.$fullflag[$birdfile];
				
			} elseif($birdfile == $fulltemplate[1]) {

				$file = $plugin.':'.$template.'/'.$fulltemplate[0].'_'.$birdfile;
			
			} elseif($birdfile == $fulltemplate[2]) {
			
				$file = $plugin.':'.$template.'/'.$birdfile;
	
			} elseif($birdfile == $fulltemplate[3]) {
			
				$file = $plugin.':'.$template.'/'.$birdfile;
	
			} elseif($birdfile == 'home') {

				$file = $plugin.':nice/'.$birdfile;

			}

		}
		
	}
	
    if ($_G['setting']['version'] == 'X2.5' || $_G['setting']['version'] == 'X3' || $_G['setting']['version'] == 'X3.1' || $_G['setting']['version'] == 'X3.2') {
		static $_init_style = false;
		if($_init_style === false) {
			C::app()->_init_style();
			$_init_style = true;
		}
	}
	else {
	  if (!defined('STYLEID')) {
		  define('STYLEID',1);
	  }
	}
	$oldfile = $file;
	if(strpos($file, ':') !== false) {
		$clonefile = '';
		list($templateid, $file, $clonefile) = explode(':', $file);
		$oldfile = $file;
		$file = empty($clonefile) ? $file : $file.'_'.$clonefile;
		if($templateid == 'diy') {
			$indiy = false;
			$_G['style']['tpldirectory'] = $tpldir ? $tpldir : (defined('TPLDIR') ? TPLDIR : '');
			$_G['style']['prefile'] = '';
			$diypath = DISCUZ_ROOT.'./data/diy/'.$_G['style']['tpldirectory'].'/';
			$preend = '_diy_preview';
			$_GET['preview'] = !empty($_GET['preview']) ? $_GET['preview'] : '';
			$curtplname = $oldfile;
			$basescript = $_G['mod'] == 'viewthread' && !empty($_G['thread']) ? 'forum' : $_G['basescript'];
			if(isset($_G['cache']['diytemplatename'.$basescript])) {
				$diytemplatename = &$_G['cache']['diytemplatename'.$basescript];
			} else {
				if(!isset($_G['cache']['diytemplatename'])) {
					loadcache('diytemplatename');
				}
				$diytemplatename = &$_G['cache']['diytemplatename'];
			}
			$tplsavemod = 0;
			if(isset($diytemplatename[$file]) && file_exists($diypath.$file.'.php') && ($tplsavemod = 1) || empty($_G['forum']['styleid']) && ($file = $primaltpl ? $primaltpl : $oldfile) && isset($diytemplatename[$file]) && file_exists($diypath.$file.'.php')) {
				$tpldir = 'data/diy/'.$_G['style']['tpldirectory'].'/';
				!$gettplfile && $_G['style']['tplsavemod'] = $tplsavemod;
				$curtplname = $file;
				if(isset($_GET['diy']) && $_GET['diy'] == 'yes' || isset($_GET['diy']) && $_GET['preview'] == 'yes') {
					$flag = file_exists($diypath.$file.$preend.'.php');
					if($_GET['preview'] == 'yes') {
						$file .= $flag ? $preend : '';
					} else {
						$_G['style']['prefile'] = $flag ? 1 : '';
					}
				}
				$indiy = true;
			} else {
				$file = $primaltpl ? $primaltpl : $oldfile;
			}
			$tplrefresh = $_G['config']['output']['tplrefresh'];
			if($indiy && ($tplrefresh ==1 || ($tplrefresh > 1 && !($_G['timestamp'] % $tplrefresh))) && filemtime($diypath.$file.'.php') < filemtime(DISCUZ_ROOT.$_G['style']['tpldirectory'].'/'.($primaltpl ? $primaltpl : $oldfile).'.php')) {
				if (!updatediytemplate($file, $_G['style']['tpldirectory'])) {
					unlink($diypath.$file.'.php');
					$tpldir = '';
				}
			}

			if (!$gettplfile && empty($_G['style']['tplfile'])) {
				$_G['style']['tplfile'] = empty($clonefile) ? $curtplname : $oldfile.':'.$clonefile;
			}

			$_G['style']['prefile'] = !empty($_GET['preview']) && $_GET['preview'] == 'yes' ? '' : $_G['style']['prefile'];

		} else {
			$tpldir = './source/plugin/'.$templateid.'/tpl';
		}
	}

	$file .= !empty($_G['inajax']) && ($file == 'common/header' || $file == 'common/footer') ? '_ajax' : '';
	$tpldir = $tpldir ? $tpldir : (defined('TPLDIR') ? TPLDIR : '');
	$templateid = $templateid ? $templateid : (defined('TEMPLATEID') ? TEMPLATEID : '');
	$filebak = $file;

	if(defined('IN_MOBILE') && !defined('TPL_DEFAULT') && strpos($file, 'mobile/') === false || (isset($_G['forcemobilemessage']) && $_G['forcemobilemessage'])) {
		$file = 'mobile/'.$oldfile;
		$tpldir = './source/plugin/'.$templateid.'_mobile/tpl';
	}

	if(!$tpldir) {
		$tpldir = './template/default';
	}
	$tplfile = $tpldir.'/'.$file.'.tpl.php';

	$file == 'common/header' && defined('CURMODULE') && CURMODULE && $file = 'common/header_'.$_G['basescript'].'_'.CURMODULE;

	if(defined('IN_MOBILE') && !defined('TPL_DEFAULT')) {
		if(strpos($tpldir, 'plugin')) {
			if(!file_exists(DISCUZ_ROOT.$tplfile) && !file_exists(DISCUZ_ROOT.$tpldir.'/'.$file.'.php')) {
				discuz_error::template_error('template_notfound', $tplfile);
			} else {
				$mobiletplfile = $tplfile;
			}
		}
		!$mobiletplfile && $mobiletplfile = $file.'.php';
		if(strpos($tpldir, 'plugin') && (file_exists(DISCUZ_ROOT.$mobiletplfile) || file_exists(substr(DISCUZ_ROOT.$mobiletplfile, 0, -4).'.php'))) {
			$tplfile = $mobiletplfile;
		} elseif(!file_exists(DISCUZ_ROOT.TPLDIR.'/'.$mobiletplfile) && !file_exists(substr(DISCUZ_ROOT.TPLDIR.'/'.$mobiletplfile, 0, -4).'.php')) {
			$mobiletplfile = './template/default/'.$mobiletplfile;
			if(!file_exists(DISCUZ_ROOT.$mobiletplfile) && !$_G['forcemobilemessage']) {
				$tplfile = str_replace('mobile/', '', $tplfile);
				$file = str_replace('mobile/', '', $file);
				define('TPL_DEFAULT', true);
			} else {
				$tplfile = $mobiletplfile;
			}
		} else {
			$tplfile = TPLDIR.'/'.$mobiletplfile;
		}
	}

	$cachefile = './data/template/'.(defined('STYLEID') ? STYLEID.'_' : '_').$templateid.'_'.str_replace('/', '_', $file).'.tpl.php';
	if($templateid != 1 && !file_exists(DISCUZ_ROOT.$tplfile) && !file_exists(substr(DISCUZ_ROOT.$tplfile, 0, -4).'.php')
			&& !file_exists(DISCUZ_ROOT.($tplfile = $tpldir.$filebak.'.php'))) {
		$tplfile = './template/default/'.$filebak.'.php';
	}

	if($gettplfile) {
		return $tplfile;
	}
	checktplrefreshEx($tplfile, $tplfile, @filemtime(DISCUZ_ROOT.$cachefile), $templateid, $cachefile, $tpldir, $file);
	srhookscriptoutput($tplfile);
	return DISCUZ_ROOT.$cachefile;
}

function srhookscriptoutput($tplfile) {
	global $_G;
	if(!empty($_G['srhookscriptoutput'])) {
		return;
	}
	$param = array('template' => $tplfile, 'message' => $_G['hookscriptmessage'], 'values' => $_G['hookscriptvalues']);
	hookscript('sanree', 'plugin', 'outputfuncs', $param);
	$_G['srhookscriptoutput'] = true;
}

function notification_addex($touid, $type, $note, $notevars = array(), $system = 0) {
	global $_G;

	$tospace = array('uid'=>$touid);
	space_merge($tospace, 'field_home');
	$filter = empty($tospace['privacy']['filter_note'])?array():array_keys($tospace['privacy']['filter_note']);

	if($filter && (in_array($type.'|0', $filter) || in_array($type.'|'.$_G['uid'], $filter))) {
		return false;
	}

	$notevars['actor'] = "<a href=\"home.php?mod=space&uid=$_G[uid]\">".$_G['member']['username']."</a>";
	if(!is_numeric($type)) {
		$vars = explode(':', $note);
		if(count($vars) == 2) {
			$notestring = lang('plugin/'.$vars[0], $vars[1], $notevars);
		} else {
			$notestring = lang('notification', $note, $notevars);
		}
		$frommyapp = false;
	} else {
		$frommyapp = true;
		$notestring = $note;
	}

	$oldnote = array();
	if($notevars['from_id'] && $notevars['from_idtype']) {
		$oldnote = DB::fetch_first("SELECT * FROM ".DB::table('home_notification')."
			WHERE from_id='$notevars[from_id]' AND from_idtype='$notevars[from_idtype]' AND uid='$touid'");
	}
	if(empty($oldnote['from_num'])) $oldnote['from_num'] = 0;
	$notevars['from_num'] = $notevars['from_num'] ? $notevars['from_num'] : 1;
	$setarr = array(
		'uid' => $touid,
		'type' => $type,
		'new' => 1,
		'authorid' => $_G['uid'],
		'author' => $_G['username'],
		'note' => $notestring,
		'dateline' => $_G['timestamp'],
		'from_id' => $notevars['from_id'],
		'from_idtype' => $notevars['from_idtype'],
		'from_num' => ($oldnote['from_num']+$notevars['from_num'])
	);
	if($system) {
		$setarr['authorid'] = 0;
		$setarr['author'] = '';
	}

	if($oldnote['id']) {
		DB::update('home_notification', $setarr, array('id'=>$oldnote['id']));
	} else {
		$oldnote['new'] = 0;
		DB::insert('home_notification', $setarr);
	}

	if(empty($oldnote['new'])) {
		DB::query("UPDATE ".DB::table('common_member')." SET newprompt=newprompt+1 WHERE uid='$touid'");

	}

	if(!$system && $_G['uid'] && $touid != $_G['uid']) {
		DB::query("UPDATE ".DB::table('home_friend')." SET num=num+1 WHERE uid='$_G[uid]' AND fuid='$touid'");
	}
}

function sendbrand_notice($bid, $act) {
    global $_G;
	$config = $_G['cache']['plugin']['sanree_brand'];
	if (in_array($act, array('brand_pass' , 'brand_pending', 'brand_refuse', 'brand_adminpass'))) {
		$bids = array();
		if (!is_array($bid)) {
			$bids[] = $bid;
		}
		else {
			$bids = $bid;
		}	
		foreach ($bids as $value) {
			$row = C::t('#sanree_brand#sanree_brand_businesses')->fetch_first_bybid($value);
			if ($row) {
			
				$welcomformat = srlang($act);
				$user1txt = '<a href="home.php?mod=space&amp;uid='.$row['uid'].'">'.$row['username'].'</a>';
				$turl = getburl($row);
				$nametxt = '<a href="'.$turl.'">'.addslashes($row['name']).'</a>';
				$adminnametxt = '<a href="home.php?mod=space&amp;uid='.$_G['uid'].'">'.$_G['username'].'</a>';
				$timetxt = dgmdate(TIMESTAMP);
				$welcomemsgtxt = str_replace('{user}', $user1txt, $welcomformat);
				$welcomemsgtxt = str_replace('{brand}', $nametxt, $welcomemsgtxt);
				$welcomemsgtxt = str_replace('{time}', $timetxt, $welcomemsgtxt);
				$welcomemsgtxt = str_replace('{price}', $row['regprice'], $welcomemsgtxt);
				$welcomemsgtxt = str_replace('{unit}', $row['creditunitname'], $welcomemsgtxt);
				$welcomemsgtxt = str_replace('{adminuser}', $adminnametxt, $welcomemsgtxt);
				$welcomemsgtxt = str_replace('{reason}', $row['reason'], $welcomemsgtxt);
				$welcomemsgtxt = nl2br(str_replace(':', '&#58;', $welcomemsgtxt));
				@notification_addex($row['uid'], 'system', $welcomemsgtxt, array(), 1);
				if ($config['isauditornotice'] && $config['isshen']) {
					sendauditor_notice($row,$act);
				}
			}
		}
	}
}

function sendmsg_notice($msgid, $act) {
    global $_G;
	if (in_array($act, array('brand_pass' , 'brand_pending', 'brand_refuse', 'brand_adminpass'))) {
		$bids = array();
		if (!is_array($bid)) {
			$bids[] = $bid;
		}
		else {
			$bids = $bid;
		}	
		foreach ($bids as $value) {
			$row = C::t('#sanree_brand#sanree_brand_businesses')->fetch_first_bybid($value);
			if ($row) {
				$welcomformat = srlang($act);
				$user1txt = '<a href="home.php?mod=space&amp;uid='.$row['uid'].'">'.$row['username'].'</a>';
				$nametxt = '<a href="forum.php?mod=viewthread&amp;tid='.$row['tid'].'">'.addslashes($row['name']).'</a>';
				$adminnametxt = '<a href="home.php?mod=space&amp;uid='.$_G['uid'].'">'.$_G['username'].'</a>';
				$timetxt = dgmdate(TIMESTAMP);
				$welcomemsgtxt = str_replace('{user}', $user1txt, $welcomformat);
				$welcomemsgtxt = str_replace('{brand}', $nametxt, $welcomemsgtxt);
				$welcomemsgtxt = str_replace('{time}', $timetxt, $welcomemsgtxt);
				$welcomemsgtxt = str_replace('{price}', $row['regprice'], $welcomemsgtxt);
				$welcomemsgtxt = str_replace('{unit}', $row['creditunitname'], $welcomemsgtxt);
				$welcomemsgtxt = str_replace('{adminuser}', $adminnametxt, $welcomemsgtxt);
				$welcomemsgtxt = str_replace('{reason}', $row['reason'], $welcomemsgtxt);
				$welcomemsgtxt = nl2br(str_replace(':', '&#58;', $welcomemsgtxt));
				@notification_addex($row['uid'], 'system', $welcomemsgtxt, array(), 1);
			}
		}
	}
}

function sendauditor_notice ($row, $act) {
	global $_G;
	$config = $_G['cache']['plugin']['sanree_brand'];
	if ($act == 'brand_pending') {

		$aact = 'brand_auditopending';

	} else {

		$aact = $act;

	}
	if ($row && $aact) {

		$welcomformat = srlang($aact);
		$user1txt = '<a href="home.php?mod=space&amp;uid='.$row['uid'].'">'.$row['username'].'</a>';
		$turl = getburl($row);
		$nametxt = '<a href="'.$turl.'">'.addslashes($row['name']).'</a>';
		$adminnametxt = '<a href="home.php?mod=space&amp;uid='.$_G['uid'].'">'.$_G['username'].'</a>';
		$timetxt = dgmdate(TIMESTAMP);
		$welcomemsgtxt = str_replace('{user}', $user1txt, $welcomformat);
		$welcomemsgtxt = str_replace('{brand}', $nametxt, $welcomemsgtxt);
		$welcomemsgtxt = str_replace('{adminuser}', $adminnametxt, $welcomemsgtxt);
		$welcomemsgtxt = str_replace('{reason}', $row['reason'], $welcomemsgtxt);
		$welcomemsgtxt = str_replace('{time}', $timetxt, $welcomemsgtxt);
		$welcomemsgtxt = nl2br(str_replace(':', '&#58;', $welcomemsgtxt));
		if ($config['isauditornotice']) {
			$auditorid = explode(',',$config['auditorid']);
			foreach ($auditorid as $key => $id) {
				if ($_G['uid'] != $id && $row['uid'] != $id) {
					@notification_addex($id, 'system', $welcomemsgtxt, array(), 1);
				}
			}
		}
	}
}

function instertoforum($data) {
    global $_G;
	$subject 		= $data['subject'];
	$message 		= $data['message'];
    $author 		= $data['username'];
	$authorid  		= $data['uid'];
	$publishdate 	= TIMESTAMP;
	$closed 		= 0;
	$replycredit	= 0;
	$isgroup		= 0;
	$moderated		= 0;
	$special		= 0;
	$displayorder = ($data['isshow']==1&&$data['status'] == 1) ? 0 : -1;
	
	$newthread = array(
		'fid' 			=> $data['fid'],
		'posttableid' 	=> 0,
		'readperm' 		=> 0,
		'price' 		=> 0,
		'typeid'		=> 0,
		'sortid' 		=> 0,
		'author' 		=> $author,
		'authorid' 		=> $data['uid'],
		'subject' 		=> $subject,
		'dateline' 		=> $publishdate,
		'lastpost' 		=> $publishdate,
		'lastposter' 	=> $author,
		'displayorder' 	=> $displayorder,
		'digest' 		=> $digest,
		'special' 		=> $special,
		'attachment' 	=> 0,
		'moderated' 	=> $moderated,
		'status' 		=> 0,
		'isgroup' 		=> $isgroup,
		'replycredit' 	=> $replycredit,
		'closed' 		=> 0
	);
	$tid = C::t('#sanree_brand#forum_thread')->insert($newthread, true);
	
	if ($displayorder != 0) {
	     $newrow = array(
			  'tid' => $tid,
			  'uid' => $_G['uid'],
			  'username' => $_G['username'],
			  'dateline' => TIMESTAMP,
			  'expiration' => 0,
			  'action' => 'DEL',
			  'status' => 1,
			  'magicid' => 0,
			  'stamp' => 0,
			  'reason' => srlang('warningdelete')	  
		 );
		C::t('#sanree_brand#forum_threadmod')->insert($newrow, true);
	}
	useractionlog($data['uid'], 'tid');
	require_once libfile('function/forum');
	require_once libfile('function/post');
	$bbcodeoff = 0;
	$smileyoff = 0;
	$parseurloff 	= 1;
	$htmlon			= 0;
	$usesig 		= 1;
	$tagstr			= '';
	$pinvisible 	= 0;
	$message = preg_replace('/\[attachimg\](\d+)\[\/attachimg\]/is', '[attach]\1[/attach]', $message);
	$pid = insertpost(array(
		'fid' => $data['fid'],
		'tid' => $tid,
		'first' => '1',
		'author' => $data['username'],
		'authorid' => $data['uid'],
		'subject' => $subject,
		'dateline' => $publishdate,
		'message' => $message,
		'useip' => $data['ip'],
		'invisible' => $pinvisible,
		'anonymous' => $isanonymous,
		'usesig' => $usesig,
		'htmlon' => $htmlon,
		'bbcodeoff' => $bbcodeoff,
		'smileyoff' => $smileyoff,
		'parseurloff' => $parseurloff,
		'attachment' => '0',
		'tags' => $tagstr,
		'replycredit' => 0,
		'status' => 0
	));
	$subject = str_replace("\t", ' ', $subject);
	$lastpost = "$tid\t".$subject."\t$_G[timestamp]\t$author";
	C::t('#sanree_brand#forum_forum')->update($data['fid'], array('lastpost' => $lastpost));
	C::t('#sanree_brand#forum_forum')->update_forum_counter($data['fid'], 1, 1, 1);
	return array($tid, $pid);	
}

function updateforum($data, $postthread) {
    global $_G;
	$tid = $data['tid'];
	$subject = $data['subject'];
	$message = $data['message'];
    $author = $data['username'];
	$authorid  = $data['uid'];
	$publishdate = TIMESTAMP;
	$closed = $postthread[closed];
	$replycredit=	$postthread[replycredit];
	$isgroup	=	$postthread[isgroup];
	$moderated	=	$postthread[moderated];
	$special	=	$postthread[special];
	$displayorder = ($data['isshow']==1&&$data['status'] == 1) ? 0 : -1;
	$digest		= $postthread[digest];
	
	$newthread = array(
		'fid' => $data['fid'],
		'posttableid' => $postthread[posttableid],
		'readperm' => $postthread[readperm],
		'price' => $postthread[price],
		'typeid' => $postthread[typeid],
		'sortid' => $postthread[sortid],
		'author' => $author,
		'authorid' => $data['uid'],
		'subject' => $subject,
		'dateline' => $publishdate,
		'lastpost' => $publishdate,
		'lastposter' => $author,
		'displayorder' => $displayorder,
		'digest' => $digest,
		'special' => $special,
		'attachment' => $postthread[attachment],
		'moderated' => $moderated,
		'status' => $postthread[status],
		'isgroup' => $isgroup,
		'replycredit' => $replycredit,
		'closed' => $closed
	);
	C::t('#sanree_brand#forum_thread')->update($tid,$newthread);
	if ($displayorder!=0) {
	     $newrow = array(
		  'tid' => $tid,
		  'uid' => $_G['uid'],
		  'username' => $_G['username'],
		  'dateline' => TIMESTAMP,
		  'expiration' => 0,
		  'action' => 'DEL',
		  'status' => 1,
		  'magicid' => 0,
		  'stamp' => 0,
		  'reason' => srlang('warningdelete')		  
		 );
		C::t('#sanree_brand#forum_threadmod')->insert($newrow, true);
	}
	useractionlog($data['uid'], 'tid');
	require_once libfile('function/forum');
	require_once libfile('function/post');

	$bbcodeoff = 0;
	$smileyoff = 0;
	$parseurloff = 1;
	$htmlon = 1;
	$usesig = 1;
	$tagstr = '';
	$pinvisible = 0;
	$message = preg_replace('/\[attachimg\](\d+)\[\/attachimg\]/is', '[attach]\1[/attach]', $message);
	$postdata=array(
		'fid' => $data['fid'],
		'tid' => $tid,
		'first' => '1',
		'subject' => $subject,
		'message' => $message,
		'invisible' => $pinvisible,
		'anonymous' => $isanonymous,
		'usesig' => $usesig,
		'htmlon' => $htmlon,
		'bbcodeoff' => $bbcodeoff,
		'smileyoff' => $smileyoff,
		'parseurloff' => $parseurloff,
		'attachment' => '0',
		'tags' => $tagstr,
		'replycredit' => 0,
		'status' => 0
	);
	C::t('#sanree_brand#forum_post')->update(0, $data[pid], $postdata);
	$subject = str_replace("\t", ' ', $subject);
	$lastpost = "$tid\t".$subject."\t$_G[timestamp]\t$author";
	C::t('#sanree_brand#forum_forum')->update($data['fid'], array('lastpost' => $lastpost));

}
function fixthreadcount($forumid) {
	$processed = 1;
	$threads = $posts = 0;
	$threadtables = array('0');
	$archive = 0;
	foreach(C::t('#sanree_brand#forum_forum_threadtable')->fetch_all_by_fid($forumid) as $data) {
		if($data['threadtableid']) {
			$threadtables[] = $data['threadtableid'];
		}
	}
	$threadtables = array_unique($threadtables);
	foreach($threadtables as $tableid) {
		$data = C::t('#sanree_brand#forum_thread')->count_posts_by_fid($forumid, $tableid);
		$threads += $data['threads'];
		$posts += $data['posts'];
		if($data['threads'] == 0 && $tableid != 0) {
			C::t('forum_forum_threadtable')->delete($forumid, $tableid);
		}
		if($data['threads'] > 0 && $tableid != 0) {
			$archive = 1;
		}
	}
	C::t('#sanree_brand#forum_forum')->update($forumid, array('archive' => $archive));

	$thread = C::t('#sanree_brand#forum_thread')->fetch_by_fid_displayorder($forumid);
	$lastpost = "$thread[tid]\t$thread[subject]\t$thread[lastpost]\t$thread[lastposter]";

	C::t('#sanree_brand#forum_forum')->update($forumid, array('threads' => $threads, 'posts' => $posts, 'lastpost' => $lastpost));
}

function fixthread($bid) {
    global $_G;
	$config = $_G['cache']['plugin']['sanree_brand']; 
	$bids = array();
	if (!is_array($bid)) {
	
		$bids[] = $bid;
		
	}
	else {
	
		$bids = $bid;
		
	}
	$category = C::t('#sanree_brand#sanree_brand_category')->fetch_all_category();
	$cates = array();
	foreach($category as $v) {
	
		$cates[$v[cateid]] = $v;
		
	}	
	foreach ($bids as $ibid) {
	
		$lastdata = C::t('#sanree_brand#sanree_brand_businesses')->fetch_first_bybid($ibid);
		$setarr =  array();
		$setarr = $lastdata;
		$setarr['forumtitle'] = $config['forumtitle'];
		$setarr['forumbody'] = $config['forumbody'];
		$setarr['fid'] = intval($config['bindingforum']);
		$setarr['catename'] = $cates[$lastdata[cateid]]['name'];
		$setarr['username'] = $lastdata['username'];
		
		if($setarr['poster']) {
			$valueparse = parse_url($setarr['poster']);
			if(isset($valueparse['host'])) {
				$result['poster'] = $setarr['poster'];
			} else {
				$setarr['poster'] = $_G['setting']['attachurl'].'forum/'.$setarr['poster'];
			}
		}	
		$postthread =  C::t('#sanree_brand#forum_thread')->fetch($lastdata['tid']);
		$setarr['propaganda'] = empty($setarr['propaganda']) ? srlang('zanwustr') : trim($setarr['propaganda']);
		$setarr['introduction']= empty($setarr['introduction']) ? srlang('zanwustr') : trim($setarr['introduction']);
		$setarr['contact']= empty($setarr['contact']) ? srlang('zanwustr') : trim($setarr['contact']);
		$setarr['qq']= empty($setarr['qq']) ? '' : trim($setarr['qq']);
		$setarr['tel']= empty($setarr['tel']) ? srlang('zanwustr') : trim($setarr['tel']);
		$setarr['address']= empty($setarr['address']) ? srlang('zanwustr') : trim($setarr['address']);
		$subject = $setarr['forumtitle'];
		$subject = str_replace('{name}', $setarr['name'], $subject);
		$subject = str_replace('{catename}', $setarr['catename'], $subject);
		$subject = isset($subject) ? dhtmlspecialchars(censor(trim($subject))) : '';
		$setarr['subject'] = !empty($subject) ? str_replace("\t", ' ', $subject) : $subject;	
		$message = $setarr['forumbody'];
		$message = str_replace('{name}', $setarr['name'], $message);
		$cateurl = $config['is_rewrite'] ? 'brand-index-'.$setarr['cateid'].'.html':'plugin.php?id=sanree_brand&tid='.$setarr['cateid'];
		$message = str_replace('{catename}', '[url='.$cateurl.']'.$setarr['catename'].'[/url]', $message);	
		$message = str_replace('{poster}', '[img]'.$setarr['poster'].'[/img]', $message);	
		$message = str_replace('{propaganda}', $setarr['propaganda'], $message);	
		$message = str_replace('{introduction}', $setarr['introduction'], $message);	
		$message = str_replace('{contact}', $setarr['contact'], $message);
		$message = str_replace('{qq}', $setarr['qq'], $message);
		$message = str_replace('{msn}', $setarr['msn'], $message);
		$message = str_replace('{wangwang}', $setarr['wangwang'], $message);
		$message = str_replace('{baiduhi}', $setarr['baiduhi'], $message);
		$message = str_replace('{skype}', $setarr['skype'], $message);		
		$message = str_replace('{tel}', $setarr['tel'], $message);
		$message = str_replace('{address}', $setarr['address'], $message);
		$setarr['weburl'] = trim(str_replace("http://", '', $setarr['weburl']));	
		$setarr['weburl'] = empty($setarr['weburl']) ? srlang('zanwustr') : '[url]http://'.$setarr['weburl'].'[/url]';	
		$setarr['message'] = str_replace('{weburl}', $setarr['weburl'], $message);
		if ($lastdata['tid'] && $lastdata['pid'] && $postthread) {
		
			updateforum($setarr, $postthread);
			setattachment($ibid, $lastdata['caid'], $lastdata[tid], $lastdata[pid]);
			
		}
		else {
		
			$thread = instertoforum($setarr);
			C::t('#sanree_brand#sanree_brand_businesses')->update($ibid, array('tid'=>$thread[0], 'pid'=>$thread[1]));
			setattachment($ibid, $lastdata['caid'], $thread[0], $thread[1]);
			
		}
		unset($postthread);
		unset($lastdata);

	}
	fixthreadcount(intval($config['bindingforum']));
}

function setattachment($bid, $caid, $tid, $pid){
    global $_G;
	$attachment = C::t('#sanree_brand#sanree_brand_attachment')->fetch_firstbyaid($caid);
	if ($attachment) {
		$aid = getattachnewaid($attachment['uid']);
		$insert = array(
			'aid' => $aid,
			'tid' => $tid,
			'pid' => $pid,
			'dateline' => $attachment['dateline'],
			'filename' => $attachment['filename'],
			'filesize' => $attachment['filesize'],
			'attachment' => $attachment['attachment'],
			'isimage' => $attachment['isimage'],
			'uid' => $attachment['uid'],
			'thumb' => $attachment['thumb'],
			'remote' => $attachment['remote'],
			'width' => $attachment['width'],
		);
		
		$target = getglobal('setting/attachdir').'./forum/'.$attachment['attachment'];
		list($one,$tow) = explode("/",$attachment['attachment']);
		$appVer = $_G['setting']['version'];
		if ($appVer=='X2') {
			require_once libfile('class/upload');
		}			
		discuz_upload::make_dir(getglobal('setting/attachdir').'./forum/'.$one);
		discuz_upload::make_dir(getglobal('setting/attachdir').'./forum/'.$one.'/'.$tow);
		$source = getglobal('setting/attachdir').'./category/'.$attachment['attachment'];
		!file_exists($target) && @copy($source, $target);
		$tableid = getattachtableid($tid);
		DB::update('forum_attachment_'.$tableid, array('tid' => 0, 'pid' => 0),"tid=".$tid);
		DB::update('forum_attachment', array('tid' => 0, 'pid' => 0),"tid=".$tid);
		C::t('#sanree_brand#forum_attachment_n')->insert($tableid, $insert);
		DB::update('forum_attachment', array('tid' => $tid, 'pid' => $pid, 'uid' => $attachment['uid'], 'tableid' => $tableid),"aid=".$aid);
		C::t('#sanree_brand#sanree_brand_businesses')->update($bid, array('aid'=>$aid));
		$tidata = C::t('#sanree_brand#forum_post')->fetch_threadpost_by_tid_invisible($tid);
		$message = $tidata['message'];
		$message = preg_replace('/\[poster\]/is', '[attach]'.$aid.'[/attach]', $message);
		C::t('#sanree_brand#forum_post')->update(0, $pid, array('message'=> $message, 'attachment' =>1), TRUE);
		$data=array(
			'tid' => $tid,
			'attachment' =>$attachment['attachment'],
			'remote' => 0
		);
		C::t('#sanree_brand#forum_threadimage')->delete($tid);
		C::t('#sanree_brand#forum_threadimage')->insert($data);
	}	
}

function chkformtitle($fid, $setconfig=NULL){
    global $_G;
	$config = isset($setconfig) ? $setconfig : $_G['cache']['plugin']['sanree_brand'];
	$forumdat=C::t('#sanree_brand#forum_forum')->fetch_info_by_fid($fid);
	$forumname = $forumdat['name'];
	$haveforumtitle = trim($config['haveforumtitle']);
	if ((strpos($forumname ,$haveforumtitle)===false)||(empty($haveforumtitle))) {
		$warningforumtitle = srlang('warningforumtitle');
		$warningforumtitle = str_replace('{haveforumtitle}', $haveforumtitle, $warningforumtitle);
		if (defined('IN_ADMINCP')) {
			cpmsg_error($warningforumtitle);
		}
		else {
			showmessage($warningforumtitle);
		}
	}
}
 
function sanreeupdatecache($cachename, $quantity = false) {
	global $_G;
	$config = $_G['cache']['plugin']['sanree_brand'];
	$cachearray = array('category', 'menu', 'help', 'hotbrandlist', 'newbrandlist',
	'recommendlist', 'slidelist');
	$cachename = in_array($cachename, $cachearray) ? $cachename : '';
	$quantity = $quantity ? $quantity : 6;
	if($cachename == 'slidelist') {
	
		$list = array();
		for($t=1; $t <3; $t++) {
			$slidelist = array();
			$slide = DB::fetch_first("SELECT * FROM ".DB::table('sanree_brand_slide').' where id='.$t);
			if ($slide) {
			   for($j=1;$j<6;$j++) {
			
					if ($slide['pic'.$j])  {
					
						$picurl = fiximage($slide['pic'.$j]);
						$link =  $slide['movie'.$j]; 
						$slidelist[] =  array('pic' => $picurl, 'url' => $link);
						  
					}
			   }
			}
			$list[$t] = $slidelist;
		}	
		save_syscache('sanree_brand_slidelist', $list);
				
	} elseif($cachename == 'recommendlist') {
	
				
		$template = trim($config['template']);
		$template = empty($template) ? 'default' : $template;		
		define('sr_brand_TPL', 'source/plugin/sanree_brand/tpl');
		define('sr_brand_IMG', sr_brand_TPL.'/'.$template.'/images');
		$adminadurl = $config['adminadurl'];
		$orderby = 't.istop desc,t.displayorder, t.dateline desc';
		$recommendlist=array();
		$ri = 0;
		for($itc=0; $itc<5; $itc++) {
			$wanted = sr_brand_IMG.'/wanted.gif';
			$recommendlist[$itc] = array('name'=> '', 'img' => $wanted, 'url' => $adminadurl);
		}
		foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_searchc(array('c.status=1', 't.isrecommend=1', 't.status=1'), $orderby, 0, 5) as $value) {
			if ($config['isbird'] && $config['isnice']) {
				$noneimg = '/topnopic.gif';
			} else {
				$noneimg = '/none180x135.jpg';
			}
			$value['recommendimg'] = newtheme($value['recommendimg'], 'common', $noneimg);
			$value['address'] = empty($value['address']) ? srlang('zanwustr') : $value['address'];
			if ($reurlmode==1) {
			
				$url = empty($value['weburl']) || $value['weburl']=='http://' ? getburl($value) : $value['weburl'];
				
			} else {
			
				$url = getburl($value);
				
			}
			$voter = C::t('#sanree_brand#sanree_brand_voter')->getvotetotal_by_tid(intval($value['tid']));
			
			list($firsttel) = explode(',', $value['tel']);
			
			$recommendlist[$ri]= array('name'=> $value['name'], 'img' => $value['recommendimg'], 'url' => $url, 'tel' => $firsttel, 'address' => $value['address'], 'satisfaction' => $voter[3]);
			$ri++;	
			
		}
		save_syscache('sanree_brand_recommendlist', $recommendlist);
	
	} elseif($cachename == 'newbrandlist') {
	
		$orderby = 't.dateline desc';
		$newbrandlist=array();
		foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_searchc(array('c.status=1', 't.isshow=1', 't.status=1'), $orderby, 0, $quantity) as $value) {
		
			$class = '';
			if (count($newbrandlist)<2) {
				$class = ' class="top2"';
			}
			if ($reurlmode==1) {
			
				$url = empty($value['weburl']) || $value['weburl']=='http://' ? getburl($value) : $value['weburl'];
				
			} else {
			
				$url = getburl($value);
				
			}
			$voter = C::t('#sanree_brand#sanree_brand_voter')->getvotetotal_by_tid(intval($value['tid']));
			$newbrandlist[]= array('name'=> $value['name'], 'url' => $url, 'class' => $class, 'satisfaction' => $voter[3], 'poster' => ($issmallpic==1 && !$config['isbird']) ? brand_getlogo($value['bid'], 0 , 90, 60, 'fixnone') : newtheme($value['poster']),);
			
		}	
		save_syscache('sanree_brand_newbrandlist', $newbrandlist);
		
	} elseif($cachename == 'hotbrandlist') {
	
		$orderby = 't.views desc';
		$hotbrandlist=array();
		$tel114version = $_G['setting']['plugins']['version']['sanree_tel114'] * 1000;
		foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_searchc(array('c.status=1', 't.isshow=1', 't.status=1'), $orderby, 0, 7) as $value) {
		
			$class = '';
			if (count($hotbrandlist)<2) {
				$class = ' class="top2"';
			}
			if ($reurlmode==1) {
			
				$url = empty($value['weburl']) || $value['weburl']=='http://' ? getburl($value) : $value['weburl'];
				
			} else {
			
				$url = getburl($value);
				
			}
			
			$voter = C::t('#sanree_brand#sanree_brand_voter')->getvotetotal_by_tid(intval($value['tid']));
			
			$value['tel114url'] = '';
			$tel114id = intval($value['tel114id']);
			if (($tel114id >0)&&($tel114version >=1121)) {
			
				$tel114url = $tel114_is_rewrite ? 'tel114-view-'.$tel114id.'.html' : 'plugin.php?id=sanree_tel114&mod=view&tid='.$tel114id;
				$value['tel114url'] = "<a href=\"".$tel114url."\" onclick=\"showWindow('showtelkey', this.href)\"><img height=18 width=18 src=\"source/plugin/sanree_brand/tpl/good/images/stel114.jpg\" /></a>";
				
			}
			
			$mcertificationplugin = C::t('#sanree_brand#common_plugin')->fetch_by_identifier('sanree_mcertification');
			$open = C::t('#sanree_brand#common_pluginvar')->fetch_all_by_pluginid($mcertificationplugin['pluginid']);
			if($open[0]['variable'] == 'isopen'){
				$mcertification_config['isopen'] = $open[0]['value'];
			}

			if($mcertification_config['isopen']){
				$mcertification = C::t('#sanree_mcertification#sanree_mcertification')->gettype_by_bid(intval($value['bid']));
				$mgif = 'source/plugin/sanree_mcertification/tpl/default/mcertification/brandimg/none.png';
				if ($mcertification) {
					$mgif = $mcertification['type'] ? 'source/plugin/sanree_mcertification/tpl/default/mcertification/brandimg/personal.png' : 'source/plugin/sanree_mcertification/tpl/default/mcertification/brandimg/company.png';
				}
			}
			list($firsttel) = explode(',', $value['tel']);
			$hotbrandlist[]= array(
				'name'=> $value['name'],
				'url' => $url,
				'class' => $class, 
				'tel' => $firsttel,
				'satisfaction' => $voter[0],
				'poster' => ($issmallpic==1 && !$config['isbird']) ? brand_getlogo($value['bid'], 0 , 210, 135, 'fixnone') : newtheme($value['poster']),
				'groupsmallicons' => getgroupsmallicons($value['groupid']),
				'tel114url' => $value['tel114url'],
				'sdiscount' => $value['discount'],
				'iscard' => intval($value['iscard']),
				'pbid' => intval($value['pbid']),
				'mcertification' => $mgif,
				
			);
			
		}	
		save_syscache('sanree_brand_hotbrandlist', $hotbrandlist);
		
	} elseif($cachename == 'help') {
	
		$help_config = array();
		$brandplugin = C::t('#sanree_brand#common_plugin')->fetch_by_identifier('sanree_brand_help');
		if($brandplugin) {
			$sanree_brand_help_pluginid = $brandplugin['pluginid'];
		}
		foreach(C::t('#sanree_brand#common_pluginvar')->fetch_all_by_pluginid($sanree_brand_help_pluginid) as $var) {
			if(strexists($var['type'], '_')) {
				continue;
			}
			$help_config[$var['variable']] = $var['value'];
		}		
		if (intval($help_config['isopen'])==1) {
		
			$helpsort = trim($help_config['helpsort']);
			$marr = explode("\r\n", $helpsort);
			$helpcatedata = array();
			foreach($marr as $row) {
				list($key , $val) = explode("=", $row);
				$helpcatedata[$key] = array($key, $val);
			}
			$helpcate=array();
			$helpcate[1] = array(1, $helpcatedata[1][1]);			
			$helpcate[1]['class'] = ' class="h_intro"';
			$helpcate[1][2] = C::t('#sanree_brand_help#sanree_brand_help')->fetch_all_by_searchc(' AND cateid=1 AND status=1', 'displayorder', 0, 3);	
			$helpcate[2] = array(1, $helpcatedata[2][1]);
			$helpcate[2]['class'] = ' class="h_rank"';
			$helpcate[2][2] = C::t('#sanree_brand_help#sanree_brand_help')->fetch_all_by_searchc(' AND cateid=2 AND status=1', 'displayorder', 0, 3);	
			$helpcate[3] = array(1, $helpcatedata[3][1]);
			$helpcate[3]['class'] = ' class="h_help"';
			$helpcate[3][2] = C::t('#sanree_brand_help#sanree_brand_help')->fetch_all_by_searchc(' AND cateid=3 AND status=1', 'displayorder', 0, 3);	
			$helpcate[4] = array(1, $helpcatedata[4][1]);
			$helpcate[4]['class'] = ' class="h_recommend"';
			$helpcate[4][2] = C::t('#sanree_brand_help#sanree_brand_help')->fetch_all_by_searchc(' AND cateid=4 AND status=1', 'displayorder', 0, 3);	
			$helpcate[5] = array(1, $helpcatedata[5][1]);
			$helpcate[5]['class'] = ' class="h_join"';
			$helpcate[5][2] = C::t('#sanree_brand_help#sanree_brand_help')->fetch_all_by_searchc(' AND cateid=5 AND status=1', 'displayorder', 0, 3);	
			save_syscache('sanree_brand_help', $helpcate);
			
		} else{
			save_syscache('sanree_brand_help', '');
		}
		
	} elseif($cachename == 'category') {
	
		$category = $admin_category = $user_category = $subcategory = array();
		$data= C::t('#sanree_brand#sanree_brand_category')->getcategory_by_pcateid(0);
		foreach($data as $cate) {
		
		    $cate['status']==1 && $user_category[$cate['cateid']] = $cate;
			$cate['status']==1 && $category[$cate['cateid']] = $cate;

			$admin_category[$cate['cateid']] = $cate;
			$subdata = C::t('#sanree_brand#sanree_brand_category')->getcategory_by_pcateid($cate['cateid']);
			$subcategories= array();
			foreach($subdata as $sub) {
				$subcategories[$sub['cateid']] = $sub;
				$sub['status']==1 && $category[$sub['cateid']] = $sub;
				$sub['name'] = "==>".$sub['name'];
				$sub['status']==1 && $user_category[$sub['cateid']] = $sub;
				$admin_category[$sub['cateid']] = $sub;
			}
			if ($cate['status']==1) {
				$subcategory[$cate['cateid']]= $cate;
				$subcategory[$cate['cateid']]['subcategories'] = $subcategories;
			}
		}
		save_syscache('sanree_brand_category', $category);
		save_syscache('sanree_brand_subcategory', $subcategory);
		save_syscache('sanree_brand_usercate', $user_category);
		save_syscache('sanree_brand_admincate', $admin_category);
		
	}	
	elseif($cachename == 'menu') {
		$topmenu =  C::t('#sanree_brand#sanree_brand_cmenu')->getusermenu(1);
		$footmenu =  C::t('#sanree_brand#sanree_brand_cmenu')->getusermenu(); 
		save_syscache('sanree_brand_topmenu', $topmenu);
		save_syscache('sanree_brand_footmenu', $footmenu);
	}
}	 

function sanreeloadcache($cachename) {
    global $_G;
	if(!isset($_G['cache']['sanree_brand_'.$cachename])) {
		loadcache('sanree_brand_'.$cachename);
	}
	$cache = &$_G['cache']['sanree_brand_'.$cachename];
	return $cache;
}


function myupload_icon_banner($bid, &$data, $file, $uid) {
	global $_G;
	$data['extid'] = empty($data['extid']) ? $data['fid'] : $data['extid'];
	if(empty($data['extid'])) return '';

	if($data['status'] == 3 && $_G['setting']['group_imgsizelimit']) {
		$file['size'] > ($_G['setting']['group_imgsizelimit'] * 1024) && showmessage('file_size_overflow', '', array('size' => $_G['setting']['group_imgsizelimit'] * 1024));
	}
	$appVer = $_G['setting']['version'];
	if ($appVer=='X2') {
		require_once libfile('class/upload');
	}	
	$upload = new discuz_upload();

	if(!$upload->init($file, 'category')) {
		return false;
	}

	if(!$upload->save()) {
		if(!defined('IN_ADMINCP')) {
			showmessage($upload->errormessage());
		} else {
			cpmsg($upload->errormessage(), '', 'error');
		}
	}
	$aid = getattachnewaid($uid);
	$insert = array(
		'aid' => $aid,
		'dateline' => $_G['timestamp'],
		'filename' => censor($upload->attach['name']),
		'filesize' => $upload->attach['size'],
		'attachment' => $upload->attach['attachment'],
		'isimage' => $upload->attach['isimage'],
		'uid' => $uid,
		'thumb' => $thumb,
		'remote' => $remote,
		'width' => $width,
	);
	C::t('#sanree_brand#sanree_brand_attachment')->insert($insert);
	return array($upload->attach['attachment'],$aid);
}

function writexml($data,$file='sanree_brand_flashad.xml') {
	global $_G;
    $data = stripcslashes($data);
	$dir = DISCUZ_ROOT.'./data/cache/';
	if(!is_dir($dir)) {
		dmkdir($dir, 0777);
	}
	if($fp = @fopen($dir.$file, 'wb')) {
		fwrite($fp, $data);
		fclose($fp);
	} else {
		exit('Can not write to cache files, please check directory ./data/ and ./data/cache/ .');
	}
}

function fiximage($picurl) {
	global $_G;
	if (strpos($picurl, '{pluginimg}')===0) {
		$pic = str_replace('{pluginimg}', 'source/plugin/sanree_brand/tpl/good/images', $picurl);
	}
	else {
		$valueparse = parse_url($picurl);
		if(!isset($valueparse['host'])) {
			$pic =  $_G['setting']['attachurl'].'common/'.$picurl;
		}
		else {
			$pic = $picurl;
		}
	}
	return $pic;
}

function getdistrictidname($id, &$catename, $addstr = '', $url = '', &$backrow = array(), $level = 0) {
    if ($id<1) return '';
	$result = C::t('#sanree_brand#sanree_brand_district')->fetch_first_by_id($id);
	if ($result){
	    $purl= str_replace('{id}',$result['id'],$url);
		$catename= !empty($purl) ? '<a href="'.$purl.'">'.$result['name']."</a>".$addstr.$catename : $result['name'].$addstr.$catename;
		$upid = $result['upid'];
		$backrow[$level] = $result;
		getdistrictidname($upid, $catename , " > ",$url, $backrow, $level+1);
	}
}

function getdistrictlist($upid, &$catename, $addstr = '') {
    if ($upid===NULL) return;
	$data= C::t('#sanree_brand#sanree_brand_district')->fetch_all_by_upid($upid);
	foreach($data as $row) {
	
	    $row[name] = $addstr.$row[name];
	    $catename[] = $row;
	    getdistrictlist($row['id'], $catename, $addstr."==");
		
	}
}

function srprofile_show($fieldid, $space=array()) {
	global $_G;

	if(empty($_G['cache']['profilesetting'])) {
		loadcache('profilesetting');
	}
	$field = $_G['cache']['profilesetting'][$fieldid];

	if(empty($field) || !$field['available'] || in_array($fieldid, array('uid', 'birthmonth', 'birthyear', 'birthprovince', 'resideprovince'))) {
		return false;
	}

	if($fieldid=='gender') {
		return lang('space', 'gender_'.intval($space['gender']));
	} elseif($fieldid=='birthday') {
		$return = $space['birthyear'] ? $space['birthyear'].' '.lang('space', 'year').' ' : '';
		if($space['birthmonth'] && $space['birthday']) {
			$return .= $space['birthmonth'].' '.lang('space', 'month').' '.$space['birthday'].' '.lang('space', 'day');
		}
		return $return;
	} elseif($fieldid=='birthcity') {
		return $space['srbirthprovince']
				.(!empty($space['srbirthcity']) ? ' '.$space['srbirthcity'] : '')
				.(!empty($space['srbirthdist']) ? ' '.$space['srbirthdist'] : '')
				.(!empty($space['srbirthcommunity']) ? ' '.$space['srbirthcommunity'] : '');
	} elseif($fieldid=='residecity') {
		return $space['resideprovince']
				.(!empty($space['residecity']) ? ' '.$space['residecity'] : '')
				.(!empty($space['residedist']) ? ' '.$space['residedist'] : '')
				.(!empty($space['residecommunity']) ? ' '.$space['residecommunity'] : '');
	} elseif($fieldid == 'site') {
		$url = str_replace('"', '\\"', $space[$fieldid]);
		return "<a href=\"$url\" target=\"_blank\">$url</a>";
	} elseif($fieldid == 'position') {
		return nl2br($space['office'] ? $space['office'] : $space['position']);
	} else {
		return nl2br($space[$fieldid]);
	}
}

function srshowdistrict($values, $elems=array(), $container='districtbox', $showlevel=null, $containertype = 'birth') {
	$html = '';
	if(!preg_match("/^[A-Za-z0-9_]+$/", $container)) {
		return $html;
	}
	$showlevel = !empty($showlevel) ? intval($showlevel) : count($values);
	$showlevel = $showlevel <= 4 ? $showlevel : 4;
	$upids = array(0);
	for($i=0;$i<$showlevel;$i++) {
		if(!empty($values[$i])) {
			$upids[] = intval($values[$i]);
		} else {
			for($j=$i; $j<$showlevel; $j++) {
				$values[$j] = '';
			}
			break;
		}
	}
	$options = array(1=>array(), 2=>array(), 3=>array(), 4=>array());
	if($upids && is_array($upids)) {
		foreach(C::t('#sanree_brand#sanree_brand_district')->fetch_all_by_upid($upids, 'displayorder', 'ASC') as $value) {
			if($value['level'] == 1 && ($value['id'] != $values[0] && ($value['usetype'] == 0 || !(($containertype == 'birth' && in_array($value['usetype'], array(1, 3))) || ($containertype != 'birth' && in_array($value['usetype'], array(2, 3))))))) {
				continue;
			}
			$options[$value['level']][] = array($value['id'], $value['name']);
		}
	}
	$names = array('province', 'city', 'district', 'community');
	for($i=0; $i<4;$i++) {
		if(!empty($elems[$i])) {
			$elems[$i] = dhtmlspecialchars(preg_replace("/[^\[A-Za-z0-9_\]]/", '', $elems[$i]));
		} else {
			$elems[$i] = ($containertype == 'birth' ? 'birth' : 'reside').$names[$i];
		}
	}

	for($i=0;$i<$showlevel;$i++) {
		$level = $i+1;
		if(!empty($options[$level])) {
			$jscall = "srshowdistrict('$container', ['$elems[0]', '$elems[1]', '$elems[2]', '$elems[3]'], $showlevel, $level, '$containertype')";
			$html .= '<select name="'.$elems[$i].'" id="'.$elems[$i].'" class="ps" onchange="'.$jscall.'" tabindex="1">';
			$html .= '<option value="">'.srlang('district_level_'.$level).'</option>';
			foreach($options[$level] as $option) {
				$selected = $option[0] == $values[$i] ? ' selected="selected"' : '';
				$html .= '<option did="'.$option[0].'" value="'.$option[1].'"'.$selected.'>'.$option[1].'</option>';
			}
			$html .= '</select>';
			$html .= '&nbsp;&nbsp;';
		}
	}
	return $html;
}

function brand_setting($fieldid, $space=array(), $showstatus=false, $ignoreunchangable = false, $ignoreshowerror = false) {
	global $_G;

	if(empty($_G['cache']['profilesetting'])) {
		loadcache('profilesetting');
	}
	$field = $_G['cache']['profilesetting'][$fieldid];

	if($fieldid=='birthcity') {
		if($field['unchangeable'] && !empty($space[$fieldid])) {
			return '<span>'.$space['srbirthprovince'].'-'.$space['srbirthcity'].'</span>';
		}
		$values = array(0,0,0,0);
		$elems = array('srbirthprovince', 'srbirthcity', 'srbirthdist', 'srbirthcommunity');
		if(!empty($space['srbirthprovince'])) {
			$html = srprofile_show('birthcity', $space);
			$html .= '&nbsp;(<a href="javascript:;" onclick="srshowdistrict(\'birthdistrictbox\', [\'birthprovince\', \'birthcity\', \'birthdist\', \'birthcommunity\'], 4, \'\', \'birth\'); return false;">'.lang('spacecp', 'profile_edit').'</a>)';
			$html .= '<p id="birthdistrictbox"></p>';
		} else {
			$html = '<p id="birthdistrictbox">'.srshowdistrict($values, $elems, 'birthdistrictbox', 1, 'birth').'</p>';
		}	
	}
	return $html;
}

function getdistrict($id) {
    $catename = '';
	$backrow = array();
	getdistrictidname($id, $catename, '', '', $backrow);
	$returnarr = array();
	foreach($backrow as $key => $row ) {
	   $returnarr[$key] = $row['name'];
	}
	return $returnarr;
}

function fixalbumpic($catid, $data) {
	$result  = C::t('#sanree_brand#sanree_brand_album_category')->get_by_catid($catid);
    if ($result) {
	
	    if (empty($result['pic'])) {
			C::t('#sanree_brand#sanree_brand_album_category')->update($catid, array('pic' => $data['pic']));
		}
		
	}
}

function mydeletealbums($albumids) {
	global $_G;
	$pics = array();
	$allowmanage = checkperm('managealbum');
	$haveforumpic = false;
	$query = C::t('#sanree_brand#sanree_brand_album_category')->fetch_all($albumids);
	foreach($query as $value) {
		if($allowmanage || $value['uid'] == $_G['uid']) {
			$pics[] = $value['catid'];
		}
	}
	if(empty($pics)) return array();
	$picsstr = ' AND catid IN (\''.implode($pics, ',').'\')';
	C::t('#sanree_brand#sanree_brand_album_category')->delete($pics);
	$delids = C::t('#sanree_brand#sanree_brand_album')->fetch_albumid_by_searchkey($picsstr,20);
	$picids = array();
	foreach($delids as $value) {
	    $picids[] = $value['albumid'];
	}
	if(empty($picids)) return array();
	mydeletepics($picids);
}

function mydeletepics($picids) {
	global $_G;
	$albumids = $sizes = $pics = $newids = array();
	$allowmanage = checkperm('managealbum');

	$haveforumpic = false;
	$query = C::t('#sanree_brand#sanree_brand_album')->fetch_all($picids);
	foreach($query as $value) {
		if($allowmanage || $value['uid'] == $_G['uid']) {
			$pics[] = $value;
			$newids[] = $value['albumid'];
			$sizes[$value['uid']] = $sizes[$value['uid']] + $value['size'];
			$albumids[$value['albumid']] = $value['albumid'];
			if(!$haveforumpic && $value['remote'] > 1) {
				$haveforumpic = true;
			}
		}
	}
	if(empty($pics)) return array();
	C::t('#sanree_brand#sanree_brand_album')->delete($newids);
	$remotes = array();
	include_once libfile('function/home');
	foreach ($pics as $pic) {
		pic_delete($pic['pic'], 'album', $pic['thumb'], $pic['remote']);
	}
}

function getmaxalbumcategory($bid, $uid) {

    $data = C::t('#sanree_brand#sanree_brand_businesses')->usergetmaxalbumcategory_by_bid($bid, $uid);
	return intval($data['maxalbumcategory']);
	
}

function getmaxalbumbycatid($catid, $uid) {

    $data = C::t('#sanree_brand#sanree_brand_album_category')->get_by_catid($catid);
    $data = C::t('#sanree_brand#sanree_brand_businesses')->usergetmaxalbumcategory_by_bid($data[bid], $uid);
	return intval($data['maxalbum']);
	
}

function srhooks() {

	global $_G;
	$hscript = 'plugin';
	$script= 'sanree';
	$type='funcs';
	hookscript($script, $hscript, $type);
	
}

function add_diy_template($template, $arr){

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
function sysfilecache($data, $file) {
	global $_G;
    $data = stripcslashes($data);
	$dir = DISCUZ_ROOT.'./data/sysdata/';
	if(!is_dir($dir)) {
		dmkdir($dir, 0777);
	}
	if($fp = @fopen($dir.'cache_'.$file, 'wb')) {
		fwrite($fp, $data);
		fclose($fp);
	} else {
		exit('Can not write to cache files, please check directory ./data/ and ./data/sysdata/ .');
	}
}

function diystylelog($data, $file) {
	global $_G;
    $data = stripcslashes($data);
	$dir = DISCUZ_ROOT.'./data/cache/';
	if(!is_dir($dir)) {
		dmkdir($dir, 0777);
	}
	if($fp = @fopen($dir.$file, 'wb')) {
		fwrite($fp, $data);
		fclose($fp);
	} else {
		exit('Can not write to cache files, please check directory ./data/ and ./data/cache/ .');
	}
}

function fixhtmlstr($str) {
	$str = str_replace('&amp;', '&', $str);
	$str = str_replace('&quot;', '"', $str);
	$str = str_replace('&#039;', "\'", $str);
	$str = str_replace('&lt;', '<', $str);
	$str = str_replace('&gt;', '>', $str); 
	$str = str_replace("\\\"", '"', $str);
	$str = str_replace("\'", "'", $str);    
	return $str;
}
function fixhtmlstrex($str) {
	$str = str_replace('&', '&amp;', $str);
	$str = str_replace('"', '&quot;', $str);
	$str = str_replace("\'", '&#039;', $str);
	$str = str_replace('<', '&lt;', $str);
	$str = str_replace('>', '&gt;', $str);    
	return $str;
}

function diystyle() {

	global $_G;
	$style = '';
	$condition = array();
	$condition[]= 'status=1';
	$orderby = 'displayorder, diystyleid';
	$stamplist=C::t('#sanree_brand#sanree_brand_diystyle')->fetch_all_by_search($condition, $orderby);
	foreach($stamplist as $key => $val) {
	
	    $val['content'] = fixhtmlstr(str_replace('stylename', $val['name'], $val['content']));
		
		$style.= "$val[content]\r\n";
		
	}		
	diystylelog($style, "sanree_brand_diy.css");
	
}

function diytemplate($diytemplateid = 0) {

	global $_G;
	$style = '';
	$condition = array();
	$condition[]= 'status=1';
	if ($diytemplateid>0) {
	
		$condition[]= 'diytemplateid='.$diytemplateid;
		
	}
	$orderby = 'displayorder, diytemplateid';
	$stamplist=C::t('#sanree_brand#sanree_brand_diytemplate')->fetch_all_by_search($condition, $orderby);
	foreach($stamplist as $key => $val) {
	
	    $val['name'] = $val['issys']==1 ? srlang('neizhi').$val['name'] : $val['name'];
		$arr = array(
			'name' => $val['name'],
			'blockclass' => 'sanree_brand',
		);	
		$val['content'] = fixhtmlstr($val['content']);
		add_diy_template($val['content'], $arr);
		
	}		
	
}

function isstylename($name) {
	return preg_match("/^[a-zA-Z]+[a-zA-Z0-9_]*$/i", $name);
}

function branddomain($append = TRUE) {

	global $_G;
	$config = $_G['cache']['plugin']['sanree_brand'];
	$domain = trim($config['domain']);
	$appendstr = $append ? '/' : '';
	if (!empty($domain)) {
	
		$_G['bsiteurl'] = 'http://'.$domain.$appendstr;
		return $_G['bsiteurl'];
		
	}
	return '';
	
}

function fixmodule($start, $perpage) {
	global $_G, $defaultconfig;

	$next = false;
	$adddatafield = array();
	foreach(C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_all_column() as $key =>$column)	{

		$columnname = $column[data];
		$type = $column[type];
		if ($type=='radio') {
			$adddatafield[$columnname]= $defaultconfig['module'][$columnname];
		}
	
	}
	foreach(C::t('#sanree_brand#sanree_brand_businesses')->range($start,$perpage) as $bid => $value) {
		$next = true;
		if (C::t('#sanree_brand#sanree_brand_businesses_module')->count_by_where(' AND bid='.$bid)<1) {

			$addarray = array();
			$addarray= $adddatafield;
			$addarray[bid] = $bid;
			C::t('#sanree_brand#sanree_brand_businesses_module')->insert($addarray);
		}
	}
	return $next;
}

function fixalbumall($start, $perpage) {
	$next = false;
	foreach(C::t('#sanree_brand#sanree_brand_businesses')->range($start,$perpage) as $bid => $value) {
	
		$next = true;
		fixalbum(intval($value['bid']));
		
	}
	return $next;
}


function srcode2($text){

	require_once DISCUZ_ROOT.'/source/plugin/sanree_brand/class/class_qrcode.php';
	$outfile = false;
	$logofilename = DISCUZ_ROOT.'./source/plugin/sanree_brand/code2/logo.png';
	$bgfilename = DISCUZ_ROOT.'./source/plugin/sanree_brand/code2/big.png';
	$level = 0;
	$size = 3;
	$margin = 1;
	$saveandprint = false;
	$borderrgb = array('r'=> 0xFF, 'g' => 0x62, 'b' => 0);
	QRcode::srpng($text, $outfile, $logofilename, $bgfilename, $borderrgb, $level, $size, $margin, $saveandprint);

}

function srcode2show($text,$brandlogo = false){

	global $_G;
	$config = $_G['cache']['plugin']['sanree_brand'];
	require_once DISCUZ_ROOT.'/source/plugin/sanree_brand/class/class_qrcode.php';
	$outfile = false;
	if ($code2_isbrand==1 && $brandlogo) {
		$logofilename = $brandlogo;
	} else {
		if ($code2_logo) {
			$logofilename = DISCUZ_ROOT.$code2_logo;
		} else {
			$logofilename = false;
		}
	}
	if ($code2_bgfile) {
		$bgfilename = DISCUZ_ROOT.$code2_bgfile;
	} else {
		$bgfilename = false;
	}
	$level = 0;
	$size = 3;
	$margin = 1;
	$saveandprint = false;
	$borderrgb = hColor2RGB($config['code2_bgcolor']);
	QRcode::srpng($text, $outfile, $logofilename, $bgfilename, $borderrgb, $level, $size, $margin, $saveandprint);

}
//www-FX8-co
?>