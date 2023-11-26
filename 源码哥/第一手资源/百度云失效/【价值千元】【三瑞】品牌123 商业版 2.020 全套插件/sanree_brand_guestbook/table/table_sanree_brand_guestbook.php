<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_brand_guestbook.php $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
 
class table_sanree_brand_guestbook extends discuz_table {

    var $_membertable;
	var $_brandtable;

	public function __construct() {

		$this->_table = 'sanree_brand_guestbook';
		$this->_membertable = 'common_member';
		$this->_brandtable = 'sanree_brand_businesses';
		$this->_pk    = 'guestbookid';
		
		parent::__construct();
	}

	public function count_by_where($condition, $isdelete = TRUE) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		}else {
			$where = $condition;
		}	
		if ($isdelete) {
		    $where.= ' AND isdelete=0';
		}
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE 1 %i", array($this->_table, $where));
	}
		
	public function fetch_all_by_search($condition, $orderby, $start = 0, $ppp = 0, $isdelete = TRUE) {
		if ($isdelete) {
		    $condition.= ' AND isdelete=0';
		}	
		return XDB::fetch_all("SELECT * FROM %t WHERE 1 %i ORDER BY %i LIMIT %d, %d", array($this->_table, $condition, $orderby, $start, $ppp));
	}
	public function count_by_wherec($condition, $isdelete = TRUE) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		}else {
			$where = $condition;
		}
		if ($isdelete) {
		    $where.= ' AND gb.isdelete=0';
		}			
		return XDB::result_first("SELECT COUNT(*) FROM %t as gb 
		LEFT JOIN %t as b ON b.bid = gb.bid
		WHERE 1 %i", array($this->_table, $this->_brandtable, $where));
	}
	public function fetch_all_by_searchc($condition, $orderby, $start = 0, $ppp = 0, $isdelete = TRUE) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		}else {
			$where = $condition;
		}
		if ($isdelete) {
		    $where.= ' AND gb.isdelete=0';
		}			
		return XDB::fetch_all("SELECT gb.*, b.name as brandname FROM %t as gb
		LEFT JOIN %t as b ON b.bid = gb.bid
		WHERE 1 %i ORDER BY %i LIMIT %d, %d", array($this->_table, $this->_brandtable, $where, $orderby, $start, $ppp));
	}		
	public function fetch_first_by_guestbookid($guestbookid, $isdelete = TRUE) {
	    $where = " AND guestbookid=".$guestbookid;
		if ($isdelete) {
		    $where.= ' AND isdelete=0';
		}	
		return XDB::fetch_first("SELECT * FROM %t WHERE 1 %i", array($this->_table, $where));
	}
	public function fetch_all_by_bid($bid, $isdelete = TRUE) {
	    $where = " AND bid=".$bid;
		if ($isdelete) {
		    $where.= ' AND isdelete=0';
		}	
		return XDB::fetch_all("SELECT * FROM %t WHERE 1 %i", array($this->_table, $where));
	}			
	public function fetch_all_by_uid($uid, $isdelete = TRUE) {
	    $where = " AND uid=".$uid;
		if ($isdelete) {
		    $where.= ' AND isdelete=0';
		}	
		return XDB::fetch_all("SELECT * FROM %t WHERE %i", array($this->_table, $where));
	}
	public function fetch_uid_by_guestbookid($guestbookid, $isdelete = TRUE) {
	    $where = " AND guestbookid=".$guestbookid;
		if ($isdelete) {
		    $where.= ' AND isdelete=0';
		}		
		return XDB::result_first("SELECT uid FROM %t WHERE %i", array($this->_table, $where));
	}
 
}
//From:www_YMG6_COM
?>