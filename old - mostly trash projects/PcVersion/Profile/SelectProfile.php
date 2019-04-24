
<div>
    <script src="AddOns/JavaScripts/SelectProfile.js"></script>
    <link rel="stylesheet" type="text/css" href="AddOns/Styles/SelectProfile.css"/>
    <h1>Insert the username!</h1>
    Username: <input type="text" id="username" name="username" value="<?php echo $_SESSION['username']; ?>" maxlength="100" required>
    <br>
    <a onclick="SelectProfileNext(null)" href="https://www.onno204.nl.eu.org/PcVersion/#/Profile/ViewProfile" class="SelectProfileButton">Profile</a>
    
    
    <div class="SelectProfileSelectProfile">
    <?php
        require_once '../AddOns/phps/MySQL.php';
        $MySQL = new MySQL();
        echo $MySQL->Connect();
        $MySQL->CheckConnection();
        $MySQL->First();
        $MySQL->ShowAllProfiles();
    ?> 
    </div>
    
</div>