<?php
/**
 *      [Caogen8!] (C)2014-2018 Www.Caogen8.co.
 *      Ğ¡²İ¸ù(QQ£º2575163778) wWw.Caogen8.co
 *
 *      Author: CAOGEN8.CO $
 *		qq:2575163778 $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_zhanmishu_notice extends discuz_table {

	public function __construct() {
		$this->_table = 'zhanmishu_notice';
		$this->_pk = 'nid';

		parent::__construct();
	}

	public function fet_all_should_sms($num=10){
		return DB::fetch_all('select * from %t where issendsms = 1 and issmssuccess = 0 group by uid limit '.$num,array($this->_table),'uid');
	}
	public function fet_all_should_email($num=10){
		return DB::fetch_all('select * from %t where issendemail = 1 and isemailsuccess = 0 and email !=\'\' group by uid limit '.$num,array($this->_table),'uid');
	}
	public function fet_all_should_groupsms($num=10){
		return DB::fetch_all('select * from %t where issendgroupsms = 1 and isgroupsmssuccess = 0 and mobile !=\'\' group by mobile limit '.$num,array($this->_table));
	}

	public function update_status($uid,$noticer){
		if (!$uid || !$noticer) {
			return false;
		}
		if (in_array('issmssuccess', $noticer) && in_array('isemailsuccess', $noticer)) {
			$w = 'issendsms =1 and issendemail =1 and issmssuccess = 0 and isemailsuccess = 0 and';
		}else if (in_array('issmssuccess', $noticer)) {
			$w = 'issendsms =1 and issmssuccess = 0 and';
		}else if (in_array('isemailsuccess', $noticer)) {
			$w = 'issendemail =1 and isemailsuccess = 0 and';
		}
		
		$re = DB::update($this->_table,$noticer,$w.' uid = '.$uid);
		if ($re) {
			return true;
		}
		return false;
	}

	public function get_day_send_num($uid,$type){
		$time = TIMESTAMP;
		$day = strtotime(date("Y-m-d",$time));
		if (!in_array($type, array('issmssuccess','isemailsuccess'))) {
			return false;
		}
		if ($type == 'issmssuccess') {
			$tt = 'sendsmstime';
		}else if ($type == 'isemailsuccess') {
			$tt = 'sendemailtime';
		}

		$r = DB::fetch_all('select * from %t where uid = '.$uid.' and '.$type.' = 1 and '.$tt.' > '.$day,array($this->_table));
		return $r['num'];
	}

	public function get_latestsendtime($uid,$type){
		if (!in_array($type, array('issmssuccess','isemailsuccess'))) {
			return false;
		}
		if ($type == 'issmssuccess') {
			$tt = 'sendsmstime';
		}else if ($type == 'isemailsuccess') {
			$tt = 'sendemailtime';
		}

		$r = DB::fetch_first('select '.$tt.'  from %t where uid = '.$uid.' and '.$type.' = 1 order by '.$tt.' desc',array($this->_table));
		return $r[$tt];
	}
}