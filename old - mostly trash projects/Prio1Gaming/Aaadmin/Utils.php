<?php

class Utils{
    // Function to get the client IP address
    function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])){
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        }else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else if(isset($_SERVER['HTTP_X_FORWARDED'])){
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        }else if(isset($_SERVER['HTTP_FORWARDED_FOR'])){
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        }else if(isset($_SERVER['HTTP_FORWARDED'])){
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        }else if(isset($_SERVER['REMOTE_ADDR'])){
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        }else{
            $ipaddress = 'UNKNOWN';
        }
        return $ipaddress;
    }
    
    function FormatString($String){
        if($String == ""){ return null; }
        $config = include 'Config.php';
        $mysqli = new mysqli($config->DBIp, $config->username, $config->pass, $config->database);
        if (mysqli_connect_errno()) {
            die(printf("Connect failed: %s\n", mysqli_connect_error()));
        }
        $String1 = $mysqli->real_escape_string($String);
        $String2 = htmlspecialchars($String1);
        try { $String3 = sprintf($String2);
        }catch(Exception $e) { return $String2; }
        /*
        if(!get_magic_quotes_gpc(){
            $String4 = addslashes($String3);
            return $String4;
        }
         */
        return $String3;
    }
    
    #Function to update/set a cookie
    function SetCookie($Name, $Value){
        setcookie($Name, $Value, time() + (86400 * 90), "/"); // 86400 = 1 day
        return true;
    }
    
    public static $connect;
    public static $config;
    public static $Style = "";
    
    #Connect to DB and do some stuff
    function LoadDB(){
        error_reporting(E_ALL & ~E_WARNING);
        Utils::$config = include 'Config.php';
        Utils::$connect = mysqli_connect(Utils::$config->DBIp, Utils::$config->username, Utils::$config->pass) or die('Couldn\'t Connect' . mysqli_error(Utils::$connect));
        mysqli_select_db(Utils::$connect, Utils::$config->database) or die("Couldn't Find your database !");
        
        if(isset($_COOKIE['Style'])){ Utils::$Style = $_COOKIE['Style']; }
    }
    
    #Thing to do at every frontend page
    function ConnectCheck(){
        //error_reporting(E_ALL);
        //error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
        //error_reporting(E_ALL & ~E_WARNING);
        $this->LoadDB();
        $this->NavigationBar();
    }
    
    #Check if exists and than echo
    function CSSCheckAndImport($filename){
        if (file_exists($filename)) {
            echo '<link href="'.$filename.'" rel="stylesheet" type="text/css" />';
            return true;
        }
        return false;
    }
    #Check if exists and than echo
    function JSCheckAndImport($filename){
        if (file_exists($filename)) {
            echo '<script src="'.$filename.'"></script>';
            return true;
        }
        return false;
    }
    
    #Import of all the JS and CSS
    function JSandCSSimport(){
        $RequestURL = strtolower($_SERVER['REQUEST_URI']);
        ?> 
        <!-- Fallback Styles -->
        <link href="Lib/Styles/Default/Default.css" rel="stylesheet" type="text/css" /> 
        <?php
        if(strpos($RequestURL, 'download') !== false){ $this->CSSCheckAndImport("Lib/Styles/Default/Downloads.css"); }
        if(strpos($RequestURL, 'remote') !== false){ $this->CSSCheckAndImport("Lib/Styles/Default/RemoteControl.css"); }
        if(strpos($RequestURL, 'sslog') !== false){ $this->CSSCheckAndImport("Lib/Styles/Default/ScreenShots.css"); }
        if(strpos($RequestURL, 'chat') !== false){ $this->CSSCheckAndImport("Lib/Styles/Default/Chat.css"); }
        
        //Custom Style Imports
        if(Utils::$Style != "" && Utils::$Style != "Default"){
            ?> 
            <!-- Styles for: <?php echo Utils::$Style; ?> -->
            <?php
            $this->CSSCheckAndImport("Lib/Styles/".Utils::$Style."/Default.css");
            if(strpos($RequestURL, 'download') !== false){ $this->CSSCheckAndImport("Lib/Styles/".Utils::$Style."/Downloads.css"); }
            if(strpos($RequestURL, 'remote') !== false){ $this->CSSCheckAndImport("Lib/Styles/".Utils::$Style."/RemoteControl.css"); }
            if(strpos($RequestURL, 'sslog') !== false){ $this->CSSCheckAndImport("Lib/Styles/".Utils::$Style."/ScreenShots.css"); }
            if(strpos($RequestURL, 'chat') !== false){ $this->CSSCheckAndImport("Lib/Styles/".Utils::$Style."/Chat.css"); }
            
        }   
        ?>

        <!-- JavaScript -->
        <script src="Lib/Scripts/Default/docReady.js"></script>

        <?php 
        if(strpos($RequestURL, 'download') !== false){ $this->JSCheckAndImport("Lib/Scripts/Default/Download.js"); }
        if(strpos($RequestURL, 'remote') !== false){ $this->JSCheckAndImport("Lib/Scripts/Default/RemoteLog.js"); }
        if(strpos($RequestURL, 'sslog') !== false){ $this->JSCheckAndImport("Lib/Scripts/Default/ScreenShots.js"); }
        if(strpos($RequestURL, 'chat') !== false){ $this->JSCheckAndImport("Lib/Scripts/Default/Chat.js"); }


        if(Utils::$Style != "Default"){ ?> 
            <!-- JavaScript for: <?php echo Utils::$Style; ?> -->
            <?php 
            $this->JSCheckAndImport("Lib/Scripts/".Utils::$Style."/".Utils::$Style.".js");
        }
    }
    
    #Function to close the bode and create the footer
    function LastLoad(){
        ?>
        <!-- Close Content -->
            </center>
            </main>
            <!-- Reduce Loadingtime So script is at the end -->
            <?php $this->JSandCSSimport(); ?>
            <!-- Footer Script -->
            <script title="Footer Script">
                $(document).ready(function(){
                    $("footerWait").hover(function(){ $("footer").slideDown(255); });
                    $("footer").mouseleave(function(){ $("footer").slideUp(255); });
                });
            </script>
            <!-- Footer -->
            <footer>
                This site is custom written by onno204.<br>
                For questions send me a message: <a href="mailto:webmaster@onno204.nl.eu.org">webmaster@onno204.nl.eu.org</a>, <a href="skype:onnovanh?add">skype:onnovanh</a><br>
                This site was made for a custom program.<br>
                The Program is a remote control program<br>
                <i>(No people where harmed during the creation)</i>
            </footer>
            <footerWait>☛ 2017-20<?php echo date("y"); ?>©Onno204 Site - Custom Build - <a href="skype:onnovanh?add">Skype: onnovanh</a> - Created for a Remote Control program©2017-20<?php echo date("y"); ?> ☚ </footerWait>
            <!-- END Footer -->
        <!-- Close Body -->
        </body>
        <?php
    }
    
    function NavigationBar(){
        ?>
    <head>
        <!-- Top Info -->
        <title>Remote control site</title>
        <link rel="icon" href="Lib/Pictures/Smileys/100x100.png" type="image/x-icon">
        
        <!-- Search Engine info -->
        <meta charset="UTF-8" />
        <meta name="keywords" content="Remote,Control,externalmanagement,hack,Loginrequired" />
        <meta name="description" content="Remote control program custom written and created" />
        <meta name="author" content="onno204" />
        <base href="127.0.0.1" target="" />
        <style>
            /* Loading Overlay */
            LoadingPage{
                z-index: 99999999;
                background-color: rgba(25,25,25,0.4);
                position: fixed;
                top: 0px;
                left: 0px;
                text-align: center;
                height: 100vh;
                width: 100vw;
            }
            .BlackRound{
                border-radius: 50%;
                border-width: 20px;
                border-style: dotted;
                border-color: rgba(120, 120, 120, 1) rgba(120, 120, 120, 0.7) rgba(120, 120, 120, 0.5) rgba(120, 120, 120, 0.3);
                padding: 40px;
                height: 200px;
                width: 200px;
                position: absolute;
                top: 39%;
                left: 41%;
                -webkit-animation: spin 2s linear infinite;
                animation: spin 2s linear infinite;
            }
            @-webkit-keyframes spin {
              0% { -webkit-transform: rotate(0deg); }
              100% { -webkit-transform: rotate(360deg); }
            }

            @keyframes spin {
              0% { transform: rotate(0deg); }
              100% { transform: rotate(360deg); }
            }

        </style>
        <!-- ONLY the necesary Default, More is at the bottom! -->
        <script src="Lib/Scripts/Default/JQuery.js"></script>
        <script src="Lib/Scripts/Default/DefineValues.js"></script>
        <script src="Lib/Scripts/Default/Default.js"></script>
    </head>

    <body id="body">
        <!-- Loading Page -->
        <LoadingPage onclick='SlideDown()'>
            <div class="BlackRound"> Click to skip</div>
        </LoadingPage>
        <!-- Yes or No Question -->
        <YesNo>
            <div class="YesNoText" id="YesNoText"> I wasn't set Right. </div>
            <div class="YesNoYes Button" id="YesNoYes"> Yes </div>
            <div class="YesNoNo Button" id="YesNoNo"> No </div>
        </YesNo>
        <!-- Overlay for random text -->
        <Overlay>Text</Overlay>
        <!-- Blue infobox at the bottom -->
        <output onclick="$(InfoID).slideUp(500);">Text</output>
        <!-- Navigation bar -->
        <nav>
            <img title="Custom made by onno204" onclick="$('footer').slideDown(255);" class="NavPic" id="NavPic" src="Lib/Pictures/Smileys/100x100.png" />
            <ThemeList>
                Theme: 
                <select onchange="SelectTheme(this)">
                    <option value="RESET">Reset</option>
                    <option value="EMPTYSTRING" disabled>==================</option>
                    <option value="Default" <?php echo (Utils::$Style == "Default") ? 'selected' : ''; ?>>Default</option>
                    <option value="Tablet" <?php echo (Utils::$Style == "Tablet") ? 'selected' : ''; ?>>Tablet Modus</option>
                    <option value="Phone" <?php echo (Utils::$Style == "Phone") ? 'selected' : ''; ?>>Phone Modus</option>
                    <option value="Dark" <?php echo (Utils::$Style == "Dark") ? 'selected' : ''; ?>>Dark</option>
                    <option value="Bright" <?php echo (Utils::$Style == "Bright") ? 'selected' : ''; ?>>Bright</option>
                    <option value="EMPTYSTRING" disabled>==================</option>
                    <option value="EMPTYSTRING" disabled>Background Styles</option>
                    <option value="EMPTYSTRING" disabled>==================</option>
                    <option value="BackgroundColor-Default">Color-Default</option>
                    <option value="BackgroundColor-White">Color-White</option>
                    <option value="BackgroundColor-Black">Color-Black</option>
                    <option value="BackgroundColor-Medium">Color-Medium</option>
                    <option value="EMPTYSTRING" disabled>==================</option>
                    <option value="Background-Default">Pic-Default</option>
                    <option value="Background-ColorExplode">Pic-Colors Explosion</option>
                    <option value="Background-DeadHacker">Pic-DeadHacker</option>
                    <option value="Background-Death">Pic-Death</option>
                    <option value="Background-DeathSkull">Pic-Skull</option>
                    <option value="Background-Derp">Pic-Derp</option>
                    <option value="Background-Grils">Pic-Siloet</option>
                    <option value="Background-HackerChinees">Pic-Gekke Chinees</option>
                    <option value="Background-HackerFail">Pic-Failed</option>
                    <option value="Background-HackerMatrix">Pic-Matrix</option>
                    <option value="Background-HackerWorld">Pic-WorldMap</option>
                    <option value="Background-Minions">Pic-Minions</option>
                    <option value="Background-NatureClouds">Pic-Clouds</option>
                    <option value="Background-NatureRailway">Pic-Railway</option>
                    <option value="Background-NatureRoad">Pic-Road</option>
                    <option value="Background-NatureWater">Pic-Water</option>
                    <option value="Background-Smileys">Pic-Smileys</option>
                    <option value="Background-SpaceMoon">Pic-The Moon</option>
                    <option value="Background-colors">Pic-Colors(dye)</option>
                </select>
            </ThemeList>
            <a href='Login'>Logout</a>
            <a href='/../' target="_top">Return to the Mainsite</a>
            <a href='download.php'>Download</a>
            <a href='RemoteFrontend.php?Log=1'>Log</a>
            <a href='RemoteFrontend.php?CmdLog=1'>RemoteContol</a>
            <a href='RemoteFrontend.php?SSLog=1'>ScreenShots</a>
            <a href='Chat.php?FrontEnd=1'>Chat</a>
        </nav>
        <!-- Content -->
        <main>
            <br>
            <br>
            <br>
            <center>
            <?php
    }
    
}
