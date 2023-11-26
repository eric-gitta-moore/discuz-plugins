<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if(!defined('V_D')) {
	exit('error:V_D no define!');
}
define('VIP', strexists(strtolower(PICK_VERSION), 'vip') ? TRUE : FALSE);
define('GET_URL', 'http://www.56php.com/');

if(VIP) pload('F:vip');

function get_client_info(){
	global $_G;
	require_once libfile('function/misc');
	if(strtoupper(convertip($_G['clientip'])) == '- LAN') return FALSE;
	$re['siteurl'] = $_G['siteurl'];
	$re['domain'] = get_domain($re['siteurl']);
	if(!$re['domain']) return FALSE;
	$re['sitename'] = $_G['setting']['bbname'];
	$re['dxc_version'] = PICK_VERSION;
	$re['dxc_release'] = V_D;
	$re['discuz_version'] = DISCUZ_VERSION;
	$re['discuz_release'] = DISCUZ_RELEASE;
	return $re;
}

function GetHostInfo($gurl){
    $gurl = preg_replace("/^http:\/\//i", "", trim($gurl));
    $garr['host'] = preg_replace("/\/(.*)$/i", "", $gurl);
    $garr['query'] = "/".preg_replace("/^([^\/]*)\//i", "", $gurl);
    return $garr;
}


//输出头部
function pick_header_output($header_arr, $head_url = '', $args = array()){
	global $header_config,$head_url;
	$myac = $_GET['myac'];
	if(!$myac) $myac = $header_arr[0];
	$str = '<div class="itemtitle"><ul class="tab1" style="margin-top:8px;">';
	foreach($header_arr as $k => $v){	
		$current = $v == $myac || $args['current'] == $v ? 'class="current"' : ''; 
		$str .= '<li '.$current.'><a href="'.$head_url.$v.'"><span>'.milu_lang($v).'</span></a></li>';
	}
	$str .='</ul></div>';
	return $str;
}


function get_user_pick_info(){
	$c_info = get_client_info();
	$url = GET_URL.'plugin.php?id=pick_user:pick_user&myac=auth&detail=1&domain='.urlencode($c_info['domain']).'&siteurl='.urlencode($c_info['siteurl']).'&dxc_version='.PICK_VERSION.'&discuz_version='.DISCUZ_VERSION.'&discuz_release='.DISCUZ_RELEASE.'&dxc_release='.V_D.'&sitename='.urlencode($c_info['sitename']);
	return get_contents($url, array('cache' => -1));
}


function get_user_level(){
	global $_G;
	$status = 0;
	$name = milu_lang('free_user');
	$file_name =  PICK_DIR.'/data/pick_auth.txt'; 
	$msg_arr = array(); 
	$vip_show = '<img  border="0" src="'.PICK_URL.'/static/image/vip.gif" /> '.milu_lang('vip_user').' ';
	
	$msg_arr = get_user_pick_info();
	if($msg_arr < 0){
		$status = -1;
		$name = milu_lang('no_query_info');
	}
	$web_qq = get_contents(GET_URL.'plugin.php?id=pick_user:upgrade&myac=get_qq&tpl=no', array('cache' => 3600*24*2) ); 
	$msg_arr = unserialize($msg_arr);
	extract($msg_arr);
	$show_use_time = $exp_dateline ? " ".milu_lang('no_user_dateline').":<font style='color:#09C'>".dgmdate($exp_dateline).'</font>' : '';
	if($msg == 'succeed'){
		dsetcookie('pick_auth', $msg, -1);
		$show_use_time = $show_use_time ? $show_use_time : milu_lang('forever_use');
		$name = $vip_show.$show_use_time;
		$status = 1;
	}else if($msg == 'timeout'){
		@unlink($file_name);
		$name = milu_lang('no_free_use');
		$status = -2;
	}else if($msg == 'free' || $msg == 'first'){//如果是免费版本
		if(VIP){
			$status = 2;
			$name = milu_lang('free_use').' '.$show_use_time;
		}		
	}else{
		$status = -3;
		if($msg == 'error'){
			$why = milu_lang('lan_network');
		}else{
			$why = milu_lang('no_conn_server');
		}
		$name = milu_lang('user_no_query').'  ('.$why.')';
	}
	
	if($status < 0){
		$show_upgrade = '';//服务器网络限制，无法检测升级
	}else{
		$show_upgrade = VIP  ? '<a href="?'.PICK_GO.'pick_info&ac=pick_check">'.milu_lang('check_new').'</a>' : '<a href="?'.PICK_GO.'pick_info&ac=pick_check">'.milu_lang('up_to_vip').'</a>';
	}
	$re['show_user_name'] = $name;
	$re['show_upgrade'] = $show_upgrade;
	$re['status'] = $status;
	$re['web_qq'] = $web_qq;
	return $re;
}

