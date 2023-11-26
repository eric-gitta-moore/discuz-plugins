<?php

/*
 * CopyRight  : [www.moqu8.com!] (C)2014-2015
 * Document   : 魔趣吧：www.moqu8.com
 * Created on : 2015-01-17,21:45:40
 * Author     : 魔趣吧(QQ：10373458)  $
 * Description: This is NOT a freeware, use is subject to license terms.
 *              魔趣吧出品 必属精品。
 *              魔趣吧源码论坛 全网首发 http://www.moqu8.com；
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
include_once DISCUZ_ROOT.'./source/plugin/ljdaka/shiqu.inc.php';
class table_plugin_daka_user extends discuz_table {

    public function __construct() {

        $this->_table = 'plugin_daka_user';
        $this->_pk = 'uid';
        parent::__construct();
    }

    public function fetch_all_by_allday($curnum, $perpage) {
        if ($perpage) {
            return DB :: fetch_all("select * from %t order by allday desc,money desc limit %d,%d", array($this->_table, $curnum, $perpage));
        } else {
            return DB :: fetch_all("select uid,* from %t GROUP BY allday order by allday desc,money desc ", array($this->_table));
        }
    }

    public function fetch_all_by_uid($con, $curnum, $perpage) {
        return DB :: fetch_all("select * from %t $con  limit %d,%d", array($this->_table, $curnum, $perpage));
    }

    public function fetch__by_count($con) {
        return DB :: result_first("select * from %t $con ", array($this->_table));
    }

    public function fetch_by_uid($uid) {
        return DB::result_first("select * from %t where uid=%d", array($this->_table, $uid));
    }

    public function fetch_by_uid1($uid) {
        return DB::fetch_first("select * from %t where uid=%d", array($this->_table, $uid));
    }

    public function update_by_uid($uid, $money, $myall, $mall, $timestamp) {
        return DB::query('update %t set money=money+%d,allday=allday+1,day=%d,fen=%d,timestamp=%s where uid=%d', array($this->_table, $money, $myall, $mall, $timestamp, $uid));
    }
	 public function fetch_by_first() {
		$todaytimestamp = strtotime(gmdate('Y-m-d 00:00:00',TIMESTAMP+3600*8));
        return DB::fetch_first('select * from %t where timestamp >=%d order by timestamp asc', array($this->_table,$todaytimestamp));
    }
	public function count_by_timestamp($uid) {
		$todaytimestamp = strtotime(gmdate('Y-m-d 00:00:00',TIMESTAMP+3600*8));
        return DB :: result_first('select count(*) from %t where timestamp >=%d', array($this->_table,$todaytimestamp));
    }
}

?>