$(document).ready(function () {
	//auto draw map + chart
	var chart_result;
	var chart;
	var list_item_compare, list_marker;	
	var similars = searchItemOnDemand();
	
	list_marker = initialize(similars);
	google.charts.setOnLoadCallback(function(){ drawChart(similars) });

	$(".overlay").hide();
	$("#pop_up").hide();
	
	$('.view-chart').hover(function(event) {
		eventChangeChartLegends();
	});
	$('.view-chart').mousedown(function(event) {
		eventChangeChartLegends();
	});
	$('.view-chart').mouseup(function(event) {
		eventChangeChartLegends();
	});
	
	
	//auto redraw when resize
	$(window).resize(function(event){
		event.preventDefault();
		$(".overlay").show();			
		
		var similars = searchItemOnDemand();
		list_item_compare = null;
		list_marker = initialize(similars);
		chart_result = drawChart(similars);
		
		var chart = chart_result.chart;
		google.visualization.events.addListener(chart, 'select', function() {
			var point = chart.getSelection();
			if (point[0].column == 16) {
				var i = list_marker.list_marker_cd.indexOf(list_item_compare[0]);
				var marker = list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
			}
			if (point[0].column == 19) {
				var i = list_marker.list_marker_cd.indexOf(list_item_compare[1]);
				var marker = list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
			}
			if (point[0].column == 22) {
				var i = list_marker.list_marker_cd.indexOf(list_item_compare[2]);
				var marker = list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
			}
			if (point[0].column == 25) {
				var i = list_marker.list_marker_cd.indexOf(list_item_compare[3]);
				var marker = list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
			}
			if (point[0].column == 28) {
				var i = list_marker.list_marker_cd.indexOf(list_item_compare[4]);
				var marker = list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
			}
		});
		
		list_item_compare = chart_result.list_item_compare;
		chart = chart_result.chart;
		if (chart_result) {
			$(".overlay").fadeOut().delay(1500);
		}	
	});
	
	//display item on map when click icon on chart
	//---
	$(document).on('click','#chart_div rect',function(){
		var circle = $(this).parent().find('circle');
		if(circle.length){
			checkCircle(circle);   
		}
	});
	
	$(document).on('click','#chart_div circle',function(){
		var circle = $(this).parent().find('circle');
		if(circle.length){
			checkCircle(circle);   
		}
	});

	$(document).on('click','#chart_div text',function(){
		var circle = $(this).parent().parent().find('circle');
		if(circle.length){
			checkCircle(circle);   
		}
	});
	
	$(document).on('click','#chart_div path',function(){
		var circle = $(this).parent().find('circle');
		if(circle.length){
			checkCircle(circle);   
		}
	});

	function checkCircle(circle){
		switch (circle.attr('fill')) {
			case '#ffa500':
				var i = list_marker.list_marker_cd.indexOf(list_item_compare[0]);
				var marker = list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
				
				break;
			
			case '#ffd700':
				var i = list_marker.list_marker_cd.indexOf(list_item_compare[1]);
				var marker = list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
				
				break;
				
			case '#00ffff':
				var i = list_marker.list_marker_cd.indexOf(list_item_compare[2]);
				var marker = list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
				
				break;
			
			case '#7fff00':
				var i = list_marker.list_marker_cd.indexOf(list_item_compare[3]);
				var marker = list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
				
				break;
			
			case '#ff1493':
				var i = list_marker.list_marker_cd.indexOf(list_item_compare[4]);
				var marker = list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
				
				break;
				
			default:
				break;
		}
	}
	
	$('.view-chart').on('click', '#close_item1', function (event) {
		event.preventDefault();
		list_item_compare = removeItem(list_item_compare[0]);
		if (chart_result) {
			$(".overlay").fadeOut().delay(1500);
		}	
	});
	
	$('.view-chart').on('click', '#close_item2', function (event) {
		event.preventDefault();
		list_item_compare = removeItem(list_item_compare[1]);
		if (chart_result) {
			$(".overlay").fadeOut().delay(1500);
		}	
	});
	
	$('.view-chart').on('click', '#close_item3', function (event) {
		event.preventDefault();
		list_item_compare = removeItem(list_item_compare[2]);
		if (chart_result) {
			$(".overlay").fadeOut().delay(1500);
		}	
	});
	
	$('.view-chart').on('click', '#close_item4', function (event) {
		event.preventDefault();
		list_item_compare = removeItem(list_item_compare[3]);
		if (chart_result) {
			$(".overlay").fadeOut().delay(1500);
		}	
	});
	
	$('.view-chart').on('click', '#close_item5', function (event) {
		event.preventDefault();
		list_item_compare = removeItem(list_item_compare[4]);
		if (chart_result) {
			$(".overlay").fadeOut().delay(1500);
		}	
	});
	//---
	
	
	//auto redraw when click button search
	$('.tabl-analysis').on('click', '#btn_th', function (event) {
		event.preventDefault();
		chart_result = null;
				
		$(".overlay").show();
		var similars = searchItemOnDemand();
		list_marker = initialize(similars);
		chart_result = drawChart(similars);
		
		chart = chart_result.chart;
		google.visualization.events.addListener(chart, 'select', function() {
			var point = chart.getSelection();
			if (point[0].column == 16) {
				var i = list_marker.list_marker_cd.indexOf(list_item_compare[0]);
				var marker = list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
			}
			if (point[0].column == 19) {
				var i = list_marker.list_marker_cd.indexOf(list_item_compare[1]);
				var marker = list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
			}
			if (point[0].column == 22) {
				var i = list_marker.list_marker_cd.indexOf(list_item_compare[2]);
				var marker = list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
			}
			if (point[0].column == 25) {
				var i = list_marker.list_marker_cd.indexOf(list_item_compare[3]);
				var marker = list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
			}
			if (point[0].column == 28) {
				var i = list_marker.list_marker_cd.indexOf(list_item_compare[4]);
				var marker = list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
			}
		});
		
		list_item_compare = chart_result.list_item_compare;
		
		if (chart_result) {
			$(".overlay").fadeOut().delay(1500);
		}
	});
	
	//close popup when click button close(X)
	$('#pop_up').on('click', '.btn-close', function () {
		$("#pop_up").hide();
    });
	
	//remove item when click button close(X)
	$('.form-analysis').on('click', '.btn-close-item', function () {
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
				
				if ( result[0].item_name != null ) {
					$('#item1_img').html('<button class="btn-close btn-close-item" id="item1-btn-close" value="' + result[0].item_cd + '">X<button>'
										 + '<img src="' + result[0].item_img + '" />');
					$('#item1_name').html(result[0].item_name);
					$('#item1_price').html(result[0].item_price + '万円（税込）');
					$('#item1_size_land').html(result[0].item_size_land);
					$('#item1_size_build').html(result[0].item_size_build);
					$('#item1_layout').html(result[0].item_layout);
					$('#item1_pubtrans').html(result[0].item_pubtrans);
					$('#item1_road').html(result[0].item_road);
					$('#item1_school').html(result[0].item_school);
					$('#item1_equip').html(result[0].item_equip);
				} else {
					$('#item1_img').html('');
					$('#item1_name').html('');
					$('#item1_price').html('');
					$('#item1_size_land').html('');
					$('#item1_size_build').html('');
					$('#item1_layout').html('');
					$('#item1_pubtrans').html('');
					$('#item1_road').html('');
					$('#item1_school').html('');
					$('#item1_equip').html('');
					$('#close_item1').html('');
				}
				
				if ( result[1].item_name != null ) {
					$('#item2_img').html('<button class="btn-close btn-close-item" id="item2-btn-close" value="' + result[1].item_cd + '">X<button>'
										 + '<img src="' + result[1].item_img + '" />');
					$('#item2_name').html(result[1].item_name);
					$('#item2_price').html(result[1].item_price + '万円（税込）');
					$('#item2_size_land').html(result[1].item_size_land);
					$('#item2_size_build').html(result[1].item_size_build);
					$('#item2_layout').html(result[1].item_layout);
					$('#item2_pubtrans').html(result[1].item_pubtrans);
					$('#item2_road').html(result[1].item_road);
					$('#item2_school').html(result[1].item_school);
					$('#item2_equip').html(result[1].item_equip);
				} else {
					$('#item2_img').html('');
					$('#item2_name').html('');
					$('#item2_price').html('');
					$('#item2_size_land').html('');
					$('#item2_size_build').html('');
					$('#item2_layout').html('');
					$('#item2_pubtrans').html('');
					$('#item2_road').html('');
					$('#item2_school').html('');
					$('#item2_equip').html('');
					$('#close_item2').html('');
				}
				
				if ( result[2].item_name != null ) {
					$('#item3_img').html('<button class="btn-close btn-close-item" id="item3-btn-close" value="' + result[2].item_cd + '">X<button>'
										 + '<img src="' + result[2].item_img + '" />');
					$('#item3_name').html(result[2].item_name);
					$('#item3_price').html(result[2].item_price + '万円（税込）');
					$('#item3_size_land').html(result[2].item_size_land);
					$('#item3_size_build').html(result[2].item_size_build);
					$('#item3_layout').html(result[2].item_layout);
					$('#item3_pubtrans').html(result[2].item_pubtrans);
					$('#item3_road').html(result[2].item_road);
					$('#item3_school').html(result[2].item_school);
					$('#item3_equip').html(result[2].item_equip);
				} else {
					$('#item3_img').html('');
					$('#item3_name').html('');
					$('#item3_price').html('');
					$('#item3_size_land').html('');
					$('#item3_size_build').html('');
					$('#item3_layout').html('');
					$('#item3_pubtrans').html('');
					$('#item3_road').html('');
					$('#item3_school').html('');
					$('#item3_equip').html('');
					$('#close_item3').html('');
				}
				
				if ( result[3].item_name != null ) {
					$('#item4_img').html('<button class="btn-close btn-close-item" id="item4-btn-close" value="' + result[3].item_cd + '">X<button>'
										 + '<img src="' + result[3].item_img + '" />');
					$('#item4_name').html(result[3].item_name);
					$('#item4_price').html(result[3].item_price + '万円（税込）');
					$('#item4_size_land').html(result[3].item_size_land);
					$('#item4_size_build').html(result[3].item_size_build);
					$('#item4_layout').html(result[3].item_layout);
					$('#item4_pubtrans').html(result[3].item_pubtrans);
					$('#item4_road').html(result[3].item_road);
					$('#item4_school').html(result[3].item_school);
					$('#item4_equip').html(result[3].item_equip);
				} else {
					$('#item4_img').html('');
					$('#item4_name').html('');
					$('#item4_price').html('');
					$('#item4_size_land').html('');
					$('#item4_size_build').html('');

					$('#item4_layout').html('');
					$('#item4_pubtrans').html('');
					$('#item4_road').html('');
					$('#item4_school').html('');
					$('#item4_equip').html('');
					$('#close_item4').html('');
				}
				
				if ( result[4].item_name != null ) {
					$('#item5_img').html('<button class="btn-close btn-close-item" id="item5-btn-close" value="' + result[4].item_cd + '">X<button>'
										 + '<img src="' + result[4].item_img + '" />');
					$('#item5_name').html(result[4].item_name);
					$('#item5_price').html(result[4].item_price + '万円（税込）');
					$('#item5_size_land').html(result[4].item_size_land);
					$('#item5_size_build').html(result[4].item_size_build);
					$('#item5_layout').html(result[4].item_layout);
					$('#item5_pubtrans').html(result[4].item_pubtrans);
					$('#item5_road').html(result[4].item_road);
					$('#item5_school').html(result[4].item_school);
					$('#item5_equip').html(result[4].item_equip);
				} else {
					$('#item5_img').html('');
					$('#item5_name').html('');
					$('#item5_price').html('');
					$('#item5_size_land').html('');
					$('#item5_size_build').html('');
					$('#item5_layout').html('');
					$('#item5_pubtrans').html('');
					$('#item5_road').html('');
					$('#item5_school').html('');
					$('#item5_equip').html('');
					$('#close_item5').html('');
				}
			}
		});
		//redraw chart
		var similars = searchItemOnDemand();
		chart_result = drawChart(similars);
		
		chart = chart_result.chart;
		google.visualization.events.addListener(chart, 'select', function() {
			var point = chart.getSelection();
			if (point[0].column == 16) {
				var i = list_marker.list_marker_cd.indexOf(list_item_compare[0]);
				var marker = list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
			}
			if (point[0].column == 19) {
				var i = list_marker.list_marker_cd.indexOf(list_item_compare[1]);
				var marker = list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
			}
			if (point[0].column == 22) {
				var i = list_marker.list_marker_cd.indexOf(list_item_compare[2]);
				var marker = list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
			}
			if (point[0].column == 25) {
				var i = list_marker.list_marker_cd.indexOf(list_item_compare[3]);
				var marker = list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
			}
			if (point[0].column == 28) {
				var i = list_marker.list_marker_cd.indexOf(list_item_compare[4]);
				var marker = list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
			}
		});

		list_item_compare = chart_result.list_item_compare;
		
		if (chart_result) {
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
				
				if ( result[0].item_name != null ) {
					$('#item1_img').html('<button class="btn-close btn-close-item" id="item1-btn-close" value="' + result[0].item_cd + '">X<button>'
										 + '<img src="' + result[0].item_img + '" />');
					$('#item1_name').html(result[0].item_name);
					$('#item1_price').html(result[0].item_price + '万円（税込）');
					$('#item1_size_land').html(result[0].item_size_land);
					$('#item1_size_build').html(result[0].item_size_build);
					$('#item1_layout').html(result[0].item_layout);
					$('#item1_pubtrans').html(result[0].item_pubtrans);
					$('#item1_road').html(result[0].item_road);
					$('#item1_school').html(result[0].item_school);
					$('#item1_equip').html(result[0].item_equip);
				}
				
				if ( result[1].item_name != null ) {
					$('#item2_img').html('<button class="btn-close btn-close-item" id="item2-btn-close" value="' + result[1].item_cd + '">X<button>'
										 + '<img src="' + result[1].item_img + '" />');
					$('#item2_name').html(result[1].item_name);
					$('#item2_price').html(result[1].item_price + '万円（税込）');
					$('#item2_size_land').html(result[1].item_size_land);
					$('#item2_size_build').html(result[1].item_size_build);
					$('#item2_layout').html(result[1].item_layout);
					$('#item2_pubtrans').html(result[1].item_pubtrans);
					$('#item2_road').html(result[1].item_road);
					$('#item2_school').html(result[1].item_school);
					$('#item2_equip').html(result[1].item_equip);
				}
				
				if ( result[2].item_name != null ) {
					$('#item3_img').html('<button class="btn-close btn-close-item" id="item3-btn-close" value="' + result[2].item_cd + '">X<button>'
										 + '<img src="' + result[2].item_img + '" />');
					$('#item3_name').html(result[2].item_name);
					$('#item3_price').html(result[2].item_price + '万円（税込）');
					$('#item3_size_land').html(result[2].item_size_land);
					$('#item3_size_build').html(result[2].item_size_build);
					$('#item3_layout').html(result[2].item_layout);
					$('#item3_pubtrans').html(result[2].item_pubtrans);
					$('#item3_road').html(result[2].item_road);
					$('#item3_school').html(result[2].item_school);
					$('#item3_equip').html(result[2].item_equip);
				}
				
				if ( result[3].item_name != null ) {
					$('#item4_img').html('<button class="btn-close btn-close-item" id="item4-btn-close" value="' + result[3].item_cd + '">X<button>'
										 + '<img src="' + result[3].item_img + '" />');
					$('#item4_name').html(result[3].item_name);
					$('#item4_price').html(result[3].item_price + '万円（税込）');
					$('#item4_size_land').html(result[3].item_size_land);
					$('#item4_size_build').html(result[3].item_size_build);
					$('#item4_layout').html(result[3].item_layout);
					$('#item4_pubtrans').html(result[3].item_pubtrans);
					$('#item4_road').html(result[3].item_road);
					$('#item4_school').html(result[3].item_school);
					$('#item4_equip').html(result[3].item_equip);
				}
				
				if ( result[4].item_name != null ) {
					$('#item5_img').html('<button class="btn-close btn-close-item" id="item5-btn-close" value="' + result[4].item_cd + '">X<button>'
										 + '<img src="' + result[4].item_img + '" />');
					$('#item5_name').html(result[4].item_name);
					$('#item5_price').html(result[4].item_price + '万円（税込）');
					$('#item5_size_land').html(result[4].item_size_land);
					$('#item5_size_build').html(result[4].item_size_build);
					$('#item5_layout').html(result[4].item_layout);
					$('#item5_pubtrans').html(result[4].item_pubtrans);
					$('#item5_road').html(result[4].item_road);
					$('#item5_school').html(result[4].item_school);
					$('#item5_equip').html(result[4].item_equip);
				}
			}
		});

		var similars = searchItemOnDemand();
		chart_result = drawChart(similars);
		
		chart = chart_result.chart;
		google.visualization.events.addListener(chart, 'select', function() {
			var point = chart.getSelection();
			if (point[0].column == 16) {
				var i = list_marker.list_marker_cd.indexOf(list_item_compare[0]);
				var marker = list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
			}
			if (point[0].column == 19) {
				var i = list_marker.list_marker_cd.indexOf(list_item_compare[1]);
				var marker = list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
			}
			if (point[0].column == 22) {
				var i = list_marker.list_marker_cd.indexOf(list_item_compare[2]);
				var marker = list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
			}
			if (point[0].column == 25) {
				var i = list_marker.list_marker_cd.indexOf(list_item_compare[3]);
				var marker = list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
			}
			if (point[0].column == 28) {
				var i = list_marker.list_marker_cd.indexOf(list_item_compare[4]);
				var marker = list_marker.list_marker[i];
				new google.maps.event.trigger( marker, 'click' );
			}
		});

		list_item_compare = chart_result.list_item_compare;
		
		if (chart_result) {
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
				
				if ( result[0].item_name != null ) {
					$('#item1_img').html('<button class="btn-close btn-close-item" id="item1-btn-close" value="' + result[0].item_cd + '">X<button>'
										 + '<img src="' + result[0].item_img + '" />');
					$('#item1_name').html(result[0].item_name);
					$('#item1_price').html(result[0].item_price + '万円（税込）');
					$('#item1_size_land').html(result[0].item_size_land);
					$('#item1_size_build').html(result[0].item_size_build);
					$('#item1_layout').html(result[0].item_layout);
					$('#item1_pubtrans').html(result[0].item_pubtrans);
					$('#item1_road').html(result[0].item_road);
					$('#item1_school').html(result[0].item_school);
					$('#item1_equip').html(result[0].item_equip);
				} else {
					$('#item1_img').html('');
					$('#item1_name').html('');
					$('#item1_price').html('');
					$('#item1_size_land').html('');
					$('#item1_size_build').html('');
					$('#item1_layout').html('');
					$('#item1_pubtrans').html('');
					$('#item1_road').html('');
					$('#item1_school').html('');
					$('#item1_equip').html('');
					$('#close_item1').html('');
				}
				
				if ( result[1].item_name != null ) {
					$('#item2_img').html('<button class="btn-close btn-close-item" id="item2-btn-close" value="' + result[1].item_cd + '">X<button>'
										 + '<img src="' + result[1].item_img + '" />');
					$('#item2_name').html(result[1].item_name);
					$('#item2_price').html(result[1].item_price + '万円（税込）');
					$('#item2_size_land').html(result[1].item_size_land);
					$('#item2_size_build').html(result[1].item_size_build);
					$('#item2_layout').html(result[1].item_layout);
					$('#item2_pubtrans').html(result[1].item_pubtrans);
					$('#item2_road').html(result[1].item_road);
					$('#item2_school').html(result[1].item_school);
					$('#item2_equip').html(result[1].item_equip);
				} else {
					$('#item2_img').html('');
					$('#item2_name').html('');
					$('#item2_price').html('');
					$('#item2_size_land').html('');
					$('#item2_size_build').html('');
					$('#item2_layout').html('');
					$('#item2_pubtrans').html('');
					$('#item2_road').html('');
					$('#item2_school').html('');
					$('#item2_equip').html('');
					$('#close_item2').html('');
				}
				
				if ( result[2].item_name != null ) {
					$('#item3_img').html('<button class="btn-close btn-close-item" id="item3-btn-close" value="' + result[2].item_cd + '">X<button>'
										 + '<img src="' + result[2].item_img + '" />');
					$('#item3_name').html(result[2].item_name);
					$('#item3_price').html(result[2].item_price + '万円（税込）');
					$('#item3_size_land').html(result[2].item_size_land);
					$('#item3_size_build').html(result[2].item_size_build);
					$('#item3_layout').html(result[2].item_layout);
					$('#item3_pubtrans').html(result[2].item_pubtrans);
					$('#item3_road').html(result[2].item_road);
					$('#item3_school').html(result[2].item_school);
					$('#item3_equip').html(result[2].item_equip);
				} else {
					$('#item3_img').html('');
					$('#item3_name').html('');
					$('#item3_price').html('');
					$('#item3_size_land').html('');
					$('#item3_size_build').html('');
					$('#item3_layout').html('');
					$('#item3_pubtrans').html('');
					$('#item3_road').html('');
					$('#item3_school').html('');
					$('#item3_equip').html('');
					$('#close_item3').html('');
				}
				
				if ( result[3].item_name != null ) {
					$('#item4_img').html('<button class="btn-close btn-close-item" id="item4-btn-close" value="' + result[3].item_cd + '">X<button>'
										 + '<img src="' + result[3].item_img + '" />');
					$('#item4_name').html(result[3].item_name);
					$('#item4_price').html(result[3].item_price + '万円（税込）');
					$('#item4_size_land').html(result[3].item_size_land);
					$('#item4_size_build').html(result[3].item_size_build);
					$('#item4_layout').html(result[3].item_layout);
					$('#item4_pubtrans').html(result[3].item_pubtrans);
					$('#item4_road').html(result[3].item_road);
					$('#item4_school').html(result[3].item_school);
					$('#item4_equip').html(result[3].item_equip);
				} else {
					$('#item4_img').html('');
					$('#item4_name').html('');
					$('#item4_price').html('');
					$('#item4_size_land').html('');
					$('#item4_size_build').html('');
					$('#item4_layout').html('');
					$('#item4_pubtrans').html('');
					$('#item4_road').html('');
					$('#item4_school').html('');
					$('#item4_equip').html('');
					$('#close_item4').html('');
				}
				
				if ( result[4].item_name != null ) {
					$('#item5_img').html('<button class="btn-close btn-close-item" id="item5-btn-close" value="' + result[4].item_cd + '">X<button>'
										 + '<img src="' + result[4].item_img + '" />');
					$('#item5_name').html(result[4].item_name);
					$('#item5_price').html(result[4].item_price + '万円（税込）');
					$('#item5_size_land').html(result[4].item_size_land);
					$('#item5_size_build').html(result[4].item_size_build);
					$('#item5_layout').html(result[4].item_layout);
					$('#item5_pubtrans').html(result[4].item_pubtrans);
					$('#item5_road').html(result[4].item_road);
					$('#item5_school').html(result[4].item_school);
					$('#item5_equip').html(result[4].item_equip);
				} else {
					$('#item5_img').html('');
					$('#item5_name').html('');
					$('#item5_price').html('');
					$('#item5_size_land').html('');
					$('#item5_size_build').html('');
					$('#item5_layout').html('');
					$('#item5_pubtrans').html('');
					$('#item5_road').html('');
					$('#item5_school').html('');

					$('#item5_equip').html('');
					$('#close_item5').html('');
				}
			}
		});
		//redraw chart
		var similars = searchItemOnDemand();
		chart_result = drawChart(similars);
		
		chart = chart_result.chart;
		google.visualization.events.addListener(chart, 'select', function() {
			var point = chart.getSelection();
			if (point != null) {
				if (point[0].column == 16) {
					var i = list_marker.list_marker_cd.indexOf(list_item_compare[0]);
					var marker = list_marker.list_marker[i];
					new google.maps.event.trigger( marker, 'click' );
				}
				if (point[0].column == 19) {
					var i = list_marker.list_marker_cd.indexOf(list_item_compare[1]);
					var marker = list_marker.list_marker[i];
					new google.maps.event.trigger( marker, 'click' );
				}
				if (point[0].column == 22) {
					var i = list_marker.list_marker_cd.indexOf(list_item_compare[2]);
					var marker = list_marker.list_marker[i];
					new google.maps.event.trigger( marker, 'click' );
				}
				if (point[0].column == 25) {
					var i = list_marker.list_marker_cd.indexOf(list_item_compare[3]);
					var marker = list_marker.list_marker[i];
					new google.maps.event.trigger( marker, 'click' );
				}
				if (point[0].column == 28) {
					var i = list_marker.list_marker_cd.indexOf(list_item_compare[4]);
					var marker = list_marker.list_marker[i];
					new google.maps.event.trigger( marker, 'click' );
				}
			}
		});

		return chart_result.list_item_compare;
}


