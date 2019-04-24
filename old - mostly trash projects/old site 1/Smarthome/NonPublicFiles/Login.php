<?php
#$_SESSION["InclName"] = Name of current page
#$_SESSION["InclPath"] = Path to file without file
#$_SESSION['InclFile'] = Full file location
#$_SESSION['InclFileName'] = File name without extension

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
    $RootDirPath = "Smarthome/"; #http://example.com/public/index.php - public/
    $file = str_replace($RootDirPath,'',$file);

    #Split Args and Filellink at '?'
    $Temp = explode("?", $file, 2);
    $file = (isset($Temp[0]))? str_replace("?", "", $Temp[0]) : "";
    $Args = (isset($Temp[1]))? $Temp[1] : "";
    
    #Check if index.php is needed
    $Arr = explode("/", $file);
    $_SESSION["InclName"] = $Arr[(count($Arr) - 1)];
    if(strpos($Arr[(count($Arr) - 1)], '.') === false ){
        $_SESSION["InclName"] = "index";
        $file .= "/index.php";
    }
    $_SESSION['InclFileName'] = str_replace(".php", "", $_SESSION["InclName"]);
    
    #Create simple string to File location
    $parts = explode('/', $file);
    $last = array_pop($parts);
    $parts = array(implode('', $parts), $last);
    $_SESSION["InclPath"] = $parts[0];
    
    
    
    #Remove '/' at beginning (Gives include error)
    while(true){
        if(substr($file, 0, 1 ) === "/"){ 
            $file = substr_replace($file, "", 0, 1);
        }else{ break; }
    }
    
    #File exists check
    $file = "../" . $file;
    if($file !== null && is_file($file)){
        #Imports
        $_SESSION['InclFile'] = $file;
        //include $file;
        include "IncludeHeaders.php";
    }else{
        Error(404);
    }
}
function StringContains($String, $Contains){
    return (strpos($String, $Contains) > 1)? true : false;
}

///////////////
//// Start Stuff
///////////////
session_start();


///////////////
//// LOGIN
///////////////

/*
#Logged in or not?
if(!isset($_SESSION['username'])){
    Error(401);
    die();
}
*/

//error_reporting(0);
error_reporting(E_ALL);


LoadFile();

