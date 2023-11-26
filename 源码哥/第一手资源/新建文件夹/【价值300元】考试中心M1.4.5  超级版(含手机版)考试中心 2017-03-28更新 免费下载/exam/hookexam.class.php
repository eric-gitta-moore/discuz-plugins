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
 
class plugin_exam {
    function  plugin_exam() {

    }		
}
 
class plugin_exam_forum extends plugin_exam{
    function viewthread_middle_output(){
        global $_G,$postlist,$config;
		include_once DISCUZ_ROOT . "/source/plugin/exam/tiny.common.inc.php";
 
        foreach($postlist as $pid => $post) {
            if ($post['first'] == 1  && preg_match("/\[exam=(\d+)\]/i", $post['message'], $matches)) {
				$eid  = $matches[1];
				$exam = DB::fetch_first("SELECT E.*,P.title FROM %t AS E,%t AS P where E.pid=P.pid AND E.eid='$eid'", array('tiny_exam3_exam', 'tiny_exam3_paper'));
				$exam['subject'] = dzcode( $exam['subject'] );				

				if($exam['type']==2 || $exam['type']==3) $exam['data'] = explode("\n", $exam['data']);
 
				$paper = C::t('#exam#tiny_exam3_paper')->get_paper_info($exam['pid']);
				
				$paycheck = checkPaper($paper, $_G['uid']);
 
				ob_start();
				include template("exam:$template/common/thread"); 
				$ob_contents = ob_get_contents(); 
				ob_end_clean();
                $postlist[$pid]['message'] = $ob_contents;
		
            }
			break;
        }
    }
}
?>