function version_check(){
	global $_G;
	$check = $_G['cache']['plugin']['milu_pick']['check_version'];
	if(!VIP || $check != 1) return FALSE;
	$get_site = GET_URL;
	$client_info = get_client_info();
	if(!$client_info || !$client_info['domain']) return;
	$tips_arr = dunserialize(pick_common_get(0, 'pick_tips'));
	if($tips_arr['check_version']) return;
	if(load_cache('check_version')) return;
	$url = GET_URL.'plugin.php?id=pick_user:upgrade&myac=check_version&tpl=no&php_version='.phpversion().'&dxc_version='.$client_info['dxc_version'].'&dxc_release='.$client_info['dxc_release'];
	$result = get_contents($url, array('cache' => -1));
	cache_data('check_version', 'ok', 5*3600);
	if($result == 'ok'){
		return show_tips('<div class="tipsblock"><li>'.milu_lang('have_new_version', array('url' => '?'.PICK_GO.'pick_info&ac=pick_check&checking=1')).'</li></ul></div>', array('key' => 'check_version', 'w' => 380, 'h' => 250));
	}
}


function pick_check(){
	global $_G;
	if(!$_GET['checking'])  cpmsg(milu_lang('upgrade_checking'), PICK_GO.'pick_info&ac=pick_check&checking=1', 'loading', '', false);
	$zend_check = is_zend();
	if($zend_check == -1){
		cpmsg_error(lang('plugin/milu_pick','http_visit', array('file' => 'source/plugin/milu_pick/zend/zendcheck.php')) );
	}else if($zend_check == -2){
		cpmsg_error(lang('plugin/milu_pick', 'zend_enable'));
	}
	$key_file = PICK_PATH.'/data/key.php';
	file_put_contents($key_file, $_G['timestamp']);
	if(!file_exists($key_file)) cpmsg_error(milu_lang('dir_no_write', array('dir' => PICK_PATH.'/data')));
	$get_site = GET_URL;
	$client_info = get_client_info();
	if(!$client_info || !$client_info['domain']) cpmsg_error(milu_lang('lan_upgrage'));
	$url = GET_URL.'plugin.php?id=pick_user:upgrade&myac=upgrade_check&tpl=no&get_type=1&php_version='.phpversion().'&domain='.urlencode($client_info['domain']).'&dxc_version='.$client_info['dxc_version'].'&dxc_release='.$client_info['dxc_release'].'&siteurl='.urlencode($client_info['siteurl']);
	$msg_arr = get_contents($url, array('cache' => -1));
	@unlink($key_file);

	if($msg_arr < 0) cpmsg_error(milu_lang('no_conn_up'));
	$msg_arr = json_decode(base64_decode($msg_arr));
	$status = $msg_arr->status;
	if(!$status) {
		cpmsg_error(milu_lang('up_no_err'));
	}
	if($status == -1) {
		cpmsg_error(milu_lang('up_no_free'));
	}else if($status == -2) {
		cpmsg_error(milu_lang('up_no_set_err'));
	}else if($status == -3){
		cpmsg_error(milu_lang('up_newed'));
	}else if($status == -4 || !$msg_arr->key){
		cpmsg_error(milu_lang('no_normal_up'));
	}else{	
		$version_desc = base64_decode(dstripslashes($msg_arr->version_desc));
		$msg_arr->version_filename = base64_decode(dstripslashes($msg_arr->version_filename));
	}	
	echo '<link href="'.PICK_URL.'static/style.css?v='.PICK_VERSION.'" rel="stylesheet" type="text/css" />';
	echo '<table class="tb tb2 ">
<tbody><tr class="header hover"><td>'.milu_lang('check_have_new').'</td><td></td><td></td></tr>
<tr class="hover"><td>DXC '.$msg_arr->version.milu_lang('version').' [Release '.$msg_arr->version_dateline.']</td><td><input type="button" class="btn" onclick="confirm(\''.milu_lang('cofirm_up').'\') ? window.location.href=\'?'.PICK_GO.'pick_info&ac=pick_download&tpl=no&md5_total='.$msg_arr->version_md5total.'&key='.$msg_arr->key.'\' : \'\';" value="'.milu_lang('auto_up').'"></td><td><a href="'.$msg_arr->version_filename.'" target="_blank">'.milu_lang('no_auto_up').'</a></td></tr></tbody></table>';

	if($version_desc){
		$version_desc = $version_desc ?  $version_desc : milu_lang('no_have');
		echo '<p class="partition">'.milu_lang('up_notice').'</p><div id="show_upgrade_info" class="showmess"><p>'.str_iconv($version_desc).'</p></div>';
	}
	exit();
}

