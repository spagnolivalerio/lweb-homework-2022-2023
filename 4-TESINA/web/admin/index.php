<?php

    session_start();

    if(isset($_SESSION['Tipo_utente']) && $_SESSION['Tipo_utente'] === "admin"){
        header('Location: moderator_dashboard.php');
    } else {
        header('Location: ../index.php');
    }

    exit;
?>