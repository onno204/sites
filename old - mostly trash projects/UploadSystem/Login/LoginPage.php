<?php include('options.php'); 


$config = include '../Config.php';
    require '../Utils.php';
    $Utils = new Utils();
    //$Utils->ConnectCheck();
session_start();
if(isset($_SESSION['username'])){
    die('<p>Already logged in as: ' . $_SESSION['username'] . '</p>' .
            '<p>Login email: ' . $_SESSION['email'] . '</p>' .
            '<a href="logout.php">Logout</a><br>' .
            '<a href=\'/../\' target="_top">Return to the Mainsite</a>');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title ?></title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
    <center>
    <h1>Login</h1>
        <form action="login.php" method="post">
            <p>Username: <input name="username" type="text" size="25" maxlength="25" /></p>
            <p>Password: <input name="password" type="password" size="25" maxlength="25" /></p>
            <p><input name="submit" type="submit" value="Log in" /></p>
            <a href='register.php'>Register Account</a>
        </form>
    </center>
</div>
</body>
</html>