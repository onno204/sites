<?php
require 'Utils.php';
$Utils = new Utils();
$Utils->ConnectCheck();


if(isset($_GET['Wifi'])){
    ?>
<!--
<iframe id="IFRAME" height="500px" onload="LoadIntoIframe()" width="500px" src="http://lan1.internet-access.center/tportal/demande.php?lang=en&next_url=http://denassau.nl/">
<iframe id="IFRAME" height="500px" onload="LoadIntoIframe()" width="500px" src="Chailaininternet/">
<iframe id="IFRAME" height="500px" onload="LoadIntoIframe()" width="500px" src="http://lan1.internet-access.center/tportal/demande.php?lang=en&next_url=http://denassau.nl/">

-->
<iframe id="IFRAME" height="500px" width="500px" src="Chailaininternet/">

</iframe>
<script>
    function LoadIntoIframe(){
        return true;
        $("iframe").contents().find('body').append(""
        + "<script>"
        + "function GetIndex(){"
        + "    console.log( $('amount').selectedIndex );"
        + "}"
        + "<\/script>"
        + ""
        + ""
        + ""
        + "");
        console.log("Iframe Loaded");
    }
    
$("#IFRAME").ready(function(){
});
</script>
    <?php
}














if(isset($_GET['Disco'])){
    ?>
    <link href="http://www.w3schools.com/lib/w3.css" rel="stylesheet" type="text/css" />
    <link href="Lib/Styles/w3.css" rel="stylesheet" type="text/css" />
    <script>
        var Rand, i;
        i = 10;
        function Lal(){
            Rand = getRandomInt(1,i);
            $("#Body").attr("class", "");
            i=1;
            if(Rand === i){
                $("#Body").addClass("w3-green");
            }i++;
            if(Rand === i){
                $("#Body").addClass("w3-red");
            }i++;
            if(Rand === i){
                $("#Body").addClass("w3-deep-orange");
            }i++;
            if(Rand === i){
                $("#Body").addClass("w3-yellow");
            }i++;
            if(Rand === i){
                $("#Body").addClass("w3-sand");
            }i++;
            if(Rand === i){
                $("#Body").addClass("w3-teal");
            }i++;
            if(Rand === i){
                $("#Body").addClass("w3-aqua");
            }i++;
            if(Rand === i){
                $("#Body").addClass("w3-blue");
            }i++;
            if(Rand === i){
                $("#Body").addClass("w3-purple");
            }i++;
            if(Rand === i){
                $("#Body").addClass("w3-pink");
            }i++;
            if(Rand === i){
                $("#Body").addClass("w3-cyan");
            }i++;
            if(Rand === i){
                $("#Body").addClass("w3-lime");
            }i++;
            if(Rand === i){
                $("#Body").addClass("w3-yellow");
            }
        }
        
        $(document).ready(function(){
            setInterval(Lal, 90);
        });
    </script>
    <?php
}

$Utils->LastLoad();