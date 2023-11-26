<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class serialize_cache
{
	var $baseDir	= PICK_CACHE;
	var $pathLevel	= 3;
	var $nameLen	= 2;

	function file_cache() {

	}

	function adp_init($config=array()) {
		extract($config, EXTR_SKIP);
		if (isset($baseDir)){
			$this->baseDir		= $baseDir;
		}
		if (isset($pathLevel)){
			$this->pathLevel	= $pathLevel * 1 ==0 ? 3 : $pathLevel * 1;
		}
		if (isset($nameLen)){
			$this->nameLen		= $nameLen * 1 ==0 ? 2 : $nameLen * 1;
		}
	}


	function get($key, $clearStaticKey=false){
		static $data;
		// 提供给 SET 进行通知，清除静态缓存数据
		if ($clearStaticKey){
			unset($data[$key]);
			return false;
		}
				
		$p = $this->_getSavePath($key);		
		if (isset($data[$key]) && file_exists($p['p'])){
			return $data[$key];
		}

		if ( !file_exists($p['p']) ) {return false;}
		$content = IO::read($p['p']);
		$content = str_replace("<?php die('Permission denied');?>\n", "", $content);
		$d = unserialize($content);
		$d = $d[$key];
		if ( empty($d['ttl']) || $d['timeout'] > TIMESTAMP ){
			$data[$key] = is_array($d['data']) ? $d['data'] : rawurldecode($d['data']);
			return $data[$key];
		}
		return false;
	}

	function set($key, $value, $ttl = 0) {
		$vData	= array($key => array('data' => $value, 'timeout'=> ( TIMESTAMP + $ttl), 'ttl' => $ttl));
		$formatData = "<?php die('Permission denied');?>\n" . serialize($vData);
		$p = $this->_getSavePath($key);		
		//清除GET中的静态缓存数据
		$this->get($key, true);
		return IO::write($p['p'],$formatData);
	}

	function delete($key) {
		$p = $this->_getSavePath($key);
		if (file_exists($p['p'])){
			return IO::rm($p['p']);
		}
		return true;
	}

	function _getSavePath($key) {
		$sKey = $this->_getPriviteKey($key);
		$sArr = explode("\n",wordwrap(str_repeat($sKey,10), $this->nameLen, "\n", 1));
		$pArr = array_slice($sArr, 0,$this->pathLevel);
		$d = $this->baseDir.'/'.implode('/',$pArr);
		$f = $sKey.".cache.php";
		return array('f'=>$f , 'd'=>$d , 'p'=>$d.'/'.$f);
	}

	function _getPriviteKey($key){
		return md5($key);
	}
}


class fileIo
{
	var $err = "";
	function file_io() {
		
	}

	function adp_init($config=array()) {
		
	}
	
	function write($file, $data, $append = false){
		if (!file_exists($file)){
			if (!$this->mkdir(dirname($file))) return false;
		}
		$len  = false;
		$mode = $append ? 'ab' : 'wb';
		$fp = @fopen($file, $mode);
		if (!$fp) {
			LOGSTR('io', 'fopen file error,file:' . $file);
			exit("Can not open file $file !");
		}
		flock($fp, LOCK_EX);
		$len = @fwrite($fp, $data);
		flock($fp, LOCK_UN);
		@fclose($fp);
		return $len;
	}
	
	function read($file) {
		if (!file_exists($file)){
			return false;
		}
		if (!is_readable($file)) {
			LOGSTR('io', 'file can not be read,file:' . $file);
			return false;
		}
		if (function_exists('file_get_contents')){
			return file_get_contents($file);
		}else{
			return (($contents = file($file))) ? implode('', $contents) : false; 
		}
	}
	
	/// get files and dirs not use recursion
	function ls($dir,$r=false,$info=false) {
		if (empty($dir)) $dir = '.';
		if(!file_exists($dir) || !is_dir($dir)){return false;}
		$fs = array();
		$ds = array($dir);
		while(count($ds)>0){
			foreach($ds as $i=>$d){
				unset($ds[$i]);
				$handle = opendir($d);
				while (false !== ($item = readdir($handle))) {
					if ($item == '.' || $item == '..') continue;
					$fp = ( $d=='.' || $d=='.\\' ||  $d=='./'  ) ? $item :  $d.DIRECTORY_SEPARATOR.$item;
					$t =  is_file($fp) ? 'f' : (is_dir($fp) ? 'd' : 'o');
					if (is_dir($fp) && $r) { $ds[]=$fp; }
					$fs[] = ($info ? array($t,$fp,$this->info($fp)) : array($t,$fp));
				}
			}
		}
		return $fs;
	}
	
	function mkdir($path) {
		$rst = true;
		if (!file_exists($path)){
			$this->mkdir(dirname($path));
			$rst = @mkdir($path, 0777);
		}
		return $rst;
	}
	
