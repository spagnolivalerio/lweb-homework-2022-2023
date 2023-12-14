<?php

session_start();
require_once 'functions.php';
$xmlFile = "../data/xml/richieste_accesso_discussioni.xml";

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


$data_ora = new DateTime();
$data_ora = $data_ora->format('Y-m-d H:i:s');
$id_richiesta = generate_id($xmlFile);

//AGGIUNTA IN RICHIESTE_ACCESSO_DISCUSSIONI.XML

$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;
$default = "in lavorazione";
$id_utente = $_SESSION['id_utente'];

$newRichiesta = $doc->createElement('richiesta');
$newRichiesta->setAttribute('id', $id_richiesta);
$newRichiesta->setAttribute('id_discussione', $id_discussione);
$newRichiesta->setAttribute('id_utente', $id_utente);
$newRichiesta->setAttribute('data_ora', $data_ora);
$newRichiesta->setAttribute('stato', $default);

$root->appendChild($newRichiesta);

$doc->formatOutput = true;
$xmlString = $doc->saveXML();
file_put_contents($xmlFile, $xmlString);

//AGGIUNGERE IN STORICI.XML

$xmlFile = "../data/xml/storici.xml";
$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;
$xpath = new DOMXPath($doc);

$stoRichiesta = $doc->createElement('richiesta');
$stoRichiesta->setAttribute('id_richiesta', $id_richiesta);

$storico = $xpath->query("/storici/storico[@id_utente = '$id_utente']")->item(0);
$stoRichieste = $storico->getElementsByTagName('richieste')->item(0);

$stoRichieste->appendChild($stoRichiesta);

$doc->formatOutput = true;
$xmlString = $doc->saveXML();
file_put_contents($xmlFile, $xmlString);

$url = "../web/" . $_SESSION['Tipo_utente'] . "/view-discussioni.php?id_progetto=" . $id_progetto;
header("Location: $url");
exit;

?>