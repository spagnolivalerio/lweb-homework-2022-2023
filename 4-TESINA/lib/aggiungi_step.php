<?php

    session_start();
    require_once('functions.php');
    $xmlFile = "../data/xml/tutorials.xml";

    if(!isset($_POST['descrizione']) || empty($_POST['descrizione'])){
        exit;
    } else {
        $descrizione = $_POST['descrizione']; 
    }

    if(!isset($_POST['id_progetto']) || empty($_POST['id_progetto'])){
        exit;
    } else {
        $id_progetto = $_POST['id_progetto']; 
    }

    if(!isset($_FILES['img']['tmp_name']) || empty($_FILES['img']['tmp_name'])){
        exit;
    } else {
        $fileimg = $_FILES['img']['tmp_name']; 
    }

    echo"$fileimg";

    //$content_base64 = base64_encode(file_get_contents($fileimg));

    //echo"$content_base64"; 
?>