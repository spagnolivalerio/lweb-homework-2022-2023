<?php

session_start();
require_once 'functions.php';

include('../conn.php');
$radice = "../";

if (!isset($_POST['id_progetto']) || empty($_POST['id_progetto'])) {
    exit;
} else {
    $id_progetto = $_POST['id_progetto'];
}

$xmlFile = "../data/xml/progetti.xml";
$doc = getDOMdocument($xmlFile);
$xpath = new DOMXPath($doc);

$img_path = $xpath->query("/progetti/progetto[@id = '$id_progetto']")->item(0)->getAttribute('nome_file_img');

//RIMUOVI DA PROGETTI.XML

$query = "/progetti/progetto[@id";
remove_1_1($xmlFile, $query, $id_progetto);

//RIMUOVI DA TUTORIALS.XML

$xmlFile = "../data/xml/tutorials.xml";
$query = "/tutorials_progetti/tutorial_progetto[@id";
remove_1_1($xmlFile, $query, $id_progetto);

//RIMUOVI DA REPORTS_PROGETTI.XML

$xmlFile = "../data/xml/reports_progetti.xml";
$query = "/reports_progetti/report_progetto[@id_progetto";
remove_1_n($xmlFile, $query, $id_progetto);

//RIMUOVI DA VALUTAZIONI_PROGETTI.XML

$xmlFile = "../data/xml/valutazioni_progetti.xml";
$query = "/valutazioni_progetti/valutazione_progetto[@id_progetto";
remove_1_n($xmlFile, $query, $id_progetto);

//RIMUOVI DA DISCUSSIONI.XML

$xmlFile = "../data/xml/discussioni.xml";
$query = "/discussioni/discussione[@id_progetto";
$id_discussioni = remove_1_n($xmlFile, $query, $id_progetto);

//RIMUOVI DA RICHIESTE_ACCESSO_DISCUSSIONI.XML

$xmlFile = "../data/xml/richieste_accesso_discussioni.xml";
$query = "/richieste/richiesta[@id_discussione";
remove_1_2n($xmlFile, $query, $id_discussioni);

//RIMUOVI DA COMMENTI.XML

$xmlFile = "../data/xml/commenti.xml";
$query = "/commenti/commento[@id_discussione";
$id_commenti = remove_1_2n($xmlFile, $query, $id_discussioni);

//RIMUOVI DA REPORTS_COMMENTI.XML

$xmlFile = "../data/xml/reports_commenti.xml";
$query = "/reports_commenti/report_commento[@id_commento";
remove_1_2n($xmlFile, $query, $id_commenti);

//RIMUOVI DA VALUTAZIONI_COMMENTO.XML

$xmlFile = "../data/xml/valutazioni_commenti.xml";
$query = "/valutazioni_commenti/valutazione_commento[@id_commenti";
remove_1_2n($xmlFile, $query, $id_commenti);

//RIMUOVI IMMAGINE

if (file_exists($img_path)) {
    unlink($img_path);
}

$conn = connect_to_db($servername, $db_username, $db_password, $db_name);
updateAllUsers($radice, $conn);

$url = "../web/" . $_SESSION['Tipo_utente'] . "/bacheca.php";
header("Location: $url");
exit;

?>