function eventChangeChartLegends() {
	$('g g text').each(function () {
		var path = $(this).parent().parent().find('path');
		if(path.length){
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
				var pos = $(this).position();
				var offset = $(this).outerWidth();
				var left = pos.left + offset - 30;
				$('#close_item1').attr('style', 'top: 171px; left: ' + left + 'px');
				$('#close_item1').html('X');
				break;
			
			case '#ffd700':
				$(this).attr('fill', '#ffd700');
				var pos = $(this).position();
				var offset = $(this).outerWidth();
				var left = pos.left + offset - 30;
				$('#close_item2').attr('style', 'top: 195px; left: ' + left + 'px');
				$('#close_item2').html('X');
				break;
				
			case '#00ffff':
				$(this).attr('fill', '#00ffff');
				var pos = $(this).position();
				var offset = $(this).outerWidth();
				var left = pos.left + offset - 30;
				$('#close_item3').attr('style', 'top: 219px; left: ' + left + 'px');
				$('#close_item3').html('X');
				break;
			
			case '#7fff00':
				$(this).attr('fill', '#7fff00');
				var pos = $(this).position();
				var offset = $(this).outerWidth();
				var left = pos.left + offset - 30;
				$('#close_item4').attr('style', 'top: 243px; left: ' + left + 'px');
				$('#close_item4').html('X');
				break;
			
			case '#ff1493':
				$(this).attr('fill', '#ff1493');
				var pos = $(this).position();
				var offset = $(this).outerWidth();
				var left = pos.left + offset - 30;
				$('#close_item5').attr('style', 'top: 267px; left: ' + left + 'px');
				$('#close_item5').html('X');
				break;
				
			default:
				break;
		}
		}					 
	});
}