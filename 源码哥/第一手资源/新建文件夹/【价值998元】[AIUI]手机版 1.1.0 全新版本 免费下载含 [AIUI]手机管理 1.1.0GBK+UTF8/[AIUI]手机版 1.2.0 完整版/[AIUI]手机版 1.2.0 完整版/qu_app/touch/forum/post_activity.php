<?PHP exit('QQÈº£º550494646');?>

<div class="act_exfm cl">
	<div class="asorttop cl">$alang_sorttip</div>
	<div class="cl">
    <table cellspacing="0" cellpadding="0" class="a_sorttfm">
    	<tr>
        	<th>{lang post_event_time}<span class="rq">*</span></th>
            <td>
            	<div id="certainstarttime" {if $activity['starttimeto']}style="display: none"{/if}>
					<input type="text" name="starttimefrom[0]" id="starttimefrom_0" class="px ainuo_calendar" autocomplete="off" value="$activity[starttimefrom]" tabindex="1" readonly="readonly" />
				</div>
				<div id="uncertainstarttime" {if !$activity['starttimeto']}style="display: none"{/if}>
					<input type="text" name="starttimefrom[1]" id="starttimefrom_1" class="px ainuo_calendar" autocomplete="off" value="$activity[starttimefrom]" tabindex="1" readonly="readonly" /><span> - </span><input type="text" autocomplete="off" id="starttimeto" name="starttimeto" class="px ainuo_calendar" value="{if $activity['starttimeto']}$activity[starttimeto]{/if}" tabindex="1" readonly="readonly" />
				</div>
				<div class="spmf cl">
					<label for="activitytime"><input type="checkbox" id="activitytime" name="activitytime" class="pc" onclick="if(this.checked) {document.getElementById('certainstarttime').style.display='none';document.getElementById('uncertainstarttime').style.display='block';} else {document.getElementById('certainstarttime').style.display='block';document.getElementById('uncertainstarttime').style.display='none';}" value="1" {if $activity['starttimeto']}checked{/if} tabindex="1" />{lang activity_starttime_endtime}</label>
				</div>
            </td>
        </tr>
        <tr>
        	<th><label for="activityplace">{lang activity_space}<span class="rq">*</span></label></th>
            <td><input type="text" name="activityplace" id="activityplace" class="px oinf" value="$activity[place]" tabindex="1" /></td>
        </tr>
        <!--{if $_GET[action] == 'newthread'}-->
        <tr>
        	<th><label for="activitycity">{lang activity_city}</label></th>
            <td><input name="activitycity" id="activitycity" class="px" type="text" tabindex="1" /></td>
        </tr>
        <!--{/if}-->
        <tr>
        	<th><label for="activityclass">{lang activiy_sort}<span class="rq">*</span></label></th>
            <td>
            	<!--{if $activitytypelist}-->
					<ul id="activitytypelist" style="display: none">
					<!--{loop $activitytypelist $type}-->
						<li>$type</li>
					<!--{/loop}-->
					</ul>
				<!--{/if}-->
				<span><input type="text" id="activityclass" name="activityclass" class="px" value="$activity[class]" tabindex="1" /></span>
				<!--{if $activitytypelist}-->
                    <select id="activity_con" onchange="$('#activityclass').val($('#activity_con').find('option:selected').val());">
                    <!--{loop $activitytypelist $type}-->
                    <option value="$type">$type</option>
					<!--{/loop}-->
                    </select>
				<!--{/if}-->
            </td>
        </tr>
        <tr>
        	<th><label for="activitynumber">{lang activity_need_member}</label></th>
            <td>
            	<input type="text" name="activitynumber" id="activitynumber" class="px z" style="width:55px;" onkeyup="checkvalue(this.value, 'activitynumbermessage')" value="$activity[number]" tabindex="1" />
				<span class="ftid">
					<select name="gender">
						<option value="0" {if !$activity['gender']}selected="selected"{/if}>{lang unlimited}</option>
						<option value="1" {if $activity['gender'] == 1}selected="selected"{/if}>{lang male}</option>
						<option value="2" {if $activity['gender'] == 2}selected="selected"{/if}>{lang female}</option>
					</select>
				</span>
				<span id="activitynumbermessage"></span>
            </td>
        </tr>
        <!--{if $_G['setting']['activityfield']}-->
        <tr>
        	<th>{lang optional_data}</th>
            <td>
            	<ul class="xl2 cl">
				<!--{loop $_G['setting']['activityfield'] $key $val}-->
				<li><label for="userfield_$key"><input type="checkbox" name="userfield[]" id="userfield_$key" class="pc" value="$key"{if $activity['ufield']['userfield'] && in_array($key, $activity['ufield']['userfield'])} checked="checked"{/if} />$val</label></li>
				<!--{/loop}-->
				</ul>
            </td>
        </tr>
        <!--{/if}-->
        <!--{if $_G['setting']['activityextnum']}-->
        <tr>
        	<th><label for="extfield">{lang other_data}</label></th>
            <td>
            	<textarea name="extfield" id="extfield" class="pt" cols="50" style="width: 270px;"><!--{if $activity['ufield']['extfield']}-->$activity[ufield][extfield]<!--{/if}--></textarea><br />{lang post_activity_message} $_G['setting']['activityextnum'] {lang post_option}
            </td>
        </tr>
        <!--{/if}-->
        <!--{if $_G['setting']['activitycredit']}-->
        <tr>
        	<th><label for="activitycredit">{lang consumption_credit}</label></th>
            <td>
            	<input type="text" name="activitycredit" id="activitycredit" class="px" value="$activity[credit]" />&nbsp;{$_G['setting']['extcredits'][$_G['setting']['activitycredit']][title]}
				
            </td>
        </tr>
        <!--{/if}-->
        <tr>
        	<th><label for="cost">{lang activity_payment}</label></th>
            <td>
            	<input type="text" name="cost" id="cost" class="px" onkeyup="checkvalue(this.value, 'costmessage')" value="$activity[cost]" tabindex="1" />&nbsp;{lang payment_unit}
				<span id="costmessage"></span>
            </td>
        </tr>
        <tr>
        	<th><label for="activityexpiration">{lang post_closing}</label></th>
            <td>
            	<span>
					<input type="text" name="activityexpiration" id="activityexpiration" class="ainuo_calendar px" autocomplete="off" value="$activity[expiration]" tabindex="1"  readonly="readonly" />
				</span>
            </td>
        </tr>
        <!--{if $allowpostimg}-->
        
        <tr>
        	<th>$alang_hdfm</th>
            <td>
            	<div class="activity_upimg cl">
                	<!--{if $activityattach[attachment]}-->
						<img class="spimg" src="$activityattach[url]/{if $activityattach['thumb']}{eval echo getimgthumbname($activityattach['attachment']);}{else}$activityattach[attachment]{/if}" />
					<!--{/if}-->
                </div>
                
            	<div class="a_upactpic cl">
                	<span id="act_btn" class="act_btn"><!--{if $activityattach[attachment]}-->$alang_xgtp<!--{else}-->$alang_sctp<!--{/if}--></span>
                	<input type="file" name="filedatact" id="filedatact" class="actupbtn" />
                </div>
                <input type="hidden" name="activityaid" id="activityaid" {if $activityattach[attachment]}value="$activityattach[aid]" {/if}/>
                <input type="hidden" name="activityaid_url" id="activityaid_url" />
                
            </td>
        </tr>
        <!--{/if}-->
    </table>
	<!--{hook/post_activity_extra}-->
	</div>
	
