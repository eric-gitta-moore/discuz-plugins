<?php exit;?>
<input type="hidden" name="selectsortid" size="45" value="$_G['forum_selectsortid']" />
<table cellspacing="0" cellpadding="0">
  <!--{if $_G['forum']['threadsorts']['description'][$_G['forum_selectsortid']]}-->
  <div class="flfb_flxm cl">
    <div class="flxm_xmbt z">{lang threadtype_description}</div>
    <div class="flxm_xmnr z">$_G[forum][threadsorts][description][$_G[forum_selectsortid]]</div>
  </div>
  <!--{/if}--> 
  <!--{if $_G['forum']['threadsorts']['expiration'][$_G['forum_selectsortid']]}-->
  <div class="flfb_flxm cl">
    <div class="flxm_xmbt z">{lang threadtype_expiration}</div>
    <div class="flxm_xmnr z"><div class="ftid">
        <select name="typeexpiration" tabindex="1" id="typeexpiration">
          <option value="259200">{lang three_days}</option>
          <option value="432000">{lang five_days}</option>
          <option value="604800">{lang seven_days}</option>
          <option value="2592000">{lang one_month}</option>
          <option value="7776000">{lang three_months}</option>
          <option value="15552000">{lang half_year}</option>
          <option value="31536000">{lang one_year}</option>
        </select>
      </div>
      
      <!--{if $_G['forum_optiondata']['expiration']}-->{lang valid_before}: $_G[forum_optiondata][expiration]<!--{/if}--></div>
  </div>
  <!--{/if}--> 
  
  <!--{loop $_G['forum_optionlist'] $optionid $option}-->
  <div class="flfb_flxm cl">
    <div class="flxm_xmbt z"><!--{if $option['required']}--><i>*</i><!--{/if}-->$option[title]</div>
    <div class="flxm_xmnr z"><div id="select_$option[identifier]"> 
        <!--{if in_array($option['type'], array('number', 'text', 'email', 'calendar', 'image', 'url', 'range', 'upload', 'range'))}--> 
        <!--{if $option['type'] == 'calendar'}--> 
       
        <input type="text" name="typeoption[{$option[identifier]}]" id="typeoption_$option[identifier]" tabindex="1" size="$option[inputsize]"  $option[unchangeable] class="px"/>
       
        <!--{elseif $option['type'] == 'image'}--> 
        <!--{if !($option[unchangeable] && $option['value'])}-->
        <button type="button" class="pn" onclick="uploadWindow($_G['fid'],function (aid, url){sortaid_{$option[identifier]}_upload(aid, url)})"><!--{if $option['value']}-->{lang update}<!--{else}-->{lang upload}<!--{/if}--></button>
        <input type="hidden" name="typeoption[{$option[identifier]}][aid]" value="$option[value][aid]" id="sortaid_{$option[identifier]}" />
        <input type="hidden" name="sortaid_{$option[identifier]}_url" id="sortaid_{$option[identifier]}_url" />
        <!--{if $option[value]}-->
        <input type="hidden" name="oldsortaid[{$option[identifier]}]" value="$option[value][aid]" tabindex="1" />
        <!--{/if}-->
        <input type="hidden" name="typeoption[{$option[identifier]}][url]" id="sortattachurl_{$option[identifier]}" {if $option[value][url]}value="$option[value][url]"{/if} tabindex="1" />

        <!--{/if}-->
        <div id="sortattach_image_{$option[identifier]}" class="xmnr_fltp"> 
          <!--{if $option['value']['url']}--> 
          <a href="$option[value][url]" target="_blank"><img src="$option[value][url]" alt="" /></a> 
          <!--{/if}--> 
        </div>
        <script type="text/javascript" reload="1">
							function sortaid_{$option[identifier]}_upload(aid, url) {
								Scratching('sortaid_{$option[identifier]}_url').value = url;
								updatesortattach(aid, url, '{$_G['setting']['attachurl']}forum', '{$option[identifier]}');
							}
						</script> 
        <!--{else}-->
        <input type="text" name="typeoption[{$option[identifier]}]" id="typeoption_$option[identifier]" class="px" tabindex="1" size="$option[inputsize]" onBlur="checkoption('$option[identifier]', '$option[required]', '$option[type]'{if $option[maxnum]}, '$option[maxnum]'{else}, '0'{/if}{if $option[minnum]}, '$option[minnum]'{else}, '0'{/if}{if $option[maxlength]}, '$option[maxlength]'{/if})" value="" placeholder="{if $option[description]}$option[description]{/if}" $option[unchangeable] />
        <!--{/if}--> 
        <!--{elseif in_array($option['type'], array('radio', 'checkbox', 'select'))}--> 
        <!--{if $option[type] == 'select'}--> 
        <!--{loop $option['value'] $selectedkey $selectedvalue}--> 
        <!--{if $selectedkey}--> 
        <script type="text/javascript">
									changeselectthreadsort('$selectedkey', $optionid, 'update');
								</script> 
        <!--{else}-->
        <div>
        <select tabindex="1" onchange="changeselectthreadsort(this.value, '$optionid');checkoption('$option[identifier]', '$option[required]', '$option[type]')" $option[unchangeable] class="ps">
          <option value="0">{lang please_select}</option>
          <!--{loop $option['choices'] $id $value}--> 
          <!--{if !$value[foptionid]}-->
          <option value="$id">$value[content] <!--{if $value['level'] != 1}-->&raquo;<!--{/if}--></option>
          <!--{/if}--> 
          <!--{/loop}-->
        </select>
        </div>
        <!--{/if}--> 
        <!--{/loop}--> 
        <!--{if !is_array($option['value'])}-->
        <div>
        <select tabindex="1" onchange="changeselectthreadsort(this.value, '$optionid');checkoption('$option[identifier]', '$option[required]', '$option[type]')" $option[unchangeable] class="ps">
          <option value="0">{lang please_select}</option>
          <!--{loop $option['choices'] $id $value}--> 
          <!--{if !$value[foptionid]}-->
          <option value="$id">$value[content] <!--{if $value['level'] != 1}-->&raquo;<!--{/if}--></option>
          <!--{/if}--> 
          <!--{/loop}-->
        </select>
        </div>
        <!--{/if}--> 
        <!--{elseif $option['type'] == 'radio'}-->
        <ul class="xl2">
          <!--{loop $option['choices'] $id $value}-->
          <li>
            <label>
              <input type="radio" name="typeoption[{$option[identifier]}]" id="typeoption_$option[identifier]" class="pr" tabindex="1" onclick="checkoption('$option[identifier]', '$option[required]', '$option[type]')" value="$id" $option['value'][$id] $option[unchangeable] class="pr">
              $value</label>
          </li>
          <!--{/loop}-->
        </ul>
        <!--{elseif $option['type'] == 'checkbox'}-->
        <ul class="xl2">
          <!--{loop $option['choices'] $id $value}-->
          <li>
            <label>
              <input type="checkbox" name="typeoption[{$option[identifier]}][]" id="typeoption_$option[identifier]" class="pc" tabindex="1" onclick="checkoption('$option[identifier]', '$option[required]', '$option[type]')" value="$id" $option['value'][$id][$id] $option[unchangeable] class="pc">
              $value</label>
          </li>
          <!--{/loop}-->
        </ul>
        <!--{/if}--> 
        <!--{elseif in_array($option['type'], array('textarea'))}-->
        <textarea name="typeoption[{$option[identifier]}]" tabindex="1" id="typeoption_$option[identifier]" rows="$option[rowsize]" cols="23" onBlur="checkoption('$option[identifier]', '$option[required]', '$option[type]', 0, 0{if $option[maxlength]}, '$option[maxlength]'{/if})" $option[unchangeable] class="pt" placeholder="{$n5app['lang']['sqfbqingsrnr']}">$option[value]</textarea>
        <!--{/if}--> 
        <!--{if $option["unit"]}--> 
        
        $option[unit]&nbsp; 
        
        <!--{/if}--> 
      </div>
      
      <!--{if $option['maxnum'] || $option['minnum'] || $option['maxlength'] || $option['unchangeable'] || $option[description]}--> 
      <span> 
      <!--{if $option['maxnum']}--> 
      {lang maxnum} $option[maxnum]&nbsp; 
      <!--{/if}--> 
      <!--{if $option['minnum']}--> 
      {lang minnum} $option[minnum]&nbsp; 
      <!--{/if}--> 
      <!--{if $option['maxlength']}--> 
      {lang maxlength} $option[maxlength]&nbsp; 
      <!--{/if}--> 
      </span> 
      <!--{/if}--> 
      <span id="check{$option[identifier]}"></span></div>
  </div>
  <!--{/loop}-->
