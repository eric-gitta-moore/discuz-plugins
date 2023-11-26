<?php
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if (!defined('CLOUDADDONS_WEBSITE_URL')) {
	require_once (libfile('function/cloudaddons'));
}
include_once (DISCUZ_ROOT.'source/plugin/keke_group/identity.inc.php');
$check = array();
$uskey = substr(md5('keke_group'.$_G['siteurl']), 0, 7);
loadcache($uskey);
$check = $_G['cache'][$uskey];
require_once (libfile('function/cache'));
$addonid = 'keke_group.plugin';
$array = cloudaddons_getmd5($addonid);
$comparison = md5($array['SN'].$array['RevisionID']);
if ((!$check['stylecache'] || ($check['time']+3600) < $_G['timestamp'])) {
	if (K_SITEKEY != $comparison) {
		//savecache($uskey, '');
		//exit('Access Denied (101)');
	}
	if (cloudaddons_opens('&mod=app&ac=validator&addonid='.$addonid.($array !== false ? '&rid='
		. $array['RevisionID'].'&sn='.$array['SN'].'&rd='.$array['RevisionDateline'] : '')) === '') {
		//savecache($uskey, '');
		//exit('Access Denied (102)');
	}
	else {
		$info['time'] = $_G['timestamp'];
		$info['stylecache'] = 1;
		savecache($uskey, $info);
	}
}
if (K_SITEKEY != $comparison) {
	//exit('Access Denied (103)');
}


function arrtoxml($data)
{
	$xml = '<xml>';
	foreach ($data as $key => $val) {
		if (is_numeric($val)) {
			$xml .= '<'.$key.'>'.$val.'</'.$key.'>';
		}
		else {
			$xml .= '<'.$key.'><![CDATA['.$val.']]></'.$key.'>';
		}
	}
	$xml .= '</xml>';
	return $xml;
}

function _orderid()
{
	global $_G;
	$nowdate = dgmdate($_G['timestamp'], 'YmdHis');
	$random = random(10);
	$orderid = $nowdate.$random;
	return $orderid;
}

function _getallgro()
{
	return C::t('#keke_group#keke_group')->fetchall_group();
}

function getbuygroupdata($buygorupid)
{
	return C::t('#keke_group#keke_group')->fetchfirst_bybuygorupid($buygorupid);
}

function _getusergroupopt($buygorupdata)
{
	C::t('common_usergroup')->fetch_all_by_type(array(
		0 => 'special'
	), 0);
	foreach (C::t('common_usergroup')->fetch_all_by_type(array(
		0 => 'special'
	), 0) as $keys => $value) {
		$selected = '';
		if ($buygorupdata['groupid'] == $value['groupid']) {
			$selected = 'selected';
		}
		$usergroups_options .= '<option value="'.$value['groupid'].'" '
			. $selected.'>'.$value['grouptitle'];
	}
	return $usergroups_options;
}

function _indexdata()
{
	$gorupdata = _getallgro();
	foreach ($gorupdata as $tk => $tv) {
		$gorupdata[$tk]['tequan'] = explode(',', $tv['tequan']);
		$gorupdata[$tk]['money'] = $tv['money']/100;
	}
	return $gorupdata;
}

function _buygroup($groupid, $days, $uids)
{
	global $_G;
	$keke_group = $_G['cache']['plugin']['keke_group'];
	$memberfieldforum = C::t('common_member_field_forum')->fetch($uids);
	$groupterms = dunserialize($memberfieldforum['groupterms']);
	unset($memberfieldforum);
	$extgroupidsarray = array();
	$extgroupids = $extgroupidsarray;
	$themembers = C::t('common_member')->fetch($uids);
	$extgroupids = ($themembers['extgroupids'] ? explode("\t", $themembers['extgroupids']) : array());
	require_once (libfile('function/forum'));
	array_unique(array_merge($extgroupids, array(
		0 => $groupid
	)));
	foreach (array_unique(array_merge($extgroupids, array(
		0 => $groupid
	))) as $extgroupid) {
		if ($extgroupid) {
			$extgroupidsarray[] = $extgroupid;
		}
	}
	$extgroupidsnew = implode("\t", $extgroupidsarray);
	if ($days) {
		$groupterms['ext'][$groupid] = ($groupterms['ext'][$groupid] > TIMESTAMP ? $groupterms['ext'][$groupid] : TIMESTAMP) + ($days*86400);
		$groupexpirynew = groupexpiry($groupterms);
		C::t('common_member')->update($uids, array(
			'groupexpiry' => $groupexpirynew,
			'extgroupids' => $extgroupidsnew
		));
		C::t('common_member_field_forum')->update($uids, array(
			'groupterms' => serialize($groupterms)
		));
	}
	else {
		C::t('common_member')->update($uids, array(
			'extgroupids' => $extgroupidsnew
		));
	}
	if ($keke_group['autogroup']) {
		$ret['sw'] = _switchgroup($groupid, $uids);
	}
	$ret['tims'] = $groupterms['ext'][$groupid];
	return $ret;
}

