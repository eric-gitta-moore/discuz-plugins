<?php
/**
 *      [Caogen8!] (C)2014-2018 Www.Caogen8.co.
 *      小草根(QQ：2575163778) wWw.Caogen8.co
 *
 *      Author: CAOGEN8.CO $
 *      qq:2575163778 $
 */

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class Autoloader{
  
  /**
     * 类库自动加载，写死路径，确保不加载其他文件。
     * @param string $class 对象类名
     * @return void
     */
    public static function autoload($class) {
        $name = $class;
        if(false !== strpos($name,'\\')){
          $name = strstr($class, '\\', true);
        }

        $filename = DISCUZ_ROOT.'source/plugin/zhanmishu_sms/include'."/top/".$name.".php";
        if(is_file($filename)) {
            include $filename;
            return;
        }

        $filename = DISCUZ_ROOT.'source/plugin/zhanmishu_sms/include'."/top/request/".$name.".php";
        if(is_file($filename)) {
            include $filename;
            return;
        }

        $filename = DISCUZ_ROOT.'source/plugin/zhanmishu_sms/include'."/top/domain/".$name.".php";
        if(is_file($filename)) {
            include $filename;
            return;
        }

        $filename = DISCUZ_ROOT.'source/plugin/zhanmishu_sms/include'."/aliyun/".$name.".php";
        if(is_file($filename)) {
            include $filename;
            return;
        }

        $filename = DISCUZ_ROOT.'source/plugin/zhanmishu_sms/include'."/aliyun/request/".$name.".php";
        if(is_file($filename)) {
            include $filename;
            return;
        }

        $filename = DISCUZ_ROOT.'source/plugin/zhanmishu_sms/include'."/aliyun/domain/".$name.".php";
        if(is_file($filename)) {
            include $filename;
            return;
        }         
    }
}


if (version_compare(phpversion(),'5.3.0','>=')) {
    spl_autoload_register('Autoloader::autoload',false,true);
}else{
    Autoloader::autoload("zhanmishu_sms");
    Autoloader::autoload("TopClient");
    Autoloader::autoload("TopLogger");
    Autoloader::autoload("SendSms");
    Autoloader::autoload("AlibabaAliqinFcSmsNumSendRequest");
    Autoloader::autoload("ResultSet");
    Autoloader::autoload("AliyunClient");
    Autoloader::autoload("HttpdnsGetRequest");
    Autoloader::autoload("RequestCheckUtil");
    Autoloader::autoload("DefaultProfile");
}

//From:www_caogen8_co
?>