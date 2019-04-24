<?php 
$MKVersion = 2;
?>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="../Lib/Scripts/JQuery.js"></script>
    <style>
        body{
            margin: 0px;
            padding: 0px;
            top: 0px;
            left: 0px;
            width: 100vw;
            height: 100vh;
            line-height: 1.5;
        }
        .running{
            background-color: rgba(110, 110, 110, 1);
            width: 100vw;
            height: 5vh;
            position: absolute;
        }
        .runningbar{
            position: absolute;
            top: 0px;
            height: inherit;
            width: 10%;
            background-color: green;
            text-align: center;
            color: white;
        }
        .status{
            background-color: grey;
            position: absolute;
            width: 100vw;
            height: 60vh;
            top: 5vh;
            text-align: center;
        }
        .log{
            height: 35vh;
            width: 100vw;
            position: absolute;
            bottom: 0;
            background-color: whitesmoke;
            overflow: auto;
        }
        .StatusIcon{
            height: inherit;
            width: auto;
        }
        .logItem{
            background-color: white;
            border-bottom-style: solid;
            border-width: 1px;
            padding-left: 5px;
        }
        .logItem p{
            display: inline;
            color: red;
        }
        .logItem p::after{
            content: " -> ";
            color: black;
        }
        .logItem label{
            display: inline;
            color: blue;
        }
        .Overlay{
            display: none;
            position: fixed;
            bottom: 0px;
            left: 0px;
            width: 100vw;
            height: 10vh;
            border-top-style: solid;
            border-width: 10px;
            border-color: rgba(1,20,200,0.8);
            background-color: rgba(1,20,249,0.8);
            color: white;
            z-index: 100;
            text-align: center;
        }
    </style>
    <script>
        function ShowMeATrick(){
            window.external.Popup("Ready?");
        }
        //Green top Updated bar.
        function Updated(Time){
            $(".runningbar").width();
            var offsetx = $(".runningbar").width() + $(".runningbar").offset().left;
            if(offsetx >= $("body").width()){
                offsetx = 0;
            }
            $(".runningbar").offset({ top: 0, left: offsetx });
            $(".runningbar").text(Time);
        }
        setInterval(function(){ 
            if($(".status").attr("detected") === "true"){
                if($(".status").css("background-color") === "rgb(139, 0, 0)"){
                    $(".status").css("background-color", 'red');
                }else{
                    $(".status").css("background-color", 'darkred');
                }
            }
            
        }, 300);
        //Warning Systems
        function Detected(Time){
            $(".status").html('<img class="StatusIcon" src="../Lib/Pictures/Cross.png" /><img class="StatusIcon" src="../Lib/Pictures/Cross.png" />');
            $(".status").css("background-color", "red");
            $(".status").attr("detected", true);
        }
        function NotDetected(Time){
            $(".status").html('<img class="StatusIcon" src="../Lib/Pictures/check.png" /><img class="StatusIcon" src="../Lib/Pictures/check.png" />');
            $(".status").css("background-color", "lime");
            $(".status").attr("detected", false);
        }
        //Logs
        function AddLogNewer(date, info){
            $(".log").prepend('<div class="logItem"><p>'+date+'</p><label>'+info+'</label></div>');
        }
        function AddLogOlder(date, info){
            $(".log").append('<div class="logItem"><p>'+date+'</p><label>'+info+'</label></div>');
        }
        //Overlays
        function HideOverlay(){
            $(".Overlay").slideUp(200);
        }
        function ShowOverlay(){
            $(".Overlay").slideDown(200);
        }
        //Version Check
        function CheckVersion(version){
            if(version < <?php echo $MKVersion; ?>){
                $(".Overlay").html('<a style="color: white;" href="/Random/MeekijkDetector.php">Klik hier om de nieuwe meekijkdetector te downloaden</a><p>Of download hem hier: <input type="text" value="https://site.onno204vps.nl.eu.org/Random/MeekijkDetector.php"</input></p>');
                ShowOverlay();
            }
        }
        //Doc Ready JQuery
        $(document).ready(function(){
            $(".Overlay").mouseleave(function(){
                HideOverlay();
            });
        });
    </script>
</head>

<body>
    <div class="running">
        <div class="runningbar">00:00:00</div>
    </div>
    
    <div class="status" detected="false" id="status">
        
    </div>
    <div class="HiddenPreLoad" style="display: none;">
        <img class="StatusIcon" src="../Lib/Pictures/check.png" />
        <img class="StatusIcon" src="../Lib/Pictures/Cross.png" />
    </div>
    
    <div class="log">
        <div class="logItem"><p><?php echo date("H:i:s"); ?></p><label>Programma geladen.</label></div>
    </div>
    <div class="Overlay">
        tetee
    </div>
    <div onclick="window.external.Popup('Ready?'); window.external.startm()">
    </div>
    
</body>


