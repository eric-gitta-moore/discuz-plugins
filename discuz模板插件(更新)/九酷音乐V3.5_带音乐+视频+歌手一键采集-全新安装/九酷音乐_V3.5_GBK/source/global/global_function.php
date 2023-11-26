<?php
error_reporting(0);
session_start();
date_default_timezone_set('PRC');
function ss_timing_start ($name = 'default') {
      global $ss_timing_start_times;
      $ss_timing_start_times[$name] = explode(' ', microtime());
}
function ss_timing_stop ($name = 'default') {
      global $ss_timing_stop_times;
      $ss_timing_stop_times[$name] = explode(' ', microtime());
}
function ss_timing_current ($name = 'default') {
      global $ss_timing_start_times, $ss_timing_stop_times;
      if (!isset($ss_timing_start_times[$name])) {
          return 0;
      }
      if (!isset($ss_timing_stop_times[$name])) {
          $stop_time = explode(' ', microtime());
      }else {
          $stop_time = $ss_timing_stop_times[$name];
      }
      $current = $stop_time[1] - $ss_timing_start_times[$name][1];
      $current += $stop_time[0] - $ss_timing_start_times[$name][0];
      return $current;
}
ss_timing_start();

function getupdatetime() {
	$current_time = date('Y-m-d');
	if($current_time>date('Y-01-01') && $current_time<date('Y-06-30')){
		$time = date('Y-06-30');

	}elseif($current_time>=date('Y-06-30') && $current_time<date('Y-12-31')){
		$time = date('Y-12-31');
	}
	return $time;
}

function getendtime() {
	$current_time = date('Y-m-d');
	if($current_time<=date('Y-06-30')){
		$time = date('Y-12-31');
	}else{
		$time = (date('Y')+1).'-06-30';
	}
	return $time;
}

function getviprank($rank,$l = '0') {
	if($rank >= 0 and $rank < 400){
		$ulevel = 0;
		$dlevel = 400;
                $userranka="1";
                $ranka=$rank-$ulevel;
                $rankb=$dlevel-$ulevel;
                $userrankb=sprintf("%01.1f",$ranka/$rankb*100);
                $userrankc=$dlevel-$rank;

	}elseif($rank >= 400 and $rank < 1600){
		$ulevel = 400;
		$dlevel = 1600;
                $userranka="2";
                $ranka=$rank-$ulevel;
                $rankb=$dlevel-$ulevel;
                $userrankb=sprintf("%01.1f",$ranka/$rankb*100);
                $userrankc=$dlevel-$rank;

	}elseif($rank >= 1600 and $rank < 3600){
		$ulevel = 1600;
		$dlevel = 3600;
                $userranka="3";
                $ranka=$rank-$ulevel;
                $rankb=$dlevel-$ulevel;
                $userrankb=sprintf("%01.1f",$ranka/$rankb*100);
                $userrankc=$dlevel-$rank;

	}elseif($rank >= 3600 and $rank < 6400){
		$ulevel = 3600;
		$dlevel = 6400;
                $userranka="4";
                $ranka=$rank-$ulevel;
                $rankb=$dlevel-$ulevel;
                $userrankb=sprintf("%01.1f",$ranka/$rankb*100);
                $userrankc=$dlevel-$rank;

	}elseif($rank >= 6400 and $rank < 10000){
		$ulevel = 6400;
		$dlevel = 10000;
                $userranka="5";
                $ranka=$rank-$ulevel;
                $rankb=$dlevel-$ulevel;
                $userrankb=sprintf("%01.1f",$ranka/$rankb*100);
                $userrankc=$dlevel-$rank;

	}elseif($rank >= 10000 and $rank < 14400){
		$ulevel = 10000;
		$dlevel = 14400;
                $userranka="6";
                $ranka=$rank-$ulevel;
                $rankb=$dlevel-$ulevel;
                $userrankb=sprintf("%01.1f",$ranka/$rankb*100);
                $userrankc=$dlevel-$rank;

	}elseif($rank >= 14400 and $rank < 19600){
		$ulevel = 14400;
		$dlevel = 19600;
                $userranka="7";
                $ranka=$rank-$ulevel;
                $rankb=$dlevel-$ulevel;
                $userrankb=sprintf("%01.1f",$ranka/$rankb*100);
                $userrankc=$dlevel-$rank;

	}elseif($rank >= 19600 and $rank < 25600){
		$ulevel = 19600;
		$dlevel = 25600;
                $userranka="8";
                $ranka=$rank-$ulevel;
                $rankb=$dlevel-$ulevel;
                $userrankb=sprintf("%01.1f",$ranka/$rankb*100);
                $userrankc=$dlevel-$rank;

	}elseif($rank >= 25600 and $rank < 32400){
		$ulevel = 25600;
		$dlevel = 32400;
                $userranka="9";
                $ranka=$rank-$ulevel;
                $rankb=$dlevel-$ulevel;
                $userrankb=sprintf("%01.1f",$ranka/$rankb*100);
                $userrankc=$dlevel-$rank;

	}elseif($rank >= 32400){
                $userranka="10";
                $ranka=0;
                $userrankb="100";
                $userrankc=0;

	}
	if($l==1){
                $qianwei_rank=$userrankb."%";
	}elseif($l==2){
                $qianwei_rank=$userrankc;
	}elseif($l==3){
                $qianwei_rank=$dlevel;
	}else{
                $qianwei_rank=$userranka;
	}
	return $qianwei_rank;
}

