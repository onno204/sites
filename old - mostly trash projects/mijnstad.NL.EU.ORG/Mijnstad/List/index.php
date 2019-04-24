<?php
    $Selected = $_GET['Selected'];
    $Option = $_GET['Option'];
?>
 <div class="LevoSynagogeLeft up"> 
    <div class="nothing">
        <?php
            require_once '../../AddOns/phps/MySQLMijnstad.php';
            $MysqlClass2 = new MySQLMijnstad();
            require_once '../../AddOns/phps/MySQL.php';
            $MysqlClass = new MySQL();
            echo $MysqlClass2->Connect();
            $MysqlClass2->CheckConnection();
            $MysqlClass2->First();
            echo $MysqlClass->Connect();
            $MysqlClass->CheckConnection();
            $MysqlClass->First();
            session_start();
            $AllowChanges = FALSE;
            $CurrentUser = "henkdepotviss";
            if($_SESSION['username'] != ""){
                $Group = $MysqlClass->GetPerms($_SESSION['username']);
                 if ($CurrentUser == $_SESSION['username']){
                    $AllowChanges = TRUE;
                }
                if($Group == "Admin"){
                     $AllowChanges = TRUE;
                }
            }
            if (!($_COOKIE['Ideas'] == '') ){
                echo '
                    <script>
                        console.log("1");
                    </script>
                ';
                $MysqlClass2->AddIdea($_COOKIE['Ideas'], $_SESSION['username']);
                unset($_COOKIE['Ideas']);
                setcookie('Ideas', null, -1, '/');
                echo '
                    <script>
                        document.cookie = "Ideas=";
                    </script>
                ';
            }
            
        ?>
    </div>
    <div>
        <div class="ServerTopper"> Alle ideeën voor de nieuwe RealLands server. </div>
            <div class="MijnstadIdeeen">
                <script>
                    function Next(){
                        var InputIdea = document.getElementById("InputIdea").value;
                        document.cookie = "Ideas=" + InputIdea;
                        GotoURL2();
                    }
                </script>
            <?php
                if(!$AllowChanges){
                }else{
                    echo '
                            <form class="LoginAsignMiddle" style="margin-top: 30px; margin-right: 40px; text-align: right;">
                                <div class="LoginBar2">
                                    Idee:<input class="AddIdea" id="InputIdea" value="Voeg je idee toe! (Alleen voor jaap en onno :D)" type="text" maxlength="500" required>
                                    <input onclick="Next()" type="submit" value="Voeg idee toe.">
                                </div>
                            </form>'
                    ;
                    
                }
                $MysqlClass2->ShowAllideas();
                ?>
                
            </div>
    </div>
</div>
