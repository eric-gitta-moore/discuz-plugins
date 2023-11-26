<?php
/*
 *源码哥出品，必属精品
 *源码哥分享吧www.ymg6.com
 *备用域名www.fx8.cc
 *更多精品资源请访问源码哥官方网站免费获取
 *源码哥99%的资源都是回复后直接免费下载的，不像某网站需要这个VIP，那个VIP
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