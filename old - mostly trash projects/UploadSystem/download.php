<?php

$config = include 'Config.php';
require 'Utils.php';
$Utils = new Utils();

$Utils->ConnectCheck();
$connect = mysqli_connect($config->DBIp, $config->username, $config->pass) or die ('Couldn\'t Connect' . mysqli_error($connect));
mysqli_select_db($connect, $config->database) or die ("Couldn't Find your database !");
#mysqli_query($connect, $query) or die('Error, query failed');

if(isset($_GET['id'])){
    ob_end_clean();
    $id    = $_GET['id'];
    $query = "SELECT name, type, size, content FROM upload WHERE id = '$id'";
    
    $result = mysqli_query($connect, $query) or die('Error, query failed');
    list($name, $type, $size, $content) = mysqli_fetch_array($result);
    header("Content-length: $size");
    header("Content-type: $type");
    header("Content-Disposition: attachment; filename=" . $name);
    echo $content;
    die();
}

$query = "SELECT id, name FROM upload ORDER BY `name` ASC";
$rows = mysqli_query($connect, $query) or die('Error, query failed');

if(mysqli_num_rows($rows) == 0) { echo "Database is empty <br>";
}else{
    while($row = mysqli_fetch_assoc($rows)){ echo "<a href=\"download.php?id=". $row['id'] . "\">" . $row['name'] . "</a> <br>"; }
}



