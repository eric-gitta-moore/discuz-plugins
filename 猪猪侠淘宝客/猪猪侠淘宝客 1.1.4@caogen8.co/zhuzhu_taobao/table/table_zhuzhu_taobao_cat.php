<?php

/**
 *      [Caogen8!] (C)2014-2018 Www.Caogen8.co.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_zhuzhu_taobao_cat.php 33234 2017-10-19 11:28:37Z Вн-Иљ-АЩ $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_zhuzhu_taobao_cat extends discuz_table {

	public function __construct() {
		$this->_table = 'zhuzhu_taobao_cat';
		$this->_pk    = 'cat_id';

		parent::__construct();
	}

	public function count_by_search($param) {
		return DB::result_first('SELECT COUNT(*) FROM %t %i', array($this->_table, $this->wheresql($param)));
	}

	public function fetch_all_by_displayorder($param, $start = 0, $limit = 0, $order = 'displayorder', $sort = 'ASC') {
		$ordersql =  $order ? ' ORDER BY '.DB::order($order, $sort) : '';
		return DB::fetch_all('SELECT * FROM %t %i %i '.DB::limit($start, $limit), array($this->_table, $this->wheresql($param), $ordersql));
	}

	public function fetch_all_by_search($param, $start = 0, $limit = 0, $order = '', $sort = '') {
		$ordersql =  $order ? ' ORDER BY '.DB::order($order, $sort) : '';
		return DB::fetch_all('SELECT * FROM %t %i %i '.DB::limit($start, $limit), array($this->_table, $this->wheresql($param), $ordersql));
	}

	public function wheresql($param) {
		foreach($param as $key => $value) {
			if($value) {
				$glue = strpos($value, '%') !== false ? 'like' : '=';
				$wherearr[] = DB::field($key, $value, $glue);
			}
		}
		$wheresql = $wherearr ? 'WHERE '.implode(' AND ', $wherearr) : '';
		return $wheresql;
	}
}
//From:www_caogen8_co
?>