<?php

    session_start();

    if(isset($_SESSION['Tipo_utente']) && $_SESSION['Tipo_utente'] === "standard"){
        header('Location: homepage.php');
    } else {
        header('Location: ../index.php');
    }

    exit;
?>