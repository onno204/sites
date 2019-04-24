<?php

if(!$Utils->HasPerms("HockeyLog") && !$Utils->HasPerms("HockeyLogView")){
    echo "<p class=\"MsgError\">You have no perms to see this page!</p>";
    return;
}

if(isset($_GET['Backend'])){
    if(isset($_GET['PlayerInfo'])){
        $PlayerInfoID = $Utils->FormatString($_GET['PlayerInfo']);
        $Info =  new \stdClass();
        
        $query2 = sprintf("SELECT * FROM `HockeyPlayers` WHERE `id` IN (". $PlayerInfoID . ")");
        $rows2 = mysqli_query(Utils::$connect, $query2);
        $numrows = mysqli_num_rows($rows2); 
        if($numrows){
            $rowsJ = array();
            while($r = mysqli_fetch_assoc($rows2)) {
                $matches = array();
                $PresentL = array();
                $TolateL = array();
                $UnSub = array();
                $AToLate = array();
                $Pid = $r['id'];
                $query = "SELECT * FROM `HockeyScheme` WHERE `Players` LIKE '%$Pid%'";
                $rows = mysqli_query(Utils::$connect, $query);
                $numrows = mysqli_num_rows($rows); 
                if($numrows){
                    while($row = mysqli_fetch_assoc($rows)){
                        $PlayerIDList = explode(",", $row['Players']);
                        $PlayerPresentList = explode(",", $row['PresentPlayers']);
                        $PlayerTolateList = explode(",", $row['ToLate']);
                        $UnsubList = explode(",", $row['unsubscriptions']);
                        $AToLateList = explode(",", $row['AnnouncedTolate']);
                        if(in_array($Pid, $PlayerIDList)){
                            $matches[count($matches)] = $row;
                        }if(in_array($Pid, $PlayerPresentList)){
                            $PresentL[count($PresentL)] = $row;
                        }if(in_array($Pid, $PlayerTolateList)){
                            $TolateL[count($TolateL)] = $row;
                        }if(in_array($Pid, $UnsubList)){
                            $UnSub[count($UnSub)] = $row;
                        }if(in_array($Pid, $AToLateList)){
                            $AToLate[count($AToLate)] = $row;
                        }
                    }
                }else{
                    echo "<p class=\"MsgError\">Error, No results!</p>";
                }
                $r['MatchC'] = count($matches);
                $r['PresentC'] = count($PresentL);
                $r['ToLateC'] = count($TolateL);
                $r['AnnouncedToLateC'] = count($AToLate);
                $r['UnSubC'] = count($UnSub);
                $r['NotAnnouncedC'] = $r['MatchC'] - ($r['PresentC'] + $r['UnSubC']);
                $rowsJ[] = $r;
            }
            echo json_encode($rowsJ);
        }else{
            echo '{"id":9999,"Name":"Not Found","Email":"Not Found","Mobile":"060000000","Team":["Not", "Found"]}';
            die();
        }
    }
    if($Utils->HasPerms("HockeyLog")){
        if(isset($_GET['UpdateTolate'])){
            $TolateListS = $Utils->FormatString($_GET['UpdateTolate']);
            $MatchID = $Utils->FormatString($_GET['Backend']);
            $Info =  new \stdClass();

            $query = sprintf("UPDATE `HockeyScheme` SET `ToLate`='%s' WHERE `id`='%s'",
                $TolateListS, $MatchID);
            $rows = mysqli_query(Utils::$connect, $query);
            echo mysqli_error(Utils::$connect);
            echo 'success';
        }
        if(isset($_GET['UpdatePresent'])){
            $PresentListS = $Utils->FormatString($_GET['UpdatePresent']);
            $MatchID = $Utils->FormatString($_GET['Backend']);
            $Info =  new \stdClass();

            $query = sprintf("UPDATE `HockeyScheme` SET `PresentPlayers`='%s' WHERE `id`='%s'",
                $PresentListS, $MatchID);
            $rows = mysqli_query(Utils::$connect, $query);
            echo mysqli_error(Utils::$connect);
            echo 'success';
        }    
        if(isset($_GET['UpdateUnSub'])){
            $PresentListS = $Utils->FormatString($_GET['UpdateUnSub']);
            $MatchID = $Utils->FormatString($_GET['Backend']);
            $Info =  new \stdClass();

            $query = sprintf("UPDATE `HockeyScheme` SET `unsubscriptions`='%s' WHERE `id`='%s'",
                $PresentListS, $MatchID);
            $rows = mysqli_query(Utils::$connect, $query);
            echo mysqli_error(Utils::$connect);
            echo 'success';
        }
        if(isset($_GET['UpdateAnnouncedTolate'])){
            $PresentListS = $Utils->FormatString($_GET['UpdateAnnouncedTolate']);
            $MatchID = $Utils->FormatString($_GET['Backend']);
            $Info =  new \stdClass();

            $query = sprintf("UPDATE `HockeyScheme` SET `AnnouncedTolate`='%s' WHERE `id`='%s'",
                $PresentListS, $MatchID);
            $rows = mysqli_query(Utils::$connect, $query);
            echo mysqli_error(Utils::$connect);
            echo 'success';
        }
    }    
    die();
}
if($Utils->HasPerms("HockeyLog")){
    if(isset($_POST['RegisterUser'])){
        $query = sprintf("INSERT INTO `HockeyPlayers` (`id`, `Name`, `Email`, `Mobile`, `Team`) 
                VALUES (NULL, '%s', '%s', '%s', '%s')",
                $Utils->FormatString($_POST['Name']),
                $Utils->FormatString($_POST['Email']),
                $Utils->FormatString($_POST['Mobile']),
                $Utils->FormatString($_POST['Team']));
        $rows = mysqli_query(Utils::$connect, $query);
        echo mysqli_error(Utils::$connect);
    }
    if(isset($_POST['CreateMatch'])){
        $Team = $Utils->FormatString($_POST['Team']);
        $PlayerS = "";
        $query = "SELECT * FROM `HockeyPlayers` WHERE `Team` LIKE '%{$Team}%'";
        $rows = mysqli_query(Utils::$connect, $query);
        $numrows = mysqli_num_rows($rows); 
        if($numrows){
            while($row = mysqli_fetch_assoc($rows)) {
                $PlayerS .= (strlen($PlayerS) <= 0)? $row['id'] : ",".$row['id'];
            }
        }else{
            $PlayerS = "";
        }
        $query = sprintf("INSERT INTO `HockeyScheme` (`id`, `Name`, `Players`, `Date`, `Type`) 
            VALUES (NULL, '%s', '%s', '%s', '%s')",
            $Utils->FormatString($_POST['Name']),
            $PlayerS,
            $Utils->FormatString($_POST['Date']),
            $Utils->FormatString($_POST['Type']));
        $rows = mysqli_query(Utils::$connect, $query);
        echo mysqli_error(Utils::$connect);
    }
}
?>

