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

//require_once 'class/qq.class.php';

class video_qq_grab_module {

	public static $isgbk = false;
	
	public static function video_qq_grab() {
		$offset = 20 * max(1, intval($_GET['page'])) -20;
		if ($_GET['k'] =='9999.1') {
			$data['url'] = 'http://v.qq.com/x/funnylist/?sort=5&offset='.$offset.'&itype=963';
		}elseif ($_GET['k'] =='9999.2') {
			$data['url'] = 'http://v.qq.com/x/movielist/?cate=10001&offset='.$offset.'&sort=4';
		}elseif ($_GET['k'] =='9999.3') {//电视剧
			$data['url'] = 'http://v.qq.com/x/teleplaylist/?sort=4&offset='.$offset;
		}elseif ($_GET['k'] =='9999.4') {
			$data['url'] = 'http://v.qq.com/x/varietylist/?sort=5&offset='.$offset;
		}else {
			$data['url'] = 'http://v.qq.com/x/funnylist/?sort=5&offset='.$offset.'&itype=-1';
		}
		$res = lev_module::ismodule2('x_curl', 'doCurl', $data);
		$vdlist = strstr($res, 'figures_list');
		$vdarrs = explode('</ul>', $vdlist);
		$vdhtml = str_replace(array('src', 'r-lazyload'), array('lazyload', 'src'), '<ul class="'.$vdarrs[0].'</ul>');//echo $vdhtml;
		$vdhref = self::explode_url($vdhtml, 'http://v.qq.com');//print_r($vdhref);
		$vdsrcs = self::explode_img($vdhtml, 'http://v.qq.com');//print_r($vdsrcs);
		foreach ($vdsrcs['alt'] as $k => $r) {
			if (!$r || $vdhref['href'][$k] =='http://v.qq.com/') continue;
			$lists['lists'][] = array(
				'vdtype' => $_GET['k'],
				'sectime' => lev_base::levdiconv($vdhref['title'][$k]),
				'url' => urlencode($vdhref['href'][$k]),
				'title' => lev_base::levdiconv($r),
				'imgsrc' => $vdsrcs['src'][$k],
				'uptime' => TIMESTAMP - mt_rand(1000, 100000),
				'addtime' => TIMESTAMP - mt_rand(1000, 100000),
			);
		}//print_r($lists);
		return $lists;
	}
	
	public static function xgvd() {
		$url = trim(urldecode($_GET['url']));
		if ($_GET['k'] =='9999.3') {
			$res = lev_module::ismodule2('x_curl', 'doCurl', array('url'=>$url));
			$vdlist = strstr($res, '"mod_videolist"');
			$vdarrs = explode('</ul>', $vdlist);
			$vdhtml = $vdarrs[0];
			$vdhref = self::explode_url($vdhtml, 'http://v.qq.com');//print_r($vdhref);
			foreach ($vdhref['title'] as $k => $r) {
				if (!$r || $vdhref['href'][$k] =='http://v.qq.com/') continue;
				$lists[] = array(
					'vdtype' => $_GET['k'],
					'sectime' => lev_base::levdiconv($vdhref['title'][$k]),
					'url' => urlencode($vdhref['href'][$k]),
					'title' => $_GET['title'].'&'.lev_base::levdiconv($r),
					'imgsrc' => $vdsrcs['src'][$k],
					'uptime' => TIMESTAMP - mt_rand(1000, 100000),
					'addtime' => TIMESTAMP - mt_rand(1000, 100000),
				);
			}//print_r($lists);
		}else {
			$vid = lev_module::ismodule2('video_qq', 'vdvid', $url);
			$data['url'] = 'http://like.video.qq.com/fcgi-bin/like?callback=jQuery'.TIMESTAMP.'&low_login=1&tablist=9&playright=2&size=24&uin=0&otype=json&msgtype=52&id='.$vid.'&_='.TIMESTAMP;
			$res = lev_module::ismodule2('x_curl', 'doCurl', $data);
			$json = strstr($res, '({');
			$info = lev_module::ismodule2('x_curl', 'jsondcode', $json);//print_r($info);
			foreach ($info['tablist'][0]['cover_info'] as $r) {
				$cmnum = intval(substr($r['vv'], 1, 3)) +123;
				$lists[] = array(
					'vdtype' => $_GET['k'],
					'sectime' => lev_class::sectime($r['timelong']),
					'url' => urlencode($r['playurl']),
					'title' => $r['title'],
					'imgsrc' => $r['picurl'],
					'hitnum' => $r['vv'],
					'cmnum' => $cmnum,
					'uptime' => TIMESTAMP - mt_rand(1000, 100000),
					'addtime' => TIMESTAMP - mt_rand(1000, 100000),
				);
			}
		}
		return $lists;
	}

