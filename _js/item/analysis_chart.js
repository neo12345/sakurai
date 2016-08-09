$(document).ready(function () {
	window.market_rate = Array();
	$('#analysis_tbl').hide();
	$(".overlay").hide();
	
	
    $(".btn-aggregate").click(function (e) {
        e.preventDefault();
        $(".overlay").show();
        $('#error').html('');
        $('#chart_div').html('');
        
        google.charts.setOnLoadCallback(drawChart);
		
		window.market_rate = Array();
		$('#analysis_tbl').show();
		$('#name').html('<th width="12%"></th>');
		$('#sale_number').html('<th>売出件数</th>');
		$('#avg_price_regist').html('<th>平均売出価格</th>');
		$('#avg_price_sold').html('<th>平均成約価格</th>');
		$('#avg_time_sold').html('<th>平均売出期間</th>');
		$('#avg_time_change_circle').html('<th>平均価格改定周期</th>');
		$('#avg_down_price_rate').html('<th>平均値下率</th>');
		$('#market_rate').html('<th>販売シェア率</th>');
		
		var analysis = analysisGroupItem();
		insertAnalysisTable(analysis);
		
		drawPieChart()
		
		$(".overlay").fadeOut().delay(1500);
    });
	
	$(".btn-time").click(function (e) {
        e.preventDefault();
        
		var monthsAgo = parseInt($(this).val());
		
		var now = new Date();
		
		var year = now.getFullYear();
		var month = now.getMonth() + 1;
		month = (month < 10) ? '0' + month : month;
		var date = now.getDate()
		var to = year + '/' + month + '/' + date;
		$("#to").val(to);
		
		now.setMonth(now.getMonth() - monthsAgo);
		
		var year = now.getFullYear();
		var month = now.getMonth() + 1;
		month = (month < 10) ? '0' + month : month;
		var date = now.getDate()
		var from = year + '/' + month + '/' + date;
		
		$("#from").val(from);
		
    });
	
    $(window).resize(function(){
		$(".overlay").show();					  
		if ($('#chart_div').html() != '') {
  			drawChart();
		
			window.market_rate = Array();
			$('#analysis_tbl').show();
			$('#name').html('<th width="12%"></th>');
			$('#sale_number').html('<th>売出件数</th>');
			$('#avg_price_regist').html('<th>平均売出価格</th>');
			$('#avg_price_sold').html('<th>平均成約価格</th>');
			$('#avg_time_sold').html('<th>平均売出期間</th>');
			$('#avg_time_change_circle').html('<th>平均価格改定周期</th>');
			$('#avg_down_price_rate').html('<th>平均値下率</th>');
			$('#market_rate').html('<th>販売シェア率</th>');
			
			var analysis = analysisGroupItem();
			insertAnalysisTable(analysis);
			
			drawPieChart()
		}
		
		$(".overlay").fadeOut().delay(1500);
	});
	
	
    function drawChart() {
        // Get data.
        var result;
        
	var city = new Array();
        $.each($("input[name='city[]']:checked"), function() {
            city.push($(this).val());
        });
        var cat_item = new Array();
        $.each($("input[name='cat_item[]']:checked"), function() {
            cat_item.push($(this).val());
        });
        var condition = new Array();
        $.each($("input[name='condition[]']:checked"), function() {
            condition.push($(this).val());
        });
        var seller = new Array();
        $.each($("input[name='seller[]']:checked"), function() {
            seller.push($(this).val());
        });
        
        var formData = {
            city: city,
            cat_item: cat_item,
            condition: condition,
            seller: seller,
            from: $("#from").val(),
            to: $("#to").val(),
            select_opt: $("#select_opt").val()
            };
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })    
            
	$.ajax({
		url: "/item/?md=get_analysis",
		type: 'POST',
		data: formData,
		dataType: "json",
		async: false,
		success: function (data) {
			result = data;
		}
	});
	
        if (!result) {
            var error = '<div class="alert alert-danger">見付かっていません。</div>';
            $('#error').html(error);
        }
        // create chart
        var data = new google.visualization.DataTable();
        
        data.addColumn('date', 'Date');
        if ($("#select_opt").val() == 4 || $("#select_opt").val() == 5){
            data.addColumn('number', '価格');
        } else {
            data.addColumn('number', '件数');
        }
        data.addColumn({type: 'string', role: 'tooltip', p: {html: true}}, 'Status');
        
		if (result.length == 1 && $("#select_opt").val() < 4) {
			var date = new Date(result[0].x_axis).getDate()-1;
			var month = new Date(result[0].x_axis).getMonth();
			var year = new Date(result[0].x_axis).getFullYear();
			
			var x_axis = new Date(year, month, date);
			var y_axis = parseInt(0); 
			data.addRows([[x_axis, y_axis, '']]);
		}
		
        for (var i = 0; i < result.length; i++) {                                  
            var date = new Date(result[i].x_axis).getDate();
            var month = new Date(result[i].x_axis).getMonth();
			var year = new Date(result[i].x_axis).getFullYear();
			
			var x_axis = new Date(year, month, date);
            var y_axis = parseInt(result[i].y_axis);  
			
            if ($("#select_opt").val() == 4 || $("#select_opt").val() == 5){ //if opt = 4 || opt = 5
				if ((new Date($("#to").val()) - new Date($("#from").val())) > 365*86400*1000) {
					var d = new Date(result[i].x_axis);
					
					var month = d.getMonth() + 1;
					var year = d.getFullYear();
					
					var tooltip = '<div style = "width: 130px; height: 70px; padding: 15px 20px;">'
							+ '<div style = "font-size: larger;">'
                            + year + '年' + month + '月</div><br>'
							+ '<div style = "font-size: large;"><b>' + y_axis + '万円</b></div></div>';
					
				} else if ((new Date($("#to").val()) - new Date($("#from").val())) > 180*86400*1000) {
					var d = new Date(result[i].x_axis);
					
					d.setDate(d.getDate() - 7);
					d = (d > new Date($("#from").val()))? d : new Date($("#from").val());
										
					var date_start = d.getDate();
            		var month_start = d.getMonth() + 1;
					
					d.setDate(d.getDate() + 13);
					d = (d < new Date($("#to").val()))? d : new Date($("#to").val());
					
					var date_end = d.getDate();
            		var month_end = d.getMonth() + 1;
					
					var tooltip = '<div style = "width: 130px; height: 70px; padding: 15px 20px;">'
							+ '<div style = "font-size: larger;">'
                            + month_start + '月' + date_start + '日 - ' + month_end + '月' + date_end + '日</div><br>'
							+ '<div style = "font-size: large;"><b>' + y_axis + '万円</b></div></div>';
					
				} else if ((new Date($("#to").val()) - new Date($("#from").val())) > 30*86400*1000) {
					var d = new Date(result[i].x_axis);
					
					d.setDate(d.getDate() - 3);
					d = (d > new Date($("#from").val()))? d : new Date($("#from").val());
										
					var date_start = d.getDate();
            		var month_start = d.getMonth() + 1;
					
					d.setDate(d.getDate() + 6);
					d = (d < new Date($("#to").val()))? d : new Date($("#to").val());
					
					var date_end = d.getDate();
            		var month_end = d.getMonth() + 1;
					
					var tooltip = '<div style = "width: 130px; height: 70px; padding: 15px 20px;">'
							+ '<div style = "font-size: larger;">'
                            + month_start + '月' + date_start + '日 - ' + month_end + '月' + date_end + '日</div><br>'
							+ '<div style = "font-size: large;"><b>' + y_axis + '万円</b></div></div>';
				} else {
					month = month + 1;
					var tooltip = '<div style = "width: 130px; height: 70px; padding: 15px 20px;">'
							+ '<div style = "font-size: larger;">'
                            + month + '月' + date + '日</div><br><b>' + y_axis + '万円</b></div></div>';
				}
               
            } else { //if opt = 1 || opt = 2 || opt = 3
				if ((new Date($("#to").val()) - new Date($("#from").val())) > 730*86400*1000) {
					var d = new Date(result[i].x_axis);
					
					var month = d.getMonth() + 1;
					var year = d.getFullYear();
					
					var tooltip = '<div style = "width: 130px; height: 70px; padding: 15px 20px;">'
							+ '<div style = "font-size: larger;">'
                            + year + '年' + month + '月</div><br>'
							+ '<div style = "font-size: large;"><b>' + y_axis + '</b></div></div>';
				
				} else if ( (new Date($("#to").val()) - new Date($("#from").val())) > 365*86400*1000 )
				{
					var d = new Date(result[i].x_axis);
					
					d.setDate(d.getDate() - 7);
					d = (d > new Date($("#from").val()))? d : new Date($("#from").val());
										
					var date_start = d.getDate();
            		var month_start = d.getMonth() + 1;
					
					d.setDate(d.getDate() + 13);
					d = (d < new Date($("#to").val()))? d : new Date($("#to").val());
					
					var date_end = d.getDate();
            		var month_end = d.getMonth() + 1;
					
					var tooltip = '<div style = "width: 130px; height: 70px; padding: 15px 20px;">'
							+ '<div style = "font-size: larger;">'
                            + month_start + '月' + date_start + '日 - ' + month_end + '月' + date_end + '日</div><br>'
							+ '<div style = "font-size: large;"><b>' + y_axis + '</b></div></div>';
				
				} else if ( (new Date($("#to").val()) - new Date($("#from").val())) > 180*86400*1000 )
				{
					var d = new Date(result[i].x_axis);
					
					d.setDate(d.getDate() - 3);
					d = (d > new Date($("#from").val()))? d : new Date($("#from").val());
										
					var date_start = d.getDate();
            		var month_start = d.getMonth() + 1;
					
					d.setDate(d.getDate() + 6);
					d = (d < new Date($("#to").val()))? d : new Date($("#to").val());
					
					var date_end = d.getDate();
            		var month_end = d.getMonth() + 1;
					
					var tooltip = '<div style = "width: 130px; height: 70px; padding: 15px 20px;">'
							+ '<div style = "font-size: larger;">'
                            + month_start + '月' + date_start + '日 - ' + month_end + '月' + date_end + '日</div><br>'
							+ '<div style = "font-size: large;"><b>' + y_axis + '</b></div></div>';
				
				} else if ( (new Date($("#to").val()) - new Date($("#from").val())) > 60*86400*1000 )
				{
					var d = new Date(result[i].x_axis);
					
					d.setDate(d.getDate() - 1);
					d = (d > new Date($("#from").val()))? d : new Date($("#from").val());
										
					var date_start = d.getDate();
            		var month_start = d.getMonth() + 1;
					
					d.setDate(d.getDate() + 2);
					d = (d < new Date($("#to").val()))? d : new Date($("#to").val());
					
					var date_end = d.getDate();
            		var month_end = d.getMonth() + 1;
					
					var tooltip = '<div style = "width: 130px; height: 70px; padding: 15px 20px;">'
							+ '<div style = "font-size: larger;">'
                            + month_start + '月' + date_start + '日 - ' + month_end + '月' + date_end + '日</div><br>'
							+ '<div style = "font-size: large;"><b>' + y_axis + '</b></div></div>';
				
				} else {
					month += 1; 
                	var tooltip = '<div style = "width: 130px; height: 70px; padding: 15px 20px;">'
							+ '<div style = "font-size: larger;">'
                            + month + '月' + date + '日</div><br><div style = "font-size: large;"><b>' + y_axis + '</b></div></div>';
				}
            }
            data.addRows([[x_axis, y_axis, tooltip]]);
        }
        // Set chart options
        var max_xAxis = new Date($("#to").val());
        max_xAxis.setDate(max_xAxis.getDate() + 3);
        var min_xAxis = new Date($("#from").val());
        min_xAxis.setDate(min_xAxis.getDate() - 3);
        
        var options = {
			explorer: { 
				actions: ['dragToZoom', 'rightClickToReset'],
				axis: 'horizontal',
				keepInBounds: true,
				zoomDelta: 0.5,
			},
			height:400,
			bar: { 
				groupWidth: "100%"
			},
            tooltip: {
                isHtml: true
            },
            hAxis: {
				baseline: min_xAxis,
				baselineColor: '#CCC',
				textStyle: {
					fontSize: 13,
				},
				slantedText: true,
                format: 'M月d日',
				viewWindowMode: 'pretty',
                viewWindow: {
                    max: max_xAxis,
                    min: min_xAxis
                },
				gridlines: {
          			count: 20,
					units: {
						years: {format: ["yy/mm"]},
						months: {format: ["mm/dd"]},
						days: {format: ["mm/dd"]},
					  }
        		}
            },
            pointSize: 10
        };

	var options1 = {
			explorer: { 
				actions: ['dragToZoom', 'rightClickToReset'],
				axis: 'horizontal',
				keepInBounds: true,
				zoomDelta: 0.5,
			},
			height:400,
			
            tooltip: {
                isHtml: true
            },
            hAxis: {
				baseline: min_xAxis,
				baselineColor: '#CCC',
				textStyle: {
					fontSize: 13,
				},
				slantedText: true,
                format: 'M月d日',
				viewWindowMode: 'pretty',
                viewWindow: {
                    max: max_xAxis,
                    min: min_xAxis
                },
				gridlines: {
          			count: 20,
					units: {
						years: {format: ["yy/mm"]},
						months: {format: ["mm/dd"]},
						days: {format: ["mm/dd"]},
					  }
        		}
            },
            pointSize: 10
        };
        
        // Instantiate and draw our chart, passing in some options.
        if ($("#select_opt").val() <= 3) {
            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        } else {
            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));	
        }
	if ( (new Date($("#to").val()) - new Date($("#from").val())) > 60*86400*1000 )
	{
        		chart.draw(data, options);
	} else {
		chart.draw(data, options1);
	}
    }
    });

