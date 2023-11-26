<?php
/*
 * 出处：源码哥
 * 官网: Www.fx8.cc
 * 备用网址: www.ymg6.com (请收藏备用!)
 * 技术支持/更新维护：QQ 154606914
 * 
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Deined');
}
$lang = lang('plugin/csu_guarantee');
function account(){
	global $var;
	$rem_1 = explode("\r\n",$var['account']);
	foreach ($rem_1 as $rem_2){
		$rem_3 = array();
		$rem_3 = explode("|",$rem_2);
		echo '<li><span class="ab"><img src="'.$rem_3['0'].'" /></span>   <span class="aa"><a href="'.$rem_3['2'].'" target="_blank" >'.$rem_3['1'].'</a></span> <span class="af" >'.$rem_3['3'].'</span> <span class="ae">'.$rem_3['4'].'</span> <span class="ae">'.$rem_3['5'].'</span></li>';
	}
}
function leftmenus($setting){
	foreach($setting as $key=>$sets){
		echo $key==$_GET['item'] ? "<li class=\"home\">" : "<li>";
		echo $_GET['item']=='detail' ? "<a href=\"plugin.php?id=csu_guarantee&item=".$key."&gid=".$_GET['gid']."\"><strong>".$sets."</strong></a></li>" : "<a href=\"plugin.php?id=csu_guarantee&item=".$key."\"><strong>".$sets."</strong></a></li>";
	}
}
function mold(){
	global $var;
	$type = explode("\r\n",$var['type']);
	$i = 1;
	foreach ($type as $types){
		echo '<input type="radio" name="mold" onclick="get_amount()" value="'.$i.'" />'.$types;
		$i++;
	}
}
function dealprice($price,$deduct_type){
	global $var;
	if($deduct_type == 1){
		if($price > 100) {
			$r['amount'] = $price;
			$r['gains'] = $price - $price * $var['sale'] / 100;
		} else {
			$r['gains'] = $price- $var['min'];
		}
	}elseif($deduct_type == 2){
		if($price > 100) {
			$r['amount'] = $price + $price * $var['sale'] / 100;
		} else {
			$r['amount'] = $price+$var['min'];
		}
		$r['gains'] = $price;
	}else{
		if($price > 100) {
			$r['amount'] = $price + $price * $var['sale'] / 200;
			$r['gains'] = $price - $price * $var['sale'] / 200;
		} else {
			$r['gains'] = $price-$var['min'] / 2;
			$r['amount'] = $price+$var['min'] / 2;
		}
	}
	return $r;
}
function getorder($sql){
	$rs = DB::fetch_first("SELECT * FROM ".DB::table('csu_guarantee')." ".$sql);
	if(!empty($rs)) {
		$re = array();
		$re = $rs;
		unset($re['contact']);
		unset($re['other_contact']);
		$re['contact'] = unserialize($rs['contact']);
		$re['other_contact'] = unserialize($rs['other_contact']);
		$re['send'] = unserialize($rs['send']);
		$re['reply'] = unserialize($rs['reply']);
		$se[] = $re;
		return $se;
	}
	else return false;
}
function getorders($sql){
	$rs = DB::fetch_all("SELECT * FROM ".DB::table('csu_guarantee')." ".$sql);
	if(!empty($rs)) {
		foreach ($rs as $rss){
			$re = array();
			$re = $rss;
			unset($re['contact']);
			unset($re['other_contact']);
			$re['contact'] = unserialize($rss['contact']);
			$re['other_contact'] = unserialize($rss['other_contact']);
			$re['send'] = unserialize($rss['send']);
			$re['reply'] = unserialize($rss['reply']);
			$se[] = $re;
		}
		return $se;
	}
	else return false;
}
function orderop($order){
	global $_G,$lang;
	switch ($order['status']) {
		case 0:
			return $lang[41];
			break;
		case 1:
			if($_G['uid']==$order['uid']) return '<font color="red">'.$lang[42].'</font>';
			elseif($_G['uid']==$order['other_side']) return '<div id="bottonA" style="width:92px;height:32px"  onclick="showWindow(\'csu_guarantee_status\', \'plugin.php?id=csu_guarantee:op&status=2&gid='.$order['id'].'\');return false;">'.$lang[43].'</div>';
			break;
		case 2:
			return $lang[44];
			break;
		case 3:
			if($order['trade_type']==1){
				if($_G['uid']==$order['uid']) return '<div id="bottonA" style="width:92px;height:32px"  onclick="showWindow(\'csu_guarantee_status\', \'plugin.php?id=csu_guarantee:op&status=4&gid='.$order['id'].'\');return false;">'.$lang[45].'</div>';
				elseif($_G['uid']==$order['other_side']) return $lang[46];
			}elseif($order['trade_type']==2){
				if($_G['uid']==$order['uid']) return $lang[46];
				elseif($_G['uid']==$order['other_side']) return '<div id="bottonA" style="width:92px;height:32px"  onclick="showWindow(\'csu_guarantee_status\', \'plugin.php?id=csu_guarantee:op&status=4&gid='.$order['id'].'\');return false;">'.$lang[45].'</div>';
			}
			break;
		case 4:
			if($order['trade_type']==1){
				if($_G['uid']==$order['uid']) return $lang[47];
				elseif($_G['uid']==$order['other_side']) return '<div id="bottonA" style="width:92px;height:32px"  onclick="showWindow(\'csu_guarantee_status\', \'plugin.php?id=csu_guarantee:op&status=5&gid='.$order['id'].'\');return false;">'.$lang[48].'</div>';
			}elseif($order['trade_type']==2){
				if($_G['uid']==$order['uid']) return '<div id="bottonA" style="width:92px;height:32px"  onclick="showWindow(\'csu_guarantee_status\', \'plugin.php?id=csu_guarantee:op&status=5&gid='.$order['id'].'\');return false;">'.$lang[48].'</div>';
				elseif($_G['uid']==$order['other_side']) return $lang[47];
			}
			break;
		case 5:
			return $lang[49];
			break;
		case 6:
			return $lang[50];
			break;
		case 7:
			return $lang[51];
			break;
	}
}
function nextop($order){
	global $_G,$lang;
	switch ($order['status']) {
		case 0:
			return $lang[41];
			break;
		case 1:
			if($_G['uid']==$order['uid']) return '<font color="red">'.$lang[52].'</font><div id="bottonA" style="width:92px;height:32px"  onclick="showWindow(\'csu_guarantee_status\', \'plugin.php?id=csu_guarantee:op&status=0&gid='.$order['id'].'\');return false;">'.$lang[53].'</div>';
			elseif($_G['uid']==$order['other_side']) return '<font color="red">'.$lang[52].'</font>';
			break;
		case 2:
			return '<font color="red">'.$lang[54].'</font>';
			break;
		case 3:
			if($order['trade_type']==1){
				if($_G['uid']==$order['uid']) return '<font color="red">'.$lang[55].'</font>';
				elseif($_G['uid']==$order['other_side']) return '<font color="red">'.$lang[56].'</font>';
			}elseif($order['trade_type']==2){
				if($_G['uid']==$order['uid']) return '<font color="red">'.$lang[56].'</font>';
				elseif($_G['uid']==$order['other_side']) return '<font color="red">'.$lang[55].'</font>';
			}
			break;
		case 4:
			return '<font color="red">'.$lang[47].'</font><div id="bottonA" style="width:92px;height:32px"  onclick="showWindow(\'csu_guarantee_status\', \'plugin.php?id=csu_guarantee:op&status=6&gid='.$order['id'].'\');return false;">'.$lang[57].'</div>';
			break;
		case 5:
			return '<font color="red">'.$lang[49].'</font>';
			break;
		case 6:
			return '<font color="red">'.$lang[50].'</font>';
			break;
		case 7:
			return '<font color="red">'.$lang[51].'</font>';
			break;
	}
}
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
//WWW.fx8.cc
?>