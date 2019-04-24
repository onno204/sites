<?php

if(!isset($Errorcode)){
    $Errorcode = getenv("REDIRECT_STATUS");
}

switch($Errorcode)
{
	# "400 - Bad Request"
	case 400:
	$error_code = "400 - Bad Request";
        $error_code_plain = 400;
        $error_explain = "Something went wrong!";
	break;

	# "401 - Unauthorized"
	case 401:
	$error_code = "401 - Unauthorized";
        $error_code_plain = 401;
        $error_explain = "
            <p>You aren't logged in!</p>
            <br>
            <h1><a href=\Login\>Login or Register</a></h1>
            ";
	break;

	# "403 - Forbidden"
	case 403:
	$error_code = "403 - Forbidden";
        $error_code_plain = 403;
        $error_explain = "
            <p>Your account is not authorized to see this page!</p>
            <br>
            <h1><a href=\Login\>Login or Register</a></h1>
            ";
	break;

	# "404 - Not Found"
	case 404:
	$error_code = "404 - Not Found";
        $error_code_plain = 404;
        $error_explain = "The file you where looking for was not found on our servers!";
	break;
}

?>
<style>
    Upper{
        width: 100vw;
        height: 15vh;
        background-color: rgba(150,150,150,1);
        position: absolute;
        top: 0px;
        left:0px;
        font-size: 5vh;
        align-items: center;
        justify-content: center;
        display: flex;
    }
    Main{
        width: 100vw;
        height: 70vh;
        background-color: rgba(199,199,199,1);
        position: absolute;
        top: 15vh;
        left:0px;
        font-size: 5vh;
        text-align: center;
        align-items: center;
        justify-content: center;
    }
    footer{
        width: 100vw;
        height: 15vh;
        background-color: rgba(100,100,100,1);
        position: absolute;
        top: 85vh;
        left:0px;
        font-size: 5vh;
        align-items: center;
        justify-content: center;
        display: flex;
    }
</style>

<title>Error: <?php echo $error_code; ?></title>
<Upper>
    <?php echo $error_code; ?>
</Upper>
<Main>
    <br>
    <?php echo $error_explain; ?>
</Main>
<footer>
    blablalba
</footer>


<?php

echo $error_code;
echo "<br>";
echo $error_code_plain;
echo "<br>";
echo $error_explain;


