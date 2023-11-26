<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_forum_threadimage.php 28051 2012-02-21 10:36:56Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_forum_threadimage extends discuz_table
{
	public function __construct() {

		$this->_table = 'forum_threadimage';
		$this->_pk    = '';

		parent::__construct();
	}

	public function delete($tid) {
		return ($tid = dintval($tid)) ? XDB::delete('forum_threadimage', "tid='$tid'") : false;
	}
	public function delete_by_tid($tids) {
		return !empty($tids) ? XDB::delete($this->_table, XDB::field('tid', $tids)) : false;
	}

}
//www-FX8-co
?>