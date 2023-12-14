<?php

session_start();
require_once 'functions.php';

if (!isset($_SESSION['Tipo_utente'])) {
    header('Location: ../web/login.php');
    exit;
}

if (!isset($_POST['utility']) || empty($_POST['utility'])) {
    exit;
} else {
    $utilita = $_POST['utility'];
}

if (!isset($_POST['id_commento']) || empty($_POST['id_commento'])) {
    exit;
} else {
    $id_commento = $_POST['id_commento'];
}

if (!isset($_POST['id_progetto']) || empty($_POST['id_progetto'])) {
    exit;
} else {
    $id_progetto = $_POST['id_progetto'];
}

if (!isset($_POST['rating']) || empty($_POST['rating'])) {
    exit;
} else {
    $liv_accordo = $_POST['rating'];
}

$id_votante = $_SESSION['id_utente'];
$data_ora = new DateTime();
$data_ora = $data_ora->format('Y-m-d H:i:s');

//AGGIUNGI IN VALUTAZIONI_COMMENTI.XML

$xmlFile = "../data/xml/valutazioni_commenti.xml";
$id_valutazione = generate_id($xmlFile);
$doc = getDOMdocument($xmlFile);

$root = $doc->documentElement;
$newValutazione = $doc->createElement('valutazione_commento');
$newValutazione->setAttribute('id', $id_valutazione);
$newValutazione->setAttribute('data_ora', $data_ora);
$newValutazione->setAttribute('id_votante', $id_votante);
$newValutazione->setAttribute('id_commento', $id_commento);

$newUtilita = $doc->createElement('utilita', $utilita);
$newAccordo = $doc->createElement('livello_di_accordo', $liv_accordo);

$newValutazione->appendChild($newUtilita);
$newValutazione->appendChild($newAccordo);

$root->appendChild($newValutazione);

$doc->formatOutput = true;
$xmlString = $doc->saveXML();
file_put_contents($xmlFile, $xmlString);

//AGGIUNGI IN COMMENTI.XML

$xmlFile = "../data/xml/commenti.xml";
$doc = getDOMdocument($xmlFile);
$xpath = new DOMXPath($doc);

$comValutazioni_commenti = $xpath->query("/commenti/commento[@id = '$id_commento']/valutazioni_commento")->item(0);

$comValutazione = $doc->createElement('valutazione_commento');
$comValutazione->setAttribute('id_valutazione_commento', $id_valutazione);

$comValutazioni_commenti->appendChild($comValutazione);

$doc->formatOutput = true;
$xmlString = $doc->saveXML();
file_put_contents($xmlFile, $xmlString);

//AGGIUNGI IN STORICI.XML

$xmlFile = "../data/xml/storici.xml";
$doc = getDOMdocument($xmlFile);
$xpath = new DOMXPath($doc);

$stoValutazioni_commenti = $xpath->query("/storici/storico[@id_utente = '$id_votante']/valutazioni_commenti")->item(0);

$stoValutazione = $doc->createElement('valutazione_commento');
$stoValutazione->setAttribute('id_valutazione', $id_valutazione);

$stoValutazioni_commenti->appendChild($stoValutazione);

$doc->formatOutput = true;
$xmlString = $doc->saveXML();
file_put_contents($xmlFile, $xmlString);

$url = "../web/" . $_SESSION['Tipo_utente'] . "/view-discussioni.php?id_progetto=" . $id_progetto;
header("Location: $url");
exit; 

?>
















?>
