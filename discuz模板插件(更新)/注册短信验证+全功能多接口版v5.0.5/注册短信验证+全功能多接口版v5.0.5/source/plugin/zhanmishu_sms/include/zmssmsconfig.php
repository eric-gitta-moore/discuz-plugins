<?php
/**
 *      [Caogen8!] (C)2014-2018 Www.Caogen8.co.
 *      Ğ¡²İ¸ù(QQ£º2575163778) wWw.Caogen8.co
 *
 *      Author: CAOGEN8.CO $
 *		qq:2575163778 $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$smsconfig=array(
	'apis'=>array(
		'1'=>array('name'=>lang('plugin/zhanmishu_sms', 'alidayu'),'default'=>'0'),
		'2'=>array('name'=>lang('plugin/zhanmishu_sms', 'smsbao'),'default'=>'0'),
		'3'=>array('name'=>lang('plugin/zhanmishu_sms', 'taiwan_sanzhu'),'default'=>'0'),
		'4'=>array('name'=>lang('plugin/zhanmishu_sms', 'zhanxintong'),'default'=>'0'),
		'6'=>array('name'=>lang('plugin/zhanmishu_sms', 'webchinses'),'default'=>'0'),
		'5'=>array('name'=>lang('plugin/zhanmishu_sms', 'mydevelop'),'default'=>'0'),
		'7'=>array('name'=>lang('plugin/zhanmishu_sms', 'aliyunsms'),'default'=>'0'),
		'8'=>array('name'=>lang('plugin/zhanmishu_sms', 'alismsapi'),'default'=>'1'),
		'10'=>array('name'=>lang('plugin/zhanmishu_sms', 'ali_message_smsapi'),'default'=>'0'),
		'9'=>array('name'=>lang('plugin/zhanmishu_sms', 'qcloudsms'),'default'=>'0')),
	'types'=>array(
		'1'=>array('name'=>lang('plugin/zhanmishu_sms', 'user_register'),'default'=>'0'),
		'2'=>array('name'=>lang('plugin/zhanmishu_sms', 'user_verify'),'default'=>'0'),
		'3'=>array('name'=>lang('plugin/zhanmishu_sms', 'user_getpasswd'),'default'=>'0'),
		'4'=>array('name'=>lang('plugin/zhanmishu_sms', 'smsnotice'),'default'=>'0'),
		'5'=>array('name'=>lang('plugin/zhanmishu_sms', 'smsgroupnotice'),'default'=>'0'),
		'6'=>array('name'=>lang('plugin/zhanmishu_sms', 'sms_sce_verify'),'default'=>'0'),
		),
	'protecttypes'=>array('1','2','3','4','6'),
	'protectvars'=>array('1','2','3','4')
);
