<?php
$wechat = _init_wechat();
$param = array("noncestr"=>random(10),"timestamp"=>TIMESTAMP);
$param['url'] = $_G['siteurl'].substr($_SERVER['REQUEST_URI'],1);
$param['signature'] = getsignature($param);
if(!$_G['cache']['plugin']) loadcache("plugin");
$param['img'] = $_G['cache']['plugin']['zhikai_n5appgl']['wfxmrtb'];
$param = getImg($param);
function getImg($param){
	global $_G,$postlist;
    if(CURSCRIPT == 'forum'){
    	if(CURMODULE == 'forumdisplay' && $_G['forum']['icon']){
        	$param['img'] = $_G['siteurl'].$_G['setting']['attachurl'].'common/'.$_G['forum']['icon'];
        }elseif(CURMODULE == 'viewthread'){
        	$pid = DB::result_first("SELECT pid FROM %t WHERE tid=%d AND first=1 ",array("forum_post",$_G['thread']['tid']) );
        	$query = DB::fetch_all("select tableid,aid FROM %t WHERE tid=%d AND pid=%d",array("forum_attachment",$_G['thread']['tid'],$pid) );
            $attachs = array();
            foreach($query as $v){
            	$attachs[$v['tableid']][] = $v['aid'];
            }
            $a = 0;
            foreach($attachs as $tableid =>$aids){
            	$query = DB::fetch_all("SELECT * FROM %t WHERE %i",array("forum_attachment_".$tableid,DB::field("aid",$aids)) );
                foreach($query as $v){
                	if(!$a && $v['isimage'] != 0){
                    	$param['img'] = $_G['siteurl'].$_G['setting']['attachurl'].'forum/'.$v['attachment'];
                        $a++;
                    }
                }
            }//From www.xhkj5.com
        }
    }elseif($_GET['uid'] && 'home' == CURSCRIPT && 'space' == CURMODULE){
		$param['img'] = avatar($_GET['uid'],"middle",1);
    }
    
	return $param;
}
function _init_wechat(){
	global $_G;
    if(!$_G['cache']['plugin']) loadcache("plugin");
	$return = array();
	$return['appid'] 		= $_G['cache']['plugin']['zhikai_n5appgl']['wfxappid'];
	$return['appsecret']  	= $_G['cache']['plugin']['zhikai_n5appgl']['wfxsecret'];
	return $return;
}
function getsignature($param){
	global $_G;
	$jsapi_ticket = jsapi_ticket($param);
	if(!$jsapi_ticket) return false;
	$param['jsapi_ticket'] = $jsapi_ticket;
	ksort($param);
	$strings = array();
	foreach($param as $k=>$v){
		$strings[] = $k."=".$v;
	}
	$string = implode("&",$strings);
	return sha1($string);
}
function jsapi_ticket($param){
	global $_G;
	$access_token = getAccessToken($param);
	if(!$access_token) return false;
	$dateline = $param['timestamp'];
	$getWay = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$access_token.'&type=jsapi';
	$jsapi_ticket = getcookie("dn5app_jsapi_ticket");
	if($jsapi_ticket){
		return $jsapi_ticket;
	}
	$dn5app_jsapi_ticket = C::t("common_setting")->fetch("dn5app_jsapi_ticket");
    if($dn5app_jsapi_ticket){
        list($jsapi_ticket,$dateline) = explode("|",$dn5app_jsapi_ticket,2);
        if(TIMESTAMP-$dateline<7100){
            dsetcookie("dn5app_jsapi_ticket",$jsapi_ticket,TIMESTAMP-$dateline);
            return $jsapi_ticket;
        }
    }
	$json = dfsockopen($getWay);
	$data = json_decode($json,true);
	if(!$data['errcode'] && $data['ticket']){
		$jsapi_ticket = $data['ticket'];
		$svalue = $jsapi_ticket."|".$dateline;
		if(!$dn5app_jsapi_ticket){
			DB::insert("common_setting",array("skey"=>"dn5app_jsapi_ticket","svalue"=>$svalue));
		}else{
			DB::update("common_setting",array("svalue"=>$svalue) ,array("skey"=>"dn5app_jsapi_ticket") );
		}//Fro m www. xhkj5.com
		dsetcookie("dn5app_jsapi_ticket",$jsapi_ticket,7200);
		return $jsapi_ticket;
	}
	return false;
}
function getAccessToken($param){
	global $_G;
	$wechat = _init_wechat();
	$getWay = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$wechat['appid'].'&secret='.$wechat['appsecret'];
	$dateline = $param['timestamp'];
	$access_token = getcookie("dn5app_access_token");
	if($access_token){
		return $access_token;
	}
	$dn5app_access_token = C::t("common_setting")->fetch("dn5app_access_token");
    if($dn5app_access_token){
        list($access_token,$dateline) = explode("|",$dn5app_access_token,2);
        if(TIMESTAMP-$dateline<7100){
            dsetcookie("dn5app_access_token",$access_token,TIMESTAMP-$dateline);
            return $access_token;
        }   
    }
	$json = dfsockopen($getWay);
	$data = json_decode($json,true);
	if(!$data['errcode'] && $data['access_token']){
		$access_token = $data['access_token'];
		$svalue = $access_token."|".$dateline;
		if(!$dn5app_access_token){
			DB::insert("common_setting",array("skey"=>"dn5app_access_token","svalue"=>$svalue));
		}else{
			DB::update("common_setting",array("svalue"=>$svalue) ,array("skey"=>"dn5app_access_token") );
		}
		
		dsetcookie("dn5app_access_token",$access_token,7200);
		return $access_token;
	}
	return false;
}
$navtitle = str_replace(array(" ",','),array("","_"),$navtitle);
$metadescription = str_replace(array(" ",','),array("","-"),$metadescription);
?>