function pick_download(){
	$client_info = get_client_info();
	$version_md5total = $_GET['md5_total'];
	$new_version_md5total = $_GET['new_md5_total'];
	$key = $_GET['key'];
	$version = $_GET['version'];
	$version_dateline = $_GET['version_dateline'];
	$i = intval($_GET['i']);
	if(!$client_info) cpmsg_error(milu_lang('lan_upgrage'));
	$p = intval($_GET['p']);
	$count = $_GET['count'];
	$file_md5 = $_GET['file_md5'];
	$tmpdir = DISCUZ_ROOT.'./data/download/dxc_temp';
	pload('C:cache');
	$md5s = array();
	$str = $_SERVER['QUERY_STRING'];
	if($p == 0) {
		dir_clear($tmpdir);
		dmkdir($tmpdir, 0777, false);
		cpmsg(milu_lang('diff_upgrade_file'), PICK_GO.'pick_info&ac=pick_download&key='.$key.'&p=1', 'loading', '', false);
	}else if($p == 1){
		$url = GET_URL.'plugin.php?id=pick_user:upgrade&myac=download_file&php_version='.phpversion().'&tpl=no&domain='.urlencode($client_info['domain']).'&key='.$key.'&file_md5='.$file_md5;
		$data = get_contents($url, array('cache' => -1));
		if(!$data || $data == '-1' ) cpmsg_error(milu_lang('no_normal_get'));
		$msg_arr = (array)json_decode(base64_decode($data));
		if(!$_GET['file_md5']){
			$download_file_data = upgrade_file_diff($msg_arr['md5']);
			$md5_temp_arr = array_keys($download_file_data);
			$version_md5total = md5((implode('', $md5_temp_arr)));
			$count = count($download_file_data);
			$version = $version ? $version : $msg_arr['Version'];
			$version_dateline = $version_dateline ? $version_dateline : $msg_arr['version_dateline'];
		}else{
			$download_file_data = load_cache('download_file_data');
			$filename = $tmpdir.'/'.$msg_arr['file'].'._addons_';
			$dirname = dirname($filename);
			dmkdir($dirname, 0777, false);
			$fp = fopen($filename, 'w');
			if(!$fp) {
				cpmsg('cloudaddons_download_write_error', '', 'error');
			}
			fwrite($fp, gzuncompress(base64_decode($msg_arr['text'])));
			fclose($fp);
			if($msg_arr['MD5']) {
				$new_version_md5total .= $msg_arr['MD5'];
				if($msg_arr['MD5'] != md5_file($filename)) {
				  	dir_clear($tmpdir);
				  	cpmsg(milu_lang('cloudaddons_download_error'), '', 'error');//数据下载错误
			  	}
			}
			
		}
		$file_md5_arr = array_keys($download_file_data);
		$file_md5  = $file_md5_arr[$i];
		$file = $download_file_data[$file_md5];
		$p = $i == $count ? 2 : 1;
		$percent = $i/$count;
		$percent = sprintf("%01.0f", $percent*100).'%';
		cache_data('download_file_data', $download_file_data);
		cpmsg(milu_lang('pick_upgrade_downloading_file', array('file' => $file, 'percent' => $percent)), PICK_GO.'pick_info&ac=pick_download&i='.($i+1).'&md5_total='.$version_md5total.'&new_md5_total='.$new_version_md5total.'&key='.$key.'&p='.$p.'&version='.$version.'&version_dateline='.$version_dateline.'&count='.$count.'&file_md5='.$file_md5, 'loading', '', false);
	}else if($p == 2){
		if($new_version_md5total !== '' && md5($new_version_md5total) !== $version_md5total) {
			dir_clear($tmpdir);
			cpmsg(milu_lang('cloudaddons_download_error'), '', 'error');//数据下载错误
		}
		cpmsg(milu_lang('DXC_installing'), PICK_GO.'pick_info&ac=pick_install&version='.$version.'&version_dateline='.$version_dateline, 'loading', '', false);
	}
}