</div>
<div class="grey_line cl"></div>
<script type="text/javascript">
	var forum_optionlist = <!--{if $forum_optionlist}-->'$forum_optionlist'<!--{else}-->''<!--{/if}-->;
</script> 
<script type="text/javascript" src="template/qu_app/touch/style/js/post/threadsorts.js?{VERHASH}"></script>
<script type="text/javascript" reload="1">
simulateSelect('gender');
function simulateSelect(selectId, widthvalue) {
	var selectObj = document.getElementById(selectId);
	if(!selectObj) return;
	if(BROWSER.other) {
		if(selectObj.getAttribute('change')) {
			selectObj.onchange = function () {eval(selectObj.getAttribute('change'));}
		}
		return;
	}
	var widthvalue = widthvalue ? widthvalue : 70;
	var defaultopt = selectObj.options[0] ? selectObj.options[0].innerHTML : '';
	var defaultv = '';
	var menuObj = document.createElement('div');
	var ul = document.createElement('ul');
	var handleKeyDown = function(e) {
		e = BROWSER.ie ? event : e;
		if(e.keyCode == 40 || e.keyCode == 38) doane(e);
	};
	var selectwidth = (selectObj.getAttribute('width', i) ? selectObj.getAttribute('width', i) : widthvalue) + 'px';
	var tabindex = selectObj.getAttribute('tabindex', i) ? selectObj.getAttribute('tabindex', i) : 1;

	for(var i = 0; i < selectObj.options.length; i++) {
		var li = document.createElement('li');
		li.innerHTML = selectObj.options[i].innerHTML;
		li.k_id = i;
		li.k_value = selectObj.options[i].value;
		if(selectObj.options[i].selected) {
			defaultopt = selectObj.options[i].innerHTML;
			defaultv = selectObj.options[i].value;
			li.className = 'current';
			selectObj.setAttribute('selecti', i);
		}
		li.onclick = function() {
			if(document.getElementById(selectId + '_ctrl').innerHTML != this.innerHTML) {
				var lis = menuObj.getElementsByTagName('li');
				lis[document.getElementById(selectId).getAttribute('selecti')].className = '';
				this.className = 'current';
				document.getElementById(selectId + '_ctrl').innerHTML = this.innerHTML;
				document.getElementById(selectId).setAttribute('selecti', this.k_id);
				document.getElementById(selectId).options.length = 0;
				document.getElementById(selectId).options[0] = new Option('', this.k_value);
				eval(selectObj.getAttribute('change'));
			}
			hideMenu(menuObj.id);
			return false;
		};
		ul.appendChild(li);
	}

	selectObj.options.length = 0;
	selectObj.options[0]= new Option('', defaultv);
	selectObj.style.display = 'none';
	selectObj.outerHTML += '<a href="javascript:;" id="' + selectId + '_ctrl" style="width:' + selectwidth + '" tabindex="' + tabindex + '">' + defaultopt + '</a>';

	menuObj.id = selectId + '_ctrl_menu';
	menuObj.className = 'sltm';
	menuObj.style.display = 'none';
	menuObj.style.width = selectwidth;
	menuObj.appendChild(ul);
	document.getElementById('append_parent').appendChild(menuObj);

	document.getElementById(selectId + '_ctrl').onclick = function(e) {
		document.getElementById(selectId + '_ctrl_menu').style.width = selectwidth;
		showMenu({'ctrlid':(selectId == 'loginfield' ? 'account' : selectId + '_ctrl'),'menuid':selectId + '_ctrl_menu','evt':'click','pos':'43'});
		doane(e);
	};
	document.getElementById(selectId + '_ctrl').onfocus = menuObj.onfocus = function() {
		_attachEvent(document.body, 'keydown', handleKeyDown);
	};
	document.getElementById(selectId + '_ctrl').onblur = menuObj.onblur = function() {
		_detachEvent(document.body, 'keydown', handleKeyDown);
	};
	document.getElementById(selectId + '_ctrl').onkeyup = function(e) {
		e = e ? e : window.event;
		value = e.keyCode;
		if(value == 40 || value == 38) {
			if(menuObj.style.display == 'none') {
				document.getElementById(selectId + '_ctrl').onclick();
			} else {
				lis = menuObj.getElementsByTagName('li');
				selecti = selectObj.getAttribute('selecti');
				lis[selecti].className = '';
				if(value == 40) {
					selecti = parseInt(selecti) + 1;
				} else if(value == 38) {
					selecti = parseInt(selecti) - 1;
				}
				if(selecti < 0) {
					selecti = lis.length - 1
				} else if(selecti > lis.length - 1) {
					selecti = 0;
				}
				lis[selecti].className = 'current';
				selectObj.setAttribute('selecti', selecti);
				lis[selecti].parentNode.scrollTop = lis[selecti].offsetTop;
			}
		} else if(value == 13) {
			var lis = menuObj.getElementsByTagName('li');
			lis[selectObj.getAttribute('selecti')].onclick();
		} else if(value == 27) {
			hideMenu(menuObj.id);
		}
	};
}
function checkvalue(value, message){
	if(!value.search(/^\d+$/)) {
		document.getElementById(message).innerHTML = '';
	} else {
		document.getElementById(message).innerHTML = '<b>{lang input_invalid}</b>';
	}
}

