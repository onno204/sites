<?php
    $Plugin = $_GET['Plugin'];
    if($Plugin == ""){ $Plugin = "Index"; }
    
    if($Plugin == "DispenserTrash"){
    echo'
        <div class="SelectedContainer" style=" background-color: brown; ">
        <div class="PluginsTopper"> DispenserTrash </div>
        <div class="PluginsDiscription">
            <br>
            DispenserTrash makes EVERY dispenser a Trashcan. Just place a dispenser.
            <br>
            <p class="PluginsSpecail">Commands: </p>
            NO commands made for this plugin. I am sorry!
        </div>
        <a class="PluginsDownload" onclick="PlayClick()" href="https://www.onno204.nl.eu.org/PcVersion/Plugins/Files/PlayerData.jar" target="_blank"> Download Playerdata! </a>
        </div>
    ';
    }else if($Plugin == "MinetopiaUpgrade"){
    echo'
        <div class="SelectedContainer" style=" background-color: brown; ">
        <div class="PluginsTopper"> MinetopiaUpgrade </div>
        <div class="PluginsDiscription">
            <br>
            MinetopiaUpgrade is a plugin made for Netherlands people, maybe later english.
            <br>
            <p class="PluginsSpecail">Commands: </p>
            /mu , main command
            /SetLvl
            /lvlup
            /checklevel
            /getlevelmoney
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
    
    
    
    
    