<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_brand_menu_order.php sanree checkedby.liuhuan.2014-05-02 $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}
 
class table_sanree_brand_menu_order  extends discuz_table {


	public function __construct() {

		$this->_table = 'sanree_brand_menu_order';
		$this->_pk    = 'index';
		
		parent::__construct();
	}

	public function count_by_wherec($condition) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		} else {
			$where = $condition;
		}
		return XDB::result_first("SELECT COUNT(*) FROM %t as a WHERE 1 %i", array($this->_table, $where));
	}	
	
	public function fetch_all_by_bid($bid) {
		return XDB::fetch_all("SELECT * FROM %t WHERE 1 AND bid= %i", array($this->_table, $bid));
	}
	
	public function get_by_aid($aid) {
		return XDB::fetch_first("SELECT * FROM %t WHERE aid=%d", array($this->_table, $aid));
	}
	
	public function getuid_by_bid($bid) {
		return XDB::fetch_all("SELECT uid FROM %t WHERE bid=%d", array($this->_table, $bid));
	}
	public function delete_by_bid_uid($bid, $uid) {
		return XDB::fetch_first("DELETE FROM %t WHERE `bid` = %d && `uid` = %d", array($this->_table, $bid, $uid));
	}
	
	public function getbid_by_bid($bid) {
		return XDB::fetch_first("SELECT bid FROM %t WHERE bid=%d", array($this->_table, $bid));
	}
		
	public function get_by_bid($bid) {
		return XDB::fetch_first("SELECT * FROM %t WHERE bid=%d ", array($this->_table, $bid));
	}
	
	public function fetch_all() {
		return XDB::fetch_first("SELECT * FROM %t ", array($this->_table));
	}

}
//From:www_YMG6_COM
?>