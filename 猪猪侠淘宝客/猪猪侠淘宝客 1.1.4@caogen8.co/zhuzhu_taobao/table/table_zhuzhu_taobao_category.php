<?php

/**
 *      [Caogen8!] (C)2014-2018 Www.Caogen8.co.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: zhuzhu_taobao_category.php 33234 2017-10-19 10:52:49Z Вн-Иљ-АЩ $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_zhuzhu_taobao_category extends discuz_table {

	public function __construct() {
		$this->_table = 'zhuzhu_taobao_category';
		$this->_pk    = 'category_id';

		parent::__construct();
	}

	public function count_by_search($param) {
		return DB::result_first('SELECT COUNT(*) FROM %t %i', array($this->_table, $this->wheresql($param)));
	}

	public function fetch_all_by_displayorder() {
		return DB::fetch_all("SELECT * FROM %t ORDER BY displayorder", array($this->_table), $this->_pk);
	}

	public function fetch_all() {
		return DB::fetch_all("SELECT * FROM %t ORDER BY displayorder", array($this->_table), $this->_pk);
	}
}
//From:www_caogen8_co
?>