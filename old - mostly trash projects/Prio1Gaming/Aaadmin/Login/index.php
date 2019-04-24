<!DOCTYPE html>
<?php
    $config = include '../Config.php';
    session_start();
    require '../Utils.php';
    $Utils = new Utils();
    //$Utils->ConnectCheck();
?>
<html>
    <head>
        <title><?php echo $config->ServerTitle; ?> - Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="style.css" rel="stylesheet" type="text/css" />
    </head>
    <body class="SetBackground">
        <div class="container">
            <center>
                <object class="LoginBox fixed" id="container" type="text/html" data="LoginPage.php" >
                </object>
            </center>
        </div>
    </body>
</html>

