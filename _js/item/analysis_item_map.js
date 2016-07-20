function initialize() {
	var lat = $('#lat').val();
	var lng = $('#lng').val();
	var zoom = parseInt($('#zoom').val());

	var mapProp = {
		center: new google.maps.LatLng(lat, lng),
		zoom: zoom,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
	};

	var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

	var marker = new google.maps.Marker({
		position: new google.maps.LatLng(lat, lng),
	});
	
	marker.setMap(map);
	
	var item_cd = $('#item_cd').val();
	var result;
	
	$.ajax({
		url: "/item/?md=get_item_in_area&item_cd=" + item_cd,
		type: 'GET',
		dataType: "json",
		async: false,
		success: function (data) {
			result = data;
		}
	});
	
	var infowindow = new google.maps.InfoWindow();

    var marker, i;

	var image = {
	  url: '/_img/common/google-map-marker.png',
	  size: new google.maps.Size(71, 71),
	  scaledSize: new google.maps.Size(30, 30)
	};	
	
    for (i = 0; i < result.length; i++) {  
    	marker = new google.maps.Marker({
        	position: new google.maps.LatLng(result[i].lat, result[i].lng),
            map: map,
			icon: image,
      	});
		
		var date_regist = new Date(result[i].date_regist);
		var date = date_regist.getDate();
		var month = date_regist.getMonth() + 1;
		var year = date_regist.getFullYear();
		
		var item_cd = result[i].item_cd;
		if (item_cd < 10) {
				var folder = '00' . item_cd;
			}
			if (item_cd >= 10 && item_cd < 100) {
				var folder = '0' . item_cd;
			}
			if (item_cd >= 100) {
				var folder = item_cd;
			}
	
		var link_img = '/_up/item/' + folder + '/main_s.jpg';
		
		
		var content = '<div style="width: 300px; height: auto;">'
						+ '<table style="width: 100%; border: 0px">'
						+ '<tr><td colspan="2" style="border: 0px">'
						+ '<div style="font-size: 16px">' + result[i].item_name + '</div></td></tr>'
						+ '<tr><td style="width: 67%; border: 0px"><div style="font-size: 14px">' 
						+  year + '年' + month + '月' + date + '日</div></td>'
						+ '<td style="width: 33%; border: 0px" rowspan="2"><img width="100px" src="' + link_img + '"/></td>'
						+ '<tr><td style="width: 67%; border: 0px"><div style="font-size: 16px"><span style="color: blue">成約価格 </span>'
						+ '<b>' + result[i].hist_price + '万円</b></div></td></tr>'
						+ '</div>';
		
		google.maps.event.addListener(marker,'mouseover', (function(marker,content,infowindow){ 
			return function() {
			   infowindow.setContent(content);
			   infowindow.open(map,marker);
			};
    	})(marker,content,infowindow)); 
		
		
		google.maps.event.addListener(marker, 'mouseout', (function(marker, i) {
        	return function() {
			   infowindow.close(map, marker);
        	}
        })(marker, i));
    }
}

google.maps.event.addDomListener(window, 'load', initialize);