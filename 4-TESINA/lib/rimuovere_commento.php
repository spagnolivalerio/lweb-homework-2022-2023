<?php

session_start();
require_once 'functions.php';


include('../conn.php');
$radice = "../";

if (!isset($_SESSION['Tipo_utente'])) {
    header('Location:../web/login.php');
    exit();
}

//HO BISOGNO DI PORTARMI DIETRO SIA L'IDENTIFICATIVO DEL COMMENTO CHE DELLA DISCUSSIONE

if (!isset($_POST['id_commento']) || empty($_POST['id_commento'])) {
    exit();
} else {
    $id_commento = $_POST['id_commento'];
}

if (!isset($_POST['id_discussione']) || empty($_POST['id_discussione'])) {
    exit();
} else {
    $id_discussione = $_POST['id_discussione'];
}

if (!isset($_POST['id_progetto']) || empty($_POST['id_progetto'])) {
    exit();
} else {
    $id_progetto = $_POST['id_progetto'];
}

//RIMUOVI DA COMMENTI.XML

$xmlFile = "../data/xml/commenti.xml";
$query = "/commenti/commento[@id";
remove_1_1($xmlFile, $query, $id_commento);

//RIMUOVI DA REPORTS_COMMENTI.XML

$xmlFile = "../data/xml/reports_commenti.xml";
$query = "/reports_commenti/report_commento[@id_commento";
remove_1_n($xmlFile, $query, $id_commento);


//RIMUOVI DA VALUTAZIONI_COMMENTO.XML

$xmlFile = "../data/xml/valutazioni_commenti.xml";
$query = "/valutazioni_commenti/valutazione_commento[@id_commenti";
remove_1_n($xmlFile, $query, $id_commento);


//RIMUOVI DA DISCUSSIONI.XML

$xmlFile = "../data/xml/discussioni.xml";

$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;
$nodes = $root->childNodes;

foreach ($nodes as $node) {

    if ($id_discussione === $node->getAttribute('id')) {

        $discCommenti = $node->getElementsByTagName('commenti')->item(0);
        $discCommento = $discCommenti->childNodes;

        foreach ($discCommento as $commento) {

            if ($id_commento === $commento->getAttribute('id_commento')) {

                $discCommenti->removeChild($commento);
                $doc->formatOutput = true;
                $xmlString = $doc->saveXML(); //ottengo il file xml come stringa
                file_put_contents($xmlFile, $xmlString);

                break;

            }
        }
    }
}

$conn = connect_to_db($servername, $db_username, $db_password, $db_name);
updateAllUsers($radice, $conn);

if(isset($_GET['goto']) && $_GET['goto'] == "view_segnalazioni"){
    $url = "../web/" . $_SESSION['Tipo_utente'] . "/view_segnalazioni.php";
}else{
    $url = "../web/" . $_SESSION['Tipo_utente'] . "/view.php?id_progetto=" . $id_progetto;
}
header("Location: $url");
exit;

?>
