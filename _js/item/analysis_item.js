$(document).ready(function () {
	//window.rtime;
	//window.timeout = false;
	
	//auto draw map + chart
	window.chart_result;
	window.list_item_compare;
	window.list_marker;
	window.main_marker_loc;
	window.search_result;
	
	var similars = searchItemOnDemand();
	window.search_result = similars;
	
	var analysis = analysisGroupItem();
	insertAnalysisTable(analysis);
	
	window.list_marker = initialize(similars);
	window.main_marker_loc = window.list_marker.map.getCenter();
	
	google.charts.setOnLoadCallback(function(){ 
										window.chart_result = drawChart(similars); 
										var chart = window.chart_result.chart;
										google.visualization.events.addListener(chart, 'select', function() {
											var point = chart.getSelection();
											if (point.length > 0) {
												setChartEvent(point);
											}
										});
	});

	$(".overlay").hide();
	$("#pop_up").hide();
	
	$('#chart_div').bind('DOMNodeInserted', function(event) {
		if (event.type == 'DOMNodeInserted') {
			eventChangeChartLegends();
			/*window.rtime = new Date();
			if (window.timeout === false) {
				window.timeout = true;
				setTimeout(endChange, 20);
			}*/
		}
	});
	
	//auto redraw when resize
	$(window).resize(function(event){
		event.preventDefault();
		$(".overlay").show();			
		
		var zoom = window.list_marker.map.getZoom();
		var center = window.list_marker.map.getCenter();
		
		var similars = searchItemOnDemand();
		window.search_result = similars;
		
		var analysis = analysisGroupItem();
		insertAnalysisTable(analysis);
		
		window.list_item_compare = null;
		window.list_marker = initialize(similars);
		window.list_marker.map.setCenter(center);
		window.list_marker.map.getZoom(zoom);
		
		window.chart_result = drawChart(similars);
		
		change_marker_selected_icon();
		
		var chart = window.chart_result.chart;
		google.visualization.events.addListener(chart, 'select', function() {
			var point = chart.getSelection();
			if (point.length > 0) {
				setChartEvent(point);
			}
		});
		
		window.list_item_compare = window.chart_result.list_item_compare;
		chart = window.chart_result.chart;
		if (window.chart_result) {
			$(".overlay").fadeOut().delay(1500);
		}	
	});
	
	$('.view-chart').on('click', '#close_item1', function (event) {
		event.preventDefault();
		$(".overlay").show();
		//remove from list
		window.list_item_compare = removeItem(window.list_item_compare[0]);
		
		//change icon
		var j;
		for (j = 0; j < window.list_marker.list_marker.length; j++) {
			window.list_marker.list_marker[j].setIcon(window.list_marker.list_icon[j].url);
		}
		
		change_marker_selected_icon();
		change_map_zoom();
		
		if (window.chart_result) {
			$(".overlay").fadeOut().delay(1500);
		}	
		event.stopPropagation();
	});
	
	$('.view-chart').on('click', '#close_item2', function (event) {
		event.preventDefault();
		$(".overlay").show();
		//remove from list
		window.list_item_compare = removeItem(window.list_item_compare[1]);
		
		
		//change icon
		var j;
		for (j = 0; j < window.list_marker.list_marker.length; j++) {
			window.list_marker.list_marker[j].setIcon(window.list_marker.list_icon[j].url);
		}
		change_marker_selected_icon();
		change_map_zoom();
		
		if (window.chart_result) {
			$(".overlay").fadeOut().delay(1500);
		}
		event.stopPropagation();
	});
	
	$('.view-chart').on('click', '#close_item3', function (event) {
		event.preventDefault();
		$(".overlay").show();
		//remove from list
		window.list_item_compare = removeItem(window.list_item_compare[2]);
		
		
		//change icon
		var j;
		for (j = 0; j < window.list_marker.list_marker.length; j++) {
			window.list_marker.list_marker[j].setIcon(window.list_marker.list_icon[j].url);
		}
		change_marker_selected_icon();
		change_map_zoom();
		
		if (window.chart_result) {
			$(".overlay").fadeOut().delay(1500);
		}
		event.stopPropagation();
	});
	
	$('.view-chart').on('click', '#close_item4', function (event) {
		event.preventDefault();
		$(".overlay").show();
		//remove from list
		window.list_item_compare = removeItem(window.list_item_compare[3]);
		
		
		//change icon
		var j;
		for (j = 0; j < window.list_marker.list_marker.length; j++) {
			window.list_marker.list_marker[j].setIcon(window.list_marker.list_icon[j].url);
		}
		change_marker_selected_icon();
		change_map_zoom();
		
		if (window.chart_result) {
			$(".overlay").fadeOut().delay(1500);
		}
		event.stopPropagation();
	});
	
	$('.view-chart').on('click', '#close_item5', function (event) {
		event.preventDefault();
		$(".overlay").show();
		//remove from list
		window.list_item_compare = removeItem(window.list_item_compare[4]);
		
		
		//change icon
		var j;
		for (j = 0; j < window.list_marker.list_marker.length; j++) {
			window.list_marker.list_marker[j].setIcon(window.list_marker.list_icon[j].url);
		}
		change_marker_selected_icon();
		change_map_zoom();
		
		if (window.chart_result) {
			$(".overlay").fadeOut().delay(1500);
		}
		event.stopPropagation();
	});
	//---
	
	
	//auto redraw when click button search
	$('.tabl-analysis').on('click', '#btn_th', function (event) {
		event.preventDefault();
		window.chart_result = null;
		$("#pop_up").hide();
		$(".overlay").show();
		var zoom = window.list_marker.map.getZoom();		
		var analysis = analysisGroupItem();
		insertAnalysisTable(analysis);
		
		var similars = searchItemOnDemand();
		window.search_result = similars;
		
		window.list_marker = initialize(similars);
		window.chart_result = drawChart(similars);
		
		window.list_marker.map.setZoom(zoom);
		change_marker_selected_icon();
		
		chart = window.chart_result.chart;
		google.visualization.events.addListener(chart, 'select', function() {
			var point = chart.getSelection();
			if (point.length > 0) {
				setChartEvent(point);
			}
		});
		
		window.list_item_compare = window.chart_result.list_item_compare;
		
		if (window.chart_result) {
			$(".overlay").fadeOut().delay(1500);
		}
	});
	
	//close popup when click button close(X)
	$('#pop_up').on('click', '.btn-close', function () {
		$("#pop_up").hide();
		
		chart = window.chart_result.chart;	
    	chart.setSelection([]);
		
		var j;
		for (j = 0; j < window.list_marker.list_marker.length; j++) {
			window.list_marker.list_marker[j].setIcon(window.list_marker.list_icon[j].url);
		}
		change_marker_selected_icon();
    });
	
	//remove item when click button close(X)
	$('.form-compare-item').on('click', '.btn-close-item', function () {
		$(".overlay").show();
		
		var item_cd = $(this).val();
		//delete from queue
		var list_item = $("#list_item").val();
		
		while ( list_item != list_item.replace(',' + item_cd, '')) {
			list_item = list_item.replace(',' + item_cd, '');
		}
		
		$("#list_item").val(list_item);
		
		//recreate analysis table
		var formData = {
			list_item: $("#list_item").val(),
		};
		
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		})
		
		var result;
		
		$.ajax({
			url: "/item/?md=get_info_item",
			type: 'POST',
			data: formData,
			dataType: "json",
			async: false,
			success: function (data) {
				result = data;
				insertItem(result)
			}
		});
		//redraw chart
		var similars = searchItemOnDemand();
		window.search_result = similars;
		
		window.chart_result = drawChart(similars);
		//change icon
		var j;
		for (j = 0; j < window.list_marker.list_marker.length; j++) {
			window.list_marker.list_marker[j].setIcon(window.list_marker.list_icon[j].url);
		}
		change_marker_selected_icon();
		change_map_zoom();
		
		chart = window.chart_result.chart;
		google.visualization.events.addListener(chart, 'select', function() {
			var point = chart.getSelection();
			if (point.length > 0) {
				setChartEvent(point);
			}
		});

		window.list_item_compare = window.chart_result.list_item_compare;
		
		change_marker_selected_icon();
		change_map_zoom();
		
		if (window.chart_result) {
			$(".overlay").fadeOut().delay(1500);
		}
    });
	
	//redraw chart when click button compare
	$('#pop_up').on('click', '#btn-compare', function () {
		$(".overlay").show();											   
													   
		var item_cd = $(this).val();
		$("#list_item").val($("#list_item").val() + ',' + item_cd);		
		
		var formData = {
			list_item: $("#list_item").val(),
		};
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		})
		
		var result;
		
		$.ajax({
			url: "/item/?md=get_info_item",
			type: 'POST',
			data: formData,
			dataType: "json",
			async: false,
			success: function (data) {
				result = data;
				insertItem(result)
			}
		});

		var similars = searchItemOnDemand();
		window.search_result = similars;
		
		window.chart_result = drawChart(similars);
		change_marker_selected_icon();
		
		chart = window.chart_result.chart;
		google.visualization.events.addListener(chart, 'select', function() {
			var point = chart.getSelection();
			if (point.length > 0) {
				setChartEvent(point);
			}
		});

		window.list_item_compare = window.chart_result.list_item_compare;
		
		change_marker_selected_icon();
		change_map_zoom();
		
		if (window.chart_result) {
			$(".overlay").fadeOut().delay(1500);
		}
    });
});

