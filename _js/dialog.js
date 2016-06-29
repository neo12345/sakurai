$(function(){
	var dl_frame = $('.js_dialog_frame');
	var dl_op = $('.js_dialog_open');
	var dl_cl = $('.js_dialog_close');
	var dl_scroll = $('.js_dialog_scroll');
	var dl_scroll_rate = 10;
	var speed = "fast";
	var z_index = 20;
	
	dl_frame.css({
		display: 'none',
		zIndex: z_index + 10
	});
	dl_cl.css({
		cursor: 'pointer'
	});
	
	function DarkIN(rel){
		var my_frame;
		if(rel){
			my_frame = $('.js_dialog_frame[rel="'+ rel +'"]')
		}else{
			my_frame = dl_frame;
		}
		my_frame.before('<div class="js_dialog_wrap js_dialog_close" rel="'+ rel +'"></div>');
		var wrapper = $('.js_dialog_wrap');
		wrapper.css({
			position: 'fixed', top: '0px', left: '0px', 
			width: '100%',
			height: '100%',
			backgroundColor: '#000000',
			zIndex: z_index,
			filter: 'alpha(opacity=50)',
//			-moz-opacity: '0.5',
			opacity: '0.5'
		});
		wrapper.fadeIn(speed);
	} 
	
	function DarkOut(rel){
		var wrapper = $('.js_dialog_wrap[rel='+ rel +']');
		wrapper.fadeOut(speed, function(){
			wrapper.remove();
		});
	} 
	
	function ShowFrame(obj){
		var my_frame;
		var rel = $(obj).attr("rel");
		if(rel){
			my_frame = $('.js_dialog_frame[rel="'+ rel +'"]')
		}else{
			my_frame = dl_frame;
		}
		if(my_frame.length){
			var width = parseInt(my_frame.width());
			var height = parseInt(my_frame.height());
			var border_t = parseInt(my_frame.css('border-top-width').replace("px", ""));
			var border_r = parseInt(my_frame.css('border-right-width').replace("px", ""));
			var border_b = parseInt(my_frame.css('border-bottom-width').replace("px", ""));
			var border_l = parseInt(my_frame.css('border-left-width').replace("px", ""));
			var padding_t = parseInt(my_frame.css('padding-top').replace("px", ""));
			var padding_r = parseInt(my_frame.css('padding-right').replace("px", ""));
			var padding_b = parseInt(my_frame.css('padding-bottom').replace("px", ""));
			var padding_l = parseInt(my_frame.css('padding-left').replace("px", ""));
			DarkIN(rel);
			my_frame.css({
				position: 'fixed', top: '50%',left: '50%',
				marginTop: '-' + (height + border_t + border_b + padding_t + padding_b)/2 + 'px',
				marginLeft: '-' + (width + border_r + border_l + padding_r + padding_l)/2 + 'px'
			});
			my_frame.fadeIn(speed);
		}
	}
	
	function HideFrame(obj){
		var my_frame;
		var rel = $(obj).attr("rel");
		if(!rel){
			rel = $(obj).closest('.js_dialog_frame').attr("rel");
		}
		if(rel){
			my_frame = $('.js_dialog_frame[rel="'+ rel +'"]')
		}else{
			my_frame = dl_frame;
		}
		if(my_frame.length){
			my_frame.fadeOut(speed);
			DarkOut(rel);
		}
	}
	
	$(document).on('click', '.js_dialog_open', function(){
		ShowFrame(this);
	});
	$(document).on('click', '.js_dialog_close', function(){
		HideFrame(this);
	});
	$(document).on('mousewheel', '.js_dialog_scroll', function(event, delta, delta_x, delta_y){
		event.preventDefault();
		var sc_t = $(this).scrollTop();
		var sc_l = $(this).scrollLeft();
		$(this).scrollTop(sc_t - delta_y * dl_scroll_rate);
		$(this).scrollLeft(sc_l - delta_x * dl_scroll_rate);
	});
	$(document).on('mousewheel', '.js_dialog_frame', function(event, delta, delta_x, delta_y){
		event.preventDefault();
	});
	$(document).on('mousewheel', '.js_dialog_wrap', function(event, delta){
		event.preventDefault();
	});


	//トップページから来た場合
	if($('#js_search').val()){
		ShowFrame($('#js_search'));
	}

});
