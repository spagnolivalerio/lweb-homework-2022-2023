<?php

    session_start();
    require_once('functions.php');
    $xmlFile = "../data/xml/tutorials.xml";
    $img_dir_path = "../img/steps/";

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

    if(!isset($_POST['num_step']) || empty($_POST['num_step'])){
        exit;
    } else {
        $num_step = $_POST['num_step']; 
    }

    if(!isset($_FILES['img']['tmp_name']) || empty($_FILES['img']['tmp_name'])){
        exit;
    } else {
        $img_location = $_FILES['img']['tmp_name']; 
    }

    $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
    $nome_file_img = $img_dir_path .  "img_step_" . $num_step . "_proj_" . $id_progetto . "." . $ext;  
    $fd = fopen($nome_file_img, 'w'); 

    $img = file_get_contents($img_location); 

    if($fd){

        fwrite($fd, $img);
        fclose($fd);

    } else {

        exit; 

    }

    $doc = getDOMdocument($xmlFile);
    $xpath = new DOMXPath($doc);

    $tutorial = $xpath->query("/tutorials_progetti/tutorial_progetto[@id_progetto = '$id_progetto']")->item(0);

    $step = $doc->createElement('step'); 
    $descrizione = $doc->createElement('descrizione', $descrizione);

    $step->setAttribute('num_step', $num_step);
    $step->setAttribute('nome_file_img', $nome_file_img);

    $step->appendChild($descrizione);

    $tutorial->appendChild($step);

    $doc->formatOutput = true;
    $xmlString = $doc->saveXML();
    file_put_contents($xmlFile, $xmlString);

    header('Location: ../prove_funzioni/prova_aggiungi_step.php');
    exit; 

?>