<?php

if(!$Utils->HasPerms("Smarthome")){
    echo "<p class=\"MsgError\">You have no perms to see this page!</p>";
    return;
}
?>




<div class="CamPreview">
    <video autoplay="true" id="videoElement1">
        
    </video>
    <button type="submit" class="RequestButton" onclick="UploadPic('videoElement1', 'Upload');">Save Picture</button>
    <button type="submit" class="RequestButton" onclick="StreamVideo('videoElement1');">Start Stream</button>
    <button type="submit" class="RequestButton" onclick="StopUploadStream = true;">Stop Stream</button>
</div>
<br>
<br>
<div class="CamPreview">
    <img autoplay="true" id="ImageElement1">
        
    </img>
</div>
    <button type="submit" class="RequestButton" onclick="DownloadSingleVideo('ImageElement1');">Download Single picture</button>
    <button type="submit" class="RequestButton" onclick="DownloadStreamVideo('ImageElement1');">Start Download Stream</button>
    <button type="submit" class="RequestButton" onclick="StopDownloadStream = true;">Stop Download Stream</button>


<!-- Load Video Stream -->
<script>
    var video = document.getElementById("videoElement1");
    var ImgE = document.getElementById("ImageElement1");
 
    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;

    if (navigator.getUserMedia) {       
        navigator.getUserMedia({video: true}, handleVideo, videoError);
    }

    function handleVideo(stream) {
        video.src = window.URL.createObjectURL(stream);
    }

    function videoError(e) { }
</script>

<!-- Connect to socket -->
<script src="Lib/Scripts/socket.io.js"></script>
<script src="Lib/Scripts/jsxcompressor.js"></script>
<script>
    var ws = new WebSocket("ws://127.0.0.1:9999/");
    ws.onmessage = function (event) {
        if(event.data.length < 100){
            console.log("Received: ", event.data);
        }else{
            console.log("Received a long string");
        }
        var Split = event.data.split(':');
        var Command = Split[0].toLowerCase();
        var Args = Split[1];
        switch(Command) {
            case "updateimage":
                ImgE.src = "data:image/png;base64," + Args;
                break;
            case "none":
                break;
            default:
                console.log("Command not found", Command);
        }
    };
    ws.onopen = function (event) {
        console.log("Opent With: ", event);
        SendMessage("name:<?php echo $_SESSION['username']; ?>");
    };
    ws.onerror = function (event) {
        console.log("Error: ", event);
    };
    ws.onclose = function (event) {
        console.log("closed: ", event);
    };
    
    
    function SendMessage(Message){
        if(length.length < 100){
            console.log("Sending: ", Message);
        }else{
            console.log("Sending a long string");
        }
        ws.send(Message);
    }
</script>

<script>
    function UploadPic(CamName, Prefix){
        var canvas = document.createElement('canvas');
        var Cam = document.getElementById(CamName);
        canvas.height = Cam.videoHeight;
        canvas.width = Cam.videoWidth;
        var ctx = canvas.getContext('2d');
        console.log("Uploading");
        ctx.drawImage(Cam, 0, 0, canvas.width, canvas.height);
        var Base64S = canvas.toDataURL().replace("data:image/png;base64,", "");
        SendMessage(Prefix+":"+Base64S);
    }
    var StopUploadStream = false;
    function StreamVideo(CamName){
        var inter = setInterval(function() {
            if(StopUploadStream){
                StopUploadStream = false;
                clearInterval(inter);
                return;
            }
            UploadPic(CamName, "UploadStream");
        }, 150);
    }
    function DownloadSingleVideo(CamName){
        SendMessage("ReceiveStream:" + CamName);
    }
    var StopDownloadStream = false;
    function DownloadStreamVideo(CamName){
        var inter = setInterval(function() {
            if(StopDownloadStream){
                StopDownloadStream = false;
                clearInterval(inter);
                return;
            }
            DownloadSingleVideo(CamName);
        }, 150);
    }
</script>


