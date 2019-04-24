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
    public static $Test = "testttttttttttt";
    
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
        <link href="Lib/Styles/Default.css" rel="stylesheet" type="text/css" /> 
        <?php
        if(strpos($RequestURL, 'info') !== false){ $this->CSSCheckAndImport("Lib/Styles/Info.css"); }
        if(strpos($RequestURL, 'remote') !== false){ $this->CSSCheckAndImport("Lib/Styles/RemoteControl.css"); }
        if(strpos($RequestURL, 'sslog') !== false){ $this->CSSCheckAndImport("Lib/Styles/ScreenShots.css"); }
        if(strpos($RequestURL, 'chat') !== false){ $this->CSSCheckAndImport("Lib/Styles/Chat.css"); }
        ?>

        <!-- JavaScript -->
        <script src="Lib/Scripts/docReady.js"></script>

        <?php 
        if(strpos($RequestURL, 'info') !== false){ $this->JSCheckAndImport("Lib/Scripts/Info.js"); }
        if(strpos($RequestURL, 'remote') !== false){ $this->JSCheckAndImport("Lib/Scripts/RemoteLog.js"); }
        if(strpos($RequestURL, 'sslog') !== false){ $this->JSCheckAndImport("Lib/Scripts/ScreenShots.js"); }
        if(strpos($RequestURL, 'chat') !== false){ $this->JSCheckAndImport("Lib/Scripts/Chat.js"); }
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
        <meta name="keywords" content="Prio1Gaming Prio1 FiveM GTAV Rollpaly Politie spelen" />
        <meta name="description" content="Prio1Gaming Website! FiveM Rollplay server! speel politie of een andere hulpdienst! Inclusief Discord! Met een Actieve spelers! " />
        <meta name="author" content="onno204" />
        <base href="prio1.onno204.nl.eu.org" target="" />
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
        <script src="Lib/Scripts/JQuery.js"></script>
        <script src="Lib/Scripts/DefineValues.js"></script>
        <script src="Lib/Scripts/Default.js"></script>
    </head>

    <body id="body">
        <!-- -->
        <!-- Overlays! -->
        <!-- -->
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
        <!-- -->
        <!-- END OF Overlays! -->
        <!-- -->
        <!-- Navigation bar -->
        <nav>
            <img title="Custom made by onno204" onclick="$('footer').slideDown(255);" class="NavPic" id="NavPic" src="Lib/Pictures/Logo/StreamLogo.php" />
            <div class="InfoLeftTop">
            <?php if(isset($_SESSION['username'])) {
                echo '<div class="Login">In gelogged als: '.$_SESSION['username'].'</div>'; 
                $Rank = ($_SESSION['permed'] == 1) ? "Admin" : "Normaal";
                echo '<div class="Rank">Account Type: '.$Rank.'</div>';
            }?>
            </div>`
            <a href='/../' target="_top">Home</a>
            <a href='User.php'>Login</a>
            <a href='Info.php'>Informatie</a>
            <a href='Screenshots.php'>ScreenShots</a>
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
