<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{if $_G['inajax']==1}-->
{template common/header_ajax}
<!--{else}-->
{subtemplate common/header}
<!--{/if}-->
<!--{if ($do=='show')}-->
<!--{if ($lng)}-->
	<!--{if $config[isbird]}-->
    <h3 class="flb mn sr"><em>{lang sanree_brand:bird_item_map}</em> 
      <span><!--{if $_G['inajax']}--><a href="javascript:;" class="flbc" onclick="hideWindow('publisheddlg', 0, 0);" title="{lang close}">{lang close}</a><!--{/if}--></span> </h3>
	<!--{/if}-->
<div style="width:520px;height:340px;border:1px solid gray" id="containermap"></div>
<script type="text/javascript">
	var lng = {$lng};
	var lat = {$lat};
	var popupID="popupID";
	var remindID ="remindID";
	var confirmHTML = '<div id="' + popupID + '"><div id="' + remindID + '" class="content">{$info}</div></div></div>';
	var opts1 = {title : '<span style="font-size:14px;color:#0A8021">{$info}</span>'};
	var t1 = "<div style='line-height:1.8em;font-size:12px; width:200px'><b>{lang sanree_brand:map_address}</b>{$brandresult['address']}<br /><b>{lang sanree_brand:map_tel}</b>{$brandresult['tel']}<br /><b>{lang sanree_brand:map_mouth}</b>";
	var t2 = "<!--{loop $starlist $star}--><img src='{$_G[siteurl]}{sr_brand_IMG}/st.png' /><!--{/loop}-->";
	var t3= "<a style='text-decoration:none;color:#2679BA;float:right'>>></a></div>";
	try{
		var infoWindow1 =new BMap.InfoWindow(t1 + t2 + t3, opts1);	
		var confirmWindow = new BMap.InfoWindow(confirmHTML, {offset: new BMap.Size(0, -8),width: 240});  	
		var markerImage= "http://ditu.baidu.com/img/markers.png";
		var I = new BMap.Icon(markerImage, new BMap.Size(23, 25), {imageOffset: new BMap.Size(0, 0 - 27 * 25 + 3)});
		var map = new BMap.Map("containermap");
		var point = new BMap.Point(lng||116.404, lat||39.915);
		map.centerAndZoom(point, 15);
		var marker = new BMap.Marker(point, {icon: I});
		map.addOverlay(marker);
		var opts = {type: BMAP_NAVIGATION_CONTROL_LARGE}  
		map.addControl(new BMap.NavigationControl(opts));
		map.addOverlay(infoWindow1);
		marker.openInfoWindow(infoWindow1);
		map.centerAndZoom(point,15);
	}
	catch(e){
		alert(e);
	}
	</script>
<!--{else}-->
&nbsp;
<!--{/if}-->
<!--{elseif $do=='marked'}-->
<h3 class="flb mn"> <em>{lang sanree_brand:markedinfo}{lang sanree_brand:baidumap}</em> <span><a href="javascript:;" class="flbc" onclick="hideWindow('showmap',1,0);" title="{lang close}">{lang close}</a></span> </h3>
<div style="text-align:right; margin-right:10px; height:25px; line-height:30px;"> <strong id="curCity">{$defaultcity}</strong> [<a id="curCityText" href="javascript:void(0)">{lang sanree_brand:chanagecity}</a>] </div>
<div style="width:520px;height:340px;border:1px solid gray" id="containermap"> </div>
<div class="map_popup" id="cityList" style="display:none;text-align: left;position: absolute;z-index: 99999;width: 522px;height: 424px;top:10px;">
  <div class="popup_main" style="background:#fff;border: 1px solid #8BA4D8;overflow: scroll; height:400px;">
    <div class="title" style="background: url('{sr_brand_IMG}/popup_title.gif') repeat scroll 0 0 transparent;
    color: #6688CC;font-size: 12px;font-weight: bold;height: 24px;line-height: 25px;padding-left: 7px;">{lang sanree_brand:citylist}</div>
    <div class="cityList" id="citylist_container"></div>
    <button id="popup_close" style="background: url('{sr_brand_IMG}/popup_close.gif') no-repeat scroll 0 0 transparent;
    border: 0 none;cursor: pointer;height: 12px;position: absolute;right: 4px;top: 6px;width: 12px;"></button>
  </div>
</div>
<script type="text/javascript">
	var popupID="popupID";
	var remindID ="remindID";
	var confirmID="confirmID";
	var okButtonID="okButtonID";
	var cancelButtonID="cancelButtonID";
	var map ;
	var confirmHTML = '<div id="' + popupID + '"><div id="' + remindID + '" class="content">{lang sanree_brand:markedinfo1}</div></div></div>';
	try{
		var confirmWindow = new BMap.InfoWindow(confirmHTML, {offset: new BMap.Size(0, -8),width: 240});  	
		var markerImage= "http://ditu.baidu.com/img/markers.png";
		var I = new BMap.Icon(markerImage, new BMap.Size(23, 25), {imageOffset: new BMap.Size(0, 0 - 27 * 25 + 3)	});
		map = new BMap.Map("containermap");
		var lng = {$lng};
		var lat = {$lat};
		var point = new BMap.Point(lng||116.404, lat||39.915);
		map.centerAndZoom(point, 15);
		var marker = new BMap.Marker(point, {icon: I});
		map.addOverlay(marker);
		marker.enableDragging(true);
		marker.addEventListener("dragstart",function(){});
		marker.addEventListener("dragend",function(p){Select(p.point)});
		var opts = {type: BMAP_NAVIGATION_CONTROL_LARGE}  
		map.addControl(new BMap.NavigationControl(opts));
		map.addOverlay(confirmWindow);
		marker.openInfoWindow(confirmWindow);
		var menu = new BMap.ContextMenu();
		var txtMenuItem = [
		  {
		   text:'{lang sanree_brand:marked}',
		   callback:function(p){
				map.clearOverlays();
				var marker = new BMap.Marker(p, {
						icon: I
					}), px = map.pointToPixel(p);
				map.addOverlay(marker); 
				marker.openInfoWindow(confirmWindow);
				marker.enableDragging(true);
				marker.addEventListener("dragstart",function(){});
				marker.addEventListener("dragend",function(p){Select(p.point)});		  
				Select(p)
			   }
		  }
		 ];
		 for(var i=0; i < txtMenuItem.length; i++){
		  menu.addItem(new BMap.MenuItem(txtMenuItem[i].text,txtMenuItem[i].callback,100));
		 }
		 map.centerAndZoom(point,15);
		 map.addContextMenu(menu);
		var myCl = new BMapLib.CityList({container : "citylist_container", map : map});
		myCl.addEventListener("cityclick", function(e) {
			document.getElementById("curCity").innerHTML = e.name;
			document.getElementById("cityList").style.display = "none";
		});
		 
	 }
	catch(e){ 
		alert(e);
	}
	function Select(s){
		var maptxt = s.lng+','+s.lat;
		$('mappoint_mappoint').value=maptxt;
	}
	document.getElementById("curCityText").onclick = function() {
		var cl = document.getElementById("cityList");
		if (cl.style.display == "none") {
			cl.style.display = "";
		} else {
			cl.style.display = "none";
		} 
	};
	document.getElementById("popup_close").onclick = function() {
		var cl = document.getElementById("cityList");
		if (cl.style.display == "none") {
			cl.style.display = "";
		} else {
			cl.style.display = "none";
		} 
	};	
</script>
<!--{/if}-->
<!--{if $_G['inajax']==1}-->
{template common/footer_ajax}
<!--{else}-->
{subtemplate common/footer}
<!--{/if}-->
