<?php
/*
Author:·Ö.Ïí.°É
Website:www.fx8.cc
Qq:154-6069-14
*/
if (!defined('IN_DISCUZ')) {
    exit('Aecsse Denied');
}
class table_hjbox_users extends discuz_table{
    public function __construct() {
        $this->_table = 'hjbox_users';
        $this->_pk = 'id';
        parent::__construct();
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
    public function fetch_gz_all(){
         return DB::fetch_all('select * from %t where is_gz = 1 order by gztime desc',array($this->_table));
    }
    public function fetch_gz_limit($startnum,$count){
         return DB::fetch_all('select * from %t where is_gz = 1 order by gztime desc limit %d,%d',array($this->_table,$startnum,$count));
    }
    public function fetch_qxgz_all(){
         return DB::fetch_all('select * from %t where is_gz = 0 order by gztime desc',array($this->_table));
    }
    public function fetch_qxgz_limit($startnum,$count){
         return DB::fetch_all('select * from %t where is_gz = 0 order by gztime desc limit %d,%d',array($this->_table,$startnum,$count));
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