<?php

session_start();

if (!isset($_SESSION['Tipo_utente'])) {
    header('Location: ../web/login.php');
    exit;
}

require_once 'functions.php';
$xmlFile = "../data/xml/valutazioni_progetti.xml";

include('../conn.php');
$radice = "../";

if (!isset($_POST['testo']) || empty($_POST['testo'])) {
    exit;
} else {
    $newTestoValue = $_POST['testo'];
}

if (!isset($_POST['id_progetto']) || empty($_POST['id_progetto'])) {
    exit;
} else {
    $id_progetto = $_POST['id_progetto'];
}

if (!isset($_POST['rating']) || empty($_POST['rating'])) {
    exit;
} else {
    $newValue = $_POST['rating'];
}

$id_votante = $_SESSION['id_utente'];
$id_valutazione = generate_id($xmlFile);
$data_ora = new DateTime();
$data_ora = $data_ora->format('Y-m-d H:i:s');

//AGGIUNTA IN VALUTAZIONI.XML

$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;

$newValutazione = $doc->createElement('valutazione_progetto');
$newValutazione->setAttribute('id', $id_valutazione);
$newValutazione->setAttribute('id_progetto', $id_progetto);
$newValutazione->setAttribute('value', $newValue);
$newValutazione->setAttribute('id_votante', $id_votante);
$newValutazione->setAttribute('data_ora', $data_ora);

$newTesto = $doc->createElement('testo', $newTestoValue);
$newValutazione->appendChild($newTesto);
$root->appendChild($newValutazione);

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

        $proValutazione = $doc->createElement('valutazione');
        $proValutazione->setAttribute('id_valutazione', $id_valutazione);
        $proValutazioni = $node->getElementsByTagName('valutazioni')->item(0);
        $proValutazioni->appendChild($proValutazione);

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

        $stoValutazione = $doc->createElement('valutazione_progetto');
        $stoValutazione->setAttribute('id_valutazione', $id_valutazione);
        $stoValutazione->setAttribute('id_progetto', $id_progetto);
        $stoValutazione->setAttribute('data_ora', $data_ora);
        $stoValutazione->setAttribute('value', $newValue);
        $stoValutazioni = $node->getElementsByTagName('valutazioni_progetti')->item(0);
        $stoValutazioni->appendChild($stoValutazione);

        $doc->formatOutput = true;
        $xmlString = $doc->saveXML(); //ottengo il file xml come stringa
        file_put_contents($xmlFile, $xmlString);

        break;
    }
}

$conn = connect_to_db($servername, $db_username, $db_password, $db_name);
updateAllUsers($radice, $conn);

$url = "../web/" . $_SESSION['Tipo_utente'] . "/view.php?id_progetto=" . $id_progetto;
header("Location: $url");
exit;

?>
