<?php

/*
 * CopyRight  : [www.moqu8.com!] (C)2014-2015
 * Document   : Ä§È¤°É£ºwww.moqu8.com
 * Created on : 2015-01-17,21:45:40
 * Author     : Ä§È¤°É(QQ£º10373458)  $
 * Description: This is NOT a freeware, use is subject to license terms.
 *              Ä§È¤°É³öÆ· ±ØÊô¾«Æ·¡£
 *              Ä§È¤°ÉÔ´ÂëÂÛÌ³ È«ÍøÊ×·¢ http://www.moqu8.com£»
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
include_once DISCUZ_ROOT.'./source/plugin/ljdaka/shiqu.inc.php';
class table_plugin_daka extends discuz_table {

    public function __construct() {

        $this->_table = 'plugin_daka';
        $this->_pk = 'id';
        parent::__construct();
    }

    public function fetch_by_tables() {
        return DB :: result_first("show tables like '" . DB :: table('plugin_daka') . "'");
    }

    public function fetch_by_uid($uid){
		$todaytimestamp = strtotime(gmdate('Y-m-d 00:00:00',TIMESTAMP+3600*8));
		return DB :: result_first('select count(*) from %t where uid=%d and timestamp>=%d',array($this->_table,$uid,$todaytimestamp));
	}
	public function fetch_by_uid_c($uid) {
        return DB :: result_first("select count(*) from " . DB :: table($this->_table) . " where uid=$uid ");
    }
    public function count_by_timestamp($uid) {
		$todaytimestamp = strtotime(gmdate('Y-m-d 00:00:00',TIMESTAMP+3600*8));
        return DB :: result_first('select count(*) from %t where timestamp >=%d', array($this->_table,$todaytimestamp));
    }

    public function fetch_by_jinuid() {
		$todaytimestamp = strtotime(gmdate('Y-m-d 00:00:00',TIMESTAMP+3600*8));
        return DB :: result_first('select count(*) from %t where  timestamp >=%d', array($this->_table,$todaytimestamp));
    }

    public function fetch_by_uid_yesterday($uid){
		$todaytimestamp = strtotime(gmdate('Y-m-d 00:00:00',TIMESTAMP+3600*8));
		$yesterdaytimestamp  = $todaytimestamp-86400;
		return DB :: result_first('select alldays from %t where uid=%d and timestamp >=%d and timestamp <=%d',array($this->_table,$uid,$yesterdaytimestamp,$todaytimestamp));
	}

    public function fetch_by_first() {
		$todaytimestamp = strtotime(gmdate('Y-m-d 00:00:00',TIMESTAMP+3600*8));
        return DB::fetch_first('select * from %t where timestamp >=%d order by id asc', array($this->_table,$todaytimestamp));
    }

}

?>