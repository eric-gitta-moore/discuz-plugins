<?php
if (! defined ( 'BCS_API_PATH' )) {
	define ( 'BCS_API_PATH', dirname ( __FILE__ ) );
}
require_once (BCS_API_PATH . '/conf.inc.php');
require_once (BCS_API_PATH . '/requestcore.class.php');
require_once (BCS_API_PATH . '/mimetypes.class.php');
/**
 * Default BCS Exception.
 */
class BCS_Exception extends Exception {
}
/**
 * BCS API
 */
class BaiduBCS {
	/*%******************************************************************************************%*/
	// CLASS CONSTANTS
	//�ٶ��ƴ洢Ĭ����������
	const DEFAULT_URL = 'bcs.duapp.com';
	//SDK �汾
	const API_VERSION = '2012-4-17-1.0.1.6';
	const ACL = 'acl';
	const BUCKET = 'bucket';
	const OBJECT = 'object';
	const HEADERS = 'headers';
	const METHOD = 'method';
	const AK = 'ak';
	const SK = 'sk';
	const QUERY_STRING = "query_string";
	const IMPORT_BCS_LOG_METHOD = "import_bs_log_method";
	const IMPORT_BCS_PRE_FILTER = "import_bs_pre_filter";
	const IMPORT_BCS_POST_FILTER = "import_bs_post_filter";
	/**********************************************************
	 ******************* Policy Constants**********************
	 **********************************************************/
	const STATEMETS = 'statements';
	//Action �û�����
	//'*'��������action 
	const BCS_SDK_ACL_ACTION_ALL = '*';
	//��bucket��ص�action
	const BCS_SDK_ACL_ACTION_LIST_OBJECT = 'list_object';
	const BCS_SDK_ACL_ACTION_PUT_BUCKET_POLICY = 'put_bucket_policy';
	const BCS_SDK_ACL_ACTION_GET_BUCKET_POLICY = 'get_bucket_policy';
	const BCS_SDK_ACL_ACTION_DELETE_BUCKET = 'delete_bucket';
	//��object��ص�action
	const BCS_SDK_ACL_ACTION_GET_OBJECT = 'get_object';
	const BCS_SDK_ACL_ACTION_PUT_OBJECT = 'put_object';
	const BCS_SDK_ACL_ACTION_DELETE_OBJECT = 'delete_object';
	const BCS_SDK_ACL_ACTION_PUT_OBJECT_POLICY = 'put_object_policy';
	const BCS_SDK_ACL_ACTION_GET_OBJECT_POLICY = 'get_object_policy';
	static $ACL_ACTIONS = array (
			self::BCS_SDK_ACL_ACTION_ALL, 
			self::BCS_SDK_ACL_ACTION_LIST_OBJECT, 
			self::BCS_SDK_ACL_ACTION_PUT_BUCKET_POLICY, 
			self::BCS_SDK_ACL_ACTION_GET_BUCKET_POLICY, 
			self::BCS_SDK_ACL_ACTION_DELETE_BUCKET, 
			self::BCS_SDK_ACL_ACTION_GET_OBJECT, 
			self::BCS_SDK_ACL_ACTION_PUT_OBJECT, 
			self::BCS_SDK_ACL_ACTION_DELETE_OBJECT, 
			self::BCS_SDK_ACL_ACTION_PUT_OBJECT_POLICY, 
			self::BCS_SDK_ACL_ACTION_GET_OBJECT_POLICY );
	//EFFECT:
	const BCS_SDK_ACL_EFFECT_ALLOW = "allow";
	const BCS_SDK_ACL_EFFECT_DENY = "deny";
	static $ACL_EFFECTS = array (
			self::BCS_SDK_ACL_EFFECT_ALLOW, 
			self::BCS_SDK_ACL_EFFECT_DENY );
	//ACL_TYPE:
	//������Ȩ��
	const BCS_SDK_ACL_TYPE_PUBLIC_READ = "public-read";
	//����дȨ�ޣ����߱�ɾ��Ȩ�ޣ�
	const BCS_SDK_ACL_TYPE_PUBLIC_WRITE = "public-write";
	//������дȨ�ޣ����߱�ɾ��Ȩ�ޣ�
	const BCS_SDK_ACL_TYPE_PUBLIC_READ_WRITE = "public-read-write";
	//��������Ȩ��
	const BCS_SDK_ACL_TYPE_PUBLIC_CONTROL = "public-control";
	//˽��Ȩ�ޣ���bucket�����߾�������Ȩ��
	const BCS_SDK_ACL_TYPE_PRIVATE = "private";
	//SDK�п��Ŵ�������acl_tpe
	static $ACL_TYPES = array (
			self::BCS_SDK_ACL_TYPE_PUBLIC_READ, 
			self::BCS_SDK_ACL_TYPE_PUBLIC_WRITE, 
			self::BCS_SDK_ACL_TYPE_PUBLIC_READ_WRITE, 
			self::BCS_SDK_ACL_TYPE_PUBLIC_CONTROL, 
			self::BCS_SDK_ACL_TYPE_PRIVATE );
	/*%******************************************************************************************%*/
	// PROPERTIES
	//�Ƿ�ʹ��ssl
	protected $use_ssl = false;
	//��Կ account key
	private $ak;
	//˽Կ secret key
	private $sk;
	//�ƴ洢server��ַ
	private $hostname;

	/**
	 * ���캯��
	 * @param string $ak  �ƴ洢��Կ
	 * @param string $sk  �ƴ洢˽Կ
	 * @param string $hostname �ƴ洢Api���ʵ�ַ
	 * @throws BCS_Exception
	 */
	public function __construct($ak = NULL, $sk = NULL, $hostname = NULL) {
		//valid ak & sk
		if (! $ak && ! defined ( 'BCS_AK' ) && false === getenv ( 'HTTP_BAE_ENV_AK' )) {
			throw new BCS_Exception ( 'No account key was passed into the constructor.' );
		}
		if (! $sk && ! defined ( 'BCS_SK' ) && false === getenv ( 'HTTP_BAE_ENV_SK' )) {
			throw new BCS_Exception ( 'No secret key was passed into the constructor.' );
		}
		if ($ak && $sk) {
			$this->ak = $ak;
			$this->sk = $sk;
		} elseif (defined ( 'BCS_AK' ) && defined ( 'BCS_SK' ) && strlen ( BCS_AK ) > 0 && strlen ( BCS_SK ) > 0) {
			$this->ak = BCS_AK;
			$this->sk = BCS_SK;
		} elseif (false !== getenv ( 'HTTP_BAE_ENV_AK' ) && false !== getenv ( 'HTTP_BAE_ENV_SK' )) {
			$this->ak = getenv ( 'HTTP_BAE_ENV_AK' );
			$this->sk = getenv ( 'HTTP_BAE_ENV_SK' );
		} else {
			throw new BCS_Exception ( 'Construct can not get ak &sk pair, please check!' );
		}
		//valid $hostname 
		if (NULL !== $hostname) {
			$this->hostname = $hostname;
		} elseif (false !== getenv ( 'HTTP_BAE_ENV_ADDR_BCS' )) {
			$this->hostname = getenv ( 'HTTP_BAE_ENV_ADDR_BCS' );
		} else {
			$this->hostname = self::DEFAULT_URL;
		}
	}

