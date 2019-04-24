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
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="AddOns/Pictures/Image.ico" />
        <title>RealLands Server Site</title>
        <link rel="stylesheet" type="text/css" href="AddOns/Styles/AddOns.css"/>
        <link rel="stylesheet" type="text/css" href="AddOns/Styles/Default.css"/>
        <link rel="stylesheet" type="text/css" href="AddOns/Styles/ServerLayout.css"/>
        <link rel="stylesheet" type="text/css" href="AddOns/Styles/Login.css"/>
        <script src="AddOns/JavaScripts/LittleProjects.js"></script>
        <script src="AddOns/JavaScripts/index.js"></script>
        <script src="AddOns/JavaScripts/Servers.js"></script>
        <script src="AddOns/JavaScripts/JQuery.js"></script>
        <script src="AddOns/JavaScripts/MainMenu.js"></script>
    </head>
    <body style="background-color: aqua;">
        <div class='ImgOverlay' id='ImgOverlay'>
            <div id="ImgOverlayImg" class='ImgOverlayImg'>
                <img src="AddOns/Pictures/Image.png">
            </div>
            <h1>Loading time depends on your internet speed!</h1>
            <h4>The Profile pages can take a pit longer to load!</h4>
        </div>
        <div class="Overlay" id="Overlay">
            <div class="OverlayText" id="OverlayText"><?php
            $DenyClose = FALSE;
            $ClearSession = FALSE;
            require_once 'AddOns/phps/MySQL.php';
            
            $MysqlClass = new MySQL();
            echo $MysqlClass->Connect();
            $MysqlClass->CheckConnection();
            $MysqlClass->First();
            session_start();
            $SUsername = $_SESSION["username"];
            $SPassword = $_SESSION["password"];
            $SSessioned = $_SESSION["sessioned"];
            if($SUsername == ""){
                //not logged in
            }else{
                echo $SUsername . "<br>";
                $DBPassword = $MysqlClass->GetUserPassword($SUsername);
                if ($SPassword == ""){ 
                    $DenyClose = TRUE;
                    echo 'Error while getting your password!';
                    $ClearSession = TRUE;
                }else if( $SPassword != $DBPassword ){
                    $DenyClose = TRUE;
                    echo 'Password changed!<br> pleass use your new password!<br>';
                    $ClearSession = TRUE;
                }else if($SPassword == $DBPassword ){
                    echo '<script> CloseOverlay(); </script>';
                }else{
                    $DenyClose = TRUE;
                    echo 'You f*cked up!';
                    $ClearSession = TRUE;
                    
                }
            }
                if(!$DenyClose){
                    echo '<div class="CloseButton" onclick="CloseOverlay()">X</div>';
                }else{
                    echo '<div class="CloseButton">You are not allowed to close this!</div>';
                }
                if($ClearSession){
                    echo 'Your Session was DESTROYED!<br>';
                    session_unset();
                    session_destroy(); 
                }
            
        ?></div>
        </div>
        <div class="Overlay" id="Overlay2">
            <div class="OverlayText" id="OverlayText2"><?php
            echo '<div class="CloseButton" onclick="CloseOverlay2()">X</div>';
            $file = $_FILES['ProfilePicture']['tmp_name'];
            if( isset($file) ){
                if(getimagesize($_FILES['ProfilePicture']['tmp_name']) == FALSE) {
                    echo "NO IMAGE FOUND!<br>";
                }else{
                    echo getimagesize($_FILES['ProfilePicture']['tmp_name']);
                    $image= addslashes($_FILES['ProfilePicture']['tmp_name']);
                    $name= addslashes($_FILES['ProfilePicture']['tmp_name']);
                    $image= file_get_contents($image);
                    $image= base64_encode($image);
                }
                if(FALSE){ echo "Your file wasn't a image?<br>";
                }else{
                    $Image= base64_encode($Image);
                    echo $_SESSION["username"];
                    echo "Uploading....<br>";
                    $MysqlClass->SaveImage($_SESSION["username"], $image); 
                    echo "Uploaded!.<br>";
                }
            }else{
                echo '<script> CloseOverlay2() </script>';
            }
        ?></div>
        </div>
        
        <div class="LoginOverlay" id="LoginOverlay">
            <div class="CloseButton" onclick="ToggleLogin()">X</div>
                <div class="LoginOverlayText" id="LoginOverlayText"><?php
                    $ReceivedLoginPassword = $_POST['password'];
                    $ReceivedLoginUsername = $_POST['username'];
                    $ReceivedLogin = $_POST['Login'];
                    $Sessiond = $_SESSION["sessioned"];
                    if(($ReceivedLogin != "TRUE") && ($Sessiond != TRUE)){
                        echo '
                            <form id="LoginForm" class="LoginAsignMiddle" action="" method="POST">
                                <div class="LoginBar">
                                Username: <input type="text" name="username" maxlength="100" required><br>
                                </div>
                                <div class="LoginBar">
                                Password: <input type="password" name="password" maxlength="100" required ><br>
                                </div>
                                <input class="hide" type="text" name="Login" value="TRUE" maxlength="100"><br>
                                <input type="submit">
                            </form>
                        ';
                    }else if($Sessiond != TRUE){
                        $LoggedIn = $MysqlClass->LoginUser($ReceivedLoginUsername, $ReceivedLoginPassword);
                        if ($LoggedIn == TRUE){
                            echo 'Logging you in...<br>';
                            $row = $MysqlClass->GetUserIdentitie($ReceivedLoginUsername, $ReceivedLoginPassword);
                                $_SESSION["username"] = $row["username"];
                                $_SESSION["password"] = $row['password'];
                                $_SESSION["gender"] = $row['gender'];
                                $_SESSION["age"] = $row['age'];
                                $_SESSION["email"] = $row['email'];
                                $_SESSION["fullname"] = $row['fullname'];
                                $_SESSION["about"] = $row['about'];
                                $_SESSION["phone"] = $row['phone'];
                                $_SESSION["submitedform"] = TRUE;
                                $_SESSION["sessioned"] = TRUE;
                            
                            echo 'Succesfully logged in!<br> Welkom ' . $_SESSION["fullname"] . "<br>";
                        }else{
                            echo "NOT LOGGEDIN!";
                            echo '
                                <form id="LoginForm" class="LoginAsignMiddle" action="" method="POST">
                                    <div class="LoginBar">
                                    Username: <input type="text" name="username" maxlength="100" required><br>
                                    </div>
                                    <div class="LoginBar">
                                    Password: <input type="password" name="password" maxlength="100" required ><br>
                                    </div>
                                    <input class="hide" type="text" name="Login" value="TRUE" maxlength="100"><br>
                                    <input type="submit">
                                </form>
                            ';
                        }
                    }else if($Sessiond == TRUE){
                        echo 'Logged in as: '.$_SESSION["username"];
                        echo '<script> ToggleLogin(); </script>';
                    }else{
                        echo 'SOMETHING REALY WHENT WRONG THOUGH!';
                    }
                    /*
                        $_POST['Finished'] = "TRUE";
                        $_SESSION["username"] = $ReceivedUsername;
                        $_SESSION["password"] = $ReceivedPassword;
                        $_SESSION["gender"] = $ReceivedGender;
                        $_SESSION["age"] = $ReceivedAge;
                        $_SESSION["email"] = $ReceivedEMail;
                        $_SESSION["fullname"] = $ReceivedFullname;
                        $_SESSION["about"] = $ReceivedAbout;
                        $_SESSION["phone"] = $ReceivedPhone;
                        $_SESSION["submitedform"] = $ReceivedSubmit;
                        $_SESSION["sessioned"] = TRUE;
                    */        
                
                ?></div>
        </div>
        <div class="LoginOverlay" id="RegisterOverlay">
            <div class="CloseButton" onclick="ToggleRegister()">X</div>
                <div class="LoginOverlayText" id="RegisterOverlayText">
                    <form id="RegisterForm" class="LoginAsignMiddle" action="" method="POST"><?php
                                $ReceivedSubmit = $_POST['submitted'];
                                $ReceivedSubmit2 = $_POST['submitted1'];
                                $Finished = $_POST['Finished'];
                                $Error = FALSE;
                                $HideRegister = FALSE;
                                echo $ReceivedSubmit2;
                                if(( ($ReceivedSubmit != "TRUE") && ($ReceivedSubmit2 != "TRUE") ) && ($_SESSION['sessioned'] !=TRUE)){
                                    echo '
                                        <div class="LoginBar">
                                            Username: <input type="text" name="username" maxlength="100" required><br>
                                        </div>
                                        <div class="LoginBar">
                                            Password: <input type="password" name="password" maxlength="100" required ><br>
                                        </div>
                                        <div class="LoginBar">
                                            Age: <input type="number" name="age" max="99" required><br>
                                        </div>
                                        <div class="LoginBar">
                                            E-Mail: <input type="text" name="email" maxlength="40" required><br>
                                        </div>
                                        <div class="LoginBar">
                                            Phone: +<input type="number" name="phone" max="999999999999" required><br>
                                        </div>
                                        <div class="LoginBar">
                                            FullName: <input type="text" name="fullname" maxlength="100" required><br>
                                        </div>
                                        <div class="LoginBar">
                                            <input type="radio" name="gender" value="male"> Male
                                            <input type="radio" name="gender" value="female"> Female
                                            <input type="radio" name="gender" value="other" checked="checked"> Other<br>
                                        </div>
                                        <div class="LoginBar">
                                            About your self: <textarea name="about" rows="1" cols="21" maxlength="500" required></textarea><br>
                                        </div>
                                        <div class="LoginBar hide">
                                            <input type="text" name="submitted" value="TRUE" maxlength="100"><br>
                                        </div>
                                        <input type="submit">';
                                        $HideRegister = TRUE;
                                }else if($SSessioned && $ReceivedSubmit2 != "TRUE"){
                                    echo "Already Registered!";
                                    $HideRegister = FALSE;
                                }else {
                                    $ReceivedAbout = $_POST['about'];
                                    $ReceivedGender = $_POST['gender'];
                                    $ReceivedFullname = $_POST['fullname'];
                                    $ReceivedPhone = $_POST['phone'];
                                    $ReceivedEMail = $_POST['email'];
                                    $ReceivedAge = $_POST['age'];
                                    $ReceivedPassword = $_POST['password'];
                                    $ReceivedUsername = $_POST['username'];
                                    if (($ReceivedUsername == '' || $ReceivedUsername > 100 || strpos($ReceivedUsername, " ") )){
                                        echo '  <div class="LoginError">! Enter a valid name(No spaces)!</div>
                                                    <div class="LoginBar LoginRed">
                                                        Username: <input value="' . $ReceivedUsername . '" class="LoginRedText" type="text" name="username" maxlength="100" required><br>
                                                    </div>
                                                ';
                                        $Error = TRUE;
                                    }else{
                                        echo '
                                            <div class="LoginBar">
                                                Username: <input value="' . $ReceivedUsername . '" type="text" name="username" maxlength="100" required><br>
                                            </div>
                                        ';
                                    } if ( ($ReceivedPassword == '' || $ReceivedPassword > 100)){
                                        echo '  <div class="LoginError">! Enter a valid Password!</div>
                                                    <div class="LoginBar LoginRed">
                                                        Password: <input value="' . $ReceivedPassword . '" class="LoginRedText" type="password" name="password" maxlength="100" required ><br>
                                                    </div>
                                                ';
                                        $Error = TRUE;
                                    }else{
                                        echo '
                                            <div class="LoginBar">
                                                Password: <input value="' . $ReceivedPassword . '" type="password" name="password" maxlength="100" required ><br>
                                            </div>
                                        ';
                                    } if ($ReceivedAge == '' || $ReceivedAge > 99 || !is_numeric($ReceivedAge) ){
                                        echo '  <div class="LoginError">! Enter a valid age!</div>
                                                    <div class="LoginBar LoginRed">
                                                        Age: <input value="' . $ReceivedAge . '" class="LoginRedText" type="number" name="age" max="99" required><br>
                                                    </div>';
                                        $Error = TRUE;
                                    }else{
                                        echo '
                                            <div class="LoginBar">
                                                Age: <input value="' . $ReceivedAge . '" type="number" name="age" max="99" required><br>
                                            </div>
                                        ';
                                    }if ($ReceivedEMail == '' || $ReceivedEMail > 40 || !strpos($ReceivedEMail, '@') || !strpos($ReceivedEMail, '.') ){
                                        echo '  <div class="LoginError">! Enter a valid E-mail!</div>
                                                    <div class="LoginBar LoginRed">
                                                        E-Mail: <input value="' . $ReceivedEMail . '" class="LoginRedText" type="text" name="email" maxlength="40" required><br>
                                                    </div>';
                                        $Error = TRUE;
                                    }else{
                                        echo '
                                            <div class="LoginBar">
                                                E-Mail: <input value="' . $ReceivedEMail . '" type="text" name="email" maxlength="40" required><br>
                                            </div>
                                        ';
                                    }if ($ReceivedPhone == '' || $ReceivedPhone > 999999999999 || !is_numeric($ReceivedPhone) ){
                                        echo '  <div class="LoginError">! Enter a valid Phone number!</div>
                                                    <div class="LoginBar LoginRed">
                                                        Phone: +<input value="' . $ReceivedPhone . '" class="LoginRedText" type="number" name="phone" max="999999999999" required><br>
                                                    </div>';
                                        $Error = TRUE;
                                    }else{
                                        echo '
                                            <div class="LoginBar">
                                                Phone: +<input value="' . $ReceivedPhone . '" type="number" name="phone" max="999999999999" required><br>
                                            </div>
                                        ';
                                    }if ($ReceivedFullname == '' || $ReceivedFullname > 100 ){
                                        echo '  <div class="LoginError">! Enter a valid name(First and last name)!</div>
                                                    <div class="LoginBar LoginRed">
                                                        FullName: <input value="' . $ReceivedFullname . '" class="LoginRedText" type="text" name="fullname" maxlength="100" required><br>
                                                    </div>';
                                        $Error = TRUE;
                                    }else{
                                        echo '
                                            <div class="LoginBar">
                                                FullName: <input value="' . $ReceivedFullname . '" type="text" name="fullname" maxlength="100" required><br> 
                                            </div>
                                        ';
                                    }if ($ReceivedGender != 'male' && $ReceivedGender != 'female' && $ReceivedGender != 'other'){
                                        echo '  <div class="LoginError">  You messed with the gender!</div>
                                                    <div class="LoginBar LoginRed">
                                                        <input class="LoginRedText" type="radio" name="gender" value="male"> Male
                                                        <input class="LoginRedText" type="radio" name="gender" value="female"> Female
                                                        <input class="LoginRedText" type="radio" name="gender" value="other" checked="checked"> Other<br>
                                                    </div>';
                                        $Error = TRUE;
                                    }else{
                                        echo '
                                            <div class="LoginBar">
                                                <input type="radio" name="gender" value="male"> Male
                                                <input type="radio" name="gender" value="female"> Female
                                                <input type="radio" name="gender" value="other" checked="checked"> Other<br>   
                                            </div>
                                        ';
                                    }if ($ReceivedAbout == '' || $ReceivedAbout > 500 ){
                                        echo '  <div class="LoginError">! Enter a valid About text!</div>
                                                    <div class="LoginBar LoginRed">
                                                        About your self: <textarea value="' . $ReceivedAbout . '" class="LoginRedText" name="about" rows="1" cols="21" maxlength="500" required></textarea><br>
                                                    </div>';
                                        $Error = TRUE;
                                    }else{
                                        echo '
                                            <div class="LoginBar">
                                                About your self: <textarea value="' . $ReceivedAbout . '" name="about" rows="1" cols="21" maxlength="500" required></textarea><br> 
                                            </div>
                                        ';
                                    }
                                    echo '<input type="submit"><br>';
                                }
                      ?></form>
                        <?php
                                $DefaultLogin = '
                                        <form id="RegisterForm" class="LoginAsignMiddle" action="" method="POST">
                                            <div class="LoginBar">
                                                Username: <input value="' . $ReceivedUsername . '" type="text" name="username" maxlength="100" required><br>
                                            </div>
                                            <div class="LoginBar">
                                                Password: <input value="' . $ReceivedPassword . '" type="password" name="password" maxlength="100" required ><br>
                                            </div>
                                            <div class="LoginBar">
                                                Age: <input value="' . $ReceivedAge . '" type="number" name="age" max="99" required><br>
                                            </div>
                                            <div class="LoginBar">
                                                E-Mail: <input value="' . $ReceivedEMail . '" type="text" name="email" maxlength="40" required><br>
                                            </div>
                                            <div class="LoginBar">
                                                Phone: +<input value="' . $ReceivedPhone . '" type="number" name="phone" max="999999999999" required><br>
                                            </div>
                                            <div class="LoginBar">
                                                FullName: <input value="' . $ReceivedFullname . '" type="text" name="fullname" maxlength="100" required><br>
                                            </div>
                                            <div class="LoginBar">
                                                <input type="radio" name="gender" value="male"> Male
                                                <input type="radio" name="gender" value="female"> Female
                                                <input type="radio" name="gender" value="other" checked="checked"> Other<br>
                                            </div>
                                            <div class="LoginBar">
                                                About your self: <textarea value="' . $ReceivedAbout . '" name="about" rows="1" cols="21" maxlength="500" required></textarea><br>
                                            </div>
                                            <div class="LoginBar hide">
                                                <input type="text" name="submitted" value="TRUE" maxlength="100"><br>
                                            </div>
                                            <input type="submit">
                                        </form>';
                                if( ($Error == FALSE) && (($ReceivedSubmit == "TRUE")) ){
                                    echo '<script>ClearRegisterMenu();</script>';
                                    $CheckError = !$MysqlClass->CheckExits($ReceivedUsername, $ReceivedEMail, $ReceivedFullname, $ReceivedPhone);
                                    if($CheckError){
                                        echo 'Succesfully Registered user:<br>';
                                        echo "'$ReceivedFullname' as '$ReceivedUsername'.<br>Age: $ReceivedAge <br>Phone: $ReceivedPhone<br>E-mail: $ReceivedEMail<br>Gender: $ReceivedGender<br> About: $ReceivedAbout<br>";
                                        $MysqlClass->AddUser(NULL, $ReceivedUsername, $ReceivedPassword, $ReceivedAge, $ReceivedEMail, $ReceivedPhone, $ReceivedFullname, $ReceivedAbout, $AcceptTerms, 0, $Currentip, $ReceivedGender);
                                        $_POST['Finished'] = "TRUE";
                                        $_SESSION["username"] = $ReceivedUsername;
                                        $_SESSION["password"] = $ReceivedPassword;
                                        $_SESSION["gender"] = $ReceivedGender;
                                        $_SESSION["age"] = $ReceivedAge;
                                        $_SESSION["email"] = $ReceivedEMail;
                                        $_SESSION["fullname"] = $ReceivedFullname;
                                        $_SESSION["about"] = $ReceivedAbout;
                                        $_SESSION["phone"] = $ReceivedPhone;
                                        $_SESSION["submitedform"] = $ReceivedSubmit;
                                        $_SESSION["sessioned"] = TRUE;
                                    }else{
                                        echo '<div class="LoginError">Error?! <br></div>';
                                        echo $DefaultLogin;
                                    }
                                }if( ($Error == FALSE) && (($ReceivedSubmit2 == "TRUE")) ){
                                    $ReceivedID = $_POST['id'];
                                    echo '<script>ClearRegisterMenu();</script>';$MysqlClass->UpdateSettings($ReceivedUsername, "email", $ReceivedEMail);
                                        $MysqlClass->UpdateSettings($ReceivedUsername, "age", $ReceivedAge);
                                        $_SESSION["sessioned"] = TRUE;
                                }else if($_SESSION["sessioned"] == TRUE){
                                    $HideRegister = TRUE;
                                    echo 'already registert!';
                                }
                            
                        ?>
                </div>
        </div>
        <div id="container" class="container">
            <div class="Left">
                <?php 
                    include("AddOns/phps/MainMenu.php");
                    if($HideRegister){
                            echo '<script>ToggleRegister();</script>';
                    }
                ?>
            </div>
            <div class="Left up">
                <div class="SelectedContainer" id="ContentBox">
                    <?php include( $SelectedFile ); ?>
                </div>
            </div>
            <div class="Footer"> 
                ©onno204 - Premium Neq3Host host(Awsome host!) - Webmaster@onno204.nl.eu.org - Skype: onnovanh - onno204© <a href="http://www.dmca.com/Protection/Status.aspx?ID=78c60b88-7587-42e0-a783-b10103df4dab" title="DMCA.com Protection Status" class="dmca-badge"> <img src="//images.dmca.com/Badges/dmca_protected_sml_120m.png?ID=78c60b88-7587-42e0-a783-b10103df4dab" alt="DMCA.com Protection Status" style="height: 14px;"></a> <script src="//images.dmca.com/Badges/DMCABadgeHelper.min.js"> </script>
            </div>
        </div>
        
        <!--
            <audio id="ClickAudio" src="AddOns/Sounds/Click.wav" ></audio>
        -->
    </body>
</html>