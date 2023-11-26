<?php
include "source/global/global_conn.php";
include "source/global/global_inc.php";
$open = Copyright_Plugin(!empty($_GET['open']) ? $_GET['open'] : 'upload');
$opens = !empty($_GET['opens']) ? $_GET['opens'] : 'user_upload';
include_once('source/plugin/'.$open.'/'.$opens.'.php');
?>