function _switchgroup($groupid, $uids)
{
	$groupid = intval($groupid);
	$extgroupidsarray = array();
	$extgroupids = $extgroupidsarray;
	$themembers = C::t('common_member')->fetch($uids);
	$extgroupids = ($themembers['extgroupids'] ? explode("\t", $themembers['extgroupids']) : array());
	$ret = array();
	$ret['state'] = 1;
	if (!in_array($groupid, $extgroupids)) {
		$ret['msg'] = lang('plugin/keke_group', 'lang05');
		$ret['state'] = 0;
		return $ret;
	}
	if ($themembers['groupid'] == 4 && $themembers['groupexpiry'] > 0) {
		$ret['msg'] = lang('plugin/keke_group', 'lang06');
		$ret['state'] = 0;
		return $ret;
	}
	$group = C::t('common_usergroup')->fetch($groupid);
	$memberfieldforum = C::t('common_member_field_forum')->fetch($uids);
	$groupterms = dunserialize($memberfieldforum['groupterms']);
	unset($memberfieldforum);
	$extgroupidsnew = $themembers['groupid'];
	$groupexpirynew = $groupterms['ext'][$groupid];
	foreach ($extgroupids as $extgroupid) {
		if ($extgroupid && $extgroupid != $groupid) {
			$extgroupidsnew .= "\t".$extgroupid;
		}
	}
	if ($themembers['adminid'] > 0 && $group['radminid'] > 0) {
		$newadminid = ($themembers['adminid'] < $group['radminid'] ? $themembers['adminid'] : $group['radminid']);
	}
	elseif ($themembers['adminid'] > 0){
		$newadminid = $themembers['adminid'];
	}
	else {
		$newadminid = $group['radminid'];
	}
	C::t('common_member')->update($uids, array(
		'groupid' => $groupid,
		'adminid' => $newadminid,
		'groupexpiry' => $groupexpirynew,
		'extgroupids' => $extgroupidsnew
	));
	return $ret;
}

function _upuserdata($out_trade_no, $sns, $opid = '')
{
	global $_G;
	$keke_group = $_G['cache']['plugin']['keke_group'];
	$orderdata = C::t('#keke_group#keke_group_orderlog')->fetch($out_trade_no);
	if (!$orderdata['state']) {
		$ret = _buygroup($orderdata['groupid'], $orderdata['groupvalidity'],
			$orderdata['uid']);
		$orderarr = array(
			'state' => 1,
			'zftime' => $_G['timestamp'],
			'sn' => $sns,
			'opid' => $opid,
			'groupinvalid' => $ret['tims']
		);
		C::t('#keke_group#keke_group_orderlog')->update($out_trade_no, $orderarr);
	}
}

