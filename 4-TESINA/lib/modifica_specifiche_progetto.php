<?php

session_start();
include('../conn.php');
require_once('get_nodes.php');
$radice = "../";


if (!isset($_SESSION['Tipo_utente'])) {
    header('Location: ../web/login.php');
    exit;
}

if (!isset($_POST['id_progetto']) || empty($_POST['id_progetto'])) {
    exit;
} else {
    $id_progetto = $_POST['id_progetto'];
}

if (!isset($_POST['clearance']) || empty($_POST['clearance'])) {
    $_SESSION['empty_form'] = "true";
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/form_modifica_progetto.php?id_progetto=' . $id_progetto);
    exit;
} else {
    $clearance = $_POST['clearance'];
}

if (!isset($_POST['difficoltà']) || empty($_POST['difficoltà'])) {
    $_SESSION['empty_form'] = "true";
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/form_modifica_progetto.php?id_progetto=' . $id_progetto);
    exit;
} else {
    $difficoltà = $_POST['difficoltà'];
}

if (!isset($_POST['durata']) || empty($_POST['durata'])) {
    $_SESSION['empty_form'] = "true";
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/form_modifica_progetto.php?id_progetto=' . $id_progetto);
    exit;
} else {
    $durata = $_POST['durata'];
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
    
$_SESSION['esito'] = "true";
header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/form_modifica_progetto.php?id_progetto=' . $id_progetto);

exit;

?>