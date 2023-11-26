<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: class_sanree_brand_menu.php 2014-07-29 10:20:00 sanree checkedby fx8.cc $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}

class sanree_brand_nicemenu{
     
	var $_identifier = 'sanree_brand';
	var $_template = 'nice';
	
	var $_nofoot_template  = array(
			'albumlist', 'albumshow'
		);
	
	function __construct($identifier, $brandresult, $nicefile){

		define('NICE_CSS', 'source/plugin/'.$this->_identifier.'/tpl/'.$this->_template.'/');
		
		if(!in_array($nicefile, $this->_nofoot_template)) {

			$this->get_menu_head($brandresult, $identifier);
			$this->get_menu_foot($brandresult);
			
		} else{
		
			$this->get_menu_head($brandresult, $identifier);
			
		}
				
	}
	
	function get_menu_foot($brandresult) {
		
		global $_G;
		
		$bid = $brandresult['bid'];
		$tid = $brandresult['tid'];
		
		$perpage 	= 5;
		$page 		= intval($_G[sr_page]);
		$page 		= max(1, intval($page));
		$start 		= ($page - 1) * $perpage;
		$start 		= max(0, $start);
		require_once libfile('function/discuzcode');
		$count = C::t('#sanree_brand#forum_post')->count_by_tid_post(0, $tid);
		if ($count>0) {
	
			$postthread = C::t('#sanree_brand#forum_post')->fetch_all_by_tid(0, $tid, true, ' desc', ($page - 1) * $perpage, $perpage, 0, 0);
			foreach($postthread as $key =>$val) {
			
				$postthread[$key]['message'] = discuzcode($val['message'], 0, 0, 0, 1);
				$postthread[$key]['satisfaction'] = C::t('#sanree_brand#sanree_brand_voterlog')->getstar_by_tid_uid($val['authorid'], $tid) * 20;
				$postthread[$key]['dateline'] = dgmdate($val['dateline']);
				$postthread[$key]['img'] = avatar($val['authorid'], 'middle', 1);
				
			}
			$murl= $_G['item_detail'] == 'item' ? ($is_rewrite ? getburl($brandresult).'?t'.$extra : getburl($brandresult).$extra) : ($is_rewrite ? getdetailurl($brandresult).'?t'.$extra : getdetailurl($brandresult).$extra);
	
			$multi = multi ( $count, $perpage, $page, $murl);		
		}
		
		$satisfaction = C::t('#sanree_brand#sanree_brand_voterlog')->getstar_by_tid_uid($_G['uid'] ,$tid) * 20;
		
		$seditor = array('fastpost', array('bold', 'color', 'link', 'quote', 'smilies'));
		$selfimg = avatar($_G['uid'], 'middle', 1);
		$wx_prefix = $_G['setting']['attachurl'].'category/';
		
		$appVer = $_G['setting']['version'];
		$dzv = array('X3.2','X3.1');
		if(in_array($appVer, $dzv)) {
			
			list($seccodecheck) = seccheck('publish');
			$dzvflag = true;
			$sectpl = '<div class="rfm"><table><tr><th><sec>: </th><td><span id="sec<hash>" onclick="showMenu({\'ctrlid\':\'sec<hash>\',\'pos\':\'*\'})"><sec></span><br /><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div></td></tr></table></div>';
			
		} else {
			
			$seccodecheck = ($_G['setting']['seccodestatus'] & 4) && (!$_G['setting']['seccodedata']['minposts'] || getuserprofile('posts') < $_G['setting']['seccodedata']['minposts']);
			$secqaacheck = $_G['setting']['secqaa']['status'] & 2 && (!$_G['setting']['secqaa']['minposts'] || getuserprofile('posts') < $_G['setting']['secqaa']['minposts']);
			$dzvflag = false;
		
		}

		include templateEx($this->_identifier.':'.$this->_template.'/srfoot');
		$GLOBALS['srfoot'] = $srfoot;
	
	}
	
