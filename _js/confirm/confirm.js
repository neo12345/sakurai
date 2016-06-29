//確認ダイヤログ
function ConfirmDialog(title, message, callback_true, callback_false) {
	var obj_frame = $('body');
	var contents = ''+
		'<div class="ConfirmDiv">'+
			'<div>'+
				'<p class="ConfirmTitle">'+ title +'</p>'+
				'<p class="ConfirmMessage">'+ message +'</p>'+
				'<div class="ConfirmButton">'+
					'<div class="ConfirmButtonAction"></div>'+
					'<div class="ConfirmButtonCancel"></div>'+
				'</div>'+
				'<div class="ConfirmClear"></div>'+
			'</div>'+
		'</div>';
	obj_frame.append(contents);
	DarkIN();
	$(document).on('click','.ConfirmButtonAction',function(){
		DarkOut();
		$('.ConfirmDiv').remove();
		callback_true();
		$(document).off('click', '.ConfirmButtonAction');
	});
	$(document).on('click','.ConfirmButtonCancel',function(){
		DarkOut();
		$('.ConfirmDiv').remove();
		callback_false();
		$(document).off('click', '.ConfirmButtonCancel');
	});
}
function DarkIN(){
	$('.ConfirmDiv').before('<div id="js_dialog_wrap"></div>');
	var wrapper = $("#js_dialog_wrap");
	wrapper.css({
		position: 'fixed', top: '0px', left: '0px', 
		width: '100%',
		height: '100%',
		backgroundColor: '#000000',
		zIndex: "10"
	});
	wrapper.fadeTo(0, 0.5);
} 
function DarkOut(){
	var wrapper = $("#js_dialog_wrap");
	wrapper.remove();
} 
