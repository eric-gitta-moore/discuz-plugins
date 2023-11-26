<?php
vCode(100, 40);
function vCode($width = 0, $height = 0) {
	Header("Content-type:image/png");
	$authnum_session = '';
	$str = '1234567890';
	$l = strlen($str);
	for($i = 1;$i <= 4;$i++) {
		$num=rand(0,$l-1);
		$authnum_session.= $str[$num];
	}
	$_SESSION["VerifyCode"]=$authnum_session;
	srand((double)microtime()*1000000);
	$im = imagecreate($width, $height);
	$back_color = imagecolorallocate($im, 235, 236, 237);
	$text_color = imagecolorallocate($im, rand(0, 200), rand(0, 120), rand(0, 120));
	imagefilledrectangle($im, 0, 0, $width, $height, $back_color);
	for($i = 0;$i < 5;$i++) {
		$font_color = imagecolorallocate($im, rand(0, 255), rand(0, 255), rand(0, 255));
		imagearc($im, rand(- $width, $width), rand(- $height, $height), rand(30, $width * 2), rand(20, $height * 2), rand(0, 360), rand(0, 360), $font_color);
	}
	for($i = 0;$i < 50;$i++) {
		$font_color = imagecolorallocate($im, rand(0, 255), rand(0, 255), rand(0, 255));
		imagesetpixel($im, rand(0, $width), rand(0, $height), $font_color);
	}
	imagestring($im, 5, 33, 12, $authnum_session, $text_color);
	ImagePNG($im);
	ImageDestroy($im);
}
?>