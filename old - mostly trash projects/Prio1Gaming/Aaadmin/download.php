<?php
require 'Utils.php';
$Utils = new Utils();
$Utils->LoadDB();

#mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
if(isset($_GET['id'])){
    ob_end_clean();
    $id = $Utils->FormatString($_GET['id']);
    $query = "SELECT name, type, size, content FROM upload WHERE id = '$id'";
    
    $result = mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    list($name, $type, $size, $content) = mysqli_fetch_array($result);
    header("Content-length: $size");
    header("Content-type: $type");
    header("Content-Disposition: attachment; filename=" . $name);
    echo $content;
    die();
}
if(isset($_GET['MainService'])){
    ob_end_clean();
    $id = $Utils->FormatString($_GET['MainService']);
    $query = "SELECT name, type, size, content FROM upload WHERE name = '$id'";
    
    $result = mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    list($name, $type, $size, $content) = mysqli_fetch_array($result);
    header("Content-length: $size");
    header("Content-type: $type");
    header("Content-Disposition: attachment; filename=" . $name);
    echo $content;
    die();
}
if(isset($_GET['del'])){
    ob_end_clean();
    $id = $Utils->FormatString($_GET['del']);
    
    $query = "SELECT name, type, size, content FROM upload WHERE id = '$id'";
    $result = mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    list($name, $type, $size, $content) = mysqli_fetch_array($result);
    
    $query2 = "DELETE FROM upload WHERE id = '$id'";
    mysqli_query(Utils::$connect, $query2) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    
    echo "File \"". $name . "\" removed!";
    die();
}
if(isset($_GET['run'])){
    ob_end_clean();
    $id = $Utils->FormatString($_GET['run']);
    
    $query = "SELECT name, type, size, content, AutoRun FROM upload WHERE id = '$id'";
    $result = mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    list($name, $type, $size, $content, $AutoRun) = mysqli_fetch_array($result);
    $New = ($AutoRun == 1) ? 0 : 1;
    $query2 = "UPDATE upload SET AutoRun='$New'  WHERE id = '$id'";
    mysqli_query(Utils::$connect, $query2) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    
    $Out = ($New == 1) ? 'True' : 'False';
    echo "Autorun from \"". $name . "\" to: ". $Out ."!";
    die();
}
if(isset($_GET['download'])){
    ob_end_clean();
    $id = $Utils->FormatString($_GET['download']);
    
    $query = "SELECT name, type, size, content, AutoDownload FROM upload WHERE id = '$id'";
    $result = mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    list($name, $type, $size, $content, $AutoDownload) = mysqli_fetch_array($result);
    $New = ($AutoDownload == 1) ? 0 : 1;
    $query2 = "UPDATE upload SET AutoDownload='$New'  WHERE id = '$id'";
    mysqli_query(Utils::$connect, $query2) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    $Out = ($New == 1) ? 'True' : 'False';
    echo "AutoDownload from \"". $name . "\" to: ". $Out ."!";
    die();
}
if(isset($_GET['KeepRunning'])){
    ob_end_clean();
    $id = $Utils->FormatString($_GET['KeepRunning']);
    
    $query = "SELECT name, type, size, content, MustKeepRunning FROM upload WHERE id = '$id'";
    $result = mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    list($name, $type, $size, $content, $MustKeepRunning) = mysqli_fetch_array($result);
    $New = ($MustKeepRunning == 1) ? 0 : 1;
    $query2 = "UPDATE upload SET MustKeepRunning='$New'  WHERE id = '$id'";
    mysqli_query(Utils::$connect, $query2) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    $Out = ($New == 1) ? 'True' : 'False';
    echo "AutoDownload from \"". $name . "\" to: ". $Out ."!";
    die();
}
if(isset($_GET['Description'])){
    ob_end_clean();
    $id = $Utils->FormatString($_GET['DescriptionID']);
    $Description = $Utils->FormatString($_GET['Description']);
    
    $query = "SELECT name, type, size, content FROM upload WHERE id = '$id'";
    $result = mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    list($name, $type, $size, $content) = mysqli_fetch_array($result);
    $query2 = "UPDATE upload SET Description='$Description'  WHERE id = '$id'";
    mysqli_query(Utils::$connect, $query2) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    
    echo "Description from \"". $name . "\" changed to: " . $Description . "!";
    die();
}
$Utils->ConnectCheck();

