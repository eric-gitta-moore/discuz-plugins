<?php
/*
 * ������Դ���
 * ����: Www.fx8.cc
 * ������ַ: www.ymg6.com (���ղر���!)
 * ����֧��/����ά����QQ 154606914
 * 
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_webtctz_mobilelists extends discuz_table
{
	public function __construct() {
		$this->_table = 'webtctz_mobilelists';
		$this->_pk    = 'id';
		parent::__construct();
	}
	public function getone(){
		return DB::fetch_first('SELECT * FROM %t ORDER BY id DESC limit 0,1',array($this->_table));
		
	}
	
	public function getall(){
		return DB::fetch_all('SELECT * FROM %t ORDER BY id DESC',array($this->_table));
	
	}
}
//WWW.fx8.cc
?>