function searchItemOnDemand() {
	//------------------------------------		
	//search in radius
	
	var item_cd = $('#item_cd').val();	
	var radius = $("#radius").val();
	var cat_item = new Array();
	$.each($("input[name='cat_item[]']:checked"), function() {
		cat_item.push($(this).val());
	});
	var condition = new Array();
	$.each($("input[name='condition[]']:checked"), function() {
		condition.push($(this).val());
	});
	var layout = new Array();
	$.each($("input[name='layout[]']:checked"), function() {
		layout.push($(this).val());
	});
	var seller = new Array();
	$.each($("input[name='seller[]']:checked"), function() {
		seller.push($(this).val());
	});
	if (document.getElementById('sold_before_complete').checked) {
		var sold_before_complete = 1;
	} else {
		var sold_before_complete = 0;
	}
	
	var formData = {
		item_cd: item_cd,
		cat_item: cat_item,
		condition: condition,
		layout: layout,
		seller: seller,
		radius: radius,
		sold_before_complete: sold_before_complete
	};		
	
	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		})
	var result
	$.ajax({
		url: "/item/?md=get_item_in_area",
		type: 'POST',
		data: formData,
		dataType: "json",
		async: false,
		success: function (data) {
			result = data;
		}
	});

	return result
}


function analysisGroupItem() {
	//------------------------------------		
	//search in radius
	
	var item_cd = $('#item_cd').val();	
	var radius = $("#radius").val();
	var cat_item = new Array();
	$.each($("input[name='cat_item[]']:checked"), function() {
		cat_item.push($(this).val());
	});
	var condition = new Array();
	$.each($("input[name='condition[]']:checked"), function() {
		condition.push($(this).val());
	});
	var layout = new Array();
	$.each($("input[name='layout[]']:checked"), function() {
		layout.push($(this).val());
	});
	var seller = new Array();
	$.each($("input[name='seller[]']:checked"), function() {
		seller.push($(this).val());
	});
	if (document.getElementById('sold_before_complete').checked) {
		var sold_before_complete = 1;
	} else {
		var sold_before_complete = 0;
	}
	
	var formData = {
		item_cd: item_cd,
		cat_item: cat_item,
		condition: condition,
		layout: layout,
		seller: seller,
		radius: radius,
		sold_before_complete: sold_before_complete
	};		
	
	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		})
	var result
	$.ajax({
		url: "/item/?md=get_info_group_item_in_area",
		type: 'POST',
		data: formData,
		dataType: "json",
		async: false,
		success: function (data) {
			result = data;
		}
	});
	
	return result
}


