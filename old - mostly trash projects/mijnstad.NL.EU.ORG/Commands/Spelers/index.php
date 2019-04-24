<?php
    $Selected = $_GET['Selected'];
    $Option = $_GET['Option'];
?>

 <div class="up"> 
    <div class="nothing"><?php
            require_once '../../AddOns/phps/MySQL.php';
            $MysqlClass = new MySQL();
            echo $MysqlClass->Connect();
            $MysqlClass->CheckConnection();
            $MysqlClass->First();
            
            require_once '../../AddOns/phps/MySQLOnno204CommandsSpelers.php';
            $MySQLOnno204CommandsSpelers = new MySQLOnno204CommandsSpelers();
            echo $MySQLOnno204CommandsSpelers->Connect();
            $MySQLOnno204CommandsSpelers->CheckConnection();
            $MySQLOnno204CommandsSpelers->First();

            session_start();
            $AllowChanges = FALSE;
            $CurrentUser = "onno204";
            if($_SESSION['username'] != ""){
                $Group = $MysqlClass->GetPerms($_SESSION['username']);
                 if ($CurrentUser == $_SESSION['username']){
                    $AllowChanges = TRUE;
                }
            }
            ?>
        
            <?php
            if (!($_COOKIE['idea'] == '') ){
                $type = $_COOKIE['type'];
                $idea = $_COOKIE['idea'];
                unset($_COOKIE['type']);
                unset($_COOKIE['idea']);
                setcookie('type', null, -1, '/');
                setcookie('idea', null, -1, '/');
                $MySQLOnno204CommandsSpelers->AddIdea($type, $idea);
                echo '
                    <script>
                        document.cookie = "type=";
                        document.cookie = "idea=";
                    </script>
                ';
            }
            if (!($_COOKIE['RemoveID'] == '') ){
                $RemoveID = $_COOKIE['RemoveID'];
                unset($_COOKIE['RemoveID']);
                setcookie('RemoveID', null, -1, '/');
                $MySQLOnno204CommandsSpelers->RemoveIdea($RemoveID);
                echo '
                    <script>
                        document.cookie = "RemoveID=";
                    </script>
                ';
            }
      ?></div>
    <div>
        <div class="IdeasContainer">
        <div class="ServerTopper">Type /help in de server.</div>
            <link rel="stylesheet" type="text/css" href="AddOns/Styles/Commands.css"/>
            <?php
                if(!$AllowChanges){
                    //echo "<p class=IdeasOnlySite>Since you aren't onno204 you can only see the site ideas.</p>";
                    $MySQLOnno204CommandsSpelers->ShowAllIdeasNoAdmin();
                    //echo '<div class="ServerTopper"> You are not allowed to view this page though. </div>';
                }else{
                    echo '
                    <script src="AddOns/JavaScripts/Commands.js"></script>
                    <div class="IdeasContent">
                        <script>
                            function Next(){
                                document.cookie = "type=" + document.getElementById("Type").value;
                                document.cookie = "idea=" + document.getElementById("Idea").value;
                                GotoNoLoadCheck();
                            }
                        </script>
                            <form class="IdeasaddPW">
                                    Command:<input class="" id="Type" value="Command" type="text" maxlength="500" required>
                                    Uitleg:<input class="" style="width: 350px;" id="Idea" value="Uitleg" type="text" maxlength="500" required>
                                    <input onclick="Next()" type="submit" value="Add Commands.">
                            </form>
                    </div>
                ' ;
                $MySQLOnno204CommandsSpelers->ShowAllIdeas();
                }
            ?>
        </div>
</div>
