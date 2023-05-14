<?php

    session_start();

    require('res/var/connection.php');

    $conn = new mysqli($servername, $db_username, $db_password);

    if ($conn->connect_error) {
        exit();
    }

    if(!isset($_SESSION['tipo_utente'])) {
        header('Location: web/login.php');
        exit();
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