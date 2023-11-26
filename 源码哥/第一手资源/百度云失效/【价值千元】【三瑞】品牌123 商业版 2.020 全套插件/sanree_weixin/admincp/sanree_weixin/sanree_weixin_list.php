<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_weixin.php $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$do = $_G['sr_do'];
$doarray = array('list', 'upgrading', 'test');
$do = !in_array($do,$doarray) ? 'list' : $do;
$_G['sr_page'] = isset($_G['sr_page']) ? $_G['sr_page'] : 0;
if ($do == 'test') {
    $weixinid = intval($_G['sr_weixinid']);
	$result = C::t('#sanree_weixin#sanree_weixin')->get_by_weixinid($weixinid);	
	if (CHARSET=='utf-8') {
	
		define('C_CHARSET','_utf8');
		
	} else {
	
		define('C_CHARSET','');
		
	}
	if ($result) {
		require_once DISCUZ_ROOT.'/source/plugin/sanree_weixin/class/class_sanree_weixin.php';
		define('TOKEN', trim($config['token']));
		$chat = new wechatCallbackapi();
		$chat -> test($firstcmd.$result['cmd']);
	}
	
} elseif ($do == 'upgrading') {
    $weixinid = intval($_G['sr_weixinid']);
	if(submitcheck('addsubmit')){
	    $setarr = array();
	    $title = dhtmlspecialchars(trim($_G['sr_title']));
		if (empty($title)) {
			cpmsg_error($langs['error_weixintitle']);
		}		
		$cmd = strtolower(dhtmlspecialchars(trim($_G['sr_cmd'])));
		if (empty($cmd)) {
			cpmsg_error($langs['error_weixintitle']);
		}			
		preg_match("/[^a-z]/", $cmd, $matches);
		if (count($matches)>0) {
		
			cpmsg_error($langs['error_cmd_a_z']);
			
		}
		$setarr['typeid'] = intval(trim($_G['sr_typeid']));
		$setarr['title'] = $title;
		$setarr['cmd'] = $cmd;
		$setarr['uid'] = $_G['uid'];
		$setarr['content'] = dhtmlspecialchars(trim($_G['sr_content']));
		$setarr['status'] = intval(trim($_G['sr_status']));
		if ($weixinid) {
		
			$count=C::t('#sanree_weixin#sanree_weixin')->count_by_where(" AND cmd='$cmd' AND weixinid <> $weixinid");
			if ($count>0) {
			
				cpmsg_error($langs['error_cmd']);	
					
			}		
			C::t('#sanree_weixin#sanree_weixin')->update($weixinid, $setarr);
			
		} else {

			$count=C::t('#sanree_weixin#sanree_weixin')->count_by_where(" AND cmd='$cmd'");
			if ($count>0) {
			
				cpmsg_error($langs['error_cmd']);	
					
			}
		    $setarr['dateline'] = TIMESTAMP;
			$setarr['issys'] = 0;			 			
			C::t('#sanree_weixin#sanree_weixin')->insert($setarr);

		}	
		cpmsg($langs['succeed'], $gotourl.'list', 'succeed');				
	}
	else {
	    showsubmenu($menustr);	
	
		if($weixinid>0) {
		    $menustr = $langs['editweixin'];
		    $result = C::t('#sanree_weixin#sanree_weixin')->get_by_weixinid($weixinid);	
        }
		else {	
		    $menustr = $langs['addweixin'];
			$result['status'] = 1;
		}		
		showformheader($thisurl1."&do=".$do."&weixinid=".$weixinid."&page=".$page, 'enctype');
		showtableheader($menustr, 'nobottom');
		showsetting($langs['cmd'], 'cmd', $result['cmd'], 'text','','', $langs['error_cmd_a_z']);
		showsetting($langs['title'], 'title', $result['title'], 'text', '', '', $langs['bitian']);						
		showsetting($langs['type'], array('typeid', $weixincate), $result['typeid'], 'select');	
		showsetting($langs['content'], 'content', $result['content'], 'textarea');
		showsetting($langs['status'], 'status', $result['status'], 'radio');
		$result['dateline'] && showsetting($langs['dateline'], 'dateline', dgmdate($result[dateline]), 'text','1');
		showsubmit('addsubmit');
		showtablefooter();
		showformfooter();		
	}
} elseif ($do == 'list') {
	if(submitcheck('submit')){

		if($_G['sr_delete']) {
		
			C::t('#sanree_weixin#sanree_weixin')->delete($_G['sr_delete']);
			
		}	
		cpmsg($langs['succeed'], $gotourl.'weixin', 'succeed');	
		
	}
	else
	{	
		showsubmenu($menustr);

        echo $langs['helptipshow'];
		
		$skeyword = $_G['sr_skeyword'];
		showformheader($thisurl);
		showtableheader($langs['searchbar'], '', 'style="border:1px solid #F0F7FD"');
		showtablerow('', '', $langs['skeyword'].'<input type="text" name="skeyword" value="'.$skeyword.'" class="txt" style="width:200px;" /> <input type="submit" value="'.$langs['search'].'" class="btn" name="searchsubmit"/>');
		showtablefooter();
		showformfooter();
						
		showformheader($thisurl1);
		showtableheader($langs['weixin'], 'nobottom');
		showsubtitle(array('', 'ID', $langs['cmd'], $langs['title'], $langs['status'], $langs['type'],'operation'));
		$perpage = 10;
		$srchadd = $searchtext = $extra = $srchuid = '';
		$page = max(1, intval($_G['sr_page']));
		$orderby = 'weixinid  desc';
		
		if(!empty($skeyword)){
		
			$searchfield = array('title');
			$search = array();
			foreach($searchfield as $v) {
			
				$search[] = "(".$v." LIKE '%".$skeyword."%')";
				
			}
			$searchtext .= " AND (".implode(' OR ',$search).")";
			$extra = '&skeyword='.urlencode($skeyword);
		}
				
		$count = C::t('#sanree_weixin#sanree_weixin')->count_by_wherec($searchtext);
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_weixin&pmod=admincp$extra");	
		$datalist = C::t('#sanree_weixin#sanree_weixin')->fetch_all_by_searchc($searchtext,$orderby,(($page - 1) * $perpage),$perpage);
        $type = array();
		foreach($weixincate as $row) {
		   $type[$row[0]] = $row[1];
		}
		foreach($datalist as $value) {

            $statusstr = $value['status']==1 ? $langs['yes']:$langs['no'];
			$delst = $value['issys'] == 1 ? ' disabled="disabled"' : '';
			$operationstr = $value['issys'] == 1 ? '' : '<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=list&identifier=sanree_weixin&pmod=admincp&do=upgrading&weixinid='.$value['weixinid']."&page=".$page.'\'">'.$lang['edit'].'</a> | ';
			$operationstr .= '<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=list&identifier=sanree_weixin&pmod=admincp&do=test&weixinid='.$value['weixinid']."&page=".$page.'\'">'.$langs['test'].'</a>';
			
			showtablerow('', array(), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$value[weixinid]]\" value=\"$value[weixinid]\"$delst>",
				$value['weixinid'],
				$value['cmd'],
				$value['title'],				
				$statusstr,
				$type[$value['typeid']],
				$operationstr
			));
			
		}
		echo '<tr><td>&nbsp;</td><td colspan="7"><div><a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=list&identifier=sanree_weixin&pmod=admincp&do=upgrading\'" class="addtr">'.$langs['addweixin'].'</a></div></td></tr>';			
		showsubmit('submit', 'submit', 'del', '', $multipage, false);
		showtablefooter();
		showformfooter();
	}	
}
//From:www_YMG6_COM
?>