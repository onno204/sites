
////////////////////
////// Misc functions
////////////////////

function test(){
    return "test123"
}

var InfoTime = 0;
function ShowMessage(Text, Time){
    $("output").text(Text);
    if(!Boolean(Time)){ Time = 2; }
    InfoTime = new Date().getSeconds();
    $("output").slideDown(500);
    setTimeout(function() {
        if((InfoTime === (new Date().getSeconds()-(Time))) || InfoTime === (new Date().getSeconds()-(1+Time))){ $("output").slideUp(500); }
    }, (Time * 1000));

}

//Set a cookie
function SetCookie(Key, Value){
    var d = new Date();
    d.setTime(d.getTime() + (90*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = Key+"="+Value+"; "+expires+"; path=/";
}

//Get a cookie from a string
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)===' ') c = c.substring(1);
        if (c.indexOf(name) === 0) return c.substring(name.length, c.length);
    }
    return "";
}

//Get a random number between x and y
function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}


////////////////////
//// Load/Save Functions
////////////////////
function load(){
    // Yes/No question
    var Confirm = confirm("Are you sure you want to override your current game?");
    if(Confirm !== true){ ShowMessage("loading cancelled", 2); return;}
    ShowMessage("Loading....", 2);
    var Val = $("#SaveName").val();
    var List = getCookie(Val).split(","); //Get the saved list in RAW data
    if(Val === "Reset"){ // If the value = Reset, reset the sudoku
        List = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
    }
    var id = "t1-1";//Start at the beginning with importing
    i = 0;
    for(var x = 1; x <= 9; x++){ // Loop trough all the rows
        id = setRow(id, x);
        for(var y = 1; y <= 9; y++){ //Loop trough all the collums
            id = setCollum(id, y);
            AddAsPossible(id, []);
            if(List[i] === "0" || List[i] === 0){
                setNumber(id, "");// If the numbers = 0, Make it empty
                ResetColor(id);
            }else{
                setNumber(id, List[i]); // Add the number to the item
                SetColor(id);
            }
            i++;
        }
    }
    CheckField();
    ShowMessage("Loaded "+$("#SaveName").val()+" succesfully!", 1);
}

//Save the current sudoku
function save(){
    // Yes/No question
    var Confirm = confirm("Are you sure you want to override your old save?");
    if(Confirm !== true){ ShowMessage("Save cancelled", 2); return;}
    ShowMessage("Saving...", 2);
    var Output = []; // Output List
    var id = "t1-1";//Start at the beginning
    for(var x = 1; x <= 9; x++){ //Loop trough all the rows
        id = setRow(id, x);
        for(var y = 1; y <= 9; y++){ //Loop trough all the collums
            id = setCollum(id, y);
            if(getNumber(id) !== ""){ // Cneck if the numbers is not empty
                Output.push(getNumber(id));
            }else{
                Output.push("0"); // Replace empty numbers with 0
            }
        }
    }
    SetCookie($("#SaveName").val(), Output);
    ShowMessage("Saved succesfully as "+$("#SaveName").val()+"!", 1);
}

//////////////////////////////
/////// Item Events
/////////////////////////////

//Show the info box with the possible numbers
function HoverInput(Elmt){
    $("info").fadeIn(10).text($(Elmt).attr("possible")).animate({left: $(Elmt).offset()["left"]-19,top: $(Elmt).offset()["top"]-48}, 50);
}

//Center the body in the page
function CenterScreen(){
    var Left = ($(window).width() - $("body").width()) / 2; // Calculate half of the white space
    var Top = ($(window).height() - $("body").height()) / 2; // Calculate half of the white space
    $("body").css({left: Left, top: Top});//Set it to the body
}
//Center the screen when the page is loaded
$(document).ready(function(){ CenterScreen(); });

//Max nine input
function OnFocus(Elmt){
    $(Elmt).attr("old", $(Elmt).val());
}
//Max nine input
function OnChange(Elmt){
    if($(Elmt).val() > 9){
        var val = $(Elmt).val();
        var length = val.length;
        $(Elmt).val(val.slice(length-1, length));
    }else{
        $(Elmt).attr("old", $(Elmt).val());
    }
}



