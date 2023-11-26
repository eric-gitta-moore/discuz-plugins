<?php
/**
 *	[手机多功能灵活弹窗(webtctz.{modulename})] (C)2014-2099 Powered by jzsjiale.
 *	Version: A1.0
 *	Date: 2016-2-19 12:48
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class mobileplugin_webtctz {
	//TODO - Insert your code here
	
	var $g_isopen;
	var $m_isopenborder;
	var $m_isclosetime;
	var $m_isanimatestart;
	var $m_iscloseshow;
	var $m_isfloat;
	var $m_isbg;
	var $m_zindex;
	var $m_delay;
	var $m_height;
	var $m_width;
	var $m_type;
	var $m_cimg;
	var $m_ctext;
	var $m_curl;
	var $m_ciframe;
	var $m_chtml;
	var $m_isok = false;
	var $m_mtzcount;
	var $m_position;
	var $m_pyright;
	var $m_pybottom;
	var $m_transparency;
	var $m_closetime;
	var $m_starttime;
	var $m_endtime;
	var $m_contentbg;
	var $m_ccloseimg;
	var $m_closeheight;
	var $m_closewidth;
	var $m_closepyright;
	var $m_closepybottom;
	
	function mobileplugin_webtctz(){
		global $_G;
		$this->g_isopen = $_G['cache']['plugin']['webtctz']['g_isopen'];
	}
	
	
	
	function global_footer_mobile(){	
		if($this->g_isopen){
			global $_G;
			global $m_isopenborder,$m_isclosetime,$m_isanimatestart,$m_iscloseshow,$m_isfloat,$m_delay,$m_isbg,$m_zindex,$m_height, $m_width,$m_type,$m_cimg,$m_ctext,$m_curl,$m_ciframe,$m_chtml,$m_isok,$m_mtzcount,$m_position,$m_pyright,$m_pybottom,$m_transparency,$m_closetime,$m_starttime,$m_endtime,$m_contentbg,$m_ccloseimg,$m_closepyright,$m_closepybottom,$m_closeheight,$m_closewidth;
			$basescript = $_G['basescript'];
			$curm = CURMODULE;
			$nowtime = TIMESTAMP;
			$m_mtzcount = "";
			$cookiestag = "";
			
			$uid = $_G['uid'];
			$username = $_G['username'];
			$groupid = $_G['groupid'];
			//echo $_G['uid'].'|'.$_G['username'].'|'.$_G['groupid'];
			//echo "----basescript------".$_G['basescript']."====".CURMODULE."++";
			
			$mtz = C::t('#webtctz#webtctz_mobilelists')->getall();
		
			
			
			if($basescript == "portal"){
				$catid = $_GET['catid'];//频道大类id
				$aid = $_GET['aid'];
				$mtzid = "";
				$mtzvalue = array();
				$m_isok = false;
				//echo "----catid------".$catid."===aid===".$aid;
				//--portal index start
				if($curm == "index"){
					$cookiestag = "portalindex";
					foreach($mtz as $key => $value) {
							
						if (in_array('1',json_decode($value['targets'])) && (empty($catid)?in_array('0',json_decode($value['category'])):in_array($catid,json_decode($value['category']))) && $value ['isopen'] == '1')
						{
						    $m_starttime = $value['starttime'];
						    $m_endtime = $value['endtime'];
						    $m_isok = $this->gettimeisok($m_starttime,$m_endtime);
						    if($m_isok == 1){
						        $m_isok = true;
						        
						        if(!empty($value['users'])){
						            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
						                $m_isok = true;
						                $mtzid = $value['id'];
						                $mtzvalue = $value;
						                break;
						            }
						        }else{
						            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
						                $m_isok = true;
						                $mtzid = $value['id'];
						                $mtzvalue = $value;
						                break;
						            }
						        }
						    }else{
						        $m_isok = false;
						        dsetcookie('webtctzcount'.$cookiestag.$mtzid, '0',time()+3153600000);
						    }
						    
						       
						}else{
							$m_isok = false;
						}
					}
				
		
				    if($m_isok){
						$m_mtzcount = $_G['cookie']['webtctzcount'.$cookiestag.$mtzid];
						$lastopentime = $_G['cookie']['webtctzlastopentime'.$cookiestag.$mtzid];
						$nowopentime = TIMESTAMP;
						if(empty($m_mtzcount)){
							$m_mtzcount = 0;
						}
						if(empty($lastopentime)){
							$lastopentime = $nowopentime-$mtzvalue['interval'];
						}
						
						if((($m_mtzcount + 1) <= $mtzvalue['count']) && ($mtzvalue['interval'] == 0?true:(($nowopentime - $lastopentime)>=$mtzvalue['interval']))){
							
							$this->setvalues($mtzvalue);
							$m_mtzcount++;
						
							dsetcookie('webtctzcount'.$cookiestag.$mtzid, $m_mtzcount,time()+3153600000);
							dsetcookie('webtctzlastopentime'.$cookiestag.$mtzid, $nowopentime,time()+3153600000);
							
							$m_isok = true;
						}else{
							$m_isok = false;
						}
					}
						
						
						
				}
				//--portal index end
				
				//--portal list start
				if($curm == "list"){
					$cookiestag = "portallist";
					foreach($mtz as $key => $value) {
							
						if (in_array('1',json_decode($value['targets'])) && (!empty($catid)?in_array($catid,json_decode($value['category'])):false) && $value ['isopen'] == '1' )
						{
						    $m_starttime = $value['starttime'];
						    $m_endtime = $value['endtime'];
						    $m_isok = $this->gettimeisok($m_starttime,$m_endtime);
						    if($m_isok == 1){
						        $m_isok = true;
						        
						        if(!empty($value['users'])){
						            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
						                $m_isok = true;
						                $mtzid = $value['id'];
						                $mtzvalue = $value;
						                break;
						            }
						        }else{
						            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
						                $m_isok = true;
						                $mtzid = $value['id'];
						                $mtzvalue = $value;
						                break;
						            }
						        }
						    }else{
						        $m_isok = false;
						        dsetcookie('webtctzcount'.$cookiestag.$mtzid, '0',time()+3153600000);
						    }
						    
						       
						}else{
							$m_isok = false;
						}
					}
				
	
				    if($m_isok){
						$m_mtzcount = $_G['cookie']['webtctzcount'.$cookiestag.$mtzid];
						$lastopentime = $_G['cookie']['webtctzlastopentime'.$cookiestag.$mtzid];
						$nowopentime = TIMESTAMP;
						if(empty($m_mtzcount)){
							$m_mtzcount = 0;
						}
						if(empty($lastopentime)){
							$lastopentime = $nowopentime-$mtzvalue['interval'];
						}
						
						if((($m_mtzcount + 1) <= $mtzvalue['count']) && ($mtzvalue['interval'] == 0?true:(($nowopentime - $lastopentime)>=$mtzvalue['interval']))){
							
							$this->setvalues($mtzvalue);
							$m_mtzcount++;
						
							dsetcookie('webtctzcount'.$cookiestag.$mtzid, $m_mtzcount,time()+3153600000);
							dsetcookie('webtctzlastopentime'.$cookiestag.$mtzid, $nowopentime,time()+3153600000);
							
							$m_isok = true;
						}else{
							$m_isok = false;
						}
					}
				
				
				
				}
				//--portal list end
				
				//--portal view start
				if($curm == "view"){
					$cookiestag = "portalview";
					
					
					$exittargets = false;
					
					if(!empty($aid)){
						foreach($mtz as $key => $value) {
								
							if (in_array('1',json_decode($value['targets'])) && in_array($aid,json_decode($value['aids'])) && $value ['isopen'] == '1' )
							{
							    $m_starttime = $value['starttime'];
							    $m_endtime = $value['endtime'];
							    $m_isok = $this->gettimeisok($m_starttime,$m_endtime);
							    if($m_isok == 1){
							        $m_isok = true;
							        
							        if(!empty($value['users'])){
							            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
							                $m_isok = true;
							                $mtzid = $value['id'];
							                $mtzvalue = $value;
							                $exittargets = true;
							                break;
							            }
							        }else{
							            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
							                $m_isok = true;
							                $mtzid = $value['id'];
							                $mtzvalue = $value;
							                $exittargets = true;
							                break;
							            }
							        }
							    }else{
							        $m_isok = false;
							        dsetcookie('webtctzcount'.$cookiestag.$mtzid, '0',time()+3153600000);
							    }
							    
								
									
							}else{
								$m_isok = false;
								$exittargets = false;
							}
						}
					}
					
					
					
					
					
					if(!$exittargets){
						if(!empty($aid)){
							$portalresult = C::t('portal_article_title')->fetch($aid);
							$catid = $portalresult['catid'];
							$m_isok = true;
						}else{
							$catid = "";
							$m_isok = false;
						}
						foreach($mtz as $key => $value) {
								
							if (in_array('1',json_decode($value['targets'])) && (!empty($catid)?in_array('0',json_decode($value['category'])):in_array($catid,json_decode($value['category']))) && $value ['isopen'] == '1' )
							{
							    $m_starttime = $value['starttime'];
							    $m_endtime = $value['endtime'];
							    $m_isok = $this->gettimeisok($m_starttime,$m_endtime);
							    if($m_isok == 1){
							        $m_isok = true;
							        
							        if(!empty($value['users'])){
							            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
							                $m_isok = true;
							                $mtzid = $value['id'];
							                $mtzvalue = $value;
							                $exittargets = true;
							                break;
							            }
							        }else{
							            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
							                $m_isok = true;
							                $mtzid = $value['id'];
							                $mtzvalue = $value;
							                $exittargets = true;
							                break;
							            }
							        }
							    }else{
							        $m_isok = false;
							        dsetcookie('webtctzcount'.$cookiestag.$mtzid, '0',time()+3153600000);
							    }
								
									
							}else{
								$m_isok = false;
								$exittargets = false;
							}
						}
					}
					
	
				    if($m_isok){
						$m_mtzcount = $_G['cookie']['webtctzcount'.$cookiestag.$mtzid];
						$lastopentime = $_G['cookie']['webtctzlastopentime'.$cookiestag.$mtzid];
						$nowopentime = TIMESTAMP;
						if(empty($m_mtzcount)){
							$m_mtzcount = 0;
						}
						if(empty($lastopentime)){
							$lastopentime = $nowopentime-$mtzvalue['interval'];
						}
						
						if((($m_mtzcount + 1) <= $mtzvalue['count']) && ($mtzvalue['interval'] == 0?true:(($nowopentime - $lastopentime)>=$mtzvalue['interval']))){
							
							$this->setvalues($mtzvalue);
							$m_mtzcount++;
						
							dsetcookie('webtctzcount'.$cookiestag.$mtzid, $m_mtzcount,time()+3153600000);
							dsetcookie('webtctzlastopentime'.$cookiestag.$mtzid, $nowopentime,time()+3153600000);
							
							$m_isok = true;
						}else{
							$m_isok = false;
						}
					}
				
				
				
				}
				//--portal view end
			}
			if($basescript == "forum"){
				$gid = $_GET['gid'];//版块大类id
				$fid = $_GET['fid'];//版块小类id
				$tid = $_GET['tid'];
				$mtzid = "";
				$mtzvalue = array();
				$m_isok = false;
				
				//echo "-----".$gid."--fid--".$fid."==tid==".$tid."))))))";
				
				//--forum index start
				if($curm == "index"){
					$cookiestag = "forumindex";
					foreach($mtz as $key => $value) {
						
						if (in_array('2',json_decode($value['targets'])) && (empty($gid)?in_array('0',json_decode($value['fids'])):in_array($gid,json_decode($value['fids']))) && $value ['isopen'] == '1' )
						{
						    $m_starttime = $value['starttime'];
						    $m_endtime = $value['endtime'];
						    $m_isok = $this->gettimeisok($m_starttime,$m_endtime);
						    if($m_isok == 1){
						        $m_isok = true;
						        
						        if(!empty($value['users'])){
						            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
						                $m_isok = true;
						                $mtzid = $value['id'];
						                $mtzvalue = $value;
						                break;
						            }
						        }else{
						            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
						                $m_isok = true;
						                $mtzid = $value['id'];
						                $mtzvalue = $value;
						                break;
						            }
						        }
						    }else{
						        $m_isok = false;
						        dsetcookie('webtctzcount'.$cookiestag.$mtzid, '0',time()+3153600000);
						    }
						    
						        
						}else{
							$m_isok = false;
						}
					}
	
				    if($m_isok){
						$m_mtzcount = $_G['cookie']['webtctzcount'.$cookiestag.$mtzid];
						$lastopentime = $_G['cookie']['webtctzlastopentime'.$cookiestag.$mtzid];
						$nowopentime = TIMESTAMP;
						if(empty($m_mtzcount)){
							$m_mtzcount = 0;
						}
						if(empty($lastopentime)){
							$lastopentime = $nowopentime-$mtzvalue['interval'];
						}
						
						if((($m_mtzcount + 1) <= $mtzvalue['count']) && ($mtzvalue['interval'] == 0?true:(($nowopentime - $lastopentime)>=$mtzvalue['interval']))){
						
							$this->setvalues($mtzvalue);
							$m_mtzcount++;
						
							dsetcookie('webtctzcount'.$cookiestag.$mtzid, $m_mtzcount,time()+3153600000);
							dsetcookie('webtctzlastopentime'.$cookiestag.$mtzid, $nowopentime,time()+3153600000);
							
							$m_isok = true;
						}else{
							$m_isok = false;
						}
					}
			
					
					
				}
				//--forum index end
				
				//--forum forumdisplay start
				if($curm == "forumdisplay"){
					$cookiestag = "forumforumdisplay";
					foreach($mtz as $key => $value) {
							
						if (in_array('2',json_decode($value['targets'])) && (!empty($fid)?in_array($fid,json_decode($value['fids'])):false) && $value ['isopen'] == '1' )
						{
						    $m_starttime = $value['starttime'];
						    $m_endtime = $value['endtime'];
						    $m_isok = $this->gettimeisok($m_starttime,$m_endtime);
						    if($m_isok == 1){
						        $m_isok = true;
						        
						        if(!empty($value['users'])){
						            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
						                $m_isok = true;
						                $mtzid = $value['id'];
						                $mtzvalue = $value;
						                break;
						            }
						        }else{
						            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
						                $m_isok = true;
						                $mtzid = $value['id'];
						                $mtzvalue = $value;
						                break;
						            }
						        }
						    }else{
						        $m_isok = false;
						        dsetcookie('webtctzcount'.$cookiestag.$mtzid, '0',time()+3153600000);
						    }
						    
						        
						}else{
							$m_isok = false;
						}
					}
					

					if($m_isok){
						$m_mtzcount = $_G['cookie']['webtctzcount'.$cookiestag.$mtzid];
						$lastopentime = $_G['cookie']['webtctzlastopentime'.$cookiestag.$mtzid];
						$nowopentime = TIMESTAMP;
						if(empty($m_mtzcount)){
							$m_mtzcount = 0;
						}
						if(empty($lastopentime)){
							$lastopentime = $nowopentime-$mtzvalue['interval'];
						}
						
						if((($m_mtzcount + 1) <= $mtzvalue['count']) && ($mtzvalue['interval'] == 0?true:(($nowopentime - $lastopentime)>=$mtzvalue['interval']))){
							
							$this->setvalues($mtzvalue);
							$m_mtzcount++;
						
							dsetcookie('webtctzcount'.$cookiestag.$mtzid, $m_mtzcount,time()+3153600000);
							dsetcookie('webtctzlastopentime'.$cookiestag.$mtzid, $nowopentime,time()+3153600000);
							
							$m_isok = true;
						}else{
							$m_isok = false;
						}
					}
						
						
						
				}
				//--forum forumdisplay end
				
				//--forum viewthread start
				if($curm == "viewthread"){
					$cookiestag = "forumviewthread";
					
					$exittargets = false;

					if(!empty($tid)){
						foreach($mtz as $key => $value) {
						    
							if (in_array('2',json_decode($value['targets'])) && in_array($tid,json_decode($value['tids'])) && $value ['isopen'] == '1' )
							{
							    $m_starttime = $value['starttime'];
							    $m_endtime = $value['endtime'];
							    $m_isok = $this->gettimeisok($m_starttime,$m_endtime);
							    if($m_isok == 1){
							        $m_isok = true;
							        
							        if(!empty($value['users'])){
							            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
							                $m_isok = true;
							                $mtzid = $value['id'];
							                $mtzvalue = $value;
							                $exittargets = true;
							                break;
							            }
							        }else{
							            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
							                $m_isok = true;
							                $mtzid = $value['id'];
							                $mtzvalue = $value;
							                $exittargets = true;
							                break;
							            }
							        }
							    }else{
							        $m_isok = false;
							        dsetcookie('webtctzcount'.$cookiestag.$mtzid, '0',time()+3153600000);
							    }
							    
								
								
							}else{
								$m_isok = false;
								$exittargets = false;
							}
						}
					}
					

					
					if(!$exittargets){
						if(!empty($tid)){
							$threadresult = C::t('forum_thread')->fetch($tid);
							$fid = $threadresult['fid'];
							$m_isok = true;
						}else{
							$fid = "";
							$m_isok = false;
						}
						foreach($mtz as $key => $value) {
						    
							if (in_array('2',json_decode($value['targets'])) && (!empty($fid)?in_array($fid,json_decode($value['fids'])):false) && $value ['isopen'] == '1' )
							{
							    $m_starttime = $value['starttime'];
							    $m_endtime = $value['endtime'];
							    $m_isok = $this->gettimeisok($m_starttime,$m_endtime);
							    if($m_isok == 1){
							        $m_isok = true;
							        
							        if(!empty($value['users'])){
							            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
							                $m_isok = true;
							                $mtzid = $value['id'];
							                $mtzvalue = $value;
							                $exittargets = true;
							                break;
							            }
							        }else{
							            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
							                $m_isok = true;
							                $mtzid = $value['id'];
							                $mtzvalue = $value;
							                $exittargets = true;
							                break;
							            }
							        }
							    }else{
							        $m_isok = false;
							        dsetcookie('webtctzcount'.$cookiestag.$mtzid, '0',time()+3153600000);
							    }
							    
								
								
							}else{
								$m_isok = false;
								$exittargets = false;
							}
						}
					}
					
	
					
					if($m_isok){
						$m_mtzcount = $_G['cookie']['webtctzcount'.$cookiestag.$mtzid];
						$lastopentime = $_G['cookie']['webtctzlastopentime'.$cookiestag.$mtzid];
						$nowopentime = TIMESTAMP;
						//echo "===".$m_mtzcount;
						if(empty($m_mtzcount)){
							$m_mtzcount = 0;
						}
						if(empty($lastopentime)){
							$lastopentime = $nowopentime-$mtzvalue['interval'];
						}
						//var_dump((($m_mtzcount + 1) <= $mtzvalue['count']));
						if((($m_mtzcount + 1) <= $mtzvalue['count']) && ($mtzvalue['interval'] == 0?true:(($nowopentime - $lastopentime)>=$mtzvalue['interval']))){
							
							$this->setvalues($mtzvalue);
							$m_mtzcount++;
						
							dsetcookie('webtctzcount'.$cookiestag.$mtzid, $m_mtzcount,time()+3153600000);
							dsetcookie('webtctzlastopentime'.$cookiestag.$mtzid, $nowopentime,time()+3153600000);
							
							$m_isok = true;
						}else{
							$m_isok = false;
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
				$mtzid = "";
				$mtzvalue = array();
				$m_isok = false;
				//echo "---gid--".$gid."--sgid---".$sgid."---fid--".$fid."--tid---".$tid;
				//echo "--fid--".$fid."==tid==".$tid."))))))";
			
				//--group index start
				if($curm == "index"){
					$cookiestag = "groupindex";
					foreach($mtz as $key => $value) {
							
						if (in_array('3',json_decode($value['targets'])) && (empty($gid)?(empty($sgid)?in_array('0',json_decode($value['groups'])):in_array($sgid,json_decode($value['groups']))):in_array($gid,json_decode($value['groups']))) && $value ['isopen'] == '1' )
						{
						    $m_starttime = $value['starttime'];
						    $m_endtime = $value['endtime'];
						    $m_isok = $this->gettimeisok($m_starttime,$m_endtime);
						    if($m_isok == 1){
						        $m_isok = true;
						        
						        if(!empty($value['users'])){
						            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
						                $m_isok = true;
						                $mtzid = $value['id'];
						                $mtzvalue = $value;
						                break;
						            }
						        }else{
						            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
						                $m_isok = true;
						                $mtzid = $value['id'];
						                $mtzvalue = $value;
						                break;
						            }
						        }
						    }else{
						        $m_isok = false;
						        dsetcookie('webtctzcount'.$cookiestag.$mtzid, '0',time()+3153600000);
						    }
						    
						        
						}else{
							$m_isok = false;
						}
					}
			
		
					if($m_isok){
						$m_mtzcount = $_G['cookie']['webtctzcount'.$cookiestag.$mtzid];
						$lastopentime = $_G['cookie']['webtctzlastopentime'.$cookiestag.$mtzid];
						$nowopentime = TIMESTAMP;
						if(empty($m_mtzcount)){
							$m_mtzcount = 0;
						}
						if(empty($lastopentime)){
							$lastopentime = $nowopentime-$mtzvalue['interval'];
						}
						
						if((($m_mtzcount + 1) <= $mtzvalue['count']) && ($mtzvalue['interval'] == 0?true:(($nowopentime - $lastopentime)>=$mtzvalue['interval']))){
							
							$this->setvalues($mtzvalue);
							$m_mtzcount++;
						
							dsetcookie('webtctzcount'.$cookiestag.$mtzid, $m_mtzcount,time()+3153600000);
							dsetcookie('webtctzlastopentime'.$cookiestag.$mtzid, $nowopentime,time()+3153600000);
							
							$m_isok = true;
						}else{
							$m_isok = false;
						}
					}
						
						
						
				}
				//--group index end
			
				//--group group start
				if($curm == "group"){
					$cookiestag = "groupgroup";
					foreach($mtz as $key => $value) {
							
						if (in_array('3',json_decode($value['targets'])) && (!empty($fid)?in_array($fid,json_decode($value['groups'])):false) && $value ['isopen'] == '1' )
						{
						    $m_starttime = $value['starttime'];
						    $m_endtime = $value['endtime'];
						    $m_isok = $this->gettimeisok($m_starttime,$m_endtime);
						    if($m_isok == 1){
						        $m_isok = true;
						        
						        if(!empty($value['users'])){
						            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
						                $m_isok = true;
						                $mtzid = $value['id'];
						                $mtzvalue = $value;
						                break;
						            }
						        }else{
						            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
						                $m_isok = true;
						                $mtzid = $value['id'];
						                $mtzvalue = $value;
						                break;
						            }
						        }
						    }else{
						        $m_isok = false;
						        dsetcookie('webtctzcount'.$cookiestag.$mtzid, '0',time()+3153600000);
						    }
						    
						        
						}else{
							$m_isok = false;
						}
					}
						
		
					if($m_isok){
						$m_mtzcount = $_G['cookie']['webtctzcount'.$cookiestag.$mtzid];
						$lastopentime = $_G['cookie']['webtctzlastopentime'.$cookiestag.$mtzid];
						$nowopentime = TIMESTAMP;
						if(empty($m_mtzcount)){
							$m_mtzcount = 0;
						}
						if(empty($lastopentime)){
							$lastopentime = $nowopentime-$mtzvalue['interval'];
						}
						
						if((($m_mtzcount + 1) <= $mtzvalue['count']) && ($mtzvalue['interval'] == 0?true:(($nowopentime - $lastopentime)>=$mtzvalue['interval']))){
							
							$this->setvalues($mtzvalue);
							$m_mtzcount++;
						
							dsetcookie('webtctzcount'.$cookiestag.$mtzid, $m_mtzcount,time()+3153600000);
							dsetcookie('webtctzlastopentime'.$cookiestag.$mtzid, $nowopentime,time()+3153600000);
							
							$m_isok = true;
						}else{
							$m_isok = false;
						}
					}
			
			
			
				}
				//--group group end
			
				//--group viewthread start
				if($curm == "viewthread"){
					$cookiestag = "groupviewthread";
					
					
					
					$exittargets = false;
						
					if(!empty($tid)){
						foreach($mtz as $key => $value) {
					
							if (in_array('3',json_decode($value['targets'])) && in_array($tid,json_decode($value['tids'])) && $value ['isopen'] == '1' )
							{
							    $m_starttime = $value['starttime'];
							    $m_endtime = $value['endtime'];
							    $m_isok = $this->gettimeisok($m_starttime,$m_endtime);
							    if($m_isok == 1){
							        $m_isok = true;
							        
							        if(!empty($value['users'])){
							            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
							                $m_isok = true;
							                $mtzid = $value['id'];
							                $mtzvalue = $value;
							                $exittargets = true;
							                break;
							            }
							        }else{
							            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
							                $m_isok = true;
							                $mtzid = $value['id'];
							                $mtzvalue = $value;
							                $exittargets = true;
							                break;
							            }
							        }
							    }else{
							        $m_isok = false;
							        dsetcookie('webtctzcount'.$cookiestag.$mtzid, '0',time()+3153600000);
							    }
							    
								
					
							}else{
								$m_isok = false;
								$exittargets = false;
							}
						}
					}
						
						
						
						
					if(!$exittargets){
						if(!empty($tid)){
							$threadresult = C::t('forum_thread')->fetch($tid);
							$fid = $threadresult['fid'];
							$m_isok = true;
						}else{
							$fid = "";
							$m_isok = false;
						}
						foreach($mtz as $key => $value) {
					
							if (in_array('3',json_decode($value['targets'])) && (!empty($fid)?in_array($fid,json_decode($value['groups'])):false) && $value ['isopen'] == '1' )
							{
							    $m_starttime = $value['starttime'];
							    $m_endtime = $value['endtime'];
							    $m_isok = $this->gettimeisok($m_starttime,$m_endtime);
							    if($m_isok == 1){
							        $m_isok = true;
							        
							        if(!empty($value['users'])){
							            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
							                $m_isok = true;
							                $mtzid = $value['id'];
							                $mtzvalue = $value;
							                $exittargets = true;
							                break;
							            }
							        }else{
							            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
							                $m_isok = true;
							                $mtzid = $value['id'];
							                $mtzvalue = $value;
							                $exittargets = true;
							                break;
							            }
							        }
							    }else{
							        $m_isok = false;
							        dsetcookie('webtctzcount'.$cookiestag.$mtzid, '0',time()+3153600000);
							    }
							    
								
					
							}else{
								$m_isok = false;
								$exittargets = false;
							}
						}
					}
					

					if($m_isok){
						$m_mtzcount = $_G['cookie']['webtctzcount'.$cookiestag.$mtzid];
						$lastopentime = $_G['cookie']['webtctzlastopentime'.$cookiestag.$mtzid];
						$nowopentime = TIMESTAMP;
						if(empty($m_mtzcount)){
							$m_mtzcount = 0;
						}
						if(empty($lastopentime)){
							$lastopentime = $nowopentime-$mtzvalue['interval'];
						}
						
						if((($m_mtzcount + 1) <= $mtzvalue['count']) && ($mtzvalue['interval'] == 0?true:(($nowopentime - $lastopentime)>=$mtzvalue['interval']))){
							
							$this->setvalues($mtzvalue);
							$m_mtzcount++;
						
							dsetcookie('webtctzcount'.$cookiestag.$mtzid, $m_mtzcount,time()+3153600000);
							dsetcookie('webtctzlastopentime'.$cookiestag.$mtzid, $nowopentime,time()+3153600000);
							
							$m_isok = true;
						}else{
							$m_isok = false;
						}
					}
			
			
			
				}
				//--group viewthread end
			
			}
			
			
			
			
			
			
			if($basescript == "home"){
				
				$mtzid = "";
				$mtzvalue = array();
				$m_isok = false;
				//echo "----catid------".$catid."===aid===".$aid;
				//--home space start
				if($curm == "space"){
					$cookiestag = "homespace";
					foreach($mtz as $key => $value) {
							
						if (in_array('4',json_decode($value['targets'])) && $value ['isopen'] == '1')
						{
						    $m_starttime = $value['starttime'];
						    $m_endtime = $value['endtime'];
						    $m_isok = $this->gettimeisok($m_starttime,$m_endtime);
						    if($m_isok == 1){
						        $m_isok = true;
						        
						        if(!empty($value['users'])){
						            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
						                $m_isok = true;
						                $mtzid = $value['id'];
						                $mtzvalue = $value;
						                break;
						            }
						        }else{
						            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
						                $m_isok = true;
						                $mtzid = $value['id'];
						                $mtzvalue = $value;
						                break;
						            }
						        }
						    }else{
						        $m_isok = false;
						        dsetcookie('webtctzcount'.$cookiestag.$mtzid, '0',time()+3153600000);
						    }
						    
						        
						}else{
							$m_isok = false;
						}
					}
			

					if($m_isok){
						$m_mtzcount = $_G['cookie']['webtctzcount'.$cookiestag.$mtzid];
						$lastopentime = $_G['cookie']['webtctzlastopentime'.$cookiestag.$mtzid];
						$nowopentime = TIMESTAMP;
						if(empty($m_mtzcount)){
							$m_mtzcount = 0;
						}
						if(empty($lastopentime)){
							$lastopentime = $nowopentime-$mtzvalue['interval'];
						}
						
						if((($m_mtzcount + 1) <= $mtzvalue['count']) && ($mtzvalue['interval'] == 0?true:(($nowopentime - $lastopentime)>=$mtzvalue['interval']))){
							
							$this->setvalues($mtzvalue);
							$m_mtzcount++;
						
							dsetcookie('webtctzcount'.$cookiestag.$mtzid, $m_mtzcount,time()+3153600000);
							dsetcookie('webtctzlastopentime'.$cookiestag.$mtzid, $nowopentime,time()+3153600000);
							
							$m_isok = true;
						}else{
							$m_isok = false;
						}
					}
			
			
			
				}
				//--home space end
			
			}
			
			
			
			//-----plugin start----------
			if($basescript == "plugin"){
			
				$mtzid = "";
				$mtzvalue = array();
				$m_isok = false;
				
					$cookiestag = "plugin";
					foreach($mtz as $key => $value) {
							
						if (in_array('5',json_decode($value['targets'])) && in_array($curm,json_decode($value['plugins'])) && $value ['isopen'] == '1')
						{
						    $m_starttime = $value['starttime'];
						    $m_endtime = $value['endtime'];
						    $m_isok = $this->gettimeisok($m_starttime,$m_endtime);
						    if($m_isok == 1){
						        $m_isok = true;
						        
						        if(!empty($value['users'])){
						            if(in_array ( $uid, json_decode ( $value ['users'] ) )){
						                $m_isok = true;
						                $mtzid = $value['id'];
						                $mtzvalue = $value;
						                break;
						            }
						        }else{
						            if(in_array ( $groupid, json_decode ( $value ['usergroup'] ) )){
						                $m_isok = true;
						                $mtzid = $value['id'];
						                $mtzvalue = $value;
						                break;
						            }
						        }
						    }else{
						        $m_isok = false;
						        dsetcookie('webtctzcount'.$cookiestag.$mtzid, '0',time()+3153600000);
						    }
							
						}else{
							$m_isok = false;
						}
					}
						

					if($m_isok){
						$m_mtzcount = $_G['cookie']['webtctzcount'.$cookiestag.$mtzid];
						$lastopentime = $_G['cookie']['webtctzlastopentime'.$cookiestag.$mtzid];
						$nowopentime = TIMESTAMP;
						if(empty($m_mtzcount)){
							$m_mtzcount = 0;
						}
						if(empty($lastopentime)){
							$lastopentime = $nowopentime-$mtzvalue['interval'];
						}
							
						if((($m_mtzcount + 1) <= $mtzvalue['count']) && ($mtzvalue['interval'] == 0?true:(($nowopentime - $lastopentime)>=$mtzvalue['interval']))){
			
							$this->setvalues($mtzvalue);
							$m_mtzcount++;
								
							dsetcookie('webtctzcount'.$cookiestag.$mtzid, $m_mtzcount,time()+3153600000);
							dsetcookie('webtctzlastopentime'.$cookiestag.$mtzid, $nowopentime,time()+3153600000);
			
							$m_isok = true;
						}else{
							$m_isok = false;
						}
					}
						
					
			}
				
				
			//------plugin end---------
			
			
			
			if($m_isok == true){
				include template('webtctz:mobilepopup');
				return $return;
			}else{
				return "";
			}
		}else{
			return "";
		}
	}
	
	
	function setvalues($mtzvalue) {
		global $m_isopenborder,$m_isclosetime,$m_isanimatestart,$m_iscloseshow,$m_isfloat,$m_delay,$m_isbg,$m_zindex,$m_height, $m_width,$m_type,$m_cimg,$m_ctext,$m_curl,$m_ciframe,$m_chtml,$m_closetime,$m_position,$m_pyright,$m_pybottom,$m_transparency,$m_contentbg,$m_ccloseimg,$m_closepyright,$m_closepybottom,$m_closeheight,$m_closewidth;
		$m_isopenborder  = $mtzvalue ['isopenborder'];
		$m_isclosetime  = $mtzvalue ['isclosetime'];
		$m_isanimatestart  = $mtzvalue ['isanimatestart'];
		$m_iscloseshow  = $mtzvalue ['iscloseshow'];
		$m_isfloat  = $mtzvalue ['isfloat'];
		$m_isbg  = $mtzvalue ['isbg'];
		$m_delay = $mtzvalue ['delay'];
		$m_zindex  = $mtzvalue ['zindex'];
		$m_height = $mtzvalue ['height'];
		$m_width = $mtzvalue ['width'];
		$m_type = $mtzvalue ['type'];
		$m_position = $mtzvalue ['position'];
		$m_pyright = $mtzvalue ['pyright'];
		$m_pybottom = $mtzvalue ['pybottom'];
		$m_transparency = $mtzvalue ['transparency'];
		$m_contentbg = $mtzvalue ['contentbg'];
		$m_ccloseimg = $mtzvalue ['ccloseimg'];
		$m_closeheight = $mtzvalue ['closeheight'];
		$m_closewidth = $mtzvalue ['closewidth'];
		$m_closepyright = $mtzvalue ['closepyright'];
		$m_closepybottom = $mtzvalue ['closepybottom'];
		
		if ($mtzvalue ['type'] == 0) {
			$m_cimg = $mtzvalue ['cimg'];
		} else if ($mtzvalue ['type'] == 1) {
			$m_ctext = $mtzvalue ['ctext'];
		} else if ($mtzvalue ['type'] == 2) {
			$m_ciframe = $mtzvalue ['ciframe'];
		} else if ($mtzvalue ['type'] == 3) {
			$m_chtml = $mtzvalue ['chtml'];
		} else {
			$m_ctext = $mtzvalue ['ctext'];
		}
		
		if (! empty ( $mtzvalue ['curl'] )) {
			$m_curl = $mtzvalue ['curl'];
		} else {
			$m_curl = "";
		}
		
		$m_closetime = $mtzvalue ['closetime'];
		
		if($m_width == "-1" && $m_height != "-1"){
		    $m_width = "100%";
		    if(empty($m_height) || $m_height == "0"){
		        $m_height = "";
		    }else{
		        $m_height = $m_height."px";
		    }
		    
		}else if($m_width != "-1" && $m_height == "-1"){
		    if(empty($m_width) || $m_width == "0"){
		        $m_width = "30px";
		    }else{
		        $m_width = $m_width."px";
		    }
		    $m_height = "100%";
		}else if($m_width == "-1" && $m_height == "-1"){
		    $m_width = "100%";
		    $m_height = "100%";
		}else{
		    $m_width = $m_width."px";
		    $m_height = $m_height."px";
		}
		return;
	}
	

	function gettimeisok($m_starttime,$m_endtime){
		$m_isok = false;
		$nowtime = TIMESTAMP;
		if(empty($m_starttime) && empty($m_endtime)){
			$m_isok = true;
		}elseif (!empty($m_starttime) && empty($m_endtime)){
			if($m_starttime <= $nowtime){
				$m_isok = true;
			}else{
				$m_isok = false;
			}
		}elseif (empty($m_starttime) && !empty($m_endtime)){
			if($m_endtime >= $nowtime){
				$m_isok = true;
			}else{
				$m_isok = false;
			}
		}elseif (!empty($m_starttime) && !empty($m_endtime)){
			if($m_starttime <= $nowtime && $m_endtime >= $nowtime){
				$m_isok = true;
			}else{
				$m_isok = false;
			}
		}else{
			$m_isok = false;
		}
		return $m_isok;
	}
	
	function getsetting() {
		global $_G;
		$settings = array(
				'fids' => array(
						'title' => 'mtzfidstitle',
						'type' => 'mselect',
						'comment' => 'mtzfidscomment',
						'value' => array(),
				),
				'groups' => array(
						'title' => 'mtzgroupstitle',
						'type' => 'mselect',
						'comment' => 'mtzgroupscomment',
						'value' => array(),
				),
				'category' => array(
						'title' => 'mtzcategorytitle',
						'type' => 'mselect',
						'comment' => 'mtzcategorycomment',
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
			$targetsname .= plang('mtztargetscategory').",";
		}
		if(in_array('2',$targets)){
			$targetsname .= plang('mtztargetsfids').",";
		}
		if(in_array('3',$targets)){
			$targetsname .= plang('mtztargetsgroups').",";
		}
		if(in_array('4',$targets)){
			$targetsname .= plang('mtztargetshome').",";
		}
		if(in_array('5',$targets)){
			$targetsname .= plang('mtztargetsplugin').",";
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
	
	function gettypename($m_type) {
		$m_typename = "";
		$mtztype = plang('mtztype');
		switch ($m_type) {
			case "0" :
				$m_typename = $mtztype[0];
				break;
			case "1" :
				$m_typename = $mtztype[1];
				break;
			case "2" :
				$m_typename = $mtztype[2];
				break;
			case "3" :
				$m_typename = $mtztype[3];
				break;
			default :
				$m_typename = $mtztype[0];
				break;
		}
		return $m_typename;
	}
	
	function getpositionname($m_position) {
		$m_positionname = "";
		$mtzposition = plang ( 'mtzposition' );
		switch ($m_position) {
			case "0" :
				$m_positionname = $mtzposition [0];
				break;
			case "1" :
				$m_positionname = $mtzposition [1];
				break;
			case "2" :
				$m_positionname = $mtzposition [2];
				break;
			case "3" :
				$m_positionname = $mtzposition [3];
				break;
			case "4" :
				$m_positionname = $mtzposition [4];
				break;
			case "5" :
				$m_positionname = $mtzposition [5];
				break;
			case "6" :
				$m_positionname = $mtzposition [6];
				break;
			case "7" :
				$m_positionname = $mtzposition [7];
				break;
			case "8" :
				$m_positionname = $mtzposition [8];
				break;
			default :
				$m_positionname = $mtzposition [0];
				break;
		}
		return $m_positionname;
	}
	
	function plang($str) {
		return lang('plugin/webtctz', $str);
	}
}
//WWW.fx8.cc
?>