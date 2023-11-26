<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: hook.class.php $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
define('CURMODE_SANREE_GOODS', 'goods');
$modfile=DISCUZ_ROOT.'./source/plugin/sanree_brand_goods/function/function_core.php';
@require_once($modfile);
$modfile = DISCUZ_ROOT.'./source/plugin/sanree_brand_goods/function/function_module.php';
@require_once($modfile);

class plugin_sanree_brand_goods {

	function sanreebrandmanagemenu($param){
	
		global $_G;
		$config = $_G['cache']['plugin']['sanree_brand_goods'];
		if (!$config['isopen']) {
		
			return;
			
		}	
		$brand_config = $_G['cache']['plugin']['sanree_brand'];
		if (!$brand_config['isopen']) {
		
			return;
			
		}			
		if ($param['bid']<1) {
			return;
		}
		$isgoods = C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_by_modename('isgoods', $param['bid']);	
		if ($isgoods!=1) {
		
			return;
			
		}			
		$_G['sanree_brand_managemenus'][] = array(
			'displayorder'=> 200, 
			'window' => 0,
			'name'=>'mygoods', 
			'title'=> goods_modlang('mygoods'), 
			'url'=> 'plugin.php?id=sanree_brand_goods&mod=mygoods',
			'class' => '',
			'image' => 'source/plugin/sanree_brand_goods/tpl/default/images/mygoods.png'
		);
		$_G['sanree_brand_managemenus'][] = array(
			'displayorder'=> 201, 
			'window' => 1,
			'name'=>'publisheddlg', 
			'title'=> goods_modlang('post_new_goods'), 
			'url'=> 'plugin.php?id=sanree_brand_goods&mod=published',
			'class' => '',
			'addhtml' => '<link rel="stylesheet" type="text/css" id="sanree_brand_goods" href="source/plugin/sanree_brand_goods/tpl/default/sanree_brand_goods.css" />',
			'image' => 'source/plugin/sanree_brand_goods/tpl/default/images/post_new_goods.png'
		);
		
	}
	
	function global_footer(){
	
		global $_G;
		$config = $_G['cache']['plugin']['sanree_brand'];
		if (!$config['isopen']) {
			return '';
		}			  
		$style = '';
		if (file_exists(DISCUZ_ROOT."/data/cache/sanree_brand_goos_diy.css")) {
		
			$style .= '<link href="data/cache/sanree_brand_goos_diy.css" rel="stylesheet" type="text/css" />';
			
		}		
		return $style;
		
	}
	
      function sanreemoduleupdate($param) {
	  
	      global $_G;
	      $bid = intval($param[bid]);
		  $data = $param[data];
          $isgoods = $data[isgoods];
		  $gid = array();
		  if ($bid<1) return;
		  foreach(C::t('#sanree_brand_goods#sanree_brand_goods')->fetch_all_by_bid($bid) as $data) {

			  C::t('#sanree_brand_goods#sanree_brand_goods')->update($data[gid], array('isshow' => $isgoods));
			  $gid[] = $data[gid];
			  
		  }
		  goods_fixthread($gid);
		  
	  }
	  
