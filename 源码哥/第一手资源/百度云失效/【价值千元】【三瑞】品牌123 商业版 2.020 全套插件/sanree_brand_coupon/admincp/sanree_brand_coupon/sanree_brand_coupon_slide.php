<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_coupon_slide.php $
 */
 
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

if(submitcheck('submit')){

	$setarr = array();
	$tmpstr='';
	for($j=1;$j<6;$j++) {
	
		if($_FILES['pic'.$j]) {
		
			if ($_FILES['LinkFaceCH']['error']==0){
			
				$data = array('extid' => $j);
				$setarr['pic'.$j] = upload_icon_banner($data, $_FILES['pic'.$j], 'couponslide');	
						
			}
			
		} else {
		
			$setarr['pic'.$j] = $_G['sr_pic'.$j];
				
		}	
		$setarr['movie'.$j]=$_G['sr_movie'.$j];
		if (!empty($setarr['pic'.$j])) {
		
			$picurl = coupon_fiximage($setarr['pic'.$j]);
			$link =  $setarr['movie'.$j];
			$tmp ='<track><title></title><creator></creator>';
			$tmp .='<location>'.$picurl.'</location>';
			$tmp .='<info>'.$link.'</info></track>'."\r\n";	
			$tmpstr .= $tmp;
			
		}
				
	}
	$result = DB::fetch_first("SELECT * FROM ".DB::table('sanree_brand_coupon_slide'));
	if ($result) {
	
		DB::update('sanree_brand_coupon_slide', $setarr,"ID=1");
		
	} else {
	
	    $setarr['ID'] = 1;
		DB::insert('sanree_brand_coupon_slide', $setarr);
		
	}
	cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&identifier=sanree_brand_coupon&pmod=admincp", 'succeed');
	
} else {

	$result = DB::fetch_first("SELECT * FROM ".DB::table('sanree_brand_coupon_slide'));
	showsubmenu($menustr);
	showformheader($thisurl, 'enctype');
	showtableheader($langs['slide'], 'nobottom');
	for($j=1; $j<6; $j++) {
	
	    $grouplogohtml ='';
		$pic ='';
		if($result['pic'.$j]) {
		
		    $pic = $result['pic'.$j];
		    $grouplogohtml = '<label>'.$langs['slideimgtip'].'<br /><img src="'.coupon_fiximage($pic).'?'.random(6).'" width="300" height="75" />';
			
		}
		showsetting($langs['slide_img'].$j, 'pic'.$j, $pic, 'filetext', '', 0,$grouplogohtml);
		showsetting($langs['slide_link'].$j, 'movie'.$j, $result['movie'.$j], 'text');
		
	}
	showsubmit('submit');
	showtablefooter();
	showformfooter();			
}
//www-FX8-co
?>