	/**
	 * ����Ϣ����Baidu BCS.
	 * @param array $opt
	 * @return BCS_ResponseCore
	 */
	private function authenticate($opt) {
		//set common param into opt
		$opt [self::AK] = $this->ak;
		$opt [self::SK] = $this->sk;
		
		// Validate the S3 bucket name, only list_bucket didnot need validate_bucket
		if (! ('/' == $opt [self::OBJECT] && '' == $opt [self::BUCKET] && 'GET' == $opt [self::METHOD] && ! isset ( $opt [self::QUERY_STRING] [self::ACL] )) && ! self::validate_bucket ( $opt [self::BUCKET] )) {
			throw new BCS_Exception ( $opt [self::BUCKET] . 'is not valid, please check!' );
		}
		//Validate object
		if (isset ( $opt [self::OBJECT] ) && ! self::validate_object ( $opt [self::OBJECT] )) {
			throw new BCS_Exception ( "Invalid object param[" . $opt [self::OBJECT] . "], please check.", - 1 );
		}
		//construct url
		$url = $this->format_url ( $opt );
		if ($url === false) {
			throw new BCS_Exception ( 'Can not format url, please check your param!', - 1 );
		}
		$opt ['url'] = $url;
		$this->log ( "[method:" . $opt [self::METHOD] . "][url:$url]", $opt );
		//build request
		$request = new BCS_RequestCore ( $opt ['url'] );
		$headers = array (
				'Content-Type' => 'application/x-www-form-urlencoded' );
		
		$request->set_method ( $opt [self::METHOD] );
		//Write get_object content to fileWriteTo
		if (isset ( $opt ['fileWriteTo'] )) {
			$request->set_write_file ( $opt ['fileWriteTo'] );
		}
		// Merge the HTTP headers
		if (isset ( $opt [self::HEADERS] )) {
			$headers = array_merge ( $headers, $opt [self::HEADERS] );
		}
		// Set content to Http-Body
		if (isset ( $opt ['content'] )) {
			$request->set_body ( $opt ['content'] );
		}
		// Upload file
		if (isset ( $opt ['fileUpload'] )) {
			if (! file_exists ( $opt ['fileUpload'] )) {
				throw new BCS_Exception ( 'File[' . $opt ['fileUpload'] . '] not found!', - 1 );
			}
			$request->set_read_file ( $opt ['fileUpload'] );
			// Determine the length to read from the file
			$length = $request->read_stream_size; // The file size by default
			$file_size = $length;
			if (isset ( $opt ["length"] )) {
				if ($opt ["length"] > $file_size) {
					throw new BCS_Exception ( "Input opt[length] invalid! It can not bigger than file-size", - 1 );
				}
				$length = $opt ['length'];
			}
			if (isset ( $opt ['seekTo'] ) && ! isset ( $opt ["length"] )) {
				// Read from seekTo until EOF by default, when set seekTo but not set $opt["length"]
				$length -= ( integer ) $opt ['seekTo'];
			}
			$request->set_read_stream_size ( $length );
			// Attempt to guess the correct mime-type
			if ($headers ['Content-Type'] === 'application/x-www-form-urlencoded') {
				$extension = explode ( '.', $opt ['fileUpload'] );
				$extension = array_pop ( $extension );
				$mime_type = BCS_MimeTypes::get_mimetype ( $extension );
				$headers ['Content-Type'] = $mime_type;
			}
			$headers ['Content-MD5'] = '';
		}
		// Handle streaming file offsets
		if (isset ( $opt ['seekTo'] )) {
			// Pass the seek position to BCS_RequestCore
			$request->set_seek_position ( ( integer ) $opt ['seekTo'] );
		}
		// Add headers to request and compute the string to sign
		foreach ( $headers as $header_key => $header_value ) {
			// Strip linebreaks from header values as they're illegal and can allow for security issues
			$header_value = str_replace ( array (
					"\r", 
					"\n" ), '', $header_value );
			// Add the header if it has a value
			if ($header_value !== '') {
				$request->add_header ( $header_key, $header_value );
			}
		}
		// Set the curl options.
		if (isset ( $opt ['curlopts'] ) && count ( $opt ['curlopts'] )) {
			$request->set_curlopts ( $opt ['curlopts'] );
		}
		$request->send_request ();
		return new BCS_ResponseCore ( $request->get_response_header (), $request->get_response_body (), $request->get_response_code () );
	}

	/**
	 * ��ȡ��ǰ��Կ��ӵ���ߵ�bucket�б�
	 * @param array $opt (Optional) 
	 * BaiduBCS::IMPORT_BCS_LOG_METHOD - String - Optional: ֧���û�������־������������������ function f($log)
	 * @throws BCS_Exception
	 * @return BCS_ResponseCore
	 */
	public function list_bucket($opt = array()) {
		$this->assertParameterArray ( $opt );
		$opt [self::BUCKET] = '';
		$opt [self::METHOD] = 'GET';
		$opt [self::OBJECT] = '/';
		$response = $this->authenticate ( $opt );
		$this->log ( $response->isOK () ? "List bucket success!" : "List bucket failed! Response: [" . $response->body . "]", $opt );
		return $response;
	}

	/**
	 * ���� bucket
	 * @param string $bucket (Required) bucket����
	 * @param string $acl (Optional)    bucketȨ�����ã���Ϊnull��ʹ��server�����Ĭ��Ȩ��
	 * @param array $opt (Optional) 
	 * @throws BCS_Exception
	 * @return BCS_ResponseCore
	 */
	public function create_bucket($bucket, $acl = NULL, $opt = array()) {
		$this->assertParameterArray ( $opt );
		$opt [self::BUCKET] = $bucket;
		$opt [self::METHOD] = 'PUT';
		$opt [self::OBJECT] = '/';
		if (NULL !== $acl) {
			if (! in_array ( $acl, self::$ACL_TYPES )) {
				throw new BCS_Exception ( "Invalid acl_type[" . $acl . "], please check!", - 1 );
			}
			self::set_header_into_opt ( "x-bs-acl", $acl, $opt );
		}
		$response = $this->authenticate ( $opt );
		$this->log ( $response->isOK () ? "Create bucket success!" : "Create bucket failed! Response: [" . $response->body . "]", $opt );
		return $response;
	}

	/**
	 * ɾ��bucket
	 * @param string $bucket (Required)
	 * @param array $opt (Optional)
	 * @return boolean|BCS_ResponseCore
	 */
	public function delete_bucket($bucket, $opt = array()) {
		$this->assertParameterArray ( $opt );
		$opt [self::BUCKET] = $bucket;
		$opt [self::METHOD] = 'DELETE';
		$opt [self::OBJECT] = '/';
		$response = $this->authenticate ( $opt );
		$this->log ( $response->isOK () ? "Delete bucket success!" : "Delete bucket failed! Response: [" . $response->body . "]", $opt );
		return $response;
	}

	/**
	 * ����bucket��acl��������ģʽ��
	 * (1).������ϸjson��ʽ��acl��
	 * a. $acl Ϊjson��array
	 * b. $acl Ϊjson��string
	 * (2).ͨ��acl_type�ֶν�������
	 * a. $acl ΪBaiduBCS::$ACL_TYPES�е��ֶ�
	 * @param string $bucket (Required)
	 * @param string $acl (Required)
	 * @param array $opt (Optional)
	 * @return boolean|BCS_ResponseCore
	 */
	public function set_bucket_acl($bucket, $acl, $opt = array()) {
		$this->assertParameterArray ( $opt );
		$result = $this->analyze_user_acl ( $acl );
		$opt = array_merge ( $opt, $result );
		$opt [self::BUCKET] = $bucket;
		$opt [self::METHOD] = 'PUT';
		$opt [self::OBJECT] = '/';
		$opt [self::QUERY_STRING] = array (
				self::ACL => 1 );
		$response = $this->authenticate ( $opt );
		$this->log ( $response->isOK () ? "Set bucket acl success!" : "Set bucket acl failed! Response: [" . $response->body . "]", $opt );
		return $response;
	}

