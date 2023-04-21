<?php 
    session_start();

    require('../../var/db.php');

    $conn = new mysqli($servername, $db_username, $password);

    $sql = "CREATE DATABASE $dbname;";


    if(!mysqli_query($conn,$sql)){
        die("Error");
    }

    header('Location: ../../index.php');
?>