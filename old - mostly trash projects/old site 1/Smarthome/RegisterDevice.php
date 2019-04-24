<?php
/**
 * 
 
    
    
    $query = sprintf("INSERT INTO `Users` (`id`, `name`, `username`, `email`, `password`, `registerdate`, `lastlogin`, `permissions`, `registerip`, `loginip`) "
            . "VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
    $Realname, $Username, $Email, password_hash($Password, PASSWORD_BCRYPT), $CurrentTime, "RegisterOnly", $Utils->CreateDefaultPerms(), $IP, "RegisterOnly");
    $rows = mysqli_query(Utils::$connect, $query);
 * 
 * 
    $query = sprintf("SELECT * FROM `Passwords` WHERE `for`='$Username'");
    $rows = mysqli_query(Utils::$connect, $query);
    $numrows = mysqli_num_rows($rows); 
    if($numrows){
        while($row = mysqli_fetch_assoc($rows)){
            #id, for, site, username, password, registerdate
            $plaintext = $Crypt->DeCrypt($row['password']);

            ?>
            <tr>
                <td><a href="Password.php?Remove=<?php echo $row['id']; ?>"><?php echo $row['id']; ?></a></td>
                <td><a href="<?php echo $row['site']; ?>"><?php echo $row['site']; ?></a></td>
                <td><?php echo $row['username']; ?></td>
                <td><a href="#" onclick="prompt('Password', '<?php echo $plaintext; ?>')"><?php echo RandomNess($plaintext, .8); ?></a></td>
            </tr>
            <?php
        }
    }else{
        echo "<p class=\"MsgError\">Error, No results!</p>";
    }
 * 
 * 
 */

if(!$Utils->HasPerms("Smarthome")){
    echo "<p class=\"MsgError\">You have no perms to see this page!</p>";
    return;
}

?>

<!-- Styles -->
<link href="Lib/RegisterDevice.css" rel="stylesheet" type="text/css">

<?php

function EchoPostVal($Val){
    if($Val == null){ return; }
    if(!isset($_POST[$Val])){ return; }
    echo $_POST[$Val];
} 

if(isset($_POST['RegDev'])){
    RegDev:
    $DevName = $Utils->FormatString($_POST['name']);
    $DevType = $Utils->FormatString($_POST['Type']);
    $DevID = mt_rand(1, mt_getrandmax());
    if(strlen($DevName) > 200){
        echo "<p class=\"RegDevError\">Error! You entered something that was longer than our allowed limit!</p>";
        goto RegDevForm;
    }
    
    $query = sprintf("SELECT * FROM `SmartoDevices` WHERE `devid`='%s'",
            $DevID);
    $rows = mysqli_query(Utils::$connect, $query);
    $numrows = mysqli_num_rows($rows); 
    if($numrows > 0){
        //Unique device ID already exist, Redo the loop
        goto RegDev;
    }
    $state1 = "";
    $state0 = "";
    //Get States
    $query = sprintf("SELECT * FROM `SmartoDeviceList` WHERE `type`='%s'",
            $DevType);
    $rows = mysqli_query(Utils::$connect, $query);
    $numrows = mysqli_num_rows($rows); 
    if($numrows){
        while($row = mysqli_fetch_assoc($rows)){
            $state1 = $row['State1Text'];
            $state0 = $row['State0Text'];
        }
    }else{
        echo "<option value='error'>Error, No results!</p>";
        goto RegDevForm;
    }
    
    $CurrentTime = date("Y-m-d H:i:s");
    $query = sprintf("INSERT INTO `SmartoDevices` (`id`, `devid`, `name`, `type`, `regdate`, `lastdate`, `OwnerID`, `state`, `previousstate`, `stateid`, `previousstateid`) "
            . "VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
    $DevID, $DevName, $DevType, $CurrentTime, $CurrentTime, $_SESSION['id'], $state1, $state0, 0, 1);
    $rows = mysqli_query(Utils::$connect, $query);
    //echo mysqli_error(Utils::$connect);
    
    ?>
    <div class="RegSuccess">
        <p class="RegDevError">Succesfully registered device.</p>
        <ul>
            <li>Device ID: <?php echo $DevID; ?></li>
            <li>Type: <?php echo $DevType; ?></li>
        </ul>
    </div>
    <?php
    goto RegDevForm;
}

RegDevForm:
?>

<form class="RegisterDeviceForm" action="RegisterDevice.php" method="post">
    <ul id="RegDevForm" class="Hidden">
        <li>Device Name: <input name="name" value="<?php EchoPostVal('name'); ?>" type="text" size="25" maxlength="200" required></li>
        <li>
            <select name="Type">
                <option value="" disabled selected>Choose Type</option>
                <?php
                    $query = sprintf("SELECT * FROM `SmartoDeviceList`");
                    $rows = mysqli_query(Utils::$connect, $query);
                    $numrows = mysqli_num_rows($rows); 
                    if($numrows){
                        while($row = mysqli_fetch_assoc($rows)){
                            ?>
                                <option value="<?php echo $row['type']; ?>"><?php echo $row['type']; ?></option>
                            <?php
                        }
                    }else{
                        echo "<option value='error'>Error, No results!</p>";
                    }
                ?>
            </select>
        </li>
        <li><input name="RegDev" type="submit" value="Register Device"></li>
    </ul>
</form>