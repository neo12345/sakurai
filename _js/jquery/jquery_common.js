//独自メソッド作成
jQuery.fn.extend({
	//チェックボックスにチェックがあればvalueを返す
  checked: function() {
		if(this.attr('checked')){
		//if(this.is(':checked')){
			return this.val();
		}else{
			return "";
		}   
  },
	//デシリアライズ
  deserialize: function(arr) {
		var obj_form = this;
		$.each(arr,function(key,value){
			$('input[name="'+ key +'"]:text',obj_form).val(value);
			$('input[name="'+ key +'"]:password',obj_form).val(value);
			$('select[name="'+ key +'"]',obj_form).val(value);
			$('textarea[name="'+ key +'"]',obj_form).val(value);
			if(value){
				$('input[name="'+ key +'"]:checkbox',obj_form).attr('checked','checked');
			}else{
				$('input[name="'+ key +'"]:checkbox',obj_form).removeAttr('checked');
			}
		});
  }	//カンマつなぎで追記…
});

//必須項目のチェック
function CheckInput(){
	var required = $('.js_required');
	var length = required.length;
	for (i = 0; i < length; i++) {
		var val = required.eq(i).val();
		if(val == undefined || val.length == 0){
			return false;
		}
	}
	return true;
}
// NumberFormat 数字をカンマ区切りにする
function NumberFormat(str) {
	var num = new String(str).replace(/,/g, "");
	while(num != (num = num.replace(/^(-?\d+)(\d{3})/, "$1,$2")));
	return num;
}
// カンマを除去してつなげる
function RemoveComma(mun){
	return mun.split(",").join("");
}
// 数字のみ入力可
function NumberOnly() {
	
}
// 指定form内の要素からパラメータを抽出
function MakeParam(form){
	var param = {};
	$(form.serializeArray()).each(function(i, v) {
		param[v.name] = v.value;
	});
	return param;
}
// 指定form内の要素からパラメータを抽出しjson文字データを作成
function MakeJson(form){
	var param = MakeParam(form);
	//checkboxにチェックがない場合の対策(↓6行)
	var obj_chkbox = $('input:checkbox', form);
	obj_chkbox.each(function(i, v) {
		if(!param[v.name]){
			param[v.name] = "";
		}
	});
	var json = $.toJSON(param);
	return json;
}
function ConvColorNum(clr){
	if (clr.match(/^#(\w{2})(\w{2})(\w{2})$/)) {
		return clr;
	} else if (clr.match(/^rgb\(\s*(\d+),\s*(\d+),\s*(\d+)\)$/)) {
		var m = clr.match(/^rgb\(\s*(\d+),\s*(\d+),\s*(\d+)\)$/);
		var r = parseInt(m[1],16);
		var g = parseInt(m[2],16);
		var b = parseInt(m[3],16);
		return '#'+pad(r)+pad(g)+pad(b);
	} else if (clr.match(/^rgba\(\s*(\d+),\s*(\d+),\s*(\d+),\s*(\d+)\)$/)) {
		var m = clr.match(/^rgba\(\s*(\d+),\s*(\d+),\s*(\d+),\s*(\d+)\)$/);
		var r = parseInt(m[1],16);
		var g = parseInt(m[2],16);
		var b = parseInt(m[3],16);
		var a = parseInt(m[4],16);
		return '#'+pad(r)+pad(g)+pad(b);
	} else {
		return '';
	}
	function pad(d){
		return ('00'+d.toString(16)).slice(-2);
	}
}
// 全てのチェックボックスにチェック
function CheckAll(name){
	var test = $('input[name^="'+ name +'"]:checkbox');
	test.each(function(){
		var name_str = $(this).attr("name");
		name_str = name_str.replace(/\[.*\]/g, "");
		if(name_str == name){
			$(this).attr({ checked: 'checked' });
		}
	});
}
//親formをサブミット
function SubmitParent(obj){
	var form = $(obj).closest("form");
	form.trigger("submit");
}
//今日の日付取得
function GetDate(){
	var weeks = new Array('日', '月', '火', '水', '木', '金', '土');
	var d = new Date();
	// 年月日・曜日・時分秒の取得
	var month  = d.getMonth() + 1;
	var day    = d.getDate();
	var week   = weeks[ d.getDay() ];
	var hour   = d.getHours();
	var minute = d.getMinutes();
	var second = d.getSeconds();
	// 1桁を2桁に変換する
	if (month < 10) {month = "0" + month;}
	if (day < 10) {day = "0" + day;}
	if (hour < 10) {hour = "0" + hour;}
	if (minute < 10) {minute = "0" + minute;}
	if (second < 10) {second = "0" + second;}
	// 整形して返却
	//return d.getFullYear()  + "/" + month + "/" + day + "（" + week + "） " + hour + ":" + minute + ":" + second;
	return d.getFullYear()  + "/" + month + "/" + day;
}
//指定桁数に0で埋める
function convertNum(num, figures) {
	var str = String(num);
	while (str.length < figures) {
		str = "0"+str;
	}
	return str;
}
//全てのページの初期設定
$(function(){
	//datepickerのクラスを指定
	$('.js_datepicker').datepicker().css("width", "70px");
	//入力禁止（datepickerで使用）
	$(document).on("keydown", '.js_datepicker', function(ev){
		//alert(ev.which);
		return false;
	});
	//ページ内のdisabledを解除（値をPOSTする際に使用）
	$(document).on("click", '.js_undisabled', function(){
	 $('input, select').attr('disabled',false);
	});
	//親formをサブミット
	$(document).on("click", '.js_submit_bt', function(){
		var form = $(this).closest("form");
		form.trigger("submit");
	});
	// enterによるsubmitを防止
	$(document).on("keypress", '.js_unsubmit', function(ev){
		if ((ev.which && ev.which === 13) || (ev.keyCode && ev.keyCode === 13)) {
			if($(ev.target)[0].nodeName == "TEXTAREA"){
				return true;
			}else{
				return false;
			}
		} else {
			return true;
		}
	});
	// テーブルソート(jQeryUI)のid指定と設定
	var obj = $('.js_sortable');
	var handle = '.js_sort';
	var file_path = $('#js_file_path').val();
	var fixHelper = function(e, ui) {
		ui.children().each(function() {
			$(this).width($(this).width());
		});
		return ui;
	};
	obj.sortable({
		cursor: "move",
		opacity: 0.7,
		handle: handle,
		helper: fixHelper, //ドラック中にセルの幅を保持させる
		//revert: true,
		start: function(event, ui){
			ui.item.css("background", "#eeeeee");
		},
		stop: function(event, ui){
			var form = ui.item.closest('.js_sort_form');
			var pram = form.serialize();
			$.ajax({
				type: "POST",
				url: file_path,
				data: "md=sort&"+ pram,
				success: function(data){
					if(data){
						ui.item.css("background", "");
					}
				}
			});
		}
	});
	obj.disableSelection();
});
