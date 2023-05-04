<?php 

    $servername='127.0.0.1';
    $db_username='root';
    $db_password='password';
    $db_name='sands';

    function create_db($server, $username, $mypassword, $name_of_db){

        $myconn = new mysqli($server, $username, $mypassword, $name_of_db);

        if($myconn->connect_error){
            exit(1);
        }

        return $myconn;
    }
     
?>
    
