<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_brand_mf.php $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
 
class table_sanree_brand_mf  extends discuz_table
{

	public function __construct() {

		$this->_table = 'sanree_brand_mf';
		$this->_pk    = 'mfid';

		parent::__construct();
	}

	public function count_by_where($where) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE 1 %i", array($this->_table, $where));
	}
	public function fetch_all_by_search($condition, $orderby, $start = 0, $ppp = 0) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		} else {
			$where = $condition;
		}	
		return XDB::fetch_all("SELECT * FROM %t WHERE 1 %i ORDER BY %i LIMIT %d, %d", array($this->_table, $where, $orderby, $start, $ppp));
	}	
	public function fetch_all_by_searchc($condition, $orderby) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		} else {
			$where = $condition;
		}	
		return XDB::fetch_all("SELECT * FROM %t WHERE 1 %i ORDER BY %i", array($this->_table, $where, $orderby));
	}			
	public function fetch_all_mf() {
		return XDB::fetch_all("SELECT * FROM %t ORDER BY displayorder", array($this->_table));
	}			
}
//From:www_YMG6_COM
?>