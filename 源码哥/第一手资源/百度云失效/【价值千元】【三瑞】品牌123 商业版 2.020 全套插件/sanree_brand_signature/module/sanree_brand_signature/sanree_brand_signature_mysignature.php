<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_signature_mysignature.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('2014061214ZqZQfEgNZb||8228||1402027202');
}
if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}
$signature = C::t('#sanree_brand_signature#sanree_brand_signature')->fetch_first_by_uid($_G['uid']);
$brandlist='<select name="bid"><option value="0">'.signature_modlang('selected').'</option>';
$bids=array();
$bids[] = 0;
foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_search("AND uid=$_G[uid] AND status=1",'displayorder',0,1000) as $data) {

    if ($signature[bid]==$data[bid]) {
		$brandlist.='<option value="'.$data[bid].'" selected>'.$data[name].'</option>';
	
	} else {
		$brandlist.='<option value="'.$data[bid].'">'.$data[name].'</option>';
	}
	$bids[] = $data[bid];
	
}
$brandlist.='</select>';
if(submitcheck('postsubmit')) {

	$bid = intval($_G['sr_bid']);
	$allowshowsignature = intval($_G['sr_allowshowsignature']);
	if (!in_array($bid,$bids)) {
		showmessage(signature_modlang('errorby'));
	}
	if ($signature) {
		C::t('#sanree_brand_signature#sanree_brand_signature')->update($signature['signatureid'], array( 'bid'=> $bid, 'allowshowsignature'=> $allowshowsignature));
	} else {
		C::t('#sanree_brand_signature#sanree_brand_signature')->insert(array('uid'=>$_G['uid'], 'bid'=> $bid, 'allowshowsignature'=> $allowshowsignature));
	}
	$extra = array();
	$url_forward = 'plugin.php?id=sanree_brand_signature&mod=mysignature&view=list';
	$href = $url_forward;
	$href = str_replace("'", "\'", $href);	
	$url_forward = '';	
	$extra = array(
		'showdialog' => false,
		'extrajs' => "<script type=\"text/javascript\" reload=\"1\">///hideWindow('publisheddlg', 0, 1);\r\nsetTimeout(\"window.location.href ='".$href."';\", 3000);</script>"
	);
	showmessage(signature_modlang('chulisucceed'), $url_forward, array(), $extra);
			
} else {

	$view = $_G['sr_view'];
	$viewarray = array('list','show', 'chuli', 'delete');
	$view = !in_array($view, $viewarray) ? 'list' : $view;
	$actives[$view] = ' class="a"';
	$bcount[0] = C::t('#sanree_brand#sanree_brand_businesses')->count_by_wherec(array('t.uid='.$_G['uid'],'c.status=1','t.status=1'));
	$bcount[1] = C::t('#sanree_brand#sanree_brand_businesses')->count_by_wherec(array('t.uid='.$_G['uid'],'c.status=1','t.status=0'));
	$bcount[2] = C::t('#sanree_brand#sanree_brand_businesses')->count_by_wherec(array('t.uid='.$_G['uid'],'c.status=1','t.status=-1'));
	$bcount[3] = $bcount[0] + $bcount[1] +$bcount[2];
	$checkallowshowsignature[0] = intval($signature['allowshowsignature'])==1 ? ' checked="checked"' : '';
	$checkallowshowsignature[1] = intval($signature['allowshowsignature'])!=1 ? ' checked="checked"' : '';
	include templateEx($plugin['identifier'].':'.$template."/".$mod);
	
}
//From:www_YMG6_COM
?>