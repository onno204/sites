<?php ?>

<script>

$(document).ready(function(){
    $("#HeaderButton1").click(function(){
        ClearMenus123();
        $("#HeaderButton1Content").slideDown(300);
    });
    $("#HeaderButton2").click(function(){
        ClearMenus123();
        $("#HeaderButton2Content").slideDown(300);
    });
    $("#HeaderButton3").click(function(){
        ClearMenus123();
        $("#HeaderButton3Content").slideDown(300);
    });
    $("#HeaderButton4").click(function(){
        ClearMenus123();
        $("#HeaderButton4Content").slideDown(300);
    });
    
    $("#Header2SubButton2Content").click(function(){
        ClearSubMenus123();
        $("#Header2SubButton2ContentShow").slideDown(300);
    });
    $("#Header2SubButton3Content").click(function(){
        ClearSubMenus123();
        $("#Header2SubButton3ContentShow").slideDown(300);
    });
    
    $(".ContentButtons").click(function(){
        
    });
    
    $("#container").mouseup(function(e) {
        if( ($(e.target).attr('class') != "HeaderButton") && ($(e.target).attr('class') != "ContentButtons") && ($(e.target).attr('class') != "DropdownMenuContent") && ($(e.target).attr('class') != "DropdownMenuContentSub") ) { 
            ClearMenus123();
        }
    });
    GotoURL2();
});
</script>




<div class="HeaderHolder"> 
    <div id="Headernav" class="Headernav" >
                    <br>
                    <div class="Login">
                    <?php
                        if ($_SESSION['username'] == ""){
                            echo '
                            <a onclick="ToggleLogin()" class="LoginOrRegister">Login</a>
                            <a onclick="ToggleRegister()" class="LoginOrRegister LoginRecht">Register</a>
                            ';
                        }else{
                            echo '
                            <a href="?Type=Default&Selected=DumpSessions" class="LoginOrRegister"> Logout ' . $_SESSION['username'] . '  </a>
                        ';
                        }
                    ?>
                    </div>
                    <a class="Headertitle" href="https://www.onno204.nl.eu.org"><br>onno204</a>
                    
                    <a id="HeaderButton1" class="Headerbutton" >RealLands Ideeën ></a>
                        <div id="HeaderButton1Content" class="DropdownMenuContent">
                            <a onclick="GoToMyID('#/Mijnstad/List/')" href="#/Mijnstad/List/" class="ContentButtons">Mijnstad Ideeën</a>
                        </div>
                    <br>
                    <br>
                    <a onclick="GoToMyID('#/Commands/Staff/')" href="#/Commands/Staff/" class="Headerbutton">Staff Commands</a>
                    <br>
                    <br>
                    <a onclick="GoToMyID('#/Commands/Spelers/')" href="#/Commands/Spelers/" class="Headerbutton">Speler Commands</a>
                    <br>
                    <br>
                </div>
            </div>