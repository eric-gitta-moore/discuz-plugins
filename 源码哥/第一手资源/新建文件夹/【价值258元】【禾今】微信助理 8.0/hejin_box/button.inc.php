<?php
/*
 * 出处：草根吧
 * 官网: Www.fx8.cc
 * 备用网址: www.ymg6.com (请收藏备用!)
 * 技术支持/更新维护：QQ 154606914
 * 
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require_once DISCUZ_ROOT.'./source/plugin/hejin_box/config.inc.php';
$model = addslashes($_GET['model']);
if(submitcheck('add_button')){
	if($_POST['sid']){
		$sid = intval($_POST['sid']);
		$fendhs = C::t('#hejin_box#hjbox_buttons')->fetch_fen_sid($sid);
		if(count($fendhs)>4){
			$dhman = 0;	
		}else{
			$dhman = 1;	
		}
	}else{
		$zhudhs = C::t('#hejin_box#hjbox_buttons')->fetch_zhu_all();
		if(count($zhudhs)>2){
			$dhman = 0;	
		}else{
			$dhman = 1;	
		}
	}
	if($dhman){
		$addcaidan = array();
		$addcaidan['type'] =  intval($_POST['type']);
		$addcaidan['title'] =  addslashes($_POST['title']);
		$addcaidan['content'] =  addslashes($_POST['content']);
		$addcaidan['status'] =  intval($_POST['status']);
		if($_POST['sid']){
			$addcaidan['sid'] =  intval($_POST['sid']);
		}
		$addcd = C::t('#hejin_box#hjbox_buttons')->insert($addcaidan);
		if($addcd){
			$okurl = 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=button';
			cpmsg(lang('plugin/hejin_box', 'adddhcg'), $okurl, 'succeed');
		}
	}else{
		$url = 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=button';
		if($_POST['sid']){
			cpmsg(lang('plugin/hejin_box', 'fencdman'), $url, 'error');
		}else{
			cpmsg(lang('plugin/hejin_box', 'zhucdman'), $url, 'error');
		}
	}
}
if(submitcheck('edit_button')){
	if($_POST['id']){
		$id = intval($_POST['id']);
		$updhdata = array();
		$updhdata['type'] = intval($_POST['type']);
		$updhdata['title'] =  addslashes($_POST['title']);
		$updhdata['content'] =  addslashes($_POST['content']);
		$updhdata['status'] = intval($_POST['status']);
		$editcd = C::t('#hejin_box#hjbox_buttons')->update_by_id($id,$updhdata);
		if($editcd){
			$okurl = 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=button';
			cpmsg(lang('plugin/hejin_box', 'editdhcg'), $okurl, 'succeed');
		}
	}
}


if(empty($model)){
	loadcache('plugin');
	$plugin = $_G['cache']['plugin']['hejin_box'];
	$token =  C::t('#hejin_box#hjbox_token')->fetch_by_id(1);
		if($plugin['hjbox_appid'] && $plugin['hjbox_appsecret']){
			$zhu = C::t('#hejin_box#hjbox_buttons')->fetch_zhu_all();
			$leixin = array(
				1=>lang('plugin/hejin_box', 'caidanlxa'),
				2=>lang('plugin/hejin_box', 'caidanlxb'),
				3=>lang('plugin/hejin_box', 'caidanlxc'),
				4=>lang('plugin/hejin_box', 'caidanlxd'),
				5=>lang('plugin/hejin_box', 'caidanlxe'),
			);
			include template('hejin_box:admin/button');
		}else{
			$url = 'action=plugins&operation=config&do=' . $_GET['do'];
			cpmsg(lang('plugin/hejin_box', 'apperror'), $url, 'error');	
		}
}

else if($model == 'add'){
	if($_GET['sid']){
		$sid = intval($_GET['sid']);
	}
	include template('hejin_box:admin/addbutton');
}
else if($model == 'edit'){
	if($_GET['id']){
		$id = intval($_GET['id']);
		$dhinfo = C::t('#hejin_box#hjbox_buttons')->fetch_by_id($id);
		include template('hejin_box:admin/editbutton');
	}
}

else if($model == 'del'){
	if($_GET['formhash']==formhash()){
		if($_GET['id']){
			$id = intval($_GET['id']);
			$dhinfo = C::t('#hejin_box#hjbox_buttons')->fetch_by_id($id);
			if($dhinfo['sid']){
				$bnsc = 1;
			}else{
				$fendhs = C::t('#hejin_box#hjbox_buttons')->fetch_fen_sid(intval($dhinfo['id']));
				if(count($fendhs)){
					$bnsc = 0;
				}else{
					$bnsc = 1;
				}
			}
			if($bnsc){
				$deldh = C::t('#hejin_box#hjbox_buttons')->delete_by_id($id);
				if($deldh){
					$okurl = 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=button';
					cpmsg(lang('plugin/hejin_box', 'deldhcg'), $okurl, 'succeed');
				}
			}else{
					$errorurl = 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=button';
					cpmsg(lang('plugin/hejin_box', 'deldhe'), $errorurl, 'error');
			}
		}
	}
}

else if($model == 'save'){
	loadcache('plugin');
	$plugin = $_G['cache']['plugin']['hejin_box'];
	if($plugin['hjbox_appid']&&$plugin['hjbox_appsecret']){
		
					$token =  C::t('#hejin_box#hjbox_token')->fetch_by_id(1);
					if(!count($token)){
						$access_token = getaccesstoken($plugin['hjbox_appid'], $plugin['hjbox_appsecret']);
						if($access_token){
							$addtokendata = array(
								'id'=>1,
								'access_token' => addslashes($access_token),
								'cj_time'=>time(),
							);
							$addtoken = C::t('#hejin_box#hjbox_token')->insert($addtokendata);
							$returnaccess = $access_token;
						}
					}else{
						$sytime = time()-$token['cj_time'];
						if($sytime>7000){
							$access_token = getaccesstoken($plugin['hjbox_appid'], $plugin['hjbox_appsecret']);
							if($access_token){
								$uptokendata = array(
									'access_token' => addslashes($access_token),
									'cj_time'=>time(),
								);
								$uptoken = C::t('#hejin_box#hjbox_token')->update_by_id(1,$uptokendata);
								$returnaccess = $access_token;
							}
						}else{
							$returnaccess = $token['access_token'];
						}
					}

					$leixin = array(
							1=>'view',
							2=>'click',
							3=>'scancode_push',
							4=>'pic_photo_or_album',
							5=>'location_select',
					);
					$zhudhs = C::t('#hejin_box#hjbox_buttons')->fetch_azhu_all();
					$zhunub = count($zhudhs);
					$dharray = '{"button":[';
					foreach($zhudhs as $key=>$zhudh){
						$fendhs = C::t('#hejin_box#hjbox_buttons')->fetch_afen_sid(intval($zhudh['id']));
						if(count($fendhs)){
							$dharray.='{"name":"'.g2u($zhudh['title']).'","sub_button":[';
							foreach($fendhs as $keys=>$fendh){
								if($fendh['type']==1){
									$ftype='url';
								}else{
									$ftype='key';
								}
								if($keys==count($fendhs)-1){
									$dharray.='{"type":"'.$leixin[$fendh['type']].'","name":"'.g2u($fendh['title']).'","'.$ftype.'":"'.g2u($fendh['content']).'"}';
								}else{
									$dharray.='{"type":"'.$leixin[$fendh['type']].'","name":"'.g2u($fendh['title']).'","'.$ftype.'":"'.g2u($fendh['content']).'"},';
								}
							}
							if($key==$zhunub-1){
								$dharray.=']}';
							}else{
								$dharray.=']},';
							}
			
						}else{
							if($zhudh['type']==1){
								$type='url';
							}else{
								$type='key';
							}
							if($key==$zhunub-1){
									$dharray.='{"type":"'.$leixin[$zhudh['type']].'","name":"'.g2u($zhudh['title']).'","'.$type.'":"'.g2u($zhudh['content']).'"}';
							}else{
								$dharray.='{"type":"'.$leixin[$zhudh['type']].'","name":"'.g2u($zhudh['title']).'","'.$type.'":"'.g2u($zhudh['content']).'"},';
							}
						}
					}
				$dharray.=']}';
		
        $menuurl = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$returnaccess;
        $res = https_request($menuurl, $dharray);
        $zhuangtai = json_decode($res, true);
		if($zhuangtai['errcode']==0){
			$okurl = 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=button';
			cpmsg(lang('plugin/hejin_box', 'dhgxcg'), $okurl, 'succeed');
		}else{
			 print_r($zhuangtai);
		}
	}
}




else if($model == 'cztoken'){
	loadcache('plugin');
	$plugin = $_G['cache']['plugin']['hejin_box'];
	if($plugin['hjbox_appid']&&$plugin['hjbox_appsecret']){
					$token =  C::t('#hejin_box#hjbox_token')->fetch_by_id(1);
					if(!count($token)){
						$access_token = getaccesstoken($plugin['hjbox_appid'], $plugin['hjbox_appsecret']);
						if($access_token){
							$addtokendata = array(
								'id'=>1,
								'access_token' => addslashes($access_token),
								'cj_time'=>time(),
							);
							$addtoken = C::t('#hejin_box#hjbox_token')->insert($addtokendata);
						}
					}else{
							$access_token = getaccesstoken($plugin['hjbox_appid'], $plugin['hjbox_appsecret']);
							if($access_token){
								$uptokendata = array(
									'access_token' => addslashes($access_token),
									'cj_time'=>time(),
								);
								$uptoken = C::t('#hejin_box#hjbox_token')->update_by_id(1,$uptokendata);
							}
					}
	}
}





function https_request($url, $data = null) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}
//获取access_token
function getaccesstoken($appid, $appsecret) {
    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
    $result = https_request($url);
    $jsoninfo = json_decode($result, true);
    $access_token = $jsoninfo["access_token"];
    return $access_token;
}

function u2g($a) {
        return is_array($a) ? array_map('u2g', $a) : diconv($a, 'UTF-8', CHARSET);
}
function g2u($a) {
        return is_array($a) ? array_map('g2u', $a) : diconv($a, CHARSET, 'UTF-8');
}

//WWW.fx8.cc
?>