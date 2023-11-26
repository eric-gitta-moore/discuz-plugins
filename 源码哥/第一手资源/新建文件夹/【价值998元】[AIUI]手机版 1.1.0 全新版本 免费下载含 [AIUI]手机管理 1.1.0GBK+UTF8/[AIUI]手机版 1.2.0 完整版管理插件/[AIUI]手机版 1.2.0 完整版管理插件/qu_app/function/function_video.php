<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function vgetaudio($str){
	if(strpos($str,'.mp3') || strpos($str,'.wav') || strpos($str,'.ogg') || strpos($str,'.m4a')){
		return '<audio id="audio_id" style="width:100%" preload="auto" src="'.$str.'"></audio>';
	}else{
		return '';
	}
}
function vgetaudiomusic($str){
	if(strpos($str,'.mp3') || strpos($str,'.wav') || strpos($str,'.ogg') || strpos($str,'.m4a')){
		return '<audio id="audio_id" style="width:100%" preload="auto" src="'.$str.'"></audio>';
	}else{
		return '';
	}
}

function vgetvideo($str,$width,$height,$cover){
	if(strpos($str,'.mp4') || strpos($str,'.webm') || strpos($str,'.ogv') || strpos($str,'.m3u8')){//mp4视频
			$videolink = '<link href="./source/plugin/qu_app/video/video-js.min.css" rel="stylesheet" type="text/css">'.'<script src="./source/plugin/qu_app/video/video.min.js"></script><style>.video-js{width:'.$width.' !important; height:'.$height.'px !important;}</style>';
			return $videolink.'<div class="aiim_video cl"><video id="example_video_1" class="video-js vjs-default-skin" controls preload="none" poster="'.$cover.'" data-setup="{}"><source src="'.$str.'" type="video/mp4" /></video></div>';
		
		}elseif(strpos($str,'youku.com')){//优酷
			if(strpos($str,'player.youku.com')){
				$videoid = explode('sid/',$str);
				$videoid = explode('/',$videoid[1]);
				$videoid = $videoid[0];
				return '<div class="aiim_video cl"><iframe height="'.$height.'" width="'.$width.'" src="http://player.youku.com/embed/'.$videoid.'" frameborder=0 allowfullscreen></iframe></div>';
			}else{
				if(strpos($str,'v.youku.com')){
					$videoid = explode('id_',$str);
					$videoid = explode('.',$videoid[1]);
					$videoid = $videoid[0];
					return '<div class="aiim_video cl"><iframe height="'.$height.'" width="'.$width.'" src="http://player.youku.com/embed/'.$videoid.'" frameborder=0 allowfullscreen></iframe></div>';
				}else{
					$videoid = explode('vid=',$str);
					$videoid = $videoid[1];
					return '<div class="aiim_video cl"><iframe height="'.$height.'" width="'.$width.'" src="http://player.youku.com/embed/'.$videoid.'" frameborder=0 allowfullscreen></iframe></div>';
				}
			}
		
		}elseif(strpos($str,'ku6.com')){//酷6
			if(strpos($str,'player.ku6.com')){
				$videoid = explode('refer/',$str);
				$videoid = explode('/v',$videoid[1]);
				$videoid = $videoid[0];
				return '<div class="aiim_video cl"><script data-vid="'.$videoid.'" src="http://player.ku6.com/out/v.js" data-height="'.$height.'" data-width="'.$width.'"></script></div>';
			}elseif(strpos($str,'v.ku6.com') || strpos($str,'m.ku6.com')){
				$videoid = explode('/show/',$str);
				$videoid = explode('.html',$videoid[1]);
				$videoid = $videoid[0];
				return '<div class="aiim_video cl"><script data-vid="'.$videoid.'" src="http://player.ku6.com/out/v.js" data-height="'.$height.'" data-width="'.$width.'"></script></div>';
			}
		
		
		
		}elseif(strpos($str,'wasu.cn')){//华数
			$videoid = explode('id/',$str);
			$videoid = $videoid[1];
			return '<div class="aiim_video cl"><iframe src="http://www.wasu.cn/Play/iframe/id/'.$videoid.'&auto=0" height="'.$height.'" width="'.$width.'" frameborder="0" allowfullscreen=""></iframe></div>';

		}elseif(strpos($str,'qq.com')){//腾讯
			if(strpos($str,'imgcache.qq.com')){
				$videoid = explode('vid=',$str);
				$videoid = explode('&',$videoid[1]);
				$videoid = $videoid[0];
				return '<div class="aiim_video cl"><iframe src="https://v.qq.com/iframe/player.html?vid='.$videoid.'&tiny=1&auto=0" height="'.$height.'" width="'.$width.'" frameborder="0" allowfullscreen=""></iframe></div>';
			}elseif(strpos($str,'v.qq.com')){
				if(strpos($str,'m.v.qq.com/play')){
					$videoid = explode('vid=',$str);
					$videoid = explode('&',$videoid[1]);
					$videoid = $videoid[0];
					return '<div class="aiim_video cl"><iframe src="https://v.qq.com/iframe/player.html?vid='.$videoid.'&tiny=1&auto=0" height="'.$height.'" width="'.$width.'" frameborder="0" allowfullscreen=""></iframe></div>';
				}elseif(strpos($str,'m.v.qq.com/x')){
					$videoid = explode('/',$str);
					$videoid = explode('.',$videoid[7]);
					$videoid = $videoid[0];
					return '<div class="aiim_video cl"><iframe src="https://v.qq.com/iframe/player.html?vid='.$videoid.'&tiny=1&auto=0" height="'.$height.'" width="'.$width.'" frameborder="0" allowfullscreen=""></iframe></div>';
				}elseif(strpos($str,'v.qq.com/x/cover')){
					$videoid = explode('.htm',$str);
					$videoid = explode('/',$videoid[0]);
					$videoid = $videoid[6];
					return '<div class="aiim_video cl"><iframe src="https://v.qq.com/iframe/player.html?vid='.$videoid.'&tiny=1&auto=0" height="'.$height.'" width="'.$width.'" frameborder="0" allowfullscreen=""></iframe></div>';
				}elseif(strpos($str,'v.qq.com/iframe/')){
					$videoid = explode('vid=',$str);
					$videoid = explode('&',$videoid[1]);
					$videoid = $videoid[0];
					return '<div class="aiim_video cl"><iframe src="https://v.qq.com/iframe/player.html?vid='.$videoid.'&tiny=1&auto=0" height="'.$height.'" width="'.$width.'" frameborder="0" allowfullscreen=""></iframe></div>';
				}else{
					$videoid = explode('page/',$str);
					$videoid = explode('.',$videoid[1]);
					$videoid = $videoid[0];
					return '<div class="aiim_video cl"><iframe src="https://v.qq.com/iframe/player.html?vid='.$videoid.'&tiny=1&auto=0" height="'.$height.'" width="'.$width.'" frameborder="0" allowfullscreen=""></iframe></div>';
				}
			}
		
		}else{
			return '';
		}

}