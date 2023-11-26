<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_brand_album.php 28041 2012-02-21 07:33:55Z chenmengshu $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_sanree_brand_album extends discuz_table
{
    var $_joinbrandtable;
    var $_membertable;
	var $_catetable;
		
	public function __construct() {

		$this->_table = 'sanree_brand_album';
		$this->_catetable = 'sanree_brand_album_category';
		$this->_joinbrandtable = 'sanree_brand_businesses';
		$this->_membertable = 'common_member';		
		$this->_pk    = 'albumid';

		parent::__construct();
	}
	public function count_by_where($where) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE 1 %i", array($this->_table, $where));
	}	
	
	public function count_by_catid($catid) {
		return XDB::result_first('SELECT COUNT(*) FROM %t WHERE catid = %d', array($this->_table, $catid));
	}

	public function count_by_uid($uid) {
		return XDB::result_first('SELECT COUNT(*) FROM %t WHERE uid = %d', array($this->_table, $uid));
	}

	public function update_num_by_albumid($albumid, $inc, $field = 'picnum', $uid = '') {
		if(!in_array($field, array('picnum', 'favtimes', 'sharetimes'))) {
			return null;
		}
		$parameter = array($this->_table, $inc, $albumid);
		if($uid) {
			$parameter[] = $uid;
			$uidsql = ' AND uid = %d';
		}
		return XDB::query('UPDATE %t SET '.$field.'='.$field.'+\'%d\' WHERE albumid=%d '.$uidsql, $parameter);
	}

	public function update_uid_by_bid($bid, $uid) {
		$args = array($this->_table, $uid, $bid);
		return XDB::query("UPDATE %t SET uid = %d WHERE bid=%d ", $args);
	}
	
	public function delete_by_uid($uid) {
		if(!$uid) {
			return null;
		}
		return XDB::delete($this->_table, XDB::field('uid', $uid));
	}

	public function update_by_catid($catid, $data) {
		if(!is_array($data) || empty($data)) {
			return null;
		}
		return XDB::update($this->_table, $data, XDB::field('catid', $catid));
	}

	public function fetch_uid_by_username($users) {
		if(!$users) {
			return null;
		}
		return XDB::fetch_all('SELECT uid FROM %t WHERE username IN (%n)', array($this->_table, $users), 'uid');
	}

	public function fetch_albumid_by_albumname_uid($albumname, $uid) {
		return XDB::result_first('SELECT albumid FROM %t WHERE albumname=%s AND uid=%d', array($this->_table, $albumname, $uid));
	}

	public function fetch_albumid_by_searchkey($searchkey, $limit) {
		return XDB::fetch_all('SELECT albumid FROM %t WHERE 1 %i ORDER BY albumid DESC %i', array($this->_table, $searchkey, XDB::limit(0, $limit)));
	}

	public function fetch_uid_by_uid($uid) {
		if(!is_array($uid)) {
			$uid = explode(',', $uid);
		}
		if(!$uid) {
			return null;
		}
		return XDB::fetch_all('SELECT uid FROM %t WHERE uid IN (%n)', array($this->_table, $uid), 'uid');
	}

	public function fetch($albumid, $uid = '') {
		$data = $this->fetch_all_by_uid($uid, false, 0, 0, $albumid);
		return $data[0];
	}

	public function fetch_all($albumids, $order = false, $start = 0, $limit = 0) {
		return $this->fetch_all_by_uid('', $order, $start, $limit, $albumids);
	}

	public function fetch_all_by_uid($uid, $order = false, $start = 0, $limit = 0, $albumid = '') {
		$parameter = array($this->_table);
		$wherearr = array();
		if($albumid) {
			$wherearr[] = XDB::field('albumid', $albumid);
		}
		if($uid) {
			$wherearr[] = XDB::field('uid', $uid);
		}
		if(is_string($order) && $order = XDB::order($order, 'DESC')) {
			$ordersql = ' ORDER BY '.$order;
		}
		if($limit) {
			$parameter[] = XDB::limit($start, $limit);
			$ordersql .= ' %i';
		}

		$wheresql = !empty($wherearr) && is_array($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';

		if(empty($wheresql)) {
			return null;
		}

		return XDB::fetch_all('SELECT * FROM %t '.$wheresql.$ordersql, $parameter);
	}

	public function fetch_all_by_block($aids, $bannedids, $uids, $catid, $startrow, $items, $orderby) {
		$wheres = array();
		if($aids) {
			$wheres[] = XDB::field('albumid', $aids, 'in');
		}
		if($bannedids) {
			$wheres[]  = XDB::field('albumid', $bannedids, 'notin');
		}
		if($uids) {
			$wheres[] = XDB::field('uid', $uids, 'in');
		}
		if($catid && !in_array('0', $catid)) {
			$wheres[] = XDB::field('catid', $catid, 'in');
		}
		$wheres[] = "friend = '0'";
		$wheresql = $wheres ? implode(' AND ', $wheres) : '1';

		if(!in_array($orderby, array('dateline', 'picnum', 'updatetime'))) {
			$orderby = 'dateline';
		}

		return XDB::fetch_all('SELECT * FROM '.XDB::table($this->_table).' WHERE '.$wheresql.' ORDER BY '.XDB::order($orderby, 'DESC').XDB::limit($startrow, $items));
	}

	public function fetch_all_by_searchex($condition, $orderby, $start = 0, $ppp = 0) {
		return XDB::fetch_all("SELECT * FROM %t	WHERE 1 %i ORDER BY %i LIMIT %d, %d", array($this->_table, $condition, $orderby, $start, $ppp));
	}

	public function fetch_all_by_cateid($cateid) {
		return XDB::fetch_all("SELECT * FROM %t	WHERE catid = %i ORDER BY ishome desc,displayorder,albumid desc", array($this->_table, $cateid));
	}

	public function count_by_whered($where) {
		return XDB::result_first("SELECT COUNT(*) FROM %t as a
		LEFT JOIN %t as m ON a.uid = m.uid	
		LEFT JOIN %t as b ON a.bid = b.bid
		LEFT JOIN %t as c ON a.catid = c.catid	
		WHERE 1 %i", array($this->_table, $this->_membertable, $this->_joinbrandtable,$this->_catetable, $where));
	}
		
	public function fetch_all_by_searched($condition, $orderby, $start = 0, $ppp = 0) {
		return XDB::fetch_all("SELECT a.* FROM %t	as a
		LEFT JOIN %t as m ON a.uid = m.uid			
		LEFT JOIN %t as b ON a.bid = b.bid
		LEFT JOIN %t as c ON a.catid = c.catid			
		WHERE 1 %i ORDER BY %i LIMIT %d, %d", array($this->_table, $this->_membertable, $this->_joinbrandtable,$this->_catetable, $condition, $orderby, $start, $ppp));
	}	
	
	public function fetch_all_by_search($fetchtype, $uids, $albumname, $searchname, $catid, $starttime, $endtime, $albumids, $friend = '', $orderfield = '', $ordersort = 'DESC', $start = 0, $limit = 0, $findex = '') {
		$parameter = array($this->_table);
		$wherearr = array();
		if(is_array($uids) && count($uids)) {
			$parameter[] = $uids;
			$wherearr[] = 'uid IN(%n)';
		}

		if($albumname) {
			if($searchname == false) {
				$parameter[] = $albumname;
				$wherearr[] = 'albumname=%s';
			} else {
				$parameter[] = '%'.$albumname.'%';
				$wherearr[] = 'albumname LIKE %s';
			}
		}

		if($catid) {
			$parameter[] = $catid;
			$wherearr[] = 'catid=%d';
		}

		if($starttime) {
			$parameter[] = is_numeric($starttime) ? $starttime : strtotime($starttime);
			$wherearr[] = 'dateline>%d';
		}

		if($endtime) {
			$parameter[] = is_numeric($endtime) ? $endtime : strtotime($endtime);
			$wherearr[] = 'dateline<%d';
		}

		if(is_numeric($friend)) {
			$parameter[] = $friend;
			$wherearr[] = 'friend=%d';
		}

		if(is_array($albumids) && count($albumids)) {
			$parameter[] = $albumids;
			$wherearr[] = 'albumid IN(%n)';
		}

		if($fetchtype == 3) {
			$selectfield = "count(*)";
		} elseif ($fetchtype == 2) {
			$selectfield = "albumid";
		} else {
			$selectfield = "*";
			if(is_string($orderfield) && $order = XDB::order($orderfield, $ordersort)) {
				$ordersql = 'ORDER BY '.$order;
			}
			if($limit) {
				$parameter[] = XDB::limit($start, $limit);
				$ordersql .= ' %i';
			}
		}

		if($findex) {
			$findex = 'USE INDEX(updatetime)';
		}

		$wheresql = !empty($wherearr) && is_array($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';

		if($fetchtype == 3) {
			return XDB::result_first("SELECT $selectfield FROM %t $wheresql", $parameter);
		} else {
			return XDB::fetch_all("SELECT $selectfield FROM %t {$findex} $wheresql $ordersql", $parameter);
		}
	}
	public function count_by_wherec($condition) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		}
		return XDB::result_first("SELECT COUNT(*) FROM %t as a WHERE 1 %i", array($this->_table, $where));
	}	
	
	public function fetch_all_by_searchc($condition, $orderby, $start = 0, $ppp = 0) {
	    if (is_array($condition)) {
			$where = " AND ".implode($condition, ' AND ');
		}	
		return XDB::fetch_all("SELECT a.*,b.name FROM %t as a
		LEFT JOIN %t as b ON a.bid = b.bid
		WHERE 1 %i ORDER BY %i LIMIT %d, %d", array($this->_table, $this->_joinbrandtable, $where, $orderby, $start, $ppp));
	}
	public function get_by_albumid($albumid) {
		return XDB::fetch_first("SELECT * FROM %t
		WHERE albumid=%d order by displayorder", array($this->_table, $albumid));
	}
	public function userget_by_albumid($albumid, $uid) {
		return XDB::fetch_first("SELECT * FROM %t
		WHERE albumid=%d AND uid=%d order by displayorder", array($this->_table, $albumid, $uid));
	}	
	
	public function userupdate($albumid, $uid, $data) {
		if(!is_array($data) || empty($data)) {
			return null;
		}	
		$condition = array();
		$albumid = dintval($albumid, true);
		$condition[] = XDB::field('albumid', $albumid);
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