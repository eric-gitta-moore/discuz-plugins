<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
{template common/header_ajax}
<script language="javascript">
function chkadd(obj)
{
    <!--{if $ischkdistrict==1}-->
		<!--{if $isselfdistrict==1}-->
		if(obj.srbirthprovince&&obj.srbirthprovince.value=='') {
			alert('{lang sanree_brand:inputbirthprovince}');
			obj.srbirthprovince.focus();
			return false;
		}
		<!--{else}-->
		if(obj.birthprovince&&obj.birthprovince.value=='') {
			alert('{lang sanree_brand:inputbirthprovince}');
			obj.birthprovince.focus();
			return false;
		}		
		<!--{/if}-->
	<!--{/if}-->
	if(obj.name.value=='') {
		alert('{lang sanree_brand:inputname}');
		obj.name.focus();
		return false;
	}
	if(obj.cateid.selectedIndex <1) 	{
		alert('{lang sanree_brand:inputcate}');
		obj.cateid.focus();
		return false;
	}
	if(obj.poster.value=='') {
		alert('{lang sanree_brand:inputposter}');
		return false;
	}	
	/*
	if(obj.qq.value=='') {
		alert('{lang sanree_brand:inputqq}');
		obj.qq.focus();
		return false;
	}*/
	/*
	if(obj.mappos.value=='') {
		alert('{lang sanree_brand:inputmappos}');
		obj.mappos.focus();
		return false;
	}*/
	if(obj.tel.value=='') {
		alert('{lang sanree_brand:inputtel}');
		obj.tel.focus();
		return false;
	}
	if(obj.address.value=='') {
		alert('{lang sanree_brand:inputaddress}');
		obj.address.focus();
		return false;
	}

	if(!obj.ty.checked) {
		alert('{lang sanree_brand:tyxieyi}');
		obj.ty.focus();
		return false;
	}		
	ajaxpost('postform', 'return_error', 'return_error' , '', '',function(){srshowdialog();});
	return false;	

}
var haveuploaded='{lang sanree_brand:haveuploaded}';
</script>
<script src="{sr_brand_JS}/upload{C_CHARSET}.js"></script>
<script src="{sr_brand_JS}/msg{C_CHARSET}.js"></script>
<script language="javascript" src="{sr_brand_JS}/district.js"></script>
<link rel="stylesheet" type="text/css" id="sanree_brand" href="{SANREE_BRAND_TEMPLATE}/sanree_brand.css?{VERHASH}" />
<div class="published">
  <h3 class="flb mn sr"><em>{lang sanree_brand:published_title}</em> 
  <span><!--{if $_G['inajax']}--><a href="javascript:;" class="flbc" onclick="hideWindow('publisheddlg', 0, 1);" title="{lang close}">{lang close}</a><!--{/if}--></span> </h3>
  <div class="pub_tip"><ul><!--{if $regprice>0 || $config['isshen']==1}--><!--{if $regprice>0}--><li>{$pubtip_price}</li><!--{/if}--><!--{if $config['isshen']==1}--><li>{$pubtip_shen}</li><!--{/if}--><!--{else}--><li>{$pubtip_ok}</li><!--{/if}--></ul></div>
  <form method="post" action="plugin.php?id=sanree_brand&mod=published" autocomplete="off" id="postform" onsubmit="return chkadd(this)">
    <input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
    <input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />
	<input type="hidden" name="inajax" id="inajax" value="1" />
	<input type="hidden" name="bid" id="bid" value="{$bid}" />
    <span id="return_error" style="display:none"></span>
	<span id="succeedmessage"></span>
	<span id="upload"></span>
	<div class="pub_district">
	<p<!--{if $ischkdistrict==1}--> class="cred"><i>*</i><!--{else}-->><!--{/if}--><em>{lang sanree_brand:regionselect}</em></p><!--{$districthtml}-->
	</div>		
    <div class="pub_body">
      <div class="pub_left">
          <dl class="pub_data">
            <dd class="pub_name">
              <label><span>*</span>{lang sanree_brand:brand_name}</label>
              <input type="text" name="name" id="name" value="{$result['name']}" title="{lang sanree_brand:pubnametip}" tabindex="4" align="absmiddle" <!--{if !empty($result['name'])}-->readonly style="background:#ECE9D8"<!--{/if}--> />
            </dd>
            <dd class="pub_cate">
              <label><span>*</span>{lang sanree_brand:brand_cate}</label>
              <select name="cateid" class="catesel"  tabindex="5" >
                <option value="">{lang sanree_brand:pchose}</option>
                <!--{loop $category_list $cate}-->
                <option value='<!--{$cate[cateid]}-->' <!--{if $cate[cateid]==$result[cateid]}-->selected<!--{/if}--> >
                <!--{$cate[name]}-->
                </option>
                <!--{/loop}-->
              </select>
            </dd>
			<dd class="pub_tel">
				<label><span>*</span>{lang sanree_brand:brand_tel}</label>
				<input type="text" name="tel" id="tel" value="{$result['tel']}" tabindex="7" maxlength="255" align="absmiddle" />
			</dd>
			<dd class="pub_address">
				<label><span>*</span>{lang sanree_brand:brand_address}</label>
				<input type="text" name="address" id="address" value="{$result['address']}" tabindex="8" maxlength="255" align="absmiddle" />
			</dd>
		    <dd class="pub_discount">
				<label>{lang sanree_brand:pub_discount}</label>{$discounthtml}
			</dd>			
			<dd class="pub_qq">
				<div class="pub_map">
				<a href="plugin.php?id=sanree_brand&mod=map&do=marked&mappoint={$result['mappos']}" id="showmap" onclick="showWindow('showmap',this.href);return false;" tabindex="9">{lang sanree_brand:mapmarked}</a>
				<INPUT class=txt name=mappos  value="{$result['mappos']}"id="mappoint_mappoint" tabindex="9">
				</div>
				<!--{if $ismultiple==1}-->
					<!--{if $icq=='msn'}-->			
					<label>{lang sanree_brand:brand_msn}</label>
					<input type="text" name="msn" id="msn" value="{$result['msn']}" tabindex="9" maxlength="255" align="absmiddle" />
					<!--{elseif $icq=='wangwang'}-->			
					<label>{lang sanree_brand:brand_wangwang}</label>
					<input type="text" name="wangwang" id="wangwang" value="{$result['wangwang']}" tabindex="9" maxlength="255" align="absmiddle" />				
					<!--{elseif $icq=='baiduhi'}-->			
					<label>{lang sanree_brand:brand_baiduhi}</label>
					<input type="text" name="baiduhi" id="baiduhi" value="{$result['baiduhi']}" tabindex="9" maxlength="255" align="absmiddle" />				
					<!--{elseif $icq=='skype'}-->			
					<label>{lang sanree_brand:brand_skype}</label>
					<input type="text" name="skype" id="skype" value="{$result['skype']}" tabindex="9" maxlength="255" align="absmiddle" />				
					<!--{else}-->
					<label>{lang sanree_brand:brand_qq}</label>
					<input type="text" name="qq" id="qq" value="{$result['qq']}" tabindex="9" maxlength="255" align="absmiddle" />
					<!--{/if}-->
				<!--{else}-->
				<label>{lang sanree_brand:brand_qq}</label>
				<input type="text" name="qq" id="qq" value="{$result['qq']}" tabindex="9" maxlength="255" align="absmiddle" />
			    <!--{/if}-->
			</dd>			
            <dd class="pub_weburl">
              <label>{lang sanree_brand:brand_weburl}</label>
              <input type="text" class="weburltxt" name="weburl" value="{$result['weburl']}" tabindex="10" title="{lang sanree_brand:urltip}" />
            </dd>
          <dd class="pub_introduction">

            <DIV class=tedt1>
              <DIV class=bar><SPAN class=y>
                <HOOK>{lang sanree_brand:propaganda_tip}</HOOK>
                </SPAN>
                <span class="hook">{lang sanree_brand:propaganda}</span>
					<!--{eval $seditor = array('propaganda', array('bold', 'color', 'link', 'quote', 'smilies'));}-->
					<!--{subtemplate common/seditor}-->
              </DIV>
              <DIV class=area>
                <TEXTAREA id="propagandamessage" class=pt tabIndex="11" rows=3 cols=10 name=propaganda>{$result[propaganda]}</TEXTAREA>
              </DIV>
            </DIV>
          </dd>			
          </dl>
      </div>
      <div class="pub_right">
        <dl class="pub_data">
            <dd class="pub_poster">	
			  <div class="uploadbar" id="uploadbar"><label><span>*</span>{lang sanree_brand:brand_poster}</label>
			  <input type="button" onclick="Showupload();" value="{lang sanree_brand:clickupload}" tabindex="6" />
			  </div>				
              
            </dd>		
            <dd class="pub_propaganda">
              <DIV class=tedt1>
                <DIV class=bar><SPAN class=y>
                  <HOOK>{lang sanree_brand:introduction_tip}</HOOK>
                  </SPAN>
                  <span class="hook">{lang sanree_brand:introduction}</span>
					<!--{eval $seditor = array('introduction', array('bold', 'color', 'link', 'quote', 'smilies'));}-->
					<!--{subtemplate common/seditor}-->
                </DIV>
                <DIV class=area>
                  <TEXTAREA id="introductionmessage" tabIndex="12" class=pt rows=6 cols=40 name=introduction>{$result[introduction]}</TEXTAREA>
                </DIV>
              </DIV>
            </dd>
          <dd class="pub_contact">
            <DIV class=tedt1>
              <DIV class=bar><SPAN class=y>
                <HOOK>{lang sanree_brand:contact_tip}</HOOK>
                </SPAN>
                <span class="hook">{lang sanree_brand:contact}</span>
					<!--{eval $seditor = array('contact', array('bold', 'color', 'link', 'quote', 'smilies'));}-->
					<!--{subtemplate common/seditor}-->
              </DIV>
              <DIV class=area>
                <TEXTAREA id="contactmessage" class=pt tabIndex="13" rows=6 cols=40 name=contact>{$result[contact]}</TEXTAREA>
              </DIV>
            </DIV>
          </dd>
        </dl>
      </div>
	  <div class="clear"></div>
    </div>
	<div class="pub_agreement">
	   <div class="fd">
	   <input class="submit" type="image" src="{sr_brand_IMG}/quebtn.jpg" align="absmiddle"   tabIndex="15" />
	   <input type="checkbox" name="ty" id="ty"   tabIndex="14" /><label for="ty">{lang sanree_brand:brand_agreementbt}</label>
	   </div>
	   <div class="hd">{lang sanree_brand:brand_agreement}</div>	   
	   <div class="bd">
	        <div class="agreementtxt">{$agreement}</div>
	   </div>	   
	</div>
	  <input type="hidden" name="caid" id="caid" value="{$result['caid']}" />
	  <input type="hidden" id="poster" title="{lang sanree_brand:required}" value="{$result['poster']}" name="poster" tabindex="6" />	
	<input type="hidden" name="postsubmit" value="1" />
  </form>
</div>
{template common/footer_ajax}