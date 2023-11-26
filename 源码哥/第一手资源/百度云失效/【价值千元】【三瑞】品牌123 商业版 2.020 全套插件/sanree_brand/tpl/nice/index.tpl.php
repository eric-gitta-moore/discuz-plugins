<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
{subtemplate common/header}
<link type="text/css" rel="stylesheet" href="{NICE_TPL}nice.css" />
<link rel="stylesheet" type="text/css" id="sanree_brand" href="{SANREE_BRAND_TEMPLATE}/sanree_brand.css?{VERHASH}" />
<script type="text/javascript" src="{NICE_JS}jquery.min.js"></script>
<script language="javascript">jQuery.noConflict();</script>
<script>
jQuery.noConflict();
	jQuery(document).ready(function(){
		jQuery(document.body).limit();
});
</script>
  <div id="pt" class="bm cl">
    <div class="z"> <a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a><em>&raquo;</em><a href="{$allurl}">{$maintitle}</a>$navigation </div>
  </div>
<div class="sr_header">
    <div class="sr_slide">
      <div class="fullSlide">
        <div class="bd">
          <ul>
          <!--{loop $slidelist $cate}-->
            <li style="background:{$cate[color]} center 0 no-repeat;"><a target="_blank" href="{$cate[url]}"><img src="$_G[siteurl]{$cate[pic]}"></a></li>
          <!--{/loop}-->
          </ul>
        </div>
        <div class="hd">
          <ul>
          </ul>
        </div>
    </div>
</div>
<div class="h-box">
<div class="sr_rb">
	<div class="t_link">
		<ul>
			<li class="tl_link current"><a><i class="all-icon"></i>{lang sanree_brand:bird_bus_add}</a></li>
			<li class="tr_link"><a><i class="all-icon"></i>{lang sanree_brand:scancode}</a></li>
		</ul>
	</div>
	<div class="clear"></div>
    <div class="sr_nav">
	<div class="nav-tab">
		<ul class="nav-box">
			<li>
				<div class="join_c">
					<a href="plugin.php?id=sanree_brand&mod=published" id="publisheddlg" onclick="showWindow(this.id, this.href, 'get', 1)"><i class="all-icon"></i>{lang sanree_brand:bird_bus_add}</a>
				</div>
				<div class="join_s" onclick="window.open('plugin.php?id=sanree_brand&mod=mybrand','_blank');">
					<a><i class="all-icon"></i>{lang sanree_brand:mybrand}</a>
				  </div>
				<div class="sr_mp">{lang sanree_brand:bird_yetenter}<span>{$allcount}</span>{lang sanree_brand:h_businesses}</div>
			</li>
		</ul>
		<ul class="sr_morebox nav-hide">
			<li>
				<div class="sr_mpcode">
					<!--{eval $weconfig = $_G['cache']['plugin']['sanree_we']}-->
					<!--{if $weconfig['is_brandadimgplace'] && $weconfig['isopen']}-->
					<div class="mp_tit">{lang sanree_brand:scancostwap}{lang sanree_brand:h_businesses}</div>
					<div class="mp_code"><img src="plugin.php?id=sanree_we&mod=codehome" /></div>
					<!--{elseif $config['birdindexcode']}-->
					<div class="mp_nocode"><img src="$_G['cache']['plugin']['sanree_brand']['birdindexcode']" /></div>
					<!--{else}-->
					<div class="mp_tit">{lang sanree_brand:scancostwap}</div>
					<div class="mp_code"><img src="{sr_brand_IMG}/nocode.gif" /></div>
					<!--{/if}-->
				</div>
			</li>
		</ul>
	</div>
    </div>
  </div>
</div>
</div>
<div class="clear"></div>

<div class="clear"></div>
<div class="sr_brand">
	<div class="sr_c">
		<div class="nr-tit">
			<div class="l-tit">{lang sanree_brand:h_newpub}</div>
		</div>
		<div class="clear"></div>
		<div class="sr-newcon">
			<ul class="sr-newlist">
			<!--{loop $newbrandlist $cate}-->
				<li>
					<a target="_blank" href="{$cate[url]}" title="{$cate[name]}"><img src="{$cate[poster]}" /><div class="newlist-tit"><div>{$cate[name]}</div></div></a>
				</li>
			<!--{/loop}-->
			</ul>
			<a class="btn-left"></a>
			<a class="btn-right"></a>
		</div>
	</div>