function analysisGroupItem() {
	//------------------------------------		
	//search in radius
	
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

	
	var formData = {
		cat_item: cat_item,
		condition: condition,
		layout: layout,
		seller: seller,
		from: $("#from").val(),
        to: $("#to").val(),
	};		
	
	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		})
	var result
	$.ajax({
		url: "/item/?md=get_info_group_item_on_demand",
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




function insertAnalysisTable(analysis) {
	for (var i = 0; i < analysis.length; i++) {	
		var td_sale_number = '';
		var count_item = 0;
		for (var k = 0; k < analysis[i].items.length; k++){
			var hist_regist = new Date(analysis[i].items[k].regist)
				count_item++;
		}
		td_sale_number = td_sale_number + '<td>' + count_item 
						+ '<input type="hidden" id="sale_number_'
						+ analysis[i].seller_cd 
						+ '" value="' + count_item + '" /></td>';
		window.market_rate.push([analysis[i].seller_name, parseInt(count_item)]);
	
	
		var td_avg_price_regist = '';
		var sum = 0;
		var count_item = 0;
		for (var k = 0; k < analysis[i].items.length; k++){
			if (analysis[i].items[k].price_regist != null) {
				count_item++
				sum = sum + parseFloat(analysis[i].items[k].price_regist);
			}
		}
		var avg_price = Math.ceil(sum / count_item);
		if (count_item == 0) {
			avg_price = '----';	
		}
		td_avg_price_regist = td_avg_price_regist + '<td>' + avg_price 
							+ '万円<input type="hidden" id="avg_price_regist_'
							+ analysis[i].seller_cd
							+ '" value="' + avg_price + '" /></td>';
		
		
		var td_avg_price_soldout = '';
		var sum = 0;
		var count_item = 0;
		for (var k = 0; k < analysis[i].items.length; k++){
			if (analysis[i].items[k].price_soldout != null) {
				count_item++;
				sum = sum + parseInt(analysis[i].items[k].price_soldout);
			}
		}
		var avg_price = Math.ceil(sum / count_item);
		if (count_item == 0) {
			avg_price = '----';	
		}
		td_avg_price_soldout = td_avg_price_soldout + '<td>' + avg_price 
							+ '万円<input type="hidden" id="avg_price_soldout_'
							+ analysis[i].seller_cd 
							+ '" value="' + avg_price + '" /></td>';
		
		
		
		var time = '';
		var sum = 0;
		var count_item = 0;
		for (var k = 0; k < analysis[i].items.length; k++){console.log(analysis[i].items[k].time);
			count_item++;
			sum = sum + parseInt(analysis[i].items[k].time);
		}
		var avg_time = Math.ceil(sum / count_item);
		if (count_item == 0) {
			avg_time = '----';	
		}
		time = time + '<td>' + avg_time 
			 + '日間<input type="hidden" id="time_'
			 + analysis[i].seller_cd 
			 + '" value="' + avg_time + '" /></td>';
		
		
		
		var avg_time_change_price = '';
		var sum = 0;
		var count_item = 0;
		for (var k = 0; k < analysis[i].items.length; k++){
			for (var m = 0; m < analysis[i].items[k].history.length; m++) {
				if (analysis[i].items[k].history[m].stat_cd == 2) {
					for (var n = m - 1; n >= 0; n--) { 
						if(analysis[i].items[k].history[m].stat_cd == "2" || analysis[i].items[k].history[m].stat_cd == "1") {
							if (analysis[i].items[k].history[m].hist_regist != null && analysis[i].items[k].history[n].hist_regist != null) {
								console.log(analysis[i].items[k].history[m].hist_regist);

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
		
		var avg_time = Math.ceil(sum / count_item);
		if (count_item == 0) {
			avg_time = '----';	
		}
		avg_time_change_price = avg_time_change_price + '<td>' + avg_time 
							  + '日間<input type="hidden" id="time_change_price_'
							  + analysis[i].seller_cd 
							  + '" value="' + avg_time + '" /></td>';

		
		
		var avg_down_price_rate = '';
		var sum = 0;
		var count_item = 0;
		for (var k = 0; k < analysis[i].items.length; k++){
			if (analysis[i].items[k].price_regist != null && analysis[i].items[k].price_soldout != null)
			sum = sum + parseFloat((analysis[i].items[k].price_regist - analysis[i].items[k].price_soldout) / analysis[i].items[k].price_regist);
			count_item++;
		}
		
		var rate = (sum / count_item * 100).toFixed(2);
		if (count_item == 0) {
			rate = '----';	
		}
		avg_down_price_rate = avg_down_price_rate + '<td>' + rate + '%' 
							  + '<input type="hidden" id="down_price_rate_'
							  + analysis[i].seller_cd 
							  + '" value="' + rate + '" /></td>';
		
		
		var market_rate = '';
		// count item seller sold
		var sum = 0;
		var count_item = 0;
		for (var k = 0; k < analysis[i].items.length; k++){
			count_item++;
		}
		// count item all seller sold
		var count_total_item = 0;	
		for ( var n = 0; n < analysis.length; n++ ) {
			var count_item_per_seller = 0;
			for (var k = 0; k < analysis[n].items.length; k++){
				var hist_regist = new Date(analysis[n].items[k].regist);
				count_item_per_seller++;
			}
			count_total_item = count_total_item + count_item_per_seller;
		}
		
		var rate = (count_item / count_total_item * 100).toFixed(2);
		if (count_total_item == 0) {
			rate = 0;	
		}
		market_rate = market_rate + '<td>' + rate + '%' 
					+ '<input type="hidden" id="market_rate_'
					+ analysis[i].seller_cd 
					+ '" value="' + rate + '" /></td>';
		
		
		$('#name').append('<th>' + analysis[i].seller_name + '</th>');
		$('#sale_number').append(td_sale_number);
		$('#avg_price_regist').append(td_avg_price_regist);
		$('#avg_price_sold').append(td_avg_price_soldout);
		$('#avg_time_sold').append(time);
		$('#avg_time_change_circle').append(avg_time_change_price);
		$('#avg_down_price_rate').append(avg_down_price_rate);
		$('#market_rate').append(market_rate);
	}
	
	//total
	$('#name th:first-child').after('<th>地域の総合</th>');

	var sale_number	= 0;
	for (var i = 0; i < analysis.length ; i++) {
		var per_seller = parseInt($('#sale_number_' + analysis[i].seller_cd).val());
		if (per_seller) {
			sale_number = sale_number + per_seller;
		}
	}
	$('#sale_number th:first-child').after('<td>' + sale_number 
							 + '<input id="sale_number_all" type="hidden" value="' + sale_number + '" /></td>');

	
	var avg_price_regist = 0;
	for (var i = 0; i < analysis.length ; i++) {
		var per_seller = 0;
		per_seller = parseInt($('#avg_price_regist_' + analysis[i].seller_cd).val())
					   * parseInt($('#sale_number_' + analysis[i].seller_cd).val())
					   ;
		
		if (per_seller) {
			avg_price_regist = avg_price_regist + per_seller;
		}
	}
	
	avg_price_regist = Math.ceil(avg_price_regist / $('#sale_number_all').val());
	if ($('#sale_number_all').val() == 0) {
		avg_price_regist = '----';
	}
	$('#avg_price_regist th:first-child').after('<td>' + avg_price_regist + '万円</td>');
		
	

	var avg_price_sold = 0;
	for (var i = 0; i < analysis.length ; i++) {
		var per_seller = 0;
		per_seller = parseInt($('#avg_price_soldout_' + analysis[i].seller_cd).val())
					   * parseInt($('#sale_number_' + analysis[i].seller_cd).val())
					   ;
		
		if (per_seller) {
			avg_price_sold = avg_price_sold + per_seller;
		}
	}
	
	avg_price_sold = Math.ceil(avg_price_sold / $('#sale_number_all').val());
	if ($('#sale_number_all').val() == 0) {
		avg_price_sold = '----';
	}
	
	$('#avg_price_sold th:first-child').after('<td>' + avg_price_sold + '万円</td>');


	
	var time = 0;
	for (var i = 0; i < analysis.length ; i++) {
		var per_seller = 0;
		per_seller = parseInt($('#time_' + analysis[i].seller_cd).val())
					   * parseInt($('#sale_number_' + analysis[i].seller_cd).val())
					   ;
		
		if (per_seller) {
			time = time + per_seller;
		}
	}
	
	time = Math.ceil(time / $('#sale_number_all').val());
	if ($('#sale_number_all').val() == 0) {
		time = '----';
	}
	
	$('#avg_time_sold th:first-child').after('<td>' + time + '日間</td>');


	
	var avg_time_change_circle = 0;
	var sum = 0;
	var count_item = 0;
	for (var i = 0; i < analysis.length ; i++) {
		for (var k = 0; k < analysis[i].items.length; k++){
			var hist_regist = new Date(analysis[i].items[k].date_soldout);		
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
	
	avg_time_change_circle = Math.ceil(sum / count_item);
	if (count_item == 0) {
		avg_time_change_circle = '----';
	}
	
	$('#avg_time_change_circle th:first-child').after('<td>' + avg_time_change_circle + '日間</td>');
	
	
	var down_price_rate = 0;
	for (var i = 0; i < analysis.length ; i++) {
		var per_seller = 0;
		per_seller = parseFloat($('#down_price_rate_' + analysis[i].seller_cd).val())
					   * parseInt($('#sale_number_' + analysis[i].seller_cd).val())
					   ;
		
		if (per_seller) {
			down_price_rate = down_price_rate + per_seller;
		}
	}
	
	down_price_rate = (down_price_rate / $('#sale_number_all').val()).toFixed(2);
	if ($('#sale_number_all').val() == 0) {
		down_price_rate = '----';
	}
	$('#avg_down_price_rate th:first-child').after('<td>' + down_price_rate + '%</td>');
	
	$('#market_rate th:first-child').after('<td>100%</td>');
}




function drawPieChart() {
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Seller');
    data.addColumn('number', '販売シェア率');	
    
	for (var i = 0; i < window.market_rate.length; i++) {
		 data.addRows([[window.market_rate[i][0], window.market_rate[i][1]]]);	
	}
        var options = {
          title: '販売シェア率',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }