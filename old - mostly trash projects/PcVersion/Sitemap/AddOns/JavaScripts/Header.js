
//Drop Down:
function HeaderButton1() { ClearMenus(); ClearSubMenus(); document.getElementById("HeaderButton1Content").classList.toggle("show"); }
function HeaderButton2() { ClearMenus(); ClearSubMenus(); document.getElementById("HeaderButton2Content").classList.toggle("show"); }
function HeaderButton3() { ClearMenus(); ClearSubMenus(); document.getElementById("HeaderButton3Content").classList.toggle("show"); }
function HeaderButton4() { ClearMenus(); ClearSubMenus(); document.getElementById("HeaderButton4Content").classList.toggle("show"); }


function HeaderSubButton1() { ClearSubMenus(); document.getElementById("HeaderSubButton1Content").classList.toggle("show"); }
function HeaderSubButton2() { ClearSubMenus(); document.getElementById("HeaderSubButton2Content").classList.toggle("show"); }

function Slide(id){
    var id = id.toString();
    document.getc;
}

function ClearSubMenus(){
    var dropdowns = document.getElementsByClassName("DropdownMenuContentSub");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) { openDropdown.classList.remove('show'); }
    }
}

function ClearMenus(){
    var dropdowns = document.getElementsByClassName("DropdownMenuContent");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) { openDropdown.classList.remove('show'); }
    }
}

function CheckMenus(){
    if (!event.target.matches('.Headerbutton')) { 
        if (!event.target.matches('.DropdownMenuContentSub')) { 
            ClearMenus();
            ClearSubMenus();
        }
    }
}

window.onclick = function(event) {
    if (!event.target.matches('.Headerbutton')) { 
        if (!event.target.matches('.DropdownMenuContentSub')) { 
            if (!event.target.matches('.DropdownMenuContent')) { 
                if (!event.target.matches('.ContentButtons')) { 
                    console.log(event.target);
                    ClearMenus();
                    ClearSubMenus();
                }
            }
        }
    }
};
