<?php
 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_e6_pro_user extends discuz_table {
	public function __construct() {
		$this->_table = 'e6_pro_user';
		$this->_pk    = 'uid';
		parent::__construct();
	}
	public function count_by_search($conditions = '') {
		return DB::result_first("SELECT COUNT(*) FROM %t WHERE 1 %i ", array($this->_table, $conditions));
	}
	public function fetch_all_by_search($conditions = '', $start, $limit) {
		return DB::fetch_all("SELECT * FROM %t WHERE 1 %i ORDER BY `id` DESC" . DB::limit($start, $limit), array($this->_table, $conditions));
	}
	public function fetch_all_by_son($conditions = '', $start, $limit) {
		return DB::fetch_all("SELECT p.*,m.username,m.regdate,m.groupid,d.oltime,d.posts FROM %t p ".
		" LEFT JOIN ".DB::table('common_member')." m ON p.uid=m.uid ".
		" LEFT JOIN ".DB::table('common_member_count')." d ON p.uid=d.uid ".
		" WHERE 1 %i ORDER BY p.id DESC" . DB::limit($start, $limit), array($this->_table, $conditions));
	}
	public function fetch_all_by_multi($conditions = '') {
		return DB::fetch_all("SELECT m.uid,m.username,c.register FROM %t p ".
		" LEFT JOIN ".DB::table('e6_pro_user_count')." c ON p.uid=c.uid ".
		" LEFT JOIN ".DB::table('common_member')." m ON p.uid=m.uid ".
		" WHERE 1 %i ORDER BY p.id DESC", array($this->_table, $conditions));
	}
	public function update_by_fuid($uids, $num, $data) {
		DB::update($this->_table, $data, DB::field('fuid'.$num, $uids), 'UNBUFFERED');
	}
	public function fetch_all_new_user() {
		return DB::fetch_all("SELECT m.username,u.username as fusername,p.uid,p.fuid1 FROM %t p ".
			" LEFT JOIN ".DB::table('common_member')." m ON p.uid=m.uid ".
			" LEFT JOIN ".DB::table('common_member')." u ON p.fuid1=u.uid ".
			" ORDER BY p.id DESC LIMIT 10 ", array($this->table));
	}
	public function fetch_all_by_member($uids) {
		return DB::fetch_all("SELECT m.groupid,m.username,c.uid,c.oltime,c.posts,c.extcredits1,c.extcredits2,c.extcredits3,c.extcredits4,c.extcredits5,c.extcredits6,c.extcredits7,c.extcredits8 ".
		" FROM %t m LEFT JOIN %t c ON m.uid=c.uid WHERE m.uid IN(%i)", array('common_member', 'common_member_count', $uids));
	}
	public function fetch_all_by_vip($conditions) {
		return DB::fetch_all("SELECT m.username,m.groupid,m.extgroupids,p.* FROM %t p ".
		" LEFT JOIN %t m ON p.uid=m.uid WHERE p.vip=0 AND (%i)", array($this->_table, 'common_member', $conditions));
	}
}
 
?>