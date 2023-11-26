<?php
/*
 * CopyRight  : [fx8.cc!] (C)2014-2016
 * Document   : 源码哥：www.fx8.cc，www.ymg6.com
 * Created on : 2016-08-25,11:30:56
 * Author     : 源码哥(QQ：2575163778) wWw.fx8.cc $
 * Description: This is NOT a freeware, use is subject to license terms.
 *              源码哥出品 必属精品。
 *              源码哥源码论坛 全网首发 http://www.fx8.cc；
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

/*define("TOKEN", "weixin");

$wechatObj = new wxboxApi();
if (!isset($_GET['echostr'])) {
    $wechatObj->respond();
}else{
    $wechatObj->valid();
}*/

class wxboxApi
{
    //验证签名
   /* public function valid()
    {
        $echoStr = $_GET["echostr"];
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if($tmpStr == $signature){
            echo $echoStr;
            exit;
        }
    }*/
    //响应消息
    public function respond()
    {
       	$postStr = file_get_contents("php://input");
		if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);

			global $_G;
			$plugininfo = $_G['cache']['plugin']['hejin_box'];
			$openid = $postObj->FromUserName;
			if($openid){
				$user = C::t('#hejin_box#hjbox_users')->fetch_by_openid($openid);
				if(!count($user)){
					$adduserdata = array();
					$adduserdata['openid']= addslashes($openid);
					$adduserdata['gztime']= time();
					$adduser = C::t('#hejin_box#hjbox_users')->insert($adduserdata);
				}else{
					if($user['is_gz']==0){
						$upuserdata = array();
						$upuserdata['is_gz']= 1;
						$upuserdata['gztime']= time();
						$upuser = C::t('#hejin_box#hjbox_users')->update_by_id($user['id'],$upuserdata);
					}
				}
			}

