<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_brand_hint.php zs
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_sanree_brand_hint  extends discuz_table {

	public function __construct() {

		$this->_table = 'sanree_brand_hint';
		$this->_pk    = '';

		parent::__construct();
	}

	public function fetch_by_uid($uid) {
		$user = array();
		if($uid) {
			$user = XDB::fetch_first('SELECT * FROM %t WHERE uid=%s', array($this->_table, $uid));
		}
		return $user;
	}

	public function fetch_all_by_uid($uid) {
		$user = '';
		if($uid) {
			$user = XDB::result_first('SELECT uid FROM %t WHERE uid=%s', array($this->_table, $uid));
		}
		return $user;
	}

	public function update_by_uid($uid, $data) {

		return XDB::update($this->_table, $data, XDB::field('uid', $uid));

	}


}
//www-FX8-co
?>