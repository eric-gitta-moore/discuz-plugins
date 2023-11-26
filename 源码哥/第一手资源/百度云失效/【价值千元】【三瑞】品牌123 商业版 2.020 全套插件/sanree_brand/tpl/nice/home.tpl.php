<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'));?>
{subtemplate common/header}
<link type="text/css" href="{NICE_TPL}home.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" id="sanree_brand_common" href="data/cache/style_{STYLEID}_forum_viewthread.css?{VERHASH}" />
<script type="text/javascript" src="http://libs.baidu.com/jquery/1.9.0/jquery.min.js"></script>
<script>
jQuery.noConflict();
jQuery(document).ready(function(){
    jQuery(document.body).limit();
})
</script>
<!--{if $mapapi=='baidu'}-->
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.2"></script>
<script type="text/javascript" src="http://api.map.baidu.com/library/CityList/1.2/src/CityList_min.js"></script>
<!--{/if}-->
<!--{if $mapapi=='google'}--><script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script><!--{/if}-->
<!--{eval $weconfig = $_G['cache']['plugin']['sanree_we']}-->
<div class="n-header">
	<div class="nh-nav">
		<div class="nhn-tit">{lang sanree_brand:all_sale}</div>
		<div class="nhn-list">
		<div class="nhn-onelist">
			<ul id="cardlist" class="l">
			<!--{loop $category_list $cate}-->

			<li {$cate[class]}>
				<a href="{$cate[url]}" title="{$cate[name]}">
				<div class="cat l"><i class="cat-icon"><!--{if $cate[clogo]}--><img src="{$cate[clogo]}"><!--{/if}--></i>{$cate[name]}</div>
				<div class="ar r">></div>
			</a>
			</li>
			<!--{/loop}-->
			</ul>
			<div class="clear"></div>
			<div class="boxdown">{lang sanree_brand:more_cate}<i></i></div>
		</div>
		<div class="clear"></div>
			<!--{if $subcategory_bird}-->
			<!--{loop $subcategory_bird $key $cate}-->
			<!--{if !$key}-->
			<div class="nhn-box nhn-th">
				<ul>
					<li {$cate[class]}>
					<a href="{$cate[url]}" title="{$cate[name]}">{$cate[name]}</a>
					</li>
				</ul>
			</div>
			<!--{else}-->
			<div class="nhn-box">
				<ul>
					<!--{loop $cate $subcate}-->
					<li {$subcate[class]}><a href="{$subcate[url]}" title="{$subcate[name]}">{$subcate[name]}</a></li>
					<!--{/loop}-->
				</ul>
			</div>
			<!--{/if}-->
			<!--{/loop}-->
			<!--{/if}-->
		</div>
	</div>
	<div class="nh-sr">
		<div class="nhs-slide">
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
		<div class="nhs-vip">
			<ul>
			<!--{eval $re=0}-->
			<!--{loop $brandtglist $brandtg}-->
				<!--{if $brandtg}-->
				<li>
					<a href="{$brandtg['url']}" title="{$brandtg['name']}">
						<img src="{$brandtg['poster']}" alt="{$brandtg['name']}" />
						<div class="v-text">
							<div class="vt-tit">{$brandtg['name']}</div>
							<div class="vt-static">{lang sanree_brand:goods_colon}<span>{$brandtg['tggoods']}</span><em>|</em>{lang sanree_brand:coupon_colon} <span>{$brandtg['tgcoupon']}</span></div>
						</div>
					</a>
				</li>
				<!--{else}-->
				<li>
					<div class="novip"><img src="{NICE_IMG}nopic.gif" /></div>
				</li>
				<!--{/if}-->
			<!--{/loop}-->

			</ul>
		</div>
	</div>
	<div class="nh-about">
		<div class="nha-jm">
			<a class="nha-join" href="plugin.php?id=sanree_brand&mod=published" id="publisheddlg" onclick="showWindow(this.id, this.href, 'get', 1)" title="{lang sanree_brand:bird_bus_add}">{lang sanree_brand:bird_bus_add}</a>
			<a class="nha-manage" onclick="window.open('plugin.php?id=sanree_brand&mod=mybrand','_blank');" title="{lang sanree_brand:mybrand}">{lang sanree_brand:mybrand}</a>
		</div>
		<div class="nha-notice">
			<div class="n-tit">{lang sanree_brand:newsnotice}</div>
			<div class="n-con">
				<ul>
					<!--{if $config['nicenotice']}-->
					{eval $re=0}
					<!--{loop $nicenoticeshow $notice}-->
					<!--{if $re==3}-->{eval break}<!--{/if}-->
					<li>{$notice}</li>
					{eval $re++}
					<!--{/loop}-->
					<!--{else}-->
					<li><div class="notnotice">{lang sanree_brand:nonotice}</div></li>
					<!--{/if}-->
				</ul>
			</div>
			<i></i>
		</div>
		<div class="nha-plugin">
			{eval $re=0}
			<!--{loop $nicennavshow $nav}-->
				<!--{if $re==6}-->{eval break}<!--{/if}-->
				{$nav}
				{eval $re++}
			<!--{/loop}-->
		</div>
	</div>
