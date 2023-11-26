<?php
/*
 *源  码   哥   y  m    g 6     .    c  o     m
 *更多商业插件/模版免费下载 就在源   码  哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

loadcache('plugin');
class plugin_rsf_elasticity_pull_screen_adv {

    function plugin_rsf_elasticity_pull_screen_adv() {
			global $_G;

			$plugin_arr = $_G['cache']['plugin']['rsf_elasticity_pull_screen_adv'];
			
			$this->rsf_epsa_start   = $plugin_arr['rsf_epsa_start'];
			$this->rsf_epsa_width   = $plugin_arr['rsf_epsa_width'];
			$this->rsf_epsa_delay_time   = $plugin_arr['rsf_epsa_delay_time'];
			$this->rsf_epsa_show_speed   = $plugin_arr['rsf_epsa_show_speed'];
			$this->rsf_epsa_show_time    = $plugin_arr['rsf_epsa_show_time'];
			$this->rsf_epsa_link         = $plugin_arr['rsf_epsa_link'];
			$this->rsf_epsa_banner_start = $plugin_arr['rsf_epsa_banner_start'];
			$this->rsf_epsa_banner_link  = $plugin_arr['rsf_epsa_banner_link'];
			$this->rsf_epsa_show_frequency = $plugin_arr['rsf_epsa_show_frequency'];

			if(!empty($this->rsf_epsa_link)){
				$adurl = $this->rsf_epsa_link;
				$epsa = daddslashes(str_replace(' ','',$adurl));
				
				$arr = explode('|', $epsa);
				
				$this->rsf_epsa_big_link = $arr[0];
				$this->rsf_epsa_big_url  = $arr[1];
			};
			if($this->rsf_epsa_banner_start == 1){
				$bannerurl = empty($this->rsf_epsa_banner_link)?false:$this->rsf_epsa_banner_link;
				$epsa_ba = daddslashes(str_replace(' ','',$bannerurl));
				
				$arr_ba = explode('|', $epsa_ba);
				
				$this->rsf_epsa_banner_link = $arr_ba[0];
				$this->rsf_epsa_banner_url  = $arr_ba[1];
			};

	}
	
	function global_footer(){
		global $_G;
		$this->rsf_epsa_play_channel = unserialize($_G['cache']['plugin']['rsf_elasticity_pull_screen_adv']['rsf_epsa_play_channel']);

		$cur = implode('',$this->rsf_epsa_play_channel);

		preg_match('/1/',$cur,$curNum1);
		preg_match('/2/',$cur,$curNum2);
		preg_match('/3/',$cur,$curNum3);
		preg_match('/4/',$cur,$curNum4);
		preg_match('/5/',$cur,$curNum5);
		preg_match('/6/',$cur,$curNum6);
		preg_match('/7/',$cur,$curNum7);
		
		if($curNum1&&CURSCRIPT == 'forum'){
			include template('rsf_elasticity_pull_screen_adv:index');
		};
		if($curNum2&&CURSCRIPT == 'portal'){
			include template('rsf_elasticity_pull_screen_adv:index');
		};
		if($curNum3&&CURSCRIPT == 'home'){
			include template('rsf_elasticity_pull_screen_adv:index');
		};
		if($curNum4&&CURSCRIPT == 'group'){
			include template('rsf_elasticity_pull_screen_adv:index');
		};
		if($curNum5&&CURSCRIPT == 'member'){
			include template('rsf_elasticity_pull_screen_adv:index');
		};
		if($curNum6&&CURSCRIPT == 'plugin'){
			include template('rsf_elasticity_pull_screen_adv:index');
		};
		if($curNum7&&CURSCRIPT == 'index'){
			include template('rsf_elasticity_pull_screen_adv:index');
		};

		return $return;	
			
	}
	
}
?>