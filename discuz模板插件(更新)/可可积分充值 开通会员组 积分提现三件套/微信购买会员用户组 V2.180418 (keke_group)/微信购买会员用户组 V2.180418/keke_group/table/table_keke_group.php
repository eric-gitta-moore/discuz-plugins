<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_keke_group extends discuz_table
{
	public function __construct() {
		$this->_table = 'keke_group';
		$this->_pk = 'id';
		parent::__construct();
	}
	
	public function fetchall_group() {
		$data=DB::fetch_all("SELECT * FROM %t order by display ASC", array($this->_table));
		return $data;
	}
	
	public function fetchfirst_bybuygorupid($buygorupid) {
		return DB::fetch_first("SELECT * FROM %t WHERE id=%d", array($this->_table,$buygorupid));
	}
	
}

?>