</div>
<div class="clear"></div>
<!--{hook/sanree_brand_index_toper}-->
<!--{hook/sanree_brand_index_header}-->
<div class="clear"></div>
<div class="sr_wrapper">
  <div class="sr_re">
    <div class="toptit">
      <div class="re_tit"> <i class="all-icon"></i>{lang sanree_brand:bird_bus_rec}</div>
      <div class="dh l"> <a href="{$adminadurl}" target="_blank">{lang sanree_brand:bird_bus_pos}</a> </div>
    </div>
	<div class="clear"></div>
    <div class="re_box">
      <ul>
      <!--{loop $recommendlist $key $cate}-->
      	<!--{if $key == 4}-->
        <!--{else}-->
        <li>
			<a href="{$cate[url]}" target="_blank" title="{$cate[name]}">
				<div class="topimg">
					<div class="tp_img">
						<img src="{$cate[img]}" />
					</div>
					<div class="hidebox">
						<div class="c_infor">
							<div class="c_inforbox">
								<div class="c_tel"><i>{lang sanree_brand:brand_tel}</i><span>{$cate[tel]}<span></div>
								<div class="c_adress"><i>{lang sanree_brand:brandaddress}</i><div class="bl" limit="50">{$cate[address]}</div></div>
							</div>
						</div>
					</div>
				</div>
				<div class="c_tit">{$cate[name]}</div>
			</a>
		  </li>
        <!--{/if}-->
      <!--{/loop}-->
      </ul>
    </div>
  </div>
  <div class="clear"></div>
	<div class="mc_tit">
		<div class="re_tit"><i class="all-icon"></i>{lang sanree_brand:bird_bus_list}</div>
		<div class="dh l">{lang sanree_brand:bird_yetenter}<span>{$allcount}</span>{lang sanree_brand:h_businesses}</div>
	</div>
	<div class="hy_box">
		<div class="hy l">{lang sanree_brand:tpl_category}</div>
		<div class="lb l">
			<ul id="cardlist">
				<!--{loop $category_list $cate}-->
				<li{$cate[class]}><a href="{$cate[url]}">{$cate[name]}<i class="all-icon"></i></a>
				</li>
				<!--{/loop}-->
			</ul>
			<div class="clear"></div>
			<!--{if $subcategory_list}-->
			<ul class="subcate">
				<li {$categoryclass->_subdata[class]}><a href="{$categoryclass->_subdata[url]}">{$categoryclass->_subdata[name]}<i class="all-icon"></i></a>
				</li>
				<!--{loop $subcategory_list $cate}-->
				<li{$cate[class]}><a href="{$cate[url]}">{$cate[name]}<i class="all-icon"></i></a>
				</li>
				<!--{/loop}-->
			</ul>
			<!--{/if}-->
			</ul>
		</div>
	</div>
	<div class="clear"></div>
  <div class="sr_area">
    <div class="areabox">
      <div class="dq l">{lang sanree_brand:brandcity}</div>
      <div class="dq_list l">
       <!--{loop $districtcategory_list $mlist}-->
	   <div class="dsubcate{$mlist[class]}">
            <ul id="dshow{$mlist[id]}">
			  <li {$mlist[pidclass]}><A href="{$mlist[pidurl]}">{$mlist[allname]}<i class="all-icon"></i></A></li>
              <!--{loop $mlist[data] $cate}-->
              <li {$cate[class]}><A href="{$cate[url]}">{$cate[name]}<i class="all-icon"></i></A></li>
              <!--{/loop}-->
            </ul>
	   </div>
      <!--{/loop}-->
      </div>
    </div>
  </div>
  <div class="clear"></div>
    <div class="sr_search">
      <div class="searchbox">
      	<div class="leftsearch l">
        <form method="post" action="{$allurl}">
        <label>{lang sanree_brand:bird_bus_search}</label>
        <input type="text" class="ss mykeyword" onclick="setthis(this)" name="keyword" value="{$defaultkeyword}" onfocus="if (value =='{$defaultkeyword}'){value =''}" onblur="if (value ==''){value='{$defaultkeyword}'}" />
        <input type="submit" class="btn" value="{lang sanree_brand:bird_bus_searchbar}" />
        <div class="search_icon"></div>
        </form>
        </div>
        <div class="st r">
        <!--{loop $popularsearchlist $type}-->
        	<a href="{$type[url]}">{$type[name]}</a>
        <!--{/loop}-->
      </div>
    </div>
  </div>
  <div class="clear"></div>
  <!--{if $niceindexad[0]}-->
  <div class="n-banner">{$niceindexad[0]}</div>
  <!--{/if}-->
  <div class="clear"></div>
  <!--{hook/sanree_brand_index_middle}-->
  <div class="sr_main">
    <div class="sr_content">
	<div class="sr_topbox">
      <div class="catetype">
      	<a class="{$orderclass[ordertime]}" href="{$orderurl1}">{lang sanree_brand:orderdefault}</a>
        <a class="{$orderclass[orderview]}" href="{$orderurl2}">{lang sanree_brand:ordertime}<i class="all-icon"></i></a>
        <a class="{$orderclass[orderrecommend]}" href="{$orderurl3}">{lang sanree_brand:orderrecommend}<i class="all-icon"></i></a>
        <a class="{$orderclass[orderdiscount]}" href="{$orderurl4}">{lang sanree_brand:orderdiscount}<i class="all-icon"></i></a>
        <a class="{$orderclass[orderclick]}" href="{$orderurl5}">{lang sanree_brand:orderclick}<i class="all-icon"></i></a>
        <a class="{$orderclass[orderexponent]}" href="{$orderurl6}">{lang sanree_brand:orderexponent}<i class="all-icon"></i></a>
		<div class="rz-box l">
			<input type="checkbox" class="rz-input"  onclick="window.location.href='{$attestation}'" {$checked}/>
			<label>{lang sanree_brand:yetattestation}</label>
		</div>
      </div>
      <ul class="listmode r">
          <li> <a href="{$bigurl}" title="{lang sanree_brand:bigmode}"><img src="{sr_brand_IMG}/hello_big{$slistmode['big']}.jpg" alt="{lang sanree_brand:bigmode}" /></a> </li>
          <li> <a href="{$middleurl}" title="{lang sanree_brand:middlemode}"><img src="{sr_brand_IMG}/hello_middle{$slistmode['middle']}.jpg" alt="{lang sanree_brand:middlemode}" /></a> </li>
          <li> <a href="{$smallurl}" title="{lang sanree_brand:smallmode}"><img src="{sr_brand_IMG}/hello_small{$slistmode['small']}.jpg" alt="{lang sanree_brand:smallmode}" /></a> </li>
       </ul>
    </div>
	<div class="sr_brandlist">
		<!--{if $fbusinesses_list}-->
			<!--{loop $fbusinesses_list $cate}-->
				<!--{if $listmode==1}-->
				<div class="box_l">
					<a href="{$cate[turl]}" title="{$cate[name]}" target="_blank">
						<em></em>
						<div class="tpic_m"><img class="brlogo{$cate[bid]}"  src="{$cate[poster]}" alt="{$cate[name]}" /></div>
						<div class="inc l">
							<div class="c_name">{$cate[name]}</div>
							<ul>
								<li class="star-box">
									<div class="star"><div class="star-tit"><i>{lang sanree_brand:reggrade}</i></div><span class="staroff"> <span class="staron" style="width: {$cate[satisfaction]}%;"></span> </span>
										<span class="voter-box">
											<strong>{$cate[voter]}.{$cate[voter2]}</strong>{lang sanree_brand:fen}
										</span>
									</div>
								</li>
								<li class="view-num"><i>{lang sanree_brand:visitors}</i><span>{$cate['forum_thread']['views']}</span></li>
								<li class="brandtel"><i>{lang sanree_brand:brand_tel}</i><span><strong>{$cate[tel]}</strong></span></li>
								<li class="brandaddress"><i>{lang sanree_brand:brandaddress}</i>{$cate[address]}</li>
							</ul>
							<div class="clear"></div>
							<div class="infor">
								<div class="in_box l">
									<img src="{$cate['groupsmallicons']}" />
									<!--{if $cate[sdiscount]>0}-->
									<img src="{sr_brand_IMG}/discountico.jpg" />
									<!--{/if}-->
									<!--{if $cate[iscard]==1}-->
									<img src="{sr_brand_IMG}/cardico.jpg" />
									<!--{/if}-->
									<!--{if $cate[pbid]>0}-->
									<img src="{sr_brand_IMG}/fenico.jpg" />
									<!--{/if}-->
									<!--{if $mtf}-->
									<img src="{$cate[mcertification]}" />
									<!--{/if}-->
									<!--{if $cate['tel114id'] > 0 && $tel114version >=1121}-->
									<img src="{sr_brand_IMG}/stel114.jpg" />
									<!--{/if}-->
								</div>
							</div>
						</div>
						<div class="function-box">
							<!--{if $cate['allowfastpost'] && $config['allowfastpost']}-->
							<a href="{$cate['detailurl']}#fastpostform" class="dp"><i class="all-icon"></i>{lang sanree_brand:myremark}</a>
							<!--{/if}-->
							<a href="home.php?mod=spacecp&ac=favorite&type=thread&id={$cate[tid]}" id="k_favorite" onClick="stid={$cate[tid]};showWindow(this.id, this.href, 'get', 0);" class="sc"><i class="all-icon"></i>{lang sanree_brand:joincollect}</a>
							<a class="dt" href="plugin.php?id=sanree_brand&mod=map&tid={$cate['tid']}&bid={$cate['bid']}" onClick="showWindow(this.id, this.href, 'get', 1)" id="publisheddlg"><i class="all-icon"></i>{lang sanree_brand:brandmap}</a></a>
							<!--{if $weconfig['isopen']}-->
							<a class="cd"><i class="all-icon"></i>{lang sanree_brand:scancode}<div class="cd-box"><img src="plugin.php?id=sanree_we&mod=codehome&cmod=item&tid={$cate['bid']}" /></div></a>
							<!--{/if}-->
						</div>
					</a>
				</div>
				<!--{elseif $listmode==3}-->
				<div class="box_m">
					<a href="{$cate[turl]}" title="{$cate[name]}" target="_blank">
						<em></em>
						<div class="tpic_m"><img class="brlogo{$cate[bid]}"  src="{$cate[poster]}" alt="{$cate[name]}" /></div>
						<div class="c_name">{$cate[name]}</div>
						<div class="infor">
							<div class="in_box l">
								<img src="{$cate['groupsmallicons']}" />
								<!--{if $cate[sdiscount]>0}-->
								<img src="{sr_brand_IMG}/discountico.jpg" />
								<!--{/if}-->
								<!--{if $cate[iscard]==1}-->
								<img src="{sr_brand_IMG}/cardico.jpg" />
								<!--{/if}-->
								<!--{if $cate[pbid]>0}-->
								<img src="{sr_brand_IMG}/fenico.jpg" />
								<!--{/if}-->
								<!--{if $mtf}-->
								<img src="{$cate[mcertification]}" />
								<!--{/if}-->
								<!--{if $cate['tel114id'] > 0 && $tel114version >=1121}-->
								<img src="{sr_brand_IMG}/stel114.jpg" />
								<!--{/if}-->
							</div>
							<!--<div class="in_box r">
								<strong>{$cate[voter]}.{$cate[voter2]}</strong>{lang sanree_brand:fen}
							</div>-->
						</div>
						<div class="hidebox">
							<div class="more-infor">
								<div class="mi-box">
									<div class="brandtel"><i>{lang sanree_brand:brand_tel}</i><span>{$cate[tel]}</span></div>
									<div class="brandaddress"><i>{lang sanree_brand:brandaddress}</i><div class="bl" limit="50">{$cate[address]}</div></div>
								</div>
							</div>
						</div>
					</a>
				</div>
				<!--{else}-->
				<div class="box_b">
					<a href="{$cate[turl]}" title="{$cate[name]}" target="_blank">
						<em></em>
						<div class="tpic_m"><img class="brlogo{$cate[bid]}"  src="{$cate[poster]}" alt="{$cate[name]}" /></div>
						<div class="c_name">{$cate[name]}</div>
						<div class="infor">
							<div class="in_box l">
								<img src="{$cate['groupsmallicons']}" />
								<!--{if $cate[sdiscount]>0}-->
								<img src="{sr_brand_IMG}/discountico.jpg" />
								<!--{/if}-->
								<!--{if $cate[iscard]==1}-->
								<img src="{sr_brand_IMG}/cardico.jpg" />
								<!--{/if}-->
								<!--{if $cate[pbid]>0}-->
								<img src="{sr_brand_IMG}/fenico.jpg" />
								<!--{/if}-->
								<!--{if $mtf}-->
								<img src="{$cate[mcertification]}" />
								<!--{/if}-->
								<!--{if $cate['tel114id'] > 0 && $tel114version >=1121}-->
								<img src="{sr_brand_IMG}/stel114.jpg" />
								<!--{/if}-->
							</div>
						</div>
						<div class="b-box">
							<div class="view-num l">{lang sanree_brand:brandview}<span>{$cate['forum_thread']['views']}</span></div>
							<div class="in_box r">
							  <div class="star"><div class="star-tit">{lang sanree_brand:grade}</div><span class="staroff"> <span class="staron" style="width: {$cate[satisfaction]}%;"></span> </span> </div>
							</div>
						</div>
						<!--	{$cate[tel114url]} -->
						<div class="hidebox">
							<div class="more-infor">
								<div class="mi-box">
									<div class="brandtel"><i>{lang sanree_brand:brand_tel}</i><span>{$cate[tel]}</span></div>
									<div class="brandaddress"><i>{lang sanree_brand:brandaddress}</i><div class="bl" limit="50">{$cate[address]}</div></div>
								</div>
							</div>
						</div>
					</a>
				</div>
				<!--{/if}-->
			<!--{/loop}-->
			<div class="clear"></div>
			<div class="bigPage vm center" id="xp3">{$multi}</div>
			<!--{else}-->
			<div class="nobusinesses">{lang sanree_brand:nobusinesses}</div>
		<!--{/if}-->
	</div>
  </div>
    <div class="sr_sidebar">
      <div class="cbl_box">
        <h2><i class="all-icon"></i>{lang sanree_brand:h_hotbrand}</h2>
        <div class="hot_c">
          <ul>
          <!--{loop $hotbrandlist $cate}-->
            <li {$cate[class]} onclick="window.open('{$cate[url]}','_blank');">
              <div class="tp"><img src="{$cate[poster]}" /></div>
              <div class="h_tit">{$cate[name]}</div>
              <div class="infor">
                <div class="in_box l">
                	<img src="{$cate['groupsmallicons']}" />
                    {$cate[tel114url]}
                    <!--{if $cate[sdiscount]}-->
                    <img src="{sr_brand_IMG}/discountico.jpg" />
                    <!--{/if}-->
                    <!--{if $cate[iscard]}-->
                    <img src="{sr_brand_IMG}/cardico.jpg" />
                    <!--{/if}-->
                    <!--{if $cate[pbid]}-->
                    <img src="{sr_brand_IMG}/fenico.jpg" />
                    <!--{/if}-->
                    <!--{if $mtf}-->
                    <img src="{$cate[mcertification]}" />
                    <!--{/if}-->
                </div>
              </div>
              </li>
          <!--{/loop}-->
          </ul>
        </div>
        <div class="clear"></div>
        <h2>{lang sanree_brand:servicecenter}</h2>
        <div class="service">
          <p>{lang sanree_brand:h_admintel}<strong>{$admintel}</strong></p>
          <p>
          	<span class="l">{lang sanree_brand:h_adminqq}</span>
          	<span class="l"><script language="javascript">document.write('<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin={$adminqq}&site=qq&menu=yes"><img align="baseline" border="0" src="http://wpa.qq.com/pa?p=2:{$adminqq}:41"></a>');</script></span>
          </p>
          <div class="clear"></div>
          <p>{lang sanree_brand:servicetime}{$admintime}</p>
        </div>
          <!--{hook/sanree_brand_index_right_bottom}-->
      </div>
    </div>
