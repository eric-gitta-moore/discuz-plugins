<?php
/*
 *源 码  哥    y     m  g   6 .     c     o   m
 *更多商业插件/模版免费下载 就在源   码    哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */

if(!defined('IN_DISCUZ')) {
        exit('Access Denied');
}

class plugin_daxiong_avatar_meituxiuxiu {
    public  $name='daxiong_avatar_meituxiuxiu';
    public  $conf = array();
	public  $isopen = FALSE;
	function __construct()
	{
		global $_G;		
		if(!isset($_G['cache']['plugin'])){
			loadcache('plugin');
		}
		 $this->isopen = $_G['cache']['plugin'][$this->name]['isopen'] ? TRUE : FALSE;
		if($this->isopen) {
			$this->conf = $_G['cache']['plugin'][$this->name];
		
		}
	}
	
	function common(){
		
		if($this->isopen) {
			global $_G;
			    if($_G['basescript'] == 'home' && $_GET['mod'] == 'spacecp' && $_GET['ac'] == 'avatar'){
				require_once libfile('function/spacecp');
				require_once libfile('function/magic');
				if(empty($_G['uid'])) {
				if($_SERVER['REQUEST_METHOD'] == 'GET') {
						dsetcookie('_refer', rawurlencode($_SERVER['REQUEST_URI']));
					} else {
						dsetcookie('_refer', rawurlencode('home.php?mod=spacecp&ac='.$ac));
					}
					showmessage('to_login', '', array(), array('showmsg' => true, 'login' => 1));
				}

				$space = getuserbyuid($_G['uid']);
				if(empty($space)) {
					showmessage('space_does_not_exist');
				}
				space_merge($space, 'field_home');

				if(($space['status'] == -1 || in_array($space['groupid'], array(4, 5, 6))) && $ac != 'usergroup') {
					showmessage('space_has_been_locked');
				}
				if(submitcheck('avatarsubmit')) {
					showmessage('do_success', 'cp.php?ac=avatar&quickforward=1');
				}
				
				loaducenter();
				$uc_avatarflash = uc_avatar($_G['uid'], 'virtual', 0);
				
				if(empty($space['avatarstatus']) && uc_check_avatar($_G['uid'], 'middle')) {
					C::t('common_member')->update($_G['uid'], array('avatarstatus'=>'1'));
				
					updatecreditbyaction('setavatar');
				
					manyoulog('user', $_G['uid'], 'update');
				}
				$reload = intval($_GET['reload']);
				$actives = array('avatar' =>' class="a"');
				include template($this->name.":home");
				exit();
				}
			}
			
		}
	

}
	

?>