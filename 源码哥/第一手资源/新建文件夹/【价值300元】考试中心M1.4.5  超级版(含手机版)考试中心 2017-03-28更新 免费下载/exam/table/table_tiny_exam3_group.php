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

class table_tiny_exam3_group extends discuz_table
{
	var $_field;
	public function __construct() {
		$this->_table = 'tiny_exam3_group';
		$this->_pk    = 'gid';
		$this->_field = '*';
		parent::__construct();
	}
 
	public function get_groups($pid, $bAll = false) 
	{
		$w = $bAll ? '' : "AND `sort`>=0";
		$groups = DB::fetch_all("select %i from %t where `pid`='%d' $w order by `sort`,`gid` asc", array($this->_field, $this->_table, $pid), $this->_pk);
		$new_groups = array();
		foreach($groups AS $gid=>$g){
			if(!$g['assoc']){
				unset($g['assoc']);
				$new_groups[$gid] = $g;
			}
			else{
				$g['assoc'] = str_replace('，', ',', $g['assoc']);
				$ga = explode(',', $g['assoc']);
				unset($g['assoc']);
				$g['pid'] = $pid;
				foreach($ga AS $k){
					$g['gid'] = $k;
					$new_groups[$k] = $g;
				}
			}
		}
		return $new_groups;
	}
	
	public function get_groups2($pid, $bAll = false) 
	{
		$w = $bAll ? '' : "AND `sort`>=0";
		$groups = DB::fetch_all("select %i from %t where `pid`='%d' $w order by `sort`,`gid` asc", array($this->_field, $this->_table, $pid), $this->_pk);
		return $groups;
	}
	
	
	public function field($field) 
	{
		$this->_field = $field;
		return $this;
	}
	
	public function get_group($gid, $fields = '*') 
	{
		$data = DB::fetch_first("select %i from %t where `gid`='%d'",array($fields, $this->_table, $gid));
		return $data;
	}
 
}
?>