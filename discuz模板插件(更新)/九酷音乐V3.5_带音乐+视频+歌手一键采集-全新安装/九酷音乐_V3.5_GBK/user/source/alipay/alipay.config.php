<?php
$aliapy_config['partner']      = cd_alipayid;
$aliapy_config['key']          = cd_alipaykey;
$aliapy_config['seller_email'] = cd_alipayuid;
$aliapy_config['return_url']   = 'http://'.$_SERVER['HTTP_HOST'].cd_upath.'source/alipay/return_url.php';
$aliapy_config['notify_url']   = 'http://'.$_SERVER['HTTP_HOST'].cd_upath.'source/alipay/notify_url.php';
$aliapy_config['sign_type']    = 'MD5';
$aliapy_config['input_charset']= 'gbk';
$aliapy_config['transport']    = 'http';
?>