<?php
/*
Author:·Ö.Ïí.°É
Website:www.fx8.cc
Qq:154-6069-14
*/
if (!defined('IN_DISCUZ')) {
    exit('Aecsse Denied');
}
class table_hjtp_tpjles extends discuz_table{
    public function __construct() {
        $this->_table = 'hjtp_tpjles';
        $this->_pk = 'id';
        parent::__construct();
    }

    public function fetch_today_uid_vid($uid,$vid,$timedate){
         return DB::fetch_all('select * from %t where uid=%d and vid=%d and timedate=%d order by id desc',array($this->_table,$uid,$vid,$timedate));
    }
    public function fetch_today_ip_vid($ip,$vid,$timedate){
         return DB::fetch_all('select * from %t where ips=%s and vid=%d and timedate=%d order by id desc',array($this->_table,$ip,$vid,$timedate));
    }

    public function fetch_zid_all($zid){
         return DB::fetch_all('select * from %t where zid=%d order by id desc',array($this->_table,$zid));
    }
    public function fetch_zid_limit($zid,$start,$count){
         return DB::fetch_all('select * from %t where zid=%d order by id desc limit %d,%d',array($this->_table,$zid,$start,$count));
    }

    public function fetch_by_zvudid($zid,$vid,$uid,$timedate){
         return DB::fetch_first('select * from %t where zid=%d and vid=%d and uid=%d and timedate=%d',array($this->_table,$zid,$vid,$uid,$timedate));
    }
	
    public function fetch_by_id($id){
         return DB::fetch_first('select * from %t where id=%d',array($this->_table,$id));
    }
    public function update_by_id($id,$data){
         return DB::update($this->_table,$data,'id='.$id);	 
    }

    public function delete_by_id($id){
         return DB::delete($this->_table,'id='.$id);
    }
    public function delete_by_zid($zid){
         return DB::delete($this->_table,'zid='.$zid);
    }
    public function delete_by_vid($vid){
         return DB::delete($this->_table,'vid='.$vid);
    }
    public function delete_by_openid($openid){
         return DB::delete($this->_table,'openid='.$openid);
    }
    public function delete_by_uid($uid){
         return DB::delete($this->_table,'uid='.$uid);
    }
    public function insert($data){
         return DB::insert($this->_table,$data);
    }



}
//www-fx8.cc
?>