	/**
	 * ��ȡbucket��acl
	 * @param string $bucket (Required)
	 * @param array $opt (Optional)
	 * @return BCS_ResponseCore
	 */
	public function get_bucket_acl($bucket, $opt = array()) {
		$this->assertParameterArray ( $opt );
		$opt [self::BUCKET] = $bucket;
		$opt [self::METHOD] = 'GET';
		$opt [self::OBJECT] = '/';
		$opt [self::QUERY_STRING] = array (
				self::ACL => 1 );
		$response = $this->authenticate ( $opt );
		$this->log ( $response->isOK () ? "Get bucket acl success!" : "Get bucket acl failed! Response: [" . $response->body . "]", $opt );
		return $response;
	}

	/**
	 * ��ȡbucket��object�б�
	 * @param string $bucket (Required)
	 * @param array $opt (Optional)
	 * start : ��Ҫ���ڷ�ҳ���ܣ��÷�ͬmysql��start���÷�
	 * limit : ��Ҫ���ڷ�ҳ���ܣ��÷�ͬmysql��limit���÷�
	 * prefix: ֻ������prefixΪǰ׺��object���˴�prefix������'/'��ͷ
	 * @throws BCS_Exception
	 * @return BCS_ResponseCore
	 */
	public function list_object($bucket, $opt = array()) {
		$this->assertParameterArray ( $opt );
		$opt [self::BUCKET] = $bucket;
		if (empty ( $opt [self::BUCKET] )) {
			throw new BCS_Exception ( "Bucket should not be empty, please check", - 1 );
		}
		$opt [self::METHOD] = 'GET';
		$opt [self::OBJECT] = '/';
		$opt [self::QUERY_STRING] = array ();
		if (isset ( $opt ['start'] ) && is_int ( $opt ['start'] )) {
			$opt [self::QUERY_STRING] ['start'] = $opt ['start'];
		}
		if (isset ( $opt ['limit'] ) && is_int ( $opt ['limit'] )) {
			$opt [self::QUERY_STRING] ['limit'] = $opt ['limit'];
		}
		if (isset ( $opt ['prefix'] )) {
			$opt [self::QUERY_STRING] ['prefix'] = rawurlencode ( $opt ['prefix'] );
		}
		$response = $this->authenticate ( $opt );
		$this->log ( $response->isOK () ? "List object success!" : "Lit object failed! Response: [" . $response->body . "]", $opt );
		return $response;
	}

	/**
	 * ��Ŀ¼��ʽ��ȡbucket��object�б�
	 * @param string $bucket (Required)
	 * @param $dir (Required)
	 * Ŀ¼������ʽΪ������'/'��ͷ�ͽ�β��Ĭ��Ϊ'/'
	 * @param string $list_model (Required)
	 * Ŀ¼չ����ʽ��ֵ����Ϊ0,1,2��Ĭ��Ϊ2�����¶Ը���ֵ�Ĺ��ܽ��н��ܣ�
	 * 0->ֻ����object�б���������Ŀ¼�б�
	 * 1->ֻ������Ŀ¼�б�������object�б� 
	 * 2->ͬʱ������Ŀ¼�б��object�б�
	 * @param array $opt (Optional)
	 * start : ��Ҫ���ڷ�ҳ���ܣ��÷�ͬmysql��start���÷�
	 * limit : ��Ҫ���ڷ�ҳ���ܣ��÷�ͬmysql��limit���÷�
	 * @throws BCS_Exception
	 * @return BCS_ResponseCore
	 */
	public function list_object_by_dir($bucket, $dir = '/', $list_model = 2, $opt = array()) {
		$this->assertParameterArray ( $opt );
		$opt [self::BUCKET] = $bucket;
		if (empty ( $opt [self::BUCKET] )) {
			throw new BCS_Exception ( "Bucket should not be empty, please check", - 1 );
		}
		$opt [self::METHOD] = 'GET';
		$opt [self::OBJECT] = '/';
		$opt [self::QUERY_STRING] = array ();
		if (isset ( $opt ['start'] ) && is_int ( $opt ['start'] )) {
			$opt [self::QUERY_STRING] ['start'] = $opt ['start'];
		}
		if (isset ( $opt ['limit'] ) && is_int ( $opt ['limit'] )) {
			$opt [self::QUERY_STRING] ['limit'] = $opt ['limit'];
		}
		
		$opt [self::QUERY_STRING] ['prefix'] = rawurlencode ( $dir );
		$opt [self::QUERY_STRING] ['dir'] = $list_model;
		
		$response = $this->authenticate ( $opt );
		$this->log ( $response->isOK () ? "List object success!" : "Lit object failed! Response: [" . $response->body . "]", $opt );
		return $response;
	}

	/**
	 * �ϴ��ļ�
	 * @param string $bucket (Required) 
	 * @param string $object (Required) 
	 * @param string $file (Required); ��Ҫ�ϴ����ļ����ļ�·��
	 * @param array $opt (Optional) 
	 * filename - Optional; ָ���ļ���
	 * acl - Optional ; �ϴ��ļ���acl��ֻ��ʹ��acl_type
	 * seekTo - Optional; �ϴ��ļ���ƫ��λ��
	 * length - Optional; ���ϴ�����
	 * @return BCS_ResponseCore
	 */
	public function create_object($bucket, $object, $file, $opt = array()) {
		$this->assertParameterArray ( $opt );
		$opt [self::BUCKET] = $bucket;
		$opt [self::OBJECT] = $object;
		$opt ['fileUpload'] = $file;
		$opt [self::METHOD] = 'PUT';
		if (isset ( $opt ['acl'] )) {
			if (in_array ( $opt ['acl'], self::$ACL_TYPES )) {
				self::set_header_into_opt ( "x-bs-acl", $opt ['acl'], $opt );
			} else {
				throw new BCS_Exception ( "Invalid acl string, it should be acl_type", - 1 );
			}
			unset ( $opt ['acl'] );
		}
		if (isset ( $opt ['filename'] )) {
			self::set_header_into_opt ( "Content-Disposition", 'attachment; filename=' . $opt ['filename'], $opt );
		}
		$response = $this->authenticate ( $opt );
		$this->log ( $response->isOK () ? "Create object[$object] file[$file] success!" : "Create object[$object] file[$file] failed! Response: [" . $response->body . "] Logid[" . $response->header ["x-bs-request-id"] . "]", $opt );
		return $response;
	}

