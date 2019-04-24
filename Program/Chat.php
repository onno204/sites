<?php
require 'Utils.php';
$Utils = new Utils();
$Utils->LoadDB();

if(isset($_GET['FrontEnd'])){
    $Utils->ConnectCheck();
    ?>
        <div id="ConnectButton" class="Button" onclick="SetupListener(); $(this).slideUp(500);">Connect</div>
        <div id="ChatBox" class="ChatBox"> 
            <label><span>Time</span><a>UserName</a><p>Message</p></label>
        </div>
        <br />
        <div id="SendMessage" class="SendMessage">
            <input id="SendMessageText" type="text" maxlength="500" onkeydown="SendMessageKEY(this, event);" > </input>
            <input id="SendMessageSubmit" class="button" type="submit" value="Send Message" onclick="SendMessage();" > </input>
        </div>
    <?php
}

function Query($query){
    $rows = mysqli_query(Utils::$connect, $query) or die('Error, query failed: ' . mysqli_error(Utils::$connect));
    return $rows;
}

if(isset($_GET['SendMessage'])){
    $UniID = random_int(1,99999);
    $User = $_SESSION['nickname'];
    $Message = $Utils->FormatString($_GET['Message']);
    $Time = date("Y-m-d G:i:s");
    $query = "INSERT INTO Chat (UniID, nickname, message, time) " .
                "VALUES ('$UniID', '$User', '$Message', '$Time')";
    Query($query);
    echo "Message Send!";
    die();
}

function sendMsg($JSON) {
    echo "data: $JSON" . PHP_EOL;
    echo PHP_EOL;
    flush();
}
function NewMessageCheck($FIRST){
    $Date = date("Y-m-d G:i:s", strtotime("-6 Seconds"));
    $rows = "";
    if($FIRST){
        $rows = Query("SELECT * FROM `Chat` ORDER BY id ASC LIMIT 50");
    }else{
        $rows = Query("SELECT * FROM `Chat` WHERE Time >= '$Date'");
    }
    
    if (mysqli_num_rows($rows) == 0) {
        return "NoMessages";
    } else {
        $Prep = array();
        while ($row = mysqli_fetch_assoc($rows)) { $Prep[] = $row; }
        $JSON = json_encode($Prep);
        return $JSON;
    }
}
if(isset($_GET['BackEnd'])){
    header("Content-Type: text/event-stream");
    $NUM = $_GET['BackEnd'];
    //SOURCE: http://jsjoy.com/blog/197/simple-php-comet-example
    //SOURCE: https://www.html5rocks.com/en/tutorials/eventsource/basics/
    header('Content-Type: text/event-stream');
    header("Cache-Control: no-cache, must-revalidate");
    ini_set('output_buffering', 'Off'); //Disable all PHP output buffering
    ini_set('implicit_flush', 1);
    ini_set('max_execution_time', 35);
    ob_implicit_flush(1);
    for ($i = 0, $level = ob_get_level(); $i < $level; $i++) { ob_end_flush(); } //Flush all levels of the buffer to start
   
    /*
     * OLD Script
     * <script type="text/javascript">
     *      parent.Log("<?php echo $_COOKIE['Chat']; ?> ");  <?php //.str_repeat(' ',500); 500 characters of padding ?>
     * </script>
    */
    if($NUM === "2"){
        $JSON = NewMessageCheck(true);
        if($JSON !== "NoMessages"){ sendMsg($JSON); }
    }
    
    $startTime = time();
    $maxLoopTime = 20;
    while(time()-$startTime < $maxLoopTime) {
        $serverTime = time();
        $UniID = "1";
        $JSON = NewMessageCheck(false);
        if($JSON !== "NoMessages"){ sendMsg($JSON); }
        
        //Ending
        flush();
        $randSleep = mt_rand(100000, 300000); //sleep between 100 ms and * ms
        usleep($randSleep);
    }

    /*
    <script type="text/javascript">
        parent.Log("Output Finished");
    </script>
    */
    die();
}




$Utils->LastLoad();