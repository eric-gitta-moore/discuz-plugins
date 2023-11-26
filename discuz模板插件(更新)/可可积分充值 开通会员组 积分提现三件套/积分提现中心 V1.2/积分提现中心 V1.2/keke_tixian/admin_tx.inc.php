<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
	global $_G;
	loadcache('plugin');
	$keke_tixian = $_G['cache']['plugin']['keke_tixian'];
	$orderid=intval($_GET['orderid']);
	if($_GET['ac']=='ok'){
		if($keke_tixian['sxfuid']){
			$orderdata=C::t('#keke_tixian#keke_tixian')->fetchfirst_by_id($orderid);
			$creditdata=$_G['cache']['keke_tixian'] ? $_G['cache']['keke_tixian'] : C::t('#keke_tixian#keke_tixian_credit')->fetchall_credit();	
			$sxfcredit=round($orderdata['credit']*$creditdata[$orderdata['credittype']]['sxf']/100);
			updatemembercount($keke_tixian['sxfuid'], array('extcredits'.$orderdata['credittype']=>$sxfcredit), true, '', 0, '',lang('plugin/keke_tixian', 'lang59'),$orderdata['usname'].lang('plugin/keke_tixian', 'lang60'));
		}
		$arr=array('state'=>1,'endtime'=>$_G['timestamp']);
		C::t('#keke_tixian#keke_tixian')->update($orderid,$arr);
		cpmsg(lang('plugin/keke_tixian', 'lang01'), 'action=plugins&operation=config&identifier=keke_tixian&pmod=admin_tx', 'succeed');
	}elseif($_GET['ac']=='del'){
		C::t('#keke_tixian#keke_tixian')->delete($orderid);
		cpmsg(lang('plugin/keke_tixian', 'lang11'), 'action=plugins&operation=config&identifier=keke_tixian&pmod=admin_tx', 'succeed');
	}elseif($_GET['ac']=='tui'){
		if (submitcheck("forumset")) {
			$orderdata=C::t('#keke_tixian#keke_tixian')->fetchfirst_by_id($orderid);
			$yuanyin=daddslashes($_GET['yuanyin']);
			$arr=array('state'=>2,'endtime'=>$_G['timestamp'],'tuiyuanyin'=>$yuanyin);
			C::t('#keke_tixian#keke_tixian')->update($orderid,$arr);
			updatemembercount($orderdata['uid'], array('extcredits'.$orderdata['credittype']=>$orderdata['credit']), true, '', 0, '',lang('plugin/keke_tixian', 'lang12'),lang('plugin/keke_tixian', 'lang13').$orderid);
			cpmsg(lang('plugin/keke_tixian', 'lang14'), 'action=plugins&operation=config&identifier=keke_tixian&pmod=admin_tx&page='.intval($_GET['page']), 'succeed');
		}
		showformheader("plugins&operation=config&do=" . $plugin["pluginid"] . "&identifier=" . $plugin["identifier"] . "&pmod=admin_tx&ac=tui");
		showtableheader('');
		showsubtitle(array(lang('plugin/keke_tixian', 'lang56')));
		$table = array();
		$table[0] = '<input name="yuanyin" value="" style="width:200px"><input type="hidden" name="orderid" value="'.$orderid.'"><input type="hidden" name="page" value="'.intval($_GET['page']).'"> <font style="color:#666; margin-left:15px">'.lang('plugin/keke_tixian', 'lang57').'</font>';
		showtablerow('',array('width="100"'), $table);
		showsubmit('forumset', 'submit', '', '');
    	showtablefooter();
		exit();
		
	}
	
    showtableheader(lang('plugin/keke_tixian', 'lang15'));
    showsubtitle(array('ID', lang('plugin/keke_tixian', 'lang16'), lang('plugin/keke_tixian', 'lang17'),lang('plugin/keke_tixian', 'lang18'), lang('plugin/keke_tixian', 'lang19'),lang('plugin/keke_tixian', 'lang20'),lang('plugin/keke_tixian', 'lang21')));
	loadcache('keke_tixian');
	$creditdata=$_G['cache']['keke_tixian'] ? $_G['cache']['keke_tixian'] : $creditdata=C::t('#keke_tixian#keke_tixian_credit')->fetchall_credit();
	$ppp=30;
	$tmpurl='admin.php?action=plugins&operation=config&identifier=keke_tixian&pmod=admin_tx';
	$page = max(1, intval($_GET['page']));
	$startlimit = ($page - 1) * $ppp;
	$allcount = C::t('#keke_tixian#keke_tixian')->count_by_all();
	if($allcount){
		$query = C::t('#keke_tixian#keke_tixian')->fetch_all_by_all(0,0,$startlimit,$ppp);
		foreach($query as $val){
			$sxf=$creditdata[$val['credittype']]['sxf'];
			$bili=$creditdata[$val['credittype']]['bili'];
			$money=$val['credit']*(1-($sxf/100))*$bili;
			$money=round($money ,2);
			$money='<div style="width:100px;color:#c30;height:30px;line-height:30px;font-family:Microsoft YaHei; font-size:12px; font-weight:bold ">'.$money.' '.lang('plugin/keke_tixian', 'lang03').'</div><font color="#999">'.$val['credit'].$_G['setting']['extcredits'][$val['credittype']]['title'].' * '.(100-$sxf).lang('plugin/keke_tixian', 'lang22').$bili.lang('plugin/keke_tixian', 'lang23').$money.lang('plugin/keke_tixian', 'lang03').'</font>';
			$time=dgmdate($val['time'], 'Y/m/d H:i');
			$endtime='<font color="#999">'.dgmdate($val['endtime'], 'Y/m/d H:i').'</font>';
			$opurl=!$keke_tixian['deldd'] ? '<a href="admin.php?action=plugins&operation=config&identifier=keke_tixian&pmod=admin_tx&ac=del&orderid='.$val['id'].'&formhash='.FORMHASH.'" onClick="return confirm(\''.lang('plugin/keke_tixian', 'lang24').'\');">'.lang('plugin/keke_tixian', 'lang25').'</a>' : "<font color='#CCCCCC'>".lang('plugin/keke_tixian', 'lang25').'</font>';
			if($val['state']==1){
				$stat='<font color="#33CC33">'.lang('plugin/keke_tixian', 'lang26').'</font> / '.$endtime ;
			}elseif($val['state']==2){
				$stat='<font color="#666">'.lang('plugin/keke_tixian', 'lang27').'</font> / '.$endtime.'<p style="margin-top:3px; color:#F90;max-width:190px;"> '.$val['tuiyuanyin'].'</p>';
			}else{
				$stat='<font color="#FF3333">'.lang('plugin/keke_tixian', 'lang28').'</font>' ;
				$opurl='<a href="admin.php?action=plugins&operation=config&identifier=keke_tixian&pmod=admin_tx&ac=ok&orderid='.$val['id'].'&formhash='.FORMHASH.'" onClick="return confirm(\''.lang('plugin/keke_tixian', 'lang29').' \');">'.lang('plugin/keke_tixian', 'lang30').'</a> / <a href="admin.php?action=plugins&operation=config&identifier=keke_tixian&pmod=admin_tx&ac=tui&orderid='.$val['id'].'&formhash='.FORMHASH.'">'.lang('plugin/keke_tixian', 'lang32').'</a> / '.$opurl;
			}
			
			$table = array();
			$table[0] = $val['id'];
			$table[1] = '<a href="admin.php?frames=yes&action=logs&operation=credit&srch_uid='.$val['uid'].'&frame=yes" target="_blank">'.$val['usname'].'</a>';
			$table[2] = $money;
			$table[3] = $val['cardtype'].' <font color="#999">/</font> '.$val['cardon'] .' <font color="#999">/</font> '.$val['cardname'];
			$table[4] = $time;
			$table[5] = $stat;
			$table[6] = $opurl;
			showtablerow('',array(), $table);
		}
	}
	$multipage='';
	$multipage = multi($allcount, $ppp, $page, $_G['siteurl'].$tmpurl);
	echo '<tr class="hover"><td colspan="7">'.$multipage.'</td></tr>';
    showtablefooter();
