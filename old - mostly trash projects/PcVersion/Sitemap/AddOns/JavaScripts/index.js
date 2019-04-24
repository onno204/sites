function codeAddress() {
    CheckOverlays();
}
window.onload = codeAddress;

document.onkeydown = function(evt) {
    evt = evt || window.event;
    var isEscape = false;
    if ("key" in evt) { isEscape = evt.key == "Escape";
    }else { isEscape = evt.keyCode == 27; } 
    if (isEscape) { CloseAllOverlays(); }
}

function PlayClick(){
       var audio = document.getElementById("ClickAudio");
       audio.currentTime=0;
       audio.play();
}


function CloseOverlay() { document.getElementById("Overlay").classList.toggle("hide"); }
function CheckOverlay() { if(document.getElementById("OverlayText").innerHTML  === ""){ CloseOverlay(); } }

function CheckOverlays(){
    CheckOverlay();
    CheckRegister();
}

function CloseAllOverlays(){
    document.getElementById("Overlay").className = "Overlay hide";
    document.getElementById("RegisterOverlay").className = "LoginOverlay hide";
}

function ToggleRegister() { document.getElementById("RegisterOverlay").classList.toggle("hide"); }
function CheckRegister() { if(document.getElementById("RegisterOverlayText").innerHTML  === ""){ ToggleRegister(); }  }
function ClearRegisterMenu() { document.getElementById("RegisterOverlayText").innerHTML  = ""; }

function GetSpaceLeft(){
    var hey = window.screen.availWidth - 144;
    document.getElementById("MijnstadServer").style.width = hey;
    return hey;
}