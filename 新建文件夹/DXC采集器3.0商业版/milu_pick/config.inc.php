<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
loadcache('plugin');
if(!defined('DEBUG_MODE')) define('DEBUG_MODE', $_G['cache']['plugin']['milu_pick']['show_error']);
if(DEBUG_MODE){
	ini_set("display_errors", "On");
	error_reporting(E_ALL);
	//error_reporting(E_ERROR);
}
if($_GET['inajax']) ob_start();
ini_set('max_execution_time', '0');
ini_set('pcre.backtrack_limit', 10000000);//正则最大字符串限制
set_time_limit(0);
ob_implicit_flush();
if($_GET['inajax']) ob_end_flush();
define('GBK', strtoupper(CHARSET) == 'GBK');
define('PICK_DIR', DISCUZ_ROOT.'source/plugin/milu_pick');
define('PICK_CACHE', PICK_DIR.'/data/cache');
define('PICK_URL', $_G['siteurl'].'source/plugin/milu_pick/');
define('PICK_PATH', DISCUZ_ROOT.'source/plugin/milu_pick');
define('WRAP', strtoupper(substr(PHP_OS, 0, 3)) == 'WIN' ? "\r\n" : "\n");
loadcache('milu_pick');
if( (!($my_pick_info = $_G['cache']['milu_pick']) ) || ( $_G['cache']['milu_pick']['version'] != $_G['setting']['plugins']['version']['milu_pick'] ) ){
	$my_pick_info = DB::fetch_first("SELECT * FROM ".DB::table('common_plugin')." WHERE identifier='milu_pick'");
	save_syscache('milu_pick', $my_pick_info);
}
define('PICK_ID', $my_pick_info['pluginid']);

define('PICK_VERSION', $my_pick_info['version']);//版本号
define('PICK_GO', 'action=plugins&operation=config&do='.PICK_ID.'&identifier=milu_pick&pmod=');
define('PICK_CACHE_SIZE', 40);//缓冲区最大空间 单位MB 超过指定大小将全部清空缓存
define('PICK_ENABLE_CACHE', FALSE);//是否批量采集时候开启缓存？ TRUE代表开启 

$article_status =  array(
	'0' => lang('plugin/milu_pick', 'all'),
	'1' => lang('plugin/milu_pick', 'no_import'),
	'2' => lang('plugin/milu_pick', 'imported'),
	'3' => lang('plugin/milu_pick', 'trash'),
	'4' => lang('plugin/milu_pick', 'timing')
	
);


$pick_config = array(
	'pick_num' => 10,//默认的每批采集数
	'time_out' => 10,//超时时间
	'max_redirs' => 2,
	'ask_mode' => 1,//问答模式 内容获取不到的话，内容=标题
	'index_localtion_cache_time' => 3600 ,//本地查询无结果索引过期时间
	'index_server_cache_time' => 3600,//服务端查询无结果索引过期时间
	'evo_index_server_cache_time' => 3600,//智能学习规则服务端索引过期时间
	'is_big' => 0,//是否在utf-8环境下将繁体转换成简体，因为自动判断的代价太高了，改为手动 1为开启 0关闭
	'max_memory_per' => '90%',//最大内存占用百分比，超过这个内存限制，自动停止采集
);

$evo_rules = array(

		'no_title' => array(//不允许的标题
			'403 Forbidden',
			'404 Not Found',
		),
		'no_url' => array(//不允许的网址
			'javascript:',
			'sendpwd',
			//'/:80',
			'login',
			'mod=register',
			'mod=ranklist',
			'/uid-',
			'/username-',
			'?mod=rss&',
		),

);
$system_rules = array(
	'1' => lang('plugin/milu_pick', 'bbs'),
	'2' => lang('plugin/milu_pick', 'article'),
	//'3' => '图集'
);

$long_text = array(
	'网址','地址','网站名称',
);

