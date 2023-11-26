<?php
/**
 *	[全站弹出层通知插件【完整版】(webtctz.{modulename})] (C)2014-2099 Powered by jzsjiale.
 *	Version: A1.0
 *	Date: 2014-7-31 12:48
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class plugin_webtctz {
	//TODO - Insert your code here
	
	var $g_isopen;
	var $isopenborder;
	var $isclosetime;
	var $isanimatestart;
	var $iscloseshow;
	var $isfloat;
	var $isbg;
	var $zindex;
	var $delay;
	var $height;
	var $width;
	var $type;
	var $cimg;
	var $ctext;
	var $curl;
	var $ciframe;
	var $chtml;
	var $isok = false;
	var $tzcount;
	var $position;
	var $pyright;
	var $pybottom;
	var $transparency;
	var $closetime;
	var $starttime;
	var $endtime;
	var $contentbg;
	var $ccloseimg;
	var $closeheight;
	var $closewidth;
	var $closepyright;
	var $closepybottom;
	
	function plugin_webtctz(){
		global $_G;
		$this->g_isopen = $_G['cache']['plugin']['webtctz']['g_isopen'];
	}
	
	
	
	function global_footer(){	
		
		if($this->g_isopen){
			global $_G;
			global $isopenborder,$isclosetime,$isanimatestart,$iscloseshow,$isfloat,$delay,$isbg,$zindex,$height, $width,$type,$cimg,$ctext,$curl,$ciframe,$chtml,$isok,$tzcount,$position,$pyright,$pybottom,$transparency,$closetime,$starttime,$endtime,$contentbg,$ccloseimg,$closepyright,$closepybottom,$closeheight,$closewidth;
			$basescript = $_G['basescript'];
			$curm = CURMODULE;
			$nowtime = TIMESTAMP;
			$tzcount = "";
			$cookiestag = "";
			
			$uid = $_G['uid'];
			$username = $_G['username'];
			$groupid = $_G['groupid'];
			//echo $_G['uid'].'|'.$_G['username'].'|'.$_G['groupid'];
			//echo "----basescript------".$_G['basescript']."====".CURMODULE."++";
			
			$tz = C::t('#webtctz#webtctz_lists')->getall();
		
			
			if($basescript == "portal"){
				$catid = $_GET['catid'];//频道大类id
				$aid = $_GET['aid'];
				$tzid = "";
				$tzvalue = array();
				$isok = false;
				
				//--portal index start
				if($curm == "index"){
					$cookiestag = "portalindex";
					foreach($tz as $key => $value) {
							
						if (in_array('1',json_decode($value['targets'])) && (empty($catid)?in_array('0',json_decode($value['category'])):in_array($catid,json_decode($value['category']))) && $value ['isopen'] == '1')
						{
						    $starttime = $value['starttime'];
						    $endtime = $value['endtime'];
						    $isok = $this->gettimeisok($starttime,$endtime);
						    if($isok == 1){
						        $isok = true;
						        
						        if(!empty($value['users'])){
						            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
						                $isok = true;
						                $tzid = $value['id'];
						                $tzvalue = $value;
						                break;
						            }
						        }else{
						            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
						                $isok = true;
						                $tzid = $value['id'];
						                $tzvalue = $value;
						                break;
						            }
						        }
						    }else{
						        $isok = false;
						        dsetcookie('webtctzcount'.$cookiestag.$tzid, '0',time()+3153600000);
						    }
						    
						       
						}else{
							$isok = false;
						}
					}
				
				
				    if($isok){
						$tzcount = $_G['cookie']['webtctzcount'.$cookiestag.$tzid];
						$lastopentime = $_G['cookie']['webtctzlastopentime'.$cookiestag.$tzid];
						$nowopentime = TIMESTAMP;
						if(empty($tzcount)){
							$tzcount = 0;
						}
						if(empty($lastopentime)){
							$lastopentime = $nowopentime-$tzvalue['interval'];
						}
						
						if((($tzcount + 1) <= $tzvalue['count']) && ($tzvalue['interval'] == 0?true:(($nowopentime - $lastopentime)>=$tzvalue['interval']))){
							
							$this->setvalues($tzvalue);
							$tzcount++;
						
							dsetcookie('webtctzcount'.$cookiestag.$tzid, $tzcount,time()+3153600000);
							dsetcookie('webtctzlastopentime'.$cookiestag.$tzid, $nowopentime,time()+3153600000);
							
							$isok = true;
						}else{
							$isok = false;
						}
					}
						
						
						
				}
				//--portal index end
				
				//--portal list start
				if($curm == "list"){
					$cookiestag = "portallist";
					foreach($tz as $key => $value) {
							
						if (in_array('1',json_decode($value['targets'])) && (!empty($catid)?in_array($catid,json_decode($value['category'])):false) && $value ['isopen'] == '1' )
						{
						    $starttime = $value['starttime'];
						    $endtime = $value['endtime'];
						    $isok = $this->gettimeisok($starttime,$endtime);
						    if($isok == 1){
						        $isok = true;
						        
						        if(!empty($value['users'])){
						            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
						                $isok = true;
						                $tzid = $value['id'];
						                $tzvalue = $value;
						                break;
						            }
						        }else{
						            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
						                $isok = true;
						                $tzid = $value['id'];
						                $tzvalue = $value;
						                break;
						            }
						        }
						        
						    }else{
						        $isok = false;
						        dsetcookie('webtctzcount'.$cookiestag.$tzid, '0',time()+3153600000);
						    }
						    
						       
						}else{
							$isok = false;
						}
					}
				
		
				    if($isok){
						$tzcount = $_G['cookie']['webtctzcount'.$cookiestag.$tzid];
						$lastopentime = $_G['cookie']['webtctzlastopentime'.$cookiestag.$tzid];
						$nowopentime = TIMESTAMP;
						if(empty($tzcount)){
							$tzcount = 0;
						}
						if(empty($lastopentime)){
							$lastopentime = $nowopentime-$tzvalue['interval'];
						}
						
						if((($tzcount + 1) <= $tzvalue['count']) && ($tzvalue['interval'] == 0?true:(($nowopentime - $lastopentime)>=$tzvalue['interval']))){
							
							$this->setvalues($tzvalue);
							$tzcount++;
						
							dsetcookie('webtctzcount'.$cookiestag.$tzid, $tzcount,time()+3153600000);
							dsetcookie('webtctzlastopentime'.$cookiestag.$tzid, $nowopentime,time()+3153600000);
							
							$isok = true;
						}else{
							$isok = false;
						}
					}
				
				
				
				}
				//--portal list end
				
				//--portal view start
				if($curm == "view"){
					$cookiestag = "portalview";
					
					
					$exittargets = false;
					
					if(!empty($aid)){
						foreach($tz as $key => $value) {
								
							if (in_array('1',json_decode($value['targets'])) && in_array($aid,json_decode($value['aids'])) && $value ['isopen'] == '1' )
							{
							    $starttime = $value['starttime'];
							    $endtime = $value['endtime'];
							    $isok = $this->gettimeisok($starttime,$endtime);
							    if($isok == 1){
							        $isok = true;
							        
							        if(!empty($value['users'])){
							            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
							                $isok = true;
							                $tzid = $value['id'];
							                $tzvalue = $value;
							                $exittargets = true;
							                break;
							            }
							        }else{
							            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
							                $isok = true;
							                $tzid = $value['id'];
							                $tzvalue = $value;
							                $exittargets = true;
							                break;
							            }
							        }
							    }else{
							        $isok = false;
							        dsetcookie('webtctzcount'.$cookiestag.$tzid, '0',time()+3153600000);
							    }
							    
								
									
							}else{
								$isok = false;
								$exittargets = false;
							}
						}
					}
					
					
					
					
					
					if(!$exittargets){
						if(!empty($aid)){
							$portalresult = C::t('portal_article_title')->fetch($aid);
							$catid = $portalresult['catid'];
							$isok = true;
						}else{
							$catid = "";
							$isok = false;
						}
						foreach($tz as $key => $value) {
								
							if (in_array('1',json_decode($value['targets'])) && (!empty($catid)?in_array('0',json_decode($value['category'])):in_array($catid,json_decode($value['category']))) && $value ['isopen'] == '1' )
							{
							    $starttime = $value['starttime'];
							    $endtime = $value['endtime'];
							    $isok = $this->gettimeisok($starttime,$endtime);
							    if($isok == 1){
							        $isok = true;
							        
							        if(!empty($value['users'])){
							            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
							                $isok = true;
							                $tzid = $value['id'];
							                $tzvalue = $value;
							                $exittargets = true;
							                break;
							            }
							        }else{
							            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
							                $isok = true;
							                $tzid = $value['id'];
							                $tzvalue = $value;
							                $exittargets = true;
							                break;
							            }
							        }
							    }else{
							        $isok = false;
							        dsetcookie('webtctzcount'.$cookiestag.$tzid, '0',time()+3153600000);
							    }
							    
								
									
							}else{
								$isok = false;
								$exittargets = false;
							}
						}
					}
					
					
					
	
				    if($isok){
						$tzcount = $_G['cookie']['webtctzcount'.$cookiestag.$tzid];
						$lastopentime = $_G['cookie']['webtctzlastopentime'.$cookiestag.$tzid];
						$nowopentime = TIMESTAMP;
						if(empty($tzcount)){
							$tzcount = 0;
						}
						if(empty($lastopentime)){
							$lastopentime = $nowopentime-$tzvalue['interval'];
						}
						
						if((($tzcount + 1) <= $tzvalue['count']) && ($tzvalue['interval'] == 0?true:(($nowopentime - $lastopentime)>=$tzvalue['interval']))){
							
							$this->setvalues($tzvalue);
							$tzcount++;
						
							dsetcookie('webtctzcount'.$cookiestag.$tzid, $tzcount,time()+3153600000);
							dsetcookie('webtctzlastopentime'.$cookiestag.$tzid, $nowopentime,time()+3153600000);
							
							$isok = true;
						}else{
							$isok = false;
						}
					}
				
				
				
				}
				//--portal view end
			}
			if($basescript == "forum"){
				$gid = $_GET['gid'];//版块大类id
				$fid = $_GET['fid'];//版块小类id
				$tid = $_GET['tid'];
				$tzid = "";
				$tzvalue = array();
				$isok = false;
				
				//echo "-----".$gid."--fid--".$fid."==tid==".$tid."))))))";
				
				//--forum index start
				if($curm == "index"){
					$cookiestag = "forumindex";
					foreach($tz as $key => $value) {
						
						if (in_array('2',json_decode($value['targets'])) && (empty($gid)?in_array('0',json_decode($value['fids'])):in_array($gid,json_decode($value['fids']))) && $value ['isopen'] == '1' )
						{
						    $starttime = $value['starttime'];
						    $endtime = $value['endtime'];
						    $isok = $this->gettimeisok($starttime,$endtime);
						    if($isok == 1){
						        $isok = true;
						        
						        if(!empty($value['users'])){
						            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
						                $isok = true;
						                $tzid = $value['id'];
						                $tzvalue = $value;
						                break;
						            }
						        }else{
						            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
						                $isok = true;
						                $tzid = $value['id'];
						                $tzvalue = $value;
						                break;
						            }
						        }
						    }else{
						        $isok = false;
						        dsetcookie('webtctzcount'.$cookiestag.$tzid, '0',time()+3153600000);
						    }
						    
						        
						}else{
							$isok = false;
						}
					}
				
			
				    if($isok){
						$tzcount = $_G['cookie']['webtctzcount'.$cookiestag.$tzid];
						$lastopentime = $_G['cookie']['webtctzlastopentime'.$cookiestag.$tzid];
						$nowopentime = TIMESTAMP;
						if(empty($tzcount)){
							$tzcount = 0;
						}
						if(empty($lastopentime)){
							$lastopentime = $nowopentime-$tzvalue['interval'];
						}
						
						if((($tzcount + 1) <= $tzvalue['count']) && ($tzvalue['interval'] == 0?true:(($nowopentime - $lastopentime)>=$tzvalue['interval']))){
						
							$this->setvalues($tzvalue);
							$tzcount++;
						
							dsetcookie('webtctzcount'.$cookiestag.$tzid, $tzcount,time()+3153600000);
							dsetcookie('webtctzlastopentime'.$cookiestag.$tzid, $nowopentime,time()+3153600000);
							
							$isok = true;
						}else{
							$isok = false;
						}
					}
			
					
					
				}
				//--forum index end
				
				//--forum forumdisplay start
				if($curm == "forumdisplay"){
					$cookiestag = "forumforumdisplay";
					foreach($tz as $key => $value) {
							
						if (in_array('2',json_decode($value['targets'])) && (!empty($fid)?in_array($fid,json_decode($value['fids'])):false) && $value ['isopen'] == '1' )
						{
						    $starttime = $value['starttime'];
						    $endtime = $value['endtime'];
						    $isok = $this->gettimeisok($starttime,$endtime);
						    if($isok == 1){
						        $isok = true;
						        
						        if(!empty($value['users'])){
						            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
						                $isok = true;
						                $tzid = $value['id'];
						                $tzvalue = $value;
						                break;
						            }
						        }else{
						            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
						                $isok = true;
						                $tzid = $value['id'];
						                $tzvalue = $value;
						                break;
						            }
						        }
						    }else{
						        $isok = false;
						        dsetcookie('webtctzcount'.$cookiestag.$tzid, '0',time()+3153600000);
						    }
						    
						        
						}else{
							$isok = false;
						}
					}
					
		
					if($isok){
						$tzcount = $_G['cookie']['webtctzcount'.$cookiestag.$tzid];
						$lastopentime = $_G['cookie']['webtctzlastopentime'.$cookiestag.$tzid];
						$nowopentime = TIMESTAMP;
						if(empty($tzcount)){
							$tzcount = 0;
						}
						if(empty($lastopentime)){
							$lastopentime = $nowopentime-$tzvalue['interval'];
						}
						
						if((($tzcount + 1) <= $tzvalue['count']) && ($tzvalue['interval'] == 0?true:(($nowopentime - $lastopentime)>=$tzvalue['interval']))){
							
							$this->setvalues($tzvalue);
							$tzcount++;
						
							dsetcookie('webtctzcount'.$cookiestag.$tzid, $tzcount,time()+3153600000);
							dsetcookie('webtctzlastopentime'.$cookiestag.$tzid, $nowopentime,time()+3153600000);
							
							$isok = true;
						}else{
							$isok = false;
						}
					}
						
						
						
				}
				//--forum forumdisplay end
				
				//--forum viewthread start
				if($curm == "viewthread"){
					$cookiestag = "forumviewthread";
					
					$exittargets = false;
					
					if(!empty($tid)){
						foreach($tz as $key => $value) {
								
							if (in_array('2',json_decode($value['targets'])) && in_array($tid,json_decode($value['tids'])) && $value ['isopen'] == '1' )
							{
							    $starttime = $value['starttime'];
							    $endtime = $value['endtime'];
							    $isok = $this->gettimeisok($starttime,$endtime);
							    if($isok == 1){
							        $isok = true;
							        
							        if(!empty($value['users'])){
							            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
							                $isok = true;
							                $tzid = $value['id'];
							                $tzvalue = $value;
							                $exittargets = true;
							                break;
							            }
							        }else{
							            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
							                $isok = true;
							                $tzid = $value['id'];
							                $tzvalue = $value;
							                $exittargets = true;
							                break;
							            }
							        }
							        
							    }else{
							        $isok = false;
							        dsetcookie('webtctzcount'.$cookiestag.$tzid, '0',time()+3153600000);
							    }
							    
								
								
							}else{
								$isok = false;
								$exittargets = false;
							}
						}
					}
					
					
					
					
					
					if(!$exittargets){
						if(!empty($tid)){
							$threadresult = C::t('forum_thread')->fetch($tid);
							$fid = $threadresult['fid'];
							$isok = true;
						}else{
							$fid = "";
							$isok = false;
						}
						foreach($tz as $key => $value) {
								
							if (in_array('2',json_decode($value['targets'])) && (!empty($fid)?in_array($fid,json_decode($value['fids'])):false) && $value ['isopen'] == '1' )
							{
							    $starttime = $value['starttime'];
							    $endtime = $value['endtime'];
							    $isok = $this->gettimeisok($starttime,$endtime);
							    if($isok == 1){
							        $isok = true;
							        
							        if(!empty($value['users'])){
							            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
							                $isok = true;
							                $tzid = $value['id'];
							                $tzvalue = $value;
							                $exittargets = true;
							                break;
							            }
							        }else{
							            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
							                $isok = true;
							                $tzid = $value['id'];
							                $tzvalue = $value;
							                $exittargets = true;
							                break;
							            }
							        }
							    }else{
							        $isok = false;
							        dsetcookie('webtctzcount'.$cookiestag.$tzid, '0',time()+3153600000);
							    }
							    
								
								
							}else{
								$isok = false;
								$exittargets = false;
							}
						}
					}
					
				
				
			
					if($isok){
						$tzcount = $_G['cookie']['webtctzcount'.$cookiestag.$tzid];
						$lastopentime = $_G['cookie']['webtctzlastopentime'.$cookiestag.$tzid];
						$nowopentime = TIMESTAMP;
						if(empty($tzcount)){
							$tzcount = 0;
						}
						if(empty($lastopentime)){
							$lastopentime = $nowopentime-$tzvalue['interval'];
						}
						
						if((($tzcount + 1) <= $tzvalue['count']) && ($tzvalue['interval'] == 0?true:(($nowopentime - $lastopentime)>=$tzvalue['interval']))){
							
							$this->setvalues($tzvalue);
							$tzcount++;
						
							dsetcookie('webtctzcount'.$cookiestag.$tzid, $tzcount,time()+3153600000);
							dsetcookie('webtctzlastopentime'.$cookiestag.$tzid, $nowopentime,time()+3153600000);
							
							$isok = true;
						}else{
							$isok = false;
						}
					}
				
				
				
				}
				//--forum viewthread end
				
			}

			
			
			
			
			if($basescript == "group"){
				$gid = $_GET['gid'];//群组大类id
				$sgid = $_GET['sgid'];//群组小类id
				$fid = $_GET['fid'];
				$tid = $_GET['tid'];
				$tzid = "";
				$tzvalue = array();
				$isok = false;
				//echo "---gid--".$gid."--sgid---".$sgid."---fid--".$fid."--tid---".$tid;
				//echo "--fid--".$fid."==tid==".$tid."))))))";
			
				//--group index start
				if($curm == "index"){
					$cookiestag = "groupindex";
					foreach($tz as $key => $value) {
							
						if (in_array('3',json_decode($value['targets'])) && (empty($gid)?(empty($sgid)?in_array('0',json_decode($value['groups'])):in_array($sgid,json_decode($value['groups']))):in_array($gid,json_decode($value['groups']))) && $value ['isopen'] == '1' )
						{
						    $starttime = $value['starttime'];
						    $endtime = $value['endtime'];
						    $isok = $this->gettimeisok($starttime,$endtime);
						    if($isok == 1){
						        $isok = true;
						        
						        if(!empty($value['users'])){
						            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
						                $isok = true;
						                $tzid = $value['id'];
						                $tzvalue = $value;
						                break;
						            }
						        }else{
						            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
						                $isok = true;
						                $tzid = $value['id'];
						                $tzvalue = $value;
						                break;
						            }
						        }
						    }else{
						        $isok = false;
						        dsetcookie('webtctzcount'.$cookiestag.$tzid, '0',time()+3153600000);
						    }
						    
						        
						}else{
							$isok = false;
						}
					}
			
		
					if($isok){
						$tzcount = $_G['cookie']['webtctzcount'.$cookiestag.$tzid];
						$lastopentime = $_G['cookie']['webtctzlastopentime'.$cookiestag.$tzid];
						$nowopentime = TIMESTAMP;
						if(empty($tzcount)){
							$tzcount = 0;
						}
						if(empty($lastopentime)){
							$lastopentime = $nowopentime-$tzvalue['interval'];
						}
						
						if((($tzcount + 1) <= $tzvalue['count']) && ($tzvalue['interval'] == 0?true:(($nowopentime - $lastopentime)>=$tzvalue['interval']))){
							
							$this->setvalues($tzvalue);
							$tzcount++;
						
							dsetcookie('webtctzcount'.$cookiestag.$tzid, $tzcount,time()+3153600000);
							dsetcookie('webtctzlastopentime'.$cookiestag.$tzid, $nowopentime,time()+3153600000);
							
							$isok = true;
						}else{
							$isok = false;
						}
					}
						
						
						
				}
				//--group index end
			
				//--group group start
				if($curm == "group"){
					$cookiestag = "groupgroup";
					foreach($tz as $key => $value) {
							
						if (in_array('3',json_decode($value['targets'])) && (!empty($fid)?in_array($fid,json_decode($value['groups'])):false) && $value ['isopen'] == '1' )
						{
						    $starttime = $value['starttime'];
						    $endtime = $value['endtime'];
						    $isok = $this->gettimeisok($starttime,$endtime);
						    if($isok == 1){
						        $isok = true;
						        
						        if(!empty($value['users'])){
						            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
						                $isok = true;
						                $tzid = $value['id'];
						                $tzvalue = $value;
						                break;
						            }
						        }else{
						            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
						                $isok = true;
						                $tzid = $value['id'];
						                $tzvalue = $value;
						                break;
						            }
						        }
						    }else{
						        $isok = false;
						        dsetcookie('webtctzcount'.$cookiestag.$tzid, '0',time()+3153600000);
						    }
						    
						       
						}else{
							$isok = false;
						}
					}
						
					
					if($isok){
						$tzcount = $_G['cookie']['webtctzcount'.$cookiestag.$tzid];
						$lastopentime = $_G['cookie']['webtctzlastopentime'.$cookiestag.$tzid];
						$nowopentime = TIMESTAMP;
						if(empty($tzcount)){
							$tzcount = 0;
						}
						if(empty($lastopentime)){
							$lastopentime = $nowopentime-$tzvalue['interval'];
						}
						
						if((($tzcount + 1) <= $tzvalue['count']) && ($tzvalue['interval'] == 0?true:(($nowopentime - $lastopentime)>=$tzvalue['interval']))){
							
							$this->setvalues($tzvalue);
							$tzcount++;
						
							dsetcookie('webtctzcount'.$cookiestag.$tzid, $tzcount,time()+3153600000);
							dsetcookie('webtctzlastopentime'.$cookiestag.$tzid, $nowopentime,time()+3153600000);
							
							$isok = true;
						}else{
							$isok = false;
						}
					}
			
			
			
				}
				//--group group end
			
				//--group viewthread start
				if($curm == "viewthread"){
					$cookiestag = "groupviewthread";
					
					
					
					$exittargets = false;
						
					if(!empty($tid)){
						foreach($tz as $key => $value) {
					
							if (in_array('3',json_decode($value['targets'])) && in_array($tid,json_decode($value['tids'])) && $value ['isopen'] == '1' )
							{
							    $starttime = $value['starttime'];
							    $endtime = $value['endtime'];
							    $isok = $this->gettimeisok($starttime,$endtime);
							    if($isok == 1){
							        $isok = true;
							        
							        if(!empty($value['users'])){
							            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
							                $isok = true;
							                $tzid = $value['id'];
							                $tzvalue = $value;
							                $exittargets = true;
							                break;
							            }
							        }else{
							            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
							                $isok = true;
							                $tzid = $value['id'];
							                $tzvalue = $value;
							                $exittargets = true;
							                break;
							            }
							        }
							    }else{
							        $isok = false;
							        dsetcookie('webtctzcount'.$cookiestag.$tzid, '0',time()+3153600000);
							    }
							    
								
					
							}else{
								$isok = false;
								$exittargets = false;
							}
						}
					}
						
						
						
						
						
					if(!$exittargets){
						if(!empty($tid)){
							$threadresult = C::t('forum_thread')->fetch($tid);
							$fid = $threadresult['fid'];
							$isok = true;
						}else{
							$fid = "";
							$isok = false;
						}
						foreach($tz as $key => $value) {
					
							if (in_array('3',json_decode($value['targets'])) && (!empty($fid)?in_array($fid,json_decode($value['groups'])):false) && $value ['isopen'] == '1' )
							{
							    $starttime = $value['starttime'];
							    $endtime = $value['endtime'];
							    $isok = $this->gettimeisok($starttime,$endtime);
							    if($isok == 1){
							        $isok = true;
							        
							        if(!empty($value['users'])){
							            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
							                $isok = true;
							                $tzid = $value['id'];
							                $tzvalue = $value;
							                $exittargets = true;
							                break;
							            }
							        }else{
							            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
							                $isok = true;
							                $tzid = $value['id'];
							                $tzvalue = $value;
							                $exittargets = true;
							                break;
							            }
							        }
							    }else{
							        $isok = false;
							        dsetcookie('webtctzcount'.$cookiestag.$tzid, '0',time()+3153600000);
							    }
							    
								
					
							}else{
								$isok = false;
								$exittargets = false;
							}
						}
					}
					
		
					if($isok){
						$tzcount = $_G['cookie']['webtctzcount'.$cookiestag.$tzid];
						$lastopentime = $_G['cookie']['webtctzlastopentime'.$cookiestag.$tzid];
						$nowopentime = TIMESTAMP;
						if(empty($tzcount)){
							$tzcount = 0;
						}
						if(empty($lastopentime)){
							$lastopentime = $nowopentime-$tzvalue['interval'];
						}
						
						if((($tzcount + 1) <= $tzvalue['count']) && ($tzvalue['interval'] == 0?true:(($nowopentime - $lastopentime)>=$tzvalue['interval']))){
							
							$this->setvalues($tzvalue);
							$tzcount++;
						
							dsetcookie('webtctzcount'.$cookiestag.$tzid, $tzcount,time()+3153600000);
							dsetcookie('webtctzlastopentime'.$cookiestag.$tzid, $nowopentime,time()+3153600000);
							
							$isok = true;
						}else{
							$isok = false;
						}
					}
			
			
			
				}
				//--group viewthread end
			
			}
			
			
			
			
			
			
			if($basescript == "home"){
				
				$tzid = "";
				$tzvalue = array();
				$isok = false;
				//echo "----catid------".$catid."===aid===".$aid;
				//--home space start
				if($curm == "space"){
					$cookiestag = "homespace";
					foreach($tz as $key => $value) {
							
						if (in_array('4',json_decode($value['targets'])) && $value ['isopen'] == '1')
						{
						    $starttime = $value['starttime'];
						    $endtime = $value['endtime'];
						    $isok = $this->gettimeisok($starttime,$endtime);
						    if($isok == 1){
						        $isok = true;
						        
						        if(!empty($value['users'])){
						            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
						                $isok = true;
						                $tzid = $value['id'];
						                $tzvalue = $value;
						                break;
						            }
						        }else{
						            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
						                $isok = true;
						                $tzid = $value['id'];
						                $tzvalue = $value;
						                break;
						            }
						        }
						    }else{
						        $isok = false;
						        dsetcookie('webtctzcount'.$cookiestag.$tzid, '0',time()+3153600000);
						    }
						    
						        
						}else{
							$isok = false;
						}
					}
	
					if($isok){
						$tzcount = $_G['cookie']['webtctzcount'.$cookiestag.$tzid];
						$lastopentime = $_G['cookie']['webtctzlastopentime'.$cookiestag.$tzid];
						$nowopentime = TIMESTAMP;
						if(empty($tzcount)){
							$tzcount = 0;
						}
						if(empty($lastopentime)){
							$lastopentime = $nowopentime-$tzvalue['interval'];
						}
						
						if((($tzcount + 1) <= $tzvalue['count']) && ($tzvalue['interval'] == 0?true:(($nowopentime - $lastopentime)>=$tzvalue['interval']))){
							
							$this->setvalues($tzvalue);
							$tzcount++;
						
							dsetcookie('webtctzcount'.$cookiestag.$tzid, $tzcount,time()+3153600000);
							dsetcookie('webtctzlastopentime'.$cookiestag.$tzid, $nowopentime,time()+3153600000);
							
							$isok = true;
						}else{
							$isok = false;
						}
					}
			
			
			
				}
				//--home space end
			
			}
			
			
			
			//-----plugin start----------
			if($basescript == "plugin"){
			
				$tzid = "";
				$tzvalue = array();
				$isok = false;
				
					$cookiestag = "plugin";
					foreach($tz as $key => $value) {
							
						if (in_array('5',json_decode($value['targets'])) && in_array($curm,json_decode($value['plugins'])) && $value ['isopen'] == '1')
						{
						    $starttime = $value['starttime'];
						    $endtime = $value['endtime'];
						    $isok = $this->gettimeisok($starttime,$endtime);
						    if($isok == 1){
						        $isok = true;
						        
						        if(!empty($value['users'])){
						            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
						                $isok = true;
						                $tzid = $value['id'];
						                $tzvalue = $value;
						                break;
						            }
						        }else{
						            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
						                $isok = true;
						                $tzid = $value['id'];
						                $tzvalue = $value;
						                break;
						            }
						        }
						    }else{
						        $isok = false;
						        dsetcookie('webtctzcount'.$cookiestag.$tzid, '0',time()+3153600000);
						    }
						    
							
						}else{
							$isok = false;
						}
					}
						
		
					if($isok){
						$tzcount = $_G['cookie']['webtctzcount'.$cookiestag.$tzid];
						$lastopentime = $_G['cookie']['webtctzlastopentime'.$cookiestag.$tzid];
						$nowopentime = TIMESTAMP;
						if(empty($tzcount)){
							$tzcount = 0;
						}
						if(empty($lastopentime)){
							$lastopentime = $nowopentime-$tzvalue['interval'];
						}
							
						if((($tzcount + 1) <= $tzvalue['count']) && ($tzvalue['interval'] == 0?true:(($nowopentime - $lastopentime)>=$tzvalue['interval']))){
			
							$this->setvalues($tzvalue);
							$tzcount++;
								
							dsetcookie('webtctzcount'.$cookiestag.$tzid, $tzcount,time()+3153600000);
							dsetcookie('webtctzlastopentime'.$cookiestag.$tzid, $nowopentime,time()+3153600000);
			
							$isok = true;
						}else{
							$isok = false;
						}
					}
						
					
			}
				
				
			//------plugin end---------
			
			
			
			if($isok == true){
				include template('webtctz:webtctz');
				return $return;
			}else{
				return "";
			}
		}else{
			return "";
		}
	}
	
	
	function setvalues($tzvalue) {
		global $isopenborder,$isclosetime,$isanimatestart,$iscloseshow,$isfloat,$delay,$isbg,$zindex,$height, $width,$type,$cimg,$ctext,$curl,$ciframe,$chtml,$closetime,$position,$pyright,$pybottom,$transparency,$contentbg,$ccloseimg,$closepyright,$closepybottom,$closeheight,$closewidth;
		$isopenborder  = $tzvalue ['isopenborder'];
		$isclosetime  = $tzvalue ['isclosetime'];
		$isanimatestart  = $tzvalue ['isanimatestart'];
		$iscloseshow  = $tzvalue ['iscloseshow'];
		$isfloat  = $tzvalue ['isfloat'];
		$isbg  = $tzvalue ['isbg'];
		$delay = $tzvalue ['delay'];
		$zindex  = $tzvalue ['zindex'];
		$height = $tzvalue ['height'];
		$width = $tzvalue ['width'];
		$type = $tzvalue ['type'];
		$position = $tzvalue ['position'];
		$pyright = $tzvalue ['pyright'];
		$pybottom = $tzvalue ['pybottom'];
		$transparency = $tzvalue ['transparency'];
		$contentbg = $tzvalue ['contentbg'];
		$ccloseimg = $tzvalue ['ccloseimg'];
		$closeheight = $tzvalue ['closeheight'];
		$closewidth = $tzvalue ['closewidth'];
		$closepyright = $tzvalue ['closepyright'];
		$closepybottom = $tzvalue ['closepybottom'];
		
		if ($tzvalue ['type'] == 0) {
			$cimg = $tzvalue ['cimg'];
		} else if ($tzvalue ['type'] == 1) {
			$ctext = $tzvalue ['ctext'];
		} else if ($tzvalue ['type'] == 2) {
			$ciframe = $tzvalue ['ciframe'];
		} else if ($tzvalue ['type'] == 3) {
			$chtml = $tzvalue ['chtml'];
		} else {
			$ctext = $tzvalue ['ctext'];
		}
		
		if (! empty ( $tzvalue ['curl'] )) {
			$curl = $tzvalue ['curl'];
		} else {
			$curl = "";
		}
		
		$closetime = $tzvalue ['closetime'];
		return;
	}
	

	function gettimeisok($starttime,$endtime){
		$isok = false;
		$nowtime = TIMESTAMP;
		if(empty($starttime) && empty($endtime)){
			$isok = true;
		}elseif (!empty($starttime) && empty($endtime)){
			if($starttime <= $nowtime){
				$isok = true;
			}else{
				$isok = false;
			}
		}elseif (empty($starttime) && !empty($endtime)){
			if($endtime >= $nowtime){
				$isok = true;
			}else{
				$isok = false;
			}
		}elseif (!empty($starttime) && !empty($endtime)){
			if($starttime <= $nowtime && $endtime >= $nowtime){
				$isok = true;
			}else{
				$isok = false;
			}
		}else{
			$isok = false;
		}
		return $isok;
	}
	
	function getsetting() {
		global $_G;
		$settings = array(
				'fids' => array(
						'title' => 'tzfidstitle',
						'type' => 'mselect',
						'comment' => 'tzfidscomment',
						'value' => array(),
				),
				'groups' => array(
						'title' => 'tzgroupstitle',
						'type' => 'mselect',
						'comment' => 'tzgroupscomment',
						'value' => array(),
				),
				'category' => array(
						'title' => 'tzcategorytitle',
						'type' => 'mselect',
						'comment' => 'tzcategorycomment',
						'value' => array(),
				),
		);
		loadcache(array('forums', 'grouptype'));
		$settings['fids']['value'][] = array(0, plang('bbshome'));
		$settings['groups']['value'][] = array(0, plang('groupshome'));
		if(empty($_G['cache']['forums'])) $_G['cache']['forums'] = array();
		foreach($_G['cache']['forums'] as $fid => $forum) {
			$settings['fids']['value'][] = array($fid, ($forum['type'] == 'forum' ? str_repeat('&nbsp;', 4) : ($forum['type'] == 'sub' ? str_repeat('&nbsp;', 8) : '')).$forum['name']);
		}
	
		foreach($_G['cache']['grouptype']['first'] as $gid => $group) {
			$settings['groups']['value'][] = array($gid, $group['name']);
			if($group['secondlist']) {
				foreach($group['secondlist'] as $sgid) {
					$settings['groups']['value'][] = array($sgid, str_repeat('&nbsp;', 4).$_G['cache']['grouptype']['second'][$sgid]['name']);
					if(!empty($sgid)){
						$sgidresult = C::t('forum_forum')->fetch_all_sub_group_by_fup($sgid);
						if(!empty($sgidresult)){
							foreach($sgidresult as $subgid) {
								$settings['groups']['value'][] = array($subgid['fid'], str_repeat('&nbsp;', 8).$subgid['name']);
							}
						}
						
					}
				
				}
			}
		}
		loadcache('portalcategory');
		
		$this->getcategory(0,true);

		$settings['category']['value'] = $this->categoryvalue;
		
		//var_dump($this->categoryvalue);
		return $settings;
	}
	
	function getcategory($upid,$ishome) {
		global $_G;
		if($ishome){
			$this->categoryvalue[] = array('0', plang('categoryhome'));
		}
		foreach($_G['cache']['portalcategory'] as $category) {
			$ishome = false;
			if($category['upid'] == $upid) {
				$this->categoryvalue[] = array($category['catid'], str_repeat('&nbsp;', $category['level'] * 4).$category['catname']);
				$this->getcategory($category['catid'],false);
			}
		}
	}
	
	function gettargetsname($targets) {
		global $_G;
		$targetsname = "";
		
		if(in_array('1',$targets)){
			$targetsname .= plang('tztargetscategory').",";
		}
		if(in_array('2',$targets)){
			$targetsname .= plang('tztargetsfids').",";
		}
		if(in_array('3',$targets)){
			$targetsname .= plang('tztargetsgroups').",";
		}
		if(in_array('4',$targets)){
			$targetsname .= plang('tztargetshome').",";
		}
		if(in_array('5',$targets)){
			$targetsname .= plang('tztargetsplugin').",";
		}
		$targetsname = rtrim($targetsname,',');
		return $targetsname;
	}
	
	function getgroupsname($group,$groups,$isarray = false) {
		global $_G;
		$groupsname = "";
		loadcache(array('grouptype'));
		if(empty($_G['cache']['grouptype'])) {
			$groupsname = plang('nullstr');
			return $groupsname;
		}
		
		if($isarray){
			if(in_array('0',$groups)){
				$groupsname .= plang('groupshome').",";
			}
			foreach($_G['cache']['grouptype']['first'] as $gid => $group) {
				if(in_array($gid,$groups)){
					$groupsname .= $group['name'].",";
				}
				if($group['secondlist']) {
					foreach($group['secondlist'] as $sgid) {
					if(in_array($sgid,$groups)){
						$groupsname .= $_G['cache']['grouptype']['second'][$sgid]['name'].",";
					}if(!empty($sgid)){
							$sgidresult = C::t('forum_forum')->fetch_all_sub_group_by_fup($sgid);
							if(!empty($sgidresult)){
								foreach($sgidresult as $subgid) {
									if(in_array($subgid['fid'],$groups)){
										$groupsname .= $subgid['name'].",";
									}
								}
							}
			
						}
			
					}
				}
			}
			$groupsname = rtrim($groupsname,',');
		}else{
			if($group == '0'){
				$groupsname = plang('groupshome');
			}
			foreach($_G['cache']['grouptype']['first'] as $gid => $group) {
				if($gid == $group){
					$groupsname = $group['name'];
				}
				if($group['secondlist']) {
					foreach($group['secondlist'] as $sgid) {
						if($sgid == $group){
							$groupsname = $_G['cache']['grouptype']['second'][$sgid]['name'];
						}if(!empty($sgid)){
							$sgidresult = C::t('forum_forum')->fetch_all_sub_group_by_fup($sgid);
							if(!empty($sgidresult)){
								foreach($sgidresult as $subgid) {
									if($subgid['fid'] == $group){
										$groupsname = $subgid['name'];
									}
								}
							}
								
						}
							
					}
				}
			}
		}
	
	
		return $groupsname;
	}
	
	
	
	
	
	function getcategoryname($category,$categorys,$isarray = false) {
		global $_G;
		$categoryname = "";
		
		loadcache('portalcategory');
		
		if(empty($_G['cache']['portalcategory'])) {
			$categoryname = plang('nullstr');
			return $categoryname;
		}
		if($isarray){
			if(in_array('0',$categorys)){
				$categoryname .= plang('categoryhome').",";
			}
			foreach($_G['cache']['portalcategory'] as $category) {
				if(in_array($category['catid'],$categorys)){
					$categoryname .= $category['catname'].",";
				}
			}
			$categoryname = rtrim($categoryname,',');
		}else{
			if($category == '0'){
				$categoryname = plang('categoryhome');
			}
			foreach($_G['cache']['portalcategory'] as $category) {
				if($category['catid'] == $category){
					$categoryname = $category['catname'];
				}
			}
		}
	
	
		return $categoryname;
	}
	
	
	
	
	
	
	function getforumsname($fid,$fids,$isarray = false) {
		global $_G;
		$fidname = "";
		loadcache(array('forums'));
		if(empty($_G['cache']['forums'])) {
			$fidname = plang('nullstr');
			return $fidname;
		}
	    if($isarray){
	        if(in_array('0',$fids)){
	    			$fidname .= plang('bbshome').",";
	    	}
	    	foreach($_G['cache']['forums'] as $fid => $forum) {
	    		if(in_array($forum['fid'],$fids)){
	    			$fidname .= $forum['name'].",";
	    		}
	    	}
	    	$fidname = rtrim($fidname,',');
	    }else{
	    	if($fid == '0'){
	    		$fidname = plang('bbshome');
	    	}
	    	foreach($_G['cache']['forums'] as $fid => $forum) {
	    		if($forum['fid'] == $fid){
	    			$fidname = $forum['name'];
	    		}
	    	}
	    }
		
		
	    return $fidname;
	}
	
	function getusergroupname($usergroup,$usergroups,$isarray = false) {
		global $_G;
		$usergroupname = "";
		//$query = C::t('common_usergroup')->fetch_all_not(array(6, 7), true);
		$query = C::t('common_usergroup')->fetch_all_not(array(), true);
		if(empty($query)) {
			$usergroupname = plang('nullstr');
			return $usergroupname;
		}
		
		if($isarray){
			foreach($query as $group) {
				if(in_array($group['groupid'],$usergroups)){
					$usergroupname .= $group['grouptitle'].",";
				}
			}
			$usergroupname = rtrim($usergroupname,',');
		}else{
			foreach($query as $group) {
				if($group['groupid'] == $usergroup){
					$usergroupname = $group['grouptitle'];
				}
			}
		}
	
	
		return $usergroupname;
	}
	
	function gettypename($type) {
		$typename = "";
		$tztype = plang('tztype');
		switch ($type) {
			case "0" :
				$typename = $tztype[0];
				break;
			case "1" :
				$typename = $tztype[1];
				break;
			case "2" :
				$typename = $tztype[2];
				break;
			case "3" :
				$typename = $tztype[3];
				break;
			default :
				$typename = $tztype[0];
				break;
		}
		return $typename;
	}
	
	function getpositionname($position) {
		$positionname = "";
		$tzposition = plang ( 'tzposition' );
		switch ($position) {
			case "0" :
				$positionname = $tzposition [0];
				break;
			case "1" :
				$positionname = $tzposition [1];
				break;
			case "2" :
				$positionname = $tzposition [2];
				break;
			case "3" :
				$positionname = $tzposition [3];
				break;
			case "4" :
				$positionname = $tzposition [4];
				break;
			case "5" :
				$positionname = $tzposition [5];
				break;
			case "6" :
				$positionname = $tzposition [6];
				break;
			case "7" :
				$positionname = $tzposition [7];
				break;
			case "8" :
				$positionname = $tzposition [8];
				break;
			default :
				$positionname = $tzposition [0];
				break;
		}
		return $positionname;
	}
	
	function plang($str) {
		return lang('plugin/webtctz', $str);
	}
}
//WWW.fx8.cc
?>