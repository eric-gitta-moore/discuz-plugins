<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_forum_forum_threadtable.php 27819 2012-02-15 05:12:23Z svn_project_zhangjie $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_forum_forum_threadtable extends discuz_table
{
	public function __construct() {

		$this->_table = 'forum_forum_threadtable';
		$this->_pk    = '';

		parent::__construct();
	}

	public function count_by_fid($fids) {
		if(empty($fids)) {
			return 0;
		}
		return XDB::result_first('SELECT COUNT(*) FROM %t WHERE '.XDB::field('fid', $fids), array($this->_table));
	}

	public function fetch_all_by_fid($fids) {
		if(empty($fids)) {
			return array();
		}
		return XDB::fetch_all('SELECT * FROM %t WHERE '.XDB::field('fid', $fids), array($this->_table));
	}

	public function update($fid, $threadtableid, $data, $unbuffered = false, $low_priority = false) {
		if(empty($data)) {
			return false;
		}
		return XDB::update($this->_table, $data, array('fid' => $fid, 'threadtableid' => $threadtableid), $unbuffered, $low_priority);
	}

	public function update_by_threadtableid($threadtableid, $data, $unbuffered = false, $low_priority = false) {
		if(empty($data)) {
			return false;
		}
		return XDB::update($this->_table, $data, XDB::field('threadtableid', $threadtableid), $unbuffered, $low_priority);
	}

	public function delete($fid, $threadtableid, $unbuffered = false) {
		return XDB::delete($this->_table, array('fid' => dintval($fid), 'threadtableid' => dintval($threadtableid)), null, $unbuffered);
	}

	public function delete_none_threads() {
		return XDB::delete($this->_table, "threads='0'");
	}
}
//www-FX8-co
?>