function getmrank($rank,$l = '0') {
	$__level = $rank;
	$ratio = 10;
	$dengji = 1;
	for ($i = 1; $i < 100; $i++) {
		if ($__level < (($i * $i) * ($i * $ratio))){
			$dengji = $i-1;
			$level = (($i * $i) * ($i * $ratio));
			$ulevel = ((($i-1) * ($i-1)) * (($i-1) * $ratio));
			$ratios = $level-$ulevel;
			break;
		}
	}
	if($l==1){
		$ranka = $rank-$ulevel;
                $qianwei_rank = sprintf("%01.1f",$ranka/$ratios*100)."%";
	}elseif($l==2){
		$qianwei_rank = $level-$rank;
	}elseif($l==3){
		$qianwei_rank = $dengji;
	}elseif($l==4){
		$ranka = $rank-$ulevel;
                $qianwei_rank = sprintf("%01.0f",$ranka/$ratios*100)."%";
	}else{
                $qianwei_rank = "Lv".$dengji;
	}
	return $qianwei_rank;
}

function getdancerank($rank,$l = '0') {
	$__level = $rank;
	$ratio = 10;
	$dengji = 1;
	for ($i = 1; $i < 100; $i++) {
		if ($__level < ($i * ($i * $ratio))){
			$dengji = $i-1;
			$level = ($i * ($i * $ratio));
			$ulevel = (($i-1) * (($i-1) * $ratio));
			$ratios = $level-$ulevel;
			break;
		}
	}
	if($l==1){
		$ranka = $rank-$ulevel;
                $qianwei_rank = sprintf("%01.1f",$ranka/$ratios*100)."%";
	}elseif($l==2){
		$qianwei_rank = $level-$rank;
	}elseif($l==3){
		$qianwei_rank = $dengji;
	}elseif($l==4){
		$ranka = $rank-$ulevel;
                $qianwei_rank = sprintf("%01.0f",$ranka/$ratios*100)."%";
	}else{
                $qianwei_rank = "Lv".$dengji;
	}
	return $qianwei_rank;
}

function getsetting($value) {
	global $db;
	$value = $db->getrow("select cd_value from ".tname('setting')." where cd_key='".$value."'");
	if($value){
		$values = $value['cd_value'];
	}else{
		$values = getendtime();
	}
	return $values;
}

function getavatars($uid, $cid='0'){
	if($cid == 1){
		$size = "middle";
		$width = "120";
	}elseif($cid == 2){
		$size = "big&.jpg";
		$width = "200";
	}else{
		$size = "small";
		$width = "48";
	}
	global $db;
	$row = $db->getrow("select * from ".tname('user')." where cd_id=".$uid);
	$avatar = _qianwei_root_."data/attachment/avatar/".$uid."_".$width."x".$width.".jpg";
	if(!file_exists($avatar) && IsNul($row['cd_qqopen'])){
		$avatar = $row['cd_qqimg']."&.jpg";
	}elseif(cd_ucenter==1 && $row['cd_ucenter']>0){
		require_once _qianwei_root_.'./client/ucenter.php';
		$avatar = UC_API."/avatar.php?uid=".$row['cd_ucenter']."&size=".$size;
	}else{
	        if(file_exists($avatar)){
		        $avatar = cd_webpath."data/attachment/avatar/".$uid."_".$width."x".$width.".jpg";
	        }else{
		        $avatar = cd_upath."static/images/noface_".$width."x".$width.".gif";
	        }
	}
	return $avatar;
}

function getalbumthumb($url, $cid='0'){
	if($cid == 1) {
		$album = cd_webpath."data/attachment/album/".$url.".thumb.".fileext($url);
	} elseif($cid == 2) {
		$album = cd_webpath."data/attachment/album/".$url.".thumb_180x180.".fileext($url);
	} else {
		$album = cd_webpath."data/attachment/album/".$url;
	}
	return $album;
}

function formatsize($size) {
	$prec=3;
	$size = round(abs($size));
	$units = array(0=>" B", 1=>" KB", 2=>" MB", 3=>" GB", 4=>" TB");
	if ($size==0) return str_repeat(" ", $prec)."0$units[0]";
	$unit = min(4, floor(log($size)/log(2)/10));
	$size = $size * pow(2, -10*$unit);
	$digi = $prec - 1 - floor(log($size)/log(10));
	$size = round($size * pow(10, $digi)) * pow(10, -$digi);
	return $size.$units[$unit];
}

function ZxingCrypt($date,$mode = 'encode'){
	$key = md5('qianwei');
	if ($mode == 'decode'){ 
		$date = base64_decode($date); 
	}
	if (function_exists('mcrypt_create_iv')){ 
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB); 
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND); 
	}
	if (isset($iv) && $mode == 'encode'){ 
		$passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $date, MCRYPT_MODE_ECB, $iv);
	}elseif (isset($iv) && $mode == 'decode'){ 
		$passcrypt = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $date, MCRYPT_MODE_ECB, $iv); 
	}
	if ($mode == 'encode'){
		$passcrypt = base64_encode($passcrypt); 
	}
	return $passcrypt;
}

function getlen($para='',$val='',$res=''){
	if(!empty($para) && !empty($val)){
		if(is_numeric($val)){
			$cont=cnsubstr($res,intval($val));
		}else{
			$cont=$res;
		}
	}else{
		$cont=$res;
	}
	return $cont;
}

