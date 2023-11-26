<?php
header("Content-type:text/html; charset=gb2312;");
require_once('function.php');
session_start();

if( !isset($_GET["state"])||empty($_GET["state"])||!isset($_GET["code"])||empty($_GET["code"]) )
{
	echo "第三方登录获取参数失败。<br />";
}
else
{
	if( $_GET["state"]!=$_SESSION["state"] )
	{
		echo "<span style='font-size:12px;line-height:24px;'>请求非法或超时!&nbsp;&nbsp;<a href='../../index.php'>返回首页</a></span>";
		exit;
	}
	$get_url = "https://graph.qq.com/oauth2.0/token";
	$get_param = array(
			"grant_type"     =>    "authorization_code",
			"client_id"      =>    $_SESSION['appid'],
			"client_secret"  =>    $_SESSION['appkey'],
			"code"           =>    $_GET["code"],
			"state"          =>    $_GET["state"],
			"redirect_uri"   =>    $_SESSION["redirect_url"]
	);
	unset($_SESSION["redirect_url"]);

	$content = get($get_url,$get_param);

	if( $content && $content!==FALSE)
	{
		$temp = explode("&", $content);
		$param = array();
		foreach($temp as $val)
		{
			$temp2 = explode("=", $val);
			$param[$temp2[0]] = $temp2[1];
		}
		$_SESSION["access_token"] = $param["access_token"];
		$get_url = "https://graph.qq.com/oauth2.0/me";
		$get_param = array(
				"access_token"    => $param["access_token"]
		);
		$content = get($get_url, $get_param);

		if( $content && $content!==FALSE )
		{
			$random = get_random(6);
			
			$temp = array();
			preg_match('/callback\(\s+(.*?)\s+\)/i', $content, $temp);
			$result = json_decode($temp[1],true);
			
			$openid = $result["openid"];
			$_SESSION["oauth_pass"] = $random.strtolower(substr($openid, 2, 2));
			$_SESSION["oauth_openid"] = $openid;
			$email = strtolower(substr($openid, 2, 8))."@qq.com";

			if( $result["openid"] && !empty($result["openid"]) && !empty($param["access_token"]) )
			{
				$get_url = "https://graph.qq.com/user/get_user_info";
				$get_param = array(
					"access_token"	=>	$param["access_token"],
					"oauth_consumer_key"	=>	$_SESSION['appid'],
					"openid"	=>	$result["openid"]
				);
								
				unset($_SESSION['appid']);
				unset($_SESSION['appkey']);
				$token = $param["access_token"];
				
				$content = get($get_url, $get_param);
				$result = json_decode($content,true);

				if( $result && $result['ret'] == 0 )
				{
					$user = iconv('UTF-8', 'GB2312//IGNORE', trim($result['nickname']));
					$img = $result['figureurl_2'];
					echo "<script type=\"text/javascript\">location.href='callback.php?openid=".$openid."&user=".base64_encode($user)."&img=".$img."';</script>";
				}
				else
				{
					echo "用户信息请求错误，错误代码：".$result['ret']."；错误信息：".$result['msg'];
				}
			}
		}
	}
}
?>