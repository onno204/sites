<?php

class Utils{
    // Function to get the client IP address
    function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
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
        $String3 = sprintf($String2);
        /*
        if(!get_magic_quotes_gpc(){
            $String4 = addslashes($String3);
            return $String4;
        }
         */
        return $String3;
    }
    
    function HasPerms($Perm){
        $config = include $_SERVER['DOCUMENT_ROOT'] . "/Site1" . '/AddOns/PhP/Config.php';
        $connect = mysqli_connect($config->DBIp, $config->username, $config->pass) or die ('Couldn\'t Connect to the host, ' . mysqli_error($connect));
        mysqli_select_db($connect, $config->database) or die ("Couldn't Find your database !");
    
        session_start();
        $query = sprintf("SELECT * FROM users WHERE `username`='%s'", $this->FormatString($_SESSION['username']));
        $rows = mysqli_query($connect, $query);
        while($row = mysqli_fetch_assoc($rows)){ $PermArray = explode(",", $row['Perm']); }
        return in_array($Perm, $PermArray);
    }
    
    function ConnectCheck(){
        $config = include $_SERVER['DOCUMENT_ROOT'] . "/Site1" . '/AddOns/PhP/Config.php';
    
        $connect = mysqli_connect($config->DBIp, $config->username, $config->pass) or die ('Couldn\'t Connect to the host, ' . mysqli_error($connect));
        mysqli_select_db($connect, $config->database) or die ("Couldn't Find your database !");
        session_start();
        
        //$query = sprintf("SELECT * FROM users WHERE `LastIP`='%s' OR `username`='%s'",
        //mysqli_real_escape_string($connect, $this->get_client_ip()),
        //mysqli_real_escape_string($connect, $_SESSION['username']));
        $query = sprintf("SELECT * FROM users WHERE `username`='%s'", $this->FormatString($_SESSION['username']));
        $rows = mysqli_query($connect, $query);
        $numrows = mysqli_num_rows($rows); 
        if($numrows){
            while($row = mysqli_fetch_assoc($rows)){
                $Banned = $row['Banned'];
                $BanReason = $row['BanReason'];
                if($Banned){
                    echo("<title>BANNED</title>");
                    echo("<h2 style='color:rgb(200, 50, 50)'><u>Your account has been banned from the site!</u></h2>");
                    echo("<h2 style='color:rgb(200, 50, 50)'>Reason:</h2>");
                    echo("<h1 style='color:rgb(255, 0, 0)'>".$BanReason."</h1>");
                    die();
                }
            }
        }
        
        $query2 = sprintf("SELECT * FROM users WHERE `LastIP`='%s'",
        mysqli_real_escape_string($connect, $this->get_client_ip()));
        $rows2 = mysqli_query($connect, $query2);
        $numrows2 = mysqli_num_rows($rows2); 
        if($numrows2){
            while($row = mysqli_fetch_assoc($rows2)){
                $Banned = $row['IpBanned'];
                $BanReason = $row['BanReason'];
                if($Banned){
                    echo("<title>IP-BANNED</title>");
                    echo("<h2 style='color:rgb(200, 50, 50)'><u>Your account has been IP-banned from the site!</u></h2>");
                    echo("<h2 style='color:rgb(200, 50, 50)'>Reason:</h2>");
                    echo("<h1 style='color:rgb(255, 0, 0)'>".$BanReason."</h1>");
                    die();
                }
            }
        }
        if(!isset($_COOKIE["Agree"])){
            echo ' <script src="'.$config->MainPath . "/AddOns/JavaScripts/JQuery.js".'"></script>';
            echo '
                <div class="CookieAgree" id="CookieAgree">
                <script>
                $("#CookieAgree").click(function(){
                    $("#CookieAgree").slideUp("fast");
                        var d = new Date();
                        d.setTime(d.getTime() + (123*24*60*60*1000));
                        var expires = "expires="+ d.toUTCString();
                        document.cookie = "Agree=1;" + expires + "; path=/";
                });
                </script>
                If you click anywhere on this page you AGREE to the use of cookies on this website!
                <br>
                <br>
                (We all hate this notification but sadly we have to display it.)
                <br>
                <br>
                No not the cookies in your cookie jar, Internet cookies.
                <br>
                Not tasty but usefull;
                </div>
                ';
        }
        
    }
    
}

