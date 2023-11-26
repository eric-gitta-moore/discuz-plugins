<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: class_sanree_brand_selfdistrict.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class sanree_brand_selfdistrict{
     
	var $_category_list =array();
	var $_navigation;
	var $_identifier;
	var $_allurl;
	var $_location;
	var $_filter;
	var $_tid;
	var $_locationdata;
	var $_nowrow;
	var $_search;
	
	function __construct($identifier){
	
		$this->sanree_brand_selfdistrict($identifier);
				
	}
	
	function sanree_brand_selfdistrict($identifier) {
	
		$this->sanree_brand_category($identifier);
		
	}
		
	function Getrow($upid,&$indata) {
	
	    $row =C::t('#sanree_brand#sanree_brand_district')->fetch_first_by_id($upid);
		if ($row) {
		   $indata[$row['level']] = $row;	   
		   $this->Getrow($row['upid'],$indata);
		}
		
	}
	
	function sanree_brand_category($identifier){
		global $_G;
		$this->_tid = intval($_G['sr_tid']);
		$did 	= intval($_G[sr_did]);
		$this->_locationdata = array();
		$this->_nowrow = C::t('#sanree_brand#sanree_brand_district')->fetch_first_by_id($did);
		$this->Getrow($did,$this->_locationdata);
	}
	
	function show($is_rewrite){
	    global $_G;

		$did 	= intval($_G[sr_did]);
		$act = $cateid<1 ? ' class="cateon"' : '';
		$this->_category_list= array();
		$this->_navigation = srlang('region');
		$region= array('','srbirthprovince','srbirthcity','srbirthdist','srbirthcommunity');
		$this->search= array();
		for($i=1; $i<5;$i++) {
		   if ($this->_locationdata[$i]) {

				$this->_search[$region[$i]] = $this->_locationdata[$i]['name'];
			   
			   $this->_navigation.= "<em>-</em>" .$this->_locationdata[$i]['name'];
			   $this->_category_list[$i] =  array();
			   foreach(C::t('#sanree_brand#sanree_brand_district')->fetch_all_by_upid($this->_locationdata[$i]['upid']) as $key => $value){
					if ($value['id'] == $did || $value['id'] == $this->_locationdata[$i]['id']) {
					
						$value['class'] = ' class="cateon"';
												
					}			   
					$value['url'] = getcateurl(array('did' => $value['id']));
				    $this->_category_list[$i]['data'][$key] = array( 'class' => $value['class'], 'name' => $value['name'], 'url' => $value['url']);	
			   }
			   $this->_category_list[$i]['allname'] = srlang('notlimited');
			   $this->_category_list[$i]['pidurl'] = getcateurl(array('did' => $this->_locationdata[$i]['upid']));
			   $this->_category_list[$i]['pidclass'] =  ' class="districtl'.$i.'"';
			   $this->_category_list[$i]['class'] =  ' dshow3';
			   $this->_category_list[$i]['id'] =  $i;	
		   }
		}
	   foreach(C::t('#sanree_brand#sanree_brand_district')->fetch_all_by_toupid($did) as $key => $value){
	   
			$value['url'] = getcateurl(array('did' => $value['id']));
			$this->_category_list[5]['data'][$key] = array( 'class' => $value['class'], 'name' => $value['name'], 'url' => $value['url']);	
			
	   }
	   if ($this->_category_list[5]) {
		   $this->_category_list[5]['allname'] = srlang('notlimited');
		   $this->_category_list[5]['pidurl'] = getcateurl(array('did' => $did));
		   $this->_category_list[5]['pidclass'] = ' class="cateon"';
		   $this->_category_list[5]['class'] =  ' dshow3';	
		   $this->_category_list[5]['id'] =  $this->_nowrow['level']+1;	
	   }  

	}

}
//From:www_YMG6_COM
?>
