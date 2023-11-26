<?php

/**
 * Www.魔趣吧.Vip
 *
 * [魔趣吧!] (C)2014-2017 www.moqu8.com.  By www-魔趣吧-co
 *
 * Support: caogenba@qq.com QQ:1218894030
 *
 * Date: 2013-02-17 16:22:17 moqu8.com $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

header("Content-Type: text/html; charset=utf-8");//固定utf8编码。

class x_upload_module {

	public static function _form() {
		global $_G;
		$lev_lang = lev_base::$lang;
		//if ($_G['adminid'] !=1) exit($lev_lang['noactop']);
		$PLSTATIC = lev_base::$PLSTATIC;
		$lm = lev_base::$lm;
		$_PLG = lev_base::$PL_G;
		include template(lev_base::$PLNAME.':x_upload');
	}
	
	public static function _upload($field, $isimage = 0) {
		global $_G;
		if ($isimage) {
			$attach = self::up_image($field, 1);
		}else {
			$attach = self::up_attach($field, 1);
		}
		echo $_G['siteurl'].$attach['attachment'];
		return $attach;
	}
	
	public static function up_image($field, $all = 0) {
		if ($_FILES[$field]['size']) {
			$attach = self::upload($_FILES[$field]);
			if ($attach['attachment']) {
				$data = lev_base::$uploadurl.$attach['attachment'];
				$attach['attachment'] = $data;
				if ($all) return $attach;
			}
		}
		return $data;
	}

	public static function up_attach($field, $all = 0) {
		if ($_FILES[$field]['size']) {
			$attach = self::upload($_FILES[$field], 0);
			if ($attach['attachment']) {
				$data = lev_base::$uploadurl.$attach['attachment'];
				$attach['attachment'] = $data;
				if ($all) return $attach;
			}
		}
		return $data;
	}

	public static function upload($files, $isimg = 1, $ext = array(), $extid = 0, $forcename = '') {//X2.5 up
		self::ckupload($files, $isimg);
		if (is_array($files)) {
			if (!$isimg) {
				$ext = $ext ? $ext : self::exts();
			}
			$fileroot = DISCUZ_ROOT.lev_base::$PLSTATIC.'upload/';
			dmkdir($fileroot);
		    setglobal('setting/attachdir', $fileroot);//更改上传目录到$fileroot插件目录
			require_once libfile('discuz/upload', 'class');
		    $upload = new discuz_upload();
		    if($upload->init($files, 'common', $extid, $forcename) && $upload->save(1)) {//print_r($upload->attach);
		    	if ($isimg && !$upload->attach['isimage']) {
					@chmod($upload->attach['target'], 0644); 
					@unlink($upload->attach['target']);
		    	}elseif (!empty($ext) && !in_array($upload->attach['ext'], $ext)) {
					@chmod($upload->attach['target'], 0644); 
					@unlink($upload->attach['target']);
		    	}else{
		    		if (!$isimg && lev_base::isopen('zip') && !in_array($upload->attach['ext'], array('zip', 'rar'))) {
		    			rename($upload->attach['target'], $upload->attach['target'].'.'.$upload->attach['ext']);
		    			$upload->attach['attachment'] .= '.'.$upload->attach['ext'];
		    		}
		    		return $upload->attach;
		    	}
		    }
		}
	}
	public static function ckupload($thumb, $isimage = 1, $uploadsize = 0) {
		$errmsg = array(
			0 => "没有错误发生，文件上传成功。 ",
			1 => "文件超过 php.ini中upload_max_filesize选项限制值。",
			2 => "文件的大小超过HTML表单中 MAX_FILE_SIZE指定的值。 ",
			3 => "失败，文件只有部分被上传。",
			4 => "没有文件被上传。"
		);
		$uploadsize = $uploadsize ? $uploadsize : lev_base::$PL_G['uploadsize'];
		if ($thumb['error']) {
			exit($errmsg[$thumb['error']]);
		}elseif ($thumb['size'] > $uploadsize * 1000) {
			exit('上传文件超过上限['.lev_base::$PL_G['uploadsize'].'KB]');
		}elseif ($isimage && !strstr($thumb['type'], 'image')) {
			exit('请上传图片类型文件！');
		}
	}
	public static function exts() {
		$exts = explode('=', trim(lev_base::$PL_G['exts']));
		if ($exts[0]) return $exts;
		return array();
	}
	
	public static function dir_delete($dir) {
		if (!$dir || !is_dir($dir)) return FALSE;
		$list = glob($dir.'*');
		foreach($list as $v) {
			is_dir($v) ? self::dir_delete($v) : @unlink($v);
		}
	    return @rmdir($dir);
	}
	
	public static function delattach($attach) {
		if (!is_array($attach) && strpos($attach, '..') !==FALSE) return TRUE;
		if (is_array($attach)) {
			foreach ($attach as $v) {
				self::dir_delete(DISCUZ_ROOT.self::$uploadurl.$v.'/');
			}
		}elseif (is_file(DISCUZ_ROOT.self::$uploadurl.$attach)) {
			@chmod(DISCUZ_ROOT.self::$uploadurl.$attach, 0644); 
			@unlink(DISCUZ_ROOT.self::$uploadurl.$attach);
		}elseif (is_file($attach)) {
			@chmod($attach, 0644); 
			@unlink($attach);
		}elseif ($attach) {
				self::dir_delete(DISCUZ_ROOT.self::$uploadurl.$attach);
		}else {
			return TRUE;
		}
	}
	
}







