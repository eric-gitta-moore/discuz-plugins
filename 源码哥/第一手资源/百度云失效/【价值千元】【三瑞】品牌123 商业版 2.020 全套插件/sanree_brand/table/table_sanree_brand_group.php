<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_company_group.php $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
 
class table_sanree_brand_group  extends discuz_table
{
    var $_membertable;

	public function __construct() {

		$this->_table = 'sanree_brand_group';
		$this->_membertable = 'common_member';		
		$this->_pk    = 'groupid';

		parent::__construct();
	}
	
	public function fetch_all_group() {
		return XDB::fetch_all("SELECT * FROM %t WHERE 1 and isuse=1", array($this->_table));
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
	
	public function get_by_groupid($groupid) {
		return XDB::fetch_first("SELECT t.*,m.username as user FROM %t AS t
		LEFT JOIN %t AS m on t.adminid = m.uid
		WHERE t.groupid= %d", array($this->_table, $this->_membertable, $groupid));
	}
	
	public function get_by_order($order) {
		return XDB::fetch_first("SELECT * FROM %t WHERE `order`=%d", array($this->_table, $order));
	}
	
	public function get_by_maxorder() {
		return XDB::fetch_first("SELECT * FROM %t ORDER BY `order`  DESC", array($this->_table));
	}
	
	public function fetch_order_by_groupid($groupid) {
		return XDB::fetch_first("SELECT `order` FROM %t WHERE groupid=%d", array($this->_table, $groupid));
	}
	
	public function fetch_all_by_order($order) {
		return XDB::fetch_all("SELECT * FROM %t WHERE `order`>%d ORDER BY `order` ", array($this->_table, $order));
	}
	
	public function fetch_groupname_by_order($order) {
		return XDB::result_first("SELECT groupname FROM %t WHERE `order` = %d ", array($this->_table, $order));
	}
	
	public function getgroup_by_gid($gid) {
		return XDB::fetch_first("SELECT groupname,price FROM %t WHERE groupid=%d ", array($this->_table, $gid));
	}
	
	public function fetch_mfandtag_by_groupid($groupid) {
		return XDB::fetch_first("SELECT ismf,istag FROM %t WHERE groupid=%d", array($this->_table, $groupid));
	}			
}
//From:www_YMG6_COM
?>