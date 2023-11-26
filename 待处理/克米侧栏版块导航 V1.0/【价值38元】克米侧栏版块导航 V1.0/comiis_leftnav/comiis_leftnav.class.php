<?php

/**
 * 
 * Ñ¶»ÃÍø www.xhkj5.com
 */
 
if(!defined('IN_DISCUZ')) {exit('Access Denied');}
$finish = TRUE;
class plugin_comiis_leftnav {
	function global_header(){
		global $_G;
		if(!$_G['cache']['forums']) {
			loadcache('forums');
		}
		$plugindata = $inforums = $forumlist = $haschild = array();
		$html = '';
		$plugindata = $_G['cache']['plugin']['comiis_leftnav'];
		$inshow = unserialize($plugindata['show']);
		if(in_array('all', $inshow) || in_array($_G['basescript'].CURMODULE, $inshow)) {
			$inforums = unserialize($plugindata['inforum']);
			foreach($_G['cache']['forums'] as $forum) {
				if(!$forum['status']) {
					continue;
				}
				if(in_array(0, $inforums) || in_array($forum['fid'], $inforums)) {
					$forum['name'] = addslashes($forum['name']);
					$forum['type'] != 'group' && $haschild[$forum['fup']] = true;
					$forumlist[] = $forum;
				}
			}
			foreach($_G['cache']['forums'] as $forumdata) {
				if($forumdata['type'] == 'group' && $haschild[$forumdata['fid']]){
						$html .= '<dl><dt> <a href="forum.php?gid='.$forumdata['fid'].'" '.($plugindata['target'] ? 'target="_blank"' : '').'>'.$forumdata['name'].'</a> </dt><dd>';
						foreach($forumlist as $forums) {
							if($forums['type'] == 'forum' && $forums['fup']==$forumdata['fid']){
								$html .= '<a href="forum.php?mod=forumdisplay&fid='.$forums['fid'].'" '.($plugindata['target'] ? 'target="_blank"' : '').($_G['fid']==$forums['fid'] ? ' class="kmon"' : '').'>'.$forums['name'].'</a>';
								if($plugindata['showsub']){
									foreach($forumlist as $forumsub) {
										if($forumsub['type'] == 'sub' && $forumsub['fup']==$forums['fid']){
											$html .= '<a href="forum.php?mod=forumdisplay&fid='.$forumsub['fid'].'" '.($plugindata['target'] ? 'target="_blank"' : ''). ' class="comiis_sub' .($_G['fid']==$forumsub['fid'] ? ' kmon' : '').'">'.$forumsub['name'].'</a>';
										}
									}
								}
							}					
						}
						$html .= '</dd></dl>';
				}
			}
			return '<style>
					.comiis_left_div{position:relative;overflow:visible;z-index:190;}
					#comiis_left_bar{border:'.$plugindata['bcolor'].' 1px solid;position:absolute;width:'.$plugindata['width'].'px;background:#fff;top:'.$plugindata['ptop'].'px;left:-'.($plugindata['width'] + $plugindata['pright']).'px;border-radius:3px;}
					#comiis_left_bar p{text-align:center;line-height:40px;background:url('.$plugindata['bgimage'].') repeat-x 0px 0px;color:'.$plugindata['dbtcolor'].';font-size:16px;font-weight:400;height:40px;overflow:hidden;border-radius:3px 3px 0px 0px;margin:1px;}					
					#comiis_left_bar dl dt{padding-left:10px;background:'.$plugindata['gidbgcolor'].';height:30px;border-top:'.$plugindata['bcolor'].' 1px solid;border-bottom:'.$plugindata['bcolor'].' 1px solid;}
					#comiis_left_bar dl dt a{line-height:30px;color:'.$plugindata['gidcolor'].';font-size:14px;font-weight:400;text-decoration:none}
					#comiis_left_bar dl dd{padding:5px;font-size:14px;}
					#comiis_left_bar dl dd a.comiis_sub{font-size:12px;text-indent:12px;background-image:url(source/plugin/comiis_leftnav/image/comiis_dot.gif);background-repeat:no-repeat;background-position:8px 12px;}
					#comiis_left_bar dl dd a{line-height:28px;padding-left:5px;display:block;height:28px;color:'.$plugindata['fidcolor'].';overflow:hidden;}
					#comiis_left_bar dl dd a.kmon,#comiis_left_bar dl dd a:hover{background-color:'.$plugindata['infidbgcolor'].';color:'.$plugindata['infidcolor'].';text-decoration:none;}
					.comiis_left_close{position:absolute;top:-15px;right:2px;background:#fff;}
					.ie6 #comiis_left_bar p,.ie6 #comiis_left_bar dl dt a{font-weight:700;}				
					</style>
					<div class="comiis_left_div wp">
						<div id="comiis_left_bar">
						'.($plugindata['inclose'] ?	'<a onclick="this.parentNode.style.display=\'none\'" href="javascript:;" class="comiis_left_close"><IMG src="source/plugin/comiis_leftnav/image/comiis_close.gif" /></a>' : '').'
							<p> '.$plugindata['name'].' </p>
							'.$html.'		
						</div>
					</div>
					<script type="text/javascript">
					function comiis_left_js() {
						var element = $(\'nv\');
						var left = element.offsetLeft;
						while(element = element.offsetParent) {
							left += element.offsetLeft;
						}
						if(left <= '.($plugindata['width'] + $plugindata['pright']).'){
							$(\'comiis_left_bar\').style.left = "0px";
							if(0 == '.$plugindata['inwidth'].'){
								$(\'comiis_left_bar\').style.display=\'none\';
							}
						}else{
							$(\'comiis_left_bar\').style.left = "-'.($plugindata['width'] + $plugindata['pright']).'px";
							if(0 == '.$plugindata['inwidth'].'){
								$(\'comiis_left_bar\').style.display=\'\';
							}
						}
					}
					_attachEvent(window, \'resize\', function(){comiis_left_js();});
					comiis_left_js();
					</script>';	
		}
	}
}

?>