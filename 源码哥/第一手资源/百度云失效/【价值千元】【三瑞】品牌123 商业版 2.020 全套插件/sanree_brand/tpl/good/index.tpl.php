<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{eval $_G['disabledwidthauto']=TRUE;}-->
{subtemplate common/header}
<link rel="stylesheet" type="text/css" id="sanree_brand" href="{SANREE_BRAND_TEMPLATE}/sanree_brand.css?{VERHASH}" />
<!--{if ($tel114version >=1121) }-->
<link rel="stylesheet" type="text/css" id="sanree_tel114" href="source/plugin/sanree_tel114/style/tel.css?{VERHASH}" />
<!--{/if}-->
<script language="javascript" src="{sr_brand_JS}/swfobject.js"></script>
<script language="javascript" src="{sr_brand_JS}/sanree_brand.js"></script>
<div class="sanree_brand_indexbody" id="brand">
  <!--{hook/sanree_brand_index_toper}-->
  <div id="pt" class="bm cl">
    <div class="z"> <a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a><em>&raquo;</em><a href="{$allurl}">{$maintitle}</a>$navigation </div>
  </div>
  <!--{hook/sanree_brand_index_header}-->
<style id="diy_style" type="text/css"></style>
<div class="wp">
	<!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->
</div>   
  <div class="brandslogan">
      <div class="sloganleft">
	     <div class="flashad">
			<div id="sanreecontainer">
			<a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this rotator.</div>
			<script type="text/javascript">
			var s1 = new SWFObject("{sr_brand_IMG}/imagerotator.swf","rotator","731","125","7");
				s1.addParam('wmode',"transparent");
				s1.addVariable("file","{$flashadurl}");
				s1.addVariable("transition","fade");
				s1.addVariable("overstretch","false");
				s1.addVariable('shownavigation','true');
				s1.addVariable("width","731");
				s1.addVariable("height","125");
				s1.addVariable("linkfromdisplay","true");
				s1.addVariable("overstretch","false");
				s1.write("sanreecontainer");
			</script>  
		 </div>
	  </div>
	  <div class="sloganright">
	     <div class="userbar">
		     <div class="total">{lang sanree_brand:statistics}<span>{$allcount}</span></div>
			 <div class="addbutton"><a href="plugin.php?id=sanree_brand&mod=published" id="publisheddlg" onclick="showWindow(this.id, this.href, 'get', 1)"></a></div>
			 <div class="managebtn"><a href="plugin.php?id=sanree_brand&mod=mybrand"></a></div>
		 </div>
	  </div>
  </div>
  <!--{hook/sanree_brand_index_middle}-->
  <!--[diy=diy2]--><div id="diy2" class="area"></div><!--[/diy]-->
  <div class="mainbar">
    <div class="mainleft">
	  <!--{hook/sanree_brand_index_left_top}-->
      <div class="brandsort">
        <div class="hd">
          <H1>{lang sanree_brand:brandcate}</H1>
        </div>
        <div class="bd">
            <ul class="sanree_brand_catedata">
              <!--{loop $category_list $cate}-->
              <li{$cate[class]}><A href="{$cate[url]}">{$cate[name]}</A></li>
              <!--{/loop}-->
            </ul>
        </div>
      </div>
	  <!-- /brandsort -->
      <div class="stepto">
      </div>
	  <!-- /stepto -->	
      <div class="service">
        <div class="hd">
          <H1>{lang sanree_brand:servicecenter}</H1>
        </div>
        <div class="bd">
		<ul>
		<li class="sanreetel">{$admintel}</li>
		<li class="qq">{$adminqq}</li>
		<li class="sanreetime">{lang sanree_brand:servicetime}<br />{$admintime}</li>
		</ul>
        </div>
      </div>
	  <!-- /service -->
	  <!--[diy=diy3]--><div id="diy3" class="area"></div><!--[/diy]-->
	  <!--{hook/sanree_brand_index_left_bottom}-->	
	  <!--{if $copyrightshow}-->
      <div class="copyright">
        <div class="hd">
          <h1>{lang sanree_brand:copyright}</h1>
        </div>
        <div class="bd">
		<ul>
		<li class="softname">{lang sanree_brand:brand123}</li>
		<li class="ver">V {$pluginversion} For X2,X2.5!</li>
		<li class="sanree">&copy;<a href="http://www.fx8.cc/" target="_blank">Sanree.com</a></li>
		</ul>
        </div>
      </div>
	  <!-- /service -->	
	  <!--{else}-->
	    <!-- Copyright Sanree.com  {$pluginversion} -->
	 <!--{/if}-->	      
    </div>
    <!-- /left-->
    <div class="mainright"> 
	   <!--{hook/sanree_brand_index_right_top}-->
	   <!--[diy=diy4]--><div id="diy4" class="area"></div><!--[/diy]-->
	<form method="post" action="{$allurl}">
	   <div class="location">
		<div class="sanree_brand_searchbar">
		<input align="absmiddle" type="text" class="mykeyword" onclick="setthis(this)" name="keyword" value="{$defaultkeyword}" /><input align="absmiddle" type="image" border="0" src="{sr_brand_IMG}/searbtn.jpg" />
		</div>
	    <h1>{$location}</h1>
	   </div>
	   </form>
      <div class="recommendbrand">
        <div class="hd">
		  <div class="adc"><a href="{$adminadurl}" target="_blank">{lang sanree_brand:adminadurl}</a></div>
          <H1>{lang sanree_brand:recommend_brand}</H1>
        </div>
        <div class="bd">
			<ul class="recommendlist">
				<!--{loop $recommendlist $cate}-->
				<li>
				<div class="rimg"><a href="{$cate[url]}" rel="nofollow" target='_blank' title="{$cate[name]}">{$cate[img]}</A></div>
				<p><a href="{$cate[url]}" rel="nofollow" target='_blank' title="{$cate[name]}">{$cate[name]}</A></p></li>
				<!--{/loop}-->
			</ul>			
        </div>
      </div>
	  <!-- /recommendbrand -->	
	  <!--[diy=diy5]--><div id="diy5" class="area"></div><!--[/diy]-->
	   <div class="indexad"><a href="{$adlink}" target="_blank"><img src="{$adimage}" /></a></div>	
	   <div class="district">  
	   <div class="hd"> <h1>{$districtnavigation}</h1></div> 
	  <!--{loop $districtcategory_list $mlist}-->  
	   <div class="dsubcate{$mlist[class]}">
            <ul id="dshow{$mlist[id]}">
			  <li{$mlist[pidclass]}><A href="{$mlist[pidurl]}">[{$mlist[allname]}]</A></li>
              <!--{loop $mlist[data] $cate}-->
			  <li class="fg">|</li>
              <li{$cate[class]}><A href="{$cate[url]}">{$cate[name]}</A></li>
              <!--{/loop}-->
            </ul>
			<div class="dm"><a onclick="showit({$mlist[id]})"><em id="onbtn{$mlist[id]}"></em></a><a onclick="showit({$mlist[id]})"><i id="offbtn{$mlist[id]}"></i></a></div>
	   </div>
      <!--{/loop}-->
	  </div>
	   <div class="subcate">
            <ul>
			  <li{$pidclass}><A href="{$pidurl}">{lang sanree_brand:notlimited}</A></li>
              <!--{loop $subcategory_list $cate}-->
			  <li class="fg">|</li>
              <li{$cate[class]}><A href="{$cate[url]}">{$cate[name]}({$cate[count]})</A></li>
              <!--{/loop}-->
            </ul>
	   </div>
	   <!--[diy=diy6]--><div id="diy6" class="area"></div><!--[/diy]-->	   
	   <div class="orderby">
	   <div class="listmode"><a href="{$bigurl}" class="noline"><img src="{sr_brand_IMG}/big{$slistmode}.gif" alt="{lang sanree_brand:bigmode}" width="16" height="16" /></a>&nbsp;&nbsp;<a href="{$smallurl}" class="noline"><img src="{sr_brand_IMG}/small{$slistmode}.gif" alt="{lang sanree_brand:smallmode}" width="16" height="16" /></a>
	   </div>
	   <SPAN><SPAN class="oders">{lang sanree_brand:oders}</SPAN> <A href="{$orderurl1}"><SPAN class="{$orderclass[ordertime]}">{lang sanree_brand:orderdefault}</SPAN></A><SPAN class="{$orderclass[orderview]}" ><A href="{$orderurl2}">{lang sanree_brand:ordertime}</A></SPAN> <SPAN class="{$orderclass[orderrecommend]}"><A href="{$orderurl3}">{lang sanree_brand:orderrecommend}</A></SPAN> <SPAN class="{$orderclass[orderdiscount]}"><A href="{$orderurl4}">{lang sanree_brand:orderdiscount}</A></SPAN> <SPAN class="{$orderclass[orderclick]}"><A href="{$orderurl5}">{lang sanree_brand:orderclick}</A></SPAN></SPAN></div>
			<div class="businesslist{$slistmode}">
			<!--{if $fbusinesses_list}-->	   
			<ul id="onedata">			
			<!--{loop $fbusinesses_list $cate}-->
			<li{$cate[class]} onmousemove="onmousemovet(this)" onmouseout= "onmouseoutt(this)">
			    <!--{if $listmode==1}-->
					<EM></EM>
					<div class="businessshow">
					  <div class="bname">{$cate[tel114url]}<h1><a href="{$cate[turl]}" target="_blank">{$cate[name]}</a></h1></div>
					  <div class="blogo">
						 <div class="image"><a href="{$cate[turl]}" target="_blank"><img src="{$cate[poster]}" alt="{$cate[name]}" /></a></div>
						 <div class="recommendationindex">
							 {lang sanree_brand:recommendationindex}
							 <p>{$cate[recommendationindex]}%</p>
						 </div>
						 <div class="minfo">
						 <div class="catename"> 
						{lang sanree_brand:cateh}<a href="{$cate[cateurl]}"><span>{$cate[catename]}</span></a>
					     </div>
						 <div class="brandqq"> <span class="branddiscount">{lang sanree_brand:pub_discount}<span class="discount">{$cate['discount']}</span></span>
						 <!--{if $ismultiple==1&&$cate[allowmultiple]==1}-->
						 <!--{if $icq=='msn'}-->{lang sanree_brand:brandmsn}<span>{$cate[icq]}</span><!--{elseif $icq=='wangwang'}-->{lang sanree_brand:brandwangwang}<span>{$cate[icq]}</span><!--{elseif $icq=='baiduhi'}-->{lang sanree_brand:brandbaiduhi}<span>{$cate[icq]}</span><!--{elseif $icq=='skype'}-->{lang sanree_brand:brandskype}<span>{$cate[icq]}</span><!--{else}-->{lang sanree_brand:brandqq}<span>{$cate[icq]}</span><!--{/if}-->
						 <!--{else}-->
						 {lang sanree_brand:oqq}<span>{$cate[qq]}</span>
						 <!--{/if}-->
						 </div>
						 <div class="brandview">{lang sanree_brand:brandview}<span>{$cate[forum_thread][views]}</span></div>
						 <div class="brandgroup">{lang sanree_brand:brandgroup}<span><img src="{$cate[groupimg]}" /></span></div>
						 <div class="brandaddress">{lang sanree_brand:brandaddress}<span title="{$cate[address]}">{$cate[address]}</span></div>
						 </div>
						<!--{if $cate[tel]}--> <div class="brandtel">{$cate[tel]}</div><!--{else}--><div class="nonebrandtel"></div><!--{/if}-->
					  </div>					 
					</div>
				<!--{else}-->
					<EM></EM>
					<div class="businessshow">
					  <div class="bname">{$cate[tel114url]}<h1><a href="{$cate[turl]}" target="_blank">{$cate[name]}</a></h1></div>
					  <div class="blogo">
						 <div class="image"><a href="{$cate[turl]}" target="_blank"><img src="{$cate[poster]}" alt="{$cate[name]}" /></a></div>
						 <div class="recommendationindex">
							 {lang sanree_brand:recommendationindex}
							 <p>{$cate[recommendationindex]}%</p>
						 </div>
					  </div>
					 <div class="catename"> 
						{lang sanree_brand:cateh}<a href="{$cate[cateurl]}"><span>{$cate[catename]}</span></a> 
					 </div>
					 <div class="branddiscount">{lang sanree_brand:pub_discount}<span class="discount">{$cate['discount']}</span> <img align="absmiddle" src="{sr_brand_IMG}/zhe.gif" /></div>
					 <div class="brandqq">
					 <!--{if $ismultiple==1&&$cate[allowmultiple]==1}-->
					     <!--{if $icq=='msn'}-->{lang sanree_brand:brandmsn}<span>{$cate[icq]}</span><!--{elseif $icq=='wangwang'}-->{lang sanree_brand:brandwangwang}<span>{$cate[icq]}</span><!--{elseif $icq=='baiduhi'}-->{lang sanree_brand:brandbaiduhi}<span>{$cate[icq]}</span><!--{elseif $icq=='skype'}-->{lang sanree_brand:brandskype}<span>{$cate[icq]}</span><!--{else}-->{lang sanree_brand:brandqq}<span>{$cate[icq]}</span><!--{/if}-->
                     <!--{else}-->
					 {lang sanree_brand:oqq}<span>{$cate[qq]}</span>
					 <!--{/if}-->						 
					 </div>
					 <div class="brandview">{lang sanree_brand:brandview}<span>{$cate[forum_thread][views]}</span></div>
					 <div class="brandgroup">{lang sanree_brand:brandgroup}<span><img src="{$cate[groupimg]}" /></span></div>
					 <div class="brandaddress">{lang sanree_brand:brandaddress}<span title="{$cate[address]}">{$cate[address]}</span></div>
					 <div class="brandtel">{$cate[tel]}</div>
					</div>				
				<!--{/if}-->
			</li>				  
			<!--{/loop}-->	
			</ul>
			<div class="pager">{$multi}</div>
			<!--{else}-->
			{lang sanree_brand:nobusinesses}
			<!--{/if}-->
			</div>
			<!--[diy=diy7]--><div id="diy7" class="area"></div><!--[/diy]-->
			<!--{hook/sanree_brand_index_right_bottom}-->
	</div>
    <div class="clear"></div>
  </div>
</div>
<!--[diy=diy8]--><div id="diy8" class="area"></div><!--[/diy]-->
<!--{hook/sanree_brand_index_footer}-->
<!--{if $mapapi=='baidu'}--><script type="text/javascript" src="http://api.map.baidu.com/api?v=1.2"></script><script type="text/javascript" src="http://api.map.baidu.com/library/CityList/1.2/src/CityList_min.js"></script><!--{/if}-->
<!--{if $mapapi=='google'}--><script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script><!--{/if}-->
{subtemplate common/footer}