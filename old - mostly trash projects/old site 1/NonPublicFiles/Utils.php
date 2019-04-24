<?php

class Utils{
    #Get cleint ip address
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
    
    #Prevent SQL injection
    function FormatString($String){
        if($String == ""){ return null; }
        $config = include 'Config.php';
        $mysqli = new mysqli($config->DBIp, $config->username, $config->pass, $config->database);
        if (mysqli_connect_errno()) {
            die(printf("Connect failed: %s\n", mysqli_connect_error()));
        }
        $String1 = $mysqli->real_escape_string($String);
        $String2 = htmlspecialchars($String1);
        return $String2;
    }
    
    public static $connect; #DB connect
    public static $config; #Config
    
    #Connect to DB
    function LoadDB(){
        Utils::$config = include 'Config.php';
        Utils::$connect = mysqli_connect(Utils::$config->DBIp, Utils::$config->username, Utils::$config->pass) or die('Couldn\'t Connect' . mysqli_error(Utils::$connect));
        mysqli_select_db(Utils::$connect, Utils::$config->database) or die("Couldn't Find your database !");
    }
    
    #Function to update/set a cookie
    function SetCookie($Name, $Value){
        setcookie($Name, $Value, time() + (86400 * 365), "/"); // 86400 = 1 day
        return true;
    }
    
    #Replace first occurance
    function ReplaceFirst($needle, $replace, $haystack) {
        $pos = strpos($haystack, $needle);
        if ($pos !== false) {
            return substr_replace($haystack, $replace, $pos, strlen($needle));
        }else{
            return $haystack;
        }
    }
    function Contains($sentence, $word){
        if (strpos($sentence, $word) !== false) {
            return true;
        }
        return false;
    }
    
    function CreateDefaultPerms(){
        $Perms = array("Default", "ViewUserlist", "SendEmail");
        $JSON = json_encode($Perms);
        return $JSON;
    }
    function HasPerms($Perm){
        if(!isset($_SESSION['permissions'])){ return false; }
        $Perms = json_decode($_SESSION['permissions']);
        if($Perms==null){ return false; }
        if(in_array($Perm, $Perms)){
            return true;
        }
        return false;
    }
    
    function UpdateSession(){
        if(!isset($_SESSION['username'])){ return; }
        $query = sprintf("SELECT * FROM `Users` WHERE `username`='%s' LIMIT 1",
        $_SESSION['username']);
        $rows = mysqli_query(Utils::$connect, $query);
        $numrows = mysqli_num_rows($rows); 
        if($numrows){
            while($row = mysqli_fetch_assoc($rows)){
                #id, name, username, email, password, registerdate, lastlogin, permissions
                if($_SESSION['lastlogin'] != $row['lastlogin']){
                    #Warning, Somewhere else loggedin
                    //echo "<h1>Please note! There has been an login from another device.</h1>";
                }
                $_SESSION['id'] = $row['id'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['registerdate'] = $row['registerdate'];
                $_SESSION['lastlogin'] = $row['lastlogin'];
                $_SESSION['permissions'] = $row['permissions'];
            }
        }else{
            //ERROR
        }
    }
    
    
    
    
    
    
    
    
    
}
