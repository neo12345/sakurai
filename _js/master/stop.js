$(function(){

	//▼コンフィグ群▼//
	var file_path = "/master/stop.php";
	
	
	//▼ファンクション群▼//
	function MakeMain(){
		var pubtrans_cd = $('#js_pubtrans_cd').val();
		$('#js_list').children().remove();
		$.ajax({
			type: "POST",
			url: file_path,
			data: "md=make_main&pubtrans_cd="+ pubtrans_cd,
			datatype: "text",
			success: function(data){
				if(data){
					var list = $('#js_list');
					list.html(''+ data +'');
				}
//				if(data){
//					var arr = eval(data);
//					var list = $('#js_list');
//					$.each(arr, function(){
//						var html = ''+
//							'<tr class="js_colum">'+
//								'<td>'+
//								''+ this.stop_cd +''+
//								'<input type="hidden" class="js_stop_cd" value="'+ this.stop_cd +'" />'+
//								'</td>'+
//								'<td>'+ this.stop_name +
//								'<input type="hidden" class="js_stop_name" value="'+ this.stop_name +'" />'+
//								'</td>'+
//								'<td class="edit"><input type="button" class="js_edit" value="編" /></td>'+
//								'<td class="del"><p class="js_delete">削除</p></td>'+
//							'</tr>';
//						list.append(''+ html +'');
//					});
//				}
			}
		});
	}
	function ShowRegist(){
		var pubtrans_cd = $('#js_pubtrans_cd').val();
		//if(pubtrans_cd == "3" || pubtrans_cd == "27" || pubtrans_cd == "28" || pubtrans_cd == "29"){
		if(pubtrans_cd){
			$('#js_frame_regist').css("display", "block");
		}else{
			$('#js_frame_regist').css("display", "none");
		}
	}
	function RegistStop(){
		var pubtrans_cd = $('#js_pubtrans_cd').val();
		if(pubtrans_cd == "3" || pubtrans_cd == "27" || pubtrans_cd == "28" || pubtrans_cd == "29"){
			var stop_name = $('#js_stop_name').val();
			if(stop_name){
				$.ajax({
					type: "POST",
					url: file_path,
					data: "md=regist_stop&pubtrans_cd="+ pubtrans_cd +"&stop_name="+ stop_name,
					datatype: "text",
					success: function(data){
						if(data){
							var html = ''+
								'<tr class="js_colum">'+
									'<td>'+ data +'<input type="hidden" class="js_stop_cd" value="'+ data +'" /></td>'+
									'<td>'+ stop_name +'<input type="hidden" class="js_stop_name" value="'+ stop_name +'" /></td>'+
									'<td class="edit"><input type="button" class="js_edit" value="編" /></td>'+
									'<td class="del"><p class="js_delete">削除</p></td>'+
								'</tr>';
							$('#js_list').prepend(''+ html +'');
							$('#js_stop_name').val("");
						}else{
							alert("同じ名前の駅があります");
						}
					}
				});
			}
		}else{
			//alert("現在登録できるのは「バス」のみです");
			var stop_name = $('#js_stop_name').val();
			if(stop_name){
				$.ajax({
					type: "POST",
					url: file_path,
					data: "md=search_name&stop_name="+ stop_name,
					datatype: "text",
					success: function(json){
						if(json){
							var param = eval(json);
							//$.print_r(param, true);
							var arr_name = [];
							$.each(param, function(i){
								arr_name[i] = this['pubtrans_name']+ ":" +this['stop_name'];
							});
							var result = arr_name.join()
							alert("類似する名称「"+ result +"」");
						}else{
							$.ajax({
								type: "POST",
								url: file_path,
								data: "md=regist_stop&pubtrans_cd="+ pubtrans_cd +"&stop_name="+ stop_name,
								datatype: "text",
								success: function(data){
									if(data){
										var html = ''+
											'<tr class="js_colum">'+
												'<td>'+ data +'<input type="hidden" class="js_stop_cd" value="'+ data +'" /></td>'+
												'<td>'+ stop_name +'<input type="hidden" class="js_stop_name" value="'+ stop_name +'" /></td>'+
												'<td class="edit"><input type="button" class="js_edit" value="編" /></td>'+
												'<td class="edit"><input type="button" class="js_edit" value="編" /></td>'+
												'<td class="del"><p class="js_delete">削除</p></td>'+
											'</tr>';
										$('#js_list').prepend(''+ html +'');
										$('#js_stop_name').val("");
									}else{
										alert("同じ名前の駅があります");
									}
								}
							});
						}
					}
				});
			}
		}
	}
	function DeleteSop(obj){
		var my_colum = $(obj).closest('.js_colum');
		var stop_cd = $('.js_stop_cd', my_colum).val();
		var pubtrans_cd = $('#js_pubtrans_cd').val();
		//if(pubtrans_cd == "3" || pubtrans_cd == "27" || pubtrans_cd == "28" || pubtrans_cd == "29"){
		if(pubtrans_cd){
			CheckLink(stop_cd, function(){
				var stop_name = $('.js_stop_name', my_colum).val();
				ConfirmDialog("削除確認", "「"+ stop_name +"」<br />を削除します。", function(){
					$.ajax({
						type: "POST",
						url: file_path,
						data: "md=delete_stop&stop_cd="+ stop_cd,
						datatype: "text",
						success: function(data){
							if(data){
								my_colum.remove();
							}
						}
					});
				});
			});
		}else{
			alert("現在削除できるのは「バス」のみです");
		}
	}
	function CheckLink(stop_cd, call_back){
		$.ajax({
			type: "POST",
			url: file_path,
			data: "md=check_link&stop_cd="+ stop_cd,
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


	function UpImage(obj, my_colum){
		var stop_cd = $('.js_stop_cd', my_colum).val();
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
				data: "md=up_image&stop_cd="+ stop_cd +"&img_type="+ files[0].type +"&img_uri="+ loadedImageUri,
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
		var stop_cd = $('.js_stop_cd', my_colum).val();
		var dir = $('#js_dir').val();
		var file = dir + "/" + convertNum(stop_cd, 4) +".jpg";
		$('#js_stop_view').attr("src", file);
	}


	//▼バインド群▼//
	$(document).on('change','#js_pubtrans_cd',function(){
		 MakeMain();
		 ShowRegist();
	});
	$(document).on('click','#js_regist_stop',function(){
		 RegistStop();
	});
	$(document).on('click','.js_delete',function(){
		 DeleteSop(this);
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
