<?php
/*
Author:·Ö.Ïí.°É
Website:www.fx8.cc
Qq:154-6069-14
*/
if (!defined('IN_DISCUZ')) {
    exit('Aecsse Denied');
}
class table_hjbox_token extends discuz_table{
    public function __construct() {
        $this->_table = 'hjbox_token';
        $this->_pk = 'id';
        parent::__construct();
    }


	
    public function fetch_by_id($id){
         return DB::fetch_first('select * from %t where id=%d',array($this->_table,$id));
    }
    public function fetch_by_url($url){
         return DB::fetch_first('select * from %t where weburl=%s',array($this->_table,$url));
    }
    public function fetch_all(){
         return DB::fetch_all('select * from %t order by id desc',array($this->_table));
    }
    public function fetch_limit($startnum,$count){
         return DB::fetch_all('select * from %t order by id desc limit %d,%d',array($this->_table,$startnum,$count));
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