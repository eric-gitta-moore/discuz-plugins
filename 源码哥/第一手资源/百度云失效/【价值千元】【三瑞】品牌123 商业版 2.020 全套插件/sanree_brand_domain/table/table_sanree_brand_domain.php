<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_brand_domain.php 28041 2012-02-21 07:33:55Z chenmengshu $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_sanree_brand_domain extends discuz_table
{
	var $_jointable;
	var $_brandtable;		
	
	public function __construct() {

		$this->_table = 'sanree_brand_domain';
		$this->_jointable = 'sanree_brand_domain_brand2domain';	
		$this->_brandtable = 'sanree_brand_businesses';			
		$this->_pk    = 'domainid';

		parent::__construct();
	}
	public function count_by_where($where) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE 1 %i", array($this->_table, $where));
	}	
	public function fetch_all_by_search($condition, $orderby) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
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
	public function count_by_whered($condition) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		} else {
			$where = $condition;
		}
		return XDB::result_first("SELECT COUNT(*) FROM %t as d 
		LEFT JOIN %t AS b ON b.domainid = d.domainid 
		WHERE 1 %i", array($this->_table, $this->_jointable, $where));
	}
	public function fetch_all_by_searchd($condition, $orderby, $start = 0, $ppp = 0) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		} else {
			$where = $condition;
		}
		return XDB::fetch_all("SELECT d.*,b.isshow, br.name AS brandname FROM %t as d
		LEFT JOIN %t AS b ON b.domainid = d.domainid 
		LEFT JOIN %t AS br ON br.bid = b.bid 		
		WHERE 1 %i ORDER BY %i LIMIT %d, %d", array($this->_table, $this->_jointable, $this->_brandtable, $where, $orderby, $start, $ppp));
	}	
	public function get_by_domainid($domainid) {
		return XDB::fetch_first("SELECT * FROM %t WHERE domainid=%d", array($this->_table, $domainid));
	}

	public function fetch_by_domainname($domainname) {
		return XDB::fetch_first("SELECT * FROM %t WHERE domainname=%s", array($this->_table, $domainname));
	}
	public function get_by_uidanddomainid($uid, $domainid) {
		return XDB::fetch_first("SELECT * FROM %t WHERE uid=%d AND domainid=%d", array($this->_table, $uid, $domainid));
	}			

}
//www-FX8-co
?>