function insertItem(result) {
	//item 1
	if ( result[0].item_price != null ) {
		$('#item1_img').html('<button class="btn-close btn-close-item" id="item1-btn-close" value="'
							 + result[0].item_cd + '"><p style="font-size: large">x</p></button>'
							 + '<img width="100%" src="' + result[0].item_img + '" />');
		$('#item1_name').html(result[0].item_name);
		$('#item1_price').html(result[0].item_price + '万円（税込）');
		$('#item1_date_soldout').html(result[0].date_soldout);
		$('#item1_seller').html(result[0].seller);
		$('#item1_size_land').html(result[0].item_size_land);
		$('#item1_size_build').html(result[0].item_size_build);
		$('#item1_layout').html(result[0].item_layout);
		$('#item1_pubtrans').html(result[0].item_pubtrans);
		$('#item1_road').html(result[0].item_road);
		$('#item1_school').html(result[0].item_school);
		$('#item1_equip').html(result[0].item_equip);
		$('#item1_btn_details').html('<a href="/item/?md=analysis_item&item_cd=' + result[0].item_cd
										+ '" target="_blank"><button class="btn-ana-item"><span style="font-size:large;">詳　細</span></button></a>');
	} else {
		$('#item1_img').html('');
		$('#item1_name').html('');
		$('#item1_price').html('');
		$('#item1_date_soldout').html('');
		$('#item1_seller').html('');
		$('#item1_size_land').html('');
		$('#item1_size_build').html('');
		$('#item1_layout').html('');
		$('#item1_pubtrans').html('');
		$('#item1_road').html('');
		$('#item1_school').html('');
		$('#item1_equip').html('');
		$('#close_item1').html('');
		$('#item1_btn_details').html('');
	}
	
	//item 2
	if ( result[1].item_price != null ) {
		$('#item2_img').html('<button class="btn-close btn-close-item" id="item2-btn-close" value="'
							 + result[1].item_cd + '"><p style="font-size: large">x</p></button>'
							 + '<img width="100%" src="' + result[1].item_img + '" />');
		$('#item2_name').html(result[1].item_name);
		$('#item2_price').html(result[1].item_price + '万円（税込）');
		$('#item2_date_soldout').html(result[1].date_soldout);
		$('#item2_seller').html(result[1].seller);
		$('#item2_size_land').html(result[1].item_size_land);
		$('#item2_size_build').html(result[1].item_size_build);
		$('#item2_layout').html(result[1].item_layout);
		$('#item2_pubtrans').html(result[1].item_pubtrans);
		$('#item2_road').html(result[1].item_road);
		$('#item2_school').html(result[1].item_school);
		$('#item2_equip').html(result[1].item_equip);
		$('#item2_btn_details').html('<a href="/item/?md=analysis_item&item_cd=' + result[1].item_cd
										+ '" target="_blank"><button class="btn-ana-item"><span style="font-size:large;">詳　細</span></button></a>');
	} else {
		$('#item2_img').html('');
		$('#item2_name').html('');
		$('#item2_price').html('');
		$('#item2_date_soldout').html('');
		$('#item2_seller').html('');
		$('#item2_size_land').html('');
		$('#item2_size_build').html('');
		$('#item2_layout').html('');
		$('#item2_pubtrans').html('');
		$('#item2_road').html('');
		$('#item2_school').html('');
		$('#item2_equip').html('');
		$('#close_item2').html('');
		$('#item2_btn_details').html('');
	}
	
	//item 3
	if ( result[2].item_price != null ) {
		$('#item3_img').html('<button class="btn-close btn-close-item" id="item3-btn-close" value="'
							 + result[2].item_cd + '"><p style="font-size: large">x</p></button>'
							 + '<img width="100%" src="' + result[2].item_img + '" />');
		$('#item3_name').html(result[2].item_name);
		$('#item3_price').html(result[2].item_price + '万円（税込）');
		$('#item3_date_soldout').html(result[2].date_soldout);
		$('#item3_seller').html(result[2].seller);
		$('#item3_size_land').html(result[2].item_size_land);
		$('#item3_size_build').html(result[2].item_size_build);
		$('#item3_layout').html(result[2].item_layout);
		$('#item3_pubtrans').html(result[2].item_pubtrans);
		$('#item3_road').html(result[2].item_road);
		$('#item3_school').html(result[2].item_school);
		$('#item3_equip').html(result[2].item_equip);
		$('#item3_btn_details').html('<a href="/item/?md=analysis_item&item_cd=' + result[2].item_cd
										+ '" target="_blank"><button class="btn-ana-item"><span style="font-size:large;">詳　細</span></button></a>');
	} else {
		$('#item3_img').html('');
		$('#item3_name').html('');
		$('#item3_price').html('');
		$('#item3_date_soldout').html('');
		$('#item3_seller').html('');
		$('#item3_size_land').html('');
		$('#item3_size_build').html('');
		$('#item3_layout').html('');
		$('#item3_pubtrans').html('');
		$('#item3_road').html('');
		$('#item3_school').html('');
		$('#item3_equip').html('');
		$('#close_item3').html('');
		$('#item3_btn_details').html('');
	}
	
	//item 4
	if ( result[3].item_price != null ) {
		$('#item4_img').html('<button class="btn-close btn-close-item" id="item4-btn-close" value="'
							 + result[3].item_cd + '"><p style="font-size: large">x</p></button>'
							 + '<img width="100%" src="' + result[3].item_img + '" />');
		$('#item4_name').html(result[3].item_name);
		$('#item4_price').html(result[3].item_price + '万円（税込）');
		$('#item4_date_soldout').html(result[3].date_soldout);
		$('#item4_seller').html(result[3].seller);
		$('#item4_size_land').html(result[3].item_size_land);
		$('#item4_size_build').html(result[3].item_size_build);
		$('#item4_layout').html(result[3].item_layout);
		$('#item4_pubtrans').html(result[3].item_pubtrans);
		$('#item4_road').html(result[3].item_road);
		$('#item4_school').html(result[3].item_school);
		$('#item4_equip').html(result[3].item_equip);
		$('#item4_btn_details').html('<a href="/item/?md=analysis_item&item_cd=' + result[3].item_cd
										+ '" target="_blank"><button class="btn-ana-item"><span style="font-size:large;">詳　細</span></button></a>');
	} else {
		$('#item4_img').html('');
		$('#item4_name').html('');
		$('#item4_price').html('');
		$('#item4_date_soldout').html('');
		$('#item4_seller').html('');
		$('#item4_size_land').html('');
		$('#item4_size_build').html('');
		$('#item4_layout').html('');
		$('#item4_pubtrans').html('');
		$('#item4_road').html('');
		$('#item4_school').html('');
		$('#item4_equip').html('');
		$('#close_item4').html('');
		$('#item4_btn_details').html('');
	}
	
	//item 5
	if ( result[4].item_price != null ) {
		$('#item5_img').html('<button class="btn-close btn-close-item" id="item5-btn-close" value="'
							 + result[4].item_cd + '"><p style="font-size: large">x</p></button>'
							 + '<img width="100%" src="' + result[4].item_img + '" />');
		$('#item5_name').html(result[4].item_name);
		$('#item5_price').html(result[4].item_price + '万円（税込）');
		$('#item5_date_soldout').html(result[4].date_soldout);
		$('#item5_seller').html(result[4].seller);
		$('#item5_size_land').html(result[4].item_size_land);
		$('#item5_size_build').html(result[4].item_size_build);
		$('#item5_layout').html(result[4].item_layout);
		$('#item5_pubtrans').html(result[4].item_pubtrans);
		$('#item5_road').html(result[4].item_road);
		$('#item5_school').html(result[4].item_school);
		$('#item5_equip').html(result[4].item_equip);
		$('#item5_btn_details').html('<a href="/item/?md=analysis_item&item_cd=' + result[4].item_cd
										+ '" target="_blank"><button class="btn-ana-item"><span style="font-size:large;">詳　細</span></button></a>');
	} else {
		$('#item5_img').html('');
		$('#item5_name').html('');
		$('#item5_price').html('');
		$('#item5_date_soldout').html('');
		$('#item5_seller').html('');
		$('#item5_size_land').html('');
		$('#item5_size_build').html('');
		$('#item5_layout').html('');
		$('#item5_pubtrans').html('');
		$('#item5_road').html('');
		$('#item5_school').html('');
		$('#item5_equip').html('');
		$('#close_item5').html('');
		$('#item5_btn_details').html('');
	}
}


