<?php

if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class plugin_e6_propaganda {
	public $e6_x = FALSE;
	function plugin_e6_propaganda() {
        global $_G;
		$this->config = unserialize($_G['setting']['e6_propaganda']);
		if (!function_exists('e6_propaganda')) {
			require DISCUZ_ROOT.'source/plugin/e6_propaganda/e6_propaganda.func.php';
		}
		$_G['tid'] && $e6_url = pro_rewrite($_G['tid']);
        $this->script = <<<EOT
		<div class="bdsharebuttonbox" data-tag="share_8">
			<a class="bds_qzone" data-cmd="qzone" href="#"></a>
			<a class="bds_tsina" data-cmd="tsina"></a>
			<a class="bds_tqq" data-cmd="tqq"></a>
			<a class="bds_sqq" data-cmd="sqq"></a>
			<a class="bds_weixin" data-cmd="weixin"></a>
			<a class="bds_tieba" data-cmd="tieba"></a>
			<a class="bds_renren" data-cmd="renren"></a>
		</div>
		<script>
			window._bd_share_config = {
				common : {
					bdText : $('thread_subject').innerHTML.replace(/&amp;/g, '&'),
					bdUrl : '{$e6_url}',
					bdSign : 'off'
				},
				share : [{
					"tag" : "share_8",
					"bdSize" : 16
				}],
			}
			with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];
		</script>
EOT;
		if ($this->config['tidshare']) {
			$this->position = $this->config['tidshare_position'];
		}
    }
	function common() {
		global $_G, $_GET;
		$pro_module = DISCUZ_ROOT . 'source/plugin/e6_propaganda/module/';
		$GLOBALS['config'] = $config = $this->config;
		if (file_exists("{$pro_module}register_extra.php") && $this->config['register_extra']) {
			if (!function_exists('register_extra_submit')) {
				require "{$pro_module}register_extra.php";
			}
			register_extra_submit();	
		}
	}
	function global_e6_x() {
		if (!$this->e6_x) {
			$this->e6_x = TRUE;
			global $_G, $_GET;
			$_GET['x'] && $GLOBALS['x'] = $x = intval($_GET['x']);
			$_GET['regsubmit'] && $e6_reg = 1;
			if ($x or ($e6_reg && $_G['uid'] && getcookie('pro_x'))) {
				!$GLOBALS['e6_propaganda_x'] && @include DISCUZ_ROOT . 'source/plugin/e6_propaganda/x.php';
			}
		}
	}
	function global_header() {
		if (!$this->e6_x) {
			self::global_e6_x();
		}
	}
	function is_ie() {
		$str = preg_match('/MSIE ([0-9]\.[0-9])/', $_SERVER['HTTP_USER_AGENT'], $matches);
		if ($str == 0){
			return 0;
		} else {
			return floatval($matches[1]);
		}
	}
	function is_ff() {
		$str = preg_match('/Firefox/', $_SERVER['HTTP_USER_AGENT'], $matches);
		if ($str == 0){
			return false;
		} else {
			return true;
		}
	}
}
class plugin_e6_propaganda_member extends plugin_e6_propaganda {
	function register_input_output() {
		$pro_module = DISCUZ_ROOT . 'source/plugin/e6_propaganda/module/';
		$GLOBALS['config'] = $config = $this->config;
		if (file_exists("{$pro_module}register_extra.php") && $this->config['register_extra']) {
			if (!function_exists('register_extra_index')) {
				require "{$pro_module}register_extra.php";
			}
			return register_extra_index();	
		} else {
			if ($GLOBALS['x'] = $x = intval(getcookie('pro_x'))) {
				if ($this->config['open'] == 1 && $this->config['showuser']) {
					$pro_user = C::t('common_member')->fetch($x);
					$recommend = lang('plugin/e6_propaganda', 'recommend');
					return <<<EOT
<div class="rfm">
	<table>
		<tbody>
			<tr>
				<th>{$recommend}:</th>
				<td>{$pro_user['username']}</td>
				<td class="tipcol"></td>
			</tr>
		</tbody>
	</table>
</div>
EOT;
				}
			}
		}
	}
}
class plugin_e6_propaganda_forum extends plugin_e6_propaganda {
	function viewthread_postheader() {
		if ($this->position == 0) {
			$v = $this->is_ie();
			if ($v <= 6 && $v != 0) {
				return array('<div style="float:right;position:relative;top:-20px;">' . $this->script . '</div>');
			} else if ($v == 7) {
				return array('<div style="float:right;position:relative;top:-20px;">' . $this->script . '</div>');
			} else if ($this->is_ff()) {
				return array('<div style="float:right;">' . $this->script . '</div>');
			} else {
				return array('<div style="float:right;position:relative;top:-6px;">' . $this->script . '</div>');
			}
		}
	}
	function viewthread_postfooter(){
		if($this->position == 1) {
			$v = $this->is_ie();
			if ($v <= 6 && $v != 0) {
				return array('<div style="margin-top:6px;line-height:14px;float:left;">' . $this->script . '</div>');
			} else if ($v == 7) {
				return array('<div style="margin-top:6px;line-height:14px;float:left;">' . $this->script . '</div>');
			} else if ($v == 8) {
				return array('<div style="margin-top:6px;line-height:14px;float:right;margin-top:6px;">' . $this->script . '</div>');
			} else if ($this->is_ff()) {
				return array('<div style="margin-top:6px;line-height:14px;float:right;margin-top:6px;">' . $this->script . '</div>');
			} else {
				return array('<div style="margin-top:6px;line-height:14px;float:right;position:relative;">' . $this->script . '</div>');
			}
		}
	}
	function viewthread_posttop() {
		if ($this->position == 2) {
			return array('<div style="float:left;padding-top:5px;margin-bottom:25px;width:100%">' . $this->script . '</div>');
		}
	}
	function viewthread_postbottom() {
		if ($this->position == 3) {
			return array('<div style="margin-bottom:-10px; overflow:hidden;">' . $this->script . '</div>');
		}
	}
	function viewthread_useraction_output() {
		global $_G;
		if ($this->config['open'] == 1 && $this->config['tidurl']) {
			$visit_sum = array_sum($this->config['visit_money']);
			if ($visit_sum) {
				foreach ($this->config['visit_money'] as $k => $v) {
					if ($v) $visit_money[] = $v.$_G['setting']['extcredits'][$k]['title'];
				}
				$e6_reward = lang('plugin/e6_propaganda', 'reward_visit', array('reward' => implode(' ', $visit_money)));
			} else {
				if ($this->config['registertype']) {
					if ($this->config['registertype'] == 1) {
						$register_sum = array_sum($this->config['register_money']);
						if ($register_sum) {
							foreach ($this->config['register_money'] as $k => $v) {
								if ($v) $register_money[] = $v.$_G['setting']['extcredits'][$k]['title'];
							}
							$reward = implode(' ', $register_money);
						}
					} else {
						$reward = $this->config['multi_reg'][1]['money'].$_G['setting']['extcredits'][$this->config['multi_reg'][1]['type']]['title'];
					}
					$e6_reward = lang('plugin/e6_propaganda', 'reward_register', array('reward'=>$reward));
				} else {
					$region_sum = array_sum($this->config['region_money']);
					if ($region_sum) {
						foreach ($this->config['region_money'] as $k => $v) {
							if ($v) $region_money[] = $v.$_G['setting']['extcredits'][$k]['title'];
						}
						$e6_reward = lang('plugin/e6_propaganda', 'reward_region', array('area'=>$this->config['area'],'reward'=>implode(' ', $region_money)));
					} else {
						if ($this->config['active_num']>0) {
							$e6_reward = lang('plugin/e6_propaganda', 'reward_active');
						} else {
							if ($this->config['paytype']) {
								$e6_reward = lang('plugin/e6_propaganda', 'reward_paytype');
							}
						}
					}
				}
			}
			if ($e6_reward) {
				if (!function_exists('e6_propaganda')) {
					require DISCUZ_ROOT.'source/plugin/e6_propaganda/e6_propaganda.func.php';
				}
				$e6_rewri_url = pro_rewrite($_G['tid']);
				$copy_str = lang('plugin/e6_propaganda', 'reward_copy');
				$copy = lang('plugin/e6_propaganda', 'copy');
				$str = <<<EOT
					<div style="padding-bottom:10px;">
						<span style="color:#FF6600">{$e6_reward}</span>
						<div style="padding-top:5px;">
							<input type="text" class="px vm" onclick="this.select();setCopy(this.value, '{$copy_str}');" value="{$e6_rewri_url}" size="80" />
							<button type="submit" class="pn vm" onclick="setCopy($('thread_subject').innerHTML.replace(/&amp;/g, '&')+'\\r\\n'+'{$e6_rewri_url}', '{$copy_str}');" type="submit"><em>{$copy}</em></button>
						</div>
					</div>
EOT;
				return $str;
			}
		}
	}
}
class plugin_e6_propaganda_group extends plugin_e6_propaganda {
	function viewthread_useraction_output() {
		return plugin_e6_propaganda_forum::viewthread_useraction_output();
	}
	function viewthread_postheader() {
		return plugin_e6_propaganda_forum::viewthread_postheader();
	}
	function viewthread_postfooter(){
		return plugin_e6_propaganda_forum::viewthread_postfooter();
	}
	function viewthread_posttop() {
		return plugin_e6_propaganda_forum::viewthread_posttop();
	}
	function viewthread_postbottom() {
		return plugin_e6_propaganda_forum::viewthread_postbottom();
	}
}

?>