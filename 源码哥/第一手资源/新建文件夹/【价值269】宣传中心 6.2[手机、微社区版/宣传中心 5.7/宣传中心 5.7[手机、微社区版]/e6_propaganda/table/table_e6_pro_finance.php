<?php
 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_e6_pro_finance extends discuz_table {
	public function __construct() {
		$this->_table = 'e6_pro_finance';
		$this->_pk    = 'id';
		parent::__construct();
	}
	public function count_by_search($conditions = '') {
		return DB::result_first("SELECT COUNT(*) FROM %t WHERE 1 %i ", array($this->_table, $conditions));
	}
	public function fetch_all_by_search($conditions = '', $start, $limit) {
		return DB::fetch_all("SELECT * FROM %t WHERE 1 %i ORDER BY `id` DESC" . DB::limit($start, $limit), array($this->_table, $conditions));
	}
	public function fetch_all_by_excel() {
		return DB::fetch_all("SELECT * FROM %t WHERE `ok`='0' ORDER BY `id` DESC", array($this->_table));
	}
	public function delete_by_uid($uids) {
		return DB::delete($this->_table, DB::field('uid', $uids));
	}
}
 
?>