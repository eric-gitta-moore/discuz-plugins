<?php
 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_e6_pro_credit extends discuz_table {
	public function __construct() {
		$this->_table = 'e6_pro_credit';
		$this->_pk    = 'id';
		parent::__construct();
	}
	public function count_by_search($conditions = '', $get_username = FALSE) {
		return DB::result_first("SELECT COUNT(*) FROM %t ".($get_username ? 'c' : '')." WHERE 1 %i ", array($this->_table, $conditions));
	}
	public function fetch_all_by_search($conditions = '', $start, $limit, $get_username = FALSE) {
		if (!$get_username) {
			return DB::fetch_all("SELECT * FROM %t WHERE 1 %i ORDER BY `id` DESC ".DB::limit($start, $limit), array($this->_table, $conditions));
		} else {
			return DB::fetch_all("SELECT m.username,c.* FROM %t c ".
			" LEFT JOIN ".DB::table('common_member')." m ON c.uid=m.uid WHERE 1 %i ".
			" ORDER BY c.id DESC ".DB::limit($start, $limit), array($this->_table, $conditions));
		}
	}
	public function delete_by_log($date) {
		return DB::delete($this->_table, "`date`<{$date}");
	}
	public function delete_by_uid($uids) {
		return DB::delete($this->_table, DB::field('uid', $uids));
	}
	public function fetch_all_by_allmoney($uid, $logtype, $date) {
		return DB::fetch_all("SELECT sum(`change`) as allmoney,`type` FROM %t WHERE `uid`=%d AND `logtype`=%d AND `date`>%i GROUP BY `type`",
		array($this->table, $uid, $logtype, $date));
	}
}
 
?>