<?php
require 'Utils.php';
$Utils = new Utils();
$Utils->LoadDB();

$query = "SELECT id, name, AutoDownload, AutoRun, MustKeepRunning FROM upload ORDER BY `name` ASC";
$rows = mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));

if(mysqli_num_rows($rows) == 0) { echo "Database is empty <br>";
}else{
    $Prep = array();
    while($row = mysqli_fetch_assoc($rows)){ 
        $Prep[] = $row;
    }
    echo(json_encode($Prep));
}

