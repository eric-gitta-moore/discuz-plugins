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
$modfile=DISCUZ_ROOT.'./source/plugin/sanree_brand_news/function/function_core.php';
@require_once($modfile);
$modfile = DISCUZ_ROOT.'./source/plugin/sanree_brand_news/function/function_module.php';
@require_once($modfile);

class plugin_sanree_brand_news {

	function sanreebrandmanagemenu($param){
	
		global $_G;
		$config = $_G['cache']['plugin']['sanree_brand_news'];
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
		$isnews = C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_by_modename('isnews', $param['bid']);	
		if ($isnews!=1) {
		
			return;
			
		}		
		$_G['sanree_brand_managemenus'][] = array(
			'displayorder'=> 300, 
			'window' => 0,
			'name'=>'mynews', 
			'title'=> news_modlang('mynews'), 
			'url'=> 'plugin.php?id=sanree_brand_news&mod=mynews',
			'class' => '',
			'image' => 'source/plugin/sanree_brand_news/tpl/default/images/mynews.png'
		);
		$_G['sanree_brand_managemenus'][] = array(
			'displayorder'=> 301, 
			'window' => 1,
			'name'=>'publisheddlg', 
			'title'=> news_modlang('post_new_news'), 
			'url'=> 'plugin.php?id=sanree_brand_news&mod=published',
			'class' => '',
			'addhtml' => '<link rel="stylesheet" type="text/css" id="sanree_brand_news" href="source/plugin/sanree_brand_news/tpl/default/sanree_brand_news.css" />',
			'image' => 'source/plugin/sanree_brand_news/tpl/default/images/post_new_news.png'
		);
		
	}
	
      function sanreemoduleupdate($param) {
	  
	      global $_G;
	      $bid = intval($param[bid]);
		  $data = $param[data];
          $isnews = $data[isnews];
		  $gid = array();
		  if ($bid<1) return;
		  foreach(C::t('#sanree_brand_news#sanree_brand_news')->fetch_all_by_bid($bid) as $data) {

			  C::t('#sanree_brand_news#sanree_brand_news')->update($data[gid], array('isshow' => $isnews));
			  $gid[] = $data[gid];
			  
		  }
		  news_fixthread($gid);
		  
	  }
	  
	  function discuzcode($data) {
	  
			global $_G,$thread;
			$brandconfig = $_G['cache']['plugin']['sanree_brand'];
			if (!$brandconfig['isopen']) {
			
				return;
				
			}			
			$config = $_G['cache']['plugin']['sanree_brand_news'];
			if (!$config['isopen']) {
			
				return;
				
			}
			$bindingforum = intval($config['bindingforum']);
			if ($bindingforum<1) return;
			if ($bindingforum != $thread['fid']) {	
			
				return;
				
			}
			$result = C::t('#sanree_brand_news#sanree_brand_news')->getnews_by_tid($_G[tid]);
			$brandurl= news_brandgetburl($result[bid]);
			$brandinfo =  '<a href=\''.$brandurl.'\' target=\'_blank\'>'.$result['brandname'].'</a>';
			$_G['discuzcodemessage'] = str_replace('{brandinfo}', $brandinfo, $_G['discuzcodemessage']);
					
			$selectpriceunit = $config['selectpriceunit'];
			$marr = explode("\r\n", $selectpriceunit);
			foreach($marr as $row) {
			
				list($key , $val) = explode("=", $row);
				$config['selectpriceunitshow'][trim($key)] = news_shtmlspecialchars(trim($val));
				
			}			
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
			$config = $_G['cache']['plugin']['sanree_brand_news'];
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
		$config = $_G['cache']['plugin']['sanree_brand_news'];
		if (!$config['isopen']) {
		
			return;
			
		}		
		if ($param['bid']<1) {
			return;
		}
		$isnews = C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_by_modename('isnews', $param['bid']);	
		if ($isnews!=1) {
		
			return;
			
		}	
		$modulemenuname = empty($config['modulemenuname']) ? news_modlang('itemnews') : $config['modulemenuname'];
		$_G['sanree_brand_menus']['news'] = array('name'=>'news', 'title'=> $modulemenuname, 'url'=>news_getusermodeurl($param),'class' => ' class="normal"');
		
	}
		  
}

//class plugin_identifier_CURSCRIPT extends plugin_identifier {