	  function discuzcode($data) {
	  
			global $_G,$thread;
			$brandconfig = $_G['cache']['plugin']['sanree_brand'];
			if (!$brandconfig['isopen']) {
			
				return;
				
			}			
			$config = $_G['cache']['plugin']['sanree_brand_goods'];
			if (!$config['isopen']) {
			
				return;
				
			}
			$bindingforum = intval($config['bindingforum']);
			if ($bindingforum<1) return;
			if ($bindingforum != $thread['fid']) {	
			
				return;
				
			}
			$result = C::t('#sanree_brand_goods#sanree_brand_goods')->getgoods_by_tid($_G[tid]);
			$_G['discuzcodemessage'] = str_replace('{stock}', intval($result['stock']), $_G['discuzcodemessage']);
			$brandurl= goods_brandgetburl($result[bid]);
			$brandinfo =  '<a href=\''.$brandurl.'\' target=\'_blank\'>'.$result['brandname'].'</a>';
			$_G['discuzcodemessage'] = str_replace('{brandinfo}', $brandinfo, $_G['discuzcodemessage']);
					
			$selectpriceunit = $config['selectpriceunit'];
			$marr = explode("\r\n", $selectpriceunit);
			foreach($marr as $row) {
			
				list($key , $val) = explode("=", $row);
				$config['selectpriceunitshow'][trim($key)] = goods_shtmlspecialchars(trim($val));
				
			}			
			$_G['discuzcodemessage'] = str_replace('{priceunit}', $config['selectpriceunitshow'][$result['priceunit']].' ', $_G['discuzcodemessage']);
			
			if($data['caller'] == 'discuzcode') {
			
				$_G['discuzcodemessage'] = preg_replace("/\s?\[legend\](.+?)\[\/legend\]\s?/ies", '$this->sanreetemplate(\'legend\',\'\\1\')', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = preg_replace("/\s?\[fieldset\](.+?)\[\/fieldset\]\s?/ies", '$this->sanreetemplate(\'fieldset\',\'\\1\')', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = preg_replace("/\s?\[label\](.+?)\[\/label\]\s?/ies", '$this->sanreetemplate(\'label\',\'\\1\')', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = preg_replace("/\s?\[logo\](.+?)\[\/logo\]\s?/ies", '$this->sanreetemplate(\'logo\',\'\\1\')', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = preg_replace("/\s?\[qq\](.+?)\[\/qq\]\s?/ies", '$this->sanreetemplate(\'qq\',\'\\1\')', $_G['discuzcodemessage']);
				
			} else {
			
				$_G['discuzcodemessage'] = preg_replace("/\s?\[legend\](.+?)\[\/legend\]\s?/ies", '', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = preg_replace("/\s?\[fieldset\](.+?)\[\/fieldset\]\s?/ies", '', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = preg_replace("/\s?\[label\](.+?)\[\/label\]\s?/ies", '', $_G['discuzcodemessage']);
				
			}
			
	  }
	  
	  function sanreetemplate($tag, $param = '') {
	  
	        global $_G,$thread;
			$brandconfig = $_G['cache']['plugin']['sanree_brand'];
			if (!$brandconfig['isopen']) {
			
				return '';
				
			}
			$config = $_G['cache']['plugin']['sanree_brand_goods'];
			if (!$config['isopen']) {
			
				return '';
				
			}		
	
			if ($tag=='logo') {
			
			    return '<style>.sanreegoodslogo{padding:10px;float:left;width:150px; height:150px;overflow:hidden}.sanreegoodslogo img {width:150px; height:150px}</style><div class="sanreegoodslogo">'.$param.'</div>';
				
			} elseif ($tag=='qq') {
			
			    return '<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$param.'&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:'.$param.':16" alt="'.lang('plugin/sanree_brand','qqtip').'" title="'.lang('plugin/sanree_brand','qqtip').'" align="absmiddle"></a><br>';
				
			} else {
			
			    return '<'.$tag.'>'.$param.'</'.$tag.'>';
				
			}
			
	  }
	
	function sanreebrandusermenu($param){
	
		global $_G;
		$config = $_G['cache']['plugin']['sanree_brand_goods'];
		if (!$config['isopen']) {
		
			return;
			
		}		
		if ($param['bid']<1) {
			return;
		}
		$isgoods = C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_by_modename('isgoods', $param['bid']);	
		if ($isgoods!=1) {
		
			return;
			
		}	
		$modulemenuname = empty($config['modulemenuname']) ? goods_modlang('itemgoods') : $config['modulemenuname'];
		$_G['sanree_brand_menus']['goods'] = array('name'=>'goods', 'title'=> $modulemenuname, 'url'=>goods_getusermodeurl($param),'class' => ' class="normal"');
		
	}
		  
}

class plugin_sanree_brand_goods_home extends plugin_sanree_brand_goods {

	function spacecp_credit_top_output() {
	
		global $_G;
		lang('spacecp');		
		$_G['lang']['spacecp']['GRD_credit'] = lang('plugin/sanree_brand_goods', 'GRD');
		$_G['lang']['spacecp']['logs_credit_update_GRD'] = lang('plugin/sanree_brand_goods', 'GRD');
		
	} 
	
}

//class plugin_identifier_CURSCRIPT extends plugin_identifier {

class plugin_sanree_brand_goods_plugin extends plugin_sanree_brand_goods {
///function CURMODULE_USERDEFINE[_output]()
	function sanree_brand_userbar(){
	
		global $_G;
		$actives = array();
		$view = '';
		if ($_G['sr_id']=='sanree_brand_goods') {
			$view = ' class="a"';
		}
		$config = $_G['cache']['plugin']['sanree_brand_goods'];
		if (!$config['isopen']) {
		
			return;
			
		}
		$gcount[0] = C::t('#sanree_brand_goods#sanree_brand_goods')->count_by_wherec(array('t.uid='.$_G['uid'],'c.status=1','t.status=1'));
		$gcount[1] = C::t('#sanree_brand_goods#sanree_brand_goods')->count_by_wherec(array('t.uid='.$_G['uid'],'c.status=1','t.status=0'));
		$gcount[2] = C::t('#sanree_brand_goods#sanree_brand_goods')->count_by_wherec(array('t.uid='.$_G['uid'],'c.status=1','t.status=-1'));
		$gcount[3] = $gcount[0] + $gcount[1] +$gcount[2];		
		$result = '<li'.$view.'><a href="plugin.php?id=sanree_brand_goods&mod=mygoods&view=index">'.lang('plugin/sanree_brand_goods','mygoods').'('.$gcount[3].')</a></li>';
		return $result;
		
	}	

	function sanree_brand_user_index_righttop_output($param){
	
		global $_G;
		$config = $_G['cache']['plugin']['sanree_brand_goods'];
		if (!$config['isopen']) {
		
			return;
			
		}	
		$selectpriceunit = $config['selectpriceunit'];
		$marr = explode("\r\n", $selectpriceunit);
		foreach($marr as $row) {
		
			list($key , $val) = explode("=", $row);
			$config['selectpriceunitshow'][trim($key)] = goods_shtmlspecialchars(trim($val));
			
		}		
		$template = trim($config['template']);
		$template = empty($template) ? 'default' : $template;			
		$brand_config = $_G['cache']['plugin']['sanree_brand'];
		if (!$brand_config['isopen']) {
		
			return;
			
		}	
		$values = $param['values'];
		if ($values['sign']!=='sanree') return;		
		$bid = intval($values['bid']);
		$brandresult = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($bid);
		if (!$brandresult) {
			return;
		}
		if ($brandresult['status']!=1) {
			return;
		}
		$brandmoduleresult = C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_by_bid($bid);
		if ($brandmoduleresult['isgoods']!=1) {
			return;
		}	
		$goodsshownum = 4;
		$modelurl = goods_getusermodeurl(array('bid' => $bid));
		$datalist = C::t('#sanree_brand_goods#sanree_brand_goods')->fetch_all_by_searchc(array('c.status=1', 't.status=1', 't.isshow=1', 't.bid='.$bid), 't.dateline desc', 0, $goodsshownum);
		$htmlline = '';
		$show_price = goods_modlang('show_price');
		$show_minprice = goods_modlang('show_minprice');
		foreach($datalist as $line) {
		
			$value = array(
				'title' => $line['name'], 
				'url' => goods_getburl($line),
				'pic' => goods_getforumimg($line['homeaid'], 0 , 78, 78),
				'price' => $line['price'],
				'minprice' => $line['minprice'],
				'priceunit' => $config['selectpriceunitshow'][$line['priceunit']],	
				'unit' => empty($line['unit']) ? '' : '/ '.$line['unit'] 
			);
			
			$htmlline .="<li><div class=\"glistleft\"><a href=\"$value[url]\" title=\"$value[title]\" target=\"_blank\"><img src=\"$value[pic]\" width=\"78\" height=\"78\" /></a></div><div class=\"glistright\">
			<div class=\"goodsname\"><a href=\"$value[url]\" title=\"$value[title]\" target=\"_blank\">$value[title]</a></div>
			<div class=\"goodsprice\"><span title=\"$show_price $value[priceunit]$value[price] $value[unit]\">$value[priceunit]$value[price] $value[unit]</span></div>
			<div class=\"goodsminprice\"><span title=\"$show_minprice $value[priceunit]$value[minprice] $value[unit]\">$value[priceunit]$value[minprice]</span> $value[unit]</div>
			</div></li>\n";
			
		}
		$goodstitle = empty($config['modulemenuname']) ? goods_modlang('itemgoods') : $config['modulemenuname'];
		$more = goods_modlang('more');
$outhtml =<<<EOF
<div class="brand_goodslist">
<div class="hd">
<span><a href="$modelurl" target="_blank">$more</a></span>
<h1>$goodstitle</h1>
</div>
<div class="bd">
  <ul>
	$htmlline
  </ul>	  
</div>
</div>
EOF;
		return $outhtml;
		
	}	
		
}

class plugin_sanree_brand_goods_forum extends plugin_sanree_brand_goods {

    function viewthread_postfooter_output(){
	
	    global $_G;
		$config = $_G['cache']['plugin']['sanree_brand_goods'];
		if (!$config['isopen']) {
		
		    return;
			
		}
		if ($_G[uid]==1) return;
		$action = $_GET['action'];
		$bindingforum = intval($config['bindingforum']);
		if ($bindingforum<1) return;
		if ((CURSCRIPT == 'forum') && $bindingforum == $_G['fid']) {
		
			$_G['group']['alloweditpost'] = 0;
			$_G['group']['allowdelpost'] = 0;
			$_G['group']['allowclosethread'] = 0;
			$_G['group']['allowmovethread'] = 0;
			$_G['group']['allowedittypethread'] = 0;
			$_G['group']['allowcopythread'] = 0;
			$_G['group']['allowsplitthread'] = 0;
			$_G['group']['allowrepairthread'] = 0;
			$_G['group']['allowwarnpost'] = 0;
			$_G['group']['allowmergethread'] = 0;
			$_G['group']['allowbanpost'] = 0;
			
		}
			
	}
	
	function viewthread_title_extra_output() {
	    global $_G;
		$config = $_G['cache']['plugin']['sanree_brand_goods'];
		if (!$config['isopen']) {
		
		    return '';
			
		}
		$bindingforum = intval($config['bindingforum']);
		if ($bindingforum<1) return '';
		if ((CURSCRIPT == 'forum') && $bindingforum == $_G['fid']) {
		
		   return $config['forumwarning'];
		   
		}			
		return '';
		
	}
	
	function forumdisplay_top_output() {
	
	    global $_G,$fastpost;
		$config = $_G['cache']['plugin']['sanree_brand_goods'];
		if (!$config['isopen']) {
		
		    return;
			
		}
		if ($_G[uid]==1) return;
		$action = $_GET['action'];
		$bindingforum = intval($config['bindingforum']);
		if ($bindingforum<1) return;
		if ((CURSCRIPT == 'forum') && $bindingforum == $_G['fid']) {
		
		   $fastpost = 0;
		   
		}
		
	}
	
	function viewthread_middle_output() {
	
	    global $_G,$allowfastpost,$thread;
		$config = $_G['cache']['plugin']['sanree_brand_goods'];
		if (!$config['isopen']) {
		
		    return;
			
		}
		if ($_G[uid]==1) return;
		$action = $_GET['action'];
		$bindingforum = intval($config['bindingforum']);
		if ($bindingforum<1) return;
		if ((CURSCRIPT == 'forum') && $bindingforum == $_G['fid']) {
		
		   $result = C::t('#sanree_brand_goods#sanree_brand_goods')->getgoods_by_tid($thread['tid']);
		   if ($result['allowreply'] != 1) {
		   
			   $allowfastpost = FALSE;
			   
		   }
		   
		}
		
	}	
	function viewthread(){
	
	    global $_G;
		$config = $_G['cache']['plugin']['sanree_brand_goods'];
		if (!$config['isopen']) {
		
		    return;
			
		}
		if ($_G[uid]==1) return;
		$bindingforum = intval($config['bindingforum']);
		if ($bindingforum<1) return;
				
		if ((CURSCRIPT == 'forum') && $bindingforum == $_G['fid']) {
		
			$allowgroup = unserialize($config['allowgroup']);
			$groupid = $_G['group']['groupid'];
			if (!in_array($groupid, $allowgroup)) {
			
				showmessage(goods_modlang('stopallowtip'));
				
			}
			$viewgroup = unserialize($config['viewgroup']);
			if (!in_array($groupid, $viewgroup)) {
			
				showmessage(goods_modlang('stopviewtip'));
				
			}
			
		}
		
	}
		
	function post() {
	
	    global $_G, $mod;
		$config = $_G['cache']['plugin']['sanree_brand_goods'];
		if (!$config['isopen']) {
		
		    return;
			
		}
		if ($_G[uid]==1) return;
		$action = $_GET['action'];
		$bindingforum = intval($config['bindingforum']);
		if ($bindingforum<1) return;
		if ((CURSCRIPT == 'forum') && ($mod == 'post') && $bindingforum == $_G['fid']) {
		
		   if ($action != 'reply') {
		   
			   showmessage('postperm_none_nopermission');
			   
		   }
		   $gresult = C::t('#sanree_brand_goods#sanree_brand_goods')->getgoods_by_tid($_G['tid']);
		   if (!$gresult) {
		   
			   showmessage(lang('plugin/sanree_brand_goods', 'nofastpostcontrol'));
			   
		   }
		   $result = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($gresult[bid]);
		   if ($result['allowfastpost'] != 1) {
		   
			   showmessage(lang('plugin/sanree_brand_goods', 'nofastpostcontrol'));
			   
		   }
		   
		}
			
	} 
	
}
//From:www_YMG6_COM
?>