function upgrade_file_diff($md5_data){
	$md5_data = (array) $md5_data;
	if(!$md5_data) return array();
	foreach($md5_data as $k => $v){
		if(md5(file_get_contents(PICK_DIR.'/'.$v)) == $k) unset($md5_data[$k]);
	}
	return $md5_data;
}


function pick_install(){
	global $_G;
	$tmpdir = DISCUZ_ROOT.'./data/download/dxc_temp';
	if(!is_dir($tmpdir)) {
		cpmsg(milu_lang('cloudaddons_download_error'), '', 'error');//数据下载错误
	}
	$_GET['type'] = 'plugin';
	$_GET['key'] = 'milu_pick';
	$to_version = $_GET['version'];
	$to_version_dateline = $_GET['version_dateline'];
	if(!libfile('function/cloudaddons')) exit('error01:file not found');
	require_once libfile('function/cloudaddons');
	$descdir = DISCUZ_ROOT.'source/plugin/';
	$subdir = 'milu_pick';
	$unwriteabledirs = cloudaddons_dirwriteable($descdir, $subdir, $tmpdir);
	if($unwriteabledirs) {//目录不可写
		showtips(milu_lang('cloudaddons_unwriteabledirs', array('basedir' => 'source/plugin', 'unwriteabledirs' => implode(', ', $unwriteabledirs))));
		exit;		
	}
	$descdir .= $subdir;
	cloudaddons_comparetree($tmpdir, $descdir, $tmpdir, $_GET['key'].'.'.$_GET['type'].'vip', 1);
	
	if(!empty($_G['treeop']['oldchange']) && empty($_GET['confirmed'])) {
		cpmsg(milu_lang('cloudaddons_install_files_changed', array('files' => implode('<br />', $_G['treeop']['oldchange']))), '', 'form', '');
	}
	cloudaddons_copytree($tmpdir, $descdir);
	$client_info = get_client_info();
	$_GET['end'] = 'Status=End&ID=milu_pick_vip.plugin&SN='.$client_info['domain'].'&RevisionID='.$client_info['domain'].'&RevisionDateline='.$client_info['domain'];
	cloudaddons_savemd5($_GET['key'].'.'.$_GET['type'].'vip', $_GET['end'], $_G['treeop']['md5']);
	cloudaddons_deltree($tmpdir);
	//成功之后的一些动作
	
	$set['pick_tips']['check_version'] = 0;
	pick_common_set($set);
	
	$charset = str_replace('-', '', strtoupper($_G['config']['output']['charset']));
	$locale = '';
	if($charset == 'BIG5') {
		$locale = 'TC';
	} elseif($charset == 'GBK') {
		$locale = 'SC';
	} elseif($charset == 'UTF8') {
		if($_G['config']['output']['language'] == 'zh_cn') {
			$locale = 'SC';
		} elseif($_G['config']['output']['language'] == 'zh_tw') {
			$locale = 'TC';
		}
	}
	$xml_ext = 'discuz_plugin_milu_pick_'.$locale.'_'.$charset.'.xml';
	$xml_file = $descdir.'/'.$xml_ext;
	
	if(!file_exists($xml_file)) cpmsg(milu_lang('xml_no_found', array('f' => $xml_ext)), '', 'error');//xml文件丢失
	
	require_once libfile('class/xml');
	$data = file_get_contents($xml_file);
	$data_arr = xml2array($data);
	$xml_data = exportarray($data_arr['Data'], 0);
	$installtype = $locale.'_'.$charset;
	pluginupgrade($xml_data, $installtype);
	$auth_file = PICK_DIR.'/data/pick_auth.txt';  
	$upgrade_file = $descdir.'/upgrade.php';
	if(file_exists($upgrade_file)) {
		$_GET['fromversion'] = PICK_VERSION;
		include($upgrade_file);
		if(!$finish) cpmsg_error(milu_lang('up_fail'));
	}
	@unlink($auth_file);
	cpmsg('plugins_upgrade_succeed', PICK_GO."pick_info", 'succeed', array('toversion' => $to_version.' '.$to_version_dateline));
}


function num_limit($table_name, $limit_num, $lang){
	$f_num = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table($table_name)), 0);
	if(!VIP && $f_num > $limit_num) cpmsg_error(milu_lang($lang, array('n' => $limit_num)));
}


