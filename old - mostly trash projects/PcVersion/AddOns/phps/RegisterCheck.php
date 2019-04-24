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
                                if( ($Error == FALSE) && ($ReceivedSubmit == "TRUE") ){
                                    echo '<script>ClearRegisterMenu();</script>';
                                    $CheckError = !$MysqlClass->CheckExits($ReceivedUsername, $ReceivedEMail, $ReceivedFullname, $ReceivedPhone);
                                    if($CheckError){
                                        echo 'Succesfully Registered user:<br>';
                                        echo "'$ReceivedFullname' as '$ReceivedUsername'.<br>Age: $ReceivedAge <br>Phone: $ReceivedPhone<br>E-mail: $ReceivedEMail<br>Gender: $ReceivedGender<br> About: $ReceivedAbout<br>";
                                        $MysqlClass->AddUser($ReceivedUsername, $ReceivedPassword, $ReceivedAge, $ReceivedEMail, $ReceivedPhone, $ReceivedFullname, $ReceivedAbout, $AcceptTerms, 0, $Currentip, $ReceivedGender);
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
                                }else if($_SESSION["sessioned"] == TRUE){
                                    $HideRegister = TRUE;
                                    echo 'already registert!';
                                }
                            