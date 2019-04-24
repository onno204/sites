<?php

require './././Utils.php';
$Utils = new Utils();
$Utils->LoadDB();

function LoadFilee(){
    
    //include $file;
    #Load picture
    
    $query = "SELECT * FROM `UploadSS` AS r1 JOIN (SELECT CEIL(RAND() * (SELECT MAX(id) FROM `UploadSS`)) AS id) AS r2 WHERE (r1.id >= r2.id) AND (Accepted = 1) ORDER BY r1.id ASC LIMIT 1";
    $rows = mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    if (mysqli_num_rows($rows) == 0) {
        echo "No accepted images yet!<br>";
    } else {
        while ($row = mysqli_fetch_assoc($rows)) {
            //header('Content-Type: image/png');
            //header('Content-Length: ' . $row['size']);
            //echo $row['content'];
            $Cont = base64_encode($row['content']);
            //echo "<img src=\"data:image/png;base64,$Cont\"/>";
            header('Content-Type: image/png');
            echo base64_decode($Cont);
            
        }
    }
}
LoadFilee();