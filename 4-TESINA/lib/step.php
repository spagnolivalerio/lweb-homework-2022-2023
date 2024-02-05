<?php

session_start(); 
require_once('functions.php'); 
$tps_root = "../"; 
$id_bozza_corrente = $_SESSION['id_bozza']; 
$img_dir_path = "img/steps/";

$xmlFile = "../data/xml/bozze.xml";

if (!isset($_POST['titolo']) || empty($_POST['titolo'])) {
    $_SESSION['empty_form'] = "true";
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/form_step.php');
    exit;
} else {
    $titolo = $_POST['titolo'];
}

if (!isset($_POST['descrizione']) || empty($_POST['descrizione'])) {
    $_SESSION['empty_form'] = "true";
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/form_step.php');
    exit;
} else {
    $descrizione = nl2br($_POST['descrizione']);
}

if (!isset($_POST['num_step'])) {
    $_SESSION['empty_form'] = "true";
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/form_step.php');
    exit;
} elseif (!empty($_POST['num_step']) || $_POST['num_step'] === '0') {
    $num_step = (int) $_POST['num_step'] + 1;
}

if (!isset($_FILES['img']['tmp_name']) || empty($_FILES['img']['tmp_name'])) {
    $_SESSION['empty_form'] = "true";
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/form_step.php');
    exit;
} else {
    $img_location = $_FILES['img']['tmp_name'];
}

$doc = getDOMdocument($xmlFile);
$xpath = new DOMXPath($doc);
$ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);

$tutorial = $xpath->query("/bozze/bozza[@id = '$id_bozza_corrente']/tutorial_bozza")->item(0);

$succ_step = $xpath->query("/bozze/bozza[@id = '$id_bozza_corrente']/tutorial_bozza/step[@num_step = '$num_step']")->item(0);

$nome_file_img = $img_dir_path . uniqid('img_step_') . "." . $ext;

$newStep = $doc->createElement('step');
$newDescrizione = $doc->createElement('descrizione', $descrizione);
$newStep->appendChild($newDescrizione);
$newStep->setAttribute('titolo_step', $titolo);
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

$nome_file_img = $tps_root . $nome_file_img; 
add_img($img_location, $nome_file_img);

$doc->formatOutput = true;
$xmlString = $doc->saveXML();
file_put_contents($xmlFile, $xmlString);

$where = $num_step-1;
$url = "../web/" . $_SESSION['Tipo_utente'] . "/anteprima_tutorial.php?num_step=$where";
header("Location: $url");
exit;

?>
