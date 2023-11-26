<?php
/*

 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

global $_G;
$keke_chongzhi = $_G['cache']['plugin']['keke_chongzhi'];
if(!function_exists('curl_init')){
	echo 'not function curl_init';
}
define('WXAPPID', trim($keke_chongzhi['wxappid']));
define('WXSECRET', trim($keke_chongzhi['wxsecert']));
define('WXMCHID', trim($keke_chongzhi['wxmchid']));
define('WXKEY', trim($keke_chongzhi['wxshkey']));

include_once DISCUZ_ROOT."source/plugin/keke_chongzhi/paylib/wechat/lib/WxPay.Config.php";
include_once DISCUZ_ROOT."source/plugin/keke_chongzhi/paylib/wechat/lib/WxPay.Api.php";
include_once DISCUZ_ROOT.'source/plugin/keke_chongzhi/paylib/wechat/lib/WxPay.Data.php';
include_once DISCUZ_ROOT.'source/plugin/keke_chongzhi/paylib/wechat/lib/WxPay.Exception.php';
include_once DISCUZ_ROOT.'source/plugin/keke_chongzhi/paylib/wechat/lib/WxPay.Notify.php';
include_once DISCUZ_ROOT."source/plugin/keke_chongzhi/paylib/wechat/WxPay.JsApiPay.php";
include_once DISCUZ_ROOT."source/plugin/keke_chongzhi/paylib/wechat/WxPay.NativePay.php";
$uskey= substr(md5('kekechongzhi'.$_G['siteurl']), 0, 7);
$iswx='';
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false){
	$iswx=1;
}
$s_type=$iswx?"JSAPI" : "NATIVE";

function arrtoxml($data){
    $xml = "<xml>";
    foreach ($data as $key=>$val)
    {
        if (is_numeric($val)){
            $xml.="<".$key.">".$val."</".$key.">";
        }else{
            $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
        }
    }
    $xml.="</xml>";
    return $xml;
}