<?php
include "../../../../source/global/global_conn.php";
include "../../../../source/global/global_inc.php";
$do = SafeRequest("do","get");
if ($do == "add") {
	$qianwei_in_userid = $_POST['userid'];
	$qianwei_in_username = base64_decode($_POST['username']);
	if ($qianwei_in_userid) {
		if (!empty($_FILES)) {
			$randnum = rand(2,pow(2,24));
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$filepath = "../../../../data/attachment/album/".date('Y',time())."/".date('m',time())."/".date('d',time())."/";
			creatdir($filepath);
			$targetFile = $filepath.time().mt_rand(1000,9999)."_".$qianwei_in_userid.".".fileext($_FILES['Filedata']['name']);
			$fileTypes  = str_replace('*.', '', '*.jpg;*.jpeg;*.gif;*.png');
			$fileTypes  = str_replace(';', '|', $fileTypes);
			$typesArray = preg_split('/\|/',$fileTypes);
			$fileParts  = pathinfo($_FILES['Filedata']['name']);
			if (in_array($fileParts['extension'],$typesArray)) {
				if(function_exists('getimagesize')) {
					$tmp_imagesize = @getimagesize($tempFile);
					list($tmp_width, $tmp_height, $tmp_type) = (array)$tmp_imagesize;
					$tmp_size = $tmp_width * $tmp_height;
					if($tmp_size > 16777216 || $tmp_size < 4 || empty($tmp_type) || strpos($tmp_imagesize['mime'], 'flash') > 0) {
						@unlink($tempFile);
						exit('1');
					}
				}
				move_uploaded_file($tempFile,$targetFile);
				$ica=new ImageCrop($targetFile,$targetFile.'.thumb.'.fileext($_FILES['Filedata']['name']));
				$ica->Crop(80,80,2);
				$ica->SaveImage();
				$ica->destory();
				$ic=new ImageCrop($targetFile,$targetFile.'.thumb_180x180.'.fileext($_FILES['Filedata']['name']));
				$ic->Crop(180,180,2);
				$ic->SaveImage();
				$ic->destory();
				$image_size = getimagesize($targetFile);
				$setarrs = array(
					'cd_uid' => $qianwei_in_userid,
					'cd_uname' => $qianwei_in_username,
					'cd_uip' => getonlineip(),
					'cd_title' => '暂无说明',
					'cd_url' => str_replace("../../../../data/attachment/album/","",$targetFile),
					'cd_hits' => 0,
					'cd_praisenum' => 0,
					'cd_replynum' => 0,
					'cd_theorder' => 0,
					'cd_weborder' => 0,
					'cd_width' => $image_size[0],
					'cd_height' => $image_size[1],
					'cd_addtime' => time()
				);
				inserttable('pic', $setarrs, 1);
				$sql="select cd_id from ".tname('pic')." where cd_url='".$targetFile."'";
				if($row=$db->getrow($sql)){
					$db->query("update ".tname('pic')." set cd_theorder='".$row['cd_id']."' where cd_id='".$row['cd_id']."'");
				}
				$setarrss = array(
					'cd_userid' => $qianwei_in_userid,
					'cd_username' => $qianwei_in_username,
					'cd_userip' => getonlineip(),
					'cd_filetype' => '图片文件',
					'cd_filename' => time().mt_rand(1000,9999)."_".$qianwei_in_userid.".".fileext($_FILES['Filedata']['name']),
					'cd_filesize' => $_FILES["Filedata"]["size"],
					'cd_fileurl' => $targetFile,
					'cd_filetime' => time()
				);
				inserttable('upload', $setarrss, 1);
				$timea = date('Y',time());
				$timeb = date('m',time());
				$timec = date('d',time());
				$timed = mktime(0,0,0,$timeb,$timec,$timea);
				$picnum = $db -> num_rows($db -> query("select cd_id from ".tname('pic')." where cd_uid='$qianwei_in_userid' and cd_addtime >= '$timed'"));
				if(($picnum*cd_pointsuda) < cd_pointsudc){
					if(cd_pointsuca >= 1){
						$setarr = array(
							'cd_type' => 1,
							'cd_uid' => $qianwei_in_userid,
							'cd_uname' => $qianwei_in_username,
							'cd_icon' => 'album',
							'cd_title' => '分享照片',
							'cd_points' => cd_pointsuda,
							'cd_state' => 0,
							'cd_addtime' => date('Y-m-d H:i:s'),
							'cd_endtime' => getendtime()
						);
						inserttable('bill', $setarr, 1);
					}
					$db->query("update ".tname('user')." set cd_points=cd_points+".cd_pointsuda.",cd_rank=cd_rank+".cd_pointsudb." where cd_id='$qianwei_in_userid'");
				}
                		$feedsql = "select cd_id from ".tname('feed')." where cd_icon='album' and cd_title='更新了照片' and cd_uid='$qianwei_in_userid'";
				$feed = $db->getrow($feedsql);
				if($feed){
					$db->query("update ".tname('feed')." set cd_addtime='".date('Y-m-d H:i:s')."' where cd_id='".$feed['cd_id']."'");
				}else{
					$setarrs = array(
						'cd_uid' => $qianwei_in_userid,
						'cd_uname' => $qianwei_in_username,
						'cd_icon' => 'album',
						'cd_title' => '更新了照片',
						'cd_data' => '',
						'cd_image' => '',
						'cd_imagelink' => '',
						'cd_dataid' => 0,
						'cd_addtime' => date('Y-m-d H:i:s')
					);
					inserttable('feed', $setarrs, 1);
				}
				echo '0';
			}
		} else {
	 		echo 'Invalid file type.';
		}
	}
}
class ImageCrop{
	var $sImage;
	var $dImage;
	var $src_file;
	var $dst_file;
	var $src_width;
	var $src_height;
	var $src_ext;
	var $src_type;
	function ImageCrop($src_file,$dst_file=''){
		$this->src_file=$src_file;
		$this->dst_file=$dst_file;
		$this->LoadImage();
	}
	function SetSrcFile($src_file){
		$this->src_file=$src_file;
	}
	function SetDstFile($dst_file){
		$this->dst_file=$dst_file;
	}
	function LoadImage(){
		list($this->src_width, $this->src_height, $this->src_type) = getimagesize($this->src_file);
		switch($this->src_type) {
			case IMAGETYPE_JPEG :
				$this->sImage=imagecreatefromjpeg($this->src_file);
				$this->ext='jpg';
				break;
			case IMAGETYPE_PNG :
				$this->sImage=imagecreatefrompng($this->src_file);
				$this->ext='png';
				break;
			case IMAGETYPE_GIF :
				$this->sImage=imagecreatefromgif($this->src_file);
				$this->ext='gif';
				break;
			default:
				exit();
		}
	}
	function SaveImage($fileName=''){
		$this->dst_file=$fileName ? $fileName : $this->dst_file;
		switch($this->src_type) {
			case IMAGETYPE_JPEG :
				imagejpeg($this->dImage,$this->dst_file,100);
				break;
			case IMAGETYPE_PNG :
				imagepng($this->dImage,$this->dst_file);
				break;
			case IMAGETYPE_GIF :
				imagegif($this->dImage,$this->dst_file);
				break;
			default:
				break;
		}
	}
	function OutImage(){
		switch($this->src_type) {
			case IMAGETYPE_JPEG :
				header('Content-type: image/jpeg');
				imagejpeg($this->dImage);
				break;
			case IMAGETYPE_PNG :
				header('Content-type: image/png');
				imagepng($this->dImage);
				break;
			case IMAGETYPE_GIF :
				header('Content-type: image/gif');
				imagegif($this->dImage);
				break;
			default:
				break;
		}
	}
	function SaveAlpha($fileName=''){
		$this->dst_file=$fileName ? $fileName . '.png' : $this->dst_file .'.png';
		imagesavealpha($this->dImage, true);
		imagepng($this->dImage,$this->dst_file);
	}
	function OutAlpha(){
		imagesavealpha($this->dImage, true);
		header('Content-type: image/png');
		imagepng($this->dImage);
}
function destory(){
	imagedestroy($this->sImage);
	imagedestroy($this->dImage);
}
function Crop($dst_width,$dst_height,$mode=1,$dst_file=''){
	if($dst_file) $this->dst_file=$dst_file;
	$this->dImage = imagecreatetruecolor($dst_width,$dst_height);
	$bg = imagecolorallocatealpha($this->dImage,255,255,255,127);
	imagefill($this->dImage, 0, 0, $bg);
	imagecolortransparent($this->dImage,$bg);
	$ratio_w=1.0 * $dst_width / $this->src_width;
	$ratio_h=1.0 * $dst_height / $this->src_height;
	$ratio=1.0;
	switch($mode){
		case 1:
			if( ($ratio_w < 1 && $ratio_h < 1) || ($ratio_w > 1 && $ratio_h > 1)){
				$ratio = $ratio_w < $ratio_h ? $ratio_h : $ratio_w;
				$tmp_w = (int)($dst_width / $ratio);
				$tmp_h = (int)($dst_height / $ratio);
				$tmp_img=imagecreatetruecolor($tmp_w , $tmp_h);
				$src_x = (int) (($this->src_width-$tmp_w)/2) ; 
				$src_y = (int) (($this->src_height-$tmp_h)/2) ;    
				imagecopy($tmp_img, $this->sImage, 0,0,$src_x,$src_y,$tmp_w,$tmp_h);    
				imagecopyresampled($this->dImage,$tmp_img,0,0,0,0,$dst_width,$dst_height,$tmp_w,$tmp_h);
				imagedestroy($tmp_img);
			}else{
				$ratio = $ratio_w < $ratio_h ? $ratio_h : $ratio_w;
				$tmp_w = (int)($this->src_width * $ratio);
				$tmp_h = (int)($this->src_height * $ratio);
				$tmp_img=imagecreatetruecolor($tmp_w ,$tmp_h);
				imagecopyresampled($tmp_img,$this->sImage,0,0,0,0,$tmp_w,$tmp_h,$this->src_width,$this->src_height);
				$src_x = (int)($tmp_w - $dst_width) / 2 ; 
				$src_y = (int)($tmp_h - $dst_height) / 2 ;    
				imagecopy($this->dImage, $tmp_img, 0,0,$src_x,$src_y,$dst_width,$dst_height);
				imagedestroy($tmp_img);
			}
			break;
		case 2:
			if($ratio_w < 1 && $ratio_h < 1){
				$ratio = $ratio_w < $ratio_h ? $ratio_h : $ratio_w;
				$tmp_w = (int)($dst_width / $ratio);
				$tmp_h = (int)($dst_height / $ratio);
				$tmp_img=imagecreatetruecolor($tmp_w , $tmp_h);
				$src_x = (int) ($this->src_width-$tmp_w)/2 ; 
				$src_y = (int) ($this->src_height-$tmp_h)/2 ;    
				imagecopy($tmp_img, $this->sImage, 0,0,$src_x,$src_y,$tmp_w,$tmp_h);    
				imagecopyresampled($this->dImage,$tmp_img,0,0,0,0,$dst_width,$dst_height,$tmp_w,$tmp_h);
				imagedestroy($tmp_img);
			}elseif($ratio_w > 1 && $ratio_h > 1){
				$dst_x = (int) abs($dst_width - $this->src_width) / 2 ; 
				$dst_y = (int) abs($dst_height -$this->src_height) / 2;    
				imagecopy($this->dImage, $this->sImage,$dst_x,$dst_y,0,0,$this->src_width,$this->src_height);
			}else{
				$src_x=0;$dst_x=0;$src_y=0;$dst_y=0;
				if(($dst_width - $this->src_width) < 0){
					$src_x = (int) ($this->src_width - $dst_width)/2;
					$dst_x =0;
				}else{
					$src_x =0;
					$dst_x = (int) ($dst_width - $this->src_width)/2;
				}
				if( ($dst_height -$this->src_height) < 0){
					$src_y = (int) ($this->src_height - $dst_height)/2;
					$dst_y = 0;
				}else{
					$src_y = 0;
					$dst_y = (int) ($dst_height - $this->src_height)/2;
				}
				imagecopy($this->dImage, $this->sImage,$dst_x,$dst_y,$src_x,$src_y,$this->src_width,$this->src_height);
			}
			break;
		case 3:
			if($ratio_w > 1 && $ratio_h > 1){
				$dst_x = (int)(abs($dst_width - $this->src_width )/2) ; 
				$dst_y = (int)(abs($dst_height- $this->src_height)/2) ;
				imagecopy($this->dImage, $this->sImage, $dst_x,$dst_y,0,0,$this->src_width,$this->src_height);
			}else{
				$ratio = $ratio_w > $ratio_h ? $ratio_h : $ratio_w;
				$tmp_w = (int)($this->src_width * $ratio);
				$tmp_h = (int)($this->src_height * $ratio);
				$tmp_img=imagecreatetruecolor($tmp_w ,$tmp_h);
				imagecopyresampled($tmp_img,$this->sImage,0,0,0,0,$tmp_w,$tmp_h,$this->src_width,$this->src_height);
				$dst_x = (int)(abs($tmp_w -$dst_width )/2) ; 
				$dst_y = (int)(abs($tmp_h -$dst_height)/2) ;
				imagecopy($this->dImage, $tmp_img, $dst_x,$dst_y,0,0,$tmp_w,$tmp_h);
				imagedestroy($tmp_img);
			}
			break;
		case 4:
			if($ratio_w > 1 && $ratio_h > 1){
				$this->dImage = imagecreatetruecolor($this->src_width,$this->src_height);
				imagecopy($this->dImage, $this->sImage,0,0,0,0,$this->src_width,$this->src_height);
			}else{
				$ratio = $ratio_w > $ratio_h ? $ratio_h : $ratio_w;
				$tmp_w = (int)($this->src_width * $ratio);
				$tmp_h = (int)($this->src_height * $ratio);
				$this->dImage = imagecreatetruecolor($tmp_w ,$tmp_h);
				imagecopyresampled($this->dImage,$this->sImage,0,0,0,0,$tmp_w,$tmp_h,$this->src_width,$this->src_height);
			}
			break;
		}
	}
}
?>