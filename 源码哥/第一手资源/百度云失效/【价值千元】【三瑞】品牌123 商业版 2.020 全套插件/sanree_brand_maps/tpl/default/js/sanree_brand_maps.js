var isbig = false;
var isshow=0;
var isquan = false;
sanree_jQuery(function() {
	var h = sanree_jQuery('#tdshowInfo').height() - 40;
	if (h<600) h = 600;
	sanree_jQuery('#mapshow').height(h);
});
function setthis(obj) {
	obj.value='';
}
function hasClass(ele, cls) {
    return ele.className.match(new RegExp('(\\s|^)' + cls + '(\\s|$)'));
}
function addClass(ele, cls) {
    if (!this.hasClass(ele, cls)) ele.className += " " + cls;
}
function removeClass(ele, cls) {
    if (hasClass(ele, cls)) {
        var reg = new RegExp('(\\s|^)' + cls + '(\\s|$)');
        ele.className = ele.className.replace(reg, ' ');
    }
}
function hiden_cata(){
	var cata = $("cata");
	var catebtn = $("catebtn");
	if(isshow == 0){
		cata.style.display="none";
		catebtn.className="cata_hidden";
		isshow =1;
	}else{
		cata.style.display="block";
		catebtn.className="cata_show";
		isshow =0;
	}
}
function hideinfolist(){
	var tdshowInfo = $("tdshowInfo");
	var showInfo = $("showInfo");
	var zhanbtn = $("zhanbtn");
	if (!isbig) {
		tdshowInfo.style.width = "0px";
		showInfo.style.display="none";
		zhanbtn.innerText = lang1;
	} else {
		tdshowInfo.style.width = "300px";
		showInfo.style.display="block";	
		zhanbtn.innerText = lang2;
	}
	isbig = !isbig;
}
function quanifolist(){
	var mapsmain = $("mapsmain");
	var onclass = 'mapsmainquan';
	var quanbtn = $("quanbtn");
	if (!isquan) {
		addClass(mapsmain,onclass);
		quanbtn.innerText = lang3;
	} else {
		removeClass(mapsmain,onclass);
		quanbtn.innerText = lang4;
	}
	isquan = !isquan;
}
(function($){  
    var map;
	var infowindow;
	var mapLat;
	var mapLng;
	var LatLngArray;
	var querycity;
	var defaultcity;
	var showMsg;
    $.fn.sanree_googlemap = function(options){  
        var defaults = {  
            defaultmappos: '39.91293336712716,116.39724969863891'
        }
		var options=sanree_jQuery.extend(defaults, options);
		var _self = this;
		var position_array=options.defaultmappos.split(',');
		_self.mapLat = parseFloat(position_array[0]);
		_self.mapLng = parseFloat(position_array[1]);
		_self.LatLngArray = options.LatLngArray; 
		_self.showMsg = options.showMsg; 
		_self.querycity = options.querycity;
		this.showShop = function(i) {
			ar=_self.LatLngArray[i].split(",");
			var point = new google.maps.LatLng(parseFloat(ar[0]),parseFloat(ar[1]));
			_self.map.setCenter(point);
			_self.infowindow.setPosition(point);
			_self.infowindow.setContent(_self.showMsg[i]);	
			_self.infowindow.open(_self.map);		
		};		
		this.codeAddress = function() {
			var address = _self.querycity;
			var geocoder = new google.maps.Geocoder();
			geocoder.geocode( { 'address': address}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					_self.map.setCenter(results[0].geometry.location);
				} else {
					_self.map.setZoom(5);
					_self.map.setCenter(new google.maps.LatLng(_self.defaultcity));
				}
			});			
		};
		this.addMark = function(i) {
			ar = _self.LatLngArray[i].split(",");
			var mapLatLng = new google.maps.LatLng(parseFloat(ar[0]),parseFloat(ar[1]));	
			var newMarker = new google.maps.Marker({map: _self.map,position:mapLatLng});
			newMarker.setIcon("http://www.google.com/mapfiles/marker"+String.fromCharCode("A".charCodeAt(0) + i)+".png");
			google.maps.event.addListener(newMarker, 'click', function() {
				_self.infowindow.setContent(_self.showMsg[i]);
				_self.infowindow.open(_self.map, this);
			});
		};			
		return this.each(function(){ 
			sanree_jQuery('#infolist dl',this).each(function(){sanree_jQuery(this).click(function(){_self.showShop(sanree_jQuery(this).attr('vk'))})});
			_self.map = new google.maps.Map(sanree_jQuery('#mapshow',this)[0], {scaleControl: true,scrollwheel:false});
			_self.map.setZoom(13);
			_self.map.setMapTypeId(google.maps.MapTypeId.ROADMAP);	
			if( isNaN(_self.mapLat) || isNaN(_self.mapLng) ){
				_self.codeAddress();
			}else{
				_self.map.setCenter(new google.maps.LatLng(_self.mapLat,_self.mapLng));
			}
			_self.infowindow = new google.maps.InfoWindow();
			for(i=0;i<_self.LatLngArray.length;i++){
				_self.addMark(i);
			}
			if (_self.LatLngArray.length>0) {
				ar=_self.LatLngArray[0].split(",");
				var point = new google.maps.LatLng(parseFloat(ar[0]),parseFloat(ar[1]));
				_self.map.setCenter(point);
				_self.infowindow.setPosition(point);
				_self.infowindow.setContent(_self.showMsg[0]);	
				_self.infowindow.open(_self.map);
			}
		});

    }
})(sanree_jQuery);

