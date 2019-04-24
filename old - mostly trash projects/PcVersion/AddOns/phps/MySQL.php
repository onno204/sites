<?php
class MySQL {
    function MySQL(){
        $this->Username = "udzotgxc_SiteManager";
        $this->Password = "SiteManager1";
        $this->Database = "udzotgxc_SiteDB";
        $this->URL = "localhost";
        $this->LoginTable = "UserData2";
    }
    
    function Connect(){
        $this->conn = new mysqli($this->URL, $this->Username, $this->Password, $this->Database);
    }
    
    function First(){
        $sql = "CREATE TABLE $this->LoginTable ( id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            username VARCHAR(100) NOT NULL, password VARCHAR(100) NOT NULL, age INT(2),
            email VARCHAR(40), phone INT(25), fullname VARCHAR(100), about VARCHAR(500), profilepicture LONGBLOB NULL,
            terms INT(2), banned INT(2), permissions VARCHAR(200) NOT NULL DEFAULT  'Member', ip MEDIUMTEXT, gender VARCHAR(20), reg_date TIMESTAMP
        )";
        if ($this->conn->query($sql) == "true"){ echo "Table $this->LoginTable created successfully" . "<br>";
        }else{
            if($this->conn->error == "Table '$this->LoginTable' already exists"){
            }else{
            echo "Error creating table: " . $this->conn->error . "<br>" . "<br>";
            }
        }
    }
    
    function CheckConnection(){ if ($this->conn->connect_error) { echo("Connection failed: " . $this->conn->connect_error . "<br>"); } }
    
    function RunQuery($sql){
        $Result = $this->conn->query($sql);
        if ($Result === TRUE) { echo "New record created successfully" . "<br>";
        } else { echo "Error: " . $sql . "<br>" . $this->conn->error . "<br>";
        }
        return $Result;
    }
    
    function CloseConnection(){ $this->conn->close(); }
    function GetAllData(){
        $sql = "SELECT * FROM $this->LoginTable";
        $Result = $this->conn->query($sql);
        if ($Result->num_rows > 0) { return $Result->fetch_assoc();
        } else { return 0; }
    }
    
    function GetUsernames() {
        $sql = "SELECT * FROM $this->LoginTable";
        $Result = $this->conn->query($sql);
        $Users = Array("NULL");
        if ($Result->num_rows > 0) {
            while($row = $Result->fetch_assoc()) {array_push($Users, $row['username']);}
        } else { echo "0 results<br>"; }
        return $Users;
    }
    
    function CheckExits($Username, $EMail, $Fullname, $Phone){
        $Error = FALSE;
        if (in_array($Username, $this->GetUsernames() ) ){ $Error=TRUE; echo "The Username '$Username' was already taken. <br>"; }
        if (in_array($Fullname, $this->GetFullname() ) ){ $Error=TRUE; echo "The User '$Fullname' Has already registerd an account before! <br>"; }
        if (in_array($EMail, $this->GetEmail() ) ){ $Error=TRUE; echo "The Email '$EMail' was already used. <br>"; }
        if (in_array($Phone, $this->GetPhone() ) ){ $Error=TRUE; echo "The Phone Number '+$Phone' was already used. <br>"; }
        return $Error;
    }
    
    function AddUser($ID, $Username, $Password, $Age, $EMail, $Phone, $Fullname, $About, $AcceptTerms, $Banned, $Currentip, $Gender){
        $LoginTable = $this->LoginTable;
        $sql = "INSERT INTO `$LoginTable` (`id`, `username`, `password`, `age`, `email`, `phone`, `fullname`, `about`, `terms`, `banned`, `ip`, `gender`, `reg_date`) VALUES ('$ID', '$Username', '$Password', '$Age', '$EMail', '$Phone', '$Fullname', '$About ', '$AcceptTerms', '$Banned', '$Currentip', '$Gender', CURRENT_TIMESTAMP);";
        $Result = $this->conn->query($sql);
        if ($Result === TRUE) { 
        } else { echo "Error: " . $sql . "<br>" . $this->conn->error . "<br>";
        }
    }
    function CheckUser($row, $Username, $Password){
        if($row["username"] == $Username){
            if($row["password"] == $Password){ return TRUE;
            }else{ echo "Wrong Password enterd! <br>"; }
        }else { }
    }
    
    function GetUserPassword($User){
        $sql = "SELECT * FROM $this->LoginTable WHERE  `username` LIKE  '$User'";
        $Result = $this->conn->query($sql);
        if ($Result->num_rows > 0) {
            while($row = $Result->fetch_assoc()) { return $row['password'];}
        } else { echo "0 results<br>"; }
        return NULL;
    }
    
    function GetUserID($User){
        $sql = "SELECT * FROM $this->LoginTable WHERE  `username` LIKE  '$User'";
        $Result = $this->conn->query($sql);
        if ($Result->num_rows > 0) {
            while($row = $Result->fetch_assoc()) { return $row['id'];}
        } else { echo "0 results<br>"; }
        return NULL;
    }
    
    function LoginUser($Username, $Password){
        $sql = "SELECT username, password FROM $this->LoginTable";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if ($this->CheckUser($row, $Username, $Password)) {
                    return TRUE;
                }
            }
        } else {
            echo "0 results";
        }
        return FALSE;
    }
    
    function GetUserIdentitie($Username, $Password){
        $sql = "SELECT * FROM $this->LoginTable WHERE `username` LIKE  '$Username' AND  `password` LIKE  '$Password'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                return $row;
            }
        } else {
            echo "0 results";
        }
        return $result;
    }
    
    function SaveImage($User, $Image){
        //UPDATE  `UserData2` SET `username`='onno205' WHERE `username` LIKE 'onno204'
        $sql = "UPDATE  `$this->LoginTable` SET `profilepicture`='$Image' WHERE `username` LIKE '$User'";
        //$sql="insert into $this->LoginTable (profilepicture) values ('$Image')";
        $Result = $this->conn->query($sql);
        if ($Result === TRUE) { 
            echo "Profile Picture uploaded!<br>";
        } else { echo "Error: " . $sql . "<br>" . $this->conn->error . "<br>";
        }
    }
    function GetImage($User, $Class){
        $sql="SELECT * FROM $this->LoginTable WHERE `username` LIKE'$User' ";
        $result=$this->conn->query($sql);
        
        $DefaultPic = "PcVersion/../AddOns/Pictures/Image.png";
        $Output = '<img class="'.$Class.'" src="'.$DefaultPic.'">';
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if($row['profilepicture'] != NULL){
                    $Output =  '<img class="'.$Class.'" src="data:image;base64,'.$row['profilepicture'].'">';
                }
            }
        }else { echo "0 results";
        }
        echo $Output;
    }
    function GetGender($User){
        $sql="SELECT * FROM $this->LoginTable WHERE `username` LIKE'$User' ";
        $result=$this->conn->query($sql);
        if ($result->num_rows > 0) { while($row = $result->fetch_assoc()) {
                return $row['gender'];
        } }else { echo "0 results"; }
    }
    function GetId($User){
        $sql="SELECT * FROM $this->LoginTable WHERE `username` LIKE'$User' ";
        $result=$this->conn->query($sql);
        if ($result->num_rows > 0) { while($row = $result->fetch_assoc()) {
                return $row['id'];
        } }else { echo "0 results"; }
    }
    function GetAge($User){
        $sql="SELECT * FROM $this->LoginTable WHERE `username` LIKE'$User' ";
        $result=$this->conn->query($sql);
        if ($result->num_rows > 0) { while($row = $result->fetch_assoc()) {
                return $row['age'];
        } }else { echo "0 results"; }
    }
    function GetEmail($User){
        $sql="SELECT * FROM $this->LoginTable WHERE `username` LIKE'$User' ";
        $result=$this->conn->query($sql);
        if ($result->num_rows > 0) { while($row = $result->fetch_assoc()) {
                return $row['email'];
        } }else { echo "0 results"; }
    }
    function GetPhone($User){
        $sql="SELECT * FROM $this->LoginTable WHERE `username` LIKE'$User' ";
        $result=$this->conn->query($sql);
        if ($result->num_rows > 0) { while($row = $result->fetch_assoc()) {
                return $row['phone'];
        } }else { echo "0 results"; }
    }
    function GetFullname($User){
        $sql="SELECT * FROM $this->LoginTable WHERE `username` LIKE'$User' ";
        $result=$this->conn->query($sql);
        if ($result->num_rows > 0) { while($row = $result->fetch_assoc()) {
                return $row['fullname'];
        } }else { echo "0 results"; }
    }
    function GetAbout($User){
        $sql="SELECT * FROM $this->LoginTable WHERE `username` LIKE'$User' ";
        $result=$this->conn->query($sql);
        if ($result->num_rows > 0) { while($row = $result->fetch_assoc()) {
                return $row['about'];
        } }else { echo "0 results"; }
    }
    function GetPerms($User){
        $sql="SELECT * FROM $this->LoginTable WHERE `username` LIKE'$User' ";
        $result=$this->conn->query($sql);
        if ($result->num_rows > 0) { while($row = $result->fetch_assoc()) {
            $Group = $row['permissions'];
            return $Group;
        } }else { echo "0 results"; }
    }
    
    function UpdateSettings($User, $Option, $NewVariable){
        $sql = "UPDATE  `$this->LoginTable` SET `$Option`='$NewVariable' WHERE `username` LIKE '$User'";
        $Result = $this->conn->query($sql);
        if ($Result === TRUE) { 
            echo "Succesfully updated your settings!<br>";
        } else { echo "Error: " . $sql . "<br>" . $this->conn->error . "<br>";
        }
    }
    function ShowAllProfiles(){
        $sql="SELECT * FROM $this->LoginTable ORDER BY  `username` ASC";
        $result=$this->conn->query($sql);
        echo ' <table class="SelectProfileTable" > ';
        if ($result->num_rows > 0) { while($row = $result->fetch_assoc()) {
            $Username = $row['username'];
            echo ' <tr class="SelectedProfileTR" > <td class="SelectProfileTDTH" onclick="SelectProfileNext(\'' . $Username . '\')" >' .$Username. '</td> </tr> ';
        } 
        echo ' </table> ';
        }else { echo "0 results"; }
    }    
}