<?php
/**
 *      [Caogen8.Co!] (C)2014-2018 Cgzz8.Com && plugin by caogen8. && cgzz8.com
 *      小草根(QQ：2575163778) wWw.Caogen8.co
 *
 *      Author: CAOGEN8.CO $
 */
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
 class zhanmishu_sms
{
	protected $appkey='';
	protected $appsecret='';
	protected $iplimit=5;
	public $code='';
	protected $ismobilelimit=1;
	protected $isauto=1;
	protected $cookiehead='cookieverify';
	protected $sign='';
	protected $verify_life=360;
	protected $timeslimit=4;
	protected $maxnums=4;
	public $config;
	public $verify='';
	public $templateid='';
	public $product= '';
	public $type= '1';
	public $randemail= '@randrno.com';
	public $addresscheckurl = 'https://tcc.taobao.com/cc/json/mobile_tel_segment.htm?tel=';
	public $smsbaosendurl='http://api.smsbao.com/sms?';
	public $mitakeurl='http://smexpress.mitake.com.tw:9600/SmSendGet.asp?DestName=SiteApiSend';
	public $zrsmsapi = 'http://oa.zrsms.com/api/post_send/';
	public $webchinses = 'http://utf8.sms.webchinese.cn/?';
	public $cachefile = 'zhanmishu_sms';
	public $sendsmsapi = 'http://sms.market.alicloudapi.com/singleSendSms';
	
	public function get_cache_file(){
		return DISCUZ_ROOT.'./data/sysdata/cache_'.$this->cachefile.'.php';
	}	

	public function __construct($config=array(),$code='',$verify='',$cookiehead = '')
	{
		global $_G;
		if (empty($config)) {
			if (!function_exists('getconfig')) {/*www-caogen8-vip*/
				/*www-cgzz8-com*/include DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/function.php';
			}
			$config = getconfig();
		}
		$this->config = $config;
	 	if (isset($config['appkey']) && $config['appkey']) {$this->appkey = $config['appkey'];}
	 	if (isset($config['appsecret']) && $config['appsecret']) {$this->appsecret = $config['appsecret'];}
	 	if (isset($config['sign']) && $config['sign']) {$this->sign = $config['sign'];}
	 	if (isset($config['iplimit']) && $config['iplimit']) {$this->iplimit = $config['iplimit'];}
	 	if (isset($config['ismobilelimit'])) {$this->ismobilelimit = $config['ismobilelimit'];}
	 	if (isset($config['isauto'])) {$this->isauto = $config['isauto'];}
	 	if (isset($config['verify_life']) && $config['verify_life']) {$this->verify_life = $config['verify_life'];}
	 	if (isset($config['timeslimit']) && $config['timeslimit']) {$this->timeslimit = $config['timeslimit'];}
	 	if (isset($config['templateid']) && $config['templateid']) {$this->templateid = $config['templateid'];}
	 	if (isset($config['product']) && $config['product']) {$this->product = $config['product'];}
	 	if (isset($config['maxnums']) && $config['maxnums']) {$this->maxnums = $config['maxnums'] + 1;}
	 	if (isset($cookiehead) && $cookiehead) {$this->cookiehead = $cookiehead;}
	 	if (isset($code) && $code) {$this->code = $code;}
	 	if (isset($verify) && $verify) {$this->verify = $verify;}
	 	$this->smsbaosendurl .= 'u='.$config['smsbaousername'];
	 	$this->smsbaosendurl .= '&p='.md5($config['smsbaopassword']);
	 	$this->mitakeurl .= '&username='.$config['mitakeusername'].'&password='.$config['mitakepwd'];
	 	$this->sign=diconv(strval($this->sign),CHARSET , 'UTF-8');
	 	$this->product = $this->product == '' ? $this->sign : diconv(strval($this->product),CHARSET , 'UTF-8');

	}

	public function checkappbyme_exists(){
		$table = DB::table('appbyme_sendsms');
		$count = DB::fetch_first('show tables like \''.$table.'\'');
		if (!empty($count)) {
			return true;
		}
		return false;
	}

