<?php
/*%*************************************************************************************%*/
//access id & access key ���
define('NOT_SET_OSS_ACCESS_ID', 'δ����OSS�����ACCESS ID');
define('NOT_SET_OSS_ACCESS_KEY', 'δ����OSS�����ACCESS KEY');
define('NOT_SET_OSS_ACCESS_ID_AND_ACCESS_KEY', 'û������ACCESS ID & ACCESS KEY');
define('OSS_ACCESS_ID_OR_ACCESS_KEY_EMPTY', 'ACCESS ID��ACCESS KEYΪ��');

/*%*************************************************************************************%*/
//OSS���԰��Լ��ļ����
define('OSS_LANG_FILE_NOT_EXIST', 'OSS���԰��ļ�������');
define('OSS_CONFIG_FILE_NOT_EXIST',OSS_API_PATH.DIRECTORY_SEPARATOR.'conf.inc.php������');
define('OSS_UTILS_FILE_NOT_EXIST',OSS_API_PATH.DIRECTORY_SEPARATOR.'util'.DIRECTORY_SEPARATOR.'utils.php������');
define('OSS_CURL_EXTENSION_MUST_BE_LOAD','ϵͳû�а�װCURL��չ');
define('OSS_NO_ANY_EXTENSIONS_LOADED','ϵͳû�а�װ�κ���չ,����ϵͳ����');


/*%*************************************************************************************%*/
//��־�ļ����
define('OSS_WRITE_LOG_TO_FILE_FAILED','��־д��ʧ��,������־�ļ��Ƿ���ڻ�����־�ļ���Ȩ��');
define('OSS_LOG_PATH_NOT_EXIST','��־·��������');

/*%**************************************************************************************%*/
//OSS bucket�������
define('OSS_OPTIONS_MUST_BE_ARRAY', '$option����Ϊ����');
define('OSS_GET_BUCKET_LIST_SUCCESS','��ȡBucket�б�ɹ�!');
define('OSS_GET_BUCKET_LIST_FAILED', '��ȡBucket�б�ʧ��!');
define('OSS_CREATE_BUCKET_SUCCESS', '����Bucket�ɹ�');
define('OSS_CREATE_BUCKET_FAILED', '����Bucketʧ��');
define('OSS_DELETE_BUCKET_SUCCESS', 'ɾ��Bucket�ɹ�');
define('OSS_DELETE_BUCKET_FAILED', 'ɾ��Bucketʧ��');
define('OSS_BUCKET_NAME_INVALID', 'δͨ��Bucket���ƹ���У��');
define('OSS_GET_BUCKET_ACL_SUCCESS','��ȡBucket ACL�ɹ�');
define('OSS_GET_BUCKET_ACL_FAILED','��ȡBucket ACLʧ��');
define('OSS_SET_BUCKET_ACL_SUCCESS','����Bucket ACL�ɹ�');
define('OSS_SET_BUCKET_ACL_FAILED','����Bucket ACLʧ��');
define('OSS_ACL_INVALID','ACL��������Χ,Ŀǰ������(private,public-read,public-read-write����Ȩ��)');
define('OSS_BUCKET_IS_NOT_ALLOWED_EMPTY', 'Bucket������Ϊ��');

