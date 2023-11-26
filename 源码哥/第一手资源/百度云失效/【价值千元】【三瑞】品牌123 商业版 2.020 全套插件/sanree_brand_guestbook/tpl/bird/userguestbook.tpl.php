<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{if ($ishideheader==1) }-->
<!--{subtemplate common/header_common}-->
{$brand_header_one}
<!--{ad/headerbanner/wp a_h}-->
<!--{hook/global_header}-->
<div id="wp" class="wp">
<!--{else}-->
{subtemplate common/header}
<!--{/if}-->
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand/tpl/good/sanree_brand.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand_guestbook/tpl/bird/userguestbook.css" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand/tpl/good/userbar.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand/tpl/good/header.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand/tpl/good/albumlist.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand/tpl/good/msg.css?{VERHASH}" />
<link type="text/css" rel="stylesheet" href="{BIRD_CSS}album.css" />
<link type="text/css" rel="stylesheet" href="source/plugin/sanree_brand/tpl/bird/cr.css?{VERHASH}" />
<script type="text/javascript" src="source/plugin/sanree_brand/tpl/bird/js/jquery.min.js"></script>
<script type="text/javascript" src="source/plugin/sanree_brand/tpl/bird/js/dropdown.js"></script>
<script language="javascript">jQuery.noConflict();</script>
<script src="source/plugin/sanree_brand/tpl/bird/js/jquery.kinMaxShow-1.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="source/plugin/sanree_brand/tpl/bird/js/jquery.autofix_anything.js"></script>
<script type="text/javascript" src="source/plugin/sanree_brand/tpl/bird/js/modernizr.custom.79639.js"></script>
<!--[if IE 6]>
<script src="source/plugin/sanree_brand/tpl/bird/js/DD_belatedPNG_0.0.8a.js" type="text/javascript" ></script>
<script type="text/javascript">
DD_belatedPNG.fix('#main,.in-v1-top,.in-v1-bot,.in-v1-cont,.in-v2-top,.in-v2-bot,h1.logo,ul#nav li a,.copyRight,img,background,.modal');
</script> 
<![endif]-->
<script src="source/plugin/sanree_brand/tpl/good/js/sanree_brand.js?{VERHASH}"></script>
<script src="source/plugin/sanree_brand_guestbook/tpl/default/js/sanree_brand_guestbook.js?{VERHASH}"></script>
<script src="{sr_brand_guestbook_JS}/msg{C_CHARSET}.js" reload="1"></script>
<script language="javascript">
var stid=0;
function chuli(obj) {
	if(obj.title.value=='') {
		alert('{lang sanree_brand_guestbook:post_inputtitletip}');
		obj.title.focus();
		return false;
	}
	if(obj.fullname.value=='') {
		alert('{lang sanree_brand_guestbook:post_inputfullnametip}');
		obj.fullname.focus();
		return false;
	}
	if (!isTrueName(obj.fullname.value))	{
		alert('{lang sanree_brand_guestbook:post_inputfullnamecktip}');
		obj.fullname.focus();
		return false;
	}

	if(obj.address.value=='') {
		alert('{lang sanree_brand_guestbook:post_inputaddresstip}');
		obj.address.focus();
		return false;
	}
	if(obj.phone.value=='') {
		alert('{lang sanree_brand_guestbook:post_inputphonetip}');
		obj.phone.focus();
		return false;
	}
	if(!checkPhone(obj.phone.value)) {
		alert('{lang sanree_brand_guestbook:post_inputphonecktip}');
		obj.phone.focus();
		return false;
	}	
	if(obj.email.value !='') {
		if (!isEmail(obj.email.value)) {
			alert('{lang sanree_brand_guestbook:post_inputemailcktip}');
			obj.email.focus();
			return false;
		}
	}	
	if(obj.qq.value !='') {
		if (!isNumber(obj.qq.value)) {
			alert('{lang sanree_brand_guestbook:post_inputqqcktip}');
			obj.qq.focus();
			return false;
		}
	}							
	if(obj.words.value=='') {
		alert('{lang sanree_brand_guestbook:post_inputwordstip}');
		obj.words.focus();
		return false;
	}								
	<!--{if $isshowcode==1}-->
	if(obj.seccodeverify.value=='') {
		alert('{lang sanree_brand_guestbook:post_inputseccodeverifytip}');
		obj.seccodeverify.focus();
		return false;
	}
	<!--{/if}-->																								
	ajaxpost('postform', 'return_error', 'return_error' , '', '',function(){srshowdialog();});
	return false;					
}
</script>
<style>
body {
	margin: 0;
	padding: 0;
	font-family: microsoft yahei, Verdana, Geneva, sans-serif;
	font-size: 14px;
}
ul, li, div, span, img, h1, p {
	list-style: none;
	margin: 0;
	padding: 0;
	border: 0;
}

.l {
	float: left;
}
.r {
	float: right;
}
.clear {
	clear: both;
}