////////////////////////////////////////
////// Calculate functions
////////////////////////////////////////

var OneToNine = ["1","2","3","4","5","6","7","8","9"];

//   Sudoku Layout
//   *|*|* Cage1 - Cage 3
//   *|*|* Cage4 - Cage 6
//   *|*|* Cage7 - Cage 9

//Upper layer
var Cage1 = ["t1-1", "t1-2", "t1-3", "t2-1", "t2-2", "t2-3", "t3-1", "t3-2", "t3-3"];
var Cage2 = ["t1-4", "t1-5", "t1-6", "t2-4", "t2-5", "t2-6", "t3-4", "t3-5", "t3-6"];
var Cage3 = ["t1-7", "t1-8", "t1-9", "t2-7", "t2-8", "t2-9", "t3-7", "t3-8", "t3-9"];
//Mid layer
var Cage4 = ["t4-1", "t4-2", "t4-3", "t5-1", "t5-2", "t5-3", "t6-1", "t6-2", "t6-3"];
var Cage5 = ["t4-4", "t4-5", "t4-6", "t5-4", "t5-5", "t5-6", "t6-4", "t6-5", "t6-6"];
var Cage6 = ["t4-7", "t4-8", "t4-9", "t5-7", "t5-8", "t5-9", "t6-7", "t6-8", "t6-9"];
//Bottom Layer
var Cage7 = ["t7-1", "t7-2", "t7-3", "t8-1", "t8-2", "t8-3", "t9-1", "t9-2", "t9-3"];
var Cage8 = ["t7-4", "t7-5", "t7-6", "t8-4", "t8-5", "t8-6", "t9-4", "t9-5", "t9-6"];
var Cage9 = ["t7-7", "t7-8", "t7-9", "t8-7", "t8-8", "t8-9", "t9-7", "t9-8", "t9-9"];


/////////////////////////////////
////////  Main
/////////////////////////////////

//Calculate the sudoku
function Execute(){
    ErrorDisplayed = false;
    if(!FieldNotEmpty()){
        ShowMessage("Your sudoku is already finished!", 6);
        return true;
    }
    var Starttime = (new Date()).getMilliseconds();
    var TotalMS = 0;
    //Check if we have to do it more than once
    var Looptimes = Number($(".LoopTimes").val());
    for(var i=0; i<= Looptimes; i++){
        var id = "t1-1";//Start at the beginning
        for(var x = 1; x <= 9; x++){
            id = setRow(id, x);//Set the row with incresed value
            for(var y = 1; y <= 9; y++){
                id = setCollum(id, y);//Set the Collum with incresed value
                CheckID(id);//Do the whole process for an ID
            }
        }
        id = "t1-1";//Start at the beginning
        for(var x = 1; x <= 9; x++){
            id = setRow(id, x);//Set the row with incresed value
            for(var y = 1; y <= 9; y++){
                id = setCollum(id, y);//Set the Collum with incresed value
                var imto = IAmTheOneCage(id);//Check with all the rows or collums
                if(imto > 0){
                    SetNumber(id, imto); // Set the good number as value 
                    AddAsPossible(id, [imto]);
                    SetColor(id);
                }
                imto = IAmTheOneRowOrCollum(id);//Check with all the rows or collums
                if(imto > 0){
                    SetNumber(id, imto); // Set the good number as value 
                    AddAsPossible(id, [imto]);
                    SetColor(id);
                }
            }
        }
        
        TotalMS =  (new Date()).getMilliseconds() - Starttime;
        if(!FieldNotEmpty()){
            CheckField();
            ShowMessage("Your sudoku has been finished! Took: " + TotalMS + "ms", 6);
            return true;
        }
    }
    CheckField();
    ShowMessage("The AI. failed to finish your sudoku! retry or help us a little bit! Took: " + TotalMS + "ms", 8);
    return false;
}

