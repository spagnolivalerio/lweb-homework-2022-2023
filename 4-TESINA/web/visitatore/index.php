<?php

    session_start();

    if(!isset($_SESSION['Tipo_utente']) || empty($_SESSION['Tipo_utente'])){
        header('Location: homepage.php');
    } else {
        header('Location: ../index.php');
    }

    exit;
?>