	public function checkappbyme_updatemobile($mobile,$uid=''){
		global $_G;
		$this->checkqianfanmobile($mobile,$uid);
		if (!$this->checkappbyme_exists()) {
			return false;
		}
		$uid = $uid ? $uid : $_G['uid'];
		if (!$mobile || !$this->verify_mobile_number($mobile) || $uid < 1) {
			return false;
		}
		//check mobile && uid
		$user = DB::fetch_first('select * from %t where uid ='.$uid.' and mobile = '.$mobile,array('appbyme_sendsms'));
		if (!empty($user)) {
			return '1';
		}

		//check mobile 
		$user = DB::fetch_first('select * from %t where mobile = '.$mobile,array('appbyme_sendsms'));
		if (!empty($user)) {
			DB::update("appbyme_sendsms",array('uid'=>$uid,'time'=>TIMESTAMP),'mobile='.$mobile);
			return '2';
		}
		//check uid
		$user = DB::fetch_first('select * from %t where uid = '.$uid,array('appbyme_sendsms'));
		if (!empty($user)) {
			DB::update("appbyme_sendsms",array('mobile'=>$mobile,'time'=>TIMESTAMP),'uid='.$uid);
			return '3';
		}

		$user = array(
			'uid'=>$uid,	
			'mobile'=>$mobile,
			'time'=>TIMESTAMP,
		);

		$r = DB::insert('appbyme_sendsms',$user,true,false);

		return $r;
	}

	public function checkqianfanmobile($mobile,$uid=''){
		global $_G;
		if (!$this->checkqianfan_exists()) {
			return false;
		}
		$uid = $uid ? $uid : $_G['uid'];

		if (!$mobile || !$this->verify_mobile_number($mobile) || $uid < 1) {
			return false;
		}
		//check mobile && uid
		$user = DB::fetch_first('select * from %t where uid ='.$uid.' and phone = '.$mobile,array('phonebind'));
		if (!empty($user)) {
			return '1';
		}
		//check mobile 
		$user = DB::fetch_first('select * from %t where phone = '.$mobile,array('phonebind'));
		if (!empty($user)) {
			DB::update("phonebind",array('uid'=>$uid,'dateline'=>TIMESTAMP),'phone='.$mobile);
			return '2';
		}
		//check uid
		$user = DB::fetch_first('select * from %t where uid = '.$uid,array('phonebind'));
		if (!empty($user)) {
			DB::update("phonebind",array('phone'=>$mobile,'dateline'=>TIMESTAMP),'uid='.$uid);
			return '3';
		}

		$user = array(
			'uid'=>$uid,	
			'phone'=>$mobile,
			'dateline'=>TIMESTAMP,
		);

		$r = DB::insert('phonebind',$user,true,false);
		return $r;


	}

