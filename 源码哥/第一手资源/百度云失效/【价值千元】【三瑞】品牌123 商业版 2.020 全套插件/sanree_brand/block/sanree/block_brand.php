<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class block_brand {

    var $setting = array();
	function name() {
		return lang('plugin/sanree_brand', 'blockclass_brandname');
	}

	function blockclass() {
		return array('brand', lang('plugin/sanree_brand', 'blockclass_brandname'));
	}

	function fields() {
		return array(
				'brandname' => array('name' => lang('plugin/sanree_brand', 'blockclass_brand_field_title'), 'formtype' => 'title', 'datatype' => 'title'),
				'bid' => array('name' => lang('plugin/sanree_brand', 'blockclass_brand_field_bid'), 'formtype' => 'text', 'datatype' => 'int'),
				'url' => array('name' => lang('plugin/sanree_brand', 'blockclass_brand_field_url'), 'formtype' => 'text', 'datatype' => 'string'),
				'pic' => array('name' => lang('plugin/sanree_brand', 'blockclass_brand_field_pic'), 'formtype' => 'text', 'datatype' => 'pic'),	
				'views' => array('name' => lang('plugin/sanree_brand', 'blockclass_brand_field_views'), 'formtype' => 'text', 'datatype' => 'int'),
				'icq' => array('name' => lang('plugin/sanree_brand', 'blockclass_brand_field_icq'), 'formtype' => 'text', 'datatype' => 'string'),
				'qq' => array('name' => lang('plugin/sanree_brand', 'blockclass_brand_field_qq'), 'formtype' => 'text', 'datatype' => 'string'),
				'msn' => array('name' => lang('plugin/sanree_brand', 'blockclass_brand_field_msn'), 'formtype' => 'text', 'datatype' => 'string'),
				'wangwang' => array('name' => lang('plugin/sanree_brand', 'blockclass_brand_field_wangwang'), 'formtype' => 'text', 'datatype' => 'string'),
				'baiduhi' => array('name' => lang('plugin/sanree_brand', 'blockclass_brand_field_baiduhi'), 'formtype' => 'text', 'datatype' => 'string'),
				'skype' => array('name' => lang('plugin/sanree_brand', 'blockclass_brand_field_skype'), 'formtype' => 'text', 'datatype' => 'string'),			
				'address' => array('name' => lang('plugin/sanree_brand', 'blockclass_brand_field_address'), 'formtype' => 'text', 'datatype' => 'string'),
				'weburl' => array('name' => lang('plugin/sanree_brand', 'blockclass_brand_field_weburl'), 'formtype' => 'text', 'datatype' => 'string'),
				'cateid' => array('name' => lang('plugin/sanree_brand', 'blockclass_brand_field_cateid'), 'formtype' => 'text', 'datatype' => 'int'),
				'catename' => array('name' => lang('plugin/sanree_brand', 'blockclass_brand_field_catename'), 'formtype' => 'text', 'datatype' => 'string'),
				'tel' => array('name' => lang('plugin/sanree_brand', 'blockclass_brand_field_tel'), 'formtype' => 'text', 'datatype' => 'string'),
				'brandno' => array('name' => lang('plugin/sanree_brand', 'blockclass_brand_field_brandno'), 'formtype' => 'text', 'datatype' => 'string'),
				'region' => array('name' => lang('plugin/sanree_brand', 'blockclass_brand_field_region'), 'formtype' => 'text', 'datatype' => 'string'),
				'brandmf' => array('name' => lang('plugin/sanree_brand', 'blockclass_brand_field_brandmf'), 'formtype' => 'text', 'datatype' => 'string'),
				'brandtag' => array('name' => lang('plugin/sanree_brand', 'blockclass_brand_field_brandtag'), 'formtype' => 'text', 'datatype' => 'string'),
				'weixin' => array('name' => lang('plugin/sanree_brand', 'blockclass_brand_field_weixin'), 'formtype' => 'text', 'datatype' => 'string'),
				'weixinimg' => array('name' => lang('plugin/sanree_brand', 'blockclass_brand_field_weixinimg'), 'formtype' => 'text', 'datatype' => 'pic'),
				'weixinpublic' => array('name' => lang('plugin/sanree_brand', 'blockclass_brand_field_weixinpublic'), 'formtype' => 'text', 'datatype' => 'string'),
				'weixinpublicpic' => array('name' => lang('plugin/sanree_brand', 'blockclass_brand_field_weixinpublicpic'), 'formtype' => 'text', 'datatype' => 'pic'),
				'iscard' => array('name' => lang('plugin/sanree_brand', 'blockclass_brand_field_iscard'), 'formtype' => 'text', 'datatype' => 'string'),
			);
	}

	function getsetting() {
		global $_G;
		@require_once(DISCUZ_ROOT.'./source/plugin/sanree_brand/function/function_core.php');
		define('APPC',DISCUZ_ROOT.'./source/plugin/sanree_brand/condition/');
		$modfile = APPC.'index.php';
		require_once($modfile);			
		$category_list = array();
		$category = sanreeloadcache('usercate');
		$category_list[] = array('0', lang('plugin/sanree_brand','allcate'));
		foreach($category as $value) {
		
			$category_list[] = array($value[cateid], $value[name]);
			
		}
		$group_list = array();
		$group_list[] = array('0', lang('plugin/sanree_brand','kong'));
		foreach(C::t('#sanree_brand#sanree_brand_group')->fetch_all_group() as $value) {
		
			$group_list[] = array($value[groupid], $value[groupname]);
			
		}		
		
		$settings = array(	
			'cateid' => array(
				'title' => lang('plugin/sanree_brand','blockclass_catename'),
				'type' => 'select',
				'default' => 0,
				'value' => $category_list
			),	
			'groupid' => array(
				'title' => lang('plugin/sanree_brand','blockclass_groupname'),
				'type' => 'select',
				'default' => 0,
				'value' => $group_list
			),							
			'showfilter' => array(
				'title' => lang('plugin/sanree_brand','blockclass_showfilter'),
				'type' => 'mradio',
				'default' => 0,
				'value' => array(
					array('0', lang('plugin/sanree_brand','blockclass_zuixin')),
					array('1', lang('plugin/sanree_brand','blockclass_zhiding')),
					array('2', lang('plugin/sanree_brand','blockclass_tuijian'))
				)
			),		
			'orderby' => array(
				'title' => lang('plugin/sanree_brand','blockclass_ordertitle'),
				'type' => 'mradio',
				'default' => 0,
				'value' => array(
					array('0', lang('plugin/sanree_brand','blockclass_bid')),
					array('1', lang('plugin/sanree_brand','blockclass_showid')),
					array('2', lang('plugin/sanree_brand','blockclass_dateline')),
					array('3', lang('plugin/sanree_brand','blockclass_views'))
				)
			),
			'ordersc' => array(
				'title'=> lang('plugin/sanree_brand','blockclass_ordersctitle'),
				'type' => 'mradio',
				'default' => 0,
				'value' => array(
					array('0', lang('plugin/sanree_brand','blockclass_orderscdown')),
					array('1', lang('plugin/sanree_brand','blockclass_orderscup'))
				)
			),
			'start' => array(
				'title' => lang('plugin/sanree_brand','blockclass_starttitle'),
				'type' => 'text',
				'default' => 0
			)														
		);
		return $settings;
	}

	function cookparameter($parameter) {
		return daddslashes($parameter);
	}
	
	function getdata($style, $parameter) {

		global $_G;
		define('APPC',DISCUZ_ROOT.'./source/plugin/sanree_brand/condition/');
		$modfile = APPC.'index.php';
		@require_once($modfile);
		@require_once(DISCUZ_ROOT.'./source/plugin/sanree_brand/function/function_core.php');		
		$parameter = $this->cookparameter($parameter);		
		$config = $_G['cache']['plugin']['sanree_brand'];
		$is_rewrite = intval($config['is_rewrite']);
		$isselfdistrict = intval($config['isselfdistrict']);
		$ismultiple = intval($config['ismultiple']);
		$allicq = array('qq', 'msn', 'wangwang', 'baiduhi', 'skype');
		$icq = trim($config['icq']); 
		$icq = !in_array($icq, $allicq) ? 'qq' : $icq;
		$qqcode = trim($config['qqcode']); 
		$msncode = trim($config['msncode']); 
		$wangwangcode = trim($config['wangwangcode']); 
		$baiduhicode = trim($config['baiduhicode']); 
		$skypecode = trim($config['skypecode']);
		$icqshow = $icq.'code'; 
		$icqshow = $$icqshow;
		$start = isset($parameter['start']) ? intval($parameter['start']) : 0;
		$bannedids = !empty($parameter['bannedids']) ? explode(',', $parameter['bannedids']) : array();
		$items = !empty($parameter['items']) ? intval($parameter['items']) : 10;
		$orderby = isset($parameter['orderby']) ? $parameter['orderby'] : '0';
		$ordersc = isset($parameter['ordersc']) ? $parameter['ordersc'] : '0';
		$cateid = isset($parameter['cateid']) ? intval($parameter['cateid']) : '0';
		$groupid = isset($parameter['groupid']) ? intval($parameter['groupid']) : '0';		
		$showfilter = isset($parameter['showfilter']) ? intval($parameter['showfilter']) : '0';
		$spicwidth = isset($parameter['spicwidth']) ? intval($parameter['spicwidth']) : 0;
		$spicheight = isset($parameter['spicheight']) ? intval($parameter['spicheight']) : 0;			
		$showfilter = in_array($showfilter, array(0, 1, 2)) ? $showfilter : 0;
		$sc =array('asc', 'desc');
		$by = array('t.bid', 't.displayorder', 't.dateline', 'tt.views');
		$orderby=$by[$orderby];
		$ordersc=$sc[$ordersc];		
		$datalist = $wherearr = array(); 
        $wherearr[] = 't.status=1';
		$wherearr[] = 't.isshow=1';
		if ($cateid>0) {
		
			$category_list = $subcategory_list = array();
			require_once libfile('class/sanree_brand_category','plugin/sanree_brand');			
			$allurl = gethomeurl();
			$categoryclass = new sanree_brand_category('sanree_brand');
			$categoryclass->show($is_rewrite);
			$pid = $categoryclass->_pid;
			$category_list = $categoryclass->_category_list;
			$subcategory_list = $categoryclass->_subcategory_list;
			$cateids = array();
			$cateids[] = $cateid;
			if (is_array($subcategory_list)) {
			
			   foreach($subcategory_list as $key => $val) {
			   
				   $cateids[] = $key;
				   
			   }
			   
			}
			$ids = implode($cateids,',');
			if ($pid == $cateid) {
			
				$wherearr[] = 't.cateid in ('.$ids.')';
				
			} else {
			
				$wherearr[] = 't.cateid ='.$cateid ;
				
			}
			
		}
		if(!empty($bannedids)) {
		
			$banids = explode(',', $bannedids);
			$wherearr[] = 't.bid NOT IN ('.implode("','", $banids)."')";
			
		}
		if ($showfilter==1) {
		
			$wherearr[] = 't.istop = 1';
			
		} elseif ($showfilter==2) {
		
			$wherearr[] = 't.isrecommend = 1';
			
		}	
		if ($groupid>0) {
		
			$wherearr[] = 't.groupid = '.$groupid;
			
		}
		$where = !empty($wherearr) ? 'WHERE '.implode(' AND ', $wherearr) : '';
		$itemsnum= $items==0 ? '':" LIMIT $start,$items";
		foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_forblock($where, $orderby, $ordersc, $itemsnum) as $value) {	
			
			$value['icq'] = '';
			if ($ismultiple==1&&$value['allowmultiple']==1) {
				$value['icq'] = getallicq($value[$icq]);
				$value['tel'] = getfirsticq($value['tel']);
				$value['qq'] = getfirsticq($value['qq']);
				$value['msn'] = getfirsticq($value['msn']);
				$value['wangwang'] = getfirsticq($value['wangwang']);
				$value['baiduhi'] = getfirsticq($value['baiduhi']);
				$value['skype'] = getfirsticq($value['skype']);	
				$value[$icq] = empty($value[$icq]) ? '' : str_replace('{icqnumber}',getfirsticq($value[$icq]), $icqshow);
			} else {
				$value['qq'] = empty($value['qq']) ? srlang('zanwustr') : str_replace('{icqnumber}',getfirsticq($value['qq']), $icqshow);
				$value['tel'] = getfirsticq($value['tel']);
			}	
			$datalist[] = array(
				'id' => $value['bid'],
				'idtype' => 'brandid',				
				'title' => $value['name'], 
				'url' => getburl_by_bid($value[bid]),
				'pic' => 'category/'.$value['poster'],
				'picflag' => 1,
				'summary' => '',
				'fields' => array(
					'brandname' => $value['name'],
					'bid' => $value['bid'],
					'recommendimg' => $_G['siteurl'].$value['recommendimg']	,
					'views' => $value['views'],
					'qq' => $value['qq'],
					'msn' => $value['msn'],
					'wangwang' => $value['wangwang'],
					'baiduhi' => $value['baiduhi'],
					'skype' => $value['skype'], 
					'icq' => $value['icq'], 
					'address' => $value['address'],
					'tel' => $value['tel'], 
					'weburl' => $value['weburl'], 
					'cateid' => $value['cateid'],
					'catename' => $value['catename'], 
					'brandno' => $value['brandno'],
					'region' => $isselfdistrict==1 ? "$value[birthcity] - $value[birthdist]" : "$value[srbirthprovince] - $value[srbirthcity]",
					'brandmf' => $value['brandmf'],
					'brandtag' => $value['brandtag'],
					'weixin' => $value['weixin'],
					'weixinimg' => $value['weixinimg'],
					'weixinpublic' => $value['weixinpublic'],
					'weixinpublicpic' => $value['weixinpublicpic'],
					'iscard' => $value['iscard'] ? '<img src="source/plugin/sanree_brand/tpl/good/images/cardico.jpg"/>' : '',
				)
			);
			
		}
		return array('html' => '', 'data' => $datalist);
	}
}
//From:www_YMG6_COM
?>