function _getmygrouplist()
{
	global $_G;
	$gorupdata = _getallgro();
	foreach ($gorupdata as $tk => $tv) {
		$gorupdata[$tv['groupid']] = $tv;
	}
	$extgroupids = ($_G['member']['extgroupids'] ? explode("\t", $_G['member']['extgroupids']) : array());
	$memberfieldforum = C::t('common_member_field_forum')->fetch($_G['uid']);
	$groupterms = dunserialize($memberfieldforum['groupterms']);
	unset($memberfieldforum);
	$termsarray = array();
	$expirylist = $termsarray;
	$expgrouparray = $expirylist;
	if ((!empty($groupterms['ext']) && is_array($groupterms['ext']))) {
		$termsarray = $groupterms['ext'];
	}
	if ((!empty($groupterms['main']['time']) && (empty($termsarray[$_G['groupid']])
		|| $termsarray[$_G['groupid']] > $groupterm['main']['time']))) {
		$termsarray[$_G['groupid']] = $groupterms['main']['time'];
	}
	foreach ($termsarray as $expgroupid => $expiry) {
		if ($expiry <= TIMESTAMP) {
			$expgrouparray[] = $expgroupid;
		}
	}
	if (!empty($groupterms['ext'])) {
		foreach ($groupterms['ext'] as $extgroupid => $time) {
			$expirylist[$extgroupid] = array(
				'time' => dgmdate($time, 'd'),
				'type' => 'ext',
				'noswitch' => $time < TIMESTAMP
			);
		}
	}
	if (!empty($groupterms['main'])) {
		$expirylist[$_G['groupid']] = array(
			'time' => dgmdate($groupterms['main']['time'], 'd'),
			'type' => 'main'
		);
	}
	$groupids = array();
	foreach ($_G['cache']['usergroups'] as $groupid => $usergroup) {
		if (!empty($usergroup['pubtype'])) {
			$groupids[] = $groupid;
		}
	}
	$expiryids = array_keys($expirylist);
	if (!$expiryids && $_G['member']['groupexpiry']) {
		C::t('common_member')->update($_G['uid'], array(
			'groupexpiry' => 0
		));
	}
	$groupids = array_merge($extgroupids, $expiryids, $groupids);
	if ($groupids) {
		C::t('common_usergroup')->fetch_all($groupids);
		foreach (C::t('common_usergroup')->fetch_all($groupids) as $group) {
			$isexp = in_array($group['groupid'], $expgrouparray);
			$expirylist[$group['groupid']]['maingroup'] = ($group['type'] != 'special'
				|| $group['system'] == 'private') || $group['radminid'] > 0;
			$expirylist[$group['groupid']]['grouptitle'] = ($isexp ? '<s>'
				. $group['grouptitle'].'</s>' : $group['grouptitle']);
			if ($gorupdata[$group['groupid']]) {
				$expirylist[$group['groupid']]['ico'] = $gorupdata[$group['groupid']]['ico'];
			}
			$expirylist[$group['groupid']]['dateline'] = $groupterms['ext'][$group['groupid']];
		}
	}
	return $expirylist;
}

function _getnowgroup()
{
	global $_G;
	$allgroup = C::t('common_usergroup')->range();
	$nowgroup['title'] = $allgroup[$_G['groupid']]['grouptitle'];
	$time = lang('plugin/keke_group', 'lang07');
	$overdue = 0;
	if ($_G['member']['groupexpiry']) {
		$time = dgmdate($_G['member']['groupexpiry'], 'd');
		if ($_G['member']['groupexpiry'] < TIMESTAMP) {
			$overdue = 1;
		}
	}
	$nowgroup['time'] = $time;
	$nowgroup['overdue'] = $overdue;
	return $nowgroup;
}

function _sensms($text, $phone, $alitmpid)
{
	global $_G;
	$keke_group = $_G['cache']['plugin']['keke_group'];
	if (file_exists(DISCUZ_ROOT.'./source/plugin/keke_sms/sendsms.php')) {
		$alisign = dhtmlspecialchars(trim($keke_group['sign']));
		$alitmpid = dhtmlspecialchars(trim($alitmpid));
		;
		include_once (DISCUZ_ROOT.'./source/plugin/keke_sms/sendsms.php');
		error_reporting(0);
		$kekesmsapi = new kekesmsapi();
		$return = $kekesmsapi->kekesendsms($phone, $alisign, $text, $alitmpid,
			$keke_group['smschannel']);
	}
	return $return;// f r om  ww w.mo qu8.c om
}