<?php 
if($Utils->HasPerms("HockeyLog")){
    ?>
<script>

    function PrepRequest(){
        var RequestPresent = "";
        var RequestToLate = "";
        var RequestUnSub = "";
        var RequestATolate = "";
        $('.SchemePop tbody').children('tr').each(function () {
            try{
                var PID = String($(this).attr("id")).replace("PlayerID", "");
                var Present = document.getElementById("CheckID" + PID).checked;
                var Tolate = document.getElementById("CheckTLID" + PID).checked;
                var UnSub = document.getElementById("CheckUSID" + PID).checked;
                var ATL = document.getElementById("CheckATID" + PID).checked;
                if(Present){
                    RequestPresent += (RequestPresent === "")? PID : ","+PID;
                    if(Tolate){
                        RequestToLate += (RequestToLate === "")? PID : ","+PID;
                        if(ATL){
                            RequestATolate += (RequestATolate === "")? PID : ","+PID;
                        }
                    }
                }else if(UnSub){
                    RequestUnSub += (RequestUnSub === "")? PID : ","+PID;
                }
                //Request += (Request === "")? PID+":"+Present : ","+PID+":"+Present;
            }catch(err) {
                console.log("Error: ", err);
            }
        });
        var SchemeID = $(".SchemePop").attr("id");
        $("#scheme"+SchemeID).attr("PresentPlayers", RequestPresent);
        $("#scheme"+SchemeID).attr("TolatePlayers", RequestToLate);
        $("#scheme"+SchemeID).attr("UnSubPlayers", RequestUnSub);
        $("#scheme"+SchemeID).attr("AnnouncedTolate", RequestATolate);
        var httpData = HttpRequest(URL + "?Backend="+$(".SchemePop").attr("id")+"&UpdatePresent=" + RequestPresent+"&UpdateTolate="+RequestToLate+"&UpdateUnSub="+RequestUnSub+"&UpdateAnnouncedTolate="+RequestATolate);
        httpData = String(httpData).replace("success", "");
        if(httpData === ""){ alert("Successfully updated!"); 
        }else{ alert("Error: " + httpData); }
        return RequestPresent+":"+RequestToLate+":"+RequestUnSub;
    }
    
    function RegisterUser(){
        $(".PopupContainer").html('<form class="RegForm" action="Hockey.php" method="post"><ul><li>Name: <input name="Name" type="text" required></li><li>Team: <input name="Team" type="text" required></li><li>Mobile: <input name="Mobile" type="text" required></li><li>Email: <input name="Email" type="text" required></li><li><input name="RegisterUser" type="submit" value="Register User"></li></ul></form>');
        ShowPopup(); 
    }
    
    function CreateMatch(){
        $(".PopupContainer").html('<form class="RegForm" action="Hockey.php" method="post"><ul><li>Name: <input name="Name" type="text" required=""></li><li>Team: <input name="Team" type="text" required=""></li><li>Date: <input name="Date" type="text" required=""></li><li>Type: <input name="Type" type="text" required=""></li><li><input name="CreateMatch" type="submit" value="Create Match"></li></ul></form>');
        ShowPopup(); 
    }
</script>
    <?php
}

