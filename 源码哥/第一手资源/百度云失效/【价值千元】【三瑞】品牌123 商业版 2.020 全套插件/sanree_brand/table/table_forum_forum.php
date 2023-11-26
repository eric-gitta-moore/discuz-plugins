<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_forum_forum.php 29580 2012-04-20 02:53:59Z svn_project_zhangjie $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_forum_forum extends discuz_table
{
	public function __construct() {

		$this->_table = 'forum_forum';
		$this->_pk    = 'fid';

		parent::__construct();
	}

	public function fetch_all_by_status($status, $orderby = 1) {
		$status = $status ? 1 : 0;
		$ordersql = $orderby ? 'ORDER BY t.type, t.displayorder' : '';
		return XDB::fetch_all('SELECT * FROM '.XDB::table($this->_table)." t WHERE t.status='$status' $ordersql");
	}
	public function fetch_all_fids($allstatus = 0, $type = '', $fup = '', $start = 0, $limit = 0, $count = 0) {
		$typesql = empty($type) ? "type<>'group'" : XDB::field('type', $type);
		$statussql = empty($allstatus) ? ' AND status<>3' : '';
		$fupsql = empty($fup) ? '' : ' AND '.XDB::field('fup', $fup);
		$limitsql = empty($limit) ? '' : ' LIMIT '.$start.', '.$limit;
		if($count) {
			return XDB::result_first("SELECT count(*) FROM ".XDB::table($this->_table)." WHERE $typesql $statussql $fupsql");
		}
		return XDB::fetch_all("SELECT * FROM ".XDB::table($this->_table)." WHERE $typesql $statussql $fupsql $limitsql");
	}
	public function fetch_info_by_fid($fid) {
		return XDB::fetch_first("SELECT ff.*, f.* FROM %t f LEFT JOIN %t ff ON ff.fid=f.fid WHERE f.fid=%d", array($this->_table, 'forum_forumfield', $fid));
	}
	public function fetch_all_name_by_fid($fids) {
		if(empty($fids)) {
			return array();
		}
		return XDB::fetch_all('SELECT fid, name FROM '.XDB::table($this->_table)." WHERE ".XDB::field('fid', $fids), array(), 'fid');
	}
	public function fetch_all_info_by_fids($fids, $status = 0, $limit = 0, $fup = 0, $displayorder = 0, $onlyforum = 0, $noredirect = 0, $type = '', $start = 0) {
		$sql = $fids ? "f.".XDB::field('fid', $fids) : '';
		$sql .= empty($fup) ? '' : ($sql ? ' AND ' : '').'f.'.XDB::field('fup', $fup);
		if(!strcmp($status, 'available')) {
			$sql .= ($sql ? ' AND ' : '')." f.status>'0'";
		} elseif($status) {
			$sql .= $status ? ($sql ? ' AND ' : '')." f.".XDB::field('status', $status) : '';
		}
		$sql .= $onlyforum ? ($sql ? ' AND ' : '').'f.type<>\'group\'' : '';
		$sql .= $type ? ($sql ? ' AND ' : '').'f.'.XDB::field('type', $type) : '';
		$sql .= $noredirect ? ($sql ? ' AND ' : '').'ff.redirect=\'\'' : '';
		$ordersql = $displayorder ? ' ORDER BY f.displayorder' : '';
		$limitsql = $limit ? XDB::limit($start, $limit) : '';
		if(!$sql) {
			return array();
		}
		return XDB::fetch_all("SELECT ff.*, f.* FROM %t f LEFT JOIN %t ff USING (fid) WHERE $sql $ordersql $limitsql", array($this->_table, 'forum_forumfield'), 'fid');
	}
	public function fetch_all_default_recommend($num = 10) {
		return XDB::fetch_all("SELECT f.fid, f.name, ff.description, ff.icon FROM ".XDB::table($this->_table)." f LEFT JOIN ".XDB::table('forum_forumfield')." ff USING(fid) WHERE f.status='3' AND f.type='sub' ORDER BY f.commoncredits desc ".XDB::limit($num));
	}
	public function fetch_all_group_type($alltypeorder = 0) {
		$ordersql = empty($alltypeorder) ? 'f.type, ' : "f.type<>'group', ";
		return XDB::fetch_all("SELECT f.fid, f.type, f.status, f.name, f.fup, f.displayorder, f.forumcolumns, f.inheritedmod, ff.moderators, ff.password, ff.redirect, ff.groupnum FROM ".XDB::table($this->_table)." f LEFT JOIN ".XDB::table('forum_forumfield')." ff USING(fid) WHERE f.status='3' AND f.type IN('group', 'forum') ORDER BY $ordersql f.displayorder");
	}
	public function fetch_all_recommend_by_fid($fid) {
		return XDB::fetch_all("SELECT ff.*, f.* FROM %t f LEFT JOIN %t ff ON ff.fid=f.fid WHERE f.recommend=%d", array($this->_table, 'forum_forumfield', $fid));
	}
	public function fetch_all_info_by_ignore_fid($fid) {
		if(!intval($fid)) {
			return array();
		}
		return XDB::fetch_all("SELECT fid, type, name, fup FROM ".XDB::table($this->_table)." WHERE ".XDB::field('fid', $fid, '<>')." AND type<>'sub' AND status<>'3' ORDER BY displayorder");
	}
	public function fetch_all_forum($status = 0) {
		$statusql = intval($status) ? 'f.'.XDB::field('status', $status) : 'f.status<>\'3\'';
		return XDB::fetch_all("SELECT ff.*, f.*, a.uid FROM ".XDB::table($this->_table)." f LEFT JOIN ".XDB::table('forum_forumfield')." ff ON ff.fid=f.fid LEFT JOIN ".XDB::table('forum_access')." a ON a.fid=f.fid AND a.allowview>'0' WHERE $statusql ORDER BY f.type, f.displayorder");
	}
	public function fetch_all_subforum_by_fup($fups) {
		return XDB::fetch_all("SELECT fid, fup, name, threads, posts, todayposts, domain FROM %t WHERE status='1' AND fup IN (%n) AND type='sub' ORDER BY displayorder", array($this->_table, $fups));
	}
	public function fetch_all_forum_ignore_access() {
		return XDB::fetch_all("SELECT ff.*, f.* FROM ".XDB::table($this->_table)." f LEFT JOIN ".XDB::table('forum_forumfield')." ff ON ff.fid=f.fid WHERE status <3 ORDER BY f.fid");
	}
	public function fetch_all_forum_for_sub_order() {
		return XDB::fetch_all("SELECT ff.*, f.fid, f.type, f.status, f.name, f.fup, f.displayorder, f.inheritedmod FROM ".XDB::table($this->_table)." f LEFT JOIN ".XDB::table('forum_forumfield')." ff USING(fid) WHERE f.status<>'3' ORDER BY f.type<>'group', f.displayorder");
	}
	public function fetch_all_valid_forum() {
		return XDB::fetch_all("SELECT * FROM ".XDB::table($this->_table)." WHERE status='1' AND type IN ('forum', 'sub') ORDER BY type");
	}
	public function fetch_all_valid_fieldinfo() {
		return XDB::fetch_all("SELECT ff.* FROM ".XDB::table($this->_table)." f INNER JOIN ".XDB::table('forum_forumfield')." ff USING(fid) WHERE f.status='1'");
	}
	public function fetch_threadcacheon_num() {
		return XDB::result_first("SELECT COUNT(*) FROM ".XDB::table($this->_table)." WHERE status='1' AND threadcaches>0");
	}
	public function update_threadcaches($threadcache, $fids) {
		if(empty($fids)) {
			return false;
		}
		$sqladd = in_array('all', $fids) ? '' :  ' WHERE '.XDB::field('fid', $fids);
		XDB::query("UPDATE ".XDB::table($this->_table)." SET threadcaches='".intval($threadcache)."'$sqladd");
	}
	public function update_styleid($ids) {
		XDB::query("UPDATE ".XDB::table($this->_table)." SET styleid='0' WHERE styleid IN(%n)",array($ids));
	}
	public function fetch_forum_num($type = '', $fup = '') {
		$fupsql = $fup ? XDB::field('fup', $fup).' AND ' : '';
		$addwhere = $type == 'group' ? "`status`='3'" : "`status`<>3";
		return XDB::result_first("SELECT COUNT(*) FROM ".XDB::table($this->_table)." WHERE $fupsql $addwhere");
	}
	public function check_forum_exists($fids, $issub = 1) {
		if(empty($fids)) {
			return false;
		}
		$typesql = $issub ? " AND type<>'group'" : '';
		return XDB::result_first("SELECT COUNT(*) FROM ".XDB::table($this->_table)." WHERE %i".$typesql, array(XDB::field('fid', $fids)));
	}
	public function fetch_sum_todaypost() {
		return XDB::result_first("SELECT sum(todayposts) FROM ".XDB::table($this->_table));
	}
	public function fetch_group_counter() {
		return XDB::fetch_first("SELECT SUM(todayposts) AS todayposts, COUNT(fid) AS groupnum FROM ".XDB::table($this->_table)." WHERE status='3' AND type='sub'");
	}
	public function fetch_all_sub_group_by_fup($fups, $limit = 20) {
		return XDB::result_first("SELECT fid, name FROM %t WHERE fup IN(%n) AND type='sub' AND level>'-1' ORDER BY commoncredits DESC LIMIT %d", array($this->_table, $fups, $limit));
	}
	public function fetch_all_for_threadsorts() {
		return XDB::fetch_all("SELECT f.fid, f.name, ff.threadsorts FROM ".XDB::table($this->_table)." f , ".XDB::table('forum_forumfield')." ff WHERE ff.threadsorts<>'' AND f.fid=ff.fid");
	}

	public function fetch_all_for_search($conditions, $start = 0, $limit = 20) {
		if(empty($conditions)) {
			return array();
		}
		if($start == -1) {
			return XDB::result_first("SELECT count(*) FROM ".XDB::table($this->_table)." f LEFT JOIN ".XDB::table('forum_forumfield')." ff ON f.fid=ff.fid
			WHERE status='3' AND type='sub' AND %i", array($conditions));
		}
		return XDB::fetch_all("SELECT f.fid, f.fup, f.type, f.name, f.posts, f.threads, ff.membernum, ff.lastupdate, ff.dateline, ff.foundername, ff.founderuid FROM ".XDB::table($this->_table)." f LEFT JOIN ".XDB::table('forum_forumfield')." ff ON f.fid=ff.fid
			WHERE status='3' AND type='sub' AND %i ".XDB::limit($start, $limit), array($conditions));
	}
	public function clear_todayposts() {
		XDB::query("UPDATE ".XDB::table($this->_table)." SET todayposts='0'");
	}
	public function clear_forum_counter_for_group() {
		XDB::query("UPDATE ".XDB::table($this->_table)." SET threads='0', posts='0' WHERE type='group'");
	}
	public function update_forum_counter($fid, $threads = 0, $posts = 0, $todayposts = 0, $modwork = 0, $favtimes = 0) {
		if(!intval($fid)) {
			return false;
		}
		$addsql = array();
		if($threads) {
			$addsql[] = "threads=threads+'".intval($threads)."'";
		}
		if($posts) {
			$addsql[] = "posts=posts+'".intval($posts)."'";
		}
		if($todayposts) {
			$addsql[] = "todayposts=todayposts+'".intval($todayposts)."'";
		}
		if($modwork) {
			$addsql[] = "modworks='1'";
		}
		if($favtimes) {
			$addsql[] = "favtimes=favtimes+'".intval($favtimes)."'";
		}
		if($addsql) {
			XDB::query("UPDATE ".XDB::table($this->_table)." SET ".implode(', ', $addsql)." WHERE ".XDB::field('fid', $fid), 'UNBUFFERED');
		}
	}
	public function update_commoncredits($fid) {
		if(!intval($fid)) {
			return false;
		}
		XDB::query("UPDATE ".XDB::table($this->_table)." SET commoncredits=commoncredits+1 WHERE ".XDB::field('fid', $fid));
	}
	public function update_group_level($levelid, $fid) {
		if(!intval($levelid) || !intval($fid)) {
			return false;
		}
		XDB::query("UPDATE ".XDB::table($this->_table)." SET level=%d WHERE fid=%d", array($levelid, $fid));
	}
	public function fetch_all_fid_for_group($start, $limit, $issub = 0, $conditions = '') {
		if(!empty($conditions) && !is_string($conditions)) {
			return array();
		}
		$typesql = $issub ? 'type=\'sub\'' : 'type<>\'sub\'';
		return XDB::fetch_all("SELECT fid FROM ".XDB::table($this->_table)." WHERE status='3' AND $typesql %i ".XDB::limit($start, $limit), array($conditions));
	}
	public function fetch_groupnum_by_fup($fup) {
		if(!intval($fup)) {
			return false;
		}
		return XDB::result_first("SELECT COUNT(*) as num FROM ".XDB::table($this->_table)." WHERE fup=%d AND type='sub' GROUP BY fup", array($fup));
	}
	public function fetch_all_group_for_ranking() {
		return XDB::fetch_all("SELECT fid FROM ".XDB::table($this->_table)." WHERE type='sub' AND status='3' ORDER BY commoncredits DESC LIMIT 0, 1000");
	}
	public function fetch_all_for_ranklist($status, $type, $orderfield, $start = 0, $limit = 0, $ignorefids = array()) {
		if(empty($orderfield)) {
			return array();
		}
		$typesql = $type ? ' AND f.'.XDB::field('type', $type) : ' AND f.type<>\'group\'';
		$ignoresql = $ignorefids ? ' AND f.fid NOT IN('.dimplode($ignorefids).')' : '';
		if($orderfield == 'membernum') {
			$fields = ', ff.membernum';
			$jointable = ' LEFT JOIN '.XDB::table('forum_forumfield').' ff ON ff.fid=f.fid';
			$orderfield = 'ff.'.$orderfield;
		}
		return XDB::fetch_all("SELECT f.* $fields FROM %t f $jointable WHERE f.status=%d $typesql $ignoresql ORDER BY %i DESC ".XDB::limit($start, $limit), array($this->_table, $status, $orderfield));
	}
	public function fetch_fid_by_name($name) {
		return XDB::result_first("SELECT fid FROM %t WHERE name=%s", array($this->_table, $name));
	}
	public function insert_group($fup, $type, $name, $status, $level) {
		XDB::query("INSERT INTO %t (fup, type, name, status, level) VALUES (%d, %s, %s, %d, %d)", array($this->_table, $fup, $type, $name, $status, $level));
		return XDB::insert_id();
	}
	public function fetch_all_by_fid($fids) {
		return XDB::fetch_all("SELECT * FROM %t WHERE fid IN(%n)", array($this->_table, (array)$fids), $this->_pk);
	}
	public function delete_by_fid($fids) {
		if(empty($fids)) {
			return false;
		}
		XDB::query("DELETE FROM ".XDB::table($this->_table)." WHERE %i", array(XDB::field('fid', $fids)));
		XDB::query("DELETE FROM ".XDB::table('forum_forumfield')." WHERE %i", array(XDB::field('fid', $fids)));
	}
	public function update_fup_by_fup($sourcefup, $targetfup) {
		XDB::query("UPDATE ".XDB::table($this->_table)." SET fup=%d WHERE fup=%s", array($targetfup, $sourcefup));
	}
	public function validate_level_for_group($fids) {
		if(empty($fids)) {
			return false;
		}
		XDB::query("UPDATE ".XDB::table($this->_table)." SET level='0' WHERE %i", array(XDB::field('fid', $fids)));
	}
	public function validate_level_num() {
		return XDB::result_first("SELECT count(*) FROM ".XDB::table($this->_table)." WHERE status='3' AND level='-1'");
	}
	public function fetch_all_validate($start, $limit) {
		return XDB::fetch_all("SELECT f.*, ff.dateline, ff.founderuid, ff.foundername, ff.description FROM ".XDB::table($this->_table)." f LEFT JOIN ".XDB::table('forum_forumfield')." ff ON ff.fid=f.fid WHERE status='3' AND level='-1' ORDER BY f.fid DESC LIMIT ".intval($start).', '.intval($limit));
	}
	public function update_archive($fids) {
		return XDB::update('forum_forum', array('archive' => '0'), "fid NOT IN (".dimplode($fids).")");
	}
	public function fetch_all_for_grouplist($orderby = 'displayorder', $fieldarray = array(), $num = 1, $fids = array(), $sort = 0, $getcount = 0) {
		if($fieldarray && is_array($fieldarray)) {
			$fieldadd = '';
			foreach($fieldarray as $field) {
				$fieldadd .= $field.', ';
			}
		} else {
			$fieldadd = 'ff.*, ';
		}
		$start = 0;
		if(is_array($num)) {
			list($start, $snum) = $num;
		} else {
			$snum = $num;
		}
		$orderbyarray = array('displayorder' => 'f.displayorder DESC', 'dateline' => 'ff.dateline DESC', 'lastupdate' => 'ff.lastupdate DESC', 'membernum' => 'ff.membernum DESC', 'thread' => 'f.threads DESC', 'activity' => 'f.commoncredits DESC');
		$useindex = $orderby == 'displayorder' ? 'USE INDEX(fup_type)' : '';
		$orderby = !empty($orderby) && $orderbyarray[$orderby] ? "ORDER BY ".$orderbyarray[$orderby] : '';
		$limitsql = $num ? "LIMIT $start, $snum " : '';
		$field = $sort ? 'fup' : 'fid';
		$fids = $fids && is_array($fids) ? 'f.'.$field.' IN ('.dimplode($fids).')' : '';
		if(empty($fids)) {
			 $levelsql = " AND f.level>'-1'";
		}

		$fieldsql = $fieldadd.' f.fid, f.name, f.threads, f.posts, f.todayposts, f.level as flevel ';
		if($getcount) {
			return XDB::result_first("SELECT count(*) FROM ".XDB::table($this->_table)." f $useindex WHERE".($fids ? " $fids AND " : '')." f.type='sub' AND f.status=3 $levelsql");
		}
		return XDB::fetch_all("SELECT $fieldsql FROM ".XDB::table($this->_table)." f $useindex LEFT JOIN ".XDB::table("forum_forumfield")." ff ON ff.fid=f.fid WHERE".($fids ? " $fids AND " : '')." f.type='sub' AND f.status=3 $levelsql $orderby $limitsql");
	}

	function fetch_table_struct($tablename, $result = 'FIELD') {
		if(empty($tablename)) {
			return array();
		}
		$datas = array();
		$query = XDB::query("DESCRIBE ".XDB::table($tablename));
		while($data = XDB::fetch($query)) {
			$datas[$data['Field']] = $result == 'FIELD' ? $data['Field'] : $data;
		}
		return $datas;
	}

	function get_forum_by_fid($fid, $field = '', $table = 'forum') {
		static $forumlist = array('forum' => array(), 'forumfield' => array());
		$table = $table != 'forum' ? 'forumfield' : 'forum';
		$return = array();
		if(!array_key_exists($fid, $forumlist[$table])) {
			$forumlist[$table][$fid] = XDB::fetch_first("SELECT * FROM ".XDB::table('forum_'.$table)." WHERE fid=%d", array($fid));
			if(!is_array($forumlist[$table][$fid])) {
				$forumlist[$table][$fid] = array();
			}
		}

		if(!empty($field)) {
			$return = isset($forumlist[$table][$fid][$field]) ? $forumlist[$table][$fid][$field] : null;
		} else {
			$return = $forumlist[$table][$fid];
		}
		return $return;
	}
}
//www-FX8-co
?>