<?php
 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_e6_pro_task extends discuz_table {
	public function __construct() {
		$this->_table = 'e6_pro_task';
		$this->_pk    = 'id';
		parent::__construct();
	}
	public function count_by_search($conditions = '') {
		return DB::result_first("SELECT COUNT(*) FROM %t WHERE 1 %i ", array($this->_table, $conditions));
	}
	public function fetch_all_by_search($conditions = '', $start, $limit) {
		return DB::fetch_all("SELECT * FROM %t WHERE 1 %i ORDER BY `id` DESC" . DB::limit($start, $limit), array($this->_table, $conditions));
	}
	public function update_by_count($id, $sql) {
		DB::query("UPDATE %t SET %i WHERE `id`=%d", array($this->table, $sql, $id));
	}
}
 
?>