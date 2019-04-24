<?php
class MySQL {
    public function MySQL(){
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
            email VARCHAR(40), phone INT(25), fullname VARCHAR(100), about VARCHAR(500),
            terms INT(2), banned INT(2), permissions MEDIUMTEXT, ip MEDIUMTEXT, gender VARCHAR(20), reg_date TIMESTAMP
        )";
        if ($this->conn->query($sql) == "true"){ echo "Table $this->LoginTable created successfully" . "<br>";
        }else{
            if($this->conn->error == "Table '$this->LoginTable' already exists"){
            }else{
            echo "Error creating table: " . $this->conn->error . "<br>" . "<br>";
            }
        }
    }
    
    function CheckConnection(){
        if ($this->conn->connect_error) {
            echo("Connection failed: " . $this->conn->connect_error . "<br>");
        }
    }
    
    function RunQuery($sql){
        $Result = $this->conn->query($sql);
        if ($Result === TRUE) { echo "New record created successfully" . "<br>";
        } else { echo "Error: " . $sql . "<br>" . $this->conn->error . "<br>";
        }
        return $Result;
    }
    
    function CloseConnection(){
        $this->conn->close();
    }
    public function GetAllData(){
        $sql = "SELECT * FROM $this->LoginTable";
        $Result = $this->conn->query($sql);
        if ($Result->num_rows > 0) { return $Result->fetch_assoc();
        } else { return 0; }
    }
    
    public function GetUsernames(){
        echo "WHAT";
        $sql = "SELECT * FROM $this->LoginTable";
        $Result = $this->conn->query($sql);
        $Users = Array("NULL");
        if ($Result->num_rows > 0) {
            while($row = $Result->fetch_assoc()) {array_push($Users, $row['username']);}
        } else { echo "0 results"; }
        return $Users;
    }
    public function GetEMails(){
        $sql = "SELECT * FROM $this->LoginTable";
        $Result = $this->conn->query($sql);
        $Users = Array("NULL");
        if ($Result->num_rows > 0) {
            while($row = $Result->fetch_assoc()) {array_push($Users, $row['email']);}
        } else { echo "0 results"; }
        return $Users;
    }
    public function GetFullname(){
        $sql = "SELECT * FROM $this->LoginTable";
        $Result = $this->conn->query($sql);
        $Users = Array("NULL");
        if ($Result->num_rows > 0) {
            while($row = $Result->fetch_assoc()) {array_push($Users, $row['fullname']);}
        } else { echo "0 results"; }
        return $Users;
    }
    public function GetPhone(){
        $sql = "SELECT * FROM $this->LoginTable";
        $Result = $this->conn->query($sql);
        $Users = Array("NULL");
        if ($Result->num_rows > 0) {
            while($row = $Result->fetch_assoc()) {array_push($Users, $row['phone']);}
        } else { echo "0 results"; }
        return $Users;
    }
    
    function CheckExits($Username, $EMail, $Fullname, $Phone){
        $Error = FALSE;
        echo '1';
        echo in_array($Username, GetUsernames());
        if (in_array($Username, GetUsernames()) ){ $Error=TRUE; echo "The username '$Username' was already taken. "; }
        echo '2';
        if (in_array($Fullname, GetFullname() ) ){ $Error=TRUE; echo "The Username '$Fullname' was already taken. "; }
        echo '3';
        if (in_array($EMail, GetEmail() ) ){ $Error=TRUE; echo "The Email '$EMail' was already taken. "; }
        echo '4';
        if (in_array($Phone, GetPhone() ) ){ $Error=TRUE; echo "The Phone Number '+$Phone' was already taken. "; }
        echo '5';
        return $Error;
    }
    
    function AddUser($Username, $Password, $Age, $EMail, $Phone, $Fullname, $About, $AcceptTerms, $Banned, $Perms, $Currentip){
        $LoginTable = $this->LoginTable;
        $sql = "INSERT INTO `$LoginTable` (`id`, `username`, `password`, `age`, `email`, `phone`, `fullname`, `about`, `terms`, `banned`, `permissions`, `ip`, `reg_date`) VALUES (NULL, '$Username', '$Password', '$Age', '$EMail', '$Phone', '$Fullname', '$About ', '$AcceptTerms', '$Banned', '$Perms', '$Currentip', CURRENT_TIMESTAMP);";
        $Result = $this->conn->query($sql);
        if ($Result === TRUE) { echo "New record created successfully" . "<br>";
        } else { echo "Error: " . $sql . "<br>" . $this->conn->error . "<br>";
        }
    }
    
    
}
