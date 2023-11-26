<?php

if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$GLOBALS['e6_propaganda'] = $e6_propaganda = unserialize($_G['setting']['e6_propaganda']);
if ($e6_propaganda['open'] == 1) {
	if (!discuz_process::islocked('e6_pro_uid'.$x, 60)){
		if (!function_exists('e6_propaganda')) {
			require DISCUZ_ROOT.'source/plugin/e6_propaganda/e6_propaganda.func.php';
		}
		$e6_reg && $x = getcookie('pro_x');
		!is_numeric($x) && $x = 0;
		$x && $user = C::t('common_member')->fetch($x);
		if ($x && $user && (!$e6_propaganda['group'] or in_array($user['groupid'], $e6_propaganda['group']))) {
			$pro_reg = C::t('#e6_propaganda#e6_pro_user')->fetch($_G['uid']);
			if ($e6_reg && !$pro_reg) {
				$pro_fuser = C::t('#e6_propaganda#e6_pro_user')->fetch($x);
				C::t('#e6_propaganda#e6_pro_user')->insert(array(
					'uid'	=>	$_G['uid'],
					'fuid1'	=>	$x,
					'fuid2'	=>	$pro_fuser['fuid1'],
					'fuid3'	=>	$pro_fuser['fuid2'],
					'fuid4'	=>	$pro_fuser['fuid3'],
					'fuid5'	=>	$pro_fuser['fuid4'],
					'fuid6'	=>	$pro_fuser['fuid5'],
					'fuid7'	=>	$pro_fuser['fuid6'],
					'fuid8'	=>	$pro_fuser['fuid7'],
					'fuid9'	=>	$pro_fuser['fuid8'],
					'fuid10'=>	$pro_fuser['fuid9']));
				C::t('#e6_propaganda#e6_pro_user_count')->insert(array('uid'=>$_G['uid']));
				if ($e6_propaganda['registertype'] && array_sum($e6_propaganda['max_register'])) {
					$my_date = strtotime(dgmdate($_G['timestamp'], 'Y-m-d'));
					$fuser_allmoney = C::t('#e6_propaganda#e6_pro_credit')->fetch_all_by_allmoney($x, 2, $my_date);
					foreach ($fuser_allmoney as $v) {
						$my_allmoney[$v['type']] = $v['allmoney'];
					}
					foreach($e6_propaganda['max_register'] as $key => $value) {
						if ($value && ($my_allmoney[$key] >= $value)) {
							$no_money = 1;
							if ($e6_propaganda['cheatlog']) {
								C::t('#e6_propaganda#e6_pro_credit')->insert(array(
									'uid'		=>	$x,
									'logtype'	=>	'9',
									'date'		=>	$_G['timestamp'],
									'ip'		=>	$_G['clientip'],
									'describe'	=>	pro_lang('log_9h', array('username'=>$_G['username'], 'moneytype'=> $_G['setting']['extcredits'][$key]['title']))));
							}
							break;
						}
					}
				}
				if (!$no_money && $e6_propaganda['registertype'] == 1) {
					$register_sum = array_sum($e6_propaganda['register_money']);
					if ($register_sum) {
						pro_money($e6_propaganda['register_money'], '2a', array('username'=>$_G['username']), $x);
						C::t('e6_pro_user_count')->update_by_count($x, "`money`=`money`+$register_sum");
					}
				} elseif (!$no_money && $e6_propaganda['registertype'] == 2){
					for($n = 1; $n <= 10; $n++) {
						if ($e6_propaganda['multi_reg'][$n]['money']) {
							if ($n == 1) {
								$f_uid = $x;
							} else {
								$m = $n-1;
								$f_uid = $pro_fuser['fuid'.$m];
							}
							if ($f_uid) {
								$f_group = C::t('common_member')->fetch($f_uid);
								if ($e6_propaganda['dividend'][$f_group['groupid']] >= $n) {
									pro_money(array($e6_propaganda['multi_reg'][$n]['type'] => $e6_propaganda['multi_reg'][$n]['money']), '2b', array('username'=>$_G['username'], 'n'=>$n), $f_uid);
									C::t('e6_pro_user_count')->update_by_count($f_uid, "`money`=`money`+{$e6_propaganda['multi_reg'][$n]['money']}");
								}
							} else {
								break;
							}
						}
					}
				}
				$region_sum = array_sum($e6_propaganda['region_money']);
				if ($region_sum && $e6_propaganda['area']) {
					if($e6_propaganda['iptype'] ==1) {
						if (!function_exists('convertip')) {
							require_once libfile('function/misc');
						}
						$file_region = convertip($_G['clientip']);
					} elseif ($e6_propaganda['iptype'] ==2) {
						$file_region = ip_area($_G['clientip']);
						if (!$file_region) {
							if (!function_exists('convertip')) {
								require_once libfile('function/misc');
							}
							$file_region = convertip($_G['clientip']);
						}
					}
					$arr_area = explode(',', $e6_propaganda['area']);
					foreach ($arr_area as $value) {
						if (strstr($file_region, $value)){
							$area_ok = 1;
							break;
						}
					}
					if ($area_ok == 1) {
						pro_money($e6_propaganda['region_money'], 3, array('username'=>$_G['username']), $x);
						C::t('#e6_propaganda#e6_pro_user')->update($_G['uid'], array('region'=>1));
						C::t('#e6_propaganda#e6_pro_user_count')->update_by_count($x, "`money`=`money`+{$region_sum}");
					}
				}
				if ($e6_propaganda['message'] == 1) {
					notification_add($x, 'system', 'system_notice', array(
						'subject' => pro_lang('reg_msg_title'),
						'message' => pro_lang('reg_msg_content', array('username'=>$_G['username'], 'date'=>dgmdate($_G['timestamp']))),
						'from_id' => 0,
						'from_idtype' => 'e6_pro'
					),1);
				}
				$e6_propaganda['cookie'] != '-1' && dsetcookie('pro_x','',-3600);
				C::t('#e6_propaganda#e6_pro_user_count')->update_by_count($x, "`register`=`register`+1");
			} else {
				if (!$_G['uid'] && ($e6_propaganda['cookie'] == '-1' or !getcookie('pro'))) {
					if ($user['uid']) {
						$fuser = C::t('#e6_propaganda#e6_pro_user')->fetch($x);
						if (!$fuser) add_prouser($x);
						if ($e6_propaganda['ip']) {
							$overdate = $_G['timestamp'] - ($e6_propaganda['ip'] * 3600);
							C::t('#e6_propaganda#e6_pro_visit')->delete_by_ip("`date`<'{$overdate}'");
							$ip_uid = C::t('#e6_propaganda#e6_pro_visit')->fetch_uid_by_ip($_G['clientip']);
							if (!$ip_uid) {
								if ($e6_propaganda['interval'] or $e6_propaganda['ipsection']) {
									$ip_y = C::t('#e6_propaganda#e6_pro_visit')->fetch($x);
									if ($e6_propaganda['interval']) {
										if (($_G['timestamp'] - $ip_y['date']) < $e6_propaganda['interval']) {
											if($e6_propaganda['cheatlog']) {
												C::t('#e6_propaganda#e6_pro_credit')->insert(array(
													'uid'		=>	$x,
													'logtype'	=>	'9',
													'date'		=>	$_G['timestamp'],
													'ip'		=>	$_G['clientip'],
													'describe'	=>	pro_lang('log_9e', array('ip'=>$_G['clientip'], 'second'=>$e6_propaganda['interval']))));
											}
											$pro_no = 1;
										}
									}
									if (!$pro_no && $e6_propaganda['ipsection']) {
										$ip_arr1 = explode('.', $ip_y['ip']);
										$ip_arr2 = explode('.', $_G['clientip']);
										if ($ip_arr1[0] == $ip_arr2[0] && $ip_arr1[1] == $ip_arr2[1]) {
											if ($e6_propaganda['cheatlog']) {
												C::t('#e6_propaganda#e6_pro_credit')->insert(array(
													'uid'		=>	$x,
													'logtype'	=>	'9',
													'date'		=>	$_G['timestamp'],
													'ip'		=>	$_G['clientip'],
													'describe'	=>	pro_lang('log_9f', array('ip'=>$_G['clientip'], 'oldip'=>$ip_y['ip']))));
											}
											$pro_no = 1;
										}
									}
								}
								if (!$pro_no) {
									dsetcookie('pro_x',$x ,315360000);
									C::t('#e6_propaganda#e6_pro_visit')->insert(array(
										'uid'	=>	$x,
										'ip'	=>	$_G['clientip'],
										'date'	=>	$_G['timestamp']));
									$visit_money = 1;
								}
							} else {
								if ($e6_propaganda['cheatlog']) {
									$ip_user = C::t('common_member')->fetch($ip_uid);
									C::t('#e6_propaganda#e6_pro_credit')->insert(array(
										'uid'		=>	$x,
										'logtype'	=>	'9',
										'date'		=>	$_G['timestamp'],
										'ip'		=>	$_G['clientip'],
										'describe'	=>	pro_lang('log_9d', array('ip'=>$_G['clientip'], 'username'=>$ip_user['username']))));
								}
							}
						} else {
							dsetcookie('pro_x',$x ,315360000);
							$visit_money = 1;
						}
						if ($visit_money && array_sum($e6_propaganda['max_visit'])) {
							$my_date = strtotime(dgmdate($_G['timestamp'], 'Y-m-d'));
							$fuser_allmoney = C::t('#e6_propaganda#e6_pro_credit')->fetch_all_by_allmoney($x, 1, $my_date);
							foreach ($fuser_allmoney as $v) {
								$my_allmoney[$v['type']] = $v['allmoney'];
							}
							foreach($e6_propaganda['max_visit'] as $key => $value) {
								if ($value && ($my_allmoney[$key] >= $value)) {
									$visit_money = NULL;
									if ($e6_propaganda['cheatlog']) {
										C::t('#e6_propaganda#e6_pro_credit')->insert(array(
											'uid'		=>	$x,
											'logtype'	=>	'9',
											'date'		=>	$_G['timestamp'],
											'ip'		=>	$_G['clientip'],
											'describe'	=>	pro_lang('log_9g', array('ip'=>$_G['clientip'], 'moneytype'=> $_G['setting']['extcredits'][$key]['title']))));
									}
									break;
								}
							}
						}
						if ($visit_money) {
							$visit_money_sum = array_sum($e6_propaganda['visit_money']);
							if ($visit_money_sum) {
								C::t('#e6_propaganda#e6_pro_user_count')->update_by_count($x, "`money`=`money`+'{$visit_money_sum}',`ip`=`ip`+1");
								pro_money($e6_propaganda['visit_money'], 1, array('ip'=>$_G['clientip']), $x);
							}
							$pro_module = DISCUZ_ROOT . 'source/plugin/e6_propaganda/module/';
							if (file_exists("{$pro_module}area_extra.php")) {
								if (!function_exists('area_extra_x')) {
									require "{$pro_module}area_extra.php";
								}
								area_extra_x();
							}
						}
						if ($e6_propaganda['cookie'] && $e6_propaganda['cookie'] != '-1') {
							$cookie_time = $e6_propaganda['cookie'] * 86400;
							dsetcookie('pro', $x, $cookie_time);
						} else {
							dsetcookie('pro', $x, 315360000);
						}
					}
				} else {
					if ($e6_propaganda['cheatlog']) {
						if($_G['uid']) {
							C::t('#e6_propaganda#e6_pro_credit')->insert(array(
								'uid'		=>	$x,
								'logtype'	=>	'9',
								'date'		=>	$_G['timestamp'],
								'ip'		=>	$_G['clientip'],
								'describe'	=>	pro_lang('log_9b', array('username'=>$_G['username']))));
						} else {
							$user = C::t('common_member')->fetch(getcookie('pro'));
							C::t('#e6_propaganda#e6_pro_credit')->insert(array(
								'uid'		=>	$x,
								'logtype'	=>	'9',
								'date'		=>	$_G['timestamp'],
								'ip'		=>	$_G['clientip'],
								'describe'	=>	pro_lang('log_9c', array('ip'=>$_G['clientip'],'username'=>$user['username']))));
						}
					}
				}
			}
		} else {
			if ($x && $e6_propaganda['cheatlog']) {
				C::t('#e6_propaganda#e6_pro_credit')->insert(array(
					'uid'		=>	$x,
					'logtype'	=>	'9',
					'date'		=>	$_G['timestamp'],
					'ip'		=>	$_G['clientip'],
					'describe'	=>	pro_lang('log_9a', array('ip'=>$_G['clientip']))));
			}
		}
		discuz_process::unlock('e6_pro_uid'.$x);
	}
}
if ($e6_propaganda['wechat_open'] && $_GET['id'] == 'e6_propaganda' && $_GET['x']) {
	header("Location: {$_G['siteurl']}"); 
	exit;
}
$e6_propaganda_x = 1;
?>