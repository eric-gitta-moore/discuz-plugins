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
include_once DISCUZ_ROOT.'./source/plugin/ljdaka/shiqu.inc.php';
class table_plugin_daka_thread extends discuz_table {

    public function __construct() {

        $this->_table = 'plugin_daka_thread';
        $this->_pk = 'tid';
        parent::__construct();
    }

    public function fetch_tid_by_dateline() {
        return DB::result_first("select tid from " . DB::table($this->_table) . " where dateline='" . gmdate('Ymd', TIMESTAMP + 3600 * 8) . "'");
    }

    public function fetch_by_dateline() {
        return DB::result_first("select count(*) from " . DB::table($this->_table) . " where dateline='" . gmdate('Ymd', TIMESTAMP + 3600 * 8) . "'");
    }

}

?>