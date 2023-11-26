<?php
/*
 *源 码  哥 y   m    g  6  .  c     o   m
 *更多商业插件/模版免费下载 就在源 码  哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */


if (!defined('IN_DISCUZ'))
{
    exit('Access Denied');
}

class plugin_nxx_autozan
{
    //TODO - Insert your code here
    protected $setting;

    public function __construct()
    {
        global $_G;
        loadcache('plugin');
        $this->setting = $_G['cache']['plugin']['nxx_autozan'];
        $this->setting['forums'] = dunserialize($this->setting['forums']);
        $this->setting['userlist'] = explode("\n", $this->setting['userlist']);
        $this->setting['time'] = explode("\n", $this->setting['time']);
        $this->setting['threads'] = explode("\n", $this->setting['thread']);

    }


    protected function dianzan($tid)
    {
        $userlist = $this->setting['userlist'];
        //首先把uid空循环掉
        foreach ($userlist as $key => $value)
        {
            if (empty($value))
            {
                unset($userlist[$key]);
            }
        }
        //首先获得用户
        $uid = array_rand($userlist);
        $user = $userlist[$uid];
        //查看是否点赞
        $num = DB::result_first('SELECT COUNT(*) from %t WHERE `tid`=%d AND `recommenduid`=%d', array('forum_memberrecommend', $tid, $user));
        if ($num >= 1)
        {
            return false;
        }
        //点赞
        C::t('forum_thread')->increase($tid, array('recommend_add' => '+1','views'=>'+'.$this->setting['view']));
        DB::insert('forum_memberrecommend', array('tid' => $tid, 'recommenduid' => $user, 'dateline' => time()));

        return true;
    }

    protected function getOhterThread()
    {
        if(!$this->setting['thread']){
            return true;
        }
        $thread = DB::fetch_all("select `tid` from  %t WHERE tid not in (".implode(',',$this->setting['threads']).")",array("forum_thread"));
        foreach ($thread as $key=>$value){
            $this->insertThread($value['tid']);
        }
        return true;
    }

    protected function getThread()
    {
        if(!$this->setting['forums']){
            return true;
        }
        global $_G;
        loadcache("nxx_autozan");
        $starttime = time()-$this->setting['starttime']*60;
        if($_G['cache']['nxx_autozan']){
            $thread = DB::fetch_all("select `tid` from  %t WHERE  tid>%s AND dateline<%s AND fid  in (".implode(',',$this->setting['forums']).")",array("forum_thread",$_G['cache']['nxx_autozan'],$starttime));
            foreach ($thread as $key=>$value){
                $this->insertThread($value['tid']);
            }
        }
        savecache("nxx_autozan",DB::result_first("SELECT MAX(tid) as maxtid FROM ".DB::table('forum_thread')." WHERE dateline<".$starttime));
    }

    protected function insertThread($tid)
    {
        $info['tid'] =$tid;
        $info['time'] = time() + $this->setting['time'][0]*60;
        $info['zannum'] = 0;
        DB::insert('nxx_authzan', $info, false, true);
    }

    public function common()
    {
        //30秒检查一次任务
        if(!discuz_process::islocked('nxx_aotuzan',30)){
            $this->getOhterThread();
            $this->getThread();
        }
        $list = DB::fetch_all("SELECT * from %t WHERE `time`<%s AND zannum!=999999",array("nxx_authzan",time()));
        foreach ($list as $key=>$info){
            $cishu = intval($info['zannum']);
            if(!empty($this->setting['time'][$cishu])){
                $info['time'] = time() + $this->setting['time'][$cishu]*60;
                $info['zannum'] = $info['zannum'] + 1;
            }else{
                $info['time'] = time() ;
                $info['zannum'] = '999999';
            }
            $this->dianzan($info['tid']);
            DB::insert('nxx_authzan', $info, false, true);
        }
    }
}


?>