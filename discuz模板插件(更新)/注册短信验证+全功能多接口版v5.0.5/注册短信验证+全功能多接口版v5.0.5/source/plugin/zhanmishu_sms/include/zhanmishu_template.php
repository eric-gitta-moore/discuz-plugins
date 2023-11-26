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
class zhanmishu_template{
	public $config;
	public function __construct(){
		if (empty($config)) {
			if (!function_exists('getconfig')) {/*www-caogen8-vip*/
				/*www-cgzz8-com*/include DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/function.php';
			}
			$config = getconfig();
		}
		
		$this->config = $config;
	}
	public function getconfig(){
		return $this->config;
	}
	public function get_default_template(){

		$config = $this->getconfig();
		$templates = array();
		foreach ($config['smsconfig']['types'] as $key => $value) {
			if ($key=='5') {
				continue;
			}
			$templates[$key]['tid'] = $key;
			$templates[$key]['sign'] = $config['sign'];
			$templates[$key]['uid'] = '1';
			$templates[$key]['templatename'] = $value['name'];
			$templates[$key]['templatetype'] = $key;
			$templates[$key]['api'] = '1';
			$templates[$key]['isopen'] = '1';
			$templates[$key]['dateline'] = TIMESTAMP;
			switch ($key) {
				case '1':
					$templates[$key]['templateid'] = $config['templateid'];
					break;
				case '2':
					$templates[$key]['templateid'] = $config['verifytemplateid'];
					break;
				case '3':
					$templates[$key]['templateid'] = $config['pwdtemplateid'];
					break;
				case '4':
					$templates[$key]['templateid'] = $config['smsnoticetemplateid'];
					break;
				case '6':
					$templates[$key]['templateid'] = $config['verifytemplateid'];
					break;
				
				default:
					$templates[$key]['templateid'] = $config['templateid'];
					break;
			}
			//$templates[$key]['templateintro'] = $this->diconv_back($this->get_template_intro_by_templateid($templates[$key]['templateid']));
			C::t("#zhanmishu_sms#zhanmishu_template")->insert($templates[$key],false,ture);
		}

		return $templates;
	}
	public function diconv_back($str){
		return diconv(strval($str),'UTF-8', CHARSET);
	}

	public function to_utf8($str){
		return diconv($str,CHARSET,'UTF-8');
	}
	public function get_templates(){
		$templates = C::t("#zhanmishu_sms#zhanmishu_template")->range();
		if (empty($templates)) {
			$templates = $this->get_default_template();
		}
		if(file_exists($zmstemplatevarfile = DISCUZ_ROOT.'./data/sysdata/cache_zhanmishu_sms.php')) {
			foreach ($templates as  $value) {
				if (strlen($value['templateintro']) < 5) {
					$value['templateintro'] = $this->diconv_back($this->get_template_intro_by_templateid($value['tid']));
				}

				C::t("#zhanmishu_sms#zhanmishu_template")->insert($value,false,ture);
			}
		}
		return $templates;
	}

	public function writesettingcache(){
		if(file_exists($zmstemplatevarfile = DISCUZ_ROOT.'./data/sysdata/cache_zhanmishu_sms.php')) {
			@include $zmstemplatevarfile;
		}
		if (!isset($zmstemplatevar)) {
			$zmstemplatevar = array();
		}
		$zmstemplatevar['templates'] = $this->get_templates();
		$zmstemplatevar['vars'] = $this->get_vars();

		require_once libfile('function/cache');
		$datacache = "\$zmstemplatevar=".arrayeval($zmstemplatevar).";\n";
		writetocache('zhanmishu_sms', $datacache);
	}

