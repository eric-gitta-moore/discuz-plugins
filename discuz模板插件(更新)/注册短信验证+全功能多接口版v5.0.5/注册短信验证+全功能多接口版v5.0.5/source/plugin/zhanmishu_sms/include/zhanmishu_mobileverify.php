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
class zhanmishu_mobileverify extends zhanmishu_sms{
	
	public $type = '2';
	public $newhead = 'zmscm';
	public $newcookiehead = 'dedfeaade';

	public function mobile_verify(){
		global $_G;
 
		$verify = $this->verify();
		$mobile = $this->get_mobile_number();
		$verify_id = $this->get_verify_id();
		$umobile = $this->get_usermobile();
		if (!$verify_id) {
			$return = array('code'=>'-3','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','verify_error_please_checksetting')));
			return $return;
		}
		//check is verify ?

		if ($this->check_user_isverify($_G['uid']) > 0 && $this->verify_mobile_number($mobile) && $this->verify_mobile_number($umobile)) {
			$return = array('code'=>'-8','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','haven_verify_thissuer')));
			return $return;
		}
		
		if ($verify['code'] == '1') {
			return $this->set_verify($_G['uid'],$verify_id,$mobile,'1','',$_G['username']);
		}else{
			return $this->set_verify($_G['uid'],$verify_id,$mobile,'-1','',$_G['username']);
		}
	}

	public function check_user_isverify($uid=''){
		if ($this->config['iseasy_verisy']) {
			if ( $this->get_usermobile()) {
				return '1';
			}
		}
		if (!$uid) {
			global $_G;
		}
		$verify_id = $this->get_verify_id();
		$uid = $uid ? $uid : $_G['uid'];
		if ($uid) {
			$verify = C::t('common_member_verify')->fetch($uid);
			if (!empty($verify)) {

				return intval($verify['verify'.$verify_id]) > 0 ? $verify['verify'.$verify_id] : false;
			}
		}
		return false;
	}

	public function set_verify($uid='',$verifytype=false,$mobile='',$flag='1',$vid='',$username='',$ischeckverify=true){
		global $_G;	
		$uid = $uid ? $uid : $_G['uid'];
		$mobile = $mobile ? $mobile : $this->get_usermobile($uid);
		if ($ischeckverify && $this->ismobile_verify($mobile) && !defined('IN_ADMINCP')) {
			$return = array('code'=>'-4','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','have_verify')));
			return $return;
		}
		$verifytype = $verifytype ? $verifytype : $this->get_verify_id();
		$flag = $flag > 0 ? '1' : '-1';
		if (!$username) {
			$u = getuserbyuid($uid);
			$username = $u['username'];
		}
		$vid = $vid ? $vid : $this->get_vid_byverifyid($uid,$verifytype);
		$verify_input = array();
		$verify_input['uid'] = $uid;
		
		$verify_info = array();
		$verify_info['uid'] = $uid;
		$verify_info['username'] = $username;
		$verify_info['verifytype'] = $verifytype;
		$verify_info['flag'] = $flag;
		$verify_info['dateline'] = TIMESTAMP;
		$verify_info['field']['mobile'] = $mobile;
		if ($flag < 1) {
			$verify_info['field']['mobile'] = '';
		}
		$verify_info['field'] = serialize($verify_info['field']);
		
		if ($vid) {
			$verify_info['vid'] = $vid;
		}

		if ($flag >= 1 && $mobile) {
			$verify_input['verify'.$verifytype] = '1';
			C::t('common_member_verify')->insert($verify_input, false,true);
			C::t('common_member_verify_info')->insert($verify_info, false,true);
			C::t('common_member_profile')->update($uid,array('mobile'=>$mobile));
			$this->checkappbyme_updatemobile($mobile,$uid);
			$config = &$this->config;
			notification_add($uid,'system',$config['noticetemplate']);

			if ($config['openaddextcredit']) {
				$newsid = C::t("#zhanmishu_sms#zhanmishu_sms")->get_newest_sid_byuid($uid);
				$isaddextcredit = $this->is_get_extcredit($mobile,$uid);
				if (!$isaddextcredit) {
					updatemembercount($uid,array('extcredits'.$config['extcredit']=>$config['addnum']),false,'TRC');
					C::t("#zhanmishu_sms#zhanmishu_sms")->update($newsid,array('isverify'=>'1','isaddextcredit'=>'1','status'=>'1'));
				}

			}
			$return =array('code'=>'1','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','verify_success')));
			return $return;
		 }else{
		 	$verify_input['verify'.$verifytype] = '-1';
		 	C::t('common_member_verify')->insert($verify_input, false,true);
		 	C::t('common_member_verify_info')->insert($verify_info, false,true);
			C::t('common_member_profile')->update($uid,array('mobile'=>''));
		 	$return =array('code'=>'-3','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','verifyerror_verify_notsuccess')));
			return $return;
		 }

	}

	public function is_get_extcredit($mobile='',$uid=''){
		$num = C::t("#zhanmishu_sms#zhanmishu_sms")->get_count_by_field(array('mobile'=>$mobile,'isverify'=>'1','isaddextcredit'=>'1'));
		if ($uid) {
			$num += C::t("#zhanmishu_sms#zhanmishu_sms")->get_count_by_field(array('uid'=>$uid,'isverify'=>'1','isaddextcredit'=>'1'));
		}

		return $num;
	}

	public function ismobile_verify($mobile){
		if (!$mobile) {
			return;
		}

		$sql = 'select m.uid,m.mobile,v.verify'.$this->get_verify_id().' from '.DB::table("common_member_profile").' m left join '.DB::table("common_member_verify").' v on m.uid = v.uid where m.mobile = '.$mobile.' and v.verify'.$this->get_verify_id().' = 1';
		$user = DB::fetch_first($sql);
		if (empty($user)) {
			return false;
		}else{
			return $user['uid'];
		}

	}
	public function sendsms($phone,$code,$ischeckverify=true,$isunset=false,$isnewsend=false,$nationcode='86'){
		$this->templateid = $this->config['verifytemplateid'] ? $this->config['verifytemplateid'] : $this->templateid;
		global $_G;
		if ($ischeckverify && $this->ismobile_verify($phone)) {
			$return = array('code'=>'-3','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','have_verify')));
			return $return;
		}
		$ip_num = C::t("#zhanmishu_sms#zhanmishu_sms")->fetch_day_ip($_G['clientip']);
		$phone_num = C::t("#zhanmishu_sms#zhanmishu_sms")->fetch_day_phone($phone);
		
		if ($ip_num > $this->iplimit || $phone_num > $this->timeslimit || !$this->verify_mobile_number($phone)) {

			$return = array('code'=>'-1','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','too_offen')));
			return $return;
		}
		$is_register = $this->ismobilelimit && $this->ismobile_register($phone);

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
			if ($isunset > 0) {
				$return['status'] = '2';
			}else if ($isnewsend) {
				$return['status'] = '3';
			}
			
			$return['mobile'] = $phone;
			$return['type'] = $this->type;
			$return['verify'] = $verify;
			$return['dateline'] = TIMESTAMP;
			$return['ip1'] = $ip_array[0];
			$return['ip2'] = $ip_array[1];
			$return['ip3'] = $ip_array[2];
			$return['ip4'] = $ip_array[3];
			if ($_G['uid']) {
				$return['uid'] = $_G['uid'];
			}
			if ($nationcode) {
				$return['nationcode'] = $nationcode;
			}


		$sid=C::t("#zhanmishu_sms#zhanmishu_sms")->insert($return,true);
		$this->clear_send_coolie();
		
		if (!isset($resp['result']['err_code']) || $resp['result']['err_code'] !== '0') {
			$return = array('code'=>$resp['code'] ? $resp['code']  :'-3','msg'=>$resp['msg'] ? $resp['msg'] :$this->to_utf8(lang('plugin/zhanmishu_sms','send_error')));
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

	public function new_send($phone,$code){
		global $_G;
		$ismobile_verify = $this->ismobile_verify($phone);
		if ($ismobile_verify) {
			return array('code'=>'-6','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','mobile_have_verify')));
		}
		$verify = $this->verify();
		if (intval($verify['code']) < 1) {
			return $verify;
		}
		$oldmobile = $this->get_mobile_number();
		$userinfo = $this->get_member_verify_info();
		$usermobile = $userinfo['field']['mobile'];
		$verify_id = $this->get_verify_id();

		if (!$verify_id) {
			return array('code'=>'-3','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','verify_error')));
		}
		$info = $this->get_member_verify_info($_G['uid'],$verify_id,'1');

		if ($phone == $oldmobile) {
			$return = array('code'=>'-3','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','newold_mobile_cannot_same')));
			return $return;
		}


		if ($oldmobile == $info['field']['mobile'] && $oldmobile==$usermobile) {
				$this->cookiehead = $this->newcookiehead;
				$return =  $this->sendsms($phone,$code,true,false,true);
				if ($return['code'] == '1') {

					$cookieverify_arr = array();
					$cookieverify_arr['oldverify'] = $this->verify; 
					$cookieverify_arr['life'] = TIMESTAMP + $this->verify_life;
					$cookieverify_arr['formhash'] = FORMHASH;
					$cookieverify_arr['code'] = $code;
					$cookieverify_arr['oldcode'] = $this->code;
					$cookieverify_arr['phone'] = $phone;
					$cookieverify_arr['oldmobile'] = $oldmobile;
					$cookieverify_json = json_encode($cookieverify_arr);
					$cookieverify = authcode($cookieverify_json, 'ENCODE', $_G['config']['security']['authkey']);
					
					$this->clear_send_coolie($this->newhead);
					dsetcookie($this->newhead.$code, $cookieverify, 0);
				}
				return $return;
				
		}
		$return = array('code'=>'-3','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','senderror')));
		return $return;

	}

	public function new_verify($data = array()){
		global $_G;
		$this->cookiehead = $this->newcookiehead;
		if (!isset($data['code']) || !isset($data['oldmobile']) || !isset($data['oldverify']) || !isset($data['oldcode']) || !isset($data['mobile']) || !isset($data['verify'])) {
			$return = array('code'=>'-22','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','dataeror_or_not')));
			return $return;
		}
		$cookieverify = getcookie($this->newhead.$data['code']);
		$verify_json = authcode($cookieverify,'DECODE',$_G['config']['security']['authkey']);
		$verify_arr = json_decode($verify_json,true);

		if ($data['oldcode'] == $verify_arr['oldcode'] && $data['code'] == $verify_arr['code'] && $data['oldmobile']==$verify_arr['oldmobile'] && $data['mobile'] == $verify_arr['phone'] && $data['oldverify'] == $verify_arr['oldverify']) {		
			$return = $this->verify();

			return $return;
		}


		return array('code'=>'-3','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','verify_error')));
	}

	public function change_mobile($data=array()){
		global $_G;
		$verify = $this->new_verify($data);
		if ($verify['code'] < 1) {
			return $verify;
		}
		$vinfo = $this->get_member_verify_info($_G['uid']);
		$vinfo['field']['mobile'] = $data['mobile'];
		$vinfo['field'] = serialize($vinfo['field']);
		C::t("common_member_verify_info")->update($vinfo['vid'],$vinfo);
		C::t('common_member_profile')->update($_G['uid'],array('mobile'=>$data['mobile']));
		C::t("#zhanmishu_sms#zhanmishu_sms")->update($this->get_sid(),array('isverify'=>'1','isaddextcredit'=>'0','status'=>'3'));
		$this->checkappbyme_updatemobile($data['mobile'],$_G['uid']);
		return array('code'=>'1','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','updatesuccess')));

	}

	public function get_member_verify_info($uid='',$verifytype='',$issuccess=false){
		global $_G;
		if ($issuccess !== false) {
			$flag = ' and flag = '.$issuccess.' ';
		}
		$uid = $uid ? $uid : $_G['uid'];
		$verifytype = $verifytype ? $verifytype : $this->get_verify_id();

		$info = DB::fetch_first('select * from %t where verifytype = '.$verifytype.$flag.' and uid ='.$uid,array('common_member_verify_info'));
		$info['field'] = unserialize($info['field']);
		if ($this->config['iseasy_verisy'] && !$info['field']['mobile']) {
			$info['field']['mobile'] = $this->getmobilebyuid($uid);
		}

		return $info;
	}

	public function getmobilebyuid($uid){
	$user = DB::fetch_first('select uid ,mobile from %t where uid = '.$uid,array('common_member_profile'));
	if (empty($user)) {
		return false;
	}

	return $user['mobile'];
}

	public function get_vid_byverifyid($uid,$verifytype){
		$v = $this->get_member_verify_info($uid,$verifytype);
		if (empty($v)) {
			return false;
		}
		return $v['vid'];
	}



	public function get_verify_setting(){
		$verify = C::t('common_setting')->fetch(array('skey'=>'verify'));
		$verify = unserialize($verify);
		return $verify;
	}

	public function get_verify_id(){
		if (!function_exists('getconfig')) {/*www-caogen8-vip*/
			/*www-cgzz8-com*/include DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/function.php';
		}
		
		return get_verify_id();
	}

	public function get_all_member($uid,$mobile,$isverify,$start,$limit){
		
		$users = DB::fetch_all($this->auto_sql($uid,$mobile,$isverify,$start,$limit));
		if ($this->config['iseasy_verisy']) {
			foreach ($users as $key => $value) {
				if ($value['mobile']) {
					$users[$key]['verifyststus'] = '1';
				}
			}
		}

		return $users;
	}

	public function auto_sql($uid='',$mobile='',$isverify='',$start=0,$limit=0,$iscount=false){
		$verifytype = $this->get_verify_id();
		if (!$verifytype) {
			return false;
		}
		if (!$this->config['iseasy_verisy']) {
			$where = 'where p.mobile !=\'\'';
		}else{
			$where = 'where p.uid > 0 ';
			if ($isverify == '1') {
				$where .= ' and v.verify'.$verifytype.' = 1';
			}else if ($isverify == '-1') {
				$where .= ' and v.verify'.$verifytype.' != 1';
			}
		}

		
		if ($uid) {
			$where .= ' and m.uid = '.$uid;
		}
		if ($mobile) {
			$where .= ' and p.mobile = '.$mobile;
		}


		$select = 'm.uid,m.username,v.verify'.$verifytype.' as verifyststus ,m.groupid,p.mobile,s.dateline,s.carrier';

		$sql = 'select '.$select.' from ( '.DB::table('common_member_profile').' p left join '.DB::table('common_member').' m on p.uid = m.uid ) left join '.DB::table('zhanmishu_sms').' s on p.uid = s.uid left join '.DB::table('common_member_verify').' v on m.uid=v.uid '.$where.'  group by m.uid order by m.uid desc '.DB::limit($start, $limit);

		return $sql;
	}

	public function count_verify($uid,$mobile,$isverify){
		$sql = $this->auto_sql($uid,$mobile,$isverify,'',0,true);
		if (!$sql) {
			return false;
		}
		$num = DB::num_rows(DB::query($sql));
		return $num;
	}
	public function logbymobile($mobile){
		global $_G;
		$verify = $this->verify();
		if ($verify['code'] < '1') {
			return $verify;
		}
		loaducenter();
		$uid = $this->getuidbymobile($mobile);
		$secmobile = $this->get_mobile_number();

		if ($mobile !== $secmobile) {
			$return = array('code'=>'-13','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','data_error')));
			return $return;
		}
		if ($uid > 0) {
			$ip=$_G['clientip'];

			$member = getuserbyuid($uid, 1);
			require_once libfile('function/member');
			$cookietime = 1296000;
			setloginstatus($member, $cookietime);
			dsetcookie('lip', $_G['member']['lastip'].','.$_G['member']['lastvisit']);
			C::t('common_member_status')->update($_G['uid'], array('lastip' => $_G['clientip'], 'lastvisit' =>TIMESTAMP, 'lastactivity' => TIMESTAMP));
			$return = array('code'=>'1','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','login_success')));
	
			return $return;
			$this->clear_send_coolie();
		}
		$return = array('code'=>'-11','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','login_error')));
		return $return;
	}
}
//From:www-cgzz8-Com
?>