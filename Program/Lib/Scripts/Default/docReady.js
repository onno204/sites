

//Stuff to do when the page is loaded
$(document).ready(function(){
    ClearInter = setInterval(SlideDown, 500); // Remove Loading overlay and fadein the content
    $("#RefreshTime").text(CheckTime); // Set timer for the RemoteControl
    $(".Waiting").mouseenter(function(){ // Create event for Remotecontrol AutoUpdate
        WaitingEnter(this);
    });
    SetCustomBackground();
});