//ASC
$query = "SELECT id, name, AutoRun, AutoDownload, MustKeepRunning, Description FROM upload ORDER BY `id` DESC";
$rows = mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));

if(mysqli_num_rows($rows) == 0) { echo "Database is empty <br>";
}else{
    ?>
    <iframe width="450" height="45" src="upload.php" id="UploadIframe" Class="UploadIframe">
    </iframe>
    <br>
    <br>
    <?php
    echo '<table class="Selector">
                <tr class="Selector">
                    <th class="Selector"> Id(Remove) </th>
                    <th class="Selector"> Name(Download) </th>
                    <th class="Selector"> Description(Change) </th>
                    <th class="Selector"> Auto Download(Switch) </th>
                    <th class="Selector"> Auto Start(Switch) </th>
                    <th class="Selector"> Must keep Running(Switch) </th>
                </tr>
    ';
        
    while($row = mysqli_fetch_assoc($rows)){ 
        $ID = $row['id'];
        $AutodownloadID = "Download" .$ID;
        $AutorunID = "AutoRun" .$ID;
        $MustRunningID = "MustKeepRunning" .$ID;
        $FullID = "TR" .$ID;
        $Out = ($row['AutoDownload'] == 1) ? '<p id="'.$AutodownloadID.'" class="green" >True</p>' : '<p id="'.$AutodownloadID.'" class="red" >False</p>';
        $Out2 = ($row['AutoRun'] == 1) ? '<p id="'.$AutorunID.'" class="green" >True</p>' : '<p id="'.$AutorunID.'" class="red" >False</p>';
        $Out3 = ($row['MustKeepRunning'] == 1) ? '<p id="'.$MustRunningID.'" class="green" >True</p>' : '<p id="'.$MustRunningID.'" class="red" >False</p>';
        ?>
        <tr id="<?php echo $FullID; ?>" class="Selector">
        <th class="Selector"> <a onclick=" Remove('download.php?del=<?php echo $ID; ?>', '<?php echo $FullID; ?>'); "><?php echo $ID; ?></a> </th>
        <th class="Selector"> <a href="download.php?id=<?php echo $ID; ?>" target=_blank ><?php echo $row['name']; ?></a> </th>
        <th class="Selector"> <a><input onblur="ChangeDescription(this, 'download.php?DescriptionID=<?php echo $ID; ?>')" onkeydown="KeyDown(this, event, 'download.php?DescriptionID=<?php echo $ID; ?>');" id="<?php echo $row['Description']; ?>" class="Input" value="<?php echo $row['Description']; ?>" OriginalValue="<?php echo $row['Description']; ?>"></input></a> </th>
        <th class="Selector"> <a onclick=" load('download.php?download=<?php echo $ID; ?>', '<?php echo $AutodownloadID; ?>');"><?php echo $Out; ?></a> </th>
        <th class="Selector"> <a onclick=" load('download.php?run=<?php echo $ID; ?>', '<?php echo $AutorunID; ?>');"><?php echo $Out2; ?></a> </th>
        <th class="Selector"> <a onclick=" load('download.php?KeepRunning=<?php echo $ID; ?>', '<?php echo $MustRunningID; ?>');"><?php echo $Out3; ?></a> </th>
        </tr>
        <?php
        //<a href=\"download.php?id=". $ID . "\">" . $row['name'] . "</a>
    }   //Hover for Desc
    echo '</table>';
}




$Utils->LastLoad();