(function($){  
    var map;
	var infowindow;
	var mapLat;
	var mapLng;
	var LatLngArray;
	var querycity;
	var defaultcity;
	var showMsg;
	var newMarker;
    $.fn.sanree_baidumap = function(options){  
        var defaults = {  
            defaultmappos: '116.404,39.915'
        }
		var options=sanree_jQuery.extend(defaults, options);
		var _self = this;
		var position_array=options.defaultmappos.split(',');
		_self.mapLat = parseFloat(position_array[0]);
		_self.mapLng = parseFloat(position_array[1]);
		_self.LatLngArray = options.LatLngArray; 
		_self.showMsg = options.showMsg; 
		_self.infowindow = Array();
		_self.newMarker = Array();
		_self.querycity = options.querycity;
		this.showShop = function(i) {
			ar=_self.LatLngArray[i].split(",");
			var point = new BMap.Point(parseFloat(ar[0]),parseFloat(ar[1]));
			_self.newMarker[i].openInfoWindow(_self.infowindow[i]);	
			_self.map.centerAndZoom(point, 15);
		};		
		this.codeAddress = function() {
			var address = _self.querycity;
			var options = {  
				onSearchComplete: function(results){  
					if (local.getStatus() == BMAP_STATUS_SUCCESS){}  
				},
				renderOptions:{map: _self.map}
			};  
			var local = new BMap.LocalSearch(_self.map,options);			
			local.search(address);	
		};
		this.addMark = function(i) {
			ar = _self.LatLngArray[i].split(",");
			var point = new BMap.Point(parseFloat(ar[0]),parseFloat(ar[1]));	
			var markerImage= "http://ditu.baidu.com/img/markers.png";
			var I = new BMap.Icon(markerImage, new BMap.Size(23, 25), {imageOffset: new BMap.Size(0, -25*i)});
			_self.newMarker[i] = new BMap.Marker(point, {icon: I});
			_self.infowindow[i] =new BMap.InfoWindow(_self.showMsg[i], {title : '<span style="font-size:14px;color:#0A8021"></span>'});
			_self.newMarker[i].addEventListener("click", function(){this.openInfoWindow(_self.infowindow[i]);});	
			_self.map.addOverlay(_self.newMarker[i]);
		};			
		return this.each(function(){  		  
			sanree_jQuery('#infolist dl',this).each(function(){sanree_jQuery(this).click(function(){_self.showShop(sanree_jQuery(this).attr('vk'))})});
			_self.map = new BMap.Map(sanree_jQuery('#mapshow',this)[0]);
			var opts = {type: BMAP_NAVIGATION_CONTROL_LARGE}  
			_self.map.addControl(new BMap.NavigationControl(opts));
			if( isNaN(_self.mapLat) || isNaN(_self.mapLng) ){
				_self.codeAddress();
			}else{
				_self.map.centerAndZoom(new BMap.Point(_self.mapLat, _self.mapLng), 15);
			}
			for(i=0;i<_self.LatLngArray.length;i++){
				_self.addMark(i);
			}
			if (_self.LatLngArray.length>0) {
				ar=_self.LatLngArray[0].split(",");
				var point = new BMap.Point(parseFloat(ar[0]),parseFloat(ar[1]));
				_self.map.centerAndZoom(point, 15);			
				_self.newMarker[0].openInfoWindow(_self.infowindow[0]);
			}
		});
    }
})(sanree_jQuery); 