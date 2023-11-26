<?php
 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_e6_pro_visit extends discuz_table {
	public function __construct() {
		$this->_table = 'e6_pro_visit';
		$this->_pk    = 'uid';
		parent::__construct();
	}
	public function delete_by_ip($conditions) {
		DB::query("DELETE FROM %t WHERE %i", array($this->_table, $conditions));
	}
	public function fetch_uid_by_ip($ip) {
		return DB::result_first("SELECT `uid` FROM %t WHERE `ip`='%i'", array($this->_table, $ip));
	}
	public function fetch($uid) {
		return DB::fetch_first("SELECT * FROM %t WHERE `uid`=%d ORDER BY `id` DESC", array($this->_table, $uid));
	}
} 
?>