	/**
	 * �ϴ��ļ�
	 * @param string $bucket (Required) 
	 * @param string $object (Required) 
	 * @param string $file (Required); ��Ҫ�ϴ����ļ����ļ�·��
	 * @param array $opt (Optional) 
	 * filename - Optional; ָ���ļ���
	 * acl - Optional ; �ϴ��ļ���acl��ֻ��ʹ��acl_type
	 * @return BCS_ResponseCore
	 */
	public function create_object_by_content($bucket, $object, $content, $opt = array()) {
		$this->assertParameterArray ( $opt );
		$opt [self::BUCKET] = $bucket;
		$opt [self::OBJECT] = $object;
		$opt [self::METHOD] = 'PUT';
		if ($content !== NULL && is_string ( $content )) {
			$opt ['content'] = $content;
		} else {
			throw new BCS_Exception ( "Invalid object content, please check.", - 1 );
		}
		if (isset ( $opt ['acl'] )) {
			if (in_array ( $opt ['acl'], self::$ACL_TYPES )) {
				self::set_header_into_opt ( "x-bs-acl", $opt ['acl'], $opt );
			} else {
				throw new BCS_Exception ( "Invalid acl string, it should be acl_type", - 1 );
			}
			unset ( $opt ['acl'] );
		}
		if (isset ( $opt ['filename'] )) {
			self::set_header_into_opt ( "Content-Disposition", 'attachment; filename=' . $opt ['filename'], $opt );
		}
		$response = $this->authenticate ( $opt );
		$this->log ( $response->isOK () ? "Create object[$object] success!" : "Create object[$object] failed! Response: [" . $response->body . "] Logid[" . $response->header ["x-bs-request-id"] . "]", $opt );
		return $response;
	}

	/**
	 * ͨ��superfile�ķ�ʽ�ϴ��ļ�
	 * @param string $bucket (Required) 
	 * @param string $object (Required) 
	 * @param string $file (Required); ��Ҫ�ϴ����ļ����ļ�·��
	 * @param array $opt (Optional) 
	 * filename - Optional; ָ���ļ���
	 * sub_object_size - Optional; ָ�����ļ��Ļ��ִ�С����λB��������256KBΪ��λ������object���֣�Ĭ��Ϊ1MB���л���
	 * @return BCS_ResponseCore
	 */
	public function create_object_superfile($bucket, $object, $file, $opt = array()) {
		if (isset ( $opt ['length'] ) || isset ( $opt ['seekTo'] )) {
			throw new BCS_Exception ( "Temporary unsupport opt of length and seekTo of superfile.", - 1 );
		}
		//$opt array
		$this->assertParameterArray ( $opt );
		$opt [self::BUCKET] = $bucket;
		$opt ['fileUpload'] = $file;
		$opt [self::METHOD] = 'PUT';
		if (isset ( $opt ['acl'] )) {
			if (in_array ( $opt ['acl'], self::$ACL_TYPES )) {
				self::set_header_into_opt ( "x-bs-acl", $opt ['acl'], $opt );
			} else {
				throw new BCS_Exception ( "Invalid acl string, it should be acl_type", - 1 );
			}
			unset ( $opt ['acl'] );
		}
		//��Ƭ�ϴ�
		if (! file_exists ( $opt ['fileUpload'] )) {
			throw new BCS_Exception ( 'File not found!', - 1 );
		}
		$fileSize = filesize ( $opt ['fileUpload'] );
		$sub_object_size = 1024 * 1024; //default 1MB
		if (defined ( "BCS_SUPERFILE_SLICE_SIZE" )) {
			$sub_object_size = BCS_SUPERFILE_SLICE_SIZE;
		}
		if (isset ( $opt ["sub_object_size"] )) {
			if (is_int ( $opt ["sub_object_size"] ) && $opt ["sub_object_size"] > 0) {
				$sub_object_size = $opt ["sub_object_size"];
			} else {
				throw new BCS_Exception ( "Param [sub_object_size] invalid ,please check!", - 1 );
			}
		}
		$sliceNum = intval ( ceil ( $fileSize / $sub_object_size ) );
		$this->log ( "File[" . $opt ['fileUpload'] . "], size=[$fileSize], sub_object_size=[$sub_object_size], sub_object_num=[$sliceNum]", $opt );
		$object_list = array (
				'object_list' => array () );
		for($i = 0; $i < $sliceNum; $i ++) {
			//send slice
			$opt ['seekTo'] = $i * $sub_object_size;
			
			if (($i + 1) === $sliceNum) {
				//last sub object
				$opt ['length'] = (0 === $fileSize % $sub_object_size) ? $sub_object_size : $fileSize % $sub_object_size;
			} else {
				$opt ['length'] = $sub_object_size;
			}
			$opt [self::OBJECT] = $object . BCS_SUPERFILE_POSTFIX . $i;
			$object_list ['object_list'] ['part_' . $i] = array ();
			$object_list ['object_list'] ['part_' . $i] ['url'] = 'bs://' . $bucket . $opt [self::OBJECT];
			$this->log ( "Begin to upload Sub-object[" . $opt [self::OBJECT] . "][$i/$sliceNum][seekto:" . $opt ['seekTo'] . "][Length:" . $opt ['length'] . "]", $opt );
			$response = $this->create_object ( $bucket, $opt [self::OBJECT], $file, $opt );
			if ($response->isOK ()) {
				$this->log ( "Sub-object upload[" . $opt [self::OBJECT] . "][$i/$sliceNum][seekto:" . $opt ['seekTo'] . "][Length:" . $opt ['length'] . "]success! ", $opt );
				$object_list ['object_list'] ['part_' . $i] ['etag'] = $response->header ['Content-MD5'];
				continue;
			} else {
				$this->log ( "Sub-object upload[" . $opt [self::OBJECT] . "][$i/$sliceNum] failed! ", $opt );
				return $response;
			}
		}
		//�����ļ���Ƭ���б���� superfile
		unset ( $opt ['fileUpload'] );
		unset ( $opt ['length'] );
		unset ( $opt ['seekTo'] );
		$opt ['content'] = self::array_to_json ( $object_list );
		$opt [self::QUERY_STRING] = array (
				"superfile" => 1 );
		$opt [self::OBJECT] = $object;
		if (isset ( $opt ['filename'] )) {
			self::set_header_into_opt ( "Content-Disposition", 'attachment; filename=' . $opt ['filename'], $opt );
		}
		$response = $this->authenticate ( $opt );
		$this->log ( $response->isOK () ? "Create object-superfile success!" : "Create object-superfile failed! Response: [" . $response->body . "]", $opt );
		return $response;
	}

