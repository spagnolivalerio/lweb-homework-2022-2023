<?php

session_start();
include('../conn.php');
require_once('get_nodes.php');
$radice = "../";


if (!isset($_SESSION['Tipo_utente'])) {
    header('Location: ../web/login.php');
    exit;
}

if (!isset($_POST['clearance']) || empty($_POST['clearance'])) {
    exit;
} else {
    $clearance = $_POST['clearance'];
}

if (!isset($_POST['difficoltà']) || empty($_POST['difficoltà'])) {
    exit;
} else {
    $difficoltà = $_POST['difficoltà'];
}

if (!isset($_POST['durata']) || empty($_POST['durata'])) {
    exit;
} else {
    $durata = $_POST['durata'];
}

if (!isset($_POST['id_progetto']) || empty($_POST['id_progetto'])) {
    exit;
} else {
    $id_progetto = $_POST['id_progetto'];
}



# AGGIORNAMENTO IN PROGETTI.XML

$xmlFile = "../data/xml/progetti.xml";
$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;
$xpath = new DOMXPath($doc); 


$modProgetto = $xpath->query("/progetti/progetto[@id = '$id_progetto']")->item(0); 

$modProgetto->setAttribute('tempo_medio', $durata);
$modProgetto->setAttribute('difficolta', $difficoltà);
$modProgetto->setAttribute('clearance', $clearance);

$doc->formatOutput = true;
$xmlString = $doc->saveXML();
file_put_contents($xmlFile, $xmlString);
    

header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/homepage.php');

exit;

?>