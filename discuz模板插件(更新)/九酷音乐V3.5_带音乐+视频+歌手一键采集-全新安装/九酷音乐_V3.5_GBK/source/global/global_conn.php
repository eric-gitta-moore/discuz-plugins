<?php
require_once("global_function.php");
require_once("global_config.php");
require_once("global_label.php");
require_once("global.php");
if(!file_exists(_qianwei_root_.'./data/install.xml')){header("Location:install/index.php");}
class cls_mysql{
	protected $link_id;
	public function __construct($dbhost, $dbuser, $dbpw, $dbname = '', $charset = 'gbk'){
		if(!($this->link_id = @mysql_connect($dbhost, $dbuser, $dbpw))){
			$this->ErrorMsg("Can't pConnect MySQL Server!");
		}
		mysql_query("SET NAMES " . $charset, $this->link_id);
		if ($dbname){
			if (@mysql_select_db($dbname, $this->link_id) === false ){
				$this->ErrorMsg("Can't select MySQL database($dbname)!");
				return false;
			}else{
				return true;
			}
		}
	}
	function result($query, $row) {
		$query = mysql_result($query, $row);
		return $query;
	}
	public function select_database($dbname){
		return mysql_select_db($dbname, $this->link_id);
	}
	public function list_tables($dbname){
		return mysql_query("SHOW TABLES FROM $dbname",$this->link_id);
	}
	public function list_fields($dbname,$tbname){
		return  mysql_list_fields($dbname,$tbname,$this->link_id);
	}
	public function fetch_array($query, $result_type = MYSQL_ASSOC){
		return mysql_fetch_array($query, $result_type);
	}
	public function query($sql){
		return mysql_query($sql, $this->link_id);
	}
	public function affected_rows(){
		return mysql_affected_rows($this->link_id);
	}
	public function num_rows($query){
		return mysql_num_rows($query);
	}
	public function insert_id(){
		return mysql_insert_id($this->link_id);
	}
	public function selectLimit($sql, $num, $start = 0){
		if ($start == 0){
			$sql .= ' LIMIT ' . $num;
		}else{
			$sql .= ' LIMIT ' . $start . ', ' . $num;
		}
		return $this->query($sql);
	}
	public function getone($sql, $limited = false){
		if ($limited == true){
			$sql = trim($sql . ' LIMIT 1');
		}
		$res = $this->query($sql);
		if ($res !== false){
			$row = mysql_fetch_row($res);
			return $row[0];
		}else{
			return false;
		}
	}
	public function getrow($sql){
		$res = $this->query($sql);
		if ($res !== false){
			return mysql_fetch_assoc($res);
		}else{
			return false;
		}
	}
	public function getall($sql){
		$res = $this->query($sql);
		if ($res !== false){
			$arr = array();
			while ($row = mysql_fetch_assoc($res)){
				$arr[] = $row;
			}
			return $arr;
		}else{
			return false;
		}
	}
	function ErrorMsg($message = '', $sql = ''){
		if ($message){
			echo "<b>error info</b>: $message\n\n";
		}else{
			echo "<b>MySQL server error report:";
			print_r($this->error_message);
		}
		exit;
	}
}

class Cache_Lite{
	var $_dir  = '/cache/';
	var $_time = 60;
	var $_id;
	function __construct($options=array(NULL)){
		if(is_array($options)){
			$available_options = array('_dir','_time');
			foreach($options as $key => $value){
				if(in_array($key,$available_options)){
					$this->$key = $value;
				}
			}
		}
	}
	function get($id){
		$this->_id = md5(md5($id));
		if(file_exists($this->_dir.$this->_id) && ((time() - filemtime($this->_dir.$this->_id)) < $this->_time)){
			if(PHP_VERSION >= '4.3.0'){
				$data = file_get_contents($this->_dir.$this->_id);
			}else{
				$handle = fopen($this->_dir.$this->_id,'rb');
				$data = fread($handle,filesize($this->_dir.$this->_id));
				fclose($handle);
			}
			return $data;
		}else{
			return false;
		}
	}
	function save($data){
		if(!is_writable($this->_dir)){
			if(!@mkdir($this->_dir,0777,true)){
				echo 'Cache directory not writable';
				exit;
			}
		}
		if(PHP_VERSION >= '5'){
			file_put_contents($this->_dir.$this->_id,$data);
		}else{
			$handle = fopen($this->_dir.$this->_id,'wb');
			fwrite($handle,$data);
			fclose($handle);
		}
		return true;
	}
	function start($id){
		$data = $this->get($id);
		if($data !== false && cd_iscache==1){
			echo($data);
			return true;
		}
		ob_start();
		ob_implicit_flush(false);
		return false;
	}
	function end(){
		$data = ob_get_contents();
		ob_end_clean();
		if(cd_iscache==1) $this->save($data);
		echo($data);
	}
}
	$cache_opt = new Cache_Lite(array('_dir'=>_qianwei_root_.'./data/cache/','_time'=>'3600'));
	$db = new cls_mysql(cd_sqlservername,cd_sqluserid,cd_sqlpwd,cd_sqldbname);
?>