

function OpenServerStatusConnection(ServerIP, ServerName){
    var ws = new WebSocket(ServerIP);
    var Current = ServerName;
    ws.onopen = function() {
        $("#OnlineStatus" + Current).text("Online");
        $("#OnlineStatus" + Current).addClass('OnlineStatus').removeClass('OfflineStatus');
        console.log("Connection established for: " + ServerName);
    };
    ws.onmessage = function(evt) {
        var received_msg = evt.data;
        if(received_msg.startsWith("Players")){
            var res = received_msg.replace("Players", "");
            $("#Players" + Current).text(res);
        }
        if(received_msg.startsWith("OnlinePlayers")){
            var res = received_msg.replace("OnlinePlayers", "");
            $("#OnlinePlayers" + Current).text(res);
        }
        if(received_msg.startsWith("Version")){
            if($("#Version" + Current).text() === "Highly recommended to reload! Server no longer show Up-to-Date info!"){ return; }
            var res = received_msg.replace("Version", "");
            $("#Version" + Current).text(res);
        }
        if(received_msg.startsWith("Whitelist")){
            var res = received_msg.replace("Whitelist", "");
            $("#Whitelist" + Current).text(res);
        }
        
        console.log(ServerName + " received: " + received_msg);
    };
    ws.onerror = function(evt) {
        if($("#OnlineStatus" + Current).text() === "Offline"){ $("#Version" + Current).text("Highly recommended to reload! Server no longer show Up-to-Date info!").addClass('OfflineStatus'); }
        $("#Players" + Current).text("");
        var received_msg = evt.data;
        console.log(ServerName + " Error: " + received_msg);
    };
    ws.onclose = function() {
        $("#OnlineStatus" + Current).text("Offline");
        $("#OnlineStatus" + Current).addClass('OfflineStatus').removeClass('OnlineStatus');
        console.log("Connection closed for: " + ServerName);
        OpenServerStatusConnection(ServerIP, ServerName);
        //Replace
        //Replace
    };
}
