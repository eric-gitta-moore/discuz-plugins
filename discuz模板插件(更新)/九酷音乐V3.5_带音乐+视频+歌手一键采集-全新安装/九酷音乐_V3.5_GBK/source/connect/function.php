<?php
function get($get_url,$get_param){
    global $aConfig;
    $oCurl = curl_init();
    if(stripos($get_url,"https://")!==FALSE){
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
    }
    $aGet = array();
    foreach($get_param as $key=>$val){
        $aGet[] = $key."=".urlencode($val);
    }
    curl_setopt($oCurl, CURLOPT_URL, $get_url."?".join("&",$aGet));
    curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
    $sContent = curl_exec($oCurl);
    $aStatus = curl_getinfo($oCurl);
    curl_close($oCurl);
    if(intval($aConfig["debug"])===1){
        echo "<tr><td class='narrow-label'>请求地址:</td><td><pre>".$get_url."</pre></td></tr>";
        echo "<tr><td class='narrow-label'>GET参数:</td><td><pre>".var_export($get_param,true)."</pre></td></tr>";
        echo "<tr><td class='narrow-label'>请求信息:</td><td><pre>".var_export($aStatus,true)."</pre></td></tr>";
        if(intval($aStatus["http_code"])==200){
            echo "<tr><td class='narrow-label'>返回结果:</td><td><pre>".$sContent."</pre></td></tr>";
            if((@$aResult = json_decode($sContent,true))){
                echo "<tr><td class='narrow-label'>结果集合解析:</td><td><pre>".var_export($aResult,true)."</pre></td></tr>";
            }
        }
    }
    if(intval($aStatus["http_code"])==200){
        return $sContent;
    }else{
        echo "<tr><td class='narrow-label'>返回出错:</td><td><pre>".$aStatus["http_code"].",请检查参数或者确实是腾讯服务器出错咯。</pre></td></tr>";
        return FALSE;
    }
}

function post($sUrl,$aPOSTParam){
    global $aConfig;
    $oCurl = curl_init();
    if(stripos($sUrl,"https://")!==FALSE){
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
    }
    $aPOST = array();
    foreach($aPOSTParam as $key=>$val){
        $aPOST[] = $key."=".urlencode($val);
    }
    curl_setopt($oCurl, CURLOPT_URL, $sUrl);
    curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt($oCurl, CURLOPT_POST,true);
    curl_setopt($oCurl, CURLOPT_POSTFIELDS, join("&", $aPOST));
    $sContent = curl_exec($oCurl);
    $aStatus = curl_getinfo($oCurl);
    curl_close($oCurl);
    if(intval($aConfig["debug"])===1){
        echo "<tr><td class='narrow-label'>请求地址:</td><td><pre>".$sUrl."</pre></td></tr>";
        echo "<tr><td class='narrow-label'>POST参数:</td><td><pre>".var_export($aPOSTParam,true)."</pre></td></tr>";
        echo "<tr><td class='narrow-label'>请求信息:</td><td><pre>".var_export($aStatus,true)."</pre></td></tr>";
        if(intval($aStatus["http_code"])==200){
            echo "<tr><td class='narrow-label'>返回结果:</td><td><pre>".$sContent."</pre></td></tr>";
            if((@$aResult = json_decode($sContent,true))){
                echo "<tr><td class='narrow-label'>结果集合解析:</td><td><pre>".var_export($aResult,true)."</pre></td></tr>";
            }
        }
    }
    if(intval($aStatus["http_code"])==200){
        return $sContent;
    }else{
        echo "<tr><td class='narrow-label'>返回出错:</td><td><pre>".$aStatus["http_code"].",请检查参数或者确实是腾讯服务器出错咯。</pre></td></tr>";
        return FALSE;
    }
}

