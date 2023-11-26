<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class plugin_zhanmishu_sms {
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
		return $config['isopen'];
	}
	function global_footer(){
		global $_G;
		$config = $this->get_config();
    	if ($config['iseasy_verisy'] && (CURSCRIPT == 'portal' || CURSCRIPT == 'forum') && $_G['uid'] && !defined('IN_ADMINCP')  && $_GET['id'] !=='zhanmishu_sms:verify') {
    		$ispostcheck = $this->call_function('ispost_check');
    		$mobile =getuserprofile('mobile');
    		if ($ispostcheck && empty($_POST)) {
    			header('location:plugin.php?id=zhanmishu_sms:verify&mobile='.$mobile);
    			exit;
    		}
    	}
		$verifytype =  $this->call_function('get_verify_id');
		if (!$_G['uid'] || !$verifytype) {
			$showverify = false;
			$show = false;
		}else{
			$info =  $this->call_function('get_member_verify_info',array($_G['uid'],$verifytype));
			$isvid = $this->call_function('check_user_isverify');
			
			$mobile = $info['field']['mobile'] ? $info['field']['mobile'] : getuserprofile('mobile');
			$notip = !empty($config['no_tip_group']) && in_array($_G['groupid'], $config['no_tip_group']);
			$tip_times = getcookie('zmsttime');

			if (CURSCRIPT == 'member' || $tip_times || $isvid || $notip || !$config['verify_tip']) {
				$show = false;
			}else{
				dsetcookie('zmsttime', '1', $config['tip_times']);
				$show = true;
			}
			$showverify = true;
		}
		include template("zhanmishu_sms:js");
    	return $js;
	}

}

