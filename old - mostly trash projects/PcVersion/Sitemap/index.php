<?php 
    $Type = $_GET['Type'];
    $Selected = $_GET['Selected'];
    $Option = $_GET['Option'];
    
    $TypeFolder = $Type.'/';
    if($Type == ""){ $TypeFolder = ""; }
    if($Selected == ""){ $Selected = "Default"; }
    if($Option == ""){ $Option = "php"; }
    $SelectedFile = $TypeFolder . $Selected . "." . $Option;
    if(file_exists($SelectedFile) == FALSE){ $SelectedFile = "Default/start.php"; }
?>
<!DOCTYPE html>
<html>
    <head>
        <?php 
            $Title = $Selected;
            if ($Title == "Default"){ $Title = "Main Page"; }
            echo"<title>Onno204 - $Selected </title>"; 
        ?>
        <?php include("AddOns/phps/InsertSheets.php"); ?>
    </head>
    <body>
        <div class="container">
            <div class="Left">
                <?php include("AddOns/phps/MainMenu.php"); ?>
            </div>
            <div class="Left up"> 
                <?php include( $SelectedFile ); ?>
            </div>
            <div class="Footer"> 
                ©onno204 - Premium Neq3Host host(Awsome host!) - Webmaster@onno204.nl.eu.org - Skype: onnovanh - onno204©
            </div>
        </div>
        <!--
            <audio id="ClickAudio" src="AddOns/Sounds/Click.wav" ></audio>
        -->
    </body>
</html>
