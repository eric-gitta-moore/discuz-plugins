<?php
/*
 *Դ �� ��   y     m   g  6     . c    o   m
 *������ҵ���/ģ��������� ����Դ  �� ��
 *����Դ��Դ�������ռ�,��������ѧϰ����������������ҵ��;����������24Сʱ��ɾ��!
 *����ַ�������Ȩ��,�뼰ʱ��֪����,���Ǽ���ɾ��!
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$sql = <<<EOF
DROP TABLE IF EXISTS `pre_nxx_authzan`;

EOF;

runquery($sql);
$finish = true;
?>