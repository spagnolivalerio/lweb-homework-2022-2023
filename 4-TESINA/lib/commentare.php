<?php

session_start();
require_once 'functions.php';
//bisogna fare il controllo su chi può commentare in base agli accessi alle discussioni

if (!isset($_SESSION['Tipo_utente'])) {
    header('Location: ../web/login.php');
    exit;
}

require_once 'functions.php';
$xmlFile = "../data/xml/commenti.xml";

if (!isset($_POST['testo']) || empty($_POST['testo'])) {
    exit;
} else {
    $newTestoValue = $_POST['testo'];
}

if (!isset($_POST['id_discussione']) || empty($_POST['id_discussione'])) {
    exit;
} else {
    $id_discussione = $_POST['id_discussione'];
}

$id_commentatore = $_SESSION['id_utente'];
$id_commento = generate_id($xmlFile);
$data_ora = new DateTime();
$data_ora = $data_ora->format('Y-m-d H:i:s');

//AGGIUNTA IN COMMENTI.XML

$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;

$newCommento = $doc->createElement('commento');
$newCommento->setAttribute('id', $id_commento);
$newCommento->setAttribute('id_discussione', $id_discussione);
$newCommento->setAttribute('id_commentatore', $id_commentatore);
$newCommento->setAttribute('data_ora', $data_ora);

$newTesto = $doc->createElement('testo', $newTestoValue);
$newVoti = $doc->createElement('voti');
$newReport = $doc->createElement('reports_commento');

$newCommento->appendChild($newTesto);
$newCommento->appendChild($newVoti);
$newCommento->appendChild($newReport);

$root->appendChild($newCommento);

$doc->formatOutput = true;
$xmlString = $doc->saveXML(); //ottengo il file xml come stringa
file_put_contents($xmlFile, $xmlString);

//AGGIUNTA IN DISCUSSIONI.XML

$xmlFile = "../data/xml/discussioni.xml";
$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;
$nodes = $root->childNodes;

foreach ($nodes as $node) {

    if ($id_discussione === $node->getAttribute('id')) {

        $discCommento = $doc->createElement('commento');
        $discCommento->setAttribute('id_commento', $id_commento);
        $discCommenti = $node->getElementsByTagName('commenti')->item(0);
        $discCommenti->appendChild($discCommento);

        $doc->formatOutput = true;
        $xmlString = $doc->saveXML(); //ottengo il file xml come stringa
        file_put_contents($xmlFile, $xmlString);

        break;
    }
}

//AGGIUNTA IN STORICI.XML

$xmlFile = "../data/xml/storici.xml";
$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;
$nodes = $root->childNodes;

foreach ($nodes as $node) {

    if ($_SESSION['id_utente'] === $node->getAttribute('id_utente')) {

        $stoCommento = $doc->createElement('commento');
        $stoCommento->setAttribute('id_commento', $id_commento);
        $stoTesto = $doc->createElement('testo', $newTestoValue);
        $stoCommento->appendChild($stoTesto);
        $stoCommenti = $node->getElementsByTagName('commenti')->item(0);
        $stoCommenti->appendChild($stoCommento);

        $doc->formatOutput = true;
        $xmlString = $doc->saveXML();
        file_put_contents($xmlFile, $xmlString);

        break;

    }
}

header('Location: ../prove_funzioni/prova_commentare.php');
exit;

?>