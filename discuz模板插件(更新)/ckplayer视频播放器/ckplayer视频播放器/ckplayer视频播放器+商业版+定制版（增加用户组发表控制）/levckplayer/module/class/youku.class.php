<?php

class Youku {

	public static $baseurl = 'https://openapi.youku.com/v2/videos/files.json';
	public static $basepar = 'client_id=e57bc82b1a9dcd2f&client_secret=a361608273b857415ee91a8285a16b4a&type=play&video_id=';
	public static $hz = "_youku";
	
	public static function parse($url){
		if ($url && $url != '') {
			//to search the aim value in the $url variable
			$ykid=stripos($url, 'v.youku.com');
			//if the value of the $ykid is not empty, continue.
			if ($ykid>"0") {
				//将取到的网址传入指定的方法中
				$xml = self::yk_list_url($url);
				return $xml;
			}
		}
	}

	public static function _getYouku($vid, $qxd = 'bq') {
		return self::yk_begin($vid, $qxd);
	}
	
	//利用分割符来取出优酷vid值
	public static function yk_list_url($url){
		//根据优酷网址的特征，利用下划线来分割,并且取到下标为2的值
		$vid = explode('_', $url);
		if ($vid[2])
		//接着用点来分割，取出下标为0的值。也就是VID了
		$id = explode('.', $vid[2]);
		if ($id[0])
		//将VID传入取优酷视频信息的方法进行下一步操作
		$xml = self::yk_begin($id[0], 'bq');
		return $xml;
	}
	public static function yk_begin($vid,$qxd){
		$data = self::$basepar .$vid;
		$html = self::curl_https(self::$baseurl, $data);
		//用PHP自带JSON来解码
		$jdata = json_decode($html);
		$sid = $jdata->sid;
		$files = $jdata->files;
		if ($sid=="") {
			//echo "sidnull";
			return;
		}
		$definition = $files;
		// 当没有传指定清晰度的值的时候，默认输出最高清晰度，所以需要循环视频所有清晰度，然后再取最后一个清晰度。
		// 定义一个数组用来存放清晰度数据
		$types = array();
		// 用foreach循环来把获得的清晰度数据加入到指定数组中  可以用来智能识别清晰度的值
		foreach ($definition as $key => $v) {
			array_push($types, $key);
		}
		$xhcs = count($types);
		// 判断传的值是否带清晰度
		$hden2 = array("3gp","bq","gq","cq","hd2");

		//$hden = array("3gphd","flvhd","mp4hd","mp4hd2","mp4hd3");//"flv","mp4",之前写的时候有这个格式
		//如果去掉，可以通过$types来获取清晰度的值
		if ($qxd=="") {
			// 为空则输出最高清晰度
			$vtype = $hden2[count($types)-1];//这里取到的值是视频信息页的清晰度数据 flvhd,mp4hd
			$qxurl = $vtype."_".$vid.self::$hz;
			// echo $vtype;
			// 重置清晰度的值
			$vtype = $types[count($types)-1];
		}else{
			$vtype2 = $qxd;//cq
			$qxurl = $vtype2."_".$vid.self::$hz;
		}
		// 判断是否存在该清晰度
		// 重置清晰度的值 将传过来的参数cq/gq/bq/转化成原始清晰度数据
		//echo $vtype2;//cq
		for ($i=0; $i < $xhcs; $i++) {
			if ($hden2[$i]==$vtype2) {//cq==3
				$num = $i;
				$vtype = $types[$num];
				break;
			}
		}
		$yktypes = array("3gphd","flv","mp4","hd2","hd3");
		$ykhd = array("1","0","1","2","3");
		$ykformatname = array("mp4","flv","mp4","flv","flv");
		$ykclear = array("3gp","标清","高清","超清","1080");
		$ykarr = array("type"=>$yktypes,"hd"=>$ykhd,"fn"=>$ykformatname,"cl"=>$ykclear);
		foreach ($files as $key =>$v) {
			$segs = $v->segs;
			$yktype = $key;
			if ($yktype==$vtype) {//hd2
				$segs = $v->segs;
				for ($i=0; $i < count($types); $i++) {
					if ($yktype == $ykarr["type"][$i]) {
						$hd = $ykarr["hd"][$i];
						$formatname = $ykarr["fn"][$i];
						$clear = $ykarr["cl"][$i];
						break;
					}
				}
				foreach ($segs as $k => $value) {
					$ts = $value->duration;
					$downlink = $value->url;
					$sdata['high'][$k] = $downlink;
				}
				return $sdata;
			}
		}
		return;
	}
	public static function getdefa($xhcs,$vid){
		$hden2 = array("3gp","bq","gq","cq","hd2");
		$qvars = "bq_". $vid . self::$hz . "|" . "gq_" . $vid . self::$hz . "|" . "cq_". $vid . self::$hz;
		for ($i=0; $i < $xhcs; $i++) {
			if ($i>0) {
				$defa .= "|".$hden2[$i]."_".$vid.self::$hz;
			}else{
				$defa .= $hden2[$i]."_".$vid.self::$hz;
			}
		}
		return $defa;
	}

	public static function getdeft($xhcs){
		// $qxd = "标清|高清|超清";
		// $types = array();
		$hdcn = array("标清(3GP)","标清hd","高清","超清","1080P","1080Phd");//"标清", 不知道为什么现在没
		for ($i=0; $i < $xhcs; $i++) {
			if ($i>0) {
				$qxd .= "|".$hdcn[$i];
			}else{
				$qxd .= $hdcn[$i];
			}
		}
		return $qxd;
	}
	/** curl 获取 https 请求 
	 * @param String $url 请求的url 
	 * @param Array $data 要發送的數據 
	 * @param Array $header 请求时发送的header 
	 * @param int $timeout 超时时间，默认30s 
	 */
	public static function curl_https($url, $data,$timeout=30){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在 
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}

}