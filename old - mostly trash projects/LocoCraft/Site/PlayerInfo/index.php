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
        <link rel="stylesheet" type="text/css" href="<?php echo $config->MainPath . "/AddOns/Styles/PlayerInfo.css"; ?>"/>
        <script src="<?php echo $config->MainPath . "/AddOns/JavaScripts/Container.js"; ?>"></script>
        <script src="<?php echo $config->MainPath . "/AddOns/JavaScripts/JQuery.js"; ?>"></script>
    </head>
    <body class="SetBackground">
        <?php 
            include($config->MainPathRaw . "/AddOns/PageInclude/Footer.php");
            include($config->MainPathRaw . "/AddOns/PageInclude/Top.php"); 
        ?>
        <div class="container">
            <div class="PlayerInfoT">
                <table class="PlayerInfoT">
                    <tr class="PlayerInfoT">
                        <th class="PlayerInfoT">Naam</th>
                        <th class="PlayerInfoT">Eerste Login</th>
                        <th class="PlayerInfoT">Laatste Login</th>
                    </tr>
                    <?php
                        $connect = mysqli_connect('mysql.kaashosting.nl', 'KH_4592', 'df3ca53026') or die ('Couldn\'t Connect');
                        mysqli_select_db($connect, "KH_4592") or die ("Couldn't Find your database !");

                        $query = sprintf("SELECT * FROM BAT_players ORDER BY BAT_player",
                        mysqli_real_escape_string($connect, $username),
                        mysqli_real_escape_string($connect, $password));
                        $rows = mysqli_query($connect, $query);
                        $Counting = 0;
                        $numrows = mysqli_num_rows($rows); 
                        while($row = mysqli_fetch_assoc($rows)){
                            $Counting = $Counting + 1;
                            $DBNaam = $row['BAT_player'];
                            $DBFirstLogin = $row['firstlogin'];
                            $DBLastLogin = $row['lastlogin'];
                            echo '<tr class="PlayerInfoT">';
                            echo("<th class=\"PlayerInfoT\">".$DBNaam."</th>");
                            echo("<th class=\"PlayerInfoT\">".$DBFirstLogin."</th>");
                            echo("<th class=\"PlayerInfoT\">".$DBLastLogin."</th>");
                            echo '</tr">';
                        }
                    ?>
                </table>
            </div>
            <br>
            <?php
                echo "<p class=\"info\">Max players: ". $Counting."</p>";
                echo"<a href='http://lococraft.nl.eu.org/Site/ServerStatus/'>Currently online</a>";
            ?>
            <br>
            <br>
        </div>
    </body>
</html>

