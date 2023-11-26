<?php
/**
 *	[游客变会员(guests.{modulename})] (C)2012-2099 Powered by 源码哥.
 *  Version: 5.0
 *  Date: 2015-09-06 14:06:26
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_guests {
	var $setting = array();

	function plugin_guests() {
		global $_G;
		if($_G['uid'] || $_G['member']['username']) {
			return '';
		}
		$this->setting = $_G['cache']['plugin']['guests'];
	}

	function global_footer() {
		global $_G;

		if (!$this->setting['open']) {	//close
			return '';
		}

		if($_G['uid']) {	//logined
			return '';
		}

        $show_scope = unserialize($this->setting['show_scope']);

        if (!in_array('all',$show_scope)) {
            if (!in_array($_G['basescript'],$show_scope)) {
                return '';
            }
        }
		global $mod; 
		if (CURSCRIPT == 'member' && 
			($mod == $_G['setting']['regname'] || $mod == 'logging' || $mod == 'register') || $mod == 'spacecp') {
			return '';
		}

		//record_off
		if (!$this->setting['record_radio']) {
			$result = "<script>showWindow('guests', 'plugin.php?id=guests:dialog');</script>";
			return $result;
		}

		//clear
		if ($this->setting['ip_save_time'] > 0 && (mt_rand() / mt_getrandmax() <= 0.2)) {
			$this->_clear_ip();
		}
		
		//get
		$guest = $this->_get_guest($_G['clientip']);
		if (empty($guest)) {
			return '';
		}
		
		//check
		$visit_count = isset($this->setting['visit_count'])?$this->setting['visit_count']:3;
		$visit_time_interval = $this->setting['visit_time_interval'] * 60;
		if ($guest['count'] >= $visit_count 
			&& (!$guest['uptime'] || (time() - strtotime($guest['uptime']) >= $visit_time_interval))) {
			return $this->_show_message($_G['clientip']);
		}

		return '';
	}
	
	function _get_guest($ip) {
		$res = DB::fetch_first('SELECT count,month_count,ctime,uptime FROM '.DB::table('plugin_guests')." WHERE ip = '{$ip}'");
		if(!$res) {
			DB::insert('plugin_guests', array('ip' => $ip));
			return array(
				'count' => 1,
				'uptime' => time(),
			);	//first
		} else {
			$res['count'] += 1;
			$month = date('m', strtotime($res['ctime']));
			$cur_month = date('m');
			if ($month == $cur_month) {
				DB::update('plugin_guests', 
					array('count' => $res['count'], 'month_count' => $res['month_count'] + 1), 
					array('ip' => $ip)
				);
			} else {
				DB::update('plugin_guests', 
					array('count' => $res['count'], 'month_count' => 1), 
					array('ip' => $ip)
				);
			}
			return $res;
		}
	}
	
	function _show_message($ip) {
		DB::update('plugin_guests', 
			array('uptime' => date('Y-m-d H:i:s')), 
			array('ip' => $ip)
		);

		$result = "<script>showWindow('guests', 'plugin.php?id=guests:dialog');</script>";
		return $result;
	}

	function _clear_ip()
	{
		$expire_time = time() - ($this->setting['ip_save_time'] * 24 * 60 * 60);
		$res = DB::fetch_first('SELECT count FROM '.DB::table('plugin_guests')." WHERE ctime < '{$expire_time}'");
		if($res && $res['count'] > 0) {
			//do {
				$ret = DB::delete(DB::table('plugin_guests'), 'ctime<'.$expire_time, 1000);
			//} while ($ret == 1000);
		}
	}
}
?>