function removeItem(item_cd) {
		//delete from queue
		var item_cd = item_cd;
		var list_item = $("#list_item").val();
		
		while ( list_item != list_item.replace(',' + item_cd, '')) {
			list_item = list_item.replace(',' + item_cd, '');
		}
		
		$("#list_item").val(list_item);
		
		//recreate analysis table
		var formData = {
			list_item: $("#list_item").val(),
		};
		
		$.ajaxSetup({

			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		})
		
		var result;
		
		$.ajax({
			url: "/item/?md=get_info_item",
			type: 'POST',
			data: formData,
			dataType: "json",
			async: false,
			success: function (data) {
				result = data;
				insertItem(result)
			}
		});
		
		//redraw chart
		var similars = searchItemOnDemand();
		window.chart_result = drawChart(similars);
		
		change_map_zoom();
				
		chart = window.chart_result.chart;
		google.visualization.events.addListener(chart, 'select', function() {
			var point = chart.getSelection();
			if (point.length > 0) {
				setChartEvent(point);
			}
		});

		return window.chart_result.list_item_compare;
}


function endChange() {
	if (new Date() - window.rtime < 20) {
		setTimeout(endChange, 20);
	} else {
		eventChangeChartLegends();
		window.timeout = false;
	}               
}




function setChartEvent(point) {
	if (point.length > 0) {
		if (point[0].column == 7) {
			var i = window.list_marker.list_marker_cd.indexOf(window.chart_result.max_index);
			if (i >= 0) {
				var marker = window.list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
				window.list_marker.map.setCenter(marker.position);
			}
		}
		if (point[0].column == 10) {
			var i = window.list_marker.list_marker_cd.indexOf(window.chart_result.min_index);
			if (i >= 0) {
				var marker = window.list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
				window.list_marker.map.setCenter(marker.position);
			}
		}
		if (point[0].column == 13) {
			var i = window.list_marker.list_marker_cd.indexOf(window.list_item_compare[0]);
			if (i >= 0) {
				var marker = window.list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
				window.list_marker.map.setCenter(marker.position);
			}
		}
		if (point[0].column == 16) {
			var i = window.list_marker.list_marker_cd.indexOf(window.list_item_compare[1]);
			if (i >= 0) {
				var marker = window.list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
				window.list_marker.map.setCenter(marker.position);
			}
		}
		if (point[0].column == 19) {
			var i = window.list_marker.list_marker_cd.indexOf(window.list_item_compare[2]);
			if (i >= 0) {
				var marker = window.list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
				window.list_marker.map.setCenter(marker.position);
			}
		}
		if (point[0].column == 22) {
			var i = window.list_marker.list_marker_cd.indexOf(window.list_item_compare[3]);
			if (i >= 0) {
				var marker = window.list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
				window.list_marker.map.setCenter(marker.position);
			}
		}
		if (point[0].column == 25) {
			var i = window.list_marker.list_marker_cd.indexOf(window.list_item_compare[4]);
			if (i >= 0) {
				var marker = window.list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
				window.list_marker.map.setCenter(marker.position);
			}
		}
	}
}



