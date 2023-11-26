<?php

class Tudou {
	
	public static function parse($url){
        $html = Base::_cget($url);
        preg_match("#vcode:\s*'([=\w]+)'\s*#ix",$html,$vcode);
       // $vcode[1] = 'PLyNgnwPfsw';
        if(!empty($vcode)&&!empty($vcode[1])){
            //判断视频是不是来自 优酷
            require_once 'youku.class.php';//echo '=='; $r['high'][] = 'http://vr.tudou.com/v2proxy/v?sid=95000&id=375020759&st=52';
            $r = Youku::_getYouku(trim($vcode[1]));//print_r($r);
            return $r;
        }
        /* 土豆改版 此方法失效 2013.10.17
        $api_url = "http://v2.tudou.com/v.action?ui=0&hd=100&sid={$areaCode}&vn=02&refurl=".urlencode($url)."&it=".$iid."&si=11000&pw=&st=1%2C2%2C3%2C5%2C99";
        */
        //现在根据土豆视频页面上的 segs 里的参数可以拼接地址 id为 segs里的k 获得相应清晰度的视频地址  http://v2.tudou.com/f?id=176466865&sid=10000&hd=3&sj=1
        $data = array();
        $time = $areaCode = $title = '';
        preg_match('#areaCode:\s*["\'](\d+)["\']#',$html,$areaCodes); //获得地区id
        $areaCode = $areaCodes[1]?$areaCodes[1]:10000;       
        preg_match("#segs:\s*'([^']+)'#ms",$html,$segs);
        preg_match('#kw:\s*"([^"]+)"#ms',$html,$kws); //获得标题
        preg_match('#time:\s*"([^"]+)"#ms',$html,$times);
        if(!empty($times[1])&&is_array($times)){
            $times_array = explode(":",$times[1]);
            if(count($times_array)==2){ 
                $time = intval($times_array[0])*60 + intval($times_array[1]);
            }else if(count($times_array)==3){
                $time = intval($times_array[0])*60*60 + intval($times_array[1])*60+intval($times_array[2]);
            }else{
                $time = intval($times[1]);        
            }
            
        }
        preg_match('#iid:\s*(\d+)#',$html,$iid);
        //$data['high'][] = 'http://vr.tudou.com/v2proxy/v2.m3u8?it='.$iid[1].'&st=52&cvid='.$iid[1];
        $title = (!empty($kws[1]))?$kws[1]:'';
        if(!empty($segs[1])){
            $segs_json = json_decode($segs[1],true);//print_r($segs_json);
            foreach($segs_json as $key =>$val){
            	if ($key !=2) continue;
                foreach ($val as $k =>$v){
                   // echo $api_url = "http://v2.tudou.com/f?id=".$v['k']."&sid={$areaCode}&hd={$key}&st=1";
                  // $api_url = 'http://v2.tudou.com/x?ev=1&expire=1449602931&cks=c59f69336d6e200d555cc85e8a5cd355&ctype=11&csig=75522d11b7563372f9d07135cfa9a66d&id=358228071&sid=11000&hd=3&sj=1';
                    $num = count($val);
                    $id = $v['k'] + ($num >1 ? $num : 1);
                    $id+= $num >1 ? 1 : 0;
                    $id+= $num >10 ? 1 : 0;
                    //$areaCode = 11000;
            		$data['high'][] = 'http://vr.tudou.com/v2proxy/v?sid='.$areaCode.'&id='.$id.'&st=2&cvid='.$iid[1];
            		break;
                   /* $v_xml = Base::_fget($api_url);
                    if(empty($v_xml)){
                        return false;
                    }
                    $s_xml = @simplexml_load_string($v_xml);var_dump($s_xml);
                    if($key == 2) $data['normal'][] = strval($s_xml);//normal
                    if($key == 3) $data['high'][] = strval($s_xml);
                    if($key == 5) $data['super'][] = strval($s_xml);
                    if($key == 99) $data['original'][] = strval($s_xml);*/
                }
                break;
            }
            $data['title'] = $title; //土豆网已经变为utf-8编码了无需转码
            $data['seconds'] = $time;//print_r($data);
            //$data['high'] = $data['super'];
            //$data['high'][0] = 'http://vr.tudou.com/v2proxy/v?sid='.$areaCode.'&id=375020759&st=52';
           return $data;               
        }else{
            return false;
        }	
	}
}