<?php
/*
 * CopyRight  : [fx8.cc!] (C)2014-2016
 * Document   : Դ��磺www.fx8.cc��www.ymg6.com
 * Created on : 2016-01-06,09:53:15
 * Author     : Դ���(QQ��154606914) wWw.fx8.cc $
 * Description: This is NOT a freeware, use is subject to license terms.
 *              Դ����Ʒ ������Ʒ��
 *              Դ������� ȫ���׷� http://www.fx8.cc��
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$sql = <<<EOF
DROP TABLE IF EXISTS pre_webtctz_lists;
DROP TABLE IF EXISTS pre_webtctz_mobilelists;
EOF;

runquery($sql);


$finish = TRUE;
?>