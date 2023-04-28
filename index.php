<?php

    session_start();

    require('res/var/db.php');

    $conn = new mysqli($servername, $db_username, $db_password);

    if ($conn->connect_error) {
        exit(1);
    }

    if(!mysqli_query($conn, $create_db)){
        exit(1);
    } else {
        $conn = new mysqli($servername, $db_username, $db_password, $db_name);
    }

    foreach ($queries as $query) {
        if(!$conn->query($query)){
            exit(1);
        }
    }

    $conn->close();

    if(!isset($_SESSION['tipo_utente'])) {
        header('Location: web/login.php');
        exit(1);
    } 

    switch ($_SESSION['tipo_utente']) {
        case 'cliente':
          header('Location: web/homepage.php');
          break;

        /*case 'amministratore':
          header('');
          break;*/
      }

?>