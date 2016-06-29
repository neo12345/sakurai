$(function(){

	//▼コンフィグ群▼//
	var file_path = "/master/seller_office.php";
	
	
	//▼ファンクション群▼//
	function MakeMain(){
		$('#js_list').children().remove();
		$.ajax({
			type: "POST",
			url: file_path,
			data: "md=make_main",
			datatype: "text",
			success: function(data){
				if(data){
					var list = $('#js_list');
					list.html(''+ data +'');
				}
			}
		});
	}
	function RegistSellerOffice(){
		var seller_cd = $('#js_seller_cd').val();
		var seller_office_cd = $('#js_seller_office_cd').val();
		var seller_office_name = $('#js_seller_office_name').val();
		var seller_office_tel = $('#js_seller_office_tel').val();
		if(seller_office_name){
			$.ajax({
				type: "POST",
				url: file_path,
				data: "md=regist_seller_office&seller_cd="+ seller_cd +"&seller_office_cd="+ seller_office_cd +"&seller_office_name="+ seller_office_name +"&seller_office_tel="+ seller_office_tel,
				datatype: "text",
				success: function(data){
					if(data){
						window.location.href = '/master/?md=seller_office';
//						var html = ''+
//							'<tr class="js_colum">'+
//								'<td>'+ data +'<input type="hidden" class="js_seller_office_cd" value="'+ data +'" /></td>'+
//								'<td>'+ seller_office_name +'<input type="hidden" class="js_seller_office_name" value="'+ seller_office_name +'" /></td>'+
//								'<td class="edit"><input type="button" class="js_edit" value="編" /></td>'+
//								'<td class="del"><p class="js_delete">削除</p></td>'+
//							'</tr>';
//						$('#js_list').prepend(''+ html +'');
//						$('#js_seller_office_name').val("");
					}else{
						alert("同じ名前の営業所があります");
					}
				}
			});
		}
	}
	function EditSellerOffice(obj){
		var my_colum = $(obj).closest('.js_colum');
		var seller_cd = $('.js_seller_cd', my_colum).val();
		var seller_office_cd = $('.js_seller_office_cd', my_colum).val();
		var seller_office_name = $('.js_seller_office_name', my_colum).val();
		var seller_office_tel = $('.js_seller_office_tel', my_colum).val();
		$('#js_seller_office_name').val(seller_office_name);
		$('#js_seller_office_tel').val(seller_office_tel);
		$('#js_seller_office_cd').val(seller_office_cd);
		$('#js_seller_cd').val(seller_cd);
	}
	function DeleteSellerOffice(obj){
		var my_colum = $(obj).closest('.js_colum');
		var seller_office_cd = $('.js_seller_office_cd', my_colum).val();
		var seller_office_name = $('.js_seller_office_name', my_colum).val();
		ConfirmDialog("削除確認", "「"+ seller_office_name +"」<br />を削除します。", function(){
			$.ajax({
				type: "POST",
				url: file_path,
				data: "md=delete_seller_office&seller_office_cd="+ seller_office_cd,
				datatype: "text",
				success: function(data){
					if(data){
						my_colum.remove();
					}
				}
			});
		});
	}
	function CheckLink(seller_office_cd, call_back){
		$.ajax({
			type: "POST",
			url: file_path,
			data: "md=check_link&seller_office_cd="+ seller_office_cd,
			datatype: "text",
			success: function(data){
				if(data){
					call_back();
				}else{
					alert("物件に紐付けされています\n紐付けを解除すれば削除できます");
				}
			}
		});
		
	}



	//▼バインド群▼//
	$(document).on('click','#js_regist_seller',function(){
		 RegistSellerOffice();
	});
	$(document).on('click','.js_delete',function(){
		 DeleteSellerOffice(this);
	});
	$(document).on('click','.js_edit',function(){
		 EditSellerOffice(this);
	});
	
	
	//▼イニシャル群▼//
//	MakeMain();


});
