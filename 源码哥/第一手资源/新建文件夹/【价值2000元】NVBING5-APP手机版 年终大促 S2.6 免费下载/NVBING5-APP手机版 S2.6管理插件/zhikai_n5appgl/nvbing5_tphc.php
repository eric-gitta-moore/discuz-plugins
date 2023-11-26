<?php
dsrcreplace();
function dsrcreplace(){
	$s = ob_get_contents();
	ob_end_clean();
    preg_match_all('/<img(.*?)src=[\'|\"|](.*?)[\'|\"|]/',$s,$matches);
    $find = $replace = array();
    foreach($matches[0] as $k=>$html){
    	if(!strstr($html,"nodata-echo")){
        	$find[] = $html;
            $replace[] = '<img'.$matches[1][$k].'src="template/zhikai_n5app/images/n5app_ysjz.png" data-echo="'.$matches[2][$k].'"';
        }
    }//From  www.ymg6.co m
    $s = str_replace($find,$replace,$s);
    echo $s;
}
?>