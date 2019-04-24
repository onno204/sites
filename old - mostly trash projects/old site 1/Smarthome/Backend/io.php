<?php

include "GetDeviceInfo.php";


if(isset($_GET['IOid'])){
    if(!isset($_GET['IOstate'])){ 
        echo '{"error":"Missing IOstate","errorid":"500","deviceid":"'. $Info->devid .'"}';
        return false;
    }
    $IOstate = $Utils->FormatString($_GET['IOstate']);
    $Info = GetDevInfo($Utils->FormatString($_GET['IOid']));
    $IOstate = intval($IOstate);
    if($IOstate == $Info->stateid){
        echo '{"error":"Already in this state.","errorid":"500","deviceid":"'. $Info->devid .'"}';
        return false;
    }
    
    $CurrentTime = date("Y-m-d H:i:s");
    $PreviousState = $Info->state;
    $PreviousStateid = $Info->stateid;
    if($Info->previousstateid === $IOstate){
        $Newstate = $Info->previousstate;
        $Newstateid = $Info->previousstateid;
        $query = sprintf("UPDATE `SmartoDevices` SET `lastdate`='%s', `state`='%s', `previousstate`='%s', `stateid`='%s', `previousstateid`='%s' WHERE `devid`='%s'",
            $CurrentTime, $Newstate, $PreviousState, $Newstateid, $PreviousStateid, $Info->devid);
        $rows = mysqli_query(Utils::$connect, $query);
        echo mysqli_error(Utils::$connect);
    }
    if($IOstate > 1){
        $Newstate = "CustomState";
        $Newstateid = $IOstate;
        $CurrentTime = date("Y-m-d H:i:s");
        $query = sprintf("UPDATE `SmartoDevices` SET `lastdate`='%s', `state`='%s', `previousstate`='%s', `stateid`='%s', `previousstateid`='%s' WHERE `devid`='%s'",
            $CurrentTime, $Newstate, $PreviousState, $Newstateid, $PreviousStateid, $Info->devid);
        $rows = mysqli_query(Utils::$connect, $query);
        echo mysqli_error(Utils::$connect);
    }
    if($IOstate <= 1){
        $state1 = "";
        $state0 = "";
        //Get States
        $query = sprintf("SELECT * FROM `SmartoDeviceList` WHERE `type`='%s'",
                $Info->type);
        $rows = mysqli_query(Utils::$connect, $query);
        $numrows = mysqli_num_rows($rows); 
        if($numrows){
            while($row = mysqli_fetch_assoc($rows)){
                $state1 = $row['State1Text'];
                $state0 = $row['State0Text'];
            }
        }
        $Newstate = "CustomState";
        $Newstateid = $IOstate;
        if($IOstate === 1){
            $Newstate = $state1;
        }else if($IOstate === 0){
            $Newstate = $state0;
        }
        
        $CurrentTime = date("Y-m-d H:i:s");
        $query = sprintf("UPDATE `SmartoDevices` SET `lastdate`='%s', `state`='%s', `previousstate`='%s', `stateid`='%s', `previousstateid`='%s' WHERE `devid`='%s'",
            $CurrentTime, $Newstate, $PreviousState, $Newstateid, $PreviousStateid, $Info->devid);
        $rows = mysqli_query(Utils::$connect, $query);
        echo mysqli_error(Utils::$connect);
    }
    
    
    
    echo json_encode($Info);
    
}

