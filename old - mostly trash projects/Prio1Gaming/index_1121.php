<?php

require 'Utils.php';
$Utils = new Utils();
$Utils->ConnectCheck();


echo "Site Reached!";

//Secure Input: $Utils->FormatString($username)

//$_SESSION['username']
//$_SESSION['nickname']
//$_SESSION['email']
//$_SESSION['password']


$Utils->LastLoad();