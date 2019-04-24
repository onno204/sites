<?php

$config = include 'Config.php';
require 'Utils.php';
$Utils = new Utils();

$Utils->ConnectCheck();
$connect = mysqli_connect($config->DBIp, $config->username, $config->pass) or die ('Couldn\'t Connect' . mysqli_error($connect));
mysqli_select_db($connect, $config->database) or die ("Couldn't Find your database !");


if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0){
    $fileName = $_FILES['userfile']['name'];
    $tmpName  = $_FILES['userfile']['tmp_name'];
    $fileSize = $_FILES['userfile']['size'];
    $fileType = $_FILES['userfile']['type'];
    
    $fp = fopen($tmpName, 'r');
    $content = fread($fp, filesize($tmpName));
    $content = addslashes($content);
    fclose($fp);
    
    if(!get_magic_quotes_gpc()) {
        $fileName = addslashes($fileName);
    }
    include 'library/config.php';
    include 'library/opendb.php';
    
    $query = "INSERT INTO upload (name, size, type, content ) ".
    "VALUES ('$fileName', '$fileSize', '$fileType', '$content')";
    
    //mysql_query($query) or die('Error, query failed');
    mysqli_query($connect, $query) or die('Error, query failed');
    
    include 'library/closedb.php';

    echo "<br>File $fileName uploaded<br>";
    echo "<br><br>";
} 
?>


<form method="post" enctype="multipart/form-data">
<table width="350" border="0" cellpadding="1" cellspacing="1" class="box">
<tr> 
<td width="246">
<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
<input name="userfile" type="file" id="userfile"> 
</td>
<td width="80"><input name="upload" type="submit" class="box" id="upload" value=" Upload "></td>
</tr>
</table>
</form>