EXTRAFUNC['validator']['special'] = 'validateextra';
function validateextra() {
	if($('postform').starttimefrom_0.value == '' && $('postform').starttimefrom_1.value == '') {
		showDialog('{lang post_error_message_1}', 'alert', '', function () { if($('activitytime').checked) {$('postform').starttimefrom_1.focus();} else {$('postform').starttimefrom_0.focus();} });
		return false;
	}
	if($('postform').activityplace.value == '') {
		showDialog('{lang post_error_message_2}', 'alert', '', function () { $('postform').activityplace.focus() });
		return false;
	}
	if($('postform').activityclass.value == '') {
		showDialog('{lang post_error_message_3}', 'alert', '', function () { $('postform').activityclass.focus() });
		return false;
	}
	return true;
}
function activityaid_upload(aid, url) {
	$('activityaid_url').value = url;
	updateactivityattach(aid, url, '{$_G['setting']['attachurl']}forum');
}
</script>
<script type="text/javascript">
$(document).on('change', '#filedatact', function() {
	Zepto('.page').append('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
	uploadsuccess = function(data) {
		if(data == '') {
			popup.open('$alang_uperror', 'alert');
		}
		var dataarr = data.split('|');
		if(dataarr[0] == 'DISCUZUPLOAD' && dataarr[2] == 0) {
			Zepto('.ainuooverlay').remove();
			$('#activityaid').val(dataarr[3]);
			$('#activityaid_url').val('/' + dataarr[5]);
			$('.activity_upimg').html('<img src="data/attachment/forum/'+dataarr[5]+'" />');
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