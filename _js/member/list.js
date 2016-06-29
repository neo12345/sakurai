$(function(){

	//▼コンフィグ群▼//
	var file_path = "/member/list.php";
	
	
	//▼ファンクション群▼//
	function DelItem(obj){
		var my_colum = $(obj).closest('.js_colum');
		var mem_cd = $('.js_mem_cd', my_colum).val();
		var mem_name = $('.js_mem_name', my_colum).val();
		ConfirmDialog("削除確認", "「"+ mem_name +"」<br />を削除します。", function(){
			$.ajax({
				type: "POST",
				url: file_path,
				data: "md=del_mem&mem_cd="+ mem_cd,
				datatype: "data",
				success: function(data){
					if(data){
						my_colum.remove();
					}
				}
			});		
		});
	}
	

	//▼バインド群▼//
	$(document).on('click','.js_delete',function(){
		DelItem(this);
	});
	
	
	//▼イニシャル群▼//



});
