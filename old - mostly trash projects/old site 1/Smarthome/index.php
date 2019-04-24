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


<devices>
    <!--
    <device id="12312">
        <devicename>Test1233</devicename>
        <br>

        <object data="../Lib/Pictures/Image.png" alt="Device Image" type="image/png">
          <img alt="Device Image" src="../Lib/Pictures/Image.png" />
        </object>
        <devicestate>closed</devicestate>
        <switchdevicestate>open</switchdevicestate>
    </device>
    -->
    <?php
    $ID = $_SESSION['id'];
    $filter = "";
    if(isset($_GET['type'])){ $filter = sprintf(" AND `type`='%s'",$Utils->FormatString($_GET['type'])); }
    $query = sprintf("SELECT * FROM `SmartoDevices` WHERE `OwnerID`='$ID'". $filter);
    $rows = mysqli_query(Utils::$connect, $query);
    $numrows = mysqli_num_rows($rows); 
    if($numrows){
        while($row = mysqli_fetch_assoc($rows)){
            ?>
            <device id="<?php echo $row['devid']; ?>">
                <devicename><?php echo $row['name']; ?></devicename>
                <br>
                <object id="CamID<?php echo $row['devid']; ?>" data="data:image/png;base64, <?php echo $row['PictureState' + $row['stateid']]; ?>" alt="Device Image" type="image/png">
                  <img alt="Device Image" src="../Lib/Pictures/Image.png" />
                </object>
                <devicestate><?php echo $row['state']; ?></devicestate>
                <switchdevicestate><?php echo $row['previousstate']; ?></switchdevicestate>
            </device>
            <?php
        }
    }else{
        echo "<p class=\"MsgError\">Error, No results!</p>";
    }
    ?>
</devices>
<script src="../Lib/Scripts/socket.io.js"></script>
<script>
    
</script>
<script>
    var ws = new WebSocket("ws://127.0.0.1:9999/");
    ws.onmessage = function (event) {
        if(event.data.length < 100){
            console.log("Received: ", event.data);
        }else{
            console.log("Received a long string");
        }
        var Split = event.data.split(':');
        var devID = Split[0];
        var Command = Split[1].toLowerCase();
        var Args = Split[2];
        switch(Command) {
            case "updateimage":
                var ImgE = document.getElementById("CamID" + devID);
                ImgE.data = "data:image/png;base64," + Args;
                break;
            case "none":
                break;
            default:
                console.log("Command not found", Command);
        }
    };
    ws.onopen = function (event) {
        console.log("Opent With: ", event);
        SendMessage("ownerid:<?php echo $_SESSION['id']; ?>");
    };
    ws.onerror = function (event) {
        console.log("Error: ", event);
    };
    ws.onclose = function (event) {
        console.log("closed: ", event);
    };
    
    
    function SendMessage(Message){
        if(Message.length < 100){
            console.log("Sending: ", Message);
        }else{
            console.log("Sending a long string");
        }
        ws.send(Message);
    }
</script>
<script>
    function DownloadSingleVideo(CamName){
        SendMessage("ReceiveStream:" + CamName);
    }
</script>