<?php
/**
 * ONEXIN HTML5 PLAYER For Discuz!X 2.0+
 * ============================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * @package    onexin_html5player
 * @module	   html5player 
 * @date	   2017-11-10
 * @author	   King
 * @copyright  Copyright (c) 2017 Onexin Platform Inc. (http://www.onexin.com)
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

/*
//--------------Tall us what you think!----------------------------------
*/

function _onexin_html5player($html, $vtag = 'html5video') {
	global $_G;
	$search = $replace = array();
	
	$tag = 'html5video';
	$search[] = "/\[".$vtag."(=(.*?))?\]\s*([^\[\<\r\n]+?)\s*\[\/".$vtag."\]/i";
	$replace[] = "[".$tag."]\\3[/".$tag."]";
		
	$tag_s = "\[".$tag."\]";
	$tag_e = ".*?\[\/".$tag."\]";//[&|\?]?
	$video_s = '<video class="html5video video-js" src="';
	$video_e = '" controls="" preload="auto" poster=""></video>';
	$iframe_s = '<iframe class="html5video" src="';
	$iframe_e = '" frameborder="0" scrolling="no" allowfullscreen></iframe>';
	
		$search[] = "/\[media(=([\w,]+))?\]\s*([^\[\<\r\n]+?)\s*\[\/media\]/i";
		$replace[] = "[".$tag."]\\3[/".$tag."]";
		if($_G['cache']['plugin']['onexin_html5player']['flashconvert']) {
			$search[] = "/\[flash(=(\w+|\d+,\d+))?\]\s*([^\[\<\r\n]+?)\s*\[\/flash\]/i";
			$replace[] = "[".$tag."]\\3[/".$tag."]";
		}
		
		$search[] = "/\[".$tag."\]\s*([^\[\<\r\n]+?\.(mp4|m3u8).*?)\s*\[\/".$tag."\]/i";
		$replace[] = $video_s."\\1".$video_e;
        
	//$html = preg_replace($search, $replace, $html);	
	//$search = $replace = array();
    
	// video 
	$search[] = "/".$tag_s."https?:\/\/www.miaopai.com\/show\/([^\/]+)\.htm".$tag_e."/i";
	$replace[] = $video_s.'http://gslb.miaopai.com/stream/\\1.mp4'.$video_e;
	$search[] = "/".$tag_s."https?:\/\/video.sina.com.cn\/share\/video\/\d+\.swf.*?ipad_vid=([^\/&]+)".$tag_e."/i";
	$replace[] = $video_s.'http://ask.ivideo.sina.com.cn/v_play_ipad.php?vid=\\1&tags=h5_jsplay'.$video_e;	
	
	// iframe	
	$search[] = "/".$tag_s."https?:\/\/youtu.be\/([^\/&]+)".$tag_e."/i";
	$replace[] = $iframe_s.'https://www.youtube.com/embed/\\1'.$iframe_e;	
	$search[] = "/".$tag_s."https?:\/\/www.youtube.com\/v\/([^\/&]+)".$tag_e."/i";
	$replace[] = $iframe_s.'https://www.youtube.com/embed/\\1'.$iframe_e;	
	$search[] = "/".$tag_s."https?:\/\/www.youtube.com\/watch\?v=([^\/&]+)".$tag_e."/i";
	$replace[] = $iframe_s.'https://www.youtube.com/embed/\\1'.$iframe_e;	
	$search[] = "/".$tag_s."https?:\/\/www.youtube.com\/embed\/([^\/&]+)".$tag_e."/i";
	$replace[] = $iframe_s.'https://www.youtube.com/embed/\\1'.$iframe_e;	
	
	// tudou
	$search[] = "/".$tag_s."http:\/\/www.tudou.com\/programs\/view\/([^\/\?]+)\/".$tag_e."/i";
	$replace[] = $iframe_s.'http://www.tudou.com/programs/view/html5embed.action?type=0&code=\\1&lcode=&resourceId=119693922_06_05_99'.$iframe_e;
	$search[] = "/".$tag_s."http:\/\/www.tudou.com\/(listplay|albumplay)\/([^\/]+)\/([^\/\?\.]+)".$tag_e."/i";
	$replace[] = $iframe_s.'http://www.tudou.com/programs/view/html5embed.action?type=0&code=\\3&lcode=\\2&resourceId=119693922_06_05_99'.$iframe_e;
	$search[] = "/".$tag_s."http:\/\/www.tudou.com\/[v|a]\/([^\/]+)\/([^\/]+)\/v.swf".$tag_e."/i";
	$replace[] = $iframe_s.'http://www.tudou.com/programs/view/html5embed.action?type=0&code=\\1&lcode=\\2'.$iframe_e;
	$search[] = "/".$tag_s."https?:\/\/video.tudou.com\/v\/([^\/]+).html".$tag_e."/i";
	$replace[] = $iframe_s.'https://player.youku.com/embed/\\1?autoplay=false'.$iframe_e;	
	
	// youku
	$search[] = "/".$tag_s."https?:\/\/v.youku.com\/v_show\/id_([^\/]+).html".$tag_e."/i";
	$replace[] = $iframe_s.'https://player.youku.com/embed/\\1?autoplay=false'.$iframe_e;	
	$search[] = "/".$tag_s."https?:\/\/player.youku.com\/player.*?\/sid\/([^\/]+)\/v.swf".$tag_e."/i";
	$replace[] = $iframe_s.'https://player.youku.com/embed/\\1?autoplay=false'.$iframe_e;	
	$search[] = "/".$tag_s."https?:\/\/player.youku.com\/embed\/(\w+==)".$tag_e."/i";
	$replace[] = $iframe_s.'https://player.youku.com/embed/\\1?autoplay=false'.$iframe_e;	
	
	// qq
	$search[] = "/".$tag_s."https?:\/\/[^\/]+.qq.com\/x\/.*?\/(\w+)\.html".$tag_e."/i";
	$replace[] = $iframe_s.'https://v.qq.com/iframe/player.html?vid=\\1&auto=0'.$iframe_e;
	$search[] = "/".$tag_s."https?:\/\/[^\/]+.qq.com\/.*?vid=(\w+)".$tag_e."/i";
	$replace[] = $iframe_s.'https://v.qq.com/iframe/player.html?vid=\\1&auto=0'.$iframe_e;
	
	// iqiyi
	$search[] = "/".$tag_s."https?:\/\/[^\/]+.iqiyi.com\/.*?vid=([^\/]+)".$tag_e."/i";
	$replace[] = $iframe_s.'http://m.iqiyi.com/openplay.html?vid=\\1'.$iframe_e;
	
	// bilibili
	$search[] = "/".$tag_s."https?:\/\/share.acg.tv\/\w+\.swf\?([^\/\[\<]+)".$tag_e."/i";
	$replace[] = $iframe_s.'https://www.bilibili.com/blackboard/html5player.html?as_wide=1&\\1'.$iframe_e;
	$search[] = "/".$tag_s."https?:\/\/static.hdslb.com\/\w+\.swf\?([^\/\[\<]+)".$tag_e."/i";
	$replace[] = $iframe_s.'https://www.bilibili.com/blackboard/html5player.html?as_wide=1&\\1'.$iframe_e;
	$search[] = "/".$tag_s."https?:\/\/[^\/]+.bilibili.com\/.*?cid=([^\/\[\<]+)".$tag_e."/i";
	$replace[] = $iframe_s.'https://www.bilibili.com/blackboard/html5player.html?as_wide=1&cid=\\1'.$iframe_e;
	
		$html = preg_replace("/\[".$tag."\]\s*([^\[\<\r\n]+?\.swf.*?)\s*\[\/".$tag."\]/i", '[flash]\\1[/flash]', $html);
			    
	$html = preg_replace($search, $replace, $html);	     
	
	if(preg_match("/ class=\"html5video/", $html)){
		$html = preg_replace("/<!--html5player-->.*?<!--\/html5player-->/is", "", $html);
		$_G['cache']['plugin']['onexin_html5player']['html5code'] = str_replace(array("\n", "\r"), "", $_G['cache']['plugin']['onexin_html5player']['html5code']);
		$html = '<!--html5player--><script src="'.$_G['siteurl'].'source/plugin/onexin_html5player/open/video.js"></script><link href="'.$_G['siteurl'].'source/plugin/onexin_html5player/open/video.css" rel="stylesheet">'.$_G['cache']['plugin']['onexin_html5player']['html5code'].'<!--/html5player-->'.$html;
	}
	
	return $html;
}
