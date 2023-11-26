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

class table_forum_attachment_unused extends discuz_table
{
	public function __construct() {

		$this->_table = 'forum_attachment_unused';
		$this->_pk    = 'aid';

		parent::__construct();
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
			XDB::query("DELETE FROM %t WHERE %i", array('forum_attachment', XDB::field('aid', $delaids)), false, true);
			XDB::query("DELETE FROM %t WHERE %i", array($this->_table, XDB::field('dateline', TIMESTAMP - 86400)), false, true);
		}
	}

}
//www-FX8-co
?>