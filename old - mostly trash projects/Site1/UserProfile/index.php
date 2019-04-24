<!DOCTYPE html>
<?php
    $config = include $_SERVER['DOCUMENT_ROOT'] . "/Site1" . '/AddOns/PhP/Config.php';
    session_start();
    require $config->MainPathRaw . '/AddOns/PhP/Utils.php';
    $Utils = new Utils();
    $Utils->ConnectCheck();
    session_start();
?>
<html>
    <head>
        <title><?php echo $config->ServerTitle; ?> - UserProfiles</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="<?php echo $config->MainPath . "/AddOns/Pictures/Image.png"; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo $config->MainPath . "/AddOns/Styles/Container.css"; ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $config->MainPath . "/AddOns/Styles/UserProfile.css"; ?>"/>
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
            $Username = $Utils->FormatString($_GET['Username']);
            if(!isset($Username)){
                echo ' <div class="Selector">
                <table class="Selector">
                    <tr class="Selector">
                        <th class="Selector"> NickName </th>';
                        if($Utils->HasPerms("Profile_Username")){ echo '<th class="Selector">Username</th>'; }
                        if($Utils->HasPerms("Profile_ViewIP")){ echo '<th class="Selector">Last-IP</th>'; }
                        if($Utils->HasPerms("Profile_Manager")){ echo '<th class="Selector">B</th>'; }
                    echo '</tr>';
                    if(!isset($_SESSION['nickname'])){ die("<h1>Pleass logging before viewing this page!</h1>" . $_SESSION['nickname']); }
                        if(!$Utils->HasPerms("Profile_List")){ die("<h2>I'm sorry to inform you that you can't view the user list.</h2>"); }
                        $connect = mysqli_connect($config->DBIp, $config->username, $config->pass) or die ('Couldn\'t Connect to the host, ' . mysqli_error($connect));
                        mysqli_select_db($connect, $config->database) or die ("Couldn't Find your database !");

                        $query = sprintf("SELECT * FROM users ORDER BY `Banned` ASC, `nickname` ASC");
                        $rows = mysqli_query($connect, $query);
                        $TotalUsers = 0;
                        $TotalBanned = 0;
                        while($row = mysqli_fetch_assoc($rows)){ 
                            echo '<tr class="Selector">';
                                echo '<th class="Selector"><a class="Selector" href="?Username='. $row['username'] . '">'. $row['nickname'] . '</a></th>'; 
                                $TotalUsers = $TotalUsers+1;
                                if($row['Banned']){ $TotalBanned = $TotalBanned+1; }
                                if($Utils->HasPerms("Profile_Username")){ echo '<th class="Selector">'. $row['username'] . '</th>'; }
                                if($Utils->HasPerms("Profile_ViewIP")){ echo '<th class="Selector IP">'. $row['LastIP'] . '</th>'; }
                                if($Utils->HasPerms("Profile_Manager")){
                                    if($row['Banned']){ echo '<th class="Selector Banned"></th>'; 
                                    }else{ echo '<th class="Selector NotBanned"></th>'; 
                                    }
                                }
                            echo '</tr>';
                        }
                        if($Utils->HasPerms("Profile_ViewBanned")){
                            echo '<tr class="Selector">';
                                echo '<th class="Selector">Total Users: '. $TotalUsers . '</th>';
                                echo '<th class="Selector">Total BannedUsers: '. $TotalBanned . '</th>';
                                echo '<th class="Selector">Total UnbannedUsers: '. ($TotalUsers-$TotalBanned) . '</th>';
                            echo '</tr>';
                        }
                        
                    echo '
                    </table>
                        </div>';
                    
            }else{
                if(!$Utils->HasPerms("Profile_View")){ die("<h2>I'm sorry to inform you that you can't view the user profiles.</h2>"); }
                $connect = mysqli_connect($config->DBIp, $config->username, $config->pass) or die ('Couldn\'t Connect to the host, ' . mysqli_error($connect));
                mysqli_select_db($connect, $config->database) or die ("Couldn't Find your database !");

                $query = "SELECT * FROM users WHERE `username`='".$Username."'";
                $rows = mysqli_query($connect, $query);
                $RowC = mysqli_num_rows($rows);
                if($RowC){
                    while($row = mysqli_fetch_assoc($rows)){
                        
                        
                        if($_SESSION['username'] == $Username){
                            $image = addslashes(file_get_contents($_FILES['image']['tmp_name'])); //SQL Injection defence!
                            $image_name = addslashes($_FILES['image']['name']);
                            $sql = "INSERT INTO `product_images` (`id`, `image`, `image_name`) VALUES ('1', '{$image}', '{$image_name}')";
                            if (!mysql_query($sql)) { echo "Something went wrong! Just relaxe take a coffee of than after you send an email to webmaster@onno204.nl.eu.org"; }
                        }
                        
                        
                        
                    }
                    echo "<h2>Not sure what to put here :) <br> Mail idea's: webmaster@onno204.nl.eu.org</h2>"; 
                }else{
                    echo "<h2>The user profile: " . $Username . " wasn't found</h2>"; 
                }
            }
            ?>
        </div>
    </body>
</html>