function fileext($filename) {
	return strtolower(trim(substr(strrchr($filename, '.'), 1)));
}

function tname($name) {
	return cd_tablename.$name;
}

function IsNum($str){
	if( is_numeric($str) ){
		return true;
	}else{
		return false;
	}
}

function IsNul($str){
	if (!is_string($str)) return false;
	if (empty($str)) return false;
	if ($str=='') return false;
	return true;
}

function str_encode($str){
	$str=ReplaceStr($str,"\"","&quot;");
	$str=ReplaceStr($str,"'","&#039;");
	$str=ReplaceStr($str,"<","&lt;");
	$str=ReplaceStr($str,">","&gt;");
	return $str;
}

function str_r_n($str){
	$str=ReplaceStr($str,"\r\n","<br>");
	$str=ReplaceStr($str,"&lt;br&gt;","<br>");
	return $str;
}

function str_sex($str){
	if($str=="1"){
		$str_sex="帅哥";
	}else{
		$str_sex="美女";
	}
	return $str_sex;
}

function str_isbest($str){
	if($str=="0"){
		$str_best="☆☆☆☆☆";
	}elseif($str=="1"){
		$str_best="★☆☆☆☆";
	}elseif($str=="2"){
		$str_best="★★☆☆☆";
	}elseif($str=="3"){
		$str_best="★★★☆☆";
	}elseif($str=="4"){
		$str_best="★★★★☆";
	}elseif($str=="5"){
		$str_best="★★★★★";
	}
	return $str_best;
}

function numtoabc($str){
	$str=ReplaceStr($str,"0","ling");
	$str=ReplaceStr($str,"1","yi");
	$str=ReplaceStr($str,"2","er");
	$str=ReplaceStr($str,"3","san");
	$str=ReplaceStr($str,"4","si");
	$str=ReplaceStr($str,"5","wu");
	$str=ReplaceStr($str,"6","liu");
	$str=ReplaceStr($str,"7","qi");
	$str=ReplaceStr($str,"8","ba");
	$str=ReplaceStr($str,"9","jiu");
	return $str;
}

function SafeRequest($key,$mode){
	$magic=get_magic_quotes_gpc();
	switch($mode){
		case 'post':
			$value=isset($_POST[$key]) ? $magic?trim($_POST[$key]):addslashes(trim($_POST[$key])) : '';
			break;
		case 'get':
			$value=isset($_GET[$key]) ? $magic?trim($_GET[$key]):addslashes(trim($_GET[$key])) : '';
			break;
		default:
			$value=isset($_POST[$key]) ? $magic?trim($_POST[$key]):addslashes(trim($_POST[$key])) : '';
			if($value==""){
				$value=isset($_GET[$key]) ? $magic?trim($_GET[$key]):addslashes(trim($_GET[$key])) : '';
			}
			break;
	}
	return htmlspecialchars($value,ENT_QUOTES);
}

function RequestBox($key, $classid='0'){
	if($classid==1){
		$array =isset($_GET[$key]) ? $_GET[$key] : '';
	}else{
		$array =isset($_POST[$key]) ? $_POST[$key] : '';
	}
	if($array==""){
		$value="0";
	}else{
		for($i=0;$i<count($array);$i++){
			$value=implode(',',$array);
		}
	}
	return $value;
}

function ReplaceStr($text,$search,$replace){
	if(empty($text)){$text="";}
	$result_text=str_replace($search, $replace, $text);
	return $result_text;
}

function destroyDir($dir, $virtual=false) {
        $ds = DIRECTORY_SEPARATOR;
        $dir = $virtual ? realpath($dir) : $dir;
        $dir = substr($dir, -1) == $ds ? substr($dir, 0, -1) : $dir;
        if(is_dir($dir) && $handle=opendir($dir)) {
                while ($file = readdir($handle)) {
                        if($file == '.' || $file == '..') {
                                continue;
                        }elseif(is_dir($dir.$ds.$file)) {
                                destroyDir($dir.$ds.$file);
                        }else{
                                unlink($dir.$ds.$file);
                        }
                }
                closedir($handle);
                rmdir($dir);
                return true;
        }else{
                return false;
        }
}

function creatdir($path){
	if(!is_dir($path)){
		if(creatdir(dirname($path))){
			mkdir($path,0777);
			return true;
		}
	}else{
		return true;
	}
}

function spandir($dir){
	$spandirpos=strrpos($dir,'/');
	$spandir=substr($dir,0,$spandirpos+1);
	if(!file_exists($spandir)){
		mkdir($spandir,0777,true);
	}
}

function cnsubstr($str,$strlen=10) {
	if(empty($str)||!is_numeric($strlen)){
		$strlen=10;
	}
	$strlen=intval($strlen*2);
	if(strlen($str)<=$strlen){
		return $str;
	}
	$last_word_needed=substr($str,$strlen-1,1);
	if(!ord($last_word_needed)>128){
		$needed_sub_sentence=substr($str,0,$strlen);
	}else{
		for($i=0;$i<$strlen;$i++){
			if(ord($str[$i])>128){
				$i++;
			}
		}
		$needed_sub_sentence=substr($str,0,$i);
	}
	if(strlen($str)<=$strlen){
		return $needed_sub_sentence;
	}else{
		return $needed_sub_sentence."...";
	}
}

