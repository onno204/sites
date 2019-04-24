<?php

require 'Utils.php';
$Utils = new Utils();
$Utils->ConnectCheck();

?>
<iframe style="width: 99vw; height: 50vh; border-style: none;" src="/Login/">
    
</iframe>

<?php

//Secure Input: $Utils->FormatString($username)

//$_SESSION['username']
//$_SESSION['nickname']
//$_SESSION['email']
//$_SESSION['password']


$Utils->LastLoad();