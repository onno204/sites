
<?php

function EchoPostVal($Val){
    if($Val == null){ return; }
    if(!isset($_POST[$Val])){ return; }
    echo $_POST[$Val];
} 

if(isset($_POST['Logout'])){
    unset($_SESSION['id']);
    unset($_SESSION['username']);
    unset($_SESSION['name']);
    unset($_SESSION['email']);
    unset($_SESSION['registerdate']);
    unset($_SESSION['lastlogin']);
    unset($_SESSION['permissions']);
}

if(isset($_SESSION['username'])){
    ?>
    
    <p class="LoginError">Already logged in!</p>
    
<form class="LoginForm" action="Login.php" method="post">
    <ul id="Form">
        <li>Username: <?php echo $_SESSION['username']; ?></li>
        <li>Real name: <?php echo $_SESSION['name']; ?></li>
        <li>E-Mail: <?php echo $_SESSION['email']; ?></li>
        <li>Register-date: <?php echo $_SESSION['registerdate']; ?></li>
        <li>Last login: <?php echo $_SESSION['lastlogin']; ?></li>
        <li><input name="Logout" type="submit" value="Logout"></li>
        <li></li>
    </ul>
</form>
    <?php
    return;
}

if(isset($_POST['Register'])){
    $Username = $Utils->FormatString($_POST['username']);
    $Realname = $Utils->FormatString($_POST['realname']);
    $Email = $Utils->FormatString($_POST['email']);
    $Password = $Utils->FormatString($_POST['password']);
    $PasswordRepeat = $Utils->FormatString($_POST['passwordrepeat']);
    if(strlen($Username) > 75 || strlen($Realname) > 75 || strlen($Email) > 75 || strlen($Password) > 75 || strlen($PasswordRepeat) > 75){
        echo "<p class=\"LoginError\">Error! You entered something that was longer than our allowed limit!</p>";
        goto Login;
    }
    if(strlen($Username) < 5){
        echo "<p class=\"LoginError\">Please think of a username longer than 5 characters.</p>";
        goto Login;
    }
    if($Username == $Realname){
        echo "<p class=\"LoginError\">Please don't use your username as your realname.</p>";
        goto Login;
    }
    if(!$Utils->Contains($Email, "@") || !$Utils->Contains($Email, ".")){
        echo "<p class=\"LoginError\">Please check if your email address is written oke!</p>";
        goto Login;
    }
    if(strlen($Password) < 6){
        echo "<p class=\"LoginError\">Your password needs to be at least 6 characters!</p>";
        goto Login;
    }
    if($Password != $PasswordRepeat){
        echo "<p class=\"LoginError\">Passwords don't match! Please retry!</p>";
        goto Login;
    }
    
    $query = sprintf("SELECT * FROM `Users` WHERE `username`='%s' OR `email`='%s'",
    $Username, $Email);
    $rows = mysqli_query(Utils::$connect, $query);
    $numrows = mysqli_num_rows($rows); 
    if($numrows > 0){
        echo "<p class=\"LoginError\">Someone has already register with that username or email!</p>";
        goto Login;
    }
    
    
    $query = sprintf("INSERT INTO `Users` (`id`, `name`, `username`, `email`, `password`, `registerdate`, `lastlogin`, `permissions`, `registerip`, `loginip`) "
            . "VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
    $Realname, $Username, $Email, password_hash($Password, PASSWORD_BCRYPT), $CurrentTime, "RegisterOnly", $Utils->CreateDefaultPerms(), $IP, "RegisterOnly");
    $rows = mysqli_query(Utils::$connect, $query);
    
    
    echo "<p class=\"LoginError\">Succesfully registered, Please now Login!</p>";
    goto Login;
    
} elseif(isset($_POST['Login'])) {
    $username = $Utils->FormatString($_POST['username']);
    $Password = $Utils->FormatString($_POST['password']);
    if(strlen($username) < 5) {
        echo "<p class=\"LoginError\">Error! The username needs to be atleast 5 characters long!</p>";
        goto Login;
    }
    if(strlen($Password) < 6) {
        echo "<p class=\"LoginError\">Error! The password needs to be atleast 6 characters long!</p>";
        goto Login;
    }
    
    $query = sprintf("SELECT * FROM `Users` WHERE `username`='%s' LIMIT 1",
    $username);
    $rows = mysqli_query(Utils::$connect, $query);
    $numrows = mysqli_num_rows($rows); 
    if($numrows){
        while($row = mysqli_fetch_assoc($rows)){
            #id, name, username, email, password, registerdate, lastlogin, permissions
            if (password_verify($Password, $row['password'])) {
                //echo 'Password is valid!';
                $_SESSION['id'] = $row['id'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['registerdate'] = $row['registerdate'];
                $_SESSION['lastlogin'] = $CurrentTime;
                $_SESSION['permissions'] = $row['permissions'];
                $ID = $row['id'];
                $query = sprintf("UPDATE `Users` SET `lastlogin`='$CurrentTime', `loginip`='$IP' WHERE `Users`.`id` = $ID",
                $username);
                $rows = mysqli_query(Utils::$connect, $query);
                echo "<p class=\"LoginError\">Logged in!</p>";
                ?>
                <form class="LoginForm" action="Login.php" method="post">
                    <ul id="Form">
                        <li>Username: <?php echo $_SESSION['username']; ?></li>
                        <li>Real name: <?php echo $_SESSION['name']; ?></li>
                        <li>E-Mail: <?php echo $_SESSION['email']; ?></li>
                        <li>Register-date: <?php echo $_SESSION['registerdate']; ?></li>
                        <li>Last login: <?php echo $_SESSION['lastlogin']; ?></li>
                        <li><input name="Logout" type="submit" value="Logout"></li>
                        <li></li>
                    </ul>
                </form>
                <?php
                return;
            } else {
                $Utils->SetCookie("PasswordTries", ((int)$_COOKIE['PasswordTries']) + 1);
                echo "<p class=\"LoginError\">Invalid password!</p>";
                goto Login;
            }
        }
    }else{
        echo "<p class=\"LoginError\">Error, Username not found!</p>";
        goto Login;
    }
    
    
    
} else{
    echo "<script>$(document).ready(function(){ GoLogin(); });</script>";
}


Login:
?>


<script>
    var GoRegister = function(){
        $("#Form").html($("#FormRegister").html());
    };
    var GoLogin = function(){
        $("#Form").html($("#FormLogin").html());
    };
    
</script>

<form class="LoginForm" action="Login.php" method="post">
    <ul id="Form">
        <?php 
            if(isset($_POST['Register'])){
                echo "<script>$(document).ready(function(){ GoRegister(); });</script>";
            }else{
                echo "<script>$(document).ready(function(){ GoLogin(); });</script>";
            }
        ?>
    </ul>
</form>
<ul id="FormLogin" class="Hidden">
    <li>Username: <input name="username" value="<?php EchoPostVal('username'); ?>" type="text" size="25" maxlength="75" required></li>
    <li>Password: <input name="password" type="password" size="25" maxlength="75" required></li>
    <li><input name="Login" type="submit" value="Login"></li>
    <li><a href="#" onclick="GoRegister();">Register Account</a></li>
</ul>
<ul id="FormRegister" class="Hidden">
    <li>Username: <input name="username" value="<?php EchoPostVal('username'); ?>" type="text" size="25" maxlength="75" required></li>
    <li>Real name: <input name="realname" value="<?php EchoPostVal('realname'); ?>" type="text" size="25" maxlength="75" required></li>
    <li>E-mail: <input name="email" value="<?php EchoPostVal('email'); ?>" type="text" size="25" maxlength="75" required></li>
    <li>Password: <input name="password" type="password" size="25" maxlength="75" required></li>
    <li>Repeat-Password: <input name="passwordrepeat" type="password" size="25" maxlength="75" required></li>
    <li><input name="Register" type="submit" value="Register"></li>
    <li><a href="#" onclick="GoLogin();">Go to Login</a></li>
</ul>