<?php
require 'Utils.php';
$Utils = new Utils();
$Utils->LoadDB();

#mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));

//Add an new Item
if(isset($_GET['Create'])){
    ob_end_clean();
    $name = "LeegTekst";
    $query2 = "INSERT INTO `upload` (`id`, `visable`, `categorie`, `tekst`, `name`) VALUES (NULL, NULL, NULL, NULL, '$name');";
    mysqli_query(Utils::$connect, $query2) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    echo "Nieuwe tekst gemaakt, naam=\"". $name . "\"!";
    die();
}


//Remove an Item
if(isset($_GET['del'])){
    ob_end_clean();
    $id = $Utils->FormatString($_GET['del']);
    $query2 = "DELETE FROM upload WHERE id = '$id'";
    mysqli_query(Utils::$connect, $query2) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    echo "TekstID \"". $id . "\" verwijderd!";
    die();
}
//Switch True/False
if(isset($_GET['Switch'])){
    ob_end_clean();
    $id = $Utils->FormatString($_GET['ID']);
    
    $query = "SELECT visable, name, id FROM upload WHERE id = '$id'";
    $result = mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    list($visable, $name, $id) = mysqli_fetch_array($result);
    $New = ($visable == 1) ? 0 : 1;
    $query2 = "UPDATE upload SET visable='$New'  WHERE id = '$id'";
    mysqli_query(Utils::$connect, $query2) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    $Out = ($New == 1) ? 'True' : 'False';
    echo "Je hebt \"". $name . "\" Veranderd naar: ". $Out ."!";
    die();
}
//Change Tekst (CT)
if(isset($_GET['CT'])){
    //ob_end_clean();
    $id = $Utils->FormatString($_GET['ID']);
    $Value = $Utils->FormatString($_GET['Value']);
    $Column = $Utils->FormatString($_GET['Column']);
    
    $query2 = "UPDATE upload SET `$Column`='$Value'  WHERE `id`='$id'";
    mysqli_query(Utils::$connect, $query2) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    
    echo "Tekst van \"". $Column . "\" Veranderd naar: " . $Value . "!";
    die();
}
$Utils->ConnectCheck();

//ASC
$query = "SELECT * FROM upload ORDER BY `id` DESC";
$rows = mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));


?>
<div class="Button" style="width:400px" onclick="CreateNewInfo()">Click to Add a new Empty item.</div>
<?php
if(mysqli_num_rows($rows) == 0) { echo "Database is empty <br>";
}else{
    ?>
    <br>
    <br>
    <?php
    echo '<table class="Selector">
                <tr class="Selector">
                    <th class="Selector"> Id(Remove) </th>
                    <th class="Selector"> Visable(Switch) </th>
                    <th class="Selector"> Categorie(Change) </th>
                    <th class="Selector"> Name(Change) </th>
                    <th class="Selector"> Tekst(Change) </th>
                </tr>
    ';
        
    while($row = mysqli_fetch_assoc($rows)){ 
        $ID = $row['id'];
        $FullID = "Table". $ID;
        $VisableID = "Visable" .$ID;
        $CategorieID = "Categorie" .$ID;
        $NameID = "Name" .$ID;
        $TekstID = "Tekst" .$ID;
        $VisableOut = ($row['visable'] == 1) ? '<p id="'.$VisableID.'" class="green" >True</p>' : '<p id="'.$VisableID.'" class="red" >False</p>';
        ?>
        <tr id="<?php echo $FullID; ?>" class="Selector">
        <th class="Selector"> <a onclick="Remove('Info.php?del=<?php echo $ID; ?>', '<?php echo $FullID; ?>'); "><?php echo $ID; ?></a> </th>
        <th class="Selector"> <a onclick="Switch('Info.php?Switch=1&ID=<?php echo $ID; ?>&Column=visable', this);"><?php echo $VisableOut; ?></a> </th>
        <th class="Selector"> <a><input onblur="ChangeTekst(this, 'Info.php?CT=1&ID=<?php echo $ID; ?>&Column=categorie')" onkeydown="KeyDown(this, event);" id="<?php echo $CategorieID; ?>" class="Input" value="<?php echo $row['categorie']; ?>" OriginalValue="<?php echo $row['categorie']; ?>"></input></a> </th>
        <th class="Selector"> <a><input onblur="ChangeTekst(this, 'Info.php?CT=1&ID=<?php echo $ID; ?>&Column=name')" onkeydown="KeyDown(this, event);" id="<?php echo $NameID; ?>" class="Input" value="<?php echo $row['name']; ?>" OriginalValue="<?php echo $row['name']; ?>"></input></a> </th>
        <th class="Selector"> <a><input onblur="ChangeTekst(this, 'Info.php?CT=1&ID=<?php echo $ID; ?>&Column=tekst')" onkeydown="KeyDown(this, event);" id="<?php echo $TekstID; ?>" class="Input" value="<?php echo $row['tekst']; ?>" OriginalValue="<?php echo $row['tekst']; ?>"></input></a> </th>
        </tr>
        <?php
        //<a href=\"Info.php?id=". $ID . "\">" . $row['name'] . "</a>
    }   //Hover for Desc
    echo '</table>';
}




$Utils->LastLoad();