<?php
/**
 *      [Caogen8!] (C)2014-2018 Www.Caogen8.co.
 *      Ð¡²Ý¸ù(QQ£º2575163778) wWw.Caogen8.co
 *
 *      Author: CAOGEN8.CO $
 *    qq:2575163778 $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_zhanmishu_sms extends discuz_table {

	public function __construct() {
		$this->_table = 'zhanmishu_sms';
		$this->_pk = 'sid';

		parent::__construct();
	}

	public function get_mts_exists($mts){
		if (!$mts) {
			# code...
			return false;
		}
		$data = DB::fetch_first('select mts,province,catname,areavid,ispvid,carrier from %t where mts = '.$mts,array($this->_table));
		if (empty($data)) {
			return;
		}

		return $data;
	}

	public function update_area($area){
		if (!is_array($area)) {
			return false;
		}
		$t = DB::fetch_all('select sid from %t where mobile = '.$area['telstring'],array($this->_table),'sid');
		if (empty($t)) {
			return false;
		}
		foreach ($t as $key => $value) {
			C::t("#zhanmishu_sms#zhanmishu_sms")->update($key,$area);
		}
	}

	public function fetch_day_ip($ip){
		$ip_arr = explode(".", $ip);
		if (count($ip_arr) !== 4) {
			return false;
		}
		$day_time = strtotime(date('Y-m-d',TIMESTAMP));
		$count = DB::fetch_first('select count(*) as num from %t where issuccess = 1 and dateline > '.$day_time.' and ip1='.$ip_arr[0].' and ip2='.$ip_arr[1].' and ip3='.$ip_arr[2].' and ip4='.$ip_arr[3],array($this->_table));
		return $count['num'];
	}
	public function fetch_day_num(){

		$day_time = strtotime(date('Y-m-d',TIMESTAMP));
		$count = DB::fetch_first('select count(*) as num from %t where issuccess = 1 and dateline > '.$day_time,array($this->_table));
		return $count['num'];
	}
	public function fetch_day_phone($mobile){
		if (!$mobile) {
			return false;
		}
		$day_time = strtotime(date('Y-m-d',TIMESTAMP));
		$count = DB::fetch_first('select count(*) as num from %t where issuccess = 1 and dateline > '.$day_time.' and mobile='.$mobile,array($this->_table));
		return $count['num'];
	}

	public function get_send_success_num(){
		$num = DB::fetch_first('select count(*) as num from %t where issuccess=1',array($this->_table));
		return $num['num'];
	}

	public function get_register_success_num(){
		return $this->get_type_success_num('1');
	}

	public function get_type_success_num($type){
		if ($type) {
			$type = 'type = '.$type.' and ';
		}
		$num = DB::fetch_first('select count(*) as num from %t where '.$type.' uid > 0',array($this->_table));
		return $num['num'];
	}


	public function get_type_smses($start = 0, $limit = 0, $sort = '',$type = '',$field=array()) {
		if($sort) {
			$this->checkpk();
		}
		if ($type && isset($field['type'])) {
			$where = ' where type = '.$type.' ';
			unset($field['type']);
		}
		if (!empty($field) && $where) {
			$where = $where.' and ';
		}elseif (!empty($field)) {
			$where = ' where ';
		}else{
			$where = '';
		}

		$i = 1;
		foreach ($field as $key => $value) {
			if ($i == count($field)) {
				$where = $where.' '.$key.' = '.$value.' ';
			}else{
				$where = $where.' '.$key.' = '.$value.' and ';
			}

			++$i;
		}
		return DB::fetch_all('SELECT * FROM '.DB::table($this->_table).$where.($sort ? ' ORDER BY '.DB::order($this->_pk, $sort) : '').DB::limit($start, $limit), null, $this->_pk ? $this->_pk : '');
	}


	public function fetch_by_fields($data=array()){
		if (empty($data)) {
			return false;
		}

		$where = ' where ';
		$i = 1;
		foreach ($data as $key => $value) {
			if ($i == count($data)) {
				$where = $where.' '.$key.' = '.$value.' ';
			}else{
				$where = $where.' '.$key.' = '.$value.' and ';
			}

			++$i;
		}

		return DB::fetch_first('select * from %t '.$where,array($this->_table));
	}

	public function get_count_by_field($data='',$extsql='',$filed=''){
		if (!is_array($data) || empty($data)) {
			return $this->count();
		}
		$where = ' where ';
		$i = 1;
		foreach ($data as $key => $value) {
			if ($i == count($data)) {
				$where = $where.' '.$key.' = '.$value.' ';
			}else{
				$where = $where.' '.$key.' = '.$value.' and ';
			}

			++$i;
		}
		$filed = strlen($filed) > 0 ? ' distinct '.$filed : '*';
		$count = DB::fetch_first('select count(  '.$filed.') as num  from %t '.$where.' '.$extsql,array($this->_table));

		return $count['num'];
	}

	public function get_newest_sid_byuid($uid){
		if (!$uid) {
			return false;
		} 

		$s = DB::fetch_first('select * from %t where uid = '.$uid.' order by sid desc',array($this->_table));
		if (empty($s)) {
			return false;
		}
		return $s['sid'];
	}

	public function fetch_all_black_mobiles($start = 0, $limit = 0, $sort = '',$type = '',$field=array()) {
		if($sort) {
			$this->checkpk();
		}

		if (!empty($field)) {
			$where = ' where ';
		}else{
			$where = '';
		}

		$i = 1;
		foreach ($field as $key => $value) {
			if ($i == count($field)) {
				$where = $where.' '.$key.' = \''.$value.'\' ';
			}else{
				$where = $where.' '.$key.' = \''.$value.'\' and ';
			}

			++$i;
		}
		return DB::fetch_all('SELECT * FROM '.DB::table($this->_table).$where.($sort ? ' ORDER BY '.DB::order($this->_pk, $sort) : '').' group by mobile '.DB::limit($start, $limit), null, $this->_pk ? $this->_pk : '');
	}
	public function check_isblask_mobile($mobile=''){
		if (!$mobile) {
			return false;
		}
		$data = $this->fetch_by_fields(array('mobile'=>$mobile));
		if (!empty($data) && $data['isblack'] == '1') {
			return true;
		}
		return false;
	}
	public function get_nationcode_bymobile($mobile){
		$mobileinfo = DB::fetch_first('select * from %t where mobile = %s and nationcode > 0',array($this->_table,$mobile));
		return $mobileinfo['nationcode'];
	}
	public function set_black_mobile($mobile='',$isblack='1'){
		if (!$mobile) {
			return false;
		}

		return DB::update($this->_table, array('isblack' => $isblack), "`mobile` = '$mobile'");
	}

}