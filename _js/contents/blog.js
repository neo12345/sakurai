$(function(){
	
	//▼コンフィグ群▼//
	var file_path = "/contents/blog.php";
	
	
	//▼ファンクション群▼//
	function MakePreview(obj, my_frame){
		var stat = $('.js_status', my_frame).val();
		var files = obj.files;
		var fileReader = new FileReader();
		fileReader.readAsDataURL(files[0]);
		fileReader.onloadstart = function(){
			$('.js_image', my_frame).css({
				backgroundImage: "url(../../_img/common/icon_loading.gif)",
				backgroundPosition: "center center",
				backgroundRepeat: "no-repeat",
				backgroundSize: "auto"
			});
		}
		fileReader.onload = function(event) {
			
		}
		fileReader.onloadend = function(event){
			var loadedImageUri = event.target.result;
			var type = files[0].type;
			$.ajax({
				type: "POST",
				url: file_path,
				data: "md=up_image&st="+ stat +"&img_type="+ type +"&img_uri="+ loadedImageUri,
				datatype: "data",
				success: function(data){
					if(data){
						$('.js_image', my_frame).css({
							backgroundImage: "url("+ loadedImageUri +")",
							backgroundSize: "cover"
						});
					}
				}
			});		
		}
	}
	
	
	//▼バインド群▼//
	$(document).on('dragenter', '.js_image', function(e){
		e.preventDefault();
	}).on('dragover', '.js_image', function(e){
		e.preventDefault();
	}).on('drop', '.js_image', function(e){
		e.preventDefault();
		var my_frame = $(this).closest('.js_frame');
		MakePreview(e.originalEvent.dataTransfer, my_frame);
	});


	//▼イニシャル群▼//
	
	
});