function datetime($TimeTime){
	$limit=time()-strtotime($TimeTime);
	if ($limit < 5) { $show_t = "刚刚"; }
	if ($limit >= 5 and $limit < 60) { $show_t = $limit."秒前"; }
	if ($limit >= 60 and $limit < 3600) { $show_t = sprintf("%01.0f", $limit/60)."分钟前"; }
	if ($limit >= 3600 and $limit < 86400) { $show_t = sprintf("%01.0f", $limit/3600)."小时前"; }
	if ($limit >= 86400 and $limit < 2592000) { $show_t = sprintf("%01.0f", $limit/86400)."天前"; }
	if ($limit >= 2592000 and $limit < 31104000) { $show_t = sprintf("%01.0f", $limit/2592000)."个月前"; }
	if ($limit >= 31104000) { $show_t = $TimeTime; }
 	return $show_t;
}

function DateDiff($d1,$d2=""){
 	if(is_string($d1))$d1=strtotime($d1);
 	if(is_string($d2))$d2=strtotime($d2);
 	return ($d2-$d1);
}

function getpagerow($mysql,$pagesize){
	global $db;
	$url=$_SERVER["QUERY_STRING"];
	if(stristr($url,'&pages')){
		$url=preg_replace('/&pages=([\S]+?)$/','',$url);
	}
	if(stristr($url,'pages')){
		$url=preg_replace('/pages=([\S]+?)$/','',$url);
	}
	if(IsNul($url)){$url.="&";}
	$pages=SafeRequest("pages","get");
	$pagesok=$pagesize;
	if (!isset($pages)||$pages==""||!is_numeric($pages)||$pages<=0){
		$pages=1;
	}
  	$sqlstr=$mysql;
  	$res=$db -> query($sqlstr);
 	$nums= $db -> num_rows($res);
	if($nums==0){$nums=1;}
 	$str="<tr><td colspan=\"15\"><div class=\"cuspages right\"><div class=\"pg\"><em>&nbsp;".$nums."&nbsp;</em>";
	$pagejs=ceil($nums/$pagesok);
	if($pages>$pagejs){
		$pages=$pagejs;
	}
	$sql=$sqlstr." LIMIT ".$pagesok*($pages-1).",".$pagesok;
	$result = $db -> query($sql);
	$str.= "<a href=\"?".$url."pages=1\" class=\"prev\">首页</a>";
	if($pages>1){
		$str.="<a href=\"?".$url."pages=".($pages-1)."\" class=\"prev\">&lsaquo;&lsaquo;</a>";
	}
	if($pagejs<=10){
  		for($i=1;$i<=$pagejs;$i++){
   			if($i==$pages){
   				$str.="<strong>".$i."</strong>";
   			}else{
   				$str.="<a href=\"?".$url."pages=".$i."\">".$i."</a>";
   			}
 	 	}
	}else{
 		if($pages>=12){
 			for($i=$pages-5;$i<=$pages+6;$i++){
   				if($i<=$pagejs){
   				        if($i==$pages){
   						$str.="<strong>".$i."</strong>";
   				        }else{
   						$str.="<a href=\"?".$url."pages=".$i."\">".$i."</a>";
   				        }
    				}
  			}
  			if($i<=$pagejs){ 
    				$str.="...";
	    			$str.="<a href=\"?".$url."pages=".$pagejs."\">".$pagejs."</a>";
   			}
   		}else{
  			for($i=1;$i<=12;$i++){
   				if($i==$pages){
   					$str.="<strong>".$i."</strong>";
   				}else{
   					$str.="<a href=\"?".$url."pages=".$i."\">".$i."</a>";
   				}
 			} 
 			if($i<=$pagejs){ 
      				$str.="...";
	  			$str.="<a href=\"?".$url."pages=".$pagejs."\">".$pagejs."</a>";
    			}
 		 }
	}
	if($pages<$pagejs){
		$str.="<a href=\"?".$url."pages=".($pages+1)."\" class=\"nxt\">&rsaquo;&rsaquo;</a>";
	}
	$str.="<a href=\"?".$url."pages=".$pagejs."\" class=\"nxt\">尾页</a>";
	$str.="<em>&nbsp;".$pages."/".$pagejs."&nbsp;</em></div></div></td></tr>";
	while ($row = $db -> fetch_array($result)){}
	$arr=array($str,$result,$sql,$pagejs);
	return $arr;
}