	/**
	 * ��Ŀ¼�е������ļ������ϴ���ÿ���ļ�Ϊ����object��object������ʽ���꣺
	 * ���� /home/worker/a/b/c.txt  ���ϴ�Ŀ¼Ϊ$dir=/home/worker/a  
	 * object���ʽΪ
	 * 1. objectĬ��������ʽΪ ����Ŀ¼�� +�ļ��������������ļ�c.txt��Ĭ��Ϊ '/b/c.txt'
	 * 2. ��ǿ����ģʽ����$opt���п�ѡ������������
	 * ����˵�� ��prefix . has_sub_directory?"/b":"" . '/c.txt' 
	 * @param string $bucket (Required) 
	 * @param string $dir (Required) 
	 * @param array $opt(Optional) 
	 * string prefix �ļ�objectǰ׺
	 * boolean has_sub_directory(default=true)   object�������Ƿ�Я���ļ�����Ŀ¼�ṹ������Ϊfalse����ȷ�ϴ��ϴ���Ŀ¼��������Ŀ¼��û�������ļ�����������object��������
	 * BaiduBCS::IMPORT_BCS_PRE_FILTER   �û����Զ����ϴ��ļ�ǰ�Ĳ�������
	 * 1. ���������б�˳����Ϊ ($bucket,$object,$file,&$opt)��ע��$optΪupload_directory���������$opt�Ŀ�����ֻ�Ե�ǰobject��Ч
	 * 2. ��������ֵ����Ϊboolean����true���ļ������ϴ�����false�����ϴ�
	 * 3. �����������false�����������post_filter�ĵ���
	 * BaiduBCS::IMPORT_BCS_POST_FILTER  �û����Զ����ϴ��ļ���Ĳ�������
	 * 1. ���������б�˳����Ϊ ($bucket,$object,$file,&$opt,$response)��ע��$optΪupload_directory���������$opt�Ŀ�����ֻ�Ե�ǰobject��Ч
	 * 2. ��������ֵ��Ҫ��
	 * string seek_object �û��ϵ���������ҪΪobject���ƣ������object��Ŀ¼�в����ڣ��׳��쳣���������򽫸�object�ʹ˺��object�����ϴ�
	 * string seek_object_id ����ͬseek_object��ֻ��Ҫ�����ϴ���������־��չʾ��[a/b]��object��ż��ɣ�ע��object�������1��ʼ�����
	 * @return array  ������ʽ���ϴ����
	 * 'success' => int  �ϴ��ɹ����ļ���Ŀ
	 * 'skipped' => int  ���������ļ�
	 * 'failed' => array()   �ϴ�ʧ�ܵ��ļ�
	 * 
	 */
	public function upload_directory($bucket, $dir, $opt = array()) {
		$this->assertParameterArray ( $opt );
		if (! is_dir ( $dir )) {
			throw new BCS_Exception ( "$dir is not a dir!", - 1 );
		}
		$result = array (
				"success" => 0, 
				"failed" => array (), 
				"skipped" => 0 );
		$prefix = "";
		if (isset ( $opt ['prefix'] )) {
			$prefix = $opt ['prefix'];
		}
		$has_sub_directory = true;
		if (isset ( $opt ['has_sub_directory'] ) && is_bool ( $opt ['has_sub_directory'] )) {
			$has_sub_directory = $opt ['has_sub_directory'];
		}
		//��ȡ�ļ����͹���object��
		$file_tree = self::get_filetree ( $dir );
		$objects = array ();
		foreach ( $file_tree as $file ) {
			$object = $has_sub_directory == true ? substr ( $file, strlen ( $dir ) ) : "/" . basename ( $file );
			$objects [$prefix . $object] = $file;
		}
		$objectCount = count ( $objects );
		$before_upload_log = "Upload directory: bucket[$bucket] upload_dir[$dir] file_sum[$objectCount]";
		if (isset ( $opt ["seek_object_id"] )) {
			$before_upload_log .= " seek_object_id[" . $opt ["seek_object_id"] . "/$objectCount]";
		}
		if (isset ( $opt ["seek_object"] )) {
			$before_upload_log .= " seek_object[" . $opt ["seek_object"] . "]";
		}
		$this->log ( $before_upload_log, $opt );
		//�鿴�Ƿ���Ҫ��ѯ�ϵ㣬���жϵ�����
		if (isset ( $opt ["seek_object_id"] ) && isset ( $opt ["seek_object"] )) {
			throw new BCS_Exception ( "Can not set see_object_id and seek_object at the same time!", - 1 );
		}
		
		$num = 1;
		if (isset ( $opt ["seek_object"] )) {
			if (isset ( $objects [$opt ["seek_object"]] )) {
				foreach ( $objects as $object => $file ) {
					if ($object != $opt ["seek_object"]) {
						//���Ƕϵ��ļ�����object������ϴ�
						$this->log ( "Seeking[" . $opt ["seek_object"] . "]. Skip id[$num/$objectCount]object[$object]file[$file].", $opt );
						//$result ['skipped'] [] = "[$num/$objectCount]  " . $file;
						$result ['skipped'] ++;
						unset ( $objects [$object] );
					} else {
						//���ҵ��ϵ��ļ���ֹͣѭ�����Ӷϵ��ļ������ϴ�
						//���Ƕϵ��ļ�����object������ϴ�
						$this->log ( "Found seek id[$num/$objectCount]object[$object]file[$file], begin from here.", $opt );
						break;
					}
					$num ++;
				}
			} else {
				throw new BCS_Exception ( "Can not find you seek object, please check!", - 1 );
			}
		}
		if (isset ( $opt ["seek_object_id"] )) {
			if (is_int ( $opt ["seek_object_id"] ) && $opt ["seek_object_id"] <= $objectCount) {
				foreach ( $objects as $object => $file ) {
					if ($num < $opt ["seek_object_id"]) {
						$this->log ( "Seeking object of [" . $opt ["seek_object_id"] . "/$objectCount]. Skip  id[$num/$objectCount]object[$object]file[$file].", $opt );
						//$result ['skipped'] [] = "[$num/$objectCount]  " . $file;
						$result ['skipped'] ++;
						unset ( $objects [$object] );
					} else {
						break;
					}
					$num ++;
				}
			} else {
				throw new BCS_Exception ( "Param seek_object_id not valid, please check!", - 1 );
			}
		}
		//�ϴ�objects
		$objectCount = count ( $objects );
		foreach ( $objects as $object => $file ) {
			$tmp_opt = array_merge ( $opt );
			if (isset ( $opt [self::IMPORT_BCS_PRE_FILTER] ) && function_exists ( $opt [self::IMPORT_BCS_PRE_FILTER] )) {
				$bolRes = $opt [self::IMPORT_BCS_PRE_FILTER] ( $bucket, $object, $file, $tmp_opt );
				if ($bolRes !== true) {
					$this->log ( "User pre_filter_function return un-true. Skip id[$num/$objectCount]object[$object]file[$file].", $opt );
					//$result ['skipped'] [] = "id[$num/$objectCount]object[$object]file[$file]";
					$result ['skipped'] ++;
					$num ++;
					continue;
				}
			}
			try {
				$response = $this->create_object ( $bucket, $object, $file, $tmp_opt );
			} catch ( Exception $e ) {
				$this->log ( $e->getMessage (), $opt );
				$this->log ( "Upload Failed id[$num/$objectCount]object[$object]file[$file].", $opt );
				$num ++;
				continue;
			}
			if ($response->isOK ()) {
				$result ["success"] ++;
				$this->log ( "Upload Success id[$num/$objectCount]object[$object]file[$file].", $opt );
			} else {
				$result ["failed"] [] = "id[$num/$objectCount]object[$object]file[$file]";
				$this->log ( "Upload Failed id[$num/$objectCount]object[$object]file[$file].", $opt );
			}
			if (isset ( $opt [self::IMPORT_BCS_POST_FILTER] ) && function_exists ( $opt [self::IMPORT_BCS_POST_FILTER] )) {
				$opt [self::IMPORT_BCS_POST_FILTER] ( $bucket, $object, $file, $tmp_opt, $response );
			}
			$num ++;
		}
		//��ӡ��־�����ؽ������
		$result_str = "\r\n\r\nUpload $dir to $bucket finished!\r\n";
		$result_str .= "**********************************************************\r\n";
		$result_str .= "**********************Result Summary**********************\r\n";
		$result_str .= "**********************************************************\r\n";
		$result_str .= "Upload directory :  [$dir]\r\n";
		$result_str .= "File num :  [$objectCount]\r\n";
		$result_str .= "Success: \r\n\tNum: " . $result ["success"] . "\r\n";
		$result_str .= "Skipped:\r\n\tNum:" . $result ["skipped"] . "\r\n";
		//		foreach ( $result ["skipped"] as $skip ) {
		//			$result_str .= "\t$skip\r\n";
		//		}
		$result_str .= "Failed:\r\n\tNum:" . count ( $result ["failed"] ) . "\r\n";
		foreach ( $result ["failed"] as $fail ) {
			$result_str .= "\t$fail\r\n";
		}
		if (isset ( $opt [self::IMPORT_BCS_LOG_METHOD] )) {
			$this->log ( $result_str, $opt );
		} else {
			echo $result_str;
		}
		return $result;
	}

