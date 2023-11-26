<?php
/**
 *      [Caogen8!] (C)2014-2018 Www.Caogen8.co.
 *      ะกฒÝธ๙(QQฃบ2575163778) wWw.Caogen8.co
 *
 *      Author: CAOGEN8.CO $
 *      qq:2575163778 $
 */

/*www-Cgzz8-com*/include_once DISCUZ_ROOT.'source/plugin/zhanmishu_sms/include/zhanmishu_getpassword.php';
class sendSms {
    protected $config;
    public function __construct(){
        /*www-Cgzz8-com*/include_once DISCUZ_ROOT.'source/plugin/zhanmishu_sms/include/function.php';
        $this->config = getconfig();
    }
    public function sendCode($mobile, $code, $act){
        $re = array();
        switch ($act) {
            case 'register':
                $sendsms = new zhanmishu_sms($this->config);
                $re = $sendsms->sendsms($mobile, '999999', $code);
                break;
             case 'getpwd':
                $sendsms = new zhanmishu_getpassword($this->config);
                $re = $sendsms->sendsms('',$mobile,'999999',$code,true);
                break;           
            default:
                $re = array('code'=>'-5','msg'=>'nomsg');
                break;
        }

        $return = array();
        $return['rs'] = $re['code'] > 0 ? '1' : '0';
        $return['msg'] = $re['msg'];
        return $return;
    }

}

//From:www_caogen8_co
?>