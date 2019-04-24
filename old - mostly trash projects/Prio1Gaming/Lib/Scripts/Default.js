///////////////////
// Required functions
//////////////////


/////////////////////////////
//  Overlays / Info
////////////////////////////
//
//
//Show the Bottom info
function ShowInfo(Time){
    if(!Boolean(Time)){ Time = 0; }
    console.log(Time);
    InfoTime = new Date().getSeconds();
    $(InfoID).slideDown(500);
    setTimeout(function() {
        if((InfoTime === (new Date().getSeconds()-(2+Time))) || InfoTime === (new Date().getSeconds()-(3+Time))){ $(InfoID).slideUp(500); }
    }, (2000 + (Time * 1000)));
}

//Check if Overlay is Active
function OverlayActive(){
    if($(OverlayId).attr("Shown") === "1"){
        return true;
    }else{
        return false;
    }
}

//Set overlay active or De-active
function SwitchOverlay(){
    if(OverlayActive()){
        $(OverlayId).animate({margin: "0px 0px 0px 120vw"}, 200).fadeOut(0);
        $(OverlayId).attr("Shown", "0");
    }else{
        $(OverlayId).attr("Shown", "1");
        $(OverlayId).fadeIn(0).animate({margin: "0px 0px 0px 0px"}, 200);
    }
}

//Yes/No Question
function YesNoQ(Text, YesAction, NoAction){
    $("#YesNoText").text(Text);
    $("YesNo").slideDown(500);
    $("#YesNoYes").attr("onclick", YesAction);
    $("#YesNoNo").attr("onclick", NoAction);
    
}


/////////////////////////////
//  Site Loader
////////////////////////////

var ClearInter;
//More fancy loading
function SlideDown(){
    $("nav").slideDown(650).css("display", "inline-block");
    $("main").fadeIn(600);
    $("LoadingPage").fadeOut(400).remove();
    $("footerWait").slideDown(650);
    clearInterval(ClearInter);
}


/////////////////////////////
//  Misc functions
////////////////////////////

function Log(Text){
    console.log(Text);
};
            
function SetCookie(Key, Value){
    var d = new Date();
    d.setTime(d.getTime() + (90*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = Key+"="+Value+"; "+expires+"; path=/";
}

function GetCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)===' ') c = c.substring(1);
        if (c.indexOf(name) === 0) return c.substring(name.length, c.length);
    }
    return "";
}

function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

