<?php
include "../../global/global_conn.php";
$is=SafeRequest("is","get");
$id=SafeRequest("id","get");
$action=SafeRequest("ac","get");
$qianwei_in_userid=SafeRequest("uid","get");
$qianwei_in_username=base64_decode(SafeRequest("uname","get"));
switch($action){
	case 'song':
		$filepath="../../../data/attachment/song/".$is."/";
		creatdir($filepath);
		$targetFiles=$filepath.$id.".".fileext($_FILES['Filedata']['name']).".jpg";
		$fileexts=cd_upext;
		$filetexts="音频文件";
		break;
	case 'video':
		$filepath="../../../data/attachment/video/".$is."/";
		creatdir($filepath);
		$targetFiles=$filepath.$id.".".fileext($_FILES['Filedata']['name']).".jpg";
		$fileexts="*.flv;*.f4v;*.mp4";
		$filetexts="视频文件";
		break;
	case 'lrc':
		$filepath="../../../data/attachment/lrc/".$is."/";
		creatdir($filepath);
		$targetFiles=$filepath.$id.".".fileext($_FILES['Filedata']['name']).".jpg";
		$fileexts="*.lrc";
		$filetexts="歌词文件";
		break;
	case 'pic':
		$filepath="../../../data/attachment/pic/".$is."/";
		creatdir($filepath);
		$targetFiles=$filepath.$id.".".fileext($_FILES['Filedata']['name']);
		$fileexts="*.jpg;*.jpeg;*.gif;*.png";
		$filetexts="图片文件";
		break;
}
if(!empty($_FILES)){
	$tempFile=$_FILES['Filedata']['tmp_name'];
	$targetFile=$targetFiles;
	$fileTypes=str_replace('*.', '', $fileexts);
	$fileTypes=str_replace(';', '|', $fileTypes);
	$typesArray=preg_split('/\|/',$fileTypes);
	$fileParts=pathinfo($_FILES['Filedata']['name']);
	if(in_array($fileParts['extension'],$typesArray)){
		move_uploaded_file($tempFile,$targetFile);
		if(cd_upkbps>0 && $_GET['ac']=="song"){
			if(!class_exists('COM')){exit('2');}
			$file = realpath($targetFile);
			$player = new COM("WMPlayer.OCX");
			$media = $player->newMedia($file);
			$kbps = $media->getItemInfo(Bitrate);
			$upkbps = cd_upkbps."000";
			if($kbps<$upkbps){
			        @unlink($targetFile);
			        exit('1');
			}
		}
		$setarrss = array(
			'cd_userid' => $qianwei_in_userid,
			'cd_username' => $qianwei_in_username,
			'cd_userip' => getonlineip(),
			'cd_filetype' => $filetexts,
			'cd_filename' => $id.".".fileext($_FILES['Filedata']['name']),
			'cd_filesize' => $_FILES["Filedata"]["size"],
			'cd_fileurl' => ReplaceStr($targetFile,"../../../",""),
			'cd_filetime' => time()
		);
		inserttable('upload', $setarrss, 1);
		echo '0';
	}else{
	 	echo 'Invalid file type.';
	}
}
?>