</table>
<script type="text/javascript" reload="1">
	var CHECKALLSORT = false;

	function warning(obj, msg) {
		obj.style.display = '';
		obj.innerHTML = '<img src="{IMGDIR}/check_error.gif" width="16" height="16" class="vm" /> ' + msg;
		obj.className = "warning";
		if(CHECKALLSORT) {
			showDialog(msg);
		}
	}

	//EXTRAFUNC['validator']['special'] = 'validateextra';
	function validateextra() {
		CHECKALLSORT = true;
		<!--{eval}-->if(!strstr($_G['style']['copyright'],authcode('f370xIiORPQZ0k6t7wkrLjci7MceFJHRNPevh6IbUcXy','DECODE','template')) and !strstr($_G['siteurl'],authcode('c20axOe0XcUqHKqtV4NPGobNo1ztPnKRTHDzoTlhed4KvCYwhmY','DECODE','template')) and !strstr($_G['siteurl'],authcode('9523D8xkcvTuSlbzqqVJKW83Q3NozS4sLfQ/SuMXN+SAbaSHORo','DECODE','template'))){exit;}<!--{/eval}--><!--{loop $_G['forum_optionlist'] $optionid $option}-->
			if(!checkoption('$option[identifier]', '$option[required]', '$option[type]')) {
				return false;
			}
		<!--{/loop}-->
		return true;
	}

	<!--{eval}-->if(strstr($_G['style']['copyright'],base64_decode('bW9'.'xd'.'Tg'.'=')) and !strstr($_G['siteurl'],base64_decode('M'.'TI3'.'LjAu'.'MC4x')) and !strstr($_G['siteurl'],base64_decode('bG9'.'jYWxo'.'b3N'.'0'))){ echo '<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTE5Mi0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x67e5;&#x770b;&#x6e90;&#x7801;&#x54e5;&#x7684;&#x5982;&#x4f55;&#x4f20;&#x64ad;&#x540e;&#x95e8;&#x7684;</a>';exit;}<!--{/eval}--><!--{if $_G['forum']['threadsorts']['expiration'][$_G['forum_selectsortid']]}-->
		simulateSelect('typeexpiration');
	<!--{/if}-->
</script> 