function _grosms($credit = '', $money = '', $type = '', $name = '', $orderuid = '')
{
	global $_G;
	$keke_group = $_G['cache']['plugin']['keke_group'];
	$times = dgmdate($_G['timestamp'], 'Y-m-d H:i');
	$moneys = $money/100;
	$carditname = $_G['setting']['extcredits'][$type]['title'];
	if ($keke_group['smsa']) {
		$member_profile = C::t('common_member_profile')->fetch($orderuid);
		$phone = trim($member_profile['mobile']);
		if ($phone) {
			$text = array(
				'time' => $times,
				'credit' => $credit.$carditname,
				'money' => $moneys
			);
			$ret = _sensms($text, $phone, $keke_group['tmpa']);
		}
	}
	if ($keke_group['smsb']) {
		$adminphone = dhtmlspecialchars(trim($keke_group['adminphone']));
		if ($adminphone) {
			$admintext = array(
				'time' => $times,
				'credit' => $credit.$carditname,
				'money' => $moneys,
				'name' => $name
			);
			$ret = _sensms($admintext, $adminphone, $keke_group['tmpb']);
		}
	}
	return $ret;
}

function cloudaddons_opens($extra, $post = '', $timeout = 999)
{
	global $_G;
	require_once (DISCUZ_ROOT.'./source/discuz_version.php');
	$data = 'siteuniqueid='.rawurlencode(cloudaddons_getuniqueids()).'&siteurl='
		. rawurlencode($_G['siteurl']).'&sitever='.DISCUZ_VERSION.'/'.DISCUZ_RELEASE
		. '&sitecharset='.CHARSET.'&mysiteid='.$_G['setting']['my_siteid'];
	$param = 'data='.rawurlencode(base64_encode($data));
	$param .= '&md5hash='.substr(md5($data.TIMESTAMP), 8, 8).'&timestamp='
		. TIMESTAMP;
	return dfsockopen(CLOUDADDONS_DOWNLOAD_URL.'?'.$param.'&from=s'.$extra,
		0, $post, '', false, CLOUDADDONS_DOWNLOAD_IP, $timeout);
}

function cloudaddons_getuniqueids()
{
	global $_G;
	if (CLOUDADDONS_WEBSITE_URL == 'http://addon.discuz.com') {
		return ($_G['setting']['siteuniqueid'] ? $_G['setting']['siteuniqueid'] : C::t('common_setting')->fetch('siteuniqueid'));
	}
	if (!$_G['setting']['addon_uniqueid']) {
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
		$addonuniqueid = $chars[date('y') % 60].$chars[date('n')].$chars[date('j')]
			. $chars[date('G')].$chars[date('i')].$chars[date('s')].substr(md5($_G['clientip']
			. TIMESTAMP), 0, 4).random(6);
		C::t('common_setting')->update('addon_uniqueid', $addonuniqueid);
		require_once (libfile('function/cache'));
		updatecache('setting');
	}
	return $_G['setting']['addon_uniqueid'];
}

function _h5pay($money, $out_trade_no, $title)
{
	global $_G;
	$keke_group = $_G['cache']['plugin']['keke_group'];
	$userip = get_client_ip();
	$appid = trim($keke_group['wxappid']);
	$mch_id = trim($keke_group['wxmchid']);
	$key = trim($keke_group['wxshkey']);
	$nonce_str = createNoncestr();
	$body = $title;
	$total_fee = $money;
	$spbill_create_ip = $userip;
	$notify_url = $_G['siteurl'].'source/plugin/keke_group/paylib/notify_wx.inc.php';
	$trade_type = 'MWEB';
	$scene_info = '{"h5_info":{"type":"Wap","wap_url":"'.$_G['siteurl']
		. 'plugin.php?id=keke_group","wap_name":"$title"}}';
	$signA = 'appid='.$appid.'&attach='.$out_trade_no.'&body='.$body.'&mch_id='
		. $mch_id.'&nonce_str='.$nonce_str.'&notify_url='.$notify_url.'&out_trade_no='
		. $out_trade_no.'&scene_info='.$scene_info.'&spbill_create_ip='.$spbill_create_ip
		. '&total_fee='.$total_fee.'&trade_type='.$trade_type;
	$strSignTmp = $signA.'&key='.$key;
	$sign = strtoupper(MD5($strSignTmp));
	$post_data = "<xml>\r\n\t\t\t\t\t   <appid>".$appid."</appid>\r\n\t\t\t\t\t   <mch_id>"
		. $mch_id."</mch_id>\r\n\t\t\t\t\t   <body>".$body."</body>\r\n\t\t\t\t\t   <out_trade_no>"
		. $out_trade_no."</out_trade_no>\r\n\t\t\t\t\t   <total_fee>".$total_fee
		. "</total_fee>\r\n\t\t\t\t\t   <spbill_create_ip>".$spbill_create_ip
		. "</spbill_create_ip>\r\n\t\t\t\t\t   <notify_url>".$notify_url."</notify_url>\r\n\t\t\t\t\t   <trade_type>"
		. $trade_type."</trade_type>\r\n\t\t\t\t\t   <scene_info>".$scene_info
		. "</scene_info>\r\n\t\t\t\t\t   <attach>".$out_trade_no."</attach>\r\n\t\t\t\t\t   <nonce_str>"
		. $nonce_str."</nonce_str>\r\n\t\t\t\t\t   <sign>".$sign."</sign>\r\n\t\t\t\t   </xml>";
	$url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
	$dataxml = postXmlCurl($post_data, $url);
	$objectxml = (array)simplexml_load_string($dataxml, 'SimpleXMLElement',
		LIBXML_NOCDATA);
	$objectxml['mweb_url'] = $objectxml['mweb_url']._redurl($out_trade_no);
	return $objectxml;
}

