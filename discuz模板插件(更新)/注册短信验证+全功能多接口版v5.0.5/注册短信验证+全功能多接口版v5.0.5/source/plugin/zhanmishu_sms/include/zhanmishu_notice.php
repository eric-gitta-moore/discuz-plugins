<?php
/**
 *      [Caogen8!] (C)2014-2018 Www.Caogen8.co.
 *      Ð¡²Ý¸ù(QQ£º2575163778) wWw.Caogen8.co
 *
 *      Author: CAOGEN8.CO $
 *    	qq:2575163778 $
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if (!class_exists('zhanmishu_sms',false)) {
	/*www-Cgzz8-com*/include_once DISCUZ_ROOT.'source/plugin/zhanmishu_sms/include/Autoloader.php';
}
class zhanmishu_notice extends zhanmishu_sms{
	
	public $type = '4';

	public function notice($tid,$pid,$fid,$tiduser=array(),$fromuid=''){
		//is open 
		global $_G;
		$config = $this->config;
		if (!$tiduser['uid']) {
			$tiduser = $this->getthreadbytid($tid);
			$tsetting = C::t("#zhanmishu_sms#zhanmishu_tsetting")->fetch($tid);
			if ($tsetting) {
				$tiduser = array_merge($tsetting,$tiduser);
			}
		}

		if ($tiduser['uid'] == $_G['uid']) {
			return ;
		}

		$user = getuserbyuid($tiduser['uid']);
		$groupid = $user['groupid'];
		$mobile = $this->getmobilebyuid($tiduser['uid']);
		$email = $user['email'];

		$notice = array();
		$notice['uid'] = $tiduser['uid'];
		$notice['tid'] = $tiduser['tid'];
		$notice['mobile'] = $mobile;
		$notice['email'] = $email;
		$notice['dateline'] = TIMESTAMP;

		$smsdaynum = C::t("#zhanmishu_sms#zhanmishu_notice")->get_day_send_num($notice['uid'],'issmssuccess');
		$emaildaynum = C::t("#zhanmishu_sms#zhanmishu_notice")->get_day_send_num($notice['uid'],'isemailsuccess');
		$smslatesttime = C::t("#zhanmishu_sms#zhanmishu_notice")->get_latestsendtime($notice['uid'],'issmssuccess');
		$emaillatesttime = C::t("#zhanmishu_sms#zhanmishu_notice")->get_latestsendtime($notice['uid'],'isemailsuccess');

		if ($notice['mobile'] && ($config['smsnoticemustsend'] || $tiduser['issmsnotice']) && $config['isopensmsnotice'] && in_array($fid, $config['smsnoticeforum']) && in_array($groupid, $config['smsnoticegroups']) && $config['smsnoticedaylimit'] > $smsdaynum && (TIMESTAMP > $config['smstimeslimit'] * 3600 + $smslatesttime)) {
			$notice['issendsms'] = 1;
		}

		if ($notice['mobile'] && ($config['emailnoticemustsend'] || $tiduser['isemailnotice']) && $config['isopenemailnotice'] && in_array($fid, $config['emailnoticeforum']) && in_array($groupid, $config['smsnoticegroups']) && $config['emailnoticedaylimit'] > $emaildaynum && (TIMESTAMP > $config['emailtimeslimit'] * 3600 + $emaillatesttime)) {
			$notice['issendemail'] = 1;
		}

		if ($notice['issendsms'] || $notice['issendemail']) {
			C::t("#zhanmishu_sms#zhanmishu_notice")->insert($notice,false,false);
		}

		return;
	}

	public function getuidbymobile($mobile){
		if (!$mobile) {
			return false;
		}
		$user = DB::fetch_first('select mobile,uid from %t where mobile = '.$mobile,array('common_member_profile'));
		if (empty($user)) {
			return false;
		}
		return $user['uid'];
	}

