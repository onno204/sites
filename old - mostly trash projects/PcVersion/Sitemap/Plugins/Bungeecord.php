<?php
    $Plugin = $_GET['Plugin'];
    if($Plugin == ""){ $Plugin = "Index"; }
    
    if($Plugin == "PlayerData"){
    echo'
        <div class="SelectedContainer" style=" background-color: brown; ">
        <div class="PluginsTopper"> PlayerData </div>
        <div class="PluginsDiscription">
            <br>
            Playerdata is a Plugin for bungeecord made by "onno204".
            <br>
            <p class="PluginsSpecail">Commands: </p>
            /ghelp - main help command. type this for more help!
            <br>
            <br>
            /gban
            /gunban
            /gtempban
            /gbanlist
            /gbanip
            /gunbanip
            /gkick
            /gkickall
            /gmute
            /gunmute
            /gwhitelist
            /gtempmute
            /servermessage
            /getinfo
            /gtell
            /gtellmute
            /gtellspy
            /gserver
            /report
            /reportinfo
            /reportdone
            /reportlist
            /channal
        </div>
        <a class="PluginsDownload" onclick="PlayClick()" href="https://www.onno204.nl.eu.org/PcVersion/Plugins/Files/PlayerData.jar" target="_blank"> Download Playerdata! </a>
        </div>
    ';
    }else if($Plugin == "AutoUpdate"){
    echo'
        <div class="SelectedContainer" style=" background-color: brown; ">
        <div class="PluginsTopper"> AutoUpdate </div>
        <div class="PluginsDiscription">
            <br>
            AutoUpdate is a Plugin for bungeecord made by "onno204".
            <br>
            <p class="PluginsSpecail">Commands: </p>
            Dont instal it whitout asking onno204.
            mail: "onno204@onno204.nl.eu.org"
        </div>
        <a class="PluginsDownload" onclick="PlayClick()" href="https://www.onno204.nl.eu.org/PcVersion/Plugins/Files/AutoUpdate.jar" target="_blank"> Download Playerdata! </a>
        </div>
    ';
    }else{
    echo'
        <div class="SelectedContainer" style=" background-color: brown; ">
        <div class="PluginsTopper"> Bungeecord Plugins </div>
        <div class="PluginsDiscription">
            <br>
            This are my Bungeecord created plugins!
            <br>
            
        </div>
        <div class="PluginBlockHolder">
            <a class="PluginsButton" onclick="PlayClick()" href="https://www.onno204.nl.eu.org/PcVersion?Type=Plugins&Selected=Bungeecord&Plugin=PlayerData"> Download Playerdata! </a>
            <a class="PluginsButton" onclick="PlayClick()" href="https://www.onno204.nl.eu.org/PcVersion?Type=Plugins&Selected=Bungeecord&Plugin=AutoUpdate"> Download AutoUpdate! </a>
        </div>
        </div>
    ';
    }
    
    
    
    
    