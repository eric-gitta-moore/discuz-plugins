<?php

if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if($e6_propaganda['open'] && (!$e6_propaganda['group'] or in_array($_G['groupid'], $e6_propaganda['group'])) && $_G['uid']) {
	@set_time_limit(1000);
	@ignore_user_abort(TRUE);
	loadcache('e6_pro_global');
	if ($_G['cache']['e6_pro_global'] <= TIMESTAMP) {
		if (!discuz_process::islocked('e6_pro_uid'.$_G['uid'], 60)){
			if ($e6_propaganda['active_num']) {
				for ($n=1; $n<=$e6_propaganda['active_num']; $n++) {
					$active_arr[] ="activation{$n}=0";
				}
				$active_where = ' AND `fuid1`=\''.$_G['uid'].'\' AND (' .implode(' OR ', $active_arr). ')';
				$active_data = C::t('#e6_propaganda#e6_pro_user')->fetch_all_by_search($active_where);
				foreach ($active_data as $v) {
					$pro_user[$v['uid']] = $v;
					$active_uid[] = $v['uid'];
				}
				$active_uid && $active_uids = implode(',', $active_uid);
				if ($active_uids) {
					$data = C::t('#e6_propaganda#e6_pro_user')->fetch_all_by_member($active_uids);
					foreach($data as $v) {
						for($n=1; $n<=$e6_propaganda['active_num']; $n++) {
							$active_money = array_sum($e6_propaganda['active_money'][$n]);
							if ($active_money && !$pro_user[$v['uid']]['activation'.$n]) {
								$online = $e6_propaganda['active_condition'][$n]['online'] ? $e6_propaganda['active_condition'][$n]['online'] : 0;
								$posts = $e6_propaganda['active_condition'][$n]['posts'] ? $e6_propaganda['active_condition'][$n]['posts'] : 0;
								$groupid = $e6_propaganda['active_condition'][$n]['groupid'] ? $e6_propaganda['active_condition'][$n]['groupid'] : $v['groupid'];
								if ($v['oltime'] >= $online && $v['posts'] >= $posts && $groupid == $v['groupid']) {
									${'user_money'.$_G['uid']} = pro_money($e6_propaganda['active_money'][$n], 4, array('n'=>$n, 'username'=>$v['username']), $_G['uid'], ${'user_money'.$_G['uid']});
									C::t('#e6_propaganda#e6_pro_user')->update($v['uid'], array('activation'.$n => 1));
									$user_active_array = '';
									!$pro_count[$_G['uid']] && $pro_count[$_G['uid']] = C::t('#e6_propaganda#e6_pro_user_count')->fetch($_G['uid']);
									if ($pro_count[$_G['uid']]['active']) $user_active_array = unserialize($pro_count[$_G['uid']]['active']);
									if($user_active_array[$n]) {
										$user_active_array[$n] = $user_active_array[$n] + 1;
									} else {
										$user_active_array[$n] = 1;
									}
									$user_active = $pro_count[$_G['uid']]['active'] = serialize($user_active_array);
									C::t('#e6_propaganda#e6_pro_user_count')->update_by_count($_G['uid'], "`money`=`money`+'{$active_money}',`active`='{$user_active}'");
								}
							}
						}
					}
				}
			}
			if ($e6_propaganda['vip_open'] && $e6_propaganda['group_id'] && $e6_propaganda['dividend'][$_G['groupid']]) {
				if (!$group_list) {
					foreach(C::t('common_usergroup')->fetch_all_by_type('special', '0') as $group) {
						$group_list[$group['groupid']] = $group['grouptitle'];
					}
				}
				if (file_exists("{$pro_module}vip_extra.php")) {
					if (!function_exists('vip_extra_send')) {
						require "{$pro_module}vip_extra.php";
					}
					vip_extra_send();
				} else {
					$e6_groupid_L = $e6_propaganda['group_id'];
					$e6_propaganda['group_id'] = $e6_propaganda['group_id'][0];
					$vip_sql = get_multi_sql($_G['uid'], $e6_propaganda['dividend'][$_G['groupid']]);
					$vip_data = C::t('#e6_propaganda#e6_pro_user')->fetch_all_by_vip($vip_sql);
					foreach($vip_data as $v) {
						$pro_user[$v['uid']] = $v;
						$v['extgrouparray'] = explode("\t", $v['extgroupids']);
						if ($v['groupid'] == $e6_propaganda['group_id'] or in_array($e6_propaganda['group_id'], $v['extgrouparray'])) {
							for ($n = 1; $n<=10; $n++) {
								$vip_money = $e6_propaganda['multi_vip'][$e6_propaganda['group_id']][$n]['money'];
								$vip_type = $e6_propaganda['multi_vip'][$e6_propaganda['group_id']][$n]['type'];
								$v['Y'] = '';
								if ($v['fuid'.$n] && $vip_money) {
									if ($v['fuid'.$n] != $_G['uid']) {
										!$e6_user[$v['fuid'.$n]] && $e6_user[$v['fuid'.$n]] = C::t('common_member')->fetch($v['fuid'.$n]);
										$v['fuid_groupid'] = $e6_user[$v['fuid'.$n]]['groupid'];
									} else {
										$v['fuid_groupid'] = $_G['groupid'];
									}
									if ($e6_propaganda['dividend'][$v['fuid_groupid']] >= $n) {
										$v['Y'] = 1;
									}
								}
								if ($v['Y']) {
									${'user_money'.$v['fuid'.$n]} = pro_money(array($vip_type => $vip_money), 5, array('n'=>$n, 'username'=>$v['username'], 'vip'=>$group_list[$e6_propaganda['group_id']]), $v['fuid'.$n], ${'user_money'.$v['fuid'.$n]});
									if ($n == 1) {
										$user_upvip_array = '';
										!$pro_count[$v['fuid'.$n]] && $pro_count[$v['fuid'.$n]] = C::t('#e6_propaganda#e6_pro_user_count')->fetch($v['fuid'.$n]);
										if ($pro_count[$v['fuid'.$n]]['upvip']) $user_upvip_array = unserialize($pro_count[$v['fuid'.$n]]['upvip']);
										if($user_upvip_array[$e6_propaganda['group_id']]) {
											$user_upvip_array[$e6_propaganda['group_id']] = $user_upvip_array[$e6_propaganda['group_id']] + 1;
										} else {
											$user_upvip_array[$e6_propaganda['group_id']] = 1;
										}
										$user_upvip = $pro_count[$v['fuid'.$n]]['upvip'] = serialize($user_upvip_array);
										$set_upvip = ",`upvip`='{$user_upvip}'";
									}
									C::t('#e6_propaganda#e6_pro_user_count')->update_by_count($v['fuid'.$n], "`money`=`money`+'{$vip_money}'{$set_upvip}");
									C::t('#e6_propaganda#e6_pro_user')->update($v['uid'], array('activation'.$n => 1));
									if ($e6_propaganda['paymsg'] == 1) {
										notification_add($v['fuid'.$n], 'system', 'system_notice', array(
											'subject' => pro_lang('vip_msg_title'),
											'message' => pro_lang('vip_msg_content', array('n'=>$n, 'username'=>$_G['username'], 'vip'=>$group_list[$e6_propaganda['group_id']])),
											'from_id' => 0,
											'from_idtype' => 'e6_pro'
										),1);
									}
								}
							}
							C::t('#e6_propaganda#e6_pro_user')->update($v['uid'], array('vip'=>1));
						}
					}
					$e6_propaganda['group_id'] = $e6_groupid_L;
				}	
			}
			if ($e6_propaganda['paytype'] && $e6_propaganda['dividend'][$_G['groupid']]) {
				$over_date = C::t('#e6_propaganda#e6_pro_clientorder')->fetch_by_date();
				C::t('#e6_propaganda#e6_pro_clientorder')->insert_by_orderid($over_date);
				if ($e6_propaganda['paycard']) {
					C::t('#e6_propaganda#e6_pro_clientorder')->insert_by_card($over_date);
				}
				$orderid_data = C::t('#e6_propaganda#e6_pro_clientorder')->fetch_all_by_orderid();
				foreach($orderid_data as $v) {
					!$pro_user[$v['uid']] && $pro_user[$v['uid']] = C::t('#e6_propaganda#e6_pro_user')->fetch($v['uid']);
					!$e6_user[$v['uid']] && $e6_user[$v['uid']] = C::t('common_member')->fetch($v['uid']);
					
					for($n =1; $n <= 10; $n++) {
						$pay_money = $pay_type = $fuid_n = '';
						$fuid_n = $pro_user[$v['uid']]['fuid'.$n];
						if ($fuid_n) {
							if ($e6_propaganda['paytype'] == 1) {
								$pay_money = $e6_propaganda['multi_pay'][$n]['money'];
								$pay_type = $e6_propaganda['multi_pay'][$n]['type'];
							} else {
								$pay_money = (int)($e6_propaganda['pay_money2'] * $v['price'] * ($e6_propaganda['multi_pay'][$n]['percentage']/100));
								$pay_type = $e6_propaganda['pay_type2'];
							}
							if ($pay_money && $pay_type) {
								!$e6_user[$fuid_n] && $e6_user[$fuid_n] = C::t('common_member')->fetch($fuid_n);
								if ($e6_propaganda['dividend'][$e6_user[$fuid_n]['groupid']] >= $n) {
									$log_type = $v['type'] == 0 ? '6a' : '6b';
									${'user_money'.$fuid_n} = pro_money(array($pay_type	=>	$pay_money), $log_type, array('n'=>$n, 'username'=>$e6_user[$v['uid']]['username'], 'num'=>$v['price']), $fuid_n, ${'user_money'.$fuid_n});
									$set_paymoney = $n == 1 ? ",`paymoney`=`paymoney`+{$v['price']}" : '';
									C::t('#e6_propaganda#e6_pro_user_count')->update_by_count($fuid_n, "`money`=`money`+'{$pay_money}'{$set_paymoney}");
									if ($e6_propaganda['paymsg'] == 1) {
										notification_add($fuid_n, 'system', 'system_notice', array(
											'subject' => pro_lang('pay_msg_title'),
											'message' => pro_lang('pay_msg_content', array('n'=>$n, 'username'=>$e6_user[$v['uid']]['username'], 'num'=>$v['price'], 'money'=>$pay_money.$_G['setting']['extcredits'][$pay_type]['title'])),
											'from_id' => 0,
											'from_idtype' => 'e6_pro'
										),1);
									}
								}
							}
						} else {
							break;
						}
					}
				}
				C::t('#e6_propaganda#e6_pro_clientorder')->update_by_pay();
			}
			discuz_process::unlock('e6_pro_uid'.$_G['uid']);
		}
		savecache('e6_pro_global', TIMESTAMP + 60);
	}
}

?>