<?php 
    session_start();

    require('../../var/db.php');

    $conn = new mysqli($servername, $username, $password);

    $sql = "CREATE DATABASE $dbname;

            CREATE TABLE utente (
             id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
             nome VARCHAR(30) NOT NULL,
             cognome VARCHAR(30) NOT NULL,
             email VARCHAR(50) NOT NULL UNIQUE
             )";


    if(!mysqli_query($conn,$sql)){
        die("Error");
    }

    header(Location: '../../index.php');
?>