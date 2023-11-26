<?php
/*
Author:·Ö.Ïí.°É
Website:www.fx8.cc
Qq:154-6069-14
*/
if (!defined('IN_DISCUZ')) {
    exit('Aecsse Denied');
}
class table_hjbox_replys extends discuz_table{
    public function __construct() {
        $this->_table = 'hjbox_replys';
        $this->_pk = 'id';
        parent::__construct();
    }


    public function fetch_img_all(){
         return DB::fetch_all('select * from %t where type = 1 order by add_time desc',array($this->_table));
    }
    public function fetch_text_all(){
         return DB::fetch_all('select * from %t where type = 2 order by add_time desc',array($this->_table));
    }

    public function fetch_img_search($keyword){
		$keyworda = '%'.$keyword.'%';
         return DB::fetch_all('select * from %t where state = 1 and type = 1 and keywords like %s order by sort desc,add_time desc limit 0,9',array($this->_table,$keyworda));
    }
    public function fetch_text_search($keyword){
		$keyworda = '%'.$keyword.'%';
         return DB::fetch_first('select * from %t where state = 1 and type = 2 and keywords like %s limit 0,1',array($this->_table,$keyworda));
    }

	
    public function fetch_by_id($id){
         return DB::fetch_first('select * from %t where id=%d',array($this->_table,$id));
    }
    public function fetch_by_tel($tel){
         return DB::fetch_first('select * from %t where telphone=%s',array($this->_table,$tel));
    }
    public function fetch_by_openid($openid){
         return DB::fetch_first('select * from %t where openid=%s',array($this->_table,$openid));
    }
    public function fetch_by_tel_pass($tel,$pass){
         return DB::fetch_first('select * from %t where telphone=%s and password=%s',array($this->_table,$tel,$pass));
    }
    public function update_by_id($id,$data){
         return DB::update($this->_table,$data,'id='.$id);	 
    }

    public function delete_by_id($id){
         return DB::delete($this->_table,'id='.$id);
    }
    public function insert($data){
         return DB::insert($this->_table,$data,true);
    }



}
//www-fx8.cc
?>