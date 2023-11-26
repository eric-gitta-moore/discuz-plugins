<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_category.class.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class sanree_brand_goods_category{
     
	var $_table;
	var $_category = array();
	var $_category_list =array();
	var $_subcategory = array();
	var $_subcategory_list = array();
	var $_pid = 0;
	var $_navigation;
	var $_curcatedata = array();
	var $_identifier;
	var $_location;
	var $_did;

	function __construct($identifier){
	
		$this->sanree_brand_goods_category($identifier);
		
	}
	
	function sanree_brand_goods_category($identifier){
	
	    global $_G;	
	    $this->_did = intval($_G['sr_did']);
		$this->_table= '#'.$identifier.'#'.$identifier.'_category';
		
	}
	
	function show($is_rewrite){
	    global $_G, $modelurl;
	    $cateid 	= intval($_G[sr_tid]);
		$act = $cateid<1 ? ' class="a"' : '';
		$this->_category_list[0] = array('index' => 0,'cateid'=>0,'class' => $act,'name' => goods_modlang('all'), 'url' => $modelurl);
		$this->_location = srlang('all');
		if (!is_array($_G['cache']['sanree_brand_goods_category'])) {
			goods_updatecache('category');
		}
		$this->_subcategory = goods_loadcache('subcategory');
		$this->_category = goods_loadcache('category');
		$this->_navigation = '';
		
		$cateindex = 1;
		foreach($this->_subcategory as $value) {
		
		    if ($value['status']!=1) continue;
			$value['url'] = goods_getcateurl(array('tid' => $value[cateid]));
			if ($value['cateid'] == $cateid) {
			
				$this->_navigation = "<em>&raquo;</em>$value[name]";
				$this->_location = $value[name];
				
			}
			$subarr = array();
			foreach ($value['subcategories'] as $subkey =>$subcate) {
			
				$subarr[$subkey]=$subcate;
				$subarr[$subkey][url] = goods_getcateurl(array('tid' => $subcate[cateid]));
			
			}
			$this->_category_list[$value['cateid']] = array('subcategories' => $subarr,'index' => $cateindex, 'cateid'=>$value['cateid'],'class' => $value['class'] ,'name' => $value[name], 'url' => $value['url']);
			$cateindex++;
			
		} 
		
		if ($cateid>0) {
		    
			$this->_pid = intval($this->_category[$cateid]['pcateid']);
			if ($this->_pid ==0) {
				$this->_pid = $cateid;
				$this->_curcatedata = $this->_subcategory[$cateid];
			}
			else {
				$purl = goods_getcateurl(array('tid' => $this->_pid));
				$this->_navigation .= '<em>&raquo;</em><a href="'.$purl.'">'.$this->_category[$this->_pid][name].'</a>';
				$this->_curcatedata = $this->_subcategory[$this->_pid]['subcategories'][$cateid];
			}
			$this->_category_list[$this->_pid]['class'] = ' class="a"';
			foreach($this->_subcategory[$this->_pid]['subcategories'] as $value) {
			
			    $count = C::t('#sanree_brand_goods#sanree_brand_goods')->count_by_cateid($value['cateid']);
				$value['url'] = goods_getcateurl(array('tid' => $value[cateid]));
				if ($value['cateid'] == $cateid) {
				
					$value['class'] = ' class="a"';
					$this->_navigation .= '<em>&raquo;</em>'.$value[name];
					$this->_location = $value[name];
					
				}
				$this->_subcategory_list[$value['cateid']] = array('count'=> $count, 'class' => $value['class'], 'name' => $value[name], 'url' => $value['url']);
				
			}		
		}	
	}

	function getcatenavigation($cateid, &$navigation, $addstr='', $url='') {
		if ($cateid<1) return;
		$value=C::t($this->_table)->get_by_cateid($cateid);
		if ($value){
			$purl= goods_getcateurl(array('tid' => $value[cateid]));
			$navigation= !empty($purl) ? "<a href=\"$purl\">$value[name]</a>".$addstr.$navigation : $value['name'].$addstr.$navigation;
			$this->getcatenavigation($value['pcateid'], $navigation, "<em>&raquo;</em>", $url);
		}
	}
	
	function getcatelocal($cateid, $url){
		$catenavigation = '';
		$this->getcatenavigation($cateid, $catenavigation, '<em>&raquo;</em>', $url);
		return $catenavigation;
	}
	
}
//From:www_YMG6_COM
?>
