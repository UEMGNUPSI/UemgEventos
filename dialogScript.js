
$(document).ready(function(){

	$('.btn-inscrever').on('click', function(){
		if($('#login-dialog').position().left != 0){
			$('#login-dialog').animate({
				left: "+=590px"
			}, 400);
		}
	});
			
	$('#close-login-dialog').on('click', function(){
		if($('#login-dialog').position().left == 0){
			$('#login-dialog').animate({
				left: "-=590px"
			}, 300);
		}
	});
	$('#btn-cheio').on('click', function(){
		if($('#cheio-dialog').position().left != 0){
			$('#cheio-dialog').animate({
				left: "+=590px"
			}, 400);
		}
	});
	$('#close-cheio-dialog').on('click', function(){
		if($('#cheio-dialog').position().left == 0){
			$('#cheio-dialog').animate({
				left: "-=590px"
			}, 300);
		}
	});

});




