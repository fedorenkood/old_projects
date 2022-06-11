var xhr = 0,litsentimer, hash;

//////////////

function videoCallMessage(){
    
	var mess =  'calling';
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
				if ( data.res===0 ){
					$('#message_box').append(data.html);
					_scrollBottom();
				}
			}
		},'json');
	}
	return false;
} 


// Clear chat before close
// window.onbeforeunload = closingCode;
// function closingCode(){
//     alert('hola!!!');
//     var st = 'no';
//     $.post(save_user_inform_link, {
//     	st_off: st
//     });

//   return null;
// }

window.onbeforeunload = function(e) {
    var st = 'no';
    $.post(save_user_inform_link, {
    	st_off: st
    });
  return null;
};


var userleft = false;
function timerTimer(waiting){
        waiting = waiting || false;
		hash = $.trim($('input#dialog_hash').val());
		xhr = $.post('wp-content/themes/team_fight/libs/xhr/get_msg.php?action=get_new_messages', {
			hash:hash
		}, function(data,status){
			if( status=='success' && !userleft ){
				var empty_chat = $.trim(data);
				if (empty_chat == 'waiting123') {
                    
                    // if(waiting == false){
                    //     setTimeout(function(){ timerTimer(true); }, 45000);
                    //     return;
                    // }
                    
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
					
					$('#lStop').trigger( "click" );
					userleft = true;

				} else if( data.res==0 ){
					if( data.html!=''){
                        if(data.html=='calling'){
                            $('#listencall').val(data.sender).trigger('change');
                        } else {
    						$('#message_box').append(data.html);
    						_scrollBottom();                            
                        }

					}
					setTimeout(timerTimer, 1000);
				}  
			}
		},'json');
}
///////////////
function listenMe(hash){
  setTimeout(timerTimer, 1000);
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