$(function(){

	//▼コンフィグ群▼//
	var file_path = "/master/seller.php";
	
	
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
	function RegistSeller(){
		var seller_cd = $('#js_seller_cd').val();
		var seller_name = $('#js_seller_name').val();
		var seller_tel = $('#js_seller_tel').val();
		if(seller_name){
			$.ajax({
				type: "POST",
				url: file_path,
				data: "md=regist_seller&seller_cd="+ seller_cd +"&seller_name="+ seller_name +"&seller_tel="+ seller_tel,
				datatype: "text",
				success: function(data){
					if(data){
						window.location.href = '/master/?md=seller';
//						var html = ''+
//							'<tr class="js_colum">'+
//								'<td>'+ data +'<input type="hidden" class="js_seller_cd" value="'+ data +'" /></td>'+
//								'<td>'+ seller_name +'<input type="hidden" class="js_seller_name" value="'+ seller_name +'" /></td>'+
//								'<td class="edit"><input type="button" class="js_edit" value="編" /></td>'+
//								'<td class="del"><p class="js_delete">削除</p></td>'+
//							'</tr>';
//						$('#js_list').prepend(''+ html +'');
//						$('#js_seller_name').val("");
					}else{
						alert("同じ名前の売主があります");
					}
				}
			});
		}
	}
	function EditSeller(obj){
		var my_colum = $(obj).closest('.js_colum');
		var seller_cd = $('.js_seller_cd', my_colum).val();
		var seller_name = $('.js_seller_name', my_colum).val();
		var seller_tel = $('.js_seller_tel', my_colum).val();
		$('#js_seller_name').val(seller_name);
		$('#js_seller_tel').val(seller_tel);
		$('#js_seller_cd').val(seller_cd);
	}
	function DeleteSeller(obj){
		var my_colum = $(obj).closest('.js_colum');
		var seller_cd = $('.js_seller_cd', my_colum).val();
		CheckLink(seller_cd, function(){
			var seller_name = $('.js_seller_name', my_colum).val();
			ConfirmDialog("削除確認", "「"+ seller_name +"」<br />を削除します。", function(){
				$.ajax({
					type: "POST",
					url: file_path,
					data: "md=delete_seller&seller_cd="+ seller_cd,
					datatype: "text",
					success: function(data){
						if(data){
							my_colum.remove();
						}
					}
				});
			});
		});
	}
	function CheckLink(seller_cd, call_back){
		$.ajax({
			type: "POST",
			url: file_path,
			data: "md=check_link&seller_cd="+ seller_cd,
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
		 RegistSeller();
	});
	$(document).on('click','.js_delete',function(){
		 DeleteSeller(this);
	});
	$(document).on('click','.js_edit',function(){
		 EditSeller(this);
	});
	
	
	//▼イニシャル群▼//
//	MakeMain();


});
