<?php
class MySQLOnno204WW {
    function MySQLOnno204WW(){
        $this->Username = "udzotgxc_SiteManager";
        $this->Password = "SiteManager1";
        $this->Database = "udzotgxc_Personal";
        $this->URL = "localhost";
        $this->NoMainPasswords = "NoMainPasswords";
    }
    
    function Connect(){
        $this->conn = new mysqli($this->URL, $this->Username, $this->Password, $this->Database);
    }
    
    function First(){
        $sql = "CREATE TABLE $this->NoMainPasswords ( id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            username VARCHAR(100), password VARCHAR(500), url VARCHAR(500))";
        if ($this->conn->query($sql) == "true"){ echo "Table $this->NoMainPasswords created successfully" . "<br>";
        }else{
            if($this->conn->error == "Table '$this->NoMainPasswords' already exists"){
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
        $sql = "SELECT * FROM $this->NoMainPasswords";
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
    function ShowAllPasswords(){
        $sql="SELECT * FROM $this->NoMainPasswords";
        $result=$this->conn->query($sql);
        echo '
            <table class="PWDBTable" >
                <tr>
                    <th class="PWDBTDTH" >Username</th>
                    <th class="PWDBTDTH" >Password</th>
                    <th class="PWDBTDTH" >URL</th>
                </tr>
        ';
        
        if ($result->num_rows > 0) { while($row = $result->fetch_assoc()) {
            $URL = $row['url'];
            $WW = $row['password'];
            $UserName = $row['username'];
            echo '
                  <tr class="PWDBTR" >
                    <td class="PWDBTDTH" >' . $UserName . '</td>
                    <td class="PWDBTDTH" onclick="PopupWW(\'' . $WW . '\')" >' . $this->RandomNess($WW, .8) . '</td>
                    <td class="PWDBTDTH" ><a  target="_blank" href="' . $URL . '">' . $this->RandomNess($URL, .15) . '</a></td>
                  </tr>
            ';
        }
        echo '
                </table>
        ';
        }else { echo "0 results"; }
    }
    function AddPassword($Username, $WW, $URL){
        $sql = "INSERT INTO `$this->NoMainPasswords` (`username`, `password`, `url`) VALUES ('" . $Username . "','". $WW ."','". $URL ."')";
        echo $sql;
        $Result = $this->conn->query($sql);
        if ($Result === TRUE) { 
            echo $Username;
            echo $WW;
            echo $URL;
            echo "Succesfully updated your settings!<br>";
        } else { echo "Error: " . $sql . "<br>" . $this->conn->error . "<br>";
        }
    }
    
    function RandomNess($ToRandom, $amount){
        
            $str = "" . $ToRandom;
            $len = strlen($str);
            $num_to_remove = ceil($len * $amount); // 40% removal
            for($i = 0; $i < $num_to_remove; $i++) {
              $k = 0;
              do {
                $k = rand(1, $len);
              } while($str[$k-1] == "*");
              $str[$k-1] = "*";
            }
            echo '<script> console.log("'.$str.'"); </script>';
            return $str;
    }
    
    
    
}