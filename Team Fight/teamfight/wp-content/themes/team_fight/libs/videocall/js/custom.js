(function ( $ ) {

    $.videoCall = function( callerId,roomId ) {
        
        $.magnificPopup.close();
        var connection = new RTCMultiConnection();
        var streamId = '';
        caller = '';
        
        // this line is VERY_important
        connection.socketURL = 'https://rtcmulticonnection.herokuapp.com:443/';
        
        connection.keepStreamsOpened = false;
        
        // if you want audio+video conferencing
        connection.session = {
            audio: true,
            video: false
        };
        
        connection.socketMessageEvent = 'audio-conference-demo';
        connection.session = {
            audio: true,
            video: false
        };
        connection.mediaConstraints = {
            audio: true,
            video: false
        };
        connection.sdpConstraints.mandatory = {
            OfferToReceiveAudio: true,
            OfferToReceiveVideo: false
        };
        connection.remoteaudiosContainer = document.getElementById('remote-audios-container');
        connection.localaudiosContainer = document.getElementById('local-audios-container');
        connection.onstream = function(event) {
            
             if (event.type == 'remote') {
                 remoteAudio(event);
                 return;
             }
             if (event.type == 'local') {
                 localAudio(event);
                 return;
             }
        };

        function remoteAudio(event){
            $('#'+event.userid).attr('streamid',event.streamid);
            var width = parseInt(connection.remoteaudiosContainer.clientWidth / 2) - 20;
            var mediaElement = getHTMLMediaElement(event.mediaElement, {
                title: event.userid,
                buttons: ['full-screen'],
                width: width,
                showOnMouseEnter: false
            });
            
            connection.remoteaudiosContainer.appendChild(mediaElement);
                setTimeout(function() {
                    mediaElement.media.play();
                }, 5000);
                mediaElement.id = event.streamid;
            
        
        }
        
        function localAudio(event){
            $('#lMirco,#lVolume').attr('streamid',event.streamid);
            var width = parseInt(connection.localaudiosContainer.clientWidth / 2) - 20;
            var mediaElement = getHTMLMediaElement(event.mediaElement, {
                title: event.userid,
                buttons: ['full-screen'],
                width: width,
                showOnMouseEnter: false
            });
            
            connection.localaudiosContainer.appendChild(mediaElement);
                setTimeout(function() {
                    mediaElement.media.play();
                    mediaElement.media.muted = true;
                }, 5000);
                mediaElement.id = event.streamid;
        
        }
        
            
        connection.onstreamended = function(event) {
            var mediaElement = document.getElementById(event.streamid);
            if (mediaElement) {
                mediaElement.parentNode.removeChild(mediaElement);
            }
        };   
        
        
        
        
        connection.userid = callerId;
        connection.openOrJoin(roomId);
        
        $('#local-audios-container audio').prop("muted", true);
        
        function AllvolumeDown(action,lstreamId){
            $(".chat_inf_box audio").each(function(){
                
                $('#local-audios-container audio').prop("muted", true);
                
                
                if($(this).attr("was") != 'muted' && action == true && $(this).attr("id") != lstreamId){
                    $(this).prop("muted", action);
                } else if( action == false ) {
                    $(this).prop("muted", action);
                }
                
                $('#local-audios-container audio').prop("muted", true);
                
            });
        }
        $('#lVolume').on('click',function(){
        lstreamId = $(this).attr('streamid');    
            if($(this).hasClass('fa-volume-up')){
                AllvolumeDown(true,lstreamId);
            } else {
                AllvolumeDown(false,lstreamId);
            }    
           $(this).toggleClass('fa-volume-up fa-volume-off');
        });

        $('#lMirco').on('click',function(){
          streamId = $(this).attr('streamid');    
          if($(this).attr('class') === 'fa fa-microphone-slash'){
            connection.streamEvents[streamId].stream.unmute('audio');
          } else {
            connection.streamEvents[streamId].stream.mute('audio');   
          }        
           $(this).toggleClass('fa-microphone fa-microphone-slash');
           $('#local-audios-container audio').prop("muted", true);
        });        


    $('.remoteUser').on('click',function(){    
        
        userId   = $(this).attr('id');
        streamId = $(this).attr('streamid');
        
        if (streamId.indexOf("{") >= 0){
            streamId = streamId.replace("{", '').replace("}", '');
            audioElem = $("audio#\\{"+streamId+"\\}");
        } else {
            audioElem = $('audio#'+streamId);            
        }
        // alert('#'+userId+'audio');
        
        if($(this).hasClass('fa-volume-up')){
                audioElem.prop("muted", true);
                $(this).attr('was','muted');
        } else {
                audioElem.prop("muted", false);
                $(this).attr('was','');
        }    
       $(this).toggleClass('fa-volume-up fa-volume-off');        
    });
        
    }
    
}( jQuery ));