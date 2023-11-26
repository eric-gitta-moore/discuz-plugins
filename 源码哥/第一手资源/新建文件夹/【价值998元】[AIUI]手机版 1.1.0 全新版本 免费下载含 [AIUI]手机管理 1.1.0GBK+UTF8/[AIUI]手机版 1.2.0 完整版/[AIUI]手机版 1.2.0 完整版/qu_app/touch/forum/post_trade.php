<?PHP exit('QQÈº£º550494646');?>
<input type="hidden" name="trade" value="yes" />
<input type="hidden" name="item_type" value="1" />
<div class="trad_exfm cl">
	<p class="info cl">{lang post_message1}</p>
	<div class="cl">
    <table cellspacing="0" cellpadding="0" class="a_sorttfm">
    	<tr>
        	<th><label for="item_name">{lang post_trade_name}</label><span class="rq">*</span></th>
            <td><input type="text" name="item_name" id="item_name" class="px oinf" value="$trade[subject]" tabindex="1" /></td>
        </tr>
        <tr>
        	<th><label for="item_number">{lang post_trade_number}</label><span class="rq">*</span></th>
            <td>
            	<div class="spmf">
					<em>
						<input type="text" name="item_number" id="item_number" class="px" value="$trade[amount]" tabindex="1" />
					</em>
					<em>
						<span class="ftid">
							<select class="ps" width="108" name="item_quality" tabindex="1">
								<option value="1" {if $trade['quality'] == 1}selected="selected"{/if}>{lang trade_new}</option>
								<option value="2" {if $trade['quality'] == 2}selected="selected"{/if}>{lang trade_old}</option>
							</select>
						</span>
					</em>
				</div>
            </td>
        </tr>
        <tr>
        	<th><label for="transport">{lang post_trade_transport}</label></th>
            <td>
            	<span class="ftid">
					<select name="transport" width="108" change="$('logisticssetting').style.display = $('transport').value == 'virtual' ? 'none' : ''" class="ps">
						<option value="virtual" {if $trade['transport'] == 3}selected="selected"{/if}>{lang post_trade_transport_virtual}</option>
						<option value="seller" {if $trade['transport'] == 1}selected="selected"{/if}>{lang post_trade_transport_seller}</option>
						<option value="buyer" {if $trade['transport'] == 2}selected="selected"{/if}>{lang post_trade_transport_buyer}</option>
						<option value="logistics" {if $trade['transport'] == 4}selected="selected"{/if}>{lang trade_type_transport_physical}</option>
						<option value="offline" {if $trade['transport'] == 0}selected="selected"{/if}>{lang post_trade_transport_offline}</option>
					</select>
				</span>
            </td>
        </tr>
        <tr>
        	<th>{lang post_trade_price}<span class="rq">*</span></th>
            <td>
            	<div class="smmb">
					<em>
						<input type="text" name="item_price" id="item_price" class="px" value="$trade[price]" tabindex="1" />
						<label for="item_price">{lang post_current_price}</label>
					</em>
					<em>
						<input type="text" name="item_costprice" id="item_costprice" class="px" value="$trade[costprice]" tabindex="1" />
						<label for="item_costprice">{lang post_original_price}</label>
					</em>
				</div>
				<!--{if $_G['setting']['creditstransextra'][5] != -1}-->
					<div class="smmb mbm">
						<em>
							<input type="text" name="item_credit" id="item_credit" class="px" value="$trade[credit]" tabindex="1" />
							<label for="item_credit">{lang post_current_credit}({$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][5]][title]})</label>
						</em>
						<em>
							<input type="text" name="item_costcredit" id="item_costcredit" class="px" value="$trade[costcredit]" tabindex="1" />
							<label for="item_costcredit">{lang post_original_credit}({$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][5]][title]})</label>
						</em>
					</div>
				<!--{/if}-->
				<div class="smmb mbm" id="logisticssetting" style="display:{if !$trade['transport'] || $trade['transport'] == 3}none{/if}">
					<em>
						<input type="text" name="postage_mail" id="postage_mail" class="px" value="$trade[ordinaryfee]" tabindex="1" />
						<label for="postage_mail">{lang post_trade_transport_mail}</label>
					</em>
					<em>
						<input type="text" name="postage_express" id="postage_express" class="px" value="$trade[expressfee]" tabindex="1" />
						<label for="postage_express">{lang post_trade_transport_express}</label>
					</em>
					<em>
						<input type="text" name="postage_ems" id="postage_ems" class="px" value="$trade[emsfee]" tabindex="1" />
						<label for="postage_ems">EMS</label>
					</em>
				</div>
            </td>
        </tr>
        <tr>
        	<th><label for="paymethod">{lang post_trade_paymethod}</label></th>
            <td>
            	<span class="ftid">
					<select name="paymethod" width="108" change="display('tenpayseller')" class="ps" tabindex="1">
						<!--{if $_G[setting][ec_tenpay_opentrans_chnid]}--><option value="0" {if $trade[tenpayaccount]}selected{/if}>{lang post_trade_paymethod_online}</option><!--{/if}-->
						<option value="1" {if !$trade[tenpayaccount]}selected{/if}>{lang post_trade_paymethod_offline}</option>
					</select>
				</span>
            </td>
        </tr>
        {if $trade[tenpayaccount]}
        <tr>
        	<th><label for="tenpay_account">{lang post_trade_tenpay_seller}</label></th>
            <td><input type="text" name="tenpay_account" id="tenpay_account" class="px" value="$trade[tenpayaccount]" tabindex="2" /></td>
        </tr>
        {/if}
        <tr>
        	<th><label for="item_locus">{lang post_trade_locus}</label></th>
            <td><input type="text" name="item_locus" id="item_locus" class="px oinf2" value="$trade[locus]" tabindex="1" /></td>
        </tr>
        <tr>
        	<th><label for="item_expiration">{lang valid_before}</label></th>
            <td>
            	<input type="text" name="item_expiration" id="item_expiration" class="ainuo_calendar px oinf2" autocomplete="off" value="$trade[expiration]" tabindex="1" readonly="readonly" />
               
            </td>
        </tr>
        <!--{if $allowpostimg}-->
        <tr>
        	<th>{lang post_trade_picture}</th>
            <td>
            	<div class="activity_upimg cl">
                	<!--{if $tradeattach[attachment]}-->
						<img src="$tradeattach[url]/{if $tradeattach['thumb']}{eval echo getimgthumbname($tradeattach['attachment']);}{else}$tradeattach[attachment]{/if}" />
					<!--{/if}-->
                </div>
                
            	<div class="a_upactpic cl">
                	<span id="act_btn" class="act_btn"><!--{if $tradeattach[attachment]}-->$alang_xgtp<!--{else}-->$alang_sctp<!--{/if}--></span>
                	<input type="file" name="filedatatrade" id="filedatatrade" class="actupbtn" />
                </div>
                <input type="hidden" name="tradeaid" id="tradeaid" {if $tradeattach[attachment]}value="$tradeattach[aid]" {/if}/>
                <input type="hidden" name="tradeaid_url" id="tradeaid_url" />
            </td>
        </tr>
        <!--{/if}-->
    </table>
    <!--{hook/post_trade_extra}-->
	</div>
	
