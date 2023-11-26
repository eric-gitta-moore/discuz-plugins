<?php
header("Content-type:text/html; charset=gb2312;");
require_once('function.php');
require_once('config.php');
session_start();

$times= md5(date("YmdHis".get_client_ip()));
$callback_url = $_SERVER['HTTP_REFERER'];
$redirect_url =  "http://".$_SERVER["HTTP_HOST"].str_replace("login.php", "redirect.php", $_SERVER["REQUEST_URI"]);
$_SESSION["state"] = $times;
$_SESSION["redirect_url"] = $redirect_url;
$_SESSION["callback_url"] = $callback_url;

$scope = array();
foreach($oauth["api"] as $key=>$val){
    if($val==1){
        $scope[] = $key;
    }
}
$param = array(
    "response_type"    => "code",
    "client_id"        =>    $oauth["appid"],
    "redirect_uri"    =>    $redirect_url,
    "scope"            =>    join(",", $scope),
    "state"            =>    $times
);
$_SESSION['appid'] = $oauth["appid"];
$_SESSION['appkey'] = $oauth["appkey"];

$get_array = array();
foreach($param as $key=>$val){
    $get_array[] = $key."=".urlencode($val);
}
$get_url = "https://graph.qq.com/oauth2.0/authorize?";
$get_url .= join("&",$get_array);

header("location:".$get_url);

?>