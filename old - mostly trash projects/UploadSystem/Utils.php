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
    
    function ConnectCheck(){
        ob_start();
        $config = include 'Config.php';
        session_start();
        if(!isset($_SESSION['username'])){
            die('<a href=\'Login\'>Login or Register</a>');
        }
        
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];


        $connect = mysqli_connect($config->DBIp, $config->username, $config->pass) or die ('Couldn\'t Connect' . mysqli_error($connect));
        mysqli_select_db($connect, $config->database) or die ("Couldn't Find your database !");

        $query = sprintf("SELECT * FROM users WHERE `username`='%s' AND `password`='%s'",
        $this->FormatString($username),
        $this->FormatString($password));
        $rows = mysqli_query($connect, $query);

        $numrows = mysqli_num_rows($rows); 
        if($numrows){
            while($row = mysqli_fetch_assoc($rows)){
                $dbusername = $row['username'];
                $dbpassword = $row['password'];
                $dbnickname = $row['nickname'];
                $dbdate = $row['date'];
                $dbemail = $row['email'];
                $Permed = $row['Perm'];
            }


            echo("<a href='Login'>Logout</a><br>");
            echo('<a href=\'/../\' target="_top">Return to the Mainsite</a>');
            //echo('<a href=\'/../\' target="_top">Return to the Mainsite</a>');
            $_SESSION['username']=$dbusername;
            $_SESSION['nickname']=$dbnickname;
            $_SESSION['email']=$dbemail;
            $_SESSION['password']=$dbpassword;

            if(!$Permed){
                die('<h1>You don\'t have permission to access this page!<h1>');
            }

            //Session Access
            //$UpdateOnline = "UPDATE  `users` SET  `online` =  '1' WHERE  `users`.`email` ='". $dbemail ."' AND  `users`.`username` =  '". $dbusername ."'";
            //$rowss = mysqli_query($connect, $UpdateOnline);

        }else{
            die("Username or Password is wrong, <a href='Login'>Log in</a>");
        }
        echo "<h1>Access Granted<h1>";
    }
    
}