	function get_menu_head($brandresult, $active) {
	
		global $_G, $template, $bodycss, $ishideheader, $allurl, $myhomeurl, $referer, $addgroup, $ismultiple;
		
		$bid = $brandresult['bid'];
		$tid = $brandresult['tid'];
		$group = C::t('#sanree_brand#sanree_brand_group')->get_by_groupid($brandresult['groupid']);
 
		$tmpconfig = $_G['cache']['plugin']['sanree_brand'];
		$allowsyngroup = intval($tmpconfig['allowsyngroup']);
		$isshowordinary = intval($tmpconfig['isshowordinary']);
		!defined('sr_brand_JS') && define('sr_brand_JS', sr_brand_TPL.'/'.$tmpconfig['template'].'/js');
		!defined('SANREE_BRAND_TEMPLATE') && define('SANREE_BRAND_TEMPLATE', sr_brand_TPL.'/'.$tmpconfig['template']);
		$allurl = gethomeurl();
		$myhomeurl = !empty($brandresult['brandno']) ? getbrandnourl($brandresult['brandno']) : getmyburl_by_bid($brandresult['bid']);
		$referer = urlencode($myhomeurl);
		if (!isset($_G['cache']['sanree_brand_topmenu'])||!is_array($_G['cache']['sanree_brand_topmenu'])) {
		
			sanreeupdatecache('menu');
			
		}	
		$menu = sanreeloadcache('topmenu');
		$headermenulist = array();
		$headermenulist['index'] = array('url'=> getburl($brandresult), 'title' => srlang('frontpage'), 'class' =>' class="normal"');
		($brandresult['allowalbum']==1)&& $headermenulist ['myalbum']= array('url'=> getalbumurl($brandresult['bid']), 'title' => srlang('myalbum'), 'class' =>' class="normal"');
		($allowsyngroup==1&&intval($group['allowsyngroup'])==1&&$brandresult['syngrouptid'])&& $headermenulist['dzgroup'] = array('url'=> 'forum.php?mod=group&amp;fid='.$brandresult['syngrouptid'], 'title' => srlang('dzgroup'), 'class' =>' class="normal"');
		
		hookscript('sanreebrandusermenu', 'global', 'funcs', array('bid' => $brandresult['bid']), 'sanreebrandusermenu');	
		if ($_G['sanree_brand_menus']) {
		
			foreach($_G['sanree_brand_menus'] as $row) {
			
				$row['url'] = str_replace('{tid}',$brandresult['tid'],$row['url']);
				$row['url'] = str_replace('{bid}',$brandresult['bid'],$row['url']);
				$row['url'] = str_replace('{pid}',$brandresult['pid'],$row['url']);
				$headermenulist[$row['name']] = $row;
				
			}
	
		}
		($isshowordinary==1)&& $headermenulist['ordinary'] = array('url'=> 'forum.php?mod=viewthread&amp;tid='.$brandresult['tid'], 'title' => srlang('ordinary'), 'class' =>' class="normal"');		
		foreach($menu as $row) {
		
			$row['url'] = str_replace('{tid}',$brandresult['tid'],$row['url']);
			$row['url'] = str_replace('{bid}',$brandresult['bid'],$row['url']);
			$row['url'] = str_replace('{pid}',$brandresult['pid'],$row['url']);
			$headermenulist['menu'.$row[id]] = $row;
			
		}

		$headermenulist[$active] && $headermenulist[$active]['class'] = ' class="current"';
		
		$headermenulists = $headermenulist;
		$headermenulist = array();
		$menuorder = C::t('#sanree_brand#sanree_brand_menu_order')->fetch_all();
		asort($menuorder);
		
		foreach($menuorder as $key => $row) {
			
			if($headermenulists[$key]) {
				
				$headermenulist[$key] = $headermenulists[$key];
			
			}

		}

		if (intval($_G['uid']) === intval($brandresult['uid'])) {
			
			define('IN_BRAND_USER', TRUE);
			hookscript('sanreebrandmanagemenu', 'global', 'funcs', array('bid' => $brandresult['bid']), 'sanreebrandmanagemenu');
			$managemenulist = array();
			$_G['sanree_brand_managemenus'][] = array(
				'displayorder'=> 9999, 
				'window' => 0,
				'name'=>'', 
				'title'=> '', 
				'url'=> '',
				'class' => '',
				'image' => 'source/plugin/sanree_brand/tpl/good/images/add.png'
			);			
			if ($_G['sanree_brand_managemenus']) {
			
				foreach($_G['sanree_brand_managemenus'] as $row) {
				
					$row['url'] = str_replace('{tid}',$brandresult['tid'],$row['url']);
					$row['url'] = str_replace('{bid}',$brandresult['bid'],$row['url']);
					$row['url'] = str_replace('{pid}',$brandresult['pid'],$row['url']);
					$managemenulist[] = $row;
				
				}
				$ncount = count($managemenulist);
				$mod = $ncount % 10;
				$mt = intval($ncount / 10);
				$oneh = 100;
				if ($mt == 0) {
					$ih = $oneh;
				} else {
					if ($mod == 0) {
						$ih = $mt * $oneh;
					} else {
						$ih = ($mt + 1) * $oneh;
					}
				}
				$ih += 10;
			}
			
		}
	
		$allowtemplate = intval($group['allowtemplate']);
		if ($allowtemplate==1) {		
			$templateconfig = unserialize($brandresult['templateconfig']);
			$bodystyle = $templateconfig['bodystyle']; 
			$bodycss = '';
			if ($bodystyle) {
				if (intval($bodystyle['isuse'])==1) {
					$bodycss="body {\r\n";
					if ($bodystyle['notbackimg']==1) {
						if (!empty($bodystyle['backgroundimage'])) {
							$bodycss.= "background-image:url('".$_G['setting']['attachurl'].'category/'."$bodystyle[backgroundimage]');\r\n";
						}				
					} else{
						$bodycss.= "background:none;\r\n";
					}
					if (!empty($bodystyle['backgroundrepeat'])) {
						$bodycss.= "background-repeat:$bodystyle[backgroundrepeat];\r\n";
					}
					if (!empty($bodystyle['backgroundcolor'])) {
						$bodycss.= "background-color:$bodystyle[backgroundcolor];\r\n";
					}
					if (!empty($bodystyle['backgroundattachment'])) {
						$bodycss.= "background-attachment:$bodystyle[backgroundattachment];\r\n";
					}	
					if (!empty($bodystyle['backgroundpositionx'])&&!empty($bodystyle['backgroundpositiony'])) {
						$bodycss.= "background-position:$bodystyle[backgroundpositionx] $bodystyle[backgroundpositiony];\r\n";
					}				
					$bodycss.="}";
					$ishideheader = intval($bodystyle['ishideheader']);
				}
			}
			if ($ishideheader==1) {
			
				$appVer = $_G['setting']['version'];
				include templateEx($this->_identifier.':'.$template.'/header_one_'.$appVer);
				$GLOBALS['brand_header_one'] = $brand_header_one;
				
			}	
		} else {
		
			$ishideheader= 0;
			
		}

		$slideid = 3;
		$slidelistarr = sanreeloadcache('slidelist');
		$birdbannerurl = $_G['cache']['plugin']['sanree_brand']['birdbannerurl'];
		if(!$brandresult['newbanner']) {

			$slidelistarr[3] = array(
				array(
					'pic' => 'source/plugin/sanree_brand/tpl/bird/images/c_banner.jpg',
					'url' => $birdbannerurl
				),
				array(
					'pic' => 'source/plugin/sanree_brand/tpl/bird/images/c_banner_01.jpg',
					'url' => $birdbannerurl
				),
				array(
					'pic' => 'source/plugin/sanree_brand/tpl/bird/images/c_banner_02.jpg',
					'url' => $birdbannerurl
				),
				array(
					'pic' => 'source/plugin/sanree_brand/tpl/bird/images/c_banner_05.jpg',
					'url' => $birdbannerurl
				),
				array(
					'pic' => 'source/plugin/sanree_brand/tpl/bird/images/c_banner_06.jpg',
					'url' => $birdbannerurl
				)
			);

		}else {
		
			$brandresult['newbanner'] = explode(',', $brandresult['newbanner']);
			$brandresult['newbannerurl'] = explode(',', $brandresult['newbannerurl']);
			foreach ($brandresult['newbanner'] as $key => $vla) {

				if ($vla) {
					if (!$brandresult['newbannerurl'][$key]) {

						$symoneurl = 'javascript:';

					} elseif (substr($brandresult['newbannerurl'][$key],0,4) != 'http') {

						$symoneurl = 'http://'.$brandresult['newbannerurl'][$key];

					} else {

						$symoneurl = $brandresult['newbannerurl'][$key];

					}
					$slidelistarr[3][$key]['pic'] = $_G['setting']['attachurl'].'category/'.$vla;
					$slidelistarr[3][$key]['url'] = $symoneurl;
				}

			}

		}

		$slidelist = $slidelistarr[$slideid];
		$slide_prefix = $_G['setting']['attachurl'].'category/';

		$mfliststr = srlang('zanwustr');
		if ($brandresult['brandmf']) {
			foreach(C::t('#sanree_brand#sanree_brand_mf')->fetch_all_by_searchc(array(' mfid IN ('.$brandresult['brandmf'].')'),'displayorder') as $data) {

				$mflist[] = $data['mfname'];

			}
			$mfliststr = implode($mflist,'&nbsp;&nbsp;&nbsp;&nbsp;');
		}

		$tagdata = array();
		if ($brandresult['brandtag']) {
			$taglist = explode(',', $brandresult['brandtag']);
			foreach($taglist as $key => $tag) {
				$tagid = C::t('#sanree_brand#sanree_brand_tag')->gettagid_by_tagname($tag);
				if ($tagid>0) {
					$url = gettagurl($tagid);
					$tagdata[] = array('url' => $url, 'tagname' => $tag);
				}
			}
		}
		$brandresult['weixin'] = $brandresult['weixin'] ? $brandresult['weixin'] : srlang('zanwustr');
		$brandresult['weixinimg'] = $brandresult['weixinimg'] ? $_G['setting']['attachurl'].'category/'.$brandresult['weixinimg'].'?'.random(6) : false;
		$brandresult['weixinpublic'] = $brandresult['weixinpublic'] ? $brandresult['weixinpublic'] : srlang('zanwustr');
		$brandresult['weixinpublicpic'] = $brandresult['weixinpublicpic'] ? $_G['setting']['attachurl'].'category/'.$brandresult['weixinpublicpic'].'?'.random(6) : false;
		
		$mtfopen = $_G['cache']['plugin']['sanree_mcertification']['isopen'];
		if($mtfopen) {
			$mcertification = C::t('#sanree_mcertification#sanree_mcertification')->gettype_by_bid(intval($bid));
			$mtf = 'source/plugin/sanree_mcertification/tpl/default/mcertification/brandimg/bignone.png';
			if($mcertification) {
				$mtf = $mcertification['type'] ? 'source/plugin/sanree_mcertification/tpl/default/mcertification/brandimg/bigpersonal.png' : 'source/plugin/sanree_mcertification/tpl/default/mcertification/brandimg/bigcompany.png';
			}
		}
		
		$attention = $_G['cache']['plugin']['sanree_attention']['isopen'];
		if($attention) {
			$addbtn = 'source/plugin/sanree_attention/tpl/default/img/addbtn.png';
			$delbtn = 'source/plugin/sanree_attention/tpl/default/img/delbtn.png';
			$uids = C::t('#sanree_attention#sanree_attention')->getuid_by_bid(intval($bid));
			$atnbtn = $addbtn;
			$flag = 0;
			$atnurl = 'plugin.php?id=sanree_attention&mod=addattention&bid='.intval($bid);
			if($uids) {
				foreach($uids as $uid) {
					if($uid['uid'] == $_G['uid']) {
						$atnbtn = $delbtn;
						$flag = 1;
						$atnurl = 'plugin.php?id=sanree_attention&mod=delattention&bid='.intval($bid);
						$deltip = attention_modlang('confirmationdel');
						break;
					}
				}
			}
		}
		
		$assistcount = C::t('#sanree_brand#sanree_brand_assist')->count_by_where(' && bid ='.intval($bid));
		$assistuids = C::t('#sanree_brand#sanree_brand_assist')->getuid_by_bid(intval($bid));
		if($assistuids) {
			foreach($assistuids as $uid) {
				if($uid['uid'] == $_G['uid']) {
		
					$assistflag = 1;
					break;
					
				}
			}
		}
		
		if(!$brandresult['satisfaction']) {
			
			$voter = C::t('#sanree_brand#sanree_brand_voter')->getvotetotal_by_tid($tid);
			$brandresult['satisfaction'] = intval($voter[3]);
		
		}
		
		if ($ismultiple==1&&$brandresult['allowmultiple']==1) {

			$tempresult = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($bid);
			$tellist = explode(',', $tempresult['tel']);
			$GLOBALS['tellist'] = $tellist;
		
		} else {

			$brandresult['tel'] = getfirsticq($brandresult['tel']);
		
		}
		$pbidlist = array();
		foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_searchc(array('c.status=1', 't.pbid='.$bid, 't.status=1'), 't.istop desc,t.displayorder, t.dateline desc', 0, 100) as $value) {
			$url = getburl($value);
			$pbidlist[] = array('name' => $value['name'],'url' => $url);
		}