class iFile {
	private $Fp;
	private $Pipe;
	private $File;
	private $OpenMode;
	private $Data;
	function iFile($File,$Mode = 'r',$Data4Write='',$Pipe = 'f'){
        	$this -> File = $File;
        	$this -> Pipe = $Pipe;
        	if($Mode == 'dr'){
        		$this -> OpenMode = 'r';
        		$this -> OpenFile();
        		$this -> getFileData();
        	}else{
        		$this -> OpenMode = $Mode;
        		$this -> OpenFile();
        	}
        	if($this->OpenMode=='w'&$Data4Write!=''){
        		$this -> WriteFile($Data4Write,$Mode = 3);
        	}
	}
	function OpenFile(){
        	if($this -> OpenMode == 'r'||$this -> OpenMode == 'r+'){
            		if($this->CheckFile()){
                		if($this -> Pipe == 'f'){
                			$this->Fp = fopen($this -> File, $this -> OpenMode);
                		}elseif ($Pipe == 'p'){
                			$this->Fp = popen($this -> File, $this -> OpenMode);
                		}else{
                			die("Please check the file open parameter 3,f:fopen()");
                		}
			}else{
                		die("File access error, please check if the file exists!");
			}
		}else{
			if($this -> Pipe == 'f'){
				$this->Fp = fopen($this -> File, $this -> OpenMode);
			}elseif ($Pipe == 'p'){
				$this->Fp = popen($this -> File, $this -> OpenMode);
			}else{
				die("Please check the file open parameter 3,f:fopen()");
			}
		}
	}
	function CloseFile(){
        	if($this->Pipe == 'f'){
        		@fclose($this->Fp);
        	}else{
        		@pclose($this->Fp);
        	}
	}
	function getFileData(){
        	@flock($this->Fp, 1);
        	$Content = fread($this->Fp, filesize($this->File));
        	$this->Data = $Content;
	}
	function CheckFile(){
        	if (file_exists($this -> File)) { return true; } else { return false; }
	}
	function WriteFile($Data4Write,$Mode = 3){
        	@flock($this->Fp,$Mode);
        	fwrite($this->Fp,$Data4Write);
        	$this->CloseFile();
        	return true;
	}
}

function escape($str){
       preg_match_all("/[\x80-\xff].|[\x01-\x7f]+/",$str,$r);
       $ar=$r[0];
       foreach($ar as $k=>$v){
       if(ord($v[0]) < 128)
              $ar[$k] = rawurlencode($v);
       else
              $ar[$k] = "%u".bin2hex(iconv("GBK","UCS-2",$v));
       }
       return join("",$ar);
}

function unescape($str) {
       $str = rawurldecode($str); 
       preg_match_all("/%u.{4}|&#x.{4};|&#d+;|.+/U",$str,$r); 
       $ar = $r[0]; 
       foreach($ar as $k=>$v) { 
              if(substr($v,0,2) == "%u") 
                     $ar[$k] = mb_convert_encoding(pack("H4",substr($v,-4)),"gb2312","UCS-2");
              elseif(substr($v,0,3) == "&#x") 
                     $ar[$k] = mb_convert_encoding(pack("H4",substr($v,3,-1)),"gb2312","UCS-2");
              elseif(substr($v,0,2) == "&#") { 
                     $ar[$k] = mb_convert_encoding(pack("H4",substr($v,2,-1)),"gb2312","UCS-2");
              }
       }
       return str_encode(join("",$ar));
}

function linkweburl($UserID,$UserName){
	if($UserID==""){
		$linkweburl=cd_upath;
	}else{
		switch(cd_userhtml){
			case '0':
				$linkweburl="http://".$_SERVER['HTTP_HOST'].cd_upath."index.php?p=space&uid=".$UserID;
				break;
			case '1':
				$linkweburl="http://".$_SERVER['HTTP_HOST'].cd_upath.$UserID."/";
				break;
		}
	}
	return $linkweburl;
}

function LinkSpecialUrl($Table,$ClassID,$SystemID,$ID){
	$Table=strtolower($Table);
	if($Table=='special'){
	if($ID==0){
		$LinkSpecialUrl=cd_webpath;
	}else{
		switch(cd_webhtml){
			case '1':
				$LinkSpecialUrl=cd_webpath."index.php/album/".$ID."/";
				break;
			case '2':
				$LinkSpecialUrl=str_linkurl(cd_caspecialfolder,$ID,$ClassID,0);
				break;
			case '3':
				$LinkSpecialUrl=cd_webpath."album/".$ID."/";
				break;
		}
	}
	}
	return $LinkSpecialUrl;
}

function LinkSingerUrl($Table,$ClassID,$SystemID,$ID){
	$Table=strtolower($Table);
	if($Table=='singer'){
	if($ID==0){
		$LinkSingerUrl=cd_webpath;
	}else{
		switch(cd_webhtml){
			case '1':
				$LinkSingerUrl=cd_webpath."index.php/singer/".$ID."/";
				break;
			case '2':
				$LinkSingerUrl=str_linkurl(cd_casingerfolder,$ID,$ClassID,0);
				break;
			case '3':
				$LinkSingerUrl=cd_webpath."singer/".$ID."/";
				break;
		}
	}
	}
	return $LinkSingerUrl;
}

function LinkFmUrl($ClassID){
		switch(cd_webhtml){
			case '1':
				$LinkFmUrl=cd_webpath."user.php?mod=radio&fm=".$ClassID;
				break;
			case '2':
				$LinkFmUrl=cd_webpath."user.php?mod=radio&fm=".$ClassID;
				break;
			case '3':
				$LinkFmUrl=cd_webpath."fm/".$ClassID."/";
				break;
		}
	return $LinkFmUrl;
}

function LinkDownUrl($ID){
		switch(cd_webhtml){
			case '1':
				$LinkDownUrl=cd_webpath."index.php/down/".$ID."/";
				break;
			case '2':
				$LinkDownUrl=cd_webpath."index.php/down/".$ID."/";
				break;
			case '3':
				$LinkDownUrl=cd_webpath."down/".$ID."/";
				break;
		}
	return $LinkDownUrl;
}

function LinkDianGeUrl($ID){
		switch(cd_webhtml){
			case '1':
				$LinkDianGeUrl=cd_webpath."user.php?do=diange&id=".$ID;
				break;
			case '2':
				$LinkDianGeUrl=cd_webpath."user.php?do=diange&id=".$ID;
				break;
			case '3':
				$LinkDianGeUrl=cd_webpath."diange/".$ID."/";
				break;
		}
	return $LinkDianGeUrl;
}