	/**
	 * ͨ���˷����Կ����ķ�ʽ����object��object��ԴΪ$source
	 * @param array $source (Required)  object ��Դ
	 * bucket(Required)
	 * object(Required)
	 * @param array $dest (Required)    ��������Ŀ��object
	 * bucket(Required)
	 * object(Required)
	 * @param array $opt (Optional) 
	 * source_tag ָ����������İ汾��
	 * @throws BCS_Exception
	 * @return BCS_ResponseCore
	 */
	public function copy_object($source, $dest, $opt = array()) {
		$this->assertParameterArray ( $opt );
		//valid source and dest
		if (empty ( $source ) || ! is_array ( $source ) || ! isset ( $source [self::BUCKET] ) || ! isset ( $source [self::OBJECT] )) {
			throw new BCS_Exception ( '$source invalid, please check!', - 1 );
		}
		if (empty ( $dest ) || ! is_array ( $dest ) || ! isset ( $dest [self::BUCKET] ) || ! isset ( $dest [self::OBJECT] ) || ! self::validate_bucket ( $dest [self::BUCKET] ) || ! self::validate_object ( $dest [self::OBJECT] )) {
			throw new BCS_Exception ( '$dest invalid, please check!', - 1 );
		}
		$opt [self::BUCKET] = $dest [self::BUCKET];
		$opt [self::OBJECT] = $dest [self::OBJECT];
		$opt [self::METHOD] = 'PUT';
		self::set_header_into_opt ( 'x-bs-copy-source', 'bs://' . $source [self::BUCKET] . $source [self::OBJECT], $opt );
		if (isset ( $opt ['source_tag'] )) {
			self::set_header_into_opt ( 'x-bs-copy-source-tag', $opt ['source_tag'], $opt );
		}
		$response = $this->authenticate ( $opt );
		$this->log ( $response->isOK () ? "Copy object success!" : "Copy object failed! Response: [" . $response->body . "]", $opt );
		return $response;
	}

	/**
	 * ����object��meta��Ϣ
	 * @param string $bucket (Required) 
	 * @param string $object (Required) 
	 * @param array $opt (Optional) 
	 * Ŀǰ֧�ֵ�meta��Ϣ���£�
	 * Content-Type
	 * Cache-Control
	 * Content-Disposition
	 * Content-Encoding
	 * Content-MD5
	 * Expires
	 * @return BCS_ResponseCore
	 */
	public function set_object_meta($bucket, $object, $meta, $opt = array()) {
		$this->assertParameterArray ( $opt );
		$this->assertParameterArray ( $meta );
		$opt [self::BUCKET] = $bucket;
		$opt [self::OBJECT] = $object;
		$opt [self::METHOD] = 'PUT';
		//����copy_object�ӿ�������meta��Ϣ
		$source = "bs://$bucket$object";
		if (empty ( $meta )) {
			throw new BCS_Exception ( '$meta can not be empty! And $meta must be array.', - 1 );
		}
		foreach ( $meta as $header => $value ) {
			self::set_header_into_opt ( $header, $value, $opt );
		}
		$source = array (
				self::BUCKET => $bucket, 
				self::OBJECT => $object );
		$response = $this->copy_object ( $source, $source, $opt );
		$this->log ( $response->isOK () ? "Set object meta success!" : "Set object meta failed! Response: [" . $response->body . "]", $opt );
		return $response;
	}

	/**
	 * ��ȡobject��acl
	 * @param string $bucket (Required) 
	 * @param string $object (Required) 
	 * @param array $opt (Optional) 
	 * @throws BCS_Exception
	 * @return BCS_ResponseCore
	 */
	public function get_object_acl($bucket, $object, $opt = array()) {
		$this->assertParameterArray ( $opt );
		$opt [self::BUCKET] = $bucket;
		$opt [self::METHOD] = 'GET';
		$opt [self::OBJECT] = $object;
		$opt [self::QUERY_STRING] = array (
				self::ACL => 1 );
		$response = $this->authenticate ( $opt );
		$this->log ( $response->isOK () ? "Get object acl success!" : "Get object acl failed! Response: [" . $response->body . "]", $opt );
		return $response;
	}

	/**
	 * ����object��acl��������ģʽ��
	 * (1).������ϸjson��ʽ��acl��
	 * a. $acl Ϊjson��array
	 * b. $acl Ϊjson��string
	 * (2).ͨ��acl_type�ֶν�������
	 * a. $acl ΪBaiduBCS::$ACL_ACTIONS�е��ֶ�
	 * @param string $bucket (Required)
	 * @param string $object (Required)
	 * @param string|array $acl (Required)
	 * @param array $opt (Optional)
	 * @return BCS_ResponseCore
	 */
	public function set_object_acl($bucket, $object, $acl, $opt = array()) {
		$this->assertParameterArray ( $opt );
		//analyze acl
		$result = $this->analyze_user_acl ( $acl );
		$opt = array_merge ( $opt, $result );
		$opt [self::BUCKET] = $bucket;
		$opt [self::METHOD] = 'PUT';
		$opt [self::OBJECT] = $object;
		$opt [self::QUERY_STRING] = array (
				self::ACL => 1 );
		$response = $this->authenticate ( $opt );
		$this->log ( $response->isOK () ? "Set object acl success!" : "Set object acl failed! Response: [" . $response->body . "]", $opt );
		return $response;
	}

	/**
	 * ɾ��object
	 * @param string $bucket (Required)
	 * @param string $object (Required)
	 * @param array $opt (Optional)
	 * @throws BCS_Exception
	 * @return BCS_ResponseCore
	 */
	public function delete_object($bucket, $object, $opt = array()) {
		$this->assertParameterArray ( $opt );
		$opt [self::BUCKET] = $bucket;
		$opt [self::METHOD] = 'DELETE';
		$opt [self::OBJECT] = $object;
		$response = $this->authenticate ( $opt );
		$this->log ( $response->isOK () ? "Delete object success!" : "Delete object failed! Response: [" . $response->body . "]", $opt );
		return $response;
	}

	/**
	 * �ж�object�Ƿ����
	 * @param string $bucket (Required)
	 * @param string $object (Required)
	 * @param array $opt (Optional)
	 * @throws BCS_Exception
	 * @return boolean true|boolean false|BCS_ResponseCore
	 * true��object����
	 * false��������
	 * BCS_ResponseCore��������
	 */
	public function is_object_exist($bucket, $object, $opt = array()) {
		$this->assertParameterArray ( $opt );
		$opt [self::BUCKET] = $bucket;
		$opt [self::METHOD] = 'HEAD';
		$opt [self::OBJECT] = $object;
		$response = $this->get_object_info ( $bucket, $object, $opt );
		if ($response->isOK ()) {
			return true;
		} elseif ($response->status === 404) {
			return false;
		}
		return $response;
	}

