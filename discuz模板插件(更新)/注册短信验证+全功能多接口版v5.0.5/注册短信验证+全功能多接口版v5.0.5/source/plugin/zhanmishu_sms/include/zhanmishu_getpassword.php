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

class zhanmishu_getpassword extends zhanmishu_sms{
	
	public $type = '3';
	public $newhead = 'zmspw';
	public $cookiehead = 'zmsgetpwd';

	public function sendsms($username='',$phone,$code,$verify='',$is_appme=false,$nationcode='86'){
		if (!$phone) {
			$return = array('code'=>'-2','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','phone_isnot_exists')));
			return $return;
		}
		global $_G;
		$this->templateid = $this->config['pwdtemplateid'] ? $this->config['pwdtemplateid'] : $this->templateid;
		$ip_num = C::t("#zhanmishu_sms#zhanmishu_sms")->fetch_day_ip($_G['clientip']);
		$phone_num = C::t("#zhanmishu_sms#zhanmishu_sms")->fetch_day_phone($phone);

		if ($ip_num > $this->iplimit || $phone_num > $this->timeslimit) {
			$return = array('code'=>'-1','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','too_offen')));
			return $return;
		}

		if (!$this->verify_mobile_number($phone)) {
			$return = array('code'=>'-2','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','wrongmobile_number')));
			return $return;
		}

		if ($is_appme) {
			$user = DB::fetch_first('select * from %t where mobile ='.$phone,array('appbyme_sendsms'));
			if (!empty($user)) {
				$uid = $user['uid'];
			}
		}
		//check username and mobile exists
		$uid = isset($uid) && $uid ? $uid : $this->check_username_mobile($username,$phone);
		if (!$uid) {
			$return = array('code'=>'-3','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','user_and_mobile_is_not_exists')));
			return $return;
		}

		$verify = $verify ? $verify : rand(100000,999999);
		$verify = diconv(strval($verify),CHARSET , 'UTF-8');

		$param = array('code'=>$verify,'product'=>$this->product);
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
			$return['mobile'] = $phone;
			$return['type'] = $this->type;
			$return['verify'] = $verify;
			$return['dateline'] = TIMESTAMP;
			$return['ip1'] = $ip_array[0];
			$return['ip2'] = $ip_array[1];
			$return['ip3'] = $ip_array[2];
			$return['ip4'] = $ip_array[3];
			$return['uid'] = $uid;
			if ($nationcode) {
				$return['nationcode'] = $nationcode;
			}

		$sid=C::t("#zhanmishu_sms#zhanmishu_sms")->insert($return,true);
		$this->clear_send_coolie();
		if (!isset($resp['result']['err_code']) || $resp['result']['err_code'] !== '0') {
			$return = array('code'=>'-3','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','send_error')));
			return $return;
		}
		$cookieverify_arr = array();
		$cookieverify_arr['verify'] = $verify;
		$cookieverify_arr['life'] = TIMESTAMP + $this->verify_life;
		$cookieverify_arr['formhash'] = FORMHASH;
		$cookieverify_arr['code'] = $code;
		$cookieverify_arr['sid'] = $sid;
		$cookieverify_arr['uid'] = $uid;
		$cookieverify_arr['phone'] = $phone;
		$cookieverify_json = json_encode($cookieverify_arr);

		$cookieverify = authcode($cookieverify_json, 'ENCODE', $_G['config']['security']['authkey']);

		dsetcookie($this->cookiehead.$code, $cookieverify, 0);
		$return = array('code'=>'1','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','send_success')));
		
		return $return;
	}

	public function verify($data){
		if (strlen($this->verify) !== 6) {
			$return = array('code'=>'-11','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','data_error')));
			return $return;
		}
		$cookieverify = getcookie($this->cookiehead.$this->code);
		
		$cookieverify_arr = $this->get_verify_array();
		if (!is_array($cookieverify_arr)) {
			$return = array('code'=>'-12','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','data_error')));
			return $return;
		}

		$sid = $cookieverify_arr['sid'];
		$sms = C::t("#zhanmishu_sms#zhanmishu_sms")->fetch($sid);
		if ($sms['ischangepwd']) {
			$return = array('code'=>'-13','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','data_error')));
			return $return;
		}
		if ($sms['nums'] > $this->maxnums) {
			$return = array('code'=>'-14','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','too_offen')));
			return $return;
		}else if($sms['uid'] > 0 && $this->type=='1'){
			$return = array('code'=>'-15','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','is_used')));
			return $return;
		}else if($sms['uid'] < 1){
			$return = array('code'=>'-9','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','data_error')));
			return $return;
		}
		C::t("#zhanmishu_sms#zhanmishu_sms")->update($sid,array('nums'=>$sms['nums'] +1));

		if (!isset($cookieverify_arr['code']) || $cookieverify_arr['code'] !== $this->code) {
			$return = array('code'=>'-2','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','data_error')));
			return $return;
		}
		if ($this->get_ture_verify() !== $this->verify) {

			$return = array('code'=>'-3','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','verify_error')));
			return $return;
		}

		if ($cookieverify_arr['life'] < TIMESTAMP) {
			$return = array('code'=>'-4','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','verify_timeout')));
			return $return;
		}

		if ($cookieverify_arr['uid'] !== $this->check_username_mobile($data['username'],$data['phone']) || $cookieverify_arr['phone'] !== $data['phone']) {
			$return = array('code'=>'-8','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','data_error')));
			return $return;
		}

		$return = array('code'=>'1','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','success')));
			return $return;
	}

	public function changepwd($data){
		$pwd = $data['pwd'];
		if (strlen($pwd) < 6) {
			$return = array('code'=>'-1','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','password_too_simple')));
			return $return;
		}

		$verify = $this->verify($data);
		if ($verify['code'] < 1) {
			return $verify;
		}
		$mobile = $data['phone'];
		$uid = $this->check_username_mobile($username,$mobile);
		$user = getuserbyuid($uid);
		$username = $user['username'];
		if (!$uid) {
			$return = array('code'=>'-2','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','data_error')));
			return $return;
		}
		loaducenter();
		$re = uc_user_edit($username,'',$pwd,'',1,0,'');

		if ($re = 1) {
			$sid = $this->get_sid();
			if ($sid) {
				C::t("#zhanmishu_sms#zhanmishu_sms")->update($sid,array('ischangepwd'=>'1'));
			}
			$ip=$_G['clientip'];
			$result = uc_user_login($user['username'],$pwd,0);

			if ($result[0] > 0) {
				$member = getuserbyuid($result[0], 1);
				require_once libfile('function/member');
				$cookietime = 1296000;
				setloginstatus($member, $cookietime);
				dsetcookie('lip', $_G['member']['lastip'].','.$_G['member']['lastvisit']);
				C::t('common_member_status')->update($_G['uid'], array('lastip' => $_G['clientip'], 'lastvisit' =>TIMESTAMP, 'lastactivity' => TIMESTAMP));
				if ($this->isauto) {
					C::t('common_member_profile')->update($_G['uid'],array('mobile'=>$user['mobile']));
				}
			}
			$return = array('code'=>'1','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','editpwdsuccess')));
			return $return;
		}


		$this->clear_send_coolie();
		$return = array('code'=>$rs,'msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','set_error')));
		return $return;

	}

	public function check_username_mobile($username='',$mobile){
		if (!$mobile) {
			return false;
		}
		if ($username) {
			$user = DB::fetch_first('select m.uid,p.mobile,m.username from '.DB::table('common_member').' m left join '.DB::table('common_member_profile').' p on m.uid=p.uid having username =\''.$username.'\' and mobile ='.$mobile);
		}else{
			$user = DB::fetch_first('select uid,mobile from %t where mobile = '.$mobile,array('common_member_profile'));
		}
		if (empty($user)) {
			return false;
		}
		return $user['uid'];
	}

}
//From:www-cgzz8-Com
?>