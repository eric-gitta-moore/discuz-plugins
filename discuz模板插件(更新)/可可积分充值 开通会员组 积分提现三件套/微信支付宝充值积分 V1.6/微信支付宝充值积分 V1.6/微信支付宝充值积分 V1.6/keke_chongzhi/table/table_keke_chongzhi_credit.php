<?php
/*

 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_keke_chongzhi_credit extends discuz_table
{
	public function __construct() {
		$this->_table = 'keke_chongzhi_credit';
		$this->_pk = 'creditid';
		parent::__construct();
	}
	
	public function fetchall_credit() {
		$data=DB::fetch_all("SELECT * FROM %t", array($this->_table));
		foreach($data as $val){
			$ret[$val['creditid']]=$val;
		}
		return $ret;
	}
	
	
}

?>