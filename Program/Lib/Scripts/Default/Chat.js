var UNumber = 2;
var source;
function SetupListener(){
    if (!!window.EventSource) {
        source = new EventSource('Chat.php?BackEnd=' + UNumber);
    } else { }// Result to xhr polling :( 
    source.addEventListener('message', function(e) {
        Log(e.data);
        var arr = JSON.parse(e.data);
        var ChatBox = $('#ChatBox');
        var i, Time, User, Message, ID, ElmtID;
        for(i = 0; i < arr.length; i++) {
            Time = arr[i].time;
            User = arr[i].nickname;
            Message = arr[i].message;
            ID = arr[i].id;
            ElmtID = "ID" + ID;
            if($("#" + ElmtID).attr("id") === undefined){
                ChatBox.append("<label id='"+ElmtID+"'><span>"+Time+"</span><a>"+User+"</a><p>"+Message+"</p></label>");
            }
        }
        var elem = document.getElementById("ChatBox"); elem.scrollTop = elem.scrollHeight;
    }, false);

    source.addEventListener('open', function(e) {
        Log("Connection Opened");
    }, false);

    source.addEventListener('error', function(e) {
        if (e.readyState === EventSource.CLOSED) {
            Log("Connection Closed.");
        }
        if(UNumber === 2){ 
            Log("Restarting WHITOUT first start!");
            UNumber = 1;
            source.close();
            SetupListener();
        }
        Log("Restarting Connection!");
    }, false);
    
}
function SendMessageKEY(Elmt, event){
    var Key = event.key;
    if(Key === "Enter"){
        SendMessage();
    }else if(Key === "Escape"){
    }
}

function SendMessage(){
    $(InfoID).text("Sending message..");
    $(InfoID).slideDown(500);
    var Content = $("#SendMessageText").val();
    $("#SendMessageText").val("");
    var msg = Content.replace(/ /g, "%20");
    var URL = "Chat.php?SendMessage=1&Message=" + msg;
    console.log(URL);
    $(InfoID).load(URL, function(){
        $(InfoID).slideUp(500);
    });
    return true;
}