<?php


/**
* 各大视频网站地址解析
* 目前支持 优酷/芒果TV/音悦台 (其他 酷我音乐)
*/
class Media
{

	private static $sz='-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,62,-1,-1,-1,63,52,53,54,55,56,57,58,59,60,61,-1,-1,-1,-1,-1,-1,-1,0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,-1,-1,-1,-1,-1,-1,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,-1,-1,-1,-1,-1';
	private static $source="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ/\\:._-1234567890";
	private static $str='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';

	
	function __construct()
	{
		
	}
	
	public static function parse($url)
	{
		if(strpos($url,'iqiyi.com'))
		{
			$data=self::getIQiYiInfo($url);
		}
		else if(strpos($url,'youku.com'))
		{
			$data=self::getYouKuInfo($url);
		}
		else if(strpos($url,'yinyuetai.com'))
		{
			$data=self::getYinYueTaiInfo($url);
		}
		else if(strpos($url,'hunantv.com') || strpos($url,'mgtv.com'))
		{
			$data=self::getImgoTvInfo($url);
		}
		else if(strpos($url,'letv.com'))
		{
			$data=self::getLeTvInfo($url);
		}
		else if(strpos($url,'kuwo.cn'))
		{
			$data=self::getKuWoInfo($url);
		}
		else
		{
			$data=false;
		}
		return $data?$data:false;
	}

	//爱奇艺视频解析
	private static function getIQiYiInfo($url)
	{
		$html=self::httpGet($url,86400);
		$html=substr($html,strpos($html,'data-player-collectionid',4e4),150);
		$pattern='/[\S\s]+?data-player-videoid="(\w{32})"[\S\s]+?data-player-tvid="(\d{9})"[\S\s]+?/';
		if(preg_match_all($pattern,$html,$matches))
		{
			$vid=$matches[1][0];
			$tvId=$matches[2][0];
			$uuid=md5(uniqid());
			$tn=rand(1,9999);
			$src='1702633101b340d8917a69cf8a4b8c7';
			$tm=rand(2000,4000);
			$enc=md5(implode('',array('a6f2a01ab9ad4510be0449fab528b82c',$tm,$tvId)));
			$authKey=md5(implode('',array('',$tm,$tvId)));
			$url="http://cache.video.qiyi.com/vms?key=fvip&src={$src}&tvId={$tvId}&vid={$vid}&vinfo=1&tm={$tm}&qyid={$uuid}&um=1&tn={$tn}&enc={$enc}&authkey={$authKey}";
			$baseInfo=json_decode(self::httpGet($url),true);
			var_dump($baseInfo);die;
			$vs=$baseInfo['data']['vp']['tkl'][0]['vs']; //包含各个清晰度
			$index=min($index,count($vs)-1);
			$fs=$vs[$index]['fs']; //包含各个分段
			$t=floor(time()/600);
			$tp=')(*&^flash@#$%a';
			foreach ($fs as &$item)
			{
				$l=$item['l'];
				$segment=explode('/',$l);
				$segment=explode('.',end($segment));
				$segment=$segment[0];
				$key=md5($t.$tp.$segment);
				$baseurl=rtrim($baseInfo["data"]["vp"]["du"],'/videos')."/{$key}/videos";
				$item=$baseurl.$l;
			}
			foreach (($fs=self::httpGet($fs)) as $item)
			{
				$item=json_decode($item,true);
				$item=$item['l'];
			}
			return $fs;
		}
		return false;
	}

