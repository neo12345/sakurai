$(function(){

	//▼コンフィグ群▼//
	var file_path = "/item/regist.php";
	var timer;
	
	//▼ファンクション群▼//
	function MakeThumbnail(obj, my_flame){
		var files = obj.files;
		var lng = files.length;
//for (i = 0; i < lng; i++) {
		var fileReader = new FileReader();
		var width = $( '.js_img', my_flame ).css("width");
		var height = $( '.js_img', my_flame ).css("height");
		var back = $( '.js_box', my_flame ).css("background-image");
		fileReader.readAsDataURL( files[0] );
		fileReader.onloadstart = function(){
			$( '.js_img', my_flame ).html("");
			$( '.js_box', my_flame ).css({
				backgroundImage: "url(../_img/common/icon_loading.gif)"
			});
//			for (i = 1; i < lng; i++) {
//				MakeFlame(my_flame);
//			}
		}
		fileReader.onload = function( event ) {
			var loadedImageUri = event.target.result;
			$( '.js_img', my_flame ).html( '<img src="' + loadedImageUri + '">' );
			$( '.js_img', my_flame ).imgLiquid();
			$( '.js_img img', my_flame ).css({
				width: width,
				height: height
			});
			var title = files[0].name.replace(/\.[^\.]+$/,"");
			$('.js_title', my_flame ).val( title );
			$('.js_uri', my_flame ).val( loadedImageUri );
			$('.js_type', my_flame ).val( files[0].type );
			$('.js_exist', my_flame).val("");
			$('.js_num', my_flame).val("");
		}
		fileReader.onloadend = function(){
			$( '.js_box', my_flame ).css({
				backgroundImage: back
			});
			$('.js_delete_flame', my_flame).addClass("del_on");
			$('.js_delete_contents', my_flame).addClass("del_on");
		}
		var parent_flame = my_flame.closest('.js_ul');
		var last_flame = $('.js_flame:last', parent_flame);
		if(my_flame.get(0) == last_flame.get(0)){
			MakeFlame(my_flame);
		}	
//}
	}
	function UpImage(){
		var uri = $( '.js_uri' ).val();
		var type = $( '.js_type' ).val();
		$.ajax({
			type: "POST",
			url: file_path,
			data: {type : type, data: uri},
			success: function(data){
				if(data){
					alert(data);
				}
			}
		});		
	}
	function DelContents(obj){
		var my_flame = $(obj).closest('.js_flame');
		$('.js_img', my_flame).html("");
		$('.js_img', my_flame).css("background-image", "none");
		$('.js_title', my_flame).val("");
		$('.js_uri', my_flame).val("");
		$('.js_type', my_flame).val("");
		$('.js_delete_contents', my_flame).removeClass("del_on");
		$('.js_exist', my_flame).val("");
	}
	function DelFlame(obj){
		var my_flame = $(obj).closest('.js_flame');
		var uri = $('.js_uri', my_flame).val();
		var num = $('.js_num', my_flame).val();
		if(uri || num){
			my_flame.remove();
		}
	}
	function MakeFlame(obj){
		var parent_flame = obj.closest('.js_ul');
		var last_flame = $('.js_flame:last', parent_flame);
		var html = '<li class="js_flame">'+ last_flame.html() +'</li>' 
		//parent_flame.append(html);
		obj.after(html);
	}
	function MakeCity(){
		var pref_cd = $('#js_pref_cd').val();
		var select = $('#js_city_cd');
		select.children().remove();
		$.ajax({
			type: "POST",
			url: file_path,
			data: "md=make_city&pref_cd="+ pref_cd,
			datatype: "json",
			success: function(data){
				if(data){
					var arr = eval(data);
					$.each(arr, function(){
						select.append('<option value="'+ this.city_cd +'">'+ this.city_name +'</option>');
					});
					NarrowSearchSchool();
				}
			}
		});		
	}
	function NarrowSearchSchool(){
		var city_cd = $('#js_city_cd').val();
		var select_pri = $('#js_school_pri_cd');
		var select_jun = $('#js_school_jun_cd');
		var select_cathigh = $('#js_cat_schigh_cd');
		select_pri.children().remove();
		select_jun.children().remove();
		$.ajax({
			type: "POST",
			url: file_path,
			data: "md=narrow_search_school&city_cd="+ city_cd,
			datatype: "json",
			success: function(data){
				if(data){
					var arr = eval(data);
					$.each(arr[0], function(){
						select_pri.append('<option value="'+ this.school_pri_cd +'">'+ this.school_pri_name +'</option>');
					});
					$.each(arr[1], function(){
						select_jun.append('<option value="'+ this.school_jun_cd +'">'+ this.school_jun_name +'</option>');
					});
					select_cathigh.val(arr[2]);
				}
			}
		});		
	}
	function NarrowSearchSchoolHigh(){
		var school_jun_cd = $('#js_school_jun_cd').val();
		$.ajax({
			type: "POST",
			url: file_path,
			data: "md=narrow_search_school_high&school_jun_cd="+ school_jun_cd,
			datatype: "text",
			success: function(data){
				if(data){
					$('#js_cat_schigh_cd').val(data);
				}
			}
		});		
	}
	function MakeStop(obj, pubtrans_cd){
		var my_list = $(obj).closest('.js_list'); 
		var select = $('.js_stop', my_list);
		select.children().remove();
		$.ajax({
			type: "POST",
			url: file_path,
			data: "md=make_stop&pubtrans_cd="+ pubtrans_cd,
			datatype: "json",
			success: function(data){
				if(data){
					var arr = eval(data);
					$.each(arr, function(){
						select.append('<option value="'+ this.stop_cd +'">'+ this.stop_name +'</option>');
					});
				}
			}
		});		
	}
	function SearchWordStop(obj){
		var my_colum = $(obj).closest('.js_list');
		var serach_word = $('.js_search_word_stop', my_colum).val();
		var pubtrans_cd = $('.js_pubtrans', my_colum).val();
		var select = $('.js_stop', my_colum);
		select.children().remove();
		clearTimeout(timer);
		timer = setTimeout(function(){
			$.ajax({
				type: "POST",
				url: file_path,
				data: "md=make_stop&pubtrans_cd="+ pubtrans_cd +"&serach_word="+ serach_word,
				datatype: "json",
				success: function(data){
					if(data){
						var arr = eval(data);
						$.each(arr, function(){
							select.append('<option value="'+ this.stop_cd +'">'+ this.stop_name +'</option>');
						});
					}
				}
			});		
		}, 1000);
	}
	function ClearWordStop(obj){
		var my_colum = $(obj).closest('.js_list');
		$('.js_search_word_stop', my_colum).val("");
	}
	function SearchWordPri(){
		var serach_word = $('#js_search_word_pri').val();
		var city_cd = $('#js_city_cd').val();
		var select = $('#js_school_pri_cd');
		select.children().remove();
		clearTimeout(timer);
		timer = setTimeout(function(){
			$.ajax({
				type: "POST",
				url: file_path,
				data: "md=make_school_pri&city_cd="+ city_cd +"&serach_word="+ serach_word,
				datatype: "json",
				success: function(data){
					if(data){
						var arr = eval(data);
						$.each(arr, function(){
							select.append('<option value="'+ this.school_pri_cd +'">'+ this.school_pri_name +'</option>');
						});
					}
				}
			});		
		}, 1000);
	}
	function SearchWordJun(){
		var serach_word = $('#js_search_word_jun').val();
		var city_cd = $('#js_city_cd').val();
		var select = $('#js_school_jun_cd');
		select.children().remove();
		clearTimeout(timer);
		timer = setTimeout(function(){
			$.ajax({
				type: "POST",
				url: file_path,
				data: "md=make_school_jun&city_cd="+ city_cd +"&serach_word="+ serach_word,
				datatype: "json",
				success: function(data){
					if(data){
						var arr = eval(data);
						$.each(arr, function(){
							select.append('<option value="'+ this.school_jun_cd +'">'+ this.school_jun_name +'</option>');
						});
					}
				}
			});		
		}, 1000);
	}
	function AddList(obj){
		var my_colum = $(obj).closest('.js_colum');
		var html = '<li class="js_list">'+ $('.js_list:first', my_colum).html() +'</li>' 
		$('.js_flame_stop', my_colum).append(html);
	}
	function AddListTheta(obj){
		var my_colum = $(obj).closest('.js_colum');
		var html = '<li class="js_flame mb15">'+ $('.js_flame:first', my_colum).html() +'</li>' 
		$('.js_flame_theta', my_colum).append(html);
	}
	function DelList(obj){
		var my_list = $(obj).closest('.js_list'); 
		my_list.remove();
	}
	function DelListTheta(obj){
		var my_frame = $(obj).closest('.js_flame'); 
		my_frame.remove();
	}
	function AdjustStyle(){
		$('.js_box').css("position", "relative");
		$('.js_input').css("display", "none");
		$('.js_img').css({
			width: "100%",
			height: "100%",
			position: "absolute"
		});
		$('.js_img img').css({
			width: "100%",
			height: "100%"
		});
		$('.js_drop').css({
			width: "100%",
			height: "100%",
			position: "absolute"
		});
	}
	function ShowColum(){
		var cat_item_cd = $('#js_cat_item_cd').val();
		if(cat_item_cd == "1"){
			$('.js_colum_apart').css("display", "none");
			$('.js_colum_house').css("display", "");
		}else if(cat_item_cd == '2'){
			$('.js_colum_house').css("display", "none");
			$('.js_colum_apart').css("display", "");
		}
	}
	function CalTime(obj){
		var my_colum = $(obj).closest('.js_colum');
		var dist = $('.js_dist',  my_colum).val();
		var obj_min = $('.js_min', my_colum);
		obj_min.val("");
		clearTimeout(timer);
		timer = setTimeout(function(){
			var min = Math.ceil(dist / 80);
			obj_min.val(min);	
		}, 1000);
	}
	function SwitchSoldDate(){
		if($('#js_flg_soldout').is(':checked')){
			$('#js_date_soldout').css("display", "block").removeAttr('disabled');
		}else{
			$('#js_date_soldout').css("display", "none").attr('disabled', 'disabled');
		}
	}
	function CalSize(obj){
		var num = $('.js_detail_size').length;
		var total = $('#js_item_size_build').val();
		var sum = parseInt(0);
		if(num > 2){
			for (var i = 0; i < num; i++) {
				var size = $('.js_detail_size').eq(i).val();
				if(size && size != "undefined"){
					sum = sum + size * 1000;
				}
			}
			var rest = (parseInt(total*1000) - sum) / 1000;
			$('.js_detail_size:last').val(rest);
		}
		if(num > 0){
			var name = (num-1) +"階面積";
			$('.js_detail_name:last').val(name);
		}
	}
	function ChangeCommissionRate(){
		var value_discount = $('#js_item_discount').val();
		var item_price = $('#js_item_price').val();
//		var price_boder = 1800;
//		if($('#js_flg_new').is(':checked')){
//			if(item_price > price_boder && value_discount != "70" && item_price){
//				$('#js_item_discount').val("70");
//				alert("手数料割引を70%に変更しました");
//			}else if(item_price <= price_boder && value_discount != "50" && item_price){
//				$('#js_item_discount').val("50");
//				alert("手数料割引を50%に変更しました");
//			}
//		}
    if(item_price >= "3500" && value_discount != "100" && item_price){
      $('#js_item_discount').val("100");
      alert("手数料割引を100%に変更しました");
    }else if(item_price >= "3000" && value_discount != "70" && item_price){
      $('#js_item_discount').val("70");
      alert("手数料割引を70%に変更しました");
    }else if(item_price >= "1800" && value_discount != "50" && item_price){
      $('#js_item_discount').val("50");
      alert("手数料割引を50%に変更しました");
    }else if(item_price < "1800" && value_discount != "30" && item_price){
      $('#js_item_discount').val("30");
      alert("手数料割引を30%に変更しました");
    }
	}
	function SelectOffice(){
		var seller_cd = $('#js_seller_cd').val();
		$('#js_seller_office_cd').children().remove();
		$.ajax({
			type: "POST",
			url: file_path,
			data: "md=select_office&seller_cd="+ seller_cd,
			datatype: "json",
			success: function(data){
				$('#js_seller_office_cd').append('<option value="">-----</option>');
				if(data){
					var arr = eval(data);
					$.each(arr, function(){
						$('#js_seller_office_cd').append('<option value="'+ this.seller_office_cd +'">'+ this.seller_office_name +'</option>');
					});
				}
			}
		});		
		
	}
	
	//▼バインド群▼//
	$(document).on('dragenter','.js_drop',function(e){
		e.preventDefault();
	}).on('dragover','.js_drop',function(e){
		e.preventDefault();
	}).on('drop','.js_drop',function(e){
		e.preventDefault();
		var my_flame = $(this).closest('.js_flame');
		MakeThumbnail(e.originalEvent.dataTransfer, my_flame);
	});
	$(document).on('click','.js_up',function(){
		UpImage();
	});
	$(document).on('click','.js_choose',function(){
	var my_flame = $(this).closest('.js_flame');
		$(".js_input", my_flame).click();
	});
	$(document).on('change','.js_input',function(){
		var my_flame = $(this).closest('.js_flame');
		MakeThumbnail(this, my_flame);
	});
	$(document).on('click','.js_delete_flame',function(){
		DelFlame(this);
	});
	$(document).on('click','.js_delete_contents',function(){
		DelContents(this);
	});
	$(document).on('change','#js_pref_cd',function(){
		MakeCity();
	});
	$(document).on('change','#js_city_cd',function(){
		NarrowSearchSchool();
	});
	$(document).on('change','#js_school_jun_cd',function(){
		NarrowSearchSchoolHigh();
	});
	$(document).on('change','.js_pubtrans',function(){
		var pubtrans_cd = $(this).val();
		MakeStop(this, pubtrans_cd);
		ClearWordStop(this);
	});
	$(document).on('keyup','.js_search_word_stop',function(){
		SearchWordStop(this);
	});
//	$(document).on('blur','.js_search_word_stop',function(){
//		ClearWordStop(this);
//	});
	$(document).on('keyup','#js_search_word_pri',function(){
		SearchWordPri();
	});
	$(document).on('keyup','#js_search_word_jun',function(){
		SearchWordJun();
	});
	$(document).on('click','.js_add_list',function(){
		AddList(this);
	});
	$(document).on('click','.js_add_list_theta',function(){
		AddListTheta(this);
	});
	$(document).on('click','.js_del_list',function(){
		DelList(this);
	});
	$(document).on('click','.js_del_list_theta',function(){
		DelListTheta(this);
	});
	$(document).on('change','#js_cat_item_cd',function(){
		ShowColum();
	});
	$(document).on('keyup','.js_dist',function(){
		CalTime(this);
	});
	$(document).on('change','#js_flg_soldout',function(){
		SwitchSoldDate();
	});
	$(document).on('click','#js_cal_size',function(){
		CalSize(this);
	});
	$(document).on('change','#js_flg_new',function(){
		ChangeCommissionRate();
	});
	$(document).on('blur','#js_item_price',function(){
		ChangeCommissionRate();
	});
	$(document).on('change','#js_seller_cd',function(){
		SelectOffice();
	});
	
	//▼イニシャル群▼//
	AdjustStyle();
	ShowColum();
	SwitchSoldDate();

});
