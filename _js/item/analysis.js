$(function(){

	//▼コンフィグ群▼//
	var file_path = "/item/analysis.php";
	
	//▼ファンクション群▼//
	function NarrowSearchCity2(){
		var city_cd = $('#js_city_cd').val();
		var list = $('#js_list');
		window.location = "/item/?md=analysis&city_cd="+ city_cd;
	}
	
	//▼バインド群▼//
	$(document).on('change','#js_city_cd',function(){
		NarrowSearchCity2();
	});
	
	//▼イニシャル群▼//
	
	
});
