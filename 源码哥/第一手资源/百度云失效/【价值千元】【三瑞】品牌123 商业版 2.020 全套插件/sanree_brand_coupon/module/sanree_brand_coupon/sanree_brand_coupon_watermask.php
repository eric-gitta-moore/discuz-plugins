<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_coupon_watermask.php sanree $
 */

if(!defined('IN_DISCUZ') || empty($_GET['aid'])) {
	header('location: '.$_G['siteurl'].'static/image/common/none.gif');
	exit;
}
if (!$watermarkfont) {
	showmessage(coupon_modlang('notwatermarkfont'));
}
$watermarkfontfile = DISCUZ_ROOT.$watermarkfont;
if (!file_exists($watermarkfontfile)) {
	showmessage(coupon_modlang('notwatermarkfontfile'));
}
$cid = intval($_G['sr_tid']);
$couponresult = C::t('#sanree_brand_coupon#sanree_brand_coupon')->getcoupon_by_cid($cid);
if (!$couponresult) {
	coupon_showimg(coupon_modlang('nocouponshow'));
}
if ($couponresult['isshow']!=1) {
	coupon_showimg(coupon_modlang('notisshow'));
}
$stock = intval($couponresult['stock']);
if ($stock<1) {
	coupon_showimg(coupon_modlang('nostock'));
}
if ($couponresult['enddate']) {
	if (TIMESTAMP > $couponresult['enddate']) {
		coupon_showimg($enddatetip);
	}
}
$iscolor = intval($_G['sr_color'])==1 ? 1 : 0;
$daid = intval($_GET['aid']);
if ($daid != $couponresult['homeaid']) {
	coupon_showimg(coupon_modlang('nostock'));
}
$pringlogid = intval($_G['sr_pringlogid']);
$logresult = C::t('#sanree_brand_coupon#sanree_brand_coupon_printlog')->fetch_first_by_printlogid_and_puid($pringlogid, $_G['uid']);
if (!$logresult) {
	coupon_showimg(coupon_modlang('noprintlog'));
}
$status = intval($result['status']);
if ($status!=0) {
	coupon_showimg(coupon_modlang('notuseprintlog'));
}	
$parse = parse_url($_G['setting']['attachurl']);
$attachurl = !isset($parse['host']) ? $_G['siteurl'].$_G['setting']['attachurl'] : $_G['setting']['attachurl'];
define('NOROBOT', TRUE);
if($attach = C::t('#sanree_brand#sanree_brand_attachment')->fetch_firstbyaid($daid)) {
    dheader('Expires: '.gmdate('D, d M Y H:i:s', TIMESTAMP + 3600).' GMT');
	if($attach['remote']) {
		$filename = $_G['setting']['ftp']['attachurl'].'category/'.$attach['attachment'];
	} else {
		$filename = $_G['setting']['attachdir'].'category/'.$attach['attachment'];
	}
	writecopyright($filename, $iscolor, $logresult);
}
coupon_showimg('error 2');
function coupon_showimg($watermarktextcvt) {
	global $watermarkfontfile;
	if (CHARSET!='utf-8') {
		$watermarktextcvt = iconv('GB2312', 'UTF-8', $watermarktextcvt); 
	}
	$imwidth=strlen($watermarktextcvt) * 10;
	$im = imagecreatetruecolor($imwidth, 20); 
	imagesavealpha($im, true); 
	$red = imagecolorallocate($im, 0xff, 0, 0);  
	$trans_colour = imagecolorallocatealpha($im, 0xff, 0xff, 0xff, 127); 
	imagefill($im, 0, 0, $trans_colour); 
	imagecolortransparent($im, $trans_colour);
	$fontfile = $watermarkfontfile;
	$font = imageloadfont($fontfile );	
	imagettftext($im, 12, 0, 5, 15, $red, $fontfile, $watermarktextcvt);
	header("Content-type:image/jpeg");  
	imagegif($im);  
	imagedestroy($im); 
}
function writecopyright($filename,$iscolor,$logresult) {
	global $_G, $isprintwatermark, $watermarkfontfile;
	$config = $_G['cache']['plugin']['sanree_brand_coupon'];
	$isprintwatermark = intval($config['isprintwatermark']);
	$watermarktext = $config['watermarktext'];	
	$watercolor = !empty($config['watercolor']) ? $config['watercolor'] : '#3333FF';	
	$imginfo = @getimagesize($filename);
	switch($imginfo['mime']) {
		case 'image/jpeg':
			$imagecreatefromfunc = function_exists('imagecreatefromjpeg') ? 'imagecreatefromjpeg' : '';
			$imagefunc = function_exists('imagejpeg') ? 'imagejpeg' : '';
			break;
		case 'image/gif':
			$imagecreatefromfunc = function_exists('imagecreatefromgif') ? 'imagecreatefromgif' : '';
			$imagefunc = function_exists('imagegif') ? 'imagegif' : '';
			break;
		case 'image/png':
			$imagecreatefromfunc = function_exists('imagecreatefrompng') ? 'imagecreatefrompng' : '';
			$imagefunc = function_exists('imagepng') ? 'imagepng' : '';
			break;
		default:
			coupon_showimg('-3');
			break;
	}
	$im = $imagecreatefromfunc($filename);
	if ($iscolor!=1) {
		if (imageistruecolor($im)) {
			imagetruecolortopalette($im, false, 256);
		}
		for ($i = 0; $i < imagecolorstotal($im); $i++){
			$rgb = imagecolorsforindex($im, $i);
			$gray = round(0.229 * $rgb['red'] + 0.587 * $rgb['green'] + 0.114 * $rgb['blue']);
			imagecolorset($im, $i, $gray, $gray, $gray);
		}
	}
	if ($isprintwatermark==1&&!empty($watermarktext)) {

		if ($iscolor!=1) {
			$red = imagecolorat($im, 0, 0);
			$blue = imagecolorallocatealpha($im, 0xff, 0xff, 0xff, 75); 
			imagefilledrectangle($im, 0, 0, $imginfo[0], 50, $blue); 			 
		} else {
			$red = getImageColorAllocate($im, $watercolor); 		
			$blue = imagecolorallocatealpha($im, HexDec(66), HexDec(66), HexDec(66), 75); 
			imagefilledrectangle($im, 0, 0, $imginfo[0], 50, $blue); 		
		}
		$fontfile = $watermarkfontfile;
		$font = imageloadfont($fontfile );
		$offset = getglobal('member/timeoffset');
		$watermarktext = str_replace('{username}', $_G['username'], $watermarktext);
		$watermarktext = str_replace('{printcode}', $logresult['printcode'], $watermarktext);
		$str = str_replace('{time}', gmdate('Y-m-d H:i:s', TIMESTAMP+$offset * 3600), $watermarktext);
		if (CHARSET!='utf-8') {
			$str = iconv('GB2312', 'UTF-8', $str); 
		}		
		imagettftext($im, 12, 0, 11, 21, $red, $fontfile, $str);
	}
	header('Content-Type: '.$imginfo['mime']);
	if ('imagepng'==$imagefunc){
		$imagefunc($im);
	} else {
		$imagefunc($im, NULL, 100);
	}
	imagedestroy($im);
}

function getImageColorAllocate($im, $colorStr) {
	$firstChar = subStr($colorStr, 0, 1);
	if($firstChar == "#") {
		$startPos = 1;
	} else {
		$startPos = 0;
	}
	$R = HexDec(subStr($colorStr, $startPos, 2));
	$G = HexDec(subStr($colorStr, $startPos+2, 2));
	$B = HexDec(subStr($colorStr, $startPos+4, 2));
	return imageColorAllocate($im, $R, $G, $B);
}
//www-FX8-co
?>