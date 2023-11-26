<?php
include "source/global/global_conn.php";
class AvatarUploader {
	private function getThisUrl() {
		$thisUrl = $_SERVER['SCRIPT_NAME'];
		$thisUrl = "http://{$_SERVER['HTTP_HOST']}{$thisUrl}";
		return $thisUrl;
	}
	private function getBaseUrl() {
		$baseUrl = $this->getThisUrl();
		$baseUrl = substr( $baseUrl, 0, strrpos( $baseUrl, '/' ) + 1 );
		return $baseUrl;
	}
	private function uploadAvatar($uid) {
		if ( empty($_FILES['Filedata']) ) {
			return -3;
		}
		$tmpPath = _qianwei_root_ . "data/attachment/avatar/{$uid}.jpg";
		$dir = dirname( $tmpPath );
		if ( !file_exists( $dir ) ) {
			@mkdir( $dir, 0777, true );
		}
		if ( file_exists($tmpPath) ) {
			@unlink($tmpPath);
		}
		if ( @copy($_FILES['Filedata']['tmp_name'], $tmpPath) || @move_uploaded_file($_FILES['Filedata']['tmp_name'], $tmpPath)) {
			@unlink($_FILES['Filedata']['tmp_name']);
			list($width, $height, $type, $attr) = getimagesize($tmpPath);
			if ( $width < 10 || $height < 10 || $width > 3000 || $height > 3000 || $type == 4 ) {
				@unlink($tmpPath);
				return -2;
			}
		} else {
			@unlink($_FILES['Filedata']['tmp_name']);
			return -4;
		}
		$tmpUrl = $this->getBaseUrl() . "data/attachment/avatar/{$uid}.jpg";
		return $tmpUrl;
	}
	private function flashdata_decode($s) {
		$r = '';
		$l = strlen($s);
		for($i=0; $i<$l; $i=$i+2) {
			$k1 = ord($s[$i]) - 48;
			$k1 -= $k1 > 9 ? 7 : 0;
			$k2 = ord($s[$i+1]) - 48;
			$k2 -= $k2 > 9 ? 7 : 0;
			$r .= chr($k1 << 4 | $k2);
		}
		return $r;
	}
	private function rectAvatar($uid) {
		$bigavatar    = $this->flashdata_decode( $_POST['avatar1'] );
		$middleavatar = $this->flashdata_decode( $_POST['avatar2'] );
		$smallavatar  = $this->flashdata_decode( $_POST['avatar3'] );
		if ( !$bigavatar || !$middleavatar || !$smallavatar ) {
			return '<root><message type="error" value="-2" /></root>';
		}
		$bigavatarfile    = _qianwei_root_ . "data/attachment/avatar/{$uid}_200x200.jpg";
		$middleavatarfile = _qianwei_root_ . "data/attachment/avatar/{$uid}_120x120.jpg";
		$smallavatarfile  = _qianwei_root_ . "data/attachment/avatar/{$uid}_48x48.jpg";
		$success = 1;
		$fp = @fopen($bigavatarfile, 'wb');
		@fwrite($fp, $bigavatar);
		@fclose($fp);
		$fp = @fopen($middleavatarfile, 'wb');
		@fwrite($fp, $middleavatar);
		@fclose($fp);
		$fp = @fopen($smallavatarfile, 'wb');
		@fwrite($fp, $smallavatar);
		@fclose($fp);
		$biginfo    = @getimagesize($bigavatarfile);
		$middleinfo = @getimagesize($middleavatarfile);
		$smallinfo  = @getimagesize($smallavatarfile);
		if ( !$biginfo || !$middleinfo || !$smallinfo || $biginfo[2] == 4 || $middleinfo[2] == 4 || $smallinfo[2] == 4 ) {
			file_exists($bigavatarfile) && unlink($bigavatarfile);
			file_exists($middleavatarfile) && unlink($middleavatarfile);
			file_exists($smallavatarfile) && unlink($smallavatarfile);
			$success = 0;
		}
		$tmpPath = _qianwei_root_ . "data/attachment/avatar/{$uid}.jpg";
		if ($uid == 0) {
			@unlink($bigavatarfile);
			@unlink($middleavatarfile);
			@unlink($smallavatarfile);
		}
		@unlink($tmpPath);
		return '<?xml version="1.0" ?><root><face success="' . $success . '"/></root>';
	}
	public function processRequest() {
		global $db;
		$arr = array();
		if(isset($_GET['input']))
			parse_str($_GET['input'], $arr);
		if(isset($arr['uid']))
			$avatar = explode('|', base64_decode($arr['uid']));
			if ($db->getone("select * from ".tname('user')." where cd_lock=0 and cd_id=".$avatar[0]." and cd_password='".$avatar[1]."'")) {
			        $uid = intval($avatar[0]);
			} else {
			        $uid = 0;
			}
		if (isset($_GET['a']) && $_GET['a'] == 'uploadavatar') {
			echo $this->uploadAvatar( $uid );
			return true;
		} else if (isset($_GET['a']) && $_GET['a'] == 'rectavatar') {
			echo $this->rectAvatar( $uid );
			return true;
		}
		return false;
	}
}
header("Expires: 0");
header("Cache-Control: private, post-check=0, pre-check=0, max-age=0", FALSE);
header("Pragma: no-cache");
header("Cache-Control:no-cache");
$au = new AvatarUploader();
if ( $au->processRequest() ) {
	exit();
}
?>