
<nav>
    <ul>
        <base href="https://site.onno204vps.nl.eu.org/Smarthome/">
        <li><a href="index.php">Index</a></li>
        <li><a href="RegisterDevice.php">Register Device</a></li>
        <li><a href="#">O</a></li>
        <li><a href="#" onclick="$('#Typeselect').focus()">
            <select id="Typeselect" onchange="location = this.options[this.selectedIndex].value">
                <option value="https://site.onno204vps.nl.eu.org/Smarthome/" disabled selected>Filter On Type</option>
                <option value="https://site.onno204vps.nl.eu.org/Smarthome/">No filter</option>
                <?php
                    $query = sprintf("SELECT * FROM `SmartoDeviceList`");
                    $rows = mysqli_query(Utils::$connect, $query);
                    $numrows = mysqli_num_rows($rows); 
                    if($numrows){
                        while($row = mysqli_fetch_assoc($rows)){
                            ?>
                                <option value="https://site.onno204vps.nl.eu.org/Smarthome/index.php?type=<?php echo $row['type']; ?>"><?php echo $row['type']; ?></option>
                            <?php
                        }
                    }else{
                        echo "<option value='error'>Error, No results!</p>";
                    }
                ?>
            </select>
        </a></li>
        
    </ul>
</nav>