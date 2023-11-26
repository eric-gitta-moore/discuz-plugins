<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_keke_xzhseo extends discuz_table
{
	public function __construct() {
		$this->_table = 'keke_xzhseo';
		$this->_pk = 'id';
		parent::__construct();
	}
	
	
	public function count_all() {
		return DB::result_first("SELECT count(1) FROM %t", array($this->_table));
	}
	
	public function fetch_all_by_limit($startlimit,$ppp) {
		return DB::fetch_all("SELECT * FROM %t order by id desc LIMIT %d,%d", array($this->_table,$startlimit,$ppp));
	}//д╖ х╓ ╟и лА ╧╘об ть
	
	
	public function fetchfirst_byatid($ids,$mods) {
		return DB::fetch_first("SELECT * FROM %t WHERE atid=%d AND mods=%d", array($this->_table,$ids,$mods));
	}

	
}

?>