<?PHP exit('QQÈº£º550494646');?>

<script type="text/javascript">
	var forum_optionlist = <!--{if $forum_optionlist}-->'$forum_optionlist'<!--{else}-->''<!--{/if}-->;
</script> 

<input type="hidden" name="selectsortid" value="$_G['forum_selectsortid']" />
<!--{if $_G['forum_typetemplate']}-->
	<!--{if $_G['forum']['threadsorts']['description'][$_G['forum_selectsortid']] || $_G['forum']['threadsorts']['expiration'][$_G['forum_selectsortid']]}-->
		<div class="sinf bw0">
			<dl>
				<!--{if $_G['forum']['threadsorts']['description'][$_G['forum_selectsortid']]}-->
					<dt>{lang threadtype_description}</dt>
					<dd>$_G[forum][threadsorts][description][$_G[forum_selectsortid]]</dd>
				<!--{/if}-->
				<!--{if $_G['forum']['threadsorts']['expiration'][$_G['forum_selectsortid']]}-->
					<dt><span class="rq">*</span>{lang threadtype_expiration}</dt>
					<dd>
						<div class="ftid">
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
						<!--{if $_G['forum_optiondata']['expiration']}--><span class="fb">{lang valid_before}: $_G[forum_optiondata][expiration]</span><!--{/if}-->
					</dd>
				<!--{/if}-->
			</dl>
		</div>
	<!--{/if}-->
	$_G[forum_typetemplate]

