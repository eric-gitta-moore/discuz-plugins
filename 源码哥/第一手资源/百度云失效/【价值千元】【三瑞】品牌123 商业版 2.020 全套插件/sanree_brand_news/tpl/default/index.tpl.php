<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{eval $_G['disabledwidthauto']=TRUE;}-->
{subtemplate common/header}
<link rel="stylesheet" type="text/css" id="sanree_brand_news" href="{sr_brand_news_TPL}sanree_brand_news.css?{VERHASH}" />
<script language="javascript">
	var modeurl = '{$modelurl}';
	var addstr = '<!--{if ($is_rewrite==1)}-->?<!--{else}-->&<!--{/if}-->';
</script>
<script type="text/javascript" src="{sr_brand_news_JS}/jquery-1.4.2.min.js"></script>
<script>jQuery.noConflict();</script>
<script type="text/javascript" src="{sr_brand_news_JS}/sanree_brand_news-1.0.js"></script>
<div class="sanree_brand_news_indexbody">
  <div id="pt" class="bm cl">
    <div class="z"> <a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a><em>&raquo;</em><a href="{$modelurl}">{$maintitle}</a>$navigation </div>
  </div>
  <div class="news_body">
    <div class="news_body_left">
      <div class="lefttop">
        <div class="falshad" id="slide">
          <ul>
            <!--{loop $slidelist $cate}-->
            <li><a href="{$cate[url]}" target="_blank"><img src="{$cate[pic]}" width="200" height="300" alt="" /></a></li>
            <!--{/loop}-->
          </ul>		
		</div>
        <div class="news_h1">
          <div class="hd"></div>
          <div class="bd">
            <ul>
              <!--{loop $recommendnews $cate}-->
              <li><a class="catecolor1" href="{$cate[cateurl]}" title="{$cate[catename]}">[{$cate[catename]}]</a><a class="newscolor1" href="{$cate[url]}" target="_blank" title="{$cate[name]}">{$cate[showname]}</a></li>
              <!--{/loop}-->
            </ul>
          </div>
        </div>
        <!-- /news_h1 -->
      </div>
      <!-- /lefttop -->
      <div class="r_brand">
        <div class="hd"></div>
        <div class="bd">
          <ul>
            <!--{loop $recommendlist $cate}-->
            <li>
              <div class="brand_logo"><a href="{$cate[url]}" target="_blank" title="{$cate[name]}">{$cate[img]}</a></div>
              <div class="brand_name"><a href="{$cate[url]}" target="_blank" title="{$cate[name]}">{$cate[name]}</a> </div>
            </li>
            <!--{/loop}-->
          </ul>
        </div>
      </div>
      <!-- /r_brand -->
      <div class="index_catelist">
        <div class="hd">{lang sanree_brand_news:filterstr}</div>
        <div class="bd">
		  <div class="catetipshow">{lang sanree_brand_news:newscate}</div>
          <ul class="ulcatelist">
            
            <!--{loop $category_list $cate}-->
            <li{$cate[class]}><a href="{$cate[url]}" title="{$cate[name]}">{$cate[name]}</a>
            </li>
            <!--{/loop}-->
          </ul>
          <!--{if count($subcategory_list)>0}-->
		  <div class="srsubcate">
		  <div class="catetipshow">{lang sanree_brand_news:subcate}</div>
          <ul class="ulsubcatelist">
            <li{$nowcate[class]}><a href="{$nowcate[url]}" title="{$nowcate[name]}">{$nowcate[name]}</a>
            </li>
            <!--{loop $subcategory_list $subcate}-->
            <li{$subcate[class]}><a href="{$subcate[url]}" title="{$subcate[name]}">{$subcate[name]}</a>
            </li>
            <!--{/loop}-->
          </ul>
		  </div>
          <!--{/if}-->
        </div>
        <div class="fd"></div>
      </div>
      <!-- /index_catelist -->
      <div class="orderby"> <SPAN><SPAN class="oders">{lang sanree_brand:oders}</SPAN> <A href="{$orderurl1}" title="{lang sanree_brand:orderdefault}"><SPAN class="{$orderclass[ordertime]}">{lang sanree_brand:orderdefault}</SPAN></A><SPAN class="{$orderclass[orderview]}" ><A href="{$orderurl2}" title="{lang sanree_brand:ordertime}">{lang sanree_brand:ordertime}</A></SPAN> <SPAN class="{$orderclass[orderrecommend]}"><A href="{$orderurl3}" title="{lang sanree_brand:orderrecommend}">{lang sanree_brand:orderrecommend}</A></SPAN> <SPAN class="{$orderclass[orderclick]}"><A href="{$orderurl4}" title="{lang sanree_brand:orderclick}">{lang sanree_brand:orderclick}</A></SPAN></SPAN> </div>
      <!-- /orderby -->
      <div class="index_news_showlist">
        <ul>
          <!--{loop $fnews_list $cate}-->
          <!--{if !empty($cate[pic])}-->
          <li>
            <div class="newspic">
              <div  style="position:absolute"> <a href="{$cate[url]}" title="{$cate[name]}" target="_blank"><img src="{$cate[pic]}" border="0" /></a> </div>
              <!--{if ($cate[isrecommend]==1)}-->
              <em></em>
              <!--{/if}-->
            </div>
            <div class="newsinfo">
              <div class="newstitle"><span class="ntitle"><a href="{$cate[url]}" title="{$cate[name]}" target="_blank">{$cate[showname1]}</a></span><span class="ndate">[ {$cate[dateline]} ]</span></div>
              <div class="newsin">{$cate[description]}</div>
              <div class="newsbrandname">{lang sanree_brand_news:postby}<a href="{$cate[brandurl]}" title="{$cate[brandname]}" target="_blank">{$cate[brandname]}</a></div>
            </div>
          </li>
          <!--{else}-->
          <li>
            <div class="newsinfo">
              <div class="newstitle">
                <!--{if ($cate[isrecommend]==1)}-->
                <img style="margin-right:10px;" src="source/plugin/sanree_brand_news/tpl/default/images/tj.gif" align="absmiddle" />
                <!--{/if}-->
                <span class="ntitle"><a href="{$cate[url]}" title="{$cate[name]}" target="_blank">{$cate[showname]}</a></span><span class="ndate">[ {$cate[dateline]} ]</span></div>
              <div class="newsin">{$cate[description]}</div>
              <div class="newsbrandname">{lang sanree_brand_news:postby}<a href="{$cate[brandurl]}" title="{$cate[brandname]}" target="_blank">{$cate[brandname]}</a></div>
            </div>
          </li>
          <!--{/if}-->
          <!--{/loop}-->
        </ul>
      </div>
      <!-- /index_news_showlist -->
      <div class="pager">{$multi}</div>
    </div>
	<!-- /news_body_left -->
    <div class="news_body_right"> 
	  <a title="{lang sanree_brand_news:publishedtip}" href="plugin.php?id=sanree_brand_news&mod=published" id="publisheddlg" onclick="showWindow(this.id, this.href, 'get', 1)" class="pubbtn"></a>
      <div class="news_search">
        <input type="text" class="<!--{if empty($defaultkeyword)}-->newskeyword<!--{else}-->newskeyword1<!--{/if}-->" id="sanreekeyword" name="sanreekeyword"  onclick="setthis(this)" value="{$defaultkeyword}"/>
        <a href="javascript:void(0)" onclick="getsearch()" class="searchbtn"></a> 
	  </div>
	  <!-- /news_search -->
      <div class="hotnews">
        <div class="hd">{lang sanree_brand_news:hotnews}</div>
        <div class="bd">
          <ul class="hotnewslist">
            <!--{loop $hotnews $cate}-->
            <li><a href="{$cate[url]}" target="_blank" title="{$cate[name]}">{$cate[showname]}</a></li>
            <!--{/loop}-->
          </ul>
        </div>
      </div>
      <!-- /hotnews -->
      <div class="hotbrandbox">
        <div class="hd">{lang sanree_brand_news:hotbrand}</div>
        <div class="bd">
          <ul class="index_hotbrand">
            <!--{loop $hotbrandlist $cate}-->
            <li>
              <div class="brandlogo"> <a href="{$cate[url]}" target="_blank" title="{$cate[name]}">{$cate[img]}</a> </div>
              <div class="brandinfo">
                <div class="hotbrandname"><a href="{$cate[url]}" target="_blank" title="{$cate[name]}">{$cate[name]}</a></div>
                <div class="hotclick">{lang sanree_brand_news:views}<span>{$cate[views]}</span></div>
              </div>
            </li>
            <!--{/loop}-->
          </ul>
        </div>
      </div>
      <!-- /hotnews -->
	  <!--{if !empty($indexadimgurl1)}-->
      <div class="news_ad">
		  <a href="{$indexadlinkurl1}" target="_blank"><img src="{$indexadimgurl1}" width="300" /></a>
	  </div>
	  <!-- /news_ad -->
	  <!--{/if}-->
      <!--{if $copyrightshow}-->
      <div class="copyright">
        <div class="hd">
          <H1>{lang sanree_brand:copyright}</H1>
        </div>
        <div class="bd">
          <ul>
            <li class="softname">{lang sanree_brand_news:news123}</li>
            <li class="ver">V {$pluginversion} For X2,X2.5!</li>
            <li class="sanree">&copy;<a href="http://www.fx8.cc/" target="_blank">Sanree.com</a></li>
          </ul>
        </div>
      </div>
      <!-- /service -->
      <!--{else}-->
      <!-- Copyright Sanree.com  {$pluginversion} -->
      <!--{/if}-->
      <!-- /copyright -->
    </div>
	<!-- /news_body_right -->
  </div>
  <!-- /news_body -->
</div>
<!-- /sanree_brand_news_indexbody -->
<div class="clear"></div>
{subtemplate common/footer}