	/**
	 * ��ȡ�ļ���Ϣ�����͵�ΪHTTP HEAD�����ļ���Ϣ����http response��header�У�������ȡ�ļ�������
	 * @param string $bucket (Required)
	 * @param string $object (Required)
	 * @param array $opt (Optional)
	 * @throws BCS_Exception
	 * @return array BCS_ResponseCore
	 */
	public function get_object_info($bucket, $object, $opt = array()) {
		$this->assertParameterArray ( $opt );
		$opt [self::BUCKET] = $bucket;
		$opt [self::METHOD] = 'HEAD';
		$opt [self::OBJECT] = $object;
		$response = $this->authenticate ( $opt );
		$this->log ( $response->isOK () ? "Get object info success!" : "Get object info failed! Response: [" . $response->body . "]", $opt );
		return $response;
	}

	/**
	 * ����object
	 * @param string $bucket (Required)
	 * @param string $object (Required)
	 * @param array $opt (Optional)
	 * fileWriteTo   (Optional)ֱ�ӽ�������д����ļ������fileWriteTo�ļ����ڣ�sdk�����������ٴ洢
	 * @throws BCS_Exception
	 * @return BCS_ResponseCore
	 */
	public function get_object($bucket, $object, $opt = array()) {
		$this->assertParameterArray ( $opt );
		//��fileWriteTo��д����ļ��Ѿ����ڣ���Ҫ����������
		if (isset ( $opt ["fileWriteTo"] ) && file_exists ( $opt ["fileWriteTo"] )) {
			$original_file_write_to = $opt ["fileWriteTo"];
			$arr = explode ( DIRECTORY_SEPARATOR, $opt ["fileWriteTo"] );
			$file_name = $arr [count ( $arr ) - 1];
			$num = 1;
			while ( file_exists ( $opt ["fileWriteTo"] ) ) {
				$new_name_arr = explode ( ".", $file_name );
				if (count ( $new_name_arr ) > 1) {
					$new_name_arr [count ( $new_name_arr ) - 2] .= " ($num)";
				} else {
					$new_name_arr [0] .= " ($num)";
				}
				$arr [count ( $arr ) - 1] = implode ( ".", $new_name_arr );
				$opt ["fileWriteTo"] = implode ( DIRECTORY_SEPARATOR, $arr );
				$num ++;
			}
			$this->log ( "[$original_file_write_to] already exist, rename it to [" . $opt ["fileWriteTo"] . "]", $opt );
		}
		$opt [self::BUCKET] = $bucket;
		$opt [self::METHOD] = 'GET';
		$opt [self::OBJECT] = $object;
		$response = $this->authenticate ( $opt );
		$this->log ( $response->isOK () ? "Get object success!" : "Get object failed! Response: [" . $response->body . "]", $opt );
		if (! $response->isOK () && isset ( $opt ["fileWriteTo"] )) {
			unlink ( $opt ["fileWriteTo"] );
		}
		return $response;
	}

	/**
	 * ����ǩ������
	 */
	private function generate_user_url($method, $bucket, $object, $opt = array()) {
		$opt [self::AK] = $this->ak;
		$opt [self::SK] = $this->sk;
		$opt [self::BUCKET] = $bucket;
		$opt [self::METHOD] = $method;
		$opt [self::OBJECT] = $object;
		$opt [self::QUERY_STRING] = array ();
		if (isset ( $opt ["time"] )) {
			$opt [self::QUERY_STRING] ["time"] = $opt ["time"];
		}
		if (isset ( $opt ["size"] )) {
			$opt [self::QUERY_STRING] ["size"] = $opt ["size"];
		}
		return $this->format_url ( $opt );
	}

	/**
	 * ����get_object��url
	 * @param string $bucket (Required)
	 * @param string $object (Required)
	 * return false| string url
	 */
	public function generate_get_object_url($bucket, $object, $opt = array()) {
		$this->assertParameterArray ( $opt );
		return $this->generate_user_url ( "GET", $bucket, $object, $opt );
	}

	/**
	 * ����put_object��url
	 * @param string $bucket (Required)
	 * @param string $object (Required)
	 * return false| string url
	 */
	public function generate_put_object_url($bucket, $object, $opt = array()) {
		$this->assertParameterArray ( $opt );
		return $this->generate_user_url ( "PUT", $bucket, $object, $opt );
	}

	/**
	 * ����post_object��url
	 * @param string $bucket (Required)
	 * @param string $object (Required)
	 * return false| string url
	 */
	public function generate_post_object_url($bucket, $object, $opt = array()) {
		$this->assertParameterArray ( $opt );
		return $this->generate_user_url ( "POST", $bucket, $object, $opt );
	}

	/**
	 * ����delete_object��url
	 * @param string $bucket (Required)
	 * @param string $object (Required)
	 * return false| string url
	 */
	public function generate_delete_object_url($bucket, $object, $opt = array()) {
		$this->assertParameterArray ( $opt );
		return $this->generate_user_url ( "DELETE", $bucket, $object, $opt );
	}

	/**
	 * ����head_object��url
	 * @param string $bucket (Required)
	 * @param string $object (Required)
	 * return false| string url
	 */
	public function generate_head_object_url($bucket, $object, $opt = array()) {
		$this->assertParameterArray ( $opt );
		return $this->generate_user_url ( "HEAD", $bucket, $object, $opt );
	}

	/**
	 * @return the $use_ssl
	 */
	public function getUse_ssl() {
		return $this->use_ssl;
	}

	/**
	 * @param boolean $use_ssl
	 */
	public function setUse_ssl($use_ssl) {
		$this->use_ssl = $use_ssl;
	}

	/**
	 * У��bucket�Ƿ�Ϸ���bucket�淶
	 * 1. ��Сд��ĸ�����ֺͺ���'-'��ɣ�����Ϊ6~63λ 
	 * 2. ������������ΪBucket��ͷ 
	 * 3. ������'-'��ΪBucket�Ŀ�ͷ���߽�β
	 * @param string $bucket
	 * @return boolean
	 */
	public static function validate_bucket($bucket) {
		//bucket ����
		$pattern1 = '/^[a-z][-a-z0-9]{4,61}[a-z0-9]$/';
		if (! preg_match ( $pattern1, $bucket )) {
			return false;
		}
		return true;
	}

	/**
	 * У��object�Ƿ�Ϸ���object�����淶
	 * 1. object������'/'��ͷ
	 * @param string $object
	 * @return boolean
	 */
	public static function validate_object($object) {
		$pattern = '/^\//';
		if (empty ( $object ) || ! preg_match ( $pattern, $object )) {
			return false;
		}
		return true;
	}

	/**
	 * ������set http-header�Ķ����������
	 * @param string $header
	 * @param string $value
	 * @param array $opt
	 * @throws BCS_Exception
	 * @return void
	 */
	private static function set_header_into_opt($header, $value, &$opt) {
		if (isset ( $opt [self::HEADERS] )) {
			if (! is_array ( $opt [self::HEADERS] )) {
				trigger_error ( 'Invalid $opt[\'headers\'], please check.' );
				throw new BCS_Exception ( 'Invalid $opt[\'headers\'], please check.', - 1 );
			}
		} else {
			$opt [self::HEADERS] = array ();
		}
		$opt [self::HEADERS] [$header] = $value;
	}

	/**
	 * ʹ���ض�function������������Ԫ��������
	 * @param string    &$array        Ҫ������ַ���
	 * @param string    $function    Ҫִ�еĺ���
	 * @param boolean   $apply_to_keys_also     �Ƿ�ҲӦ�õ�key��
	 */
	private static function array_recursive(&$array, $function, $apply_to_keys_also = false) {
		foreach ( $array as $key => $value ) {
			if (is_array ( $value )) {
				self::array_recursive ( $array [$key], $function, $apply_to_keys_also );
			} else {
				$array [$key] = $function ( $value );
			}
			
			if ($apply_to_keys_also && is_string ( $key )) {
				$new_key = $function ( $key );
				if ($new_key != $key) {
					$array [$new_key] = $array [$key];
					unset ( $array [$key] );
				}
			}
		}
	}

