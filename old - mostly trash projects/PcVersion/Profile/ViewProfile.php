<div class="nothing">
    <?php
        require_once '../AddOns/phps/MySQL.php';
        $MysqlClass = new MySQL();
        echo $MysqlClass->Connect();
        $MysqlClass->CheckConnection();
        $MysqlClass->First();
        session_start();
        $CurrentUser = $_COOKIE["username"];
        if ($CurrentUser == null){
            echo "<script> windows.location = http://onno204.nl.eu.org; </script>";
        }
        $AllowChanges = FALSE;
        if($_SESSION['username'] != ""){
            $Group = $MysqlClass->GetPerms($_SESSION['username']);
            if ($CurrentUser == $_SESSION['username']){
                $AllowChanges = TRUE;
            }
            if($Group == "Admin"){
                $AllowChanges = TRUE;
            }
        }
    ?>
</div>
<div>
    <div class="ServerTopper"> Profile From <?php echo $CurrentUser; ?></div>
    <div class="LeftTop">
        <div class="Upload">
                <?php if($AllowChanges){
                    echo'
                        <form id="LoginForm" class="Upload" action="" method="POST" enctype="multipart/form-data">
                            <p class="ProfileNotice">Change Profile Picture: </p>
                            <input type="file" class="ProfileUpload" name="ProfilePicture" />
                            <br>
                            <input type="submit" class="ProfileSpace ProfileUpload" name="sumit" value="Upload" />
                        </form>
                    ';
                }?>
        </div>
            <?php $MysqlClass->GetImage($CurrentUser, "ProfileImg"); ?>
        <br>
    </div>
    <div class="RightTop">
        <div class="">
            <?php
            if(!$AllowChanges){
                echo '
                    <p class="ProfileInfo">Fullname: '.$MysqlClass->GetFullname($CurrentUser).'</p>
                    <p class="ProfileInfo">Age: '.$MysqlClass->GetAge($CurrentUser).'</p>
                    <p class="ProfileInfo">Email: '.$MysqlClass->GetEmail($CurrentUser).'</p>
                    <p class="ProfileInfo">Phone: ********* We are not giving phone numbers away!contact me( onno204@onno204.nl.eu.org )</p>
                    <p class="ProfileInfo">Gender: '.$MysqlClass->GetGender($CurrentUser).'</p>
                    <p class="ProfileInfo">About: '.$MysqlClass->GetAbout($CurrentUser).'</p>
                    <p class="ProfileInfo">Group: '. $MysqlClass->GetPerms($CurrentUser) . '</p>'
                ;
            }else{
                echo '
                    <form id="RegisterForm" class="" style="margin-top: 60px; margin-right: 70px; text-align: right;" action="" method="POST">
                        <div class="LoginBar">
                            Age: <input value="' . $MysqlClass->GetAge($CurrentUser) . '" type="number" name="age" max="99" required><br>
                        </div>
                        <div class="LoginBar">
                            E-Mail: <input value="' . $MysqlClass->GetEmail($CurrentUser) . '" type="text" name="email" maxlength="40" required><br>
                        </div>
                        <div class="LoginBar">
                            Phone: +<input value="' . $MysqlClass->GetPhone($CurrentUser) . '" type="number" name="phone" max="999999999999" required><br>
                        </div>
                        <div class="LoginBar">
                            FullName: <input value="' . $MysqlClass->GetFullname($CurrentUser) . '" type="text" name="fullname" maxlength="100" required><br>
                        </div>
                        Gender change? Mail: "Webmaster@onno204.nl.eu.org"
                        <div class="LoginBar"> About your self: <input value="' . $MysqlClass->GetAbout($CurrentUser) . '" name="about" rows="1" cols="21" maxlength="500" required></input><br>
                        </div>
                        <div class="LoginBar hide">
                            <input type="text" name="submitted1" value="TRUE" maxlength="100"><br>
                        </div>
                        <input type="submit" value="Update Settings">
                        <p class="ProfileInfo">Group: '. $MysqlClass->GetPerms($CurrentUser) . '</p>
                        <input class="hide" type="text" name="gender" value="' . $MysqlClass->GetGender($CurrentUser) . '" maxlength="100"><br>
                        <input class="hide" type="text" name="username" value="' . $_SESSION['username'] . '" maxlength="100"><br>
                        <input class="hide" type="text" name="password" value="' . $MysqlClass->GetUserPassword($CurrentUser) . '" maxlength="100"><br>
                        <input class="hide" type="text" name="id" value="' . $MysqlClass->GetUserID($CurrentUser) . '" maxlength="100"><br>
                                        </form>'
                ;
            }
            ?>
        </div>
    </div>
    <div class="ProfileMiddle">
        
    </div>
</div>