</div>
</div>

<div class="clear"></div>
<!--{if $niceindexad[1]}-->
<div class="n-banner">{$niceindexad[1]}</div>
<!--{/if}-->
<!--{if !empty($config['niceserveinfo'])}-->
<div class="clear"></div>
<div class="ft-banner">
	<div class="ft-img">
		<img src="{$config['niceserveinfo']}" />
	</div>
</div>
<!--{/if}-->
<div class="clear"></div>
<!--{if $helpcate}-->
<div class="n-footer">
	<div class="ft-box">
		<div class="ft-left">
			<div class="fl-img"><img src="{if $config['webweixinpic']}{$config['webweixinpic']}{else}{$config['defaultwxcodeimg']}{/if}" /></div>
			<div class="fl-txt">{lang sanree_brand:scangzwx}</div>
		</div>
		<div class="ft-right">
		<div class="helpbar">
			<ul>
				<!--{loop $helpcate $cate}-->
				<li>
					<dl {$cate[class]}>
					<dt>{$cate[1]}</dt>
					<!--{loop $cate[2] $cateli}-->
					<dd><a href="{$cateli[url]}" target="_blank">{$cateli[title]}</a></dd>
					<!--{/loop}-->
					</dl>
				</li>
				<!--{/loop}-->
			</ul>
		</div>
		<!-- /friendly_linkbar -->
		</div>
		<div class="clear"></div>
	</div>
