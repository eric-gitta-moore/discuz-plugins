<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_sanree_brand_voter.php 2014-07-29 10:20:00 sanree checkedby fx8.cc $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}
 
class table_sanree_brand_voter  extends discuz_table {

	public function __construct() {

		$this->_table = 'sanree_brand_voter';
		$this->_pk    = 'bid';
		
		parent::__construct();
	}

	public function delete_by_bids($bids) {
		XDB::delete($this->_table, XDB::field('bid', $bids));
	}	
 
	public function getvote_by_tid($tid) {
		return XDB::fetch_first("SELECT * FROM %t where tid=%d", array($this->_table, $tid));	
	}
			
	public function getvote_by_bid($bid) {
		return XDB::fetch_first("SELECT * FROM %t where bid=%d", array($this->_table, $bid));	
	}
	
	public function update_by_bids($ids, $data) {
		return XDB::update($this->_table, $data, XDB::field('bid', $ids));
	}	
	
	public function getvoter_by_bid( $bid) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE bid=%d", array($this->_table, $bid));
	}
	
	public function getvoter_by_tid( $tid) {
		return XDB::result_first("SELECT COUNT(*) FROM %t WHERE tid=%d", array($this->_table, $tid));
	}	
		
	public function updatestar_by_tid($uid, $username, $tid, $star = 1) {
	    !in_array($star,array(1,2,3,4,5)) && $star = 1;
		$hcount = C::t('#sanree_brand#sanree_brand_voterlog')->getvoter_by_tid_uid($uid, $tid);
		if ($hcount>0){
			return 0;
		}
		$data = array(
			'uid' => $uid,
			'username' => $username,
			'tid' => $tid,
			'star' => $star,
			'dateline' => TIMESTAMP
		);
		C::t('#sanree_brand#sanree_brand_voterlog')->insert($data);
		$tcount = $this->getvoter_by_tid($tid);
		if ($tcount>0) {
			XDB::query("UPDATE ".XDB::table($this->_table)." SET `star".$star."`= star".$star." + 1 WHERE `tid`=".$tid);
		}
		else {
			$mdata = array(
				'uid' => $uid,
				'tid' => $tid,
				'star'.$star => 1,
				'dateline' => TIMESTAMP
			);
			$this->insert($mdata);
		}
		return 1;
	}
			
	public function updatestar_by_bid($uid, $username, $bid, $star = 1) {
	    !in_array($star,array(1,2,3,4,5)) && $star = 1;
		$hcount = C::t('#sanree_brand#sanree_brand_voterlog')->getvoter_by_bid_uid($uid, $bid);
		if ($hcount>0){
			return 0;
		}
		$data = array(
			'uid' => $uid,
			'username' => $username,
			'bid' => $bid,
			'star' => $star,
			'dateline' => TIMESTAMP
		);
		C::t('#sanree_brand#sanree_brand_voterlog')->insert($data);
		$tcount = $this->getvoter_by_bid($bid);
		if ($tcount>0) {
			XDB::query("UPDATE ".XDB::table($this->_table)." SET `star".$star."`= star".$star." + 1 WHERE `bid`=".$bid);
		}
		else {
			$mdata = array(
				'uid' => $uid,
				'bid' => $bid,
				'star'.$star => 1,
				'dateline' => TIMESTAMP
			);
			$this->insert($mdata);
		}
		return 1;
	}
	public function getvotetotal_by_tid($tid) {
		$votedata =  XDB::fetch_first("SELECT (star1 * 1 + star2 * 2 + star3 * 3 + star4 * 4 + star5 * 5) as total,(star1  + star2  + star3   + star4   + star5 ) as totalnum FROM %t where tid=%d", array($this->_table, $tid));	
		$total = array(0.0 , 0, 0 ,0);
		if ($votedata) {
		    $total = $votedata['total'] /  $votedata['totalnum'];
			$total =  sprintf("%1.1f", $total);
			$vt = ($total / 5) * 100;
			$vt =  sprintf("%1.0f", $vt);
			return array($total, $votedata['total'], $votedata['totalnum'],$vt);
		}
		return $total;
	}
	public function getvotetotal_by_bid($bid) {
		$votedata =  XDB::fetch_first("SELECT (star1 * 1 + star2 * 2 + star3 * 3 + star4 * 4 + star5 * 5) as total,(star1  + star2  + star3   + star4   + star5 ) as totalnum FROM %t where bid=%d", array($this->_table, $bid));	
		$total = array(0.0 , 0, 0 ,0);
		if ($votedata) {
		    $total = $votedata['total'] /  $votedata['totalnum'];
			$total =  sprintf("%1.1f", $total);
			$vt = ($total / 5) * 100;
			$vt =  sprintf("%1.0f", $vt);
			return array($total, $votedata['total'], $votedata['totalnum'],$vt);
		}
		return $total;
	}	
}
//From:www_YMG6_COM
?>