function eventChangeChartLegends() {
	//change color
	//add close button
	$('g g text').each(function () { 
		var path = $(this).parent().parent().find('path');
		if(path.length){
			var pos = $(this).position();
			var offset = $(this).outerWidth();
			var left = pos.left + offset - 20;
			
			var distance = $(".view-chart").offset().top - $(this).offset().top;;
			var top = -distance - 6;
				
			switch (path.attr('stroke')) {
			case '#0000ff':
				$(this).attr('fill', '#0000ff');
				
				break;	
				
			case '#dfbadd':
				$(this).attr('fill', '#dfbadd');
				
				break;
				
			case '#be1d2c':
				$(this).attr('fill', '#be1d2c');
				
				break;
				
			case '#283890':
				$(this).attr('fill', '#283890');
				
				break;
			
			case '#ffa500':
				$(this).attr('fill', '#ffa500');
				
				$('#close_item1').attr('style', 'top: ' + top + 'px; left: ' + left + 'px');
				$('#close_item1').html('<button class="btn-close-chart"><p style="font-size: large">x</p></button>');
				break;
			
			case '#ffd700':
				$(this).attr('fill', '#ffd700');
				
				$('#close_item2').attr('style', 'top: ' + top + 'px; left: ' + left + 'px');
				$('#close_item2').html('<button class="btn-close-chart"><p style="font-size: large">x</p></button>');
				break;
				
			case '#00ffff':
				$(this).attr('fill', '#00ffff');
				
				$('#close_item3').attr('style', 'top: ' + top + 'px; left: ' + left + 'px');
				$('#close_item3').html('<button class="btn-close-chart"><p style="font-size: large">x</p></button>');
				break;
			
			case '#7fff00':
				$(this).attr('fill', '#7fff00');
				
				$('#close_item4').attr('style', 'top: ' + top + 'px; left: ' + left + 'px');
				$('#close_item4').html('<button class="btn-close-chart"><p style="font-size: large">x</p><button>');
				break;
			
			case '#ff1493':
				$(this).attr('fill', '#ff1493');
				
				$('#close_item5').attr('style', 'top: ' + top + 'px; left: ' + left + 'px');
				$('#close_item5').html('<button class="btn-close-chart"><p style="font-size: large">x</p><button>');
				break;
				
			default:
				break;
		}
		}					 
	});
}




function change_marker_selected_icon() {
	var str = $("#list_item").val();
	var list_item = str.split(",");
	
	var list_item_compare = Array();
	
	for (var j = list_item.length - 1; j >= 0; j--) {
		if (list_item_compare.length < 5 && list_item_compare.indexOf(list_item[j]) < 0 ){
			list_item_compare.push(list_item[j]);
		}
	}

	
	for ( var j = 0; j < list_item_compare.length; j++ ) {
		for ( var k = 0; k < window.search_result.length; k++) {
			if (window.search_result[k].item_cd == list_item_compare[j]) {
				break;
			}
		}
		if (k < window.search_result.length) {
			if (window.search_result[k].cat_item == 1 && window.search_result[k].status == 1) {
				window.list_marker.list_marker[k].setIcon({url: '/_img/common/map-markers/map-marker-11-highlight.gif'});
			} else if (window.search_result[k].cat_item == 1 && window.search_result[k].status == 2) {
				window.list_marker.list_marker[k].setIcon({url: '/_img/common/map-markers/map-marker-12-highlight.gif'});
			} else if (window.search_result[k].cat_item == 1 && window.search_result[k].status == 3) {
				window.list_marker.list_marker[k].setIcon({url: '/_img/common/map-markers/map-marker-13-highlight.gif'});
			} else if (window.search_result[k].cat_item == 2 && window.search_result[k].status == 1) {
				window.list_marker.list_marker[k].setIcon({url: '/_img/common/map-markers/map-marker-21-highlight.gif'});
			} else if (window.search_result[k].cat_item == 2 && window.search_result[k].status == 2) {
				window.list_marker.list_marker[k].setIcon({url: '/_img/common/map-markers/map-marker-22-highlight.gif'});
			} else {
				window.list_marker.list_marker[k].setIcon({url: '/_img/common/map-markers/map-marker-23-highlight.gif'});
			}
		}
	}
}



