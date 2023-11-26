<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{eval $_G['disabledwidthauto']=TRUE;}-->
<!--{eval $picload='src';}-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={CHARSET}" />
<!--{if $_G['config']['output']['iecompatible']}-->
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE{$_G['config']['output']['iecompatible']}" />
<!--{/if}-->
<title><!--{if !empty($navtitle)}-->$navtitle -<!--{/if}--><!--{if empty($nobbname)}-->$_G['setting']['bbname'] -<!--{/if}-->Powered by Ô´Âë¸ç!</title>
$_G['setting']['seohead']
<meta name="keywords" content="{if !empty($metakeywords)}{echo dhtmlspecialchars($metakeywords)}{/if}" />
<meta name="description" content="{if !empty($metadescription)}{echo dhtmlspecialchars($metadescription)} {/if}{if empty($nobbname)},$_G['setting']['bbname']{/if}" />
<meta name="generator" content="Discuz! $_G['setting']['version']" />
<meta name="author" content="Discuz! Team and Comsenz UI Team" />
<meta name="copyright" content="2001-2012 Comsenz Inc." />
<meta name="MSSmartTagsPreventParsing" content="True" />
<meta http-equiv="MSThemeCompatible" content="Yes" />
<base href="{$_G['siteurl']}" />
<meta name="application-name" content="$_G['setting']['bbname']" />
<meta name="msapplication-tooltip" content="$_G['setting']['bbname']" />
<script language="javascript">
	<!--{if $isslideload==1}-->
	var sr_loadimg = true;
	<!--{else}-->
	var sr_loadimg = false;
	<!--{/if}-->
	</script>
<script language="javascript">
	var isbigslide=false;
	function showTopLink(){}
	</script>
</head>
<body>
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div id="hd"></div>
<link rel="stylesheet" type="text/css" href="{SANREE_BRAND_TEMPLATE}/sanree_brand.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="{SANREE_BRAND_TEMPLATE}/springfestival/style.css?{VERHASH}" />
<script src="{SANREE_BRAND_TEMPLATE}/springfestival/js/jquery-1.4.2.min.js" type="text/javascript"></script> 
<script src="{SANREE_BRAND_TEMPLATE}/springfestival/js/tab.js" type="text/javascript"></script> 
<script src="{SANREE_BRAND_TEMPLATE}/springfestival/js/hello.js" type="text/javascript"></script>
<div class="headerbox">
  <div class="header">
    <div class="logo"><a href="/" title="$navtitle - $_G['setting']['bbname']"></a></div>
    <div class="menubox">
      <div class="sc_index"> 
        <!--{if !$_G['uid']}--><a href="member.php?mod=logging&action=login">{lang login}</a> 
        <!--{else}--><a>{$_G['username']}</a><!--{/if}-->&nbsp;&nbsp;&nbsp;&nbsp; 
        <!--{if !$_G['uid']}--><a href="member.php?mod=register">$_G['setting']['reglinkname']</a> 
        <!--{else}--><a href="member.php?mod=logging&action=logout&formhash={FORMHASH}">{lang logout}</a><!--{/if}-->&nbsp;&nbsp;&nbsp;&nbsp; <a onClick="SetHome(window.location)" href="javascript:void(0)">{lang sanree_brand:sethome}</a>&nbsp;&nbsp;&nbsp;&nbsp; <a onClick="AddFavorite(window.location,document.title)" href="javascript:void(0)">{lang sanree_brand:favorite}</a></div>
    </div>
    <!-- /menubox --> 
  </div>
  <!-- /header --> 
</div>
<!-- /headerbox -->
<div class="topnav">
  <div class="topmenu">
    <ul>
      <li><a href="/" class="index">{lang sanree_brand:frontpage}</a></li>
      <li><a href="forum.php">{lang sanree_brand:forum}</a></li>
      <li><a href="{$allurl}">{lang sanree_brand:brand}</a></li>
      <!--{if $new_goodslist}-->
      <li><a href="{$modurl_goods}">{lang sanree_brand:h_goods}</a></li>
      <!--{/if}--> 
      <!--{if $new_newslist}-->
      <li><a href="{$modurl_news}">{lang sanree_brand:h_news}</a></li>
      <!--{/if}--> 
      <!--{if $new_couponlist}-->
      <li><a href="{$modurl_coupon}">{lang sanree_brand:h_coupon}</a></li>
      <!--{/if}-->
    </ul>
  </div>
  <!-- /topmenu --> 
