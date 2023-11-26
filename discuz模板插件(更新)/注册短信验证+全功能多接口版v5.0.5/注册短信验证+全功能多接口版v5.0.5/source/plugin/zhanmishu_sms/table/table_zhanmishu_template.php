<?php
/**
 *      [Caogen8!] (C)2014-2018 Www.Caogen8.co.
 *      Ğ¡²İ¸ù(QQ£º2575163778) wWw.Caogen8.co
 *
 *      Author: CAOGEN8.CO $
 *    qq:2575163778 $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_zhanmishu_template extends discuz_table {

	public function __construct() {
		$this->_table = 'zhanmishu_template';
		$this->_pk = 'tid';

		parent::__construct();
	}



}