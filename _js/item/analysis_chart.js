$(document).ready(function () {
    $(".btn-aggregate").click(function (e) {
        e.preventDefault();
        
        $('#error').html('');
        $('#chart_div').html('');
        
        google.charts.setOnLoadCallback(drawChart);
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
		if ($('#chart_div').html() != '') {
  			drawChart();
		}
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
            },
        });
        console.log(result);
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
        max_xAxis.setDate(max_xAxis.getDate() + 1);
        var min_xAxis = new Date($("#from").val());
        min_xAxis.setDate(min_xAxis.getDate() - 1);
        
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
        
        // Instantiate and draw our chart, passing in some options.
        if ($("#select_opt").val() <= 3) {
            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        } else {
            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));	
        }
        chart.draw(data, options);
    }
    });