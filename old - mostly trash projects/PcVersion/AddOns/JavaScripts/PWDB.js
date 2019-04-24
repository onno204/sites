function randString(){
  id = document.getElementById("RandomPasswordInput");
  var dataSet = $(id).attr('data-character-set').split(',');  
  var possible = '';
  if($.inArray('a-z', dataSet) >= 0){
    possible += 'abcdefghijklmnopqrstuvwxyz';
  }
  if($.inArray('A-Z', dataSet) >= 0){
    possible += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  }
  if($.inArray('0-9', dataSet) >= 0){
    possible += '0123456789';
  }
  if($.inArray('#', dataSet) >= 0){
    possible += '![]{}()%&*$#^<>~@|';
  }
  var text = '';
  for(var i=0; i < $(id).attr('data-size'); i++) {
    text += possible.charAt(Math.floor(Math.random() * possible.length));
  }
  id.value = text;
  return text;
}
function OverlayLogin(){
    console.log("Checking...");
    User = document.getElementById("IdentifyerUsername").value;
    Password = document.getElementById("IdentifyerPassword").value;
    console.log(User + ":" + Password);
    if(User == "onno205"){
        if(Password == "Wachtwoorden"){
            console.log("true.");
            return true;
        }
    }
    console.log("checked...");
    return false;
}

function Allow(){
    document.cookie = "LogHolder=";
    $("#Identifyer").slideUp(2125);
}

function PopupWW(ww){ window.prompt("Copy the password:", ww); }

