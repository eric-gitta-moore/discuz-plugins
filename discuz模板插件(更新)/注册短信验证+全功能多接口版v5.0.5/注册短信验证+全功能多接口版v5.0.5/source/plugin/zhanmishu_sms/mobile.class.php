<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class mobileplugin_zhanmishu_sms {
	function is_weixin() { 
	    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) { 
	        return true; 
	    } return false; 
	}
	function common(){
		if(defined('IN_MAGMOBILE_API') || $this->is_weixin()) {
			//return;
		}
		global $_G;
		$config = $this->get_config();
    	if ($config['mobilelogin'] && CURSCRIPT == 'member' && $_GET['mod'] =='logging' && isset($_GET["loginsubmit"]) && $_GET['action']=='login') {
    		$username = addslashes($_GET['username']);
    		$ismobile = $this->call_function('verify_mobile_number',array($username));
    		if ($ismobile) {

    			$isuser = $this->call_function('checkusernameexists',array($username));
    			if ($isuser) {
    				return ;
    			}
				$uid = $this->call_function('getuidbymobile',array($username));
	    		if ($uid) {
	    			$user = getuserbyuid($uid);
	    			$_GET['username'] = $user['username'];
	    			$_POST['username'] = $user['username'];
	    		}
    		}
    	}
	}

	function global_footer_mobile(){
		global $_G;
		if(defined('IN_MAGMOBILE_API')) {
			return;
		}

    	if ($config['iseasy_verisy'] && (CURSCRIPT == 'portal' || CURSCRIPT == 'forum') && $_G['uid'] && !defined('IN_ADMINCP')  && $_GET['id'] !=='zhanmishu_sms:verify') {
			$ispostcheck = $this->call_function('ispost_check');
			$mobile =getuserprofile('mobile');
    		if ($ispostcheck) {
    			header('location:plugin.php?id=zhanmishu_sms:verify&mobile='.$mobile);
    			exit;
    		}
		}
		if ($_G['uid'] || !$this->issmsopen()) {
			$isreply_check = $this->call_function('isreply_check',array(1,1));
			if ($isreply_check && $_G['uid']) {
				$mobile = getuserprofile('mobile');
				return '<script>(function(){$("#fastpostmessage").on("focus", function() {popup.open("'.lang('plugin/zhanmishu_sms','verify_before_post').'", "confirm", "plugin.php?id=zhanmishu_sms:verify&mobile='.$mobile.'");});$("#needmessage").on("focus", function() {popup.open("'.lang('plugin/zhanmishu_sms','verify_before_post').'", "confirm", "plugin.php?id=zhanmishu_sms:verify&mobile='.$mobile.'");})})();</script>';
			}
			return;
		}
		if (CURSCRIPT == 'member') {
			if ($_GET['mod'] == $_G['setting']['regname'] && $_G['setting']['regstatus']) {
				$url = 'plugin.php?id=zhanmishu_sms:register#/';
				dheader("location:".$url);
				exit;
			}else if ($config['login_gotospa'] && ($_GET['mod'] == 'login' || $_GET['action'] == 'login') && !strpos(dreferer(), 'zhanmishu_sms:register')) {
				$url = 'plugin.php?id=zhanmishu_sms:register#/login';
				dheader("location:".$url);
				exit;
			}
		}

		include template("zhanmishu_sms:register");
		return $register;
	}
	function get_config(){
		$config = $this->call_function('getconfig');
		return $config;
	}

	function  call_function($function,$args=array()){
		include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/function.php';
		$return =  call_user_func_array($function,$args);
	
		return $return;
	}
	function issmsopen(){
		$config = $this->get_config();
		return $config['ismobileopen'];
	}

}

class mobileplugin_zhanmishu_sms_member extends  mobileplugin_zhanmishu_sms{
	function logging_bottom_mobile(){
		return '<p><a href="plugin.php?id=zhanmishu_sms:getpassword&mod=mobilegetpasswd">'.lang('plugin/zhanmishu_sms', 'fogetpwd_getpasswd_bymobile').'</a></p>';
	}

