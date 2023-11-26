<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_brand_signature.php $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
 
class table_sanree_brand_signature extends discuz_table {

    var $_membertable;
	var $_brandtable;

	public function __construct() {

		$this->_table = 'sanree_brand_signature';
		$this->_membertable = 'common_member';		
		$this->_brandtable = 'sanree_brand_businesses';
		$this->_pk    = 'signatureid';
		
		parent::__construct();
	}

	public function count_by_where($condition) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		}else {
			$where = $condition;
		}	
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE 1 %i", array($this->_table, $where));
	}
		
	public function fetch_all_by_search($condition, $orderby, $start = 0, $ppp = 0) {
		return XDB::fetch_all("SELECT * FROM %t WHERE 1 %i ORDER BY %i LIMIT %d, %d", array($this->_table, $condition, $orderby, $start, $ppp));
	}
	public function count_by_wherec($condition) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		}else {
			$where = $condition;
		}		
		return XDB::result_first("SELECT COUNT(*) FROM %t as si 
		LEFT JOIN %t as b ON b.bid = si.bid
		LEFT JOIN %t as m ON m.uid = si.uid
		WHERE 1 %i", array($this->_table, $this->_brandtable, $this->_membertable, $where));
	}
	public function fetch_all_by_searchc($condition, $orderby, $start = 0, $ppp = 0) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		}else {
			$where = $condition;
		}		
		return XDB::fetch_all("SELECT si.*, b.name as brandname,m.username FROM %t as si
		LEFT JOIN %t as b ON b.bid = si.bid
		LEFT JOIN %t as m ON m.uid = si.uid
		WHERE 1 %i ORDER BY %i LIMIT %d, %d", array($this->_table, $this->_brandtable, $this->_membertable, $where, $orderby, $start, $ppp));
	}			
	public function fetch_first_by_uid($uid) {
		return XDB::fetch_first("SELECT si.*,m.username FROM %t as si
		LEFT JOIN %t as m ON m.uid = si.uid
		WHERE si.uid= %d", array($this->_table,$this->_membertable, $uid));
	}
	public function fetch_first_by_signatureid($signatureid) {
	    return XDB::fetch_first("SELECT si.*,m.username FROM %t as si 
		LEFT JOIN %t as m ON m.uid = si.uid
		WHERE signatureid= %d", array($this->_table, $this->_membertable, $signatureid));
	}
 
}
//From:www_YMG6_COM
?>