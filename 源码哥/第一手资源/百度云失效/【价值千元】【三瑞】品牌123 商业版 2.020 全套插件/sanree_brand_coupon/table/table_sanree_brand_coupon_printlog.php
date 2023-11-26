<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_brand_coupon_printlog.php $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
 
class table_sanree_brand_coupon_printlog  extends discuz_table {

    var $_jointable;
	var $_brandtable;
	public function __construct() {

		$this->_table = 'sanree_brand_coupon_printlog';
		$this->_jointable = 'sanree_brand_coupon';
		$this->_pk    = 'printlogid';
		$this->_brandtable = 'sanree_brand_businesses';	
		
		parent::__construct();
	}
	public function count_by_bid($bid) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE bid=%d", array($this->_table, $bid));
	}
	public function count_by_cid($cid) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE cid=%d", array($this->_table, $cid));
	}	
	public function count_by_cid_and_uid($cid,$uid) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE cid=%d AND uid =%d", array($this->_table, $cid, $uid));
	}
	public function count_by_where($where) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE 1 %i", array($this->_table, $where));
	}
	public function fetch_first_by_printlogid_and_uid($printlogid, $uid) {
		return XDB::fetch_first("SELECT * FROM %t WHERE printlogid=%d AND uid = %d", array($this->_table, $printlogid, $uid));
	}
	public function fetch_first_by_printlogid_and_puid($printlogid, $puid) {
		return XDB::fetch_first("SELECT t.*,c.minprice FROM %t AS t
		LEFT JOIN %t as c ON c.cid = t.cid
		WHERE printlogid=%d AND puid = %d", array($this->_table,$this->_jointable, $printlogid, $puid));
	}		
	
	public function fetch_all_by_search($condition, $orderby, $start = 0, $ppp = 0) {
		return XDB::fetch_all("SELECT * FROM %t WHERE 1 %i ORDER BY %i LIMIT %d, %d", array($this->_table, $condition, $orderby, $start, $ppp));
	}
	public function count_by_wherec($condition) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		} else {
			$where = $condition;
		}	
		return XDB::result_first("SELECT COUNT(*) FROM %t as t LEFT JOIN %t AS c ON t.bid = c.bid WHERE 1 %i", array($this->_table, $this->_brandtable, $where));
	}	
	public function fetch_all_by_searchc($condition, $orderby, $start = 0, $ppp = 0) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		} else {
			$where = $condition;
		}		
		return XDB::fetch_all("SELECT t.*,c.name,b.name as brandname FROM %t as t
		LEFT JOIN %t as c ON c.cid = t.cid
		LEFT JOIN %t as b ON t.bid = b.bid
		WHERE 1 %i ORDER BY %i LIMIT %d, %d", array($this->_table, $this->_jointable, $this->_brandtable, $where, $orderby, $start, $ppp));
	}
	public function fetch_all_by_searchd($condition, $orderby, $start = 0, $ppp = 0) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		} else {
			$where = $condition;
		}	
		return XDB::fetch_all("SELECT t.*,c.name,b.name as brandname FROM %t as t
		LEFT JOIN %t as c ON c.cid = t.cid
		LEFT JOIN %t as b ON t.bid = b.bid
		WHERE 1 %i ORDER BY %i LIMIT %d, %d", array($this->_table, $this->_jointable, $this->_brandtable, $where, $orderby, $start, $ppp));
	}
	public function fetch_all_by_searche($group, $condition, $orderby, $start = 0, $ppp = 0) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		} else {
			$where = $condition;
		}		
		return XDB::fetch_all("SELECT * FROM %t WHERE 1 %i group by %i ORDER BY %i LIMIT %d, %d", array($this->_table, $where, $group, $orderby, $start, $ppp));
	}						
}
//From:www_YMG6_COM
?>