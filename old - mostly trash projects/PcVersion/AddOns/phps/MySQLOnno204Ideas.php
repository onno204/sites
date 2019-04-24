<?php
class MySQLOnno204Ideas {
    function MySQLOnno204Ideas(){
        $this->Username = "udzotgxc_SiteManager";
        $this->Password = "SiteManager1";
        $this->Database = "udzotgxc_Personal";
        $this->URL = "localhost";
        $this->Ideas = "Ideas";
    }
    
    function Connect(){
        $this->conn = new mysqli($this->URL, $this->Username, $this->Password, $this->Database);
    }
    
    function First(){
        $sql = "CREATE TABLE $this->Ideas ( id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            type VARCHAR(100), idea VARCHAR(500))";
        if ($this->conn->query($sql) == "true"){ echo "Table $this->Ideas created successfully" . "<br>";
        }else{
            if($this->conn->error == "Table '$this->Ideas' already exists"){
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
    function ShowAllIdeas(){
        $sql="SELECT * FROM $this->Ideas ORDER BY  `type` ASC";
        $result=$this->conn->query($sql);
        echo ' <table class="IdeasTable" >
                <tr>
                    <th class="IdeasTDTH IdeasSmallType" >Type</th>
                    <th class="IdeasTDTH" >Idea</th>
                    <th class="IdeasTDTH IdeasSmall" >Remove</th>
                </tr> ';
        if ($result->num_rows > 0) { while($row = $result->fetch_assoc()) {
            $Type = $row['type'];
            $Idea = $row['idea'];
            $ID = $row['id'];
            echo ' <tr class="IdeasTR" >
                    <td class="IdeasTDTH">' . $Type . '</td>
                    <td class="IdeasTDTH">' . $Idea . '</td>
                    <td class="IdeasTDTH IdeasSmall" onclick="RemoveIdea(\'' . $ID . '\')" >' .$ID. ' - X</td>
                  </tr> ';
        } echo ' </table> ';
        }else { echo "0 results"; }
    }
    function ShowAllIdeasNoAdmin(){
        $sql="SELECT * FROM $this->Ideas ORDER BY  `type` ASC";
        $result=$this->conn->query($sql);
        echo ' <table class="IdeasTable" >
                <tr>
                    <th class="IdeasTDTH IdeasSmallType" >Type</th>
                    <th class="IdeasTDTH" >Idea</th>
                </tr> ';
        if ($result->num_rows > 0) { while($row = $result->fetch_assoc()) {
            $Type = $row['type'];
            if($Type == "Site"){
                $Idea = $row['idea'];
                echo ' <tr class="IdeasTR" >
                        <td class="IdeasTDTH">' . $Type . '</td>
                        <td class="IdeasTDTH">' . $Idea . '</td>
                      </tr> ';
            }
        } echo ' </table> ';
        }else { echo "0 results"; }
    }
    function AddIdea($type, $idea){
        $sql = "INSERT INTO `$this->Ideas` (`type`, `idea`) VALUES ('" . $type . "','". $idea ."')";
        $Result = $this->conn->query($sql);
        if ($Result === TRUE) {
            echo "Succesfully updated your settings!<br>";
        } else { echo "Error: " . $sql . "<br>" . $this->conn->error . "<br>";
        }
    }
    function RemoveIdea($id){
        $sql = "DELETE FROM `Ideas` WHERE `id` = " . $id;
        $Result = $this->conn->query($sql);
        if ($Result === TRUE) {
            echo "Succesfully updated your settings!<br>";
        } else { echo "Error: " . $sql . "<br>" . $this->conn->error . "<br>";
        }
    }
}