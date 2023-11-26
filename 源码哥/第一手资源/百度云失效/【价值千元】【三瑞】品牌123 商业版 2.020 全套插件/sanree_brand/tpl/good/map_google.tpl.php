<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{if $_G['inajax']==1}-->
{template common/header_ajax}
<!--{else}-->
{subtemplate common/header}
<!--{/if}-->
<!--{if ($do=='show')}-->
	<!--{if ($lng)}-->
	<div style="width:520px;height:340px;border:1px solid gray" id="containermap"></div>
	<script type="text/javascript">
	var lng = {$lng};
	var lat = {$lat};	
	var t1 = "<div style='line-height:1.8em;font-size:12px; width:200px'><b>{lang sanree_brand:map_address}</b>{$brandresult['address']}<br /><b>{lang sanree_brand:map_tel}</b>{$brandresult['tel']}<br /><b>{lang sanree_brand:map_mouth}</b>";
	var t2 = "<!--{loop $starlist $star}--><img src='{$_G[siteurl]}{sr_brand_IMG}/st.png' /><!--{/loop}-->";
	var t3= "<a style='text-decoration:none;color:#2679BA;float:right'>>></a></div>";
	function load() {
		try{
			var center = new google.maps.LatLng(lng || 39.91293336712716, lat|| 116.39724969863891);
			var defaultopt ={zoom: 15,mapTypeId: google.maps.MapTypeId.ROADMAP}; 
			map = new google.maps.Map(document.getElementById("containermap"),defaultopt);
			creatmarker(center);
			map.setCenter(center, 15); 
		}
		catch(e){
		}
	}
	
	function markwindow(center){
        var table= t1+t2+t3;
		infowindow = new google.maps.InfoWindow({
			content: table,  
			size: new google.maps.Size(50,50),  
			position: center  
		});  
		infowindow.open(map); 
		map.setCenter(center, 15);
	}
	function creatmarker(center){
	   marker = new google.maps.Marker({
		position: center,
		title: '',
		map: map,
		draggable: false
	  });
      markwindow(center);
	  google.maps.event.addListener(marker, 'click', function(e){infowindow.open(map);});	  
	}
	load();
	</script>
	<!--{else}-->
	&nbsp; 
	<!--{/if}-->
<!--{elseif $do=='marked'}-->
	<h3 class="flb mn">
	<em>{lang sanree_brand:markedinfo}{lang sanree_brand:googlemap}</em>
		<span><a href="javascript:;" class="flbc" onclick="hideWindow('showmap',1,0);" title="{lang close}">{lang close}</a></span>
	</h3>
      <div style="width:510px; height:30px; padding-top:5px;border-top:1px solid gray;border-left:1px solid gray;border-right:1px solid gray;text-align:right; padding-right:10px;">
	  <span style="color:#3333CC">{lang sanree_brand:searchcitytip}</span>
        <input type="text" id="myaddress" style="width: 120px; height:17px"  align="absmiddle" />
        <input type="button" id="mysearchbtn" value="{lang sanree_brand:searchbar}" align="absmiddle" />
      </div>	
	<div style="width:520px;height:340px;border:1px solid gray" id="containermap"></div>
<style>.context{font-size:12px;font-weight:bold;padding:10px;}</style>
<script type="text/javascript" reload="1">
	var map;
	var marker ;
	var lng = '{$lng}';
	var lat = '{$lat}';	
	var geocoder;
	var infowindow;
	
    function load() { 
		var center = new google.maps.LatLng(lng || 39.91293336712716, lat|| 116.39724969863891);
		var defaultopt ={zoom: 15,mapTypeId: google.maps.MapTypeId.ROADMAP}; 
 		map = new google.maps.Map(document.getElementById("containermap"),defaultopt);
		map.setCenter(center, 15); 
		createContextMenu(map);
		creatmarker(center);		
		geocoder = new google.maps.Geocoder();  
    }   
	function markwindow(x,y){
        var maptxt = x+','+y;
		$('mappoint_mappoint').value=maptxt;	
        var table= "<div><span>{lang sanree_brand:markedinfo1}</span></div>";
		var center = new google.maps.LatLng(x,y);
		infowindow = new google.maps.InfoWindow({
			content: table,  
			size: new google.maps.Size(50,50),  
			position: center  
		});  
		infowindow.open(map); 

	}
	function creatmarker(center){
	   if (marker) marker.setMap(null); 
	   if (infowindow) infowindow.setMap(null);  
	   marker = new google.maps.Marker({
		position: center,
		title: '',
		map: map,
		draggable: true
	  });
       markwindow(center.lat(),center.lng());
       google.maps.event.addListener(marker, "dragstart", function() {infowindow.close();});   
       google.maps.event.addListener(marker, "dragend", function() { markwindow(marker.getPosition().lat(),marker.getPosition().lng()); });    
	   google.maps.event.addListener(marker, 'click', function(e){ markwindow(marker.getPosition().lat(),marker.getPosition().lng()); });
	}
	function setmark(){
		contextmenu.style.visibility = "hidden";
		creatmarker(clickedPixel);	
	}
	function createContextMenu(map) {		
		google.maps.event.addListener(map, 'rightclick',
		function(event) {
			var currentLatLng = event.latLng; 
			creatmarker(currentLatLng);
		});
		google.maps.event.addListener(map, "click",function() {contextmenu.style.visibility = "hidden";});
	}	
	document.getElementById("mysearchbtn").onclick = function() {
	    var address = $("myaddress").value;
			if(address=='') return;
			geocoder.geocode({address:address},function(results, status) {  
			if (status == google.maps.GeocoderStatus.OK) { 
				var point = results[0].geometry.location;
				map.setCenter(point, 13);  
				creatmarker(point);
			}
		}); 		
	};
	load();
    </script>
<!--{/if}-->
<!--{if $_G['inajax']==1}-->
{template common/footer_ajax}
<!--{else}-->
{subtemplate common/footer}
<!--{/if}-->