<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_brand_video_diytemplate.php 28041 2012-02-21 07:33:55Z chenmengshu $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_sanree_brand_video_diytemplate extends discuz_table
{
		
	public function __construct() {

		$this->_table = 'sanree_brand_video_diytemplate';
		$this->_pk    = 'diytemplateid';

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
	public function get_by_diytemplateid($diytemplateid) {
		return XDB::fetch_first("SELECT * FROM %t WHERE diytemplateid=%d", array($this->_table, $diytemplateid));
	}
	
	public function srupdate($val, $data, $condition='', $unbuffered = false, $low_priority = false) {
		if(isset($val) && !empty($data) && is_array($data)) {
			$this->checkpk();
			$where = '';
			if (empty($condition)) {
				$where = XDB::field($this->_pk, $val);
			} elseif (is_array($condition)) {
				$where = XDB::field($this->_pk, $val).' AND '.self::implode($condition, ' AND ');
			} else {
				$where = XDB::field($this->_pk, $val).' AND '.$condition;
			}			
			$ret = XDB::update($this->_table, $data, $where, $unbuffered, $low_priority);
			foreach((array)$val as $id) {
				$this->update_cache($id, $data);
			}
			return $ret;
		}
		return !$unbuffered ? 0 : false;
	}
	public function srdelete($val, $condition='', $unbuffered = false) {
		$ret = false;
		if(isset($val)) {
			$this->checkpk();
			$where = '';
			if (empty($condition)) {
				$where = XDB::field($this->_pk, $val);
			} elseif (is_array($condition)) {
				$where = XDB::field($this->_pk, $val).' AND '.self::implode($condition, ' AND ');
			} else {
				$where = XDB::field($this->_pk, $val).' AND '.$condition;
			}			
			$ret = XDB::delete($this->_table, $where, null, $unbuffered);
			$this->clear_cache($val);
		}
		return $ret;
	}	
}
//www-FX8-co
?>