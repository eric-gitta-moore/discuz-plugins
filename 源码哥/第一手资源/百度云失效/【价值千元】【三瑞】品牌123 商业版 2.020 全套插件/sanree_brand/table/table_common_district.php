<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_common_district.php 28647 2012-03-07 02:03:00Z chenmengshu $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_district extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_district';
		$this->_pk    = 'id';

		parent::__construct();
	}

	public function fetch_all_by_upid($upid, $order = null, $sort = 'DESC') {
		$upid = is_array($upid) ? array_map('intval', (array)$upid) : dintval($upid);
		if($upid !== null) {
			$ordersql = $order !== null && !empty($order) ? ' ORDER BY '.XDB::order($order, $sort) : '';
			return XDB::fetch_all('SELECT * FROM %t WHERE '.XDB::field('upid', $upid)." $ordersql", array($this->_table), $this->_pk);
		}
		return array();
	}
	
	public function fetch_first_by_id($id) {
		return XDB::fetch_first('SELECT * FROM %t WHERE 1 and id=%d', array($this->_table, $id));
	}
	public function fetch_first_by_toupid($upid) {
		return XDB::fetch_first('SELECT * FROM %t WHERE 1 and upid=%d', array($this->_table, $upid));
	}
	public function fetch_all_by_toupid($upid) {
		return XDB::fetch_all('SELECT * FROM %t WHERE 1 and upid=%d', array($this->_table, $upid));
	}				

	public function fetch_all_by_name($name) {
		if(!empty($name)) {
			return XDB::fetch_all('SELECT * FROM %t WHERE '.XDB::field('name', $name), array($this->_table));
		}
		return array();
	}
	public function fetch_first_by_name($name, $upid) {
		return XDB::fetch_first("SELECT * FROM %t WHERE ".XDB::field('name', $name)." and upid=%d", array($this->_table, $upid));
	}	

}
//www-FX8-co
?>