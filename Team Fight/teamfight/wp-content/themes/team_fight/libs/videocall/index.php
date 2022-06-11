<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <script src="js/RTCMultiConnection.min.js"></script>
        <script src="js/socket.io.js"></script>
        <script src="js/getMediaElement.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css"> 
        
    </head>
    <body>
    <div class="videos-box">
        <div id="videos-container">
            <div class="views"><i class="fa fa-eye" aria-hidden="true"></i><span id="views"> 0</span></div>
            <div id="videos-remote-multi"></div>
        </div>
        <div class="videos-container-bottom">
            <div id="videos-local"></div>
            <div class="local-buttons">
                <i id="lStop" class="fa fa-phone" aria-hidden="true"></i>
                <i id="lCamera" class="fa fa-video-camera" aria-hidden="true"></i>
                <i id="lMirco" class="fa fa-microphone" aria-hidden="true"></i>
                <i id="lVolume" class="fa fa-volume-up" aria-hidden="true"></i>
            </div>
        </div>
    </div>
<script src="js/custom.js"></script>    
<script>
    $.videoCall('<?=$_GET['u']?>','<?=$_GET['id']?>');
</script>    

</body>
</html>