<?php

    session_start();

    require('res/var/db.php');

    $conn = new mysqli($servername, $db_username, $password);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        exit(1);
    }

    if(!mysqli_query($conn, $create_db)){
        die("Errore" . $conn->connect_error);
        exit(1);
    } else {
        $conn = new mysqli($servername, $db_username, $password, $dbname);
    }

    foreach ($queries as $query) {
        if(!$conn->query($query)){
            die("ERROR: ". $conn->connect_error);
            exit(1);
        }
    }

    $conn->close();

    if(!isset($_SESSION['tipo_utente'])) {
        header('Location: web/login.html');
    } else {
        header('Location: web/homepage.html');
    }

    
?>