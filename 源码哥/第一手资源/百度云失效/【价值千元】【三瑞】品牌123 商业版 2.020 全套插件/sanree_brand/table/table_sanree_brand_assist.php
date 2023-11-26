<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_brand_assist.php sanree checkedby.liuhuan.2014-05-02 $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}
 
class table_sanree_brand_assist  extends discuz_table {


	public function __construct() {

		$this->_table = 'sanree_brand_assist';
		$this->_pk    = 'aid';
		
		parent::__construct();
	}
	
	public function count_by_groupid($groupid) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE groupid=%d", array($this->_table, $groupid));
	}
	
	public function count_by_where($where) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE 1 %i", array($this->_table, $where));
	}
	
	public function count_by_wherea($where) {
		return XDB::result_first("SELECT COUNT( * ) FROM %t AS t
		JOIN %t AS c ON t.bid = c.bid WHERE %i", array('sanree_brand_businesses', $this->_table, $where));
	}
		
	public function fetch_all_by_search($condition, $orderby) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');//把‘AND’放在$condition数组的元素见连接成字符串
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
	
	public function fetch_all_by_searcha($condition, $orderby, $start = 0, $ppp = 0) {
	    if (is_array($condition)) {
			$where = implode($condition, ' AND ');
		} else {
			$where = $condition;
		}
		return XDB::fetch_all("SELECT * FROM %t	AS t
		JOIN %t AS c ON t.bid = c.bid WHERE 1 AND %i ORDER BY %i LIMIT %d, %d", array('sanree_brand_businesses', $this->_table, $where, $orderby, $start, $ppp));
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
}
//From:www_YMG6_COM
?>