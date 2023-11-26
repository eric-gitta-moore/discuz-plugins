<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{eval $_G['disabledwidthauto']=TRUE;}-->
<!--{if ($ishideheader==1) }-->
<!--{subtemplate common/header_common}-->
{$brand_header_one}
<!--{ad/headerbanner/wp a_h}-->
<!--{hook/global_header}-->
<div id="wp" class="wp">	
<!--{else}-->
{subtemplate common/header}
<!--{/if}-->
<link type="text/css" rel="stylesheet" href="{BIRD_CSS}cr.css" />
<link type="text/css" rel="stylesheet" href="{BIRD_CSS}album.css" />
<script type="text/javascript" src="{BIRD_JS}jquery.min.js"></script>
<script type="text/javascript" src="{BIRD_JS}dropdown.js"></script>
<script language="javascript">jQuery.noConflict();</script>
<script src="{BIRD_JS}jquery.kinMaxShow-1.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="{BIRD_JS}jquery.autofix_anything.js"></script>
<script type="text/javascript" src="{BIRD_JS}modernizr.custom.79639.js"></script>
<!--[if IE 6]>
<script src="{BIRD_JS}DD_belatedPNG_0.0.8a.js" type="text/javascript" ></script>
<script type="text/javascript">
DD_belatedPNG.fix('#main,.in-v1-top,.in-v1-bot,.in-v1-cont,.in-v2-top,.in-v2-bot,h1.logo,ul#nav li a,.copyRight,img,background,.modal');
</script> 
<![endif]-->
</head>
<script type="text/javascript">
jQuery(function(){
	jQuery(".sr_slide").kinMaxShow({
		intervalTime: 2
	});
});
function showhid(id){
 document.getElementById(id).style.display ='block';
}
function showhid2(id){
 document.getElementById(id).style.display ='none';
}
</script>
<link rel="stylesheet" type="text/css" href="{SANREE_BRAND_TEMPLATE}/albumlist.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="data/cache/style_{STYLEID}_forum_viewthread.css?{VERHASH}" />
<script src="{sr_brand_JS}/sanree_brand.js"></script>
<script src="{sr_brand_JS}/album.js"></script>
<body>
<div class="sr_wrapper">
    <!--{hook/sanree_brand_usertoper}-->
    <div id="pt" class="bm cl">
    <div class="z"> <a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a><em>&raquo;</em><a href="{$allurl}">{$maintitle}</a>$navigation</div>
    </div> 
    {$srhead}
    <div class="al_cc">
        <div class="al_cb">
          <div class="mc_tit">
            <span class="l"><i class="icon"></i><strong>{$cate[catname]}</strong></span>
            <!--{if defined('IN_BRAND_USER')}-->
            <span class="r">
                <a href="plugin.php?id=sanree_brand&amp;mod=ajax&amp;do=uploadpic&amp;bid={$brandresult[bid]}&catid={$catid}" onClick="showWindow('uploadpicdlg', this.href, 'get', 1)" class="l_link">+ {lang sanree_brand:uploadnewpic}</a>
            <!--{if $allowbatchimage==1}-->
                <a href="plugin.php?id=sanree_brand&amp;mod=ajax&amp;do=uploadpicbatch&amp;bid={$brandresult[bid]}&catid={$catid}" onClick="showWindow('uploadpicbatchdlg', this.href, 'get', 1)" title="{lang sanree_brand:batch_upload}" class="r_link">{lang sanree_brand:batch_upload} +</a>
            <!--{/if}-->
            </span>
            <!--{/if}-->
          </div>
          <div class="clear"></div>
            <div class="al_center">
            <!--{if $picturecatelist}-->
                <ul>
                <!--{loop $picturecatelist $picture}-->
                    <li class=clearall onMouseMove="showthis({$picture[albumid]})" onMouseOut="hidethis({$picture[albumid]})">
                        <a href="javascript:;">
                            <div class="al_ti">
								<img onClick="zoom(this, '{$picture[pic]}')" id='aimg_{$picture[albumid]}' src="$_G[siteurl]{BIRD_CSS}timthumb.php?src=$_G[siteurl]{$picture[thumbpic]}&h=218&w=218&zc=1" zoomfile="{$picture[pic]}" title="{$picture[albumname]}" alt="{$picture[albumname]}" />
							</div>
							<div class="al_tb albumname" id='aimgtxt_{$picture[albumid]}'><span onClick="clickshow({$picture[albumid]})">{$picture[albumname]}</span></div>
                        </a>
                    </li>
                <!--{/loop}-->
                </ul>
				<div class="clear"></div>
                <div class="pager">{$multi}</div>
            <!--{else}-->
            <div class="zanwu">{lang sanree_brand:nopic}</div>
            <!--{/if}-->
            </div>
        </div>
        <div class="al_sidebar">
            <div class="al_sl">
            <h1>{lang sanree_brand:h_newpub}</h1>
                <ul>
                <!--{loop $newlist $value}-->
                    <li>
                        <a href="{$value[url]}" target="_blank">
                            <div class="al_ll"><img src="{$value[poster]}" /></div>
                            <div class="al_slt">
                                <div class="al_tt">{$value[name]}</div>
                                <div class="star"> <span class="staroff"> <span class="staron" style="width: {$value[satisfaction]}%;"></span></span></div>
                            </div>
                        </a>
                    </li>
                <!--{/loop}-->
                </ul>
            </div>
            <div class="clear"></div>
            <div class="al_sc">
                <span class="al_lsc"><a href="home.php?mod=spacecp&ac=favorite&type=thread&id=$brandresult[tid]" id="k_favorite" onClick="stid={$brandresult[tid]};showWindow(this.id, this.href, 'get', 0);">{lang sanree_brand:bird_detail_favor}</a></span>
                <span class="al_rsc">{lang sanree_brand:fav} {$brandresult[favtimes]}</span>
            </div>
            <div class="al_kf">
                 <h1>{lang sanree_brand:servicecenter}</h1>
                <p>
                <!--{if $ismultiple==1&&$brandresult[allowmultiple]==1}-->
                <span class="l">{lang sanree_brand:oqq}</span>
                <span class="l">{$brandresult[icq]}</span>
                <!--{else}-->
				<span class="l">{lang sanree_brand:oqq}</span>
                <span class="l">{$brandresult[qq]}</span>
				<!--{/if}-->
                </p>
            </div>
        </div>
    </div>