	public function groupsmsnotice(){
		$this->type = '5';
		$groupsmssend = C::t("#zhanmishu_sms#zhanmishu_notice")->fet_all_should_groupsms();
		if (empty($groupsmssend)) {
			return;
		}
		$config = &$this->config;
		foreach ($groupsmssend as $value) {
			if ($value['uid'] < 1) {
				$value['uid'] = $this->getuidbymobile($value['mobile']);
			}
			$this->templateid = $value['templateid'];
			$r = $this->sendgroupsms($value['mobile'],$this->templateid,$value['uid']);
			$groupsms = array();
			$groupsms['sendgroupsmstime'] = TIMESTAMP;
			if ($r['code'] =='1') {
				$groupsms['isgroupsmssuccess'] = '1';
			}else{
				$groupsms['isgroupsmssuccess'] = '2';
			}
			C::t("#zhanmishu_sms#zhanmishu_notice")->update($value['nid'],$groupsms);
		}

	}

	public function smsnotice(){
		$smssend = C::t("#zhanmishu_sms#zhanmishu_notice")->fet_all_should_sms();
		if (empty($smssend)) {
			return;
		}
		$config = &$this->config;
		foreach ($smssend as $value) {
			$r = $this->sendsms($value['mobile'],$value['uid']);
			$noticer = array();
			$noticer['issendsms'] ='2';
			$noticer['sendsmstime'] =TIMESTAMP;
			if ($r['code'] =='1') {
				$noticer['issmssuccess'] ='1';
				if ($config['smsnoticeextcredit']) {
					updatemembercount($value['uid'],array('extcredits'.$config['extcredit']=>-$config['smsnoticeextcredit']),false,'TRC');
				}
			}else{
				$noticer['issmssuccess'] ='-1';
			}

			C::t("#zhanmishu_sms#zhanmishu_notice")->update_status($value['uid'],$noticer);
		}
	}
	public function emailnotice(){
		$emailsend = C::t("#zhanmishu_sms#zhanmishu_notice")->fet_all_should_email();
		if (empty($emailsend)) {
			return;
		}
		$config = &$this->config;
		include libfile('function/mail');
		foreach ($emailsend as $value) {
			$noticer = array();
			$succeed = sendmail($value['email'], $this->config['emailnoticetemplateid'], $_G['setting']['bbname']."\n\n\n$message");
				$noticer['issendemail'] ='2';
				$noticer['sendemailtime'] =TIMESTAMP;
			if ($succeed) {
				$noticer['isemailsuccess'] ='1';
				if ($config['emailnoticeextcredit']) {
					updatemembercount($value['uid'],array('extcredits'.$config['extcredit']=>-$config['emailnoticeextcredit']),false,'TRC');
				}
				
			}else{
				$noticer['isemailsuccess'] ='-1';
			}
			C::t("#zhanmishu_sms#zhanmishu_notice")->update_status($value['uid'],$noticer);
		}
	}

