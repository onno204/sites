<?php
session_start();
//Session Access
$connection = mysqli_connect('localhost', 'onno204n_SiteDB', 'SiteDB123') or die ("Could not connect to the database server!");
mysqli_select_db($connection, "onno204n_Site") or die ("Could not connect to the database");
$UpdateOnline = "UPDATE  `users` SET  `online` =  '0' WHERE  `users`.`email` ='". $_SESSION['email'] ."' AND  `users`.`username` =  '". $_SESSION['username'] ."'";
$rows = mysqli_query($connect, $UpdateOnline);
unset($_SESSION['username']);
unset($_SESSION['email']);
unset($_SESSION['password']);


die("Successfully Logged you out: <a href='LoginPage.php'>Log in</a>!");
?>