<?php

$config = include 'Config.php';
require 'Utils.php';
$Utils = new Utils();

$Utils->ConnectCheck();
//Secure Input: $Utils->FormatString($username)

//$_SESSION['username']
//$_SESSION['nickname']
//$_SESSION['email']
//$_SESSION['password']

//$connect = mysqli_connect($config->DBIp, $config->username, $config->pass) or die ('Couldn\'t Connect to the host, ' . mysqli_error($connect));

echo "<a href='upload.php'>Upload</a>";
echo "<br>";
echo "<a href='download.php'>Download</a>";
echo "<br>";
