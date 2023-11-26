<?php
/*
Author:·Ö.Ïí.°É
Website:www.fx8.cc
Qq:154-6069-14
*/
if (!defined('IN_DISCUZ')) {
    exit('Aecsse Denied');
}
class table_hjbox_wfl extends discuz_table{
    public function __construct() {
        $this->_table = 'hjbox_wfl';
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
    public function fetch_fl_all(){
         return DB::fetch_all('select * from %t where type = 1 order by sort asc,id asc',array($this->_table));
    }
    public function fetch_fl_show(){
         return DB::fetch_all('select * from %t where type = 1 and isshow = 1 order by sort asc,id asc',array($this->_table));
    }
    public function fetch_dbdh_all(){
         return DB::fetch_all('select * from %t where type = 2 and zid=0 order by sort asc,id asc',array($this->_table));
    }
    public function fetch_dbdh_four(){
         return DB::fetch_all('select * from %t where type = 2 and zid=0 order by sort asc,id asc limit 0,4',array($this->_table));
    }
    public function fetch_dbdh_zid($zid){
         return DB::fetch_all('select * from %t where type = 2 and zid=%d order by sort asc,id asc',array($this->_table,$zid));
    }
    public function fetch_fen_sid($sid){
         return DB::fetch_all('select * from %t where sid = %d order by status asc,id desc',array($this->_table,$sid));
    }

    public function fetch_azhu_all(){
         return DB::fetch_all('select * from %t where sid = 0 order by status asc,id desc limit 0,3',array($this->_table));
    }
    public function fetch_afen_sid($sid){
         return DB::fetch_all('select * from %t where sid = %d order by status asc,id desc limit 0,5',array($this->_table,$sid));
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