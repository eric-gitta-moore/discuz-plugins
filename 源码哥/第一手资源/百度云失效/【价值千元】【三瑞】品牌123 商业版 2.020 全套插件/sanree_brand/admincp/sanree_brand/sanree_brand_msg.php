<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_msg.php sanree $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('');
} 
$do= $_G['sr_do'];
$page = max(1, intval($_G['sr_page']));
if(!in_array($do, array('list', 'audit'))) {

	$do = 'list';
	
}

if ($do == 'audit') {
	
	$control = $_G['sr_control'];
	$controlarr = array('chuli', 'pass', 'refuse');
	if(!in_array($control, $controlarr)) {
	
		cpmsg($langs['notcontrol']);
		
	}	
	$type = intval($_G['sr_type']);
	$msgid = intval($_G['sr_msgid']);	
	$result = C::t('#sanree_brand#sanree_brand_msg')->getmsg_by_msgid($msgid);
	if(!$result) {
	
		cpmsg($langs['notmsgid']);
		
	}
	if ($control == 'chuli') {
	
	    if (submitcheck('chuli')) {
		
		    C::t('#sanree_brand#sanree_brand_msg')->update($msgid , array('refuse' => dhtmlspecialchars(trim($_G['sr_refuse'])), 'status' => intval(dhtmlspecialchars(trim($_G['sr_status']))), 'opdate' => TIMESTAMP));
			$welcomemsgtxt = $langs['chulijieguo'].dhtmlspecialchars(trim($_G['sr_refuse']));
			@notification_addex($result['uid'], 'system', $welcomemsgtxt, array(), 1);				
			cpmsg($langs['succeed'], $gotourl.'msg&type='.$type.'&page='.$_G['sr_page'], 'succeed');	
			
		}
		else {

			showsubmenu($menustr);	 
			showformheader($thisurl."&do=".$do."&msgid=".$msgid."&page=".$page.'&control='.$control.'&type='.$_G['sr_type'], 'enctype');
			showtableheader($langs['typeinfo1'], 'nobottom');
			showsubtitle(array($langs['error_brand'].': <span style="color:#FF0000;">'.$result['brandname'].'</span>'));	
			showsubtitle(array($langs['error_subject'].'<span style="color:#0000FF;">'.$result['words'].'</span>'));	
			showsetting($langs['yichuli'], 'status', $result['status'], 'radio');			
			showsetting($langs['error_result'], 'refuse', $result['refuse'], 'textarea');
			showsubmit('chuli', 'submit','','<input onclick="javascript:history.back()" class="btn" type="button" value="'.$langs['back'].'">');
			showtablefooter();
			showformfooter();
					
		}	
		
	}
	elseif ($control == 'pass') {
	
	    if (submitcheck('passsubmit')) {
		
		    C::t('#sanree_brand#sanree_brand_msg')->update($msgid , array('refuse' => dhtmlspecialchars(trim($_G['sr_refuse'])), 'status' => 1, 'opdate' => TIMESTAMP));
			C::t('#sanree_brand#sanree_brand_businesses')->update($result[bid], array('ownerid' => $result[uid], 'uid' => $result[uid]));
			fixthread($result[bid]);
			C::t('#sanree_brand#sanree_brand_album_category')->update_uid_by_bid($result[bid], $result[uid]);
			C::t('#sanree_brand#sanree_brand_album')->update_uid_by_bid($result[bid], $result[uid]);
			$welcomemsgtxt = $langs['renlingchenggong'].dhtmlspecialchars(trim($_G['sr_refuse']));
			@notification_addex($result['uid'], 'system', $welcomemsgtxt, array(), 1);				
			cpmsg($langs['succeed'], $gotourl.'msg&type='.$type.'&page='.$_G['sr_page'], 'succeed');	
			
		}
		else {
		
			showsubmenu($menustr);	 
			showformheader($thisurl."&do=".$do."&msgid=".$msgid."&page=".$page.'&control='.$control.'&type='.$_G['sr_type'], 'enctype');
			showtableheader('', 'nobottom');
			showsubtitle(array($langs['error_brand'].$result['brandname']));	
			showsubtitle(array($langs['error_subject'].$result['words']));	
			showsetting($langs['yichuli'], 'status', $result['status'], 'radio');
			showsetting($langs['error_result'], 'refuse', $result['refuse'], 'textarea');
			showsubmit('passsubmit', $langs['pass'],'','<input onclick="javascript:history.back()" class="btn" type="button" value="'.$langs['back'].'">');
			showtablefooter();
			showformfooter();
					
		}
		
	}
	elseif ($control=='refuse') {
	
	    if (submitcheck('refusesubmit')) {
		
		    C::t('#sanree_brand#sanree_brand_msg')->update($msgid , array('refuse' => dhtmlspecialchars(trim($_G['sr_refuse'])), 'status' => intval(dhtmlspecialchars(trim($_G['sr_status']))), 'opdate' => TIMESTAMP));
			$welcomemsgtxt = $langs['renlingjujue'].dhtmlspecialchars(trim($_G['sr_refuse']));
			@notification_addex($result['uid'], 'system', $welcomemsgtxt, array(), 1);				
			cpmsg($langs['succeed'], $gotourl.'msg&type='.$type.'&page='.$_G['sr_page'], 'succeed');	
			
		}
		else {
		
			showsubmenu($menustr);	 
			showformheader($thisurl."&do=".$do."&msgid=".$msgid."&page=".$page.'&control='.$control.'&type='.$_G['sr_type'], 'enctype');
			showtableheader('', 'nobottom');
			showsubtitle(array($langs['error_brand'].$result['brandname']));	
			showsubtitle(array($langs['error_subject'].$result['words']));	
			showsetting($langs['yichuli'], 'status', $result['status'], 'radio');				
			showsetting($langs['refusereason'], 'refuse', $result['refuse'], 'textarea');
			showsubmit('refusesubmit', $langs['refuse'],'','<input onclick="javascript:history.back()" class="btn" type="button" value="'.$langs['back'].'">');
			showtablefooter();
			showformfooter();
				
		}
		
	}

}
elseif ($do == 'list') {

	if(submitcheck('submit')) {
	
		if ($_G['sr_delete']) {
		
			C::t('#sanree_brand#sanree_brand_msg')->delete($_G['sr_delete']);
			
		}
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=$act&identifier=sanree_brand&pmod=admincp", 'succeed');
		
	}
	else {
	
		$type =  intval($_G['sr_type']);
		!in_array($type, array(1, 2, 3, 4)) && $type = 0;
		showsubmenu($menustr);
		showtableheader('', 'nobottom');
		$typeclass= array(0,1,2,3,4);
		showtablerow('', array(), array(shownavmenu($type, $typeclass, $langs)));
		showtablefooter();
		$marr = explode('|', $langs['typelist']);
		showformheader($thisurl);
		showtableheader($langs['typeinfo'.$type], 'nobottom');
		showsubtitle(array('', 'ID', $langs['type'], $langs['bid'], $langs['errorword'], $langs['postusername'], $langs['status'], $lang['time'], 'operation'));
		$perpage = 10;
		$orderby = $searchtext = $extra = '';
		$orderby= 'status,dateline desc';
		if (in_array($type, array(1, 2, 3 , 4))) {
		
			$searchtext= ' and typeid='.($type-1);
			$extra = '&type='.$type;
			
		}
		$page = max(1, intval($_G['sr_page']));
		$count = C::t('#sanree_brand#sanree_brand_msg')->count_by_where($searchtext);
		$msglist = C::t('#sanree_brand#sanree_brand_msg')->fetch_all_by_search($searchtext, $orderby, (($page - 1) * $perpage), $perpage);
		foreach($msglist as $msg) {
	
			$msg[status] = $msg[status]==1 ? $langs['yichuli'] : $langs['weichuli'];
			$uname = ($msg[uid] > 0) ? C::t('#sanree_brand#xcommon_member')->fetch_all_username_by_uid($msg[uid]) : $langs['guest'];
			$copymsg = $langs[copywordformat].dhtmlspecialchars($msg[words]);	
			$copymsg = str_replace('{uname}', $uname, $copymsg);
			$msg['type'] = $msg['typeid'];
			$msg['typeid'] = $msg['typeid'] + 1;
			$operation = '<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=msg&do=audit&control=chuli&identifier=sanree_brand&pmod=admincp&type='.$msg['typeid'].'&msgid='.$msg['msgid']."&page=".$_G['sr_page'].'\'">'.$langs['chuli'].'</a>'.
					'&nbsp;|&nbsp;<a href="###" onclick="copycode(\''.$copymsg.'\')">'.$langs['copyword'].'</a>';

			if ($msg['typeid']==2) {
			
				$operation = '<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=msg&do=audit&control=pass&identifier=sanree_brand&pmod=admincp&type=2&msgid='.$msg['msgid']."&page=".$_G['sr_page'].'\'">'.$langs['pass'].'</a>'.
					'&nbsp;|&nbsp;<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=msg&do=audit&control=refuse&identifier=sanree_brand&type=2&pmod=admincp&msgid='.$msg['msgid']."&page=".$_G['sr_page'].'\'">'.$langs['refuse'].'</a>';		
					
			}
			$msg[opdate] = $msg[opdate] ? dgmdate($msg[opdate]): '';		
			showtablerow('', array(), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$msg[msgid]]\" value=\"$msg[msgid]\">",
				$msg[msgid],
				$marr[$msg[type]],
				'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=businesseslist&do=upgrading&identifier=sanree_brand&pmod=admincp&bid='.$msg['bid'].'\'">'.$msg['bid'].'|'.$lang['edit'].'</a>',
				'<div title="'.dhtmlspecialchars($msg[words]).'" style="table-layout:fixed;width:230px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;word-wrap:nowrap">'.dhtmlspecialchars($msg[words]).'</div>
				<div title="'.$msg[refuse].'" style="table-layout:fixed;width:230px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;word-wrap:nowrap">',				
				'<a href="home.php?mod=space&amp;uid='.$msg[uid].'" target="_blank">'.$uname."</a>",
				$msg[status],
				dgmdate($msg[dateline]),
				$operation
	
			));
			
		}
		?>
		<script language="javascript">
		function copycode(code) {
			  window.clipboardData.setData("Text",code);
			  alert("<?php echo $langs['copysucceed']?>");
		}
		</script>	
		<?php
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=msg&identifier=sanree_brand&pmod=admincp$extra");
		showsubmit('submit', 'submit', 'del', '', $multipage);
		showtablefooter();
		showformfooter();	
		
	}
}	

function shownavmenu($type, $typeclass, $langs) {

	$result ='<ul class="tab1">';
	$typelist = array();
	$typelist[$type] = ' class="current"';
    foreach($typeclass as $key => $value) {
	
	    if ($key>0) {
		
			$searchtext= ' AND status<>1 AND typeid='.($key-1);
			
		} else {
		
			$searchtext= ' AND status<>1';
		
		}
		$ncount = C::t('#sanree_brand#sanree_brand_msg')->count_by_where($searchtext);	
		$result .='<li'.$typelist[$key].'><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=msg&identifier=sanree_brand&pmod=admincp&type='.$key.'"><span>'.$langs['typeinfo'.$key].'('.$ncount.')</span></a></li>';
		
	}
	$result.= '</ul>';
	return $result;
	
}
//From:www_YMG6_COM
?>