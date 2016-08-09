function drawChart(similars) {
	// Get data.
	var item_cd = $('#item_cd').val();
	var hist;
	var similars;
	
	$.ajax({
		url: "/item/?md=get_history_price&item_cd=" + item_cd,
		type: 'GET',
		dataType: "json",
		async: false,
		success: function (data) {
			hist = data;
		}
	});
	
	var item_compare;
	var list_item = $("#list_item").val();
	var formData = {
		item_cd: item_cd,
		list_item: list_item
	};		
	
	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		})
	
	$.ajax({
		url: "/item/?md=get_item_compare",
		type: 'POST',
		data: formData,
		dataType: "json",
		async: false,
		success: function (data) {
			item_compare = data;
		}
	});
	
	//caculate max, min, avg price
	var i;
	var avg_price = 0;
	var sum = 0;
	var count = 0;		
	var max_price = -9999999;
	var min_price = 9999999;
	var max_index = -1;
	var min_index = -1;
	
	for (i = 0; i < similars.length; i++) {
		if (similars[i].status > 1) {
			sum = sum + parseInt(similars[i].hist_price);
			count++;
			if (max_price < parseInt(similars[i].hist_price)) {
				max_price = parseInt(similars[i].hist_price);
				max_index = i;
			}
			if (min_price > parseInt(similars[i].hist_price)) {
				min_price = parseInt(similars[i].hist_price);
				min_index = i
			}
		}
	}
	avg_price = sum / count;
	
	avg_price = parseInt(avg_price);
	max_price = parseInt(max_price);
	min_price = parseInt(min_price);

	if (sum == 0) {
		avg_price = 0;
	}
	if (max_price == -9999999) {
		max_price = 0;	
	}
	if (min_price == 9999999) {
		min_price = 0;	
	}
	
	// create chart
	var data = new google.visualization.DataTable();
	data.addColumn('date', 'Date');
	data.addColumn('number', '価格');		
	data.addColumn({type: 'string', role: 'tooltip', p: {html: true}}, 'Status');
	data.addColumn({'type': 'string', 'role': 'style'});
	
	data.addColumn('number', avg_price + '万円 (平均成約価格)');
	data.addColumn({type: 'string', role: 'tooltip', p: {html: true}}, 'Status1');	
	data.addColumn({'type': 'string', 'role': 'style'});
	
	data.addColumn('number', (similars[max_index] != null) ? max_price +'万円 (' + similars[max_index].item_name + ') ' + similars[max_index].seller : null);
	data.addColumn({type: 'string', role: 'tooltip', p: {html: true}}, 'Status2');
	data.addColumn({'type': 'string', 'role': 'style'});
	
	data.addColumn('number', (similars[min_index] != null) ? min_price +'万円 (' + similars[min_index].item_name + ') ' + similars[min_index].seller : null);
	data.addColumn({type: 'string', role: 'tooltip', p: {html: true}}, 'Status3');
	data.addColumn({'type': 'string', 'role': 'style'});
	
	data.addColumn('number', (item_compare[0] != null)?'' + item_compare[0][item_compare[0].length - 1].hist_price + '万円 (' + item_compare[0][0].item_name + ') ' + item_compare[0][0].seller:null);
	data.addColumn({type: 'string', role: 'tooltip', p: {html: true}}, 'Status');
	data.addColumn({'type': 'string', 'role': 'style'});
	
	data.addColumn('number', (item_compare[1] != null)?'' + item_compare[1][item_compare[1].length - 1].hist_price + '万円 (' + item_compare[1][0].item_name + ') ' + item_compare[1][0].seller:null);
	data.addColumn({type: 'string', role: 'tooltip', p: {html: true}}, 'Status');
	data.addColumn({'type': 'string', 'role': 'style'});
	
	data.addColumn('number', (item_compare[2] != null)?'' + item_compare[2][item_compare[2].length - 1].hist_price + '万円 (' + item_compare[2][0].item_name + ') ' + item_compare[2][0].seller:null);
	data.addColumn({type: 'string', role: 'tooltip', p: {html: true}}, 'Status');
	data.addColumn({'type': 'string', 'role': 'style'});
	
	data.addColumn('number', (item_compare[3] != null)?'' + item_compare[3][item_compare[3].length - 1].hist_price + '万円 (' + item_compare[3][0].item_name + ') ' + item_compare[3][0].seller:null);
	data.addColumn({type: 'string', role: 'tooltip', p: {html: true}}, 'Status');
	data.addColumn({'type': 'string', 'role': 'style'});
	
	data.addColumn('number', (item_compare[4] != null)?'' + item_compare[4][item_compare[4].length - 1].hist_price + '万円 (' + item_compare[4][0].item_name + ') ' + item_compare[4][0].seller:null);
	data.addColumn({type: 'string', role: 'tooltip', p: {html: true}}, 'Status');
	data.addColumn({'type': 'string', 'role': 'style'});
	
	
	//primary item
	var change_price_day = null;
	for (var i = 0; i < hist.length; i++) {
		var datetime = new Date(hist[i].date_regist);
		var hist_price = parseInt(hist[i].hist_price);
		var stat_name = hist[i].stat_name;
		
		
		var datetime1 = new Date(datetime);
		datetime1.setDate(datetime1.getDate() - 1);
		
		var date = datetime.getDate();
		var month = datetime.getMonth() + 1;
		var year = datetime.getFullYear();
		
		var oneDay = 24*60*60*1000;
		var firstDate = new Date(hist[i].date_regist);
		var secondDate = new Date(hist[0].date_regist);
		var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
		
		var date_diff = '---';
		var month_diff = '---';
		var year_diff = '---';
		var change_price_diffDays = '----';
		
		if (change_price_day) {	
			lastday = new Date(hist[change_price_day].date_regist);
			
			date_diff = lastday.getDate();
			month_diff = lastday.getMonth() + 1;	
			year_diff = lastday.getFullYear();
			
			var firstDate = new Date(hist[i].date_regist);
			var secondDate = new Date(hist[change_price_day].date_regist);
			var change_price_diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
		}
		if (stat_name == '価格改定') {
			change_price_day = i;
		}
		
		if (stat_name == '販売開始') {
			var style = 'point {fill-color: #000000;}';
		}
		if (stat_name == '価格改定') {
			var style = 'point {fill-color: #FF0000;}';
		}
		if (stat_name == '商談') {
			var style = 'point {fill-color: #0000FF;}';
		}
		if (stat_name == '再販' && hist[i-1].stat_name != '商談') {
			var style = 'point {fill-color: #1170FF;}}';
		}
		if (stat_name == '再販' && hist[i-1].stat_name == '商談') {
			var style = 'point {fill-color: #1170FF;}, line {color: #A0A0A0;}';
		}
		if (stat_name == '問合せ') {
			var style = 'point {fill-color: #006600;}';
		}
		if (stat_name == '成約') {
			var style = 'point {fill-color: #000000;}';
		}
		data.addRows([[datetime, hist_price,
						'<div style = "width: 250px; height: auto; padding: 15px 20px;">'
						+ '<div style = "font-size: larger;">' + year + '年' + month + '月' + date + '日</div>'
						+ '<div>売出開始日から'+ diffDays +'日</div>'
						+ '<div style = "font-size: large;"><span style="color: blue">'
						+ stat_name + ': </span>' + hist_price + '万円</div>'
						+ '<div>最終価格改定日：' + year_diff + '年' + month_diff + '月' + date_diff + '日('
						+ change_price_diffDays + '日前)</div>'
						+ '</div>', style, 
						null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null]]);	
	}
	
	var datetime = new Date();
	var hist_price = parseInt(hist[hist.length-1].hist_price);
	var stat_name = hist[hist.length-1].stat_name;
	
	var date = datetime.getDate();
	var month = datetime.getMonth() + 1;
	var year = datetime.getFullYear();
	
	var oneDay = 24*60*60*1000;
	var firstDate = new Date();
	var secondDate = new Date(hist[0].date_regist);
	var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
	
	var date_diff = '---';
	var month_diff = '---';
	var year_diff = '---';
	var change_price_diffDays = '----';
	
	if (change_price_day) {	
		lastday = new Date(hist[change_price_day].date_regist);
		
		date_diff = lastday.getDate();
		month_diff = lastday.getMonth() + 1;	
		year_diff = lastday.getFullYear();
		
		var firstDate = new Date();
		var secondDate = new Date(hist[change_price_day].date_regist);
		var change_price_diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
	}
	
	if (stat_name == '販売開始') {
		var style = 'point {fill-color: #000000;}';
	}
	if (stat_name == '価格改定') {
		var style = 'point {fill-color: #FF0000;}';
	}
	if (stat_name == '商談') {
		var style = 'point {fill-color: #0000FF;}';
	}
	if (stat_name == '再販' && hist[hist.length-2].stat_name != '商談') {
		var style = 'point {fill-color: #1170FF;}}';
	}
	if (stat_name == '再販' && hist[hist.length-2].stat_name == '商談') {
		var style = 'point {fill-color: #1170FF;}, line {color: #A0A0A0;}';
	}
	if (stat_name == '問合せ') {
		var style = 'point {fill-color: #006600;}';
	}
	if (stat_name == '成約') {
		var style = 'point {fill-color: #000000;}';
	}
	data.addRows([[datetime, hist_price,
					'<div style = "width: 250px; height: auto; padding: 15px 20px;">'
					+ '<div style = "font-size: larger;">' + year + '年' + month + '月' + date + '日</div>'
					+ '<div>売出開始日から'+ diffDays +'日</div>'
					+ '<div style = "font-size: large;"><span style="color: blue">'
					+ stat_name + ': </span>' + hist_price + '万円</div>'
					+ '<div>最終価格改定日：' + year_diff + '年' + month_diff + '月' + date_diff + '日('
					+ change_price_diffDays + '日前)</div>'
					+ '</div>', style, 
					null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null]]);
	
	
	
	
	var j;
	var list_item_compare = new Array(5);
	//item 1
	var change_price_day = null;
	if (item_compare[0] != null) {
		list_item_compare[0] = item_compare[0][0].item_cd;
		for ( j = 0; j < item_compare[0].length; j++ ) {
			var datetime = new Date(item_compare[0][j].date_regist);
			var hist_price = parseInt(item_compare[0][j].hist_price);
			var stat_name = item_compare[0][j].stat_name;
		
			var date = datetime.getDate();
			var month = datetime.getMonth() + 1;
			var year = datetime.getFullYear();
			
			var oneDay = 24*60*60*1000;
			var firstDate = new Date(item_compare[0][j].date_regist);
			var secondDate = new Date(item_compare[0][0].date_regist);
			var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
			
			var date_diff = '---';
			var month_diff = '---';
			var year_diff = '---';
			var change_price_diffDays = '----';
			
			if (change_price_day) {	
				lastday = new Date(item_compare[0][change_price_day].date_regist);
				
				date_diff = lastday.getDate();
				month_diff = lastday.getMonth() + 1;	
				year_diff = lastday.getFullYear();
				
				var firstDate = new Date(item_compare[0][j].date_regist);
				var secondDate = new Date(item_compare[0][change_price_day].date_regist);
				var change_price_diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
			}
			if (stat_name == '価格改定') {
				change_price_day = j;
			}
		
			if (stat_name == '販売開始') {
				var style = 'point {fill-color: #000000;}';
			}
			if (stat_name == '価格改定') {
				var style = 'point {fill-color: #FF0000;}';
			}
			if (stat_name == '商談') {
				var style = 'point {fill-color: #0000FF;}';
			}
			if (stat_name == '再販' && item_compare[0][j-1].stat_name != '商談') {
				var style = 'point {fill-color: #1170FF;}}';
			}
			if (stat_name == '再販' && item_compare[0][j-1].stat_name == '商談') {
				var style = 'point {fill-color: #1170FF;}, line {color: #A0A0A0;}';
			}
			if (stat_name == '問合せ') {
				var style = 'point {fill-color: #006600;}';
			}
			if (stat_name == '成約') {
				var style = 'point {fill-color: #000000;}';
			}
			data.addRows([[ 
						datetime, null, null, null, null, null, null, null, null, null, null, null, null, hist_price,
						'<div style = "width: 250px; height: auto; padding: 15px 20px;">'
						+ '<div style = "font-size: larger;">' + year + '年' + month + '月' + date + '日</div>'
						+ '<div>売出開始日から'+ diffDays +'日</div>'
						+ '<div style = "font-size: large;"><span style="color: blue">'
						+ stat_name + ': </span>' + hist_price + '万円</div>'
						+ '<div>最終価格改定日：' + year_diff + '年' + month_diff + '月' + date_diff + '日('
						+ change_price_diffDays + '日前)</div>'
						+ '</div>', style, null, null, null, null, null, null, null, null, null, null, null, null]]);	
		}
		
		var datetime = new Date();
		var hist_price = parseInt(item_compare[0][item_compare[0].length - 1].hist_price);
		var stat_name = item_compare[0][item_compare[0].length - 1].stat_name;
	
		var date = datetime.getDate();
		var month = datetime.getMonth() + 1;
		var year = datetime.getFullYear();
		
		var oneDay = 24*60*60*1000;
		var firstDate = new Date();
		var secondDate = new Date(item_compare[0][0].date_regist);
		var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
		
		var date_diff = '---';
		var month_diff = '---';
		var year_diff = '---';
		var change_price_diffDays = '----';
		
		if (change_price_day) {	
			lastday = new Date(item_compare[0][change_price_day].date_regist);
			
			date_diff = lastday.getDate();
			month_diff = lastday.getMonth() + 1;	
			year_diff = lastday.getFullYear();
			
			var firstDate = new Date();
			var secondDate = new Date(item_compare[0][change_price_day].date_regist);
			var change_price_diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
		}
	
		if (stat_name == '販売開始') {
			var style = 'point {fill-color: #000000;}';
		}
		if (stat_name == '価格改定') {
			var style = 'point {fill-color: #FF0000;}';
		}
		if (stat_name == '商談') {
			var style = 'point {fill-color: #0000FF;}';
		}
		if (stat_name == '再販' && hist[item_compare[0].length - 2].stat_name != '商談') {
			var style = 'point {fill-color: #1170FF;}}';
		}
		if (stat_name == '再販' && hist[item_compare[0].length - 2].stat_name == '商談') {
			var style = 'point {fill-color: #1170FF;}, line {color: #A0A0A0;}';
		}
		if (stat_name == '問合せ') {
			var style = 'point {fill-color: #006600;}';
		}
		if (stat_name == '成約') {
			var style = 'point {fill-color: #000000;}';
		}
		data.addRows([[ 
					datetime, null, null, null, null, null, null, null, null, null, null, null, null, hist_price,
					'<div style = "width: 250px; height: auto; padding: 15px 20px;">'
					+ '<div style = "font-size: larger;">' + year + '年' + month + '月' + date + '日</div>'
					+ '<div>売出開始日から'+ diffDays +'日</div>'
					+ '<div style = "font-size: large;"><span style="color: blue">'
					+ stat_name + ': </span>' + hist_price + '万円</div>'
					+ '<div>最終価格改定日：' + year_diff + '年' + month_diff + '月' + date_diff + '日('
					+ change_price_diffDays + '日前)</div>'
					+ '</div>', style, null, null, null, null, null, null, null, null, null, null, null, null]]);
	}
	
	//item 2
	var change_price_day = null;
	if (item_compare[1] != null) {
		list_item_compare[1] = item_compare[1][0].item_cd;
		for ( j = 0; j < item_compare[1].length; j++ ) {
			var datetime = new Date(item_compare[1][j].date_regist);
			var hist_price = parseInt(item_compare[1][j].hist_price);
			var stat_name = item_compare[1][j].stat_name;
		
			var date = datetime.getDate();
			var month = datetime.getMonth() + 1;
			var year = datetime.getFullYear();
			
			var oneDay = 24*60*60*1000;
			var firstDate = new Date(item_compare[1][j].date_regist);
			var secondDate = new Date(item_compare[1][0].date_regist);
			var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
			
			var date_diff = '---';
			var month_diff = '---';
			var year_diff = '---';
			var change_price_diffDays = '----';
			
			if (change_price_day) {	
				lastday = new Date(item_compare[1][change_price_day].date_regist);
				
				date_diff = lastday.getDate();
				month_diff = lastday.getMonth() + 1;	
				year_diff = lastday.getFullYear();
				
				var firstDate = new Date(item_compare[1][j].date_regist);
				var secondDate = new Date(item_compare[1][change_price_day].date_regist);
				var change_price_diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
			}
			if (stat_name == '価格改定') {
				change_price_day = j;
			}
			
			if (stat_name == '販売開始') {
				var style = 'point {fill-color: #000000;}';
			}
			if (stat_name == '価格改定') {
				var style = 'point {fill-color: #FF0000;}';
			}
			if (stat_name == '商談') {
				var style = 'point {fill-color: #0000FF;}';
			}
			if (stat_name == '再販' && item_compare[1][j-1].stat_name != '商談') {
				var style = 'point {fill-color: #1170FF;}}';
			}
			if (stat_name == '再販' && item_compare[1][j-1].stat_name == '商談') {
				var style = 'point {fill-color: #1170FF;}, line {color: #A0A0A0;}';
			}
			if (stat_name == '問合せ') {
				var style = 'point {fill-color: #006600;}';
			}
			if (stat_name == '成約') {
				var style = 'point {fill-color: #000000;}';
			}
			data.addRows([[ 
						datetime, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, hist_price,
						'<div style = "width: 250px; height: auto; padding: 15px 20px;">'
						+ '<div style = "font-size: larger;">' + year + '年' + month + '月' + date + '日</div>'
						+ '<div>売出開始日から'+ diffDays +'日</div>'
						+ '<div style = "font-size: large;"><span style="color: blue">'
						+ stat_name + ': </span>' + hist_price + '万円</div>'
						+ '<div>最終価格改定日：' + year_diff + '年' + month_diff + '月' + date_diff + '日('
						+ change_price_diffDays + '日前)</div>'
						+ '</div>', style, null, null, null, null, null, null, null, null, null]]);	
		}
		
		var datetime = new Date();
		var hist_price = parseInt(item_compare[1][item_compare[1].length - 1].hist_price);
		var stat_name = item_compare[1][item_compare[1].length - 1].stat_name;
	
		var date = datetime.getDate();
		var month = datetime.getMonth() + 1;
		var year = datetime.getFullYear();
		
		var oneDay = 24*60*60*1000;
		var firstDate = new Date();
		var secondDate = new Date(item_compare[1][0].date_regist);
		var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
		
		var date_diff = '---';
		var month_diff = '---';
		var year_diff = '---';
		var change_price_diffDays = '----';
		
		if (change_price_day) {	
			lastday = new Date(item_compare[1][change_price_day].date_regist);
			
			date_diff = lastday.getDate();
			month_diff = lastday.getMonth() + 1;	
			year_diff = lastday.getFullYear();
			
			var firstDate = new Date();
			var secondDate = new Date(item_compare[1][change_price_day].date_regist);
			var change_price_diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
		}
		
		if (stat_name == '販売開始') {
			var style = 'point {fill-color: #000000;}';
		}
		if (stat_name == '価格改定') {
			var style = 'point {fill-color: #FF0000;}';
		}
		if (stat_name == '商談') {
			var style = 'point {fill-color: #0000FF;}';
		}
		if (stat_name == '再販' && item_compare[1][item_compare[1].length - 2].stat_name != '商談') {
			var style = 'point {fill-color: #1170FF;}}';
		}
		if (stat_name == '再販' && item_compare[1][item_compare[1].length - 2].stat_name == '商談') {
			var style = 'point {fill-color: #1170FF;}, line {color: #A0A0A0;}';
		}
		if (stat_name == '問合せ') {
			var style = 'point {fill-color: #006600;}';
		}
		if (stat_name == '成約') {
			var style = 'point {fill-color: #000000;}';
		}
		data.addRows([[ 
					datetime, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, hist_price,
					'<div style = "width: 250px; height: auto; padding: 15px 20px;">'
					+ '<div style = "font-size: larger;">' + year + '年' + month + '月' + date + '日</div>'
					+ '<div>売出開始日から'+ diffDays +'日</div>'
					+ '<div style = "font-size: large;"><span style="color: blue">'
					+ stat_name + ': </span>' + hist_price + '万円</div>'
					+ '<div>最終価格改定日：' + year_diff + '年' + month_diff + '月' + date_diff + '日('
					+ change_price_diffDays + '日前)</div>'
					+ '</div>', style, null, null, null, null, null, null, null, null, null]]);	
	}
	
	//item 3
	var change_price_day = null;
	if (item_compare[2] != null) {
		list_item_compare[2] = item_compare[2][0].item_cd;
		for ( j = 0; j < item_compare[2].length; j++ ) {
			var datetime = new Date(item_compare[2][j].date_regist);
			var hist_price = parseInt(item_compare[2][j].hist_price);
			var stat_name = item_compare[2][j].stat_name;
		
			var date = datetime.getDate();
			var month = datetime.getMonth() + 1;
			var year = datetime.getFullYear();
			
			var oneDay = 24*60*60*1000;
			var firstDate = new Date(item_compare[2][j].date_regist);
			var secondDate = new Date(item_compare[2][0].date_regist);
			var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
			
			var date_diff = '---';
			var month_diff = '---';
			var year_diff = '---';
			var change_price_diffDays = '----';
			
			if (change_price_day) {	
				lastday = new Date(item_compare[2][change_price_day].date_regist);
				
				date_diff = lastday.getDate();
				month_diff = lastday.getMonth() + 1;	
				year_diff = lastday.getFullYear();
				
				var firstDate = new Date(item_compare[2][j].date_regist);
				var secondDate = new Date(item_compare[2][change_price_day].date_regist);
				var change_price_diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
			}
			if (stat_name == '価格改定') {
				change_price_day = j;
			}
		
			if (stat_name == '販売開始') {
				var style = 'point {fill-color: #000000;}';
			}
			if (stat_name == '価格改定') {
				var style = 'point {fill-color: #FF0000;}';
			}
			if (stat_name == '商談') {
				var style = 'point {fill-color: #0000FF;}';
			}
			if (stat_name == '再販' && item_compare[2][j-1].stat_name != '商談') {
				var style = 'point {fill-color: #1170FF;}}';
			}
			if (stat_name == '再販' && item_compare[2][j-1].stat_name == '商談') {
				var style = 'point {fill-color: #1170FF;}, line {color: #A0A0A0;}';
			}
			if (stat_name == '問合せ') {
				var style = 'point {fill-color: #006600;}';
			}
			if (stat_name == '成約') {
				var style = 'point {fill-color: #000000;}';
			}
			data.addRows([[ 
						datetime, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, hist_price,
						'<div style = "width: 250px; height: auto; padding: 15px 20px;">'
						+ '<div style = "font-size: larger;">' + year + '年' + month + '月' + date + '日</div>'
						+ '<div>売出開始日から'+ diffDays +'日</div>'
						+ '<div style = "font-size: large;"><span style="color: blue">'
						+ stat_name + ': </span>' + hist_price + '万円</div>'
						+ '<div>最終価格改定日：' + year_diff + '年' + month_diff + '月' + date_diff + '日('
						+ change_price_diffDays + '日前)</div>'
						+ '</div>', style, null, null, null, null, null, null]]);	
		}
		
		var datetime = new Date();
		var hist_price = parseInt(item_compare[2][item_compare[2].length - 1].hist_price);
		var stat_name = item_compare[2][item_compare[2].length - 1].stat_name;
	
		var date = datetime.getDate();
		var month = datetime.getMonth() + 1;
		var year = datetime.getFullYear();
		
		var oneDay = 24*60*60*1000;
		var firstDate = new Date();
		var secondDate = new Date(item_compare[2][0].date_regist);
		var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
		
		var date_diff = '---';
		var month_diff = '---';
		var year_diff = '---';
		var change_price_diffDays = '----';
		
		if (change_price_day) {	
			lastday = new Date(item_compare[2][change_price_day].date_regist);
			
			date_diff = lastday.getDate();
			month_diff = lastday.getMonth() + 1;	
			year_diff = lastday.getFullYear();
			
			var firstDate = new Date();
			var secondDate = new Date(item_compare[2][change_price_day].date_regist);
			var change_price_diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
		}
	
		if (stat_name == '販売開始') {
			var style = 'point {fill-color: #000000;}';
		}
		if (stat_name == '価格改定') {
			var style = 'point {fill-color: #FF0000;}';
		}
		if (stat_name == '商談') {
			var style = 'point {fill-color: #0000FF;}';
		}
		if (stat_name == '再販' && item_compare[2][item_compare[2].length - 2].stat_name != '商談') {
			var style = 'point {fill-color: #1170FF;}}';
		}
		if (stat_name == '再販' && item_compare[2][item_compare[2].length - 2].stat_name == '商談') {
			var style = 'point {fill-color: #1170FF;}, line {color: #A0A0A0;}';
		}
		if (stat_name == '問合せ') {
			var style = 'point {fill-color: #006600;}';
		}
		if (stat_name == '成約') {
			var style = 'point {fill-color: #000000;}';
		}
		data.addRows([[ 
					datetime, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, hist_price,
					'<div style = "width: 250px; height: auto; padding: 15px 20px;">'
					+ '<div style = "font-size: larger;">' + year + '年' + month + '月' + date + '日</div>'
					+ '<div>売出開始日から'+ diffDays +'日</div>'
					+ '<div style = "font-size: large;"><span style="color: blue">'
					+ stat_name + ': </span>' + hist_price + '万円</div>'
					+ '<div>最終価格改定日：' + year_diff + '年' + month_diff + '月' + date_diff + '日('
					+ change_price_diffDays + '日前)</div>'
					+ '</div>', style, null, null, null, null, null, null]]);
	}
	
	//item 4
	var change_price_day = null;
	if (item_compare[3] != null) {
		list_item_compare[3] = item_compare[3][0].item_cd;
		for ( j = 0; j < item_compare[3].length; j++ ) {
			var datetime = new Date(item_compare[3][j].date_regist);
			var hist_price = parseInt(item_compare[3][j].hist_price);
			var stat_name = item_compare[3][j].stat_name;
		
			var date = datetime.getDate();
			var month = datetime.getMonth() + 1;
			var year = datetime.getFullYear();
			
			var oneDay = 24*60*60*1000;
			var firstDate = new Date(item_compare[3][j].date_regist);
			var secondDate = new Date(item_compare[3][0].date_regist);
			var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
			
			var date_diff = '---';
			var month_diff = '---';
			var year_diff = '---';
			var change_price_diffDays = '----';
			
			if (change_price_day) {	
				lastday = new Date(item_compare[3][change_price_day].date_regist);
				
				date_diff = lastday.getDate();
				month_diff = lastday.getMonth() + 1;	
				year_diff = lastday.getFullYear();
				
				var firstDate = new Date(item_compare[3][j].date_regist);
				var secondDate = new Date(item_compare[3][change_price_day].date_regist);
				var change_price_diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
			}
			if (stat_name == '価格改定') {
				change_price_day = j;
			}
		
			if (stat_name == '販売開始') {
				var style = 'point {fill-color: #000000;}';
			}
			if (stat_name == '価格改定') {
				var style = 'point {fill-color: #FF0000;}';
			}
			if (stat_name == '商談') {
				var style = 'point {fill-color: #0000FF;}';
			}
			if (stat_name == '再販' && item_compare[3][j-1].stat_name != '商談') {
				var style = 'point {fill-color: #1170FF;}}';
			}
			if (stat_name == '再販' && item_compare[3][j-1].stat_name == '商談') {
				var style = 'point {fill-color: #1170FF;}, line {color: #A0A0A0;}';
			}
			if (stat_name == '問合せ') {
				var style = 'point {fill-color: #006600;}';
			}
			if (stat_name == '成約') {
				var style = 'point {fill-color: #000000;}';
			}
			data.addRows([[ 
						datetime, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, hist_price,
						'<div style = "width: 250px; height: auto; padding: 15px 20px;">'
						+ '<div style = "font-size: larger;">' + year + '年' + month + '月' + date + '日</div>'
						+ '<div>売出開始日から'+ diffDays +'日</div>'
						+ '<div style = "font-size: large;"><span style="color: blue">'
						+ stat_name + ': </span>' + hist_price + '万円</div>'
						+ '<div>最終価格改定日：' + year_diff + '年' + month_diff + '月' + date_diff + '日('
						+ change_price_diffDays + '日前)</div>'
						+ '</div>', style, null, null, null]]);	
		}
		
		var datetime = new Date();
		var hist_price = parseInt(item_compare[3][item_compare[3].length - 1].hist_price);
		var stat_name = item_compare[3][item_compare[3].length - 1].stat_name;
	
		var date = datetime.getDate();
		var month = datetime.getMonth() + 1;
		var year = datetime.getFullYear();
		
		var oneDay = 24*60*60*1000;
		var firstDate = new Date();
		var secondDate = new Date(item_compare[3][0].date_regist);
		var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
		
		var date_diff = '---';
		var month_diff = '---';
		var year_diff = '---';
		var change_price_diffDays = '----';
		
		if (change_price_day) {	
			lastday = new Date(item_compare[3][change_price_day].date_regist);
			
			date_diff = lastday.getDate();
			month_diff = lastday.getMonth() + 1;	
			year_diff = lastday.getFullYear();
			
			var firstDate = new Date();
			var secondDate = new Date(item_compare[3][change_price_day].date_regist);
			var change_price_diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
		}
	
		if (stat_name == '販売開始') {
			var style = 'point {fill-color: #000000;}';
		}
		if (stat_name == '価格改定') {
			var style = 'point {fill-color: #FF0000;}';
		}
		if (stat_name == '商談') {
			var style = 'point {fill-color: #0000FF;}';
		}
		if (stat_name == '再販' && item_compare[3][item_compare[3].length - 2].stat_name != '商談') {
			var style = 'point {fill-color: #1170FF;}}';
		}
		if (stat_name == '再販' && item_compare[3][item_compare[3].length - 2].stat_name == '商談') {
			var style = 'point {fill-color: #1170FF;}, line {color: #A0A0A0;}';
		}
		if (stat_name == '問合せ') {
			var style = 'point {fill-color: #006600;}';
		}
		if (stat_name == '成約') {
			var style = 'point {fill-color: #000000;}';
		}
		data.addRows([[ 
					datetime, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, hist_price,
					'<div style = "width: 250px; height: auto; padding: 15px 20px;">'
					+ '<div style = "font-size: larger;">' + year + '年' + month + '月' + date + '日</div>'
					+ '<div>売出開始日から'+ diffDays +'日</div>'
					+ '<div style = "font-size: large;"><span style="color: blue">'
					+ stat_name + ': </span>' + hist_price + '万円</div>'
					+ '<div>最終価格改定日：' + year_diff + '年' + month_diff + '月' + date_diff + '日('
					+ change_price_diffDays + '日前)</div>'
					+ '</div>', style, null, null, null]]);	
	}
	
	//item 5
	var change_price_day = null;
	if (item_compare[4] != null) {
		list_item_compare[4] = item_compare[4][0].item_cd;
		for ( j = 0; j < item_compare[4].length; j++ ) {
			var datetime = new Date(item_compare[4][j].date_regist);
			var hist_price = parseInt(item_compare[4][j].hist_price);
			var stat_name = item_compare[4][j].stat_name;
		
			var date = datetime.getDate();
			var month = datetime.getMonth() + 1;
			var year = datetime.getFullYear();
			
			var oneDay = 24*60*60*1000;
			var firstDate = new Date(item_compare[4][j].date_regist);
			var secondDate = new Date(item_compare[4][0].date_regist);
			var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
			
			var date_diff = '---';
			var month_diff = '---';
			var year_diff = '---';
			var change_price_diffDays = '----';
			
			if (change_price_day) {	
				lastday = new Date(item_compare[4][change_price_day].date_regist);
				
				date_diff = lastday.getDate();
				month_diff = lastday.getMonth() + 1;	
				year_diff = lastday.getFullYear();
				
				var firstDate = new Date(item_compare[4][j].date_regist);
				var secondDate = new Date(item_compare[4][change_price_day].date_regist);
				var change_price_diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
			}
			if (stat_name == '価格改定') {
				change_price_day = j;
			}
		
			if (stat_name == '販売開始') {
				var style = 'point {fill-color: #000000;}';
			}
			if (stat_name == '価格改定') {
				var style = 'point {fill-color: #FF0000;}';
			}
			if (stat_name == '商談') {
				var style = 'point {fill-color: #0000FF;}';
			}
			if (stat_name == '再販' && item_compare[4][j-1].stat_name != '商談') {
				var style = 'point {fill-color: #1170FF;}}';
			}
			if (stat_name == '再販' && item_compare[4][j-1].stat_name == '商談') {
				var style = 'point {fill-color: #1170FF;}, line {color: #A0A0A0;}';
			}
			if (stat_name == '問合せ') {
				var style = 'point {fill-color: #006600;}';
			}
			if (stat_name == '成約') {
				var style = 'point {fill-color: #000000;}';
			}
			data.addRows([[ 
						datetime, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, hist_price,
						'<div style = "width: 250px; height: auto; padding: 15px 20px;">'
						+ '<div style = "font-size: larger;">' + year + '年' + month + '月' + date + '日</div>'
						+ '<div>売出開始日から'+ diffDays +'日</div>'
						+ '<div style = "font-size: large;"><span style="color: blue">'
						+ stat_name + ': </span>' + hist_price + '万円</div>'
						+ '<div>最終価格改定日：' + year_diff + '年' + month_diff + '月' + date_diff + '日('
						+ change_price_diffDays + '日前)</div>'
						+ '</div>', style]]);	
		}
		
		var datetime = new Date();
		var hist_price = parseInt(item_compare[4][item_compare[4].length - 1].hist_price);
		var stat_name = item_compare[4][item_compare[4].length - 1].stat_name;
	
		var date = datetime.getDate();
		var month = datetime.getMonth() + 1;
		var year = datetime.getFullYear();
		
		var oneDay = 24*60*60*1000;
		var firstDate = new Date();
		var secondDate = new Date(item_compare[4][0].date_regist);
		var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
		
		var date_diff = '---';
		var month_diff = '---';
		var year_diff = '---';
		var change_price_diffDays = '----';
		
		if (change_price_day) {	
			lastday = new Date(item_compare[4][change_price_day].date_regist);
			
			date_diff = lastday.getDate();
			month_diff = lastday.getMonth() + 1;	
			year_diff = lastday.getFullYear();
			
			var firstDate = new Date();
			var secondDate = new Date(item_compare[4][change_price_day].date_regist);
			var change_price_diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
		}
	
		if (stat_name == '販売開始') {
			var style = 'point {fill-color: #000000;}';
		}
		if (stat_name == '価格改定') {
			var style = 'point {fill-color: #FF0000;}';
		}
		if (stat_name == '商談') {
			var style = 'point {fill-color: #0000FF;}';
		}
		if (stat_name == '再販' && item_compare[4][item_compare[4].length - 2].stat_name != '商談') {
			var style = 'point {fill-color: #1170FF;}}';
		}
		if (stat_name == '再販' && item_compare[4][item_compare[4].length - 2].stat_name == '商談') {
			var style = 'point {fill-color: #1170FF;}, line {color: #A0A0A0;}';
		}
		if (stat_name == '問合せ') {
			var style = 'point {fill-color: #006600;}';
		}
		if (stat_name == '成約') {
			var style = 'point {fill-color: #000000;}';
		}
		data.addRows([[ 
						datetime, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, hist_price,
						'<div style = "width: 250px; height: auto; padding: 15px 20px;">'
						+ '<div style = "font-size: larger;">' + year + '年' + month + '月' + date + '日</div>'
						+ '<div>売出開始日から'+ diffDays +'日</div>'
						+ '<div style = "font-size: large;"><span style="color: blue">'
						+ stat_name + ': </span>' + hist_price + '万円</div>'
						+ '<div>最終価格改定日：' + year_diff + '年' + month_diff + '月' + date_diff + '日('
						+ change_price_diffDays + '日前)</div>'
						+ '</div>', style]]);	
	}
	
	//max, min, avg price
	var now = new Date();
	var sixMonthsAgo = new Date()
	sixMonthsAgo.setDate(sixMonthsAgo.getDate() - 6*30);
	
	var style1 = 'point {fill-color: transparent;}';
	var style2 = 'point {fill-color: black;}';
	var style3 = 'point {fill-color: black;}';
	
	var tooltip1 = '<div style = "width: auto; height: auto; padding: 10px 10px; font-size: 14px;">'
				  +'<span style="color: blue">平均成約価格:</span> <b>' + avg_price + '万円</b></div>';
	var tooltip2 = '----';
	var tooltip3 = '----';
	
	
	if (similars[max_index] && similars[min_index]) {
		//get info item
		var item_max_min;
		var list_item = '-1,-2,-3,-4,' + similars[max_index].item_cd + ',' + similars[min_index].item_cd;
		var formData = {
			item_cd: item_cd,
			list_item: list_item
		};		
		
		$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
				}
			})
		
		$.ajax({
			url: "/item/?md=get_item_compare",
			type: 'POST',
			data: formData,
			dataType: "json",
			async: false,
			success: function (data) {
				item_max_min = data;
			}
		});
		
		if ( max_index == min_index ) {
			var item_max = 0;
			var item_min = 0;
		} else {
			if (item_max_min[0][0].item_cd = similars[max_index].item_cd) {
				var item_max = 0;
				var item_min = 1;
			} else {
				var item_max = 1;
				var item_min = 0;		
			}
		}
		
		//tooltip2
		var datetime = new Date();
		var hist_price = parseInt(similars[max_index].hist_price);
		var stat_name = '成約';
	
		var date = datetime.getDate();
		var month = datetime.getMonth() + 1;
		var year = datetime.getFullYear();
		
		var oneDay = 24*60*60*1000;
		var firstDate = new Date();
		var secondDate = new Date(similars[max_index].date_regist);
		var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
		
		var lastday = null;
		var date_diff = '---';
		var month_diff = '---';
		var year_diff = '---';
		var change_price_diffDays = '----';	
		
		for (var i = item_max_min[item_max].length - 1; i >= 0; i--) {
			if (item_max_min[item_max][i].stat_name == '価格改定') {
				lastday = new Date(item_max_min[item_max][i].date_regist);
				break;	
			}
		}
		if (lastday) {
			date_diff = lastday.getDate();
			month_diff = lastday.getMonth() + 1;	
			year_diff = lastday.getFullYear();
			
			var firstDate = new Date();
			var secondDate = lastday;
			var change_price_diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
		}
		
			
		var tooltip2 = '<div style = "width: 250px; height: auto; padding: 15px 20px;">'
						+ '<div style = "font-size: larger;">' + year + '年' + month + '月' + date + '日</div>'
						+ '<div>売出開始日から'+ diffDays +'日</div>'
						+ '<div style = "font-size: large;"><span style="color: blue">'
						+ stat_name + ': </span>' + hist_price + '万円</div>'
						+ '<div>最終価格改定日：' + year_diff + '年' + month_diff + '月' + date_diff + '日('
						+ change_price_diffDays + '日前)</div>'
						+ '</div>';
					  
		
		//tooltip 3
		var datetime = new Date();
		var hist_price = parseInt(similars[min_index].hist_price);
		var stat_name = '成約';
	
		var date = datetime.getDate();
		var month = datetime.getMonth() + 1;
		var year = datetime.getFullYear();
		
		var oneDay = 24*60*60*1000;
		var firstDate = new Date();
		var secondDate = new Date(similars[min_index].date_regist);
		var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
		
		var lastday = null;
		var date_diff = '---';
		var month_diff = '---';
		var year_diff = '---';
		var change_price_diffDays = '----';	
		
		for (var i = item_max_min[item_min].length - 1; i >= 0; i--) {
			if (item_max_min[item_min][i].stat_name == '価格改定') {
				lastday = new Date(item_max_min[item_min][i].date_regist);
				break;	
			}
		}
		if (lastday) {
			date_diff = lastday.getDate();
			month_diff = lastday.getMonth() + 1;	
			year_diff = lastday.getFullYear();
			
			var firstDate = new Date();
			var secondDate = lastday;
			var change_price_diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
		}
			
		tooltip3 = '<div style = "width: 250px; height: auto; padding: 15px 20px;">'
						+ '<div style = "font-size: larger;">' + year + '年' + month + '月' + date + '日</div>'
						+ '<div>売出開始日から'+ diffDays +'日</div>'
						+ '<div style = "font-size: large;"><span style="color: blue">'
						+ stat_name + ': </span>' + hist_price + '万円</div>'
						+ '<div>最終価格改定日：' + year_diff + '年' + month_diff + '月' + date_diff + '日('
						+ change_price_diffDays + '日前)</div>'
						+ '</div>';	  
	}
				  
	data.addRows([[sixMonthsAgo, null, null, null, avg_price, tooltip1, style1,  null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null]]);
	data.addRows([[now, null, null, null, avg_price, tooltip1, style1, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null]]);
	data.addRows([[sixMonthsAgo, null, null, null, null, null, null, max_price, tooltip2, style2, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null]]);
	data.addRows([[now, null, null, null, null, null, null, max_price, tooltip2, style2, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null]]);
	data.addRows([[sixMonthsAgo, null, null, null, null, null, null, null, null, null, min_price, tooltip3, style3, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null]]);
	data.addRows([[now, null, null, null, null, null, null, null, null, null, min_price, tooltip3, style3, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null]]);
	
	
	// Set chart options
	//var xAxis_max_0 = new Date(hist[hist.length - 1].date_regist);
	var xAxis_max_0 = new Date();
	xAxis_max_0.setDate(xAxis_max_0.getDate() + 5);
	
	if (item_compare[0] != null) {
		var xAxis_max_1 = new Date(item_compare[0].reduce(function(max, obj) {
										return max >= obj.date_regist ? max : obj.date_regist;
									}, -Infinity));
	}
	if (item_compare[1] != null) {
		var xAxis_max_2 = new Date(item_compare[1].reduce(function(max, obj) {
										return max >= obj.date_regist ? max : obj.date_regist;
									}, -Infinity));
	}
	if (item_compare[2] != null) {
		var xAxis_max_3 = new Date(item_compare[2].reduce(function(max, obj) {
										return max >= obj.date_regist ? max : obj.date_regist;
									}, -Infinity));
	}
	if (item_compare[3] != null) {
		var xAxis_max_4 = new Date(item_compare[3].reduce(function(max, obj) {
										return max >= obj.date_regist ? max : obj.date_regist;
									}, -Infinity));
	}
	if (item_compare[4] != null) {
		var xAxis_max_5 = new Date(item_compare[4].reduce(function(max, obj) {
										return max >= obj.date_regist ? max : obj.date_regist;
									}, -Infinity));
	}
	
	
	var xAxis_min_0 = new Date(hist[0].date_regist);
	
	if (item_compare[0] != null) {
		var xAxis_min_1 = new Date(item_compare[0].reduce(function(min, obj) {
										return min <= obj.date_regist ? min : obj.date_regist;
									}, Infinity));
	}
	if (item_compare[1] != null) {
		var xAxis_min_2 = new Date(item_compare[1].reduce(function(min, obj) {
										return min <= obj.date_regist ? min : obj.date_regist;
									}, Infinity));
	}
	if (item_compare[2] != null) {
		var xAxis_min_3 = new Date(item_compare[2].reduce(function(min, obj) {
										return min <= obj.date_regist ? min : obj.date_regist;
									}, Infinity));
	}
	if (item_compare[3] != null) {
		var xAxis_min_4 = new Date(item_compare[3].reduce(function(min, obj) {
										return min <= obj.date_regist ? min : obj.date_regist;
									}, Infinity));
	}
	if (item_compare[4] != null) {
		var xAxis_min_5 = new Date(item_compare[4].reduce(function(min, obj) {
										return min <= obj.date_regist ? min : obj.date_regist;
									}, Infinity));
	}
	
	var yAxis_max_0 = parseInt(hist.reduce(function(max, obj) {
										return max >= obj.hist_price ? max : obj.hist_price;
									}, -Infinity)) + 200;
	if (item_compare[0] != null) {
		var yAxis_max_1 = parseInt(item_compare[0].reduce(function(max, obj) {
										return max >= obj.hist_price ? max : obj.hist_price;
									}, -Infinity)) + 200;
	}
	if (item_compare[1] != null) {
		var yAxis_max_2 = parseInt(item_compare[1].reduce(function(max, obj) {
										return max >= obj.hist_price ? max : obj.hist_price;
									}, -Infinity)) + 200;
	}
	if (item_compare[2] != null) {
		var yAxis_max_3 = parseInt(item_compare[2].reduce(function(max, obj) {
										return max >= obj.hist_price ? max : obj.hist_price;
									}, -Infinity)) + 200;
	}
	if (item_compare[3] != null) {
		var yAxis_max_4 = parseInt(item_compare[3].reduce(function(max, obj) {
										return max >= obj.hist_price ? max : obj.hist_price;
									}, -Infinity)) + 200;
	}
	if (item_compare[4] != null) {
		var yAxis_max_5 = parseInt(item_compare[4].reduce(function(max, obj) {
										return max >= obj.hist_price ? max : obj.hist_price;
									}, -Infinity)) + 200;
	}
	
	var yAxis_min_0 = parseInt(hist.reduce(function(min, obj) {
										return min <= obj.hist_price ? min : obj.hist_price;
									}, Infinity)) - 200;
	if (item_compare[0] != null) {
		var yAxis_min_1 = parseInt(item_compare[0].reduce(function(min, obj) {
										return min <= obj.hist_price ? min : obj.hist_price;
									}, Infinity)) - 200;
	}
	if (item_compare[1] != null) {
		var yAxis_min_2 = parseInt(item_compare[1].reduce(function(min, obj) {
										return min <= obj.hist_price ? min : obj.hist_price;
									}, Infinity)) - 200;
	}
	if (item_compare[2] != null) {
		var yAxis_min_3 = parseInt(item_compare[2].reduce(function(min, obj) {
										return min <= obj.hist_price ? min : obj.hist_price;
									}, Infinity)) - 200;
	}
	if (item_compare[3] != null) {
		var yAxis_min_4 = parseInt(item_compare[3].reduce(function(min, obj) {
										return min <= obj.hist_price ? min : obj.hist_price;
									}, Infinity)) - 200;
	}
	if (item_compare[4] != null) {
		var yAxis_min_5 = parseInt(item_compare[4].reduce(function(min, obj) {
										return min <= obj.hist_price ? min : obj.hist_price;
									}, Infinity)) - 200;
	}
	
	var xAxis_min = xAxis_min_0;
	if (xAxis_min_1) {
		xAxis_min = (xAxis_min < xAxis_min_1) ? xAxis_min : xAxis_min_1;
	}
	if (xAxis_min_2) {
		xAxis_min = (xAxis_min < xAxis_min_2) ? xAxis_min : xAxis_min_2;
	}
	if (xAxis_min_3) {
		xAxis_min = (xAxis_min < xAxis_min_3) ? xAxis_min : xAxis_min_3;
	}
	if (xAxis_min_4) {
		xAxis_min = (xAxis_min < xAxis_min_4) ? xAxis_min : xAxis_min_4;
	}
	if (xAxis_min_5) {
		xAxis_min = (xAxis_min < xAxis_min_5) ? xAxis_min : xAxis_min_5;
	}
	
	var xAxis_max = xAxis_max_0;
	if (xAxis_max_1) {
		xAxis_max = (xAxis_max > xAxis_max_1) ? xAxis_max : xAxis_max_1;
	}
	if (xAxis_max_2) {
		xAxis_max = (xAxis_max > xAxis_max_2) ? xAxis_max : xAxis_max_2;
	}
	if (xAxis_max_3) {
		xAxis_max = (xAxis_max > xAxis_max_3) ? xAxis_max : xAxis_max_3;
	}
	if (xAxis_max_4) {
		xAxis_max = (xAxis_max > xAxis_max_4) ? xAxis_max : xAxis_max_4;
	}
	if (xAxis_max_5) {
		xAxis_max = (xAxis_max > xAxis_max_5) ? xAxis_max : xAxis_max_5;
	}
		
	var yAxis_max = yAxis_max_0;
	if (yAxis_min_1) {
		yAxis_min = (yAxis_min < yAxis_min_1) ? yAxis_min : yAxis_min_1;
	}
	if (yAxis_min_2) {
		yAxis_min = (yAxis_min < yAxis_min_2) ? yAxis_min : yAxis_min_2;
	}
	if (yAxis_min_3) {
		yAxis_min = (yAxis_min < yAxis_min_3) ? yAxis_min : yAxis_min_3;
	}
	if (yAxis_min_4) {
		yAxis_min = (yAxis_min < yAxis_min_4) ? yAxis_min : yAxis_min_4;
	}
	if (yAxis_min_5) {
		yAxis_min = (yAxis_min < yAxis_min_5) ? yAxis_min : yAxis_min_5;
	}
			
	var yAxis_min = yAxis_min_0;
	if (yAxis_max_1) {
		yAxis_max = (yAxis_max > yAxis_max_1) ? yAxis_max : yAxis_max_1;
	}
	if (yAxis_max_2) {
		yAxis_max = (yAxis_max > yAxis_max_2) ? yAxis_max : yAxis_max_2;
	}
	if (yAxis_max_3) {
		yAxis_max = (yAxis_max > yAxis_max_3) ? yAxis_max : yAxis_max_3;
	}
	if (yAxis_max_4) {
		yAxis_max = (yAxis_max > yAxis_max_4) ? yAxis_max : yAxis_max_4;
	}
	if (yAxis_max_5) {
		yAxis_max = (yAxis_max > yAxis_max_5) ? yAxis_max : yAxis_max_5;
	}
	
	if (similars != null) {
		var yAxis_max_2 = max_price + 500;
		var yAxis_min_2 = min_price - 200;

		yAxis_max = (yAxis_max > yAxis_max_2) ? yAxis_max : yAxis_max_2;
		yAxis_min = (yAxis_min < yAxis_min_2) ? yAxis_min : yAxis_min_2;
	}
	
	$offset = (xAxis_max - xAxis_min) / 86400 / 1000 / 18;
	$offset = ($offset < 5) ? 5 : $offset;
	xAxis_max.setDate(xAxis_max.getDate() + $offset);
	
	var options = {
		annotationsWidth: 5,
		annotations: {
			allowHtml: true,
			boxStyle: {
				width: 100,
			},
			textStyle: {
				fontSize: 13,
				bold: true,
			},
			style: 'point',
		},
		legend : {
			textStyle: {
				color: [['red', 'blue']]
			}
		},
		series : {      
			0: { tooltip : true},
			1: { tooltip : false, pointsVisible: false,},
			2: { tooltip : true, pointsVisible: false},
			3: { tooltip : true, pointsVisible: false},
		},
		explorer: { 
			actions: ['dragToZoom', 'rightClickToReset'],
			keepInBounds: true,
			zoomDelta: 1,
			maxZoomIn: 0.1,
			maxZoomOut: 1,
		},
		height:500,
		chartArea: {width: '60%', left: '5%'},
		colors: ['blue', '#DFBADD', '#BE1D2C', '#283890', 'Orange', 'Gold', 'Cyan', 'Chartreuse', 'DeepPink'],
		interpolateNulls: true,
		tooltip: {
			isHtml: true
		},
		hAxis: {
			slantedText: true,
			format: 'M月d日',
			baseline: new Date(),
			baselineColor: 'red',
			viewWindow: {
			   max: xAxis_max,
			   min: xAxis_min
			},
			gridlines: {
				count: 20,	
			}
		},
		vAxis: {
			baseline: yAxis_min,
			gridlines: {
				count: 5,	
			},
			viewWindow: {
				max: yAxis_max,
				min: yAxis_min
			},
		},
		pointSize: 5,
	};
	
	// Instantiate and draw our chart, passing in some options.
	var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
	
	google.visualization.events.addListener(chart, 'ready', eventChangeChartLegends);
	
	chart.draw(data, options);
	
	
	if (max_index >= 0 && min_index >= 0) {
		result = {
			chart: chart,
			list_item_compare: list_item_compare,
			max_index: similars[max_index].item_cd,
			min_index: similars[min_index].item_cd,
		};
	} else {
		result = {
			chart: chart,
			list_item_compare: list_item_compare,
			max_index: null,
			min_index: null,
		};
	}
	return result;
}