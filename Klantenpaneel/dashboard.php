<?php 
    require "config.php";
    if(isUserLoggedIn() == false){
        die("<h1>Je moet ingelogged zijn voor deze actie!</h1><a href=\"login\">Login</a>");
    }
    if(doesUserHavePermission("dashboard") == false){
        die("<h1>You don't have permission to view this page</h1>");
    }
?>

<h1>dashboard</h1>
<?php include "nav.php"; ?>