<?php

/**
 * Www.침혹걸.Vip
 *
 * [침혹걸!] (C)2014-2017 www.moqu8.com.  By www-침혹걸-co
 *
 * Support: caogenba@qq.com QQ:1218894030
 *
 * Date: 2013-02-17 16:22:17 moqu8.com $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_levckplayer extends discuz_table {
	
	public static $table = 'lev_ckplayer';
	
	public static function setstatus($table) {
		global $_G;
		if ($_G['adminid']!=1) exit('-1');
		$id = intval($_GET['opid']);
		$name = trim($_GET['name']);
		if ($id <1) {
			exit('-1');
		}
		$rs = DB::fetch_first("SELECT * FROM ".DB::table($table)." WHERE id=$id");
		if (isset($rs[$name])) {
			$value = $rs[$name] ? 0 : 1;
			DB::update($table, array($name=>$value), array('id'=>$id));
			echo $value;exit();
		}else {
			exit('-2');
		}
	}

	public static function setoption($table) {
		global $_G;
		if ($_G['adminid']!=1) exit('-1');
		$opid = intval($_GET['opid']);
		$name = trim($_GET['name']);
		$value= trim(lev_base::levdiconv($_GET['value']));
		DB::update($table, array($name=>$value), array('id'=>$opid));
		exit('1');
	}
	
	public static function deldata($table) {
		$insql = lev_base::sqlinstr($_GET['ids']);
		if ($insql) {
			DB::query("DELETE FROM ".DB::table($table)." WHERE `id` IN ({$insql})");
		}
	}
	
	public static function levpages($table, $where = '', $limit = 20, $start = 0, $url = '', $feilds = '*', $nopage = 0) {
		if (!$url) $url = lev_base::$PLURL;

		$where = $table ? DB::table($table).' WHERE '.$where : $where ;
		$page  = $nopage ? 1 : max(intval($_GET['page']), 1);
		$total = DB::result_first("SELECT COUNT(*) FROM ".$where);
		$start = ($page - 1) * $limit + $start;
		$sql   = "SELECT ".$feilds." FROM ".$where." ".DB::limit($start, $limit);
		$lists = DB::fetch_all($sql);//print_r($lists);
		$pages = multi($total, $limit, $page, $url);//print_r($pages);
		$infos = array('pages'=>$pages, 'lists'=>$lists, 'total'=>$total);

		return $infos;
	}

	public static function citys() {
		$citys = DB::fetch_all("SELECT * FROM ".DB::table('common_district'), array(), 'id');
		return $citys;
	}
	public static function mycity($id, $all = false) {
		static $citys;
		if (empty($citys)) {
			$citys = self::citys();
		}
		if ($all) {
			$mycity = self::allmycity($citys, $id);
		}else {
			$mycity = $citys[$id]['name'];
		}
		return $mycity;
	}
	public static function allmycity($citys, $id, $mycity = '') {
		$mycity = $mycity ? $citys[$id]['name'].' &raquo; '.$mycity : $citys[$id]['name'];
		if ($citys[$id]['upid']) {
			return self::allmycity($citys, $citys[$id]['upid'], $mycity);
		}else {
			return $mycity;
		}
	}
	
}








