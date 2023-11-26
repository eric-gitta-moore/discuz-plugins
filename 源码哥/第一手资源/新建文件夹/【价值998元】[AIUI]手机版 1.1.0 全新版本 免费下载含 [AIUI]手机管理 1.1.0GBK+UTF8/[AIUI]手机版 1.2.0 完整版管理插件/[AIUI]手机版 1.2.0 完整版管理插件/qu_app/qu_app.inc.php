<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
global $_G;

if ($_GET["image_file"] && $_GET['m']=='avatar' && $_GET['formhash'] == FORMHASH) {
	$imgdata = explode(',',$_GET["image_file"]);
	preg_match('/^(data:\s*image\/(\w+);base64,)/',$_GET["image_file"],$result);
	$sExt = '.'.str_replace('jpeg','jpg',$result[2]);
	$imgdata = base64_decode($imgdata[1]);
	$basedir = DISCUZ_ROOT.$_G['setting']['attachurl'];
	$sTempFileName = $basedir.'qu_app/'.$_G['uid'];
	@dmkdir($basedir.'qu_app');
	file_put_contents($sTempFileName,$imgdata);
	
	$dirs = sprintf("%09d",$_G['uid']);
	$dir = array(
		substr($dirs,0,3),
		substr($dirs,3,2),
		substr($dirs,5,2),
		substr($dirs,7,2)
	);
	$avatar_dir = DISCUZ_ROOT.'uc_server/data/avatar/'.$dir[0].'/'.$dir[1].'/'.$dir[2].'/';
	@dmkdir($avatar_dir);
	
	clipimga($sTempFileName,$avatar_dir.$dir[3].'_avatar_big'.$sExt, 200, 200);
	clipimga($sTempFileName,$avatar_dir.$dir[3].'_avatar_middle'.$sExt, 120, 120);
	clipimga($sTempFileName,$avatar_dir.$dir[3].'_avatar_small'.$sExt, 48, 48);
	
	@unlink($sTempFileName);
	echo json_encode(array('status'=>1));
}

$auser['avatar'] = avatar($_G['uid'],'middle',true);
$auser['avatar_big'] = avatar($_G['uid'],'big',true);

function clipimga($apath, $target_path='', $awidth = 200, $aheight = 200, $fixed_orig = ''){
    $source_info = getimagesize($apath);
    $source_width = $source_info[0];
    $source_height = $source_info[1];
    $source_mime = $source_info['mime'];
    $ratio_orig = $source_width / $source_height;
    if ($fixed_orig == 'width'){
        $aheight = $awidth / $ratio_orig;
    }elseif ($fixed_orig == 'height'){
        $awidth = $aheight * $ratio_orig;
    }else{
        if ($awidth / $aheight > $ratio_orig){
            $awidth = $aheight * $ratio_orig;
        }else{
            $aheight = $awidth / $ratio_orig;
        }
    }
    switch ($source_mime){
        case 'image/gif':
            $source_image = imagecreatefromgif($apath);
            break;
        case 'image/jpeg':
            $source_image = imagecreatefromjpeg($apath);
            break;
        case 'image/png':
            $source_image = imagecreatefrompng($apath);
            break;
        default:
            return false;
            break;
    }
    $target_image = imagecreatetruecolor($awidth, $aheight);
    imagecopyresampled($target_image, $source_image, 0, 0, 0, 0, $awidth, $aheight, $source_width, $source_height);
    $imgArr = explode('.', $apath);
    imagejpeg($target_image, $target_path.$imgArr[1], 100);
}

?>