            //消息类型分离
            switch ($RX_TYPE)
            {
                case "event":
                    $result = $this->receiveEvent($postObj);
                    break;
                case "text":
                    $result = $this->receiveText($postObj);
                    break;
                case "image":
                    $result = $this->receiveImage($postObj);
                    break;
                case "location":
                    $result = $this->receiveLocation($postObj);
                    break;
                case "voice":
                    $result = $this->receiveVoice($postObj);
                    break;
                case "video":
                    $result = $this->receiveVideo($postObj);
                    break;
                case "link":
                    $result = $this->receiveLink($postObj);
                    break;
                default:
                    $result = "unknown msg type: ".$RX_TYPE;
                    break;
            }
            //$this->logger("T ".$result);
            echo $result;
        }else {
            echo "";
            exit;
        }
    }

    //接收事件消息
    private function receiveEvent($object)
    {
		global $_G;
		$plugininfo = $_G['cache']['plugin']['hejin_box'];
		$toupiaoinfo = $_G['cache']['plugin']['hejin_toupiao'];
        $content = "";
		$openid = $object->FromUserName;
        switch ($object->Event)
        {
            case "subscribe":
				if($plugininfo['hjbox_sub']){
					if($plugininfo['hjbox_subkeyword'] && $plugininfo['hjbox_subkeyword']==$plugininfo['hjbox_wwebkey']){
						$content[]=array("Title"=>$this->g2u($plugininfo['hjbox_wwebtitle']),  "Description"=>$this->g2u($plugininfo['hjbox_wwebms']), "PicUrl"=>$this->g2u($plugininfo['hjbox_wwebpic']), "Url" =>$_G['siteurl'].'plugin.php?id=hejin_box:index&openid='.$object->FromUserName);
					}
					else if($plugininfo['hjbox_subkeyword']){
						$keywords = addslashes($plugininfo['hjbox_subkeyword']);
						$replyes = C::t('#hejin_box#hjbox_replys')->fetch_img_search($keywords);
						if(count($replyes)){
							$content = array();
							foreach($replyes as $reply){
								if(strpos($reply['url'], 'hejin_') !== false ){
									$url = stripslashes($reply['url']).'&openid='.$object->FromUserName;
								}else{
									if($reply['is_openid']){
										$url = stripslashes($reply['url']).'&openid='.$object->FromUserName;
									}else{
										$url = stripslashes($reply['url']);
									}
								}
                				$content[] = array("Title"=>$this->g2u(stripslashes($reply['title'])),  "Description"=>$this->g2u(stripslashes($reply['content'])), "PicUrl"=>$this->g2u(stripslashes($reply['pic'])), "Url" =>$url);
							}
						}
					}else{
						if($plugininfo['hjbox_subcontent']){
							$content = $this->g2u($plugininfo['hjbox_subcontent']);
						}
					}
				}
                break;
            case "unsubscribe":
				$user = C::t('#hejin_box#hjbox_users')->fetch_by_openid($openid);
				if(count($user)){
					if($user['is_gz']==1){
						$upuserdata = array();
						$upuserdata['is_gz']= 0;
						$upuserdata['gztime']= time();
						$upuser = C::t('#hejin_box#hjbox_users')->update_by_id($user['id'],$upuserdata);
						if($toupiaoinfo['hjtp_qxgzjp']){
							if($upuser){
								$deltpjl = C::t('#hejin_box#hjtp_tpjles')->delete_by_uid(intval($user['id']));
							}
						}
						
							
						
					}
				}
                break;
            case "SCAN":
                $content = "".$object->EventKey;
                break;
            case "CLICK":
				$content = $this->receiveText($object);
                break;
            case "LOCATION":
                //$content = "".$object->Latitude.";".$object->Longitude;
 				$content='';
                break;
            case "VIEW":
                $content = "".$object->EventKey;
                break;
            case "MASSSENDJOBFINISH":
                //$content = "消息ID：".$object->MsgID."，结果：".$object->Status."，粉丝数：".$object->TotalCount."，过滤：".$object->FilterCount."，发送成功：".$object->SentCount."，发送失败：".$object->ErrorCount;
				$content='';
                break;
            default:
                //$content = "receive a new event: ".$object->Event;
 				$content='';
               break;
        }
        if(is_array($content)){
            if (isset($content[0])){
                $result = $this->transmitNews($object, $content);
            }else if (isset($content['MusicUrl'])){
                $result = $this->transmitMusic($object, $content);
            }
        }else{
            $result = $this->transmitText($object, $content);
        }

        return $result;
    }

    //接收文本消息
    private function receiveText($object)
    {
		global $_G;
		$plugininfo = $_G['cache']['plugin']['hejin_box'];
		$toupiaoinfo = $_G['cache']['plugin']['hejin_toupiao'];
		if($object->Content){
       		$keyword = trim($object->Content);
		}else{
       		$keyword = trim($object->EventKey);
		}
		//微首页
		if (strstr($keyword, $this->g2u($plugininfo['hjbox_wwebkey'])) && $plugininfo['hjbox_wweb']){
			$content[]=array("Title"=>$this->g2u($plugininfo['hjbox_wwebtitle']),  "Description"=>$this->g2u($plugininfo['hjbox_wwebms']), "PicUrl"=>$this->g2u($plugininfo['hjbox_wwebpic']), "Url" =>$_G['siteurl'].'plugin.php?id=hejin_box:index&openid='.$object->FromUserName);
			$result = $this->transmitNews($object, $content);
		}
        //多客服人工回复模式
		else if(strstr($this->g2u($plugininfo['hjbox_dkfkey']),$keyword) && $plugininfo['hjbox_duokefu']){
            $result = $this->transmitService($object);
		}
		




        //自动回复模式
        else{
			if(CHARSET=='gbk'){
				$keywords = addslashes($this->u2g($keyword));
			}else{
				$keywords = addslashes($keyword);
			}
			//编号投票
			if($toupiaoinfo['hjtp_numbtp'] && (strtolower(substr($keywords,0,2))=="tp")){
				$openida = $object->FromUserName;
				if($openida){
					$openid = addslashes($openida);
					$user =  C::t('#hejin_box#hjbox_users')->fetch_by_openid($openid);
					if(count($user)){
						$iskey = substr($keywords,2);
						if($iskey){
							if(is_numeric($iskey)){
								$zid = intval($iskey);
							}
						}
						if($zid){
							$zuopin = C::t('#hejin_box#hjtp_zuopins')->fetch_by_id($zid);	
						}else{
							$zuopin = array();
						}
						
						if(count($zuopin)){
						if($zuopin['is_show']!=1){
							$result = $this->transmitText($object, $this->g2u(lang('plugin/hejin_box', 'tpnoa')));//投票不成功
						}else{
							$vote =  C::t('#hejin_box#hjtp_votes')->fetch_by_id(intval($zuopin['vid']));
							if($vote['is_sh']>1){
								$result = $this->transmitText($object, $this->g2u(lang('plugin/hejin_box', 'nocopy')));//投票未开始
							}elseif($vote['vote_time']>time()){
								$result = $this->transmitText($object, $this->g2u(lang('plugin/hejin_box', 'tpnoba')).date("Y-m-d H:i",$vote['vote_time']).$this->g2u(lang('plugin/hejin_box', 'tpnobb')));
							}elseif($vote['end_time']<time()){
								$result = $this->transmitText($object, $this->g2u(lang('plugin/hejin_box', 'tpnoc')));//投票已经结束
							}elseif(($vote['start_time']<time()) && ($vote['over_time']>time()) && $vote['yuliub'] && ($zuopin['toupiaos']>=$vote['yuliub'])){
								$result = $this->transmitText($object, $this->g2u(lang('plugin/hejin_box', 'tpnoda')).$vote['yuliub'].$this->g2u(lang('plugin/hejin_box', 'tpnodb')).date("Y-m-d H:i",$vote['over_time']).$this->g2u(lang('plugin/hejin_box', 'tpnodc')));//报名期间达到投票限制数
							}else{
								
									$today = date('Y-m-d',time());
									if($toupiaoinfo['hjtp_tpxzmos']==2){
										$timedate = 1111111111;
									}else{
										$timedate = strtotime($today);
									}
									$utpjls = C::t('#hejin_box#hjtp_tpjles')->fetch_today_uid_vid(intval($user['id']),intval($vote['id']),$timedate);
									$ip = $this->GetIP();//获取ip流程
										if(count($utpjls)<$vote['tpnub']){
											
											if($toupiaoinfo['hjtp_tpxznub']){
												$usetpjl = C::t('#hejin_box#hjtp_tpjles')->fetch_by_zvudid($zid,intval($vote['id']),intval($user['id']),$timedate);
												if(count($usetpjl)){
													$tpxznub = 0;
												}else{
													$tpxznub = 1;
												}
											}else{
												$tpxznub = 1;
											}
											
											if($tpxznub){//判断用户是否已经给这个用户投过一票
												
												//写投票流程	
												$tpdata = array();
												$tpdata['zid'] = $zid;
												$tpdata['uid'] = intval($user['id']);
												$tpdata['vid'] = intval($vote['id']);
												$tpdata['openid'] = $openid;
												$tpdata['ips'] = addslashes($ip);
												$tpdata['timedate'] = $timedate;
												$tpdata['yuliua'] = time();
												$addtpjl = C::t('#hejin_box#hjtp_tpjles')->insert($tpdata);
												if($addtpjl){
													//$data['status']=108;//投票成功
													$zptpup = array();
															if($toupiaoinfo['hjtp_qxgzjp']){
																if($zuopin['yuliua']){
																	$zptpjls = C::t('#hejin_toupiao#hjtp_tpjles')->fetch_zid_all($zid);
																	$zptpup['toupiaos'] = count($zptpjls);
																	$zptpup['yuliua'] = intval($zuopin['yuliua']+1);
																}else{
																	$zptpup['yuliua'] = intval($zuopin['toupiaos']+1);
																	$zptpjls = C::t('#hejin_toupiao#hjtp_tpjles')->fetch_zid_all($zid);
																	$zptpup['toupiaos'] = count($zptpjls);
																}
															}else{
																$zptpup['toupiaos'] = intval($zuopin['toupiaos']+1);
															}
													
													$upzptps = C::t('#hejin_box#hjtp_zuopins')->update_by_id($zid,$zptpup);
													$votetpup = array();
													$votetpup['toupiaos'] = intval($vote['toupiaos']+1);
													$upvotetp =  C::t('#hejin_box#hjtp_votes')->update_by_id(intval($vote['id']),$votetpup);
													if($toupiaoinfo['hjtp_tpjl'] && $toupiaoinfo['hjtp_tpjlnub']){
														$upjifen = array();
														$upjifen['yuliua'] = intval($user['yuliua']+$toupiaoinfo['hjtp_tpjlnub']);
														$jifenzj =  C::t('#hejin_box#hjbox_users')->update_by_id(intval($user['id']),$upjifen);
													}
													if($upzptps && $upvotetp){
														//投票成功提示
														if(strpos($zuopin['pica'], '://')==false){
															$pic = $_G['siteurl'].'source/plugin/hejin_toupiao/'.$zuopin['pica'];
														}else{
															$pic = $zuopin['pica'];
														}
					
														$content[]=array("Title"=>$this->g2u(lang('plugin/hejin_box', 'tpnoea')).$zuopin['id'].$this->g2u(lang('plugin/hejin_box', 'tpnoeb')).$this->g2u($zuopin['zpname']).$this->g2u(lang('plugin/hejin_box', 'tpnoec')),  "Description"=>$this->g2u(lang('plugin/hejin_box', 'tpnoed')).($zuopin['toupiaos']+1).$this->g2u(lang('plugin/hejin_box', 'tpnoee')), "PicUrl"=>$this->g2u($pic), "Url" =>$_G['siteurl'].'plugin.php?id=hejin_toupiao&model=detail&zid='.$zid);
														if($toupiaoinfo['hjtp_tpjl'] && $toupiaoinfo['hjtp_tpjlnub'] && $toupiaoinfo['hjtp_jfxfurl']){
															$content[]=array("Title"=>$this->g2u($toupiaoinfo['hjtp_jfxftitle']),  "Description"=>'', "PicUrl"=>'http://ap.haoxiangc.com/ggk.jpg', "Url" =>$toupiaoinfo['hjtp_jfxfurl']);
														}
														
														$result = $this->transmitNews($object, $content);
													}
												}else{
													$result = $this->transmitText($object, $this->g2u(lang('plugin/hejin_box', 'tpnof')));//投票不成功
												}
											}else{
													$result = $this->transmitText($object, $this->g2u($toupiaoinfo['hjtp_tpxzts']));//今日已经给这个用户投过票了
											}
										}else{
											if($toupiaoinfo['hjtp_tpxzmos']==2){
												$result = $this->transmitText($object, $this->g2u(lang('plugin/hejin_box', 'tpnoga')));//此用户本次活动已无法投票
											}else{
												$result = $this->transmitText($object, $this->g2u(lang('plugin/hejin_box', 'tpnogb')));//此用户今日已无法投票
											}
										}
								

		
							}
						}					
					
						}else{
							$result = $this->transmitText($object, $this->g2u($toupiaoinfo['hjtp_nozpts']));
						}


					}else{
						$result = $this->transmitText($object, $this->g2u(lang('plugin/hejin_box', 'tpnoh')));
					}
				}else{
					$result = $this->transmitText($object, $this->g2u(lang('plugin/hejin_box', 'tpnoh')));
				}

			}else{

				$replyes = C::t('#hejin_box#hjbox_replys')->fetch_img_search($keywords);
				if(count($replyes)){
					$content = array();
					foreach($replyes as $reply){
						if(strpos($reply['url'], 'hejin_') !== false ){
							$url = stripslashes($reply['url']).'&openid='.$object->FromUserName;
						}else{
							if($reply['is_openid']){
								$url = stripslashes($reply['url']).'&openid='.$object->FromUserName;
							}else{
								$url = stripslashes($reply['url']);
							}
						}
                		$content[] = array("Title"=>$this->g2u(stripslashes($reply['title'])),  "Description"=>$this->g2u(stripslashes($reply['content'])), "PicUrl"=>$this->g2u(stripslashes($reply['pic'])), "Url" =>$url);
					}
				}else{
					$textreply = C::t('#hejin_box#hjbox_replys')->fetch_text_search($keywords);
					if(count($textreply)){
						$content = $this->g2u(stripslashes($textreply['content']));
					}else{
						if($plugininfo['hjbox_nokey']){
							if($plugininfo['hjbox_nokey']==$plugininfo['hjbox_wwebkey']){
								$content[]=array("Title"=>$this->g2u($plugininfo['hjbox_wwebtitle']),  "Description"=>$this->g2u($plugininfo['hjbox_wwebms']), "PicUrl"=>$this->g2u($plugininfo['hjbox_wwebpic']), "Url" =>$_G['siteurl'].'plugin.php?id=hejin_box:index&openid='.$object->FromUserName);
							}else{
								$keywords = addslashes($plugininfo['hjbox_nokey']);
								$replyes = C::t('#hejin_box#hjbox_replys')->fetch_img_search($keywords);
								if(count($replyes)){
									$content = array();
									foreach($replyes as $reply){
										if(strpos($reply['url'], 'hejin_') !== false ){
											$url = stripslashes($reply['url']).'&openid='.$object->FromUserName;
										}else{
											if($reply['is_openid']){
												$url = stripslashes($reply['url']).'&openid='.$object->FromUserName;
											}else{
												$url = stripslashes($reply['url']);
											}
										}
								
                						$content[] = array("Title"=>$this->g2u(stripslashes($reply['title'])),  "Description"=>$this->g2u(stripslashes($reply['content'])), "PicUrl"=>$this->g2u(stripslashes($reply['pic'])), "Url" =>$url);
								
									}
								}
							}
						}else{
							if($plugininfo['hjbox_noanswer']){
								$content = $this->g2u($plugininfo['hjbox_noanswer']);
							}
						}
					}
				}
			
            	if($object->Content){
					if($content){
            			if(is_array($content)){
               				if (isset($content[0]['PicUrl'])){
                    			$result = $this->transmitNews($object, $content);
                			}else if (isset($content['MusicUrl'])){
                    			$result = $this->transmitMusic($object, $content);
                			}
            			}else{
                			$result = $this->transmitText($object, $content);
            			}
					}
				}
				
			}
        }
		if($object->Content){
        	return $result;
		}else{
        	return $content;
		}
		
    }





    //接收图片消息
    private function receiveImage($object)
    {
        //$content = array("MediaId"=>$object->MediaId);
        //$result = $this->transmitImage($object, $content);
        //return $result;
    }

    //接收位置消息
    private function receiveLocation($object)
    {
        //$content = "".$object->Location_X."".$object->Location_Y."".$object->Scale."".$object->Label;
        //$result = $this->transmitText($object, $content);
        //return $result;
    }

    //接收语音消息
    private function receiveVoice($object)
    {
       /* if (isset($object->Recognition) && !empty($object->Recognition)){
            $content = "".$object->Recognition;
            $result = $this->transmitText($object, $content);
        }else{
            $content = array("MediaId"=>$object->MediaId);
            $result = $this->transmitVoice($object, $content);
        }

        return $result;*/
    }

    //接收视频消息
    private function receiveVideo($object)
    {
       /* $content = array("MediaId"=>$object->MediaId, "ThumbMediaId"=>$object->ThumbMediaId, "Title"=>"", "Description"=>"");
        $result = $this->transmitVideo($object, $content);
        return $result;*/
    }

    //接收链接消息
    private function receiveLink($object)
    {
        $content = "".$object->Title."".$object->Description."".$object->Url;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    //回复文本消息
    private function transmitText($object, $content)
    {
        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }

    //回复图片消息
    private function transmitImage($object, $imageArray)
    {
        $itemTpl = "<Image>
    <MediaId><![CDATA[%s]]></MediaId>
</Image>";

        $item_str = sprintf($itemTpl, $imageArray['MediaId']);

        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[image]]></MsgType>
$item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复语音消息
    private function transmitVoice($object, $voiceArray)
    {
        $itemTpl = "<Voice>
    <MediaId><![CDATA[%s]]></MediaId>
</Voice>";

        $item_str = sprintf($itemTpl, $voiceArray['MediaId']);

        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[voice]]></MsgType>
$item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复视频消息
    private function transmitVideo($object, $videoArray)
    {
        $itemTpl = "<Video>
    <MediaId><![CDATA[%s]]></MediaId>
    <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
    <Title><![CDATA[%s]]></Title>
    <Description><![CDATA[%s]]></Description>
</Video>";

        $item_str = sprintf($itemTpl, $videoArray['MediaId'], $videoArray['ThumbMediaId'], $videoArray['Title'], $videoArray['Description']);

        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[video]]></MsgType>
$item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复图文消息
    private function transmitNews($object, $newsArray)
    {
        if(!is_array($newsArray)){
            return;
        }
        $itemTpl = "    <item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
    </item>
";
        $item_str = "";
        foreach ($newsArray as $item){
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }
        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>%s</ArticleCount>
<Articles>
$item_str</Articles>
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
        return $result;
    }

    //回复音乐消息
    private function transmitMusic($object, $musicArray)
    {
        $itemTpl = "<Music>
    <Title><![CDATA[%s]]></Title>
    <Description><![CDATA[%s]]></Description>
    <MusicUrl><![CDATA[%s]]></MusicUrl>
    <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
</Music>";

        $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);

        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[music]]></MsgType>
$item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复多客服消息
    private function transmitService($object)
    {
        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[transfer_customer_service]]></MsgType>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }
	
    private function u2g($a) {
        return is_array($a) ? array_map('u2g', $a) : diconv($a, 'UTF-8', CHARSET);
    }
    private function g2u($a) {
        return is_array($a) ? array_map('g2u', $a) : diconv($a, CHARSET, 'UTF-8');
    }

	private function GetIP(){
		$ip=false;
		if(!empty($_SERVER["HTTP_CLIENT_IP"])){
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
			if ($ip) { array_unshift($ips, $ip); $ip = FALSE; }
			for ($i = 0; $i < count($ips); $i++) {
				if (!eregi ("^(10|172\.16|192\.168)\.", $ips[$i])) {
					$ip = $ips[$i];
					break;
				}
			}
		}
		return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
	}

	private function get_ip_data($ips){
		$ip=file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=".$ips);
		$ip = json_decode($ip, true);
		if($ip['code']){
			return false;
		}
		$data = $ip['data'];
		return $data;
	}

	
}

//WWW.fx8.cc
?>