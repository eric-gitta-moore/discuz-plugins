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
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand/tpl/good/userbar.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand/tpl/good/header.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand/tpl/good/albumlist.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="source/plugin/sanree_brand/tpl/good/msg.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" href="{sr_brand_guestbook_TPL}userguestbook.css?{VERHASH}" />
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
<div class="sanree_brand_itembody" id="brandbody">
  <!--{hook/sanree_brand_usertoper}-->
  <div id="pt" class="bm cl">
    <div class="z"> <a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a><em>&raquo;</em><a href="{$allurl}">{$maintitle}</a>$navigation </div>
  </div>
  {$brand_header}
  <!--{hook/sanree_brand_userheader}-->  
    <div class="albumlist">
	  <div class="albumleft">
	    <!--{hook/sanree_brand_userlefttop}-->	  
	    <div class="goodslist">
		   <div class="ahd"><h1><a href="{$brandresult[url]}">{$brandresult[name]}</a> <span>&gt; </span>{lang sanree_brand_guestbook:mode_guestbook}</h1></div>
		   <div class="abd">		
				<FORM id=postform onsubmit="return chuli(this);" method=post action="plugin.php?id=sanree_brand_guestbook&mod=userguestbook">
				<input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
				<input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />
				<input type="hidden" name="postsubmit" value="1" /> 
				<input type="hidden" name="tid" value="{$_G[sr_tid]}">
				<div class="post_guestbook">
				  <div class="gtitle"></div>
				  <table  border="0" width="500" style="margin:0 auto">
				  <tr>
				   <td class="tmtitle" align="right"><span class="bitian">*</span>{lang sanree_brand_guestbook:temp_title}</td><td><input class="txtinput1" type="text" name="title" id="title" /></td>
				  </tr>
				  <tr><td class="tmtitle" align="right"><span class="bitian">*</span>{lang sanree_brand_guestbook:temp_fullname}</td><td><input class="txtinput1" type="text" name="fullname" id="fullname" value="{$space['realname']}" /></td>
				  </tr>
				   <tr><td class="tmtitle" align="right"><span class="bitian">*</span>{lang sanree_brand_guestbook:temp_address}</td><td><input class="txtinput1" type="text" name="address" id="address"  value="{$space['address']}" /></td>
				   </tr>
				   <tr><td class="tmtitle" align="right"><span class="bitian">*</span>{lang sanree_brand_guestbook:temp_phone}</td><td><input class="txtinput1" type="text" name="phone" id="phone" value="{$space['telephone']}" /></td>
				   </tr>
				   <tr><td class="tmtitle" align="right"><span class="bitian">&nbsp;</span>{lang sanree_brand_guestbook:temp_email}</td><td><input class="txtinput1" type="text" name="email" id="email"  value="{$space['email']}"/></td>
				   </tr>
				   <tr><td class="tmtitle" align="right"><span class="bitian">&nbsp;</span>{lang sanree_brand_guestbook:temp_qq}</td><td><input class="txtinput1" type="text" name="qq" id="qq"  value="{$space['qq']}"/></td>
				   </tr>   
				   <tr><td class="tmtitle" align="right"><i><span class="bitian">*</span>{lang sanree_brand_guestbook:temp_words}</i></td><td><textarea name="words" id="words" onkeyup="strLenCalc(this, 'checklen', 255);" ></textarea></td></tr>
				   <tr><td class="tmtitle"></td><td><div class="gtixing"><span class="bitian">*{lang sanree_brand_guestbook:temp_bitian}</span><span class="pito"></span><span class="bitian2">{lang sanree_brand_guestbook:temp_wordstr1}<strong id="checklen">255</strong>{lang sanree_brand_guestbook:temp_wordstr2}</span></div></td></tr>
				   <!--{if $isshowcode==1}-->
				   <tr class="mtop20"><td class="tmtitle" align="right"><span class="bitian">*</span>{lang sanree_brand_guestbook:temp_seccodeverify}</td><td><input class="txtinput3" type="text" name="seccodeverify" id="seccodeverify" /> &nbsp;&nbsp;<img id="checkcode" style="cursor:pointer" src="plugin.php?id=sanree_brand_guestbook&mod=checkcode" title="{lang sanree_brand_guestbook:temp_recode}" align="absmiddle" onclick="javascript:recode(0)"> <a href="javascript:recode(0)" class="seeshow">{lang sanree_brand_guestbook:temp_recode}</a></td></tr>
				   <!--{/if}-->
				   <tr><td colspan="2" align="right"><div class="gsubmit"><a class="submitshow" onclick="chuli($('postform'))"></a></div></td></tr>
				  </tr>
				  </table>
				  <div class="gbottom"></div>
				</div>				
				</form>
				<div id="return_error" style="display:none"></div>
		   </div>
		</div> 	
		<!--{hook/sanree_brand_userleftbottom}-->		  
	  </div>
	  <!-- /albumleft -->
	  <div class="albumright">  
		  <!--{if defined('IN_BRAND_USER')}-->
			  <div class="clickmanage">
				  <a href="javascript:void(0)" onclick="showmanage(1)"></a>
			  </div>
			  <!-- /clickmanage -->
		  <!--{/if}-->	  
	      <!--{hook/sanree_brand_userrighttop}-->		  
	     <div class="baseinfo<!--{if defined('IN_BRAND_USER')}--> srmtop10<!--{/if}-->">
		    <div class="hd"></div>
			<div class="bd">
			   <ul>
			      <li class="oqq">
				  <!--{if $ismultiple==1&&$brandresult[allowmultiple]==1}-->
				  {lang sanree_brand:oqq}{$brandresult[icq]}
				  <!--{else}-->
				  {lang sanree_brand:oqq}{$brandresult[qq]}
				  <!--{/if}-->				  
				  </li>
				  <li class="olevel">{lang sanree_brand:olevel}<img align="absbottom" src="{$brandresult[groupimg]}" /></li>
				  <li class="odiscount">{lang sanree_brand:odiscount}{$brandresult['discount']}</li>
				  <li class="otelphone">{lang sanree_brand:otelphone}{$brandresult[tel]}</li>
				  <li class="oaddress">{lang sanree_brand:oaddress}{$brandresult[address]}</li>
			   </ul>
			</div>
		 </div>
		 <!-- /baseinfo -->
		 <div class="brandnews">
		     <div class="hd"></div>
			 <div class="bd">
			 <ul>
			 <!--{loop $newlist $value}-->
				 <li><a href="{$value[url]}" target="_blank">{$value[name]}</a></li>
			 <!--{/loop}-->
			 </ul>
			 </div>
		 </div>
		 <!-- /brandnews -->
		 <div class="brandfavorite">
		     <div class="hd"><div class="favoritebtn"><a href="home.php?mod=spacecp&ac=favorite&type=thread&id=$brandresult[tid]" id="k_favorite" onclick="stid={$brandresult[tid]};showWindow(this.id, this.href, 'get', 0);"></a></div></div>
			 <div class="bd">{lang sanree_brand:fav}<span>{$brandresult[favtimes]}</span></div>
			 <div class="fd">
			    <ul>
				<!--{loop $favoritelist $value}-->
				<li>
				  <div class="avt"><a href="home.php?mod=space&uid=$value[uid]" target="_blank"><!--{avatar($value[uid],small)}--></a></div>
				  <div class="avname"> <a href="home.php?mod=space&uid=$value[uid]" target="_blank">$value[username]</a></div>
				</li>
			    <!--{/loop}-->
				</ul>
			 </div>
		 </div>
		 <!-- /brandfavorite -->
		 <!--{hook/sanree_brand_userrightbottom}-->
	  </div>
	  <!-- /albumright -->
	</div>
	<!-- /albumlist -->
</div>
<div id="userbar"></div>
<div class="clear"></div>
<script language="javascript">
var url = 'plugin.php?id=sanree_brand&mod=userbar&tid={$tid}&bid={$bid}';
ajaxget(url, 'userbar');
function favoriteupdate(){}
</script>
<!--{hook/sanree_brand_userfooter}-->
{subtemplate common/footer}  