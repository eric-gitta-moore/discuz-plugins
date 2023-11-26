<?php

/*
 * CopyRight  : [www.moqu8.com!] (C)2014-2015
 * Document   : 魔趣吧：www.moqu8.com
 * Created on : 2015-01-17,21:45:40
 * Author     : 魔趣吧(QQ：10373458)  $
 * Description: This is NOT a freeware, use is subject to license terms.
 *              魔趣吧出品 必属精品。
 *              魔趣吧源码论坛 全网首发 http://www.moqu8.com；
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Deined');
}
include_once DISCUZ_ROOT.'./source/plugin/ljdaka/shiqu.inc.php';
class plugin_ljdaka {

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
        $this->weizhi = $this->config['weizhi'];
        $this->xianshi = $this->config['xianshi'];
        $this->isqz = $this->config['isqz'];
        $this->check = C::t('#ljdaka#plugin_daka')->fetch_by_uid($_G['uid']);
    }
	function global_footer(){
		global $_G; 
		
	}
    function global_header() {
		global $_G; 
		$config = $_G['cache']['plugin']['ljdaka'];
		$ks = $config['s_time'];
		$js = $config['e_time'];
		$h = intval(date("H"));
		if (!($h >= $ks && $h <= $js)) {//10  1 3  10<1 
			return;
		}
		$settingfile = DISCUZ_ROOT . './data/sysdata/cache_ljdaka_setting.php';
		if(file_exists($settingfile)){
			include $settingfile;
		}
		
        if (!$this->check && $this->isqz && $this->uid) {
			if($wcache['ts_time']+$config['ts_time']*60>TIMESTAMP){
				return;
			}
			$wcache['ts_time'] = TIMESTAMP;
			require_once libfile('function/cache');
			writetocache('ljdaka_setting', getcachevars(array('wcache' => $wcache))); //将管理中心配置项写入缓存
            $return = '<script type="text/javascript" src="source/plugin/ljdaka/js/jquery.js"></script>
<script type="text/javascript">
var jq=jQuery.noConflict();
</script><script stype="text/javascript">showWindow("ljdaka","plugin.php?id=ljdaka:daka&action=showWindow&formhash=' . FORMHASH . '")</script>';
        }
        return $return;
    }

    function global_usernav_extra1() {
		global $_G; 
		$config = $_G['cache']['plugin']['ljdaka'];
		if(!$config['isan']){
			return;
		}
        if ($this->weizhi == 1 && $this->uid) {
            if (!$this->check || !empty($this->xianshi)) {
                include template('ljdaka:daka');
            }

            return $return;
        }
    }

    function global_cpnav_extra1() {
		global $_G; 
		$config = $_G['cache']['plugin']['ljdaka'];
		if(!$config['isan']){
			return;
		}
        if ($this->weizhi == 2 && $this->uid) {
            if (!$this->check || !empty($this->xianshi)) {
                include template('ljdaka:daka');
            }

            return $return;
        }
    }

    function global_cpnav_extra2() {
		global $_G; 
		$config = $_G['cache']['plugin']['ljdaka'];
		if(!$config['isan']){
			return;
		}
        if ($this->weizhi == 3 && $this->uid) {
            if (!$this->check || !empty($this->xianshi)) {
                include template('ljdaka:daka');
            }

            return $return;
        }
    }

    function global_usernav_extra2() {
		global $_G; 
		$config = $_G['cache']['plugin']['ljdaka'];
		if(!$config['isan']){
			return;
		}
        if ($this->weizhi == 4 && $this->uid) {
            if (!$this->check || !empty($this->xianshi)) {
                include template('ljdaka:daka');
            }

            return $return;
        }
    }

    function global_usernav_extra3() {
		global $_G; 
		$config = $_G['cache']['plugin']['ljdaka'];
		if(!$config['isan']){
			return;
		}
        if ($this->weizhi == 5 && $this->uid) {
            if (!$this->check || !empty($this->xianshi)) {
                include template('ljdaka:daka');
            }

            return $return;
        }
    }

    function global_usernav_extra4() {
        if ($this->weizhi == 6 && $this->uid) {
            if (!$this->check || !empty($this->xianshi)) {
                include template('ljdaka:daka');
            }

            return $return;
        }
    }
	
}
class plugin_ljdaka_forum extends plugin_ljdaka {
		function viewthread_sidetop_output() {
			global $_G,$postlist;
			$config = $_G['cache']['plugin']['ljdaka'];
			if($config['isxinxi']){
				foreach($postlist as $key=>$value){
					$check = C::t('#ljdaka#plugin_daka_user')->fetch($value['authorid']);
					if (!$check) {
						$sharecode[]='<p>'.lang('plugin/ljdaka','class_1').'</p>';
					}else{
						$sharecode[]='<div style="border:2px dashed #cdcdcd;margin:10px;text-align:center;"><table><tr><td>'.lang('plugin/ljdaka','class_2').$check['day'].lang('plugin/ljdaka','class_3').'</td></tr><tr><td>'.lang('plugin/ljdaka','class_4').$check['allday'].lang('plugin/ljdaka','class_3').'</td></tr><tr><td>'.lang('plugin/ljdaka','class_5').$check['money'].$_G['setting']['extcredits'][$config['leixing']]['title'].'</td></tr></table></div>';
					}
				}
			}
			return $sharecode;
		}
	}
?>