function upload($sUrl,$aPOSTParam,$aFileParam){
    global $aConfig;
    set_time_limit(0);
    $oCurl = curl_init();
    if(stripos($sUrl,"https://")!==FALSE){
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
    }
    $aPOSTField = array();
    foreach($aPOSTParam as $key=>$val){
        if(preg_match("/^@/i",$val)>0){
            $aPOSTField[$key] = " ".$val;
        }else{
            $aPOSTField[$key]= $val;
        }
    }
    foreach($aFileParam as $key=>$val){
        $aPOSTField[$key] = "@".$val;
    }
    curl_setopt($oCurl, CURLOPT_URL, $sUrl);
    curl_setopt($oCurl, CURLOPT_POST, true);
    curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt($oCurl, CURLOPT_POSTFIELDS, $aPOSTField);
    $sContent = curl_exec($oCurl);
    $aStatus = curl_getinfo($oCurl);
    curl_close($oCurl);
    if(intval($aConfig["debug"])===1){
        echo "<tr><td class='narrow-label'>请求地址:</td><td><pre>".$sUrl."</pre></td></tr>";
        echo "<tr><td class='narrow-label'>POST参数:</td><td><pre>".var_export($aPOSTParam,true)."</pre></td></tr>";
        echo "<tr><td class='narrow-label'>文件参数:</td><td><pre>".var_export($aFileParam,true)."</pre></td></tr>";
        echo "<tr><td class='narrow-label'>请求信息:</td><td><pre>".var_export($aStatus,true)."</pre></td></tr>";
        if(intval($aStatus["http_code"])==200){
            echo "<tr><td class='narrow-label'>返回结果:</td><td><pre>".$sContent."</pre></td></tr>";
            if((@$aResult = json_decode($sContent,true))){
                echo "<tr><td class='narrow-label'>结果集合解析:</td><td><pre>".var_export($aResult,true)."</pre></td></tr>";
            }
        }
    }
    if(intval($aStatus["http_code"])==200){
        return $sContent;
    }else{
        echo "<tr><td class='narrow-label'>返回出错:</td><td><pre>".$aStatus["http_code"].",请检查参数或者确实是腾讯服务器出错咯。</pre></td></tr>";
        return FALSE;
    }
}

function download($sUrl,$sFileName){
    $oCurl = curl_init();
    global $aConfig;
    set_time_limit(0);
    $oCurl = curl_init();
    if(stripos($sUrl,"https://")!==FALSE){
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
    }
    curl_setopt($oCurl, CURLOPT_USERAGENT, $_SERVER["USER_AGENT"] ? $_SERVER["USER_AGENT"] : "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.7) Gecko/20100625 Firefox/3.6.7");
    curl_setopt($oCurl, CURLOPT_URL, $sUrl);
    curl_setopt($oCurl, CURLOPT_REFERER, $sUrl);
    curl_setopt($oCurl, CURLOPT_AUTOREFERER, true);
    curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
    $sContent = curl_exec($oCurl);
    $aStatus = curl_getinfo($oCurl);
    curl_close($oCurl);
    file_put_contents($sFileName,$sContent);
    if(intval($aConfig["debug"])===1){
        echo "<tr><td class='narrow-label'>请求地址:</td><td><pre>".$sUrl."</pre></td></tr>";
        echo "<tr><td class='narrow-label'>请求信息:</td><td><pre>".var_export($aStatus,true)."</pre></td></tr>";
    }
    return(intval($aStatus["http_code"])==200);
}

function get_client_ip ()
{
	static $realip = NULL;
	if ($realip !== NULL)
	{
		return $realip;
	}
	if (isset($_SERVER))
	{
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
			$arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			foreach ($arr as $ip)
			{
				$ip = trim($ip);
				if ($ip != 'unknown')
				{
					$realip = $ip;
					break;
				}
			}
		}
		elseif (isset($_SERVER['HTTP_CLIENT_IP']))
		{
			$realip = $_SERVER['HTTP_CLIENT_IP'];
		}
		else
		{
			if (isset($_SERVER['REMOTE_ADDR']))
			{
				$realip = $_SERVER['REMOTE_ADDR'];
			}
			else
			{
				$realip = '0.0.0.0';
			}
		}
	}
	else
	{
		if (getenv('HTTP_X_FORWARDED_FOR'))
		{
			$realip = getenv('HTTP_X_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_CLIENT_IP'))
		{
			$realip = getenv('HTTP_CLIENT_IP');
		}
		else
		{
			$realip = getenv('REMOTE_ADDR');
		}
	}
	preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
	$realip = ! empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';
	return $realip;
}

function get_random( $length = 4 )
{
    $chars = array( 
        "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",  
        "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",  
        "w", "x", "y", "z", "0", "1", "2", "3", "4", "5", "6",
    	 "7", "8", "9"
    ); 
    $charsLen = count($chars) - 1; 
    shuffle($chars);   
    $output = ""; 
    for ($i=0; $i<$length; $i++) 
    { 
        $output .= $chars[mt_rand(0, $charsLen)]; 
    }
    return $output;  
}

function uhtml( $str )  
{
	$str = str_replace('`', '', $str);
	
	$str = strip_tags($str);

	if ( get_magic_quotes_gpc() )
	{
		$str = htmlspecialchars(trim($str), ENT_QUOTES);
	}
	else
	{
		$str = htmlspecialchars(trim(addslashes($str)), ENT_QUOTES);
	}
	
	return $str;
}
?>