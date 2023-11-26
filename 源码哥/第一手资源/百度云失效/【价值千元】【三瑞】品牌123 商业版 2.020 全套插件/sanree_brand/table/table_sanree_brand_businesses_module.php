<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_brand_businesses_module.php $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
 
class table_sanree_brand_businesses_module  extends discuz_table {

    var $_jointable;

	public function __construct() {

		$this->_table = 'sanree_brand_businesses_module';
		$this->_jointable = 'sanree_brand_businesses';	
		$this->_pk    = 'mid';
		
		parent::__construct();
	}

	public function delete_by_bids($bids) {
		XDB::delete($this->_table, XDB::field('bid', $bids));
	}	
	
	public function count_by_where($where) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE 1 %i", array($this->_table, $where));
	}
	
	public function fetch_by_bid($bid) {
		return XDB::fetch_first("SELECT * FROM %t WHERE bid='%i'", array($this->_table, $bid));
	}
	
	public function fetch_by_modename($modename,$bid) {
		return XDB::result_first("SELECT %i FROM %t WHERE bid='%i'", array($modename, $this->_table, $bid));
	}
	public function fetch_all_column() {
		$query=DB::query('SHOW COLUMNS FROM '.DB::table($this->_table));
		$columns=array();
		while ($row = mysql_fetch_array($query,MYSQL_ASSOC)) {
			$columns[]=$row;
		}
		$arraycolumns=array();
		foreach($columns as $v) {
		
		    if ($v['Field']!='mid' && $v['Field']!='bid') {
			
			    preg_match("/([a-z]+)/", $v['Type'], $kv);
				$type = $kv[0] == 'tinyint' ? 'radio' : ($kv[0] == 'text' ? 'textarea' : 'text');	
				$arraycolumns[]= array('type'=> $type, 'data'=>$v['Field']);
			
			}
		}
		return $arraycolumns;
	}
		
	public function update_by_bid($bid, $data) {
		return XDB::update($this->_table, $data, XDB::field('bid', $bid));
	}	
	
	public function addfield($addsql) {
		runquery("ALTER TABLE ".XDB::table($this->_table)." ADD ".$addsql);	
	}
	
	public function replaceupdate($bid, $data) {
	    if ($this->fetch_by_bid($bid)) {
			$this->update_by_bid($bid, $data);
		} else {
		    $data['bid'] = $bid;
			$this->insert($data);
		}
	}
	public function update_all($data) {
		if (is_array($data)) {
			$update=array();
			foreach($data as $key => $val) {
				$update[]="`".$key."` = '".$val."'";
			}
			$setwhere = implode($update, ', ');
			XDB::query("UPDATE ".XDB::table($this->_table)." SET ".$setwhere);
		}
	}		
}
//From:www_YMG6_COM
?>