/////////////
// Download.php functions
/////////////




/////////////////////////////
//  Misc
////////////////////////////


function load(Page, MyID){
    ShowInfo();
    $(InfoID).load(Page);
    ID = "#" + MyID;

    HasClass = $(ID).hasClass("green");
    if (HasClass) {
        $(ID).text("False");
        $(ID).addClass('red').removeClass('green');
    }else {
        $(ID).text("True");
        $(ID).removeClass('red').addClass('green');
    }
    $(ID).hide().fadeIn(750);
    return true;
}

/////////////////////////////
//   Set Description functions
////////////////////////////

//Input Enter press event
function KeyDown(elmt, event, Page){
    var Key = event.key;
    ///alert(Key);
    if(Key === "Enter"){
        $(elmt).blur();
    }else if(Key === "Escape"){
        $(elmt).val($(elmt).attr("OriginalValue"));
    }
}
function ChangeDescription(elmt, Page){
    ShowInfo();
    var val = elmt.value.replace(/ /g, "%20");
    var URL = Page + "&Description=" + val;
    console.log(URL);
    $(InfoID).load(URL);
    return true;
}


/////////////////////////////
// Remove file
///////////////////////////

//Ask Yes No Question
function Remove(Page, MyID){
    YesNoQ("Are you sure you want to Delete this file?", "RemoveAgree('"+Page+"', '"+MyID+"'); $(\"YesNo\").slideUp(500);", "$(\"YesNo\").slideUp(500)");
    return true;
}
//Agree To Yes No Question
function RemoveAgree(Page, MyID){
    ShowInfo();
    $(InfoID).load(Page);
    ID = "#" + MyID;
    $(ID).fadeOut(750);
    return true;
}