class plugin_sanree_brand_news_plugin extends plugin_sanree_brand_news {
///function CURMODULE_USERDEFINE[_output]()
	function sanree_brand_userbar(){
	
		global $_G;
		$actives = array();
		$view = '';
		if ($_G['sr_id']=='sanree_brand_news') {
			$view = ' class="a"';
		}
		$config = $_G['cache']['plugin']['sanree_brand_news'];
		if (!$config['isopen']) {
		
			return;
			
		}
		$gcount[0] = C::t('#sanree_brand_news#sanree_brand_news')->count_by_wherec(array('t.uid='.$_G['uid'],'c.status=1','t.status=1'));
		$gcount[1] = C::t('#sanree_brand_news#sanree_brand_news')->count_by_wherec(array('t.uid='.$_G['uid'],'c.status=1','t.status=0'));
		$gcount[2] = C::t('#sanree_brand_news#sanree_brand_news')->count_by_wherec(array('t.uid='.$_G['uid'],'c.status=1','t.status=-1'));
		$gcount[3] = $gcount[0] + $gcount[1] +$gcount[2];		
		$result = '<li'.$view.'><a href="plugin.php?id=sanree_brand_news&mod=mynews&view=index">'.lang('plugin/sanree_brand_news','mynews').'('.$gcount[3].')</a></li>';
		return $result;
		
	}

	function sanree_brand_user_index_righttop_output($param){
	
		global $_G;
		$config = $_G['cache']['plugin']['sanree_brand_news'];
		if (!$config['isopen']) {
		
			return;
			
		}	
		$template = trim($config['template']);
		$template = empty($template) ? 'default' : $template;			
		$brand_config = $_G['cache']['plugin']['sanree_brand'];
		if (!$brand_config['isopen']) {
		
			return;
			
		}	
		$values = $param['values'];
		if ($values['sign']!=='sanree') return;		
		$bid = intval($values['bid']);
		$brandresult = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($bid);
		if (!$brandresult) {
			return;
		}
		if ($brandresult['status']!=1) {
			return;
		}
		$brandmoduleresult = C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_by_bid($bid);
		if ($brandmoduleresult['isnews']!=1) {
			return;
		}		
		$newsshownum = 8;
		$modelurl = news_getusermodeurl(array('bid' => $bid));
		$datalist = C::t('#sanree_brand_news#sanree_brand_news')->fetch_all_by_searchc(array('c.status=1', 't.status=1', 't.isshow=1', 't.bid='.$bid), 't.dateline desc', 0, $newsshownum);
		$htmlline = '';
		foreach($datalist as $line) {
		
			$value = array(
				'title' => $line['name'], 
				'shorttitle' => cutstr($line['name'], 20), 
				'url' => news_getburl($line),
				'dateline' => $line['dateline'] ? dgmdate($line['dateline'],'m-d') : ''
			);
			$htmlline .="<li><span>$value[dateline]</span> <a href=\"$value[url]\" title=\"$value[title]\" target=\"_blank\">$value[shorttitle]</a></li>\n";
			
		}
		$newstitle = empty($config['modulemenuname']) ? news_modlang('itemnews') : $config['modulemenuname'];
		$more = news_modlang('more');
$outhtml =<<<EOF
<div class="brand_newslist">
<div class="hd">
<span><a href="$modelurl" target="_blank">$more</a></span>
<h1>$newstitle</h1>
</div>
<div class="bd">
  <ul>
	$htmlline
  </ul>	  
</div>
</div>
EOF;
		return $outhtml;
		
	}
			
}

class plugin_sanree_brand_news_forum extends plugin_sanree_brand_news {

    function viewthread_postfooter_output(){
	
	    global $_G;
		$config = $_G['cache']['plugin']['sanree_brand_news'];
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
		$config = $_G['cache']['plugin']['sanree_brand_news'];
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
		$config = $_G['cache']['plugin']['sanree_brand_news'];
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
		$config = $_G['cache']['plugin']['sanree_brand_news'];
		if (!$config['isopen']) {
		
		    return;
			
		}
		if ($_G[uid]==1) return;
		$action = $_GET['action'];
		$bindingforum = intval($config['bindingforum']);
		if ($bindingforum<1) return;
		if ((CURSCRIPT == 'forum') && $bindingforum == $_G['fid']) {
		
		   $result = C::t('#sanree_brand_news#sanree_brand_news')->getnews_by_tid($thread['tid']);
		   if ($result['allowreply'] != 1) {
		   
			   $allowfastpost = FALSE;
			   
		   }
		   
		}
		
	}	
	function viewthread(){
	
	    global $_G;
		$config = $_G['cache']['plugin']['sanree_brand_news'];
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
			
				showmessage(news_modlang('stopallowtip'));
				
			}
			$viewgroup = unserialize($config['viewgroup']);
			if (!in_array($groupid, $viewgroup)) {
			
				showmessage(news_modlang('stopviewtip'));
				
			}
			
		}
		
	}
		
	function post() {
	
	    global $_G, $mod;
		$config = $_G['cache']['plugin']['sanree_brand_news'];
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
		   $gresult = C::t('#sanree_brand_news#sanree_brand_news')->getnews_by_tid($_G['tid']);
		   if (!$gresult) {
		   
			   showmessage(lang('plugin/sanree_brand_news', 'nofastpostcontrol'));
			   
		   }
		   $result = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($gresult[bid]);
		   if ($result['allowfastpost'] != 1) {
		   
			   showmessage(lang('plugin/sanree_brand_news', 'nofastpostcontrol'));
			   
		   }
		   
		}
			
	} 
	
}
//From:www_YMG6_COM
?>