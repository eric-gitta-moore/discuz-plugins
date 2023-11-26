<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_mobile_setting.php 31281 2012-08-03 02:29:27Z zhangjie $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_topic extends discuz_table {

	public function __construct() {
		$this->_table = 'zhikai_topic';
		$this->_pk = 'topicid';

		parent::__construct();
	}//From www.moqu  8.com

	public function fetch_all($start,$perpage){
		$return = DB::fetch_all("SELECT * FROM %t  ORDER BY topicid DESC LIMIT %d,%d",array($this->_table,$start,$perpage));
		return dhtmlspecialchars($return);
	}

	public function fetch_by_entitle($entitle , $html = true){
		$return = DB::fetch_first("SELECT * FROM %t WHERE entitle = %s",array($this->_table,$entitle));
		return $html?dhtmlspecialchars($return):$return;
	}
	

}