function change_map_zoom() {
	//change map zoom
	var gm = google.maps;
	var bounds = new gm.LatLngBounds();
	
	bounds.extend(window.main_marker_loc);
	
	var i = window.list_marker.list_marker_cd.indexOf(window.list_item_compare[0]);
	if (i >= 0) {
		var marker = window.list_marker.list_marker[i];
		bounds.extend(marker.position);
	}
	var i = window.list_marker.list_marker_cd.indexOf(window.list_item_compare[1]);
	if (i >= 0) {
		var marker = window.list_marker.list_marker[i];
		bounds.extend(marker.position);
	}
	var i = window.list_marker.list_marker_cd.indexOf(window.list_item_compare[2]);
	if (i >= 0) {
		var marker = window.list_marker.list_marker[i];
		bounds.extend(marker.position);
	}
	var i = window.list_marker.list_marker_cd.indexOf(window.list_item_compare[3]);
	if (i >= 0) {
		var marker = window.list_marker.list_marker[i];
		bounds.extend(marker.position);
	}
	var i = window.list_marker.list_marker_cd.indexOf(window.list_item_compare[4]);
	if (i >= 0) {
		var marker = window.list_marker.list_marker[i];
		bounds.extend(marker.position);
	}
	
	if (window.list_item_compare[0]) {
		window.list_marker.map.fitBounds(bounds);
	}	
}




