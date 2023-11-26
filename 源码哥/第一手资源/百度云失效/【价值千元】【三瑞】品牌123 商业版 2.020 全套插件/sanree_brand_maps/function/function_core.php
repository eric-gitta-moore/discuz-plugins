<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: function_core.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
function sanreepage($sum, $pagesize, $url,$page_len = 4) {
    $url = strpos($url, '?')>0 ? $url."&" : $url."?" ;
    $count = ceil($sum/$pagesize);
    $pages = $count;
    $init = 1;
    $max_p = $count;    
    if(empty($_GET["page"]) || $_GET["page"]<0){
        $page = 1;
    }else{
        $page = $_GET["page"];
    }
    $off = ($page-1)*$pagesize; 
    $page_len = ($page_len%2)?$page_len:$page_len+1;
    $pageoffset = ($page_len-1)/2;
    if($page!=1){
        $key.="<span><a href=\"".$url."page=1"."\">".maps_modlang('pagestr1')."&nbsp;</a></span>";
        $key.="<span><a href=\"".$url."page=".($page-1)."\">".maps_modlang('pagestr2')."&nbsp;</a></span>";
    }else{
        $key.="<span>&nbsp;</span>";
        $key.="<span>&nbsp;</span>";
    }
    if($pages>$page_len){
        if($page<=$pageoffset){
            $init=1;
            $max_p = $page_len;
        }else{
            if($page+$pageoffset>=$pages+1){
                $init = $pages - $page_len+1;
            }else{
                $init = $page-$pageoffset;
                $max_p = $page + $pageoffset;
            }
        }
    }
    for($i=$init;$i<$max_p;$i++){
        if($i==$page){
            $key.="[&nbsp;".$i."&nbsp;]";
            
        }else{
            $key.="<a href=\"".$url."page=".$i."\">$i</a>";
        }
    }
    if($i!=$page){
        $key.="<span><a href=\"".$url."page=".($page+1)."\">".maps_modlang('pagestr3')."</a></span>";
        $key.="<span><a href=\"".$url."page=".$pages."\">".maps_modlang('pagestr4')."</a></span>";
    }else{
        $key.="<span>&nbsp;</span>";
        $key.="<span>".maps_modlang('pagestr4')."</span>";
    }
	return $key;
}	

function maps_modlang($word) {
	return lang('plugin/sanree_brand_maps', $word);
}
function maps_getmodeurl($value){
    global $_G,$pidentifier;
	$config = $_G['cache']['plugin']['sanree_brand_maps']; 	
	$is_rewrite = $config['is_rewrite'];
	if ($is_rewrite) {
		$urlgoodsmode = empty($config['urlgoodsmode']) ? $pidentifier.".html": $config['urlgoodsmode'];
		return $urlgoodsmode;
	}
	return 'plugin.php?id=sanree_brand_'.$pidentifier;
}

function maps_getcateurl($param,$zero = FALSE){
    global $_G;
	$page 		= intval($_G['sr_page']);
	$page 		= max(1, intval($page));	
	$config = $_G['cache']['plugin']['sanree_brand_maps'];  
	$is_rewrite = $config['is_rewrite'];
	$keylist = array('tid', 'did', 'filter', 'listmode');
	$extra = '';
	foreach($keylist as $key =>$val) {
	    if (isset($param[$val])) {
		    $$val = $param[$val];
		}
		else {
			if ($zero) {
			    $$val 	= 0;
			}
			else {
				$$val 	= intval($_G['sr_'.$val]);
			}
		}
		($$val>0) && $extra.="&$val=".$$val;
	}
    if ($is_rewrite) {
	    $urllistmode = empty($config['urllistmode']) ? 'maps-{tid}-{page}.html': $config['urllistmode'];
		foreach($keylist as $line) {
		    $urllistmode = str_replace("{".$line."}",$$line ,$urllistmode);
		}
		$urllistmode = str_replace('{page}',$page ,$urllistmode);
		return $urllistmode;
	}
	return "plugin.php?id=sanree_brand_maps&mod=index".$extra;
}
//From:www_YMG6_COM
?>