<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_brand_video_category.php $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
 
class table_sanree_brand_video_category  extends discuz_table {
	public function __construct() {

		$this->_table = 'sanree_brand_video_category';
		$this->_pk    = 'cateid';

		parent::__construct();
	}
	
	public function fetch_all_category() {
		return XDB::fetch_all("SELECT * FROM %t WHERE 1 order by displayorder", array($this->_table));
	}	
		
	public function getcategory_by_pcateid($pcateid, $status = FALSE) {
	    $where = '';
		if ($status) $where= ' AND status=1 ';
		return XDB::fetch_all("SELECT * FROM %t WHERE pcateid=%d %i order by displayorder", array($this->_table, $pcateid, $where));
	}
		
	public function getcategory_by_cateid($cateid) {
		return XDB::fetch_first("SELECT keywords,description,name,cateid FROM %t WHERE cateid=%d", array($this->_table, $cateid));
	}
	
	public function fetch_all_forblock($where, $orderby, $ordersc, $itemsnum) {
		return XDB::fetch_all("SELECT * FROM %t %i ORDER BY %i %i %i", array($this->_table, $where, $orderby, $ordersc, $itemsnum));
	}	
	
	public function get_by_cateid($bid) {
		return XDB::fetch_first("SELECT * FROM %t where cateid=%d", array($this->_table, $bid));
	}			
}
//www-FX8-co
?>