	public function checkqianfan_exists(){
		$table = DB::table('phonebind');
		$count = DB::fetch_first("show tables like '".$table."'");

		if (!empty($count)) {
			return true;
		}
		return false;
	}
	public function ZmsIsRiskExists(){
		return is_dir(DISCUZ_ROOT.'./source/plugin/zhanmishu_risk');

	}
	static public function check_nationcode($nations,$intel_codes,$nationcode){
		if (empty($intel_codes) && empty($nations)) {
			return true;
		}

		if (!is_array($nations) || empty($nations) || !is_array($intel_codes) || empty($intel_codes)) {
			return false;
		}
		foreach ($nations as $value) {
			if ($nationcode == $value['2'] &&  in_array(strtolower($value[1]), $intel_codes)) {
				return true;
			}
		}
		return false;
	}
	public function sendpost($phone,$param='',$tid='',$nationcode='86'){
		global $_G;
		$nations = json_decode($this->config['smsconfig']['allCountries']);
		$intel_codes = $this->config['intel_codes'];

		if (!self::check_nationcode($nations,$intel_codes,$nationcode)) {
			$return = array('code'=>'-10','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','your nationcode is not allowed register')));
			return $return;
		}
		$isblack = C::t('#zhanmishu_sms#zhanmishu_sms')->check_isblask_mobile($phone);
		if ($isblack) {
			$return = array('code'=>'-9','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','mobile_is_in_blacklist')));
			return $return;
		}
		if ($this->config['is_area_limit'] && $this->config['area_limit']) {
			$area = $this->get_area_by_mobile($phone);
			if (strpos($this->config['area_limit'],$area['province']) === false) {
				$return = array('code'=>'-10','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','this_mobile_is_not_allow_in_area')));
				return $return;	
			}
		}

		$daymaxnum=C::t("#zhanmishu_sms#zhanmishu_sms")->fetch_day_num();
		$daymaxlimit = $this->config['daymaxlimit'] > 10 ? $this->config['daymaxlimit'] : 10;


		//check risk 
		if ($this->ZmsIsRiskExists()) {
			if (!class_exists('zhanmishu_risk',false)) {
				C::import('zhanmishu_risk','plugin/zhanmishu_risk/source/class');
			}
			$risk = new zhanmishu_risk();
			$risk_data = $risk->mobile_risk($phone);
			if ($risk->config['score'] <= $risk_data['score']) {
				$return = array('code'=>'-10','msg'=>$this->to_utf8(lang('plugin/zhanmishu_risk','mobile_need_change_because_risk')));
				return $return;	
			}

		}

		$tmp = array();
		$tmp = $this->auto_template($param,$tid,true);
		if (!$tmp) {
			return false;
		}

		if (strlen($phone) == 10 && strpos($phone,'09') === 0) {
			$tmp['api'] ='3';
		}

		if ($tmp['api'] == '1') {
			$param = json_encode($tmp['param']);
			//send alidayu api
			$c = new TopClient;
			$c->appkey = $this->appkey;
			$c->secretKey = $this->appsecret;
			$req = new AlibabaAliqinFcSmsNumSendRequest;
			$req->setExtend($phone);
			$req->setSmsType("normal");
			$req->setSmsFreeSignName($this->sign);
			$req->setSmsParam($param);
			$req->setRecNum($phone);
			$req->setSmsTemplateCode($this->templateid);
			$resp = $c->execute($req);
			$resp = daddslashes($this->resp_to_array($resp));

		}else if ($tmp['api'] == '2') {
			$smsbaosendurl = $this->smsbaosendurl.'&m='.$phone.'&c='.urlencode($this->signAddLeftRight().$tmp['templateintro']);
			$statusStr = array(
				"0" => lang('plugin/zhanmishu_sms', 'smsbaosendsuccess'),
				"-1" => lang('plugin/zhanmishu_sms', 'smsbaosenddataerror'),
				"-2" => lang('plugin/zhanmishu_sms', 'smsbaosendservernot_support'),
				"30" => lang('plugin/zhanmishu_sms', 'username_password_wrong'),
				"40" => lang('plugin/zhanmishu_sms', 'smsbaosendusernotexists'),
				"41" => lang('plugin/zhanmishu_sms', 'smsbaosendpleasecharge'),
				"42" => lang('plugin/zhanmishu_sms', 'smsbaosendpleaseuser_outofdate'),
				"43" => lang('plugin/zhanmishu_sms', 'smsbaosendpleaseiplimit'),
				"50" => lang('plugin/zhanmishu_sms', 'smsbaosendcontent_limit')
			);


			$r = dfsockopen($smsbaosendurl);
			$resp=array();
			if ($r == '0') {
				$resp['result']['err_code'] = '0';
				$resp['result']['success'] = '1';
			}else{
				$resp['code'] = $r;
				$resp['sub_msg'] = $statusStr[$r];
				$resp['msg'] = $statusStr[$r];
			}
		}else if ($tmp['api'] == '3') {

			$mitakeurl = $this->mitakeurl.'&dstaddr='.$phone.'&smbody='.urlencode(diconv($this->signAddLeftRight().$tmp['templateintro'],'UTF-8','BIG-5'));
			$statusStr = array(
				"0" => lang('plugin/zhanmishu_sms', 'sendsuccess'),
				"-1" => lang('plugin/zhanmishu_sms', 'data_error'),
			);
			$r = dfsockopen($mitakeurl);
			if (strpos($r,'statuscode=1')) {
				$issuccess = true;
			}
			$resp=array();
			if ($issuccess) {
				$resp['result']['err_code'] = '0';
				$resp['result']['success'] = '1';
			}else{
				$resp['code'] = '-1';
				$resp['sub_msg'] = $statusStr['-1'];
				$resp['msg'] = $statusStr['-1'];
			}
		}else if ($tmp['api'] == '4') { 
			
			$statusStr = array(
				"0" => lang('plugin/zhanmishu_sms', 'sendsuccess'),
				"-1" => lang('plugin/zhanmishu_sms', 'data_error'),
			);
			$data = array(
		        "uid"=>$this->config['zrsmsuser'],
		        "pwd"=>$this->config['zrsmspwd'],
		        "mobile"=>$phone,
		        "msg"=>$this->signAddLeftRight().$tmp['templateintro']
			);

			$r = $this->zrsms_posttohosts($this->zrsmsapi,$data);
			
			
			$resp=array();
			if (strpos($r, '0') === 0) {
				$resp['result']['err_code'] = '0';
				$resp['result']['success'] = '1';
			}else{
				$resp['code'] = '-1';
				$resp['sub_msg'] = $statusStr['-1'];
				$resp['msg'] = $statusStr['-1'];
			}
		}else if ($tmp['api'] == '6') {
			$statusStr = array(
				"0" => lang('plugin/zhanmishu_sms', 'sendsuccess'),
				"-1" => lang('plugin/zhanmishu_sms', 'data_error'),
			);
			$data = array(
		        "Uid"=>$this->config['webcnuid'],
		        "Key"=>$this->config['webcnkey'],
		        "smsMob"=>$phone,
		        "smsText"=>$tmp['templateintro'].$this->signAddLeftRight()
			);

			$r = $this->webchinses_posttohosts($this->webchinses,$data);
			$resp=array();
			if ($r == '1') {
				$resp['result']['err_code'] = '0';
				$resp['result']['success'] = '1';
			}else{
				$resp['code'] = '-1';
				$resp['sub_msg'] = $statusStr['-1'];
				$resp['msg'] = $statusStr['-1'];
			}
		}else if ($tmp['api'] == '7') {
			$statusStr = array(
				"0" => lang('plugin/zhanmishu_sms', 'sendsuccess'),
				"-1" => lang('plugin/zhanmishu_sms', 'data_error'),
			);
			$param = json_encode($tmp['param']);

			$appcode = $this->config['AppCode'];
		    $headers = array();
		    array_push($headers, "Authorization:APPCODE " . $appcode);

		    $data = array();
		    $data['ParamString'] = $param;
		    $data['RecNum'] = strval($phone);
		    $data['SignName'] = $this->sign;
		    $data['TemplateCode'] = $this->templateid;
		    $encoded = "";
	        while (list($k,$v) = each($data))
	        {
	                $encoded .= ($encoded ? "&" : "");
	                $encoded .= rawurlencode($k)."=".rawurlencode($v);
	        }
	        $querys = $encoded;
		    $bodys = "";
		    $url = $this->sendsmsapi . "?" . $querys;
		    $curl = curl_init();
		    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
		    curl_setopt($curl, CURLOPT_URL, $url);
		    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		    curl_setopt($curl, CURLOPT_FAILONERROR, false);
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($curl, CURLOPT_HEADER, false);
		    if (1 == strpos("$".$host, "https://"))
		    {
		        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		    }
		    $resp = json_decode(curl_exec($curl),true);
			if ($resp['success'] == true) {
				$resp['result']['err_code'] = '0';
				$resp['result']['success'] = '1';
			}else{
				$resp['code'] = '-1';
				$resp['sub_msg'] = $resp['message'];
				$resp['msg'] = $resp['message'];
			}			
		}else if ($tmp['api'] == '8') {
		    $accessKeyId = $this->config['accessKeyId'];//参考本文档步骤2
		    $accessKeySecret = $this->config['accessKeySecret'];//参考本文档步骤2
		    //短信API产品名
		    $product = "Dysmsapi";
		    //短信API产品域名
		    $domain = "dysmsapi.aliyuncs.com";
		    //暂时不支持多Region
		    $region = "cn-hangzhou";
		    //初始化访问的acsCleint
		    $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
		    DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", $product, $domain);
		    $acsClient= new DefaultAcsClient($profile);
		    $request = new SendSmsRequest;
		    //必填-短信接收号码。支持以逗号分隔的形式进行批量调用，批量上限为20个手机号码,批量调用相对于单条调用及时性稍有延迟,验证码类型的短信推荐使用单条调用的方式
		    $request->setPhoneNumbers($phone);
		    //必填-短信签名
		    $request->setSignName($this->sign);
		    //必填-短信模板Code
		    $request->setTemplateCode($this->templateid);
		    //选填-假如模板中存在变量需要替换则为必填(JSON格式)
		    $request->setTemplateParam($param = json_encode($tmp['param']));
		    //选填-发送短信流水号
		  //  $request->setRegionId($region);
		    // $request->setOutId("1234");
		    //发起访问请求

		    $acsResponse = $acsClient->getAcsResponse($request);

			if ($acsResponse->Code == 'OK') {
				$resp['result']['err_code'] = '0';
				$resp['result']['success'] = '1';
			}else{
				$resp['code'] = '-1';
				$resp['sub_msg'] =$acsResponse->Code;
				$resp['msg'] = $acsResponse->Message;
			}

		}else if ($tmp['api'] == '9') {

			$message = $this->signAddLeftRight().$tmp['templateintro'];
			$qc = new qcloud_sms($this->config['sdkappid'],$this->config['qq_appkey']);
			$phone = str_replace('+'.$nationcode, '', $phone);
			$nationcode = $nationcode ? $nationcode : 86;
			$result = json_decode($qc->send(0, $nationcode, $phone, $message, "", ""),true);

			if ($result['result'] == '0' && $result['errmsg'] == 'OK') {
				$resp['result']['err_code'] = '0';
				$resp['result']['success'] = '1';
			}else{
				$resp['code'] = $result['result'];
				$resp['sub_msg'] = $result['errmsg'];
				$resp['msg'] = $result['errmsg'];
			}

		}else if ($tmp['api'] == '10') {
		    $accessKeyId = $this->config['accessKeyId'];//参考本文档步骤2
		    $accessKeySecret = $this->config['accessKeySecret'];//参考本文档步骤2
		    $Endpoint = $this->config['Endpoint'];
		    //$Endpoint = 'http://34001808.mns.cn-hangzhou.aliyuncs.com/';
		    $topicName = $this->config['topicName'];
		    //$topicName = 'sms.topic-cn-hangzhou';

		    $intance = new PublishBatchSMSMessage($accessKeyId,$accessKeySecret,$Endpoint);

		    $resp = $intance->run($phone,$topicName,$this->sign,$this->templateid,json_encode($tmp['param']));
		    
		    if (!$resp['code']) {
		    	$resp['sub_msg'] = $resp['msg'];
		    	$resp['code'] = '-1';
		    }else{
		    	$resp['result']['err_code'] = '0';
				$resp['result']['success'] = '1';
		    }
		}

			

		return $resp;
	}

	public function signAddLeftRight($sign=''){
		$sign = $sign ? $sign : $this->sign;

		return $this->to_utf8(lang('plugin/zhanmishu_sms','signleft')).$this->sign.$this->to_utf8(lang('plugin/zhanmishu_sms','signright'));
	}

	public function auto_template($param,$tid,$isReturnTemplateIntro,$isAutoToUtf8=true){
		global $_G;
		if (!class_exists('zhanmishu_template',false)) {
			/*www-Cgzz8-com*/include_once DISCUZ_ROOT.'source/plugin/zhanmishu_sms/include/zhanmishu_template.php';
		}
		$template = new zhanmishu_template(); 
		$templatesvar = $template->get_templatevar_config();

		$tid = $tid ? $tid : $this->type;

		$tmp = $templatesvar['templates'][$tid];
		$tmp['templateintro'] = $this->to_utf8($tmp['templateintro']);
		$tmp['sign'] = $this->to_utf8($tmp['sign']);

		foreach ($templatesvar['vars'] as $key => $value) {
			$templatesvar['vars'][$key] = $this->to_utf8($value);
		}



		$this->sign = $tmp['sign'] ? $tmp['sign'] : $this->sign;
		$this->templateid = $tmp['templateid'] ? $tmp['templateid'] : $this->templateid;

		if (!$tmp['templateintro'] && !$tmp['templateid']) {
			return false;
		}
		$pattern = "/\Q$\E\{(\w+)\}/";
		preg_match_all($pattern,$tmp['templateintro'],$matches);
		if (!is_array($param)) {
			$param = json_decode($param,true);
		}else{
			if ($isAutoToUtf8) {
				foreach ($param as $key => $value) {
					$param[$key] = $this->to_utf8($value);
				}	
			}		
		}
		foreach ($matches[1] as $key => $value) {
				$issystem = preg_match($pattern, $templatesvar['vars'][$value]);
				if (array_key_exists($value, $param) && $param[$value]) {
					$str = $param[$value];
				}else if (!$issystem) {
					$param[$value] = $templatesvar['vars'][$value];
					$str = $templatesvar['vars'][$value];
				}else{
					switch ($value) {
						case 'username':
							$str = $param['username'] ? $param['username'] : $_G['username'];
							break;
						case 'code':
							$str = $param['code'] = $param['code'];
							break;
						case 'time':
							$str = $param['time'] = $param['time'] ? $param['time'] : date("Y-m-d",TIMESTAMP);
							break;
						default:
							break;
					}
					
				}
				if ($isReturnTemplateIntro) {
					$tmp['templateintro'] = str_replace($matches[0][$key], $str, $tmp['templateintro']);
				}
		}
		if ($tmp['api'] == '8') {
			foreach ($param as $key => $value) {
				if (!$value) {
					unset($param[$key]);
				}
			}
		}
		$tmp['param'] = $param;
		return $tmp;
	}

	public function webchinses_posttohosts($url, $data)
	{
		if (!$url) {
			return false;
		}
        $encoded = "";
        while (list($k,$v) = each($data))
        {
                $encoded .= ($encoded ? "&" : "");
                $encoded .= $k."=".$v;
        }
        $url .= $encoded;
        if (function_exists('curl_init')) {
        	return $this->Curl($url);
        }else{
        	return dfsockopen($url,'10');
        }
        
	        
	}
	public function zrsms_posttohosts($url, $data)
	{
		if (!$url) {
			return false;
		}
        $encoded = "";
        while (list($k,$v) = each($data))
        {
                $encoded .= ($encoded ? "&" : "");
                $encoded .= rawurlencode($k)."=".rawurlencode($v);
        }
        return dfsockopen($url,'10',$encoded);
	        
	}

	public function get_carrier_by_mobile($mobile){
		if ((strpos($mobile,'+') !== false) && (strpos($mobile,'+86') === false)) {
			return false;
		}
		$area = $this->get_area_by_mobile($mobile,true);
		if (!empty($area)) {
			return $area['carrier'];
		}
		return '';
	}

	public function get_area_by_mobile($mobile,$isupdatearea=false){
		if ((strpos($mobile,'+') !== false) && (strpos($mobile , '+86') === false)) {
			return false;
		}

		if (!$this->verify_mobile_number($mobile)) {
			return false;
		}

		$mobiletmp = str_replace('+86', '', $mobile);
		$mts = substr($mobiletmp, 0,7);
		$ismts = C::t("#zhanmishu_sms#zhanmishu_sms")->get_mts_exists($mts);
		if (is_array($ismts)) {
			$ismts['telstring'] = $mobile;
			return $ismts;
		}
		$checkurl = $this->addresscheckurl.$mobiletmp;
		$r = dfsockopen($checkurl, $limit = 0, '', '', FALSE, '', 15, TRUE, 'URLENCODE',  TRUE,  0);
		$r = $this->gbk_to_charset($r);
		preg_match_all("/\'(.*)\'/", $r, $data);
		if (count($data[1]) !== 7) {
			return false;
		}
		$data = $data[1];
		$return = array();
		$return['mts'] = $data['0'];
		$return['province'] = $data['1'];
		$return['catname'] = $data['2'];
		$return['telstring'] = $mobile;
		$return['areavid'] = $data['4'];
		$return['ispvid'] = $data['5'];
		$return['carrier'] = $data['6'];
		$return = daddslashes($return);

		if ($isupdatearea) {
			C::t("#zhanmishu_sms#zhanmishu_sms")->update_area($return);
		}
		return $return;
	}

	public function fetch_day_phone($phone){
		return C::t("#zhanmishu_sms#zhanmishu_sms")->fetch_day_phone($phone);
	}

	public function sendsms($phone,$code,$verify='',$nationcode='86'){
		global $_G;
		if (!$phone) {
			$return = array('code'=>'-2','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','phone_isnot_exists')));
			return $return;
		}
		$ip_num = C::t("#zhanmishu_sms#zhanmishu_sms")->fetch_day_ip($_G['clientip']);
		$phone_num = $this->fetch_day_phone($phone);

		if ($ip_num > $this->iplimit || $phone_num > $this->timeslimit) {
			$return = array('code'=>'-1','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','too_offen')));
			return $return;
		}

		if (!$this->verify_mobile_number($phone)) {
			$return = array('code'=>'-9','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','wrongmobile_number')));
			return $return;
		}

		$is_register = $this->ismobilelimit && $this->ismobile_register($phone);
		if ($is_register) {
			$return = array('code'=>'-2','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','have_register')));
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
			if ($_G['uid']) {
				$return['uid'] = $_G['uid'];
			}

			// if ($nationcode) {
			// 	$return['nationcode'] = $nationcode;
			// }

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

	public function resp_to_array($resp){
		$resp = (array)$resp;
		if (isset($resp['result'])) {
			$resp['result'] = (array)$resp['result'];
		}

		return $resp;
	}

	public function getverify_life(){
		return $this->verify_life;
	}

	public function verify_mobile_number($phone){
		$phone = str_replace('+86', '', $phone);
		$config = $this->config;
		if (!preg_match($config['mobilerule'], $phone)) {
			return false;
		}
		return true;
	}
	public function auto_to_utf8($data){
		if (!is_array($data)) {
			return diconv($data,CHARSET,'UTF-8');
		}else if (is_array($data)) {
			$tmp = array();
			foreach ($data as $key => $value) {
				$nkey = diconv($key,CHARSET,'UTF-8');
				$nvalue = $this->auto_to_utf8($value);
				$tmp[$nkey] = $nvalue;
			}
			return $tmp;
		}

	}
	public function to_utf8($str=''){
		return diconv($str,CHARSET,'UTF-8');
	}

	public function gbk_to_charset($str=''){
		return diconv($str,'gbk',CHARSET);
	}

	public function diconv_back($str=''){
		return diconv(strval($str),'UTF-8', CHARSET);
	}

	public function clear_send_coolie($cookiehead=''){
		global $_G;
		if (!$cookiehead) {
			$cookiehead = $this->cookiehead;
		}
		if (!empty($_G['cookie'])) {
			foreach ($_G['cookie'] as $key => $value) {
				if (strpos($key,$cookiehead) !== false) {
					dsetcookie($key, '', -1);
				}
			}
		}

		return ;
	}

	public function verify(){
		if (strlen($this->verify) < 6) {
			$return = array('code'=>'-1','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','data_error')));
			return $return;
		}
		$cookieverify = getcookie($this->cookiehead.$this->code);
		
		$cookieverify_arr = $this->get_verify_array();
		if (!is_array($cookieverify_arr)) {
			$return = array('code'=>'-1','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','data_error')));
			return $return;
		}

		$sid = $cookieverify_arr['sid'];
		$sms = C::t("#zhanmishu_sms#zhanmishu_sms")->fetch($sid);
		if ($sms['nums'] > $this->maxnums) {
			$return = array('code'=>'-5','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','too_offen')));
			return $return;
		}else if($sms['uid'] > 0 && $this->type=='1'){
			$return = array('code'=>'-6','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','is_used')));
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

		$return = array('code'=>'1','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','success')));
			return $return;
	}

	public function get_verify_array(){
		global $_G;
		$cookieverify = getcookie($this->cookiehead.$this->code);
		if (!$cookieverify) {
			return false;
		}
		$verify_json = authcode($cookieverify,'DECODE',$_G['config']['security']['authkey']);
		$verify_arr = json_decode($verify_json,1);
		if (empty($verify_arr)) {
			return false;
		}
		return $verify_arr;
	}

	public function get_ture_verify(){
		$verify = $this->get_verify_array();
		return isset($verify['verify'])?$verify['verify']:false;
	}
	public function get_sid(){
		$verify = $this->get_verify_array();
		return isset($verify['sid'])?$verify['sid']:false;
	}
	public function get_mobile_number(){
		$verify = $this->get_verify_array();
		return isset($verify['phone'])?$verify['phone']:false;
	}

	public function get_smses($start, $limit=50, $sort = 'desc'){
		$smses = C::t("#zhanmishu_sms#zhanmishu_sms")->range($start, $limit, $sort);
		return $smses;
	}

	public function get_type_smses($start, $limit=50, $sort = 'desc',$type,$fieldarray=array()){
		$smses = C::t("#zhanmishu_sms#zhanmishu_sms")->get_type_smses($start, $limit, $sort,$type,$fieldarray);
		return $smses;
	}
	public function mobile_register($user){
		global $_G;

		$verify = $this->verify();
		if ($verify['code'] < '1') {
			return $verify;
		}
		if ($user['mobile'] !== $this->get_mobile_number()) {
			return array('code'=>'-1','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','data_error')));
		}
		loaducenter();
		$user['email'] = $this->get_rand_email();
		$uid = uc_user_register($user['username'], $user['passwd'], $user['email']);

		if ($uid < 1) {
			return array('code'=>$uid,'msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','username_not_vailid')));
		}
		if ($uid > 0) {
			$ip=$_G['clientip'];
			$groupid = isset($this->$config['groupid']) && $this->$config['groupid'] ? $this->$config['groupid'] : 10;
			C::t('common_member')->insert($uid, $user['username'], md5(random(10)), $user['email'], $ip, $groupid, null);
			$result = uc_user_login($user['username'],$user['passwd'],0);

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
				C::t('#zhanmishu_sms#zhanmishu_sms')->update($this->get_sid(),array('uid'=>$_G['uid'],'isregsuccess'=>'1','ismobilereg'=>'1'));
			}
			$this->clear_send_coolie();
			return array('code'=>'1','msg'=>''.
						'setTimeout("window.location.href =\''.$href.'\';", 3000);'.
						'$(\'succeedmessage_href\').href = \''.$href.'\';'.
						'$(\'main_message\').style.display = \'none\';'.
						'$(\'main_succeed\').style.display = \'\';'.
						'$(\'succeedlocation\').innerHTML = \''.lang('message', $loginmessage, $param).'\';');
		}

		return array('code'=>'-1','msg'=>$this->to_utf8(lang('plugin/zhanmishu_sms','verify_error')));
	}

	public function get_rand_email(){
		$email = 'a'.$this->get_rand_str().date('ymd',TIMESTAMP).$this->randemail;
		return $email;
	}

	public function get_rand_str(){
		$str = "0123456789abcdefghijklmnopqrstuvwxyz";
		$n = 8;
		$len = strlen($str)-1;
	    for($i=0 ; $i<$n; $i++){
	        $s .= $str[rand(0,$len)];
	    }
		return $s;		
	}
	public function ismobile_register($mobile){
		$user = DB::fetch_first('select uid,mobile from %t where mobile = '.$mobile,array('common_member_profile'));
		if (empty($user)) {
			return false;
		}else{
			return true;
		}
	}
	public function get_usermobile(){
		return $usermobile = getuserprofile('mobile');
	}
	public function Curl($url){
		$_G;
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //不验证证书
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30); 
		curl_setopt ($ch, CURLOPT_REFERER, $_G['siteurl']);
		$resultj = curl_exec($ch);
		curl_close($ch); 

		return json_decode($resultj,true);
	}
	public function str_line_toarray($str){
		$str = str_replace(array("\r\n", "\r", "\n"), '####', $str);
		$str = str_replace('########', '####', $str);
		$arr = array();
		$arr = explode('####', $str);
		$arr = array_unique($arr);
		foreach ($arr as $key => $value) {
			if (!$value) {
				unset($arr[$key]);
			}
		}
		return $arr;
	}
	public function getuidbymobile($mobile){
		$verifytype = get_verify_id();
		if (!$verifytype) {
			return false;
		}

		if ($this->checkqianfan_exists()) {
			$user = DB::fetch_first('select uid from %t where phone = '.$mobile,array('phonebind'));
			if (!empty($user)) {
				return $user['uid'];
			}
		}

		$users = DB::fetch_all('select uid from %t where mobile = '.$mobile,array('common_member_profile'),'uid');
		if (empty($users)) {
			return false;
		}
		if (count($users) == 1) {
			$user = current($users);
			return $user['uid'];
		}
		if (count($users) > 1) {
			$uids = array_keys($users);
			$uids = implode(',', $uids);
			$where = ' where uid in ('.$uids.') and verify'.$verifytype.' = 1';
			$user = DB::fetch_first('select * from %t '.$where,array('common_member_verify'));
			return $user['uid'];
		}

		return false;
	}



}

