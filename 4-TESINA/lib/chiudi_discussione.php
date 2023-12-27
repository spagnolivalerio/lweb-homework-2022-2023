<?php

session_start();

if (!isset($_SESSION['Tipo_utente'])) {
    header('Location: ../web/login.php');
    exit;
}

require_once 'functions.php';
$xmlFile = "../data/xml/discussioni.xml";



if (!isset($_POST['id_discussione']) || empty($_POST['id_discussione'])) {
    exit;
} else {
    $id_discussione = $_POST['id_discussione'];
}

if (!isset($_POST['id_progetto']) || empty($_POST['id_progetto'])) {
    exit;
} else {
    $id_progetto = $_POST['id_progetto'];
}

$risolta = $_POST['risolta'];


//MODIFICA IN DISCUSSIONI.XML

$doc = getDOMdocument($xmlFile);
$xpath = new DOMXPath($doc);


$discussione = $xpath->query("/discussioni/discussione[@id = '$id_discussione']")->item(0);

$discussione->setAttribute('risolta', $risolta);

$doc->formatOutput = true;
$xmlString = $doc->saveXML();
file_put_contents($xmlFile, $xmlString);

$url = "../web/" . $_SESSION['Tipo_utente'] . "/view.php?id_progetto=" . $id_progetto;
header("Location: $url");
exit;

?>
