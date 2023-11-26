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


//关注用户
if(empty($model)){
	include_once ("page.class.php");
	if($_GET['page']){
		$page=$_GET['page'];
	}else{
		$page=1;
	}
	$stlist = C::t('#hejin_box#hjbox_users')->fetch_gz_all();
	$totail = count($stlist);
	$number = 30;
	$url = '?action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=users&page={page}';
	$my_page=new PageClass($totail,$number,$page,$url);
	$startnum = $my_page->page_limit;
	$count = $my_page->myde_size;
	
	$stlists = C::t('#hejin_box#hjbox_users')->fetch_gz_limit($startnum,$count);

	$page_string = $my_page->myde_write();

	include template('hejin_box:admin/gzusers');
}
//取消关注用户
elseif($model=='quxiaogz'){
	include_once ("page.class.php");
	$page=$_GET['page'];
	$stlist = C::t('#hejin_box#hjbox_users')->fetch_qxgz_all();
	$totail = count($stlist);
	$number = 30;
	$url = '?action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=users&model=quxiaogz&page={page}';
	$my_page=new PageClass($totail,$number,$page,$url);
	$startnum = $my_page->page_limit;
	$count = $my_page->myde_size;
	
	$stlists = C::t('#hejin_box#hjbox_users')->fetch_qxgz_limit($startnum,$count);

	$page_string = $my_page->myde_write();

	include template('hejin_box:admin/qxgzusers');
}

//获取用户信息
elseif($model=='getuser'){
	loadcache('plugin');
	$plugin = $_G['cache']['plugin']['hejin_box'];
	if($plugin['hjbox_wxgzrz']==2 && $plugin['hjbox_appid'] && $plugin['hjbox_appsecret']){
		if($_GET['formhash']==formhash()){
			if($_GET['uid']){
				if($_GET['page']){
					$page = intval($_GET['page']);
				}else{
					$page = 1;
				}
				$uid = intval($_GET['uid']);
				$userinfo = C::t('#hejin_box#hjbox_users')->fetch_by_id($uid);
				if(count($userinfo)){
					if(!$userinfo['nickname']){
						$openid = $userinfo['openid'];
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
							if($sytime>6000){
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
						
						if($returnaccess){
							$wxuser = getwuserinfo($openid, $returnaccess);
							if($wxuser['nickname']){
								$upuserdata = array();
								$upuserdata['nickname']= addslashes(u2g($wxuser['nickname']));
								$upuserdata['sex']= intval($wxuser['sex']);
								$upuserdata['city']= addslashes(u2g($wxuser['city']));
								$upuserdata['country']= addslashes(u2g($wxuser['country']));
								$upuserdata['province']= addslashes(u2g($wxuser['province']));
								$upuserdata['headimgurl']= addslashes(u2g($wxuser['headimgurl']));
								$upuser = C::t('#hejin_box#hjbox_users')->update_by_id($userinfo['id'],$upuserdata);
								if($upuser){
									$url = 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=users&page='.$page;
									cpmsg(lang('plugin/hejin_box', 'getcg'), $url, 'succeed');	
									exit;	
								}else{
									$url = 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=users&page='.$page;
									cpmsg(lang('plugin/hejin_box', 'getsb'), $url, 'error');	
									exit;	
								}
							}else{
								$url = 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=users&page='.$page;
								cpmsg(lang('plugin/hejin_box', 'getsb'), $url, 'error');
								exit;		
							}
						}else{
							$url = 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=users&page='.$page;
							cpmsg(lang('plugin/hejin_box', 'getsb'), $url, 'error');
							exit;	
						}
					}else{
						$url = 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=users&page='.$page;
						cpmsg(lang('plugin/hejin_box', 'getcg'), $url, 'succeed');	
						exit;	
					}
				}else{
					$url = 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=users&page='.$page;
					cpmsg(lang('plugin/hejin_box', 'getsb'), $url, 'error');	
					exit;	
				}
			}
		}
	}else{
		$url = 'action=plugins&operation=config&do=' . $_GET['do'];
		cpmsg(lang('plugin/hejin_box', 'geterror'), $url, 'error');	
		exit;	
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
//获取用户信息
function getwuserinfo($openid, $returnaccess) {
    $access_token = $returnaccess;
    $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $access_token . "&openid=" . $openid . "&lang=zh_CN";
    $wuser = https_request($url);
    $wuser = json_decode($wuser, true);
    return $wuser;
}

function u2g($a) {
       return is_array($a) ? array_map('u2g', $a) : diconv($a, 'UTF-8', CHARSET);
}

//WWW.fx8.cc
?>