<?php
/*
 *源码哥：www.ymg6.com
 *更多商业插件/模版免费下载 就在源码哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class plugin_himickey_threadmail {}

class plugin_himickey_threadmail_forum extends plugin_himickey_threadmail {

    function post_message($params) {

        global $_G;
		$configs = $_G['cache']['plugin']['himickey_threadmail'];
        $param = $params["param"];

        if ($_GET["action"] == "reply" && $param[0] == "post_reply_succeed") {
			if(in_array($_G['fid'], unserialize($configs['fids']))) {
				$author = getuserbyuid($_G['forum_thread']['authorid']);
				if(in_array($author['groupid'], unserialize($configs['gids']))) {
					if(!empty($author['email']) && ($_G["uid"] != $author["uid"])) {
						$threadurl = $_G['siteurl'] . $param[1];
						$a = array(
							'{username}',
							'{subject}',
							'{postmsg}',
							'{threadurl}',
							'{bbname}',
							'{siteurl}',
						);
						$v = array(
							$_G['username'],
							dhtmlspecialchars($_G['forum_thread']['subject']),
							dhtmlspecialchars($_GET['message']),
							$threadurl,
							$_G['setting']['bbname'],
							$_G['siteurl'],
						);
						$mailtext = str_replace($a, $v, $configs['mail_text']);
						$mailtitle = str_replace($a, $v, $configs['$mail_title']);
						include_once libfile("function/mail");
						sendmail($author['email'], $mailtitle, $mailtext);
					}
				}
			}
        }
    }
}

class mobileplugin_himickey_threadmail {}

class mobileplugin_himickey_threadmail_forum extends mobileplugin_himickey_threadmail {

    function post_message($params) {

        global $_G;
		$configs = $_G['cache']['plugin']['himickey_threadmail'];
        $param = $params["param"];

        if ($_GET["action"] == "reply" && $param[0] == "post_reply_succeed") {
			if(in_array($_G['fid'], unserialize($configs['fids']))) {
				$author = getuserbyuid($_G['forum_thread']['authorid']);
				if(in_array($author['groupid'], unserialize($configs['gids']))) {
					if(!empty($author['email']) && ($_G["uid"] != $author["uid"])) {
						$threadurl = $_G['siteurl'] . $param[1];
						$a = array(
							'{username}',
							'{subject}',
							'{postmsg}',
							'{threadurl}',
							'{bbname}',
							'{siteurl}',
						);
						$v = array(
							$_G['username'],
							dhtmlspecialchars($_G['forum_thread']['subject']),
							dhtmlspecialchars($_GET['message']),
							$threadurl,
							$_G['setting']['bbname'],
							$_G['siteurl'],
						);
						$mailtext = str_replace($a, $v, $configs['mail_text']);
						$mailtitle = str_replace($a, $v, $configs['$mail_title']);
						include_once libfile("function/mail");
						sendmail($author['email'], $mailtitle, $mailtext);
					}
				}
			}
        }
    }
}