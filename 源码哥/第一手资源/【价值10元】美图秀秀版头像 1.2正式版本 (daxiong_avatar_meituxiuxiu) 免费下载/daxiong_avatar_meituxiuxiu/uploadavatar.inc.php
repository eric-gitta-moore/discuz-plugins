<?php

/*
 *源    码 哥    y   m     g   6 . c   o    m
 *更多商业插件/模版免费下载 就在源     码   哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */
if(!defined('IN_DISCUZ')) {
        exit('Access Denied');
}
require_once './source/class/class_core.php';
require_once './source/function/function_cache.php';
$discuz = & discuz_core::instance();
$discuz->init();
global $_G;
$uid=intval($_POST['uid']);
if (!$_FILES['Filedata']) {
	die ( 'Image data not detected!' );
}

if ($_FILES['Filedata']['error'] > 0) {
	switch ($_FILES ['Filedata'] ['error']) {
		case 1 :
			$error_log = 'phpallow';
			break;
		case 2 :
			$error_log = 'sizeallow';
			break;
		case 3 :
			$error_log = 'onlytype';
			break;
		case 4 :
			$error_log = 'nofile';
			break;
		default :
			break;
	}
	die ($error_log);
} else {
       
	   $config = array(
	        "uploadPath" => get_avatar_url($uid) , //保存路径
	        "fileSize" => 10000, //文件大小限制，单位KB
	   "fileType" => array( ".gif" , ".png" , ".jpg" , ".jpeg" , ".bmp" ) , //文件允许格式
			"s_size"=>48,
			"n_size"=>120,
			"b_size"=>200,
	    );
        $file = $_FILES[ "Filedata" ];
	
	    //重命名后的文件名
		 $path = $config[ 'uploadPath' ];
	    if ( !file_exists( $path ) ) {
	        create_folders( "$path" , 0777 );
	    }
		$arrImgInfo = getimagesize($file['tmp_name']);
	    //格式验证
	    
	    $current_type = strtolower( strrchr( $file['name'] , '.' ) );
	    if($current_type=='.bmp'||$current_type=='.BMP')$current_type='.png';
 		if ( !in_array( $current_type , $config[ 'fileType' ] ) || false == getimagesize( $file[ "tmp_name" ] ) ) {
	       die ('onlytype');
	    }
	 
	    //保存图片
	        
	        $tmp_file = $file['name'];
	
		    $fileName=get_avatar_url($uid).$uid.$current_type;
	 require_once './source/discuz_version.php';
	 if(DISCUZ_VERSION != 'X2'){
		    $result= move_uploaded_file( $file[ "tmp_name" ] , $fileName );
	 }else{
	 	$result= copy( $file[ "tmp_name" ] , $fileName );
	 }
if ( ! $result || ! is_file( $fileName ) ) {
	die ( 'fail' );
}
	   
	    $bigavatarfile =get_avatar($uid, 'big').'.jpg';
		$middleavatarfile = get_avatar($uid, 'middle').'.jpg';
		$smallavatarfile = get_avatar($uid, 'small').'.jpg';
	    $w=$sw=$arrImgInfo[0];
		$h=$sh=$arrImgInfo[1];
	    save_pic($config['s_size'],$w,$h,$sw,$sh,$fileName,$smallavatarfile,$current_type);
		save_pic($config['n_size'],$w,$h,$sw,$sh,$fileName,$middleavatarfile,$current_type);
		save_pic($config['b_size'],$w,$h,$sw,$sh,$fileName,$bigavatarfile,$current_type);
		if (! is_file( $bigavatarfile ) ||! is_file( $middleavatarfile )||! is_file( $smallavatarfile )) {
			die('fail');
		}else{
			
			echo 'success';
			unlink($fileName);
		}
	   
	  
}


function get_avatar($uid, $size = 'big', $type = '') {
	   global $_G;
		$size = in_array($size, array('big', 'middle', 'small')) ? $size : 'big';
		$uid = abs(intval($uid));
		$uid = sprintf("%09d", $uid);
		$dir1 = substr($uid, 0, 3);
		$dir2 = substr($uid, 3, 2);
		$dir3 = substr($uid, 5, 2);
		$typeadd = $type == 'real' ? '_real' : '';
		$uc=str_replace(dirname($_G['setting']['ucenterurl']),'', $_G['setting']['ucenterurl']);
		return substr(dirname(__FILE__),0,-41).$uc.'\\data\\avatar\\'.$dir1.'\\'.$dir2.'\\'.$dir3.'\\'.substr($uid, -2).$typeadd."_avatar_$size";
			}
	function get_avatar_url($uid) {
		global $_G;
	   $uid = abs(intval($uid));
		$uid = sprintf("%09d", $uid);
		$dir1 = substr($uid, 0, 3);
		$dir2 = substr($uid, 3, 2);
		$dir3 = substr($uid, 5, 2);
		$uc=str_replace(dirname($_G['setting']['ucenterurl']),'',$_G['setting']['ucenterurl']);
		return substr(dirname(__FILE__),0,-41).$uc.'\\data\\avatar\\'.$dir1.'\\'.$dir2.'\\'.$dir3.'\\';
	}	

function save_pic($size,$w,$h,$sw,$sh,$orgfile,$fileName,$current_type){
   		 if($w>$size||$h>$size){
				if($w>$h){
					$sw=$size;
					$sh=$h/$w*$size;
				}else{
					$sw=$w/$h*$size;
					$sh=$size;
				}
    		}
     
			 	if($current_type == ".jpg"){
			 	    $im = imagecreatefromjpeg($orgfile);
				}elseif($current_type == ".png"){
					$im = imagecreatefrompng($orgfile);
				}elseif($current_type == ".gif"){
					$im = imagecreatefromgif($orgfile);
				}elseif($current_type == ".jpeg"){
					$im = imagecreatefromjpeg($orgfile);
				}elseif($current_type == ".bmp"){
				$im = imagecreatefrompng($orgfile);
				}
					$dst_temp = imagecreatetruecolor($sw, $sh);
					imagecopyresized($dst_temp, $im , 0, 0,0,0, $sw, $sh, $w, $h);  
					if($current_type == ".jpg"||$current_type == ".jpeg"){
						imagejpeg($dst_temp,$fileName);
					}elseif($current_type == ".png"){
						imagepng($dst_temp,$fileName);
					}elseif($current_type == ".gif"){
						imagegif($dst_temp,$fileName);		
					}elseif($current_type == ".bmp"){
					imagepng($dst_temp,$fileName);
				}
				imagedestroy($im);imagedestroy($dst_temp);
				
}
function create_folders($dir){   

return is_dir($dir) or (create_folders(dirname($dir)) and mkdir($dir, 0777));
} 

?>