	//优酷视频解析
	private static function getYouKuInfo($url)
	{
		$pattern='/id_([\w=]+)\.html/';
		$videoId=null;
		if(preg_match_all($pattern,$url,$matches))
		{
			$videoId=$matches[1][0];
		}
		if($videoId)
		{
			$url=array("http://play.youku.com/play/get.json?vid={$videoId}&ct=10","http://v.youku.com/player/getPlayList/VideoIDS/{$videoId}/Pf/4/ctype/12/ev/1");
			list($metaLogo,$meta)=self::httpGet($url);
			$metaLogo=json_decode($metaLogo,true);
			$img=$metaLogo['data']['video']['logo'];
			$meta=json_decode($meta,true);
			$streamtypes=$meta['data'][0]['streamtypes']; //可以输出的视频清晰度
			$streamfileids=$meta['data'][0]['streamfileids'];
			$seed=$meta['data'][0]['seed'];
			$segs=$meta['data'][0]['segs'];
			$ip=$meta['data'][0]['ip'];
			$bsegs=$meta['data'][0]['segs'];
			$ep=$meta['data'][0]['ep'];
			list($sid,$token)=explode('_',self::e('becaf9be',self::na($ep)));
			$data=array('img'=>$img,'title'=>$meta['data'][0]['title'],'seconds'=>$meta['data'][0]['seconds']);
			foreach($segs as $key => $val)
			{
				if(in_array($key,$streamtypes))
				{
					foreach($val as $k => $v)
					{
						$no=strtoupper(dechex($v['no']));
						if(strlen($no)==1)
						{
							$no="0".$no;  //no为每段视频序号
						}
						//构建视频地址K值
						$_k=$v['k'];
						if((!$_k||$_k=='')||$_k=='-1')
						{
							$_k=$bsegs[$key][$k]['k'];
						}
						$fileId=self::getFileid($streamfileids[$key],$seed);
						$fileId=substr($fileId,0,8).$no.substr($fileId,10);
						$ep=urlencode(iconv('gbk','UTF-8',self::d(self::e('bf7e5f01',((($sid.'_').$fileId).'_').$token))));
						//判断后缀类型 、获得后缀
						$typeArray=array('flv'=>'flv','mp4'=>'mp4','hd2'=>'flv','3gphd'=>'mp4','3gp'=>'flv','hd3'=>'flv');
						//判断视频清晰度  
						$sharpness=array('flv'=>'normal','flvhd'=>'normal','mp4'=>'high','hd2'=>'super','3gphd'=>'high','3gp'=>'normal','hd3'=>'original'); //清晰度 数组
						$fileType=$typeArray[$key];
						$data[$sharpness[$key]][$k]="http://k.youku.com/player/getFlvPath/sid/{$sid}_00/st/{$fileType}/fileid/{$fileId}?K={$_k}&hd=1&myp=0&ts=".((((($v['seconds'].'&ypp=0&ctype=12&ev=1&token=').$token).'&oip=').$ip).'&ep=').$ep;
					}
				}
			}
			return $data;
		}
		return false;
	}
	private static function fromCharCode($codes)
	{
		if(is_scalar($codes))
		{
			$codes=func_get_args();
		}
		$str='';
		foreach ($codes as &$code)
		{
			$code=chr($code);
		}
		return implode('',$codes);
	}
	private static function charCodeAt($str,$index)
	{
		static $charCode=array();
		$key=md5($str);
		$index++;
		if(isset($charCode[$key]))
		{
			return $charCode[$key][$index];
		}
		$charCode[$key]=unpack('C*',$str);
		return $charCode[$key][$index];
	}
	private static function charAt($str,$index=0)
	{
		return substr($str,$index,1);
	}
	private static function na($a)
	{
		if(!$a)
		{
			return '';
		}
		$h=explode(',',self::$sz);
		$i=strlen($a);
		$f=0;
		for($e='';$f<$i;)
		{
			do
			{
				$c=$h[self::charCodeAt($a,$f++)&255];
			}
			while($f<$i && -1==$c);
			if(-1==$c)
			{
				break;
			}
			do
			{
				$b=$h[self::charCodeAt($a,$f++)&255];
			}
			while($f<$i && -1==$b);
			if(-1==$b)
			{
				break;
			}
			$e.=self::fromCharCode($c<<2|($b&48)>>4);
			do
			{
				$c=self::charCodeAt($a,$f++)&255;
				if (61==$c)
				{
					return $e;
				}
				$c=$h[$c];
			}
			while($f<$i && -1==$c);
			if(-1==$c)
			{
				break;
			}
			$e.=self::fromCharCode(($b&15)<<4|($c&60)>>2);
			do
			{
				$b=self::charCodeAt($a,$f++)&255;
				if(61==$b)
				{
					return $e;
				}
				$b=$h[$b];
			}
			while($f<$i && -1==$b);
			if(-1==$b)
			{
				break;
			}
			$e.=self::fromCharCode(($c&3)<<6|$b);
		}
		return $e;
	}
	private static function e($a,$c)
	{
		for($f=0,$i,$e='',$h=0;256>$h;$h++)
		{
			$b[$h]=$h;
		}
		for($h=0;256>$h;$h++)
		{
			$f=(($f+$b[$h])+self::charCodeAt($a,$h%strlen($a)))%256;
			$i=$b[$h];
			$b[$h]=$b[$f];
			$b[$f]=$i;
		}
		for($q=($f=($h=0));$q<strlen($c);$q++)
		{
			$h=($h+1)%256;
			$f=($f+$b[$h])%256;
			$i=$b[$h];
			$b[$h]=$b[$f];
			$b[$f]=$i;
			$e.=self::fromCharCode(self::charCodeAt($c,$q)^$b[($b[$h]+$b[$f])%256]);
		}
		return $e;
	}
	private static function d($a)
	{
		if(!$a)
		{
			return '';
		}
		$f=strlen($a);
		$b=0;
		$str=self::$str;
		for ($c='';$b<$f;)
		{
			$e=self::charCodeAt($a, $b++) & 255;
			if($b==$f)
			{
				$c.=self::charAt($str,$e>>2);
				$c.=self::charAt($str,($e&3)<<4);
				$c.='==';
				break;
			}
			$g=self::charCodeAt($a,$b++);
			if($b==$f)
			{
				$c.=self::charAt($str,$e>>2);
				$c.=self::charAt($str,($e&3)<<4|($g&240)>>4);
				$c.=self::charAt($str,($g&15)<<2);
				$c.='=';
				break;
			}
			$h=self::charCodeAt($a,$b++);
			$c.=self::charAt($str,$e>>2);
			$c.=self::charAt($str,($e&3)<<4|($g&240)>>4);
			$c.=self::charAt($str,($g&15)<<2|($h&192)>>6);
			$c.=self::charAt($str,$h&63);
		}
		return $c;
	}
	private static function getFileid($fileId,$seed)
	{
		$mixed=self::getMixString($seed);
		$ids=explode("*",rtrim($fileId,'*')); //去掉末尾的*号分割为数组
		$realId="";
		for($i=0;$i<count($ids);$i++)
		{
			$idx=$ids[$i];
			$realId.=substr($mixed,$idx,1);
		} 
		return $realId;
	}
	private static function getMixString($seed)
	{
		$mixed='';
		$source=self::$source;
		$len=strlen($source);
		for($i=0;$i<$len;$i++)
		{
			$seed=($seed*211+30031)%65536;
			$index=($seed/65536*strlen($source));
			$c=substr($source,$index,1);
			$mixed.=$c;
			$source=str_replace($c,"",$source);
		}
		return $mixed;
	}

