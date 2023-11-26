<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: hook.class.php $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
define('$pidentifier', 'video');
$modfile=DISCUZ_ROOT.'./source/plugin/sanree_brand_video/function/function_core.php';
@require_once($modfile);
$modfile = DISCUZ_ROOT.'./source/plugin/sanree_brand_video/function/function_module.php';
@require_once($modfile);

class plugin_sanree_brand_video {

	function sanreebrandmanagemenu($param){
	
		global $_G;
		$config = $_G['cache']['plugin']['sanree_brand_video'];
		if (!$config['isopen']) {
		
			return;
			
		}	
		$brand_config = $_G['cache']['plugin']['sanree_brand'];
		if (!$brand_config['isopen']) {
		
			return;
			
		}			
		if ($param['bid']<1) {
			return;
		}
		$isvideo = C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_by_modename('isvideo', $param['bid']);	
		if ($isvideo!=1) {
		
			return;
			
		}		
		$_G['sanree_brand_managemenus'][] = array(
			'displayorder'=> 700, 
			'window' => 0,
			'name'=>'myvideo', 
			'title'=> video_modlang('myvideo'), 
			'url'=> 'plugin.php?id=sanree_brand_video&mod=myvideo',
			'class' => '',
			'image' => 'source/plugin/sanree_brand_video/tpl/default/images/myvideo.png'
		);
		$_G['sanree_brand_managemenus'][] = array(
			'displayorder'=> 701, 
			'window' => 1,
			'name'=>'publisheddlg', 
			'title'=> video_modlang('post_new_video'), 
			'url'=> 'plugin.php?id=sanree_brand_video&mod=published',
			'class' => '',
			'addhtml' => '<link rel="stylesheet" type="text/css" id="sanree_brand_video" href="source/plugin/sanree_brand_video/tpl/default/sanree_brand_video.css" />',
			'image' => 'source/plugin/sanree_brand_video/tpl/default/images/post_new_video.png'
		);
		
	}
	
      function sanreemoduleupdate($param) {
	  
	      global $_G;
	      $bid = intval($param[bid]);
		  $data = $param[data];
          $isvideo = $data[isvideo];
		  $gid = array();
		  if ($bid<1) return;
		  foreach(C::t('#sanree_brand_video#sanree_brand_video')->fetch_all_by_bid($bid) as $data) {

			  C::t('#sanree_brand_video#sanree_brand_video')->update($data[gid], array('isshow' => $isvideo));
			  $gid[] = $data[gid];
			  
		  }
		  video_fixthread($gid);
		  
	  }
	  
