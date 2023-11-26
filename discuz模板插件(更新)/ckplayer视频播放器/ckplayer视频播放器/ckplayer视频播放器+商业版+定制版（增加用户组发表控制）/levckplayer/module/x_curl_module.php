<?php

/**
 * Www.魔趣吧.Vip 
 *
 * [魔趣吧!] (C)2014-2017 www.moqu8.com.  By www-魔趣吧-co
 *
 * Support: caogenba@qq.com QQ:1218894030
 *
 * Date: 2013-02-17 16:22:17 moqu8.com $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

set_time_limit(60*60);

class x_curl_module {


	public static function jsondcode($json) {
		if (empty($json)) return array();
		$comment = false;
		$x = '';
		$out = '$x=';

		for ($i=0; $i<strlen($json); $i++) {
			if (!$comment) {
				if (($json[$i] == '{') || ($json[$i] == '[')) {
					$out .= ' array(';
				}else if (($json[$i] == '}') || ($json[$i] == ']')) {
					$out .= ')';
				}else if ($json[$i] == ':') {
					$out .= '=>';
				}else {
					$out .= $json[$i];
				}
			}else {
				$out .= $json[$i];
			}
			if ($json[$i] == '"' && $json[($i-1)]!="\\")    $comment = !$comment;
		}
		eval($out . ';');
		return $x;
	}
	
	public static function _post($arr) {
		$url  = $arr[0];
		$data = $arr[1];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_URL, $url);
		$ret = curl_exec($ch);

		curl_close($ch);
		return $ret;
	}
	
	public static function _get($url) {
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result =  curl_exec($ch);
		curl_close($ch);

		return $result;
	}
	
	public static function doCurl($arr) {
			//没地址结束
			if(empty($arr['url'])) return;
	
			//没用户信息自动获取
			//if ($arr['agent'] ==1) 
			$arr['agent'] = $_SERVER['HTTP_USER_AGENT'];
	
			//没用户IP自动获取
			if (empty($arr['ip'])) $arr['ip'] = '';//ip();//$_SERVER["REMOTE_ADDR"];
	
			//没header 设置成假
			if (empty($arr['header'])) $arr['header'] = false;
			
			//来路设置
			//if(empty($arr['referer'])) $arr['referer'] = 'http://web.qq.com';//http://fight.pet.qq.com/fightindex.html?sourceid=108&ADTAG=cop.innercop.qqsh-actionhall';//'
	
			//没cookie 保存设置成空
			if(empty($arr['cookiejar'])) $arr['cookiejar'] = '';
	
			//没cookie 读取设置成空
			if(empty($arr['cookiefile'])) $arr['cookiefile'] = '';
	
			//没发送post 设置成空
			if(empty($arr['post'])) $arr['post'] = '';
			
			//输出方式
			if (empty($arr['bisfer'])) $arr['bisfer'] = FALSE;
			
			//超时时间没有设置成常量默认
			if(empty($arr['time'])) {// $arr['time'] = 5;
				$arr['time'] = 5;
			}
	
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$arr['url']);	
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, $arr['bisfer']) ;		
			curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HEADER, $arr['header']);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-FORWARDED-FOR:{$arr['ip']}","CLIENT-IP:{$arr['ip']}"));
			
			//用户浏览器信息
			if ($arr['agent']) curl_setopt($ch, CURLOPT_USERAGENT, $arr['agent']);
			
			if (!empty($arr['httpheader'])) curl_setopt($ch, CURLOPT_HTTPHEADER, $arr['httpheader']);
	
			//读取cookie
			if ($arr['cookiefile']) curl_setopt($ch, CURLOPT_COOKIEFILE, $arr['cookiefile']);
	
			//保存cookie
			if ($arr['cookiejar']) curl_setopt($ch, CURLOPT_COOKIEJAR, $arr['cookiejar']);
			
			//来路
			if ($arr['referer']) curl_setopt($ch, CURLOPT_REFERER, $arr['referer']);
	
			//post数据
			if ($arr['post']) curl_setopt($ch, CURLOPT_POSTFIELDS, $arr['post']);
			
			//发送cookie
			if (empty($arr['cookie'])) $arr['cookie'] = '';
			curl_setopt($ch, CURLOPT_COOKIE, $arr['cookie']);
	
			//多少秒超时
			curl_setopt($ch, CURLOPT_TIMEOUT, $arr['time']);
	
			$c_url = curl_exec($ch);
			curl_close($ch);
			return $c_url;
	}
	
}