function LinkFavUrl($ID){
		switch(cd_webhtml){
			case '1':
				$LinkFavUrl=cd_webpath."user.php?do=favorites&id=".$ID;
				break;
			case '2':
				$LinkFavUrl=cd_webpath."user.php?do=favorites&id=".$ID;
				break;
			case '3':
				$LinkFavUrl=cd_webpath."favorites/".$ID."/";
				break;
		}
	return $LinkFavUrl;
}

function LinkErrorUrl($ID){
		switch(cd_webhtml){
			case '1':
				$LinkErrorUrl=cd_webpath."user.php?do=error&id=".$ID;
				break;
			case '2':
				$LinkErrorUrl=cd_webpath."user.php?do=error&id=".$ID;
				break;
			case '3':
				$LinkErrorUrl=cd_webpath."wrong/".$ID."/";
				break;
		}
	return $LinkErrorUrl;
}

function LinkUrl($Table,$ClassID,$SystemID,$ID){
	$Table=strtolower($Table);
	switch(cd_webhtml){
		case '1':
			if($Table=='music'){	
				$LinkUrl=cd_webpath."index.php/song/".$ID."/";
			}elseif($Table=='special'){
				$LinkUrl=cd_webpath."index.php/album/".$ID."/";
			}elseif($Table=='singer'){
				$LinkUrl=cd_webpath."index.php/singer/".$ID."/";
			}elseif($Table=='video'){
				$LinkUrl=cd_webpath."index.php/video/".$ID."/";
			}
			break;
		case '2':
			if($Table=='music'){
				$LinkUrl=str_linkurl(cd_caplayfolder,$ID,$ClassID,0);
			}elseif($Table=='special'){
				$LinkUrl=str_linkurl(cd_caspecialfolder,$ID,$ClassID,0);
			}elseif($Table=='singer'){
				$LinkUrl=str_linkurl(cd_casingerfolder,$ID,$ClassID,0);
			}elseif($Table=='video'){
				$LinkUrl=str_linkurl(cd_cavideofolder,$ID,$ClassID,0);
			}
			break;
		case '3':
			if($Table=='music'){	
				$LinkUrl=cd_webpath."song/".$ID."/";
			}elseif($Table=='special'){
				$LinkUrl=cd_webpath."album/".$ID."/";
			}elseif($Table=='singer'){
				$LinkUrl=cd_webpath."singer/".$ID."/";
			}elseif($Table=='video'){
				$LinkUrl=cd_webpath."video/".$ID."/";
			}
			break;
	}
	return $LinkUrl;
}

function str_linkurl($str,$ID,$ClassID,$Page){
	$str=ReplaceStr($str,"[系统目录]",cd_webpath);
	$str=ReplaceStr($str,"[数字编号]",$ID);
	$str=ReplaceStr($str,"[字母编号]",numtoabc($ID));
	$str=ReplaceStr($str,"[加密编号]",substr(md5($ID),8,16));
	$str=ReplaceStr($str,"[栏目编号]",$ClassID);
	$str=ReplaceStr($str,"[分页编号]",$Page);
	$str=ReplaceStr($str,"[英文别名]",GetAlias("qianwei_class","CD_AliasName","CD_ID",$ClassID));
	return $str;	
}

function LinkClassUrl($Table,$ID,$SystemID,$Page){
	$Table=strtolower($Table);
	if(!IsNum($Page)){$Page=1;}
	switch($Table){
		case 'music':
			if($SystemID==1){
				switch(cd_webhtml){
					case '1':
						$LinkClassUrl=cd_webpath."index.php/list/".$ID."/".$Page."/";
						break;
					case '2':
						$LinkClassUrl=str_linkurl(cd_calistfolder,$ID,$ID,$Page);
						break;
					case '3':
						$LinkClassUrl=cd_webpath."list/".$ID."/".$Page."/";
						break;
				}
			}else{
				$LinkClassUrl=GetAlias("qianwei_class","CD_AliasName","CD_ID",$ID);
			}
			break;
		case 'video':
			switch(cd_webhtml){
				case '1':
					$LinkClassUrl=cd_webpath."index.php/class/".$ID."/".$Page."/";
					break;
				case '2':
					$LinkClassUrl=str_linkurl(cd_cavideocfolder,$ID,$ID,$Page);
					break;
				case '3':
					$LinkClassUrl=cd_webpath."class/".$ID."/".$Page."/";
					break;
			}
			break;
	}
	return $LinkClassUrl;
}

function LinkPicUrl($Table){
	if(substr($Table, 0, 7)=="http://" || substr($Table, 0, 1)=="/"){
		$LinkPicUrl=$Table;
	}elseif($Table==""){
		$LinkPicUrl=cd_upath."static/images/nopic.jpg";
	}else{
		$LinkPicUrl=cd_webpath.$Table;
	}
	return $LinkPicUrl;
}

function LinkLrcUrl($Table){
	if(substr($Table, 0, 7)=="http://"){
		$LinkLrcUrl=$Table;
	}elseif($Table==""){
		$LinkLrcUrl="http://".$_SERVER['HTTP_HOST'].cd_upath."static/swf/nolrc.lrc.jpg";
	}else{
		$LinkLrcUrl="http://".$_SERVER['HTTP_HOST'].cd_webpath.$Table;
	}
	return $LinkLrcUrl;
}