//View
?>
<script>
    var URL = "https://site.onno204vps.nl.eu.org/Hockey.php";
    $(document).ready(function(){
        $("PopupOverlay").click(function(){ // Create event for Remotecontrol AutoUpdate
            HidePopup();
        });
    });
    function ShowPopup(){
        $("Popup").show();
        $("Popup").css({left: '0vw', top: '0vh'});
        $("Popup").animate({width: '76vw', height: '76vh', left: '12vw', top: '12vh'},120);
        $("PopupOverlay").fadeIn(1000);
    }
    function HidePopup(){
        $("Popup").animate({width: '1vw', height: '1vh', left: '1vw', top: '1vh'},120, function (){ $("Popup").hide(); });
        $("PopupOverlay").fadeOut(600);
    }
    function UpdateScheme(SchemeID){
        //scheme
        var PPlayers = $("#scheme"+SchemeID).attr("PresentPlayers").split(",");
        var TLPlayers = $("#scheme"+SchemeID).attr("TolatePlayers").split(",");
        var USPlayers = $("#scheme"+SchemeID).attr("UnSubPlayers").split(",");
        var ATPlayers = $("#scheme"+SchemeID).attr("AnnouncedTolate").split(",");
        //AnnouncedTolate
        var PlayersL = $("#scheme"+SchemeID).attr("Players").split(",");
        var EndSchm = "<table id='0' class='SchemePop'><tr><th>Aanwezig:</th><th>Te laat:</th><th>Gemeld Telaat:</th><th>Afgemeld:</th><th>Name:</th></tr>";
        PlayersL.forEach(function(item, index){
            EndSchm += '<tr id="PlayerID'+item+'"><th><label class="ChkCont">: <input id="CheckID'+item+'" type="checkbox"> <span class="checkmark"></span></label></th>\n\
                        <th><label class="ChkCont">: <input id="CheckTLID'+item+'" type="checkbox"> <span class="checkmark"></span></label></th>\n\
                        <th><label class="ChkCont">: <input id="CheckATID'+item+'" type="checkbox"> <span class="checkmark"></span></label></th>\n\
                        <th><label class="ChkCont">: <input id="CheckUSID'+item+'" type="checkbox"> <span class="checkmark"></span></label></th>\n\
                        <th><PlayerName></PlayerName></th></tr>';
        });
        console.log(PPlayers);
        EndSchm += '<tr><th><input onclick="PrepRequest()" type="button" value="Submit" /></th></tr></table>';
        $(".PopupContainer").html(EndSchm);
        $(".SchemePop").attr("id", SchemeID);
        var httpData = HttpRequest(URL + "?Backend=1&PlayerInfo=" + PlayersL.join());
        var json = JSON.parse(httpData);
        json.forEach(function(item, index){
            var PlayerID = item['id'];
            $("#PlayerID" + PlayerID +" PlayerName").text(item['Name']);
            if(PPlayers.indexOf(String(PlayerID)) >= 0){ $('#CheckID'+PlayerID).prop('checked', true);
            }else{ $('#CheckID'+PlayerID).prop('checked', false);
            }
            if(TLPlayers.indexOf(String(PlayerID)) >= 0){ $('#CheckTLID'+PlayerID).prop('checked', true);
            }else{ $('#CheckTLID'+PlayerID).prop('checked', false);
            }
            if(USPlayers.indexOf(String(PlayerID)) >= 0){ $('#CheckUSID'+PlayerID).prop('checked', true);
            }else{ $('#CheckUSID'+PlayerID).prop('checked', false);
            }
            if(ATPlayers.indexOf(String(PlayerID)) >= 0){ $('#CheckATID'+PlayerID).prop('checked', true);
            }else{ $('#CheckATID'+PlayerID).prop('checked', false);
            }
        });
        
    }
    
    function HttpRequest(Url){
        console.log("Url Request: ", Url);
        var Httpreq = new XMLHttpRequest(); // a new request
        Httpreq.open("GET",Url,false);
        Httpreq.send(null);
        console.log("Url Reponse: ", Httpreq.responseText);
        return Httpreq.responseText;          
    }
    
    function UserList(){
        var httpData = HttpRequest(URL + "?Backend=1&PlayerInfo=" + $("#AllPlayersID").attr("content"));
        var json = JSON.parse(httpData);
        var EndSchm = "<table id='0' class='SchemePop'><tr><th>Settings:</th><th>Naam::</th><th>Team(s):</th><th>Ingedeeld:</th><th>Aanwezig:</th><th>Te laat:</th><th>Gemeld Telaat:</th><th>Afmelding:</th><th>Niet Gemeld:</th></tr>";
        json.forEach(function(item, index){
            var PlayerID = item['id'];
            var PlayerName = item['Name'];
            var PlayerPhone = item['Mobile'];
            var PlayerEmail = item['Email'];
            var PlayerTeams = item['Team'];
            
            EndSchm += '<tr id="PlayerID'+PlayerID+'" Email="'+PlayerEmail+'" Mobile="'+PlayerPhone+'"><th><PlayerSettings id="PlayerSettingsID'+PlayerID+'" onclick="PlayerInfo('+PlayerID+')">⚙</PlayerSettings></th><th><PlayerName>'+PlayerName+'</PlayerName></th><th><PlayerTeams>'+PlayerTeams+'</PlayerTeams></th>';
            EndSchm += '<th>'+item['MatchC']+'</th><th>'+item['PresentC']+'</th><th>'+item['ToLateC']+'</th><th>'+item['AnnouncedToLateC']+'</th><th>'+item['UnSubC']+'</th><th>'+item['NotAnnouncedC']+'</th> </tr>';
        });
        EndSchm += '</table>';
        $(".PopupContainer").html(EndSchm);
        ShowPopup();
    }
    
    function PlayerInfo(PID){
        var httpData = HttpRequest(URL + "?Backend=1&PlayerInfo=" + PID);
        var json = JSON.parse(httpData);
        var EndSchm = "<ul>";
        json.forEach(function(item, index){
            var PlayerID = item['id'];
            var PlayerName = item['Name'];
            var PlayerPhone = item['Mobile'];
            var PlayerEmail = item['Email'];
            var PlayerTeams = item['Team'];
            EndSchm += '<li id="PInfo'+PlayerID+'">Name: '+PlayerName+'</li><li>Mobile: '+PlayerPhone+'</li><li>Email: '+PlayerEmail+'</li><li>Team: '+PlayerTeams+'</li>';
            EndSchm += '<li>Total Schemes: '+item['MatchC']+'</li>';
            EndSchm += '<li>Total Present: '+item['PresentC']+'</li>';
            EndSchm += '<li>Total ToLate: '+item['ToLateC']+'</li>';
            EndSchm += '<li>Total Unsub: '+item['UnSubC']+'</li>';
            EndSchm += '<li>Total Not Announced: '+item['NotAnnouncedC']+'</li>';
        });
        EndSchm += '</ul>';
        $(".PopupContainer").html(EndSchm);
        ShowPopup();
    }
    
    function ShowGraph(){
        var httpData = HttpRequest(URL + "?Backend=1&PlayerInfo=" + $("#AllPlayersID").attr("content"));
        var json = JSON.parse(httpData);
        var EndSchm = "<table id='0' class='SchemePop'><tr><th>Settings:</th><th>Naam::</th><th>Team(s):</th><th>Ingedeeld:</th><th>Aanwezig:</th><th>Te laat:</th><th>Gemeld Telaat:</th><th>Afmelding:</th><th>Niet Gemeld:</th></tr>";
        json.forEach(function(item, index){
            var PlayerID = item['id'];
            var PlayerName = item['Name'];
            var PlayerPhone = item['Mobile'];
            var PlayerEmail = item['Email'];
            var PlayerTeams = item['Team'];
            
            EndSchm += '<tr id="PlayerID'+PlayerID+'" Email="'+PlayerEmail+'" Mobile="'+PlayerPhone+'"><th><PlayerSettings id="PlayerSettingsID'+PlayerID+'" onclick="PlayerInfo('+PlayerID+')">⚙</PlayerSettings></th><th><PlayerName>'+PlayerName+'</PlayerName></th><th><PlayerTeams>'+PlayerTeams+'</PlayerTeams></th>';
            EndSchm += '<th>'+item['MatchC']+'</th><th>'+item['PresentC']+'</th><th>'+item['ToLateC']+'</th><th>'+item['AnnouncedToLateC']+'</th><th>'+item['UnSubC']+'</th><th>'+item['NotAnnouncedC']+'</th> </tr>';
        });
        EndSchm += '</table>';
        $(".PopupContainer").html(EndSchm);
        ShowPopup();
    }
    