</div>
<!-- /topnav -->

<div class="bannerbox">
  <div class="banner">
    <div class="joinus">
      <div class="join"><a href="plugin.php?id=sanree_brand&mod=published" id="publisheddlg"><img src="{SANREE_BRAND_TEMPLATE}/springfestival/images/joinus.png" /></a></div>
      <div class="manager"><a href="plugin.php?id=sanree_brand&mod=mybrand"><img src="{SANREE_BRAND_TEMPLATE}/springfestival/images/bmanager.png" /></a></div>
      <div class="stat">{lang sanree_brand:totalstr1}<span class="c">{$allcount}</span>{lang sanree_brand:totalstr2}</div>
    </div>
    <!-- /joinus --> 
  </div>
  <!-- /banner -->
  <div class="jzbg"></div>
  <!-- /dlbox --> 
</div>
<!-- /bannerbox -->
<div class="clear"></div>
<!--{hook/sanree_brand_index_toper}-->
<div class="clear"></div>
<!--{hook/sanree_brand_index_header}-->
<div class="clear"></div>
<div class="tablists">
  <div class="tabbox" id="statetab">
    <ul class="tabbtn">
      <li class="current"><a>{lang sanree_brand:h_businesses}</a></li>
      <!--{if $re_goodslist}-->
      <li><a href="{$modurl_goods}" target="_blank">{lang sanree_brand:h_goods}</a></li>
      <!--{/if}--> 
      <!--{if $re_newslist}-->
      <li><a href="{$modurl_news}" target="_blank">{lang sanree_brand:h_news}</a></li>
      <!--{/if}--> 
      <!--{if $re_couponlist}-->
      <li><a href="{$modurl_coupon}" target="_blank">{lang sanree_brand:h_coupon}</a></li>
      <!--{/if}-->
    </ul>
    <!-- /tabbtn -->
    <div class="prompt"><a href="{$adminadurl}" target="_blank">!?{lang sanree_brand:adminadurl}</a></div>
    <div class="tabcon" style="display: block;">
      <div class="merchants">
        <ul>
          <!--{loop $recommendlist $cate}-->
          <li> <a href="{$cate[url]}" target="_blank" title="{$cate[name]}">
            <div class="bimg" style="width:180;height:135;">{$cate[img]}</div>
            <div class="titleurl">{$cate[name]}</div>
            </a> </li>
          <!--{/loop}-->
        </ul>
      </div>
    </div>
    <!-- /tabcon--> 
    <!--{if $re_goodslist}-->
    <div class="tabcon" style="display: none;">
      <div class="goods">
        <ul>
          <!--{loop $re_goodslist $cate}-->
          <li> <a href="{$cate[url]}" target="_blank" title="{$cate[name]}">
            <div class="gimg"><img src="{$cate[pic]}"  width="180px" height="135px"/></div>
            <div class="gurl">{lang sanree_brand:sminprice}{$cate[sminprice]}</div>
            </a> </li>
          <!--{/loop}-->
        </ul>
      </div>
      <!-- /goods --> 
    </div>
    <!-- /tabcon --> 
    <!--{/if}-->
    <div class="tabcon" style="display: none;">
      <div class="index_news">
        <div class="l_news">
          <div class="news_list">
            <div class="news_one"><a href="{$re_news_textlist[0][url]}" target="_blank" title="{$re_news_textlist[0][name]}">{$re_news_textlist[0][name]}</a></div>
            <ul>
              <!--{loop $re_news_textlist1 $cate}-->
              <li><a href="{$cate[url]}" target="_blank" title="{$cate[name]}">{$cate[name]}</a></li>
              <!--{/loop}-->
            </ul>
          </div>
          <!-- /news_list -->
          <div class="img_news"> <a href="{$re_news_imglist[0][url]}" target="_blank" title="{$re_news_imglist[0][name]}">
            <div class="limg"><img width="80" height="60" src="{$re_news_imglist[0][pic]}" /></div>
            <div class="rtitle">{$re_news_imglist[0][name]}</div>
            </a>
            <div class="clear lineboth"></div>
            <a href="{$re_news_imglist[1][url]}" target="_blank" title="{$re_news_imglist[1][name]}">
            <div class="limg"><img width="80" height="60" src="{$re_news_imglist[1][pic]}" /></div>
            <div class="rtitle">{$re_news_imglist[1][name]}</div>
            </a> </div>
          <!-- /img_news --> 
        </div>
        <!-- /l_news -->
        <div class="r_news">
          <div class="news_list">
            <div class="news_one"><a href="{$re_news_textlist[1][url]}" target="_blank" title="{$re_news_textlist[1][name]}">{$re_news_textlist[1][name]}</a></div>
            <ul>
              <!--{loop $re_news_textlist2 $cate}-->
              <li><a href="{$cate[url]}" target="_blank" title="{$cate[name]}">{$cate[name]}</a></li>
              <!--{/loop}-->
            </ul>
          </div>
          <!-- /news_list -->
          <div class="img_news"> <a href="{$re_news_imglist[2][url]}" target="_blank" title="{$re_news_imglist[2][name]}">
            <div class="limg"><img width="80" height="60" src="{$re_news_imglist[2][pic]}" /></div>
            <div class="rtitle">{$re_news_imglist[2][name]}</div>
            </a>
            <div class="clear lineboth"></div>
            <a href="{$re_news_imglist[3][url]}" target="_blank" title="{$re_news_imglist[3][name]}">
            <div class="limg"><img width="80" height="60" src="{$re_news_imglist[3][pic]}" /></div>
            <div class="rtitle">{$re_news_imglist[3][name]}</div>
            </a> </div>
          <!-- /news_list --> 
        </div>
        <!-- /r_news --> 
      </div>
      <!-- /index_news --> 
    </div>
    <!-- /tabcon --> 
    <!--{if $re_couponlist}-->
    <div class="tabcon" style="display: none;">
      <div class="coupons">
        <ul>
          <!--{loop $re_couponlist $cate}-->
          <li> <a href="{$cate[url]}" target="_blank" title="{$cate[name]}">
            <div class="cimg"><img width="180px" height="135px" src="{$cate[pic]}" /></div>
            <div class="curl">{lang sanree_brand:cminprice}{$cate[sminprice]}</div>
            </a> </li>
          <!--{/loop}-->
        </ul>
      </div>
      <!-- /coupons --> 
    </div>
    <!-- /tabcon --> 
    <!--{/if}--> 
  </div>
  <!-- /tabbox --> 
