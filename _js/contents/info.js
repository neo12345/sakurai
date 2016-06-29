$(function(){

	//▼コンフィグ群▼//
	var file_path = "/contents/info.php";
	
	
	//▼ファンクション群▼//
	function DelInfo(obj){
		var my_colum = $(obj).closest('.js_colum');
		var info_cd = $('.js_info_cd', my_colum).val();
		var info_date = $('.js_info_date', my_colum).val();
		ConfirmDialog("削除確認", "「"+ info_date +"」<br />を削除します。", function(){
			$.ajax({
				type: "POST",
				url: file_path,
				data: "md=del_info&info_cd="+ info_cd,
				datatype: "data",
				success: function(data){
					if(data){
						my_colum.remove();
					}
				}
			});		
		});
	}
	function EditInfo(obj){
		var my_colum = $(obj).closest('.js_colum');
		var info_cd = $('.js_info_cd', my_colum).val();
		$.ajax({
			type: "POST",
			url: file_path,
			data: "md=get_info&info_cd="+ info_cd,
			datatype: "data",
			success: function(data){
				if(data){
					var arr = eval(data);
					$('#js_info_cd').val(arr[0]['info_cd']);
					$('#js_info_date').val(arr[0]['info_date']);
					$('#js_info_title').val(arr[0]['info_title']);
					$('#js_info_contents').val(arr[0]['info_contents']);
					$('#js_info_link').val(arr[0]['info_link']);
				}
			}
		});		
	}
	

	//▼バインド群▼//
	$(document).on('click','.js_delete',function(){
		DelInfo(this);
	});
	$(document).on('click','.js_edit',function(){
		EditInfo(this);
	});
	
	
	//▼イニシャル群▼//



});
