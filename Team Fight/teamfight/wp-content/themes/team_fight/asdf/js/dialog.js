var xhr = 0,litsentimer, hash;
function listenMe(hash){
  clearInterval(litsentimer);
	litsentimer = setInterval(function(){
		hash = $.trim($('input#dialog_hash').val());
		xhr = $.post('wp-content/themes/team_fight/libs/xhr/get_msg.php?action=get_new_messages', {
			hash:hash
		}, function(data,status){
			if( status=='success' ){
				var empty_chat = $.trim(data);
				if (empty_chat == 'deleted') {
					clearInterval(litsentimer);
					var st = 'no';
					$.post(save_user_inform_link, {
						st_off: st
					});
					var pop_up_con = $(".pop_up_box").html();
					$.magnificPopup.open({
						items: {
							src: pop_up_con,
							type: 'inline'
						},
						closeBtnInside: true
					});
					$('#alert_box').find('.error_message').html('Mate has left chat').parent().show();
				} else if( data.res==0 ){
					if( data.html!=''){
						$('#message_box').append(data.html);
						_scrollBottom();
					}
				}  
			}
		},'json');
	},1000);
}
function _scrollBottom(){
if( $('#message_box').length )
	$('#message_box').get(0).scrollTop = $('#message_box').get(0).scrollHeight;
}
function fastChat(){
	var mess =  $.trim($('#message_form').find('#message').val());
	if(mess.length){
		clearInterval(litsentimer);
		enterSend();
		if(xhr)xhr.abort();
		$('#message_form').find('#message').val('');
		hash = $.trim($('input#dialog_hash').val());
		$.post('wp-content/themes/team_fight/libs/xhr/get_msg.php?action=send',{
			message:mess,
			hash:hash
		}, function(data,status){
			listenMe(hash);
			if( status=='success' ){
				if ( data.res==0 ){
					$('#message_box').append(data.html);
					_scrollBottom();
				}
			}
		},'json');
	}
	return false;
}


$(document).ready(function(){
	enterSend();
});


function enterSend() {
	hash = $.trim($('input#dialog_hash').val());
	_scrollBottom();
	if (hash != '') {
		listenMe(hash);
	}
	$('#message').keydown(function(e){
		if( e.which==13 ){
			e.preventDefault();
			fastChat();
			return false;
		}
	});
}