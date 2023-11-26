<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_keke_tixian_card extends discuz_table
{
	public function __construct() {
		$this->_table = 'keke_tixian_card';
		$this->_pk = 'id';
		parent::__construct();
	}
	
	public function fetch_by_uid($uid) {
		return DB::fetch_all("SELECT * FROM %t WHERE uid=%d order by id DESC", array($this->_table,$uid));
	}
	
	public function fetchfirst_by_id($cardid) {
		return DB::fetch_first("SELECT * FROM %t WHERE id=%d", array($this->_table,$cardid));
	}
	
	
}

?>