	public static function explode_img($str, $curl) {
		if (stripos($str, '<img') ===FALSE) return FALSE;
		$con = str_ireplace(array("\r\n", "\r", "\n"), '', $str);
		$imgarr = explode('<img', $con);
		if (strpos($str, '<IMG') !==FALSE) {
			$imgarr2 = explode('<IMG', $con);
			$imgarr  = array_merge((array)$imgarr, (array)$imgarr2);
		}
		$pattern = "/<(img|IMG).*?src.*?=.*?[\'|\"](.*?(?:[\.gif|\.jpg|\.png]).*?)[\'|\"].*?[\/]?>/";
		$pattern = "/<(img|IMG).*?src.*?=.*?(.*?(?:[\.gif|\.jpg|\.png|^('\")]).*?)['\"|\s+].*?[\/]?>/";
		$pattalt = "/<(img|IMG).*?(alt|title).*?=.*?['\"](.*?)['\"].*?[\/]?>/";
		foreach ($imgarr as $r) {
			$one = explode('>', $r);
			if (stripos($one[0], 'src') ===FALSE) continue;
			$img = '<img '.$one[0].'>';
			preg_match_all($pattern, $img, $src, PREG_INTERNAL_ERROR);//print_r($src);
			$src = str_ireplace(array('"', "'"), '', trim($src[2][0]));
			if (in_array($src, $imgs[2]) || !$src) continue;
			preg_match_all($pattalt, $img, $alt, PREG_INTERNAL_ERROR);//print_r($alt);
			//$alt = lev_base::levdiconv(str_ireplace(array('"', "'"), '', trim(self::ckgbk($alt[3][0]))));
			$alt = $alt[3][0];
			$src = self::fullurl($src, $curl);
			$imgs['alt'][] = $alt;
			$imgs['src'][] = $src;
			$imgs['html'][] = '<img src="'.$src.'" alt="'.$alt.'" title="'.$alt.'">';
			$imgs['localsrc'][] = $src;
		}
		return $imgs;
	}
	
	public static function explode_url($str, $curl) {
		if (stripos($str, '<a') ===FALSE) return FALSE;
		$con = str_ireplace(array("\r\n", "\r", "\n", "%>"), ' ', $str);
		$con = str_replace(array('<A', '</A>'), array('<a', '</a>'), $con);
		$aarr = explode('<a', $con);
		$pattern = "/<(a|A).*?href.*?=.*?[\'|\"](.*?)[\'|\"].*?[\/]?>/";
		$pattern = "/<(a|A).*?href.*?=.*?(.*?(?:[a-zA-Z|^('\")]).*?)['\"|\s+].*?[\/]?>/";
		$pattalt = "/<(a|A).*?(alt|title).*?=.*?[\'|\"](.*?)[\'|\"].*?[\/]?>/";
		foreach ($aarr as $r) {
			if (stripos($r, 'href') ===FALSE) continue;
			$one = explode('</a>', $r);
			//$one[0] = self::ckgbk($one[0]);
			//$tits   = explode('>', $one[0]);
			//$title  = trim($tits[1]);
			$a = '<a '.$one[0].'</a>';
			$title = trim(strip_tags($a));
			if (!$title) {
				preg_match_all($pattalt, $a, $_tit, PREG_INTERNAL_ERROR);
				$title = $_tit[3][0];
			}
			preg_match_all($pattern, $a, $href, PREG_INTERNAL_ERROR);//print_r($href);
			$href = trim($href[2][0]);
			if (stripos($href, 'javascript:') !==FALSE || stripos($href, '<') !==FALSE || stripos($href, '.htm') ===FALSE) continue;
			$href = str_ireplace(array('"', "'"), '', $href);
			$href = self::fullurl($href, $curl);
			if (in_array($href, $as['href'])) {
				if (floatval($title) >1 && strlen($title) <4) {
					foreach ($as['href'] as $k => $v) {
						if ($href ==$v) {
							unset($as['title'][$k], $as['href'][$k], $as['html'][$k]);
							break;
						}
					}
				}else {
					continue;
				}
			}
			$title = lev_base::levdiconv($title);
			$as['title'][] = $title;
			$as['href'][] = $href;
			$as['html'][] = '<a class="cg2c" href="'.$href.'" title="'.$title.'" target=_blank>'.$title.'</a>';
		}
		return $as;
	}
	public static function fullurl($a, $curl) {
		if (substr($a, 0, 4) =='http') {
			$fullurl = $a;
		}else {
			$str2 = substr($a, 0, 2);
			if (substr($a, 0, 1) =='/') {
				$urls = explode('/', $curl);
				$fullurl = $urls[0].'//'.$urls[2].'/'.$a;
			}elseif ($str2 =='./' || substr($a, 0, 1) !='/') {
				$basesrc = self::baseurl($curl);
				$fullurl = $basesrc.$a;
			}
		}
		//$fullurl = str_replace(array('//', '/./', '/../'), '/', $fullurl);
		return $fullurl;
	}
	public static function baseurl($curl, $domain =0) {
		$urls = explode('/', $curl);//print_r($urls);
		if ($domain) return $urls[0].'//'.$urls[2];
		$num  = count($urls);
		if ($num >3 && strpos(end($urls), '.') !==FALSE) {
			array_pop($urls);
		}
		foreach ($urls as $v) {
			$baseurl .= $v.'/';
		}
		$baseurl = str_replace('//', '/', $baseurl);
		$baseurl = str_replace(':/', '://', $baseurl);
		return $baseurl;
	}
	public static function ckgbk($arr) {
		$str = is_array($arr) ? $arr[0] : $arr;
		$ckgbk = json_encode($str);
		if ($ckgbk ==="null" || self::$isgbk) {
			$arr = lev_base::levdiconv($arr, 'gbk', 'utf-8');
		}
		return $arr;
	}
	public static function isgbk($html) {
		$charset = stristr($html, 'charset');
		$one = explode('>', $charset);
		if (stripos($one[0], 'gbk') !==FALSE || stripos($one[0], 'gb2312') !==FALSE) self::$isgbk = TRUE;
	}
}







