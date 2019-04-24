<?php
require 'Utils.php';
$Utils = new Utils();

if(isset($_GET['Style'])){
    $Utils->SetCookie("Style", $Utils->FormatString($_GET['Style']));
    echo "Style Changed to: " + $Utils->FormatString($_GET['Style']);
}