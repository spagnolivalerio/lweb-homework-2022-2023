<?php

session_start();
if(isset($_SESSION['Tipo_utente'])){
    $tipo = $_SESSION['Tipo_utente'];
    header("Location: web/$tipo/index.php"); 
    exit; 
} 

$_SESSION['Tipo_utente'] = "visitatore"; 
header("Location: web/visitatore/index.php"); 
exit; 

?>