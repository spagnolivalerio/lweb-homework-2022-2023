<?php

session_start();
require_once 'functions.php';
$xmlFile = "../data/xml/tutorials.xml";
$img_dir_path = "img/steps/";

if (!isset($_POST['descrizione']) || empty($_POST['descrizione'])) {
    exit;
} else {
    $descrizione = $_POST['descrizione'];
}

if (!isset($_POST['id_progetto']) || empty($_POST['id_progetto'])) {
    exit;
} else {
    $id_progetto = $_POST['id_progetto'];
}

if (!isset($_POST['num_step'])) {
    exit;
} elseif (!empty($_POST['num_step']) || $_POST['num_step'] === '0') {
    $num_step = (int) $_POST['num_step'] + 1;
}

if (!isset($_FILES['img']['tmp_name']) || empty($_FILES['img']['tmp_name'])) {
    exit;
} else {
    $img_location = $_FILES['img']['tmp_name'];
}

$doc = getDOMdocument($xmlFile);
$xpath = new DOMXPath($doc);
$ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);

$tutorial = $xpath->query("/tutorials_progetti/tutorial_progetto[@id_progetto = '$id_progetto']")->item(0);

$succ_step = $xpath->query("/tutorials_progetti/tutorial_progetto[@id_progetto = '$id_progetto']/step[@num_step = '$num_step']")->item(0);

$nome_file_img = $img_dir_path . uniqid('img_step_') . "." . $ext;

$newStep = $doc->createElement('step');
$descrizione = $doc->createElement('descrizione', $descrizione);
$newStep->appendChild($descrizione);
$newStep->setAttribute('nome_file_img', $nome_file_img);
$newStep->setAttribute('num_step', $num_step);

if ($succ_step === null) {

    $tutorial->appendChild($newStep);

} else {

    $k = 1;
    $tutorial->insertBefore($newStep, $succ_step);
    $steps = $tutorial->childNodes;

    foreach ($steps as $step) {

        $step->setAttribute('num_step', $k);
        $k++;
    }
}

$nome_file_img = "../" . $nome_file_img; 
add_img($img_location, $nome_file_img);

$doc->formatOutput = true;
$xmlString = $doc->saveXML();
file_put_contents($xmlFile, $xmlString);

header('Location: ../prove_funzioni/prova_aggiungi_step.php');
exit;

?>