function LinkVideoUrl($Table,$Type,$ID='0'){
	if($Type==1){
	        if(substr($Table, 0, 7)=="http://"){
		        if(substr($Table, -4)==".swf"){
		                $LinkVideoUrl=$Table;
		        }else{
		                $LinkVideoUrl=cd_upath."static/swf/v.swf?php=video&lists={v}".$ID."&.swf";
		        }
	        }else{
		        $LinkVideoUrl=cd_upath."static/swf/v.swf?php=video&lists={v}".$ID."&.swf";
	        }
	}else{
	        if(substr($Table, 0, 7)=="http://"){
	                $LinkVideoUrl=$Table;
	        }else{
	                $LinkVideoUrl="http://".$_SERVER['HTTP_HOST'].cd_webpath.$Table;
	        }
	}
	return $LinkVideoUrl;
}

function GetAlias($TableA,$TableB,$TableC,$ClassID){
	global $db;
	$TableA=ReplaceStr($TableA,"qianwei_",cd_tablename);
	$sql="select ".$TableB." from ".$TableA." where ".$TableC."='".$ClassID."'";
	$row=$db->getrow($sql);
	if($row){
		$aliasname=$row[$TableB];
	}else{
		$aliasname="";
	}
	return $aliasname;
}

function GetSpecialAlias($TableA,$TableB,$TableC,$ClassID){
	global $db;
	$TableA=ReplaceStr($TableA,"qianwei_",cd_tablename);
	$sql="select ".$TableB." from ".$TableA." where ".$TableC."=".$ClassID;
	$row=$db->getrow($sql);
	if($row){
		$aliasname=getlen("len","10",$row[$TableB]);
	}else{
		$aliasname="未知专辑";
	}
	return $aliasname;
}

function GetSingerAlias($TableA,$TableB,$TableC,$ClassID){
	global $db;
	$TableA=ReplaceStr($TableA,"qianwei_",cd_tablename);
	$sql="select ".$TableB." from ".$TableA." where ".$TableC."=".$ClassID;
	$row=$db->getrow($sql);
	if($row){
		$aliasname=getlen("len","10",$row[$TableB]);
	}else{
		$aliasname="未知歌手";
	}
	return $aliasname;
}

function CheckHtml($Table,$Url,$ID,$ClassID){
	if(cd_webhtml==2){
		switch($Table){
			case 'music':
				$spanurl=substr($Url,strlen(cd_webpath));
				if(file_exists($spanurl)){
					$CheckHtml="<a title=\"点击浏览\" href=\"".$Url."\" target=\"_blank\"><img src=\"static/admincp/images/isbest_yes.gif\" /></a>";
				}else{
					$CheckHtml="<a title=\"点击生成\" href=\"?iframe=htmlmusic&ac=one&cid=".$ClassID."&mid=".$ID."\"><img src=\"static/admincp/images/isbest_no.gif\" /></a>";
				}
				break;
			case 'special':
				$spanurl=substr($Url,strlen(cd_webpath));
				if(file_exists($spanurl)){
					$CheckHtml="<a title=\"点击浏览\" href=\"".$Url."\" target=\"_blank\"><img src=\"static/admincp/images/isbest_yes.gif\" /></a>";
				}else{
					$CheckHtml="<a title=\"点击生成\" href=\"?iframe=htmlspecial&ac=one&cid=".$ClassID."&sid=".$ID."\"><img src=\"static/admincp/images/isbest_no.gif\" /></a>";
				}
				break;
			case 'singer':
				$spanurl=substr($Url,strlen(cd_webpath));
				if(file_exists($spanurl)){
					$CheckHtml="<a title=\"点击浏览\" href=\"".$Url."\" target=\"_blank\"><img src=\"static/admincp/images/isbest_yes.gif\" /></a>";
				}else{
					$CheckHtml="<a title=\"点击生成\" href=\"?iframe=htmlsinger&ac=one&cid=".$ClassID."&gid=".$ID."\"><img src=\"static/admincp/images/isbest_no.gif\" /></a>";
				}
				break;
			case 'video':
				$spanurl=substr($Url,strlen(cd_webpath));
				if(file_exists($spanurl)){
					$CheckHtml="<a title=\"点击浏览\" href=\"".$Url."\" target=\"_blank\"><img src=\"static/admincp/images/isbest_yes.gif\" /></a>";
				}else{
					$CheckHtml="<a title=\"点击生成\" href=\"?iframe=htmlvideo&ac=one&cid=".$ClassID."&vid=".$ID."\"><img src=\"static/admincp/images/isbest_no.gif\" /></a>";
				}
				break;
		}
	}else{
		$CheckHtml="动态";
	}
	return $CheckHtml;
}

function convert_encoding($str,$nfate,$ofate){
	if(function_exists('mb_convert_encoding')){
		$str=mb_convert_encoding($str,$nfate,$ofate);
	}else{
		if($nfate=="GBK"){$nfate="GBK//IGNORE";}
		$str=iconv($ofate, $nfate, $str);
	}
	return $str;
}

function close_browse($msg=''){
        if(empty($_SERVER['HTTP_REFERER'])){
                exit($msg);
        }elseif(!empty($_SERVER['HTTP_REFERER']) && substr($_SERVER['HTTP_REFERER'],0,4)!=="http"){
                exit($msg);
        }else{
                $domain=explode("http",$_SERVER['HTTP_REFERER']);
                $domain=explode("/",$domain[1]);
                if($domain[2]!==$_SERVER['HTTP_HOST']){
                        exit($msg);
                }
        }
}