	/**
	 * �����鹹��json�ַ�����������һЩ���⴦����֧�������ַ��Ͳ�ͬ���������
	 * @param array $array
	 */
	private static function array_to_json($array) {
		if (! is_array ( $array )) {
			throw new BCS_Exception ( "Param must be array in function array_to_json()", - 1 );
		}
		self::array_recursive ( $array, 'addslashes', false );
		self::array_recursive ( $array, 'rawurlencode', false );
		return rawurldecode ( json_encode ( $array ) );
	}

	/**
	 * �����û������acl��������Ӧ�Ĵ���
	 * (1).������ϸjson��ʽ��acl��
	 * a. $acl Ϊjson��array
	 * b. $acl Ϊjson��string
	 * (2).ͨ��acl_type�ֶν�������
	 * @param string|array $acl
	 * @throws BCS_Exception
	 * @return array
	 */
	private function analyze_user_acl($acl) {
		$result = array ();
		if (is_array ( $acl )) {
			//(1).a
			$result ['content'] = $this->check_user_acl ( $acl );
		} else if (is_string ( $acl )) {
			if (in_array ( $acl, self::$ACL_TYPES )) {
				//(2).a
				$result ["headers"] = array (
						"x-bs-acl" => $acl );
			} else {
				//(1).b
				$result ['content'] = $acl;
			}
		} else {
			throw new BCS_Exception ( "Invalid acl.", - 1 );
		}
		return $result;
	}

	/**
	 * ����ǩ��
	 * @param array $opt
	 * @return boolean|string
	 */
	private function format_signature($opt) {
		$flags = "";
		$content = '';
		if (! isset ( $opt [self::AK] ) || ! isset ( $opt [self::SK] )) {
			trigger_error ( 'ak or sk is not in the array when create factor!' );
			return false;
		}
		if (isset ( $opt [self::BUCKET] ) && isset ( $opt [self::METHOD] ) && isset ( $opt [self::OBJECT] )) {
			$flags .= 'MBO';
			$content .= "Method=" . $opt [self::METHOD] . "\n"; //method
			$content .= "Bucket=" . $opt [self::BUCKET] . "\n"; //bucket
			$content .= "Object=" . self::trimUrl ( $opt [self::OBJECT] ) . "\n"; //object
		} else {
			trigger_error ( 'bucket��method and object cann`t be NULL!' );
			return false;
		}
		if (isset ( $opt ['ip'] )) {
			$flags .= 'I';
			$content .= "Ip=" . $opt ['ip'] . "\n";
		}
		if (isset ( $opt ['time'] )) {
			$flags .= 'T';
			$content .= "Time=" . $opt ['time'] . "\n";
		}
		if (isset ( $opt ['size'] )) {
			$flags .= 'S';
			$content .= "Size=" . $opt ['size'] . "\n";
		}
		$content = $flags . "\n" . $content;
		$sign = base64_encode ( hash_hmac ( 'sha1', $content, $opt [self::SK], true ) );
		return 'sign=' . $flags . ':' . $opt [self::AK] . ':' . urlencode ( $sign );
	}

	/**
	 * ����û������acl array�Ƿ�Ϸ�����תΪjson
	 * @param array $acl
	 * @throws BCS_Exception
	 * @return string acl-json
	 */
	private function check_user_acl($acl) {
		if (! is_array ( $acl )) {
			throw new BCS_Exception ( "Invalid acl array" );
		}
		foreach ( $acl ['statements'] as $key => $statement ) {
			// user resource action effect must in statement
			if (! isset ( $statement ['user'] ) || ! isset ( $statement ['resource'] ) || ! isset ( $statement ['action'] ) || ! isset ( $statement ['effect'] )) {
				throw new BCS_Exception ( 'Param miss: format acl error, please check your param!' );
			}
			if (! is_array ( $statement ['user'] ) || ! is_array ( $statement ['resource'] )) {
				throw new BCS_Exception ( 'Param error: user or resource must be array, please check your param!' );
			}
			if (! is_array ( $statement ['action'] ) || ! count ( array_diff ( $statement ['action'], self::$ACL_ACTIONS ) ) == 0) {
				throw new BCS_Exception ( 'Param error: action, please check your param!' );
			}
			if (! in_array ( $statement ['effect'], self::$ACL_EFFECTS )) {
				throw new BCS_Exception ( 'Param error: effect, please check your param!' );
			}
			if (isset ( $statement ['time'] )) {
				if (! is_array ( $statement ['time'] )) {
					throw new BCS_Exception ( 'Param error: time, please check your param!' );
				}
			}
		}
		
		return self::array_to_json ( $acl );
	}

	/**
	 * ����url
	 * @param array $opt
	 * @return boolean|string
	 */
	private function format_url($opt) {
		$sign = $this->format_signature ( $opt );
		if ($sign === false) {
			trigger_error ( "Format signature failed, please check!" );
			return false;
		}
		$opt ['sign'] = $sign;
		$url = "";
		$url .= $this->use_ssl ? 'https://' : 'http://';
		$url .= $this->hostname;
		$url .= '/' . $opt [self::BUCKET];
		if (isset ( $opt [self::OBJECT] ) && '/' !== $opt [self::OBJECT]) {
			$url .= "/" . rawurlencode ( $opt [self::OBJECT] );
		}
		$url .= '?' . $sign;
		if (isset ( $opt [self::QUERY_STRING] )) {
			foreach ( $opt [self::QUERY_STRING] as $key => $value ) {
				$url .= '&' . $key . '=' . $value;
			}
		}
		return $url;
	}

	/**
	 * ��url�� '//' �滻Ϊ  '/'
	 * @param $url
	 * @return string
	 */
	public static function trimUrl($url) {
		$result = str_replace ( "//", "/", $url );
		while ( $result !== $url ) {
			$url = $result;
			$result = str_replace ( "//", "/", $url );
		}
		return $result;
	}

	/**
	 * ��ȡ����Ŀ¼���ļ��б�
	 * @param string $dir �ļ�Ŀ¼
	 * @return array �ļ���
	 */
	public static function get_filetree($dir, $file_prefix = "/*") {
		$tree = array ();
		foreach ( glob ( $dir . $file_prefix ) as $single ) {
			if (is_dir ( $single )) {
				$tree = array_merge ( $tree, self::get_filetree ( $single ) );
			} else {
				$tree [] = $single;
			}
		}
		return $tree;
	}

	/**
	 * ���õ���־���������Ը����û������log������������־���
	 * @param string $log
	 * @param array $opt
	 */
	public function log($log, $opt) {
		if (isset ( $opt [self::IMPORT_BCS_LOG_METHOD] ) && function_exists ( $opt [self::IMPORT_BCS_LOG_METHOD] )) {
			$opt [self::IMPORT_BCS_LOG_METHOD] ( $log );
		} else {
			trigger_error ( $log );
		}
	}

	/**
	 * make sure $opt is an array
	 * @param $opt 
	 */
	private function assertParameterArray($opt) {
		if (! is_array ( $opt )) {
			throw new BCS_Exception ( 'Parameter must be array, please check!', - 1 );
		}
	}
}