$(function(){

	//▼コンフィグ群▼//
	var file_path = "/master/city.php";
	
	//▼ファンクション群▼//
	function SyncCode(){
		var pref_cd = $('#js_pref_cd').val();
		$('#js_pref_cd_link').val(pref_cd);
		$('#js_pref_cd_add').val(pref_cd);
	}
	function MakeMain(){
		var pref_cd = $('#js_pref_cd').val();
		$('#js_list').children().remove();
		$.ajax({
			type: "POST",
			url: file_path,
			data: "md=make_main&pref_cd="+ pref_cd,
			datatype: "json",
			success: function(data){
				if(data){
					var arr = eval(data);
					var list = $('#js_list');
					$.each(arr, function(){
						var html = ''+
							'<tr class="js_colum">'+
								'<td>'+
								''+ this.city_cd +''+
								'<input type="hidden" class="js_city_cd" name="city_cd[]" value="'+ this.city_cd +'" />'+
								'<input type="hidden" class="js_city_sort" name="city_sort[]" value="'+ this.city_sort +'" />'+
								'</td>'+
								'<td>'+ this.cat_city_name +'</td>'+
								'<td>'+ this.city_name +'</td>'+
								'<td class="edit"><input type="button" class="js_edit" value="編" /></td>'+
								'<td class=""><div class="js_sort" style="cursor: move;">並替</div></td>'+
							'</tr>';
						list.append(''+ html +'');
					});
				}
			}
		});
		
	}
	function PicCity(){
		var pref_cd = $('#js_pref_cd_add').val();
		$.ajax({
			type: "POST",
			url: file_path,
			data: "md=pic_city&pref_cd="+ pref_cd,
			datatype: "json",
			success: function(data){
				if(data){
					var arr = eval(data);
					var select = $('#js_city_cd_add');
					select.children().remove();
					$.each(arr, function(){
						select.append('<option value="'+ this.city_cd +'">'+ this.city_name +'</option>');
					});
				}
			}
		});
	}
	function AddList(){
		var city_cd = $('#js_city_cd_add').val();
		$.ajax({
			type: "POST",
			url: file_path,
			data: "md=add_list&city_cd="+ city_cd,
			datatype: "json",
			success: function(data){
				if(data){
					var arr = eval(data);
					var list = $('#js_list_link');
					list.append('<li class="js_colum_link"><input type="button" class="btn_del js_del_lilnk" value="削" />'+ arr[0].pref_name +' '+ arr[0].city_name +'<input type="hidden" name="link_city_cd[]" value="'+ arr[0].city_cd +'"></li>');
				}
			}
		});
	}
	function DelLink(obj){
		var my_colum = $(obj).closest('.js_colum_link');
		my_colum.remove();
	}
	function GetName(obj){
		var my_colum = $(obj).closest('.js_colum');
		var city_cd = $('.js_city_cd', my_colum).val();
		$.ajax({
			type: "POST",
			url: file_path,
			data: "md=get_name&city_cd="+ city_cd,
			datatype: "data",
			success: function(data){
				if(data){
					var arr = eval(data);
					var city_name = arr[0]['pref_name'] + arr[0]['city_name'];
					var cat_city_cd = arr[0]['cat_city_cd'];
					$('#js_city_name_link').text(city_name)
					$('#js_cat_city_cd').val(cat_city_cd)
				}
			}
		});
	}
	function MakeList(obj){
		var my_colum = $(obj).closest('.js_colum');
		var city_cd = $('.js_city_cd', my_colum).val();
		$('#js_list_link').children().remove();
		$('#js_frame').css("display", "none");
		$.ajax({
			type: "POST",
			url: file_path,
			data: "md=make_list&city_cd="+ city_cd,
			datatype: "json",
			success: function(data){
				if(data){
					var arr = eval(data);
					var list = $('#js_list_link');
					$.each(arr, function(){
						list.append('<li class="js_colum_link"><input type="button" class="btn_del js_del_lilnk" value="削" />'+ this.pref_name +' '+ this.link_city_name +'<input type="hidden" name="link_city_cd[]" value="'+ this.link_city_cd +'"></li>');
					});
				}
				$('#js_city_cd_link').val(city_cd);
				$('#js_frame_link').css("display", "block");
			}
		});
	}
//	function SortList(){
//		var flg = false;
//		$(document).on('mousedown','.js_sort',function(){
//      flg = true;
//      return false;
// 		}).on('mouseup','.js_sort',function(){
//      flg = false;
// 		}).on('mousemove','.js_sort',function(e){
//      if (flg) {
//				var my_colum = $(this).closest('.js_colum');
//        my_colum.css({
//         top: e.pageY,
//         left: e.pageX
//        });
//      }
//  	});
//	}
	
	//▼バインド群▼//
	$(document).on('change','#js_pref_cd',function(){
		SyncCode();
		PicCity();
		MakeMain();
	});
	$(document).on('change','#js_pref_cd_add',function(){
		PicCity();
	});
	$(document).on('click','#js_add_add',function(){
		AddList();
	});
	$(document).on('click','.js_del_lilnk',function(){
		DelLink(this);
	});
	$(document).on('click','.js_edit',function(){
		MakeList(this);
		GetName(this);
	});
	$(document).on('click','#js_return_link',function(){
		$('#js_frame').css("display", "block");
		$('#js_frame_link').css("display", "none");
	});
	
	//▼イニシャル群▼//
	PicCity();
	SyncCode();
	//SortList();
	
});
