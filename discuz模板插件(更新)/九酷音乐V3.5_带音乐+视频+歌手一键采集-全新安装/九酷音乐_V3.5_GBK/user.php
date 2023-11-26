<?php
include "source/global/global_conn.php";
include "source/global/global_inc.php";
$template=substr(substr(cd_templatedir,0,strlen(cd_templatedir)-1),0,strrpos(substr(cd_templatedir,0,strlen(cd_templatedir)-1),'/')+1);
if(!empty($_GET['mod'])){
        include_once($template.'source/'.$_GET['mod'].'.php');
}else{
        $do = !empty($_GET['do']) ? $_GET['do'] : 'login';
        include_once($template.'source/common.php');
        include_once($template.'source/head.php');
        include_once($template.'source/'.$do.'.php');
        include_once($template.'source/bottom.php');
}
?>