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