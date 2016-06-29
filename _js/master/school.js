$(function(){

	//▼コンフィグ群▼//
	var file_path = "/master/school.php";
	
	
	//▼ファンクション群▼//
	function MakeMain(){
		var school_cd = $('#js_school_cd').val();
		$('#js_list').children().remove();
		$.ajax({
			type: "POST",
			url: file_path,
			data: "md=make_main&school_cd="+ school_cd,
			datatype: "text",
			success: function(data){
				if(data){
					var list = $('#js_list');
					list.html(''+ data +'');
				}
			}
		});
	}
	function SwitchActive(obj){
		var my_colum = $(obj).closest('.js_colum');
		var check = $('.js_active', my_colum).is(':checked');
		var flg_active;
		if(check){
			flg_active = "1";
		}else{
			flg_active = "";
		}
		var school_cd = $('.js_school_cd', my_colum).val();
		var school_table = $('.js_school_table', my_colum).val();
		var school_initial = $('.js_school_initial', my_colum).val();
		$.ajax({
			type: "POST",
			url: file_path,
			data: "md=switch_active&flg_active="+ flg_active +"&school_cd="+ school_cd + "&school_table="+ school_table + "&school_initial="+ school_initial,
			datatype: "text",
			success: function(data){
				if(!data){
					alert("error");
				}
			}
		});
	}
	function UpImage(obj, my_colum){
		var m_school_cd = $('#js_school_cd').val();
		var school_cd = $('.js_school_cd', my_colum).val();
		var school_table = $('.js_school_table', my_colum).val();
		var school_initial = $('.js_school_initial', my_colum).val();
		var img_icon = $('.js_view', my_colum).css("background");
		var files = obj.files;
		var fileReader = new FileReader();
		fileReader.readAsDataURL( files[0] );
		fileReader.onloadstart = function(){
			$('.js_drop', my_colum)
			.removeClass("image")
			.addClass("load");
			$('.js_view', my_colum).css("background", "url(../_img/common/icon_loading.gif)");
		}
		fileReader.onload = function( event ) {
			var loadedImageUri = event.target.result;
			$.ajax({
				type: "POST",
				url: file_path,
				data: "md=up_image&m_school_cd="+ m_school_cd +"&school_cd="+ school_cd +"&school_table="+ school_table +"&school_initial="+ school_initial +"&img_type="+ files[0].type +"&img_uri="+ loadedImageUri,
				datatype: "text",
				success: function(data){
					if(data){
						$(".js_view", my_colum)
						.removeClass("btngray")
						.css("background", img_icon);
					}
				}
			});
		}
		fileReader.onloadend = function(){
			$('.js_drop', my_colum)
			.removeClass("load")
			.addClass("image");
			$('.js_view', my_colum).addClass("js_dialog_open");
		}
	}
	function ShowImage(obj){
		var my_colum = $(obj).closest('.js_colum');
		var m_school_cd = $('#js_school_cd').val();
		var school_cd = $('.js_school_cd', my_colum).val();
		var dir = $('#js_dir').val();
		switch(m_school_cd){
			case "1":
				dir = dir +"/primary/";
				break;
			case "2":
				dir = dir +"/junior/";
				break;
			case "3":
				dir = dir +"/high/";
				break;
		}
		var file = dir + convertNum(school_cd, 3) +".jpg";
		$('#js_school_view').attr("src", file);
	}
	

	//▼バインド群▼//
	$(document).on('change','#js_school_cd',function(){
		 MakeMain();
	});
	$(document).on('change','.js_active',function(){
		 SwitchActive(this);
	});
	$(document).on('dragenter','.js_drop',function(e){
		e.preventDefault();
	}).on('dragover','.js_drop',function(e){
		e.preventDefault();
	}).on('drop','.js_drop',function(e){
		e.preventDefault();
		var my_colum = $(this).closest('.js_colum');
		UpImage(e.originalEvent.dataTransfer, my_colum);
	});
	$(document).on('click','.js_view',function(){
		 ShowImage(this);
	});


	//▼イニシャル群▼//
	MakeMain();
	
	
});
