<?php 
include('options.php'); 
$config = include '../Config.php';
require '../Utils.php';
$Utils = new Utils();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="container">
    
<?php 
if(get_magic_quotes_gpc()) {
    $_GET = strip_slashes_deep($_GET);
    $_POST = strip_slashes_deep($_POST);
}

function strip_slashes_deep($data) {
    if(is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = strip_slashes_deep($value);
        }
        return $data;
    }
    else
    {
    return stripslashes($data);
    }
}

$submit = $_POST['submit'];
$nickname = $_POST['nickname'];
$username = $_POST['username'];
$password = $_POST['password'];
$password2 = $_POST['password2'];
$email = $_POST['email'];
$ip = $Utils->get_client_ip();
$date = date("Y-m-d");

if ($submit) {
    if ($nickname&&$username&&$password&&$password2&&$email) {
        if($password == $password2) {
            if(strlen($username) > 25 || strlen($nickname) > 25) {
                echo "Username and Nickname maximum is 25 characters";
            }else {
                if(strlen($password) > 25 || strlen($password) < 6) {
                echo "Password must be between 6 - 25 characters!";
                }else {
                
                $connection = mysqli_connect($config->DBIp, $config->username, $config->pass) or die ('Couldn\'t Connect');
                mysqli_select_db($connection, $config->database) or die ("Couldn't Find your database !");
                //encrypt password
                $password = sha1($password);
                $password2 = sha1($password2);
                
                //Dubble user check
                $DoubleUserQuery = "SELECT * FROM `users` WHERE username='" . $Utils->FormatString($username) . "'";
                $rowss = mysqli_query($connection, $DoubleUserQuery);
                
                while($roww = mysqli_fetch_assoc($rowss)){
                    if(strtolower($roww['username']) === strtolower($username)){
                        echo'<center>
                                <h1>Register</h1>
                                <h2>Username Already exists</h2>
                                <form action="register.php" method="post" id="register">
                                    <fieldset>
                                        <p>Username: <input name="username" type="text" value="'. $username . '" size="25" maxlength="25" /></p>
                                        <p>Password: <input name="password" type="password" size="25" maxlength="25" /></p>
                                        <p>Repeat Password: <input name="password2" type="password" size="25" maxlength="25" /></p>
                                        <p>Nick Name: <input name="nickname" type="text" value="'. $nickname . '" size="25" maxlength="25" /></p>
                                        <p>Email: <input name="email" type="text" value="'. $email . '" size="25" maxlength="25" /></p>
                                        <input name="submit" type="submit" value="Register" />
                                    </fieldset>
                                </form>
                            </center>
                            </div>
                            </body>
                            </html>';
                        die();
                    }
                }
                $DoubleNickQuery = "SELECT * FROM `users` WHERE nickname='" . $Utils->FormatString($nickname) . "'";
                $rowsss = mysqli_query($connection, $DoubleNickQuery);
                
                while($roww = mysqli_fetch_assoc($rowsss)){
                    if(strtolower($roww['nickname']) === strtolower($nickname)){
                        echo'<center>
                                <h1>Register</h1>
                                <h2>Nickname already in use by: '.$roww['username'].'</h2>
                                <form action="register.php" method="post" id="register">
                                    <fieldset>
                                        <p>Username: <input name="username" type="text" value="'. $username . '" size="25" maxlength="25" /></p>
                                        <p>Password: <input name="password" type="password" size="25" maxlength="25" /></p>
                                        <p>Repeat Password: <input name="password2" type="password" size="25" maxlength="25" /></p>
                                        <p>Nick Name: <input name="nickname" type="text" value="'. $nickname . '" size="25" maxlength="25" /></p>
                                        <p>Email: <input name="email" type="text" value="'. $email . '" size="25" maxlength="25" /></p>
                                        <input name="submit" type="submit" value="Register" />
                                    </fieldset>
                                </form>
                            </center>
                            </div>
                            </body>
                            </html>';
                        die();
                    }
                }
                
                
                //Register the user!
                $query = "INSERT INTO users SET
                username    = '". $Utils->FormatString($username) ."',
                password    = '". $Utils->FormatString($password) ."',
                nickname = '". $Utils->FormatString($nickname) ."',
                email     = '". $Utils->FormatString($email) ."',
                registerIP       = '". $Utils->FormatString($ip) ."',
                date      = '". $Utils->FormatString($date) ."'";
                
                
                
                mysqli_query($connection, $query);
                
                die("Successfully registered please <a href='LoginPage.php'>Log in</a>!");
                }
            }
        }else {
            echo "Password does not match!";
        }
    }else{
        echo "Please fill in all fields!";
    }
}
?>
<center>
    <h1>Register</h1>

    <form action="register.php" method="post" id="register">
        <fieldset>
            <p>Username: <input name="username" type="text" value="<?php echo $username; ?>" size="25" maxlength="25" /></p>
            <p>Password: <input name="password" type="password" size="25" maxlength="25" /></p>
            <p>Repeat Password: <input name="password2" type="password" size="25" maxlength="25" /></p>
            <p>Nick Name: <input name="nickname" type="text" value="<?php echo $nickname; ?>" size="25" maxlength="25" /></p>
            <p>Email: <input name="email" type="text" value="<?php echo $email; ?>" size="25" maxlength="25" /></p>
            <input name="submit" type="submit" value="Register" />
        </fieldset>
    </form>
</center>
</div>
</body>
</html>