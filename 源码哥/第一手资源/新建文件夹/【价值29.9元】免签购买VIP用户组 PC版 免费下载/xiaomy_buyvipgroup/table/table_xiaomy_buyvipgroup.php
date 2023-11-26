<?php
/*
 *源码哥：www.ymg6.com
 *更多商业插件/模版免费下载 就在源码哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_xiaomy_buyvipgroup extends discuz_table
{
	public function __construct() {

		$this->_table = 'xiaomy_buyvipgroup';
		$this->_pk    = 'id';
		parent::__construct();
	}
	
	public function fetch_by_uid($uid,$b,$e){
		return DB::fetch_all('SELECT * FROM  %t  where uid=%d order by dateline desc limit %d,%d', array($this->_table,$uid,$b,$e));
	}
	
	public function fetch_by_uidrcount($uid){
		return DB::fetch_first('SELECT count(*) as rcount FROM  %t  where uid=%d', array($this->_table,$uid));
	}
	
	
	public function fetch_page_data($start=0,$limit=10)
	{
		return DB::fetch_all('SELECT * FROM  %t   ORDER BY dateline desc limit '. $start.",".$limit, array($this->_table));
	}
	
	
	public function fetch_by_id($did){
			return DB::fetch_first('SELECT * FROM  %t  where id=%d', array($this->_table,$did));
	}
	
	public function delete_by_id($did){
		
		return DB::query('delete  FROM  %t  where id=%s', array($this->_table,$did));
	}
	
	
		public function fetch_pay_record($limit)
	{
		return DB::fetch_all('SELECT * FROM  %t   where status=2 ORDER BY dateline desc limit 0,%d', array($this->_table,$limit));
	}
}

?>