var Done = false;
function CheckField() {
    var TotalWidth = 81;
    var width = 100-((((TotalWidth-FieldNotAmount().length)) / TotalWidth)*100);
    var Currentwidth = (($(".Progress").css("width").replace("px", "")) / ($(".ProgressBarr").css("width").replace("px", "")) )*100;
    if(Currentwidth >= 100){ Currentwidth = 0; }
    if(Currentwidth >= width){ Currentwidth = 0; }
    var Count = Currentwidth.toFixed(0);
    var id = setInterval(frame, 20);
    function frame() {
        if (Count >= width) {
            clearInterval(id);
        } else {
            Count++; 
            $(".Progress").css({width: Count + '%'}, 0);
            $(".ProgressProcent").text(Count.toFixed(0) + '%');
        }
    }
    NumberAmount();
}

function NumberAmount(){
    var Field = FieldNotAmount();
    var Zero = 81 - Field.length;
    var One = 0;
    var Two = 0;
    var Three = 0;
    var Four = 0;
    var Five = 0;
    var Six = 0;
    var Seven = 0;
    var Aight = 0;
    var Nine = 0;
    for(var i=0; i < Field.length; i++){
        var Number = Field[i];
        if(Number === "1"){ One ++;
        }else if(Number === "2"){ Two ++;
        }else if(Number === "3"){ Three ++;
        }else if(Number === "4"){ Four ++;
        }else if(Number === "5"){ Five ++;
        }else if(Number === "6"){ Six ++;
        }else if(Number === "7"){ Seven ++;
        }else if(Number === "8"){ Aight ++;
        }else if(Number === "9"){ Nine ++;
        }
    }
    $("#N0").text(Zero);
    $("#N1").text(One);
    $("#N2").text(Two);
    $("#N3").text(Three);
    $("#N4").text(Four);
    $("#N5").text(Five);
    $("#N6").text(Six);
    $("#N7").text(Seven);
    $("#N8").text(Aight);
    $("#N9").text(Nine);
}

//Check and try to solve the number for an ID
function CheckID(id){
    $("." + id).css({background: ""});
    //Check from (Left-Right) / (Up-Down) & Compare results
    var nr = Number(getNumber(id));
    if(nr === 0){
        SetNumber(id, "");
        var RowNumbers = GetRowNumbers(id); // Get all the numbers in a row
        var CollumNumbers = GetCollumNumbers(id);// Get all the numbers in a collum
        var Notmatching1 = GetNotMatching(RowNumbers, OneToNine); // Get the NOT matching numbers in a row
        var Notmatching2 = GetNotMatching(CollumNumbers, OneToNine); // Get the NOT matching numbers in a collum
        var Matching1 = GetMatching(Notmatching1, Notmatching2); // Get the matches between the row and collum
        var CageNum = CheckCage(id); // Get all the numbers in the same cage
        var Matching2 = GetNotMatching(CageNum, OneToNine); // Change the numbers in the cage for the not existing ones
        
        var Matching3 = GetMatching(Matching2, Matching1); // Match the cage numbers to the Row/collum numbers
        CheckArr(id, Matching3); // Check if the array is allowed
        AddAsPossible(id, Matching3);//Set as Possible/Hover info
        
    }else{ // It's already set, We are not going to look if it's good
        AddAsPossible(id, [nr]);
    }
}

var ErrorDisplayed = false;
//Display Error message
function Error(id, args){
    SetNumber(id, "0");
    $("." + id).css({background: "darkred"});
    var msg = "Error(@"+id+"), " + args;
    if(ErrorDisplayed){ return true; } //Don't spam the user with 100 errors
    ErrorDisplayed = true;
    console.log(msg);
    alert(msg);
}

/////////////////////////////////
////////  Global methods
/////////////////////////////////

