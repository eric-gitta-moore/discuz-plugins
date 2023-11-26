<?php
 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_e6_pro_user_count extends discuz_table {
	public function __construct() {
		$this->_table = 'e6_pro_user_count';
		$this->_pk    = 'uid';
		parent::__construct();
	}
	public function fetch_all_top_money() {
		return DB::fetch_all("SELECT m.username,p.uid,p.money FROM %t p ".
			" LEFT JOIN ".DB::table('common_member')." m ON p.uid=m.uid ".
			" ORDER BY p.money DESC LIMIT 10 ", array($this->table));
	}
	public function fetch_all_top_register() {
		return DB::fetch_all("SELECT m.username,p.uid,p.register FROM %t p ".
			" LEFT JOIN ".DB::table('common_member')." m ON p.uid=m.uid ".
			" ORDER BY p.register DESC LIMIT 10 ", array($this->table));
	}
	public function update_by_count($uid, $sql) {
		DB::query("UPDATE %t SET %i WHERE `uid`=%d", array($this->table, $sql, $uid));
	}
}
 
?>