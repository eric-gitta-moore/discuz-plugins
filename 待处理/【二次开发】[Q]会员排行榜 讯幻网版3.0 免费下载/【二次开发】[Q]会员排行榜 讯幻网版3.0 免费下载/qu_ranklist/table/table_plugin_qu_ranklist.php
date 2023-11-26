<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_common_member.php 31849 2012-10-17 04:39:16Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_plugin_qu_ranklist extends discuz_table
{
	public function __construct() {

		$this->_table = '';
		$this->_pk    = '';

		parent::__construct();
	}

	public function fetch_user_by_uid($type, $uids = array(), $start = 0, $limit = 5000) {
		$tidsql = '';
		if($uids) {
			$uids = dintval($uids, true);
			$tidsql = ' WHERE a.'.DB::field('uid', $uids);
		} else {
			if($type == 'posts') {
				$orderby = 'b.posts';
			} elseif($type == 'threads') {
				$orderby = 'b.threads';
			} elseif($type == 'friends') {
				$orderby = 'b.friends';
			}  elseif($type == 'extcredits1') {
				$orderby = 'b.extcredits1';
			}  elseif($type == 'extcredits2') {
				$orderby = 'b.extcredits2';
			}  elseif($type == 'extcredits3') {
				$orderby = 'b.extcredits3';
			}  elseif($type == 'extcredits4') {
				$orderby = 'b.extcredits4';
			}  elseif($type == 'extcredits5') {
				$orderby = 'b.extcredits5';
			}  elseif($type == 'extcredits6') {
				$orderby = 'b.extcredits6';
			}  elseif($type == 'extcredits7') {
				$orderby = 'b.extcredits7';
			}  elseif($type == 'extcredits8') {
				$orderby = 'b.extcredits8';
			}  elseif($type == 'digestposts') {
				$orderby = 'b.digestposts';
			}  elseif($type == 'doings') {
				$orderby = 'b.doings';
			}  elseif($type == 'blogs') {
				$orderby = 'b.blogs';
			}  elseif($type == 'views') {
				$orderby = 'b.views';
			}  elseif($type == 'feeds') {
				$orderby = 'b.feeds';
			}  elseif($type == 'follower') {
				$orderby = 'b.follower';
			}  elseif($type == 'following') {
				$orderby = 'b.following';
			}  elseif($type == 'blacklist') {
				$orderby = 'b.blacklist';
			}  elseif($type == 'albums') {
				$orderby = 'b.albums';
			}  elseif($type == 'sharings') {
				$orderby = 'b.sharings';
			}  elseif($type == 'oltime') {
				$orderby = 'b.oltime';
			} else {
				$orderby = 'a.credits';
			}
			$addsql .= ' ORDER BY '.$orderby.' DESC '.DB::limit($start, $limit);

		}
		return DB::fetch_all("SELECT * FROM %t as a LEFT JOIN %t as b ON a.uid = b.uid" .$tidsql.$addsql, array('common_member', 'common_member_count', $uids));
	}
	public function gets_user_by_uid($type, $start = 0, $limit = 100) {
		
			$tidsql = ' WHERE a.uid!=1';

			$addsql .= ' ORDER BY a.'.$type.' DESC '.DB::limit($start, $limit);

		return DB::fetch_all("SELECT * FROM %t as a LEFT JOIN %t as b ON a.uid = b.uid" .$tidsql.$addsql, array('common_member', 'common_member_count', $uids));
	}
	public function fetch_by_conlist($conlist,$uid) {
		switch ($conlist) {
			case 'credits' :
				return DB::result_first("SELECT $conlist FROM ".DB::table('common_member')." where uid=$uid");
				break;
			default :
				return DB::result_first("SELECT $conlist FROM ".DB::table('common_member_count')." where uid=$uid");
		}
		
	}

	public function get_user_pos($conlist) {
		switch ($conlist) {
			case 'credits' :
				return DB::fetch_all("SELECT * FROM %t order by $conlist DESC",array('common_member',$conlist));
				break;
			default :
				return DB::fetch_all("SELECT * FROM %t order by $conlist DESC",array('common_member_count',$conlist));
		}
	}
}

?>