//Check if the field contains empty spaces
function FieldNotAmount(){
    var id = "t1-1";//Start at the beginning
    var numbers = [];
    for(var x = 1; x <= 9; x++){ //Loop trough all the rows
        id = setRow(id, x);
        for(var y = 1; y <= 9; y++){ //Loop trough all the collums
            id = setCollum(id, y);
            var num = getNumber(id);
            if(num !== ""){ // Cneck if the numbers is not empty
                numbers.push(num);
            }
        }
    }
    return numbers; //No empty space found!
}
//Check if the field contains empty spaces
function FieldNotEmpty(){
    var id = "t1-1";//Start at the beginning
    for(var x = 1; x <= 9; x++){ //Loop trough all the rows
        id = setRow(id, x);
        for(var y = 1; y <= 9; y++){ //Loop trough all the collums
            id = setCollum(id, y);
            if(getNumber(id) === ""){ // Cneck if the numbers is not empty
                return true;
            }
        }
    }
    return false; //No empty space found!
}

//Check if the array is allowed to be a number
function CheckArr(id, matchlist){
    if(matchlist.length === 1){ // Found the one
        if(matchlist[0] === "0"){ Error(id, "The only match was 0"); }
        SetNumber(id, matchlist[0]); // Set the good number as value 
        return true;
    }else if(matchlist.length === 0){ //Error, no matches
        Error(id, "No matches found!");
        return false;
    }
}

//Get all the numbers from an list of ID's
function GetNumbersFromIdList(List){
    var numbers = []; // Create an array
    for(var i=0; i< List.length; i++){ // Loop trough all the items
        if(getNumber(List[i]) > 0){ // If higher than 0, add them
            numbers.push(getNumber(List[i]));
        }
    }
    return numbers;
}

//Get all the possible from an list of ID's
function GetPossibleFromIdList(List, IgnoreID){
    var numbers = []; // Create an array
    for(var i=0; i< List.length; i++){ // Loop trough all the items
        if(List[i] === IgnoreID){ continue; }
        var PosibleN = Possible(List[i]);
        if(PosibleN.length <= 0){ continue; }
        for(var x=0; x<PosibleN.length; x++){
            var N = PosibleN[x];
            if(N !== ""){
                numbers.push(N); // Add them
            }
        }
    }
    return numbers;
}

//Get the value's that NOT match in 2 lists
function GetNotMatching(List1, List2){
    //Starting
    var NotMatching = [];
    var Matching = [];
    var L1 = [];
    var L2 = [];
    //Make sure we search in the longest array
    if(List1.length >= List2.length){ L1 = List1; L2 = List2;
    }else{ L1 = List2; L2 = List1; }
    
    var i = 0;
    for	(i = 0; i < L1.length; i++) { //Loop trough the items
        //   If list contains
        if(L2.indexOf(L1[i]) >= 0){ Matching.push(L1[i]);
        }else{ NotMatching.push(L1[i]);
        }
    }
    return NotMatching;
}

//Get the matches in 2 lists
function GetMatching(List1, List2){
    //Starting
    var NotMatching = [];
    var Matching = [];
    var L1 = [];
    var L2 = [];
    //Make sure we search in the longest array
    if(List1.length >= List2.length){ L1 = List1; L2 = List2;
    }else{ L1 = List2; L2 = List1; }
    
    var i = 0;
    for	(i = 0; i < L1.length; i++) { //Loop trough the items
        //   If list contains
        if(L2.indexOf(L1[i]) >= 0){ Matching.push(L1[i]);
        }else{ NotMatching.push(L1[i]);
        }
    }
    return Matching;
}

///////////
// Short Functions
///////////

//Get the last set possible numbers
function Possible(id){ return arr = $("." + id).attr("possible").split(","); }
//Get the row/collum from an id
function getCollum(id){ return id.replace("t", "").split("-")[1]; }
function getRow(id){ return id.replace("t", "").split("-")[0]; }
//Returns the new id with new row/collum
function setCollum(id, newcollum){ return "t" + getRow(id) + "-" + newcollum; }
function setRow(id, newrow){ return "t" + newrow + "-" + getCollum(id); }
//Get/set the number from an id
function getNumber(id){ return $("." + id).val(); }
function setNumber(id, val){ return $("." + id).val(val); }
//Set the possible numbers
function AddAsPossible(id, list){ $("." + id).attr("possible", list.join(",")); }
//Set the number
function SetNumber(id, Number){ ;$("." + id).val(Number); }
//Set green color
function SetColor(id){ $("." + id).css("background-color", "green"); }
//Set red color
function ResetColor(id){ $("." + id).css("background-color", "red"); }


