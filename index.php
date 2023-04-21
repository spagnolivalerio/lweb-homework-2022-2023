<?php

    session_start();

    require('res/var/db.php');

    $conn = new mysqli($servername, $db_username, $password);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if(!mysqli_select_db($conn, $dbname)){
        header('Location: res/lib/sql/conf.php');
    }  

    $conn->close();

    if(!isset($_SESSION['tipo_utente'])) {
        header('Location: web/login.html');
    }

    header('Location: web/homepage.html');
?>