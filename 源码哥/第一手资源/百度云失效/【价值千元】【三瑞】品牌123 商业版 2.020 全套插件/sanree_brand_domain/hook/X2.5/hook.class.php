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
$modfile=DISCUZ_ROOT.'./source/plugin/sanree_brand_domain/function/function_core.php';
@require_once($modfile);

class plugin_sanree_brand_domain {

	function sanreebrandmanagemenu($param){
	
		global $_G;
		$config = $_G['cache']['plugin']['sanree_brand_domain'];
		if (!$config['isopen']) {
		
			return;
			
		}	
		$brand_config = $_G['cache']['plugin']['sanree_brand'];
		if (!$brand_config['isopen']) {
		
			return;
			
		}	
		$groupid = $_G['group']['groupid'];
		$allowgroup = unserialize($config['allowgroup']);		
		if (!in_array($groupid, $allowgroup)) {
		
			return;
			
		}				

		$_G['sanree_brand_managemenus'][] = array(
			'displayorder'=> 800, 
			'window' => 0,
			'name'=>'mydomain', 
			'title'=> domain_modlang('mydomain'), 
			'url'=> 'plugin.php?id=sanree_brand_domain&mod=mydomain',
			'class' => '',
			'image' => 'source/plugin/sanree_brand_domain/tpl/default/images/mydomain.png'
		);
		
	}
	
	function sanreedomain($param) {
	
		global $_G;
		$config = $_G['cache']['plugin']['sanree_brand_domain'];
		if (!$config['isopen']) {
		
			return;
			
		}
		if (!$config['mdomain']) {
		
			return;
			
		}		
		if ($config['ishidden']==1) {
		
			return;
			
		}			
		$mode = $param['mode'];
		$data = $param['data'];
		if ($mode == 'bid') {
			$tp = C::t('#sanree_brand_domain#sanree_brand_domain_brand2domain')->getinfo_by_bid(intval($data));
			if ($tp) {
				$_G['hooksanreedomain'] = 'http://'.$tp['domainname'].'.'.$config['mdomain'].'/';
			}
		} elseif ($mode == 'albumlist') {
			$tp = C::t('#sanree_brand_domain#sanree_brand_domain_brand2domain')->getinfo_by_bid(intval($data));
			if ($tp) {
				$_G['hooksanreedomain'] = 'http://'.$tp['domainname'].'.'.$config['mdomain'].'/';
			}
		} elseif ($mode == 'albumshow') {
		    $bid = C::t('#sanree_brand#sanree_brand_album_category')->fetch_bid_by_catid(intval($data));
			$tp = C::t('#sanree_brand_domain#sanree_brand_domain_brand2domain')->getinfo_by_bid(intval($bid));
			if ($tp) {
				$_G['hooksanreedomain'] = 'http://'.$tp['domainname'].'.'.$config['mdomain'].'/';
			}
		} elseif ($mode == 'brandno') {
		    preg_match("/[^0-9a-zA-Z]/", $data, $matches);
			if (count($matches)>0) {
				return;
			}
		    $brandresult= C::t('#sanree_brand#sanree_brand_businesses')->get_by_brandno($data);
			if ($brandresult) {
				$tp = C::t('#sanree_brand_domain#sanree_brand_domain_brand2domain')->getinfo_by_bid(intval($brandresult['bid']));
				if ($tp) {
					$_G['hooksanreedomain'] = 'http://'.$tp['domainname'].'.'.$config['mdomain'].'/';
				}
			}
		}
		

	}	
		  
}

//class plugin_identifier_CURSCRIPT extends plugin_identifier {

class plugin_sanree_brand_domain_plugin extends plugin_sanree_brand_domain {
///function CURMODULE_USERDEFINE[_output]()
	function sanree_brand_userbar(){
	
		global $_G;
		$actives = array();
		$view = '';
		if ($_G['sr_id']=='sanree_brand_domain') {
			$view = ' class="a"';
		}
		
		$config = $_G['cache']['plugin']['sanree_brand_domain'];
		if (!$config['isopen']) {
		
			return '';
			
		}
		$groupid = $_G['group']['groupid'];
		$allowgroup = unserialize($config['allowgroup']);		
		if (!in_array($groupid, $allowgroup)) {
		
			return '';
			
		}		
		$count = C::t('#sanree_brand_domain#sanree_brand_domain')->count_by_wherec(' AND uid='.$_G['uid']);
		$result = '<li'.$view.'><a href="plugin.php?id=sanree_brand_domain&mod=mydomain">'.lang('plugin/sanree_brand_domain','mydomain').'('.intval($count).')</a></li>';	
		return $result;
		
	}
}	
class plugin_sanree_brand_domain_home extends plugin_sanree_brand_domain {

	function spacecp_credit_top_output() {
	
		global $_G;
		lang('spacecp');	

		$_G['lang']['spacecp']['DMN_credit'] = lang('plugin/sanree_brand_domain', 'DMN');
		$_G['lang']['spacecp']['logs_credit_update_DMN'] = lang('plugin/sanree_brand_domain', 'DMN');
	} 
	
}	
?>