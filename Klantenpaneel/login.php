<?php 
require "config.php";
if(doesUserHavePermission("login") == false){
    die("<h1>You don't have permission to view this page</h1>");
}
?>

<h1>Inloggen</h1>

<form method="POST" action="login">

<?php
if(isset($_GET['message'])){
    echo "<h1>".htmlToPlainText($_GET['message'])."</h1>";
}

if(isset($_GET['logout'])){
    session_destroy();
    echo "<h1>succesvol uitgelogd</h1>";
}else{
    if(isUserLoggedIn() == true){
        die("<h1>Je bent al ingelogd</h1><a href=\"login?logout=1\">uitloggen</a><a href=\"dashboard\">dashboard</a>");
    }
}


function formatString($inputstring){
    return $inputstring;
}

$enteredAll = true;
$username = "";
$password = "";

if(isset($_POST['username']) && strlen($_POST['username']) >=1 ){
    $username = formatString($_POST['username']);
}else{ $enteredAll = false; }
?>username: <input type="text" name="username" value="<?php echo $username;?>"> <br><?php

if(isset($_POST['password']) && strlen($_POST['password']) >=1 ){
    $password = formatString($_POST['password']);
}else{ $enteredAll = false; }
?>password: <input type="password" name="password" value="<?php echo $password;?>"> <br><?php

?>

    <input type="submit" name="submitbutton" value="Submit">
    
    <?php 
        if(isset($_POST['submitbutton']) && ($enteredAll !== true)){
            echo "<h1>gelieven overal iets in te vullen</h1>";
        } 
        if(isset($_POST['submitbutton']) && ($enteredAll === true)){
            $stmt = $conn->prepare("SELECT id,username,usergroup,password,firstname,lastname,email,phone,discord FROM users WHERE username = ? LIMIT 1");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $userexists = false;
            $passwordcorrect = false;
            while ($data = $result->fetch_assoc()){
                $userexists = $data;
            }
            if($userexists !== false ){
                if(password_verify($password, $userexists['password'])){
                    $passwordcorrect = true;
                }
            }
            
            if($passwordcorrect === false){
                ?><h1>Wachtwoord of gebruikersnaam is incorrect</h1><?php
            }else{
                $_SESSION['id'] = $userexists['id'];
                $_SESSION['username'] = $userexists['username'];
                $_SESSION['usergroup'] = $userexists['usergroup'];
                $_SESSION['firstname'] = $userexists['firstname'];
                $_SESSION['lastname'] = $userexists['lastname'];
                $_SESSION['email'] = $userexists['email'];
                $_SESSION['phone'] = $userexists['phone'];
                $_SESSION['discord'] = $userexists['discord'];
                $_SESSION['token'] = md5(uniqid(rand(), true));
                
                
                $stmt = $conn->prepare("UPDATE users SET lastloginip=?, lastlogindate=?, token=? WHERE id=?");
                $stmt->bind_param("sssi", strval(getUserIpAddr()), strval(microtime(true)), $_SESSION['token'], $_SESSION['id']);
                $stmt->execute();
                echo "<h1>Succesvol ingelogged</h1>";
                header("Location: dashboard");
            }
        }
    ?>
</form> 
<a href="register">registreer</a>

