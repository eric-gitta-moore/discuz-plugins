<?php
 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_e6_pro_task_list extends discuz_table {
	public function __construct() {
		$this->_table = 'e6_pro_task_list';
		$this->_pk    = 'taskid';
		parent::__construct();
	}
	public function fetch_all_by_user($uid) {
		$query = DB::query("SELECT * FROM %t WHERE `uid`=%d", array($this->_table, $uid));
		while($value = DB::fetch($query)) {
			$data[$value['taskid']] = $value;
			$this->store_cache($value[$this->_pk], $value);
		}
		return $data;
	}
	public function fetch_by_search($conditions = '') {
		return DB::fetch_first("SELECT * FROM %t WHERE 1 %i", array($this->_table, $conditions));
	}
	public function delete_by_user($taskid, $uid) {
		DB::query("DELETE FROM %t WHERE `taskid` = %d AND `uid`=%d", array($this->table, $taskid, $uid));
	}
	public function update_by_ok($taskid, $uid) {
		DB::query("UPDATE %t SET `ok`='1' WHERE `taskid`=%d AND `uid`=%d", array($this->table, $taskid, $uid));
	}
}
 
?>