</div>
<div class="clear"></div>
<div class="n-rec">
	<!--{if $brandtjlist}-->
	<div class="nr-box">
	<div class="module-block">
		<div class="nr-tit">
			<div class="l-tit">{lang sanree_brand:recommend_brand}</div>
			<div class="r-more">
				<ul class="btn-list">
					<li class="cur"></li>
					<li></li>
					<li></li>
				</ul>
			</div>
		</div>
		<div class="clear"></div>
		<div class="nr-con">
			<ul class="nr-list">
			<!--{loop $brandtjlist $tj}-->
				<li>
					<a href="{$tj['url']}">
						<img src="{$tj['poster']}" />
						<div class="c-tit">{$tj['name']}</div>
					</a>
				</li>
			<!--{/loop}-->
			</ul>
			<a class="btn-left"></a>
			<a class="btn-right"></a>
		</div>
	</div>
	</div>
	<!--{/if}-->
</div>
<div class="clear"></div>
<!--{if $nicead[0]}-->
<div class="n-banner">{$nicead[0]}</div>
<!--{/if}-->
<div class="clear"></div>
<div class="n-column">
	<div class="nc-list">
	<div class="module-block">
		<div class="nc-tit">
			<div class="tit-left">
			<a href="nolink">
				<h3>{lang sanree_brand:bird_bus_list}</h3>
				<!--{if $weconfig['isopen']}-->
				<em class="tit-code">
						<i class="code-icon"><img src="source/plugin/sanree_brand/tpl/nice/images/code-icon.png" /></i>
						<span class="code-box"><img src="plugin.php?id=sanree_brand&mod=showcode&codemode=brand" />{lang sanree_brand:visitwe}</span>
				</em>
				<!--{/if}-->
				</a>
			</div>
			<div class="more-right"><a href="{$brandurl}" >{lang sanree_brand:more_businesses}</a></div>
		</div>
		<div class="clear"></div>
		<div class="n-merlist">
			<div class="nm-left">
				<ul>
				<!--{if $brandhotlist}-->
				{eval $re=0}
				<!--{loop $brandhotlist $brandtj}-->
					<!--{if $re==3}-->{eval break}<!--{/if}-->
					<li>
						<a href="{$brandtj['url']}" title="{$brandtj['name']}">
							<img src="{$brandtj['poster']}" alt="{$brandtj['name']}" />
							<div class="nm-tit"><div>{$brandtj['name']}</div></div>
						</a>
					</li>
				{eval $re++}
				<!--{/loop}-->
				<!--{else}-->
					<li><div class="r-notfound">{lang sanree_brand:nohotbusinesses}</div></li>
				<!--{/if}-->
				</ul>
			</div>
			<div class="nm-right">
				<ul>
				<!--{if $brandlist}-->
				<!--{loop $brandlist $brand}-->
					<li>
						<a href="{$brand['url']}" title="{$brand['name']}">
							<img src="{$brand['poster']}" alt="{$brand['name']}" />
							<div class="nm-tit"><div>{$brand['name']}</div></div>
							<div class="nm-con">
								<div class="nm-contact">
									<span>{lang sanree_brand:brand_tel}</span>
									<!--{if $brand['tel']}-->{$brand['tel']}<!--{else}-->{lang sanree_brand:zanwustr}<!--{/if}-->
								</div>
								<div class="nm-infor">
									<div class="nmi-n">{lang sanree_brand:bird_detail_introduce}</div>
									<div class="nmi-txt" limit="50"><!--{if $brand['introduction']}-->{$brand['introduction']}<!--{else}-->{lang sanree_brand:zanwustr}<!--{/if}--></div>
								</div>
							</div>
						</a>
					</li>
				<!--{/loop}-->
				<!--{else}-->
					<li><div class="nm-notfound">{lang sanree_brand:noseekbusinesses}</div></li>
				<!--{/if}-->
				</ul>
			</div>
		</div>
	</div>
		<div class="clear"></div>
	<!--{if $coupon_config['isopen']}-->
	<div class="module-block">
		<div class="nc-tit">
			<div class="tit-left">
			<a href="nolink">
				<h3>{lang sanree_brand:coupon_zuixin}</h3>
				<!--{if $weconfig['isopen']}-->
				<em class="tit-code">
						<i class="code-icon"><img src="source/plugin/sanree_brand/tpl/nice/images/code-icon.png" /></i>
						<span class="code-box"><img src="plugin.php?id=sanree_brand&mod=showcode&codemode=coupon" />{lang sanree_brand:visitwe}</span>
				</em>
				<!--{/if}-->
				</a>
			</div>
			<div class="more-right"><a href="{$couponurl}" >{lang sanree_brand:morecoupon}</a></div>
		</div>
		<div class="clear"></div>
		<div class="n-coulist">
			<div class="nco-left">
				<ul>
				<!--{if $couponlist}-->
				<!--{loop $couponlist $coupon}-->
					<li>
						<a href="{$coupon['url']}" title="{$coupon['name']}">
							<img src="{$coupon['pic']}" alt="{$coupon['name']}" />
							<div class="nco-con">
								<div class="nco-price"><span>{$coupon['priceunit']}{$coupon['minprice']}</span><i>{$coupon['priceunit']}{$coupon['price']}</i></div>
								<div class="nco-tit"><div>{$coupon['name']}</div></div>
							</div>
							<div class="nco-box">
								<div class="nco-infor">
									<div class="nmi-n">{lang sanree_brand:couponexplain}</div>
									<div class="nmi-txt" limit="65">
										<!--{if $coupon['content']}-->{$coupon['content']}<!--{else}-->{lang sanree_brand:zanwustr}<!--{/if}-->
									</div>
								</div>
							</div>
						</a>
					</li>
				<!--{/loop}-->
				<!--{else}-->
					<li><div class="nco-notfound">{lang sanree_brand:seekfoundcoupon}</div></li>
				<!--{/if}-->
				</ul>
			</div>
			<div class="nco-right">
				<div class="r-box">
					<div class="r-tit">{lang sanree_brand_coupon:hotcoupon}</div>
					<ul>
					<!--{if $couponhotlist}-->
					<!--{loop $couponhotlist $couponhot}-->
						<li>
							<a href="$couponhot['url']" title="{$couponhot['name']}">
								<div class="nr-left"><img src="{$couponhot['pic']}" alt="{$couponhot['name']}" /></div>
								<div class="nr-right">
									<div class="nr-tit">{$couponhot['name']}</div>
									<div class="nr-p"><span>{$couponhot['priceunit']}{$couponhot['minprice']}</span><i>{$couponhot['priceunit']}{$couponhot['price']}</i></div>
								</div>
							</a>
						</li>
					<!--{/loop}-->
					<!--{else}-->
						<li><div class="r-notfound">{lang sanree_brand:nohotcoupon}</div></li>
					<!--{/if}-->
					</ul>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<!--{/if}-->
	<!--{if $goods_config['isopen']}-->
	<div class="module-block">
		<div class="nc-tit">
			<div class="tit-left">
				<a href="nolink">
				<h3>{lang sanree_brand:goods_zuixin}</h3>
				<!--{if $weconfig['isopen']}-->
				<em class="tit-code">
						<i class="code-icon"><img src="source/plugin/sanree_brand/tpl/nice/images/code-icon.png" /></i>
						<span class="code-box"><img src="plugin.php?id=sanree_brand&mod=showcode&codemode=goods" />{lang sanree_brand:visitwe}</span>
				</em>
				<!--{/if}-->
				</a>
			</div>
			<div class="more-right"><a href="{$goodsurl}" >{lang sanree_brand:moregoods}</a></div>
		</div>
		<div class="clear"></div>
		<div class="n-com">
			<div class="com-left">
				<div class="com-slide">
					<div class="bd">
						<ul>
						<!--{if $goodstjlist}-->
						<!--{loop $goodstjlist $goodstj}-->
							<li>
								<a target="_blank" href="{$goodstj['url']}" title="{$goodstj['name']}">
									<img src="{$goodstj['pic']}" alt="{$goodstj['name']}" />
									<div class="gn-price">
										<span>{$goodstj['priceunit']}{$goodstj['minprice']}</span>
										<i>{$goodstj['priceunit']}{$goodstj['price']}</i>
									</div>
									<div class="gn-name">{$goodstj['name']}</div>
								</a>
							</li>
						<!--{/loop}-->
						<!--{else}-->
							<li>
								<a target="_blank" href="javascript:">
									<img src="{NICE_IMG}good_nopic.png" />
								</a>
							</li>
						<!--{/if}-->
					  </ul>
					</div>
					<div class="hd">
						<ul>
						</ul>
					</div>
				</div>
				<div class="clear"></div>
				<div class="com-list">
					<ul>
					<!--{if $goodslist}-->
					<!--{loop $goodslist $goods}-->
						<li>
							<a href="{$goods['url']}" title="{$goods['name']}">
								<img src="{$goods['pic']}" alt="{$goods['name']}" />
								<div class="com-con">
									<div class="com-price"><span>{$goods['priceunit']}{$goods['minprice']}</span><i>{$goods['priceunit']}{$goods['price']}</i></div>
									<div class="com-tit"><div>{$goods['name']}</div></div>
								</div>
								<div class="com-bg"></div>
								<div class="com-content">
									<div class="com-infor">
										<div class="nmi-n">{lang sanree_brand_goods:post_content}</div>
										<div class="nmi-txt" limit="65"><!--{if $goods['content']}-->{$goods['content']}<!--{else}-->{lang sanree_brand:zanwustr}<!--{/if}-->
										</div>
									</div>
								</div>
							</a>
						</li>
					<!--{/loop}-->
					<!--{else}-->
						<div class="com-notfound">{lang sanree_brand:seekfoundgoods}</div>
					<!--{/if}-->
					</ul>
				</div>
			</div>
			<div class="com-right">
				<div class="com-box">
				<div class="cb-tit">{lang sanree_brand_goods:hotgoods}</div>
					<ul>
					<!--{if $goodshotlist}-->
					<!--{loop $goodshotlist $goodshot}-->
						<li>
							<a href="{$goodshot['url']}" title="{$goodshot['name']}">
								<img src="{$goodshot['pic']}" alt="{$goodshot['name']}" />
								<div class="cbt-tit"><div>{$goodshot['name']}</div>
								</div>
								<div class="cbt-price">
									<span>{$goodstj['priceunit']}{$goodstj['minprice']}</span>
									<i>{$goodstj['priceunit']}{$goodstj['price']}</i>
								</div>
							</a>
						</li>
					<!--{/loop}-->
					<!--{else}-->
						<li><div class="cbt-notfound">{lang sanree_brand:nohotgoods}</div></li>
					<!--{/if}-->
					</ul>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<!--{/if}-->
	<!--{if $news_config['isopen']}-->
	<div class="module-block">
		<div class="nc-tit">
			<div class="tit-left">
				<a href="nolink">
				<h3>{lang sanree_brand:news_zuixin}</h3>
				<!--{if $weconfig['isopen']}-->
				<em class="tit-code">
						<i class="code-icon"><img src="source/plugin/sanree_brand/tpl/nice/images/code-icon.png" /></i>
						<span class="code-box"><img src="plugin.php?id=sanree_brand&mod=showcode&codemode=news" />{lang sanree_brand:visitwe}</span>
				</em>
				<!--{/if}-->
				</a>
			</div>
			<div class="more-right"><a href="{$newsurl}" >{lang sanree_brand:morenews}</a></div>
		</div>
		<div class="clear"></div>
		<!--{if $nl_tl}-->
			<div class="n-newlist">
				<div class="nn-slide">
					<div class="bd">
					  <ul>
						<!--{if $newstjlist}-->
						<!--{loop $newstjlist $newstj}-->
						<li style="background:{$newstj[color]} center 0 no-repeat;"><a target="_blank" href="{$newstj[url]}"><img src="{$newstj[pic]}"></a></li>
						<!--{/loop}-->
						<!--{else}-->
						<li style=" center 0 no-repeat;"><a target="_blank" href="javascript:"><img src="{NICE_IMG}new_nopic.png"></a></li>
						<!--{/if}-->
					  </ul>
					</div>
					<div class="hd">
						<ul>
						</ul>
					</div>
				</div>
				<!--{if $nl_tl}-->
				<div class="nn-list">
					<div class="nl-tl">
						<!--{loop $nl_tl $tl}-->
						<a href="{$tl['url']}" title="{$tl['name']}">{$tl['name']}</a>
						<!--{/loop}-->
					</div>
					<div class="nl-bl">
						<!--{loop $nl_bl $bl}-->
						<a href="{$bl['url']}" title="{$bl['name']}">{$bl['name']}</a>
						<!--{/loop}-->
					</div>
				</div>
				<!--{else}-->
				<div class="nl-nofound">{lang sanree_brand_news:nonews}</div>
				<!--{/if}-->
				<!--{if $nt_tn}-->
				<div class="nn-tl">
					<div class="nt-tn">
						<!--{loop $nt_tn $tn}-->
						<a href="{$tn['url']}" title="{$tn['name']}">
							<img src="{$tn['pic']}" alt="{$tn['name']}" />
							<div class="nt-rt">
								<span>{$tn['name']}</span>
								<em>
									{$tn['content']}</em>
							</div>
						</a>
						<!--{/loop}-->
					</div>
					<div class="nt-bn">
						<!--{loop $nt_bn $bn}-->
						<a href="{$bn['url']}" title="{$bn['name']}">{$bn['name']}</a>
						<!--{/loop}-->
					</div>
				</div>
				<!--{else}-->
				<div class="nl-nofound">{lang sanree_brand_news:nonews}</div>
				<!--{/if}-->
				<!--{if $np_tp}-->
				<div class="nn-pl">
					<div class="np-tp">
						<ul>
							<!--{loop $np_tp $tp}-->
							<li><a href="{$tp['url']}" title="{$tp['name']}"><img src="{$tp['pic']}" title="{$tp['name']}" /><i><div>{$tp['name']}</div></i></a></li>
							<!--{/loop}-->
						</ul>
					</div>
					<div class="clear"></div>
					<div class="np-bn">
						<!--{loop $np_bn $bn}-->
						<a href="{$bn['url']}" title="{$bn['name']}">{$bn['name']}</a>
						<!--{/loop}-->
					</div>
				</div>
				<!--{else}-->
				<div class="nl-nofound" style="margin-right: 0px;">{lang sanree_brand_news:nonews}</div>
				<!--{/if}-->
			</div>
			<div class="clear"></div>
		<!--{else}-->
			<div class="nonew">{lang sanree_brand:seekfoundnews}</div>
		<!--{/if}-->
		<div class="clear"></div>
	</div>
	<!--{/if}-->
	<!--{if $jobs_config['isopen']}-->
	<div class="module-block">
		<div class="nc-tit">
			<div class="tit-left">
				<a href="nolink">
				<h3>{lang sanree_brand:jobs_zuixin}</h3>
				<!--{if $weconfig['isopen']}-->
				<em class="tit-code">
						<i class="code-icon"><img src="source/plugin/sanree_brand/tpl/nice/images/code-icon.png" /></i>
						<span class="code-box"><img src="plugin.php?id=sanree_brand&mod=showcode&codemode=jobs" />{lang sanree_brand:visitwe}</span>
				</em>
				<!--{/if}-->
				</a>
			</div>
			<div class="more-right"><a href="{$jobsurl}" >{lang sanree_brand:morejobs}</a></div>
		</div>
		<div class="clear"></div>
		<div class="n-recruit">
			<div class="nrt-blist">
				<ul>
				<!--{if $jobslist}-->
				<!--{loop $jobslist $jobs}-->
					<li>
						<a href="{$jobs['url']}" title="{$jobs['title']}">
							<div class="job-tit">{$jobs['title']}</div>
							<div class="job-cate ntb"><span>{$jobs['catename']}</span></div>
						</a>
					</li>
				<!--{/loop}-->
				<!--{else}-->
					<li><div class="job-notfound">{lang sanree_brand:seekfoundjobs}</div></li>
				<!--{/if}-->
				</ul>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<!--{/if}-->
	<!--{if $activity_config['isopen']}-->
	<div class="module-block">
		<div class="nc-tit">
			<div class="tit-left">
				<a href="nolink">
				<h3>{lang sanree_brand:activity_zuixin}</h3>
				<!--{if $weconfig['isopen']}-->
				<em class="tit-code">
						<i class="code-icon"><img src="source/plugin/sanree_brand/tpl/nice/images/code-icon.png" /></i>
						<span class="code-box"><img src="plugin.php?id=sanree_brand&mod=showcode&codemode=activity" />{lang sanree_brand:visitwe}</span>
				</em>
				<!--{/if}-->
				</a>
			</div>
			<div class="more-right"><a href="{$activityurl}" >{lang sanree_brand:moreactivity}</a></div>
		</div>
		<div class="clear"></div>
		<div class="n-activity">
			<ul>
			<!--{if $activitylist}-->
			<!--{loop $activitylist $activity}-->
				<li>
					<a href="{$activity['url']}" title="{$activity['name']}">
						<img src="{$activity['pic']}" alt="{$activity['name']}" />
						<div class="na-con">
							<div class="nac-tit">{$activity['name']}</div>
							<div class="clear"></div>
							<div class="nac-b">
								{lang sanree_brand_activity:deadline_colon}{$activity['enddate']}
							</div>
						</div>
					</a>
					<div class="nac-cate">{$activity['catename']}</div>
				</li>
			<!--{/loop}-->
			<!--{else}-->
				<div class="ac-notfound">{lang sanree_brand:seekfoundactivity}</div>
			<!--{/if}-->
			</ul>
		</div>
	</div>
	<!--{/if}-->
	<!--{if $tel_config['isopen']}-->
	<div class="clear"></div>
	<div class="module-block">
		<div class="nc-tit">
			<div class="tit-left">
			<a href="nolink">
				<h3>{lang sanree_brand:tell_zuixin}</h3>
				<!--{if $weconfig['isopen']}-->
				<em class="tit-code">
						<i class="code-icon"><img src="source/plugin/sanree_brand/tpl/nice/images/code-icon.png" /></i>
						<span class="code-box"><img src="plugin.php?id=sanree_brand&mod=showcode&codemode=tel114" />{lang sanree_brand:visitwe}</span>
				</em>
				<!--{/if}-->
				</a>
			</div>
			<a href="{$telurl}" ><div class="more-right">{lang sanree_brand:moretel}</div></a>
		</div>
		<div class="n-tell">
			<ul>
				<!--{if $tellist}-->
				<!--{loop $tellist $tel}-->
				<li>
					<a href="{$tel['url']}" onclick="showWindow('showtelkey', this.href)" title="{$tel['companyname']}">
						<div class="nt-top">
							<img src="{$tel['pic']}" alt="{$tel['companyname']}" />
							<div class="ntt-con">
								<div class="ntt-tit">{$tel['companyname']}</div>
							</div>
						</div>
						<div class="clear"></div>
						<div class="nt-tell">
							<div class="ntte-tell"><i><img src="source/plugin/sanree_brand/tpl/nice/images/tell-icon.png" /></i>$tel['telnum']</div>
						</div>
					</a>
				</li>
				<!--{/loop}-->
				<!--{else}-->
				<div class="tell-notfound">{lang sanree_brand:seekfoundtel}</div>
				<!--{/if}-->
			</ul>
		</div>
	</div>
	<!--{/if}-->
	<!--{if $newposter}-->
	<div class="clear"></div>
	<div class="module-block">
		<div class="nc-tit">
			<div class="tit-left"><h3>{lang sanree_brand:zuixincomment}</h3></div>
		</div>
		<div class="n-comment">
			<div class="nc-newcom">
				<ul>
				<!--{loop $newposter $poster}-->
					<li>
						<a href="{$_G[siteurl]}home.php?mod=space&uid={$poster['authorid']}"><img src="uc_server/avatar.php?uid={$poster['authorid']}&size=middle" />
						<span>{$poster['author']}</span>
					</li>
				<!--{/loop}-->
				</ul>
			</div>
			<div class="clear"></div>
			<div class="nc-com">
				<ul>
				<!--{loop $userpostlist $userpost}-->
					<li>
						<div class="ncc-compic"><a href="{$_G[siteurl]}home.php?mod=space&uid={$userpost['authorid']}"><img src="uc_server/avatar.php?uid={$userpost['authorid']}&size=middle" /></a></div>
						<div class="ncc-infor">
							<div class="ncc-t"><span>{$userpost['author']}</span><a href="{$userpost['url']}" title="{$userpost['name']}">{$userpost['name']}</a></div>
							<div class="ncc-time">{lang sanree_brand:issue_time}{$userpost['dateline']}</div>
							<div class="clear"></div>
							<div class="ncc-s">
								<!--<div class="ncc-staroff">
									<div class="ncc-staron" style="width: 50%;"></div>
								</div>-->
							</div>
						</div>
						<div class="clear"></div>
						<div class="ncc-con">
							<div class="ncc-toparrow"></div>
							<div class="ncc-comment">{$userpost['message']}
							</div>
						</div>
					</li>
				<!--{/loop}-->
				</ul>
			</div>
		</div>
	</div>
	<!--{/if}-->
	</div>