function html_message($title,$msg,$code=''){
        return "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\" /><title>站点提示</title></head><body bgcolor=\"#FFFFFF\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"850\" align=\"center\" height=\"85%\"><tr align=\"center\" valign=\"middle\"><td><table cellpadding=\"20\" cellspacing=\"0\" border=\"0\" width=\"80%\" align=\"center\" style=\"font-family: Verdana, Tahoma; color: #666666; font-size: 12px\"><tr><td valign=\"middle\" align=\"center\" bgcolor=\"#EBEBEB\"><b style=\"font-size: 16px\">".$title."</b><br /><br /><p style=\"text-align:left;\">".$msg."</p><br /><br /></td></tr></table></td></tr></table>".$code."</body></html>";
}

function iframe_message($msg){
        return "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\" /><table style=\"border:1px solid #09C\" align=\"center\"><tr><td><div style=\"text-align:center;color:#09C\">".$msg."</div></td></tr></table>";
}

function mainjump(){
        echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\" /><style type=\"text/css\">body{background:#F2F9FD;}</style>";
}

function Copyright_Style($PATH){
        if($PATH!=="template/default/html/"){
		$dir=substr(substr($PATH,0,strlen($PATH)-1),0,strrpos(substr($PATH,0,strlen($PATH)-1),'/')+1);
		$api=_qianwei_root_.$dir.'purchase.xml';
                if(!file_exists($api)){
                        return false;
                }else{
                        if(file_get_contents($api)!==md5($_SERVER['HTTP_HOST'])){
                                return false;
                        }else{
                                return true;
                        }
                }
	}else{
	        return true;
	}
}

function Copyright_Plugin($GET){
        if($GET!=="upload" && $GET!=="ftp" && $GET!=="qiniu" && $GET!=="baidu" && $GET!=="oss"){
		$api=_qianwei_root_.'./source/plugin/'.$GET.'/purchase.xml';
                if(!file_exists($api)){
                        return NULL;
                }else{
                        if(file_get_contents($api)!==md5($_SERVER['HTTP_HOST'])){
                                return NULL;
                        }else{
                                return $GET;
                        }
                }
	}else{
	        return $GET;
	}
}

function rewrite_url($para) {
	if(cd_userhtml==1){
		$para = str_replace(array('&','=','.php?'), array('/', '/', '/'), $para);
		return $para.'/';
	}else{
		return $para;
	}
}

function submitcheck($var) {
	if(!empty($_POST[$var]) && $_SERVER['REQUEST_METHOD'] == 'POST') {
		if((empty($_SERVER['HTTP_REFERER']) || preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) == preg_replace("/([^\:]+).*/", "\\1", $_SERVER['HTTP_HOST']))) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function getonlineip($format=0) {
	global $_SGLOBAL;
	if(empty($_SGLOBAL['onlineip'])) {
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			$onlineip = getenv('HTTP_CLIENT_IP');
		} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$onlineip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			$onlineip = getenv('REMOTE_ADDR');
		} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
			$onlineip = $_SERVER['REMOTE_ADDR'];
		}
		preg_match("/[\d\.]{7,15}/", $onlineip, $onlineipmatches);
		$_SGLOBAL['onlineip'] = $onlineipmatches[0] ? $onlineipmatches[0] : 'unknown';
	}
	if($format) {
		$ips = explode('.', $_SGLOBAL['onlineip']);
		for($i=0;$i<3;$i++) {
			$ips[$i] = intval($ips[$i]);
		}
		return sprintf('%03d%03d%03d', $ips[0], $ips[1], $ips[2]);
	} else {
		return $_SGLOBAL['onlineip'];
	}
}

function inserttable($tablename, $insertsqlarr, $returnid=0, $replace = false, $silent=0) {
	global $db;
	$insertkeysql = $insertvaluesql = $comma = '';
	foreach ($insertsqlarr as $insert_key => $insert_value) {
		$insertkeysql .= $comma.'`'.$insert_key.'`';
		$insertvaluesql .= $comma.'\''.$insert_value.'\'';
		$comma = ', ';
	}
	$method = $replace?'REPLACE':'INSERT';
	$db->query($method.' INTO '.tname($tablename).' ('.$insertkeysql.') VALUES ('.$insertvaluesql.')', $silent?'SILENT':'');
	if($returnid && !$replace) {
		return $db->insert_id();
	}
}

function updatetable($tablename, $setsqlarr, $wheresqlarr, $silent=0) {
	global $db;
	$setsql = $comma = '';
	foreach ($setsqlarr as $set_key => $set_value) {
		$setsql .= $comma.'`'.$set_key.'`'.'=\''.$set_value.'\'';
		$comma = ', ';
	}
	$where = $comma = '';
	if(empty($wheresqlarr)) {
		$where = '1';
	} elseif(is_array($wheresqlarr)) {
		foreach ($wheresqlarr as $key => $value) {
			$where .= $comma.'`'.$key.'`'.'=\''.$value.'\'';
			$comma = ' AND ';
		}
	} else {
		$where = $wheresqlarr;
	}
	$db->query('UPDATE '.tname($tablename).' SET '.$setsql.' WHERE '.$where, $silent?'SILENT':'');
}
?>