$filter_html = array(
	'0' => array(
		'name' => lang('plugin/milu_pick', 'link').'<a',
		'search' => 'a',
	),
	'1' => array(
		'name' => lang('plugin/milu_pick', 'table').'<table',
		'search' => 'table',
	),
	'2' => array(
		'name' => lang('plugin/milu_pick', 'table_tr').'<tr',
		'search' => 'tr',
	),
	'3' => array(
		'name' => lang('plugin/milu_pick', 'table_td').'<td',
		'search' => 'td',
	),
	'4' => array(
		'name' => lang('plugin/milu_pick', 'html_p').'<p',
		'search' => 'p',
	),
	'5' => array(
		'name' => lang('plugin/milu_pick', 'html_font').'<font',
		'search' => 'font',
	),
	'6' => array(
		'name' => lang('plugin/milu_pick', 'html_div').'<div',
		'search' => 'div',
	),
	'7' => array(
		'name' => '<span',
		'search' => 'span',
	),
	'8' => array(
		'name' => lang('plugin/milu_pick', 'table_tbody').'<tbody',
		'search' => 'tbody',
	),
	'9' => array(
		'name' => lang('plugin/milu_pick', 'html_img').'<img',
		'search' => 'img',
	),
	
	'10' => array(
		'name' => lang('plugin/milu_pick', 'html_b').'<b<strong',
		'search' => 'b|strong',
	),

	'11' => array(
		'name' => lang('plugin/milu_pick', 'html_br').'<br>',
		'search' => '<br>',
		'flag' => 1,
	),

	'12' => array(
		'name' => lang('plugin/milu_pick', 'html_nbsp').'&nbsp;',
		'search' => '&nbsp;',
		'flag' => 1,
	),
	'13' => array(
		'name' => 'H'.lang('plugin/milu_pick', 'label').'<h1-7',
		'search' => 'h1|h2|h3|h4|h5|h6|h7',
	),
	'14' => array(
		'name' => 'hr'.lang('plugin/milu_pick', 'label').'<hr>',
		'search' => 'hr',
		'flag' =>1,
	),
	'15' => array(
		'name' => lang('plugin/milu_pick', 'html_form').'<form',
		'search' => 'form',
	),
	/*
	'16' => array(
		'name' => lang('plugin/milu_pick', 'html_frame').'<iframe<frame',
		'search' => 'iframe|frame',
	),
	*/
	'17' => array(
		'name' => lang('plugin/milu_pick', 'html_li').'<li<ul<dd<dt<dl',
		'search' => 'li|ul|dd|dt',
	),
	'18' => array(
		'name' => lang('plugin/milu_pick', 'html_sub').'<sub<sup',
		'search' => 'sub|sup',
	),
	'19' => array(
		'name' => lang('plugin/milu_pick', 'html_form_label').'<input<select<textarea<label<option<button',
		'search' => 'input|select|textarea|label|option|button',
		'no_show' => 1,
	),
	/*
	'20' => array(
		'name' => lang('plugin/milu_pick', 'html_script').'<script',
		'search' => 'script',
	),
	*/
	'21' => array(
		'name' => '<object<embed<param',
		'search' => 'object|embed',
		'no_show' => 1,
	),

);


//图片获取
$evo_img = array(
	'*none.gif' => 'file',//discuz 论坛  //意思就是当图片的src属性包含none.gif时，尝试获取file属性
	'*bbsLoading.jpg' => 'src2',//太平洋网络
	'*imgloading.gif' => 'original',//天涯论坛
	'*txt.mop.com' => 'data-original',//猫扑论坛
	'*blog.sina.com.cn/s/' => 'real_src ',//新浪博客(real_src 右边有空格)
	'*sg_trans.gif' => 'real_src ',//新浪博客(real_src 右边有空格)
);

//图片路径包含以下字符就检查本地是否有相应的文件,否则转换成远程路径,但不本地化。
$evo_img_no = array(
	'static/image/smiley/' ,//discuz默认表情
	'piccache3.soso.com/face',//搜搜图片
	'cache.soso.com/img/',
	'emot/em',
	'static/image/common',
	'static/image/filetype/',
);

$c_evo_img_no = explode(WRAP, trim($_G['cache']['plugin']['milu_pick']['evo_img_no']));
$c_evo_img = explode(WRAP, trim($_G['cache']['plugin']['milu_pick']['evo_img']));

foreach((array)$c_evo_img as $k => $v){
	$v_arr = explode('@@', trim($v));
	unset($c_evo_img[$k]);
	$c_evo_img[$v_arr[0]] = $v_arr[1];
}

$c_evo_img_no = $c_evo_img_no ? $c_evo_img_no : array();
$c_evo_img = $c_evo_img ? $c_evo_img : array();
$evo_img = array_merge($evo_img, $c_evo_img);
$evo_img_no = array_merge($evo_img_no, $c_evo_img_no);
$evo_img = array_filter($evo_img);
$evo_img_no = array_filter($evo_img_no);
$env_arr = array('article_status', 'pick_config', 'evo_rules', 'system_rules', 'long_text', 'filter_html', 'evo_img', 'evo_img_no');

foreach((array)$env_arr as $v){
	$evn_milu_pick[$v] = $$v;
}

loadcache('evn_milu_pick');
if(!$_G['cache']['evn_milu_pick'] || $evn_milu_pick != $_G['cache']['evn_milu_pick']){
	save_syscache('evn_milu_pick', $evn_milu_pick);
}


if(!defined('DISCUZ_VERSION')) require_once(DISCUZ_ROOT.'/source/discuz_version.php');
require_once(PICK_DIR.'/version.php');
require_once(PICK_DIR.'/lib/function.global.php');
?>