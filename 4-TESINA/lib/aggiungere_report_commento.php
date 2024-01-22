<?php

session_start();

if (!isset($_SESSION['Tipo_utente'])) {
    header('Location: ../web/login.php');
    exit;
}

require_once 'functions.php';
$xmlFile = "../data/xml/reports_commenti.xml";
$root = "../";

if (!isset($_POST['id_progetto']) || empty($_POST['id_progetto'])) {
    exit;
} else {
    $id_progetto = $_POST['id_progetto'];
}


if (!isset($_POST['testo']) || empty($_POST['testo'])) {
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/view.php?id_progetto=' . $id_progetto);
    exit;
} else {
    $newTestoValue = $_POST['testo'];
}

if (!isset($_POST['tipo']) || empty($_POST['tipo'])) {
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/view.php?id_progetto=' . $id_progetto);
    exit;
} else {
    $newTipoValue = $_POST['tipo'];
}

if (!isset($_POST['id_commento']) || empty($_POST['id_commento'])) {
    exit;
} else {
    $id_commento = $_POST['id_commento'];
}

$id_segnalatore = $_SESSION['id_utente'];
$id_segnalazione = generate_id($xmlFile);
$data_ora = new DateTime();
$data_ora = $data_ora->format('Y-m-d H:i:s');

$commento = getCommento($root, $id_commento);
$commentatore = $commento->getAttribute('commentatore');

//AGGIUNTA IN REPORTS_COMMENTI.XML

$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;

$newReport = $doc->createElement('report_commento');
$newReport->setAttribute('id', $id_segnalazione);
$newReport->setAttribute('id_commento', $id_commento);
$newReport->setAttribute('id_utente', $id_segnalatore);
$newReport->setAttribute('data_ora', $data_ora);

$newTipo = $doc->createElement('tipo', $newTipoValue);
$newTesto = $doc->createElement('testo', $newTestoValue);

$newReport->appendChild($newTipo);
$newReport->appendChild($newTesto);

$root->appendChild($newReport);

$doc->formatOutput = true;
$xmlString = $doc->saveXML(); //ottengo il file xml come stringa
file_put_contents($xmlFile, $xmlString);

//AGGIUNTA IN COMMENTI.XML

$xmlFile = "../data/xml/commenti.xml";
$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;
$nodes = $root->childNodes;

foreach ($nodes as $node) {

    if ($node->getAttribute('id') === $id_commento) {

        $comReport = $doc->createElement('report_commento');
        $comReport->setAttribute('id_report', $id_segnalazione);
        $comReportsCommenti = $node->getElementsByTagName('reports_commento')->item(0);
        $comReportsCommenti->appendChild($comReport);

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

    if ($node->getAttribute('id_utente') === $_SESSION['id_utente']) {

        $stoReport = $doc->createElement('report_commento');
        $stoReport->setAttribute('id_report', $id_segnalazione);
        $stoReport->setAttribute('tipo', $newTipoValue);
        $stoReport->setAttribute('data_ora', $data_ora);
        $stoReport->setAttribute('id_commento', $id_commento);
        $stoReport->setAttribute('commentatore', $commentatore);
        $stoReports = $node->getElementsByTagName('reports_commenti')->item(0);
        $stoReports->appendChild($stoReport);

        $doc->formatOutput = true;
        $xmlString = $doc->saveXML();
        file_put_contents($xmlFile, $xmlString);

        break;

    }
}

$url = "../web/" . $_SESSION['Tipo_utente'] . "/view.php?id_progetto=" . $id_progetto;
header("Location: $url");
exit;

?>
