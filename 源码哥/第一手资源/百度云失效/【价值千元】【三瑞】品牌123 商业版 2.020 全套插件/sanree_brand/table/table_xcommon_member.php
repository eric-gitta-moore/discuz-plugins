<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_xcommon_member.php $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
 
class table_xcommon_member  extends discuz_table {

	public function __construct() {

		$this->_table = 'common_member';			
		$this->_pk    = '';

		parent::__construct();
	}
	
	public function fetch_by_username($username) {
		$user = array();
		if($username) {
			$user = XDB::fetch_first('SELECT * FROM %t WHERE username=%s', array($this->_table, $username));
		}
		return $user;
	}	
	
	public function fetch_uid_by_username($username) {
		$user = array();
		if($username) {
			$user = XDB::result_first('SELECT uid FROM %t WHERE username=%s', array($this->_table, $username));
		}
		return $user;
	}	
	public function fetch_all_username_by_uid($uid) {
		$user = '';
		if($uid) {
			$user = XDB::result_first('SELECT username FROM %t WHERE uid=%s', array($this->_table, $uid));
		}
		return $user;
	}					
}
//www-FX8-co
?>