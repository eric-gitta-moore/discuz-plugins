<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_brand_district.php $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
 
class table_sanree_brand_district  extends discuz_table {

	public function __construct() {

		$this->_table = 'sanree_brand_district';
		$this->_pk    = 'id';
		
		parent::__construct();
	}
 
	public function count_by_where($where) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE 1 %i", array($this->_table, $where));
	}
 
	public function fetch_all_by_search($condition, $orderby, $start = 0, $ppp = 0) {
		return XDB::fetch_all("SELECT * FROM %t WHERE 1 %i ORDER BY %i LIMIT %d, %d", array($this->_table, $condition, $orderby, $start, $ppp));
	}
	
	public function count_by_id($id) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE upid=%d", array($this->_table, $id));
	}
	public function fetch_first_by_id($id) {
		return XDB::fetch_first("SELECT * FROM %t WHERE id=%d", array($this->_table, $id));
	}
	public function fetch_all_by_upid($upid, $order = null, $sort = 'DESC') {
		$upid = is_array($upid) ? array_map('intval', (array)$upid) : dintval($upid);
		if($upid !== null) {
			$ordersql = $order !== null && !empty($order) ? ' ORDER BY '.XDB::order($order, $sort) : '';
			return XDB::fetch_all('SELECT * FROM %t WHERE enabled=1 and '.XDB::field('upid', $upid)." $ordersql", array($this->_table), $this->_pk);
		}
		return array();
	}
	public function result_level_by_id($id) {
		return XDB::result_first("SELECT level FROM %t WHERE id=%d", array($this->_table, $id));
	}		
	public function fetch_all_by_name($name) {
		if(!empty($name)) {
			return XDB::fetch_all('SELECT * FROM %t WHERE '.XDB::field('name', $name), array($this->_table));
		}
		return array();
	}	
	public function fetch_all_by_toupid($upid) {
		return XDB::fetch_all('SELECT * FROM %t WHERE 1 and  enabled=1 and upid=%d', array($this->_table, $upid));
	}	
	public function cleartable() {
		runquery("TRUNCATE TABLE `".XDB::table($this->_table)."`;");
	}		
}
//From:www_YMG6_COM
?>