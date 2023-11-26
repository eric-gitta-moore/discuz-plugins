<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_brand_msg.php $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
 
class table_sanree_brand_msg  extends discuz_table {

    var $_jointable;
	
	public function __construct() {

		$this->_table = 'sanree_brand_msg';
		$this->_jointable = 'sanree_brand_businesses';
		$this->_pk    = 'msgid';
		
		parent::__construct();
	}
 
	public function count_by_where($where) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE 1 %i", array($this->_table, $where));
	}
 
	public function fetch_all_by_search($condition, $orderby, $start = 0, $ppp = 0) {
		return XDB::fetch_all("SELECT * FROM %t WHERE 1 %i ORDER BY %i LIMIT %d, %d", array($this->_table, $condition, $orderby, $start, $ppp));
	}
	
	public function getmsg_by_msgid($msgid) {
		return XDB::fetch_first("SELECT m.*,b.name as brandname FROM %t as m
		LEFT JOIN %t as b ON m.bid = b.bid
		WHERE msgid=%d", array($this->_table, $this->_jointable, $msgid));
	}
	
	public function count_by_wherec($condition) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		}
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE 1 %i", array($this->_table, $where));
	}
	
	public function fetch_all_by_searchc($condition, $orderby, $start = 0, $ppp = 0) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		}	
		return XDB::fetch_all("SELECT * FROM %t WHERE 1 %i ORDER BY %i LIMIT %d, %d", array($this->_table, $where, $orderby, $start, $ppp));
	}		

}
//From:www_YMG6_COM
?>