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

class table_plugin_daka_user_z extends discuz_table {

    public function __construct() {

        $this->_table = 'plugin_daka_user_z';
        $this->_pk = 'uid';
        parent::__construct();
    }

   

}

?>