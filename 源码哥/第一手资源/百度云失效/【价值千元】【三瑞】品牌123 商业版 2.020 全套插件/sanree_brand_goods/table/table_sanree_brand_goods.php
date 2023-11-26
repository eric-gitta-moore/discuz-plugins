<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_brand_goods.php $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
 
class table_sanree_brand_goods  extends discuz_table {

    var $_jointable;
	var $_membertable;
	var $_grouptable;
	var $_threadtable;
	var $_brandtable;

	public function __construct() {

		$this->_table = 'sanree_brand_goods';
		$this->_jointable = 'sanree_brand_goods_category';
		$this->_grouptable = 'sanree_brand_group';
		$this->_membertable = 'common_member';
		$this->_threadtable = 'forum_thread';
		$this->_brandtable = 'sanree_brand_businesses';			
		$this->_pk    = 'gid';
		
		parent::__construct();
	}
	
	public function count_by_groupid($groupid) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE groupid=%d", array($this->_table, $groupid));
	}
		
	public function count_by_cateid($cateid) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE cateid=%d", array($this->_table, $cateid));
	}
	
	public function delete_by_gids($gids) {
		XDB::delete($this->_table, XDB::field('gid', $gids));
	}	
	
	public function count_by_where($where) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE 1 %i", array($this->_table, $where));
	}
	
	public function count_by_wherec($condition) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		}
		return XDB::result_first("SELECT COUNT(*) FROM %t as t LEFT JOIN %t AS c ON t.cateid = c.cateid WHERE 1 %i", array($this->_table, $this->_jointable, $where));
	}
		
	public function fetch_all_by_search($condition, $orderby, $start = 0, $ppp = 0) {
		return XDB::fetch_all("SELECT * FROM %t WHERE 1 %i ORDER BY %i LIMIT %d, %d", array($this->_table, $condition, $orderby, $start, $ppp));
	}
	public function fetch_all_tid_by_gids($gid) {
	    if (is_array($gid)) {
			$where = implode($gid, ',');
		} else {
			$where = $gid;
		}
		return XDB::fetch_all("SELECT tid FROM %t WHERE 1 AND gid IN(%i)", array($this->_table, $where));
	}
	
	public function fetch_all_by_bid($bid) {
		return XDB::fetch_all("SELECT * FROM %t WHERE 1 AND bid= %i", array($this->_table, $bid));
	}			
	
	public function fetch_all_by_searchc($condition, $orderby, $start = 0, $ppp = 0) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		}	
		return XDB::fetch_all("SELECT b.groupid,t.dateline as addtime ,t.*,c.name as catename,m.username,b.name as brandname,b.qq,b.msn,b.wangwang,b.baiduhi,b.skype FROM %t as t 
		LEFT JOIN %t AS c ON t.cateid=c.cateid 
		LEFT JOIN %t m ON m.uid=t.uid
		LEFT JOIN %t tt ON t.tid=tt.tid
		LEFT JOIN %t b ON b.bid=t.bid
		WHERE 1 %i ORDER BY %i LIMIT %d, %d", array($this->_table, $this->_jointable, $this->_membertable, $this->_threadtable, $this->_brandtable, $where, $orderby, $start, $ppp));
	}
	public function fetch_all_by_searchd($condition, $orderby) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		}	
		return XDB::fetch_all("SELECT t.dateline as addtime ,t.*,c.name as catename,m.username FROM %t as t 
		LEFT JOIN %t AS c ON t.cateid=c.cateid 
		LEFT JOIN %t m ON m.uid=t.uid
		WHERE 1 %i ORDER BY %i", array($this->_table, $this->_jointable, $this->_membertable, $where, $orderby));
	}
		
		
	public function fetch_all_by_uid($uid) {
		return XDB::result_first("SELECT * FROM %t WHERE uid=%d", array($this->_table, $uid));
	}
	
	public function fetch_tid_by_gid($gid) {
		return XDB::result_first("SELECT tid FROM %t WHERE gid=%d", array($this->_table, $gid));
	}	
	
	public function getbusinesses_by_brandno($brandno) {
		return XDB::result_first("SELECT gid FROM %t WHERE brandno='%i'", array($this->_table, $brandno));
	}
		
	public function getname_by_gid($gid) {
		return XDB::result_first("SELECT name FROM %t WHERE gid='%i'", array($this->_table, $gid));
	}	
	
	public function fetch_uid_by_gid($gid) {
		return XDB::result_first("SELECT uid FROM %t WHERE gid=%d", array($this->_table, $gid));
	}
	
	public function fetch_gid_by_brandname($brandname) {
		return XDB::result_first("SELECT gid FROM %t WHERE name='%i'", array($this->_table, $brandname));
	}
	
	public function fetch_by_brandname($brandname) {
		return XDB::fetch_first("SELECT * FROM %t WHERE name='%i'", array($this->_table, $brandname));
	}				
		
	public function fetch_first_bygid($gid) {
		return XDB::fetch_first("SELECT t.*,m.username,b.qq,b.name as brandname FROM %t AS t
		LEFT JOIN %t AS m on t.uid = m.uid
		LEFT JOIN %t b ON b.bid=t.bid
		WHERE gid= %d", array($this->_table, $this->_membertable, $this->_brandtable, $gid));
	}		
		
	public function getusername_by_gid($gid) {
		return XDB::fetch_first("SELECT mr.*,m.username AS user FROM %t mr LEFT JOIN %t m ON m.uid=mr.uid where gid=%d", array($this->_table, $this->_membertable, $gid));	
	}	
	
	public function getusername_by_gidanduid($uid, $gid) {
		return XDB::fetch_first("SELECT mr.*,m.username AS user FROM %t mr LEFT JOIN %t m ON m.uid=mr.uid where mr.gid=%d and mr.uid=%d", array($this->_table, $this->_membertable, $gid, $uid));	
	}	
		
	public function getgoods_by_gid($gid) {
		return XDB::fetch_first("SELECT t.*,c.name AS catename,m.username AS user FROM %t as t LEFT JOIN %t as c on t.cateid=c.cateid LEFT JOIN %t m ON m.uid=t.uid where c.status=1 and t.status=1 and t.gid=%d", array($this->_table, $this->_jointable, $this->_membertable, $gid));	
	}
	public function usergetgoods_by_gid($gid, $uid) {
		return XDB::fetch_first("SELECT t.*,c.name AS catename,m.username AS user FROM %t as t LEFT JOIN %t as c on t.cateid=c.cateid LEFT JOIN %t m ON m.uid=t.uid where c.status=1 and t.status=1 and t.gid=%d AND t.uid=%d", array($this->_table, $this->_jointable, $this->_membertable, $gid, $uid));	
	}	
	public function getgoods_by_tid($tid) {
		return XDB::fetch_first("SELECT t.*,c.name AS catename,m.username AS user,b.name as brandname FROM %t as t 
		LEFT JOIN %t as c on t.cateid=c.cateid 
		LEFT JOIN %t m ON m.uid=t.uid 
		LEFT JOIN %t b ON b.bid=t.bid
		where c.status=1 and t.status=1 and t.tid=%d", array($this->_table, $this->_jointable, $this->_membertable, $this->_brandtable, $tid));	
	}	
	
	public function update_by_gids($ids, $data) {
		return XDB::update($this->_table, $data, XDB::field('gid', $ids));
	}	
	
	public function addfield($addsql) {
		runquery("ALTER TABLE ".XDB::table($this->_table)." ADD ".$addsql);	
	}
	
	public function usergetmaxalbumcategory_by_gid($gid, $uid) {
	
		return XDB::fetch_first("SELECT g.maxalbumcategory, g.maxalbum FROM %t as t 
		LEFT JOIN %t as g on t.groupid=g.groupid 
		where t.gid=%d and t.uid=%d", array($this->_table, $this->_grouptable, $gid, $uid));	

	}
	public function fetch_all_forblock($where, $orderby, $ordersc, $itemsnum) {
		return XDB::fetch_all("SELECT t.*,tt.views,c.name as catename,b.name as brandname,b.groupid FROM %t AS t 
		LEFT JOIN %t AS c ON t.cateid=c.cateid 
		LEFT JOIN %t AS tt ON t.tid=tt.tid 
		LEFT JOIN %t AS b ON t.bid=b.bid %i ORDER BY %i %i %i", array($this->_table, $this->_jointable, $this->_threadtable, $this->_brandtable,$where, $orderby, $ordersc, $itemsnum));
	}	
}
//From:www_YMG6_COM
?>