$(function(){

	//▼コンフィグ群▼//
	var file_path = "/item/list.php";
	
	//▼ファンクション群▼//
	function DelItem(obj){
		var my_colum = $(obj).closest('.js_colum');
		var item_cd = $('.js_item_cd', my_colum).val();
		var item_name = $('.js_item_name', my_colum).val();
		ConfirmDialog("削除確認", "「"+ item_name +"」<br />を削除します。", function(){
			$.ajax({
				type: "POST",
				url: file_path,
				data: "md=del_item&item_cd="+ item_cd,
				datatype: "data",
				success: function(data){
					if(data){
						window.location = "/item/?md=list";
					}
				}
			});		
		});
	}
	function NarrowSearchCity1(){
		var city_cd = $('#js_city_cd').val();
		var list = $('#js_list');
		list.children().remove();
		$.ajax({
			type: "POST",
			url: file_path,
			data: "md=narrow_search_city&city_cd="+ city_cd,
			datatype: "data",
			success: function(data){
				if(data){
					var arr = eval(data);
					if(arr.length){
						$.each(arr, function(){
							var str_item_name;
							var str_item_addr;
							var item_name;
							if(this.item_name_sub){
								item_name = this.item_name +'（'+ this.item_name_sub +'）';
							}else{
								item_name = this.item_name;
							}
							if(this.flg_active){
								str_item_name = '<a href="http://www.sh-smilenavi.com/item/?md=detail&cd='+ this.item_cd +'" target="blank">'+ item_name +'</a>';
							}else{
								str_item_name = ''+ item_name +'';
							}
							if(this.item_addr3){
								str_item_addr = this.item_addr2 + this.item_addr3;
							}else{
								str_item_addr = this.item_addr2;
							}
							var html = ''+
										'<tr class="js_colum">'+
											'<td class="no">'+ this.item_cd +'<input type="hidden" class="js_item_cd" value="'+ this.item_cd +'" /></td>'+
											'<td>'+ str_item_name +'<input type="hidden" class="js_item_name" value="'+ this.item_name +'" /></td>'+
											'<td>'+ this.pref_name + this.city_name + str_item_addr +'</td>'+
											'<td class="edit"><input type="submit" name="edit['+ this.item_cd +']" value="編集" /></td>'+
											'<td class="del"><p class="js_delete">削除</p></td>'+
										'</tr>';
							list.append(''+ html +'');
						});
					}
					
				}
			}
		});		
	}
	function NarrowSearchCity2(){
		var city_cd = $('#js_city_cd').val();
		var seller_cd = $('#js_seller_cd').val();
		var seller_office_cd = $('#js_seller_office_cd').val();
		var stat_cd = $('#js_stat_cd').val();
		var stat_item_cd = $('#js_stat_item_cd').val();
		var search_name = $('#js_serach_name').val();
		var type_search = $("input[name='type_search']:checked").val();
		var list = $('#js_list');
		window.location = "/item/?md=list&city_cd="+ city_cd +"&seller_cd="+ seller_cd +"&seller_office_cd="+ seller_office_cd +"&stat_cd="+ stat_cd +"&stat_item_cd="+ stat_item_cd +"&search_name="+ search_name +"&type_search="+ type_search;
	}
	function ShowPriceFrame(obj){
		var my_colum = $(obj).closest('.js_colum');
		$('.js_item_price', my_colum).css("display", "none");
		$('.js_price_frame', my_colum).css("display", "block");
	}
	function RegistPrice(obj){
		var my_colum = $(obj).closest('.js_colum');
		var item_cd = $('.js_item_cd', my_colum).val();
		var value = $('.js_value', my_colum).val();
		$.ajax({
			type: "POST",
			url: file_path,
			data: "md=resist_price&item_cd="+ item_cd +"&item_price="+ value,
			datatype: "data",
			success: function(data){
				if(data){
					var text_price = NumberFormat(value) +"万円";
					$('.js_item_price', my_colum).text(''+ text_price +'');
					$('.js_item_price', my_colum).css("display", "block");
					$('.js_price_frame', my_colum).css("display", "none");
				}
			}
		});		
	}
	function JumpDetail(obj){
		var my_colum = $(obj).closest('.js_colum');
		var item_cd = $('.js_item_cd', my_colum).val();
		window.location.href = '/item/?md=analysis_item&item_cd='+ item_cd;
  }
	function SwitchStatus(obj){
		var my_colum = $(obj).closest('.js_colum');
		var item_cd = $('.js_item_cd', my_colum).val();
		var status = $('.js_status', my_colum).val();
		var status_new;
		var color;
		switch (status){
			case "販":
				status_new = "商";
				color = "pink";
				break;
				
			case "商":
				status_new = "成";
				color = "silver";
				break;
				
			case "成":
				status_new = "販";
				color = "white";
				break;
		}
		$.ajax({
			type: "POST",
			url: file_path,
			data: "md=switch_status&item_cd="+ item_cd +"&status_new="+ status_new,
			datatype: "data",
			success: function(data){
				if(data){
					$('.js_status', my_colum).val(status_new);
					my_colum.css("backgroundColor", color);
				}
			}
		});		
	}
	
	//▼バインド群▼//
	$(document).on('click','.js_delete',function(){
		DelItem(this);
	});
//	$(document).on('change','#js_city_cd',function(){
//		NarrowSearchCity2();
//	});
//	$(document).on('change','#js_stat_cd',function(){
//		NarrowSearchCity2();
//	});
	$(document).on('change','#js_seller_cd',function(){
		NarrowSearchCity2();
	});
//	$(document).on('change','#js_seller_office_cd',function(){
//		NarrowSearchCity2();
//	});
//	$(document).on('change','#js_stat_item_cd',function(){
//		NarrowSearchCity2();
//	});
	$(document).on('click','#js_search',function(){
		NarrowSearchCity2();
	});
	$(document).on('click','.js_item_price',function(){
		ShowPriceFrame(this);
	});
	$(document).on('click','.js_regist',function(){
		RegistPrice(this);
	});
	$(document).on('click','.js_detail',function(){
		JumpDetail(this);
	});
	$(document).on('click','.js_status',function(){
		SwitchStatus(this);
	});
	
	//▼イニシャル群▼//
	
	
});
