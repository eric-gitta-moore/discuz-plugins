<?php

/**
 *      [Caogen8!] (C)2014-2018 Www.Caogen8.co.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: upgrade.php 37712 2018-03-09 22:28:39Z Вн-Иљ-АЩ $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$sql['1.0.8'] = <<<EOF
ALTER TABLE `pre_zhuzhu_taobao_cat`
ADD COLUMN `tb_key` varchar(100) NOT NULL AFTER `tb_cat`;
EOF;


$finish = true;