<!--{else}-->
	<div class="asorttop cl">$alang_sorttip</div>
	<table cellspacing="0" cellpadding="0" class="a_sorttfm" width="100%">
	<!--{if $_G['forum']['threadsorts']['description'][$_G['forum_selectsortid']]}-->
		<tr>
			<td class="ptm pbm bbda" colspan="2"><strong>$_G[forum][threadsorts][description][$_G[forum_selectsortid]]</strong></td>
		</tr>
	<!--{/if}-->
	<!--{if $_G['forum']['threadsorts']['expiration'][$_G['forum_selectsortid']]}-->
		<tr>
			<th class="ptm pbm bbda">{lang threadtype_expiration}</th>
			<td class="ptm pbm bbda">
				<div class="ftid">
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
				<!--{if $_G['forum_optiondata']['expiration']}-->{lang valid_before}: $_G[forum_optiondata][expiration]<!--{/if}-->
			</td>
		</tr>
	<!--{/if}-->
	{eval $abgc = 1;}
	<!--{loop $_G['forum_optionlist'] $optionid $option}-->
    {eval $abgc++;}
		<tr>
			<th {if $abgc % 2 == 0}class="sortodd"{/if}>$option[title]<!--{if $option['required']}--><span class="rq">*</span><!--{/if}--></th>
			<td {if $abgc % 2 == 0}class="sortodd"{/if}>
				<div id="select_$option[identifier]">
				<!--{if in_array($option['type'], array('number', 'text', 'email', 'calendar', 'image', 'url', 'range', 'upload', 'range'))}-->
					<!--{if $option['type'] == 'calendar'}-->
						<script type="text/javascript" src="{$_G['setting']['jspath']}calendar.js?{VERHASH}"></script>
						<input type="text" name="typeoption[{$option[identifier]}]" id="typeoption_$option[identifier]" tabindex="1" onchange="checkoption('$option[identifier]', '$option[required]', '$option[type]')" value="$option[value]" onclick="showcalendar(event, this, false)" $option[unchangeable] class="px"/>
					<!--{elseif $option['type'] == 'image'}-->
						<!--{if !($option[unchangeable] && $option['value'])}-->
                        
                        <div id="sortattach_image_{$option[identifier]}" class="sortattach_image">
						<!--{if $option['value']['url']}-->
							<a href="$option[value][url]" target="_blank"><img class="spimg" src="$option[value][url]" alt="" /></a>
						<!--{/if}-->
						</div>
                        
                        <div class="a_upactpic cl">
                            <span id="act_btn" class="act_btn"><!--{if $option['value']}-->$alang_xgtp<!--{else}-->$alang_sctp<!--{/if}--></span>
                            <input type="file" id="sortfile_{$option[identifier]}" class="actupbtn" />
                            
                        </div>
                        <script type="text/javascript">
							$(document).on('change', '#sortfile_{$option[identifier]}', function() {

								popup.open('<div class="spinner"><div class="double-bounce1"></div><div class="double-bounce2"></div></div>');
								uploadsuccess = function(data) {
									if(data == '') {
										popup.open('$alang_uperror', 'alert');
									}
									var dataarr = data.split('|');
									if(dataarr[0] == 'DISCUZUPLOAD' && dataarr[2] == 0) {
										popup.close();
										$('#sortaid_{$option[identifier]}').val(dataarr[3]);
										$('#sortaid_{$option[identifier]}_url').val(dataarr[5]);
										$('#sortattachurl_{$option[identifier]}').val('data/attachment/forum/' + dataarr[5]);
										$('.sortattach_image').html('<a href="data/attachment/forum/'+dataarr[5]+'" target="_blank"><img src="data/attachment/forum/'+dataarr[5]+'" /></a>');
										document.getElementById('act_btn').innerHTML = '$alang_xiugaipic';
									} else {
										var sizelimit = '';
										if(dataarr[7] == 'ban') {
											sizelimit = '{lang uploadpicatttypeban}';
										} else if(dataarr[7] == 'perday') {
											sizelimit = '{lang donotcross}'+Math.ceil(dataarr[8]/1024)+'K)';
										} else if(dataarr[7] > 0) {
											sizelimit = '{lang donotcross}'+Math.ceil(dataarr[7]/1024)+'K)';
										}
										popup.open(STATUSMSG[dataarr[2]] + sizelimit, 'alert');
										return false;
									}
								};
								if(typeof FileReader != 'undefined' && this.files[0]) {
									$.buildfileupload({
										uploadurl:'misc.php?mod=swfupload&operation=upload&type=image&inajax=yes&infloat=yes&simple=2',
										files:this.files,
										uploadformdata:{uid:"$_G[uid]", hash:"$swfconfig[hash]"},
										uploadinputname:'Filedata',
										maxfilesize:"",
										success:uploadsuccess,
										error:function() {
											popup.open('$alang_uperror', 'alert');
										}
									});
								} else {
									$.ajaxfileupload({
										url:'misc.php?mod=swfupload&operation=upload&type=image&inajax=yes&infloat=yes&simple=2',
										uploadformdata:{uid:"$_G[uid]", hash:"$swfconfig[hash]"},
										dataType:'text',
										fileElementId:'filedata',
										success:uploadsuccess,
										error: function() {
											popup.open('$alang_uperror', 'alert');
										}
									});
								}
							});
							</script>

						<input type="hidden" name="typeoption[{$option[identifier]}][aid]" value="$option[value][aid]" id="sortaid_{$option[identifier]}" />
						<input type="hidden" name="sortaid_{$option[identifier]}_url" id="sortaid_{$option[identifier]}_url" />
						<!--{if $option[value]}--><input type="hidden" name="oldsortaid[{$option[identifier]}]" value="$option[value][aid]" tabindex="1" /><!--{/if}-->
						<input type="hidden" name="typeoption[{$option[identifier]}][url]" id="sortattachurl_{$option[identifier]}" {if $option[value][url]}value="$option[value][url]"{/if} tabindex="1" />
						<!--{/if}-->
                        
					<!--{else}-->
						<input type="text" name="typeoption[{$option[identifier]}]" id="typeoption_$option[identifier]" class="px" tabindex="1" onBlur="checkoption('$option[identifier]', '$option[required]', '$option[type]'{if $option[maxnum]}, '$option[maxnum]'{else}, '0'{/if}{if $option[minnum]}, '$option[minnum]'{else}, '0'{/if}{if $option[maxlength]}, '$option[maxlength]'{/if})" value="{if $_G['tid']}$option[value]{else}{if $member_profile[$option['profile']]}$member_profile[$option['profile']]{else}$option['defaultvalue']{/if}{/if}" $option[unchangeable] />
					<!--{/if}-->
				<!--{elseif in_array($option['type'], array('radio', 'checkbox', 'select'))}-->
					<!--{if $option[type] == 'select'}-->
						<!--{loop $option['value'] $selectedkey $selectedvalue}-->
							<!--{if $selectedkey}-->
							<!--{else}-->
								<select tabindex="1" onchange="changeselectthreadsort(this.value, '$optionid');checkoption('$option[identifier]', '$option[required]', '$option[type]')" $option[unchangeable] class="ps">
									<option value="0">{lang please_select}</option>
									<!--{loop $option['choices'] $id $value}-->
										<!--{if !$value[foptionid]}-->
										<option value="$id">$value[content] <!--{if $value['level'] != 1}-->&raquo;<!--{/if}--></option>
										<!--{/if}-->
									<!--{/loop}-->
								</select>
							<!--{/if}-->
						<!--{/loop}-->
						<!--{if !is_array($option['value'])}-->
							<select tabindex="1" onchange="changeselectthreadsort(this.value, '$optionid');checkoption('$option[identifier]', '$option[required]', '$option[type]')" $option[unchangeable] class="ps">
								<option value="0">{lang please_select}</option>
								<!--{loop $option['choices'] $id $value}-->
									<!--{if !$value[foptionid]}-->
									<option value="$id">$value[content] <!--{if $value['level'] != 1}-->&raquo;<!--{/if}--></option>
									<!--{/if}-->
								<!--{/loop}-->
							</select>
						<!--{/if}-->
					<!--{elseif $option['type'] == 'radio'}-->
						<ul class="xl2">
						<!--{loop $option['choices'] $id $value}-->
							<li><label><input type="radio" name="typeoption[{$option[identifier]}]" id="typeoption_$option[identifier]" class="pr" tabindex="1" onclick="checkoption('$option[identifier]', '$option[required]', '$option[type]')" value="$id" $option['value'][$id] $option[unchangeable] class="pr"> $value</label></li>
						<!--{/loop}-->
						</ul>
					<!--{elseif $option['type'] == 'checkbox'}-->
						<ul class="xl2">
						<!--{loop $option['choices'] $id $value}-->
							<li><label><input type="checkbox" name="typeoption[{$option[identifier]}][]" id="typeoption_$option[identifier]" class="pc" tabindex="1" onclick="checkoption('$option[identifier]', '$option[required]', '$option[type]')" value="$id" $option['value'][$id][$id] $option[unchangeable] class="pc"> $value</label></li>
						<!--{/loop}-->
						</ul>
					<!--{/if}-->
				<!--{elseif in_array($option['type'], array('textarea'))}-->
					<textarea name="typeoption[{$option[identifier]}]" tabindex="1" id="typeoption_$option[identifier]" rows="3" onBlur="checkoption('$option[identifier]', '$option[required]', '$option[type]', 0, 0{if $option[maxlength]}, '$option[maxlength]'{/if})" $option[unchangeable] class="px" style="width:95%">$option[value]</textarea>
				<!--{/if}-->
				$option[unit]
				</div>				 
				
			</td>
		</tr>
        <tr><td {if $abgc % 2 == 0}class="sortodd sorttip"{else}class="sorttip"{/if} colspan="2">
        	<span id="check{$option[identifier]}"></span>
            <!--{if $option['maxnum'] || $option['minnum'] || $option['maxlength'] || $option['unchangeable'] || $option[description]}-->
					<div class="d">
					<!--{if $option['maxnum']}-->
						{lang maxnum} $option[maxnum]&nbsp;
					<!--{/if}-->
					<!--{if $option['minnum']}-->
						{lang minnum} $option[minnum]&nbsp;
					<!--{/if}-->
					<!--{if $option['maxlength']}-->
						{lang maxlength} $option[maxlength]&nbsp;
					<!--{/if}-->
					<!--{if $option['unchangeable']}-->
						{lang unchangeable}&nbsp;
					<!--{/if}-->
					<!--{if $option[description]}-->
						$option[description]
					<!--{/if}-->
					</div>
				<!--{/if}-->
        </td></tr>
	<!--{/loop}-->
	</table>
    <div class="grey_line cl"></div>
<!--{/if}-->

<script type="text/javascript" reload="1">
	var CHECKALLSORT = false;

	function warning(obj, msg) {
		obj.style.display = '';
		obj.innerHTML = msg;
		obj.className = "warning";
		if(CHECKALLSORT) {
			showDialog(msg);
		}
	}

	function validateextra() {
		CHECKALLSORT = true;
		<!--{loop $_G['forum_optionlist'] $optionid $option}-->
			if(!checkoption('$option[identifier]', '$option[required]', '$option[type]')) {
				return false;
			}
		<!--{/loop}-->
		return true;
	}

	<!--{if $_G['forum']['threadsorts']['expiration'][$_G['forum_selectsortid']]}-->
		simulateSelect('typeexpiration');
	<!--{/if}-->
</script>


<script type="text/javascript" src="template/qu_app/touch/style/js/post/threadsorts.js?{VERHASH}"></script>