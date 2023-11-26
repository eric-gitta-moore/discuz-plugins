<?php

/*
 * 作者: Discuz!亮剑工作室
 * 技术支持: http://www.dzx30.com
 * 客服QQ: 190360183
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_aljdm_type extends discuz_table{
	public function __construct() {

			$this->_table = 'aljdm_type';
			$this->_pk    = 'id';

			parent::__construct();
	}
	public function fetch_upid_by_id($id){
		return DB::result_first('SELECT upid FROM %t WHERE id=%d',array($this->_table,$id));
	}
	public function fetch_subid_by_id($id){
		return DB::result_first('SELECT subid FROM %t WHERE id=%d',array($this->_table,$id));
	}
	public function fetch_all_by_upid($upid){
		return DB::fetch_all('SELECT * FROM %t WHERE upid=%d ORDER BY displayorder ASC',array($this->_table,$upid),'id');
	}
	public function fetch_all_by_type($type){
		return DB::fetch_all('select * from %t where id=%d ORDER BY displayorder ASC',array($this->_table,$type));
	}

}




?>