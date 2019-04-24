
var ws;
var FirstConnection = false;


function SendTestMsg(Text){
    ws.send(Text);
}

function SendClicked(){
    if($("#Message").val().length <1){
        return;
    }
    var e = document.getElementById("Clients");
    var strUser = $("#Clients :selected").text();
    SendTestMsg("Message:" + strUser + "##*()" + $("#Message").val());
    $("#Message").val("");
}
function SendClickedE(e) {
    if (e.keyCode === 13) {
        SendClicked();
    }
}


function SelectChat(){
    var Name = $("#Clients :selected").text();
    if(!$( "#MessageBox" + Name).length ) {
        console.log("Message box for " + Name + " has been created!");
        $("#Messages").html($("#Messages").html() + "<div id='" + "MessageBox" + Name + "' class='MessageBox'></div>");
    }
    $('.MessageBox').removeClass('Show');
    $( "#MessageBox" + Name).addClass("Show");
    $("#Clients" + Name).removeClass("NieuwMessage");
    $("#CurrentUser").text(Name);
}

function OpenServerStatusConnection(ServerIP, UserName){
    ws = new WebSocket(ServerIP);
    ws.onmessage = function(evt) {
        var received_msg = evt.data;
        if(!FirstConnection){ SendTestMsg("ClientName:" + UserName); }
        FirstConnection = true;
        if(received_msg.startsWith("Clients:")){
            var res = received_msg.replace("Clients:", "");
            var Name = $("#Clients :selected").text();
            $("#Clients").html('<option value="GlobalChat">GlobalChat</option>');
            var ClientsS = res.split(',');
            for (var User in ClientsS) {
                if(ClientsS[User] === ""){ continue; }
                if(ClientsS[User] === UserName){ continue; }
                console.log(ClientsS[User]);
                $("#Clients").html($("#Clients").html() + '<option id="Clients'+ ClientsS[User] +'" value="'+ ClientsS[User] +'">'+ ClientsS[User] +'</option>');
            }
            $("#Clients").val(Name);
        }
        if(received_msg.startsWith("Error:")){
            var res = received_msg.replace("Error:", "");
            //$("#ChatBox").html($("#ChatBox").html() + res);
        }
        if(received_msg.startsWith("Message:")){
            var res = received_msg.replace("Message:", "");
            var SPLT = res.split('##*()');
            var From = SPLT[1];
            var name = SPLT[0];
            var message = SPLT[2];
            if(!$( "#MessageBox" + name).length ) {
                console.log("Message box for " + name + " has been created!");
                $("#Messages").html($("#Messages").html() + "<div id='" + "MessageBox" + name + "' class='MessageBox'></div>");
            }
            //replace < by &lt; and > by &gt;
            if(From === UserName){
                $( "#MessageBox" + name).html($( "#MessageBox" + name).html() + "<span class='message Extern'>" + message + " &lt" + " </span>");
            }else{
                $( "#MessageBox" + name).html($( "#MessageBox" + name).html() + "<span class='message Intern'>" + From + "&gt " + message + "</span>");
                if( $("#Clients :selected").text() !== name){
                    $("#Clients" + name).addClass("NieuwMessage");
                }
            }
        }
        console.log(UserName + " received: " + received_msg);
    };
    
    
    
    ws.onopen = function() {
        $("#OnlineStatus").text("Online");
        $("#OnlineStatus").addClass('OnlineStatus').removeClass('OfflineStatus');
        console.log("Connection established for: " + UserName);
    };
    ws.onerror = function(evt) {
        if($("#OnlineStatus").text() === "Offline"){ $("#Version").text("Highly recommended to reload! Server no longer show Up-to-Date info!").addClass('OfflineStatus'); }
        $("#Players").text("");
        var received_msg = evt.data;
        console.log(UserName + " Error: " + received_msg);
    };
    ws.onclose = function() {
        FirstConnection = false;
        $("#OnlineStatus").text("Offline");
        $("#OnlineStatus").addClass('OfflineStatus').removeClass('OnlineStatus');
        console.log("Connection closed for: " + UserName);
        OpenServerStatusConnection(ServerIP, UserName);
    };
}
