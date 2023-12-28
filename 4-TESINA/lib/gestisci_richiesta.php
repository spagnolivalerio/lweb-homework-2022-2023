<?php

session_start();

/*controllo sui permessi

if($_SESSION['permessi']['admin'] === false && $_SESSION['permessi']['moderatore'] === false){
exit;

}*/

if ($_SESSION['Tipo_utente'] === 'standard') {
    echo "non sei mod o admin";
    exit;
}

require_once 'functions.php';
require_once '../conn.php';
$xmlFile = "../data/xml/richieste_accesso_discussioni.xml";

if (!isset($_POST['id_richiesta']) || empty($_POST['id_richiesta'])) {
    exit;
} else {
    $id_richiesta = $_POST['id_richiesta'];
}

if (!isset($_POST['esito']) || empty($_POST['esito'])) {
    exit;
} else {
    $esito = $_POST['esito'];
}

$conn = connect_to_db($servername, $db_username, $db_password, $db_name);
$doc = getDOMdocument($xmlFile);
$xpath = new DOMXPath($doc);

$data_ora = new DateTime();
$data_ora = $data_ora->format('Y-m-d H:i:s');

$richiesta = $xpath->query("/richieste/richiesta[@id = '$id_richiesta']")->item(0);

$richiesta->setAttribute('stato', $esito);
$richiesta->setAttribute('data_ora', $data_ora);
$ricModeratore = $doc->createElement('moderatore');
$ricModeratore->setAttribute('id_mod', $_SESSION['id_utente']);
$ricModeratore->setAttribute('username', $_SESSION['username']);
$richiesta->appendChild($ricModeratore);

$doc->formatOutput = true;
$xmlString = $doc->saveXML();
file_put_contents($xmlFile, $xmlString);

//AGGIUNGERE PARTECIPANTE IN DSICUSSIONI.XML

if ($esito === 'rifiutata') {
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/view_richieste.php');
    exit;
}

$id_discussione = $richiesta->getAttribute('id_discussione');
$id_partecipante = $richiesta->getAttribute('id_utente');
$xmlFile = "../data/xml/discussioni.xml";
$doc = getDOMdocument($xmlFile);
$xpath = new DOMXPath($doc);

$discussione = $xpath->query("/discussioni/discussione[@id = '$id_discussione']")->item(0);
$partecipanti = $discussione->getElementsByTagName('partecipanti')->item(0);

$discPartecipante = $doc->createElement('partecipante');
$discPartecipante->setAttribute('id_partecipante', $id_partecipante);

$partecipanti->appendChild($discPartecipante);

$doc->formatOutput = true;
$xmlString = $doc->saveXML(); //ottengo il file xml come stringa
file_put_contents($xmlFile, $xmlString);

header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/view_richieste.php');
exit;

?>