		if (!$_G['forum']['disablecollect'] && helper_access::check_module('collection') && $_G['cache']['plugin']['sanree_brand']['allcollection']) {
			$showarr = array('goodsshow', 'newsshow', 'couponshow', 'jobsshow', 'inpage','albumshow','videoshow');
			$tid = $_GET['tid'];
			list($plugin, $temp) = explode(':', $_G['sr_id']);

			if (in_array($_G['mod'], $showarr) && $tid) {

				if ($_G['mod'] == 'inpage') {

					$indexone = 't';

				} elseif ($_G['mod'] == 'albumshow') {

					$indexone = substr($_G['mod'],0,5);
					$plugin = $plugin.'_'.$indexone;

				} elseif ($_G['mod'] == 'videoshow') {

					$indexone = 'c';

				} else {

					$indexone = $_G['mod']{0};

				}

				$ttid = XDB::result_first("SELECT tid FROM %t WHERE ".$indexone."id=%d", array($plugin, $tid));

			} else {

				if ($_G['mod'] == 'item') {
					$ttid = $brandresult['tid'];
				}

			}
		}

		include templateEx($this->_identifier.':'.$this->_template.'/srhead');
		$GLOBALS['srhead'] = $srhead;
	}


	function array_sort($arr, $keys, $type = 'asc') { 
	
		$keysvalue = $new_array = array();
		foreach ($arr as $k=>$v){
			$keysvalue[$k] = $v[$keys];
		}
		if($type == 'asc') {
			asort($keysvalue);
		} else {
			arsort($keysvalue);
		}
		reset($keysvalue);
		foreach ($keysvalue as $k=>$v) {
			$new_array[$k] = $arr[$k];
		}
		return $new_array; 
		
	} 
}
//From:www_YMG6_COM
?>
