<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_brand_group_module.php $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
 
class table_sanree_brand_group_module  extends discuz_table {

    var $_jointable;

	public function __construct() {

		$this->_table = 'sanree_brand_group_module';
		$this->_jointable = 'sanree_brand_group';	
		$this->_pk    = 'mid';
		
		parent::__construct();
	}

	public function delete_by_groupids($groupids) {
		XDB::delete($this->_table, XDB::field('groupid', $groupids));
	}	
	
	public function count_by_where($where) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE 1 %i", array($this->_table, $where));
	}
	
	public function fetch_by_groupid($groupid) {
		return XDB::fetch_first("SELECT * FROM %t WHERE groupid='%i'", array($this->_table, $groupid));
	}
	
	public function fetch_by_modename($modename,$groupid) {
		return XDB::result_first("SELECT %i FROM %t WHERE groupid='%i'", array($modename, $this->_table, $groupid));
	}
	public function fetch_all_column() {
		$query=DB::query('SHOW COLUMNS FROM '.DB::table($this->_table));
		$columns=array();
		while ($row = mysql_fetch_array($query,MYSQL_ASSOC)) {
			$columns[]=$row;
		}
		$arraycolumns=array();
		foreach($columns as $v) {
		
		    if ($v['Field']!='mid' && $v['Field']!='groupid') {
			
			    preg_match("/([a-z]+)/", $v['Type'], $kv);
				$type = $kv[0] == 'tinyint' ? 'radio' : ($kv[0] == 'text' ? 'textarea' : 'text');	
				$arraycolumns[]= array('type'=> $type, 'data'=>$v['Field']);
				
			}
		}
		return $arraycolumns;
	}
		
	public function update_by_groupid($groupid, $data) {
		return XDB::update($this->_table, $data, XDB::field('groupid', $groupid));
	}	
	
	public function addfield($addsql) {
		runquery("ALTER TABLE ".XDB::table($this->_table)." ADD ".$addsql);	
	}

}
//From:www_YMG6_COM
?>