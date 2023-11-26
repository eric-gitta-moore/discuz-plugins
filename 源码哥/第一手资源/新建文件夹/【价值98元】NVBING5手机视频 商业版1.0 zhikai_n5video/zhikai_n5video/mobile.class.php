<?php


if(!defined('IN_DISCUZ')){
	exit('Access Denied');
}

class mobileplugin_zhikai_n5video {
	function discuzcode($value){
		global $_G;
$ym_copyright = DB::fetch_first("select name,copyright from ".DB::table('common_plugin')." where identifier='zhikai_n5video'");
if(!strstr($ym_copyright['copyright'],base64_decode('eW'.'1n'.'Ng='.'=')) and !strstr($_G['siteurl'],base64_decode('MT'.'I3Lj'.'AuM'.'C4x')) and !strstr($_G['siteurl'],base64_decode('bG'.'9jYWx'.'ob3'.'N0'))){ echo '&#x'.'672'.'c;&#'.'x595'.'7;&#x'.'6a21;&#'.'x7248;&#x6'.'62f;&#x76'.'d7;&#x5'.'356'.';&#x4efd;'.'&#x5b50'.';&#x8f6c;&'.'#x8f7d;&'.'#x4e8e;<a href="'.base64_decode('aH'.'R'.'0cD'.'ov'.'L3d3dy'.'55bWc2'.'LmNvbS8=').'">&#x6e90'.';&#x7801'.';&#x54e5;</a>&#xff0c;&#x8bf7;&#x652f;&#'.'x6301;&#x6e90;&#x7801;'.'&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtODg0MC0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&'.'#x524d;&#x5f'.'80;&'.'#x6e90;&#x7801;&#x54e5;&#x4e0b;&#x8f7d;</a>&#x67'.'2c;&#'.'x5957;'.$ym_copyright['name'].'&#x63d2;&#x4ef6;';exit;}
		if($value['caller'] == 'discuzcode'){
			$message = $_G['discuzcodemessage'];
			/*
 *讯幻网：www.xhkj5.com
 *更多商业插件/模版免费下载 就在讯幻网
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */
			$pattern = "/(\[media|\[flash)(.*?)\](http|https)\:\/\/([a-zA-Z0-9\.]+)\.qq\.com\/(.*?)vid=(.*?)\[\/(media|flash)\]/";
			$replacement = '<iframe frameborder="0" src="http://v.qq.com/iframe/player.html?vid=\6&auto=0" style="'.$this->default_style().'"></iframe>';
			$message = preg_replace($pattern, $replacement, $message);
			/* MP3解析 */
			$pattern = '/\[audio(.*?)\](.*?)\.mp3\[\/audio\]/';
			$message = preg_replace_callback($pattern, array($this, 'parse_mp3'),$message );
			/* 土豆解析 */
			$pattern = '/\[flash(.*?)\]http:\/\/www\.tudou\.com(.*?)\[\/flash\]/';
			$message = preg_replace_callback($pattern, array($this, 'parse_tudou'),$message );
			/* 优酷解析 */
			$pattern = "/(\[media|\[flash)(.*?)\]http\:\/\/(v|player)\.youku\.com(.*?)(id_|sid\/)(.*?)(\.|\/)(.*?)\[\/(media|flash)\]/";
			$replacement = '<iframe src="http://player.youku.com/embed/\6" frameborder=0 allowfullscreen style="'.$this->default_style().'"></iframe>';
			$message = preg_replace($pattern, $replacement, $message);
			/* iqiyi解析 */
			$pattern = "/(\[media|\[flash)(.*?)\]http\:\/\/player\.video\.qiyi\.com\/(.*?)\/(.*?)\/(.*?)\/(.*?)\.swf(.*?)\[\/(media|flash)\]/";
			$message = preg_replace_callback($pattern, array($this, 'parse_iqiyi'),$message );

			$_G['discuzcodemessage'] = $message;
		}
	}

	public function default_style(){
		global $_G;
		$set = $_G['cache']['plugin']['zhikai_n5video'];
		$width = $set['width']?$set['width']."px":"100%";
		$height = $set['height']?$set['height']."px":"230px";
		return "width:{$width};height:{$height}; margin:10px 0;";
	}

	public function parse_iqiyi($matches){
		if(count($matches) == 9 && $matches[3] && $matches[6]){
			$url = 'http://www.iqiyi.com/'.$matches[6].'.html';
			$html = dfsockopen($url);
			preg_match('/tvId:(\d+),/',$html,$tvid);
			if(!$tvid || !$tvid[1]) return $matches[0];
			$tvid = $tvid[1];
			return '<iframe src="http://open.iqiyi.com/developer/player_js/coopPlayerIndex.html?vid='.$matches[3].'&tvId='.$tvid.'" frameborder="0" allowfullscreen="true" style="'.$this->default_style().'"></iframe>';
		}else{
			return $matches[0];
		}
	}

	public function parse_tudou($matches){
		global $_G;
		if($matches[2]){
			$url  = 'http://www.tudou.com'.$matches[2];
			$parse_url = $this->parse_tudouicode($url);
			if($parse_url){
				return '<iframe src="'.$parse_url.'" allowtransparency="true" allowfullscreen="true" allowfullscreenInteractive="true" scrolling="no" border="0" frameborder="0" style="'.$this->default_style().'"></iframe>';
			}else{
				return $matches[0];
			}
		}else{
			return $matches[0];
		}
	}

	public function parse_tudouicode($url){
		global $_G;
		$url = html_entity_decode($url);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$content = curl_exec($ch);
		$info = curl_getinfo($ch);
		if(!$info['url'] || $info['url'] == $url){
			preg_match('/Location: (.*?)\n/',$content,$ma);
			$info['url'] = $ma[1];
		}
		$p = '/(.*?)&code=(\w+)&(.*?)/';
		preg_match($p,$info['url'],$matches);
		if(!$matches || !$matches[2]) return false;
		return 'http://www.tudou.com/programs/view/html5embed.action?code='.$matches[2];
	}

	public function parse_mp3($matches){
		global $_G;
		if($matches[2]){
			$url  = $matches[2].".mp3";
			return '<audio controls="controls" style="width:100%;margin:10px 0;"><source src="'.$url.'" type="audio/mpeg"></audio>';
			
		}else{
			return $matches[0];
		}
	}
}

?>