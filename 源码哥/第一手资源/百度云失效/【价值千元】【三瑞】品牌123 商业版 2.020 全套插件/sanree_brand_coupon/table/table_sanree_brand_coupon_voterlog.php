<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_brand_coupon_voterlog.php $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
 
class table_sanree_brand_coupon_voterlog  extends discuz_table {

	public function __construct() {

		$this->_table = 'sanree_brand_coupon_voterlog';
		$this->_pk    = 'gid';
		
		parent::__construct();
	}

	public function delete_by_gids($gids) {
		XDB::delete($this->_table, XDB::field('gid', $gids));
	}	
 
	public function getvoter_by_bid_uid($uid, $gid) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE bid=%d and uid=%d", array($this->_table, $gid, $uid));
	}
	public function getvoter_by_tid_uid($uid, $tid) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE tid=%d and uid=%d", array($this->_table, $tid, $uid));
	}	
}
//From:www_YMG6_COM
?>