<?php

session_start();

if (!isset($_SESSION['Tipo_utente'])) {
    header('Location: ../web/login.php');
    exit;
}

require_once 'functions.php';
$xmlFile = "../data/xml/reports_progetti.xml";
$root = "../";

if (!isset($_POST['id_progetto']) || empty($_POST['id_progetto'])) {
    exit;
} else {
    $id_progetto = $_POST['id_progetto'];
}

if (!isset($_POST['testo']) || empty($_POST['testo'])) {
    $_SESSION['empty_form'] = "true";
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/view.php?id_progetto=' . $id_progetto);
    exit;
} else {
    $newTestoValue = $_POST['testo'];
}

if (!isset($_POST['tipo']) || empty($_POST['tipo'])) {
    $_SESSION['empty_form'] = "true";
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/view.php?id_progetto=' . $id_progetto);
    exit;
} else {
    $newTipoValue = $_POST['tipo'];
}


$id_segnalatore = $_SESSION['id_utente'];
$id_segnalazione = generate_id($xmlFile);

$progetto = getProgetto($root, $id_progetto);
$publisher = $progetto->getAttribute('username_creator');
$titolo = $progetto->getElementsByTagName('titolo')->item(0)->nodeValue;

//AGGIUNTA IN REPORTS_PROGETTI.XML

$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;
$data_ora = new DateTime();
$data_ora = $data_ora->format('Y-m-d H:i:s');

$newReport = $doc->createElement('report_progetto');
$newReport->setAttribute('id', $id_segnalazione);
$newReport->setAttribute('id_progetto', $id_progetto);
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

//AGGIUNTA IN PROGETTI.XML

$xmlFile = "../data/xml/progetti.xml";
$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;
$nodes = $root->childNodes;

foreach ($nodes as $node) {

    if ($id_progetto === $node->getAttribute('id')) {

        $proReport = $doc->createElement('report_progetto');
        $proReport->setAttribute('id_report', $id_segnalazione);
        $proReportsProgetti = $node->getElementsByTagName('reports_progetti')->item(0);
        $proReportsProgetti->appendChild($proReport);

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

        $stoReport = $doc->createElement('report_progetto');
        $stoReport->setAttribute('id_report', $id_segnalazione);
        $stoReport->setAttribute('tipo', $newTipoValue);
        $stoReport->setAttribute('data_ora', $data_ora);
        $stoReport->setAttribute('id_progetto', $id_progetto);
        $stoReport->setAttribute('publisher', $publisher);
        $stoReport->setAttribute('titolo', $titolo);
        $stoReportsProgetti = $node->getElementsByTagName('reports_progetti')->item(0);
        $stoReportsProgetti->appendChild($stoReport);

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