<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_brand_language.php $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
 
class table_sanree_brand_language  extends discuz_table {

	public function __construct() {

		$this->_table = 'sanree_brand_language';
		$this->_pk    = 'langid';
		
		parent::__construct();
	}

	public function delete_by_module($module) {
		XDB::delete($this->_table, XDB::field('module', $module));
	}	
	
	public function fetch_all() {
		$retdata = array();
		foreach(XDB::fetch_all("SELECT langkey,langvalue FROM %t WHERE 1", array($this->_table)) as $key=> $value) {
				
		    $retdata[$value['langkey']] = $value['langvalue'];
		
		}
		return $retdata;
	}
	
	public function addfield($addsql) {
		runquery("ALTER TABLE ".XDB::table($this->_table)." ADD ".$addsql);	
	}

}
//From:www_YMG6_COM
?>