<?php

if(isset($_GET['InfoID'])){
    $Info = GetDevInfo($Utils->FormatString($_GET['InfoID']));
    echo json_encode($Info);
}

function GetDevInfo($ID){
    $Utils = new Utils();
    $Utils->LoadDB();
    
    $Info =  new \stdClass();
    $Info->devid = intval($Utils->FormatString($ID));
    
    $query = sprintf("SELECT * FROM `SmartoDevices` WHERE `devid`='%s'", $Info->devid );
    $rows = mysqli_query(Utils::$connect, $query);
    if(!$rows){
        die('{"error":"Device id doesn\'t exists.","errorid":"500","deviceid":"'. $Info->devid .'"}');
    }
    $numrows = mysqli_num_rows($rows); 
    if($numrows){
        while($row = mysqli_fetch_assoc($rows)){
            $Info->id = intval($row['id']);
            $Info->type = $row['type'];
            $Info->name = $row['name'];
            $Info->state = $row['state'];
            $Info->previousstate = $row['previousstate'];
            $Info->stateid = intval($row['stateid']);
            $Info->previousstateid = intval($row['previousstateid']);
            $Info->lastdate = $row['lastdate'];
            $Info->regdate = $row['regdate'];
            $Info->OwnerID = $row['OwnerID'];
        }
    }else{
        die('{"error":"Device id doesn\'t exists.","errorid":"500","deviceid":"'. $Info->devid .'"}');
    }
    
    $query = sprintf("SELECT * FROM `SmartoDeviceList` WHERE `type`='%s'", $Info->type );
    $rows = mysqli_query(Utils::$connect, $query);
    if($rows){
        $numrows = mysqli_num_rows($rows); 
        if($numrows){
            while($row = mysqli_fetch_assoc($rows)){
                $Info->defaultName = $row['name'];
                $Info->defaultState1Text = $row['State1Text'];
                $Info->defaultState0Text = $row['State0Text'];
            }
        }else{
            //die('{"error":"Device id doesn\'t exists.","errorid":"500","deviceid":"'. $Info->devid .'"}');
        }
    }
    return $Info;
}
