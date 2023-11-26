<?php

/**
 * 魔趣吧官网：http://WWW.moqu8.com
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

//require_once 'module/class/base.class.php';

if(defined('IN_ADMINCP')) loadcache('plugin');

class lev_base {

	public static $PL_G, $_G, $PLNAME, $PLSTATIC, $PLURL, $lang = array(), $table, $navtitle, $uploadurl, $remote, $debug = TRUE;
	public static $diydir, $lm, $loadjs;

	public function __construct() {
		if ($_GET['debug'] =='-1') self::__debug();
		self::init();
		self::$lang = self::levlang();
		self::navtitle();
	}

	public static function init() {
		$plugin_dir   = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));//print_r($arrs_dir);

		global $_G;
		self::$_G     = $_G;
		self::$PLNAME = trim(end($plugin_dir));
		self::$PL_G   = self::$_G['cache']['plugin'][self::$PLNAME];//print_r($PL_G);

		self::$PLSTATIC = 'source/plugin/'.self::$PLNAME.'/statics/';
		self::$PLURL    = 'plugin.php?id='.self::$PLNAME;
		self::$uploadurl= self::$PLSTATIC.'upload/common/';
		self::$remote   = 'plugin.php?id='.self::$PLNAME.':l&fh='.FORMHASH.'&m=';
		self::$lm       = 'plugin.php?id='.self::$PLNAME.':l&fh='.FORMHASH.'&m=_m.';
		self::$diydir   = 'source/plugin/'.self::$PLNAME.'/template/';
		self::$loadjs   = self::$remote.'__m.x_loadjs.__init';
		self::$table    = '#'.self::$PLNAME.'#'.self::$PLNAME;
	}

	public static function tmp($tmp = '', $diy = 1) {
		$tmp = $tmp ? $tmp : self::$PLNAME;
		if ($diy) {
			return template('diy:'.$tmp, '', self::$diydir);
		}else {
			return template(self::$PLNAME.':'.$tmp);
		}
	}
	
	public static function bbforum($fid = array()) {
		$in = is_array($fid) ? self::sqlinstr($fid) : $fid;
		$sq = "SELECT * FROM ".DB::table('forum_forum')." WHERE fup!=0 AND status!=3 AND status>0";
		$sq.= $in ? " AND fid IN ($in) " : '';
		$rs = DB::fetch_all($sq, array(), 'fid');
		return $rs;
	}
	
	public static function isfile($filename) {
		if ($filename) {
			if (is_file(DISCUZ_ROOT.'source/plugin/'.self::$PLNAME.'/'.$filename)) return TRUE;
		}
	}
	
	public static function _loadextjs($isjq = 0) {
		global $_G;
		if ($isjq && !self::$_G['loadjquery']) {
			$_G['loadjquery'] = 1;
			$jquery = '<script type="text/javascript" src="'.self::$PLSTATIC.'jquery.min.js"></script>
					   <script type="text/javascript">var $$ = jQuery.noConflict();</script>';
		}
		if (self::$_G['loadartjs']) return $jquery;
		$_G['loadartjs'] = 1;
		$artjs = '<script type="text/javascript" src="'.self::$PLSTATIC.'dialog417/dialog.js?skin=default"></script>
				  <script type="text/javascript" src="'.self::$PLSTATIC.'dialog417/plugins/iframeTools.js"></script>';
		return $artjs.$jquery;
	}
	
	public static function avatar($uid, $size = 'small', $ucenterurl = '') {
		$size = in_array($size, array('big', 'middle', 'small')) ? $size : 'middle';
		$ucenterurl = empty($ucenterurl) ? 
				basename(self::$_G['setting']['ucenterurl']).'/avatar.php?uid='.$uid.'&size='.$size : $ucenterurl;
		return $ucenterurl;
	}
	
	public static function lev_replace($str, $separate, $element) {
		$exploade = explode($separate, $str);
		foreach ($exploade as $r) {
			$search = strstr($r, $element);
			if ($search) {
				$str = str_replace($search.$separate, '', $str);
			}
		}
		return $str;
	}
	
	public static function dzhide($message) {
		$_img = explode('[/hide]', $message);
		foreach ($_img as $r) {
			$_hide = strstr($r, '[hide]');
			if ($_hide) {
				$ishide = TRUE;
				$message = str_replace($_hide.'[/hide]', '', $message);
			}
		}
		$message = $ishide ? $message.self::levdiconv('点击查看隐藏内容') : $message;
		return $message;
	}
	public static function dzimg($message) {
		$_img = explode('[/img]', $message);
		foreach ($_img as $k => $r) {
			$imgsrc = trim(strstr($r, '[img'));
			if (!$imgsrc) continue;
			$imgsrc = strstr($imgsrc, self::$_G['siteurl']);
			if (!$imgsrc) continue;
			//if ($k >3) return $imgs;
			$_imgwidth = substr(strstr($r, '[img='), 5);
			if ($_imgwidth) {
				$imgwidth = intval($_imgwidth);
				$imgheight = intval(substr(strstr($_imgwidth, $imgwidth.','), strlen($imgwidth) + 1));
			}else {
				$_imgwidth = getimagesize($imgsrc);
				if (!is_numeric($_imgwidth[0])) continue;
				$imgwidth = $_imgwidth[0];
				$imgheight= $_imgwidth[1];
			}
			$imgs[$k]['src']    = $imgsrc;
			$imgs[$k]['width']  = $imgwidth;
			$imgs[$k]['height'] = $imgheight;
		}
		return $imgs;
	}
	public static function formatatt($str, $source, $num = 4, $isthumb = 0, $style='levatatt') {
		$fallwidth  = self::$PL_G['fallwidth'] >0 ? intval(self::$PL_G['fallwidth']) : 227;
		$fallnwidth = self::$PL_G['fallnwidth'] >0 ? intval(self::$PL_G['fallnwidth']) : $fallwidth - 10;
		$fallnheight= self::$PL_G['fallnheight'] >0 ? intval(self::$PL_G['fallnheight']) : 100;
		$isthumb = $isthumb ? $isthumb : self::isopen('isnthumb');
		if (!$isthumb) return '';
		for ($i=0; $i<$num; $i++) {
			$str = substr(strstr($str, '[attach]'), 8);
			$aid = intval($str);
			$attach = $source[$aid];
			if ($attach) {
				if ($attach['isimage']) {
					if($attach['remote']) {
						$imgsrc = self::$_G['setting']['ftp']['attachurl'].'forum/'.$attach['attachment'];
					} else {
						$imgsrc = self::$_G['siteurl'].self::$_G['setting']['attachurl'].'forum/'.$attach['attachment'];
					}
					if ($isthumb) {
						if ($attach['thumb']) {
							$imgsrc = $imgsrc.'.thumb.jpg';
						}else {
							$imgsrc = self::isthumb($imgsrc, $fallnwidth, $fallnheight, 2);
						}
					}else {
						//$imgsrc = self::isthumb($imgsrc, $fallnwidth, $fallnheight, -1);
					}
					$_atts .= '<img src="'.$imgsrc.'" class="'.$style.'" width="'.$fallnwidth.'" height="'.$fallnheight.'">';
				}else {
					$_atts .= '<img border="0" alt="" class="vm" src="static/image/filetype/zip.gif" height="32">';
				}
			}else {
				break;
			}
		}
		return $_atts;
	}
	public static function getattachs($tids, $attach = 0, $extsql = '') {
		$pretab = 'forum_attachment_';
		$predb  = str_replace('forum_attachment_0', '', DB::table('forum_attachment_0'));
		if (is_array($tids)) {
			$tables = array();
			$tidarr = array();
			foreach ($tids as $r) {
				if (!$r['attachment'] && !$attach) continue;
				$tabid = getattachtableid($r['tid']);
				$tidarr['a'.$tabid] .= $r['tid'].',';
				if (strstr($tables, $pretab.$tabid)) continue;
				$tables['a'.$tabid] = $predb.$pretab.$tabid;
			}
			$_imgs = array();
			foreach($tidarr as $k => $v) {
				$_tids = 'tid IN ('.substr($v, 0, -1).')';
				$_imgs+= self::fetch_all("SELECT * FROM ".$tables[$k]." WHERE $_tids $extsql", array(), 'aid');
			}
			if ($attach ==9) {
				$imgs = array();
				foreach ($_imgs as $t) {
					$imgs[$t['tid']][] = $t;
				}
				$_imgs['tids'] = $imgs;
			}
		}else {
			$tids = intval($tids);
			$tables = $predb.$pretab.getattachtableid($tids);
			$_imgs  = self::fetch_all("SELECT * FROM ".$tables." WHERE tid=$tids");
		}
		return $_imgs;
	}
	
	public static function getbaseuserinfo($uid = 0) {
		$uid  = intval($uid);
		$sql  = "SELECT * FROM ".DB::table('common_member')." a LEFT JOIN ".DB::table('common_member_profile')." b 
				ON(a.uid=b.uid) WHERE a.uid=$uid";
		$user = DB::fetch_first($sql);
		return $user;
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
	
	public static function upload($files, $isimg = 1, $ext = array(), $extid = 0, $forcename = '') {//X2.5 up
		self::ckupload($files, $isimg);
		if (is_array($files)) {
			if (!$isimg) {
				$ext = $ext ? $ext : self::exts();
			}
			$fileroot = DISCUZ_ROOT.self::$PLSTATIC.'upload/';
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
		    		if (!$isimg && self::isopen('zip') && !in_array($upload->attach['ext'], array('zip', 'rar'))) {
		    			rename($upload->attach['target'], $upload->attach['target'].'.'.$upload->attach['ext']);
		    			$upload->attach['attachment'] .= '.'.$upload->attach['ext'];
		    		}
		    		return $upload->attach;
		    	}
		    }
		}
	}
	public static function ckupload($thumb, $isimage = 1, $uploadsize = 0) {
		$uploadsize = $uploadsize ? $uploadsize : self::$PL_G['uploadsize'];
		if ($thumb['error']) {
			showmessage(self::levdiconv('文件上传失败！'.$thumb['error']));
		}elseif ($thumb['size'] > $uploadsize * 1000) {
			showmessage(self::levdiconv('操作失败！上传文件超出限制【'.self::$PL_G['uploadsize'].'KB】'));
		}elseif ($isimage && !strstr($thumb['type'], 'image')) {
			showmessage(self::levdiconv('操作失败！请上传图片文件！'));
		}
	}
	public static function exts() {
		$exts = explode('=', trim(self::$PL_G['exts']));
		if ($exts[0]) return $exts;
		return array();
	}
	
	public static function isopen($key = 'close') {
		$isopen = unserialize(self::$PL_G['isopen']);
		if (is_array($isopen) && in_array($key, $isopen)) return TRUE;
	}
	
	public static function checkfh($ajax = 0) {
		if (self::isopen('checkfh')) {
			$fh   = $_GET['fh'] ? $_GET['fh'] : $_POST['fh'];
			$ajax = isset($_GET['ajax']) ? 1 : $ajax;
			if ($fh != formhash()) {
				$tips = self::levdiconv('抱歉，页面过期请刷新来源页面！');
				if ($ajax) {
					exit($tips);
				}else {
					showmessage($tips);
				}
			}
		}
	}

	public static function levlang($string = '', $key = 0) {
		if ($key && !$string) return array();
		$sets  = $string ? $string : self::$PL_G['levlang'];
		$lang  = array();
		if ($sets) {
			$array = explode("\n", $sets);
			foreach ($array as $r) {
				$thisr  = explode('->', trim($r));
				$lang[trim($thisr[0])] = trim($thisr[1]);
			}
			if (!$key) {
				$lang['extscore']  = self::$_G['setting']['extcredits'][self::$PL_G['scoretype']]['title'];
				$lang['extscore2'] = self::$_G['setting']['extcredits'][self::$PL_G['scoretype2']]['title'];
				$flang = lang('plugin/'.self::$PLNAME);
				if (is_array($flang)) $lang = $lang + $flang;
			}
		}
		return $lang;
	}
	
	public static function navtitle() {
		$navs = self::$_G['setting']['navs'];
		foreach ((array)$navs as $v) {
			if (strpos($v['nav'], self::$PLNAME) !==FALSE) {
				self::$navtitle = $v['navname'];
				break;
			}
		}
	}

	public static function getpluginid() {
		$sql = "SELECT * FROM ".DB::table('common_plugin')." WHERE identifier='".self::$PLNAME."'";
		$pluginid = DB::result_first($sql);
		return $pluginid;
	}
	public static function getpluginvar($var) {
		$pluginid  = self::getpluginid();
		$sql = "SELECT * FROM ".DB::table('common_pluginvar')." WHERE pluginid={$pluginid} AND variable='{$var}'";
		$pluginvar = DB::fetch_first($sql);
		return $pluginvar;
	}
	public static function uppluginvar($var, $val) {
		$pluginid  = self::getpluginid();
		DB::update('common_pluginvar', array('value'=>$val), array('pluginid'=>$pluginid, 'variable'=>$var));
		updatecache('plugin');
	}
	
	public static function fetch_all($sql, $arr = array(), $keyfield = '') {//X2
		$data  = array();
		$query = DB::query($sql);
		while ($row = DB::fetch($query)) {
			if ($keyfield && isset($row[$keyfield])) {
				$data[$row[$keyfield]] = $row;
			} else {
				$data[] = $row;
			}
		}
		return $data;
	}
	
	public static function getattachurl($remote = 0) {
		if($remote) {
			$attachurl = self::$_G['setting']['ftp']['attachurl'].'forum/';
		} else {
			$attachurl = self::$_G['siteurl'].self::$_G['setting']['attachurl'].'forum/';
		}
		return $attachurl;
	}
	public static function getimgsrc($tid, $isthumb = 0, $thumbwidth = 100, $thumbheight = 100, $type = 1) {//X2.5 up
		if($attach = C::t('forum_attachment_n')->fetch_max_image('tid:'.$tid, 'tid', $tid)) {
			$imgsrc = self::getattachurl($attach['remote']).$attach['attachment'];
			if ($isthumb) {
				$thumb = self::isthumb($imgsrc);
				if ($thumb) $imgsrc = $thumb;
			}
		}
		return $imgsrc;
	}
	public static function isthumb($picsource, $thumbwidth = 100, $thumbheight = 100, $type = 1) {
		$picsource = str_replace(self::$_G['siteurl'], '', $picsource);
		$imagename = basename($picsource);
		$thumbpath = 'thumb/'.substr($imagename, 0, 2).'/thumb_'.$thumbwidth.'_'.$thumbheight.'_'.$imagename;
		$fileroot  = DISCUZ_ROOT.self::$PLSTATIC.'upload/';
		if (is_file($fileroot.$thumbpath)) {
			return self::$PLSTATIC.'upload/'.$thumbpath;
		}elseif ($type ==99) {
			if (!self::isopen('isthumb')) return $picsource;
		}elseif (!in_array($type, array(1, 2))) {
			return $picsource;
		}
		require_once libfile('class/image');
		$image = new image();
		setglobal('setting/attachdir', $fileroot);
		$type = in_array($type, array(1, 2)) ? $type : 2;
		if($image->Thumb($picsource, $thumbpath, $thumbwidth, $thumbheight, $type)) {
			return self::$PLSTATIC.'upload/'.$thumbpath;
		}else {
			return $picsource;
		}
	}
	
	public static function acscore($spend, $notice = '', $type = 0, $uid = 0) {
		$type = intval($type) ? intval($type) : self::$PL_G['scoretype'];
		$uid  = intval($uid) ? intval($uid) : self::$_G['uid'];
		if ($uid && intval($spend) && $type >0 && $type <9) {
			$score = DB::fetch_first("SELECT * FROM ".DB::table('common_member_count')." WHERE uid={$uid}");
			$upscore = $score['extcredits'.$type] + $spend;
			if ($upscore >=0) {
				updatemembercount($uid, array($type=>$spend));
				if ($spend >0) $spend = '+'.$spend;
				if (self::isopen('scnotice') && $notice) {
					notification_add($uid, 'system', $notice.' &raquo; '.self::$lang['extscore'].' '.$spend);
				}
				return TRUE;
			}
		}
		return FALSE;
	}
	
	//return $instr = 1,2,3,4,5,6
	public static function sqlinstr($array, $key = '') {
		if (!is_array($array)) {
			$array = (array)unserialize($array);
			$key = '';
		}
		$instr = '';
		if ($key) {
			foreach ($array as $v) {
				if (is_numeric($v[$key])) $instr .= $v[$key].',';
			}
		}else {
			foreach ($array as $v) {
				if (is_numeric($v)) $instr .= $v.',';
			}
		}
		if ($instr) $instr = substr($instr, 0, -1);
		return $instr;
	}

	public static function levpages($table, $where = '', $limit = 20, $start = 0, $url = '', $feilds = '*', $nopage = 0) {
		if (!$url) $url = self::$PLURL;
		
		$where = $table ? DB::table($table).' WHERE '.$where : $where ;
		$page  = $nopage ? 1 : max(intval($_GET['page']), 1);
		$total = DB::result_first("SELECT COUNT(*) FROM ".$where);
		$start = ($page - 1) * $limit + $start;
		$sql   = "SELECT ".$feilds." FROM ".$where." ".self::limit($start, $limit);
		$lists = self::fetch_all($sql);//print_r($lists);
		$pages = multi($total, $limit, $page, $url);//print_r($pages);
		$infos = array('pages'=>$pages, 'lists'=>$lists, 'total'=>$total);
		
		return $infos;
	}
	public static function limit($start, $limit = 0) {
		$limit = intval($limit > 0 ? $limit : 0);
		$start = intval($start > 0 ? $start : 0);
		if ($start > 0 && $limit > 0) {
			return " LIMIT $start, $limit";
		} elseif ($limit) {
			return " LIMIT $limit";
		} elseif ($start) {
			return " LIMIT $start";
		} else {
			return '';
		}
	}
		
	public static function levtree($data = array(), $outarr = array(), $isid = array(), $pid = 0, $str ="", $adds = '', $group = "") {
		$str = $str ? $str : "<option value=\$id \$selected>\$spacer\$name</option>";
		$group = $group ? $group : "<optgroup label=\$name></optgroup>";
		$tree = self::levloadclass('tree.class', 'ext');
		if (empty($data) || !is_array($data)) {
			$sql  = "SELECT fid id,name,fup parentid FROM ".DB::table('forum_forum')." 
						WHERE status!=3 AND status >0 ORDER BY displayorder ASC";
			$data = self::fetch_all($sql, array(), 'id');
		}
		$tree->icon = self::levdiconv(array('│','├','└'));
		$tree->init($data);
		$options = $tree->get_tree_multi($pid, $str, $isid, $adds, $group, $outarr);
		return $options;
	}
	
	public static function levdiconv($string, $in_charset = 'utf-8', $out_charset = CHARSET, $_key = '') {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				if ($_key) {
					$string[$key][$_key] = diconv($val[$_key], $in_charset, $out_charset);
				}else {
					$string[$key] = diconv($val, $in_charset, $out_charset);
				}
			}
		} else {
			$string = diconv($string, $in_charset, $out_charset);
		}
		return $string;
	}
	
	public static function getconfig($key = '', $defaultvalue = '', $file = 'config') {
		static $config = array();
		if (isset($config[$key])) return $config[$key];
		if ($config) return $config;
	
		$m_path = dirname(dirname(__FILE__)).'/config/'.$file.'.inc.php';
		if(!file_exists($m_path)) return $defaultvalue;
		$config = include $m_path;
		if (!$key) return $config;
		if (!isset($config[$key])) return $defaultvalue;
		return $config[$key];
	}
	
	
	public static function connect_login($connect_member) {
		global $_G;
	
		if(!($member = getuserbyuid($connect_member['uid'], 1))) {
			return false;
		} else {
			if(isset($member['_inarchive'])) {
				C::t('common_member_archive')->move_to_master($member['uid']);
			}
		}
	
		require_once libfile('function/member');
		return true;
	}
		
	public static function levloadfunc($func, $path = '') {
		$base = dirname(__FILE__).'/';
		static $funcs = array();
		if (empty($path)) $path = $base.'/func/'; else $path = $base.$path.'/';
		$path.= $func.'.func.php';
		$key  = md5($path);
		if (isset($funcs[$key])) return true;
		if (file_exists($path)) {
			include $path;
		} else {
			$funcs[$key] = false;
			return false;
		}
		$funcs[$key] = true;
		return true;
	}
	
	public static function levloadclass($classname, $class_path = '', $initialize = 1) {
		$base = dirname(__FILE__).'/';
		static $classes = array();
		if (empty($class_path)) {
			$class_path = $base; 
		} else {
			$class_path = $base.$class_path.'/';
		}
		$class_path .= $classname.'.php';

		$key = md5($class_path);
		if (isset($classes[$key])) {
			if (!empty($classes[$key])) {
				return $classes[$key];
			} else {
				return true;
			}
		}

		if (file_exists($class_path)) {
			require_once $class_path;
			$name = str_replace('.class', '', $classname);
			if ($initialize) {
				$classes[$key] = new $name;
			} else {
				$classes[$key] = true;
			}
			return $classes[$key];
		} else {
			return false;
		}
	}

	public static function _run() {
		echo 'Welcome Levme.com!';
	}
		
	private static function __debug() {
		if (self::$debug) {
			error_reporting(E_ALL ^ E_NOTICE);//显示除去 E_NOTICE 之外的所有错误信息
			ini_set('display_errors', 1);
		}
	}

}













