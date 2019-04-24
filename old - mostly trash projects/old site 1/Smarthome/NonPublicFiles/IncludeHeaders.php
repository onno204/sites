<?php

require '../../NonPublicFiles/Utils.php';
$Utils = new Utils();
$Utils->LoadDB();

#Some setup and handy things

$CurrentTime = date("Y-m-d H:i:s");
$IP = $Utils->get_client_ip();

#Update Session Data
$Utils->UpdateSession();

#id, name, username, email, password, registerdate, lastlogin, permissions
#id, for, site, username, password, registerdate


$file = $_SESSION['InclFile'];
if (strpos($file, 'Backend') !== false) {
    include $file;
    return;
}

if(isset($_GET['Backend'])){
    include $file;
    return;
}
echo "<!DOCTYPE HTML>";
echo "<html>";
echo "<head>";

echo "<!--- Headers -->";
include "../Include/Header.php";

echo "</head>";
echo "<body>";

echo "<!--- Main Menu -->";
include "../Include/MainMenu.php";

echo "<!--- Contents -->";
echo "<main>";
include $file;
echo "</main>";

echo "<!--- Footer -->";
include "../Include/Footer.php";

echo "</body>";
echo "</html>";
echo "<!--- EOF -->";