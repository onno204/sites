<?php
class MySQLMijnstad {
    function MySQLMijnstad(){
        $this->Username = "udzotgxc_Mijnstad";
        $this->Password = "MijnstadMijnstad 1";
        $this->Database = "udzotgxc_Mijnstad";
        $this->URL = "localhost";
        $this->LoginTable = "Ideas";
    }
    
    function Connect(){
        $this->conn = new mysqli($this->URL, $this->Username, $this->Password, $this->Database);
    }
    
    function First(){
        $sql = "CREATE TABLE $this->LoginTable ( id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, idea VARCHAR(500), 
            username VARCHAR(100))";
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
    function CheckUser($row, $Username, $Password){
        if($row["username"] == $Username){
            if($row["password"] == $Password){ return TRUE;
            }else{ echo "Wrong Password enterd! <br>"; }
        }else { }
    }
    function ShowAllideas(){
        $sql="SELECT * FROM $this->LoginTable";
        $result=$this->conn->query($sql);
        if ($result->num_rows > 0) { while($row = $result->fetch_assoc()) {
            $Idea = $row['idea'];
            $UserName = $row['username'];
            echo $UserName . ": " . $Idea . "<br>";
        } }else { echo "0 results"; }
    }
    function AddIdea($NewVariable, $Username){
        $sql = "INSERT INTO `$this->LoginTable` (`idea`, `username`) VALUES ('" . $NewVariable . "','". $Username ."')";
        $Result = $this->conn->query($sql);
        if ($Result === TRUE) { 
            echo "Succesfully updated your settings!<br>";
        } else { echo "Error: " . $sql . "<br>" . $this->conn->error . "<br>";
        }
    }
    
}