	function rm($path){
		$path = rtrim($path,'/\\ ');
		if ( !is_dir($path) ){ return @unlink($path); }
		if ( !$handle= opendir($path) ){ 
			LOGSTR('io', 'opendir error,dir:' . $path);
			return false; 
		}
		
		while( false !==($file=readdir($handle)) ){
			if($file=="." || $file=="..") continue ;
			$file=$path .DIRECTORY_SEPARATOR. $file;
			if(is_dir($file)){ 
				$this->rm($file);
			} else {
				if(!@unlink($file)){
					LOGSTR('io','delete file error when delete dir,file:'.$file);
					return false;
				}
			}

		}
		closedir($handle);
		if(!rmdir($path)){
			LOGSTR('io', 'delete dir error,dir:'. $path);
			return false;
		}
		return true;
	}
	
	function info($path=".",$key=false) {
		$path = realpath($path);
		if (!$path) false;
		$result = array(
			"name"		=> substr($path, strrpos($path, DIRECTORY_SEPARATOR)+1),
			"location"	=> $path,
			"type"		=> is_file($path) ? 1 : (is_dir($path) ? 0 : -1),
			"size"		=> filesize($path),
			"access"	=> fileatime($path),
			"modify"	=> filemtime($path),
			"change"	=> filectime($path),
			"read"		=> is_readable($path),
			"write"		=> is_writable($path)
			);
		clearstatcache();
		return $key ? $result[$key] : $result;
	}

}

class IO {
	function IO (){
	}

	function getInstance(){
		return new fileIo();
	}
	function &instance(){
		static $c;
		if(empty($c)) {
			$c =  new fileIo();
		}
		return $c;
	}
	//------------------------------------------------------------------
	/**
	 * IO::ls($path,$r=false,$info=false);
	 * 获取某个目录的文件列表
	 * @param $path		要处理的目录
	 * @param $r		是否递归子目录
	 * @param $info		是否获取每个文件的文件信息
	 * @return 文件信息列表
	 */
	function ls($path,$r=false,$info=false){
		$c = & IO::instance();
		return $c->ls($path,$r,$info);
	}
	//------------------------------------------------------------------
	/**
	 * IO::write($file,$contents,$append=false);
	 * 写入一个文件
	 * @param $file			目标文件路径，如果目录结构不存在则自动创建
	 * @param $contents		文件内容
	 * @param $append		是否将内容追加到文件末尾，默认为 false 重写文件
	 * @return 写入字节数 失败返回 false
	 */
	function write($file,$contents,$append=false) {
		$c = & IO::instance();
		return $c->write($file,$contents,$append);
	}
	/**
	 * IO::read($file);
	 * @param $file		目标文件路径
	 * @return 如果文件存在，返回内容 反之返回 false
	 */
	function read($file) {
		$c = & IO::instance();
		return $c->read($file);
	}
	/**
	 * IO::mkdir($path);
	 * 生成目录结构，创建目录
	 * @param $path		目录结构
	 * @return 成功返回 true 失败返回 false
	 */
	function mkdir($path) {
		$c = & IO::instance();
		return $c->mkdir($path);
	}
	/**
	 * IO::rm($path);
	 * 删除一个路径，如果是目录则删除它的子目录以及文件
	 * @param $path	要删除的目标路径
	 * @return 删除成功 返回 true 反之 返回 false
	 */
	function rm($path) {
		$c = & IO::instance();
		return $c->rm($path);
	}
	/**
	 * IO::info($path,$key=false);
	 * 获取一个文件、目录的信息
	 * @param $path		目标路径
	 * @param $key		如果 $key 为空 返回所有文件信息  反之返回 文件信息中的  $key 项
	 * @return 文件信息
	 */
	function info($path,$key=false) {
		$c = & IO::instance();
		$info = $c->info($path);
		if(is_dir($path)){
			$file_arr = $c->ls($path, TRUE, TRUE);
			$size = 0;
			$file_list = array();
			foreach((array)$file_arr as $k => $v){
				if($v[2]['type'] != 1) continue;
				$size += $v[2]['size'];
				$ls[] = $v[2];
			}
			$info['size'] = $size;
			$info['ls'] = $ls;
		}
		return $info;
	}
	//------------------------------------------------------------------
}

function LOGSTR($type = '',$msg = ''){
	return $msg;
}

if(!function_exists('dir_clear')){
	function dir_clear($dir) {
		if($directory = @dir($dir)) {
			while($entry = $directory->read()) {
				if($entry == '.' || $entry == '..') {
					continue;
				}
				$filename = $dir.'/'.$entry;
				if(is_file($filename)) {
					@unlink($filename);
				} else {
					dir_clear($filename);
				}
			}
			$directory->close();
			@rmdir($dir);
		}
	}
}

?>