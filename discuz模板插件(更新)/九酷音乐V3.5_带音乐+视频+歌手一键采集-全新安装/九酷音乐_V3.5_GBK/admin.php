<?php
include "source/global/global_conn.php";
include "source/admincp/include/function.php";
$frames = array('login', 'index', 'cache', 'body', 'menu', 'config', 'skin', 'tag', 'page', 'template', 'class', 'song', 'music', 'ajax', 'server', 'album', 'special', 'singer', 'star', 'video', 'user', 'blog', 'comment', 'wall', 'pic', 'html', 'htmlindex', 'htmllist', 'htmlmusic', 'htmlpage', 'htmlspecial', 'htmlsinger', 'htmlvideo', 'htmlvideolist', 'backup', 'bulk', 'reset', 'ftp', 'sql', 'update', 'admin', 'link', 'uplog', 'pay', 'module', 'develop', 'ucenter');
$iframe = !empty($_GET['iframe']) && in_array($_GET['iframe'], $frames) ? $_GET['iframe'] : 'login';
include_once('source/admincp/module/'.$iframe.'.php');
?>