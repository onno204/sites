<?php 
require "config.php";
if(isUserLoggedIn() == true){
    die("<h1>Je bent al ingelogd</h1><a href=\"login?logout=1\">uitloggen</a>");
}
if(doesUserHavePermission("register") == false){
    die("<h1>You don't have permission to view this page</h1>");
}
?>

<h1>Registeren</h1>
<form method="POST">

<?php

function formatString($inputstring){
    return $inputstring;
}

$enteredAll = true;
$username = "";
$password = "";
$firstname = "";
$lastname = "";
$email = "";
$phone = "";
$discord = "";

if(isset($_POST['username']) && strlen($_POST['username']) >=1 ){
    $username = formatString($_POST['username']);
}else{ $enteredAll = false; }
?>username: <input type="text" name="username" value="<?php echo $username;?>"> <br><?php

if(isset($_POST['password']) && strlen($_POST['password']) >=1 ){
    $password = formatString($_POST['password']);
    if(strlen($password) < 6){
        $enteredAll = false;
        ?><h4>Je wachtwoord moet minimaal 6 tekens lang zijn</h4><?php
    }
}else{ $enteredAll = false; }
?>password: <input type="password" name="password" value="<?php echo $password;?>"> <br><?php

if(isset($_POST['firstname']) && strlen($_POST['firstname']) >=1 ){
    $firstname = formatString($_POST['firstname']);
}else{ $enteredAll = false; }
?>firstname: <input type="text" name="firstname" value="<?php echo $firstname;?>"> <br><?php

if(isset($_POST['lastname']) && strlen($_POST['lastname']) >=1 ){
    $lastname = formatString($_POST['lastname']);
}else{ $enteredAll = false; }
?>lastname: <input type="text" name="lastname" value="<?php echo $lastname;?>"> <br><?php

if(isset($_POST['email']) && strlen($_POST['email']) >=1 ){
    $email = formatString($_POST['email']);
}else{ $enteredAll = false; }
?>email: <input type="text" name="email" value="<?php echo $email;?>"> <br><?php

if(isset($_POST['phone']) && strlen($_POST['phone']) >=1 ){
    $phone = formatString($_POST['phone']);
}else{ $enteredAll = false; }
?>phone: <input type="text" name="phone" value="<?php echo $phone;?>"> <br><?php

if(isset($_POST['discord']) && strlen($_POST['discord']) >=1 ){
    $discord = formatString($_POST['discord']);
}else{ $enteredAll = false; }
?>discord: <input type="text" name="discord" value="<?php echo $discord;?>"> <br><?php

?>

    <input type="submit" name="submitbutton" value="Submit">
    
    <?php 
        if(isset($_POST['submitbutton']) && ($enteredAll !== true)){
            echo "<h1>gelieven overal iets in te vullen</h1>";
        } 
        if(isset($_POST['submitbutton']) && ($enteredAll === true)){
            $passwordhash = password_hash($password, PASSWORD_BCRYPT, ["cost" => 7]);
            $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $userexists = false;
            
            while ($data = $result->fetch_assoc()){
                $userexists = true;
            }
            if($userexists){
                ?><h1>Er is al iemand met die gebruikers naam</h1><?php
            }else{
                $stmt = $conn->prepare("INSERT INTO users (username, password, firstname, lastname, email, phone, discord, lastloginip, lastlogindate) VALUES (?,?,?,?,?,?,?,?,?)");
                $stmt->bind_param("sssssssss", $username,$passwordhash, $firstname, $lastname, $email, $phone, $discord, strval(getUserIpAddr()), strval(microtime(true)));
                $stmt->execute();
                //var_dump($stmt->error);
                ?><h1>Uw account is aangemaakt. Uw wordt omgeleid naar de inlog pagina.</h1><?php
                header("Location: login?message=Succesvol+geregistreerd%2C+log+nu+in");
            }
        }
    ?>
</form> 
<a href="login">login</a>


