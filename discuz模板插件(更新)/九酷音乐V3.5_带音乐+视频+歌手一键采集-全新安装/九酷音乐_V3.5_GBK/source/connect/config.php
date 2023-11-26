<?php
require_once('../global/global_conn.php');
$oauth = array (
  'appid' => cd_qqappid,
  'appkey' => cd_qqappkey,
  'api' => 
  array (
    'get_user_info' => '1',
    'get_info' => '1',
    'add_t' => '1',
    'add_share' => '1',
  ),
  'session' => '0',
  'debug' => '0',
);
?>