$(document).ready(function () {
    //auto draw chart
    google.charts.setOnLoadCallback(drawChart);
    
    function drawChart() {
        // Get data.
        var item_cd = $('#item_cd').val();
        var hist;
        
        $.ajax({
            url: "/item/?md=get_history_price&item_cd=" + item_cd,
            type: 'GET',
            dataType: "json",
            async: false,
            success: function (data) {
                hist = data;
            }
        });
        console.log(hist);
        
        // create chart
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Date');
        data.addColumn('number', '価格');
        data.addColumn({type: 'string', role: 'tooltip', p: {html: true}}, 'Status');
        for (var i = 0; i < hist.length; i++) {
            var datetime = new Date(hist[i].date_regist);
            var hist_price = parseInt(hist[i].hist_price);
            var stat_name = hist[i].stat_name;
            
            var date = datetime.getDate();
            var month = datetime.getMonth() + 1;
            
            data.addRows([[datetime, hist_price, 
                '<div style = "width: 130px; height: 50px; padding-left: 10px; padding-top: 5px;">'
                            + month + '月' + date + '日<br><span style="color: blue">'
                            + stat_name + ': </span><b>' + hist_price + '万円</b></div>']]);
        }
        // Set chart options
        var max = new Date(hist[hist.length - 1].date_regist);
        max.setDate(max.getDate() + 1);
        var min = new Date(hist[0].date_regist);
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