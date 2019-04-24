<?php
    session_start();
    if(!isset($_SESSION['username'])){
        die("<h1>Pleass login at the <a href=\"http://lococraft.nl.eu.org\">Lococraft Site</a><h2>Forums and Login credentials aren't the same.</h2>");
    }
    
    require 'Utils.php';
    $Utils = new Utils();
    $Utils->ConnectCheck();
?>