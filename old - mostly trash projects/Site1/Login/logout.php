<?php
$config = include $_SERVER['DOCUMENT_ROOT'] . "/Site1" . '/AddOns/PhP/Config.php';
require $config->MainPathRaw . '/AddOns/PhP/Utils.php';
$Utils = new Utils();
$Utils->ConnectCheck();
session_start();
//Session Access
$connect = mysqli_connect($config->DBIp, $config->username, $config->pass) or die ('Couldn\'t Connect');
mysqli_select_db($connect, $config->database) or die ("Couldn't Find your database !");
$UpdateOnline = "UPDATE  `users` SET  `online` =  '0' WHERE  `users`.`email` ='". $_SESSION['email'] ."' AND  `users`.`username` =  '". $_SESSION['username'] ."'";
$rows = mysqli_query($connect, $UpdateOnline);
unset($_SESSION['username']);
unset($_SESSION['nickname']);
unset($_SESSION['email']);
unset($_SESSION['password']);


die("Successfully Logged you out: <a href='LoginPage.php'>Log in</a>!");
?>