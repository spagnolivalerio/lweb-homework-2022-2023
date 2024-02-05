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

$img_path_proj = $radice .  $xpath->query("/progetti/progetto[@id = '$id_progetto']")->item(0)->getAttribute('nome_file_img');

//RIMUOVI IMMAGINE

if (file_exists($img_path_proj)) {
    unlink($img_path_proj);
}

//RIMUOVI DA PROGETTI.XML

$query = "/progetti/progetto[@id";
remove_1_1($xmlFile, $query, $id_progetto);

//RIMUOVI DA TUTORIALS.XML

$xmlFile = "../data/xml/tutorials.xml";
$query = "/tutorials_progetti/tutorial_progetto[@id";

$doc = getDOMdocument($xmlFile);
$xpath = new DOMXPath($doc);

$steps = $xpath->query("/tutorials_progetti/tutorial_progetto[@id=" . $id_progetto ."]")->item(0)->getElementsByTagName('step');
foreach($steps as $step){
    $img_path_step = $radice . $step->getAttribute('nome_file_img');
    if (file_exists($img_path_step)) {
    unlink($img_path_step);
    }
}

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
remove_n_m($xmlFile, $query, $id_discussioni);

//RIMUOVI DA COMMENTI.XML

$xmlFile = "../data/xml/commenti.xml";
$query = "/commenti/commento[@id_discussione";
$id_commenti = remove_n_m($xmlFile, $query, $id_discussioni);

//RIMUOVI DA REPORTS_COMMENTI.XML

$xmlFile = "../data/xml/reports_commenti.xml";
$query = "/reports_commenti/report_commento[@id_commento";
remove_n_m($xmlFile, $query, $id_commenti);

//RIMUOVI DA VALUTAZIONI_COMMENTO.XML

$xmlFile = "../data/xml/valutazioni_commenti.xml";
$query = "/valutazioni_commenti/valutazione_commento[@id_commenti";
remove_n_m($xmlFile, $query, $id_commenti);

$conn = connect_to_db($servername, $db_username, $db_password, $db_name);
updateAllUsers($radice, $conn);

if(isset($_GET['goto']) && !empty($_GET['goto'])){
    $url = "../web/" . $_SESSION['Tipo_utente'] . "/" . $_GET['goto'] . ".php";
}else{
    $url = "../web/" . $_SESSION['Tipo_utente'] . "/bacheca.php";
}
header("Location: $url");
exit;

?>