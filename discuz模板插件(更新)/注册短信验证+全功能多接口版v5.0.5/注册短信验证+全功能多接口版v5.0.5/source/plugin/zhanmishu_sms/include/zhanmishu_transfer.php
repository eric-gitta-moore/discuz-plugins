<?php
/**
 *      [Caogen8!] (C)2014-2018 Www.Caogen8.co.
 *      ะกฒÝธ๙(QQฃบ2575163778) wWw.Caogen8.co
 *
 *      Author: CAOGEN8.CO $
 *      qq:2575163778 $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if (!class_exists('zhanmishu_mobileverify',false)) {
	/*www-Cgzz8-com*/include_once DISCUZ_ROOT.'source/plugin/zhanmishu_sms/include/zhanmishu_mobileverify.php';
}
class zhanmishu_transfer extends zhanmishu_mobileverify{
	protected $cookiehead='zmssce';
	public $type = '6';

	public function sendsms($phone,$code,$ischeckverify=true,$nationcode){
		if (!$this->check_mobile_and_user($phone)) {
			$return = array('code'=>'-7','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','mobile_and_verify_user_is_not_exists')));
			return $return;
		}
		$this->templateid = $this->config['verifytemplateid'] ? $this->config['verifytemplateid'] : $this->templateid;
		global $_G;
		if ($ischeckverify && !$this->ismobile_verify($phone)) {
			$return = array('code'=>'-3','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','have_not_verify')));
			return $return;
		}
		$ip_num = C::t("#zhanmishu_sms#zhanmishu_sms")->fetch_day_ip($_G['clientip']);
		$phone_num = C::t("#zhanmishu_sms#zhanmishu_sms")->fetch_day_phone($phone);
		
		if ($ip_num > $this->iplimit || $phone_num > $this->timeslimit || !$this->verify_mobile_number($phone)) {
			$return = array('code'=>'-1','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','too_offen')));
			return $return;
		}

		$verify = rand(100000,999999);
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
			$return['uid'] = $_G['uid'];

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
		$cookieverify_arr['phone'] = $phone;
		$cookieverify_json = json_encode($cookieverify_arr);

		$cookieverify = authcode($cookieverify_json, 'ENCODE', $_G['config']['security']['authkey']);

		dsetcookie($this->cookiehead.$code, $cookieverify, 0);
		$return = array('code'=>'1','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','send_success')));
		
		return $return;
	}

	public function safe_verify(){
		//check mobile
		if (!$this->check_mobile_and_user()) {
			$return = array('code'=>'-7','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','mobile_and_verify_user_is_not_exists')));
			return $return;
		}

		return $this->verify();
	}

	public function check_mobile_and_user($mobile){
		$usermobile = $this->get_usermobile();
		$mobile = $mobile ? $mobile :$this->get_mobile_number();

		if ($usermobile !== $mobile) {
			return false;
		}
		return true;
	}


}
//From:www-cgzz8-Com
?>