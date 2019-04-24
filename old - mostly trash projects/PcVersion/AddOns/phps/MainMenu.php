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
    GotoURL();
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
                    
                    <a id="HeaderButton1" class="Headerbutton" >Profile></a>
                        <div id="HeaderButton1Content" class="DropdownMenuContent">
                            <a onclick="GoToMyID('#/Profile/SelectProfile')" href="#/Profile/SelectProfile" class="ContentButtons">Profile</a>
                        </div>
                    <br>
                    <br>
                    <a id="HeaderButton2" class="Headerbutton" >Minecraft></a> 
                        <div id="HeaderButton2Content" class="DropdownMenuContent">
                            <p id="Header2SubButton2Content" class="ContentButtons">Dead Servers></p>
                            <p id="Header2SubButton3Content" class="ContentButtons">Plugins></p>
                        </div>
                                <!-- SubButton -->
                                <div id="Header2SubButton2ContentShow" class="DropdownMenuContentSub">
                                        <a id="HeaderSub1Button1" onclick="GoToMyID('#/Server/FrostCraft')" href="#/Server/FrostCraft" class="ContentButtons">FrostCraft</a>
                                        <a id="HeaderSub1Button2" onclick="GoToMyID('#/Server/Binkcraft')" href="#/Server/Binkcraft" class="ContentButtons">Binkcraft</a>
                                </div>
                    
                                <!-- SubButton -->
                                <div id="Header2SubButton3ContentShow" class="DropdownMenuContentSub">
                                        <a id="HeaderSub2Button1" onclick="GoToMyID('#/Plugins/Bungeecord')" href="#/Plugins/Bungeecord" class="ContentButtons">Bungeecord</a>
                                        <a id="HeaderSub2Button2" onclick="GoToMyID('#/Plugins/Spigot')" href="#/Plugins/Spigot" class="ContentButtons">Spigot</a>
                                        <a id="HeaderSub2Button3" onclick="GoToMyID('#/Plugins/Texturepacks')" href="#/Plugins/Texturepacks" class="ContentButtons">Texturepacks</a>
                                </div>
                    <br>
                    <br>
                    <a id="HeaderButton3" class="Headerbutton" >Test ></a> 
                        <div id="HeaderButton3Content" class="DropdownMenuContent">
                            <a id="HeaderButton" href="#/31231321/31231231231" onclick="GoToMyID('#/31231321/31231231231')" class="ContentButtons">#Test</a>
                            <a id="HeaderButton" href="#about" onclick="GoToMyID('#/Server/FrostCraft')" class="ContentButtons">About</a>
                            <a id="HeaderButton" href="#contact" onclick="GoToMyID('#/Server/FrostCraft')" class="ContentButtons">Contact</a>
                        </div>
                    <br>
                    <br>
                    <a id="HeaderButton4" class="Headerbutton" >Personal></a> 
                        <div id="HeaderButton4Content" class="DropdownMenuContent">
                            <a id="HeaderButton" onclick="GoToMyID('#/Personal/PWDB')" href="#/Personal/PWDB" class="ContentButtons">PWDB</a>
                            <a id="HeaderButton" onclick="GoToMyID('#/Personal/ideas')" href="#/Personal/ideas" class="ContentButtons">ideas</a>
                        </div>
                    <br>
                    <br>
                    <a id="LittleProjects" onclick="GoToMyID('#/LittleProjects/Menu')" href="#/LittleProjects/Menu" class="Headerbutton">LittleProjects</a> 
                </div>
            </div>