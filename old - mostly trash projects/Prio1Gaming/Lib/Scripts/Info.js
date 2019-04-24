/////////////
// Info.php functions
/////////////




/////////////////////////////
//  Misc
////////////////////////////


function Switch(Page, ID){
    ShowInfo();
    $(InfoID).load(Page);

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
///////////////////////
//      Add new Tekst
//////////////////////
function CreateNewInfo(){
    var Page = "Info.php?Create=1";
    $(InfoID).load(Page);
    ShowInfo();
    setTimeout(function() {
        window.location = window.location;
    }, 750);
    return true;
}


/////////////////////////////
//   Set Description functions
////////////////////////////

//Input Enter press event
function KeyDown(elmt, event){
    var Key = event.key;
    ///alert(Key);
    if(Key === "Enter"){
        $(elmt).blur();
    }else if(Key === "Escape"){
        $(elmt).val($(elmt).attr("OriginalValue"));
    }
}
function ChangeTekst(elmt, Page){
    ShowInfo();
    var val = elmt.value.replace(/ /g, "%20");
    var URL = Page +"&Value="+ val;
    console.log(URL);
    $(InfoID).load(URL);
    return true;
}


/////////////////////////////
// Remove file
///////////////////////////

//Ask Yes No Question
function Remove(Page, MyID){
    YesNoQ("Weet je zeker dat je dit wilt verwijderen?", "RemoveAgree('"+Page+"', '"+MyID+"'); $(\"YesNo\").slideUp(500);", "$(\"YesNo\").slideUp(500)");
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