	//芒果TV解析
	private static function getImgoTvInfo($url)
	{
		$data=array();
		if(preg_match_all('/\/(\d{7})\.html/',$url,$matches))
		{
			$vid=$matches[1][0];
			$baseInfo=json_decode(self::httpGet("http://v.api.hunantv.com/player/video?video_id={$vid}"),true);
			if($baseInfo['status']==200)
			{
				$data['title']=&$baseInfo['data']['info']['title'];
				$data['img']=&$baseInfo['data']['info']['thumb'];
				$data['seconds']=&$baseInfo['data']['info']['duration'];
				list($normal,$high,$super)=self::httpGet(array($baseInfo['data']['stream'][0]['url'],$baseInfo['data']['stream'][1]['url'],$baseInfo['data']['stream'][2]['url']));
				$normal=json_decode($normal,true);
				$high=json_decode($high,true);
				$super=json_decode($super,true);
				$data['normal']=array($normal['info']);
				$data['high']=array($high['info']);
				$data['super']=array($super['info']);
				return $data;
			}
			return false;
		}
		else
		{
			return false;
		}
	}


	//乐视TV解析
	private static function getLeTvInfo($url)
	{
		if(preg_match_all('/vplay\/(\d{8})\.html/',$url,$matches))
		{
			$vid=$matches[1][0];
			$tkey=self::getTkey(time());
			$baseInfo=json_decode(self::httpGet("http://api.letv.com/mms/out/video/playJson?id={$vid}&platid=1&splatid=101&format=1&tkey={$tkey}&domain=www.letv.com&dvtype=1000&accessyx=1",60),true);
			var_dump($tkey,$vid,$baseInfo);die;
			$info=&$baseInfo['playurl'];
			$data=array('title'=>$info['title'],'img'=>$info['pic'],'seconds'=>$info['duration']);
			$args='&ctv=pc&m3v=1&termid=1&format=2&hwtype=un&ostype=Windows8.1&tag=letv&sign=letv&expect=0';
			$urls=array($info['domain'][1].$info['dispatch'][1000][0].$args,$info['domain'][1].$info['dispatch']['720p'][0].$args,$info['domain'][1].$info['dispatch']['1080p'][0].$args);
			foreach ($urls as &$item)
			{
				$item=str_replace('ios','no',$item);
			}
			list($normal,$high,$super)=self::httpGet($urls,60);
			$normal=json_decode($normal,true);
			$high=json_decode($high,true);
			$super=json_decode($super,true);
		}
		return false;
	}

	private static function getTkey($stime)
	{
		$key=773625421;
		$value=self::getLetvKey($stime,$key%13);
		$value=$value^$key;
		$value=self::getLetvKey($value,$key%17);
		return$value;
	}

	private static function getLetvKey($value,$key)
	{
		$i=0;
		while($i<$key)
		{
			$value=2147483647&$value>>1|($value&1)<<31;
			++$i;
		}
		return $value;
	}