	function register_input_message(){
		if (!$this->issmsopen()) {
			return ;
		}
		global $_G;
		$config = $this->get_config();
		if ($_G['uid'] && !empty($_POST) &&  $_GET['regsubmit']='yes' && $_GET['mobile']) {
			$verify = $this->get_verify();
			$sid = $verify->get_sid();
			$data = daddslashes($_GET);
			if ($sid) {
				C::t('#zhanmishu_sms#zhanmishu_sms')->update($sid,array('uid'=>$_G['uid'],'isregsuccess'=>'1'));
				if ($config['isauto']) {
					C::t('common_member_profile')->update($_G['uid'],array('mobile'=>$data['mobile']));
				}
			}
			$verify->clear_send_coolie();
		}
		if ($_G['uid'] && !empty($_POST) && $config['auto_verify']) {
			$data = daddslashes($_GET);
			$fields = array();
			$fields['uid'] = $_G['uid'];
			$fields['mobile'] = $data['mobile'];
			$fields['type'] = '1';
			$fields['issuccess'] = '1';
			$fields['dateline'] = TIMESTAMP;
			$user = C::t("#zhanmishu_sms#zhanmishu_sms")->fetch_by_fields($fields);
			$verify = new zhanmishu_mobileverify($config);
			$verify->checkappbyme_updatemobile($fields['mobile'],$fields['uid']);

			$ismobileverify = $verify -> ismobile_verify($data['mobile']);
			if (empty($user) && !$ismobileverify) {
				$verify->set_verify($_G['uid'],0,$fields['mobile'],'1','',$_G['username']);
			}
		}
	}
	function register_code(){
		if (!$this->issmsopen()) {
			return ;
		}
		global $_G;
		$username = trim($_GET[''.$_G['setting']['reginput']['username']]);
		$password = $_GET[''.$_G['setting']['reginput']['password']];

        if ($username && $password) {
        	$verify = $this->get_verify();
			$return = $verify->verify();

			if ($return['code'] < 0) {
				showmessage(lang('plugin/zhanmishu_sms','please_input_right_info'));
			}
        }


        return;
    }
    function get_verify(){
    	global $_G;
        if (!empty($_POST)) {
        	$config = $this->get_config();
			$data = daddslashes($_GET);
			$data['code'] = strval($data['code']);
			$data['sms_verify'] = strval($data['sms_verify']);
			
			$verify = new zhanmishu_mobileverify($config,$data['code'],$data['sms_verify']);
			return $verify;
		}
		return false;
    }
}
class mobileplugin_zhanmishu_sms_forum extends  mobileplugin_zhanmishu_sms{
	function post_recode($params) {
		global $_G;
		if (!$_G['uid']) {
			return ;
		}
		$verifytype = $this->call_function('get_verify_id');

		if (!$verifytype) {
			return;
		}
		$info = $this->call_function('get_member_verify_info',array($_G['uid'],$verifytype));
		$config = $this->get_config();
		$isvid = $this->call_function('check_user_isverify');
		$mobile = $info['field']['mobile'] ? $info['field']['mobile'] : getuserprofile('mobile');
		if ($_GET['action'] != 'reply') {
			$ispostcheck = $this->call_function('ispost_check');
			if ($ispostcheck) {
				showmessage(lang('plugin/zhanmishu_sms', 'please_verify_before_post'), 'plugin.php?id=zhanmishu_sms:verify&mobile='.$mobile, array());
			}
		}else{
			//check is_replay_verify
			$isreply_check = $this->call_function('isreply_check');
			if ($isreply_check) {
				# code...
				showmessage(lang('plugin/zhanmishu_sms','verify_before_post'), 'plugin.php?id=zhanmishu_sms:verify&mobile='.$mobile, array());
			}
		}	
		return;
	}
	function post_zhanmishu_sms_message($params) {

		global $_G;
		if ($params['param']['0'] == 'post_reply_succeed') {
			$tid = $params['param']['2']['tid'];
			$pid = $params['param']['2']['pid'];
			$fid = $params['param']['2']['fid'];

			$notice = new zhanmishu_notice($this->get_config());
			$notice ->notice($tid,$pid,$fid,$tiduser,$_G['uid']);

		}else if ($params['param']['0'] == 'post_newthread_succeed') {
			$tsetting = array();
			if ($_GET['issmsnotice']) {$tsetting['issmsnotice'] = '1';}
			if ($_GET['isemailnotice']) {$tsetting['isemailnotice'] = '1';}
			$tsetting['tid'] = $params['param']['2']['tid'];
			$tsetting['uid'] = $_G['uid'];
			$tsetting['dateline'] = TIMESTAMP;
			C::t("#zhanmishu_sms#zhanmishu_tsetting")->insert($tsetting,false,true);
		}
		
	}
}

include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/Autoloader.php';
include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/zhanmishu_mobileverify.php';
include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/zhanmishu_notice.php';
?>