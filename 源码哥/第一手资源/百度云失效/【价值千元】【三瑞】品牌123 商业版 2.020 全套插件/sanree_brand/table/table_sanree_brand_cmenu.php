<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_brand_cmenu.php $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
 
class table_sanree_brand_cmenu  extends discuz_table
{

	public function __construct() {

		$this->_table = 'sanree_brand_cmenu';
		$this->_pk    = 'id';

		parent::__construct();
	}

	public function count_by_where($where) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE 1 %i", array($this->_table, $where));
	}
	public function fetch_all_by_search($condition, $orderby, $start = 0, $ppp = 0) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		}	
		return XDB::fetch_all("SELECT * FROM %t WHERE 1 %i ORDER BY %i LIMIT %d, %d", array($this->_table, $where, $orderby, $start, $ppp));
	}		
	public function getusermenu($istop=0) {
		return XDB::fetch_all("SELECT * FROM %t WHERE 1 and status=1 and istop=%d ORDER BY displayorder ", array($this->_table, $istop));
	}			
}
//From:www_YMG6_COM
?>