<?php

/*
 *Դ��磺www.ymg6.com
 *������ҵ���/ģ��������� ����Դ���
 *����Դ��Դ�������ռ�,��������ѧϰ����������������ҵ��;����������24Сʱ��ɾ��!
 *����ַ�������Ȩ��,�뼰ʱ��֪����,���Ǽ���ɾ��!
 */
return array(
	//'TYPE' => array(1 => '�ж���',2 => '��ѡ��',3 => '��ѡ��',4 => '�����',5 => '�ʴ���'),
 
	'right'  => '��ȷ',
	'wrong'  => '����',
	
	'push_to_form_subject' => "$_G[username] �� ".date('m-d H:i',$_SERVER['REQUEST_TIME'])." �μ��� $paper[title] ����, ȡ���� $paper[score] �ֵĳɼ�",
	'push_to_form_message' => "[url=home.php?mod=space&uid=$_G[uid] ][b]$_G[username] [/b][/url] �� [b] ".date('m-d H:i',$_SERVER['REQUEST_TIME'])." [/b] �μ��� [url=plugin.php?id=exam&paper=$paper[pid] ][b]$paper[title] [/b][/url] ����, ȡ���� [b]$paper[score] [/b] �ֵĳɼ�\n�Ծ�: $paper[title] ��\n�ܷ�: $paper[total] ��\n����: $paper[pass]  ��\n����ʱ��: $paper[minute] ����",

	
	'in_zu'		=> '����|���',
	'in_da'		=> '��ȷ��|�ο���|��',
	'in_dui'	=> '��ȷ|��|��',	
	'in_cuo'	=> '����|��|��|��',
	'in_img'	=> 'ͼƬ',
	'in_note'	=> '����',
	'in_mao'	=> '��',
	'in_dun'	=> '��',
	'in_dian'	=> '��',
	);
?>