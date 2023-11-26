<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
global $_G;
$keke_tixian = $_G['cache']['plugin']['keke_tixian'];
if(!$_G['uid']){
    showmessage('not_loggedin', '', array(), array('login' => true));
}
$bank=explode("/hhf/",str_replace(array("\r\n", "\n", "\r"), '/hhf/',$keke_tixian['bank']));
$p=$_GET['p'];
loadcache('keke_tixian');
$creditdata=$_G['cache']['keke_tixian'] ? $_G['cache']['keke_tixian'] : $creditdata=C::t('#keke_tixian#keke_tixian_credit')->fetchall_credit();
if($p=='card'){
	$carddata=C::t('#keke_tixian#keke_tixian_card')->fetch_by_uid($_G['uid']);
}elseif($p=='my'){
	$ppp=30;
	$tmpurl='plugin.php?id=keke_tixian&p=my';
	$page = max(1, intval($_GET['page']));
	$startlimit = ($page - 1) * $ppp;
	$allcount = C::t('#keke_tixian#keke_tixian')->count_by_all($_G['uid']);
	if($allcount){
		$query = C::t('#keke_tixian#keke_tixian')->fetch_all_by_all($_G['uid'],0,$startlimit,$ppp);
		foreach($query as $val){
			$sxf=$creditdata[$val['credittype']]['sxf'];
			$bili=$creditdata[$val['credittype']]['bili'];
			$sxfs=round($val['credit']*($sxf/100)*$bili ,2);
			$money=round($val['credit']*(1-$sxf/100)*$bili,2);
			$time=dgmdate($val['time'], 'm-d H:i');
			$endtime=dgmdate($val['endtime'], 'm-d H:i');
			$br= checkmobile() ? '<br>' : '<b class="sep">/</b>';
			$tuiyuanyin=$val['tuiyuanyin'] ? $br.'<font color="#c30">'.lang('plugin/keke_tixian', 'lang58').''.dhtmlspecialchars($val['tuiyuanyin']).'</font>' : '';
			if($val['state']==1){$stat='<b class="gl">'.lang('plugin/keke_tixian', 'lang26').'</b> '.$endtime ;}elseif($val['state']==2){$stat='<b class="h">'.lang('plugin/keke_tixian', 'lang27').'</b> <b class="sep">|</b>'.$endtime.$tuiyuanyin  ;}else{$stat='<b class="yl">'.lang('plugin/keke_tixian', 'lang47').'</b>' ;}
			$mylist.='<li><div class="pup"><span><b class="rred">'.$val['credit'].'</b>'.$_G['setting']['extcredits'][$val['credittype']]['title'].'</span>'.lang('plugin/keke_tixian', 'lang48').'<b class="rred">'.$money.'</b>'.lang('plugin/keke_tixian', 'lang03').'<i> '.lang('plugin/keke_tixian', 'lang49').$sxfs.lang('plugin/keke_tixian', 'lang03').' </i></div><div class="dow">'.$val['cardtype'].' / '.$val['cardon'].' / '.$val['cardname'].'</div><div class="dow"><font color="#CCCCCC">'.lang('plugin/keke_tixian', 'lang50').' '.$time.'</font><b class="sep">|</b>'.$stat.'</div></li>';
		}
	}
	$multipage = multi($allcount, $ppp, $page, $_G['siteurl'].$tmpurl);
}else{
	$d=0;
	$cardid=intval($_GET['c']);
	loadcache('keke_tixian_card');
	$cachedata=$_G['cache']['keke_tixian_card'];
	$defaultcard=$cachedata[$_G['uid']]['defaultcard'];
	if(!$cardid){
		$cardid=$defaultcard;
	}elseif($cardid && ($cardid!=$defaultcard) && $_G['uid']){
		$cachedata[$_G['uid']]['defaultcard']=$cardid;
		require_once libfile('function/cache');
		savecache('keke_tixian_card', $cachedata);
	}
	
	$cardata=C::t('#keke_tixian#keke_tixian_card')->fetch($cardid);
	if($cardata['type']==1){$cardtype=lang('plugin/keke_tixian', 'lang51');}elseif($cardata['type']==2){$cardtype=lang('plugin/keke_tixian', 'lang52');}else{$cardtype=$bank[$cardata['bank']];}

	foreach($creditdata as $k=>$v){
		if($v['state']){
			$carditname=$_G['setting']['extcredits'][$k]['title'];
			$class='';
			if($d==0){
				$firstcarditname=$carditname;
				$firstcarditid=$k;
				$class='class="on"';
			}
			$nowcredit = getuserprofile('extcredits'.$k);
			$craditlist.='<li '.$class.' creditid='.$k.' data-bili='.$v['bili'].' data-min='.$v['min'].' data-nowcredit='.$nowcredit.' data-sxf='.$v['sxf'].'>'.$carditname.'</li>';
			$d++;
		}
	}
	$totaltx=C::t('#keke_tixian#keke_tixian')->sum_by_uid($_G['uid']);
	$totaltx=$totaltx?$totaltx:"0.00";
	$nowcredits = getuserprofile('extcredits'.$firstcarditid);
	
	
}


include template('keke_tixian:tx_index');