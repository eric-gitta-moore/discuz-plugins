<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_ajax.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}
if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}
$do = $_G['sr_do'];
$doarray = array('creatalbum', 'uploadpic', 'editpic', 'uploadpicbatch');
if (!in_array($do, $doarray)) {

	showmessage(srlang('unknowact'));
	
}
$bid = intval($_G['sr_bid']);
$brandresult = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bidanduid($_G['uid'], $bid);
if (!$brandresult) {

	showmessage(srlang('nobrand'));
	
}	
if ($brandresult['status']!=1) {
	showmessage(srlang('nostatus'));
}
chkbrandend($brandresult);
if ($do=='creatalbum') {
	if ($isalbum!=1) {
		showmessage(srlang('stopalbumtip'));
	}
	if ($brandresult[allowalbum]!=1) {
		showmessage(srlang('noallowalbum'));
	}
	
	$catid = intval($_G['sr_catid']);
	if(submitcheck('postsubmit')) {
	
		$catname=dhtmlspecialchars(trim($_G['sr_albumname']));
		if (empty($catname)) {
			showmessage(srlang('nocatname'));
		}
		$setarr = array();
		$setarr['catname'] = $catname;
		$setarr['description'] = dhtmlspecialchars(trim($_G['sr_description']));   
		$setarr['displayorder'] = intval(trim($_G['sr_displayorder']));
			
		if ($catid<1) {
		
			$searchtext = ' AND c.uid='.$_G[uid].' AND c.bid='.$bid;
		    $count = C::t('#sanree_brand#sanree_brand_album_category')->count_by_where($searchtext);
			$maxalbumcategory = getmaxalbumcategory($bid, $_G[uid]);
			if ($count >= $maxalbumcategory) {
				$msg = str_replace("{maxalbumcategory}", $maxalbumcategory, srlang('maxalbumcategorytip'));
			} else {

				$setarr['dateline'] = TIMESTAMP;
				$setarr['uid'] = $_G['uid'];
				$setarr['bid'] = $bid;		
				C::t('#sanree_brand#sanree_brand_album_category')->insert($setarr);
				$msg = srlang('creatalbumsucceed');

			}
			
		} else {
		
		    C::t('#sanree_brand#sanree_brand_album_category')->userupdate_by_catid($catid, $_G['uid'], $setarr);
			$msg = srlang('modiyalbumsucceed');
			
		}
		$extra = array();
		$url_forward = srreferer() ? $_G['referer'] : 'plugin.php?id=sanree_brand&mod=mybrand&view=myalbum&bid='.$bid;
		if ($_G['inajax']) {
	
			$href = $url_forward;
			$href = str_replace("'", "\'", $href);	
			$url_forward = '';	
			$extra = array(
				'showdialog' => true,
				'extrajs' => "<script type=\"text/javascript\" reload=\"1\">hideWindow('creatalbumdlg', 0, 1);setTimeout(\"window.location.href ='".$href."';\", 3000);</script>"
			);
			
		}
	    showmessage($msg,$url_forward, array(), $extra);
	}
	else {

		if ($catid>0) {
		    $htitle = srlang('editalbumname');
			$result  = C::t('#sanree_brand#sanree_brand_album_category')->userget_by_catid($catid, $_G['uid']);
			
		}
		else {
		    $htitle = srlang('creatalbum'); 
			$result['displayorder'] = 0;
		}

	}

}
elseif ($do=='uploadpicbatch') {

	if ($isalbum!=1) {
		showmessage(srlang('stopalbumtip'));
	}
	if ($brandresult['allowalbum']!=1) {
		showmessage(srlang('noallowalbum'));
	}
	$group = C::t('#sanree_brand#sanree_brand_group')->get_by_groupid($brandresult['groupid']);
	if (intval($group['allowbatchimage'])!=1) {
		showmessage(srlang('notallowbatchimage'));
	}
	$catid = $_G['fid'] = intval($_G['sr_catid']);
	$bid = intval($_G['sr_bid']);
	$albumcate = C::t('#sanree_brand#sanree_brand_album_category')->userget_by_catid($catid, $_G['uid']);
	if (!$albumcate) {
		showmessage(srlang('noalbumcatid'));
	}
	$maxattachsize_mb = $_G['group']['maxattachsize'] / 1048576 >= 1 ? round(($_G['group']['maxattachsize'] / 1048576), 1).'MB' : round(($_G['group']['maxattachsize'] / 1024)).'KB';
	$imgexts = 'jpg, jpeg, gif, png, bmp';
	$batch_upload_albumtitle = str_replace('{albumname}', $albumcate['catname'], srlang('batch_upload_albumtitle'));	
	$searchtext = " AND uid=$_G[uid] AND catid=".$catid;
	$count = C::t('#sanree_brand#sanree_brand_album')->count_by_where($searchtext);
	$maxalbum = getmaxalbumbycatid($catid,$_G['uid']);
	if ($maxalbum<0) $maxalbum = 0;	
	if ($count>=$maxalbum || $maxalbum==0) {
		$msg = str_replace("{maxalbum}", $maxalbum, srlang('maxalbumtip1'));
		showmessage($msg);
	}
	$maxpicnum = $maxalbum - $count;
		
}
elseif ($do=='uploadpic') {

	if ($isalbum!=1) {
		showmessage(srlang('stopalbumtip'));
	}
	if ($brandresult[allowalbum]!=1) {
		showmessage(srlang('noallowalbum'));
	}

	if(submitcheck('postsubmit')) {
	
	    $catid = intval($_G['sr_brandname']);
		if ($catid<1) {
			showmessage(srlang('error_alubumcate'));
		}
		$searchtext = " AND uid=$_G[uid] AND catid=".$catid;
		$count = C::t('#sanree_brand#sanree_brand_album')->count_by_where($searchtext);
        $maxalbum = getmaxalbumbycatid($catid,$_G[uid]);
		if ($count >= $maxalbum) {
			$msg = str_replace("{maxalbum}", $maxalbum, srlang('maxalbumtip'));
		} else  {
					
			$picdata = array();
			if($_FILES['Filedata']) {
				if ($_FILES['Filedata']['error']==0){
					if ($albumfilesize > 0) {
						if($_FILES['Filedata']['size'] > $albumfilesize * 1024) {
							showmessage(str_replace('{size}', $albumfilesize, srlang('error_maxpic')));
						}						
					}			
					$picdata = mypic_save($_FILES['Filedata'], $albumid);
				}
			}	
			if (empty($picdata['filepath'])) {
				showmessage(srlang('error_pictip'));
			}
			$setarr['pic'] = $picdata['filepath'];
			$setarr['albumname'] = empty($albumname) ? $picdata['filename'] : $albumname;
			$setarr['catid'] = $catid;
			$setarr['depict'] = dhtmlspecialchars(trim($_G['sr_depict']));
			$setarr['displayorder'] = intval(trim($_G['sr_displayorder']));
			$setarr['dateline'] = TIMESTAMP;
			$setarr['uid'] = $_G['uid'];
			$setarr['bid'] = $bid;
			$setarr['username'] = $_G['username'];					
			C::t('#sanree_brand#sanree_brand_album')->insert($setarr);
			fixalbumpic($catid, $setarr);
			$msg = srlang('uploadpicsucceed');
			
		}
		$extra = array();
		$url_forward = srreferer() ? $_G['referer'] : 'plugin.php?id=sanree_brand&mod=mybrand&view=myalbum&st=album&catid='.$catid.'&bid='.$bid;
		if ($_G['inajax']) {
	
			$href = $url_forward;
			$href = str_replace("'", "\'", $href);	
			$url_forward = '';	
			$extra = array(
				'showdialog' => false,
				'extrajs' => "<script type=\"text/javascript\" reload=\"1\">hideWindow('uploadpicdlg', 0, 1);\r\nsetTimeout(\"window.location.href ='".$href."';\", 3000);</script>"
			);
			
		}			
		showmessage($msg, $url_forward, array(), $extra);
	} else {
		$orderby = 'displayorder,dateline desc';
		$catid = intval($_G['sr_catid']);
		$where = array();
		$where[] = 'uid='.$_G['uid'];
		$where[] = 'bid='.$bid;
		$mybrandlist = C::t('#sanree_brand#sanree_brand_album_category')->fetch_all_by_searchd($where, $orderby);	
		$selectlist = array();
		$selectlist[] = array('bid'=>0, 'name'=> srlang('selectedalbumcate'), 'selected' => '');
		foreach($mybrandlist as $data) {
			$selectlist[] =array( 'bid'=> $data['catid'], 'name' => $data['catname'], 'selected' => '');
		}
		$imgexts = 'jpg, jpeg, gif, png, bmp';
	}
}
elseif ($do=='editpic') {
	if ($isalbum!=1) {
		showmessage(srlang('stopalbumtip'));
	}
	if ($brandresult[allowalbum]!=1) {
		showmessage(srlang('noallowalbum'));
	}

	$albumid = intval($_G['sr_albumid']);
	if(submitcheck('postsubmit')) {

		$setarr['albumname'] = dhtmlspecialchars(trim($_G['sr_albumname']));
		if (intval($_G['sr_istop'])==1) {
		
		    $data = C::t('#sanree_brand#sanree_brand_album')->get_by_albumid($albumid);
			C::t('#sanree_brand#sanree_brand_album_category')->update($data['catid'], array('pic' => $data['pic']));
			
		}
		C::t('#sanree_brand#sanree_brand_album')->userupdate($albumid, $_G['uid'], $setarr);
		$extra = array();
		$url_forward = srreferer() ? $_G['referer'] : 'plugin.php?id=sanree_brand&mod=mybrand&view=myalbum&st=album&catid='.$catid.'&bid='.$bid;
		if ($_G['inajax']) {
	
			$href = $url_forward;
			$href = str_replace("'", "\'", $href);	
			$url_forward = '';	
			$extra = array(
				'showdialog' => true,
				'extrajs' => "<script type=\"text/javascript\" reload=\"1\">hideWindow('editpic', 0, 1);setTimeout(\"window.location.href ='".$href."';\", 3000);</script>"
			);
			
		}			
		showmessage(srlang('modiypidsucceed'), $url_forward, array(), $extra);
		
	} else {
	
	    $result = C::t('#sanree_brand#sanree_brand_album')->userget_by_albumid($albumid, $_G['uid']);
		if (!$result) {
			showmessage(srlang('error_pic'));
		}
		
	}
}

include templateEx($plugin['identifier'].':'.$template.'/ajax');
?>