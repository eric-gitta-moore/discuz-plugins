<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_category.class.php 2014-07-29 10:20:00 sanree checkedby fx8.cc $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}
class sanree_brand_category{
     
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
	var $_allcategorytitle;
	var $_subdata;
	
	function __construct($identifier,$allcategorytitle=''){
	
		$this->sanree_brand_category($identifier, $allcategorytitle);
		
	}
	
	function sanree_brand_category($identifier, $allcategorytitle=''){
	
	    global $_G;	
	    $this->_did = intval($_G['sr_did']);
		$this->_table= '#'.$identifier.'#'.$identifier.'_category';
		$this->_allcategorytitle = $allcategorytitle;
		
	}
	
	function show($is_rewrite){
	    global $_G, $allurl;
	    $cateid 	= intval($_G['sr_tid']);
		$act = $cateid<1 ? ' class="cateon"' : '';
		$this->_category_list[0] = array('class' => $act,'name' => (!empty($this->_allcategorytitle) ? $this->_allcategorytitle : srlang('all')), 'url' => $allurl);
		$this->_location = srlang('all');
		if (!is_array($_G['cache']['sanree_brand_category'])) {
			sanreeupdatecache('category');
		}
		$this->_subcategory = sanreeloadcache('subcategory');
		$this->_category = sanreeloadcache('category');
		$this->_navigation = '';
		foreach($this->_subcategory as $value) {
		
			$value['url'] = getcateurl(array('tid' => $value['cateid']));
			if ($value['cateid'] == $cateid) {
			
				$this->_navigation = "<em>&raquo;</em>$value[name]";
				$this->_location = $value[name];
				
			}
			$clogo = !empty($value['clogo']) ? $_G['setting']['attachurl'].'common/'.$value['clogo'].'?'.random(6) : "";

			$this->_category_list[$value['cateid']] = array('class' => $value['class'] ,'name' => $value['name'], 'url' => $value['url'], 'clogo' => $clogo);
			
		} 	
		if ($cateid>0) {
		    $this->_curcatedata = $this->_subcategory[$cateid];
			$this->_pid = intval($this->_category[$cateid]['pcateid']);
			if ($this->_pid ==0) {
				$this->_pid = $cateid;
				$purl = getcateurl(array('tid' => $this->_pid));
				$this->_subdata = array('class'=> ' class="cateon"', 'name' => srlang('notlimited'), 'url' => $purl);
			} else {
				$purl = getcateurl(array('tid' => $this->_pid));
				$this->_navigation .= '<em>&raquo;</em><a href="'.$purl.'">'.$this->_category[$this->_pid][name].'</a>';
				$this->_subdata = array('class'=> '', 'name' => srlang('notlimited'), 'url' => $purl);
			}
			$this->_category_list[$this->_pid]['class'] = ' class="cateon"';
			foreach($this->_subcategory[$this->_pid]['subcategories'] as $value) {
			
			    $count = C::t('#sanree_brand#sanree_brand_businesses')->count_by_cateid($value['cateid']);
				$value['url'] = getcateurl(array('tid' => $value[cateid]));
				if ($value['cateid'] == $cateid) {
				
					$value['class'] = ' class="cateon"';
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
			$purl= getcateurl(array('tid' => $value['cateid']));
			$navigation= !empty($purl) ? "<a href=\"$purl\">$value[name]</a>".$addstr.$navigation : $value['name'].$addstr.$navigation;
			$this->getcatenavigation($value['pcateid'], $navigation, "<em>&raquo;</em>", $url);
		}
	}
	
	function getcatelocal($cateid, $url = ''){
		$catenavigation = '';
		$this->getcatenavigation($cateid, $catenavigation, '<em>&raquo;</em>', $url);
		return $catenavigation;
	}
	
	function getsubcategory_bird($category_list){
		global $_G;
	    $cateid = intval($_G['sr_tid']);
		
		$subcategory_list = array();
		foreach($category_list as $key => $value) {
			if(!$key) {
				$subcategory_list[] = $value;
				continue;
			}

			$subcategory = C::t('#sanree_brand#sanree_brand_category')->getcategory_by_pcateid(intval($key));
			$sub_lsit = array();
			$subcate_list = array(
				'class' => $cateid == $key ? ' class="cateon"' : '',
				'name' => srlang('notlimited'),
				'url' => getcateurl(array('tid' => $key)),
			);
			$sub_lsit[] = $subcate_list;
			foreach($subcategory as $subcate) {
				
				$subcate_list = array(
					'class' => $cateid == $subcate['cateid'] ? ' class="cateon"' : '',
					'name' => $subcate['name'],
					'url' => getcateurl(array('tid' => $subcate['cateid'])),
				);
				$sub_lsit[] = $subcate_list;
			}
			 
			$subcategory_list[] = $sub_lsit;
		}

		return $subcategory_list;
	}
	
}
//From:www_YMG6_COM
?>