class plugin_zhanmishu_sms_member extends plugin_zhanmishu_sms {
	function logging_top(){
		$config = $this->get_config();
    	if ($config['mobilelogin'] && isset($_GET["loginsubmit"]) && $_GET['action']=='login') {

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
	function register_input(){
		if (!$this->issmsopen()) {
			return ;
		}
		$config = $this->get_config();
		include_once template('zhanmishu_sms:send');

		return $return;
	}

	function register_input_message(){
		if (!$this->issmsopen()) {
			return ;
		}
		global $_G;
		if ($_G['uid'] && !empty($_POST) && $_GET['regsubmit']='yes' && $_GET['mobile']) {
			$verify = $this->get_verify();
			$sid = $verify->get_sid();
			$data = daddslashes($_GET);
			if ($sid) {
				C::t('#zhanmishu_sms#zhanmishu_sms')->update($sid,array('uid'=>$_G['uid'],'isregsuccess'=>'1'));
				$config = $this->get_config();
				if ($config['isauto']) {
					C::t('common_member_profile')->update($_G['uid'],array('mobile'=>$data['mobile']));
				}
			}
			$verifytype =  $this->call_function('get_verify_id');
			if (!$verifytype) {
				return;
			}
		}
		if ($_G['uid'] && $config['auto_verify'] && $verify) {
			$data = daddslashes($_GET);
			$fields = array();
			$fields['uid'] = $_G['uid'];
			$fields['mobile'] = $data['mobile'];
			$fields['type'] = '1';
			$fields['issuccess'] = '1';
			$fields['isregsuccess'] = '1';
			$fields['dateline'] = TIMESTAMP;
			$user = C::t("#zhanmishu_sms#zhanmishu_sms")->fetch_by_fields($fields);
			$verify = new zhanmishu_mobileverify($config);
			$verify->checkappbyme_updatemobile($fields['mobile'],$fields['uid']);
			$ismobileverify = $verify -> ismobile_verify($data['mobile']);
			if (empty($user) && !$ismobileverify) {
				$verify->set_verify($_G['uid'],false,$fields['mobile'],'1','',$_G['username']);
			}
		}
		return;
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
				showmessage($verify->diconv_back($return['msg']));
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
class plugin_zhanmishu_sms_home extends plugin_zhanmishu_sms{
	function spacecp_credit_extra(){
		$config = $this->get_config();

		if ($_GET['mod'] =='spacecp' && $_GET['ac'] =='credit' && $_GET['op'] == 'transfer') {
    		$verify = new zhanmishu_transfer($config);
 			$isverify = $verify->check_user_isverify($_G['uid']);
 			if ($isverify < 1) {
 				$mobile = $info['field']['mobile'] ? $info['field']['mobile'] : getuserprofile('mobile');
 				showmessage(lang('plugin/zhanmishu_sms','you_must_verify_before_tranfer'), 'plugin.php?id=zhanmishu_sms:verify&mobile='.$mobile,'error');
 			}
    	}
    	if ($_GET['transfersubmit_btn'] &&  !empty($_POST) && $_GET['mod'] =='spacecp' && $_GET['ac'] =='credit' && $_GET['op'] == 'transfer') {
    		$verify = new zhanmishu_transfer($config,$_GET['code'],$_GET['smsverify']);
    		$return = $verify->safe_verify();

    		if ($return['code'] == '1') {
    			return ;
    		}
    		showmessage(lang('plugin/zhanmishu_sms','sce_verify_error'), dreferer(),'error');
    	}

	}
	function spacecp_profile_extra(){
		global $_G;
    	if (submitcheck("profilesubmitbtn") && isset($_GET['mobile']) && $_GET['op'] =='verify' && $_GET['ac'] =='profile') {
    		//cannot submit 
    		echo '<script type="text/javascript">top.location.href="plugin.php?id=zhanmishu_sms:verify&mobile='.$_GET['mobile'].'"</script>';
    		exit();
    	}
		
		$verifytype = $this->call_function('get_verify_id');

		if (!$verifytype) {
			return;
		}
		$info = $this->call_function('get_member_verify_info',array($_G['uid'],$verifytype,true));
		if ($info['flag'] =='1' && ($_GET['op'] =='contact' || $_GET['op'] == 'verify')){
			$lang_change = lang('plugin/zhanmishu_sms', 'change');
			$html = <<<EOF
    <br><a class="xi2" style="padding:0 5px;font-size: 14px;line-height: 28px;" href="javascript:;" onclick="showWindow('mobileverify','plugin.php?id=zhanmishu_sms:verify&amp;mobile={$info[field][mobile]}&amp;act=edit','get','0')">{$lang_change}>></a>
EOF;
		}else{
			$html ='';
		}
    	return $html;
	}
	function spacecp_credit_bottom(){
		if ($_GET['op']=='transfer') {
			$mobile = getuserprofile('mobile');
			include_once template('zhanmishu_sms:credittransfer');
			return $return;
		}
		return;
	}

}

class plugin_zhanmishu_sms_forum extends plugin_zhanmishu_sms {

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
		if ($_GET['action'] == 'reply') {
			//check is_replay_verify
			$isreply_check = $this->call_function('isreply_check');
			if ($isreply_check) {
				# code...
				showmessage(lang('plugin/zhanmishu_sms','verify_before_post'), '', array(),array('showid' => '','extrajs' => '<script type="text/javascript">'.'hideWindow("mobileverify");showDialog("'.lang('plugin/zhanmishu_sms','verify_before_post').'","right","",function(){top.location.href="'.'plugin.php?id=zhanmishu_sms:verify&mobile='.$mobile.'";});</script>','showdialog' => false));

				//showmessage(lang('plugin/zhanmishu_sms','verify_before_post'),'plugin.php?id=zhanmishu_sms:verify&mobile='.$mobile,'info');
			}
		}else{
			$ispostcheck = $this->call_function('ispost_check');
			if ($ispostcheck) {
				showmessage(lang('plugin/zhanmishu_sms','verify_before_post'),'plugin.php?id=zhanmishu_sms:verify&mobile='.$mobile,'info');
			}
		}


		return;
	}
	function post_middle(){
		return $this->_notice_box();
	}
	function forumdisplay_fastpost_btn_extra(){
		return $this->_notice_box();
	}

	function _notice_box(){
		$config = $this->get_config();
		$r = '';
		if ($config['isopensmsnotice']) {
			$r .= '<input style="vertical-align:middle;min-height:14px;" type="checkbox" name="issmsnotice" checked><lable style="vertical-align:middle">'.lang('plugin/zhanmishu_sms', 'getsmsnotice').'</lable>';
		}
		if ($config['isopenemailnotice']) {
			$r .= '<input style="vertical-align:middle;min-height:14px;" type="checkbox" name="isemailnotice" checked><lable style="vertical-align:middle">'.lang('plugin/zhanmishu_sms', 'getemailnotice').'</lable>';
		}
		return $r;
	}
	function post_zhanmishu_sms_message($params) {

		global $_G;

		if ($params['param']['0'] == 'post_reply_succeed' || $params['param']['0'] == 'post_reply_mod_succeed') {
			$tid = $params['param']['2']['tid'];
			$pid = $params['param']['2']['pid'];
			$fid = $params['param']['2']['fid'];

			$notice = new zhanmishu_notice();
			$notice ->notice($tid,$pid,$fid,array(),$_G['uid']);

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
include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/zhanmishu_transfer.php';

?>