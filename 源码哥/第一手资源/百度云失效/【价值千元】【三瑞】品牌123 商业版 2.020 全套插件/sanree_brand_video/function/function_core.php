<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: function_core.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function video_getgroupmax($bid) {
	global $_G;
	$brandresult = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($bid);
	$groupid= $brandresult['groupid'];
	$group = C::t('#sanree_brand#sanree_brand_group')->get_by_groupid($groupid);
	if ($group) {
		$brandmoduleresult = C::t('#sanree_brand#sanree_brand_group_module')->fetch_by_groupid($group[groupid]);
		return intval($brandmoduleresult['maxvideo']);
	}
	return 20;
}

function video_modlang($word) {
	global $_G;
	return lang('plugin/sanree_brand_video', $word);
}

function video_notice($bid, $act) {
    global $_G;
	if (in_array($act, array('video_pass' , 'video_pending', 'video_refuse', 'video_adminpass'))) {
		$bids = array();
		if (!is_array($bid)) {
		
			$bids[] = $bid;
		} else {
		
			$bids = $bid;
			
		}	
		foreach ($bids as $ibid) {
		
			$row = C::t('#sanree_brand_video#sanree_brand_video')->fetch_first_bycid($ibid);
			if ($row) {
			
				$welcomformat = video_modlang($act);
				$user1txt = '<a href="home.php?mod=space&amp;uid='.$row['uid'].'">'.$row['username'].'</a>';
				$turl = video_getburl($row);
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
				
			}
			
		}
		
	}
	
}
function video_getitemurl($cid){
    global $_G;
	$config = $_G['cache']['plugin']['sanree_brand_video']; 
	$is_rewrite = $config['is_rewrite'];
	if ($is_rewrite) {
		$keylist = array('tid');
		$tid  = $cid;
		$urlitemmode = empty($config['urlitemmode']) ? "video-videoshow-{tid}.html": $config['urlitemmode'];
		foreach($keylist as $line) {
			$urlitemmode = str_replace("{".$line."}",$$line ,$urlitemmode);
		}
		return $urlitemmode;
	}
	return 'plugin.php?id=sanree_brand_video&mod=videoshow&tid='.$cid;
}

function video_getburl($value){
    global $_G;
	$config = $_G['cache']['plugin']['sanree_brand_video']; 
	$is_rewrite = $config['is_rewrite'];
	$group = C::t('#sanree_brand#sanree_brand_group')->get_by_groupid(intval($value['groupid']));
	if ($group['urlmod']==1) {
	    if ($is_rewrite) {
		    $keylist = array('tid');
			$tid  = $value['cid'];
		    $urlitemmode = empty($config['urlitemmode']) ? "video-videoshow-{tid}.html": $config['urlitemmode'];
			foreach($keylist as $line) {
				$urlitemmode = str_replace("{".$line."}",$$line ,$urlitemmode);
			}
			return $urlitemmode;
		}
		return 'plugin.php?id=sanree_brand_video&mod=videoshow&tid='.$value['cid'];
	}
	return 'forum.php?mod=viewthread&amp;tid='.$value['tid'];
}

function video_getcateurl($param,$zero = FALSE){
    global $_G;
	$config = $_G['cache']['plugin']['sanree_brand_video']; 
	$is_rewrite = $config['is_rewrite'];
	$keylist = array('tid', 'did', 'filter', 'listmode');
	$extra = '';
	foreach($keylist as $key =>$val) {
	    if (isset($param[$val])) {
		    $$val = $param[$val];
		}
		else {
			if ($zero) {
			    $$val 	= 0;
			}
			else {
				$$val 	= intval($_G['sr_'.$val]);
			}
		}
		($$val>0) && $extra.="&$val=".$$val;
	}
    if ($is_rewrite) {
	    $urllistmode = empty($config['urllistmode']) ? "video-index-{tid}-{did}-{filter}-{listmode}.html": $config['urllistmode'];
		foreach($keylist as $line) {
		    $urllistmode = str_replace("{".$line."}",$$line ,$urllistmode);
		}
		return $urllistmode;
	}
	return "plugin.php?id=sanree_brand_video&mod=index".$extra;
}

