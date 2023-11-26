<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: class_sanree_weixin.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class wechatCallbackapi {
	private $cmd = '';
	var $isdebug = false;
	var $fromUsername;
	var $toUsername;
	var $extcmd ='';
	var $welcome = '';	
	
	public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
        	echo $echoStr;
			$this->responseMsg();
        	exit;
        }
    }
	
	function logResult($log='', $islog = true) {
	
		global $_G;
		$config = $_G['cache']['plugin']['sanree_weixin'];
		if ($config['islog']!=1 || !$islog) {
		
			return;
			
		}
		$file= 'sanree_weixin';
		$yearmonth = dgmdate(TIMESTAMP, 'Ym', $_G['setting']['timeoffset']);
		$logdir = DISCUZ_ROOT.'./data/log/';
		$logfile = $logdir.$yearmonth.'_'.$file.'.php';
		if(@filesize($logfile) > 2048000) {
			$dir = opendir($logdir);
			$length = strlen($file);
			$maxid = $id = 0;
			while($entry = readdir($dir)) {
				if(strpos($entry, $yearmonth.'_'.$file) !== false) {
					$id = intval(substr($entry, $length + 8, -4));
					$id > $maxid && $maxid = $id;
				}
			}
			closedir($dir);

			$logfilebak = $logdir.$yearmonth.'_'.$file.'_'.($maxid + 1).'.php';
			@rename($logfile, $logfilebak);
		}
		if($fp = @fopen($logfile, 'a')) {
			@flock($fp, 2);
			if(!is_array($log)) {
				$log = array($log);
			}
			foreach($log as $tmp) {
				fwrite($fp, "<?PHP exit;?>\t".str_replace(array('<?', '?>'), '', $tmp)."\n");
			}
			fclose($fp);
		}
	}
	
	public function filter_cmd($data){
	    $data = trim($data);
		$this->cmd = '';
	    if ($data[0]=='@') {
		    $nowline = substr($data,1);
			$nlen = strlen($nowline);
			if ($nlen<1) return;
			$cmdline = explode(" ", $nowline);	
			$this->cmd = strtolower(daddslashes(trim($cmdline[0])));		
		} else {
		    if (strpos($data, ' ')>0) {
				$this->extcmd = explode(" ", strtolower($data));	 
			}
		}
	}
	
	public function test($cmd = '@sanree'){
	
	    $postStr = "<xml><ToUserName><![CDATA[gh_sanree]]></ToUserName>
<FromUserName><![CDATA[sanree]]></FromUserName>
<CreateTime>123456789</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[$cmd]]></Content>
<MsgId>1234567890</MsgId>
</xml>";
        $this->isdebug = true;
		$this->sanreecmd($postStr);
		
	}
    public function responseMsg($islog = true) {
		global $_G;		
		$postStr = $_GET['WXPOST'];//$GLOBALS["HTTP_RAW_POST_DATA"];
		$this->logResult('POST_DATA['.$postStr.']', $islog);	
		$this->sanreecmd($postStr, true, $islog);	
		
	}
	function TextOut($msg) {
		$time = time();
		$textTpl = "<xml>
					<ToUserName><![CDATA[".$this->fromUsername."]]></ToUserName>
					<FromUserName><![CDATA[".$this->toUsername."]]></FromUserName>
					<CreateTime>".$time."</CreateTime>
					<MsgType><![CDATA[text]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>0</FuncFlag>
					</xml>"; 
		$this->outmsg($msg,$textTpl);	
	}
	function MusicOut($url) {
		$time = time();
		$textTpl = " <xml>
<ToUserName><![CDATA[".$this->fromUsername."]]></ToUserName>
<FromUserName><![CDATA[".$this->toUsername."]]></FromUserName>
<CreateTime>".$time."</CreateTime>
<MsgType><![CDATA[music]]></MsgType>
<Music>
<Title><![CDATA[TITLE]]></Title>
<Description><![CDATA[DESCRIPTION]]></Description>
<MusicUrl><![CDATA[MUSIC_Url]]></MusicUrl>
<HQMusicUrl><![CDATA[HQ_MUSIC_Url]]></HQMusicUrl>
</Music>
<FuncFlag>0</FuncFlag>
</xml>"; 
		$this->outmsg($url,$textTpl);	
	}	
	
	function ArticlesOut($ArticleCount, $msg) {
		$time = time();
		$picTpl = "<xml> 
					 <ToUserName><![CDATA[".$this->fromUsername."]]></ToUserName> 
					 <FromUserName><![CDATA[".$this->toUsername."]]></FromUserName> 
					 <CreateTime>".$time."</CreateTime> 
					 <MsgType><![CDATA[news]]></MsgType> 
					 <Content><![CDATA[]]></Content> 
					 <ArticleCount>%d</ArticleCount> 
					 <Articles> 
					 %s 
					 </Articles> 
					 <FuncFlag>1</FuncFlag> 
					</xml>";
		$picTpl = sprintf($picTpl, $ArticleCount, $msg);
		$this->outmsg($msg, $picTpl);
	}	
	function typelocation($postObj) {
		global $_G;		
		$this->fromUsername = $postObj->FromUserName;
		$this->toUsername = $postObj->ToUserName;
		$Location_X = $postObj->Location_X;
		$Location_Y = $postObj->Location_Y; 
		$Scale = $postObj->Scale; 
		$Label = $postObj->Label; 				
		$this->TextOut('dd'.$Location_X);
	}
	function typeevent($postObj) {
		global $_G;		
		$this->fromUsername = $postObj->FromUserName;
		$this->toUsername = $postObj->ToUserName;
			
	}
	function typelink($postObj) {
		global $_G;		
		$this->fromUsername = $postObj->FromUserName;
		$this->toUsername = $postObj->ToUserName;
			
	}	
	function typeimage($postObj) {
		global $_G;		
		$this->fromUsername = $postObj->FromUserName;
		$this->toUsername = $postObj->ToUserName;
			
	}	
	function typetext($postObj) {
		global $_G;		
		$this->fromUsername = $postObj->FromUserName;
		$this->toUsername = $postObj->ToUserName;
		$keyword = trim($postObj->Content);
		$this->filter_cmd($keyword);      
		if(!empty( $keyword )) {
			
			$contentStr = $this->welcome;	
			if (!empty($this->cmd)) {					
				$cmdrow = C::t('#sanree_weixin#sanree_weixin')->get_by_cmd($this->cmd);
				if ($cmdrow) {
				
					$typeid = $cmdrow['typeid'];
					if ($typeid==1) {
					
						$contentStr = $cmdrow['content'];
						$this->TextOut($contentStr);
						
					} else {
					
						$this->TextOut('error cmd');
						
					}
					
					
				} elseif (preg_match("/^\d*$/", $this->cmd)) {
				
					$brandconfig = $_G['cache']['plugin']['sanree_brand'];
					if ($brandconfig['isopen'] !=1) {
					
						$this->TextOut(weixin_lang('noopenbrand'));

					}

					$bid = intval($this->cmd);
					if ($bid<1) {
						$this->TextOut(weixin_lang('notbrand'));
					}
					$brandresult = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($bid);
					if (!$brandresult) {
					
						$this->TextOut(weixin_lang('notbrand'));	
						
					}	
					$modfile = DISCUZ_ROOT.'./source/plugin/sanree_brand/function/function_core.php';
					@require_once($modfile);			
					$title = $brandresult['name'];
					$description = $brandresult['description'];	
					$domain = trim($brandconfig['domain']);
					$site = (!empty($domain)) ? branddomain(): $_G['siteurl'];
					$logo = $site.srfiximages($brandresult['poster'], 'category', '/none.gif');
					$url = $site.getburl($brandresult);
					$url = str_replace("&amp;", "&", $url);	
					$pic ='<item> 
					<Title><![CDATA['.$title.']]></Title> 
					<Discription><![CDATA['.$description.']]></Discription> 
					<PicUrl><![CDATA['.$logo.']]></PicUrl> 
					<Url><![CDATA['.$url.']]></Url> 
					</item>'; 					
					$this->ArticlesOut(1, $pic);
										
				}
			} elseif ($keyword=='shangjia'||$keyword=='shang'||$this->extcmd[0]=='shang') {
					$brandconfig = $_G['cache']['plugin']['sanree_brand'];
					if ($brandconfig['isopen'] !=1) {
					
						$this->TextOut(weixin_lang('noopenbrand'));

					}
					$modfile = DISCUZ_ROOT.'./source/plugin/sanree_brand/function/function_core.php';
					@require_once($modfile);
					$perpage = 5;
					$page 		= intval($this->extcmd[1]);
					$page 		= max(1, intval($page));
					$start 		= ($page - 1) * $perpage;
					$start 		= max(0, $start);
					$orderby = 't.istop desc,t.isrecommend desc,t.groupid desc, t.displayorder,t.bid desc';	
					$where = array();
					$where[] = 'c.status=1';
					$where[] = 't.status=1';
					$where[] = 't.isshow=1';
					$domain = trim($brandconfig['domain']);	
					$site = (!empty($domain)) ? branddomain(): $_G['siteurl'];
					$outxml = '';	
					$data = C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_searchc($where, $orderby, $start, $perpage);				
					foreach($data as $value) {
					
						$title = $value['name'];
						$description = $value['description'];	
						$logo = $site.srfiximages($value['poster'], 'category', '/none.gif');
						$url = $site.getburl($value);
						$url = str_replace("&amp;", "&", $url);							
						$outxml .='<item> 
						<Title><![CDATA['.$title.']]></Title> 
						<Discription><![CDATA['.$description.']]></Discription> 
						<PicUrl><![CDATA['.$logo.']]></PicUrl> 
						<Url><![CDATA['.$url.']]></Url> 
						</item>';
												
					}
					$ncount= count($data);
					if ($ncount>0) {
						$this->ArticlesOut($ncount, $outxml);	
					}					
			} elseif ($keyword=='copyright' || $keyword=='sanree' || $keyword=='sanrui' || $keyword=='3r') {
				$this->TextOut(weixin_lang('copyright'));
			}
			$brandconfig = $_G['cache']['plugin']['sanree_brand'];
			if ($brandconfig['isopen'] ==1) {	
			
			    $dkey = dhtmlspecialchars(trim($keyword));
			    $keyword = $this->srfixfilename($dkey);	
				$where = array();
				$where[] = 'c.status=1';
				$where[] = 't.status=1';
				$where[] = 't.isshow=1';			
				$searchfield = array('t.name', 't.propaganda ', 't.introduction', 't.contact', 't.weburl', 't.address', 't.tel');
				$searchtext = array();
				foreach($searchfield as $v) {
				
					$searchtext[] = "(".$v." LIKE '%".$keyword."%')";
					
				}
				$where[] = '('.implode(' OR ',$searchtext).')';			
				$count = C::t('#sanree_brand#sanree_brand_businesses')->count_by_wherec($where);
				if ($count>0) {
						$modfile = DISCUZ_ROOT.'./source/plugin/sanree_brand/function/function_core.php';
						@require_once($modfile);			
						$title = $keyword;
						$description = weixin_lang('searchstr');	
						$description = str_replace(array('{count}', '{keyword}'), array($count, $keyword), $description);	
						$id = C::t('#sanree_brand#sanree_brand_searchword')->getid_by_keyword($keyword);
						if ($id<1) {
							$id = C::t('#sanree_brand#sanree_brand_searchword')->insert(array('keyword' => $keyword, 'dateline' => TIMESTAMP), TRUE);
						}	
						$id = intval($id);				
						$domain = trim($brandconfig['domain']);
						$site = (!empty($domain)) ? branddomain(): $_G['siteurl'];
						$logo = '';//'http://demo.ymg6.Com/123/static/image/common/logo.png';
						$url = $site.'plugin.php?id=sanree_brand&mod=searchword&sid='.$id ;
						$url = str_replace("&amp;", "&", $url);	
						$pic ='<item> 
						<Title><![CDATA['.$title.']]></Title> 
						<Discription><![CDATA['.$description.']]></Discription> 
						<PicUrl><![CDATA['.$logo.']]></PicUrl> 
						<Url><![CDATA['.$url.']]></Url> 
						</item>'; 					
						$this->ArticlesOut(1, $pic);			
				}
			}
			$this->TextOut($contentStr);
			
		}
		return $this->Fixout();
		
	}	
	function srfixfilename($str) {
		if (CHARSET=='utf-8') {
			return $str;
		}
		return iconv('UTF-8', 'GB2312', $str);
	}	
	public function sanreecmd($postStr, $isout = true, $islog = true) {
		global $_G;	
		$config = $_G['cache']['plugin']['sanree_weixin'];
		if (!$config['isopen']) {
		
        	return $this->Fixout();
			
		}	
		$this->welcome = trim($config['welcome']);		
		if ($isout) {
			define('OVEROUT', TRUE);
		}
		if (!empty($postStr)){
                
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$msgtype = $postObj->MsgType;
			if ($msgtype == 'location') {
				$this->typelocation($postObj);
			} elseif ($msgtype == 'text') {
				$this->typetext($postObj);
			} elseif ($msgtype == 'image') {
				$this->typeimage($postObj);
			} elseif ($msgtype == 'link') {
				$this->typelink($postObj);
			} elseif ($msgtype == 'event') {
				$this->typeevent($postObj);
			}

        }
		return $this->Fixout();
    }
	
	function outmsg($msg, $type) {
		if ($this->isdebug) {
		    echo '<pre>'.$msg.'</pre>';
			exit();
		}else {    
			return $this->Fixout(sprintf($type, $msg)); 
		}
		
	}
	
	function Fixout($str='') {
	
		if (CHARSET!='utf-8') {
		
			$str = iconv('GB2312', 'UTF-8', $str); 
			
		}
		if (defined('OVEROUT')) {
			echo $str;		
			exit();
			
		}
		return $str;
	}
			
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
		$token = WEIXINTOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		if ($_GET['debug']==1) { 
			return true;
		}
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}
//From:www_YMG6_COM
?>