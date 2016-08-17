$(document).ready(function () {
	window.market_rate = Array();
	window.market_rate_jonan = Array();
	window.market_rate_minami = Array();
	window.market_rate_nishi = Array();
	window.market_rate_higashi = Array();
	window.market_rate_chuo = Array();
	window.market_rate_hakata = Array();
	window.market_rate_sawara = Array();
	window.market_rate_koga = Array();
	window.market_rate_sasaguri = Array();
	window.market_rate_shime = Array();
	window.market_rate_kasuga = Array();
	window.market_rate_fukutsu = Array();
	window.market_rate_sue = Array();
	window.market_rate_ounojou = Array();
	window.market_rate_hisayama = Array();
	window.market_rate_nakagawa = Array();
	window.market_rate_itoshima = Array();
	window.market_rate_shingu = Array();
	window.market_rate_kurume = Array();
	window.market_rate_kasuya = Array();
	window.market_rate_umimachi = Array();
	window.market_rate_dazaifu = Array();
	window.market_rate_yanagawa = Array();
	window.market_rate_chikuzen = Array();
	window.market_rate_kamimine = Array();
	window.market_rate_tachiarai = Array();
	window.market_rate_ogori = Array();
	window.market_rate_chikujou = Array();
	window.market_rate_chikushino = Array();
	window.market_rate_miyaki = Array();
	window.market_rate_tosu = Array();
	window.market_rate_kiyama = Array();
	
	
	$('#analysis_tbl').hide();
	$(".overlay").hide();
	
	
    $(".btn-aggregate").click(function (e) {
        e.preventDefault();
        $(".overlay").show();
        $('#error').html('');
        $('#chart_div').html('');
        
        google.charts.setOnLoadCallback(drawChart);
		
		window.market_rate = Array();
		window.market_rate_jonan = Array();
		window.market_rate_minami = Array();
		window.market_rate_nishi = Array();
		window.market_rate_higashi = Array();
		window.market_rate_chuo = Array();
		window.market_rate_hakata = Array();
		window.market_rate_sawara = Array();
		window.market_rate_koga = Array();
		window.market_rate_sasaguri = Array();
		window.market_rate_shime = Array();
		window.market_rate_kasuga = Array();
		window.market_rate_fukutsu = Array();
		window.market_rate_sue = Array();
		window.market_rate_ounojou = Array();
		window.market_rate_hisayama = Array();
		window.market_rate_nakagawa = Array();
		window.market_rate_itoshima = Array();
		window.market_rate_shingu = Array();
		window.market_rate_kurume = Array();
		window.market_rate_kasuya = Array();
		window.market_rate_umimachi = Array();
		window.market_rate_dazaifu = Array();
		window.market_rate_yanagawa = Array();
		window.market_rate_chikuzen = Array();
		window.market_rate_kamimine = Array();
		window.market_rate_tachiarai = Array();
		window.market_rate_ogori = Array();
		window.market_rate_chikujou = Array();
		window.market_rate_chikushino = Array();
		window.market_rate_miyaki = Array();
		window.market_rate_tosu = Array();
		window.market_rate_kiyama = Array();
		
			$('#analysis_tbl').show();
			$('#name').html('<th width="12%"></th>');
			$('#sale_number').html('<th>売出件数</th>');
			$('#selling_number').html('<th>売出中物件数</th>');
			$('#soldout_number').html('<th>成約済物件数</th>');
			$('#soldout_before_complete_number').html('<th>売出前成約件数</th>');
			$('#rate_soldout_before_complete').html('<th>売出前成約率</th>');
			$('#avg_price_regist').html('<th>平均売出価格</th>');
			$('#avg_price_sold').html('<th>平均成約価格</th>');
			$('#avg_time_sold').html('<th>平均売出期間</th>');
			$('#avg_time_change_circle').html('<th>平均価格改定周期</th>');
			$('#avg_down_price').html('<th>平均値下価格</th>');
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
			window.market_rate_jonan = Array();
			window.market_rate_minami = Array();
			window.market_rate_nishi = Array();
			window.market_rate_higashi = Array();
			window.market_rate_chuo = Array();
			window.market_rate_hakata = Array();
			window.market_rate_sawara = Array();
			window.market_rate_koga = Array();
			window.market_rate_sasaguri = Array();
			window.market_rate_shime = Array();
			window.market_rate_kasuga = Array();
			window.market_rate_fukutsu = Array();
			window.market_rate_sue = Array();
			window.market_rate_ounojou = Array();
			window.market_rate_hisayama = Array();
			window.market_rate_nakagawa = Array();
			window.market_rate_itoshima = Array();
			window.market_rate_shingu = Array();
			window.market_rate_kurume = Array();
			window.market_rate_kasuya = Array();
			window.market_rate_umimachi = Array();
			window.market_rate_dazaifu = Array();
			window.market_rate_yanagawa = Array();
			window.market_rate_chikuzen = Array();
			window.market_rate_kamimine = Array();
			window.market_rate_tachiarai = Array();
			window.market_rate_ogori = Array();
			window.market_rate_chikujou = Array();
			window.market_rate_chikushino = Array();
			window.market_rate_miyaki = Array();
			window.market_rate_tosu = Array();
			window.market_rate_kiyama = Array();
			
			$('#analysis_tbl').show();
			$('#name').html('<th width="12%"></th>');
			$('#sale_number').html('<th>売出件数</th>');
			$('#selling_number').html('<th>売出中物件数</th>');
			$('#soldout_number').html('<th>成約済物件数</th>');
			$('#soldout_before_complete_number').html('<th>売出前成約件数</th>');
			$('#rate_soldout_before_complete').html('<th>売出前成約率</th>');
			$('#avg_price_regist').html('<th>平均売出価格</th>');
			$('#avg_price_sold').html('<th>平均成約価格</th>');
			$('#avg_time_sold').html('<th>平均売出期間</th>');
			$('#avg_time_change_circle').html('<th>平均価格改定周期</th>');
			$('#avg_down_price').html('<th>平均値下価格</th>');
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
        } else {
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
	}
    });

function analysisGroupItem() {
	//------------------------------------		
	//search in radius
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
	var layout = new Array();
	$.each($("input[name='layout[]']:checked"), function() {
		layout.push($(this).val());
	});
	var seller = new Array();
	$.each($("input[name='seller[]']:checked"), function() {
		seller.push($(this).val());
	});

	
	var formData = {
		city: city,
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
		if (analysis[i].seller_cd != null) {
			var td_sale_number = '';
			var td_selling_number = '';
			var td_soldout_number = '';
			var td_soldout_before_complete_number = '';
			var td_rate_soldout_before_complete = '';
			var td_sale_number = '';
			var td_avg_price_regist = '';
			var td_avg_price_soldout = '';
			var time = '';			
			var avg_time_change_price = '';
			var td_avg_down_price = '';
			var avg_down_price_rate = '';
			var market_rate = '';
			
			
			
			var count_item_sale_number = 0;
			var count_item_soldout = 0;
			var count_item_soldout_before_complete = 0;
			var sum_price_regist = 0;
			var count_item_price_regist = 0;			
			var sum_price_soldout = 0;
			var count_item_price_soldout = 0;			
			var sum_time = 0;
			var count_item_time = 0;
			var sum_time_change_price = 0;
			var count_item_time_change_price = 0;			
			var sum_down_price = 0;
			var sum_down_price_rate = 0;
			var count_item_down_price_rate = 0;			
			var sum_market_rate = 0;
			var count_item_market_rate = 0;			
			var count_total_item = 0;	
			for ( var n = 0; n < analysis.length; n++ ) {
				var count_item_per_seller = 0;
				for (var k = 0; k < analysis[n].items.length; k++){
					var hist_regist = new Date(analysis[n].items[k].regist);
					count_item_per_seller++;
				}
				count_total_item = count_total_item + count_item_per_seller;
			}
			
				var count_item_in_jonan = 0;
				var count_item_in_minami = 0;
				var count_item_in_nishi = 0;
				var count_item_in_higashi = 0;
				var count_item_in_chuo = 0;
				var count_item_in_hakata = 0;
				var count_item_in_sawara = 0;
				var count_item_in_koga = 0;
				var count_item_in_sasaguri = 0;
				var count_item_in_shime = 0;
				var count_item_in_kasuga = 0;
				var count_item_in_fukutsu = 0;
				var count_item_in_sue = 0;
				var count_item_in_ounojou = 0;
				var count_item_in_hisayama = 0;
				var count_item_in_nakagawa = 0;
				var count_item_in_itoshima = 0;
				var count_item_in_shingu = 0;
				var count_item_in_kurume = 0;
				var count_item_in_kasuya = 0;
				var count_item_in_umimachi = 0;
				var count_item_in_dazaifu = 0;
				var count_item_in_yanagawa = 0;
				var count_item_in_chikuzen = 0;
				var count_item_in_kamimine = 0;
				var count_item_in_tachiarai = 0;
				var count_item_in_ogori = 0;
				var count_item_in_chikujou = 0;
				var count_item_in_chikushino = 0;
				var count_item_in_miyaki = 0;
				var count_item_in_tosu = 0;
				var count_item_in_kiyama = 0;
			
			for (var k = 0; k < analysis[i].items.length; k++){
				//sale number
				count_item_sale_number++;
				
		
				if (analysis[i].items[k].city_cd == 40136) {
					count_item_in_jonan++;
				}
				if (analysis[i].items[k].city_cd == 40134) {
					count_item_in_minami++;
				}
				if (analysis[i].items[k].city_cd == 40135) {
					count_item_in_nishi++;
				}
				if (analysis[i].items[k].city_cd == 40131) {
					count_item_in_higashi++;
				}
				if (analysis[i].items[k].city_cd == 40133) {
					count_item_in_chuo++;
				}
				if (analysis[i].items[k].city_cd == 40132) {
					count_item_in_hakata++;
				}
				if (analysis[i].items[k].city_cd == 40137) {
					count_item_in_sawara++;
				}
				if (analysis[i].items[k].city_cd == 40223) {
					count_item_in_koga++;
				}
				if (analysis[i].items[k].city_cd == 40342) {
					count_item_in_sasaguri++;
				}
				if (analysis[i].items[k].city_cd == 40343) {
					count_item_in_shime++;
				}
				if (analysis[i].items[k].city_cd == 40218) {
					count_item_in_kasuga++;
				}
				if (analysis[i].items[k].city_cd == 40224) {
					count_item_in_fukutsu++;
				}
				if (analysis[i].items[k].city_cd == 40344) {
					count_item_in_sue++;
				}
				if (analysis[i].items[k].city_cd == 40219) {
					count_item_in_ounojou++;
				}
				if (analysis[i].items[k].city_cd == 40348) {
					count_item_in_hisayama++;
				}
				if (analysis[i].items[k].city_cd == 40305) {
					count_item_in_nakagawa++;
				}
				if (analysis[i].items[k].city_cd == 40230) {
					count_item_in_itoshima++;
				}
				if (analysis[i].items[k].city_cd == 40345) {
					count_item_in_shingu++;
				}
				if (analysis[i].items[k].city_cd == 40203) {
					count_item_in_kurume++;
				}
				if (analysis[i].items[k].city_cd == 40349) {
					count_item_in_kasuya++;
				}
				if (analysis[i].items[k].city_cd == 40341) {
					count_item_in_umimachi++;
				}
				if (analysis[i].items[k].city_cd == 40221) {
					count_item_in_dazaifu++;
				}
				if (analysis[i].items[k].city_cd == 40207) {
					count_item_in_yanagawa++;
				}
				if (analysis[i].items[k].city_cd == 40447) {
					count_item_in_chikuzen++;
				}
				if (analysis[i].items[k].city_cd == 41345) {
					count_item_in_kamimine++;
				}
				if (analysis[i].items[k].city_cd == 40503) {
					count_item_in_tachiarai++;
				}
				if (analysis[i].items[k].city_cd == 40216) {
					count_item_in_ogori++;
				}
				if (analysis[i].items[k].city_cd == 40647) {
					count_item_in_chikujou++;
				}
				if (analysis[i].items[k].city_cd == 40217) {
					count_item_in_chikushino++;
				}
				if (analysis[i].items[k].city_cd == 41346) {
					count_item_in_miyaki++;
				}
				if (analysis[i].items[k].city_cd == 41203) {
					count_item_in_tosu++;
				}
				if (analysis[i].items[k].city_cd == 41341) {
					count_item_in_kiyama++;
				}
				
				
				//avg price regist
				if (analysis[i].items[k].price_regist != null) {
					count_item_price_regist++
					sum_price_regist = sum_price_regist + parseFloat(analysis[i].items[k].price_regist);
				}
				
				//avg price soldout
				if (analysis[i].items[k].price_soldout != null) {
					count_item_soldout++;
					count_item_price_soldout++;
					
					if ( analysis[i].items[k].date_build > analysis[i].items[k].date_soldout ) {
						count_item_soldout_before_complete++;	
					}
					sum_price_soldout = sum_price_soldout + parseInt(analysis[i].items[k].price_soldout);
				}
				
				
				//time sale
				count_item_time++;
				sum_time = sum_time + parseInt(analysis[i].items[k].time);
				
				//avg time change price
				for (var m = 0; m < analysis[i].items[k].history.length; m++) {
					if (analysis[i].items[k].history[m].stat_cd == 2) {
						for (var n = m - 1; n >= 0; n--) {
							if(analysis[i].items[k].history[m].stat_cd == "2" || analysis[i].items[k].history[m].stat_cd == "1") {
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
				
				//avg down price rate
				if (analysis[i].items[k].price_regist != null && analysis[i].items[k].price_soldout != null) {
					var down_price = (analysis[i].items[k].price_regist - analysis[i].items[k].price_soldout);
					sum_down_price = sum_down_price + down_price;
					sum_down_price_rate = sum_down_price_rate + parseFloat( down_price / analysis[i].items[k].price_regist);
					count_item_down_price_rate++; 
				}
				
				//market_rate
				count_item_market_rate++;
			}
			
			
			//sale number
			window.market_rate.push([analysis[i].seller_name, parseInt(count_item_sale_number)]);
			window.market_rate_jonan.push([analysis[i].seller_name, parseInt(count_item_in_jonan)]);
			window.market_rate_minami.push([analysis[i].seller_name, parseInt(count_item_in_minami)]);
			window.market_rate_nishi.push([analysis[i].seller_name, parseInt(count_item_in_nishi)]);
			window.market_rate_higashi.push([analysis[i].seller_name, parseInt(count_item_in_higashi)]);
			window.market_rate_chuo.push([analysis[i].seller_name, parseInt(count_item_in_chuo)]);
			window.market_rate_hakata.push([analysis[i].seller_name, parseInt(count_item_in_hakata)]);
			window.market_rate_sawara.push([analysis[i].seller_name, parseInt(count_item_in_sawara)]);
			window.market_rate_koga.push([analysis[i].seller_name, parseInt(count_item_in_koga)]);
			window.market_rate_sasaguri.push([analysis[i].seller_name, parseInt(count_item_in_sasaguri)]);
			window.market_rate_shime.push([analysis[i].seller_name, parseInt(count_item_in_shime)]);
			window.market_rate_kasuga.push([analysis[i].seller_name, parseInt(count_item_in_kasuga)]);
			window.market_rate_fukutsu.push([analysis[i].seller_name, parseInt(count_item_in_fukutsu)]);
			window.market_rate_sue.push([analysis[i].seller_name, parseInt(count_item_in_sue)]);
			window.market_rate_ounojou.push([analysis[i].seller_name, parseInt(count_item_in_ounojou)]);
			window.market_rate_hisayama.push([analysis[i].seller_name, parseInt(count_item_in_hisayama)]);
			window.market_rate_nakagawa.push([analysis[i].seller_name, parseInt(count_item_in_nakagawa)]);
			window.market_rate_itoshima.push([analysis[i].seller_name, parseInt(count_item_in_itoshima)]);
			window.market_rate_shingu.push([analysis[i].seller_name, parseInt(count_item_in_shingu)]);
			window.market_rate_kurume.push([analysis[i].seller_name, parseInt(count_item_in_kurume)]);
			window.market_rate_kasuya.push([analysis[i].seller_name, parseInt(count_item_in_kasuya)]);
			window.market_rate_umimachi.push([analysis[i].seller_name, parseInt(count_item_in_umimachi)]);
			window.market_rate_dazaifu.push([analysis[i].seller_name, parseInt(count_item_in_dazaifu)]);
			window.market_rate_yanagawa.push([analysis[i].seller_name, parseInt(count_item_in_yanagawa)]);
			window.market_rate_chikuzen.push([analysis[i].seller_name, parseInt(count_item_in_chikuzen)]);
			window.market_rate_kamimine.push([analysis[i].seller_name, parseInt(count_item_in_kamimine)]);
			window.market_rate_tachiarai.push([analysis[i].seller_name, parseInt(count_item_in_tachiarai)]);
			window.market_rate_ogori.push([analysis[i].seller_name, parseInt(count_item_in_ogori)]);
			window.market_rate_chikujou.push([analysis[i].seller_name, parseInt(count_item_in_chikujou)]);
			window.market_rate_chikushino.push([analysis[i].seller_name, parseInt(count_item_in_chikushino)]);
			window.market_rate_miyaki.push([analysis[i].seller_name, parseInt(count_item_in_miyaki)]);
			window.market_rate_tosu.push([analysis[i].seller_name, parseInt(count_item_in_tosu)]);
			window.market_rate_kiyama.push([analysis[i].seller_name, parseInt(count_item_in_kiyama)]);
			
			//selling number
			selling_number = count_item_sale_number - count_item_soldout;
			
			//avg price regist
			var avg_price_regist = Math.ceil(sum_price_regist / count_item_price_regist);
			if (count_item_price_regist == 0) {
				avg_price_regist = '----';	
			}
						
			//avg price soldout
			var avg_price_soldout = Math.ceil(sum_price_soldout / count_item_price_soldout);
			if (count_item_price_soldout == 0) {
				avg_price_soldout = '----';	
			}
			
			//rate soldout before complete
			rate_soldout_before_complete =  (count_item_soldout_before_complete / count_item_price_soldout * 100).toFixed(2);
			if (count_item_price_soldout == 0) {
				rate_soldout_before_complete = '----';
			}
			
			//time sale
			var avg_time_time = Math.ceil(sum_time / count_item_time);
			if (count_item_time == 0) {
				avg_time_time = '----';	
			}
			//avg time change price
			var avg_time_time_change_price = Math.ceil(sum_time_change_price / count_item_time_change_price);
			if (count_item_time_change_price == 0) {
				avg_time_time_change_price = '----';	
			}
			
			//avg down price
			var avg_down_price = Math.ceil(sum_down_price / count_item_down_price_rate);
			if (count_item_down_price_rate == 0) {
				avg_down_price = '----';	
			}
			
			//avg down price rate
			var rate_down_price_rate = (sum_down_price_rate / count_item_down_price_rate * 100).toFixed(2);
			if (count_item_down_price_rate == 0) {
				rate_down_price_rate = '----';	
			}
			
			//market rate
			var rate_market_rate = (count_item_market_rate / count_total_item * 100).toFixed(2);
			if (count_total_item == 0) {
				rate_market_rate = 0;	
			}
			
			
			
			//sale number
			td_sale_number = td_sale_number + '<td>' + count_item_sale_number 
							+ '<input type="hidden" id="sale_number_'
							+ analysis[i].seller_cd 
							+ '" value="' + count_item_sale_number + '" /></td>';
			
			//selling number
			td_selling_number = td_selling_number + '<td>' + selling_number
							+ '<input type="hidden" id="selling_number_'
							+ analysis[i].seller_cd 
							+ '" value="' + selling_number + '" /></td>';				
			
			//soldout number
			td_soldout_number = td_soldout_number + '<td>' + count_item_soldout 
							+ '<input type="hidden" id="soldout_number_'
							+ analysis[i].seller_cd 
							+ '" value="' + count_item_soldout + '" /></td>';

			//soldout before complete number
			td_soldout_before_complete_number = td_soldout_before_complete_number + '<td>' + count_item_soldout_before_complete 
							+ '<input type="hidden" id="soldout_before_complete_number_'
							+ analysis[i].seller_cd 
							+ '" value="' + count_item_soldout_before_complete + '" /></td>';
							
			//rate soldout before complete
			td_rate_soldout_before_complete = td_rate_soldout_before_complete + '<td>' + rate_soldout_before_complete 
							+ '%<input type="hidden" id="rate_soldout_before_complete_'
							+ analysis[i].seller_cd 
							+ '" value="' + rate_soldout_before_complete + '" /></td>';			

			//avg price regist
			td_avg_price_regist = td_avg_price_regist + '<td>' + avg_price_regist 
								+ '万円<input type="hidden" id="avg_price_regist_'
								+ analysis[i].seller_cd
								+ '" value="' + avg_price_regist + '" /></td>';

			//avg price soldout
			td_avg_price_soldout = td_avg_price_soldout + '<td>' + avg_price_soldout 
								+ '万円<input type="hidden" id="avg_price_soldout_'
								+ analysis[i].seller_cd 
								+ '" value="' + avg_price_soldout + '" /></td>';			
			
			//time sale
			time = time + '<td>' + avg_time_time 
				 + '日間<input type="hidden" id="time_'
				 + analysis[i].seller_cd 
				 + '" value="' + avg_time_time + '" /></td>';
			
			
			//avg time change price
			avg_time_change_price = avg_time_change_price + '<td>' + avg_time_time_change_price 
								  + '日間<input type="hidden" id="time_change_price_'
								  + analysis[i].seller_cd 
								  + '" value="' + avg_time_time_change_price + '" /></td>';
			
			//avg down price
			td_avg_down_price = td_avg_down_price + '<td>' + avg_down_price + '万円'
								  + '<input type="hidden" id="down_price_'
								  + analysis[i].seller_cd 
								  + '" value="' + avg_down_price + '" /></td>';
			
			//avg down price rate
			avg_down_price_rate = avg_down_price_rate + '<td>' + rate_down_price_rate + '%' 
								  + '<input type="hidden" id="down_price_rate_'
								  + analysis[i].seller_cd 
								  + '" value="' + rate_down_price_rate + '" /></td>';
			
			//market rate
			market_rate = market_rate + '<td>' + rate_market_rate + '%' 
						+ '<input type="hidden" id="market_rate_'
						+ analysis[i].seller_cd 
						+ '" value="' + rate_market_rate + '" /></td>';
			
			
			$('#name').append('<th>' + analysis[i].seller_name + '</th>');
			$('#sale_number').append(td_sale_number);
			$('#selling_number').append(td_selling_number);
			$('#soldout_number').append(td_soldout_number);
			$('#soldout_before_complete_number').append(td_soldout_before_complete_number);
			$('#rate_soldout_before_complete').append(td_rate_soldout_before_complete);
			$('#avg_price_regist').append(td_avg_price_regist);
			$('#avg_price_sold').append(td_avg_price_soldout);
			$('#avg_time_sold').append(time);
			$('#avg_time_change_circle').append(avg_time_change_price);
			$('#avg_down_price').append(td_avg_down_price);
			$('#avg_down_price_rate').append(avg_down_price_rate);
			$('#market_rate').append(market_rate);
		}
	}
	
	//total
	var sale_number	= 0;
	var selling_number	= 0;
	var soldout_number	= 0;
	var soldout_before_complete_number	= 0;
	var avg_price_regist = 0;
	var avg_price_sold = 0;
	var time = 0;
	var avg_time_change_circle = 0;
	var sum = 0;
	var count_item = 0;
	var down_price = 0;
	var down_price_rate = 0;	
	var market_rate = 0;
	
	for (var i = 0; i < analysis.length ; i++) {
		//sale number
		var per_seller = parseInt($('#sale_number_' + analysis[i].seller_cd).val());
		if (per_seller) {
			sale_number = sale_number + per_seller;
		}
		
		//selling number
		var per_seller = parseInt($('#selling_number_' + analysis[i].seller_cd).val());
		if (per_seller) {
			selling_number = selling_number + per_seller;
		}
		

		//soldout number
		var per_seller = parseInt($('#soldout_number_' + analysis[i].seller_cd).val());
		if (per_seller) {
			soldout_number = soldout_number + per_seller;
		}
		
		//soldout before complete number
		var per_seller = parseInt($('#soldout_before_complete_number_' + analysis[i].seller_cd).val());
		if (per_seller) {
			soldout_before_complete_number = soldout_before_complete_number + per_seller;
		}
		
		//avg price regist
		var per_seller = 0;
		per_seller = parseInt($('#avg_price_regist_' + analysis[i].seller_cd).val())
					   * parseInt($('#sale_number_' + analysis[i].seller_cd).val());
		
		if (per_seller) {
			avg_price_regist = avg_price_regist + per_seller;
		}
		
		//avg price soldout
		var per_seller = 0;
		per_seller = parseInt($('#avg_price_soldout_' + analysis[i].seller_cd).val())
					   * parseInt($('#sale_number_' + analysis[i].seller_cd).val());
		
		if (per_seller) {
			avg_price_sold = avg_price_sold + per_seller;
		}		
		
		//time sale
		var per_seller = 0;
		per_seller = parseInt($('#time_' + analysis[i].seller_cd).val())
					   * parseInt($('#soldout_number_' + analysis[i].seller_cd).val());
		
		if (per_seller) {
			time = time + per_seller;
		}
		
		//avg time change price
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
		

		
		// avg down price
		var per_seller = 0;
		per_seller = parseFloat($('#down_price_' + analysis[i].seller_cd).val())
					   * parseInt($('#soldout_number_' + analysis[i].seller_cd).val());
		
		if (per_seller) {
			down_price = down_price + per_seller;
		}


		// down price rate
		var per_seller = 0;
		per_seller = parseFloat($('#down_price_rate_' + analysis[i].seller_cd).val())
					   * parseInt($('#soldout_number_' + analysis[i].seller_cd).val());
		
		if (per_seller) {
			down_price_rate = down_price_rate + per_seller;
		}
		
		//market rate
		var per_seller = 0;
		per_seller = parseFloat($('#market_rate_' + analysis[i].seller_cd).val());
		
		if (per_seller) {
			market_rate = market_rate + per_seller;
		}
	}
	
	//rate soldout before complete
	rate_soldout_before_complete = (soldout_before_complete_number / soldout_number * 100).toFixed(2);
	if (soldout_number == 0) {
		rate_soldout_before_complete = 0;
	}
	
	//avg price regist
	avg_price_regist = Math.ceil(avg_price_regist / soldout_number);
	//avg price soldout
	avg_price_sold = Math.ceil(avg_price_sold / soldout_number);
	//time sale
	time = Math.ceil(time / soldout_number);
	//avg time change price
	avg_time_change_circle = Math.ceil(sum / count_item);
	if (count_item == 0) {
		avg_time_change_circle = '----';
	}
	
	//down price rate
	down_price = Math.ceil(down_price / soldout_number);

	//down price rate
	down_price_rate = (down_price_rate / soldout_number).toFixed(2);
	
	if (soldout_number == 0) {
		avg_price_regist = '----';
		avg_price_sold = '----';
		time = '----';
		down_price = '----';
		down_price_rate = '----';
	}
		
	$('#name th:first-child').after('<th>地域の総合</th>');
	$('#sale_number th:first-child').after('<td>' + sale_number 
							 + '<input id="sale_number_all" type="hidden" value="' + sale_number + '" /></td>');
	$('#selling_number th:first-child').after('<td>' + selling_number + '</td>');
	$('#soldout_number th:first-child').after('<td>' + soldout_number + '</td>');
	$('#soldout_before_complete_number th:first-child').after('<td>' + soldout_before_complete_number + '</td>');
	$('#rate_soldout_before_complete th:first-child').after('<td>' + rate_soldout_before_complete + '%</td>');
	$('#avg_price_regist th:first-child').after('<td>' + avg_price_regist + '万円</td>');
	$('#avg_price_sold th:first-child').after('<td>' + avg_price_sold + '万円</td>');		
	$('#avg_time_sold th:first-child').after('<td>' + time + '日間</td>');
	$('#avg_time_change_circle th:first-child').after('<td>' + avg_time_change_circle + '日間</td>');
	$('#avg_down_price th:first-child').after('<td>' + down_price + '万円</td>');
	$('#avg_down_price_rate th:first-child').after('<td>' + down_price_rate + '%</td>');
	$('#market_rate th:first-child').after('<td>' + market_rate.toFixed(0) + '%</td>');
}


function drawPieChart() {
	$('#piechart_3d').html('');
	$('#piechart_3d_1').html('');
	$('#piechart_3d_2').html('');
	$('#piechart_3d_3').html('');
	$('#piechart_3d_4').html('');
	$('#piechart_3d_5').html('');
	$('#piechart_3d_6').html('');
	$('#piechart_3d_7').html('');
	$('#piechart_3d_8').html('');
	$('#piechart_3d_9').html('');
	$('#piechart_3d_10').html('');
	$('#piechart_3d_11').html('');
	$('#piechart_3d_12').html('');
	$('#piechart_3d_13').html('');
	$('#piechart_3d_14').html('');
	$('#piechart_3d_15').html('');
	$('#piechart_3d_16').html('');
	$('#piechart_3d_17').html('');
	$('#piechart_3d_18').html('');
	$('#piechart_3d_19').html('');
	$('#piechart_3d_20').html('');
	$('#piechart_3d_21').html('');
	$('#piechart_3d_22').html('');
	$('#piechart_3d_23').html('');
	$('#piechart_3d_24').html('');
	$('#piechart_3d_25').html('');
	$('#piechart_3d_26').html('');
	$('#piechart_3d_27').html('');
	$('#piechart_3d_28').html('');
	$('#piechart_3d_29').html('');
	$('#piechart_3d_30').html('');
	$('#piechart_3d_31').html('');
	$('#piechart_3d_32').html('');
	

	var dont_draw = 1;
	$('#piechart_3d').hide();
	for (var i = 0; i < window.market_rate.length; i++) {
		if ( window.market_rate[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d').show();
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Seller');
		data.addColumn('number', '販売シェア率');
		data.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate.length; i++) {
			sum = sum + window.market_rate[i][1];
		}
		
		for (var i = 0; i < window.market_rate.length; i++) {
			var rate = (window.market_rate[i][1] / sum * 100).toFixed(1);
			 data.addRows([[window.market_rate[i][0], window.market_rate[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate[i][0] + '<br><b>' + window.market_rate[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = { 
		  title: '全体',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'},
		};
		
		var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
		chart.draw(data, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_1').hide();
	for (var i = 0; i < window.market_rate_jonan.length; i++) {
		if ( window.market_rate_jonan[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_1').show();
		var data1 = new google.visualization.DataTable();
		data1.addColumn('string', 'Seller');
		data1.addColumn('number', '販売シェア率');	
		data1.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_jonan.length; i++) {
			sum = sum + window.market_rate_jonan[i][1];
		}
		
		for (var i = 0; i < window.market_rate_jonan.length; i++) {
			var rate = (window.market_rate_jonan[i][1] / sum * 100).toFixed(1);
			 data1.addRows([[window.market_rate_jonan[i][0], window.market_rate_jonan[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_jonan[i][0] + '<br><b>' + window.market_rate_jonan[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '福岡市城南区',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart1 = new google.visualization.PieChart(document.getElementById('piechart_3d_1'));
		chart1.draw(data1, options);
	}

	var dont_draw = 1;
	$('#piechart_3d_2').hide();
	for (var i = 0; i < window.market_rate_minami.length; i++) {
		if ( window.market_rate_minami[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_2').show();
		var data2 = new google.visualization.DataTable();
		data2.addColumn('string', 'Seller');
		data2.addColumn('number', '販売シェア率');	
		data2.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_minami.length; i++) {
			sum = sum + window.market_rate_minami[i][1];
		}
		
		for (var i = 0; i < window.market_rate_minami.length; i++) {
			var rate = (window.market_rate_minami[i][1] / sum * 100).toFixed(1);
			 data2.addRows([[window.market_rate_minami[i][0], window.market_rate_minami[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_minami[i][0] + '<br><b>' + window.market_rate_minami[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '福岡市南区',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart2 = new google.visualization.PieChart(document.getElementById('piechart_3d_2'));
		chart2.draw(data2, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_3').hide();
	for (var i = 0; i < window.market_rate_nishi.length; i++) {
		if ( window.market_rate_nishi[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_3').show();
		var data3 = new google.visualization.DataTable();
		data3.addColumn('string', 'Seller');
		data3.addColumn('number', '販売シェア率');	
		data3.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_nishi.length; i++) {
			sum = sum + window.market_rate_nishi[i][1];
		}
		
		for (var i = 0; i < window.market_rate_nishi.length; i++) {
			var rate = (window.market_rate_nishi[i][1] / sum * 100).toFixed(1);
			 data3.addRows([[window.market_rate_nishi[i][0], window.market_rate_nishi[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_nishi[i][0] + '<br><b>' + window.market_rate_nishi[i][1] + ' (' + rate + '%)</b></div>']]);	
		}		var options = {
		  title: '福岡市西区',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart3 = new google.visualization.PieChart(document.getElementById('piechart_3d_3'));
		chart3.draw(data3, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_4').hide();
	for (var i = 0; i < window.market_rate_higashi.length; i++) {
		if ( window.market_rate_higashi[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_4').show();
		var data4 = new google.visualization.DataTable();
		data4.addColumn('string', 'Seller');
		data4.addColumn('number', '販売シェア率');	
		data4.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_higashi.length; i++) {
			sum = sum + window.market_rate_higashi[i][1];
		}
		
		for (var i = 0; i < window.market_rate_higashi.length; i++) {
			var rate = (window.market_rate_higashi[i][1] / sum * 100).toFixed(1);
			 data4.addRows([[window.market_rate_higashi[i][0], window.market_rate_higashi[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_higashi[i][0] + '<br><b>' + window.market_rate_higashi[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '福岡市東区',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart4 = new google.visualization.PieChart(document.getElementById('piechart_3d_4'));
		chart4.draw(data4, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_5').hide();
	for (var i = 0; i < window.market_rate_chuo.length; i++) {
		if ( window.market_rate_chuo[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_5').show();
		var data5 = new google.visualization.DataTable();
		data5.addColumn('string', 'Seller');
		data5.addColumn('number', '販売シェア率');	
		data5.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_chuo.length; i++) {
			sum = sum + window.market_rate_chuo[i][1];
		}
		
		for (var i = 0; i < window.market_rate_chuo.length; i++) {
			var rate = (window.market_rate_chuo[i][1] / sum * 100).toFixed(1);
			 data5.addRows([[window.market_rate_chuo[i][0], window.market_rate_chuo[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_chuo[i][0] + '<br><b>' + window.market_rate_chuo[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '福岡市中央区',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart5 = new google.visualization.PieChart(document.getElementById('piechart_3d_5'));
		chart5.draw(data5, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_6').hide();
	for (var i = 0; i < window.market_rate_hakata.length; i++) {
		if ( window.market_rate_hakata[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_6').show();
		var data6 = new google.visualization.DataTable();
		data6.addColumn('string', 'Seller');
		data6.addColumn('number', '販売シェア率');	
		data6.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_hakata.length; i++) {
			sum = sum + window.market_rate_hakata[i][1];
		}
		
		for (var i = 0; i < window.market_rate_hakata.length; i++) {
			var rate = (window.market_rate_hakata[i][1] / sum * 100).toFixed(1);
			 data6.addRows([[window.market_rate_hakata[i][0], window.market_rate_hakata[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_hakata[i][0] + '<br><b>' + window.market_rate_hakata[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '福岡市博多区',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart6 = new google.visualization.PieChart(document.getElementById('piechart_3d_6'));
		chart6.draw(data6, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_7').hide();
	for (var i = 0; i < window.market_rate_sawara.length; i++) {
		if ( window.market_rate_sawara[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_7').show();
		var data7 = new google.visualization.DataTable();
		data7.addColumn('string', 'Seller');
		data7.addColumn('number', '販売シェア率');	
		data7.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_sawara.length; i++) {
			sum = sum + window.market_rate_sawara[i][1];
		}
		
		for (var i = 0; i < window.market_rate_sawara.length; i++) {
			var rate = (window.market_rate_sawara[i][1] / sum * 100).toFixed(1);
			 data7.addRows([[window.market_rate_sawara[i][0], window.market_rate_sawara[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_sawara[i][0] + '<br><b>' + window.market_rate_sawara[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '福岡市早良区',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart7 = new google.visualization.PieChart(document.getElementById('piechart_3d_7'));
		chart7.draw(data7, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_8').hide();
	for (var i = 0; i < window.market_rate_koga.length; i++) {
		if ( window.market_rate_koga[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_8').show();
		var data8 = new google.visualization.DataTable();
		data8.addColumn('string', 'Seller');
		data8.addColumn('number', '販売シェア率');	
		data8.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_koga.length; i++) {
			sum = sum + window.market_rate_koga[i][1];
		}
		
		for (var i = 0; i < window.market_rate_koga.length; i++) {
			var rate = (window.market_rate_koga[i][1] / sum * 100).toFixed(1);
			 data8.addRows([[window.market_rate_koga[i][0], window.market_rate_koga[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_koga[i][0] + '<br><b>' + window.market_rate_koga[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '古賀市',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart8 = new google.visualization.PieChart(document.getElementById('piechart_3d_8'));
		chart8.draw(data8, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_9').hide();
	for (var i = 0; i < window.market_rate_sasaguri.length; i++) {
		if ( window.market_rate_sasaguri[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_9').show();
		var data9 = new google.visualization.DataTable();
		data9.addColumn('string', 'Seller');
		data9.addColumn('number', '販売シェア率');	
		data9.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_sasaguri.length; i++) {
			sum = sum + window.market_rate_sasaguri[i][1];
		}
		
		for (var i = 0; i < window.market_rate_sasaguri.length; i++) {
			var rate = (window.market_rate_sasaguri[i][1] / sum * 100).toFixed(1);
			 data9.addRows([[window.market_rate_sasaguri[i][0], window.market_rate_sasaguri[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_sasaguri[i][0] + '<br><b>' + window.market_rate_sasaguri[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '糟屋郡篠栗町',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart9 = new google.visualization.PieChart(document.getElementById('piechart_3d_9'));
		chart9.draw(data9, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_10').hide();
	for (var i = 0; i < window.market_rate_shime.length; i++) {
		if ( window.market_rate_shime[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_10').show();
		var data10 = new google.visualization.DataTable();
		data10.addColumn('string', 'Seller');
		data10.addColumn('number', '販売シェア率');	
		data10.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_shime.length; i++) {
			sum = sum + window.market_rate_shime[i][1];
		}
		
		for (var i = 0; i < window.market_rate_shime.length; i++) {
			var rate = (window.market_rate_shime[i][1] / sum * 100).toFixed(1);
			 data10.addRows([[window.market_rate_shime[i][0], window.market_rate_shime[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_shime[i][0] + '<br><b>' + window.market_rate_shime[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '糟屋郡志免町',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart10 = new google.visualization.PieChart(document.getElementById('piechart_3d_10'));
		chart10.draw(data10, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_11').hide();
	for (var i = 0; i < window.market_rate_kasuga.length; i++) {
		if ( window.market_rate_kasuga[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_11').show();
		var data11 = new google.visualization.DataTable();
		data11.addColumn('string', 'Seller');
		data11.addColumn('number', '販売シェア率');	
		data11.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_kasuga.length; i++) {
			sum = sum + window.market_rate_kasuga[i][1];
		}
		
		for (var i = 0; i < window.market_rate_kasuga.length; i++) {
			var rate = (window.market_rate_kasuga[i][1] / sum * 100).toFixed(1);
			 data11.addRows([[window.market_rate_kasuga[i][0], window.market_rate_kasuga[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_kasuga[i][0] + '<br><b>' + window.market_rate_kasuga[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '春日市',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart11 = new google.visualization.PieChart(document.getElementById('piechart_3d_11'));
		chart11.draw(data11, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_12').hide();
	for (var i = 0; i < window.market_rate_fukutsu.length; i++) {
		if ( window.market_rate_fukutsu[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_12').show();
		var data12 = new google.visualization.DataTable();
		data12.addColumn('string', 'Seller');
		data12.addColumn('number', '販売シェア率');
		data12.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_fukutsu.length; i++) {
			sum = sum + window.market_rate_fukutsu[i][1];
		}
		
		for (var i = 0; i < window.market_rate_fukutsu.length; i++) {
			var rate = (window.market_rate_fukutsu[i][1] / sum * 100).toFixed(1);
			 data12.addRows([[window.market_rate_fukutsu[i][0], window.market_rate_fukutsu[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_fukutsu[i][0] + '<br><b>' + window.market_rate_fukutsu[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '福津市',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart12 = new google.visualization.PieChart(document.getElementById('piechart_3d_12'));
		chart12.draw(data12, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_13').hide();
	for (var i = 0; i < window.market_rate_sue.length; i++) {
		if ( window.market_rate_sue[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_13').show();
		var data13 = new google.visualization.DataTable();
		data13.addColumn('string', 'Seller');
		data13.addColumn('number', '販売シェア率');
		data13.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_sue.length; i++) {
			sum = sum + window.market_rate_sue[i][1];
		}
		
		for (var i = 0; i < window.market_rate_sue.length; i++) {
			var rate = (window.market_rate_sue[i][1] / sum * 100).toFixed(1);
			 data13.addRows([[window.market_rate_sue[i][0], window.market_rate_sue[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_sue[i][0] + '<br><b>' + window.market_rate_sue[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '糟屋郡須惠町',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart13 = new google.visualization.PieChart(document.getElementById('piechart_3d_13'));
		chart13.draw(data13, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_14').hide();
	for (var i = 0; i < window.market_rate_ounojou.length; i++) {
		if ( window.market_rate_ounojou[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_14').show();
		var data14 = new google.visualization.DataTable();
		data14.addColumn('string', 'Seller');
		data14.addColumn('number', '販売シェア率');	
		data14.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_ounojou.length; i++) {
			sum = sum + window.market_rate_ounojou[i][1];
		}
		
		for (var i = 0; i < window.market_rate_ounojou.length; i++) {
			var rate = (window.market_rate_ounojou[i][1] / sum * 100).toFixed(1);
			 data14.addRows([[window.market_rate_ounojou[i][0], window.market_rate_ounojou[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_ounojou[i][0] + '<br><b>' + window.market_rate_ounojou[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '大野城市',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart14 = new google.visualization.PieChart(document.getElementById('piechart_3d_14'));
		chart14.draw(data14, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_15').hide();
	for (var i = 0; i < window.market_rate_hisayama.length; i++) {
		if ( window.market_rate_hisayama[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_15').show();
		var data15 = new google.visualization.DataTable();
		data15.addColumn('string', 'Seller');
		data15.addColumn('number', '販売シェア率');	
		data15.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_hisayama.length; i++) {
			sum = sum + window.market_rate_hisayama[i][1];
		}
		
		for (var i = 0; i < window.market_rate_hisayama.length; i++) {
			var rate = (window.market_rate_hisayama[i][1] / sum * 100).toFixed(1);
			 data15.addRows([[window.market_rate_hisayama[i][0], window.market_rate_hisayama[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_hisayama[i][0] + '<br><b>' + window.market_rate_hisayama[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '糟屋郡久山町',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart15 = new google.visualization.PieChart(document.getElementById('piechart_3d_15'));
		chart15.draw(data15, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_16').hide();
	for (var i = 0; i < window.market_rate_nakagawa.length; i++) {
		if ( window.market_rate_nakagawa[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_16').show();
		var data16 = new google.visualization.DataTable();
		data16.addColumn('string', 'Seller');
		data16.addColumn('number', '販売シェア率');	
		data16.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_nakagawa.length; i++) {
			sum = sum + window.market_rate_nakagawa[i][1];
		}
		
		for (var i = 0; i < window.market_rate_nakagawa.length; i++) {
			var rate = (window.market_rate_nakagawa[i][1] / sum * 100).toFixed(1);
			 data16.addRows([[window.market_rate_nakagawa[i][0], window.market_rate_nakagawa[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_nakagawa[i][0] + '<br><b>' + window.market_rate_nakagawa[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '筑紫郡那珂川町',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart16 = new google.visualization.PieChart(document.getElementById('piechart_3d_16'));
		chart16.draw(data16, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_17').hide();
	for (var i = 0; i < window.market_rate_itoshima.length; i++) {
		if ( window.market_rate_itoshima[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_17').show();
		var data17 = new google.visualization.DataTable();
		data17.addColumn('string', 'Seller');
		data17.addColumn('number', '販売シェア率');	
		data17.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_itoshima.length; i++) {
			sum = sum + window.market_rate_itoshima[i][1];
		}
		
		for (var i = 0; i < window.market_rate_itoshima.length; i++) {
			var rate = (window.market_rate_itoshima[i][1] / sum * 100).toFixed(1);
			 data17.addRows([[window.market_rate_itoshima[i][0], window.market_rate_itoshima[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_itoshima[i][0] + '<br><b>' + window.market_rate_itoshima[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '糸島市',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart17 = new google.visualization.PieChart(document.getElementById('piechart_3d_17'));
		chart17.draw(data17, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_18').hide();
	for (var i = 0; i < window.market_rate_shingu.length; i++) {
		if ( window.market_rate_shingu[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		
		$('#piechart_3d_18').show();
		var data18 = new google.visualization.DataTable();
		data18.addColumn('string', 'Seller');
		data18.addColumn('number', '販売シェア率');	
		data18.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_shingu.length; i++) {
			sum = sum + window.market_rate_shingu[i][1];
		}
		
		for (var i = 0; i < window.market_rate_shingu.length; i++) {
			var rate = (window.market_rate_shingu[i][1] / sum * 100).toFixed(1);
			 data18.addRows([[window.market_rate_shingu[i][0], window.market_rate_shingu[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_shingu[i][0] + '<br><b>' + window.market_rate_shingu[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '糟屋郡新宮町',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart18 = new google.visualization.PieChart(document.getElementById('piechart_3d_18'));
		chart18.draw(data18, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_19').hide();
	for (var i = 0; i < window.market_rate_kurume.length; i++) {
		if ( window.market_rate_kurume[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_19').show();
		var data19 = new google.visualization.DataTable();
		data19.addColumn('string', 'Seller');
		data19.addColumn('number', '販売シェア率');	
		data19.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_kurume.length; i++) {
			sum = sum + window.market_rate_kurume[i][1];
		}
		
		for (var i = 0; i < window.market_rate_kurume.length; i++) {
			var rate = (window.market_rate_kurume[i][1] / sum * 100).toFixed(1);
			 data19.addRows([[window.market_rate_kurume[i][0], window.market_rate_kurume[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_kurume[i][0] + '<br><b>' + window.market_rate_kurume[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '久留米市',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],	
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart19 = new google.visualization.PieChart(document.getElementById('piechart_3d_19'));
		chart19.draw(data19, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_20').hide();
	for (var i = 0; i < window.market_rate_kasuya.length; i++) {
		if ( window.market_rate_kasuya[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_20').show();
		var data20 = new google.visualization.DataTable();
		data20.addColumn('string', 'Seller');
		data20.addColumn('number', '販売シェア率');
		data20.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_kasuya.length; i++) {
			sum = sum + window.market_rate_kasuya[i][1];
		}
		
		for (var i = 0; i < window.market_rate_kasuya.length; i++) {
			var rate = (window.market_rate_kasuya[i][1] / sum * 100).toFixed(1);
			 data20.addRows([[window.market_rate_kasuya[i][0], window.market_rate_kasuya[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_kasuya[i][0] + '<br><b>' + window.market_rate_kasuya[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '糟屋郡粕屋町',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart20 = new google.visualization.PieChart(document.getElementById('piechart_3d_20'));
		chart20.draw(data20, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_21').hide();
	for (var i = 0; i < window.market_rate_umimachi.length; i++) {
		if ( window.market_rate_umimachi[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_21').show();
		var data21 = new google.visualization.DataTable();
		data21.addColumn('string', 'Seller');
		data21.addColumn('number', '販売シェア率');
		data21.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_umimachi.length; i++) {
			sum = sum + window.market_rate_umimachi[i][1];
		}
		
		for (var i = 0; i < window.market_rate_umimachi.length; i++) {
			var rate = (window.market_rate_umimachi[i][1] / sum * 100).toFixed(1);
			 data21.addRows([[window.market_rate_umimachi[i][0], window.market_rate_umimachi[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_umimachi[i][0] + '<br><b>' + window.market_rate_umimachi[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '糟屋郡宇美町',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart21 = new google.visualization.PieChart(document.getElementById('piechart_3d_21'));
		chart21.draw(data21, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_22').hide();
	for (var i = 0; i < window.market_rate_dazaifu.length; i++) {
		if ( window.market_rate_dazaifu[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_22').show();
		var data22 = new google.visualization.DataTable();
		data22.addColumn('string', 'Seller');
		data22.addColumn('number', '販売シェア率');	
		data22.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_dazaifu.length; i++) {
			sum = sum + window.market_rate_dazaifu[i][1];
		}
		
		for (var i = 0; i < window.market_rate_dazaifu.length; i++) {
			var rate = (window.market_rate_dazaifu[i][1] / sum * 100).toFixed(1);
			 data22.addRows([[window.market_rate_dazaifu[i][0], window.market_rate_dazaifu[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_dazaifu[i][0] + '<br><b>' + window.market_rate_dazaifu[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '太宰府市',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart22 = new google.visualization.PieChart(document.getElementById('piechart_3d_22'));
		chart22.draw(data22, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_23').hide();
	for (var i = 0; i < window.market_rate_yanagawa.length; i++) {
		if ( window.market_rate_yanagawa[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_23').show();
		var data23 = new google.visualization.DataTable();
		data23.addColumn('string', 'Seller');
		data23.addColumn('number', '販売シェア率');
		data23.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_yanagawa.length; i++) {
			sum = sum + window.market_rate_yanagawa[i][1];
		}
		
		for (var i = 0; i < window.market_rate_yanagawa.length; i++) {
			var rate = (window.market_rate_yanagawa[i][1] / sum * 100).toFixed(1);
			 data23.addRows([[window.market_rate_yanagawa[i][0], window.market_rate_yanagawa[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_yanagawa[i][0] + '<br><b>' + window.market_rate_yanagawa[i][1] + ' (' + rate + '%)</b></div>']]);	
		}

		var options = {
		  title: '柳川市',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],	
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart23 = new google.visualization.PieChart(document.getElementById('piechart_3d_23'));
		chart23.draw(data23, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_24').hide();
	for (var i = 0; i < window.market_rate_chikuzen.length; i++) {
		if ( window.market_rate_chikuzen[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_24').show();
		var data24 = new google.visualization.DataTable();
		data24.addColumn('string', 'Seller');
		data24.addColumn('number', '販売シェア率');	
		data24.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_chikuzen.length; i++) {
			sum = sum + window.market_rate_chikuzen[i][1];
		}
		
		for (var i = 0; i < window.market_rate_chikuzen.length; i++) {
			var rate = (window.market_rate_chikuzen[i][1] / sum * 100).toFixed(1);
			 data24.addRows([[window.market_rate_chikuzen[i][0], window.market_rate_chikuzen[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_chikuzen[i][0] + '<br><b>' + window.market_rate_chikuzen[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '朝倉郡筑前町',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart24 = new google.visualization.PieChart(document.getElementById('piechart_3d_24'));
		chart24.draw(data24, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_25').hide();
	for (var i = 0; i < window.market_rate_kamimine.length; i++) {
		if ( window.market_rate_kamimine[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_25').show();
		var data25 = new google.visualization.DataTable();
		data25.addColumn('string', 'Seller');
		data25.addColumn('number', '販売シェア率');
		data25.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_kamimine.length; i++) {
			sum = sum + window.market_rate_kamimine[i][1];
		}
		
		for (var i = 0; i < window.market_rate_kamimine.length; i++) {
			var rate = (window.market_rate_kamimine[i][1] / sum * 100).toFixed(1);
			 data25.addRows([[window.market_rate_kamimine[i][0], window.market_rate_kamimine[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_kamimine[i][0] + '<br><b>' + window.market_rate_kamimine[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '三養基郡上峰町',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart25 = new google.visualization.PieChart(document.getElementById('piechart_3d_25'));
		chart25.draw(data25, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_26').hide();
	for (var i = 0; i < window.market_rate_tachiarai.length; i++) {
		if ( window.market_rate_tachiarai[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_26').show();
		var data26 = new google.visualization.DataTable();
		data26.addColumn('string', 'Seller');
		data26.addColumn('number', '販売シェア率');	
		data26.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_tachiarai.length; i++) {
			sum = sum + window.market_rate_tachiarai[i][1];
		}
		
		for (var i = 0; i < window.market_rate_tachiarai.length; i++) {
			var rate = (window.market_rate_tachiarai[i][1] / sum * 100).toFixed(1);
			 data26.addRows([[window.market_rate_tachiarai[i][0], window.market_rate_tachiarai[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_tachiarai[i][0] + '<br><b>' + window.market_rate_tachiarai[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '三井郡大刀洗町',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart26 = new google.visualization.PieChart(document.getElementById('piechart_3d_26'));
		chart26.draw(data26, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_27').hide();
	for (var i = 0; i < window.market_rate_ogori.length; i++) {
		if ( window.market_rate_ogori[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_27').show();
		var data27 = new google.visualization.DataTable();
		data27.addColumn('string', 'Seller');
		data27.addColumn('number', '販売シェア率');	
		data27.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_ogori.length; i++) {
			sum = sum + window.market_rate_ogori[i][1];
		}
		
		for (var i = 0; i < window.market_rate_ogori.length; i++) {
			var rate = (window.market_rate_ogori[i][1] / sum * 100).toFixed(1);
			 data27.addRows([[window.market_rate_ogori[i][0], window.market_rate_ogori[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_ogori[i][0] + '<br><b>' + window.market_rate_ogori[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '小郡市',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,

		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart27 = new google.visualization.PieChart(document.getElementById('piechart_3d_27'));
		chart27.draw(data27, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_28').hide();
	for (var i = 0; i < window.market_rate_chikujou.length; i++) {
		if ( window.market_rate_chikujou[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_28').show();
		var data28 = new google.visualization.DataTable();
		data28.addColumn('string', 'Seller');
		data28.addColumn('number', '販売シェア率');	
		data28.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_chikujou.length; i++) {
			sum = sum + window.market_rate_chikujou[i][1];
		}
		
		for (var i = 0; i < window.market_rate_chikujou.length; i++) {
			var rate = (window.market_rate_chikujou[i][1] / sum * 100).toFixed(1);
			 data28.addRows([[window.market_rate_chikujou[i][0], window.market_rate_chikujou[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_chikujou[i][0] + '<br><b>' + window.market_rate_chikujou[i][1] + ' (' + rate + '%)</b></div>']]);	
		}

		var options = {
		  title: '築上郡築上町',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],	
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart28 = new google.visualization.PieChart(document.getElementById('piechart_3d_28'));
		chart28.draw(data28, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_29').hide();
	for (var i = 0; i < window.market_rate_chikushino.length; i++) {
		if ( window.market_rate_chikushino[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_29').show();
		var data29 = new google.visualization.DataTable();
		data29.addColumn('string', 'Seller');
		data29.addColumn('number', '販売シェア率');	
		data29.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_chikushino.length; i++) {
			sum = sum + window.market_rate_chikushino[i][1];
		}
		
		for (var i = 0; i < window.market_rate_chikushino.length; i++) {
			var rate = (window.market_rate_chikushino[i][1] / sum * 100).toFixed(1);
			 data29.addRows([[window.market_rate_chikushino[i][0], window.market_rate_chikushino[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_chikushino[i][0] + '<br><b>' + window.market_rate_chikushino[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '筑紫野市',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart29 = new google.visualization.PieChart(document.getElementById('piechart_3d_29'));
		chart29.draw(data29, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_30').hide();
	for (var i = 0; i < window.market_rate_miyaki.length; i++) {
		if ( window.market_rate_miyaki[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_30').show();
		var data30 = new google.visualization.DataTable();
		data30.addColumn('string', 'Seller');
		data30.addColumn('number', '販売シェア率');
		data30.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_miyaki.length; i++) {
			sum = sum + window.market_rate_miyaki[i][1];
		}
		
		for (var i = 0; i < window.market_rate_miyaki.length; i++) {
			var rate = (window.market_rate_miyaki[i][1] / sum * 100).toFixed(1);
			 data30.addRows([[window.market_rate_miyaki[i][0], window.market_rate_miyaki[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_miyaki[i][0] + '<br><b>' + window.market_rate_miyaki[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '三養基郡みやき町',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],	
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart30 = new google.visualization.PieChart(document.getElementById('piechart_3d_30'));
		chart30.draw(data30, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_31').hide();
	for (var i = 0; i < window.market_rate_tosu.length; i++) {
		if ( window.market_rate_tosu[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_31').show();
		var data31 = new google.visualization.DataTable();
		data31.addColumn('string', 'Seller');
		data31.addColumn('number', '販売シェア率');
		data31.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_tosu.length; i++) {
			sum = sum + window.market_rate_tosu[i][1];
		}
		
		for (var i = 0; i < window.market_rate_tosu.length; i++) {
			var rate = (window.market_rate_tosu[i][1] / sum * 100).toFixed(1);
			 data31.addRows([[window.market_rate_tosu[i][0], window.market_rate_tosu[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_tosu[i][0] + '<br><b>' + window.market_rate_tosu[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '鳥栖市',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],	
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart31 = new google.visualization.PieChart(document.getElementById('piechart_3d_31'));
		chart31.draw(data31, options);
	}
	
	var dont_draw = 1;
	$('#piechart_3d_32').hide();
	for (var i = 0; i < window.market_rate_kiyama.length; i++) {
		if ( window.market_rate_kiyama[i][1] != 0) {
			dont_draw = 0;
			break;
		}
	}
	if (!dont_draw) {
		$('#piechart_3d_32').show();
		var data32 = new google.visualization.DataTable();
		data32.addColumn('string', 'Seller');
		data32.addColumn('number', '販売シェア率');
		data32.addColumn({type: 'string', label: 'Tooltip Chart', role: 'tooltip', 'p': {'html': true}});
		
		var sum = 0;
		for (var i = 0; i < window.market_rate_kiyama.length; i++) {
			sum = sum + window.market_rate_kiyama[i][1];
		}
		
		for (var i = 0; i < window.market_rate_kiyama.length; i++) {
			var rate = (window.market_rate_kiyama[i][1] / sum * 100).toFixed(1);
			 data32.addRows([[window.market_rate_kiyama[i][0], window.market_rate_kiyama[i][1], 
								'<div style="width: 110px; background-color: white; padding: 5px">' + window.market_rate_kiyama[i][0] + '<br><b>' + window.market_rate_kiyama[i][1] + ' (' + rate + '%)</b></div>']]);	
		}
		
		var options = {
		  title: '三養基郡基山町',
		  backgroundColor: '#D5D5D5',
		  titleTextStyle: {fontSize: 18},
		  legend: { textStyle: {fontSize: 13}},
		  is3D: true,
		  colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'],
		  sliceVisibilityThreshold: 0,
		  chartArea:{left: 10, width:'90%'}
		};
		
		var chart32 = new google.visualization.PieChart(document.getElementById('piechart_3d_32'));
		chart32.draw(data32, options);
	}
}