<?php
/****
*
*   @QQ群626530746 By:NVBING5
*	以下代码请勿随意修改、避免出错！
*
****/
if(!defined('IN_DISCUZ')){
    exit('Access Denied');
}
class mobileplugin_zhikai_mobiad{
	
	//common
  public function global_header_mobile(){
      return $this->_adshow('telheader');
  }
  public function global_footer_mobile(){
      return $this->_adshow('telfooter');
  }
  public function global_jujiao_top_mobile(){
      return $this->_adshow('jujiao');
  }
  public function global_jujiao_bottom_mobile(){
      return $this->_adshow('jujiaod');
  }
  public function global_geren_top_mobile(){
      return $this->_adshow('geren');
  }
  public function global_gerenzj_top_mobile(){
      return $this->_adshow('gerenzj');
  }
  public function global_geren_bottom_mobile(){
      return $this->_adshow('gerendb');
  }
  public function global_kongjian_mobile(){
      return $this->_adshow('kongjian');
  }
  public function global_qunzu_top_mobile(){
      return $this->_adshow('qunzu');
  }
  public function global_qunzu_bottom_mobile(){
      return $this->_adshow('qunzudb');
  }
  public function global_qzlb_mobile(){
      return $this->_adshow('qunzulb');
  }
  
  protected function _adshow($name,$arrf=false,$flag=''){
      global $_G;
      $open = $_G['cache']['plugin']['zhikai_mobiad']['navkg'];
      if(!$open) return '';
      $nvbvip = unserialize($_G['cache']['plugin']['zhikai_mobiad']['navyh']);
      if(in_array($_G['groupid'],$nvbvip)){
          return '';
      }
      if($arrf){
          if($flag=='forumdisplay')
              $p=$_G['setting']['mobile']['mobiletopicperpage'];
          else
              $p=$_G['setting']['mobile']['mobilepostperpage'];
          $re=array();
          for($i = 0;$i <$p;$i++) {
              $re[]=adshow('zhikai_mobiad:'.$name.'//'.$i);;
          }
            return $re;
      }else{
            return adshow('zhikai_mobiad:'.$name);
         }
  }

}
//forum
class mobileplugin_zhikai_mobiad_forum extends mobileplugin_zhikai_mobiad{
    public function index_top_mobile(){
        return $this->_adshow('forumheader');
    }
    public function index_middle_mobile(){
        return $this->_adshow('forumfooter');
    }
	
	public function index_bkwdgz_mobile(){
        return $this->_adshow('bkwdgz');
    }
	
	public function guide_top_mobile(){
        return $this->_adshow('guidetop');
    }
	
	public function guide_list_mobile(){
        return $this->_adshow('guidelist',true,'forumdisplay');
    }
	
	public function misc_kuaifa_top_mobile(){
        return $this->_adshow('kuaifa');
    }
	
	public function misc_kuaifa_bottom_mobile(){
        return $this->_adshow('kuaifad');
    }
	
    public function forumdisplay_top_mobile(){
        return $this->_adshow('forumdisplayheader');
    }
    public function forumdisplay_bottom_mobile(){
        return $this->_adshow('forumdisplayfooter');
    }
    
    public function viewthread_top_mobile(){
        return $this->_adshow('viewthreadheader');
    }
    public function viewthread_bottom_mobile(){
        return $this->_adshow('viewthreadfooter');
    }
    public function forumdisplay_thread_mobile(){
        return $this->_adshow('forumdisplayarr',true,'forumdisplay');
        
    }
    public function viewthread_posttop_mobile(){
		  return $this->_adshow('viewthreadtoparr',true);
    }
    
    public function viewthread_postbottom_mobile(){
        return $this->_adshow('viewthreadbottomarr',true);
    }

    public function viewthread_fastpost_button_mobile(){
        return $this->_adshow('viewthreadfastpost');
    }
	
    public function post_bottom_mobile(){
        return $this->_adshow('postfooter');
    }
}
//member
class mobileplugin_zhikai_mobiad_member extends mobileplugin_zhikai_mobiad{
    public function logging_bottom_mobile(){
        return $this->_adshow('loginfooter');
    }
}

?>