<?php

/*
 * CopyRight  : [www.moqu8.com!] (C)2014-2015
 * Document   : Ä§È¤°É£ºwww.moqu8.com
 * Created on : 2015-01-17,21:45:40
 * Author     : Ä§È¤°É(QQ£º10373458)  $
 * Description: This is NOT a freeware, use is subject to license terms.
 *              Ä§È¤°É³öÆ· ±ØÊô¾«Æ·¡£
 *              Ä§È¤°ÉÔ´ÂëÂÛÌ³ È«ÍøÊ×·¢ http://www.moqu8.com£»
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Deined');
}
include_once DISCUZ_ROOT.'./source/plugin/ljdaka/shiqu.inc.php';
class mobileplugin_ljdaka {

    var $uid;
    var $config;
    var $weizhi;
    var $xianshi;
    var $sql;
    var $check;

    function __construct() {
        global $_G;
        $this->uid = $_G['uid'];
        $this->config = $_G['cache']['plugin']['ljdaka'];
        $this->weizhi = $this->config['sjweizhi'];
        $this->xianshi = $this->config['xianshi'];
        $this->check = C::t('#ljdaka#plugin_daka')->fetch_by_uid($this->uid);
    }

    function global_header_mobile() {
		global $_G;
		$config = $_G ['cache'] ['plugin'] ['ljdaka'];
		if(!$config['issjan']){
			return;
		}
        if ($this->weizhi == 1 && $this->uid) {
            if (!$this->check || !empty($this->xianshi)) {
                include template('ljdaka:daka');
            }

            return $return;
        }
    }

    function global_footer_mobile() {
		global $_G;
		$config = $_G ['cache'] ['plugin'] ['ljdaka'];
		if(!$config['issjan']){
			return;
		}
        if ($this->weizhi == 2 && $this->uid) {
            if (!$this->check || !empty($this->xianshi)) {
                include template('ljdaka:daka');
            }

            return $return;
        }
    }
	function index_top_mobile() {
		global $_G;
		$config = $_G ['cache'] ['plugin'] ['ljdaka'];
		if(!$config['issjan']){
			return;
		}
		if($_GET['mobile']=='1'){
			$xian='<span class="pipe">|</span>';
		}else{
			$xian='&nbsp;&nbsp;&nbsp;';
		}
		if ($this->weizhi == 3 && $this->uid) {
            if (!$this->check || !empty($this->xianshi)) {
                include template('ljdaka:daka');
            }

            return $xian.$return;
        }
	}

}
class mobileplugin_ljdaka_forum extends mobileplugin_ljdaka {
}
?>