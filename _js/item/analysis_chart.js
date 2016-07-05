$(document).ready(function () {
    $(".btn-aggregate").click(function (e) {
        e.preventDefault();
        
        $('#error').html('');
        $('#chart_div').html('');
        
        google.charts.setOnLoadCallback(drawChart);
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
        
        for (var i = 0; i < result.length; i++) {
            var x_axis = new Date(result[i].x_axis);
            var y_axis = parseInt(result[i].y_axis);            
            
            var date = x_axis.getDate();
            var month = x_axis.getMonth() + 1;
            
            if ($("#select_opt").val() == 4 || $("#select_opt").val() == 5){
                var tooltip = '<div style = "width: 130px; height: 50px; padding-left: 10px; padding-top: 5px;">'
                            + month + '月' + date + '日<br><b>' + y_axis + '万円</b></div>';
            } else {
                var tooltip = '<div style = "width: 130px; height: 50px; padding-left: 10px; padding-top: 5px;">'
                            + month + '月' + date + '日<br><b>' + y_axis + '</b></div>';
            }
            data.addRows([[x_axis, y_axis, tooltip]]);
        }
        // Set chart options
        var max = new Date(result[result.length - 1].x_axis);
        max.setDate(max.getDate() + 1);
        var min = new Date(result[0].x_axis);
        min.setDate(min.getDate() - 1);
        
        var options = {
            tooltip: {
                isHtml: true
            },
            hAxis: {
                format: 'M月d日',
                viewWindow: {
                    max: max,
                    min: min
                }
            },
            pointSize: 10
        };
        
        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
    });