</div>
<!--{/if}-->
<div class="clear"></div>
<!--{if $copyrightshow}-->
<div class="copyright">
	<div class="brand">
		<p><span class="pcolor1">{lang sanree_brand:h_brand123}</span><span class="pcolor2"><b>{lang sanree_brand:h_sanree}</b></span>
		V&nbsp;&nbsp;{$pluginversion}&nbsp;&nbsp;For&nbsp;&nbsp;X2,&nbsp;X2.5,&nbsp;X3,&nbsp;X3.1,&nbsp;X3.2!&copy;<a href="http://www.fx8.cc/" target="_blank">Sanree.com</a></p>
		<div class="box_copyright"><a href="http://www.fx8.cc/" target="_blank"><b>{lang sanree_brand:h_sanree}</b> ymg6.Com</a></div>
	</div>
</div>
<!-- /copyright -->
<!--{else}-->
<!-- Copyright Sanree.com  {$pluginversion} -->
<!--{/if}-->
<!--{hook/sanree_brand_index_footer}-->

<div class="clear"></div>
<!--{if $friendly_link}-->
<div class="friendly_link">
<div>{lang sanree_brand:friendly_link}</div>
<ul>
  <!--{loop $friendly_link $cate}-->
  <li>
	  <a href="{$cate[url]}" target="_blank">{$cate[title]}</a>
  </li>
  <!--{/loop}-->
</ul>
</div>
<!-- /friendly_linkbar -->
<!--{/if}-->

<script type="text/javascript" src="{NICE_JS}superslide.2.1.js"></script>
<script type="text/javascript" src="{NICE_JS}scroll.1.3.js"></script>
<script type="text/javascript" src="{NICE_JS}nice.js"></script>
{subtemplate common/footer}
<!--{if $mapapi=='baidu'}-->
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.2"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/library/CityList/1.2/src/CityList_min.js"></script>
<!--{/if}-->
<!--{if $mapapi=='google'}--><script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script><!--{/if}-->