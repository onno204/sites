

//Stuff to do when the page is loaded
var PageVisable = true;
var Commands = [
    {
        command: "deur",
        args: "1",
        Keys: "S-A-CONTROL"
    },
    {
        command: "bel",
        args: "06 12 34 56 78",
        Keys: "A-BA-D-GAS"
    }
];
var AllCommands = ['Deur','Vergrendel','ontgrendel','bel','animatie'];
function AddCommand(command){
    if(AllCommands.includes(command.toLowerCase()) === false){
        AllCommands.push(command.toLowerCase());
        AllCommands.sort();
    }
}
var AllCommandsStr = "";
function CreateAllCommands(selectedStr) {
    AllCommandsStr="<select class=\"PossibleCommands\">";
    AllCommands.forEach(function (value, index, array) {
        AllCommandsStr+= "<option value=\""+value+"\" "+(value.toLowerCase()===selectedStr.toLowerCase()? "selected" : "")+">"+value+"</option>"; 
    });
    AllCommandsStr +="</select>";
}
function resetCommands(){
    var EndString = '<div class="options"><label onclick="nieuwCommand()">nieuw</label><label onclick="saveCommands()">Save</label><label onclick="resetCommands()">Reset</label><label onclick="hide()">Close</label></div>';
    Commands.forEach(function (value, index, array) {
        CreateAllCommands(value.command);
        EndString += "<div class=\"inputcontainer\">";
        EndString+="<label class=\"KeyCommand\">"+value.Keys+"</label>";
        EndString+=AllCommandsStr;
        EndString+="<input class=\"InputCommandArgs\" placeholder=\"argumenten\" type=\"text\" value=\""+value.args+"\">";
        EndString+="<legend class=\"RemoveInput\">x</legend>"
        EndString+="</div>";
    });
    $(".boxcontainer").html(EndString);
    SetupEvents();
}
function saveCommands(){
    Commands = [];
    $('.inputcontainer').each(function(i) { 
        Commands.push({
            command: $(this).children('select').val(),
            args: $(this).children('input').val(),
            Keys: $(this).children('label').html()
        });
    });
}
function nieuwCommand(){
    CreateAllCommands("");
    $('.boxcontainer').append("<div class=\"inputcontainer\"><label class=\"KeyCommand\">Not set</label>"+AllCommandsStr+"<!----><input class=\"InputCommandArgs\" placeholder=\"argumenten\" type=\"text\" value=\"\"><legend class=\"RemoveInput\">x</legend></div>");
    SetupEvents();
}
var inputElemtn = undefined;
function SetupEvents(){
    $(".InputCommandArgs").focus(function(e) {
        $(this).prev().addClass("CmdFocus");
        $(this).addClass("CmdFocus");
    });
    $(".InputCommandArgs").blur(function(e) {
        $(this).prev().removeClass("CmdFocus");
        $(this).removeClass("CmdFocus");
    });
    $(".InputCommandArgs").hover(function(e) {
        if(e.type === "mouseenter"){
            $(this).prev().addClass("CmdHover");
            $(this).addClass("CmdHover");
        }else if(e.type === "mouseleave"){
            $(this).prev().removeClass("CmdHover");
            $(this).removeClass("CmdHover");
        }
    });
    $(".PossibleCommands").focus(function(e) {
        $(this).next().addClass("CmdFocus");
        $(this).addClass("CmdFocus");
    });
    $(".PossibleCommands").blur(function(e) {
        $(this).next().removeClass("CmdFocus");
        $(this).removeClass("CmdFocus");
    });
    $(".PossibleCommands").hover(function(e) {
        if(e.type === "mouseenter"){
            $(this).next().addClass("CmdHover");
            $(this).addClass("CmdHover");
        }else if(e.type === "mouseleave"){
            $(this).next().removeClass("CmdHover");
            $(this).removeClass("CmdHover");
        }
    });
    $(".KeyCommand").click(function(e){
        e.stopPropagation();
        if(inputElemtn !== undefined){
            e.preventDefault();
            $(inputElemtn).removeClass("CmdFocus");
            inputElemtn = undefined;
        }
        $(this).addClass("CmdFocus");
        inputElemtn = this;
    });
    $(".KeyCommand").hover(function(e){
        if(e.type === "mouseenter"){
            $(this).addClass("CmdHover");
        }else if(e.type === "mouseleave"){
            $(this).removeClass("CmdHover");
        }
    });
    $(".RemoveInput").click(function(e){
        $(this).parent().remove();
    });
}


function show(){
    $("body").fadeIn();
    PageVisable = true;
}
function hide(){
    $("body").fadeOut();
    PageVisable = false;
}
$(document).ready(function(){
    hide();
    show();
    resetCommands();
    
    var map = {};
    $(document).keydown(function(e) {
        map[e.keyCode] = e;
        KeyPress(e);
    }).keyup(function(e) {
        map[e.keyCode] = false;
    });
    
    function KeyPress(e) {
        //var evtobj = window.event? event : e;
        var Output = "";//(evtobj.key.length<=2 || evtobj.key.substr(0,1)==="F") ? evtobj.key.toUpperCase() : "";
        for (var e1 in map){
            Output = (e1!==false)&&(map[e1].key !== undefined) ? RemoveAccents(map[e1].key).toUpperCase()+"-"+Output : Output;
        };
        //Output = (evtobj.ctrlKey===true) ? "Ctrl-"+Output : Output;
        //Output = (evtobj.altKey===true) ? "Alt-"+Output : Output;
        //Output = (evtobj.shiftKey===true) ? "Shift-"+Output : Output;
        if(Output.substr(Output.length - 1)==="-"){ Output = Output.substr(0, Output.length - 1); }
        HandleKeyPress(Output, e);
    }
    
    function HandleKeyPress(Output, e){
        if (inputElemtn !== undefined){
            $(inputElemtn).html(Output);
            e.preventDefault();
        }else if(PageVisable === false){
            CheckKeysMatchCommand(Output);
        }
    }
    function CheckKeysMatchCommand(keys) {
        Commands.forEach(function(value, index, array) {
            if(value.Keys === keys){
                console.log(value);
            }
        });
    }
    
    function RemoveAccents(str) {
        var accents    = 'ÀÁÂÃÄÅàáâãäåÒÓÔÕÕÖØòóôõöøÈÉÊËèéêëðÇçÐÌÍÎÏìíîïÙÚÛÜùúûüÑñŠšŸÿýŽž';
        var accentsOut = "AAAAAAaaaaaaOOOOOOOooooooEEEEeeeeeCcDIIIIiiiiUUUUuuuuNnSsYyyZz";
        str = str.split('');
        var strLen = str.length;
        var i, x;
        for (i = 0; i < strLen; i++) {
          if ((x = accents.indexOf(str[i])) !== -1) {
            str[i] = accentsOut[x];
          }
        }
        return str.join('');
    }
    //document.onkeydown = KeyPress;
    
    $(document).click(function(e) {
        if(inputElemtn !== undefined){
            e.preventDefault();
            $(inputElemtn).removeClass("CmdFocus");
            inputElemtn = undefined;
        }
    });
    SetupEvents();
    
    
    
});