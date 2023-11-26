<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_brand_tag.php $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
 
class table_sanree_brand_tag  extends discuz_table
{

	public function __construct() {

		$this->_table = 'sanree_brand_tag';
		$this->_pk    = 'tagid';

		parent::__construct();
	}

	public function count_by_where($where) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE 1 %i", array($this->_table, $where));
	}
	public function gettagid_by_tagname($tagname) {
		return XDB::result_first("SELECT tagid FROM %t WHERE tagname='%i'", array($this->_table, $tagname));
	}

	public function gettagid_by_tagid($tagid) {
		return XDB::result_first("SELECT tagname FROM %t WHERE tagid='%i'", array($this->_table, $tagid));
	}

	public function fetch_all_by_search($condition, $orderby, $start = 0, $ppp = 0) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		} else {
			$where = $condition;
		}
		return XDB::fetch_all("SELECT * FROM %t WHERE 1 %i ORDER BY %i LIMIT %d, %d", array($this->_table, $where, $orderby, $start, $ppp));
	}		
	
}
//From:www_YMG6_COM
?>