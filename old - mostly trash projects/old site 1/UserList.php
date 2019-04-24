<?php

if(!$Utils->HasPerms("ViewUserlist")){
    echo "<p class=\"MsgError\">You have no perms to see this page!</p>";
    return;
}


echo "Users: ";
echo "<ul>";
$query = sprintf("SELECT username FROM `Users`");
$rows = mysqli_query(Utils::$connect, $query);
$numrows = mysqli_num_rows($rows); 
if($numrows){
    while($row = mysqli_fetch_assoc($rows)){
        #id, name, username, email, password, registerdate, lastlogin, permissions
        echo "<li>" . $row['username'] . "</li>";
    }
}else{
    echo "<p class=\"MsgError\">Error, No results!</p>";
}

echo "</ul>";