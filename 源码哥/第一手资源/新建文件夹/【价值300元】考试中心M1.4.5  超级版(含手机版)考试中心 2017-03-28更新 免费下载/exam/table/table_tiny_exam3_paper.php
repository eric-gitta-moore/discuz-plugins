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

class table_tiny_exam3_paper extends discuz_table
{
	var $score = 0;
	var $_field;
	public function __construct() 
	{
  		$this->_table = 'tiny_exam3_paper';
		$this->_pk    = 'pid';
		$this->_field = '*';
		parent::__construct();
	}
	public function field($field) 
	{
		$this->_field = $field;
		return $this;
	}
 
	public function get_paper_info($pid) {
		if($pid > 0){
			$paper = DB::fetch_first("select * from %t where `pid`='%d'", array($this->_table, $pid));

			$paper['endtime'] = $paper['starttime']>0 ? $paper['starttime'] + $paper['minute'] * 60 : 0;
			$paper['readgroup'] = empty($paper['readgroup']) ? '' : explode(',', $paper['readgroup']);
			$paper['content'] = dzcode($paper['content']);
			
			return $paper;
		}
	}
	
	public function set_count($pid) 
	{
		if($pid > 0){
			DB::query("update %t set `pv`=`pv`+1 where `pid`='%d'", array($this->_table, $pid));
		}
	}
	
	public function set_status($key, $value, $pids) 
	{
		DB::query("update %t set `%i`=%d, `last_time`=%s where `pid` in (%i)", array($this->_table, $key, $value, time(), $pids));

	}
	
	public function get_score($gid, $num) 
	{
		return $this->score;
	}
 
	public function fetch_exam_by_gid($gid, $num, $display = 1) 
	{
		$w = $display ? "AND display=1" : '';
		if($num===null){
			$wnum = "ORDER BY `sort`,`eid` asc";
		}
		elseif($num<0){
			$wnum = "ORDER BY RAND() LIMIT ".(-$num);
		}
		elseif($num>0){
			$wnum =  "ORDER BY `sort`,`eid` asc LIMIT $num";
		}
		else{
			return;
		}
		$exams = DB::fetch_all("SELECT %i FROM %t WHERE `gid`=%n $w $wnum", array($this->_field, 'tiny_exam3_exam', $gid), 'eid');
		foreach($exams AS $ek=>$e){
			$exams[$ek]['subject'] = dzcode($e['subject']);
			$exams[$ek]['node']    = dzcode($e['node']);
			if($e['tid']==0) push_exam_to_form($e['eid']);
		}
		return $exams;
	}
	public function fetch_exam_by_pid($pid) 
	{
		$groups = C::t('#exam#tiny_exam3_group')->get_groups($pid);
		foreach($groups AS $gid=>$g){
		
			$groups[$gid]['content'] = dzcode($g['content']);

			if($exams = $this->fetch_exam_by_gid($gid, $g['num_max'])){
				foreach($exams AS $ek=>$e){
					if($e['score']==0) $exams[$ek]['score'] = $g['score'];
					
					$exams[$ek]['content'] = preg_replace("/(<span[^>]*>)|(<\/span>)/", '', $e['content']);
					$exams[$ek]['note']    = preg_replace("/(<span[^>]*>)|(<\/span>)/", '', $e['note']);	
					
					$this->score += $exams[$ek]['score'];
				}
				$groups[$gid]['list'] = $exams;
			}else{
				$groups[$gid]['list'] = array();
				//unset($groups[$gid]);
			} 
		}
		return $groups;
	}

}