<!DOCTYPE html>
<?php
    $config = include $_SERVER['DOCUMENT_ROOT'] . "/Site" . '/AddOns/PhP/Config.php';
    session_start();
    require $config->MainPathRaw . '/AddOns/PhP/Utils.php';
    $Utils = new Utils();
    $Utils->ConnectCheck();
?>
<html>
    <head>
        <title><?php echo $config->ServerTitle; ?> - Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="<?php echo $config->MainPath . "/AddOns/Pictures/Image.ico"; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo $config->MainPath . "/AddOns/Styles/Container.css"; ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $config->MainPath . "/AddOns/Styles/Login.css"; ?>"/>
        <script src="<?php echo $config->MainPath . "/AddOns/JavaScripts/Container.js"; ?>"></script>
        <script src="<?php echo $config->MainPath . "/AddOns/JavaScripts/JQuery.js"; ?>"></script>
    </head>
    <body class="SetBackground">
        <?php 
            include($config->MainPathRaw . "/AddOns/PageInclude/Footer.php");
            include($config->MainPathRaw . "/AddOns/PageInclude/Top.php"); 
        ?>
        <div class="container">
            <object class="LoginBox" id="container" type="text/html" data="LoginPage.php" >
            </object>
        </div>
    </body>
</html>

