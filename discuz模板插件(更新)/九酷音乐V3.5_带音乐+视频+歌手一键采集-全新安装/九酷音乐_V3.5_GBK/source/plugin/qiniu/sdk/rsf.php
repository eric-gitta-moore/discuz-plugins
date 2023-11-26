<?php

require_once("http.php");

define('Qiniu_RSF_EOF', 'EOF');

/**
 * 1. �״����� marker = ""
 * 2. ���� err ֵ��Σ���Ӧ���ȿ� items �Ƿ�������
 * 3. �������û�и������ݣ�err ���� EOF��markerOut ���� ""������ͨ�����������ж��Ƿ������
 */
function Qiniu_RSF_ListPrefix(
	$self, $bucket, $prefix = '', $marker = '', $limit = 0) // => ($items, $markerOut, $err)
{
	global $QINIU_RSF_HOST;

	$query = array('bucket' => $bucket);
	if (!empty($prefix)) {
		$query['prefix'] = $prefix;
	}
	if (!empty($marker)) {
		$query['marker'] = $marker;
	}
	if (!empty($limit)) {
		$query['limit'] = $limit;
	}

	$url =  $QINIU_RSF_HOST . '/list?' . http_build_query($query);
	list($ret, $err) = Qiniu_Client_Call($self, $url);
	if ($err !== null) {
		return array(null, '', $err);
	}

	$items = $ret['items'];
	if (empty($ret['marker'])) {
		$markerOut = '';
		$err = Qiniu_RSF_EOF;
	} else {
		$markerOut = $ret['marker'];
	}
	return array($items, $markerOut, $err);
}

