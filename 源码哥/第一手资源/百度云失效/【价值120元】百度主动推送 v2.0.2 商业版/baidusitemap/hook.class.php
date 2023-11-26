<?php
/*
 * 主页：Www.fx8.cc
 * 源码哥源码论坛 全网首发 http://www.fx8.cc
 * 技术支持/更新维护：QQ 154606914
 * From www_FX8_co
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_baidusitemap {

}
class plugin_baidusitemap_forum extends plugin_baidusitemap {
	function viewthread_top_output(){
		global $_G;
		if(!isset($_G['thread']['tobaidu'])) return '<!--BS Table Error -->';//forum_threads中字段缺失
		if($_G['thread']['tobaidu']) return '<!--BS To Baidu OK @'.date('Y-m-d H:i:s',$_G['thread']['todate']).'-->';//已经成功推送
		if(!function_exists('curl_init')||!function_exists('curl_setopt_array')||!function_exists('curl_exec')) return '<!--BS No CURL-->';//环境不支持
		$over='';
		if(DISCUZ_VERSION=='X2'){
			$filepath=DISCUZ_ROOT.'./data/cache/cache_baidusitemap_over.php';
		}else{
			$filepath=DISCUZ_ROOT.'./data/sysdata/cache_baidusitemap_over.php';
		}
		if(file_exists($filepath)){
			@require_once $filepath;
		}
		if($over==date('Ymd')) return '<!--BS Over Quota -->';//当日推送已满
		loadcache('plugin');
		$vars=$_G['cache']['plugin']['baidusitemap'];
		$type=intval($vars['type']);
		$forums=unserialize($vars['forums']);
		if(!in_array($_G['fid'],$forums)) return '<!--BS filter forums -->';//该版块未开启
		$today=intval($vars['today']);
		if($today&&intval(date('H'))<18){//开启了今日优先推送
			if(date('Ymd',$_G['thread']['dateline'])!=date('Ymd',TIMESTAMP)) return '<!--BS filter today -->';
		}
		$domain=trim($vars['domain']);
		$token=trim($vars['token']);
		if(!$domain||!$token) return '<!-- Error Setting-->';//配置缺失
		if(in_array('forum_viewthread',$_G['setting']['rewritestatus'])){
			$url=$_G['siteurl'].str_replace(array('{tid}','{page}','{prevpage}'),array($_G['tid'],1,1),$_G['setting']['rewriterule']['forum_viewthread']);
		}else{
			$url=$_G['siteurl'].'forum.php?mod=viewthread&tid='.$_G['tid'];
		}
		if(!$type) $api = 'http://data.zz.baidu.com/urls?site='.$domain.'&token='.$token;
		else $api = 'http://data.zz.baidu.com/urls?site='.$domain.'&token='.$token.'&type=original';
		$ch = curl_init();
		$options =  array(
			CURLOPT_URL => $api,
			CURLOPT_POST => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POSTFIELDS => $url,
			CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
		);
		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);
		$json=json_decode($result,true);
		if(isset($json['success'])&&$json['success']==1){
			DB::update('forum_thread',array('tobaidu'=>1,'todate'=>TIMESTAMP),array('tid'=>$_G['tid']));
			C::t('forum_thread')->clear_cache(array($_G['tid']));
			if(isset($json['remain'])){
				$max=0;
				if(DISCUZ_VERSION=='X2'){
					$filepath=DISCUZ_ROOT.'./data/cache/cache_baidusitemap_remain.php';
				}else{
					$filepath=DISCUZ_ROOT.'./data/sysdata/cache_baidusitemap_remain.php';
				}
				if(file_exists($filepath)){
					@require_once $filepath;
				}
				$remain=intval($json['remain']);
				$max=max($remain+1,$max);
				@require_once libfile('function/cache');
				$cacheArray = "\$remain=".$remain.";\n";
				$cacheArray.= "\$max=".$max.";\n";
				writetocache('baidusitemap_remain',$cacheArray);//记录每日运行推送最大数，可近日剩余数
			}
			return '<!--BS Doing To Baidu -->';			
		}elseif(isset($json['error'])&&$json['error']=='400'&&$json['message']=='over quota'){//当日推送已满
			@require_once libfile('function/cache');
			$cacheArray= "\$over='".date('Ymd')."';\n";
			writetocache('baidusitemap_over',$cacheArray);
		}else{//其他错误 
			return '<!--BS Other Error : '.$result.' -->';
		}
		return '';
	}
}
//QQ 25 75 16 37 78  www-FX8-Co
?>