class RootDomain{
    private static $self;
    private $domain=null;
    private $host=null;
    private $state_domain;
    private $top_domain;
    /**
     * 取得域名分析实例
     * Enter description here ...
     */
    public static function instace(){
        if(!self::$self)
            self::$self=new self();
        return self::$self;
    }
    private function  __construct(){
        $this->state_domain = array(
            'al','dz','af','ar','ae','aw','om','az','eg','et','ie','ee','ad','ao','ai','ag','at','au','mo','bb','pg','bs','pk','py','ps','bh','pa','br','by','bm','bg','mp','bj','be','is','pr','ba','pl','bo','bz','bw','bt','bf','bi','bv','kp','gq','dk','de','tl','tp','tg','dm','do','ru','ec','er','fr','fo','pf','gf','tf','va','ph','fj','fi','cv','fk','gm','cg','cd','co','cr','gg','gd','gl','ge','cu','gp','gu','gy','kz','ht','kr','nl','an','hm','hn','ki','dj','kg','gn','gw','ca','gh','ga','kh','cz','zw','cm','qa','ky','km','ci','kw','cc','hr','ke','ck','lv','ls','la','lb','lt','lr','ly','li','re','lu','rw','ro','mg','im','mv','mt','mw','my','ml','mk','mh','mq','yt','mu','mr','us','um','as','vi','mn','ms','bd','pe','fm','mm','md','ma','mc','mz','mx','nr','np','ni','ne','ng','nu','no','nf','na','za','aq','gs','eu','pw','pn','pt','jp','se','ch','sv','ws','yu','sl','sn','cy','sc','sa','cx','st','sh','kn','lc','sm','pm','vc','lk','sk','si','sj','sz','sd','sr','sb','so','tj','tw','th','tz','to','tc','tt','tn','tv','tr','tm','tk','wf','vu','gt','ve','bn','ug','ua','uy','uz','es','eh','gr','hk','sg','nc','nz','hu','sy','jm','am','ac','ye','iq','ir','il','it','in','id','uk','vg','io','jo','vn','zm','je','td','gi','cl','cf','cn','yr', 'co.nz'
        );
        $this->top_domain=array('com','arpa','edu','gov','int','mil','net','org','biz','info','pro','name','museum','coop','aero','xxx','idv','me','mobi');
    }

    public function setUrl( $url = ''){
        if(empty($url)) FALSE;;
        if(!preg_match("/^http:/is", $url))
            $url="http://".$url;
        $url=parse_url(strtolower($url));
        $urlarr=explode(".", $url['host']);
        $count=count($urlarr);
        
        if ($count<=2){
            $this->domain=$url['host'];
        }else if ($count>2){
            $last=array_pop($urlarr);
            $last_1=array_pop($urlarr);
            if(in_array($last, $this->top_domain)){
                $this->domain=$last_1.'.'.$last;
                $this->host=implode('.', $urlarr);
            }else if(in_array($last_1.'.'.$last, $this->state_domain)){
				$last_2=array_pop($urlarr);
				 $this->domain=$last_2.'.'.$last_1.'.'.$last;
                 $this->host=implode('.', $urlarr);
			}else if (in_array($last, $this->state_domain)){
                $last_2=array_pop($urlarr);
                if(in_array($last_1, $this->top_domain)){
                    $this->domain=$last_2.'.'.$last_1.'.'.$last;
                    $this->host=implode('.', $urlarr);
                }else{
                    $this->host=implode('.', $urlarr).$last_2;
                    $this->domain=$last_1.'.'.$last;
                }
            }
        }
        return $this;
    }
 
    public function getDomain(){
        return $this->domain;
    }
   
    public function getHost(){
        return $this->host;
    }
} 

function tips_no($key = ''){
	$key = $key ? $key : $_GET['key'];
	$set['pick_tips'][$key] = 1;
	pick_common_set($set);
	return 'ok';
}

function is_zend(){
	if(VIP) return 1;//如果是vip不检测 
	if(!file_exists(PICK_DIR.'/zend/zendcheck')){//应用中心不允许上传zend加密文件，故临时更换检测方法。
		if (extension_loaded('Zend Optimizer') || extension_loaded('Zend Guard Loader') || get_cfg_var("zend_extension")||get_cfg_var("zend_optimizer.optimization_level")||get_cfg_var("zend_extension_manager.optimizer_ts")||get_cfg_var("zend_extension_ts")){
			return 1;
		}else{
			return -2;
		}
	}else{
		$zend_check = dfsockopen(PICK_URL.'zend/zendcheck.php');
		if(!$zend_check) return -1;
		preg_match('/s=\'(.*?)\';v=\'(.*?)\';/is', $zend_check, $v_arr);
		$msg = $v_arr[1];
		if($msg == 'OK') return 1;
		return -2;
	}
	return 1;
}

?>