</div>
<script src="{sr_brand_JS}/sanree_brand.js"></script>
<script src="static/js/forum_viewthread.js"></script>
<script language="javascript">
	var stid=0;
	var aimgcount = new Array();
	aimgcount[{$catid}] = {$aids};
	attachimggroup({$catid});
	attachimgshow({$catid});
	var aimgfid = 0;
</script>
<script type="text/javascript">
jQuery(function(){
jQuery("#tab li").first().addClass("on").siblings().removeClass("on");
jQuery("#center > div").first().show().siblings().hide();
jQuery("#tab li").mousemove(function(){
var index = jQuery("#tab li").index(this);
jQuery(this).addClass("on").siblings().removeClass("on");
jQuery("#center > div").eq(index).show().siblings().hide();
});
});
</script>
<script type="text/javascript"> 

function menuFix() { 
var sfEls = document.getElementById("wap_display").getElementsByTagName("li"); 
for (var i=0; i<sfEls.length; i++) { 
sfEls[i].onmouseover=function() { 
this.className+=(this.className.length>0? " ": "") + "sfhover"; 
} 
sfEls[i].onMouseDown=function() { 
this.className+=(this.className.length>0? " ": "") + "sfhover"; 
} 
sfEls[i].onMouseUp=function() { 
this.className+=(this.className.length>0? " ": "") + "sfhover"; 
} 
sfEls[i].onmouseout=function() { 
this.className=this.className.replace(new RegExp("( ?|^)sfhover"), 
""); 
} 
} 
} 
window.onload=menuFix; 
 
</script>
<script src="{BIRD_JS}portamento.js"></script> 
<script>
			jQuery('#mc_wr').portamento({wrapper: jQuery('.mc_content')});	// set #wrapper as the visual coundary of the panel
		</script> 
<script type='text/javascript' src='{BIRD_JS}jquery.modal.js'></script> 
<script type='text/javascript' src='{BIRD_JS}site.js'></script>
<script type="text/javascript">
			
			function DropDown(el) {
				this.dd = el;
				this.placeholder = this.dd.children('span');
				this.opts = this.dd.find('ul.dropdown > li');
				this.val = '';
				this.index = -1;
				this.initEvents();
			}
			DropDown.prototype = {
				initEvents : function() {
					var obj = this;

					obj.dd.on('click', function(event){
						$(this).toggleClass('active');
						return false;
					});

					obj.opts.on('click',function(){
						var opt = $(this);
						obj.val = opt.text();
						obj.index = opt.index();
						obj.placeholder.text(obj.val);
					});
				},
				getValue : function() {
					return this.val;
				},
				getIndex : function() {
					return this.index;
				}
			}

			$(function() {

				var dd = new DropDown( $('#dd') );

				$(document).click(function() {
					// all dropdowns
					$('.wrapper-dropdown-3').removeClass('active');
				});

			});

		</script>
{subtemplate common/footer}
<style type="text/css">.hm{position:inherit;}.zimg_prev{width:50%;}.zimg_next{width:50%;}</style>