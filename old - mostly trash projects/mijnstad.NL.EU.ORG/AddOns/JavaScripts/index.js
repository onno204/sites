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
function CheckOverlay() { var Div = '<div class="CloseButton" onclick="CloseOverlay()">X</div>'; if(document.getElementById("OverlayText").innerHTML  === Div ){ CloseOverlay(); } }

function CloseOverlay2() { document.getElementById("Overlay2").classList.toggle("hide"); }
function CheckOverlay2() { var Div = '<div class="CloseButton" onclick="CloseOverlay2()">X</div>'; if(document.getElementById("OverlayText2").innerHTML  === Div ){ CloseOverlay2(); } }

function CheckOverlays(){
    CheckOverlay();
    CheckRegister();
    CheckLogin();
}

function CloseAllOverlays(){
    document.getElementById("Overlay").className = "Overlay hide";
    document.getElementById("Overlay2").className = "Overlay hide";
    document.getElementById("RegisterOverlay").className = "LoginOverlay hide";
    document.getElementById("LoginOverlay").className = "LoginOverlay hide";
}

function ToggleRegister() { document.getElementById("RegisterOverlay").classList.toggle("hide"); }
function CheckRegister() { if(document.getElementById("RegisterOverlayText").innerHTML  === ""){ ToggleRegister(); }  }
function ClearRegisterMenu() { document.getElementById("RegisterOverlayText").innerHTML  = ""; }

function ToggleLogin() { document.getElementById("LoginOverlay").classList.toggle("hide"); }
function CheckLogin() { if(document.getElementById("LoginOverlayText").innerHTML  === ""){ ToggleLogin(); }  }
function ClearLoginMenu() { document.getElementById("LoginOverlayText").innerHTML  = ""; }

function GetSpaceLeft(){
    var hey = window.screen.availWidth - 144;
    document.getElementById("MijnstadServer").style.width = hey;
    return hey;
}

