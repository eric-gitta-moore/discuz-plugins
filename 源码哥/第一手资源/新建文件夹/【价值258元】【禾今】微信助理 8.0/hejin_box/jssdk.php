<?php
class JSSDK {

  private $appId;
  private $appSecret;

  public function __construct($appId, $appSecret) {
    $this->appId = $appId;
    $this->appSecret = $appSecret;
  }

  public function getSignPackage() {
    $jsapiTicket = $this->getJsApiTicket();

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $timestamp = time();
    $nonceStr = $this->createNonceStr();

    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

    $signature = sha1($string);

    $signPackage = array(
      "appId"     => $this->appId,
      "nonceStr"  => $nonceStr,
      "timestamp" => $timestamp,
      "url"       => $url,
      "signature" => $signature,
      "rawString" => $string
    );
    return $signPackage; 
  }

  private function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
  }

  private function getJsApiTicket() {
  
   	$jsticket =  C::t('#hejin_box#hjbox_token')->fetch_by_id(2);
	if(!count($jsticket)){
		$accessToken = $this->getAccessToken();
      	$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
      	$res = json_decode($this->httpGet($url));
      	$hqticket = $res->ticket;
		if($hqticket){
			$addtokendata = array(
				'id'=>2,
				'access_token' => addslashes($hqticket),
				'cj_time'=>time(),
			);
			$addtoken = C::t('#hejin_box#hjbox_token')->insert($addtokendata);
			$ticket = $hqticket;
		}
	}else{
		$sytime = time()-$jsticket['cj_time'];
		if($sytime>6000){
			$accessToken = $this->getAccessToken();
      		$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
      		$res = json_decode($this->httpGet($url));
      		$hqticket = $res->ticket;
			if($hqticket){
				$uptokendata = array(
					'access_token' => addslashes($hqticket),
					'cj_time'=>time(),
				);
				$uptoken = C::t('#hejin_box#hjbox_token')->update_by_id(2,$uptokendata);
				$ticket = $hqticket;
			}
		}else{
			$ticket = $jsticket['access_token'];
		}
	}
    return $ticket;
  }

  private function getAccessToken() {
 
 	$token =  C::t('#hejin_box#hjbox_token')->fetch_by_id(1);
	if(!count($token)){
      	$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
      	$res = json_decode($this->httpGet($url));
      	$access_token = $res->access_token;
		if($access_token){
			$addtokendata = array(
				'id'=>1,
				'access_token' => addslashes($access_token),
				'cj_time'=>time(),
			);
			$addtoken = C::t('#hejin_box#hjbox_token')->insert($addtokendata);
			$returnaccess = $access_token;
		}
	}else{
		$sytime = time()-$token['cj_time'];
		if($sytime>6000){
      		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
      		$res = json_decode($this->httpGet($url));
      		$access_token = $res->access_token;
			if($access_token){
				$uptokendata = array(
					'access_token' => addslashes($access_token),
					'cj_time'=>time(),
				);
				$uptoken = C::t('#hejin_box#hjbox_token')->update_by_id(1,$uptokendata);
				$returnaccess = $access_token;
			}
		}else{
			$returnaccess = $token['access_token'];
		}
	}
    return $returnaccess;
  }

  private function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
  }
}

