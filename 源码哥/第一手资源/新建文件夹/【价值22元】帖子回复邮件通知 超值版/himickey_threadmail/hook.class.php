<?php
/*
 *Դ��磺www.ymg6.com
 *������ҵ���/ģ��������� ����Դ���
 *����Դ��Դ�������ռ�,��������ѧϰ����������������ҵ��;����������24Сʱ��ɾ��!
 *����ַ�������Ȩ��,�뼰ʱ��֪����,���Ǽ���ɾ��!
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