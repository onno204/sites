<?php

if(!$Utils->HasPerms("ViewPasswords")){
    echo "<p class=\"MsgError\">You have no perms to see this page!</p>";
    return;
}

#Encryption
use NonPublicFiles\Defuse\Core;
use NonPublicFiles\Defuse\Crypto;
use NonPublicFiles\Defuse\Key;
use NonPublicFiles\Defuse\Exception as Ex;

?>
<script src="/Lib/Scripts/CryptoJSAES.js"></script>

<script>
    var encryptedAES = CryptoJS.AES.encrypt("Message", "My Secret Passphrase");
</script>
<script>
    function ChangeEncrypt(){
        var encryptedAES = CryptoJS.AES.encrypt($("#EncryptMe").val(), $("#Password").val());
        $("#DecryptMe").val(encryptedAES);
    }
    function ChangeDecrypt(){
        var decryptedBytes = CryptoJS.AES.decrypt($("#DecryptMe").val(), $("#Password").val());
        var plaintext = decryptedBytes.toString(CryptoJS.enc.Utf8);
        $("#EncryptMe").val(plaintext);
    }
    
    function SwitchPW(){
        if($("#EncryptMe").attr("type") == "password"){
            $("#EncryptMe").attr("type", "text");
        }else{
            $("#EncryptMe").attr("type", "password");
        }
        
    }
</script>


<div class="EncryptDecrypt">
    PASSWORD: <input type="password" id="Password" />
    <br>
    To-Encrypt: <input type="text" id="EncryptMe" onchange="ChangeEncrypt();"/>
    <br>
    To-Decrypt: <input type="text" id="DecryptMe" onchange="ChangeDecrypt();"/>
    <br>
    <input type="submit" value="SwitchPW" onclick="SwitchPW();"/>
</div>
<form action="Password.php" class="PWF" method="post">
    <ul id="Form">
        <li>Site: <input type="text" name="Site" required> </li>
        <li>Username: <input type="text" name="Username" required> </li>
        <li>Password: <input type="text" name="Password" required> </li>
        <li><input type="submit" value="Insert" name="InsertPW" required> </li>
    </ul>
</form>

<?php
#PHP CODE HERE
$key = "!@#&^T@&HVCA2a~dsaDFa!$4$!@DFUI(";
class Crypt{
    
    public function Encrypt($Decrypted){
        global $key;
        return openssl_encrypt($Decrypted,"AES-128-ECB",$key);
    }
    public function DeCrypt($encrypted){
        global $key;
        return openssl_decrypt($encrypted,"AES-128-ECB",$key);
    }
}
$Crypt = new Crypt();

if(isset($_POST['InsertPW'])){
    $Site = $Utils->FormatString($_POST['Site']);
    $SiteUsername = $Utils->FormatString($_POST['Username']);
    $SitePasswordNE = $Utils->FormatString($_POST['Password']);
    $SitePassword = $Crypt->Encrypt($SitePasswordNE);
    #echo "PW: $SitePassword <br>";
    #echo "PWD: ". $Crypt->DeCrypt($SitePassword);
    #id, for, site, username, password, registerdate
    $query = sprintf("INSERT INTO `Passwords` (`id`, `for`, `site`, `username`, `password`, `registerdate`) "
            . "VALUES (NULL, '%s', '%s', '%s', '%s', '%s')",
    $_SESSION['username'], $Site, $SiteUsername, $SitePassword, $CurrentTime);
    $rows = mysqli_query(Utils::$connect, $query);
    echo "<h1>Succesfully added: $SiteUsername</h1>";
}
if(isset($_GET['Remove'])){
    $Remove = $Utils->FormatString($_GET['Remove']);
    $query = sprintf("DELETE FROM `Passwords` WHERE `id`=$Remove");
    $rows = mysqli_query(Utils::$connect, $query);
    echo "<h1>Succesfully Removed ID: $Remove</h1>";
    
}



#Random * in the visable part of the screen
function RandomNess($str, $amount){ //$amount = .8
    $len = strlen($str);
    $num_to_remove = ceil($len * $amount);
    for($i = 0; $i < $num_to_remove; $i++) {
      $k = 0;
      do {
        $k = rand(1, $len);
      } while($str[$k-1] == "*");
      $str[$k-1] = "*";
    }
    return $str;
}

?>

<table class="PWTable">
    <tr>
        <th>ID</th>
        <th>Site</th>
        <th>username</th> 
        <th>password</th>
    </tr>
    <?php
    $Username = $_SESSION['username'];
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
    ?>
</table>


