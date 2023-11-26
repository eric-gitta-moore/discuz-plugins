<?php
 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_e6_pro_clientorder extends discuz_table {
	public function __construct() {
		$this->_table = 'e6_pro_clientorder';
		$this->_pk    = 'id';
		parent::__construct();
	}
	public function count_by_search($conditions = '') {
		return DB::result_first("SELECT COUNT(*) FROM %t c WHERE c.uid>0 %i ", array($this->_table, $conditions));
	}
	public function fetch_all_by_search($conditions = '', $start, $limit) {
		return DB::fetch_all("SELECT c.*,m.username FROM %t c LEFT JOIN %t m ON m.uid=c.uid WHERE c.uid>0 %i ORDER BY c.id DESC" . DB::limit($start, $limit), array($this->_table, 'common_member', $conditions));
	}
	public function fetch_by_date() {
		return DB::result_first("SELECT `date` FROM %t ORDER BY `date` DESC LIMIT 1", array($this->_table));
	}
	public function insert_by_orderid($date) {
		$data = DB::fetch_all("SELECT o.orderid,o.uid,o.price,o.submitdate as date FROM %t o LEFT JOIN %t p ON o.uid=p.uid WHERE o.submitdate>%d AND p.fuid1>0", array('forum_order', 'e6_pro_user', $date));
		foreach ($data as $v) {
			$this->insert($v);
		}
	}	
	public function insert_by_card($date) {
		$data = DB::fetch_all("SELECT o.id,o.uid,o.price,o.useddateline FROM %t o LEFT JOIN %t p ON o.uid=p.uid WHERE o.useddateline>%d AND o.status=2 AND p.fuid1>0", array('common_card', 'e6_pro_user', $date));
		foreach ($data as $v) {
			$this->insert(array(
				'uid'		=>	$v['uid'],
				'orderid'	=>	$v['id'],
				'date'		=>	$v['useddateline'],
				'type'		=>	1,
				'price'		=>	$v['price']
			));
		}
	}
	public function fetch_all_by_orderid() {
		return DB::fetch_all("SELECT p.* FROM %t p LEFT JOIN %t o ON p.orderid=o.orderid WHERE p.pay=0 AND (p.type=1 OR (p.type=0 AND o.status>1))", array($this->_table, 'forum_order'));
	}
	public function update_by_pay() {
		return DB::query("UPDATE %t p LEFT JOIN %t o ON p.orderid=o.orderid SET p.pay='1' WHERE p.pay='0' AND (p.type='1' OR (p.type='0' AND o.status>'1'))", array($this->_table, 'forum_order'));
	}
	public function delete_by_uid($uids) {
		return DB::delete($this->_table, DB::field('uid', $uids));
	}
}
 
?>