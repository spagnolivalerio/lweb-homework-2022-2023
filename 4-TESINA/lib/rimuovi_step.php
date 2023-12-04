<?php

session_start();
require_once 'functions.php';
$xmlFile = "../data/xml/tutorials.xml";
$img_dir_path = "../img/steps/";

if (!isset($_POST['id_progetto']) || empty($_POST['id_progetto'])) {
    exit;
} else {
    $id_progetto = $_POST['id_progetto'];
}

if (!isset($_POST['num_step']) || empty($_POST['num_step'])) {
    exit;
} else {
    $num_step = $_POST['num_step'];
}

$doc = getDOMdocument($xmlFile);
$xpath = new DOMXPath($doc);

$tutorialXPath = "/tutorials_progetti/tutorial_progetto[@id_progetto = '$id_progetto']";
$tutorial = $xpath->query($tutorialXPath)->item(0);

if ($tutorial) {
    $numStepXPath = "$tutorialXPath/step[@num_step = '$num_step']";
    $step = $xpath->query($numStepXPath)->item(0);
    if($step) {
        $img_path = $step->getAttribute('nome_file_img');
        $tutorial->removeChild($step);
    }
}

$steps = $tutorial->childNodes;

$k = 1;
foreach ($steps as $step){
    $step->setAttribute('num_step', $k);
    $k++;
}

$doc->formatOutput = true;
$xmlString = $doc->saveXML();
file_put_contents($xmlFile, $xmlString);

unlink($img_path);

header('Location: ../prove_funzioni/prova_rimuovi_step.php');
exit;

?>