	//音悦台视频解析
	private static function getYinYueTaiInfo($url)
	{
		$content=self::httpGet($url);
		$pattern='/property="og:title"[\s]+content="([^"]*)"\/>[\S\s]*?property="og:image" content="([^"]*)"\/>[\S\s]*?\/video\/(\d{6,8})"\/>/';
		if(preg_match_all($pattern,$content,$matches))
		{
			$title=$matches[1][0];
			$img=$matches[2][0];
			$id=$matches[3][0];
			$info=json_decode(self::httpGet("http://www.yinyuetai.com/api/info/get-video-urls?videoId={$id}"),true);
			$data=array('img'=>$img,'title'=>$title,'seconds'=>$info['duration'],'normal'=>array($info['hcVideoUrl']),'high'=>array($info['hdVideoUrl']),'super'=>array($info['heVideoUrl']));
			return $data;
		}
		return false;
	}

	//酷我音乐解析
	public static function getKuWoInfo($search,$index=0,$page=1,$pageSize=20)
	{
		if(is_numeric($search))
		{
			$url="http://antiserver.kuwo.cn/anti.s?response=url&type=convert_url&format=mp4|mp3|aac&rid=MUSIC_{$search}";
			return self::httpGet($url);
		}
		else if(substr($search,0,4)=='http' && preg_match_all('/\/(\d{6,7})\//',$search,$matches))
		{
			$id=$matches[1][0];
			return self::httpGet("http://antiserver.kuwo.cn/anti.s?response=url&type=convert_url&format=mp4|mp3|aac&rid=MUSIC_{$id}");
		}
		$url="http://search.kuwo.cn/r.s?all={$search}&rformat=json&encoding=utf8&pn={$page}&rn={$pageSize}";
		$json=json_decode(str_replace("'",'"',self::httpGet($url)),true);
		if($json)
		{
			if(is_int($index))
			{
				$id=isset($json['abslist'][$index]['MUSICRID'])?$json['abslist'][$index]['MUSICRID']:null;
				if($id)
				{
					return self::httpGet("http://antiserver.kuwo.cn/anti.s?response=url&type=convert_url&format=mp4|mp3|aac&rid={$id}");
				}
				return false;
			}
			return $json;
		}
		return false;

	}

	//百度音乐解析
	private static function getBaiduYinYueInfo()
	{

	}


	##############################辅助函数###########################

	private static function httpGet($urls,$expired=600,$timeout=5)
	{
		$headers=array('User-Agent'=>'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36','Accept'=>'*/*');
		$urls=is_array($urls)?$urls:array($urls);
		$key=md5(implode('',$urls));
		if($content=self::cacheGet($key))
		{
			return $content;
		}
		$mh=curl_multi_init();
		foreach ($urls as &$url)
		{
			$ch=curl_init($url);
			curl_setopt_array($ch,array(CURLOPT_HTTPHEADER=>$headers,CURLOPT_FOLLOWLOCATION=>1,CURLOPT_SSL_VERIFYPEER=>0,CURLOPT_RETURNTRANSFER=>1,CURLOPT_TIMEOUT=>$timeout,CURLOPT_CONNECTTIMEOUT=>$timeout));
			curl_multi_add_handle($mh,$ch);
			$url=$ch;
		}
		$runing=0;
		do
		{
			curl_multi_exec($mh,$runing);
			curl_multi_select($mh);
		}
		while($runing>0);
		foreach($urls as &$ch)
		{
			$content=curl_multi_getcontent($ch);
			curl_multi_remove_handle($mh,$ch);
			curl_close($ch);
			$ch=$content;
		}
		curl_multi_close($mh);
		$content=count($urls)>1?$urls:reset($urls);
		self::cacheSet($key,$content,$expired);
		return $content;
	}

	private static function cacheSet($key,$value,$expired=600)
	{
		if($key&&$value)
		{
			$filename=sys_get_temp_dir().DIRECTORY_SEPARATOR.'media.cache';
			$data=is_readable($filename)?unserialize(file_get_contents($filename)):array();
			$data[$key]=array('t'=>time()+intval($expired),'v'=>$value);
			file_put_contents($filename,serialize($data));
			return $data;
		}
	}

	private static function cacheGet($key)
	{
		$filename=sys_get_temp_dir().DIRECTORY_SEPARATOR.'media.cache';
		if(is_readable($filename))
		{
			$data=unserialize(file_get_contents($filename));
			$info=isset($data[$key])?$data[$key]:null;
			if($info)
			{
				if($info['t']>time())
				{
					return $info['v'];
				}
				else
				{
					unset($data[$key]);
					return file_put_contents($filename,serialize($data));
				}
			}
			return null;
		}
		return null;
	}

	private static function cacheClear()
	{
		$filename=sys_get_temp_dir().DIRECTORY_SEPARATOR.'media.cache';
		$data=is_readable($filename)?unserialize(file_get_contents($filename)):array();
		$time=time();
		foreach ($data as $key => $item)
		{
			if($item['t']<$time)
			{
				unset($data[$key]);
			}
		}
		return file_put_contents($filename,serialize($data));
	}

	function __destruct()
	{

	}

}