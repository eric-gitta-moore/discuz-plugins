<?php
/*
 *Դ����Ʒ��������Ʒ
 *Դ�������www.ymg6.com
 *��������www.fx8.cc
 *���ྫƷ��Դ�����Դ���ٷ���վ��ѻ�ȡ
 *Դ���99%����Դ���ǻظ���ֱ��������صģ�����ĳ��վ��Ҫ���VIP���Ǹ�VIP
 */
if (!defined('IN_DISCUZ'))
{
    exit('Access Denied');
}

class plugin_tshuz_imgalt
{
    public function viewthread_postbottom_output()
    {
        global $postlist,$_G;;
        $config = $_G['cache']['plugin']['tshuz_imgalt'];
        if(!$config['kaiguan']) return array();
        foreach ($postlist as $id => &$post)
        {
            $post['message'] = $this->wailian_replace($post['message']);
        }
        unset($post);
        return array();
    }

    function wailian_replace($content)
    {
        $preg_searchs = "/\<img /ie";
        $preg_replaces = '$this->iframe_url(\'\\1\')';   
        $content = preg_replace($preg_searchs, $preg_replaces, $content);
        return $content;
    }

    function iframe_url($url)
    {       
        global $_G,$postlist,$post;
        $wlist = $_G['cache']['plugin']['tshuz_imgalt']['baimingdan'];
        $onoff = $_G['cache']['plugin']['tshuz_imgalt']['onoff'];
		$subject = $_G['forum_thread']['subject'];
		$sitename = $_G['setting']['sitename'];
		$imgalt = $attach['imgalt'];
        $wlist=explode("\r\n", $wlist);        
        require_once('rootdomain.class.php');
        $rootDomain=RootDomain::instace();  
        $rootDomain->setUrl($_G['siteurl']);
        $currentdomain=$rootDomain->getDomain();
        $wlist[]=$currentdomain;          
        $domain=  explode('/', $url);
        $domain=$domain[0];
		$rootDomain->setUrl($url);
		$topdomain=$rootDomain->getDomain();  
        if(in_array($domain, $wlist)||in_array($topdomain, $wlist))
        {
            return "<img alt=\"$subject,$sitename\"";
        }
        
    }
    
}

class plugin_tshuz_imgalt_group extends plugin_tshuz_imgalt{}
class plugin_tshuz_imgalt_forum extends plugin_tshuz_imgalt{}

?>