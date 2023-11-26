<?php

/*
 * CopyRight  : [www.moqu8.com!] (C)2014-2015
 * Document   : ħȤ�ɣ�www.moqu8.com
 * Created on : 2015-01-17,21:45:40
 * Author     : ħȤ��(QQ��10373458)  $
 * Description: This is NOT a freeware, use is subject to license terms.
 *              ħȤ�ɳ�Ʒ ������Ʒ��
 *              ħȤ��Դ����̳ ȫ���׷� http://www.moqu8.com��
 */

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_plugin_daka_syscache extends discuz_table {

    public function __construct() {

        $this->_table = 'plugin_daka_syscache';
        $this->_pk = 'id';
        parent::__construct();
    }

    public function fetch_all_by_sign($sign) {
        return DB :: fetch_all("select * from %t where plugin_sign=%d", array($this->_table, $sign));
    }

    public function fetch_count($sign) {
        return DB :: result_first("select count(*) from %t where plugin_sign=%d", array($this->_table, $sign));
    }

    public function fetch_count_sign($plugin_b, $sign) {
        return DB :: result_first("select count(*) from %t where plugin_sign=%d and plugin_b=%s", array($this->_table, $sign, $plugin_b));
    }

}

?>