function createNoncestr($length = 32)
{
	$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
	$str = '';
	$i = 0;
	while ($i < $length) {
		$str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);
		$i = $i+1;
	}
	return $str;
}
//ÎÊÌâº¯Êý
function postXmlCurl($xml, $url, $second = 30)
{
	if ((function_exists('curl_init') && function_exists('curl_exec'))) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);
		if ($data) {
			curl_close($ch);
			return $data;
		}
		$error = curl_errno($ch);
		curl_close($ch);
		return 'curl_err:'.$error.'<br>';
	}
	$matches = parse_url($url);
	$scheme = $matches['scheme'];
	$host = $matches['host'];
	$path = ($matches['path'] ? $matches['path'].($matches['query'] ? $matches['query'] : '') :'/');
	$contentLength = strlen($xml);
	$port = (!empty($matches['port']) ? $matches['port'] : ($scheme == 'http' ? 80 : ''));
	$fp = fsockopen($host, $port);
	fputs($fp, 'POST '.$path." HTTP/1.0\r\n");
	fputs($fp, 'Host: '.$host.':'.$port."\r\n");
	fputs($fp, "Content-Type: text/xml\r\n");
	fputs($fp, 'Content-Length: '.$contentLength."\r\n");
	fputs($fp, "Connection: close\r\n");
	fputs($fp, "\r\n");
	fputs($fp, $xml);
	$result = '';
	while (!feof($fp)) {
		$result .= fgets($fp, 128);
	}
	return $result;
} 

function get_client_ip($type = 0)
{
	if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'),
		'unknown')) {
		$ip = getenv('HTTP_CLIENT_IP');
	}
	elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'),
		'unknown')){
		$ip = getenv('HTTP_X_FORWARDED_FOR');
	}
	elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')){
		$ip = getenv('REMOTE_ADDR');
	}
	else {
		if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR']) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
	}
	return (preg_match('/[\d\.]{7,15}/', $ip, $matches) ? $matches[0] : '');
}

function _redurl($orderid)
{
	global $_G;
	$redirect_url = urlencode($_G['siteurl'].'plugin.php?id=keke_group&p=loading&orderid='
		. $orderid);
	$redirect_urls = '&redirect_url='.$redirect_url;
	return $redirect_urls;
}

function editor_safe_replace($content)
{
	$tags = array(
		0 => '\'<iframe[^>]*?>.*?</iframe>\'is',
		1 => '\'<frame[^>]*?>.*?</frame>\'is',
		2 => '\'<script[^>]*?>.*?</script>\'is',
		3 => '\'<head[^>]*?>.*?</head>\'is',
		4 => '\'<title[^>]*?>.*?</title>\'is',
		5 => '\'<meta[^>]*?>\'is',
		6 => '\'<link[^>]*?>\'is'
	);
	return preg_replace($tags, '', $content);
}

