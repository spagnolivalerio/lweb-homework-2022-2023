<?php
    if(!isset($_SESSION['tipo_utente'])) {
        header('Location: web/login.html');
    }

    header('Location: web/homepage.html');

?>