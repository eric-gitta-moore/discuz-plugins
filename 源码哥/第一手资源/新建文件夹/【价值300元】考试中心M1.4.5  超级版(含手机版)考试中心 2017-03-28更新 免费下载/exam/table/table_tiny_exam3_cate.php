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

class table_tiny_exam3_cate extends discuz_table
{
	public function __construct() {
		$this->_table = 'tiny_exam3_cate';
		$this->_pk    = 'cid';
		parent::__construct();
	}
 
	public function fetch_cate_tree($status=0) {
		$cates = $this->fetch_cate($status);
		$tree  = gettree($cates, 0,  'cid', 'ucid');
		return $tree;
	}
	
	public function fetch_cate($status=0) {
		$cates = DB::fetch_all("select * from %t %i order by `ucid`,`sort`,`cid` asc", array($this->_table, $status==-1 ? '' : "where `status`='$status'"), $this->_pk);
		foreach($cates AS $k=>$v){
			$cates[$k]['last'] = unserialize($v['last']);
		}
		return $cates;
	}
	
	public function get_one($cid){
		return DB::fetch_first("SELECT * FROM %t where cid='%d'", array($this->_table, $cid));
	}

}
?>