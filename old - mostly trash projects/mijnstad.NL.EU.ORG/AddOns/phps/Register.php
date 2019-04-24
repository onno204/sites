                            $ReceivedSubmit = $_POST['submitted'];
                                $Finished = $_POST['Finished'];
                                $Error = FALSE;
                                $HideRegister = FALSE;
                                if(($ReceivedSubmit != "TRUE") && ($_SESSION['sessioned'] !=TRUE)){
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
                                }else if($SSessioned){
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
                                    if ($ReceivedUsername == '' || $ReceivedUsername > 100 || strpos($ReceivedUsername, " ") ){
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
                                    } if ($ReceivedPassword == '' || $ReceivedPassword > 100){
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