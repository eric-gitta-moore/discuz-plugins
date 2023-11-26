<?php
/**
 *      [Caogen8.Co!] (C)2014-2018 Cgzz8.Com && plugin by caogen8. && cgzz8.com
 *      Ð¡²Ý¸ù(QQ£º2575163778) wWw.Caogen8.co
 *
 *      Author: CAOGEN8.CO $
 */
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class HttpdnsGetRequest
{
	private $apiParas = array();
	
	public function getApiMethodName()
	{
		return "taobao.httpdns.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check(){}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
