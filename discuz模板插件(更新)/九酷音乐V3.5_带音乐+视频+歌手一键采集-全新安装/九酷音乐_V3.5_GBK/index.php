<?php
include "source/global/global_conn.php";
include "source/global/global_inc.php";
$qianwei=explode("/",isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO']:NULL);
switch(isset($qianwei[1])?$qianwei[1]:NULL){
	case 'page':
	  	if(!IsNum($qianwei[2])){die(html_message("错误信息","参数传递错误"));}
	  	$cache_id="page_".$qianwei[2];
	  	if(!($cache_opt->start($cache_id))){
        		SpanmusicPage($qianwei[2]);
        		$cache_opt->end();
	  	}
		break;
	case 'list':
	  	if(!IsNum($qianwei[2])){die(html_message("错误信息","参数传递错误"));}
	  	$cache_id="list_".$qianwei[2].$qianwei[3];
	  	if(!($cache_opt->start($cache_id))){
        		SpanmusicList($qianwei[2]);
        		$cache_opt->end();
	  	}
		break;
	case 'song':
		if(!IsNum($qianwei[2])){die(html_message("错误信息","参数传递错误"));}
		$cache_id="play_".$qianwei[2];
		if(!($cache_opt->start($cache_id))){
			SpanmusicPlay($qianwei[2]);
			$cache_opt->end();
		}
		break;
	case 'class':
		if(!IsNum($qianwei[2])){die(html_message("错误信息","参数传递错误"));}
		$cache_id="videolist_".$qianwei[2].$qianwei[3];
		if(!($cache_opt->start($cache_id))){
			SpanvideoList($qianwei[2]);
			$cache_opt->end();
		}
		break;
	case 'video':
		if(!IsNum($qianwei[2])){die(html_message("错误信息","参数传递错误"));}
		$cache_id="video_".$qianwei[2];
		if(!($cache_opt->start($cache_id))){
			SpanvideoIntro($qianwei[2]);
			$cache_opt->end();
		}
		break;
	case 'album':
		if(!IsNum($qianwei[2])){die(html_message("错误信息","参数传递错误"));}
		$cache_id="special_".$qianwei[2];
		if(!($cache_opt->start($cache_id))){
			SpanmusicSpecial($qianwei[2]);
			$cache_opt->end();
		}
		break;
	case 'singer':
		if(!IsNum($qianwei[2])){die(html_message("错误信息","参数传递错误"));}
		$cache_id="singer_".$qianwei[2];
		if(!($cache_opt->start($cache_id))){
			SpanmusicSinger($qianwei[2]);
			$cache_opt->end();
		}
		break;
	case 'down':
		if(!IsNum($qianwei[2])){die(html_message("错误信息","参数传递错误"));}
		$cache_id="down_".$qianwei[2];
		if(!($cache_opt->start($cache_id))){
			SpanmusicDown($qianwei[2]);
			$cache_opt->end();
		}
		break;
	default:
		if(cd_webhtml==1 || !file_exists("index.html")){
		        $cache_id="index_";
			if(!($cache_opt->start($cache_id))){
				echo GetTemp("index.html",0);
				$cache_opt->end();
			}
		}else{
			header("Location:index.html");
		}
		break;
}
?>