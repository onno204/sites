//////////////////
// Remote Control
/////////////////



/////////////////////////////
//  Misc
////////////////////////////


//Are you Sure - Remotecontrol Log
function ClearLogYes(){
    $('YesNo').slideUp(500);
    window.location = "Remote.php?ClearOutput=1&CmdLog=1";
}


///////////////////////
// Automatic Reloader // Remote Control
/////////////////////
setInterval(CheckUpdateTimer, 1000*1);

//Timer Function
function CheckUpdateTimer(){
    var T;
    T = $("#RefreshTime").text();
    if(T === "0"){
        T=CheckTime;
        CheckUpdate();
    }else{
        T--;
    }
    T = $("#RefreshTime").text(T);
}

//Create Tr for the Table
function CreateSelector(arr, i){
    var Ip, Id, LastUpdated, Running, Done, RunningClass, DoneClass, Command, Output;
    Id = arr[i].ID;
    Ip = arr[i].IP;
    LastUpdated = arr[i].Date;
    if (arr[i].Running === "1"){ 
        Running = "True";
        RunningClass = "SelectorGREEN";
    }else { 
        Running = "False";
        RunningClass = "SelectorRED";
    }
    if (arr[i].Done === "1"){ 
        Done = "True";
        DoneClass = "SelectorGREEN";
    }else { 
        Done = "False"; 
        DoneClass = "SelectorRED";
    }
    Command = arr[i].Command + ": " + arr[i].Args;
    Output = (arr[i].Output === null) ? "" : arr[i].Output;
    var End = ""
        +"<th class=\"Selector SelectorID \"> " + Id + " </th>"
        +"<th class=\"Selector SelectorIP \"> " + Ip + " </th>"
        +"<th class=\"Selector SelectorUPDATED \"> " + LastUpdated + " </th>"
        +"<th class=\"Selector SelectorRUNNING "+RunningClass+"\"> " + Running + " </th>"
        +"<th class=\"Selector SelectorDONE "+DoneClass+"\"> " + Done + " </th>"
        +"<th class=\"Selector SelectorCOMMAND \"> " + Command + " </th>"
        +"<th class=\"Selector SelectorOUTPUT \"> " + Output + " </th>"
    ;
    return End;
}
//End of the part (Add styles to inform of an new update)
function DoneSelector(Element, UniID){
    $(Element).attr("UniID", UniID);
    if(GetCookie("ShowOpacity") === "true"){ return true; }
    $(Element).attr("style", "background-color: red;");
    $(Element).addClass("Waiting");
    if(GetCookie("AutoRemoveOpacity") === "true"){
        setTimeout(function() {
            WaitingEnter(Element);
        }, 500);
    }
}

//Instant update button clicked
function ClickCheckUpdate(){
    $("#RefreshTime").text(CheckTime);
    $("#Clickable").animate({
        color: 'red',
        opacity: '0.5'
    }, 500).attr("style", "");
    return CheckUpdate();
}

//Check for the actual update
function CheckUpdate(){
    var UniID, Element, Id, i;
    $.get("Remote.php?Update=1", function(data, status){
        $(InfoID).html(data);
        if(data === "ty"){ return false; }
        var arr = JSON.parse(data);
        for(i = 0; i < arr.length; i++) {
            UniID = arr[i].UniID;
            Id = arr[i].ID;
            Element = "#SelectorID" + Id;
            if ($(Element).text().toString() === ""){
                console.log("Creating & Updating: " + Element );
                $("#SelectorTable").prepend("<tr class=\"Selector\" uniid=\""+UniID+"\" id=\"SelectorID"+ Id +"\">" );
                $(Element).html(CreateSelector(arr, i) );
                DoneSelector(Element, UniID);
                $(".Waiting").mouseenter(function(){
                    WaitingEnter(this);
                });
            }else if (($(Element).attr("UniID").toString() !== UniID) && $(Element).attr("UniID").toString() !== ""){
                console.log("Updating: " + Element );
                $(Element).html(CreateSelector(arr, i));
                DoneSelector(Element, UniID);
            }
        }
        
    });
    
}

function WaitingEnter(elmt){
    $(elmt).removeClass("Waiting");
    $(elmt).animate({opacity: '1'}, 150).attr("style", "");
}

function ChangeAutoOpactity(){
    var ShowChecked = document.getElementById('ShowOpacity').checked;
    if(ShowChecked === true){ 
        SetCookie("AutoRemoveOpacity", ShowChecked);
        $("#ShowOpacityMAIN").slideUp(200, function(){
            $("#ShowOpacityMAIN").animate({display: "block"}, 200, function(){
                $("#ShowOpacityMAIN").slideDown(100);
            });
        });
        document.getElementById('AutomaticOpacityRemover').checked = ShowChecked;
        return false; 
    }
    SetCookie("AutoRemoveOpacity", document.getElementById('AutomaticOpacityRemover').checked);
}
function ChangeShowOpactity(){
    var ShowChecked = document.getElementById('ShowOpacity').checked;
    document.getElementById('AutomaticOpacityRemover').checked = ShowChecked;
    SetCookie("AutoRemoveOpacity", ShowChecked);
    SetCookie("ShowOpacity", ShowChecked);
}