function video_getusermodeurl($value){
    global $_G;
	$config = $_G['cache']['plugin']['sanree_brand_video']; 
	$is_rewrite = $config['is_rewrite'];
	if ($is_rewrite) {
		$keylist = array('tid');
		$tid  = $value['bid'];
		$urlvideousermode = empty($config['urlvideousermode']) ? 'video-uservideo-{tid}.html': $config['urlvideousermode'];
		foreach($keylist as $line) {
			$urlvideousermode = str_replace("{".$line."}",$$line ,$urlvideousermode);
		}
		return $urlvideousermode;
	}
	return 'plugin.php?id=sanree_brand_video&mod=uservideo'.'&tid='.$value['bid'];
}

function video_getmodeurl(){
    global $_G;
	$config = $_G['cache']['plugin']['sanree_brand_video']; 	
	$is_rewrite = $config['is_rewrite'];
	if ($is_rewrite) {
		$urlvideomode = empty($config['urlvideomode']) ? "video.html": $config['urlvideomode'];
		return $urlvideomode;
	}
	return 'plugin.php?id=sanree_brand_video';
}

function video_updatecache($cachename) {
	global $_G;

	$cachearray = array('category');
	$cachename = in_array($cachename, $cachearray) ? $cachename : '';
	if($cachename == 'category') {
	
		$category = $admin_category = $user_category = $subcategory = array();
		$data= C::t('#sanree_brand_video#sanree_brand_video_category')->getcategory_by_pcateid(0);
		foreach($data as $cate) {
		
		    $cate['status']==1 && $user_category[$cate['cateid']] = $cate;
			$cate['status']==1 && $category[$cate['cateid']] = $cate;

			$admin_category[$cate['cateid']] = $cate;
			$subdata = C::t('#sanree_brand_video#sanree_brand_video_category')->getcategory_by_pcateid($cate['cateid']);
			$subcategories= array();
			foreach($subdata as $sub) {
				$subcategories[$sub['cateid']] = $sub;
				$sub['status']==1 && $category[$sub['cateid']] = $sub;
				$sub['name'] = "==>".$sub['name'];
				$sub['status']==1 && $user_category[$sub['cateid']] = $sub;
				$admin_category[$sub['cateid']] = $sub;
			}
			
			$subcategory[$cate['cateid']]= $cate;
			$subcategory[$cate['cateid']]['subcategories'] = $subcategories;
		}
		save_syscache('sanree_brand_video_category', $category);
		save_syscache('sanree_brand_video_subcategory', $subcategory);
		save_syscache('sanree_brand_video_usercate', $user_category);
		save_syscache('sanree_brand_video_admincate', $admin_category);
		
	}	
}	
function video_loadcache($cachename) {
    global $_G;
	if(!isset($_G['cache']['sanree_brand_video_'.$cachename])) {
		loadcache('sanree_brand_video_'.$cachename);
	}
	$cache = &$_G['cache']['sanree_brand_video_'.$cachename];
	return $cache;
} 

