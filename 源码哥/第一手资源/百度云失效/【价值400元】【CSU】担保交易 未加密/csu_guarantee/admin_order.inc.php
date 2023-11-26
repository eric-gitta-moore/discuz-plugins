<?php
/*
Author:·Ö.Ïí.°É
Website:www.fx8.cc
Qq:154-6069-14
*/
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$lang = lang('plugin/csu_guarantee');
$pluginid = DB::fetch_first("SELECT pluginid FROM ".DB::table('common_plugin')." WHERE identifier='csu_guarantee'");
$pluginid = $pluginid['pluginid'];
$rs = DB::fetch_all("SELECT * FROM ".DB::table('common_pluginvar')." WHERE pluginid=$pluginid");
foreach($rs as $set){
	$var[$set['variable']] = $set['value'];
}
if(submitcheck('changestatus')){
	$_GET = daddslashes($_GET);
	$update = DB::update('csu_guarantee',array('status'=>$_GET['status']),array('id'=>$_GET['gid']));
	cpmsg($lang['0'],dreferer());
}
showtableheader();
showformheader('plugins&operation=config&identifier=csu_guarantee&pmod=admin_order');
showtablerow('class="hover"',array('class="td31"'),array($lang['1'],'<input name="searchid" value="'.$_GET['searchid'].'" class="txt">'));
showsubmit('search');
showformfooter();
showtablefooter();
function bas($order){
	if($order['trade_type']==1){
		$r['sell'] = getuserbyuid($order['uid']);
		$r['buy'] = getuserbyuid($order['other_side']);
		$r['sellinfo'] = is_array($order['contact']) ? $order['contact'] : unserialize($order['contact']);
		$r['buyinfo'] = is_array($order['other_contact']) ? $order['other_contact'] : unserialize($order['other_contact']);
	}elseif($order['trade_type']==2){
		$r['buy'] = getuserbyuid($order['uid']);
		$r['sell'] = getuserbyuid($order['other_side']);
		$r['buyinfo'] = is_array($order['contact']) ? $order['contact'] : unserialize($order['contact']);
		$r['sellinfo'] = is_array($order['other_contact']) ? $order['other_contact'] : unserialize($order['other_contact']);
	}
	return $r;
}
function dealprice($order){
	global $var;
	if($order['deduct_type'] == 1){
		if($order['price'] > 100) {
			$r['amount'] = $order['price'];
			$r['gains'] = $order['price'] - $order['price'] * $var['sale'] / 100;
		} else {
			$r['gains'] = $order['price']- $var['min'];
		}
	}elseif($order['deduct_type'] == 2){
		if($order['price'] > 100) {
			$r['amount'] = $order['price'] + $order['price'] * $var['sale'] / 100;
		} else {
			$r['amount'] = $order['price']+$var['min'];
		}
		$r['gains'] = $order['price'];
	}else{
		if($order['price'] > 100) {
			$r['amount'] = $order['price'] + $order['price'] * $var['sale'] / 200;
			$r['gains'] = $order['price'] - $order['price'] * $var['sale'] / 200;
		} else {
			$r['gains'] = $order['price']-$var['min'] / 2;
			$r['amount'] = $order['price']+$var['min'] / 2;
		}
	}
	return $r;
}
function status($order,$type=1){
	global $lang;
	if($type==1){
		switch ($order['status']) {
			case 0:
				return $lang['2'];
				break;
			case 1:
				return $lang['3'];
				break;
			case 2:
				return $lang['4'];
				break;
			case 3:
				return $lang['5'];
				break;
			case 4:
				return $lang['6'];
				break;
			case 5:
				return $lang['7'];
				break;
			case 6:
				return $lang['8'];
				break;
			case 7:
				return $lang['9'];
				break;
		}
	}elseif($type==2){
		$i = 0;
		$r = '<select name="status" id="status">.';
		foreach(array($lang['2'],$lang['3'],$lang['4'],$lang['5'],$lang['6'],$lang['7'],$lang['8'],$lang['9'])as $key){
			$r .= $order['status'] == $i ? '<option value="'.$i.'" selected="selected">'.$key.'</option>' : '<option value="'.$i.'">'.$key.'</option>';
			$i++;
		}
		$r .= '</select>';
		return $r;
	}
}
function moldval($val){
	global $var;
	$type = explode("\r\n",$var['type']);
	$i = 1;
	foreach ($type as $types){
		if($val==$i){
			return $types;
		}
		$i++;
	}
}
if($_GET['op']=='detail'&&$_GET['gid']){
	$order = DB::fetch_first("SELECT * FROM ".DB::table('csu_guarantee')." WHERE id=".$_GET['gid']);
	showtableheader(!empty($order) ? $lang[10]." <a href=\"plugin.php?id=csu_guarantee&item=detail&gid={$order[id]}\" target=\"_blank\">".$lang[11]."</a>" : $lang[12]);
	$start = getuserbyuid($order['uid']);
	$other = getuserbyuid($order['other_side']);
	$bas = bas($order);
	$status = status($order);
	$price = dealprice($order);
	$send = unserialize($order['send']);
	showformheader(substr($_SERVER['QUERY_STRING'],7));
	showtablerow('class="hover"',array('class="td31"'),array($lang[13],$lang[14],$lang[15],$lang[16],$lang[17],$lang[18],$lang[19],$lang[20],$lang[21]));
	showtablerow('class="hover"',array('class="td31"'),array("<a href = \"plugin.php?id=csu_guarantee&item=detail&gid={$order[id]}\" target=\"_blank\" >{$order[id]}</a>","<a href=\"home.php?mod=space&uid={$order[uid]}\" target=\"_blank\" >".$start['username']."</a>","<a href=\"home.php?mod=space&uid={$order[other_side]}\" target=\"_blank\" >".$other['username']."</a>",status($order,2),$order['price'],$price['amount'],moldval($order['mold']),$send['send'],$send['sendid']));
	showsubmit('changestatus');
	showformfooter();
	showtablefooter();
	showtableheader($lang[22]);
	showtablerow('class="hover"',array('class="td31"'),array($lang[24],$lang[25],$lang[26],'QQ',$lang[27]));
	showtablerow('class="hover"',array('class="td31"'),array($bas['buy']['username'],$bas['buyinfo']['name'],$bas['buyinfo']['mobile'],$bas['buyinfo']['qq'],$bas['buyinfo']['address']));
	showtablefooter();
	showtableheader($lang[23]);
	showtablerow('class="hover"',array('class="td31"'),array($lang[24],$lang[25],$lang[28],$lang[29],$lang[26],'QQ'));
	showtablerow('class="hover"',array('class="td31"'),array($bas['sell']['username'],$bas['sellinfo']['bank_username'],$bas['sellinfo']['bank_name'],$bas['sellinfo']['bank_idnum'],$bas['sellinfo']['mobile'],$bas['sellinfo']['qq']));
	showtablefooter();
}else{
	$sql = "SELECT * FROM ".DB::table('csu_guarantee');
	if(submitcheck('search')) $sql .= !empty($_GET['searchid']) ? ' WHERE uid='.$_GET['searchid'].' OR other_side='.$_GET['searchid'] : '';
	$sql .= " order by id DESC" ;
	$all = DB::fetch_all($sql);
	showtableheader(!empty($all) ? $lang[30].count($all).$lang[31] : $lang[32]);
	showtablerow('class="hover"',array('class="td31"'),array($lang[13],$lang[19],$lang[14],$lang[15],$lang[33],$lang[34],$lang[28],$lang[29],$lang[16],$lang[17],$lang[18],$lang[35]));
	foreach($all as $order){
		$start = getuserbyuid($order['uid']);
		$other = getuserbyuid($order['other_side']);
		$bas = bas($order);
		$status = status($order);
		$price = dealprice($order);
		showtablerow('class="hover"',array('class="td31"'),array("<a href = \"plugin.php?id=csu_guarantee&item=detail&gid={$order[id]}\" target=\"_blank\" >{$order[id]}</a>",moldval($order['mold']),"<a href=\"home.php?mod=space&uid={$order[uid]}\" target=\"_blank\" >".$start['username']."</a>","<a href=\"home.php?mod=space&uid={$order[other_side]}\" target=\"_blank\" >".$other['username']."</a>",$bas['buyinfo']['name'],$bas['sellinfo']['bank_username'],$bas['sellinfo']['bank_name'],$bas['sellinfo']['bank_idnum'],$status,$order['price'],$price['amount'],"<a href = \"".ADMINSCRIPT."?action=plugins&operation=config&identifier=csu_guarantee&pmod=admin_order&op=detail&gid={$order[id]}\" >".$lang[35]."</a>"));
	}
	showtablefooter();
}
//WWW.fx8.cc
?>
