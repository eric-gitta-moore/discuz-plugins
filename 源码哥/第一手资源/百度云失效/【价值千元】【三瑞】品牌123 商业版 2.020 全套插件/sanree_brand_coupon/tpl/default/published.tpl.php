<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{if $_G['inajax']==1}-->
{template common/header_ajax}
<!--{else}-->
{subtemplate common/header}
<!--{/if}-->					
<script language="javascript">
function chkadd(obj)
{
	if(obj.bid.selectedIndex <1) 	{
		alert('{lang sanree_brand_coupon:inputbid}');
		obj.bid.focus();
		return false;
	}
	if(obj.couponname.value=='') {
		alert('{lang sanree_brand_coupon:inputcouponname}');
		obj.couponname.focus();
		return false;
	}	
	if(obj.cateid.selectedIndex <1) 	{
		alert('{lang sanree_brand_coupon:inputcate}');
		obj.cateid.focus();
		return false;
	}
	if(obj.smallpic.value=='') {
		alert('{lang sanree_brand_coupon:inputsmallpic}');
		obj.uploadbarbtn.focus();
		return false;
	}
	if(obj.content.value=='') {
		alert('{lang sanree_brand_coupon:inputcontent}');
		obj.content.focus();
		return false;
	}
	if(obj.price.value=='') {
		alert('{lang sanree_brand_coupon:inputprice}');
		obj.price.focus();
		return false;
	}
	if(obj.minprice.value=='') {
		alert('{lang sanree_brand_coupon:inputminprice}');
		obj.minprice.focus();
		return false;
	}	
	if(obj.stock.value=='') {
		alert('{lang sanree_brand_coupon:inputstock}');
		obj.stock.focus();
		return false;
	}	
	<!--{if $isrebate==1}-->
	var rebateproportion = parseInt(obj.rebateproportion.value) > 0 ? parseInt(obj.rebateproportion.value) : 0;
	if(rebateproportion<1||rebateproportion>99) {
		alert('{lang sanree_brand_coupon:inputrebateproportion}');
		obj.rebateproportion.focus();
		return false;
	}		
	<!--{/if}-->
	<!--{if $_G[inajax]}-->
		ajaxpost('postform', 'return_error', 'return_error' , '', '',function(){srshowdialog();});
		return false;	
	<!--{else}-->
		return true;
	<!--{/if}-->
}
if ($('postform')) $('postform').bid.focus();
function srshowdialog(ajaxframeid) {
	var ajaxframeid = 'ajaxframe';
	try {
		s = $(ajaxframeid).contentWindow.document.XMLDocument.text;
	} catch(e) {
		try {
			s = $(ajaxframeid).contentWindow.document.documentElement.firstChild.wholeText;
		} catch(e) {
			try {
				s = $(ajaxframeid).contentWindow.document.documentElement.firstChild.nodeValue;
			} catch(e) {
				s = '{lang sanree_brand_coupon:post_ajax_error}';
			}
		}
	}
	msg = s;
	if (msg.indexOf('hideWindow')<5) {
		showError(msg);
	}
	else {
		
		var p = /<script[^\>]*?>([^\x00]*?)<\/script>/ig;
		msg = msg.replace(p, '');
		if(msg !== '') {
			showDialog(msg, 'right', '', null, true, null, '', '', '', 3);
		}
	}
}
function smallpicupload() {
	Showuploadsmallpic(function (aid, url) {rebacksmallpic(aid, url)}, 'couponimage') ;
}
function Showuploadsmallpic(recall, type) {
	var fid = 0;
	UPLOADWINRECALL = recall;
	showWindow('upload', 'plugin.php?id=sanree_brand&mod=upload&fid=' + fid + '&type=' + type + '&w=560&h=350', 'get', 0);
}
function rebacksmallpic(aid, url){
	$('caid').value=aid;
	$('smallpic').value=url;
	$('uploadbar').innerHTML= haveuploaded;
}
function showlimit(id) {
	if (id!=1) {
		$('limitmain').style.display='none';
	}else{
		$('limitmain').style.display='';
	}
}
var haveuploaded='{lang sanree_brand:haveuploaded}';
</script>
<link rel="stylesheet" type="text/css" id="sanree_brand_coupon" href="{sr_brand_coupon_TPL}sanree_brand_coupon.css?{VERHASH}" />
<link rel="stylesheet" type="text/css"  href="data/cache/style_{STYLEID}_forum_forumdisplay.css?{VERHASH}" />
<script src="source/plugin/sanree_brand/tpl/good/js/upload{C_CHARSET}.js"></script>
<script src="source/plugin/sanree_brand/tpl/good/js/msg{C_CHARSET}.js"></script>
<div class="coupon_published<!--{if !$_G['inajax']}--> published_notajax<!--{/if}-->">
  <h3 class="flb mn sr"><em>{$addteltitle}</em> <span>    
    <!--{if $_G['inajax']}-->
    <a href="javascript:;" class="flbc" onclick="hideWindow('publisheddlg', 0, 1);" title="{lang close}">{lang close}</a>
    <!--{/if}-->
    </span> </h3>
  <div class="couponitem">
    <span id="return_error" style="display:none"></span>
	<span id="succeedmessage"></span>
	<span id="upload"></span>  
  <form method="post" target="_blank" action="plugin.php?id=sanree_brand_coupon&mod=published" autocomplete="on" id="postform" onsubmit="return chkadd(this)">
    <input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
    <input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />
	<input type="hidden" name="inajax" id="inajax" value="{$_G[inajax]}" />
	<input type="hidden" name="cid" id="cid" value="{$cid}" />  
	<input type="hidden" name="tid" id="tid" value="{$tid}" />  
	<input type="hidden" name="pid" id="pid" value="{$pid}" /> 
	<input type="hidden" name="st" id="view" value="{$_G[sr_st]}" />  
    <table class="fire" width="100%" border="1" bordercolor="E6E6E6" cellpadding="3" cellspacing="0">
	  <tbody>
      <tr>
		<td colspan="2" valign="middle"><div class="fright"><input class="pn pnc sanreesubmit" type="submit" value="<!--{if $cid}-->{lang sanree_brand_coupon:edit_new_coupon}<!--{else}-->{lang sanree_brand_coupon:post_new_coupon}<!--{/if}-->" /></div><div class="post_remind">{lang sanree_brand_coupon:post_remind}</div>
        </td>
      </tr>		  	
      <tr class="bitian">
        <td class="lefttip"><span>*</span>{lang sanree_brand:brandnameto}</td>
        <td><select name="bid" class="catesel"  tabindex="1" >
            <option value="">{lang sanree_brand:selectedbrand}</option>
            <!--{loop $selectlist $cate}-->
            <option value='<!--{$cate[bid]}-->'<!--{if $cate[bid]==$result[bid]}-->selected<!--{/if}-->>
            <!--{$cate[name]}-->
            </option>
            <!--{/loop}-->
          </select></td>
      </tr>
      <tr class="bitian">
        <td class="lefttip"><span>*</span>{lang sanree_brand_coupon:post_couponname}</td>
        <td><input type="text" name="couponname" value="{$result[name]}" class="couponname" tabindex="2" /></td>
      </tr>
      <tr class="bitian">
        <td class="lefttip"><span>*</span>{lang sanree_brand_coupon:post_couponcate}</td>
        <td><select name="cateid" class="catesel"  tabindex="3" >
            <option value="">{lang sanree_brand:pchose}</option>
            <!--{loop $category_list $cate}-->
            <option value='<!--{$cate[cateid]}-->'<!--{if $cate[cateid]==$result[cateid]}-->selected<!--{/if}-->>
            <!--{$cate[name]}-->
            </option>
            <!--{/loop}-->
          </select></td>
      </tr>
      <tr>
        <td class="lefttip">{lang sanree_brand_coupon:post_keywords}</td>
        <td><input type="text" name="keywords" value="{$result[keywords]}" class="couponname"  tabindex="4" /></td>
      </tr>
      <tr>
        <td class="lefttip">{lang sanree_brand_coupon:post_description}</td>
        <td><textarea rows="2" name="description" class="couponname"  tabindex="5">{$result[description]}</textarea></td>
      </tr>
      <tr>
        <td class="lefttip"><span>*</span>{lang sanree_brand_coupon:post_picture}</td>
        <td>
		<div id="uploadbar">
		 <input id="uploadbarbtn" name="uploadbarbtn" onclick="smallpicupload();" class="pn pnc sanreesubmit" type="button" value="{lang sanree_brand_coupon:upload}" />	
		 <br />
		 <!--{if !empty($result['smallpic'])}-->
		 <img src="{$_G['setting']['attachurl']}category/{$result['smallpic']}" width="180" height="100" />
		 <!--{/if}-->
		 </div>
		</td>
      </tr>	  
      <tr class="bitian">
        <td class="lefttip"><span>*</span>{lang sanree_brand_coupon:post_content}</td>
        <td>
			<div class=tedt>
				<div class=bar><SPAN class=y><HOOK></HOOK></SPAN><span class="hook"></span>
					<!--{eval $seditor = array('fastpost', array('bold', 'color', 'img', 'link', 'quote', 'code', 'smilies'), !$allowfastpost ? 1 : 0);}-->
					<!--{subtemplate common/seditor}-->
				</div>
				<div class=area>
					<TEXTAREA id="fastpostmessage" class=pt tabIndex="7" rows=6 cols=40 name=content>{$result[content]}</TEXTAREA>
				</div>
			</div>
		  </td>
      </tr> 
      <tr class="bitian">
        <td class="lefttip"><span>*</span>{lang sanree_brand_coupon:post_condition}</td>
        <td>
			<div class=tedt>
				<div class=bar><SPAN class=y><HOOK></HOOK></SPAN><span class="hook"></span>
					<!--{eval $seditor = array('fastpost1', array('bold', 'color', 'img', 'link', 'quote', 'code', 'smilies'), !$allowfastpost ? 1 : 0);}-->
					<!--{subtemplate common/seditor}-->
				</div>
				<div class=area>
					<TEXTAREA id="fastpost1message" class=pt tabIndex="7" rows=6 cols=40 name=condition>{$result[condition]}</TEXTAREA>
				</div>
			</div>
		  </td>
      </tr> 
      <tr class="bitian">
        <td class="lefttip"><span>*</span>{lang sanree_brand_coupon:priceunit}</td>
        <td>{$selectunitstr}</td>
      </tr>	  
      <tr class="bitian">
        <td class="lefttip"><span>*</span>{lang sanree_brand_coupon:post_price}</td>
        <td><input type="text" name="price" value="{$result[price]}"  tabindex="8" /></td>
      </tr>
      <tr>
        <td class="lefttip"><span>*</span>{lang sanree_brand_coupon:post_minprice}</td>
        <td><input type="text" name="minprice" value="{$result[minprice]}"  tabindex="9" /></td>
      </tr>	
      <tr>
        <td class="lefttip"><span>*</span>{lang sanree_brand_coupon:post_stock}</td>
        <td><input type="text" name="stock" value="{$result[stock]}"  tabindex="9" /></td>
      </tr>	
	  <!--{if $isrebate==1}-->
      <tr>
        <td class="lefttip"><span>*</span>{lang sanree_brand_coupon:rebateproportion}</td>
        <td><input type="text" name="rebateproportion" value="{$result[rebateproportion]}"  tabindex="9" /> <br />{lang sanree_brand_coupon:rebateproportiontip}</td>
      </tr>	  
	   <!--{/if}--> 
      <tr>
        <td class="lefttip">{lang sanree_brand_coupon:unit}</td>
        <td><input type="text" name="unit" value="{$result[unit]}"  tabindex="11" /> {lang sanree_brand_coupon:unittip}</td>
      </tr>	    	  
      <tr>
        <td class="lefttip">{lang sanree_brand_coupon:enddate}</td>
        <td><input type="text" name="enddate" value="{$result[enddate]}" /> {lang sanree_brand_coupon:limit_usermaxdowntip}</td>
      </tr>		  		  
      <tr>
        <td class="lefttip">{lang sanree_brand_coupon:isshow}</td>
        <td><input type="radio" name="isshow" value="1" tabindex="16" {$isshowst}/>
          {lang sanree_brand_coupon:post_yew}
          <input type="radio" name="isshow" value="0" tabindex="17" {$notshowst}/>
          {lang sanree_brand_coupon:post_no}</td>
      </tr>
      <tr>
        <td colspan="2" align="right"><input class="pn pnc sanreesubmit" type="submit" value="<!--{if $cid}-->{lang sanree_brand_coupon:edit_new_coupon}<!--{else}-->{lang sanree_brand_coupon:post_new_coupon}<!--{/if}-->"  tabindex="18" />
        </td>
      </tr>
    </table>
	<input type="hidden" name="postsubmit" value="1" />
	 <input type="hidden" name="caid" id="caid" value="{$result['homeaid']}" />
	 <input type="hidden" id="smallpic" value="{$result['smallpic']}" name="smallpic" />	
  </form>	
  </div>
</div>
<!--{if $_G['inajax']==1}-->
{template common/footer_ajax}
<!--{else}-->
{subtemplate common/footer}
<!--{/if}-->