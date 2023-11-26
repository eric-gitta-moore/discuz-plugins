<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_brand_searchword.php 28041 2012-02-21 07:33:55Z chenmengshu $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_sanree_brand_searchword extends discuz_table
{
		
	public function __construct() {

		$this->_table = 'sanree_brand_searchword';
		$this->_pk    = 'id';

		parent::__construct();
	}
	
	public function getkewword_by_id($id) {
		return XDB::result_first("SELECT keyword FROM %t WHERE id=%d", array($this->_table, $id));
	}
	
	public function getid_by_keyword($keyword) {
		return XDB::result_first("SELECT id FROM %t WHERE keyword=%s", array($this->_table, $keyword));
	}	

}
//www-FX8-co
?>