	  function discuzcode($data) {
	  
			global $_G,$thread;
			$brandconfig = $_G['cache']['plugin']['sanree_brand'];
			if (!$brandconfig['isopen']) {
			
				return;
				
			}			
			$config = $_G['cache']['plugin']['sanree_brand_video'];
			if (!$config['isopen']) {
			
				return;
				
			}
			$bindingforum = intval($config['bindingforum']);
			if ($bindingforum<1) return;
			if ($bindingforum != $thread['fid']) {	
			
				return;
				
			}
			
			$result = C::t('#sanree_brand_video#sanree_brand_video')->getvideo_by_tid($_G[tid]);
			$brandurl= video_brandgetburl($result[bid]);
			$brandinfo =  '<a href=\''.$brandurl.'\' target=\'_blank\'>'.$result['brandname'].'</a>';
			$cstatus = video_modlang('hookhtml');
			$cstatus = str_replace('{viewnum}', intval($result['viewnum']), $cstatus );
			$cstatus = str_replace('{downnum}', intval($result['downnum']), $cstatus );
			$_G['discuzcodemessage'] = str_replace('{cstatus}', $cstatus, $_G['discuzcodemessage']);
			$_G['discuzcodemessage'] = str_replace('{brandinfo}', $brandinfo, $_G['discuzcodemessage']);

			$_G['discuzcodemessage'] = str_replace('{priceunit}', $config['selectpriceunitshow'][$result['priceunit']].' ', $_G['discuzcodemessage']);
			
			if($data['caller'] == 'discuzcode') {
			
				$_G['discuzcodemessage'] = preg_replace("/\s?\[legend\](.+?)\[\/legend\]\s?/ies", '$this->sanreetemplate(\'legend\',\'\\1\')', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = preg_replace("/\s?\[fieldset\](.+?)\[\/fieldset\]\s?/ies", '$this->sanreetemplate(\'fieldset\',\'\\1\')', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = preg_replace("/\s?\[label\](.+?)\[\/label\]\s?/ies", '$this->sanreetemplate(\'label\',\'\\1\')', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = preg_replace("/\s?\[logo\](.+?)\[\/logo\]\s?/ies", '$this->sanreetemplate(\'logo\',\'\\1\')', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = preg_replace("/\s?\[qq\](.+?)\[\/qq\]\s?/ies", '$this->sanreetemplate(\'qq\',\'\\1\')', $_G['discuzcodemessage']);
				
			} else {
			
				$_G['discuzcodemessage'] = preg_replace("/\s?\[legend\](.+?)\[\/legend\]\s?/ies", '', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = preg_replace("/\s?\[fieldset\](.+?)\[\/fieldset\]\s?/ies", '', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = preg_replace("/\s?\[label\](.+?)\[\/label\]\s?/ies", '', $_G['discuzcodemessage']);
				
			}
			
	  }
	  
	  function sanreetemplate($tag, $param = '') {
	  
	        global $_G,$thread;
			$brandconfig = $_G['cache']['plugin']['sanree_brand'];
			if (!$brandconfig['isopen']) {
			
				return '';
				
			}
			$config = $_G['cache']['plugin']['sanree_brand_video'];
			if (!$config['isopen']) {
			
				return '';
				
			}		
	
			if ($tag=='qq') {
			
			    return '<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$param.'&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:'.$param.':16" alt="'.lang('plugin/sanree_brand','qqtip').'" title="'.lang('plugin/sanree_brand','qqtip').'" align="absmiddle"></a><br>';
				
			} else {
			
			    return '<'.$tag.'>'.$param.'</'.$tag.'>';
				
			}
			
	  }
	
	function sanreebrandusermenu($param){
	
		global $_G;
		$config = $_G['cache']['plugin']['sanree_brand_video'];
		if (!$config['isopen']) {
		
			return;
			
		}		
		if ($param['bid']<1) {
			return;
		}
		$isvideo = C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_by_modename('isvideo', $param['bid']);	
		if ($isvideo!=1) {
		
			return;
			
		}	
		$modulemenuname = empty($config['modulemenuname']) ? video_modlang('itemvideo') : $config['modulemenuname'];
		$_G['sanree_brand_menus']['video'] = array('name'=>'video', 'title'=> $modulemenuname, 'url'=>video_getusermodeurl($param),'class' => ' class="normal"');
		
	}
		  
}

//class plugin_identifier_CURSCRIPT extends plugin_identifier {

class plugin_sanree_brand_video_plugin extends plugin_sanree_brand_video {
///function CURMODULE_USERDEFINE[_output]()
	function sanree_brand_userbar(){
	
		global $_G;
		$actives = array();
		$view = '';
		if ($_G['sr_id']=='sanree_brand_video') {
			$view = ' class="a"';
		}
		$config = $_G['cache']['plugin']['sanree_brand_video'];
		if (!$config['isopen']) {
		
			return;
			
		}
		$gcount[0] = C::t('#sanree_brand_video#sanree_brand_video')->count_by_wherec(array('t.uid='.$_G['uid'],'c.status=1','t.status=1'));
		$gcount[1] = C::t('#sanree_brand_video#sanree_brand_video')->count_by_wherec(array('t.uid='.$_G['uid'],'c.status=1','t.status=0'));
		$gcount[2] = C::t('#sanree_brand_video#sanree_brand_video')->count_by_wherec(array('t.uid='.$_G['uid'],'c.status=1','t.status=-1'));
		$gcount[3] = $gcount[0] + $gcount[1] +$gcount[2];		
		$result = '<li'.$view.'><a href="plugin.php?id=sanree_brand_video&mod=myvideo&view=index">'.lang('plugin/sanree_brand_video','myvideo').'('.$gcount[3].')</a></li>';
		return $result;
		
	}
		
}

class plugin_sanree_brand_video_forum extends plugin_sanree_brand_video {

    function viewthread_postfooter_output(){
	
	    global $_G;
		$config = $_G['cache']['plugin']['sanree_brand_video'];
		if (!$config['isopen']) {
		
		    return;
			
		}
		if ($_G[uid]==1) return;
		$action = $_GET['action'];
		$bindingforum = intval($config['bindingforum']);
		if ($bindingforum<1) return;
		if ((CURSCRIPT == 'forum') && $bindingforum == $_G['fid']) {
		
			$_G['group']['alloweditpost'] = 0;
			$_G['group']['allowdelpost'] = 0;
			$_G['group']['allowclosethread'] = 0;
			$_G['group']['allowmovethread'] = 0;
			$_G['group']['allowedittypethread'] = 0;
			$_G['group']['allowcopythread'] = 0;
			$_G['group']['allowsplitthread'] = 0;
			$_G['group']['allowrepairthread'] = 0;
			$_G['group']['allowwarnpost'] = 0;
			$_G['group']['allowmergethread'] = 0;
			$_G['group']['allowbanpost'] = 0;
			
		}
			
	}
	
	function viewthread_title_extra_output() {
	    global $_G;
		$config = $_G['cache']['plugin']['sanree_brand_video'];
		if (!$config['isopen']) {
		
		    return '';
			
		}
		$bindingforum = intval($config['bindingforum']);
		if ($bindingforum<1) return '';
		if ((CURSCRIPT == 'forum') && $bindingforum == $_G['fid']) {
		
		   return $config['forumwarning'];
		   
		}			
		return '';
		
	}
	
	function forumdisplay_top_output() {
	
	    global $_G,$fastpost;
		$config = $_G['cache']['plugin']['sanree_brand_video'];
		if (!$config['isopen']) {
		
		    return;
			
		}
		if ($_G[uid]==1) return;
		$action = $_GET['action'];
		$bindingforum = intval($config['bindingforum']);
		if ($bindingforum<1) return;
		if ((CURSCRIPT == 'forum') && $bindingforum == $_G['fid']) {
		
		   $fastpost = 0;
		   
		}
		
	}
	
	function viewthread_middle_output() {
	
	    global $_G,$allowfastpost,$thread;
		$config = $_G['cache']['plugin']['sanree_brand_video'];
		if (!$config['isopen']) {
		
		    return;
			
		}
		if ($_G[uid]==1) return;
		$action = $_GET['action'];
		$bindingforum = intval($config['bindingforum']);
		if ($bindingforum<1) return;
		if ((CURSCRIPT == 'forum') && $bindingforum == $_G['fid']) {
		
		   $result = C::t('#sanree_brand_video#sanree_brand_video')->getvideo_by_tid($thread['tid']);
		   if ($result['allowreply'] != 1) {
		   
			   $allowfastpost = FALSE;
			   
		   }
		   
		}
		
	}	
	function viewthread(){
	
	    global $_G;
		$config = $_G['cache']['plugin']['sanree_brand_video'];
		if (!$config['isopen']) {
		
		    return;
			
		}
		if ($_G[uid]==1) return;
		$bindingforum = intval($config['bindingforum']);
		if ($bindingforum<1) return;
				
		if ((CURSCRIPT == 'forum') && $bindingforum == $_G['fid']) {
		
			$allowgroup = unserialize($config['allowgroup']);
			$groupid = $_G['group']['groupid'];
			if (!in_array($groupid, $allowgroup)) {
			
				showmessage(video_modlang('stopallowtip'));
				
			}
			$viewgroup = unserialize($config['viewgroup']);
			if (!in_array($groupid, $viewgroup)) {
			
				showmessage(video_modlang('stopviewtip'));
				
			}
			
		}
		
	}
		
	function post() {
	
	    global $_G, $mod;
		$config = $_G['cache']['plugin']['sanree_brand_video'];
		if (!$config['isopen']) {
		
		    return;
			
		}
		if ($_G[uid]==1) return;
		$action = $_GET['action'];
		$bindingforum = intval($config['bindingforum']);
		if ($bindingforum<1) return;
		if ((CURSCRIPT == 'forum') && ($mod == 'post') && $bindingforum == $_G['fid']) {
		
		   if ($action != 'reply') {
		   
			   showmessage('postperm_none_nopermission');
			   
		   }
		   $gresult = C::t('#sanree_brand_video#sanree_brand_video')->getvideo_by_tid($_G['tid']);
		   if (!$gresult) {
		   
			   showmessage(lang('plugin/sanree_brand_video', 'nofastpostcontrol'));
			   
		   }
		   $result = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($gresult[bid]);
		   if ($result['allowfastpost'] != 1) {
		   
			   showmessage(lang('plugin/sanree_brand_video', 'nofastpostcontrol'));
			   
		   }
		   
		}
			
	} 
	
}
//From:www_YMG6_COM
?>