function video_instertoforum($data) {
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
	$bbcodeoff = 0;//checkbbcodes($message, 0);
	$smileyoff = 0;//checksmilies($message, 0);
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

function video_updateforum($data, $postthread) {
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
function video_getmediatype($mediaUrl) {
    $params = explode('.', $mediaUrl);
	$ext = '';
	$n = count($params);
	if ($n>1) {
		$ext = trim($params[$n-1]);	
	}
	$ext = !in_array($ext, array('mp3', 'wma', 'ra', 'rm', 'ram', 'mid', 'asx', 'wmv', 'avi', 'mpg', 'mpeg', 'rmvb', 'asf', 'mov', 'flv', 'swf')) ? 'x' : $ext;
	if($ext == 'x') {
		if (preg_match('/^mms:\/\//',$mediaUrl)) {
			$ext = 'mms';
		} elseif (preg_match('/^(rtsp|pnm):\/\//',$mediaUrl)) {
			$ext = 'rtsp';
		}
	}	
	return $ext;
}

function video_fixthread($cid) {

    global $_G;
	$config = $_G['cache']['plugin']['sanree_brand_video'];
	if ($config['isopen']!=1) {
		return;
	}		 
	$cids = array();
	if (!is_array($cid)) {
	
		$cids[] = $cid;
		
	} else {
	
		$cids = $cid;
		
	}
	$category = C::t('#sanree_brand_video#sanree_brand_video_category')->fetch_all_category();
	$cates = array();
	foreach($category as $v) {
	
		$cates[$v[cateid]] = $v;
		
	}	
	
	foreach ($cids as $icid) {
	
		$lastdata = C::t('#sanree_brand_video#sanree_brand_video')->fetch_first_bycid($icid);
		$setarr =  array();
		$setarr = $lastdata;
		$setarr['forumtitle'] = $config['forumtitle'];
		$setarr['forumbody'] = $config['forumbody'];
		$setarr['fid'] = intval($config['bindingforum']);
		$setarr['catename'] = $cates[$lastdata[cateid]]['name'];
		$setarr['username'] = $lastdata['username'];
		
		if($setarr['smallpic']) {
		
			$valueparse = parse_url($setarr['smallpic']);
			if(isset($valueparse['host'])) {
			
				$result['smallpic'] = $setarr['smallpic'];
				
			} else {
			
				$setarr['smallpic'] = $_G['setting']['attachurl'].'category/'.$setarr['smallpic'];
				
			}
			
		}	
		$postthread =  C::t('#sanree_brand#forum_thread')->fetch($lastdata['tid']);
		$subject = $setarr['forumtitle'];
		$subject = str_replace('{name}', $setarr['name'], $subject);
		$subject = str_replace('{catename}', $setarr['catename'], $subject);
		$subject = isset($subject) ? dhtmlspecialchars(censor(trim($subject))) : '';
		$setarr['subject'] = !empty($subject) ? str_replace("\t", ' ', $subject) : $subject;	
		$message = $setarr['forumbody'];
		$message = str_replace('{name}', $setarr['name'], $message);
		$message = str_replace('{videourl}', $setarr['videourl'], $message);
		$message = str_replace('{mtype}', video_getmediatype($setarr['videourl']), $message);
		$message = str_replace('{mwidth}', intval($setarr['width']), $message);
		$message = str_replace('{mheight}', intval($setarr['height']), $message);
		$message = str_replace('{logo}', '[img]'.$setarr['smallpic'].'[/img]', $message);
		$setarr['message'] = $message;
		if ($lastdata['tid']&&$lastdata['pid']&&$postthread) {
		
			video_updateforum($setarr, $postthread);
			video_setattachment($icid, $lastdata['aids'], $lastdata[tid], $lastdata[pid], $lastdata[homeaid], $lastdata[uid]);
			
		} else {
		
			$thread = video_instertoforum($setarr);
			C::t('#sanree_brand_video#sanree_brand_video')->update($cid, array('tid'=>$thread[0],'pid'=>$thread[1]));
			video_setattachment($icid, $lastdata['aids'], $thread[0], $thread[1], $lastdata[homeaid], $lastdata[uid]);
			
		}
		unset($postthread);
		unset($lastdata);
				
	}
	
	fixthreadcount(intval($config['bindingforum']));
}


function video_fiximage($picurl) {
	global $_G;
	if (strpos($picurl, '{pluginimg}')===0) {
		$pic = str_replace('{pluginimg}', 'source/plugin/sanree_brand_video/tpl/default/images', $picurl);
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
//From:www_YMG6_COM
?>