<!--{if $_G['inajax']==1}-->
{template common/header_ajax}
<!--{else}-->
{subtemplate common/header}
<!--{/if}-->
<script language="javascript">
function chkadd(obj)
{
	if(obj.name.value=='') {
		alert('{lang sanree_brand:inputname}');
		obj.name.focus();
		return false;
	}
	if(obj.tid.selectedIndex <1) 	{
		alert('{lang sanree_brand:inputcate}');
		obj.tid.focus();
		return false;
	}
	if(obj.poster.value=='') {
		alert('{lang sanree_brand:inputposter}');
		obj.poster.focus();
		return false;
	}
	if(!obj.ty.checked) {
		alert('{lang sanree_brand:tyxieyi}');
		obj.ty.focus();
		return false;
	}		
	<!--{if $_G[inajax]}-->
		ajaxpost('postform', 'return_error', 'return_error' , 'onerror');
		return false;	
	<!--{else}-->
		return true;
	<!--{/if}-->
}
</script>
<link rel="stylesheet" type="text/css" id="sanree_brand" href="source/plugin/sanree_brand/tpl/default/sanree_brand.css?{VERHASH}" />
<div class="published<!--{if !$_G['inajax']}--> published_notajax<!--{/if}-->">
  <h3 class="flb mn sr"><em>{lang sanree_brand:published_title}</em> <span>
    <!--{if $_G['inajax']}-->
    <a href="javascript:;" class="flbc" onclick="hideWindow('publisheddlg', 0, 1);" title="{lang close}">{lang close}</a>
    <!--{/if}-->
    </span> </h3>
  <form method="post" action="plugin.php?id=sanree_brand&mod=published" autocomplete="off" id="postform" onsubmit="return chkadd(this)">
    <input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
    <input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />
	<input type="hidden" name="inajax" id="inajax" value="{$_G[inajax]}" />
    <span id="return_error" style="display:none"></span>
	<span id="succeedmessage"></span>
    <div class="pub_body">
      <div class="pub_left">
          <dl class="pub_data">
            <dd class="pub_name">
              <label><span>*</span>{lang sanree_brand:brand_name}</label>
              <input type="text" name="name" id="name" value="" title="{lang sanree_brand:required}" tabindex="1" align="absmiddle" />
            </dd>
            <dd class="pub_cate">
              <label><span>*</span>{lang sanree_brand:brand_cate}</label>
              <select name="tid" class="catesel"  tabindex="2" >
                <option value="">{lang sanree_brand:pchose}</option>
                <!--{loop $category_list $cate}-->
                <option value='<!--{$cate[cateid]}-->' >
                <!--{$cate[name]}-->
                </option>
                <!--{/loop}-->
              </select>
            </dd>
            <dd class="pub_poster">
              <label><span>*</span>{lang sanree_brand:brand_poster}</label>
              <input type="text" id="poster" title="{lang sanree_brand:required}" name="poster" tabindex="3" />
              <p>{lang sanree_brand:brand_postertip}</p>
            </dd>
            <dd class="pub_weburl">
              <label>{lang sanree_brand:brand_weburl}</label>
              &nbsp;&nbsp;<input type="text" class="weburltxt" name="weburl" tabindex="4" title="{lang sanree_brand:urltip}" />
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
                <TEXTAREA id="propagandamessage" class=pt tabIndex="5" rows=6 cols=10 name=propaganda></TEXTAREA>
              </DIV>
            </DIV>
          </dd>			
          </dl>
      </div>
      <div class="pub_right">
        <dl class="pub_data">
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
                  <TEXTAREA id="introductionmessage" class=pt tabIndex="6" rows=6 cols=40 name=introduction></TEXTAREA>
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
                <TEXTAREA id="contactmessage" class=pt tabIndex="7" rows=6 cols=40 name=contact></TEXTAREA>
              </DIV>
            </DIV>
          </dd>
        </dl>
      </div>
	  <div class="clear"></div>
    </div>
	<div class="pub_agreement">
	   <div class="hd">{lang sanree_brand:brand_agreement}</div>
	   <div class="bd">
	        <div class="agreementtxt">{$agreement}</div>
	   </div>
	   <div class="fd">
	   <input class="submit" type="image" src="{sr_brand_IMG}/quebtn.jpg" align="absmiddle"   tabIndex="9" />
	   <input type="hidden" name="postsubmit" value="1" />
	   <input type="checkbox" name="ty" id="ty"   tabIndex="8" /><label for="ty">{lang sanree_brand:brand_agreementbt}</label>
	   </div>
	</div>
  </form>
</div>
<!--{if $_G['inajax']==1}-->
{template common/footer_ajax}
<!--{else}-->
{subtemplate common/footer}
<!--{/if}-->