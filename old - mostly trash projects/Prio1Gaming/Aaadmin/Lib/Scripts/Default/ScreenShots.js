////////////////////////
// Screenshot Log
////////////////////

//Are you Sure - Screenshot Log
function ClearSSLogYes(){
    $('YesNo').slideUp(500);
    window.location = "Remote.php?ClearSS=1&CmdLog=1";
}

/////////////////////////////
//  Full Screen Options
////////////////////////////


//Create Full Screen overlay for the picture
function ResizePicture(Elmt){
    if(!OverlayActive()){
        $(OverlayId).attr("ondblclick", "ResizePicture()");
        $(OverlayId).attr("onclick", "ZoomPicture()");
        var Info = "<p>Dubbel click = Exit <br> Click = zoom <br> Easy view, Click the scroll wheel</p>";
        $(OverlayId).html(Info + "<img id=\"PikaFull\" class=\"PikaFull\" src=\""+ $(Elmt).attr("src") +"\"> </img>");
        $(PikaElmt).focus(function(){
            PikaMove(event);
        });
    }
    SwitchOverlay();
}

function PikaMove(event){
    console.log(event.pageX);
}

//Make the picture bigger in Fullscreen Mode
function ZoomPicture(){
    if($(PikaElmt).attr("Zoom") === "1"){
        $(PikaElmt).animate({width: "400vw"}, 600);
        $(PikaElmt).attr("Zoom", "2");
    }else if($(PikaElmt).attr("Zoom") === "2"){
        $(PikaElmt).animate({width: "99vw"}, 400);
        $(PikaElmt).attr("Zoom", "0");
    }else {
        $(PikaElmt).animate({width: "150vw"}, 600);
        $(PikaElmt).attr("Zoom", "1");
    }
}