<?php

class Utils{
    function Config(){
        return (object) array(
            'MainPath' => 'test/TestingSite/',
            'username' => 'root',
            'pass' => 'password',
            'database' => 'db'
        );                          
    }
}

?>