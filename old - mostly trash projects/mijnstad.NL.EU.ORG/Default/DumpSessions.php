<?php
    session_start();
    echo "<h1>Loging out: " . $_SESSION['username'] . "</h1>";
    session_unset();
    session_destroy(); 
    echo $_SESSION['username'];
?>
<script>
    var delay = 100; //Your delay in milliseconds
    setTimeout(function(){ window.location = "http://reallands.nl.eu.org/"; }, delay);
</script>
