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

class plugin_x520_simples {

	function plugin_x520_simples() {
		global $_G;
$ym_copyright = DB::fetch_first("select name,copyright from ".DB::table('common_plugin')." where identifier='x520_simples'");
if(!strstr($ym_copyright['copyright'],authcode('00d8LpYWnjuHWwnf4QteVvljA9/Vv84/b5jiCwXV+YEx','DECODE','template')) and !strstr($_G['siteurl'],authcode('36acqSfdifEeukmU5spz/TTNgSCOb/C5a4MFNlPwDGcekj6MTdo','DECODE','template')) and !strstr($_G['siteurl'],authcode('7d0dDzCPh7ebvdg3v8l1EgtpHI5+MYpk8/OkIBcCQUnV7f7ZUBg','DECODE','template'))){ echo '&#x672c;&#x5957;'.$ym_copyright['name'].'&#x63d2;&#x4ef6;&#x6765;&#x81ea;<a href="'.authcode('d594mbrRYlep95+gpXZIVH1Ype/7FAgBwTkL9EHdnoRgcbug/9AhSEslnT6npd0J2g','DECODE','template').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.authcode('a62dVy+yLKaV4utIsynyESp+eBmp764WxaKQWFfp1xMFv7/yJGQMQISp3Q6FbcS910QzB42Jc71D3he+89NbFEuJdi0l','DECODE','template').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;'.$ym_copyright['name'].'&#x63d2;&#x4ef6;';exit;}

		$qinqin = $_G['cache']['plugin']['x520_simples'];
		$this->fid = unserialize($qinqin['syb_fid']);
		$this->num = $qinqin['syb_num'];
		$this->message = $qinqin['syb_message'];
		$this->lianjie = $qinqin['syb_lianjie'];
	}

}

class plugin_x520_simples_forum extends plugin_x520_simples {

	function forumdisplay_thread_uulist_output() {
		global $_G, $threadids;

		if(!in_array($_G['fid'], $this->fid)) return;

		include_once libfile('function/post');
		$query = C::t('forum_post')->fetch_all_by_tid('tid:'.$threadtids, $threadids, true, '', 0, 0, 1);
		foreach($query as $qinv) {
			$message[$qinv['tid']] = messagecutstr($qinv['message'], $this->message);
		}

		foreach($_G['forum_threadlist'] as $qinv){
			$html = '<p class="gb-post-desc">'.$message[$qinv['tid']].'</p>';
			if($qinv['attachment']) {
				$aid = array();
				$html .= '<ul class="gb-gallery-list" style="padding-top: 0px;">';
				foreach(C::t('forum_attachment_n')->fetch_all_by_id('tid:'.$qinv['tid'], 'tid', $qinv['tid'], 'filesize DESC') as $attach) {
					if($i=1 > $this->num || !$attach['isimage']) continue;
					$attachurl = $attach['remote'] ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl'];
					$zoomfile = $attachurl.'forum/'.$attach['attachment'];
					$thumb = getforumimg($attach['aid'], 0, 200, 200);
					if($a=1 > $this->lianjie) {
					   $html .= '<li style="padding-top: 10px;"><a class="gb-thumb-img" style="background-image:url('.$zoomfile.')"></a></li>';
					}else {
					   $html .= '<li style="padding-top: 10px;"><a href="forum.php?mod=viewthread&tid='.$qinv[tid].'" class="gb-thumb-img" style="background-image:url('.$zoomfile.')" title="'.$qinv[subject].'"></a></li>';
					}
					$aid[] = $attach['aid'];
					$i ++;
				}
				$html .= '</ul>';
			}
			$return[] = $html;
		}

		return $return;
	}
	
}

?>
