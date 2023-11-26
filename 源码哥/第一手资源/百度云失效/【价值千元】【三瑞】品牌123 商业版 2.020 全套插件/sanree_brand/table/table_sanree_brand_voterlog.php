<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_brand_voterlog.php 2014-07-29 10:20:00 sanree checkedby fx8.cc $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}
 
class table_sanree_brand_voterlog  extends discuz_table {

	public function __construct() {

		$this->_table = 'sanree_brand_voterlog';
		$this->_pk    = 'bid';
		
		parent::__construct();
	}

	public function delete_by_bids($bids) {
		XDB::delete($this->_table, XDB::field('bid', $bids));
	}	
 
	public function getvoter_by_bid_uid($uid, $bid) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE bid=%d and uid=%d", array($this->_table, $bid, $uid));
	}
	public function getvoter_by_tid_uid($uid, $tid) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE tid=%d and uid=%d", array($this->_table, $tid, $uid));
	}
	
	public function getstar_by_tid_uid($uid, $tid) {
		return XDB::result_first("SELECT star FROM %t WHERE tid=%d and uid=%d", array($this->_table, $tid, $uid));
	}	
}
//From:www_YMG6_COM
?>