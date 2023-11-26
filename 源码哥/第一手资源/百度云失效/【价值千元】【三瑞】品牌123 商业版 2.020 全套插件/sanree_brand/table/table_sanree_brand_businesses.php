<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_brand_businesses.php $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
 
class table_sanree_brand_businesses  extends discuz_table {

    var $_jointable;
	var $_membertable;
	var $_grouptable;
	var $_threadtable;
	var $_blockstyletable;

	public function __construct() {

		$this->_table = 'sanree_brand_businesses';
		$this->_jointable = 'sanree_brand_category';
		$this->_grouptable = 'sanree_brand_group';
		$this->_membertable = 'common_member';
		$this->_threadtable = 'forum_thread';
		$this->_blockstyletable = 'common_block_style';

		$this->_pk    = 'bid';
		
		parent::__construct();
	}
	
	public function count_by_groupid($groupid) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE groupid=%d", array($this->_table, $groupid));
	}
		
	public function count_by_cateid($cateid) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE cateid=%d", array($this->_table, $cateid));
	}
	
	public function count_by_dis($disname) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE srbirthprovince=%s OR srbirthcity=%s OR srbirthdist=%s OR srbirthcommunity=%s AND iscard=1", array($this->_table, $disname,$disname,$disname,$disname));
	}
	
	public function delete_by_bids($bids) {
		XDB::delete($this->_table, XDB::field('bid', $bids));
	}	
	
	public function count_by_where($where, $disname) {
		if($disname) {
			return XDB::result_first("SELECT COUNT(*) FROM %t WHERE srbirthprovince=%s OR srbirthcity=%s OR srbirthdist=%s OR srbirthcommunity=%s %i", array($this->_table, $disname,$disname,$disname,$disname, $where));
		}
			
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE 1 %i", array($this->_table, $where));
	}
	
	public function count_by_wherec($condition) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		}
		return XDB::result_first("SELECT COUNT(*) FROM %t as t LEFT JOIN %t AS c ON t.cateid = c.cateid WHERE 1 %i", array($this->_table, $this->_jointable, $where));
	}
	public function count_by_wherecrz($condition) {
		if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		}
		return XDB::result_first("SELECT COUNT(*) FROM %t as rz
		LEFT JOIN %t AS t ON t.bid = rz.bid
		LEFT JOIN %t AS c ON t.cateid = c.cateid
		WHERE 1 %i",
			array('sanree_mcertification' ,$this->_table, $this->_jointable,$where));
	}
		
	public function fetch_all_by_search($condition, $orderby, $start = 0, $ppp = 0) {
		return XDB::fetch_all("SELECT * FROM %t WHERE 1 %i ORDER BY %i LIMIT %d, %d", array($this->_table, $condition, $orderby, $start, $ppp));
	}
	
	public function fetch_all_by_searchdis($condition, $disname, $orderby, $start = 0, $ppp = 0) {
		if($disname) {
			return XDB::fetch_all("SELECT * FROM %t WHERE 1 %i AND srbirthprovince=%s OR srbirthcity=%s OR srbirthdist=%s OR srbirthcommunity=%s ORDER BY %i LIMIT %d, %d", array($this->_table, $condition, $disname, $disname, $disname, $disname, $orderby, $start, $ppp));
		}else {
			return XDB::fetch_all("SELECT * FROM %t WHERE 1 %i ORDER BY %i LIMIT %d, %d", array($this->_table, $condition, $orderby, $start, $ppp));
		}
	}
	
	public function fetch_all_by_searchc($condition, $orderby, $start = 0, $ppp = 0) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		}	
		return XDB::fetch_all("SELECT t.dateline as addtime ,t.*,tt.views as tviews,c.name as catename,m.username FROM %t as t 
		LEFT JOIN %t AS c ON t.cateid=c.cateid 
		LEFT JOIN %t m ON m.uid=t.uid
		LEFT JOIN %t tt ON t.tid=tt.tid
		WHERE 1 %i ORDER BY %i LIMIT %d, %d", array($this->_table, $this->_jointable, $this->_membertable, $this->_threadtable, $where, $orderby, $start, $ppp));
	}

	public function fetch_all_by_searchrz($condition, $orderby, $start = 0, $ppp = 0) {
		if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		}
		return XDB::fetch_all("SELECT t.dateline as addtime ,t.*,tt.views as tviews,c.name as catename,m.username FROM %t as rz
		LEFT JOIN %t AS t ON t.bid=rz.bid
		LEFT JOIN %t AS c ON t.cateid=c.cateid
		LEFT JOIN %t m ON m.uid=t.uid
		LEFT JOIN %t tt ON t.tid=tt.tid
		WHERE 1 %i ORDER BY %i LIMIT %d, %d", array('sanree_mcertification' ,$this->_table, $this->_jointable, $this->_membertable, $this->_threadtable, $where, $orderby, $start, $ppp));
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
	public function fetch_all_by_searche($condition, $orderby, $start = 0, $ppp = 0) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		} else {
			$where = ' AND '.$condition;
		}	
		return XDB::fetch_all("SELECT t.* FROM %t as t LEFT JOIN %t AS c ON t.cateid=c.cateid WHERE 1 %i ORDER BY %i LIMIT %d, %d", array($this->_table, $this->_jointable, $where, $orderby, $start, $ppp));
	}	
		
	public function fetch_all_by_uid($uid) {
		return XDB::result_first("SELECT * FROM %t WHERE uid=%d", array($this->_table, $uid));
	}
	
	public function fetch_tid_by_bid($bid) {
		return XDB::result_first("SELECT tid FROM %t WHERE bid=%d", array($this->_table, $bid));
	}	
	
	public function getbusinesses_by_brandno($brandno) {
		return XDB::result_first("SELECT bid FROM %t WHERE brandno='%i'", array($this->_table, $brandno));
	}
	
	public function get_by_brandno($brandno) {
		return XDB::fetch_first("SELECT * FROM %t WHERE brandno='%i'", array($this->_table, $brandno));
	}

	public function get_all_by_bid($bid) {
		return XDB::fetch_first("SELECT * FROM %t WHERE bid=%d", array($this->_table, $bid));
	}
	public function getname_by_bid($bid) {
		return XDB::result_first("SELECT name FROM %t WHERE bid='%i'", array($this->_table, $bid));
	}
	
	public function getgroupid_by_bid($bid) {
		return XDB::result_first("SELECT groupid FROM %t WHERE bid='%i'", array($this->_table, $bid));
	}	
	
	public function fetch_uid_by_bid($bid) {
		return XDB::result_first("SELECT uid FROM %t WHERE bid=%d", array($this->_table, $bid));
	}
	
	public function fetch_bid_by_brandname($brandname) {
		return XDB::result_first("SELECT bid FROM %t WHERE name='%i'", array($this->_table, $brandname));
	}
	
	public function fetch_by_brandname($brandname) {
		return XDB::fetch_first("SELECT * FROM %t WHERE name='%i'", array($this->_table, $brandname));
	}				
	public function fetch_first_byfid($fid) {
		return XDB::fetch_first("SELECT t.*,m.username FROM %t AS t
		LEFT JOIN %t AS m on t.uid = m.uid
		WHERE syngrouptid= %d", array($this->_table, $this->_membertable, $fid));
	}	
	public function fetch_first_bybid($bid) {
		return XDB::fetch_first("SELECT t.*,m.username FROM %t AS t
		LEFT JOIN %t AS m on t.uid = m.uid
		WHERE bid= %d", array($this->_table, $this->_membertable, $bid));
	}
	public function fetch_all_by_arrbid($bid) {
		return XDB::fetch_all("SELECT * FROM %t WHERE bid IN(%n)", array($this->_table, (array)$bid));
	}
	public function getusername_by_bid($bid) {
		return XDB::fetch_first("SELECT mr.*,m.username AS user FROM %t mr LEFT JOIN %t m ON m.uid=mr.uid where bid=%d", array($this->_table, $this->_membertable, $bid));	
	}	
	
	public function getusername_by_bidanduid($uid, $bid) {
		return XDB::fetch_first("SELECT mr.*,m.username AS user FROM %t mr LEFT JOIN %t m ON m.uid=mr.uid where mr.bid=%d and mr.uid=%d", array($this->_table, $this->_membertable, $bid, $uid));	
	}	
		
	public function getbusinesses_by_bid($bid) {
		return XDB::fetch_first("SELECT t.*,c.name AS catename,m.username AS user FROM %t as t LEFT JOIN %t as c on t.cateid=c.cateid LEFT JOIN %t m ON m.uid=t.uid where c.status=1 and t.status=1 and t.bid=%d", array($this->_table, $this->_jointable, $this->_membertable, $bid));	
	}
	public function usergetbusinesses_by_bid($bid, $uid) {
		return XDB::fetch_first("SELECT t.*,c.name AS catename,m.username AS user FROM %t as t LEFT JOIN %t as c on t.cateid=c.cateid LEFT JOIN %t m ON m.uid=t.uid where c.status=1 and t.status=1 and t.bid=%d AND t.uid=%d", array($this->_table, $this->_jointable, $this->_membertable, $bid, $uid));	
	}	
	public function getbusinesses_by_tid($tid) {
		return XDB::fetch_first("SELECT t.*,c.name AS catename,m.username AS user FROM %t as t LEFT JOIN %t as c on t.cateid=c.cateid LEFT JOIN %t m ON m.uid=t.uid where c.status=1 and t.status=1 and t.tid=%d", array($this->_table, $this->_jointable, $this->_membertable, $tid));	
	}	
	
	public function update_by_bids($ids, $data) {
		return XDB::update($this->_table, $data, XDB::field('bid', $ids));
	}	
	
	public function update_all($data) {
		if (is_array($data)) {
			$update=array();
			foreach($data as $key => $val) {
				$update[]="`".$key."` = '".$val."'";
			}
			$setwhere = implode($update, ', ');
			XDB::query("UPDATE ".XDB::table($this->_table)." SET ".$setwhere);
		}
	}
		
	public function addfield($addsql) {
		runquery("ALTER TABLE ".XDB::table($this->_table)." ADD ".$addsql);	
	}
	
	public function usergetmaxalbumcategory_by_bid($bid, $uid) {
	
		return XDB::fetch_first("SELECT g.maxalbumcategory, g.maxalbum FROM %t as t 
		LEFT JOIN %t as g on t.groupid=g.groupid 
		where t.bid=%d and t.uid=%d", array($this->_table, $this->_grouptable, $bid, $uid));	

	}
	
	public function fix_get_block($hash) {
		return XDB::result_first("SELECT * FROM %t WHERE hash=%s", array($this->_blockstyletable, $hash));
	}
		
	public function fix_update_block($hash, $data) {
	    return XDB::update($this->_blockstyletable, $data, XDB::field('hash', $hash));
	}
	
	public function fix_insert_block($data) {
		return XDB::insert($this->_blockstyletable, $data);
	}
	public function fetch_all_forblock($where, $orderby, $ordersc, $itemsnum) {
		return XDB::fetch_all("SELECT t.*,tt.views,c.name as catename FROM %t AS t 
		LEFT JOIN %t AS c ON t.cateid=c.cateid 
		LEFT JOIN %t AS tt ON t.tid=tt.tid %i ORDER BY %i %i %i", array($this->_table, $this->_jointable, $this->_threadtable, $where, $orderby, $ordersc, $itemsnum));
	}
	public function usergetbusinesses_by_tid($tid) {
		return XDB::fetch_all("SELECT bid,tid,name,cateid,groupid FROM %t WHERE tid IN(%n)", array($this->_table, (array)$tid,));
	}

}
//From:www_YMG6_COM
?>