<!DOCTYPE html>
<?php
    $config = include '../AddOns/PhP/Config.php';
    require $_SERVER['DOCUMENT_ROOT'] . "/Site" . '/AddOns/PhP/Utils.php';
    $Utils = new Utils();
    $Utils->ConnectCheck();
?>
<html>
    <head>
        <title>Onno204 Site - home</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="<?php echo $config->MainPath . "/AddOns/Pictures/Image.ico"; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo $config->MainPath . "/AddOns/Styles/Container.css"; ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $config->MainPath . "/AddOns/Styles/ServerStatus.css"; ?>"/>
        <script src="<?php echo $config->MainPath . "/AddOns/JavaScripts/Container.js"; ?>"></script>
        <script src="<?php echo $config->MainPath . "/AddOns/JavaScripts/JQuery.js"; ?>"></script>
        <script src="<?php echo $config->MainPath . "/AddOns/JavaScripts/ServerStatus.js"; ?>"></script>
    </head>
    <body class="SetBackground">
        <?php 
            include($config->MainPathRaw . "/AddOns/PageInclude/Footer.php");
            include($config->MainPathRaw . "/AddOns/PageInclude/Top.php"); 
        ?>
        
        <div class="container" id="container">
            <script>
                OpenServerStatusConnection("ws://lima.kaashosting.nl:31308", "Lobby");
                OpenServerStatusConnection("ws://lima.kaashosting.nl:31309", "Minetopia");
                OpenServerStatusConnection("ws://lima.kaashosting.nl:31304", "Bungeecord");
            </script>
            <div class="BanList">
                
                <table class="BanList">
                    <tr class="BanList" style="background-color: gray;">
                        <th>Server:</th>
                        <th>Status:</th>
                        <th>Version:</th>
                        <th>Online:</th>
                        <th>Players:</th>
                        <th>Whitelist:</th>
                    </tr>
                    <?php
                    session_start();
                        require 'MinecraftQuery.php';
                        require 'MinecraftQueryException.php';

                        use xPaw\MinecraftQuery;
                        use xPaw\MinecraftQueryException;
                        
                        $Query = new MinecraftQuery();
                        $Servers = array(
                            'Bungeecord' => "138.201.23.46:42331",
                            'Minetopia' => "138.201.23.46:16781",
                            'Lobby' => "138.201.23.46:9678");
                        while ($ServerIP = current($Servers)) {
                            $ServerName = key($Servers);
                            $IpSplit = explode(":", $ServerIP);
                            echo '<tr>';
                            echo '<th style="width: 50px;">'.$ServerName.'</th>';
                            try{
                                $Query->Connect( $IpSplit[0], $IpSplit[1], 5, false );
                                $Info = $Query->GetInfo();
                                echo '<th id="OnlineStatus'.$ServerName.'" class="OnlineStatus">Online</th>';
                                echo '<th id="Version'.$ServerName.'" style="width: 150px;">'.$Info['Version'].' and higher</th>';
                                echo '<th id="OnlinePlayers'.$ServerName.'" style="width: 20px;">'.$Info['Players'].'</th>';
                                echo '<th id="Players'.$ServerName.'">'.$Info['PlayerNames'].'</th>';
                                echo '<th id="Whitelist'.$ServerName.'" style="width: 75px;">'.$Info['Whitelist'].'</th>';
                            }catch( MinecraftQueryException $e ) {
                                echo '<th id="OnlineStatus'.$ServerName.'" class="OfflineStatus">'.$e->getMessage().'</th>';
                                echo '<th id="Version'.$ServerName.'" style="width: 150px;">'.$e->getMessage().' and higher</th>';
                                echo '<th id="OnlinePlayers'.$ServerName.'" style="width: 20px;">'.$e->getMessage().'</th>';
                                echo '<th id="Players'.$ServerName.'">'.$e->getMessage().'</th>';
                                echo '<th id="Whitelist'.$ServerName.'" style="width: 75px;">'.$e->getMessage().'</th>';
                            }
                            echo '</tr>';
                            next($Servers);
                        }
                    ?>
                </table>

            </div>
        </div>
    </body>
</html>

