$(function(){

	//▼コンフィグ群▼//
	var file_path = "/contents/select.php";
	
	//▼ファンクション群▼//
	function ShowCodeFrame(obj){
		var my_colum = $(obj).closest('.js_colum');
		$('.js_item_cd', my_colum).css("display", "none");
		$('.js_cd_frame', my_colum).css("display", "block");
	}
	function RegistCode(obj){
		var my_colum = $(obj).closest('.js_colum');
		var reco_cd = $('.js_reco_cd', my_colum).val();
		var item_cd = $('.js_value', my_colum).val();
		$.ajax({
			type: "POST",
			url: file_path,
			data: "md=resist_cd&reco_cd="+ reco_cd +"&item_cd="+ item_cd,
			datatype: "data",
			success: function(data){
				if(data){
					$('.js_item_cd', my_colum).text(''+ item_cd +'');
					$('.js_item_name', my_colum).text(''+ data +'');
					$('.js_item_cd', my_colum).css("display", "block");
					$('.js_cd_frame', my_colum).css("display", "none");
				}else{
					item_cd = $('.js_item_cd', my_colum).text();
					$('.js_item_cd', my_colum).text(''+ item_cd +'');
					$('.js_value', my_colum).val(''+ item_cd +'');
					$('.js_item_cd', my_colum).css("display", "block");
					$('.js_cd_frame', my_colum).css("display", "none");
					alert("物件がありません。");
				}
			}
		});		
	}
	
	//▼バインド群▼//
	$(document).on('click','.js_item_cd',function(){
		ShowCodeFrame(this);
	});
	$(document).on('click','.js_regist',function(){
		RegistCode(this);
	});
	
	//▼イニシャル群▼//


});
