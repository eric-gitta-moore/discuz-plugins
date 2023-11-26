<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_forum_attachment_unused.php 27449 2012-02-01 05:32:35Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_sanree_brand_attachment extends discuz_table
{
	public function __construct() {

		$this->_table = 'sanree_brand_attachment';
		$this->_pk    = 'aid';

		parent::__construct();
	}
	public function count_by_where($where) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE 1 %i", array($this->_table, $where));
	}	
		
	public function fetch_by_aid($uid, $aid) {
		return XDB::result_first("SELECT attachment FROM %t WHERE uid=%d and aid=%d and isimage=1", array($this->_table, $uid, $aid));
	}
	public function fetch_firstbyaid($aid) {
		return XDB::fetch_first("SELECT * FROM %t WHERE aid=%d ", array($this->_table, $aid));
	}	
	
	public function clear() {
		require_once libfile('function/forum');
		$delaids = array();
		$query = XDB::query("SELECT aid, attachment, thumb FROM %t WHERE %i", array($this->_table, XDB::field('dateline', TIMESTAMP - 86400)));
		while($attach = XDB::fetch($query)) {
			dunlink($attach);
			$delaids[] = $attach['aid'];
		}
		if($delaids) {
			///XDB::query("DELETE FROM %t WHERE %i", array('forum_attachment', XDB::field('aid', $delaids)), false, true);
			XDB::query("DELETE FROM %t WHERE %i", array($this->_table, XDB::field('dateline', TIMESTAMP - 86400)), false, true);
		}
	}

}
//www-FX8-co
?>