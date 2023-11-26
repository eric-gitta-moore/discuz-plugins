<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_forum_attachment.php 29217 2012-03-29 08:30:37Z chenmengshu $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_forum_attachment extends discuz_table
{
	private $_tableids = array();

	public function __construct() {

		$this->_table = 'forum_attachment';
		$this->_pk    = 'aid';

		parent::__construct();
	}
	public function fetch_firstbyaid($aid) {
		return XDB::fetch_first("SELECT * FROM %t WHERE aid=%d ", array($this->_table, $aid));
	}	
	
	public function update_download($aid, $count = 1) {
		return XDB::query("UPDATE %t SET downloads=downloads+%d WHERE aid IN (%n)", array($this->_table, $count, (array)$aid), false, true);
	}

	public function fetch_all_by_id($idtype, $ids, $orderby = '') {
		$attachments = array();
		if($orderby) {
			$orderby = 'ORDER BY '.XDB::order($orderby, 'DESC');
		}
		if(in_array($idtype, array('aid', 'tid', 'pid', 'uid')) && $ids) {
			$query = XDB::query("SELECT * FROM %t WHERE %i IN (%n) %i", array($this->_table, $idtype, (array)$ids, $orderby));
			while($value = XDB::fetch($query)) {
				$attachments[$value['aid']] = $value;
				$this->_tableids[$value['tableid']][] = $value['aid'];
			}
		}
		return $attachments;
	}

	public function delete_by_id($idtype, $ids) {
		if(in_array($idtype, array('aid', 'tid', 'pid', 'uid')) && $ids) {
			XDB::query('DELETE FROM %t WHERE %i IN (%n)', array($this->_table, $idtype, (array)$ids), false, true);
		}
	}

	public function update_by_id($idtype, $ids, $newtid) {
		if(in_array($idtype, array('tid', 'pid')) && $ids) {
			XDB::query("UPDATE %t SET tid=%d,tableid=%d WHERE %i IN (%n)", array($this->_table, $newtid, getattachtableid($newtid), $idtype, (array)$ids), false, true);
		}
	}

	public function count_by_tid($tid) {
		return $tid ? XDB::result_first("SELECT COUNT(*) FROM %t WHERE tid=%d", array($this->_table, $tid)) : 0;
	}

	public function fetch_by_aid_uid($aid, $uid) {
		$query = XDB::query("SELECT * FROM %t WHERE aid=%d AND uid=%d", array($this->_table, $aid, $uid));
		return XDB::fetch($query);
	}

	public function fetch_all_unused_attachment($uid, $aids = null, $posttime = null) {
		$parameter = array($this->_table);
		$wherearr = array();
		if($aids !== null) {
			$parameter[] = $aids;
			$wherearr[] = is_array($aids) ? 'a.aid IN(%n)' : 'a.aid=%d';
		}
		$parameter[] = $uid;
		$wherearr[] = 'af.uid=%d';
		$wherearr[] = 'a.tid=0';

		if($posttime !== null) {
			$parameter[] = $posttime;
			$wherearr[] = "af.dateline>%d";
		}
		$wheresql = !empty($wherearr) && is_array($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';
		return XDB::fetch_all("SELECT a.*, af.* FROM %t a INNER JOIN ".XDB::table('forum_attachment_unused')." af USING(aid) $wheresql ORDER BY a.aid DESC", $parameter);
	}

	public function get_tableids() {
		return $this->_tableids;
	}

	public function fetch_all_for_manage($tableid, $inforum = '', $authorid = 0, $filename = '', $keyword = '', $sizeless = 0, $sizemore = 0, $dlcountless = 0, $dlcountmore = 0, $daysold = 0, $count = 0, $start = 0, $limit = 0) {
		$sql = "1";
		if(!is_numeric($tableid) || $tableid < 0 || $tableid > 9) {
			return;
		}
		if($inforum) {
			$sql .= is_numeric($inforum) ? " AND t.fid=".XDB::quote($inforum) : '';
			$sql .= $inforum == 'isgroup' ? ' AND t.isgroup=\'1\'' : ' AND t.isgroup=\'0\'';
		}
		if($authorid) {
			$sql .= " AND a.uid=".XDB::quote($authorid);
		}
		if($filename) {
			$sql .= " AND a.filename LIKE ".XDB::quote('%'.$filename.'%');
		}
		if($keyword) {
			$sqlkeywords = $or = '';
			foreach(explode(',', str_replace(' ', '', $keyword)) as $keyword) {
				$sqlkeywords .= " $or a.description LIKE ".XDB::quote('%'.$keyword.'%');
				$or = 'OR';
			}
			$sql .= " AND ($sqlkeywords)";
		}
		$sql .= $sizeless ? " AND a.filesize>'$sizeless'" : '';
		$sql .= $sizemore ? " AND a.filesize<'$sizemore' " : '';
		$sql .= $dlcountless ? " AND ai.downloads<'$dlcountless'" : '';
		$sql .= $dlcountmore ? " AND ai.downloads>'$dlcountmore'" : '';
		$sql .= $daysold ? " AND a.dateline<'".(TIMESTAMP - intval($daysold) * 86400)."'" : '';
		if($count) {
			return XDB::result_first("SELECT COUNT(*)
				FROM ". XDB::table('forum_attachment_'.$tableid)." a
				INNER JOIN ".XDB::table('forum_attachment')." ai USING(aid)
				INNER JOIN ".XDB::table('forum_thread')." t
				INNER JOIN ".XDB::table('forum_forum')." f
				WHERE t.tid=a.tid AND f.fid=t.fid AND t.displayorder>='0' AND $sql");
		}
		return XDB::fetch_all("SELECT a.*, ai.downloads, t.fid, t.tid, t.subject, f.name AS fname
				FROM ". XDB::table('forum_attachment_'.$tableid)." a
				INNER JOIN ".XDB::table('forum_attachment')." ai USING(aid)
				INNER JOIN ".XDB::table('forum_thread')." t
				INNER JOIN ".XDB::table('forum_forum')." f
				WHERE t.tid=a.tid AND f.fid=t.fid AND t.displayorder>='0' AND $sql ORDER BY a.aid DESC ".XDB::limit($start, $limit));
	}

}
//www-FX8-co
?>