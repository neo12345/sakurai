$(function(){

	//▼コンフィグ群▼//
	var div = $("#js_map").get(0);
	var lat_default = 33.54349050537885;
	var lng_default = 130.46014934778214;
	var zoom_default = 17;
	
	//▼ファンクション群▼//
	function MapInit() {
		var lat = $('#js_lat').val();
		var lng = $('#js_lng').val();
		var zoom = parseInt($('#js_zoom').val());
		if(!lat){ lat = lat_default; }
		if(!lng){ lng = lng_default; }
		if(!zoom){ zoom = zoom_default; }
		var option = {
			zoom: zoom,
			center: new google.maps.LatLng(lat, lng),
			scrollwheel: false,
			scaleControl: true,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			mapTypeControlOptions : {
				style : google.maps.MapTypeControlStyle.DROPDOWN_MENU
			}
		}
		var map = new google.maps.Map(div, option);
		google.maps.event.addListener(map, 'idle', function(){
			//MakeMarker();
		});
		google.maps.event.addListener(map, "drag", function(){
			MakeVal();
		});
		google.maps.event.addListener(map, "zoom_changed", function(){
			MakeVal();
		});
		google.maps.event.addListener(map, "center_changed", function(){
			MakeVal();
		});
		MakeVal();
		$(document).on('click','#js_search',function(){
			var word = $('#js_word').val();
			GeoCord(word);
		});
		$(document).on('click','#js_search_item',function(){
			var word = $('#js_pref option:selected').text() + $('#js_city option:selected').text() + $('#js_addr2').val() + $('#js_addr3').val();
			$('#js_word').val(word);
			GeoCord(word);
		});
		function MakeVal(){
			var lat = map.getCenter().lat();
			var lng = map.getCenter().lng();
			var zoom = map.getZoom();
			$('#js_lat').val(lat);
			$('#js_lng').val(lng);
			$('#js_zoom').val(zoom);
		}
		function GeoCord(word){
			var gc = new google.maps.Geocoder();
			gc.geocode({ address : word }, function(results, status){
				if (status == google.maps.GeocoderStatus.OK) {
					map.setCenter(results[0].geometry.location);
				}else{
					alert(status+" : ジオコードに失敗しました");
				}
			});
		}
	}
//	function MakeMarker(){
//		var w_map = $('#js_map').width();
//		var h_map = $('#js_map').height();
//		var w_marker = $('#js_marker').width();
//		var h_marker = $('#js_marker').height();
//		var top = (h_map-h_marker)/2 +"px";
//		var left = (w_map-w_marker)/2 +"px";
//		$('#js_map').css("position", "relative").append($('#js_marker'));
//		$('#js_marker').css({
//			position: "absolute",
//			top: top,
//			left: left,
//			zIndex: "10"
//		});
//	}

	//▼バインド群▼//
	$(document).on('blur', '#js_lat', function(){
		MapInit();
	});
	$(document).on('blur', '#js_lng', function(){
		MapInit();
	});
	
	
	
	//▼イニシャル群▼//
	MapInit();
	
	
});


