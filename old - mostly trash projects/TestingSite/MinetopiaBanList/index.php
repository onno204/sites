<!DOCTYPE html>
<?php
    $config = include '../AddOns/PhP/Config.php';
?>
<html>
    <head>
        <title>Onno204 Site - home</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="<?php echo $config->MainPath . "/AddOns/Pictures/Image.ico"; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo $config->MainPath . "/AddOns/Styles/Container.css"; ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $config->MainPath . "/AddOns/Styles/Download.css"; ?>"/>
        <script src="<?php echo $config->MainPath . "/AddOns/JavaScripts/Container.js"; ?>"></script>
        <script src="<?php echo $config->MainPath . "/AddOns/JavaScripts/JQuery.js"; ?>"></script>
    </head>
    <body class="SetBackground">
        <?php 
            include($config->MainPathRaw . "/AddOns/PageInclude/Footer.php");
            include($config->MainPathRaw . "/AddOns/PageInclude/Top.php"); 
        ?>
        
        <div class="container" id="container">
            <?php
                $homepage = file_get_contents('http://46.249.47.242:8778/BanList?name=' + $_GET['name']);
                echo $homepage;
            ?>
            
            
            
        </div>
    </body>
</html>