	public function get_templatevar_config(){

		if(file_exists($zmstemplatevarfile = DISCUZ_ROOT.'./data/sysdata/cache_zhanmishu_sms.php')) {
			@include $zmstemplatevarfile;
		}else{
			$this->writesettingcache();
			if(!file_exists($zmstemplatevarfile = DISCUZ_ROOT.'./data/sysdata/cache_zhanmishu_sms.php')) {
				return false;
			}
			@include $zmstemplatevarfile;
		}

		$vars = array();
		foreach ($zmstemplatevar['vars'] as $value) {
			$vars[str_replace('}', '', str_replace('${', '', $value['varname']))] = $value['varvalue'];
		}
		$zmstemplatevar['vars'] = $vars;
		return $zmstemplatevar;
	}

	public function get_template_intro_by_templateid($tid){

		$sendsms = new zhanmishu_sms($config);
		$param = array('getsmsvar'=>'getsmsvar');
		$param = json_encode($param);
		$return =  $sendsms->sendpost('1552805'.rand('0000','9999'),$param,$tid);
		if ($return['code'] !== '15') {
			return '';
		}

		$p = strpos($return['sub_msg'],$this->to_utf8(lang('plugin/zhanmishu_sms', 'templatestr1'))) + strlen($this->to_utf8(lang('plugin/zhanmishu_sms', 'templatestr1')));
		if ($p < 1) {
			return '';
		}
		$len = strpos($return['sub_msg'],$this->to_utf8(lang('plugin/zhanmishu_sms', 'templatestr2'))) - $p;
		return substr($return['sub_msg'],$p,$len);
	}
	public function zmssms_gettype_select($apis,$selectname='',$api,$key='',$protected=''){
		if ($protected) {
			$protected = 'onfocus="this.defaultIndex=this.selectedIndex;" onchange="this.selectedIndex=this.defaultIndex;"';
		}
		$select = '<select name="'.$selectname.'['.$key.']" '.$protected.'><option value ="">'.lang('plugin/zhanmishu_sms', 'choosetip').'</option>';
		foreach ($apis as $key => $value) {
			if (!$api) {
				$se = $value["default"] == '1' ? 'selected="selected"' : '';
			}else{
				$se = $key == $api ? 'selected="selected"' : '';
			}
			
			$select .= '<option '.$se.'  value ="'.$key.'">'.$value["name"].'</option>';
		}
		$select .= '</select>';
		return $select;
	}

	public function auto_finish_templates($config){
		if (empty($config)) {
			$config = $this->getconfig();
		}
		$templates = C::t("#zhanmishu_sms#zhanmishu_template")->range();
		if (empty($templates)) {
			$templates = $this->get_default_template();
		}
	}

	public function get_vars(){
		$vars = C::t("#zhanmishu_sms#zhanmishu_var")->range();
		if (empty($vars)) {
			$vars = $this->get_system_var();
		}

		return $vars;
	}

	public function get_system_var(){
		global $_G;

		$config = $this->getconfig();

		$var = array();
		$var['1']['vid'] = '1';
		$var['1']['varname'] = '${product}';
		$var['1']['varvalue'] = $config['product'];
		$var['1']['varintro'] = lang('plugin/zhanmishu_sms', 'systemvar1');

		$var['2']['vid'] = '2';
		$var['2']['varname'] = '${username}';
		$var['2']['varvalue'] = '${username}';
		$var['2']['varintro'] = lang('plugin/zhanmishu_sms', 'systemvar2');
		
		$var['3']['vid'] = '3';
		$var['3']['varname'] = '${code}';
		$var['3']['varvalue'] = '${code}';
		$var['3']['varintro'] = lang('plugin/zhanmishu_sms', 'systemvar3');		

		$var['4']['vid'] = '4';
		$var['4']['varname'] = '${time}';
		$var['4']['varvalue'] = '${time}';
		$var['4']['varintro'] = lang('plugin/zhanmishu_sms', 'systemvar4');

		foreach ($var as $value) {
			C::t("#zhanmishu_sms#zhanmishu_var")->insert($value,false,true);
		}

		return $var;
	}



}
//From:www-cgzz8-Com
?>