</div>
<div class="grey_line cl"></div>
<script type="text/javascript" reload="1">
simulateSelect('item_quality');
simulateSelect('paymethod');
simulateSelect('transport');
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

EXTRAFUNC['validator']['special'] = 'validateextra';
function validateextra() {
	if($('postform').item_name.value == '') {
		showDialog('{lang post_goods_error_message_1}', 'alert', '', function () { $('postform').item_name.focus() });
		return false;
	}
	if($('postform').item_number.value == '') {
		showDialog('{lang post_goods_error_message_2}', 'alert', '', function () { $('postform').item_number.focus() });
		return false;
	}
	if($('postform').item_price.value == '' && $('postform').item_credit.value == '') {
		showDialog('{lang post_goods_error_message_3}', 'alert', '', function () { $('postform').item_price.focus() });
		return false;
	}
	return true;
}
function tradeaid_upload(aid, url) {
	$('tradeaid_url').value = url;
	updatetradeattach(aid, url, '{$_G['setting']['attachurl']}forum');
}
</script>

<script type="text/javascript">
$(document).on('change', '#filedatatrade', function() {
	Zepto('.page').append('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
	uploadsuccess = function(data) {
		if(data == '') {
			popup.open('$alang_uperror', 'alert');
		}
		var dataarr = data.split('|');
		if(dataarr[0] == 'DISCUZUPLOAD' && dataarr[2] == 0) {
			Zepto('.ainuooverlay').remove();
			$('#tradeaid').val(dataarr[3]);
			$('#tradeaid_url').val('/' + dataarr[5]);
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
<script type="text/javascript">
	var forum_optionlist = <!--{if $forum_optionlist}-->'$forum_optionlist'<!--{else}-->''<!--{/if}-->;
</script> 
<script type="text/javascript" src="template/qu_app/touch/style/js/post/threadsorts.js?{VERHASH}"></script>
