<?php
define('_qianwei_path_', str_replace("\\", '/', dirname(__FILE__) ) );
define('_qianwei_root_', str_replace("\\", '/', substr(_qianwei_path_,0,-13) ) );
define("cd_sqlservername","localhost");
define("cd_sqldbname","root");
define("cd_sqluserid","root");
define("cd_sqlpwd","root");
define("cd_tablename","prefix_");
define("cd_webpath","/");
define("cd_upath","/user/");
define("cd_cookiepath","/");
define("cd_version","V3.5");
define("cd_charset","GBK");
define("cd_build","20141223");
?>