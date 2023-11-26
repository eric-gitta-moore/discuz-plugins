<?php

/**
 *      [Sanree!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_brand_friendly_link.php 2014-07-29 10:20:00 sanree checkedby fx8.cc $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}

class table_sanree_brand_friendly_link extends discuz_table
{
		
	public function __construct() {

		$this->_table = 'sanree_brand_friendly_link';
		$this->_pk    = 'flid';

		parent::__construct();
	}
	public function count_by_where($where) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE 1 %i", array($this->_table, $where));
	}	
	public function fetch_all_by_search($condition, $orderby) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		} else {
			$where = $condition;
		}
		return XDB::fetch_all("SELECT * FROM %t	WHERE 1 %i ORDER BY %i", array($this->_table, $where, $orderby));
	}

	public function count_by_wherec($condition) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		} else {
			$where = $condition;
		}
		return XDB::result_first("SELECT COUNT(*) FROM %t as a WHERE 1 %i", array($this->_table, $where));
	}	
	
	public function fetch_all_by_searchc($condition, $orderby, $start = 0, $ppp = 0) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		} else {
			$where = $condition;
		}
		return XDB::fetch_all("SELECT * FROM %t	WHERE 1 %i ORDER BY %i LIMIT %d, %d", array($this->_table, $where, $orderby, $start, $ppp));
	}
	public function get_by_id($helpid) {
		return XDB::fetch_first("SELECT * FROM %t WHERE flid=%d", array($this->_table, $helpid));
	}
	
	public function fetch_all() {
	   
		return XDB::fetch_all("SELECT * FROM %t	", array($this->_table));
	}

}
//www-FX8-co
?>