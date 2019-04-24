<?php 
include('options.php');
$config = include $_SERVER['DOCUMENT_ROOT'] . "/Site1" . '/AddOns/PhP/Config.php';
    require $config->MainPathRaw . '/AddOns/PhP/Utils.php';
    $Utils = new Utils();
    $Utils->ConnectCheck();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title ?></title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">

<?php
session_start();

$username = $_POST['username'];
$password = sha1($_POST['password']);

if($username && $password) {
    $connect = mysqli_connect($config->DBIp, $config->username, $config->pass) or die ('Couldn\'t Connect' . mysqli_error($connect));
    mysqli_select_db($connect, $config->database) or die ("Couldn't Find your database !");
    
    $query = sprintf("SELECT * FROM users WHERE `username`='%s' AND `password`='%s'",
    $Utils->FormatString($username),
    $Utils->FormatString($password));
    $rows = mysqli_query($connect, $query);
    
    $numrows = mysqli_num_rows($rows); 
    if($numrows){
        while($row = mysqli_fetch_assoc($rows)){
            $dbusername = $row['username'];
            $dbpassword = $row['password'];
            $dbnickname = $row['nickname'];
            $dbdate = $row['date'];
            $dbemail = $row['email'];
        }
        //Lastip
        $LastIPQuery = "UPDATE  `users` SET  `LastIP` =  '". $Utils->FormatString($Utils->get_client_ip()) . "' WHERE  `users`.`email` ='". $dbemail ."' AND  `users`.`username` =  '". $dbusername ."'";
        $rows = mysqli_query($connect, $LastIPQuery);
        
        //Session Access
        $UpdateOnline = "UPDATE  `users` SET  `online` =  '1' WHERE  `users`.`email` ='". $dbemail ."' AND  `users`.`username` =  '". $dbusername ."'";
        $rowss = mysqli_query($connect, $UpdateOnline);
        
        
        echo("<p>Welcome back $dbusername !</p> <p>as nickname: $dbnickname</p><p>Account Registered at: $dbdate</p>");
        echo("<p>Your Email address: $dbemail</p>");
        echo("<a href='logout.php'>Logout</a>");
        $_SESSION['username']=$dbusername;
        $_SESSION['nickname']=$dbnickname;
        $_SESSION['email']=$dbemail;
        $_SESSION['password']=$dbpassword;
    }else{
        die("Username or Password is wrong, <a href='LoginPage.php'>Log in</a>");
    }
}else{
    die("Username or Password is wrong, <a href='LoginPage.php'>Log in</a>");
}
?>
</div>
</body>
</html>