<?php
include "../../global/global_conn.php";
switch($_GET['ac']){
	case 'song':
		$filepath="../../../data/attachment/song/".$_GET['is']."/";
		creatdir($filepath);
		$targetFiles=$filepath.$_GET['id'].".".fileext($_FILES['Filedata']['name']).".jpg";
		$fileexts=cd_upmext;
		$filetexts="音频文件";
		break;
	case 'video':
		$filepath="../../../data/attachment/video/".$_GET['is']."/";
		creatdir($filepath);
		$targetFiles=$filepath.$_GET['id'].".".fileext($_FILES['Filedata']['name']).".jpg";
		$fileexts=cd_upvext;
		$filetexts="视频文件";
		break;
	case 'lrc':
		$filepath="../../../data/attachment/lrc/".$_GET['is']."/";
		creatdir($filepath);
		$targetFiles=$filepath.$_GET['id'].".".fileext($_FILES['Filedata']['name']).".jpg";
		$fileexts="*.lrc";
		$filetexts="歌词文件";
		break;
	case 'pic':
		$filepath="../../../data/attachment/pic/".$_GET['is']."/";
		creatdir($filepath);
		$targetFiles=$filepath.$_GET['id'].".".fileext($_FILES['Filedata']['name']);
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
		if(cd_upkbps>0 && $_GET['to']=="user" && $_GET['ac']=="song"){
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
			'cd_userid' => $_GET['uid'],
			'cd_username' => base64_decode($_GET['uname']),
			'cd_userip' => getonlineip(),
			'cd_filetype' => $filetexts,
			'cd_filename' => $_GET['id'].".".fileext($_FILES['Filedata']['name']),
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