</script>
<PopupOverlay> </PopupOverlay>
<Popup>
    <PopupX onclick="HidePopup();">X</PopupX>
    <div class="PopupContainer">
        <graph>
            <line>a</line>
        </graph>
    </div>
</Popup>

<?php
if($Utils->HasPerms("HockeyLog")){
    ?>
    <input onclick="RegisterUser()" type="button" value="Register User" />
    <input onclick="CreateMatch()" type="button" value="Create Match" />
    <?php
}
        
?>
<input onclick="UserList()" type="button" value="User list" />
<input onclick="ShowGraph()" type="button" value="Grafiek" />
<table class="Scheme">
    <tr>
        <th>Date:</th>
        <th>Name:</th>
        <!--<th>Aantal Spelers:</th>-->
        <th>Aanwezig:</th>
        <th>Te laat:</th>
        <th>Gemeld Telaat:</th>
        <th>Afgemeld:</th>
    </tr>
<?php

$query = sprintf("SELECT * FROM `HockeyScheme`");
$rows = mysqli_query(Utils::$connect, $query);
$query2 = sprintf("SELECT * FROM `HockeyPlayers`");
$rowsPlayers = mysqli_query(Utils::$connect, $query2);
$numrows = mysqli_num_rows($rows); 
if($numrows){
    while($row = mysqli_fetch_assoc($rows)){
        ?>
        <tr onclick="UpdateScheme(<?php echo $row['id']; ?>);ShowPopup();" id="scheme<?php echo $row['id']; ?>" players="<?php echo $row['Players']; ?>" PresentPlayers="<?php echo $row['PresentPlayers']; ?>" TolatePlayers="<?php echo $row['ToLate']; ?>" UnSubPlayers="<?php echo $row['unsubscriptions']; ?>" AnnouncedTolate="<?php echo $row['AnnouncedTolate']; ?>" Type="<?php echo $row['Type']; ?>" Name="<?php echo $row['Name']; ?>">
            <th><?php echo $row['Date']; ?></th>
            <th><?php echo $row['Type']."/".$row['Name']; ?></th>
            <!--<th><?php echo (strlen($row['Players'])>=1) ? count( explode(",", $row['Players']) ) : 0; ?></th>-->
            <th><?php echo (strlen($row['PresentPlayers'])>=1) ? count( explode(",", $row['PresentPlayers']) ) : 0; ?></th>
            <th><?php echo (strlen($row['ToLate'])>=1) ? count( explode(",", $row['ToLate']) ) : 0; ?></th>
            <th><?php echo (strlen($row['AnnouncedTolate'])>=1) ? count( explode(",", $row['AnnouncedTolate']) ) : 0; ?></th>
            <th><?php echo (strlen($row['unsubscriptions'])>=1) ? count( explode(",", $row['unsubscriptions']) ) : 0; ?></th>
            <!--<th><?php 
            $PlayerIDList = (strlen($row['Players'])>1) ? explode(",", $row['Players']) : $row['Players'];
            while($rowPlayer = mysqli_fetch_assoc($rowsPlayers)){
                if(in_array($rowPlayer['id'], $PlayerIDList)){
        ?><player id="Player<?php echo $rowPlayer['id']; ?>" Email="<?php echo $rowPlayer['Email']; ?>" Mobile="<?php echo $rowPlayer['Mobile']; ?>"><?php echo $rowPlayer['Name']; ?></player><?php
                }
            }
            ?></th>-->
        </tr>
        <?php
    }
}else{
    echo "<p class=\"MsgError\">Error, No results!</p>";
}

?>
</table>
<Holder id="AllPlayersID" content="<?php
    $EndEcho = "";
    $query2 = sprintf("SELECT * FROM `HockeyPlayers`");
    $rowsPlayers = mysqli_query(Utils::$connect, $query2);
    while($rowPlayer = mysqli_fetch_assoc($rowsPlayers)){
        $EndEcho .= (strlen($EndEcho)<= 0)? $rowPlayer['id'] : ",".$rowPlayer['id'];
    }
    echo $EndEcho;
?>"></Holder>