function _getqrcodeurl($urls)
{
	global $_G;
	$keke_group = $_G['cache']['plugin']['keke_group'];
	$src = ($keke_group['qr'] == 2 ? 'source/plugin/keke_group/paylib/wechat/example/qrcode.php?data='
		. urlencode($urls) : 'http://qr.liantu.com/api.php?&bg=ffffff&fg=000000&w=250&el=h&text='
		. urlencode($urls));
	return $src;
}

function _getmycount()
{
	global $_G;
	return C::t('#keke_group#keke_group_orderlog')->count_by_all($_G['uid'],
		1);
}

function _getmylist($startlimit, $ppp)
{
	global $_G;
	$query = C::t('#keke_group#keke_group_orderlog')->fetch_all_by_all($_G['uid'],
		1, $startlimit, $ppp);
	foreach ($query as $val) {
		$time = '';
		$validitys = $time;
		$money = $val['money']/100;
		$time = dgmdate($val['zftime'], 'Y/m/d H:i');
		$validitys = dgmdate($val['groupinvalid'], 'Y-m-d H:i');
		$icoid = ($val['type'] == 1 ? 'z' : 'w');
		$dates = '';
		$pcdate = '<b class="sx">|</b><b class="pcdate">'.lang('plugin/keke_group',
			'lang08').' :  <i class="yxz">'.$validitys.'</i></b>';
		if (checkmobile()) {
			$dates = '<div class="dow dows"><span>'.$val['groupvalidity']
				. ''.lang('plugin/keke_group', 'lang09').'&nbsp;&nbsp;</span>  '
				. lang('plugin/keke_group', 'lang08').' / <i class="yxz">'.$validitys
				. '</i></div>';
			$pcdate = '';
		}
		$list .= '<li><div class="pup"><span><img src="source/plugin/keke_group/template/images/'
			. $icoid.'.png"> '.$money.lang('plugin/keke_group', 'lang03').'</span> '
			. $val['groupname'].' <b style="color:#999; font-size:14px;font-weight:500"> / '
			. $val['groupvalidity'].lang('plugin/keke_group', 'lang09').' </b> </div><div class="dow"><span>'
			. $time.'</span>'.$val['sn'].$pcdate.'</div>'.$dates.'</li>';
	}
	return $list;// f rom  ww w.mo qu8.c om
}

function _getmyorder($pages)
{
	$ppp = 30;
	$tmpurl = 'plugin.php?id=keke_group&p=my';
	$page = max(1, intval($pages));
	$startlimit = ($page-1) * $ppp;
	$allcount = _getmycount();
	if ($allcount) {
		$list = _getmylist($startlimit, $ppp);
	}
	$multipage = '';
	$multipage = multi($allcount, $ppp, $page, $_G['siteurl'].$tmpurl);
	$ret['page'] = $multipage;
	$ret['list'] = $list;
	return $ret;
}

function _instorder($orderid, $money, $zftype, $buygroupid, $groupname, $groupvalidity)
{
	global $_G;
	$orderarr = array(
		'orderid' => $orderid,
		'uid' => $_G['uid'],
		'usname' => $_G['username'],
		'money' => $money,
		'type' => $zftype,
		'time' => $_G['timestamp'],
		'groupid' => $buygroupid,
		'groupname' => $groupname,
		'groupvalidity' => $groupvalidity
	);
	C::t('#keke_group#keke_group_orderlog')->insert($orderarr, true);
}

function groutf2gbk($data)
{
	$data = dhtmlspecialchars($data);
	$data1 = diconv($data, 'utf-8', 'gbk');
	$data0 = diconv($data1, 'gbk', 'utf-8');
	if ($data0 == $data) {
		$tmpstr = $data1;
	}
	else {
		$tmpstr = $data;
	}
	if (CHARSET == 'gbk') {
		return $tmpstr;
	}
	return grogbk2utf($data);
}

function grogbk2utf($data)
{
	$data1 = diconv($data, 'utf-8', 'gbk');
	$data0 = diconv($data1, 'gbk', 'utf-8');
	if ($data0 == $data) {
		$tmpstr = $data1;
	}
	else {
		$tmpstr = $data;
	}
	return diconv($tmpstr, 'gbk', 'utf-8');
}
 
