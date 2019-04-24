<?php

$config =  array(
    'db' => [
        'username' => 'root',
        'password' => '',
        'database' => 'clientpanel',
        'adress' => 'localhost',
    ],
    'permissions' => [
        "admins"=> [
            "manageproducts",
        ],
        "users"=> [
            "dashboard",
            "invoices",
            "buyproduct",
        ],
        "everyone"=> [
            "register",
            "login"
        ]
    ]
);
$config['permissions']['users'] = array_merge($config['permissions']['users'], $config['permissions']['everyone']);
$config['permissions']['admins'] = array_merge($config['permissions']['admins'], $config['permissions']['users']);


//Default Setup
session_start();
$conn = new mysqli($config['db']['adress'], $config['db']['username'], $config['db']['password'], $config['db']['database']);
if ($conn->connect_error) {
    die("<h1>Database connection error: </h1>");// . $conn->connect_error);
}
//End setup
function doesUserHavePermission($permission){
    global $config;
    $group = "everyone";
    if(isset($_SESSION['usergroup'])){
        $group = strtolower($_SESSION['usergroup']);
    }
    if(in_array(strtolower($permission), $config['permissions'][$group])){
        return true;
    }
    return false;
}
function isUserLoggedIn(){
    if(isset($_SESSION['token']) == false){
        return false;
    }
    global $conn;
    $stmt = $conn->prepare("SELECT id FROM users WHERE token = ?");
    $stmt->bind_param("s", $_SESSION['token']);
    $stmt->execute();
    $result = $stmt->get_result();
    $userexists = false;
    $passwordcorrect = false;
    while ($data = $result->fetch_assoc()){
        if($data['id'] == $_SESSION['id']){
            return true;
        }
    }
    return false;
}
function htmlToPlainText($str){
    $str = str_replace('&nbsp;', ' ', $str);
    $str = html_entity_decode($str, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $str = html_entity_decode($str, ENT_HTML5, 'UTF-8');
    $str = html_entity_decode($str);
    $str = htmlspecialchars_decode($str);
    $str = strip_tags($str);

    return $str;
}

function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
