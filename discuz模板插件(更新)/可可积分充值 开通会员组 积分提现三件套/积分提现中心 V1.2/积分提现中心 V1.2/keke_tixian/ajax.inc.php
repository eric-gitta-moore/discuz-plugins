<?php

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

global $_G;
$keke_tixian = $_G['cache']['plugin']['keke_tixian'];
if(($_GET['formhash'] != $_G['formhash']) || !$_G['uid']) {
	exit('Access Denied');
}
$cardon=daddslashes(dhtmlspecialchars($_GET['cardon']));
$cardtype=daddslashes(dhtmlspecialchars($_GET['cardtype']));
$moneyQuantity=intval($_GET['moneyQuantity']);
$credittype=intval($_GET['credittype']);
if($_GET['ac']=="addcard"){
	$truename=daddslashes(dhtmlspecialchars($_GET['truename']));
	$bank=intval($_GET['bank']);
	$arr=array(
		'uid'=>$_G['uid'],
		'usname'=>utf2gbk($truename),
		'type'=>$cardtype,
		'bank'=>$bank,
		'cardon'=>$cardon,
	);
	$id=C::t('#keke_tixian#keke_tixian_card')->insert($arr);
	if($id){
		echo json_encode(array('err' =>''));
	}
}elseif($_GET['ac']=="del"){
	$cardid=intval($_GET['cardid']);
	$carddata=C::t('#keke_tixian#keke_tixian_card')->fetchfirst_by_id($cardid);
	if($carddata['uid']==$_G['uid']){
		C::t('#keke_tixian#keke_tixian_card')->delete($cardid);
		showmsg(0);
	}else{
		showmsg(1,lang('plugin/keke_tixian', 'lang33'));
		exit();
	}
}elseif($_GET['ac']=="add"){
	$cardname=daddslashes(dhtmlspecialchars($_GET['cardname']));
	$nowcredit = getuserprofile('extcredits'.$credittype);
	loadcache('keke_tixian');
	$creditdata=$_G['cache']['keke_tixian'] ? $_G['cache']['keke_tixian'] : $creditdata=C::t('#keke_tixian#keke_tixian_credit')->fetchall_credit();
	if(!$moneyQuantity){
		showmsg(1,lang('plugin/keke_tixian', 'lang35'));
		exit();
	}
	if(!$credittype){
		showmsg(1,lang('plugin/keke_tixian', 'lang36'));
		exit();
	}
	if($nowcredit<$moneyQuantity){
		showmsg(1,lang('plugin/keke_tixian', 'lang37'));
		exit();
	}
	if($moneyQuantity<$creditdata[$credittype]['min']){
		showmsg(1,lang('plugin/keke_tixian', 'lang38').$creditdata[$credittype]['min'].$_G['setting']['extcredits'][$credittype]['title']);
		exit();
	}
	if($creditdata[$credittype]['max'] && $moneyQuantity>$creditdata[$credittype]['max']){
		showmsg(1,lang('plugin/keke_tixian', 'lang39').$creditdata[$credittype]['max'].$_G['setting']['extcredits'][$credittype]['title']);
		exit();
	}
	
	$arr=array(
		'uid'=>$_G['uid'],
		'usname'=>$_G['username'],
		'money'=>$moneyQuantity*(1-$creditdata[$credittype]['sxf']/100)*$creditdata[$credittype]['bili'],
		'credit'=>$moneyQuantity,
		'credittype'=>$credittype,
		'cardtype'=>utf2gbk($cardtype),
		'cardon'=>$cardon,
		'cardname'=>utf2gbk($cardname),
		'time'=>$_G['timestamp'],
	);
	$id=C::t('#keke_tixian#keke_tixian')->insert($arr);
	updatemembercount($_G['uid'], array('extcredits'.$credittype=>-$moneyQuantity), true, '', 0, '',lang('plugin/keke_tixian', 'lang12'),lang('plugin/keke_tixian', 'lang40'));
	showmsg(0);
}elseif($_GET['ac']=="check"){
	$nowcredit = getuserprofile('extcredits'.$credittype);
	loadcache('keke_tixian');
	$creditdata=$_G['cache']['keke_tixian'] ? $_G['cache']['keke_tixian'] : $creditdata=C::t('#keke_tixian#keke_tixian_credit')->fetchall_credit();
	if($nowcredit<$moneyQuantity){
		showmsg(1,'<font color="#CC0000">'.lang('plugin/keke_tixian', 'lang41').$nowcredit.$_G['setting']['extcredits'][$credittype]['title'].'</font>');
	}elseif($moneyQuantity<$creditdata[$credittype]['min']){
		showmsg(1,'<font color="#CC0000">'.lang('plugin/keke_tixian', 'lang42').$creditdata[$credittype]['min'].$_G['setting']['extcredits'][$credittype]['title'].'</font>');
	}elseif($creditdata[$credittype]['max'] && $moneyQuantity>$creditdata[$credittype]['max']){
		showmsg(1,'<font color="#CC0000">'.lang('plugin/keke_tixian', 'lang43').$creditdata[$credittype]['max'].$_G['setting']['extcredits'][$credittype]['title'].'</font>');
	}else{
		$sxf=$creditdata[$credittype]['sxf'];
		$bili=$creditdata[$credittype]['bili'];
		$sxfs=round($moneyQuantity*($sxf/100)*$bili ,2);
		$money=round($moneyQuantity*(1-$sxf/100)*$bili ,2);
		showmsg(1,'<font color="#339900">'.lang('plugin/keke_tixian', 'lang45').$money.lang('plugin/keke_tixian', 'lang03').' , '.lang('plugin/keke_tixian', 'lang46').$sxfs.lang('plugin/keke_tixian', 'lang03').'</font>');
	}
	exit();
}

function showmsg($err,$msg=''){
	$msg=diconv($msg, CHARSET,'utf-8');
	$err=array('err'=>$err,'msg'=>$msg);
	echo json_encode($err);
}

function utf2gbk($data){
	$data=dhtmlspecialchars($data);
	$data1 = diconv($data,'utf-8','gbk');
	$data0 = diconv($data1,'gbk','utf-8');
	if($data0 == $data){$tmpstr = $data1;}else{$tmpstr = $data;}
	if(CHARSET=='gbk'){
		return $tmpstr;
	}else{
		return gbk2utf($data);
	}
}
function gbk2utf($data){
	$data1 = diconv($data,'utf-8','gbk');
	$data0 = diconv($data1,'gbk','utf-8');
	if($data0 == $data){$tmpstr = $data1;}else{$tmpstr = $data;}
	return diconv($tmpstr,'gbk','utf-8');
}