</div>
<div class="clear"></div>
<!--{if $nicead[1]}-->
<div class="n-banner">{$nicead[1]}</div>
<!--{/if}-->
<div class="clear"></div>
<!--{if $helpcate}-->
<div class="n-footer">
	<div class="ft-box">
		<div class="ft-left"><img src="source/plugin/sanree_brand/tpl/nice/images/ft_logo.png" /></div>
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
<!--{if $weconfig['isopen'] && $config['isnicefudong']}-->
<div class="we-codebox">
	<div class="we-mobile">
		<div class="wm-img">
			<!--{if $config['nicefudongimg']}-->{$config['nicefudongimg']}<!--{else}--><img src="{NICE_IMG}fb.png" /><!--{/if}-->
		</div>
		<div class="we-code">
			<img src="plugin.php?id=sanree_we&mod=codehome" />
			<div class="wc-txt">{lang sanree_brand:scancode}<br />{lang sanree_brand:visitwe}</div>
		</div>
		<div class="fb-close"><a title="{lang sanree_brand:clickclose}"><img src="{NICE_IMG}fb-close.png" /></a></div>
	</div>
</div>
<!--{/if}-->

<script type="text/javascript" src="{NICE_JS}superslide.2.1.js"></script>
<script type="text/javascript" src="{NICE_JS}scroll.1.3.js"></script>
<script type="text/javascript" src="{NICE_JS}home.js"></script>
{subtemplate common/footer}