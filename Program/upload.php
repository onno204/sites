<?php
require 'Utils.php';
$Utils = new Utils();
$Utils->LoadDB();

if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0){
    $fileName = $_FILES['userfile']['name'];
    $tmpName  = $_FILES['userfile']['tmp_name'];
    $fileSize = $_FILES['userfile']['size'];
    $fileType = $_FILES['userfile']['type'];
    //echo "<br>Name: " . $fileName;
    //echo "<br>TmpName: " . $tmpName;
    //echo "<br>Size: " . $fileSize;
    //echo "<br>Type: " . $fileType;
    $fp = fopen($tmpName, 'r');
    $content = fread($fp, filesize($tmpName));
    $content = addslashes($content);
    fclose($fp);
    
    if(!get_magic_quotes_gpc()) { $fileName = addslashes($fileName); }
    
    $query = "INSERT INTO upload (name, size, type, content ) ".
    "VALUES ('$fileName', '$fileSize', '$fileType', '$content')";
    mysqli_query(Utils::$connect, $query) or die('Error, query failed');
    
    //echo "<br>File $fileName uploaded<br>";
    ?>
        <h1>Reload to see the file!</h1>
    <?php
} 
?>

<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="20000000">
    <input name="userfile" type="file" id="userfile"> 
    <input name="upload" type="submit" class="box" id="upload" value=" Upload ">
</form>
