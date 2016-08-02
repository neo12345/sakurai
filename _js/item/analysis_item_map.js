function initialize(result) {
	var lat = $('#lat').val();
	var lng = $('#lng').val();
	var zoom = parseInt($('#zoom').val());

	var mapProp = {
		center: new google.maps.LatLng(lat, lng),
		zoom: zoom,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		scrollwheel: false,
	};
	var gm = google.maps;
	var map = new gm.Map(document.getElementById("googleMap"), mapProp);
	var oms = new OverlappingMarkerSpiderfier(map, {markersWontMove: false, markersWontHide: false});
	var bounds = new gm.LatLngBounds();
	
	var marker = new google.maps.Marker({
		position: new google.maps.LatLng(lat, lng),
	});
	
	marker.setMap(map);
		
	var i;
	var selling = 0;
	var soldout = 0;
	var avg_time = 0;
	var sum_time = 0;
	
	for (i = 0; i < result.length; i++) {
		sum_time = sum_time + parseInt(result[i].time);
	}
	avg_time = Math.ceil(sum_time / result.length);
	avg_time = (avg_time > 0) ? avg_time:'----';
	
	var bfr_complete = 0;
	for (i = 0; i < result.length; i++) {
		if (result[i].status == 1) {
			selling++;
		}
		if (result[i].status > 1) {
			soldout++;
		}
		if (result[i].status == 3) {
			bfr_complete++;
		}
	}
	
	$("#selling").html("販売中物件数: " + selling + '件');
	$("#soldout").html("成約済物件数: " + soldout + '件');
	$("#avg_time").html("平均売出期間: " + avg_time + "日間");
	$("#bfr_complete").html("完成前成約数: " + bfr_complete + '件');

    var marker, i;
	var list_icon = [];
	var list_marker = [];
	var list_marker_cd = [];

	var image11 = {
	  url: '/_img/common/map-markers/map-marker-11.png',
	  size: new google.maps.Size(71, 71),
	  anchor: new google.maps.Point(15, 30),
	  scaledSize: new google.maps.Size(30, 30)
	};
	var image12 = {
	  url: '/_img/common/map-markers/map-marker-12.png',
	  size: new google.maps.Size(71, 71),
	  anchor: new google.maps.Point(15, 30),
	  scaledSize: new google.maps.Size(30, 30)
	};
	var image13 = {
	  url: '/_img/common/map-markers/map-marker-13.png',
	  size: new google.maps.Size(71, 71),
	  anchor: new google.maps.Point(15, 30),
	  scaledSize: new google.maps.Size(30, 30)
	};
	var image21 = {
	  url: '/_img/common/map-markers/map-marker-21.png',
	  size: new google.maps.Size(71, 71),
	  anchor: new google.maps.Point(15, 30),
	  scaledSize: new google.maps.Size(30, 30)
	};
	var image22 = {
	  url: '/_img/common/map-markers/map-marker-22.png',
	  size: new google.maps.Size(71, 71),
	  anchor: new google.maps.Point(15, 30),
	  scaledSize: new google.maps.Size(30, 30)
	};	
	var image23 = {
	  url: '/_img/common/map-markers/map-marker-23.png',
	  size: new google.maps.Size(71, 71),
	  anchor: new google.maps.Point(15, 30),
	  scaledSize: new google.maps.Size(30, 30)
	};

	google.maps.event.addDomListener(map, 'click', function(){
		var j;
		for (j = 0; j < list_marker.length; j++) {
			list_marker[j].setIcon(list_icon[j].url);
		}													
															
		return $("#pop_up").hide();											
	});	
	
	//--------------------
    for (var i = 0; i < result.length; i ++) {
        var datum = result[i];
        var loc = new gm.LatLng(datum.lat, datum.lng);
        bounds.extend(loc);
        if (result[i].cat_item == 1 && result[i].status == 1) {
			marker = new google.maps.Marker({
				position: new google.maps.LatLng(result[i].lat, result[i].lng),
				map: map,
				icon: image11,
			});
			list_marker.push(marker);
			list_icon.push(image11);
			list_marker_cd.push(result[i].item_cd);
		} else if (result[i].cat_item == 1 && result[i].status == 2) {
			marker = new google.maps.Marker({
				position: new google.maps.LatLng(result[i].lat, result[i].lng),
				map: map,
				icon: image12,
			});
			list_marker.push(marker);
			list_icon.push(image12);
			list_marker_cd.push(result[i].item_cd);
		} else if (result[i].cat_item == 1 && result[i].status == 3) {
			marker = new google.maps.Marker({
				position: new google.maps.LatLng(result[i].lat, result[i].lng),
				map: map,
				icon: image13,
			});
			list_marker.push(marker);
			list_icon.push(image13);
			list_marker_cd.push(result[i].item_cd);
		} else if (result[i].cat_item == 2 && result[i].status == 1) {
			marker = new google.maps.Marker({
				position: new google.maps.LatLng(result[i].lat, result[i].lng),
				map: map,
				icon: image21,
			});
			list_marker.push(marker);
			list_icon.push(image21);
			list_marker_cd.push(result[i].item_cd);
		} else if (result[i].cat_item == 2 && result[i].status == 2) {
			marker = new google.maps.Marker({
				position: new google.maps.LatLng(result[i].lat, result[i].lng),
				map: map,

				icon: image22,
			});
			list_marker.push(marker);
			list_icon.push(image22);
			list_marker_cd.push(result[i].item_cd);
		} else {
			marker = new google.maps.Marker({
				position: new google.maps.LatLng(result[i].lat, result[i].lng),
				map: map,
				icon: image23,
			});
			list_marker.push(marker);
			list_icon.push(image23);
			list_marker_cd.push(result[i].item_cd);
		}
		
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
		
		if (result[i].status == 2) {
			var pop_up = '<div style="width: 320px; height: auto; background-color: white; padding: 10px 5px;border:groove thin;">'
						+ '<button id="btn_close" class="btn-close">X'
						+ '</button><table style="width: 100%; border: 0px">'
						+ '<tr><td colspan="2" style="border: 0px">'
						+ '<div style="font-size: 16px">' + result[i].item_name + '</div></td></tr>'
						+ '<tr><td style="width: 67%; border: 0px"><div style="font-size: 14px">' 
						+  year + '年' + month + '月' + date + '日</div></td>'
						+ '<td style="width: 33%; border: 0px" rowspan="2"><img width="100px" src="' + link_img + '"/></td>'
						+ '<tr><td style="width: 67%; border: 0px"><div style="font-size: 16px"><span style="color: red">成約価格 </span>'
						+ result[i].hist_price + '万円<br><span style="color: blue">売出期間 </span>'
						+ '<b>' + result[i].time + '日間</div></td></tr>'
						+ '<tr><td><button class="btn-map" id="btn-compare" value="' + item_cd + '">比較</button>    '
						+ '<a href="/item/?md=analysis_item&item_cd=' + item_cd
						+ '" target="_blank"><button class="btn-map" id="btn-detail">詳細</button></a></td><td></td></tr>'
						+ '</div>';
		} else if (result[i].status == 3) {
			var pop_up = '<div style="width: 320px; height: auto; background-color: white; padding: 10px 5px;border:groove thin;">'
						+ '<button id="btn_close" class="btn-close">X'
						+ '</button><table style="width: 100%; border: 0px">'
						+ '<tr><td colspan="2" style="border: 0px">'
						+ '<div style="font-size: 16px">' + result[i].item_name + '</div></td></tr>'
						+ '<tr><td style="width: 67%; border: 0px"><div style="font-size: 14px">' 
						+  year + '年' + month + '月' + date + '日</div></td>'
						+ '<td style="width: 33%; border: 0px" rowspan="2"><img width="100px" src="' + link_img + '"/></td>'
						+ '<tr><td style="width: 67%; border: 0px"><div style="font-size: 16px"><span style="color: red">成約価格 </span>'
						+ result[i].hist_price + '万円<br><span style="color: blue">売出前成約</span>'
						+ '</div></td></tr>'
						+ '<tr><td><button class="btn-map" id="btn-compare" value="' + item_cd + '">比較</button>    '
						+ '<a href="/item/?md=analysis_item&item_cd=' + item_cd
						+ '" target="_blank"><button class="btn-map" id="btn-detail">詳細</button></a></td><td></td></tr>'
						+ '</div>';	
		} else {
			var hist_change = '----';
			if (result[i].hist_change) {
				var day_change = new Date(result[i].hist_change);
				var now = new Date();
				var diff_change = Math.floor((now - day_change) / 86400 / 1000);
				var year_change = day_change.getFullYear();
				var month_change = day_change.getMonth() + 1;
				var date_change = day_change.getDate();
				hist_change =  year_change + '年' + month_change + '月' + date_change + '日 (' + diff_change + '日前)'; 
			}
			
			var pop_up = '<div style="width: 320px; height: auto; background-color: white; padding: 10px 5px;border:groove thin;">'
						+ '<button id="btn_close" class="btn-close">X'
						+ '</button><table style="width: 100%; border: 0px">'
						+ '<tr><td colspan="2" style="border: 0px">'
						+ '<div style="font-size: 16px">' + result[i].item_name + '</div></td></tr>'
						+ '<tr><td style="width: 67%; border: 0px"><div style="font-size: 14px">' 
						+  year + '年' + month + '月' + date + '日</div></td>'
						+ '<td style="width: 33%; border: 0px" rowspan="3"><img width="100px" src="' + link_img + '"/></td>'
						+ '<tr><td style="width: 67%; border: 0px"><div style="font-size: 16px"><span style="color: red">販売価格 </span>'
						+ '<b>' + result[i].hist_price + '万円</b></div></td></tr>'
						+ '<tr><td>価格改定日: ' + hist_change +'</td></tr>'
						+ '<tr><td><button class="btn-map" id="btn-compare" value="' + item_cd + '">比較</button>    '
						+ '<a href="/item/?md=analysis_item&item_cd=' + item_cd
						+ '" target="_blank"><button class="btn-map" id="btn-detail">詳細</button></a></td><td></td></tr>'
						+ '</div>';
		}
		
		var infowindow = new google.maps.InfoWindow();
		
		google.maps.event.addListener(marker, 'mouseout', (function(marker, i, infowindow) {
        	return function() {
			   infowindow.close(map, marker);
        	}
        })(marker, i, infowindow));
		
		google.maps.event.addListener(marker, 'click', (function(marker, pop_up, result, i) {
        	return function() {
				$("#pop_up").html(pop_up);
				$("#pop_up").show();
				var j;
				for (j = 0; j < list_marker.length; j++) {
					list_marker[j].setIcon(list_icon[j].url);
				}
				
				if (result[i].cat_item == 1 && result[i].status == 1) {
					marker.setIcon("/_img/common/map-markers/map-marker-11-click.png");
				} else if (result[i].cat_item == 1 && result[i].status == 2) {
					marker.setIcon("/_img/common/map-markers/map-marker-12-click.png");
				} else if (result[i].cat_item == 1 && result[i].status == 3) {
					marker.setIcon("/_img/common/map-markers/map-marker-13-click.png");
				} else if (result[i].cat_item == 2 && result[i].status == 1) {
					marker.setIcon("/_img/common/map-markers/map-marker-21-click.png");
				} else if (result[i].cat_item == 2 && result[i].status == 2) {
					marker.setIcon("/_img/common/map-markers/map-marker-22-click.png");
				} else {
					marker.setIcon("/_img/common/map-markers/map-marker-23-click.png");
				}
        	}
        })(marker, pop_up, result, i));
    
        oms.addMarker(marker);
      }

	window.map = map;
	window.oms = oms;
	
	var output = {
		list_marker: list_marker,
		list_marker_cd: list_marker_cd,
		};
	return output;
//----------------------------------
	
}