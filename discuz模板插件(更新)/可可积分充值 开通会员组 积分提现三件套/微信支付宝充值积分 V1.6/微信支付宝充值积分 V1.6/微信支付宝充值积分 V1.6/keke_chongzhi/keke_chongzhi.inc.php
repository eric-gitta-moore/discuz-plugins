<?php
/*
 
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

	global $_G;
	$keke_chongzhi = $_G['cache']['plugin']['keke_chongzhi'];
	if(!$_G['uid']) {
		showmessage('not_loggedin', NULL, array(), array('login' => 1));
	}
	$title=dhtmlspecialchars($keke_chongzhi['title']);
	loadcache('keke_chongzhi_credit');
	$creditdata=$_G['cache']['keke_chongzhi_credit'] ? $_G['cache']['keke_chongzhi_credit'] : C::t('#keke_chongzhi#keke_chongzhi_credit')->fetchall_credit();
	
	$allmoneys=C::t('#keke_chongzhi#keke_chongzhi_orderlog')->sum_by_uid($_G['uid']);
	$allmoney=$allmoneys/100;
	$allmoney =number_format($allmoney, 2);
	$alipayoff=empty($keke_chongzhi['alipaypid']) || empty($keke_chongzhi['alipaykey']) ? 0 : 1;
	$wxpayoff=empty($keke_chongzhi['wxappid']) || empty($keke_chongzhi['wxsecert']) || empty($keke_chongzhi['wxmchid']) || empty($keke_chongzhi['wxshkey']) ? 0 : 1;
	$ys=$keke_chongzhi['ys']? dhtmlspecialchars($keke_chongzhi['ys']) : '#e14546';
	if((strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false && !$_GET['p']) && $wxpayoff){
		include_once libfile('function/cache');
		include_once DISCUZ_ROOT."source/plugin/keke_chongzhi/inc.php";
		$tools = new JsApiPay();
		$openId = $tools->GetOpenid();
		dsetcookie($uskey, authcode($openId, 'ENCODE', $_G['config']['security']['authkey']), 8640000);
	}
	if($_GET['p']=='my'){
		$ppp=$keke_chongzhi['pgt'] ? intval($keke_chongzhi['pgt']) : 30;
		$tmpurl='plugin.php?id=keke_chongzhi&p=my';
		$page = max(1, intval($_GET['page']));
		$startlimit = ($page - 1) * $ppp;
		$allcount = C::t('#keke_chongzhi#keke_chongzhi_orderlog')->count_by_all($_G['uid'],1);
		if($allcount){
			$query = C::t('#keke_chongzhi#keke_chongzhi_orderlog')->fetch_all_by_all($_G['uid'],1,$startlimit,$ppp);
			foreach($query as $val){
				$money=$val['money']/100;
				$time=dgmdate($val['zftime'], 'Y/m/d H:i');
				$cradit=intval($val['credit']);
				$creditname=$_G['setting']['extcredits'][$val['credittype']]['title'];
				$list.='<li><div class="pup"><span>-'.$money.lang('plugin/keke_chongzhi', 'lang03').'</span>'.lang('plugin/keke_chongzhi', 'lang06').' '.$cradit.' '.$creditname.'</div><div class="dow"><span>'.$time.'</span>'.$val['sn'].'</div></li>';
			}
		}
		$multipage='';
		$multipage = multi($allcount, $ppp, $page, $_G['siteurl'].$tmpurl);
		$n=0;
		foreach($creditdata as $creditid=>$v){
			if($v['state']){
				if(!$n){
					$firstcreditname=$_G['setting']['extcredits'][$creditid]['title'];
					$firstnowcredit = getuserprofile('extcredits'.$creditid);
					$n++;
				}
			}
		}
	}else{
		$preset=array();
		$zuidi=floatval($keke_chongzhi['zuidi']);
		$returnurl=$keke_chongzhi['tz']? $keke_chongzhi['tz'] : 'plugin.php?id=keke_chongzhi&p=my';
		$n=0;$zfbonwx=1;
		$creditdata_desc=$creditdata;
		$flag = array();  
		foreach($creditdata as $v){  
			$flag[] = $v['shunxu'];  
		}  
		array_multisort($flag, SORT_DESC, $creditdata_desc);  
		foreach($creditdata_desc as $creditid=>$v){
			if($v['state']){
				$check='';
				if(!$n){
					$firstcreditid=$v['creditid'];
					$firstcreditname=$_G['setting']['extcredits'][$v['creditid']]['title'];
					$firstnowcredit = getuserprofile('extcredits'.$v['creditid']);
					$check=$keke_chongzhi['mrcredit'] ? 'checked="true"' : '';
				}
				$nowcredit = getuserprofile('extcredits'.$v['creditid']);
				$credittype.='<div class="credittype"><input type="radio" name="credittype" data-now="'.$nowcredit.'" data-bili='.$v['bili'].' data-creditname="'.$_G['setting']['extcredits'][$v['creditid']]['title'].'" value="'.$v['creditid'].'" '.$check.' ><label><i></i><span class="creditname">'.$_G['setting']['extcredits'][$v['creditid']]['title'].'</span></label></div>';
				$n++;
			}
		}
		$keke_chongzhi['sm']=dhtmlspecialchars($keke_chongzhi['sm']);
		$bl=intval($creditdata[$firstcreditid]['bili']);
		$preset=explode(",",$keke_chongzhi['yz']);
		foreach($preset as $key=>$val){
			$val=floatval($val);
			$viewmoney=number_format($val,2);
			$credit=$bl*$val;
			$sty= $key ? '' : 'class="on"';
			$preval.='<li '.$sty.' money="'.$val.'"><span>'.$credit.$firstcreditname.'</span><h4>&yen;'.$viewmoney.' </h4></li>';
		}
		if((strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) && !$keke_chongzhi['zfbonwx']){
			$zfbonwx=0;
		}
		
	}
	
	include template('keke_chongzhi:index'); 