	public function getthreadbytid($tid){
		if (!$tid) {
			return false;
		}
		$thread = DB::fetch_first('select tid,authorid as uid from %t where tid ='.$tid,array('forum_thread'));
		return $thread;
	}
	public function get_username_byuid($uid){
		global $_G;
		$uid = $uid  ? $uid : $_G['uid'];
		if ($uid) {
			$user = getuserbyuid($uid);
			if (!empty($user)) {
				return $user['username'];
			}
		}

		return false;
	}
	public function sendgroupsms($phone,$templateid,$uid){
		global $_G;
		$phone_num = C::t("#zhanmishu_sms#zhanmishu_sms")->fetch_day_phone($phone);
		
		if ($phone_num > $this->timeslimit || !$this->verify_mobile_number($phone)) {
			$return = array('code'=>'-1','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','too_offen')));
			return $return;
		}

		$param = array();
		$param['username'] = $this->to_utf8($this->get_username_byuid($uid)) ? $this->to_utf8($this->get_username_byuid($uid)) : 'user';

		$param = json_encode($param);
		$resp = $this->sendpost($phone,$param,$templateid);
		if (!$resp) {
			$return = array('code'=>'-5','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','too_offen')));
			return $return;
		}	
		$return = array();
		if (isset($resp['result']['err_code']) && $resp['result']['err_code'] == '0') {
			$return['model'] = $this->diconv_back($resp['result']['model']);
			$return['issuccess'] = 1;
		}else{
			$return['code'] = $this->diconv_back($resp['code']);
			$return['issuccess'] = 0;
			$return['msg'] = $this->diconv_back($resp['msg']);
			$return['sub_code'] = $this->diconv_back($resp['sub_code']);
			$return['sub_msg'] = $this->diconv_back($resp['sub_msg']);
		}

			$return['issend'] = 1;
			$return['mobile'] = $phone;
			if ($uid) {
				$return['uid'] = $uid;
			}
			$return['type'] = $this->type;
			$return['dateline'] = TIMESTAMP;
		$sid=C::t("#zhanmishu_sms#zhanmishu_sms")->insert($return,true);
		if (!isset($resp['result']['err_code']) || $resp['result']['err_code'] !== '0') {
			$return = array('code'=>'-3','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','send_error')));
			return $return;
		}
		$return = array('code'=>'1','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','send_success')));
		return $return;
	}

	public function sendsms($phone,$uid='',$nationcode='86'){
		$this->templateid = $this->config['smsnoticetemplateid'] ? $this->config['smsnoticetemplateid'] : $this->templateid;
		global $_G;

		$phone_num = C::t("#zhanmishu_sms#zhanmishu_sms")->fetch_day_phone($phone);
		
		if ($phone_num > $this->timeslimit || !$this->verify_mobile_number($phone)) {
			$return = array('code'=>'-1','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','too_offen')));
			return $return;
		}

		if ($uid) {
			$user = getuserbyuid($uid);
			$username = $user['username'];
		}
		$username = diconv(strval($username),CHARSET , 'UTF-8');

		$param = array('username'=>$username,'product'=>$this->product);
		$param = json_encode($param);
		$ip_array = explode('.', $_G['clientip']);

		$resp = $this->sendpost($phone,$param,'',$nationcode);
		if (!$resp) {
			$return = array('code'=>'-5','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','too_offen')));
			return $return;
		}	
		$return = array();
		if (isset($resp['result']['err_code']) && $resp['result']['err_code'] == '0') {
			$return['model'] = $this->diconv_back($resp['result']['model']);
			$return['issuccess'] = 1;
		}else{
			$return['code'] = $this->diconv_back($resp['code']);
			$return['issuccess'] = 0;
			$return['msg'] = $this->diconv_back($resp['msg']);
			$return['sub_code'] = $this->diconv_back($resp['sub_code']);
			$return['sub_msg'] = $this->diconv_back($resp['sub_msg']);
		}

			$return['issend'] = 1;
			if ($isunset > 0) {
				$return['status'] = '2';
			}else if ($isnewsend) {
				$return['status'] = '3';
			}
			
			$return['mobile'] = $phone;
			$return['type'] = $this->type;
			$return['dateline'] = TIMESTAMP;
			$return['uid'] = $uid;
			if ($nationcode) {
				$return['nationcode'] = $nationcode;
			}
		$sid=C::t("#zhanmishu_sms#zhanmishu_sms")->insert($return,true);
		if (!isset($resp['result']['err_code']) || $resp['result']['err_code'] !== '0') {
			$return = array('code'=>'-3','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','send_error')));
			return $return;
		}
		$return = array('code'=>'1','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','send_success')));
		return $return;
	}

	public function getmobilebyuid($uid){
		if (!$uid) {
			return false;
		}
		$user = DB::fetch_first('select uid ,mobile from %t where uid = '.$uid,array('common_member_profile'));
		if (empty($user)) {
			return false;
		}
		$ismobile =$this->verify_mobile_number($user['mobile']);
		if (!$ismobile) {
			return false;
		}
		return $user['mobile'];
	}
}
//From:www-cgzz8-Com
?>