function insertAnalysisTable(analysis) {
	$("#tbl-analysis").html('');
	$("#name").html('<th style="width:12%;">地域の総合</th>');
	$("#sale_number").html('<th>売出件数</th>');
	$("#avg_price_regist").html('<th>平均売出価格</th>');
	$("#avg_price_sold").html('<th>平均成約価格</th>');
	$("#avg_time_sold").html('<th>平均売出期間</th>');
	$("#avg_time_change_circle").html('<th>平均価格改定周期</th>');
	$("#avg_down_price_rate").html('<th>平均値下率</th>');
	
	if (analysis[0].seller_cd == null) {
		return true;	
	}

	for (var i = 0; i < analysis.length; i++) {
		var years = Array();
		for (var j = 0; j < analysis[i].items.length; j++) {
			for (var k = 0; k < analysis[i].items[j].history.length; k++) {
				if (analysis[i].items[j].history[k].hist_regist != null) {
					var year = new Date(analysis[i].items[j].history[k].hist_regist);
					if ( years.indexOf(year.getFullYear()) < 0 && year.getFullYear() > '2013') {
						years.push(year.getFullYear());	
					}
				}
			}
		}
		years.sort();
		var count = years.length;
		
		var th_year = '';
		var td_sale_number = '';
		var td_avg_price_regist = '';
		var td_avg_price_soldout = '';
		var time = '';
		var avg_time_change_price = '';
		var avg_down_price_rate = '';
		var market_rate = '';
		
		
		for (var j = 0; j < count; j++) {
		
			var count_item_sale_number = 0;
			var sum_price_regist = 0;
			var count_item_price_regist = 0;
			var sum_price_soldout = 0;
			var count_item_price_soldout = 0;
			var sum_time = 0;
			var count_item_time = 0;
			var sum_time_change_price = 0;
			var count_item_time_change_price = 0;			
			var sum_down_price_rate = 0;
			var count_item_down_price_rate = 0;
			var sum_market_rate = 0;
			var count_item_market_rate = 0;
			var count_total_item = 0;	
			for ( var n = 0; n < analysis.length; n++ ) {
				var count_item_per_seller = 0;
				for (var k = 0; k < analysis[n].items.length; k++){
					var hist_regist = new Date(analysis[n].items[k].regist);
					if (hist_regist.getFullYear() == years[j]) {
						count_item_per_seller++;
					}
				}
				count_total_item = count_total_item + count_item_per_seller;
			}
			
			for (var k = 0; k < analysis[i].items.length; k++){
				//sale number
				//avg price regist
				//avg down price rate
				//market rate
				if (analysis[i].items[k].regist != null) {
					var hist_regist = new Date(analysis[i].items[k].regist)
					if (hist_regist.getFullYear() == years[j]) {
						//sale number
						count_item_sale_number++;
						
						//avg price regist
						if (analysis[i].items[k].price_regist != null) {
							count_item_price_regist++
							sum_price_regist = sum_price_regist + parseInt(analysis[i].items[k].price_regist);
						}
						
						//avg down price rate
						if (analysis[i].items[k].price_regist != null && analysis[i].items[k].price_soldout != null) {
							sum_down_price_rate = sum_down_price_rate + parseFloat((analysis[i].items[k].price_regist - analysis[i].items[k].price_soldout) / analysis[i].items[k].price_regist);
							count_item_down_price_rate++;
						}
						
						//market rate
						count_item_market_rate++;			
					}
				}
				
				//avg price soldout
				//time sale
				//avg time change price
				if (analysis[i].items[k].date_soldout != null) {
					var hist_regist = new Date(analysis[i].items[k].date_soldout)
					if (hist_regist.getFullYear() == years[j]) {
						//avg price soldout
						if (analysis[i].items[k].price_soldout != null ) {
							count_item_price_soldout++;
							sum_price_soldout = sum_price_soldout + parseInt(analysis[i].items[k].price_soldout);
						}
						
						//time sale
						count_item_time++;
						sum_time = sum_time + parseInt(analysis[i].items[k].time);
						
						//avg time change price
						for (var m = 0; m < analysis[i].items[k].history.length; m++) {
							if (analysis[i].items[k].history[m].stat_cd == 2) {
								for (var n = m - 1; n >= 0; n--) { 
									if(analysis[i].items[k].history[m].stat_cd == "2" ||
										analysis[i].items[k].history[m].stat_cd == "1") {
										if (analysis[i].items[k].history[m].hist_regist != null && analysis[i].items[k].history[n].hist_regist != null) {
											var oneDay = 24*60*60*1000;
											var firstDate = new Date(analysis[i].items[k].history[m].hist_regist);
											var secondDate = new Date(analysis[i].items[k].history[n].hist_regist);
											var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
											
											count_item_time_change_price++;
											sum_time_change_price = sum_time_change_price + parseInt(diffDays);
											break;
										}
									}
								}
							}
						}
					}	
				}							
			}			
			
			//years
			th_year = th_year + '<th>' + years[j] + '</th>';
			
			//sale number
			td_sale_number = td_sale_number + '<td>' + count_item_sale_number 
							+ '<input type="hidden" id="sale_number_'
							+ analysis[i].seller_cd + '_' + years[j] 
							+ '" value="' + count_item_sale_number + '" /></td>';
		
			//avg price regist
			var avg_price_regist = Math.ceil(sum_price_regist / count_item_price_regist);
			if (count_item_price_regist == 0) {
				avg_price_regist = '----';	
			}
			
			td_avg_price_regist = td_avg_price_regist + '<td>' + avg_price_regist 
								+ '万円<input type="hidden" id="avg_price_regist_'
								+ analysis[i].seller_cd + '_' + years[j] 
								+ '" value="' + avg_price_regist + '" /></td>';
			
			//avg price soldout
			var avg_price_price_soldout = Math.ceil(sum_price_soldout / count_item_price_soldout);
			if (count_item_price_soldout == 0) {
				avg_price_price_soldout = '----';	
			}
			td_avg_price_soldout = td_avg_price_soldout + '<td>' + avg_price_price_soldout 
								+ '万円<input type="hidden" id="avg_price_soldout_'
								+ analysis[i].seller_cd + '_' + years[j] 
								+ '" value="' + avg_price_price_soldout + '" /></td>';	
			
			//time sale
			var avg_time_time = Math.ceil(sum_time / count_item_time);
			if (count_item_time == 0) {
				avg_time_time = '----';	
			}
			time = time + '<td>' + avg_time_time 
				 + '日間<input type="hidden" id="time_'
				 + analysis[i].seller_cd + '_' + years[j] 
				 + '" value="' + avg_time_time + '" /></td>';
			
			//avg time change price
			var avg_time_time_change_price = Math.ceil(sum_time_change_price / count_item_time_change_price);
			if (count_item_time_change_price == 0) {
				avg_time_time_change_price = '----';	
			}
			avg_time_change_price = avg_time_change_price + '<td>' + avg_time_time_change_price 
								  + '日間<input type="hidden" id="time_change_price_'
				 				  + analysis[i].seller_cd + '_' + years[j] 
								  + '" value="' + avg_time_time_change_price + '" /></td>';			
			
			//avg down price rate
			var rate_down_price_rate = (sum_down_price_rate / count_item_down_price_rate * 100).toFixed(2);
			if (count_item_down_price_rate == 0) {
				rate_down_price_rate = '----';	
			}
			avg_down_price_rate = avg_down_price_rate + '<td>' + rate_down_price_rate + '%' 
								  + '<input type="hidden" id="down_price_rate_'
				 				  + analysis[i].seller_cd + '_' + years[j] 
								  + '" value="' + rate_down_price_rate + '" /></td>';			
			
			//market rate
			var rate_market_rate = (count_item_market_rate / count_total_item * 100).toFixed(2);
			if (count_total_item == 0) {
				rate_market_rate = 0;	
			}
			market_rate = market_rate + '<td>' + rate_market_rate + '%' 
						+ '<input type="hidden" id="market_rate_'
				 		+ analysis[i].seller_cd + '_' + years[j] 
						+ '" value="' + rate_market_rate + '" /></td>';			
		}
		
		
		var table = '<br><table class="form-compare-item" border="1" width="100%" id="seller_'
					+ analysis[i].seller_cd +'">'
					+ '<tr><th style="width:12%;">' + analysis[i].seller_name + '</th>' + th_year + '</tr>'
					+ '<tr><th style="width:12%;">売出件数</th>' + td_sale_number + '</tr>'
					+ '<tr><th>平均売出価格</th>' + td_avg_price_regist+ '</tr>'
					+ '<tr><th>平均成約価格</th>' + td_avg_price_soldout + '</tr>'
					+ '<tr><th>平均売出期間</th>' + time + '</tr>'
					+ '<tr><th>平均価格改定周期</th>' + avg_time_change_price + '</tr>'
					+ '<tr><th>平均値下率</th>' + avg_down_price_rate + '</tr>'
					+ '<tr><th>販売シェア率</th>' + market_rate + '</tr>'
					+ '</table><br>';
		
		$('#tbl-analysis').append(table);
	}	
	
	
	//total
	var years = Array();
	for (var i = 0; i < analysis.length; i++) {
		for (var j = 0; j < analysis[i].items.length; j++) {
			for (var k = 0; k < analysis[i].items[j].history.length; k++) {
				if (analysis[i].items[j].history[k].hist_regist != null) {
					var year = new Date(analysis[i].items[j].history[k].hist_regist);
					if ( years.indexOf(year.getFullYear()) < 0 && year.getFullYear() > '2013') {
						years.push(year.getFullYear());	
					}
				}
			}
		}
	}
	years.sort();
	
	for (var j = 0; j < years.length; j++) {
		
		var sale_number	= 0;
		var avg_price_regist = 0;
		var avg_price_sold = 0;		
		var time = 0;
		var avg_time_change_circle = 0;
		var sum = 0;
		var count_item = 0;		
		var down_price_rate = 0;		
		
		
		for (var i = 0; i < analysis.length ; i++) {
			
			//sale number
			var per_seller = parseInt($('#sale_number_' + analysis[i].seller_cd + '_' + years[j]).val());
			if (per_seller) {
				sale_number = sale_number + per_seller;
			}
			
			//avg price regist
			var per_seller = 0;
			per_seller = parseInt($('#avg_price_regist_' + analysis[i].seller_cd + '_' + years[j]).val())
						   * parseInt($('#sale_number_' + analysis[i].seller_cd + '_' + years[j]).val())
						   ;
			
			if (per_seller) {
				avg_price_regist = avg_price_regist + per_seller;
			}
			
			//avg price soldout
			var per_seller = 0;
			per_seller = parseInt($('#avg_price_soldout_' + analysis[i].seller_cd + '_' + years[j]).val())
						   * parseInt($('#sale_number_' + analysis[i].seller_cd + '_' + years[j]).val())
						   ;
			
			if (per_seller) {
				avg_price_sold = avg_price_sold + per_seller;
			}
			
			//time sale
			var per_seller = 0;
			per_seller = parseInt($('#time_' + analysis[i].seller_cd + '_' + years[j]).val())
						   * parseInt($('#sale_number_' + analysis[i].seller_cd + '_' + years[j]).val())
						   ;
			
			if (per_seller) {
				time = time + per_seller;
			}
			
			
			//avg time change price
			for (var k = 0; k < analysis[i].items.length; k++){
				var hist_regist = new Date(analysis[i].items[k].date_soldout);
				if (hist_regist.getFullYear() == years[j]) {
					for (var m = 0; m < analysis[i].items[k].history.length; m++) {
						if (analysis[i].items[k].history[m].stat_cd == 2) {
							for (var n = m - 1; n >= 0; n--) { 
								if(analysis[i].items[k].history[m].stat_cd == "2" ||
									analysis[i].items[k].history[m].stat_cd == "1") {
									if (analysis[i].items[k].history[m].hist_regist != null && analysis[i].items[k].history[n].hist_regist != null) {
										var oneDay = 24*60*60*1000;
										var firstDate = new Date(analysis[i].items[k].history[m].hist_regist);
										var secondDate = new Date(analysis[i].items[k].history[n].hist_regist);
										var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
										
										count_item++;
										sum = sum + parseInt(diffDays);
										break;
									}
								}
							}
						}
					}
				}
			}
			
			
			//avg down price rate
			var per_seller = 0;
			per_seller = parseFloat($('#down_price_rate_' + analysis[i].seller_cd + '_' + years[j]).val())
						   * parseInt($('#sale_number_' + analysis[i].seller_cd + '_' + years[j]).val())
						   ;
			
			if (per_seller) {
				down_price_rate = down_price_rate + per_seller;
			}
			
		}

		//avg price regist
		avg_price_regist = Math.ceil(avg_price_regist / sale_number);

	
		//avg price soldout
		avg_price_sold = Math.ceil(avg_price_sold / sale_number);
		
		
		//time sale	
		time = Math.ceil(time / sale_number);

		
		//avg time change price		
		avg_time_change_circle = Math.ceil(sum / count_item);
		if (count_item == 0) {
			avg_time_change_circle = '----';
		}
	
		//avg down price rate
		down_price_rate = (down_price_rate / sale_number).toFixed(2);

		
		if (sale_number == 0) {
			avg_price_regist = '----';
			avg_price_sold = '----';
			time = '----';
			down_price_rate = '----';
		}
		
		
		$('#name').append('<th>' + years[j] + '</th>');
		$('#sale_number').append('<td>' + sale_number 
								 + '<input id="sale_number_' + years[j] 
								 + '" type="hidden" value="' + sale_number + '" /></td>');	
		$('#avg_price_regist').append('<td>' + avg_price_regist + '万円</td>');
		$('#avg_price_sold').append('<td>' + avg_price_sold + '万円</td>');
		$('#avg_time_sold').append('<td>' + time + '日間</td>');
		$('#avg_time_change_circle').append('<td>' + avg_time_change_circle + '日間</td>');
		$('#avg_down_price_rate').append('<td>' + down_price_rate + '%</td>');	
	}
	
}