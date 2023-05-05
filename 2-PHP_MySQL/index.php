<?php

    session_start();

    require('res/var/connection.php');

    $conn = new mysqli($servername, $db_username, $db_password);

    if ($conn->connect_error) {
        exit(1);
    }

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