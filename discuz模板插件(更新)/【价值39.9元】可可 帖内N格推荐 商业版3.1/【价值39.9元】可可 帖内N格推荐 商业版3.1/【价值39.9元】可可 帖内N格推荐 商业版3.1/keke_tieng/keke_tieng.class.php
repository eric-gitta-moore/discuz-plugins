<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_keke_tieng_forum {
	
	
	function  viewthread_modaction(){
	
			global $_G;
			$keke_tieng=$_G['cache']['plugin']['keke_tieng'];
			$section = empty($keke_tieng['xsbk']) ? array() : unserialize($keke_tieng['xsbk']);
			if(!is_array($section)) $section = array();
			if(!(empty($section[0]) || in_array($_G['fid'],$section))){
			return;
			}
			
			$zda=empty($keke_tieng['zdnra']) ? array() : explode('|', $keke_tieng['zdnra']);
			$zdb=empty($keke_tieng['zdnrb']) ? array() : explode('|', $keke_tieng['zdnrb']);
			
			loadcache('keke_tieng');
			$info=$_G['cache']['keke_tieng'];
			if($info && $_G['timestamp']<$info[7]+$keke_tieng['hcsj']){
			$list[1]=$info[1];
			$list[2]=$info[2];
			}else{	
			$info[1]=$list[1]=$this->getdata($keke_tieng['sxa'],$zda);	
			$info[2]=$list[2]=$this->getdata($keke_tieng['sxb'],$zdb);
			$info[7]=$_G['timestamp'];
			require_once libfile('function/cache');
			savecache('keke_tieng', $info);
			}
			include template('keke_tieng:index');
			return $return;

	}
	
	function getdata($nb,$zd){
		
		global $_G;
		$keke_tieng=$_G['cache']['plugin']['keke_tieng'];
		
		
		$number=$keke_tieng['nb']==0 ? $number='6' : intval($keke_tieng['nb']);
		
		$attribute=$nb==0 ? 1 : $nb;
		$appoint = $zd;
		
		if($appoint){
			$where = ' a.tid IN ('.dimplode($appoint).') and ';
			$order= "dateline";
		}else{
			$source = empty($keke_tieng['ly'])?array():unserialize($keke_tieng['ly']);
			if(!is_array($source)) $source = array();
			if($source[0]){
				$where.='a.fid IN ('.dimplode($source).') and ';
				}
			if($attribute==1){
			  $order= "a.dateline";
			  }elseif($attribute==2){
			  $where.= "a.replies>'0' and ";$order= "a.lastpost";
			  }elseif($attribute==3){
			  $where.= "a.digest>'0' and ";$order= "a.dateline";
			  }elseif($attribute==4){
			  $where.= "a.displayorder IN (1, 2, 3, 4) and ";$order= "a.dateline";
			  }elseif($attribute==5){
			  $order= "a.views";
			  }elseif($attribute==6){
			  $order= "a.replies";
			  }
		}
		
		if($keke_tieng['sjfw']!=1){
		if($keke_tieng['sjfw']==2){$dateline=time()-604800;}elseif($keke_tieng['sjfw']==3){$dateline=time()-2592000;}elseif($keke_tieng['sjfw']==5){$dateline=time()-15552000;}
		$where.='a.dateline>'.$dateline.' and ';}
		
		$n=1;
		$query = DB::query("select a.tid,a.author,a.subject,a.fid,b.name from ".DB::table('forum_thread')." a,".DB::table('forum_forum')." b where ".$where."a.displayorder>='0' and a.fid=b.fid ORDER BY ".$order." desc limit 0,".$number."");	
		while ($data=DB::fetch($query)){
			
			if($keke_tieng['wjt']){
				$ajs='thread-'.$data['tid'].'-1-1.html';
				$bka="<a href='forum-".$data['fid']."-1.html' target='_blank' class='bk'><font style=\"font-size:".$keke_tieng['ztdx']."px\">[".$data[name]."]</font></a>";
				}else{
					$ajs='forum.php?mod=viewthread&tid='.$data['tid'].'';
					$bka="<a href='forum.php?mod=forumdisplay&fid=".$data['fid']."'target='_blank' class='bk'><font style=\"font-size:".$keke_tieng['ztdx']."px\">[".$data[name]."]</font></a>";
					}
					
			if($keke_tieng['bkmc']){$bk=$bka;}else{$bk='';}
			if($keke_tieng['zz']){$zz='<span><font style=\"font-size:'.$keke_tieng['ztdx'].'px\">'.$data['author'].'</font></span>';}else{$zz='';}
			if($n==1){$list[t].="<a href='".$ajs."' target='_blank' class='list'>".$data['subject']."</a>";}else{
			$list[b].="<li>".$zz."".$bk." <a href='".$ajs."' target='_blank' class='list'><font style=\"font-size:".$keke_tieng['ztdx']."px\">".$data['subject']."</font></a></li>";}
			$n++;
			
		}
		
			return $list;
	
		
	}
}