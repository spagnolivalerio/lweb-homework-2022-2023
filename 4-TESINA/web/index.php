<?php

    session_start();

    if(isset($_SESSION['Tipo_utente'])){
        $tipo_utente = $_SESSION['Tipo_utente'];
    } else {
        header('Location: visitatore/homepage.php');
    }

    switch($tipo_utente){
        case 'admin': 
            header('Location: admin/index.php');
            break;
        case 'moderatore':
            header('Location: moderatore/index.php');
            break;
        case 'standard':
            header('Location: standard/index.php');
            break;
        default:
            header('Location: visitatore/index.php');
    }

    exit;

?>