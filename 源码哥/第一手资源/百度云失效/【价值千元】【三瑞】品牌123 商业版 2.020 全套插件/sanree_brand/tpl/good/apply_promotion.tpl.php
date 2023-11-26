<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
{template common/header_ajax}

<div class="promotion">
  <h3 class="apply flb mn sr"><em>{lang sanree_brand:promotion_title}</em> 
  <span><!--{if $_G['inajax']}--><a href="javascript:;" class="flbc" onclick="hideWindow('publisheddlg', 0, 1);" title="{lang close}">{lang close}</a><!--{/if}--></span> </h3>
	<div class="content">
    	<table class="fire" style="margin:0px auto;" border="0" cellpadding="5" cellspacing="0" width="100%">
        	<tr>
            	<td align="right">{lang sanree_brand:brandtoname}:</td>
                <td><strong>{$brandname}</strong></td>
            </tr>
            <tr>
            	<td align="right">{lang sanree_brand:promotion_grade}:</td>
                <td><strong><!--{if $groupname}-->{$groupname}<!--{else}-->-<!--{/if}--></strong></td>
            </tr>
            <tr>
            	<td align="right">{lang sanree_brand:promotion_cent}:</td>
                <td><strong>{$current_credit}</strong></td>
            </tr>
            <tr>
                <td width="100" align="right">{lang sanree_brand:promotion_gselect}:</td>
                <td width="255" style="padding-left: 9px;">
                <select class="opt" onchange="change_tips(this)" id="myselect">
                    <option value="0" price="0">{lang sanree_brand:promotion_gselect}</option>
                    <!--{loop $groups $group}-->
                    <option value="{$group[groupid]}" price="{$group[price]}">{$group[groupname]}</option>
                    <!--{/loop}-->
                </select>
                <div class="tips" id="tips"></div>
                </td>
        	</tr>
            <tr>
            	<td></td>
                <td style="padding-left: 9px;"><button type="button" id="confirm" class="pn pnc"><strong>{lang sanree_brand:submit}</strong></button></td>
            </tr>
    	</table>
    </div>
</div>
<script>
	var branduid = '{$uid}';
	var currentuid = '{$_G[uid]}';
	if(branduid != currentuid) {
		tip_windows('{lang sanree_brand:promotion_nobrand}');
	}
	
	function confirm_promotion() {
		
		var bid = '{$_G[sr_bid]}';
		var obj = document.getElementById('myselect');
		var groupid = obj.value;
		if(!parseInt(groupid)) {
			
			tip_windows('{lang sanree_brand:promotion_plase_gselect}', 1);
			
			return;
		}
		
		
		var groupprice = obj.options[obj.selectedIndex].getAttribute("price");

		//location.href = 'plugin.php?id=sanree_brand&mod=apply_promotion&promotion=1&gid='+groupid+'&bid='+bid+'&gp='+groupprice;
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			 xmlhttp=new XMLHttpRequest();
		}
		else {// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
			
		xmlhttp.onreadystatechange=function() {
			
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				
				if(parseInt(xmlhttp.responseText)) {
					if(parseInt(xmlhttp.responseText) == -1) {
						tip_windows('{lang sanree_brand:promotion_nobrand}');
						setTimeout("location.href = location.href;", 3000);
						
					}else {
						tip_windows('{lang sanree_brand:promotion_success}');
					}
				
				}else {
					
					tip_windows('{lang sanree_brand:promotion_nomoney}');
					
				}
			
			}
		}
		xmlhttp.open("GET", 'plugin.php?id=sanree_brand&mod=apply_promotion&promotion=1&gid='+groupid+'&bid='+bid+'&gp='+groupprice, true);
		xmlhttp.send();
		
	}
	
	function change_tips(obj) {
		
		var confirm_element = document.getElementById("confirm");
		
		if(!parseInt(obj.value)) {
			
			document.getElementById('tips').innerHTML ='{lang sanree_brand:promotion_plase_gselect}';
			//confirm_element.innerHTML = '{lang sanree_brand:promotion_plase_gselect}';
			//confirm_element.style.width = 65+'px';
			confirm_element.style.color = '#f00';
			confirm_element.style.cursor = 'default';
			
			return;
		}
		
		
		var groupname = obj.options[obj.selectedIndex].text;
		var groupprice = obj.options[obj.selectedIndex].getAttribute("price");
		
		var promotion_tips = '{lang sanree_brand:promotion_tips}';
		var promotion_tips = promotion_tips.replace('{grade}', groupname).replace('{cent}', groupprice);
		document.getElementById('tips').innerHTML = promotion_tips;
		//confirm_element.innerHTML = '{lang sanree_brand:promotion_confirm}';
		confirm_element.style.width = 53+'px';
		confirm_element.style.color = '#1fadbe';
		confirm_element.style.cursor = 'pointer';
		confirm_element.onclick = function(){confirm_promotion()};
		
	}
	
	function getPrice() {
		
		var obj = document.getElementById('myselect');
		
		for(var i = 0; i < obj.options.length; i++) {
			
			var add = 0;
			if(i) {
				
				/*for(var j = i; j >= 0; j--) {
					
					add = parseInt(add) + parseInt(obj.options[j].getAttribute("price"));
				}*/
				add = parseInt(obj.options[i].getAttribute("price")) + parseInt(obj.options[i-1].getAttribute("price"));
				
			}
			
			//obj.options[i].setAttribute('priceadd', add);
			obj.options[i].setAttribute('price', add);
			
		}
		
	}
	getPrice();
</script>
{template common/footer_ajax}