.sr_wrapper .sr_slide {
	display:none;
}
</style>
<body>
<!--star-->
<div class="sr_wrapper">
<div class="mc_albox">
    <!--{hook/sanree_brand_usertoper}-->
    <div id="pt" class="bm cl">
    	<div class="z"> <a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a><em>&raquo;</em><a href="{$allurl}">{$maintitle}</a>$navigation </div>
    </div>
    {$srhead}
  	<!--{hook/sanree_brand_userheader}-->
	<div class="ap_cb">
    	<!--{hook/sanree_brand_userlefttop}-->
		<div class="mc_tit">
			<span class="l"><i class="icon"></i><a href="{$brandresult[url]}">{$brandresult[name]}</a> <span>&gt; </span>{lang sanree_brand_guestbook:mode_guestbook}</span>
		</div>
		<div class="clear"></div>
		<div class="state-text"><span>{lang sanree_brand_guestbook:mode_guestbook}</span>{lang sanree_brand_guestbook:bird_tips}</div>
		<div class="ap_con">
            <div class="appointment">
              <FORM id=postform onSubmit="return chuli(this);" method=post action="plugin.php?id=sanree_brand_guestbook&mod=userguestbook">
              <input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
              <input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />
              <input type="hidden" name="postsubmit" value="1" /> 
              <input type="hidden" name="tid" value="{$_G[sr_tid]}">
              <div class="appointment-content">
                <ul>
                  <li>
                    <div class="input-left"> <span>*</span>{lang sanree_brand_guestbook:temp_title}</div>
                    <div class="input-right">
                      <input type="text" class="input-text" name="title" id="title" />
                    </div>
                    <!-- .input-right --> 
                  </li>
                  <li>
                    <div class="input-left"> <span>*</span>{lang sanree_brand_guestbook:temp_fullname}</div>
                    <div class="input-right">
                      <input type="text" class="input-text" name="fullname" id="fullname" value="{$space['realname']}" />
                    </div>
                    <!-- .input-right --> 
                  </li>
                  <li>
                    <div class="input-left"> <span>*</span>{lang sanree_brand_guestbook:temp_address}</div>
                    <div class="input-right">
                      <input type="text" class="input-text" name="address" id="address"  value="{$space['address']}" />
                    </div>
                    <!-- .input-right --> 
                  </li>
                  <li>
                    <div class="input-left"> <span>*</span>{lang sanree_brand_guestbook:temp_phone}</div>
                    <div class="input-right">
                      <input type="text" class="input-text" name="phone" id="phone" value="{$space['telephone']}" />
                    </div>
                    <!-- .input-right --> 
                  </li>
                  <li>
                    <div class="input-left">{lang sanree_brand_guestbook:temp_email}</div>
                    <div class="input-right">
                      <input type="text" class="input-text" name="email" id="email"  value="{$space['email']}" />
                    </div>
                    <!-- .input-right --> 
                  </li>
                  <li>
                    <div class="input-left">{lang sanree_brand_guestbook:temp_qq}</div>
                    <div class="input-right">
                      <input type="text" class="input-text" name="qq" id="qq"  value="{$space['qq']}" />
                    </div>
                    <!-- .input-right --> 
                  </li>
                  <li>
                    <div class="input-left"> <span>*</span>{lang sanree_brand_guestbook:temp_words}</div>
                    <div class="input-right">
                      <textarea class="input-content" name="words" id="words" onKeyUp="strLenCalc(this, 'checklen', 255);"></textarea>
                      <div class="ap_b_text">{lang sanree_brand_guestbook:temp_wordstr1}<span id="checklen">255</span>{lang sanree_brand_guestbook:temp_wordstr2}</span> </div>
                    <!-- .input-right --> 
                  </li>
                  <li>
                    <div class="input-left"> <span>*</span>{lang sanree_brand_guestbook:temp_seccodeverify}</div>
                    <div class="input-right">
                      <input type="text" class="input-code" name="seccodeverify" id="seccodeverify" />
                      <span style="float: left; margin-left: 9px;"> <img id="checkcode" style="cursor:pointer" src="plugin.php?id=sanree_brand_guestbook&mod=checkcode" title="{lang sanree_brand_guestbook:temp_recode}" align="absmiddle" onClick="javascript:recode(0)" border="0" /></span> <span style="float: left; margin: 9px 0 0 9px;"><a href="javascript:recode(0)" class="seeshow">{lang sanree_brand_guestbook:temp_recode}</a></span> </div>
                    <!-- .input-right --> 
                  </li>
                </ul>
              </div>
              <!-- .appointment-content -->
              </form>
			  <div id="return_error" style="display:none"></div>
              <div class="sr_submit">
                <a class="submitshow" onClick="chuli($('postform'))"></a>
              </div>
              <!-- .submit --> 
            </div>
            <!-- .appointment -->
            <div class="submit-text"><span>*</span>{lang sanree_brand_guestbook:bird_endtip}</div>
          </div>
          <!-- .content --> 
	</div>
    <div class="al_sidebar">
    <div class="al_sl">
        <h1>{lang sanree_brand:h_newpub}</h1>
            <ul>
            <!--{loop $newlist $value}-->
                <li>
                    <a href="{$value[url]}" target="_blank">
                        <div class="al_ll"><img src="$_G[siteurl]{BIRD_CSS}timthumb.php?src=$_G[siteurl]{$value[poster]}&h=60&w=60&zc=1" /></div>
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
	<div class="clear"></div>
</div>

<!--{hook/sanree_brand_userfooter}-->
{subtemplate common/footer}
<!--end-->