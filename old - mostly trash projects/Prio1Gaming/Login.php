<?php


$Errorcode;
function Error($ErrorID){
    global $Errorcode;
    #Set and include Error page
    $Errorcode = getenv("REDIRECT_STATUS");
    http_response_code($ErrorID);
    $Errorcode = $ErrorID;
    include "Error.php";
}

function LoadFile(){
    #Get file String and remove first
    $file = str_replace("%20", " ", substr_replace($_SERVER['REQUEST_URI'], "", 0, 1));
    $RootDirPath = "gitSites/Prio1Gaming/"; #http://example.com/public/index.php - public/
    $file = str_replace($RootDirPath,'',$file);

    #Split Args and Filellink at '?'
    $Temp = explode("?", $file, 2);
    $file = (isset($Temp[0]))? str_replace("?", "", $Temp[0]) : "";
    $Args = (isset($Temp[1]))? $Temp[1] : "";

    #Check if index.php is needed
    $Arr = explode("/", $file);
    if(strpos($Arr[(count($Arr) - 1)], '.') === false ){
        $file .= "/index.php";
    }

    #Remove '/' at beginning (Gives include error)
    while(true){
        if(substr($file, 0, 1 ) === "/"){ 
            $file = substr_replace($file, "", 0, 1);
        }else{ break; }
    }

    //echo "$file<br><br>";
    #File exists check
    if($file !== null && is_file($file)){
        #Imports
        /*
        $type = mime_content_type($file);
        if(StringContains($type, 'php')){
            $type = "text/html";
        }else if(StringContains($type, 'text/plain')){
            if(StringContains($type, ".css")){
                $type = "text/css";
            }else if(StringContains($type, ".js")){
                $type = "text/javascript";
            }
        }
        header('Content-Type: ' . $type);
         */
        include $file;
    }else{
        Error(404);
    }
}
function StringContains($String, $Contains){
    return (strpos($String, $Contains) > 1)? true : false;
}

function UpdateSessionData(){
    $config = include 'Config.php';
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    $connect = mysqli_connect($config->DBIp, $config->username, $config->pass) or die ('Couldn\'t Connect' . mysqli_error($connect));
    mysqli_select_db($connect, $config->database) or die ("Couldn't Find your database !");

    $query = sprintf("SELECT * FROM users WHERE `username`='%s' AND `password`='%s'",
    $this->FormatString($username),
    $this->FormatString($password));
    $rows = mysqli_query($connect, $query);

    $numrows = mysqli_num_rows($rows); 
    if($numrows){
        while($row = mysqli_fetch_assoc($rows)){
            $dbusername = $row['username'];
            $dbpassword = $row['password'];
            $dbnickname = $row['nickname'];
            $dbdate = $row['date'];
            $dbemail = $row['email'];
            $Permed = $row['Perm'];
        }
        
        //echo('<a href=\'/../\' target="_top">Return to the Mainsite</a>');
        $_SESSION['username']=$dbusername;
        $_SESSION['password']=$dbpassword;
        $_SESSION['nickname']=$dbnickname;
        $_SESSION['date']=$dbdate;
        $_SESSION['email']=$dbemail;
        $_SESSION['permed']=$Permed;

        if(!$Permed){
            return false;
        }

        //Session Access
        //$UpdateOnline = "UPDATE  `users` SET  `online` =  '1' WHERE  `users`.`email` ='". $dbemail ."' AND  `users`.`username` =  '". $dbusername ."'";
        //$rowss = mysqli_query($connect, $UpdateOnline);

    }else{
        return false;
    }
    return true;
}


///////////////
//// Start Stuff
///////////////
session_start();


///////////////
//// LOGIN
///////////////

#RemoteProgram
/*
if(isset($_GET['AdminAllowedH'])){
    if($_GET['AdminAllowedH'] ==  1){
        LoadFile();
    }
    die();
}
*/

/*
#Logged in or not?
if(!isset($_SESSION['username'])){
    Error(401);
    die();
}
*/


//UpdateSessionData

LoadFile();

