<?php

/*
 *Դ��磺www.ymg6.com
 *������ҵ���/ģ��������� ����Դ���
 *����Դ��Դ�������ռ�,��������ѧϰ����������������ҵ��;����������24Сʱ��ɾ��!
 *����ַ�������Ȩ��,�뼰ʱ��֪����,���Ǽ���ɾ��!
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
 
if(!$uid){
	header('Location: member.php?mod=logging&action=login');
	exit;
}
 
$in_zu	= L('in_zu');//	  	  ����
$in_da	= L('in_da');//		  ��
$in_dui	= L('in_dui');//	  ��ȷ|��|��
$in_cuo	= L('in_cuo');//	  ����|��|��|��
$in_img	= L('in_img');//	  ͼƬ
$in_note= L('in_note');//	  ����
$in_mao	= L('in_mao');//	  ��
$in_dun	= L('in_dun');//	  ��
$in_dian= L('in_dian');//	  ��

$_data  = str_replace('&#160;',' ',$_POST['data']);
$txtarr = explode("\n", trim($_data));
 
$cid  = DB::result_first("select `cid` from %t where pid='$pid'", array('tiny_exam3_paper'));
 
$nAdd      = 0;
$ExamType  = '';
$LineType  = '';
$insert_id = 0;

foreach($txtarr AS $v){
	$line = trim($v);
	if(empty($line)){
		$insert_id = 0;
		continue;
	}
	
	if(preg_match("/^(?:{$in_zu})\s*(?:\:|{$in_mao})\s*(.+)/", $line, $match))
	{
		$gid = DB::result_first("select `gid` from %t where `name`=%s AND uid='$uid'", array('tiny_exam3_group', $match[1]));
		if(!$gid) $gid = DB::insert('tiny_exam3_group', array('name'=>dhtmlspecialchars($match[1]), 'pid'=>$pid, 'uid'=>$uid), true);	
		$insert_id = $gid;
		$LineType = 'group';
	}
	elseif($insert_id==0)
	{
		$post = array(
			'uid'	 => $uid,
			'pid'	 => $pid,
			'cid'	 => $cid,
			'gid'	 => $gid,
			'subject'=> $line,//$_POST['numum'] ? preg_replace("/^[\(��\[]?\s*\d+\s*[\)��\]]?[\.����]\s*/", '' , $line) : $line,
			'addtime'=> $_SERVER['REQUEST_TIME'],
			'display'=> 1,
		);
		$insert_id = DB::insert('tiny_exam3_exam', $post, true);
		push_exam_to_form($insert_id);

		$ExamType = preg_match("/(_{4,})|(\(\s{4,}\))/", $line, $match) ? 'BLANK' : 'ASK';
		$nAdd++;
		$LineType = 'subject';
		
		$_dot_n   = "";
	}
	elseif(preg_match("/^{$in_da}\s*(?:\:|{$in_mao})\s*(.*)/", $line, $match))
	{
		$LineType   = 'result';
		$line = $match[1];
		
		if(preg_match("/^({$in_dui})$/", $line, $match))//�ж���
		{
			DB::update('tiny_exam3_exam', array('type' => 1, 'result' => 1), "eid='$insert_id' AND uid='$uid'"); 
		}
		elseif(preg_match("/^({$in_cuo})$/", $line, $match))//�ж���
		{
			DB::update('tiny_exam3_exam', array('type' => 1, 'result' => 2), "eid='$insert_id' AND uid='$uid'"); 
		}
		elseif(preg_match("/^([A-Z])$/", $line, $match))//��ѡ��
		{
			DB::update('tiny_exam3_exam', array('type' => 2, 'result' => $match[1]), "eid='$insert_id' AND uid='$uid'"); 
		}
		elseif(preg_match("/^([A-Z]{1,26})#?$/", $line, $match))//��ѡ��
		{
			DB::update('tiny_exam3_exam', array('type' => 3, 'result' => $match[1]), "eid='$insert_id' AND uid='$uid'"); 
		}
		elseif($ExamType=='BLANK')
		{
			DB::update('tiny_exam3_exam', array('type' => 4, 'data' => preg_replace("/\s+/","\n",$line)), "eid='$insert_id' AND uid='$uid'");
			$LineType = 'data';
		}
		elseif($ExamType=='ASK')
		{
			DB::update('tiny_exam3_exam', array('type' => 5, 'data' => $line), "eid='$insert_id' AND uid='$uid'");
			$LineType = 'data';
		}
	}
	elseif(preg_match("/^{$in_img}\s*(?:\:|{$in_mao})\s*(.+)/", $line, $match))
	{
		DB::update('tiny_exam3_exam', array('image' =>$match[1]), "eid='$insert_id' AND uid='$uid'"); 
		$LineType = 'image';
	}
	elseif(preg_match("/^{$in_note}\s*(?:\:|{$in_mao})\s*(.*)/", $line, $match))
	{
		DB::update('tiny_exam3_exam', array('note'  =>$match[1]), "eid='$insert_id' AND uid='$uid'"); 
		$LineType = 'note';
	}
	elseif($LineType == 'subject' && preg_match("/^[A-Z]\s*(?:\.|\:|$in_dun|$in_dian|$in_mao)\s*(.*)$/", $line, $match))//ѡ�����ѡ��
	{
		DB::query("update %t SET `data`=concat(`data`, %s) where eid='$insert_id' AND uid='$uid'", array('tiny_exam3_exam', $_dot_n . $match[1]));
		$_dot_n = "\n";
	}
	elseif($LineType == 'data' || $LineType == 'note' || $LineType == 'subject')
	{
		DB::query("update %t SET `$LineType`=concat(`$LineType`, %s) where eid='$insert_id' AND uid='$uid' AND `$LineType`<>''", array('tiny_exam3_exam', "\n".$line)) ||	
		DB::query("update %t SET `$LineType`=%s where eid='$insert_id' AND uid='$uid'", array('tiny_exam3_exam', $line));
	}
	elseif($LineType == 'group')
	{
		DB::query("update %t SET `content`=concat(`content`, %s) where gid='$insert_id' AND uid='$uid' AND `content`<>''", array('tiny_exam3_group', "\n".$line)) ||	
		DB::query("update %t SET `content`=%s where gid='$insert_id' AND uid='$uid'", array('tiny_exam3_group', $line));
	}

}

$in_submit_ok = 1;
 