/*%****************************************************************************************%*/
//OSS object�������
define('OSS_GET_OBJECT_LIST_SUCCESS','���OBJECT�б�ɹ�');
define('OSS_GET_OBJECT_LIST_FAILED','���OBJECT�б�ʧ��');
define('OSS_CREATE_OBJECT_DIR_SUCCESS','����OBJECTĿ¼�ɹ�');
define('OSS_CREATE_OBJECT_DIR_FAILED','����OBJECTĿ¼ʧ��');
define('OSS_DELETE_OBJECT_SUCCESS','ɾ��OBJECT�ɹ�');
define('OSS_DELETE_OBJECT_FAILED','ɾ��OBJECTʧ��');
define('OSS_UPLOAD_FILE_BY_CONTENT_SUCCESS','ͨ��Http Body�ϴ��ļ��ɹ�');
define('OSS_UPLOAD_FILE_BY_CONTENT_FAILED','ͨ��Http Body�ϴ��ļ�ʧ��');
define('OSS_GET_OBJECT_META_SUCCESS','���OBJECT META�ɹ�');
define('OSS_GET_OBJECT_META_FAILED','���OBJECT METAʧ��');
define('OSS_OBJECT_NAME_INVALID','δͨ��Object���ƹ���У��');
define('OSS_OBJECT_IS_NOT_ALLOWED_EMPTY','Object������Ϊ��');
define('OSS_INVALID_HTTP_BODY_CONTENT','Http Body�����ݷǷ�');
define('OSS_GET_OBJECT_SUCCESS','���Object�ɹ�');
define('OSS_GET_OBJECT_FAILED','���Objectʧ��');
define('OSS_OBJECT_EXIST','Object����');
define('OSS_OBJECT_NOT_EXIST','Object������');
define('OSS_NOT_SET_HTTP_CONTENT','Ϊ����Http Body');
define('OSS_INVALID_CONTENT_LENGTH','�Ƿ���Content-Lengthֵ');
define('OSS_CONTENT_LENGTH_MUST_MORE_THAN_ZERO','Content-Length�������0');
define('OSS_UPLOAD_FILE_NOT_EXIST','�ϴ��ļ�������');
define('OSS_COPY_OBJECT_SUCCESS','����Object�ɹ�');
define('OSS_COPY_OBJECT_FAILED', '����Objectʧ��');
define('OSS_FILE_NOT_EXIST','�ļ�������');
define('OSS_FILE_PATH_IS_NOT_ALLOWED_EMPTY', '�ϴ��ļ�·��Ϊ��');

/*%****************************************************************************************%*/
//OSS object Group�������
define('OSS_CREATE_OBJECT_GROUP_SUCCESS','����Object Group�ɹ�');
define('OSS_CREATE_OBJECT_GROUP_FAILED','����Object Groupʧ��');
define('OSS_GET_OBJECT_GROUP_SUCCESS','��ȡObject Group�ɹ�');
define('OSS_GET_OBJECT_GROUP_FAILED','��ȡObject Groupʧ��');
define('OSS_GET_OBJECT_GROUP_INDEX_SUCCESS','��ȡObject Group Index�ɹ�');
define('OSS_GET_OBJECT_GROUP_INDEX_FAILED','��ȡObject Group Indexʧ��');
define('OSS_GET_OBJECT_GROUP_META_SUCCESS','��ȡObject Group Group Meta�ɹ�');
define('OSS_GET_OBJECT_GROUP_META_FAILED','��ȡObject Group Group Metaʧ��');
define('OSS_DELETE_OBJECT_GROUP_SUCCESS','ɾ��Object Group Group�ɹ�');
define('OSS_DELETE_OBJECT_GROUP_FAILED','ɾ��Object Group Groupʧ��');
define('OSS_OBJECT_GROUP_IS_NOT_ALLOWED_EMPTY', 'Object Group������Ϊ��');
define('OSS_OBJECT_ARRAY_IS_EMPTY','����Object Group��Object������Ϊ��');
define('OSS_OBJECT_GROUP_TOO_MANY_OBJECT','ÿ��Object Group������1000��Object');

/*%****************************************************************************************%*/
//OSS Multi-Part Upload���
define('OSS_INITIATE_MULTI_PART_SUCCESS', '��ʼ��Multi-Part Upload�ɹ�');
define('OSS_INITIATE_MULTI_PART_FAILED', '��ʼ��Multi-Part Uploadʧ��');

/*%*******************************************************************************************%*/
//����
define('OSS_INVALID_OPTION_HEADERS', 'OPTIONS��������');





