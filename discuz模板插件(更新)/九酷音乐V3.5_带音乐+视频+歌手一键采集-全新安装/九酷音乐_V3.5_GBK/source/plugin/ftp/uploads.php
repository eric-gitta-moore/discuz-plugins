<?php
include "../../global/global_conn.php";
class ftp {
        public $off;
        public $conn_id;
        function __construct($FTP_HOST,$FTP_PORT,$FTP_USER,$FTP_PASS) {
                $this->conn_id = @ftp_connect($FTP_HOST,$FTP_PORT) or die('1');
                @ftp_login($this->conn_id,$FTP_USER,$FTP_PASS) or die('2');
                @ftp_pasv($this->conn_id,1);
        }
        function up_file($path,$root,$newpath,$type=cd_ftptype) {
                if($type==1) {
                        $this->dir_mkdirs($root.$newpath);
                }
                $this->off = @ftp_put($this->conn_id,$root.$newpath,$path,FTP_BINARY);
                if(!$this->off) {
                        echo '3';
                } else {
                        echo cd_ftpdomain.$newpath;
                }
        }
        function dir_mkdirs($path) {
                $path_arr = explode('/',$path);
                $file_name = array_pop($path_arr);
                $path_div = count($path_arr);
                foreach($path_arr as $val) {
                        if(@ftp_chdir($this->conn_id,$val) == FALSE) {
                                $tmp = @ftp_mkdir($this->conn_id,$val);
                                if($tmp == FALSE) {
                                        exit('4');
                                }
                                @ftp_chdir($this->conn_id,$val);
                        }
                }
                for($i=1;$i<=$path_div;$i++) {
                        @ftp_cdup($this->conn_id);
                }
        }
        function close() {
                @ftp_close($this->conn_id);
        }
}
if (!empty($_FILES)) {
	$ftp = new ftp(cd_ftphost,cd_ftpport,cd_ftpuser,cd_ftppass);
	$File = $_FILES['Filedata']['name'];
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetFile = date('YmdHis',time()).rand(2,pow(2,24)).".".strtolower(trim(substr(strrchr($File, '.'), 1)));
        $ftp->up_file($tempFile,cd_ftproot,cd_ftpdir.$targetFile);
        $ftp->close();
}
?>