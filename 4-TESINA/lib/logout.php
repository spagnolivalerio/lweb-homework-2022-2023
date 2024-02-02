<?php
session_start(); 
session_destroy(); 

if(isset($_GET['ban']) && $_GET['ban'] == "true"){
    session_start();
    $_SESSION['error_ban'] = "true";
    header('Location: ../web/login.php');
    exit;
}

header('Location: ../index.php');
exit; 
?>