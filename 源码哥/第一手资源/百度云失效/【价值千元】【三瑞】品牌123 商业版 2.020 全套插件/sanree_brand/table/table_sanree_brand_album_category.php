<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_brand_album_category.php 27449 2012-02-01 05:32:35Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_sanree_brand_album_category extends discuz_table
{
    var $_membertable;
    var $_joinbrandtable;	
	
	public function __construct() {

		$this->_table = 'sanree_brand_album_category';
		$this->_joinbrandtable = 'sanree_brand_businesses';
		$this->_membertable = 'common_member';		
		$this->_pk    = 'catid';

		parent::__construct();
	}

	public function fetch_all_by_displayorder() {
		return XDB::fetch_all('SELECT * FROM %t ORDER BY displayorder', array($this->_table), $this->_pk);
	}

	public function fetch_all_numkey($numkey) {
		$allow_numkey = array('portal', 'articles', 'num');
		if(!in_array($numkey, $allow_numkey)) {
			return null;
		}
		return XDB::fetch_all("SELECT catid, $numkey FROM %t", array($this->_table), $this->_pk);
	}

	public function update_uid_by_bid($bid, $uid) {
		$args = array($this->_table, $uid, $bid);
		return XDB::query("UPDATE %t SET uid = %d WHERE bid=%d ", $args);
	}
	
	public function update_num_by_catid($num, $catid, $numlimit = false) {
		$args = array($this->_table, $num, $catid);
		if($numlimit !== false) {
			$sql = ' AND num>0';
			$args[] = $numlimit;
		}
		return XDB::query("UPDATE %t SET num=num+'%d' WHERE catid=%d {$sql}", $args);
	}

	public function fetch_catname_by_catid($catid) {
		return XDB::result_first('SELECT catname FROM %t WHERE catid=%d', array($this->_table, $catid));
	}
	public function fetch_bid_by_catid($catid) {
		return XDB::result_first('SELECT bid FROM %t WHERE catid=%d', array($this->_table, $catid));
	}
	public function fetch_by_catid($catid) {
		return XDB::fetch_first('SELECT * FROM %t WHERE catid=%d', array($this->_table, $catid));
	}			
	
	public function count_by_where($where) {
		return XDB::result_first("SELECT COUNT(*) FROM %t as c 
		LEFT JOIN %t as m ON c.uid = m.uid	
		LEFT JOIN %t as b ON b.bid = c.bid		
		WHERE 1 %i", array($this->_table, $this->_membertable, $this->_joinbrandtable, $where));
	}
	public function fetch_all_by_search($condition, $orderby, $start = 0, $ppp = 0) {
		return XDB::fetch_all("SELECT c.*,m.username,b.name as brandname FROM %t as c
		LEFT JOIN %t as m ON c.uid = m.uid	
		LEFT JOIN %t as b ON b.bid = c.bid	
		WHERE 1 %i ORDER BY %i LIMIT %d, %d", array($this->_table, $this->_membertable, $this->_joinbrandtable, $condition, $orderby, $start, $ppp));
	}		
	
	public function get_by_catid($catid) {
		return XDB::fetch_first("SELECT c.*,m.username,b.name as brandname FROM %t as c
		LEFT JOIN %t as m ON c.uid = m.uid	
		LEFT JOIN %t as b ON b.bid = c.bid		
		WHERE c.catid=%d order by c.displayorder", array($this->_table, $this->_membertable, $this->_joinbrandtable, $catid));
	}
	public function userget_by_catid($catid, $uid) {
		return XDB::fetch_first("SELECT c.*,m.username,b.name as brandname FROM %t as c
		LEFT JOIN %t as m ON c.uid = m.uid	
		LEFT JOIN %t as b ON b.bid = c.bid		
		WHERE c.catid=%d and c.uid =%d order by c.displayorder", array($this->_table, $this->_membertable, $this->_joinbrandtable, $catid, $uid));
	}	
		
	public function getcategory_by_pcateid($pcateid) {
	    $where = '';
		return XDB::fetch_all("SELECT c.*,m.username FROM %t as c
		LEFT JOIN %t as m ON c.uid = m.uid		
		WHERE c.upid=%d order by c.displayorder", array($this->_table, $this->_membertable, $pcateid));
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
	public function fetch_all_by_searchd($condition, $orderby) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		}	
		return XDB::fetch_all("SELECT * FROM %t WHERE 1 %i ORDER BY %i", array($this->_table, $where, $orderby));
	}	
	public function userupdate_by_catid($catid, $uid , $data) {
		if(!is_array($data) || empty($data)) {
			return null;
		}
		
		$condition = array();
		$catid = dintval($catid, true);
		$condition[] = XDB::field('catid', $catid);
		$uid = dintval($uid, true);
		$condition[] = XDB::field('uid', $uid);	
		return XDB::update($this->_table, $data, implode(' AND ', $condition));
	}
	function fixalbum($bid, $data){
		if(!is_array($data) || empty($data)) {
			return null;
		}
		$condition = array();
		$bid = dintval($bid, true);
		$condition[] = XDB::field('bid', $bid);
		return XDB::update($this->_table, $data, implode(' AND ', $condition));		
	}	
}
//www-FX8-co
?>