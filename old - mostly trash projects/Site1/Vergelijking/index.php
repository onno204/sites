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
        <title><?php echo $config->ServerTitle; ?> - Vergelijking</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="<?php echo $config->MainPath . "/AddOns/Pictures/Image.ico"; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo $config->MainPath . "/AddOns/Styles/Container.css"; ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $config->MainPath . "/AddOns/Styles/Vergelijking.css"; ?>"/>
        <script src="<?php echo $config->MainPath . "/AddOns/JavaScripts/Container.js"; ?>"></script>
        <script src="<?php echo $config->MainPath . "/AddOns/JavaScripts/JQuery.js"; ?>"></script>
        <script src="<?php echo $config->MainPath . "/AddOns/JavaScripts/Vergelijking.js"; ?>"></script>
    </head>
    <body class="SetBackground">
        <?php 
            include($config->MainPathRaw . "/AddOns/PageInclude/Footer.php");
            include($config->MainPathRaw . "/AddOns/PageInclude/Top.php");
        ?>
        <div class="container" id="container">
            <div class="Vergelijking">
                <table class="Vergelijking">
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> Type </th>
                        <th class="Vergelijking"> Neq3host </th>
                        <th class="Vergelijking"> vimexx </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> Price </th>
                        <th class="Vergelijking"> €1,29/Month </th>
                        <th class="Vergelijking"> €0,45/Month </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> Storage </th>
                        <th class="Vergelijking"> 20GB </th>
                        <th class="Vergelijking"> 2GB </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> Bandwidth </th>
                        <th class="Vergelijking"> 200GB/Month </th>
                        <th class="Vergelijking"> 25GB/Month </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> Domains </th>
                        <th class="Vergelijking"> Unlimited </th>
                        <th class="Vergelijking"> 25 </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> BackUps </th>
                        <th class="Vergelijking"> Unlimited </th>
                        <th class="Vergelijking"> 7x per Day </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> Free domain </th>
                        <th class="Vergelijking"> None </th>
                        <th class="Vergelijking"> None </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> CPU </th>
                        <th class="Vergelijking"> 4Core's </th>
                        <th class="Vergelijking"> 1Core </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> RAM </th>
                        <th class="Vergelijking"> 32GB </th>
                        <th class="Vergelijking"> 1GB </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> free SSL </th>
                        <th class="Vergelijking"> Unlimited </th>
                        <th class="Vergelijking"> Unlimited </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> Cache </th>
                        <th class="Vergelijking"> 100% </th>
                        <th class="Vergelijking"> 80% </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> WebsiteMoving service </th>
                        <th class="Vergelijking"> yes </th>
                        <th class="Vergelijking"> no </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> Website Creator </th>
                        <th class="Vergelijking"> Yes </th>
                        <th class="Vergelijking"> Yes </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> Emails per day </th>
                        <th class="Vergelijking"> Unlimited </th>
                        <th class="Vergelijking"> 500 </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> ControlPanel </th>
                        <th class="Vergelijking"> CPanel </th>
                        <th class="Vergelijking"> DirechtAdmin </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> PhP Version </th>
                        <th class="Vergelijking"> 5.x - 7 - 7.1 </th>
                        <th class="Vergelijking"> 5.x - 7 </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> Charge Back </th>
                        <th class="Vergelijking"> 30Day's </th>
                        <th class="Vergelijking"> 14Day's </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> Subdomains </th>
                        <th class="Vergelijking"> Unlimited </th>
                        <th class="Vergelijking"> Unlimited </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> Automatic Scripts </th>
                        <th class="Vergelijking"> Unlimited </th>
                        <th class="Vergelijking"> Unlimited </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> Application Installer </th>
                        <th class="Vergelijking"> Softacules </th>
                        <th class="Vergelijking"> Installatron </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> Databases </th>
                        <th class="Vergelijking"> Unlimited </th>
                        <th class="Vergelijking"> Unlimited </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> MySQL Version </th>
                        <th class="Vergelijking"> 5.7 </th>
                        <th class="Vergelijking"> 5.7 </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> Email's </th>
                        <th class="Vergelijking"> Unlimited </th>
                        <th class="Vergelijking"> Unlimited </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> Email Extra's </th>
                        <th class="Vergelijking"> Forwarder, AutoResponder, Mailing Lists, Email Filter, spamAssasin </th>
                        <th class="Vergelijking"> Forwarder, AutoResponder, SpamFilter </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> FTP Accounts </th>
                        <th class="Vergelijking"> Unlimited </th>
                        <th class="Vergelijking"> Unlimited </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> AutoBackup </th>
                        <th class="Vergelijking"> Monthly </th>
                        <th class="Vergelijking"> Daily </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> Self-Backups </th>
                        <th class="Vergelijking"> Unlimited, Restore, create </th>
                        <th class="Vergelijking"> Unlimited, Restore, create </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> Logs </th>
                        <th class="Vergelijking"> yes </th>
                        <th class="Vergelijking"> yes </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> Statistics </th>
                        <th class="Vergelijking"> yes </th>
                        <th class="Vergelijking"> yes </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> SEO and Marketing Tools </th>
                        <th class="Vergelijking"> yes </th>
                        <th class="Vergelijking"> no </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> CloudFlare </th>
                        <th class="Vergelijking"> yes </th>
                        <th class="Vergelijking"> no </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> Instant Active </th>
                        <th class="Vergelijking"> yes </th>
                        <th class="Vergelijking"> yes </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> DDOS Protection </th>
                        <th class="Vergelijking"> yes </th>
                        <th class="Vergelijking"> - </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> Virus Scanner </th>
                        <th class="Vergelijking"> Yes </th>
                        <th class="Vergelijking"> No </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> Networkspeed </th>
                        <th class="Vergelijking"> 1GBs </th>
                        <th class="Vergelijking"> - </th>
                    </tr>
                    <tr class="Vergelijking">
                        <th class="Vergelijking"> Support </th>
                        <th class="Vergelijking"> Instant </th>
                        <th class="Vergelijking"> Forums </th>
                    </tr>
                </table>
                <br>
            </div>
        </div>
    </body>
</html>

