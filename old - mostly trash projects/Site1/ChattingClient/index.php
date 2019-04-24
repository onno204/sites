<!DOCTYPE html>
<?php
    $config = include $_SERVER['DOCUMENT_ROOT'] . "/Site1" . '/AddOns/PhP/Config.php';
    session_start();
    require $config->MainPathRaw . '/AddOns/PhP/Utils.php';
    $Utils = new Utils();
    $Utils->ConnectCheck();
?>
<html>
    <head>
        <title><?php echo $config->ServerTitle; ?> - ChatClient</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="<?php echo $config->MainPath . "/AddOns/Pictures/Image.png"; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo $config->MainPath . "/AddOns/Styles/Container.css"; ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $config->MainPath . "/AddOns/Styles/ChattingClient.css"; ?>"/>
        <script src="<?php echo $config->MainPath . "/AddOns/JavaScripts/Container.js"; ?>"></script>
        <script src="<?php echo $config->MainPath . "/AddOns/JavaScripts/JQuery.js"; ?>"></script>
        <script src="<?php echo $config->MainPath . "/AddOns/JavaScripts/ChattingClient.js"; ?>"></script>
    </head>
    <body class="SetBackground">
        <?php 
            include($config->MainPathRaw . "/AddOns/PageInclude/Footer.php");
            include($config->MainPathRaw . "/AddOns/PageInclude/Top.php");
        ?>
        <div class="container" id="container">
            <?php
            if(!isset($_SESSION['nickname'])){ die("<h1>Pleass logging before viewing this page!</h1>" . $_SESSION['nickname']); }
            
            echo '
                <script>
                    OpenServerStatusConnection("ws://lima.kaashosting.nl:12333", "' . $_SESSION['nickname']. '");
                </script>
            ';
            ?>
            
            <select class="Inline Clients" name="Clients" id="Clients" size="10" onclick="SelectChat()">
                <option value="GlobalChat">GlobalChat</option>
            </select>
            <div class="SendMessage Inline">
                Message: <input class="Inline SendMessageMsgBox" id="Message" onclick="SendClickedE()" name="Message" type="text" size="25" maxlength="250" />
                <input class="Inline" name="submit" type="submit" value="Send" onclick="SendClicked()"/> 
            </div>
            <div class="CurrentUser" id="CurrentUser">GlobalChat</div>
            <div class="Messages Inline" id="Messages">
            </div>
        </div>
    </body>
</html>

