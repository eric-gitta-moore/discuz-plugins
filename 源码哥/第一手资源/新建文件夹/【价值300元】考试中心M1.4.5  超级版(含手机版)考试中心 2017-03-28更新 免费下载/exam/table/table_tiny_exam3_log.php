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

class table_tiny_exam3_log extends discuz_table
{
	public function __construct() {
		$this->_table = 'tiny_exam3_log';
		$this->_pk    = 'lid';
		parent::__construct();
	}
 
	public function value($field, $uid, $pid) 
	{
		return DB::result_first("select %i from %t where `uid`='%d' AND `pid`='%d' order by `lid` desc limit 1", array($field, $this->_table, $uid, $pid));
	}
	public function get_simple($num) 
	{
		if($num>0){
			return DB::fetch_all("SELECT L.lid,L.pid,P.title,L.total,L.uid,L.score,L.endtime AS time,P.pass,P.uid AS authorid,P.username AS author,M.username FROM %t AS L,%t AS P,%t AS M WHERE L.pid=P.pid AND L.uid=M.uid order by L.`lid` desc limit $num", array('tiny_exam3_log', 'tiny_exam3_paper', 'common_member'), 'lid');
		}
	}
	
	

	
	
	
 
}
?>