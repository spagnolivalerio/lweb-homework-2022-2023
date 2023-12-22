<?php

    session_start();

    if (!isset($_SESSION['Tipo_utente'])) {
        header('Location: ../web/login.php');
        exit;
    }

    if (!isset($_POST['id_bozza']) || empty($_POST['id_bozza'])) {
        exit;
    } else {
        $_SESSION['id_bozza'] = $_POST['id_bozza'];
    }

    header('Location: ../web/standard/form_progetto.php?modifica=true');
    exit;

?>