</div>
<!-- /tablist -->

<div class="clear"></div>
<div class="sr_wrapper"> 
  <!--{hook/sanree_brand_index_middle}-->
  <div class="s_type">
    <div class="typecon">
      <div class="search">
        <form class="s_form" method="post" action="{$allurl}">
          <label class="s_text"><img src="{SANREE_BRAND_TEMPLATE}/springfestival/images/sou.png"/></label>
          <input type="text" name="keyword" id="" class="input_text" value="{$defaultkeyword}" onClick="setthis(this)" onfocus="if(value=='{$defaultkeyword}') {value=''}" onblur="if (value=='') {value='{$defaultkeyword}'}">
          <input type="image" class="input_button" border="0"  src="{SANREE_BRAND_TEMPLATE}/springfestival/images/searchbtn.png" />
        </form>
      </div>
      <!-- /search -->
      <div class="type_more">
        <div class="typelist">
          <div class="industry">
            <div class="type_title">{lang sanree_brand:tpl_category}</div>
            <div class="slist">
              <ul>
                <!--{loop $category_list $cate}--> 
                <li{$cate[class]}><a href="{$cate[url]}" >{$cate[name]}</a>
                </li>
                <!--{/loop}-->
              </ul>
              <!--{if $subcategory_list}-->
              <ul class="subcate">
                <li{$categoryclass->_subdata[class]}><a href="{$categoryclass->_subdata[url]}">{$categoryclass->_subdata[name]}</a>
                </li>
                <!--{loop $subcategory_list $cate}--> 
                <li{$cate[class]}><a href="{$cate[url]}">{$cate[name]}</a>
                </li>
                <!--{/loop}-->
              </ul>
              <!--{/if}--> 
            </div>
            <!-- /slist --> 
          </div>
          <!-- /industry -->
          <div class="clear"></div>
          <!--{if $districtcategory_list}-->
          <div class="area">
            <div class="type_title">{lang sanree_brand:tpl_district}</div>
            <div class="slist"> 
              <!--{loop $districtcategory_list $mlist}-->
              <div class="dsubcate{$mlist[class]}">
                <ul>
                  <li{$mlist[pidclass]}><a href="{$mlist[pidurl]}">{$mlist[allname]}</a>
                  </li>
                  <!--{loop $mlist[data] $cate}--> 
                  <li{$cate[class]}><a href="{$cate[url]}">{$cate[name]}</a>
                  </li>
                  <!--{/loop}-->
                </ul>
                <div class="dm"><a onClick="showit({$mlist[id]})"><em id="onbtn{$mlist[id]}"></em></a><a onClick="showit({$mlist[id]})"><i id="offbtn{$mlist[id]}"></i></a></div>
              </div>
              <!--{/loop}--> 
            </div>
            <!-- /slist --> 
          </div>
          <!-- /area --> 
          <!--{/if}--> 
        </div>
        <!-- /typelist --> 
      </div>
      <!-- /type_more --> 
    </div>
  </div>
  <!-- /s_type -->
  <div class="clear"></div>
  <div class="indexmainbody" id="indexmainbody">
    <div class="bodyleft"> 
      <!--{hook/sanree_brand_index_left_top}-->
      <div class="option" id="option">
        <ul class="sort">
          <li class="{$orderclass[ordertime]}"><a href="{$orderurl1}">{lang sanree_brand:orderdefault}</a></li>
          <li class="{$orderclass[orderview]}"><a href="{$orderurl2}">{lang sanree_brand:ordertime}</a></li>
          <li class="{$orderclass[orderrecommend]}"><a href="{$orderurl3}">{lang sanree_brand:orderrecommend}</a></li>
          <li class="{$orderclass[orderdiscount]}"><a href="{$orderurl4}">{lang sanree_brand:orderdiscount}</a></li>
          <li class="{$orderclass[orderclick]}"><a href="{$orderurl5}">{lang sanree_brand:orderclick}</a></li>
          <li class="{$orderclass[orderexponent]}"><a href="{$orderurl6}">{lang sanree_brand:orderexponent}</a></li>
        </ul>
        <!-- /sort -->
        <ul class="listmode">
          <li><a href="{$bigurl}" title="{lang sanree_brand:bigmode}"><img src="{SANREE_BRAND_TEMPLATE}/springfestival/images/list_1.png"alt="{lang sanree_brand:bigmode}" /> </a></li>
          <li><a href="{$middleurl}" title="{lang sanree_brand:middlemode}"><img src="{SANREE_BRAND_TEMPLATE}/springfestival/images/list_2.png" alt="{lang sanree_brand:middlemode}" /></a></li>
          <li><a href="{$smallurl}" title="{lang sanree_brand:smallmode}"><img src="{SANREE_BRAND_TEMPLATE}/springfestival/images/list_3.png" alt="{lang sanree_brand:smallmode}"/></a></li>
        </ul>
        <!-- /listmode --> 
      </div>
      <!-- /option -->
      <div class="businesslist{$classindex}"> 
        <!--{if $fbusinesses_list}-->
        <ul class="items" id="branditem">
          <!--{loop $fbusinesses_list $cate}--> 
          <li{$cate[class]}> 
          <!--{if $listmode==1}-->
          <div class="itemlogo"><em></em><a href="{$cate[turl]}" title="{$cate[name]}" target="_blank"><img class="brlogo" {$picload}="{$cate[poster]}" alt="{$cate[name]}" /></a> </div>
          <div class="exponent"><span class="eavl_ft22">{$cate[recommendarr][0]}.</span><span class="eavl_ft14">{$cate[recommendarr][1]}</span>&nbsp;% </div>
          <div class="businesinfobar">
            <h1 class="sbusinesname"><a href="{$cate[turl]}" title="{$cate[name]}" target="_blank">{$cate[name]}</a></h1>
            <div class="stele">{lang sanree_brand:otelphone}{$cate[tel]}</div>
            <div class="saddress">{lang sanree_brand:oaddress}{$cate[address]}</div>
            <div class="operate"> <a><img src="{$cate['groupsmallicons']}" /></a> {$cate[tel114url]} 
              <!--{if $cate['sdiscount']>0}--> 
              <img src="{sr_brand_IMG}/discountico.jpg" /> 
              <!--{/if}--> 
              <!--{if $cate['iscard']==1}--> 
              <img src="{sr_brand_IMG}/cardico.jpg" /> 
              <!--{/if}--> 
              <!--{if $cate['pbid']>0}--> 
              <img src="{sr_brand_IMG}/fenico.jpg" /> 
              <!--{/if}--> 
            </div>
            <!-- /operate --> 
          </div>
          <!--{elseif $listmode==3}-->
          <div class="itemlogo"> <em></em> <a href="{$cate[turl]}" title="{$cate[name]}" target="_blank"><img class="brlogo" {$picload}="{$cate[poster]}" alt="{$cate[name]}" /></a> </div>
          <div class="businesinfobar">
            <div class="iteminfo">
              <div class="sbusinesname"><a href="{$cate[turl]}" title="{$cate[name]}" target="_blank">{$cate[name]}</a></div>
              <div class="stele">{lang sanree_brand:otelphone}
                <label title="{$cate[tel]}">{$cate[tel]}</label>
              </div>
            </div>
            <div class="operate">
              <div class="nstart"><span class="eavl_ft16">{$cate[voter]}.</span><span class="eavl_ft9">{$cate['voter2']}</span>&nbsp;{lang sanree_brand:fen}</div>
              <a><img src="{$cate['groupsmallicons']}" /></a> {$cate[tel114url]} 
              <!--{if $cate['sdiscount']>0}--> 
              <img src="{sr_brand_IMG}/discountico.jpg" /> 
              <!--{/if}--> 
              <!--{if $cate['iscard']==1}--> 
              <img src="{sr_brand_IMG}/cardico.jpg" /> 
              <!--{/if}--> 
              <!--{if $cate['pbid']>0}--> 
              <img src="{sr_brand_IMG}/fenico.jpg" /> 
              <!--{/if}--> 
            </div>
            <!-- /operate --> 
          </div>
          <!-- /businesinfobar --> 
          <!--{else}-->
          <div class="onedata1" onMouseMove="onmousemove_hello(this)" onMouseOut="onmouseout_hello(this)">
            <div class="businestop"> <em></em> <a href="{$cate[turl]}" title="{$cate[name]}" target="_blank"><img class="brlogo" {$picload}="{$cate[poster]}" alt="{$cate[name]}" /></a> </div>
            <div class="businesinfobar">
              <div class="bfilterdiv"></div>
              <div class="bfshow">
                <div class="sbusinesname"><a href="{$cate[turl]}" title="{$cate[name]}" target="_blank">{$cate[name]}</a></div>
                <div class="operate">
                  <div class="nstart">
                    <div class="okstar wt{$cate['voter']}"></div>
                  </div>
                  <a><img src="{$cate['groupsmallicons']}" /></a> {$cate[tel114url]} 
                  <!--{if $cate['sdiscount']>0}--> 
                  <img src="{sr_brand_IMG}/discountico.jpg" /> 
                  <!--{/if}--> 
                  <!--{if $cate['iscard']==1}--> 
                  <img src="{sr_brand_IMG}/cardico.jpg" /> 
                  <!--{/if}--> 
                  <!--{if $cate['pbid']>0}--> 
                  <img src="{sr_brand_IMG}/fenico.jpg" /> 
                  <!--{/if}--> 
                </div>
                <!-- /operate --> 
              </div>
            </div>
          </div>
          <!-- /onedata1 --> 
          <!--{/if}-->
          </li>
          <!--{/loop}-->
        </ul>
        <!-- /items -->
        <div class="clear"></div>
        <div class="bigPage vm center" id="xp3">{$multi}</div>
        <!--{else}-->
        <div class="nobusinesses">{lang sanree_brand:nobusinesses}</div>
        <!--{/if}--> 
      </div>
      <!-- /businesslist --> 
      <!--{hook/sanree_brand_index_left_bottom}--> 
    </div>
    <!-- /bodyleft -->
    
    <div class="sidebar"> 
      <!--{hook/sanree_brand_index_right_top}-->
      <div class="sidebar_title">
        <div class="h2title">{lang sanree_brand:h_newpub}</div>
        <div class="entitle">NEW JOIN</div>
      </div>
      <!-- /sidebar_title -->
      <div class="joinsidebar">
        <ul>
          <!--{loop $newbrandlist $cate}--> 
          <li{$cate[class]}><a href="{$cate[url]}" title="{$cate[name]}">{$cate[name]}</a>
          </li>
          <!--{/loop}-->
        </ul>
      </div>
      <!-- /joinsidebar -->
      <div class="sidebar_title">
        <div class="h2title">{lang sanree_brand:h_hotbrand}</div>
        <div class="entitle_small">POPULAR SELLER</div>
      </div>
      <!-- /sidebar_title -->
      <div class="joinsidebar">
        <ul>
          <!--{loop $hotbrandlist $cate}--> 
          <li{$cate[class]}><a href="{$cate[url]}">{$cate[name]}</a>
          </li>
          <!--{/loop}-->
        </ul>
      </div>
      <!-- /joinsidebar -->
      <div class="adbanner"> <a href="{$helloadlink}" target="_blank"><img src="{$helloadimage}" /></a> </div>
      <!--{if $new_goodslist || $new_newslist || $new_couponlist}-->
      <div class="brand">
        <div class="tabbox" id="brandtab">
          <ul class="tabbtn">
            <!--{if $new_goodslist}-->
            <li><a>{lang sanree_brand:h_goods}</a></li>
            <!--{/if}--> 
            <!--{if $new_newslist}-->
            <li><a>{lang sanree_brand:h_news}</a></li>
            <!--{/if}--> 
            <!--{if $new_couponlist}-->
            <li><a>{lang sanree_brand:h_coupon}</a></li>
            <!--{/if}-->
          </ul>
          <!-- /tabbtn -->
          <div class="tabcon" style="display: block;">
            <div class="commodity">
              <ul>
                <!--{if $new_goodslist}--> 
                <!--{loop $new_goodslist $cate}-->
                <li><a href="{$cate[url]}" target="_blank" title="{$cate[name]}">
                  <div class="com_left"><img width="80px" height="80px" class="goodslogo" {$picload}="{$cate[pic]}" /></div>
                  <div class="com_right">
                    <div class="com_title">{$cate[name]}</div>
                    <div class="old_price">{$cate[sprice]}</div>
                    <div class="new_price">{$cate[sminprice]}</div>
                  </div>
                  </a></li>
                <!--{/loop}--> 
                <!--{/if}-->
              </ul>
            </div>
            <!-- /commodity --> 
          </div>
          <!-- /tabcon -->
          <div class="tabcon" style="display: none;">
            <div class="newsli">
              <ul>
                <!--{if $new_newslist}-->
                <li id="r_news_menu" class="c_list{$tabBody[news]}">
                  <ul>
                    <!--{loop $new_newslist $cate}-->
                    <li>
                      <div class="news_title"><a href="{$cate[url]}" target="_blank" title="{$cate[name]}">{$cate[name]}</a></div>
                    </li>
                    <!--{/loop}-->
                  </ul>
                </li>
                <!--{/if}-->
              </ul>
            </div>
            <!-- /newsli --> 
          </div>
          <!-- /tabcon -->
          <div class="tabcon" style="display: none;">
            <div class="sidebar_coupons">
              <ul>
                <!--{if $new_couponlist}--> 
                <!--{loop $new_couponlist $cate}-->
                <li> <a href="{$cate[url]}" target="_blank" title="{$cate[name]}">
                  <div class="cou_left"><img width="80px" height="80px" {$picload}="{$cate[pic]}" /></div>
                  <div class="cou_right">
                    <div class="cou_title">{$cate[name]}</div>
                    <div class="old_cprice">{$cate[sprice]}</div>
                    <div class="new_cprice">{$cate[sminprice]}</div>
                    <div class="clear"></div>
                    <div class="coupons_time">{$cate[enddate]}</div>
                  </div>
                  </a> 
                  <!--{/loop}--> 
                </li>
                <!--{/if}-->
              </ul>
            </div>
            <!-- /sidebar_coupons --> 
          </div>
          <!-- /tabcon --> 
        </div>
        <!-- /tabbox --> 
      </div>
      <!--{/if}--> 
      <!-- /brand -->
      <div class="clear"></div>
      <div class="sidebar_title">
        <div class="h2title">{lang sanree_brand:servicecenter}</div>
        <div class="entitle">SERVICE</div>
      </div>
      <!-- /sidebar_title -->
      <div class="service">
        <ul>
          <li>{lang sanree_brand:h_admintel}<span class="telphone">{$admintel}</span></li>
          <li><span class="service_qq">{lang sanree_brand:h_adminqq}</span> 
            <script language="javascript">document.write('<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin={$adminqq}&site=qq&menu=yes"><img align="baseline" border="0" src="http://wpa.qq.com/pa?p=2:{$adminqq}:41"></a>');</script></li>
          <li><span class="ntime">{lang sanree_brand:servicetime}</span>{$admintime}</li>
        </ul>
      </div>
      <!-- /service --> 
      <!--{if $copyrightshow}-->
      <div class="copyright">
        <div class="copyright_img">
          <div class="toptext">{lang sanree_brand:copyright}</div>
          <div class="bottomimg"><img src="{SANREE_BRAND_TEMPLATE}/springfestival/images/copyimg.png" /></div>
        </div>
        <!-- /copyright_img -->
        <div class="copytext"> {lang sanree_brand:h_brand123}{lang sanree_brand:h_sanree}
          V&nbsp;&nbsp;{$pluginversion}&nbsp;&nbsp;For&nbsp;&nbsp;X2,&nbsp;X2.5!<br />
          &copy;<a href="http://www.fx8.cc/" target="_blank">Sanree.com</a> </div>
      </div>
      <!--{else}--> 
      <!-- Copyright Sanree.com  {$pluginversion} --> 
      <!--{/if}--> 
      <!-- /copyright --> 
      <!--{hook/sanree_brand_index_right_bottom}--> 
    </div>
    <!-- /sidebar --> 
  </div>
  <!-- /sr_wrapper -->
  <div class="clear"></div>
  
  <!--{if $helpcate}-->
  <div class="helpbar">
    <ul>
      <!--{loop $helpcate $cate}-->
      <li> <dl{$cate[class]}>
        <dt>{$cate[1]}</dt>
        <!--{loop $cate[2] $cateli}-->
        <dd><a href="{$cateli[url]}" target="_blank">{$cateli[title]}</a></dd>
        <!--{/loop}-->
        </dl>
      </li>
      <!--{/loop}-->
    </ul>
  </div>
  <!-- /helpbar --> 
  <!--{/if}--> 
  <!--{hook/sanree_brand_index_footer}--> 
</div>
<div class="clear"></div>
<div class="sr_footer">
  <div class="copyright"></div>
</div>
</body>
</html>