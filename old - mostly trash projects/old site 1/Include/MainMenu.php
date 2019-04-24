<nav>
    <ul>
        <base href="https://site.onno204vps.nl.eu.org/">
        <li><a href="index.php">Main</a></li>
        <li><a href="Login.php">Login</a></li>
        
        <?php
        
            if($Utils->HasPerms("Random")){
                ?>
                    <li><a href="Random/Carnaval2019.php">Carnaval 2019</a></li>
                    <li><a href="Random/MeekijkDetector.php">Meekijk Detector</a></li>
                <?php
            }
            if($Utils->HasPerms("ViewPasswords")){
                ?>
                    <li><a href="Password.php">PasswordList</a></li>
                <?php
            }
            if($Utils->HasPerms("Smarthome")){
                ?>
                    <li><a href="/Smarthome/">Smarthome</a></li>
                <?php
            }
            if($Utils->HasPerms("ViewUserlist")){
                ?>
                    <li><a href="UserList.php">Userlist</a></li>
                <?php
            }
            if($Utils->HasPerms("HockeyLog")){
                ?>
                    <li><a href="Hockey.php">Hockey Log</a></li>
                <?php
            }
        
        ?>
    </ul>
</nav>