/////////////////////////////////
////////  Calculate row/collum numbers
/////////////////////////////////

//Check if he's the only possible number in the row and collum
function IAmTheOneRowOrCollum(id){
    var List1 = GetPossibleFromIdList(GetRowID(id), id); //Get possible from the row
    var p = Possible(id); // List the own possible
    for(var x=0; x < p.length; x++){
        if(List1.indexOf(p[x]) < 0){ // If the list does NOT contain the number, YEAY we found it
            return p[x];
        }
    }
    var List2 = GetPossibleFromIdList(GetCollumID(id), id); //Get possible from the collum
    for(x=0; x < p.length; x++){
        if(List2.indexOf(p[x]) < 0){ // If the list does NOT contain the number, YEAY we found it
            return p[x];
        }
    }
    return 0; // Return 0 when not found
}


//Get al the numbers in a row
function GetRowNumbers(id){
    var numbers = []; //To store all the value's
    var id = id;
    for(var i = 1; i <= 9; i++){ //Loop to increes the collum
        id = setCollum(id, i);
        if(getNumber(id) !== ""){ // If value != 0 add it
            numbers.push(getNumber(id));
        }
    }
    return numbers;
}
//Get al the numbers in a Collum
function GetCollumNumbers(id){
    var numbers = []; //To store all the value's
    var id = id;
    for(var i = 1; i <= 9; i++){ //Loop to increes the collum
        id = setRow(id, i);
        if(getNumber(id) !== ""){ // If value != 0 add it
            numbers.push(getNumber(id));
        }
    }
    return numbers;
}
//Get al the numbers in a row
function GetRowID(id){
    var numbers = []; //To store all the value's
    var id = id;
    for(var i = 1; i <= 9; i++){ //Loop to increes the collum
        id = setCollum(id, i);
        numbers.push(id);
    }
    return numbers;
}
//Get al the numbers in a Collum
function GetCollumID(id){
    var numbers = []; //To store all the value's
    var id = id;
    for(var i = 1; i <= 9; i++){ //Loop to increes the collum
        id = setRow(id, i);
        numbers.push(id);
    }
    return numbers;
}

/////////////////////////////////
////////  Cage Methods
/////////////////////////////////


//Check if he's the only possible number in the cage
function IAmTheOneCage(id){
    var List1 = GetPossibleFromIdList(GetCageList(id), id); //Get possible from the row
    var p = Possible(id); // List the own possible
    for(var x=0; x < p.length; x++){
        if(List1.indexOf(p[x]) < 0){ // If the list does NOT contain the number, YEAY we found it
            return p[x];
        }
    }
    return 0; // Return 0 when not found
}

function GetCageList(id){
    var Cage = []; // Create the cage
    //Check whitch cage contains the item and add's it to the cage
          if(Cage1.indexOf(id) >= 0){ Cage = Cage1; 
    }else if(Cage2.indexOf(id) >= 0){ Cage = Cage2; 
    }else if(Cage3.indexOf(id) >= 0){ Cage = Cage3; 
    }else if(Cage4.indexOf(id) >= 0){ Cage = Cage4; 
    }else if(Cage5.indexOf(id) >= 0){ Cage = Cage5; 
    }else if(Cage6.indexOf(id) >= 0){ Cage = Cage6; 
    }else if(Cage7.indexOf(id) >= 0){ Cage = Cage7; 
    }else if(Cage8.indexOf(id) >= 0){ Cage = Cage8; 
    }else if(Cage9.indexOf(id) >= 0){ Cage = Cage9; 
    }
    return Cage;
}

//Get the cage where the id is in and execute the next function
function CheckCage(id){
    var Cage = GetCageList(id);
    var numbers = GetNumbersFromIdList(Cage);//Get all the numbers in the cage
    return numbers;
}

