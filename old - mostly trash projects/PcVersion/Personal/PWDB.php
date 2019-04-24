<?php
    $Selected = $_GET['Selected'];
    $Option = $_GET['Option'];
?>

 <div class="LevoSynagogeLeft up"> 
    <div class="nothing"><?php
            require_once '../AddOns/phps/MySQL.php';
            $MysqlClass = new MySQL();
            echo $MysqlClass->Connect();
            $MysqlClass->CheckConnection();
            $MysqlClass->First();
            
            require_once '../AddOns/phps/MySQLOnno204WW.php';
            $MySQLOnno204WWmsql = new MySQLOnno204WW();
            echo $MySQLOnno204WWmsql->Connect();
            $MySQLOnno204WWmsql->CheckConnection();
            $MySQLOnno204WWmsql->First();
            
            session_start();
            $AllowChanges = FALSE;
            $CurrentUser = "onno204";
            if($_SESSION['username'] != ""){
                $Group = $MysqlClass->GetPerms($_SESSION['username']);
                 if ($CurrentUser == $_SESSION['username']){
                    $AllowChanges = TRUE;
                }
            }
            if(!$AllowChanges){
                echo '<h1> You are not allowed to view this page though. </h1>';
                die();
            }?>
            
            <script>

            $(document).ready(function(){
                $("#IdentifyerButton").click(function(){
                    console.log("Clicked");
                    receive = OverlayLogin();
                    if(receive){
                        console.log("true...");
                        $("#Identifyer").slideUp(2125);
                    }
                });

                    <?php
                        if (!($_COOKIE['LogHolder'] == '') ){
                            $username = $_COOKIE['LogHolder'];
                            echo 'Allow();';
                        }
                    ?>



            });
            </script>

            <div class="LoginOverlay" style=" background-color: rgba( 0, 0, 0, 1); z-index: 1000000;"  id="Identifyer">
                <div class="LoginOverlayText" id="IdentifyerText">
                    <div class="LoginBar">
                        Username: <input type="text" id="IdentifyerUsername" name="username" maxlength="100" ><br>
                    </div>
                    <div class="LoginBar">
                        Password: <input type="password" id="IdentifyerPassword" name="password" maxlength="100" ><br>
                    </div>
                    <input type="submit" id="IdentifyerButton" >
                </div>
            </div>
            <?php
            if (!($_COOKIE['ww'] == '') ){
                $username = $_COOKIE['username'];
                $ww = $_COOKIE['ww'];
                $url = $_COOKIE['url'];
                unset($_COOKIE['username']);
                setcookie('username', null, -1, '/');
                unset($_COOKIE['ww']);
                setcookie('ww', null, -1, '/');
                unset($_COOKIE['url']);
                setcookie('url', null, -1, '/');
                $MySQLOnno204WWmsql->AddPassword($username, $ww, $url);
                echo '
                    <script>
                        document.cookie = "username=";
                        document.cookie = "ww=";
                        document.cookie = "url=";
                    </script>
                ';
            }
      ?></div>
    <div>
            <?php
                if(!$AllowChanges){
                    echo '<div class="ServerTopper"> You are not allowed to view this page though. </div>';
                }else{
                    echo '
                <div class="ServerTopper"> Alle ideeën voor de nieuwe mijnstad server. </div>
                    <div class="PWDBContent">
                        <link rel="stylesheet" type="text/css" href="AddOns/Styles/PWDB.css"/>
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
                        <script src="AddOns/JavaScripts/PWDB.js"></script>
                        <script>
                            function Next(){
                                document.cookie = "username=" + document.getElementById("Username").value;
                                document.cookie = "ww=" + document.getElementById("Password").value;
                                document.cookie = "url=" + document.getElementById("URL").value;
                                document.cookie = "LogHolder=true";
                                GotoNoLoadCheck();
                            }
                        </script>
                            <div class="PWDBaddPW" style="margin-top: -30px; background-color: rgba( 0, 0, 0, 0); border-style: none;">
                                <input class="PWDBGeneratorInput" type="text" id="RandomPasswordInput" rel="gp" data-size="32" data-character-set="a-z,A-Z,0-9,#">
                                <span class="PWDBGeneratorPassword"><button onclick="randString()" type="button" class="PWDBGeneratorPassword"><span class="fa fa-refresh"></span></button></span>
                            </div>
                            <form class="PWDBaddPW">
                                    Username:<input class="AddIdea" id="Username" value="Username" type="text" maxlength="500" required>
                                    Password:<input class="AddIdea" id="Password" value="Password" type="text" maxlength="500" required>
                                    URL:<input class="AddIdea" id="URL" value="https://onno204.nl.eu.org" type="text" maxlength="500" required>
                                    <input onclick="Next()" type="submit" value="Add password.">
                            </form>
                        </div>
                </div>
    '
                    ;
                    $MySQLOnno204WWmsql->ShowAllPasswords();
                }
            ?>
                
</div>
